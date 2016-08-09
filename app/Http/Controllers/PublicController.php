<?php
namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use DB;
use Session;

class PublicController extends Controller
{
    public function top()
    {
    	$uid = Session::get('uid');   //获取当前用户id
    	//根据用户id查询出当前的账号；
		$data = DB::table('res_user')->where('uid',$uid )->first();
        return view('public.top',array('data'=>$data));
    }
    
    public function left()
    {
        if(Session::get('uid') == 1){
            $access=$this->getleft('res_power','fid');
        }else{
            $access=Session::get('power');
        }

        $access_msg=[
            '权限管理'=>'icon-desktop',
            '角色管理'=>'icon-edit',
            '管理员管理'=>'icon-list',
            '成绩管理'=>'icon-list-alt',
            '组建管理'=>'icon-calendar',
            '添加权限'=>'poweradd',
            '权限列表'=>'showpower',
            '管理员添加'=>'useradd',
            '管理员列表'=>'userList',
            '添加角色'=>'roleadd',
            '角色列表'=>'rolelist',
            '成绩录入'=>'grade',
            '查看成绩'=>'gdList',
            '成绩审核'=>'examine',
            '创建班级'=>'groupClaShow',
            '创建学院'=>'collShow',
            '组员录入'=>'groupMan'
        ];
        foreach ($access as $key => $value) {
            $access[$key]['type']=$access_msg[$value['power_name']];
            foreach ($value['son'] as $k => $val) {
                if(isset($access_msg[$val['power_name']])){
                    $access[$key]['son'][$k]['url']=$access_msg[$val['power_name']];
                }
            }
        }
        // print_r($access);die;
        return view('public.left',['access'=>$access]);
    }
    public function getleft($table,$pid_name,$pid=0){
        $dbh = DB::connection()->getPdo();
        $rescolumns = $dbh->query("SHOW FULL COLUMNS FROM ".$table)->fetch();
        $k = $rescolumns['Field'];
        //查询表中根分类
        $stmt = $dbh->query("select * from $table where $pid_name = $pid and status=1");
        $arr = $stmt->fetchAll($dbh::FETCH_ASSOC);
        $dbh = null;
        //查询子分类
        foreach($arr as $key=>$val)
        {
            $arr[$key]['son']=$this->getleft( $table , $pid_name , $pid = $val[$k] );
        }
        return $arr;
    }
}
