<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB,Input,Redirect,Session,url;

/*
 * @author:dongmengtao
 * @time:2016/0803
 * @controller:成绩管理
 */


require_once (__DIR__."/../../../vendor/PHPExcel.php");
require_once (__DIR__."/../../../vendor/PHPExcel/Writer/Excel2007.php");
header("content-type:text/html;charset=utf-8");
header("Content-type:application/vnd.ms-excel");
//
class GradeController extends Controller
{
    //查看成绩录入
    public function grade()
    {
        $uid = Session::get('uid');
        $id = Db::table('res_class')
            ->where('uid',$uid)
            ->first();
        $class_id = $id->class_id;
        $class_name = $id->class_name;
        $info = $this->tree($pid=0,$class_id);
        return view('grade.from',['list'=>$info,'class_name'=>$class_name]);
    }
    public function tree($pid,$class_id){
        $list = DB::table("res_students")
            ->where('class_id',$class_id)
            ->where('pid',$pid)
            ->where('class_id',$class_id)
            ->get();
        foreach($list as $k=>$v){
            $list[$k]->son = $this->tree($v->sid,$class_id);
        }
        return $list;
    }
    //添加成绩录入
    public function grade_add(Request $request)
    {
        $uid = Session::get('uid');
        $id = Db::table('res_class')
            ->where('uid',$uid)
            ->first();
        $class_id = $id->class_id;
        $group_id = $request->group_id;
        $sid  = explode(',',$request['sid']);
        $lilun  = explode(',',$request['log_id1']);
        $jineng = explode(',',$request['log_id2']);
        $dates = $request->dates;
        $times = date("Y-m-d",time());
        $type = DB::table('res_exam')
            ->where('exam_date',$dates)
            ->lists('exam_type');
        if(empty($type) || $type[0]==0){
            echo 1;die;
        }
        $info = DB::table('res_grade')
            ->where('uid',$uid)
            ->where('g_add_date',$dates)
            ->get();
        if(!empty($info)){
            echo 3;die;
        }
        $list = array();
        $sql ="insert into res_grade(theory,exam,g_add_date,sid,type,uid,add_time) VALUES ";
        foreach($sid as $k =>$v){
            $sql.="('".$lilun[$k]."','".$jineng[$k]."','".$dates."','".$sid[$k]."','".$type[0]."','".$uid."','".$times."'),";
        }
        $sql = substr($sql,0,-1);
        $res = DB::insert($sql);
        if($res){
            echo 2;
        }
    }


    //查看成绩//成才率
    public function show(Request $request){
       $uid = Session::get('uid');
        $role = DB::table( 'res_user' )
              -> join( 'res_role' , 'res_user.rid' , '=' , 'res_role.rid' )
              -> where('uid' , $uid)
              -> first();
        //角色  账号
        $role_name = $role -> role_name;
        $accounts = $role -> accounts;
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table='res_grade inner join res_user on res_grade.uid=res_user.uid inner join res_class on res_grade.class_id=res_class.class_id inner join res_college on res_class.cid=res_college.cid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 10;
        //查询条件
        if( $role_name == '组员' ){
            $where = 'res_grade.status=3 and name = "'.$role -> username.'"';
        }elseif( $role_name == '讲师' ) {
            $where = 'res_grade.status=3 and class_name = "' . $accounts . '"';
        }elseif( $role_name == '组长' ){
            $pre = 'QWERTYUIOPASDFGHJKLZXCVBNM';
            for( $i = 0 ; $i < 26 ; $i++ ){
                if(strpos( $accounts , $pre{$i} )){
                    $str = $pre{$i};
                }
            }
            $group = substr($accounts , strrpos( $accounts , $str )+1);
            $student = DB::table('res_students')
                     -> join( 'res_user' , 'res_students.uid' , '=' , 'res_user.uid' )
                     -> where('gr_id' , $group)
                     -> get();
            foreach($student as $key => $val){
                $name[] = $val -> username;
            }
            $username = implode( "','" , $name );
            $username = "'".$username."'";
            $where = 'res_grade.status=3 and name in ('.$username.')';
        }else{
            $where = 'res_grade.status=3';
        }
        //排序
        $order = 'res_grade.g_add_date desc';
        $arr = $this -> ajaxPage( $table , $num , $p , 'gradePage' , $where , $order );
        //根据用户查询角色 并显示出来
        return view('grade.show',array('arr'=>$arr['arr'],'page'=>$arr['page']));
    }

