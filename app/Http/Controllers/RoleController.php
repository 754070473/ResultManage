<?php
namespace App\Http\Controllers;
header('content-type:text/html;charset=utf8');
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
class RoleController extends Controller
{
    /*
     * 角色是否可用页面
     */
    public function roleAdd(Request $request)
    {
            if($request->input()){
                $val['role_name'] = $request->role;
                $list = DB::table('res_role')->where($val)->get();
                $result = array(
                    'error' => 0,   // 0:成功 1:失败
                    'msg'   => '可以使用',
                    'data'  =>'',
                );
                if(empty($val['role_name'])){
                    $result['error'] = 1;
                    $result['msg'] = '不能为空';
                }else if(!empty($list)){
                    $result['error'] = 1;
                    $result['msg'] = '角色名已存在';
                }
                return $result;
            }else{
                return view('role.roleAdd');
            }
    }
    /*
     * 角色状态修改
     */
    public function roleStatus(Request $request)
    {
        $id = $request->id;
        $arr['status'] = $request->status;
        $info = Db::table('res_role')
                ->where('rid', $id)
                ->update($arr);
            if ($info) {
                echo 1;
                }
    }
    /*
     * 角色展示页面
     */
    public function roleList(Request $request){
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table = 'res_role';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 5;
        $order = 'rid desc';
        //调用ajaxPage方法
        $arr =  $this-> ajaxPage ( $table , $num , $p , 'rolelists',$where=1,$order);
        return view('role.roleList',['list'=>$arr['arr'],'page'=>$arr['page']]);
    }
    /*
     * 角色的分页页面
     */
    public  function  rolePage(Request $request){
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table = 'res_role';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 5;
        //调用ajaxPage方法
        $arr =  $this-> ajaxPage ( $table , $num , $p , 'rolelists');
        return view('role.rolePage',['list'=>$arr['arr'],'page'=>$arr['page']]);
    }
    /*
     * 角色的添加页面
     */
    public function roleIns(Request $request)
    {
       if($request->input()){
           $arr['role_name'] = $request->role_name;
           if($request->input('status')==true){
               $arr['status'] = 1;
           }else{
               $arr['status'] = 0;
           }
           $info = Db::table('res_role')->insert($arr);
           if($info){
               return redirect('rolelist');
           }
       }else{
           return view('role.roleAdd');
       }
    }
    /*
     *  角色名称的修改页面
     */
    public function roleUpd(Request $request){
        if($request->input()){
            $id = $request->id;
            $list = Db::table('res_role')
                        ->where('rid',$id)
                        ->get();
            return view('role.roleUpdate',['list'=>$list]);
        }
    }
    /*
     *  角色名称的修改
     */
    public function roleUpdate(Request $request){
        if($request->input()){
            $arr['role_name'] = $request->role_name;
            $id = $request->input('rid');
            if($request->input('status')==true){
                $arr['status'] = 1;
            }else{
                $arr['status'] = 0;
            }
            $info = Db::table('res_role')
                ->where('rid',$id)
                ->update($arr);
            if($info){
                return redirect('rolelist');
            }
        }
    }
    /*
     *  删除角色操作
     */
    public function roleDelete(Request $request){
        $id = $request->id;
        $info = Db::table('res_user_role')
            ->where('rid',$id)
            ->get();
        $default = array(
            'error'  => 0,   //0:成功，1:失败
            'msg'    => '',
            'data'   => $id
            );
        if(!empty($info)){
            $default['error'] = 1;
            $default['msg']   = '该角色下有用户,不可删除';
        }
        return $default;
    }
    /*
     *  删除角色成功
     */
    public  function roleDel(Request $request){
        $id = $request->id;
        Db::table('res_role')
            ->where('rid',$id)
            ->delete();
        Db::table('res_role_power')
            ->where('rid',$id)
            ->delete();
        echo 1;
    }
    /*
    *  赋权
    */
    public function roleGive(Request $request){
        $id = $request->id;
        //echo $id;die;
        $list = Db::table('res_role_power')
            ->where('rid',$id)
            ->join('res_power','res_role_power.pid','=','res_power.pid')
            ->get();
        $arr=array();
        foreach($list as $k=>$v){
            $arr[] = $v->pid;
        }
        $number = implode(',',$arr);
        $table = 'res_power';
        $fid = 'fid';
        $arr = $this -> classify($table,$fid);
        return view('role.rolegive',['list'=>$arr,'give'=>$list,'number'=>$number,'rid'=>$id]);
    }
    /*
    *  修改权限
    */
    public function roleGives(Request $request){
        $rel = $request->rel;
        $rid = $request->rid;
        $user = explode(',',$rel);
        Db::table('res_role_power')
            ->where('rid',$rid)
            ->delete();
        $re=Db::table('res_power')
            ->wherein('pid',$user)
            ->lists('fid');
        foreach($re as $k=>$v){
            if($v==0){
                unset($re[$k]);
            }
        }
        $user=array_merge($re,$user);
        $user=array_unique($user);
        $i=0;
        foreach($user as $k => $v){
            $info[$i]['rid'] = $rid;
            $info[$i]['pid'] = $v;
            $i++;
        }
//        print_r($info);die;
        Db::table('res_role_power')
            ->insert($info);
        return redirect('rolegive?id='.$rid);
    }
}
