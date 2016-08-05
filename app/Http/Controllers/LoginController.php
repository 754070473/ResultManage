<?php
namespace App\Http\Controllers;

use DB;
use Session;
use Illuminate\Http\Request;
use Code;
use Illuminate\Http\RedirectResponse;
use mail;

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

	//验证码
    function captcha_code()
    {
        //构造方法
        $code=new \ValidationCode(80, 20, 4);
        $code->showImage();   //输出到页面中供 注册或登录使用
        Session::put('code',$code->getCheckCode());   //将验证码保存到服务器中
        //$_SESSION["code"]=$code->getCheckCode();  

    }


	//接受数据进行判断登录
	public function login(Request $request)
	{
		//接受数据
		 $arr=$request->all();
		 //账号,去除账号两边的空白符
		 $accounts = trim($arr['accounts']);
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
				            	$power[$key]['pid'] = $v->pid;
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

	/*
	*	退出
	*/

	public function exitProcess(Request $request)
	{
		$request->session()->flush();  //清除所有的session信息
		// $sessions = $request->session()->all();
		// print_r( $sessions);
		return redirect('loginIndex');
	}

	/*
	*	修改密码
	*/
	//修改页面
	public function pass(Request $request)
	{
		//取出当前用户的id
		$uid = Session::get('uid');
		//根据用户id查询出当前的账号；
		$data = DB::table('res_user')->where('uid',$uid )->first();
		// print_r($data);die;
		return view('login.form-elements',array('data'=>$data));
	}

	//查询旧密码是否正确
	public function oldpwd(Request $request)
	{
		//接受旧密码
		$oldpwd = $request->input('oldpwd');
		//取出当前用户的id
		$uid = Session::get('uid');
		//根据用户id查询出当前的账号；
		$data = DB::table('res_user')->where('uid',$uid )->first();
		if ($oldpwd!=$data->password) 
		{
			//旧密码错误
			echo 0;
		}
		else
		{
			//旧密码正确
			echo 1;
		}
	}

	//修改
	public function update_pwd(Request $request)
	{
		 //取出当前用户的id
		$uid = Session::get('uid');
		//接受数据
		$arr=$request->all();
		// print_r($arr);die;
		 //获取旧密码
		 $oldpwd = $arr['oldpwd'];
		 if (empty($oldpwd)) 
		 {
		 	echo "<script>alert('旧密码不能为空')</script>";die;
		 }
		//根据用户id查询出当前的账号；
		$data = DB::table('res_user')->where('uid',$uid )->first();
		if ($oldpwd!=$data->password) 
		{
			//旧密码错误
			echo "<script>alert('旧密码不正确')</script>";die;
		}
		
		
		 //获取新密码
		 $newpwd = $arr['newpwd'];
		 $preg = "/^[0-9 | A-Z | a-z]{6,16}$/";
		 if (empty($newpwd) || !preg_match($preg, $newpwd)) 
		 {
		 	echo "<script>alert('新密码不能为空或格式不正确')</script>";die;
		 }
		
		 //获取再次输入的新密码
		 $newpass = $arr['newpass'];
		 //判断两次密码是否一致
		 if ($newpwd!=$newpass) 
		 {
		 	echo "<script>alert('两次密码不一致')</script>";die;
		 }
		//修改数据
		$res = DB::table('res_user')
	            ->where('uid', $uid)
	            ->update(['password' => $newpwd]);

	    if ($res) 
	    {
	    	echo "<script>alert('修改成功,请重新登录');location.href='loginIndex'</script>";
	    	// return redirect('loginIndex');
	    }
	    else
	    {
	    	echo "<script>alert('修改失败')</script>";die;
	    }		 
	}
}
