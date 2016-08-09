<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB,Input,Redirect,Session,url;
use App\Http\Requests;
use App\Http\Controllers\Controller;

require_once (__DIR__."/../../../vendor/PHPExcel.php");
header("content-type:text/html;charset=utf-8");
class GradeController extends Controller
{
    //查看成绩录入
    public function grade()
    {
        $arr1 = DB::table('res_college')->get();
        $arr5 = DB::table('res_class')->get();
        return view('grade.from',['arr1'=>$arr1,'arr5'=>$arr5]);
    }

    //添加成绩录入
    public function grade_add(Request $request)
    {
        $uid = Session::get('uid');
        //$table = DB :: table('res_grade inner join res_user on res_grade.uid=res_user.uid');
//        $table = DB::table('res_user_role')
//            ->join('res_role', 'res_role.rid', '=', 'res_user_role.rid')
//            ->where('uid',$uid)
//            ->get();
//        print_r($table);die;
        $name = $request->input('name');
        $class_id = $request->input('class_id');
        $cid = $request->input('cid');
        $theory = $request->input('theory');
        $exam = $request->input('exam');
        $g_add_date = date("Y-m-d H:i:s", time());
        $add_time = date("H:i:s", time());
       // $status = $request->input('status');
        $type = $request->input('type');
      DB::table('res_grade')->insert(
           array(
               'theory' => $theory,
               'exam' => $exam,
               'g_add_date' => $g_add_date,
               'add_time' => $add_time,
               'type' => $type,
               'uid' => $uid,
               'name' => $name,
               'class_id' => $class_id,
               'cid' => $cid,

           )
       );
        return redirect('show');
    }

    //查看成绩
    public function show(Request $request){
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
        //print_r($arr);die;
        //根据用户查询角色 并显示出来
        return view('grade.show',array('arr'=>$arr['arr'],'page'=>$arr['page']));
    }

    public function search(Request $request){
        $search = $request -> search ? $request -> search : '';
        $sel_username = $request -> username ? $request -> username : '';
        $exam1 = $request -> exam1 ? $request -> exam1 : '';
        $exam2 = $request -> exam2 ? $request -> exam2 : '';
        $type = $request -> type ? $request -> type : '';
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
        //print_r($arr);die;
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
//        print_r($arr);die;
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
            $table='res_user inner join res_role on res_user.rid=res_role.rid inner join  res_grade on res_user.uid=res_grade.uid';
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
//        print_r($arr);die;
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
        //print_r($arr);die;
        //根据用户查询角色 并显示出来
        return view( 'grade.show' , array ( 'arr' => $arr[ 'arr' ] , 'page' => $arr[ 'page' ] ) );
    }



    //管理员列表导入
    public function import()
    {
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
                'class_id' => "{$strs[0]}",
                'name'=>"{$strs[1]}",
                'theory'=>"{$strs[2]}",
                'exam'=>"{$strs[3]}",
                'type'=>"{$strs[4]}"
            ];
        }
