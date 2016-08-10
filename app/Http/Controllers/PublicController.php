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
            $access = $this->classify('res_power','fid');
        }else{
            $access = Session::get('power');
        }
//        print_r($access);die;
        $power = require_once ('Auth/PowerConfig.php');
        $access_msg = $power['navigation'];
        $navigation=array();
        foreach ($access as $key => $value) {
            if( array_key_exists($value['power_name'] , $access_msg) ){
                $navigation[$key]['power_name'] = $value['power_name'];
                $navigation[$key]['url'] = $access_msg[$value['power_name']][0];
                foreach( $value['son'] as $k => $v ){
                    if( array_key_exists($v['power_name'] , $access_msg) ){
                        $navigation[$key]['son'][$k]['power_name'] = $v['power_name'];
                        $navigation[$key]['son'][$k]['url'] = $access_msg[$v['power_name']][0];
                    }
                }
            }
        }
       // print_r($navigation);die;
        return view('public.left',['navigation'=>$navigation]);
    }
}
