<?php
namespace App\Http\Controllers;
use DB;
use Session;
use Illuminate\Http\Request;

header("content-type:text/html;charset=utf-8");
class IndexController extends Controller
{
    /**     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
//        $table = array(
//            [ 'table1' => 'res_grade' , 'table2' => 'res_user' , 'join' => 'uid' ] ,
//            [ 'table1' => 'res_grade' , 'table2' => 'res_class' , 'join' => 'class_id' ] ,
//            [ 'table1' => 'res_class' , 'table2' => 'res_college' , 'join' => 'cid' ]
//        );
//        $where = 'res_grade.status=3';
//        $order = 'res_user.uid desc';
//        $page = array( 'num' => 10 , 'p' => 1 , 'url' => 'index' );
//        $arr = $this -> databasesSelect( $table , $where , 0 , $order , $page );
//        print_r($arr);die;
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
        //查询条件
        $where = 1;
        //排序
        $order = 'log_addtime desc';
        $arr = $this -> ajaxPage( $table , $num , $p , 'logPage' , $where , $order );
//        print_r($arr);die;
        return view( 'index.userLog' , array( 'arr' => $arr['arr'] , 'page' => $arr['page'] ));
    }
    
    /**
     * 日志分页
     */
    public function logPage(Request $request)
    {
        //搜索日期
        $date = $request -> search ? $request -> search : '';
        //当前页码
        $p = $request -> p ? $request -> p : 1;
        //查询表名
        $table = 'res_user_log inner join res_user on res_user_log.uid=res_user.uid';
        //每页显示数据条数
        $num = $request -> num ? $request -> num : 10;
        //查询条件
        if($date == '') {
            $where = 1;
        }else{
            $where = "DATE(`log_addtime`) = '$date'";
        }
        //排序
        $order = 'log_addtime desc';
        $arr = $this -> ajaxPage( $table , $num , $p , 'logPage' , $where , $order );
//        print_r($arr);die;
        return view( 'index.logPage' , array( 'arr' => $arr['arr'] , 'page' => $arr['page'] ));
    }

    /**
     * 日志删除
     */
    public function logDelete(Request $request)
    {
        $log_id = $request -> log_id;
        $re = DB::table('res_user_log')->whereIn( 'log_id' , array($log_id) )->delete();
        if( $re ){
            //搜索日期
            $date = $request -> search ? $request -> search : '';
            //当前页码
            $p = $request -> p ? $request -> p : 1;
            //查询表名
            $table = 'res_user_log inner join res_user on res_user_log.uid=res_user.uid';
            //每页显示数据条数
            $num = $request -> num ? $request -> num : 10;
            //查询条件
            if($date == '') {
                $where = 1;
            }else{
                $where = "DATE(`log_addtime`) = '$date'";
            }
            //排序
            $order = 'log_addtime desc';
            $arr = $this -> ajaxPage( $table , $num , $p , 'logPage' , $where , $order );
//        print_r($arr);die;
            return view( 'index.logPage' , array( 'arr' => $arr['arr'] , 'page' => $arr['page'] ));
        }else{
            echo 0;
        }
    }
}