    //多条件查询
    public function search(Request $request){
        $search = $request -> search ? $request -> search : '';
        $sel_username = $request -> username ? $request -> username : '';
        $exam1 = $request -> exam1 ? $request -> exam1 : '';
        $exam2 = $request -> exam2 ? $request -> exam2 : '';
        $type = $request -> type ? $request -> type : '';
        $uid = Session::get('uid');
        $role = DB::table( 'res_user' )
            -> join( 'res_role' , 'res_user.rid' , '=' , 'res_role.rid' )
            -> where('uid' , $uid)
            -> first();
        $role_name = $role -> role_name;
        $accounts = $role -> accounts;
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table='res_grade inner join res_user on res_grade.uid=res_user.uid inner join res_class on res_grade.class_id=res_class.class_id inner join res_college on res_class.cid=res_college.cid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 10;
        //查询条件
        if( $role_name == '组员' ){
            $where = 'res_grade.status=3 and name = "'.$role -> username.'"';
        }elseif( $role_name == '讲师' ) {
            $where = 'res_grade.status=3 and class_name = "' . $accounts . '"';
        }elseif( $role_name == '组长' ){
            $pre = 'QWERTYUIOPASDFGHJKLZXCVBNM';
            for( $i = 0 ; $i < 26 ; $i++ ){
                if(strpos( $accounts , $pre{$i} )){
                    $str = $pre{$i};
                }
            }
            $group = substr($accounts , strrpos( $accounts , $str )+1);
            $student = DB::table('res_students') -> join( 'res_user' , 'res_students.uid' , '=' , 'res_user.uid' ) -> where('gr_id' , $group) -> get();
            foreach($student as $key => $val){
                $name[] = $val -> username;
            }
            $username = implode( "','" , $name );
            $username = "'".$username."'";
            $where = 'res_grade.status=3 and name in ('.$username.')';
        }else{
            $where = 'res_grade.status=3';
        }

        if($search != ''){
            $where .= ' and res_grade.g_add_date="'.$search.'"';
        }
        if($sel_username != ''){
            $where .= ' and res_grade.name="'.$sel_username.'"';
        }
        if( $type != '' ) {
            if ( $type == 1 ) {
                if ( $exam1 != '' && $exam2 != '' ) {
                    if ( $exam1 < $exam2 ) {
                        $where .= ' and res_grade.theory between ' . $exam1 . ' and ' . $exam2;
                    }else if( $exam2 < $exam1 ){
                        $where .= ' and res_grade.theory between ' . $exam2 . ' and ' . $exam1;
                    }else{
                        $where .= ' and res_grade.theory='.$exam1;
                    }
                }else if( $exam1 != '' ){
                    $where .= ' and res_grade.theory='.$exam1;
                }else{
                    $where .= ' and res_grade.theory='.$exam2;
                }
            } else {
                if ( $exam1 != '' && $exam2 != '' ) {
                    if ( $exam1 < $exam2 ) {
                        $where .= ' and res_grade.exam between ' . $exam1 . ' and ' . $exam2;
                    }else if( $exam2 < $exam1 ){
                        $where .= ' and res_grade.exam between ' . $exam2 . ' and ' . $exam1;
                    }else{
                        $where .= ' and res_grade.exam='.$exam1;
                    }
                }else if( $exam1 != '' ){
                    $where .= ' and res_grade.exam='.$exam1;
                }else{
                    $where .= ' and res_grade.exam='.$exam2;
                }
            }
        }
        //排序
        $order = 'res_grade.g_add_date desc';
        $arr = $this -> ajaxPage( $table , $num , $p , 'gradePage' , $where , $order );
        //根据用户查询角色 并显示出来
        return view('grade.searchs',
            array(
            'arr' => $arr['arr'],
            'page'=> $arr['page'] ,
            'search' => $search ,
            'username' => $sel_username ,
            'exam1' => $exam1 ,
            'exam2' => $exam2 ,
            'type' => $type
            )
        );
    }



