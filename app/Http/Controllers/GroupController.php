<?php
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
header("Content-type: text/html; charset=utf-8"); 
class GroupController extends Controller
{
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
                    $num=count(DB::table('res_class')->where('cid',$v->cid )->lists('class_name'));
                    $arr['arr'][$k]->num=$num;
                }
                
                // print_r($arr['arr']);die;
            	// echo 1;
                return view('group.show',array( 'arr' => $arr['arr'] , 'page' => $arr['page'] ));
            }
            
          /*
           *@学院添加
           *
           */
            public function groupCollAdd(Request $request)
            {

            	  $coll_name=$request->coll_name;
                  $reg="/^[\u4e00-\u9fa5]{1,10}$/";
                  if(preg_match($reg,$coll_name))
                  {
                        echo "学院名称必须为汉字且小于10位";
                  }else
                  {
                     // echo $coll_name;
                        $id=DB::table('res_college')->insert([
                            'college_name'=>$coll_name,
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

            public function groupClaShow()
            {
                $arr=DB::table('res_college')->select('cid','college_name')->get();

                // print_r($arr);die;
                return view('group.classShow',array( 'arr' => $arr));
            }
          /*
           *@班级添加
           *
           */

            public function groupClaAdd(Request $request)
            {

                  $class_name=$request->class_name;
                  $coll_id=$request->coll_id;
                  // echo $class_name;
                  // echo $coll_id;die;
                  $reg="/^[0-9]+[A-Z]+$/";
                  if(preg_match($reg,$class_name))
                  {
                        echo "班级名称应由数字字母组成";
                  }else
                  {
                     // echo $coll_name;
                        $id=DB::table('res_class')->insert([
                            'cid'=>$coll_id,
                            'class_name'=>$class_name,
                          ]);
                        DB::table('res_user')->insert([
                            'username'=>$class_name,
                            'password'=>'1234',
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



          /*
           *@小组添加
           *
           */
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
                            'college_name'=>$coll_name,
                          ]);
                        DB::table('res_user')->insert([
                            'username'=>$coll_name,
                            'password'=>'1234',
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

}


?>