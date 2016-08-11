<?php

namespace App\Http\Controllers;
use Storage,Input;
use DB;
use Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

header("content-type:text/html;charset=utf-8");
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //非法登录
        $action = $this -> getCurrentAction();
        if( $action['controller'] != 'Login' && $action['controller'] != 'Public') {
            if ( empty( Session::get( 'uid' ) ) ) {
                echo "<script>alert('请先登录');location.href='loginIndex'</script>";
                exit;
            }
            //权限控制
            if( Session::get('uid') != 1 ){
                 $this->userPower();
            }
        }
    }

    /**
     * 无限极分类数组处理
     * @param $table  表名
     * @param $pid_name pid字段名
     * @param int $pid
     * @return array
     */
    public function classify($table,$pid_name,$pid=0){
        $dbh = DB::connection()->getPdo();
        $rescolumns = $dbh->query("SHOW FULL COLUMNS FROM res_power")->fetch();
        $k = $rescolumns['Field'];
        //查询表中根分类
        $stmt = $dbh->query("select * from $table where $pid_name = $pid");
        $arr = $stmt->fetchAll($dbh::FETCH_ASSOC);
        $dbh = null;
        //查询子分类
        foreach($arr as $key=>$val)
        {
            $arr[$key]['son']=$this->classify( $table , $pid_name , $pid = $val[$k] );
        }
        return $arr;
    }

    /**
     * 获取当前控制器与方法
     *
     * @return array
     */
    public function getCurrentAction()
    {
        $action = \Route::current()->getActionName();
        list($class, $method) = explode('@', $action);
        $controller = substr($class, strpos($class, 'Controllers') + 12, -10);
        return ['controller' => $controller, 'function' => $method];
    }

    //添加日志
    public function adminLog($content){
        $adm_id = $_SESSION['uid'];
        $time = date('Y-m-d H:i:s',time());
        DB::table('res_user_log')->insert(
            ['uid' => $adm_id , 'content' => $content , 'log_addtime' => $time]);
    }


    /**
     * ajax分页
     * @param $table        查询表名
     * @param $num          每页显示数量
     * @param $p            当前页码
     * @param $url          分页地址
     * @param $where        查询条件
     * @param $order        排序字段
     * @return mixed        返回    三维数组
     */
    
    public function ajaxPage($table,$num,$p,$url,$where=1,$order=1){
        //查询语句
            $re = DB::select("select * from $table where $where");
        //计算查询数据条数
        $count = count($re);
        if($count == 0){
            $data['arr'] = "";
            //搜索样式
            $sel='<div class="cfD" style="float: right;margin-top: 42px;">
                    <input class="addUser" type="text" id="search" value="" placeholder="请输入要搜索的内容" />
                    <input class="button" type="button" onclick="ckPage('."'$url'".',1)"  value="搜索"/>
                </div>';
            $str = '';
            $str.="<div class='pagin'><div class='message'>共<i class='blue'>$count</i>条记录<ul class='paginList'></div>";
            $data['page'] = $str;
            $data['sel'] = $sel;
            return $data;
        }else{
            //计算总页数
            $page=ceil($count/$num);
            //计算偏移量
            $n=($p-1)*$num;
            //查询所要数据
            $arr = DB::select("select * from $table where $where order by $order limit $n,$num");
            $data['arr'] = $arr;
            //上一页
            $last=($p-1)<1?1:$p-1;
            //下一页
            $next=($p+1)>$page?$page:$p+1;
            //搜索样式
            $sel='<div class="cfD" style="float: right;margin-top: 42px;">
                    <input class="addUser" type="text" id="search" value="" placeholder="请输入要搜索的内容" />
                    <input class="button" type="button" onclick="ckPage('."'$url'".',1)"  value="搜索"/>
                </div>';
            //分页样式
            $str='<link rel="stylesheet" type="text/css" href="page/page.css"/>
            <script src="page/page.js"></script>
            ';
            $str.="<div class='pagin'><div class='message'>共<i class='blue'>$count</i>条记录，当前显示第<i class='blue'>$p</i>页</div><ul class='paginList'><li class='paginItem'><a href='javascript:;' onclick=ckPage('".$url."',1)><span class='pagepre'><<</span></a></li>";
            for($i=1;$i<=$page;$i++){
                if($i==$p){
                    $str.="<li class='paginItem current'><a href='javascript:;' onclick=ckPage('".$url."',$i)>$i</a></li>";
                }else{
                    if($i<$p-4){
                        $str.="<li class='paginItem more'><a href='javascript:;'>...</a></li>";
                        $i=$p-5;
                    }elseif($i>$p+4){
                        $str.="<li class='paginItem more'><a href='javascript:;'>...</a></li>";
                        $i=$i+3;
                    }else{
                        $str.="<li class='paginItem'><a href='javascript:;' onclick=ckPage('".$url."',$i)>$i</a></li>";
                    }
                }
            }
            $str.="<li class='paginItem'><a href='javascript:;' onclick=ckPage('".$url."',$page)><span class='pagenxt'>>></span></a></li></ul></div>";
            $data['page']=$str;
            $data['sel']=$sel;
            $data['pageNum']=$page;
            $data['count']=$count;
            $data['p']=$p;
            return $data;
        }
    }

    /**
     * 权限控制
     */
    private function userPower()
    {
        $action = $this -> getCurrentAction();
        //当前控制器名
        $controller = $action['controller'];
        //当前操作名
        $function = $action['function'];

        //公共权限
        if($controller == "Index" && $function == "index"){
            return;
        }
        $pri_list = Session::get('power');
//        print_r($pri_list);die;
        $power = require_once ('Auth/PowerConfig.php');
        $sign = 0;
        $power_list = array();
        foreach( $pri_list as $key => $val ){
            if( array_key_exists($val['power_name'] , $power['navigation']) ) {
                foreach ( $val[ 'son' ] as $k => $v ) {
                    if ( array_key_exists( $v[ 'power_name' ] , $power[ 'navigation' ] ) ) {
                        foreach ( $power[ 'navigation' ][ $v[ 'power_name' ] ][ 1 ] as $kk => $vv ) {
                            $power_list[ $power[ 'navigation' ][ $val[ 'power_name' ] ][ 1 ] ][] = $vv;
                        }
                    } elseif ( array_key_exists( $v[ 'power_name' ] , $power[ 'not_navigation' ] ) ) {
                        foreach ( $power[ 'not_navigation' ][ $v[ 'power_name' ] ] as $kk => $vv ) {
                            $power_list[ $power[ 'navigation' ][ $val[ 'power_name' ] ][ 1 ] ][] = $vv;
                        }
                    }
                }
            }
        }
        $sign = 0;
        if( array_key_exists( $controller , $power_list )){
            if( in_array( $function , $power_list[$controller] ) ){
                $sign = 1;
            }
        }
        if($sign == 0){
            echo "<script>alert('无权操作！');window.history.go(-1)</script>";
            exit;
        }
    }

    /**
     * 查询
     * @param $table 查询表名
     *               如果是多表联查  $table应为二维数组 格式为：
     *               array( [' table1' => '' , 'table2' => '' ,'join' => '' ] , ... )
     *               其中 table1 为联查表1  table2 为联查表2  join 为联查字段    三表联查例：
     *               $table = array(
                        [ 'table1' => 'res_grade' , 'table2' => 'res_user' , 'join' => 'uid' ] ,
                        [ 'table1' => 'res_grade' , 'table2' => 'res_class' , 'join' => 'class_id' ] ,
                        [ 'table1' => 'res_class' , 'table2' => 'res_college' , 'join' => 'cid' ]
                    );
     * @param int $where 查询条件 默认为没有条件
     *                   如果为多条件查询  $where为一维数组  格式为： array( '' , '' , ...); 其中引号中应该为查询条件 例：
     *                   $where = array( 'uid=1' , 'status=1' , 'add_date=2016-8-6' );
     * @param int $limit 是否是查询一条  默认为查询全表 返回二维 ， 如果为查询一条  $limit = 1  返回一维
     * @param int $order 排序规则  如果无排序  $order = 1
     * @param int $page  是否分页  默认为不分页  会直接返回查询结果
     *                    如果分页   $page应为一维数组  返回本页数据及分页样式等  例：
     *                   $page = array( 'num' => 10 , 'p' => $p , 'url' => 'logPage' )
     *                   其中  num 为每页显示条数  p 为当前页码  url 为分页替换的路由
     * @return mixed
     */
    protected function databasesSelect( $table , $where = 1 , $limit = 0 ,$order = 1 , $page = 0 )
    {
        if( is_array( $where ) ){
            foreach ( $where as $key => $val ){
                if( $key == 0 ){
                    $where = $val;
                }else{
                    $where .= ' and '.$val;
                }
            }
        }
        if( is_array( $table ) ) {
            $sql = '`' . $table[ 0 ][ 'table1' ] . '`';
            foreach ( $table as $key => $val ) {
                $sql .= ' inner join `' . $val[ 'table2' ] . '` on ' . '`' . $val[ 'table1' ] . '`.`' . $val[ 'join' ] . '`=' . '`' . $val[ 'table2' ] . '`.`' . $val[ 'join' ] . '`';
            }
        }else{
            $sql = $table;
        }
        if( $page == 0){
            if( $limit == 0 ) {
                $arr = DB::select( "select * from $sql where $where order by $order " );
            }else{
                $arr = DB::select( "select * from $sql where $where order by $order limit 1" );
                $arr = $arr[0];
            }
        } else {
//            echo $sql;die;
            $arr = $this -> ajaxPage( $sql , $page['num'] , $page['p'] ,$page['url'] , $where , $order );
        }
        return $arr ;
    }

    /**
     * 添加
     * @param $table 表名
     * @param $data  入库数据 一维数组为添加一条  二维数组为添加多条
     * @param int $insert_id  是否返回刚刚添加的数据id  默认不返回 如果返回 $insert_id = 1;
     * @return mixed
     */
    protected function databasesInsert( $table , $data , $insert_id = 0 )
    {
        if( $insert_id == 0 ) {
            $re = DB::table( $table )->insert( $data );
        }else{
            $re = DB::table( $table )->insertGetId( $data );
        }
        return $re ;
    }

    /**
     * 删除
     * @param $table 表名
     * @param $where 条件 例： 'uid=1'
     * @return mixed
     */
    protected function databasesDelete( $table , $where )
    {
        $where = explode( '=' , $where);
        $re = DB::table($table)->where(trim($where[0]) , trim($where[1]))->delete();
        return $re ;
    }
    
    /**
     * 修改
     * @param $table 表名
     * @param $data 修改的数据  一维数组     $data = array(要修改的字段 => 修改后的值)
     * @param $where 条件 例： 'uid=1'
     * @return mixed
     */
    protected function databasesUpdate( $table , $data ,$where )
    {
        $where = explode( '=' , $where);
        $re = DB::table($table)
            ->where(trim($where[0]) , trim($where[1]))
            ->update($data);
        return $re ;
    }
}
