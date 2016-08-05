<?php
/**
 * 用于用户管理模块
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/3 0003
 * Time: 上午 9:52
 */


namespace App\Http\Controllers;
use  Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class UserController extends Controller
{
    /**
     * 用于方法内所有输出
     * @param $arr
     */
    private  function  __ECHO( $arr )
    {
        $str="";
        foreach( $arr as $k => $v )
        {
            $str.=$k.$v;
        }
        echo $str;
    }

    private function __SWITCH( $string )
    {
        switch( $string )
        {
            case  1:
                $return_echo = [
                    '用户名为空，账号创建失败' => '',
                ];
                $this->__ECHO( $return_echo );
                            ;break;
            case  2:
                $return_echo = [
                    '用户名不是2-10位中文，账号创建失败' => '',
                ];
                $this->__ECHO( $return_echo );
                ;break;
            default :
                $return_echo = [
                    '创建失败，请舒心后尝试' => '',
                ];
                $this->__ECHO( $return_echo );
                break;

        }

    }
    /**
     * 查询角色
     * @return mixed
     */
    private function role( )
    {
           return  DB::table('res_role')->get();
    }

    /**
     * 取出据用户的角色信息
     * @param $type
     * @param string $where
     * @return mixed
     */
    private function user( $type , $where = "" )
    {
        if( 'all' == $type )
        {
           return   DB::table('res_user')
                    ->join('user_role', 'user.uid', '=', 'user_role.uid')
                    ->join('role', 'role.rid', '=', 'user_role.rid')
                    ->get();
        }
        else if(  'one' == $type )
        {
            $firse =  DB::table('res_user')
                        ->join('user_role', 'user.uid', '=', 'user_role.uid')
                        ->join('role', 'role.rid', '=', 'user_role.rid')
                        ->where("user.uid","=","$where")
                        ->limit(1)
                        ->get();
            return $firse[0];
        }
    }

    /**
     * 添加
     * @param $arr
     * @return mixed
     */
    private function insertUser( $arr , $table )
    {
      //返回插入id
      return  DB::table("$table")->insertGetId( $arr );
    }

    /**
     * 关联插入角色
     * @param $arr
     * @param $table
     * @return mixed
     */
    private function insertRole( $arr , $table )
    {
        //返回bool值
        return  DB::table("$table")->insert( $arr );
    }

    /**
     * 添加表单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userAdd()
    {
        //取出所有角色
        $role = $this->role();

        return view('user.userAdd',['role'=>$role]);
    }

    public function userAddPro( Request $request )
    {
        //接受值，参数 post
        $input = $request->all();

        //用户名
        empty($input['username'])?$input['username']="":$username=$input['username'];
        //角色
        empty($input['usertype'])?$input['usertype']="":$usertype=$input['usertype'];

        /*表单过滤*/

        if( empty( $username ) || empty( $usertype ) )
        {
            $this->__SWITCH(1);die;
        }

        $preg= '/[\x{4e00}-\x{9fa5}]{2,10}/u';
        if(!preg_match($preg,$username) )
        {
            $this->__SWITCH(2);die;
        }

        if( $request->isMethod('post') )
        {
            //插入数据
            $time = time();
            //汉字转拼音（生僻字不支持）
            $pinyin = $this->utf8_to("$input[username]");
            //密码随机4位数字
            $password = $pinyin;

            $date = array(
                'username' => "$input[username]",
                'accounts' => "$pinyin". rand(1000, 9999),
                'password' => "$password",
                'add_date' => "$time",
                'status' => 1,
            );

            //添加用户  并获取上一条ID
            $insertID = $this->insertUser( $date , "user" );

            $role = [
                'uid' => "$insertID",
                'rid' => "$input[usertype]",
            ];

            //插入角色
            $bool = $this->insertRole( $role , "user_role" );

            if (1 == $bool)
            {
                //查询上一条chu
                $UserRole = $this->user( 'one' , $insertID );
                $return_echo =[
                    '账号创建成功[' => $UserRole->role_name,
                    " ] 姓名 ["      => $UserRole->username,
                    "] 账户 ["              => $UserRole->accounts,
                    "] 密码 ["              => '默认为账户拼音部分',
                    "]"      => '',
                ];
                $this->__ECHO( $return_echo );
            }
            else
            {
                $return_echo = [
                    '账号创建失败，姓名 [' => $input['username'],
                      "]"      => '',
                ];

                $this->__ECHO( $return_echo );

            }
        }
    }

    /**
     * 用户列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userList()
    {
        $role = $this->role();

        return view('user.userList',['role'=>$role]);
    }

    /**
     * 用户信息分页
     * @param Request $request
     */
    public function userListInfo( Request $request )
    {
        empty( $request['page'] ) ? $page = 1 : $page = $request['page'];

        // 每页显示条数
        $page_num = 10;

        //  计算总页码
        $num = DB::table('res_user')
            ->join('res_user_role', 'res_user.uid', '=', 'res_user_role.uid')
            ->join('res_role', 'res_role.rid', '=', 'res_user_role.rid')
            ->where('status',"!=","2")
            ->count();
        $pages = ceil($num/$page_num);
        $disable = 'normal';
        if( $page <= 1)
        {
            $page=1;
            $disable = 'updisable';
        }
        else if( $page >= $pages )
        {
            $disable = 'dndisable';
            $page = $pages;
        }else if(($page <= 1)&&($page > $pages)){
            $disable = 'alldisable';
        }
        //  计算偏移量
        $limit = ( $page-1 )*$page_num;

        empty( $request['numLine'] ) ? $numLine = 10 : $numLine = $request['numLine'];

        $firse['data'] =  DB::table('res_user')
            ->join('res_user_role', 'res_user.uid', '=', 'res_user_role.uid')
            ->join('res_role', 'res_role.rid', '=', 'res_user_role.rid')
            ->where('status',"!=","2")
            ->skip($limit)
            ->take($page_num)
            ->get();

        $firse['pageAll'] = $pages;

        $firse['dpage'] = $page;

        $firse['disable'] = $disable ;

        echo json_encode($firse);
    }


    /**
     * ajax 修改用户名  账户
     * @param Request $request
     */
    public function userListUpdate( Request $request )
    {
        empty( $request['ziduan'] ) ? $ziduan = 1 : $ziduan = $request['ziduan'];
        empty( $request['id'] ) ? $id = 1 : $id = $request['id'];
        empty( $request['value'] ) ? $value= 1 : $value= $request['value'];

        if( "name" == $ziduan)
        {
            $ziduan='username';
        }
        else if( "account" == $ziduan )
        {
            $ziduan= 'accounts';
        }else{
            echo 0;die;
        }

        if(!is_int(intval($id)))
        {
            echo 0;die;
        }
       echo DB::table('res_user')
            ->where('uid', $id)
            ->update([$ziduan => "$value"]);
    }


    /**
     * 放入回收站
     * @param Request $request
     */
    public function logDelete( Request $request )
    {
        empty( $request['id'] ) ? $id = "" : $id = $request['id'];
        $array=explode(',',$id);
        if(empty($array)){
            echo 0;
        }else{
            echo DB::table('res_user')
                ->whereIn("uid",$array)
                ->update(['status' => "2"]);
        }

    }

    /**
     * ajax  修改角色
     * @param Request $request
     */
    public function roleUpdate( Request $request )
    {
        empty( $request['id'] ) ? $id = "" : $id = $request['id'];
        empty( $request['date'] ) ? $date = "" : $date = $request['date'];
        $array=explode(',',$id);
        if(empty($array)){
            echo 0;
        }else{
            echo DB::table('res_user_role')
                ->whereIn("uid",$array)
                ->update(['rid' => "$date"]);
        }

    }

    public function userRemove(){

        return view('res_user.userList');
    }





































    /**
     * 以下是中文转拼音
     * @param $s
     * @param bool $isfirst
     * @return string
     */
    public static function utf8_to($s, $isfirst = false) {
        return self::to(self::utf8_to_gb2312($s), $isfirst);
    }

    public static function utf8_to_gb2312($s) {
        return iconv('UTF-8', 'GB2312//IGNORE', $s);
    }

