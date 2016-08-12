<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB,Input,Redirect,Session,url;
use App\Http\Requests;
use App\Http\Controllers\Controller;


header("Content-type: text/html; charset=utf-8"); 
class GroupController extends Controller
{
    //查看学院页面
            public function groupShow(Request $request)
            {
                //当前页码
                $p = $request -> p ? $request -> p : 1;
                //查询表名
                $table = 'res_college';
                //每页显示数据条数
                $num = $request -> num ? $request -> num : 10;
                //查询条件
                $where = 1;
                //排序
               $arr = $this -> ajaxPage( $table , $num , $p , 'logPage' , $where );
                foreach($arr['arr'] as $k=>$v)
                {
                    $num=count(
                        DB::table('res_class')
                            ->where('ser_id',$v->cid )
                            ->lists('class_name')
                    );
                    $arr['arr'][$k]->num=$num;
                }
                //print_r($arr['arr']);die;
                return view('group.show',array( 'arr' => $arr['arr'] , 'page' => $arr['page'] ));
            }
            
          /*
           *@学院添加
           */
            public function groupCollAdd(Request $request)
            {
                $uid = session::get('uid');
            	$coll_name = $request->coll_name;
                //避免空格
                $coll_name  = preg_replace('# #', '', $coll_name);
                //汉字转拼音（生僻字不支持）
                $coll_accounts = $this->utf8_to("$coll_name");
                  $reg = '/[^\x{4e00}-\x{9fa5}]{1,10}/u';
                  if(preg_match($reg,$coll_name)) {
                        echo "学院名称必须为汉字且小于10位";
                  }else{
                        $id=DB::table('res_college')
                            ->insert([
                                'college_name'=>$coll_name,
                                'uid' =>$uid
                           ]);
                        $add_date = date('Y-m-d H:i:s',time());
                      DB::table('res_user')->insert([
                          'username'=>$coll_name,
                          'accounts'=>$coll_accounts,
                          'add_date'=>$add_date,
                          'password'=>'1234',
                          'status'=>'1',
                          'rid'=>'1',
                          'uid' => $uid
                      ]);

                        if($id){
                            echo 1;
                        }else{
                            echo 0;
                        }
                  }
            }

    //查看系
    public function series(Request $request){
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table = 'res_series inner join res_college on res_series.cid=res_college.cid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 10;
        //查询条件
        $where = 1;
        //排序
        $arr = $this -> ajaxPage( $table , $num , $p , 'logPage' , $where );
        $college = $this -> databasesSelect('res_college');
        foreach($arr['arr'] as $k=>$v)
        {
            $num=count(
                DB::table('res_series')
                    ->where('ser_id',$v->cid )
                    ->lists('ser_name')
            );

            $arr['arr'][$k]->num=$num;
        }
        // print_r($arr['arr']);die;
        // echo 1;
        return view('group.seriesShow',array( 'arr' => $arr['arr'] , 'college' => $college  , 'page' => $arr['page'] ));
    }


    //创建系
    public function seAdd(Request $request){
        $ser_name = $request->ser_name;
        $cid = $request->cid;
        //避免空格
        $ser_name  = preg_replace('# #', '', $ser_name);
        //汉字转拼音（生僻字不支持）
        $se_accounts = $this->utf8_to("$ser_name");
        $reg = '/[^\x{4e00}-\x{9fa5}]{1,10}/u';
        if(preg_match($reg,$ser_name)) {
            echo "系名称必须为汉字且小于10位";
        }else{
            $add_date = date('Y-m-d H:i:s',time());
            $uid = DB::table('res_user')->insertgetid([
                'username'=>$ser_name,
                'accounts'=>$se_accounts,
                'add_date'=>$add_date,
                'password'=>'1234',
                'status'=>'1',
                'rid'=>'4'
            ]);
            $id=DB::table('res_series')
                ->insert([
                    'ser_name'=>$ser_name,
                    'cid'=>$cid,
                    'uid' => $uid
                ]);


            if($id){
                echo 1;
            }else{
                echo 0;
            }
        }
    }


