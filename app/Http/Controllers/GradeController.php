<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB,Input,Redirect,Session,url;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\excel\PHPExcel;
use Cookie;
/*
 * @author:dongmengtao
 * @time:2016/08/03
 * @controller:成绩管理
 */


header("content-type:text/html;charset=utf-8");
class GradeController extends Controller
{
    //查看成绩录入
    public function grade()
    {
        $arr = DB::table('grade')->where('status','=','1')->get();
        $arr2 = DB::table('grade')->where('status','=','2')->get();
        $arr3 = DB::table('grade')->where('status','=','3')->get();
        $arr4 = DB::table('grade')->where('status','=','4')->get();
        return view('grade/from',['arr'=>$arr,'arr2'=>$arr2,'arr3'=>$arr3,'arr4'=>$arr4]);
    }
    //添加成绩录入
    public function grade_add(Request $request){
        $name = Session::get('name');
       $theory = $request->input('theory');
       $exam = $request->input('exam');
        $add_date = date("Y-m-d H:i:s",time());
        $add_time = date("H:i:s",time());
        $status = $request->input('status');
        $type = $request->input('type');
        DB::table('grade')->insert(array("theory"=>$theory,'exam'=>$exam,'add_date'=>$add_date,'add_time'=>$add_time,'status'=>$status,'type'=>$type,'name'=>$name));
        return redirect('show');
    }

    //查看成绩
    public function show(Request $request){
       Session::get('name');
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table='res_user inner join res_role on res_user.rid=res_role.rid inner join  res_grade on res_user.uid=res_grade.uid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 10;
        //查询条件
        $where = 1;
        //排序
        $order = 'res_grade.add_date desc';
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


    public function gradeDelete(Request $request){
        $gid=$request->input('gid');
        $re = DB::table('grade')->whereIn( 'gid' , array($gid) )->delete();
//        var_dump($re);die;
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
                $where = "DATE(`add_date`) = '$date'";
            }
            //排序
            $order = 'res_grade.add_date desc';
            $arr = $this -> ajaxPage( $table , $num , $p , 'gradePage' , $where , $order );
//        print_r($arr);die;
            return view( 'grade.gradePage' , array( 'arr' => $arr['arr'] , 'page' => $arr['page'] ));
        }else{
            echo 0;
        }

 }



    //成绩审核
    public function updates(Request $request){
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table='res_user inner join res_role on res_user.rid=res_role.rid inner join  res_grade on res_user.uid=res_grade.uid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 1;
        //查询条件
        $where = 1;
        //排序
        $order = 'res_grade.add_date desc';
        $arr = $this -> ajaxPage( $table , $num , $p , 'gradePage' , $where , $order );
        //print_r($arr);die;
        //根据用户查询角色 并显示出来
        return view('grade.updates',array('arr'=>$arr['arr'],'page'=>$arr['page']));
    }



    //管理员列表导入
    public function import(){
//        $this->load->library('/PHPExcel.php');
        new PHPExcel();
        //这里是导入excel2007 的xlsx格式，如果是2003格式可以把“excel2007”换成“Excel5"
        //怎么样区分用户上传的格式是2003还是2007呢？可以获取后缀  例如：xls的都是2003格式的
        //xlsx 的是2007格式的  一般情况下是这样的
        $objReader = PHPExcel_IOFactory::createReader('excel2007');
        //导入的excel路径
        $excelpath=$_FILES['myfile']['tmp_name'];
        @$objPHPExcel=$objReader->load($excelpath);
        if($objPHPExcel){
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            //导入的excel路径
            $excelpath=$_FILES['myfile']['tmp_name'];
            $objPHPExcel=$objReader->load($excelpath);
        }
        $sheet=$objPHPExcel->getSheet(0);
        //取得总行数
        $highestRow=$sheet->getHighestRow();
        //取得总列数
        $highestColumn=$sheet->getHighestColumn();
        $link=mysql_connect("127.0.0.1","root","root")or die('连接失败');;
        mysql_select_db("grade",$link)or die('选择失败');
        mysql_query("set names utf8");
        //从第二行开始读取数据  因为第一行是表格的表头信息
        $sql = "insert into grade (theory,exam,add_date,add_time,status,type) values ";
        for($j=2;$j<=$highestRow;$j++) {
            $str = "";
            //从A列读取数据
            for ($k='B'; $k <= $highestColumn; $k++) {
                $str .= $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue() . '|*|';//读取单元格
            }
            $str = mb_convert_encoding($str, 'utf8', 'auto');//根据自己编码修改
            $strs = explode("|*|", $str);
            //拼写sql语句
            $sql .= "('{$strs[0]}','{$strs[1]}','{$strs[2]}','{$strs[3]}','{$strs[4]}','{$strs[5]}','{$strs[6]}','{$strs[7]}','{$strs[8]}'),";
        }
//		echo $sql;die;
        $sql=substr($sql,0,-1);
//		echo $sql;die;
        $res=mysql_query($sql);
        if(mysql_affected_rows()==$highestRow-1){
            echo "<script>alert('导入成功！');location.href='show'</script>";
        }else{
            echo "<script>alert('上传失败！，总共目前上传了 '.".mysql_affected_rows().");location.href='from'</script>";
        }
    }


}
