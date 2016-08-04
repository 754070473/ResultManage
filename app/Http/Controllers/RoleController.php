<?php
namespace App\Http\Controllers;
header('content-type:text/html;charset=utf8');
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
class RoleController extends Controller
{
    /*
     * 角色是否可用页面
     */
    public function roleAdd(Request $request)
    {
            if($request->input()){
                $val['role_name'] = $request->input('role');
                $list = DB::table('role')->where($val)->get();
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
     * 角色展示页面
     */
    public function roleList(Request $request)
    {
        if($request->input()){
            $id = $request->input('id');
            $arr['status'] = $request->input('status');
            $info = Db::table('role')
                    ->where('rid',$id)
                    ->update($arr);
            if($info){
                echo 1;
            }
        }else{
            $list = Db::table('role')->get();
            return view('role.roleList',['list'=>$list]);
        }

    }
    /*
     * 角色的添加页面
     */
    public function roleIns(Request $request)
    {
       if($request->input()){
           $arr['role_name'] = $request->input('role_name');
           if($request->input('status')==true){
               $arr['status'] = 1;
           }else{
               $arr['status'] = 0;
           }
           $info = Db::table('role')->insert($arr);
           echo "<script>alert('添加成功');location.href='rolelist'</script>";
       }else{
           return view('role.roleAdd');
       }
    }
    /*
     *  角色名称的修改页面
     */
    public function roleUpd(Request $request){
        if($request->input()){
            $id = $request->input('id');
            $list = Db::table('role')
                        ->where('rid',$id)
                        ->get();
            return view('role.roleUpdate',['list'=>$list]);
        }else{

        }
    }
    /*
     *  角色名称的修改
     */
    public function roleUpdate(Request $request){
        if($request->input()){
            $arr['role_name'] = $request->input('role_name');
            $id = $request->input('rid');
            if($request->input('status')==true){
                $arr['status'] = 1;
            }else{
                $arr['status'] = 0;
            }
            $info = Db::table('role')
                ->where('rid',$id)
                ->update($arr);
            if($info){
                return redirect('rolelist');
            }
        }else{

        }
    }
    /*
     *  删除角色操作
     */
    public function roleDelete(Request $request){
        $id = $request->input('id');
        $info = Db::table('user_role')
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
        $id = $request->input('id');
        Db::table('role')
            ->where('rid',$id)
            ->delete();
        echo 1;
    }
}
