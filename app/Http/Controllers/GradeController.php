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
       $name = Session::get('name');
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table='res_user inner join res_role on res_user.rid=res_role.rid inner join  res_grade on res_user.uid=res_grade.uid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 10;
        //查询条件
        $where = 1;
        //排序
        $order = 'res_grade.g_add_date desc';
        $arr = $this -> ajaxPage( $table , $num , $p , 'gradePage' , $where , $order );
        //print_r($arr);die;
        //根据用户查询角色 并显示出来
        return view('grade.show',array('arr'=>$arr['arr'],'page'=>$arr['page']));
    }

    public function search(Request $request){
        Session::get('name');
        $search=$request->input('search');
        $username=$request->input('username');
        $exam=$request->input('exam');
        if($exam==1){

        }
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table='res_user inner join res_role on res_user.rid=res_role.rid inner join  res_grade on res_user.uid=res_grade.uid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 10;
        //查询条件
        $where = "name like '%$search%'";
        //排序
        $order = 'res_grade.add_date desc';
        $arr = $this -> ajaxPage( $table ,$num , $p , 'gradePage' , $where ,$order );
//print_r($arr);die;
        return view('grade.searchs',array('arr'=>$arr['arr'],'page'=>$arr['page'],'name'=>$search,'username'=>$username,'exam'=>$exam));
    }



    //分页
    public function gradePage(Request $request){
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
            $where = "DATE(`add_date`) = '$date'";
        }
        //排序
        $order = 'res_grade.add_date desc';
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
                'name'=>"{$strs[0]}",
                'theory'=>"{$strs[1]}",
                'exam'=>"{$strs[2]}",
                'status'=>"{$strs[3]}",
                'type'=>"{$strs[4]
                }"
            ];
        }
//		echo $sql;die;
        foreach( $sql as $key => $val ){
            $sql[$key]['g_add_date'] = date( 'Y-m-d' , time() );
            $sql[$key]['add_time'] = date( 'H:i:s' , time() );
            $sql[$key]['uid'] = Session::get('uid');
        }
        $res=DB::table('res_grade')->insert($sql);
        if($res){
            echo "<script>alert('导入成功！');location.href='show'</script>";
        }else{
            echo "<script>alert('导入失败！');location.href='from'</script>";
        }
    }

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
        }elseif( $role_name == '讲师' ){
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
}
