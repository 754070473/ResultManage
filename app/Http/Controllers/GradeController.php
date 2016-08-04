<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB,Input,Redirect,Session,url;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\excel\PHPExcel;

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
        $arr=DB::table('grade')->where('status','=','1')->get();
        $arr2=DB::table('grade')->where('status','=','2')->get();
        $arr3=DB::table('grade')->where('status','=','3')->get();
        $arr4=DB::table('grade')->where('status','=','4')->get();
        return view('grade/from',['arr'=>$arr,'arr2'=>$arr2,'arr3'=>$arr3,'arr4'=>$arr4]);
    }
    //添加成绩录入
    public function grade_add(Request $request){
       $theory=$request->input('theory');
       $exam=$request->input('exam');
        $add_date=date("Y-m-d");
        $add_time=date("H:i:s",time());
        $status=$request->input('status');
        $type=$request->input('type');
        DB::table('grade')->insert(array("theory"=>$theory,'exam'=>$exam,'add_date'=>$add_date,'add_time'=>$add_time,'status'=>$status,'type'=>$type));
        return redirect('show');
    }

    //查看成绩
    public function show(){
        $arr1=DB::table('role')->get();
        $arr=DB::table('grade')->get();
        return view('grade/show',['arr1'=>$arr1,'arr'=>$arr]);
    }
    //成绩审核
    public function updates(){
        $arr=DB::table('grade')->get();
        return view('grade/updates',['arr'=>$arr]);
    }

//    public function deletes(Request $request){
//        $gid=$request->input('gid');
//        echo $gid;die;
//    }


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