    public function groupClaShow(Request $request)
    {


        $uid=Session::get('uid');


        $users = DB::table('res_series')
            ->where('uid',$uid)
            ->select('cid','ser_id')
            ->get();
        foreach($users as $k=>$v)
        {
            $cid=$v->cid;
            $ser_id=$v->ser_id;
        }
        $where = 'res_college.cid='.$cid;



        $table = array(
            [ 'table1' => 'res_series' , 'table2' => 'res_college' , 'join' => 'cid' ] ,
            [ 'table1' => 'res_series' , 'table2' => 'res_class' , 'join' => 'ser_id' ]
        );

        $page = array( 'num' => 10 , 'p' => 1 , 'url' => 'index' );
        $arr = $this -> databasesSelect($table,$where,0,1,$page);
        // print_r($arr);die;
        $clapk=DB::table('res_class')->where('ser_id',$ser_id)->select('class_name','class_id')->get();
        // print_r($clapk);die;
        return view('group.classShow',array( 'arr' => $arr['arr'],'page'=>$arr['page'],'ser_id'=>$ser_id,'clapk'=>$clapk));
    }

    /*
     *@班级添加
     *
     */

    public function groupClaAdd(Request $request)
    {

        $uid=Session::get('uid');

        // echo 1;die;
        $users = DB::table('res_series')

            ->where('uid',$uid)
            ->select('cid')
            ->get();
        foreach($users as $k=>$v)
        {
            $cid=$v->cid;
        }
        // echo $cid;

        $uid1 = DB::table('res_college')

            ->where('cid',$cid)
            ->select('uid')
            ->get();

        foreach($uid1 as $k=>$v)
        {
            $uid2=$v->uid;
        }
        // print_r($uid2);die;
        $account = DB::table('res_user')

            ->where('uid',$uid2)
            ->select('accounts')
            ->get();
        foreach($account as $k=>$v)
        {
            $account=$v->accounts;
        }

        // print_r($account);die;

        $class_name=$request->class_name;
        $ser_id=$request->ser_id;
        // echo $class_name;
        // echo $coll_id;die;
        $reg="/^[0-9]+[A-Z]+$/";
        if(preg_match($reg,$class_name))
        {
            echo "班级名称应由数字字母组成";
        }else
        {
            $time = time();
            $insertid=DB::table('res_user')->insertgetid([
                'username'=>$class_name,
                'accounts'=>$account.$class_name,
                'add_date'=>$time,
                'password'=>'1234',
                'status'=>'1',
                'rid'=>'2'
            ]);
            // echo $coll_name;
            $id=DB::table('res_class')->insert([
                'ser_id'=>$ser_id,
                'class_name'=>$class_name,
                'uid'=>$insertid,
            ]);

            if($id)
            {
                echo 1;
            }else
            {
                echo 0;
            }
        }



    }

    public function groupAdd(Request $request)
    {
        $cla_name=$request->cla_name;
        $reg="/^[0-9]+[A-Z]+$/";
        if(preg_match($reg,$cla_name))
        {
            echo "班级名称应由数字字母组成";
        }else
        {
            // echo $coll_name;
            $id=DB::table('res_class')->insert([
                'college_name'=>$cla_name,
            ]);
            DB::table('res_user')->insert([
                'username'=>$cla_name,
                'account'=>$cla_name,
                'password'=>'1234',
                'add_date'=>date('Y-m-d H:i:s'),
            ]);
            if($id)
            {
                echo 1;
            }else
            {
                echo 0;
            }
        }


        // echo $id;
    }

    function groupManAdd(Request $request){
        //班级id
        $class_id = $request['class_id'];
        //小组数量
        $num = $request['num'];

        $class = DB::table('res_class')
                -> where('class_id' , $class_id)
                -> first();
        $class_name = $class -> class_name;
        $time = time();
        if(!empty($class_id)&&!empty($num)){
            for($i=1;$i<=$num;$i++){
                $str=array(
                    'class_id'=>$class_id,
                    'group_name'=>'第'.$i.'组'
                );
                $groupid = DB::table("res_group")->insertGetId( $str );
                $date = array(
                    'accounts' => "$class_name$groupid",
                    'password' => "1234",
                    'add_date' => "$time",
                    'status' => 1,
                    'rid' => 4
                );
                DB::table( 'res_user' ) -> insert($date);
            }
            echo 1;
        }else{
            echo 0;
        }

    }
    /**
     * 组员添加
     */
    public function groupMan(){
        $name = '1408phpG';//当前登录用户名
        $firse =  DB::table('res_class')
            ->join('res_group', 'res_class.class_id', '=', 'res_group.class_id')
            ->where('res_class.class_name','=',"$name")
            ->get();

        $_SESSION['class']=$firse;
        return view('group.groupMan',['arr' =>$firse]);
    }