    //分页
    public function gradePage(Request $request){
        $uid = Session::get('uid');
        $role = DB::table( 'res_user' ) -> join( 'res_role' , 'res_user.rid' , '=' , 'res_role.rid' ) -> where('uid' , $uid) -> first();
        $role_name = $role -> role_name;
        $accounts = $role->accounts;
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table='res_grade inner join res_user on res_grade.uid=res_user.uid inner join res_class on res_grade.class_id=res_class.class_id inner join res_college on res_class.cid=res_college.cid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 10;
        //查询条件
        if( $role_name == '组员' ){
            $where = 'res_grade.status=3 and name = "'.$role -> username.'"';
        }elseif( $role_name == '讲师' ) {
            $where = 'res_grade.status=3 and class_name = "' . $accounts . '"';
        }elseif( $role_name == '组长' ){
            $pre = 'QWERTYUIOPASDFGHJKLZXCVBNM';
            for( $i = 0 ; $i < 26 ; $i++ ){
                if(strpos( $accounts , $pre{$i} )){
                    $str = $pre{$i};
                }
            }
            $group = substr($accounts , strrpos( $accounts , $str )+1);
            $student = DB::table('res_students') -> join( 'res_user' , 'res_students.uid' , '=' , 'res_user.uid' ) -> where('gr_id' , $group) -> get();
            foreach($student as $key => $val){
                $name[] = $val -> username;
            }
            $username = implode( "','" , $name );
            $username = "'".$username."'";
            $where = 'res_grade.status=3 and name in ('.$username.')';
        }else{
            $where = 'res_grade.status=3';
        }
        //排序
        $order = 'res_grade.g_add_date desc';
        $arr = $this -> ajaxPage( $table , $num , $p , 'gradePage' , $where , $order );
        return view( 'grade.gradePage' , array( 'arr' => $arr['arr'] , 'page' => $arr['page'] ));
    }

    //删除
    public function gradeDelete(Request $request){
        $gid=$request->input('gid');
        $re = DB::table('res_grade')->whereIn( 'gid' , array($gid) )->delete();
        if( $re ){
            //搜索日期
            $date = $request -> search ? $request -> search : '';
            //当前页码
            $p = $request -> p ? $request -> p : 1;
            //查询表名
            $table='res_user inner join res_role on res_user.rid=res_role.rid
                  inner join  res_grade on res_user.uid=res_grade.uid';
            //每页显示数据条数
            $num = $request -> num ? $request -> num : 10;
            //查询条件
            if($date == '') {
                $where = 1;
            }else{
                $where = "DATE(`g_add_date`) = '$date'";
            }
            //排序
            $order = 'res_grade.g_add_date desc';
            $arr = $this -> ajaxPage( $table , $num , $p , 'gradePage' , $where , $order );
            return view( 'grade.gradePage' , array( 'arr' => $arr['arr'] , 'page' => $arr['page'] ));
        }else{
            echo 0;
        }

 }

    //成绩机试修改
    public function updatess(Request $request){
        $v = $request->v;
        $gid = $request->input('id');
        $arr['exam'] = $v;
        $arr1 = DB::table('res_grade')
            ->where('gid',$gid)
            ->update($arr);
        if ($arr1) {
            echo 1;die;
        } else {
            echo 0;die;
        }
    }