//		echo $sql;die;
        $uid = Session::get('uid');
        $class = DB::table('res_class') -> where('class_name' , $sql[0]['class_id']) -> first();
        $class_id = $class -> class_id;
        $role = DB::table( 'res_user' ) -> join( 'res_role' , 'res_user.rid' , '=' , 'res_role.rid' ) -> where('uid' , $uid) -> first();
        $role_name = $role -> role_name;
        if( $role_name == '教务' ){
            $status = 2;
        }elseif( $role_name == '讲师' ){
            $status = 1;
        }else{
            $status = 0;
        }
        foreach( $sql as $key => $val ){
            if( $val['type'] == '日考' ){
                $sql[$key]['type'] = 1;
            }elseif( $val['type'] == '周考' ){
                $sql[$key]['type'] = 2;
            }else {
                $sql[$key]['type'] = 3;
            }
            $sql[$key]['status'] = $status;
            $sql[$key]['class_id'] = $class_id;
            $sql[$key]['g_add_date'] = date( 'Y-m-d' , time() );
            $sql[$key]['add_time'] = date( 'H:i:s' , time() );
            $sql[$key]['uid'] = $uid;
        }
        $res=DB::table('res_grade')->insert($sql);
        if($res){
            echo "<script>alert('导入成功！');location.href='grade'</script>";
        }else{
            echo "<script>alert('导入失败！');location.href='from'</script>";
        }
    }

    /**
     * 审核成绩
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function examine(Request $request)
    {
        $uid = Session::get('uid');
        $role = DB::table( 'res_user' ) -> join( 'res_role' , 'res_user.rid' , '=' , 'res_role.rid' ) -> where('uid' , $uid) -> first();
        $role_name = $role -> role_name;
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table = 'res_grade inner join res_user on res_grade.uid=res_user.uid inner join res_class on res_grade.class_id=res_class.class_id inner join res_college on res_class.cid=res_college.cid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 10;
        //查询条件
        if( $role_name == '教务' ){
            $where = 'res_grade.status=2';
        }elseif($role_name == '讲师'){
            $where = 'res_grade.status=1';
        }else{
            $where = 'res_grade.status=0';
        }
        //排序
        $order = 'gid desc';
        $arr = $this -> ajaxPage( $table , $num , $p , 'examinePage' , $where , $order );
        return view( 'grade.examine' , array( 'arr' => $arr['arr'] , 'page' => $arr['page'] ));
    }

    public function examineInfo(Request $request)
    {
        $gid    = $request -> gid ;
        $status = $request -> status ;
        $re = DB::table('res_grade')
        ->where('gid', $gid)
        ->update(['status' => $status]);
        if( $re ){
            $uid = Session::get('uid');
            $role = DB::table( 'res_user' ) -> join( 'res_role' , 'res_user.rid' , '=' , 'res_role.rid' ) -> where('uid' , $uid) -> first();
            $role_name = $role -> role_name;
            //当前页码
            $p = $request -> p ? $request -> p : 1;
            //查询表名
            $table = 'res_grade inner join res_user on res_grade.uid=res_user.uid inner join res_class on res_grade.class_id=res_class.class_id inner join res_college on res_class.cid=res_college.cid';
            //每页显示数据条数
            $num = $request -> num ? $request -> num : 10;
            //查询条件
            if( $role_name == '教务' ){
                $where = 'res_grade.status=2';
            }elseif( $role_name == '讲师' ){
                $where = 'res_grade.status=1';
            }else{
                $where = 'res_grade.status=0';
            }
            //排序
            $order = 'gid desc';
            $arr = $this -> ajaxPage( $table , $num , $p , 'examinePage' , $where , $order );
            return view( 'grade.examinePage' , array( 'arr' => $arr['arr'] , 'page' => $arr['page'] ));
        }else{
            echo 0;
        }
    }
    
    public function examinePage(Request $request)
    {
        $uid = Session::get('uid');
        $role = DB::table( 'res_user' ) -> join( 'res_role' , 'res_user.rid' , '=' , 'res_role.rid' ) -> where('uid' , $uid) -> first();
        $role_name = $role -> role_name;
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table = 'res_grade inner join res_user on res_grade.uid=res_user.uid inner join res_class on res_grade.class_id=res_class.class_id inner join res_college on res_class.cid=res_college.cid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 10;
        //查询条件
        if( $role_name == '教务' ){
            $where = 'res_grade.status=2';
        }elseif( $role_name == '讲师' ){
            $where = 'res_grade.status=1';
        }else{
            $where = 'res_grade.status=0';
        }
        //排序
        $order = 'gid desc';
        $arr = $this -> ajaxPage( $table , $num , $p , 'examinePage' , $where , $order );
        return view( 'grade.examinePage' , array( 'arr' => $arr['arr'] , 'page' => $arr['page'] ));
    }

    /**
     * 查看成材率
     * @auth  刘清白
     * @date 2016-8-8 9:21
     */
    /**
     * 角色判断
     * 决定查看列表
     */
    public function gdList(){
        $uid =  Session::get('uid');
        $users = DB::table( 'res_user' )
            ->select('role_name')
            ->join( 'res_role' , 'res_role.rid' , '=' , 'res_user.rid' )
            ->where( 'uid' , $uid )
            ->get();
        if( '教务' == $users[0]->role_name )
            echo  $this->yuansheng();
    //        if( '系主任' == $users[0]->role_name )
    //            echo $this->xiDirectorList();
    //        if( '讲师' == $users[0]->role_name )
    //            echo $this->teacherList();
        }
    /**
     * 教务
     */
    /*
     * 程序可拆分使用，组合使用浪费资源
    public function jwList(){
    //查询所有学院
    $college =  DB::table('res_college')->get();
    //查询学院的所有系
    foreach($college as $k=>$v)
    {
        //主表  系res_series
        //联查表 学院表res_college  根据学院cid
        $arr =  DB::table('res_series')
            ->join('res_college', 'res_series.cid', '=', 'res_college.cid')
            ->where("res_series.cid","=",$v->cid)
            ->get();
//            print_r($arr);die;
        //查询系中的所有班级
        //主表  班级表 res_class
        //联查表 系 res_series   根据系ser_id
        foreach($arr as $kxi=>$vxi)
        {
            $arr[$kxi]->class  =  DB::table('res_class')
                ->select('class_id','class_name')
                ->join('res_series', 'res_class.ser_id', '=', 'res_series.ser_id')
                ->where("res_series.ser_id","=",$vxi->ser_id)
                ->get();
            //查询班级的所有成绩
            //主表  学生表
            //联查表 班级表 res_class   成绩表 res_grade  根据班级 class_id
            foreach($arr[$kxi]->class as $kgrade=>$vgrade)
            {
                $Aa  = date('Y-m-d',time()-24*60*60);//小于今天
                $Ba = date('Y-m-d',time()-24*60*60*10);//大于前天
                $arr[$kxi]->class[$kgrade]->grade =  DB::table('res_students')
                    ->select('*')
                    ->join('res_class', 'res_class.class_id', '=', 'res_students.class_id')
                    ->join('res_grade', 'res_grade.sid', '=', 'res_students.sid')
                    ->where("res_students.class_id","=",$vgrade->class_id)
                    ->where('g_add_date','<',"$Aa")
                    ->where('g_add_date','>',"$Ba")
                    ->get();
                if(!empty($arr[$kxi]->class[$kgrade]->grade)){
                    $manNum=count($arr[$kxi]->class[$kgrade]->grade);//计算班级总人数
                    $theory=0;
                    $exam=0;
                    foreach($arr[$kxi]->class[$kgrade]->grade as $vtheory=>$ktheory){
                        if(intval($ktheory->theory) >= 90){
                            $theory++;
                        }
                    }
                    foreach($arr[$kxi]->class[$kgrade]->grade as $vexam=>$kexam){
                        if(intval($kexam->exam) >= 90){
                            $exam++;
                        }
                    }
//                        unset()
                    $f= 2;//小数后几位
                    $newtheory = sprintf("%.".$f."f",substr(sprintf("%.6f", (($theory/$manNum)*100)), 0, -2));//理论成绩成才
                    $newexam=sprintf("%.".$f."f",substr(sprintf("%.6f", (($exam/$manNum)*100)), 0, -2));//机试成绩成才
                }else{
                    $newtheory = 0;
                    $newexam= 0;
                }
                $arr[$kxi]->class[$kgrade]->theory=$newtheory;
                $arr[$kxi]->class[$kgrade]->exam =$newexam;

            }
            unset($newtheory);
            unset($newexam);
            if(!empty($arr[$kxi]->class)){
                $manNum=count($arr[$kxi]->class);//计算班级总人数
                $theory2=0;
                $exam2=0;
                foreach($arr[$kxi]->class as $vtheory=>$ktheory){
                    $theory2+=(float)$ktheory->theory;
                }
                foreach($arr[$kxi]->class as $vexam=>$kexam){
                    $exam2+=(float)$kexam->exam;
                }
                $f= 2;//小数后几位
                $newtheory2 = sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory2/$manNum)), 0, -2));//理论成绩成才
                $newexam2=sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam2/$manNum)), 0, -2));//机试成绩成才
            }else{
                $newtheory2 = 0;
                $newexam2= 0;
            }
            $arr[$kxi]->theory=$newtheory2;
            $arr[$kxi]->exam =$newexam2;
            unset($arr[$kxi]->class);//删除班级，释放内存
        }
        if(!empty($arr)){
            $manNum=count($arr);//计算班级总人数
            $theory3=0;
            $exam3=0;
            foreach($arr as $vtheory=>$ktheory){
                $theory3+=(float)$ktheory->theory;
            }
            foreach($arr as $vexam=>$kexam){
                $exam3+=(float)$kexam->exam;
            }
            $f= 2;//小数后几位
            $newtheory3 = sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory3/$manNum)), 0, -2));//理论成绩成才
            $newexam3=sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam3/$manNum)), 0, -2));//机试成绩成才
        }else{
            $newtheory3 = 0;
            $newexam3= 0;
        }
        $college[$k]->theory=$newtheory3;
        $college[$k]->exam =$newexam3;
        unset($newtheory3);
        unset($newexam3);
        if(!empty($arr)){
            $college[$k]->xi = $arr;
            unset($arr);
        }else{
            $college[$k]->xi = [];;
        }
    }

//        print_r($college);die;
    return view('grade.cljiaowu',['college'=>$college]);
}
*/

    public function sum_stu($arr){

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
     * 根据学院id查询所有系
     */
    public function ajaxJwList($id="")
    {
        $college=$this->ajaxCollege();
        foreach($college as $k=>$v) {
            //主表  系res_series
            //联查表 学院表res_college  根据学院cid
            $arr = DB::table('res_series')
                ->join('res_college', 'res_series.cid', '=', 'res_college.cid')
                ->where("res_series.cid", "=", $v->cid)
                ->get();
        }

    }

    /**
     * 计算昨日成才
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function yuansheng()
    {
        $sql = 'select * from res_grade
                INNER JOIN res_students on res_grade.sid=res_students.sid
                INNER JOIN res_class on res_students.class_id=res_class.class_id
                INNER JOIN res_series on res_series.ser_id=res_class.ser_id
                INNER JOIN res_college on res_series.cid=res_college.cid
                where  res_college.cid in(SELECT res_college.cid FROM res_college)
                ';
        $arr = DB::select($sql);
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
            $college[$k]['cid'] =$v['cid'];
            //学院id  用于过滤
            $college_id[] = $v['cid'];
            //学院名字
            $college[$k]['college_name'] =$v['college_name'];

            //系ser_id
            $series_id[$k]=$v['ser_id'];
            $series[$k]['ser_id']=$v['ser_id'];
            //系名字
            $series[$k]['ser_name']=$v['ser_name'];
            //系 学院id
            $series[$k]['cid']=$v['cid'];

            //班级id
            $class_id[$k]=$v['class_id'];
            $class[$k]['class_id']=$v['class_id'];
            //班级   系id
            $class[$k]['ser_id']=$v['ser_id'];
            //班级名字
            $class[$k]['class_name']=$v['class_name'];
            //成绩
            $grade[$k]['theory']=$v['theory'];
            $grade[$k]['exam']=$v['exam'];
//            $grade[$k]['g_add_date']=$v['g_add_date'];
            $grade[$k]['sid']=$v['sid'];
            $grade[$k]['class_id']=$v['class_id'];
        }
        $college_id_uq =  array_unique($college_id);//学院唯一
        $series_id_uq =  array_unique($series_id);//系唯一
        $class_id_uq =  array_unique($class_id);//班级唯一
        $college_all = [];
        foreach($college_id_uq as $k=>$v)
        {
            $college_all[]=$college[$k];
        }
        unset($college_id_uq);

        $series_all = [];
        foreach ( $series_id_uq as $k => $v)
        {
            $series_all[]=$series[$k];
        }
        unset($series_id_uq);
        $class_all = [];
        foreach ( $class_id_uq as $k => $v)
        {
            $class_all[]=$class[$k];
        }
        unset($class_id_uq);
        //$college_all 学院
        //$series_all 系
        //$class_all 班级

        $cl = [];//所有班级加入cl
        foreach ($class_all as $kclass =>$vclass)
        {
            foreach ($grade as $kgrade =>$vgrade)
            {
                if($vclass['class_id']==$vgrade['class_id'])
                {
                    $cl[$kclass]['class_name'] =$vclass['class_name'];;
                    $cl[$kclass]['class_id']   =$vclass['class_id'];
                    $cl[$kclass]['ser_id']     =$vclass['ser_id'];
                    $cl[$kclass]['grade'][]    =  $vgrade;
                }
            }
            if(!empty( $cl[$kclass]['grade'] ) )
            {
                $manNum=count( $cl[$kclass]['grade'] );//计算班级总人数
                $theory3  = 0;
                $exam3    = 0;
                foreach( $cl[$kclass]['grade'] as $vtheory => $ktheory ){
                    $theory3+=(float)$ktheory['theory'];
                }
                foreach($cl[$kclass]['grade'] as $vexam => $kexam){
                    $exam3 += (float)$kexam['exam'];
                }
                $f= 2;//小数后几位
                $newtheory3 = sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory3/$manNum)), 0, -2));//理论成绩成才
                $newexam3=sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam3/$manNum)), 0, -2));//机试成绩成才
            }
            else
            {
                $newtheory3 = 0;
                $newexam3= 0;
            }
            $cl[$kclass]['theory']=$newtheory3;
            $cl[$kclass]['exam'] =$newexam3;
            unset($cl[$kclass]['grade']);
        }

        foreach ($series_all as $kseries =>$vseries)
        {
            foreach ($cl as $kcl =>$vcl)
            {
                if($vseries['ser_id']==$vcl['ser_id'])
                {
                    $series_all[$kseries]['class'][]=$vcl;
                }
            }
            if(!empty( $series_all[$kseries]['class'] ))
            {
                $manNum=count( $series_all[$kseries]['class']);//计算班级总人数
                $theory3=0;
                $exam3=0;
                foreach($series_all[$kseries]['class'] as $vtheory=>$ktheory)
                {
                    $theory3+=(float)$ktheory['theory'];
                }
                foreach($series_all[$kseries]['class'] as $vexam=>$kexam)
                {
                    $exam3+=(float)$kexam['exam'];
                }
                $f= 2;//小数后几位
                $newtheory3 = sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory3/$manNum)), 0, -2));//理论成绩成才
                $newexam3=sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam3/$manNum)), 0, -2));//机试成绩成才
            }
            else
            {
                $newtheory3 = 0;
                $newexam3= 0;
            }
            $series_all[$kseries]['theory']=$newtheory3;
            $series_all[$kseries]['exam'] =$newexam3;
        }
        //从学院到系
        $average=[];
        foreach($college_all as $kcollege=>$vcollege)
        {
            $average[$kcollege]=$vcollege;
            foreach($series_all as $kseries=>$vseries)
            {
                if($vseries['cid']==$vcollege['cid'])
                {
                    $average[$kcollege]['xi'][] = $vseries;
                }
            }
            if(!empty( $average[$kcollege]['xi'] ))
            {
                $manNum=count( $average[$kcollege]['xi']);//计算班级总人数
                $theory3=0;
                $exam3=0;
                foreach($average[$kcollege]['xi'] as $vtheory=>$ktheory)
                {
                    $theory3+=(float)$ktheory['theory'];
                }
                foreach($average[$kcollege]['xi'] as $vexam=>$kexam)
                {
                    $exam3+=(float)$kexam['exam'];
                }
                $f= 2;//小数后几位
                $newtheory3 = sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory3/$manNum)), 0, -2));//理论成绩成才
                $newexam3=sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam3/$manNum)), 0, -2));//机试成绩成才
            }
            else
            {
                $newtheory3 = 0;
                $newexam3= 0;
            }
            $average[$kcollege]['theory']=$newtheory3;
            $average[$kcollege]['exam'] =$newexam3;
        }
        return view('grade.cljiaowu',['college'=>$average]);
    }

    /**
     * ajax点击加载学生成绩
     */
    function ajaxStudent(Request $request)
    {
        $Aa  = date('Y-m-d',time()-24*60*60);//小于今天
        $Ba = date('Y-m-d',time()-24*60*60*10);//大于前天
        $arr =   DB::table('res_students')
            ->select('student_name','theory','exam')
            ->join('res_class', 'res_class.class_id', '=', 'res_students.class_id')
            ->join('res_grade', 'res_grade.sid', '=', 'res_students.sid')
            ->where("res_students.class_id","=",$request['class_id'])
            ->where('g_add_date','<',"$Aa")
            ->where('g_add_date','>',"$Ba")
            ->get();
        echo json_encode($arr);
    }
}