    /*
     * pk班级添加
     * */
    function pkAdd(Request $request)
    {
        $c_id=$request->c_id;
        $clapk=$request->clapk;
        // echo $c_id;
        // echo $clapk;
        $arr=DB::table("res_class_pk")->where("cl_id",$c_id)->first();
        // print_r($arr);die;
        if(!empty($arr))
        {
            echo 1;
        }elseif($c_id==$clapk)
        {
            echo 2;
        }else
        {
            $id=DB::table('res_class_pk')->insert([
                'cl_id'=>$c_id,
                'cl_pk_id'=>$clapk,

            ]);
            if($id)
            {
                echo 3;
            }else
            {
                echo 4;
            }
        }

    }

    public   function  studentAdd(Request $request){
        $name = $request['name'];
        $groupid = $request['groupid'];
        $newname=explode(',',$name);
        if(empty($newname)||empty($groupid)){
            echo 0;
        }else{
            $name = '1408phpG';//当前登录用户名
            $class_name =$name;
            foreach($newname as $k=>$v){
                $nname  = preg_replace('# #', '',$v);
                //插入数据
                $time = time();
                //汉字转拼音（生僻字不支持）
                $pinyin = $this->utf8_to("$nname");
                //密码随机4位数字
                $password = 1234;

                $date = array(
                    'username' => "$class_name$groupid$pinyin",
                    'accounts' => "$class_name$groupid$pinyin",
                    'password' => "$password",
                    'add_date' => "$time",
                    'status' => 1,
                    'rid' => 4
                );
                $insertID =  DB::table("res_user")->insertGetId( $date );
                $date2 = array(
                    'gr_id' => "$groupid",
                    'difference' => $k+1,
                    'uid' => $insertID,
                );
                DB::table("res_students")->insertGetId( $date2 );
            }
            echo  1;
        }
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
    
    
    /**
     *   创建小组
     */
    
    //创建小组页面 或者 "小组列表"
    public function bulidIndex()
    {
        //根据当前用户的id查出班级的id
        $uid = Session::get('uid');
        $class = DB::table('res_class') ->where('uid',$uid)->get();
        // print_r($class);die;
        $class_id = $class[0]->class_id;   //取出班级的id；
         // 查询本班级是否分组
        $res = DB::table('res_group')->where('class_id',$class_id)->orderBy('gr_id')->get();   
        //$res_class_id = DB::select("select * from res_students where gr_id = 0 and class_id ='$class_id' ");
        if ($res)
        {
            
            //查看组长
            $leader = DB::select("select * from res_students inner join res_group on res_students.gr_id=res_group.gr_id where pid = 0 and res_students.class_id = $class_id");
            $users = array();
            // print_r($leader);die;
            foreach ($leader as $key => $v)
            {
                $users[] = $v;
                $user = DB::select("select * from res_students inner join res_group on res_students.gr_id=res_group.gr_id where pid =".$v->sid);
                if(!empty($user)){
                    $users = array_merge($users,$user);
                }
            }
            // print_r($users);die;
            $arr = array();
            $group = array();
            foreach($res as $key => $val)
            {
                $group[$key]['group_name'] = $val -> group_name;
                $group[$key]['gr_id'] = $val -> gr_id;
            }
            if (empty($users))
            {
                $array = $group;
            }
            else
            {
                foreach( $group as $key => $val )
                {
                    foreach($users as $k => $v)
                    {
                        if( $v -> gr_id == $val['gr_id'] )
                        {
                            $arr[$key][] = $v;
                        }
                    }
                }
                
                if( count( $group ) != count( $arr ) )
                {
                    foreach( $group as $key => $val )
                    {
                        if(isset( $arr[$key][0] -> gr_id ))
                        {
                            if( $arr[$key][0] -> gr_id != $val['gr_id'] )
                            {
                                $array[] = $val;
                            }else{
                                $array[] = $arr[$key];
                            }
                        }
                        else
                        {
                            $array[] = $val;
                        }
                    }
                }
                else
                {
                    $array = $arr;
                }
            }
            // echo 1;die;
            // print_r($array);die;
            return view('build.buildindex',['arr' => $array]);
        }
        else
        {
            //查询班级的总人数
            $uid = Session::get('uid');        //取出当前班级用户的id
            $users = DB::table('res_class')
                ->join('res_students', 'res_students.class_id', '=', 'res_class.class_id')
                ->where('uid',$uid)
                ->get();
            // print_r($users);die;
            $count = count($users);      //总人数
            $classname = $users[0]->class_name;   //班级名称
            return view('build.buildindex',['count' => $count,'classname' => $classname]);
        }
    }
    
    //接受数据进行分组
    public function buildAdd(Request $request)
    {
        //根据当前用户的id查出班级的id
        $uid = Session::get('uid');
        $class = DB::table('res_class') ->where('uid',$uid)->get();
        // print_r($class);die;
        $class_id = $class[0]->class_id;   //取出班级的id；
        $arr = $request->all();
        // print_r($arr);
        $build_num = $arr['bulid'];   //分组的组数
        for ($i=1; $i <= $build_num ; $i++)
        {
            DB::table('res_group')->insert( ['class_id' =>$class_id , 'group_name' =>'第'.$i.'组']);
        }
    }
    
    
    //添加成员页面
    public function index(Request $request)
    {
        $arr = $request->all();     //接受所有的数据
        // print_r($arr);die;
        $gr_id = $arr['gr_id'];      //小组的id
        //取出当前班级用户的id
        $uid = Session::get('uid');
        //查出本班级为分组的成员
        $users = DB::table('res_class')
            ->join('res_students', 'res_students.class_id', '=', 'res_class.class_id')
            ->where('uid',$uid)
            ->where('gr_id',0)
            ->get();
        // print_r($users);die;
        //获取名字和id
        foreach ($users as $key => $v)
        {
            $name[$key]['name'] = $v->student_name;
            $name[$key]['sid'] = $v->sid;
        }
        
        return view('build.index',['name' => $name,'gr_id' => $gr_id]);
    }
    
    //接受数据，进行创建
    public function add_build(Request $request)
    {
        //接受数据
        $arr = $request->all();
        // print_r($arr);die;
        $gr_id = $arr['gr_id'];  //小组id
        $str = $arr['str'];    //接受的组员id，'字符串'
        $id=explode(',',$str);
        $pid=$id[0];     //默认小组第一个人为组长
        $re=DB::update("update res_students set gr_id = $gr_id , pid=0 where sid = $pid");
        // var_dump($re);die;
        $str=substr($str,strpos($str,',')+1);
        // var_dump($str);die;
        $res=DB::update("update res_students set gr_id = $gr_id , pid=$pid where sid in ($str)");
        if($res&&$res)
        {
            echo 1;
        }
        
    }


    //重新分配小组成员
    public function again_member()
    {
        //根据当前用户的id查出班级的id
        $uid = Session::get('uid');
        $class = DB::table('res_class') ->where('uid',$uid)->get();
        // print_r($class);die;
        $class_id = $class[0]->class_id;   //取出班级的id；
        DB::update("update res_students set gr_id = 0 , pid = 'Null' where class_id = $class_id");
        return redirect('build');
    }


    //重新分配小组
    public function again_build()
    {
        //根据当前用户的id查出班级的id
        $uid = Session::get('uid');
        $class = DB::table('res_class') ->where('uid',$uid)->get();
        // print_r($class);die;
        $class_id = $class[0]->class_id;   //取出班级的id；
        //清空这个班级学生的组，以及组长
        DB::update("update res_students set gr_id = 0 , pid = 'Null' where class_id = $class_id");
        //清空
        DB::delete("delete from res_group where class_id = $class_id");
        return redirect('build');
    }
    
}


?>