    //成绩理论修改
    public function updates(Request $request)
    {
        $v = $request->v;
        $gid = $request->input('id');
        $arr['theory'] = $v;
        $arr1 = DB::table('res_grade')
            ->where('gid',$gid)
            ->update($arr);
        if ($arr1) {
           return redirect('show');
        } else {
            return redirect('show');
        }

        //当前页码
        $p = $request->p ? $request->p : 1;
        //查询表名
        $table = 'res_user inner join res_role on res_user.rid=res_role.rid inner join  res_grade on res_user.uid=res_grade.uid';
        //每页显示数据条数
        $num = $request->num ? $request->num : 1;
        //查询条件
        $where = 1;
        //排序
        $order = 'res_grade.add_date desc';
        $arr = $this->ajaxPage( $table , $num , $p , 'gradePage' , $where , $order );
        //根据用户查询角色 并显示出来
        return view( 'grade.show' , array ( 'arr' => $arr[ 'arr' ] , 'page' => $arr[ 'page' ] ) );
    }



    //管理员列表导入
    public function import()
    {
        $uid = Session::get('uid');
        if(empty($_FILES['myfile']['tmp_name']))
        {
            echo "<script>alert('不能为空');location.href='grade';</script>";die;
        }
        $date = $_POST['dates'];
        $dates = date('Y-m-d',time());
        $type = Db::table('res_exam')
            ->where('exam_date',$date)
            ->lists('exam_type');
        @$id = $type[0];
        if(!$id || empty($type)){
            echo "<script>alert('这天没有考试');location.href='grade';</script>";die;
        }
        $res = DB::table('res_exam')
            ->where('g_add_time',$date)
            ->where('uid',$uid)
            ->get();
        if(!empty($res)){
            echo "<script>alert('你已经提交过了');location.href='grade';</script>";die;
        }

        //print_r($_FILES['myfile']);die;
//        $this->load->library('/PHPExcel.php');
        $PHPExcel = new \PHPExcel();
        //这里是导入excel2007 的xlsx格式，如果是2003格式可以把“excel2007”换成“Excel5"
        //怎么样区分用户上传的格式是2003还是2007呢？可以获取后缀  例如：xls的都是2003格式的
        //xlsx 的是2007格式的  一般情况下是这样的
        $objReader = \PHPExcel_IOFactory::createReader('excel2007');
        //导入的excel路径
        $excelpath=$_FILES['myfile']['tmp_name'];
//        echo $excelpath;die;
        @$objPHPExcel=$objReader->load($excelpath);
        if($objPHPExcel){
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            //导入的excel路径
            $excelpath=$_FILES['myfile']['tmp_name'];
            $objPHPExcel=$objReader->load($excelpath);
        }
        $sheet=$objPHPExcel->getSheet(0);
        //取得总行数
        $highestRow=$sheet->getHighestRow();
        //取得总列数
        $highestColumn=$sheet->getHighestColumn();
        //从第二行开始读取数据  因为第一行是表格的表头信息

        $sql = "";
        for($j=2;$j<=$highestRow;$j++) {
            $str = "";
            //从A列读取数据
            for ($k='B'; $k <= $highestColumn; $k++) {
                $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue() . '|*|';//读取单元格
            }
            $str = mb_convert_encoding($str, 'utf8', 'auto');//根据自己编码修改
            $strs = explode("|*|", $str);
            //拼写sql语句
            $sql[] = [
                'student_name' => "{$strs[0]}",
                'exam'=>"{$strs[1]}",
                'theory'=>"{$strs[2]}",
                'type'=>$type[0],
                'uid'=>$uid,
                'add_time'=>$dates,
                'g_add_date'=>$date,
            ];
        }
        for($i=0;$i<count($sql);$i++){
            $info[] = Db::table('res_students')
                    ->where('student_name',$sql[$i]['student_name'])
                    ->lists('sid');
        }
        foreach($info as $k =>$v){
            $sql[$k]['sid'] = $info[$k][0];
            unset($sql[$k]['student_name']);
        }
        $res=DB::table('res_grade')->insert($sql);
        if($res){
            echo "<script>alert('导入成功！');location.href='grade'</script>";
        }else{
            echo "<script>alert('导入失败！');location.href='from'</script>";
        }
    }