// 字符串必须为GB2312编码
    public static function to($s, $isfirst = false) {
        $res = '';
        $len = strlen($s);
        $pinyin_arr = self::get_pinyin_array();
        for($i=0; $i<$len; $i++) {
            $ascii = ord($s{$i});
            if($ascii > 0x80) {
                $ascii2 = ord($s{++$i});
                $ascii = $ascii * 256 + $ascii2 - 65536;
            }

            if($ascii < 255 && $ascii > 0) {
                if(($ascii >= 48 && $ascii <= 57) || ($ascii >= 97 && $ascii <= 122)) {
                    $res .= $s{$i}; // 0-9 a-z
                }elseif($ascii >= 65 && $ascii <= 90) {
                    $res .= strtolower($s{$i}); // A-Z
                }else{
                    $res .= '_';
                }
            }elseif($ascii < -20319 || $ascii > -10247) {
                $res .= '_';
            }else{
                foreach($pinyin_arr as $py=>$asc) {
                    if($asc <= $ascii) {
                        $res .= $isfirst ? $py{0} : $py;
                        break;
                    }
                }
            }
        }
        return $res;
    }

    public static function to_first($s) {
        $ascii = ord($s{0});
        if($ascii > 0xE0) {
            $s = self::utf8_to_gb2312($s{0}.$s{1}.$s{2});
        }elseif($ascii < 0x80) {
            if($ascii >= 65 && $ascii <= 90) {
                return strtolower($s{0});
            }elseif($ascii >= 97 && $ascii <= 122) {
                return $s{0};
            }else{
                return false;
            }
        }

        if(strlen($s) < 2) {
            return false;
        }

        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;

        if($asc>=-20319 && $asc<=-20284) return 'a';
        if($asc>=-20283 && $asc<=-19776) return 'b';
        if($asc>=-19775 && $asc<=-19219) return 'c';
        if($asc>=-19218 && $asc<=-18711) return 'd';
        if($asc>=-18710 && $asc<=-18527) return 'e';
        if($asc>=-18526 && $asc<=-18240) return 'f';
        if($asc>=-18239 && $asc<=-17923) return 'g';
        if($asc>=-17922 && $asc<=-17418) return 'h';
        if($asc>=-17417 && $asc<=-16475) return 'j';
        if($asc>=-16474 && $asc<=-16213) return 'k';
        if($asc>=-16212 && $asc<=-15641) return 'l';
        if($asc>=-15640 && $asc<=-15166) return 'm';
        if($asc>=-15165 && $asc<=-14923) return 'n';
        if($asc>=-14922 && $asc<=-14915) return 'o';
        if($asc>=-14914 && $asc<=-14631) return 'p';
        if($asc>=-14630 && $asc<=-14150) return 'q';
        if($asc>=-14149 && $asc<=-14091) return 'r';
        if($asc>=-14090 && $asc<=-13319) return 's';
        if($asc>=-13318 && $asc<=-12839) return 't';
        if($asc>=-12838 && $asc<=-12557) return 'w';
        if($asc>=-12556 && $asc<=-11848) return 'x';
        if($asc>=-11847 && $asc<=-11056) return 'y';
        if($asc>=-11055 && $asc<=-10247) return 'z';
        return false;
    }

    public static function get_pinyin_array() {
        static $py_arr;
        if(isset($py_arr)) return $py_arr;

        $k = 'a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo';
        $v = '-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274|-10270|-10262|-10260|-10256|-10254';
        $key = explode('|', $k);
        $val = explode('|', $v);
        $py_arr = array_combine($key, $val);
        arsort($py_arr);
        return $py_arr;
    }
}
