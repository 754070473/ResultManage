<?php
namespace App\Http\Controllers;

use DB;
use Session;
use Illuminate\Http\Request;
use Code;

require_once(__DIR__."/../../../vendor/captcha_code.php");


class LoginController extends Controller
{
	/*
	*	登录
	*/

	//登录页面
	public function index()
	{
		return view('login.login');
	}

	/**
     * 验证码
     */
    function captcha_code()
    {
        //构造方法
        $code=new \ValidationCode(80, 20, 4);
        $code->showImage();   //输出到页面中供 注册或登录使用
        Session::put('code',$code->getCheckCode());
        //$_SESSION["code"]=$code->getCheckCode();  //将验证码保存到服务器中

    }


	//接受数据进行判断登录
	public function login(Request $request)
	{
		//接受数据
		 $arr=$request->all();
		 //账号
		 $accounts = $arr['accounts'];
		 //密码
		 $password = $arr['password'];
		 //验证码
		 $yzm = $arr['yzm'];
		 // print_r($account);

		  $code = strtolower(Session::get("code"));   //取出session中的验证码，并且转换为小写
          $captcha =  strtolower($yzm);        //把输入的验证码转换为小写
          //判断验证码
          if ($code==$captcha) 
          {
		          //查询数据表，进行判断
				 $user = DB::table('res_user')->where('accounts',$accounts )->first();
				 if ($user) 
				 {
					 	if ($password==$user->password) 
					 	{
					 		$uid = $user->uid;
					 		Session::put('uid',$uid);  //把用户ID存入session
					 		$users = DB::table('res_user_role')
				            ->join('res_role_power', 'res_role_power.rid', '=', 'res_user_role.rid')
				            ->join('res_power', 'res_power.pid', '=', 'res_role_power.pid')
				            ->where('uid',$uid )
				            ->get();
				            foreach ($users as $key => $v) 
				            {
				            	$power[$key]['power_name'] = $v->power_name;
				            	$power[$key]['controller'] = $v->controller;
				            	$power[$key]['action'] = $v->action;
				            }
					 		// print_r($power);
					 		//把用户所对应的角色的权限存入session中；
					 		Session::put('power',$power);

					 		echo 0;

					 	}
					 	else
					 	{
					 		// echo '密码错误';
					 		echo 1;
					 	}
				 }
				 else
				 {
				 	 // echo '账号错误';
				 	echo 2;
				 }
          }
          else
          {
          	// echo '验证码错误';
          		echo 3;
          }
		 
	}

}
