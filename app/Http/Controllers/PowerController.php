<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
header("Content-type: text/html; charset=utf-8"); 
class PowerController extends Controller
{
	public $rule = [
            'power_name' => [
            	'name' => '权限名称',
                'type' => 'ZN',
                'msg' => '权限名称只能为2-10位汉字',
            ],
            'controller' => [
            	'name' => '控制器',
                'type' => 'EN',
                'msg' => '控制器只能由4-32位字母组成',
            ],
            'action' => [
            	'name' => '方法名',
                'type' => 'EN',
                'msg' => '方法名只能由4-32位字母组成',
            ]
        ];
	/**
	 * 添加
	 */
	public function powerAdd(Request $request)
	{
		if($request->isMethod('post'))//添加方法
		{
			$input = $request->all();
			unset($input['_token']);
			$this->checkpower($input);
			$re=DB::table('res_power')->insert( [
			    'power_name' => $input['power_name'], 
			    'controller' => $input['controller'],
			    'action' => $input['action'],
			    'status' => isset($input['is_show'])?1:0,
			    'fid' => $input['fid'],
			    ]);
			if($re)
			{
				return redirect('showpower');
			}else{
				$this->error('添加失败');
			}
		}else if($request->isMethod('get')){//添加页面
			 $access=$this->classify('res_power','fid');
			return view('power.add',['access'=>$access]);
		}

	}
	/**
	 * 权限展示
	 */
	public function showPower(Request $request)
	{
		 $access=$this->classify('res_power','fid');

		return view('power.show',['access'=>$access]);
	}
	/**
	 * /获取控制器
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function getcont(Request $request)
	{
		$id = $request->id;
		$controller = DB::table('res_power')->where('pid',$id)->value('controller');
		echo $controller;
	}
	/**
	 * /数据检查
	 * @param  [type] $data [要检查的数据]
	 * @return [type]       [description]
	 */
	public function checkpower($data)
	{

        $re=$this->checkParam($data,$this->rule);
        if($re){
        	$this->error($re['msg']);
        }else{
        	$result=$this->checkOne('res_power',"power_name='".$data['power_name']."'");
			if($result=='1'){
				$this->error('权限名称已存在');
			}
			$result=$this->checkOne('res_power',"controller='".$data['controller']."' and action='".$data['action']."'");
			if($result=='1'){
				$this->error('此方法已存在');
			}
        }
	}
	/**
	 * 修改权限
	 */
	public function upPower(Request $request)
	{		
		// 接收数据
		$ziduan=$request['ziduan'];
		$value=$request['value'];
		$id=$request['id'];
		
        $data[$ziduan]=$value;
        $ruler[$ziduan]=$this->rule[$ziduan];
        $re=$this->checkParam($data,$ruler);
        if($ziduan=='action'){
        	$result=$this->checkOne('res_power',"action='".$value."'");
        	// var_dump($result);die;
			if($result=='1'){
				echo '方法名已存在';die;
			}

        }
        if($ziduan=='power_name'){
        	$result=$this->checkOne('res_power',"power_name='".$value."'");
			if($result=='1'){
				echo '权限名称已存在';die;
			}
        }
        if(!$re){
        	// 修改权限
			$re=DB::update("UPDATE `res_power` SET $ziduan='$value' WHERE pid=? ", [$id]);
			if($re){
				echo '1';die;
			}else{
				echo "0";die;
			}
        }else{
        	echo $re['msg'];die;
        }
	}
	public function savePower(Request $request)
	{
		// 接收数据
		$id=$request['pid'];
		$status=$request['status'];
		// 修改状态
		$res=DB::table('res_power')->where('pid',$id)->update(['status' => $status]);
		if($res){
			echo "1";
		}else{
			echo "0";
		}
	}
	/**
	 * 删除权限
	 */
	public function dePower(Request $request)
	{
		// 接收数据
		$id=$request['pid'];
		$pid=explode(',',$id);
		// 判断此权限下是否有子权限
		$res=DB::table('res_power')->wherein('fid',$pid)->lists('pid');
		// print_r($res);die;
		if($res){
			echo '此权限下有子权限,不能删除';
		}else{
			// 删除权限
			$re=DB::delete('delete from res_power where pid in (?)',[$id]);
			if($re){
				echo $re;
			}else{
				echo "0";
			}

		}
	}

	/**
	 * 验证唯一性
	 * @param  string $table [表名]
	 * @param  string $where [条件]
	 * @param  string $value [字段]
	 * @return [type]        1,不存在返回0
	 */
	public function checkOne($table,$where=1,$value='pid',$type='0')
	{

		$re=DB::select("select $value from $table where $where limit 1");
		// return $re;
		if($re){
			// 成功返回
			return '1';
		}else{
			//失败返回
			return '0';
		}		
	}
	/**
	 * ajax唯一性验证
	 */
	public function ajaxOne(Request $request)
	{
		$value=$request['value'];
		$name=$request['name'];
		$result=$this->checkOne('res_power',$name."='".$value."'");
		// print_r($result);
		if($result){
			echo '1';
		}else{
			echo '0';
		}
	}
	/**
	 * 错误提示
	 * @param  [type] $msg [错误信息]
	 * @return [type]      [description]
	 */
	public function error($msg)
	{
		echo "<script>alert('".$msg."');location.href='poweradd';</script>";die;
	}
	public function checkParam($data,$rule)
	{
		$error=array();
		//遍历判断是否传递必须参数
        foreach ($rule as $key => $value) {
                if ($data[$key]=='') {
                    $error = array('mark' => 1 , 'msg' => $value['name']."不能为空");
                    break;
                }else{
                	$ze=$this->checkZe($data[$key],$value['type']);
                    if($ze==0){
                    	$error = array('mark' => 2 , 'msg' => $value['msg']);
                    	break;
                    }
                }
        }
        return $error;
	}
	public function checkZe($str,$t)
	{
		switch (strtoupper($t)){
            case 'EN' : $result=preg_match('/^[a-z]{4,32}$/i',$str)?1:0;break;
            case 'ZN' : $result=preg_match('/^[\x{4e00}-\x{9fa5}]{2,10}$/u',$str)?1:0;break;
        }
        return $result;
	}
}