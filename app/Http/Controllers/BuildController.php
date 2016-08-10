<?php
namespace App\Http\Controllers;

use DB;
use Session;
use Illuminate\Http\Request;
header("Content-type: text/html; charset=utf-8"); 
class BuildController extends Controller
{
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
         $res = DB::table('res_group')->where('class_id',$class_id)->get();    //查询本班级是否分组
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
                $group[] = $val -> gr_id;
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
                        if( $v -> gr_id == $val )
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
                            if( $arr[$key][0] -> gr_id != $val )
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

}