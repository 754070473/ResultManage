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
        return view('public.left');
    }
}