    /**
     * 查看成材率
     * @auth  刘清白
     * @date 2016-8-8 9:21
     */
    public function ExcelDown(Request $request){
        //创建对象
        $excel=new \PHPExcel();
        //Excel表格式,这里简略写了8列
        $letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O');
        //表头数组
        $tableheader = array('学院','系','班级','技能成才率','理论成才率');
        //填充表头信息
        for($i=0;$i<count($tableheader);$i++) {
            $excel->getActiveSheet()->setCellValue("$letter[$i]1","$tableheader[$i]");
        }

        $college=   $this->yuansheng(intval($request['zq']));
        foreach($college as $k=>$val){
           $asr1= array("$val[college_name]",'','',"$val[theory]","$val[exam]");
            for($i=0;$i<count($tableheader);$i++) {
                $j=2;
                $excel->getActiveSheet()->setCellValue("$letter[$i]$j","$asr1[$i]");
            }
            $j++;
                foreach($val['xi'] as $k2=>$val2){
                    $asr1= ["$val[college_name]", "$val2[ser_name]",'',"$val2[theory]","$val2[exam]"];
                    for($i=0;$i<count($tableheader);$i++) {
                        $excel->getActiveSheet()->setCellValue("$letter[$i]$j","$asr1[$i]");
                    }
                    $j++;
                    foreach($val2['class'] as $k3=>$val3) {
                        $asr1= ["$val[college_name]","$val2[ser_name]","$val3[class_name]","$val3[theory]","$val3[exam]"];
                        for($i=0;$i<count($tableheader);$i++) {
                            $excel->getActiveSheet()->setCellValue("$letter[$i]$j","$asr1[$i]");
                        }
                        $j++;
                    }
                }
    }
        //创建Excel输入对象
        $write = new \PHPExcel_Writer_Excel5($excel);
        //清除缓冲区,避免乱码
        ob_end_clean();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="'.date("Y-m-d",time()).'全校成才率信息统计.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }
    /**
     * 角色判断
     * 决定查看列表
     */
    public function gdList( Request $request )
    {
        $upDnDateId = intval($request['upDnDate']);
        if(!empty($upDnDateId)){
            $dateget = DB::table('res_period')
                ->where('per_id','=',$upDnDateId)
                ->limit(1)
                ->get();
            if(!empty($dateget)){
                $Dateid =  $dateget[0]->per_id;
            }
        }
        if(empty($Dateid)){
            $Aa  = date('Y-m-d',time());//今天
            $datecheck = DB::table('res_period')
                ->where('start_date','<',"$Aa")
                ->where('end_date','>',"$Aa")
                ->get();
            $Dateid = $datecheck[0]->per_id;
        }

        $uid = Session::get('uid');
        $users = DB::table('res_user')
            ->select('role_name')
            ->join('res_role', 'res_role.rid', '=', 'res_user.rid')
            ->where('uid', $uid)
            ->get();
        $date = DB::table('res_period')->get();
        if( '教务' == $users[0]->role_name )
        {
             return view('grade.cljiaowu',[
                 'college'=>$this->yuansheng($upDnDateId),
                 'date'=>$date,
                 'datecheck'=>$Dateid
             ]);
        }

        if( '系主任' == $users[0]->role_name )
        {
            $arr =  DB::table('res_series')
                ->where("res_series.uid","=",$uid)
                ->get();
            return view('grade.xizhuren', [
                'ser_id' => $arr[0]->ser_id,
                'college'=>$this->yuansheng($upDnDateId),
                'date'=>$date,
                'checkdate'=>$Dateid
            ]);
        }

        if( '讲师' == $users[0]->role_name )
        {
             $class = DB::table('res_class')
                ->select('class_id', 'class_name')
                ->where('uid', $uid)
                ->get();
             return view('grade.cljiangshi', ['class' => $class,'date'=>$date,'checkdate'=>$Dateid]);
         }
    }
    /**
     * 查询所有学院
     * @return mixed
     */
    public function ajaxCollege()
    {
        return  DB::table('res_college')->get();
    }



    /**
     * 计算昨日成才
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function yuansheng($upDnDateId)
    {
        if(!empty($upDnDateId)){
            $dateget = DB::table('res_period')
                ->where('per_id','=',$upDnDateId)
                ->limit(1)
                ->get();
            if(!empty($dateget)){
                $dateSelect =  $dateget[0]->per_id;
            }
        }
        if(empty($upDnDateId)){
            $Aa  = date('Y-m-d',time());//今天
            $datecheck = DB::table('res_period')
                ->where('start_date','<',"$Aa")
                ->where('end_date','>',"$Aa")
                ->get();
            $dateSelect = $datecheck[0]->per_id;
        }

        if(empty($dateSelect)){
            $arr =   DB::table('res_grade')
                //  ->select('student_name','theory','exam','g_add_date')//查询的字段
                ->join('res_students', 'res_grade.sid', '=', 'res_students.sid')//学生表
                ->join('res_class', 'res_students.class_id', '=', 'res_class.class_id')//班级表
                ->join('res_series', 'res_series.ser_id', '=', 'res_class.ser_id')//系表
                ->join('res_college', 'res_series.cid', '=', 'res_college.cid')//原表
//                ->wherein('res_colslege.cid',DB::table('res_college')->select('res_college.cid'))//b
                ->where('g_add_date','=',date("Y-m-d",time()))//添加时间等于为今天的
                ->get();
            $average['start_date']=date("Y-m-d",time());
            $average['end_date']=date("Y-m-d",time());
        }
        else
        {
            $datet = DB::table('res_period')
                ->where('per_id','=',$dateSelect)
                ->limit(1)
                ->get();
            $arr =   DB::table('res_grade')
                    //  ->select('student_name','theory','exam','g_add_date')
                    ->join('res_students', 'res_grade.sid', '=', 'res_students.sid')//学生表
                    ->join('res_class', 'res_students.class_id', '=', 'res_class.class_id')//班级表
                    ->join('res_series', 'res_series.ser_id', '=', 'res_class.ser_id')//系表
                    ->join('res_college', 'res_series.cid', '=', 'res_college.cid')//原表
//                    ->wherein('res_college.cid',DB::table('res_colllege')->select('res_college.cid'))报错
                    ->where('g_add_date','>',$datet[0]->start_date)//周期上
                    ->where('g_add_date','<',$datet[0]->end_date)//周期下
                    ->get();
        }

        $arr =json_decode(json_encode($arr),true);
        $college = [];//学院
        $series = [];//系
        $class = [];//班级
        $grade = [];//成绩
        $college_id =[];
        $series_id = [];
        $class_id = [];
        foreach($arr as $k=>$v)
        {
            //学院cid
            $college[$k]['cid']               =   $v['cid'];
            //学院id  用于过滤
            $college_id[]                     =    $v['cid'];
            //学院名字
            $college[$k]['college_name']      =   $v['college_name'];
            //系ser_id
            $series_id[$k]                    =   $v['ser_id'];
            $series[$k]['ser_id']             =   $v['ser_id'];
            //系名字
            $series[$k]['ser_name']           =   $v['ser_name'];
            //系 学院id
            $series[$k]['cid']                =   $v['cid'];
            //班级id
            $class_id[$k]                     =   $v['class_id'];
            $class[$k]['class_id']            =   $v['class_id'];
            //班级   系id
            $class[$k]['ser_id']              =   $v['ser_id'];
            //班级名字
            $class[$k]['class_name']          =   $v['class_name'];
            //成绩
            $grade[$k]['theory']              =   $v['theory'];
            $grade[$k]['exam']                =   $v['exam'];
//            $grade[$k]['g_add_date']          =   $v['g_add_date'];
            $grade[$k]['sid']                 =   $v['sid'];
            $grade[$k]['class_id']            =   $v['class_id'];
        }
        //学院清除重复（唯一）
        $college_id_uq   =  array_unique($college_id);
        //学院清除重复（唯一）
        $series_id_uq    =  array_unique($series_id);
        //班级清除重复（唯一）
        $class_id_uq     =  array_unique($class_id);
        //定义一个空数组，用来存放最后成才数据
        $college_all = [];
        foreach( $college_id_uq as $k => $v )
        {
            $college_all[] = $college[$k];
        }
        //删除此循环内变量
        unset( $college_id_uq );
        $series_all = [];
        foreach ( $series_id_uq as $k => $v)
        {
            $series_all[]=$series[$k];
        }
        //删除此循环内变量
        unset($series_id_uq);
        $class_all = [];
        foreach ( $class_id_uq as $k => $v)
        {
            $class_all[]=$class[$k];
        }
        //删除此循环内变量
        unset($class_id_uq);
        $cl = [];//所有班级加入cl
        foreach ( $class_all as $kclass => $vclass )
        {
            foreach ( $grade as $kgrade => $vgrade )
            {
                if( $vclass['class_id'] == $vgrade['class_id'] )
                {
                    $cl[$kclass]['class_name'] =  $vclass['class_name'];;
                    $cl[$kclass]['class_id']   =  $vclass['class_id'];
                    $cl[$kclass]['ser_id']     =  $vclass['ser_id'];
                    $cl[$kclass]['grade'][]    =  $vgrade;
                }
            }
            if(!empty( $cl[$kclass]['grade'] ) )
            {
                $manNum                        =  count( $cl[$kclass]['grade'] );//计算班级总人数
                $theory3                       =  0;
                $exam3                         =  0;
                foreach( $cl[$kclass]['grade'] as $vtheory => $ktheory )
                {
                    $theory3+=(float)$ktheory['theory'];
                }
                foreach($cl[$kclass]['grade'] as $vexam => $kexam){
                    $exam3 += (float)$kexam['exam'];
                }
                $f= 2;//小数后几位
                $newtheory3   =   sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory3/$manNum)), 0, -2));//理论成绩成才
                $newexam3     =   sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam3/$manNum)), 0, -2));//机试成绩成才
            }
            else
            {
                $newtheory3 = 0;
                $newexam3   = 0;
            }
            $cl[$kclass]['theory']   = $newtheory3;
            $cl[$kclass]['exam']     = $newexam3;
            //删除此循环内变量
            unset($cl[$kclass]['grade']);
        }

        foreach ( $series_all as $kseries => $vseries )
        {
            foreach ( $cl as $kcl => $vcl )
            {
                if($vseries['ser_id']==$vcl['ser_id'])
                {
                    $series_all[$kseries]['class'][]=$vcl;
                }
            }
            if( !empty( $series_all[$kseries]['class'] ) )
            {
                $manNum                        =   count( $series_all[$kseries]['class']);//计算班级总人数
                $theory3                       =   0;
                $exam3                         =   0;
                foreach( $series_all[$kseries]['class'] as $vtheory => $ktheory )
                {
                    $theory3+=(float)$ktheory['theory'];
                }
                foreach( $series_all[$kseries]['class'] as $vexam => $kexam )
                {
                    $exam3+=(float)$kexam['exam'];
                }
                $f            = 2;//小数后几位
                $newtheory3   =  sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory3/$manNum)), 0, -2));//理论成绩成才
                $newexam3     =  sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam3/$manNum)), 0, -2));//机试成绩成才
            }
            else
            {
                $newtheory3 = 0;
                $newexam3= 0;
            }
            $series_all[$kseries]['theory']  =  $newtheory3;
            $series_all[$kseries]['exam']    =  $newexam3;
        }
        //从学院到系
        $average=[];
        foreach( $college_all as $kcollege => $vcollege )
        {
            $average[$kcollege]    =     $vcollege;
            foreach(  $series_all as $kseries=>$vseries  )
            {
                if( $vseries['cid'] == $vcollege['cid'] )
                {
                    $average[$kcollege]['xi'][]     =     $vseries;
                }
            }
            if( !empty( $average[$kcollege]['xi'] ) )
            {
                $manNum                           =  count( $average[$kcollege]['xi']);//计算班级总人数
                $theory3                          =  0;
                $exam3                            =  0;
                foreach( $average[$kcollege]['xi'] as $vtheory => $ktheory )
                {
                    $theory3+=(float)$ktheory['theory'];
                }
                foreach($average[$kcollege]['xi'] as $vexam => $kexam )
                {
                    $exam3+=(float)$kexam['exam'];
                }
                $f          = 2;//小数后几位
                $newtheory3 = sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory3/$manNum)), 0, -2));//理论成绩成才
                $newexam3   =sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam3/$manNum)), 0, -2));//机试成绩成才
            }
            else
            {
                $newtheory3 = 0;
                $newexam3   = 0;
            }
            $average[$kcollege]['theory']  =  $newtheory3;
            $average[$kcollege]['exam']    =  $newexam3;
        }
        return $average;

    }

    /**
     * ajax点击加载学生成绩
     */
    function ajaxStudent( Request $request )
    {
        $id = intval($request['class_id']);
        if(!empty($id))
        {
            $per_id = intval($request['per_id']);
            if(empty($per_id)){
                //查询时间表
                $Aa   = date('Y-m-d',time());//小于今天
                $date = DB::table('res_period')
                    ->join('res_exam','res_period.per_id','=','res_exam.per_id')
                    ->where('start_date','<',"$Aa")
                    ->where('end_date','>',"$Aa")
                    ->get();
            }
            else
            {
                $date = DB::table('res_period')
                    ->join('res_exam','res_period.per_id','=','res_exam.per_id')
                    ->where('res_period.per_id','=',"$per_id")
                    ->get();
            }
            $dat  =[];
            $week = array('日','一','二','三','四','五','六');
            foreach( $date as $k => $v ){
                $time = strtotime( $v -> exam_date );
                $arr  = DB::table('res_students')
                    ->select('gid','student_name','theory','exam','g_add_date')
                    ->join('res_class', 'res_class.class_id', '=', 'res_students.class_id')
                    ->join('res_grade', 'res_grade.sid', '=', 'res_students.sid')
                    ->where("res_students.class_id","=",$id)
                    ->where('g_add_date','=',$v->exam_date)
                    ->orderBy('res_grade.sid','asc')
                    ->get();
                $arr['week'] = '星期'.$week[date('w',$time)];
                $arr['date'] = $v -> exam_date;
                if(!empty($arr))
                {
                    $dat['arr'][] =$arr;
                }else
                {
                    $dat['arr'][] =[];
                }
            }
            $dat['stu']          =  DB::table('res_students')->select('sid','student_name')->where('class_id','=',$id)->orderBy('sid','asc')->get();
            empty( $dat['arr'])?$dat['arr']=[]:'';
            $dat['timeDate']  = date('Y-m-d');

            $cc                  = json_decode(json_encode($dat),true);

            return view('grade.studentgd',[
                'student'=>$cc
            ]);
        }else{
            echo 0;
        }
    }


    /**
     * 成绩ajax修改
     * @param Request $request
     */
    function examUpdate( Request $request ){
        $arr[$request['examtype']] =$request['value'];
        $arr1 = DB::table('res_grade')
            ->where('gid',$request['id'])
            ->update($arr);
        if ($arr1) {
            echo 1;die;
        } else {
            echo 0;die;
        }
    }
}
