<?php
namespace App\Http\Controllers;
use DB;
use Session;
use Illuminate\Http\Request;

header("content-type:text/html;charset=utf-8");
class IndexController extends Controller
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('index.index');
    }
    
    /**
     * 管理员日志
     */
    public function userLog(Request $request)
    {
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table = 'res_user_log inner join res_user on res_user_log.uid=res_user.uid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 10;
        $where = 1;
        $order = 'log_addtime desc';
        $arr = $this -> ajaxPage( $table , $num , $p , $where , $order);
        return view('index.userLog');
    }
}
