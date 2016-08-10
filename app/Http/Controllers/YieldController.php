<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
header("Content-type: text/html; charset=utf-8"); 
class YieldController extends Controller
{
	/**
	 * 根据用户登录的角色展示对应学院，系，班级成材率
	 */
	public function Index()
	{
		//获取用户角色和用户id
		$role_id=Session::get('user_info');
		$uid=Session::get('uid');
		if($role_id==3){
			// 查询学院下的系和班级
			$sql='SELECT * FROM	res_college 
			LEFT JOIN res_series ON res_college.cid = res_series.cid
			LEFT JOIN res_class ON res_series.ser_id = res_class.ser_id
			LEFT JOIN res_grade ON res_class.class_id = res_grade.class_id
			WHERE res_college.uid = '.$uid.' ORDER BY g_add_date';
			$arr=DB::select($sql);
			// 对象转数组
			$arr=array_map('get_object_vars', $arr);
			// 计算班级和系的成材率
			$data=$this->checkYi($arr);
			// var_dump($data);die;
			// 展示统计数据
			return view('yield.show',['arr'=>$data]);

		}else if($role_id==4){
			// 查询系下的班级
			$sql='SELECT * FROM	res_series 
			LEFT JOIN res_class ON res_series.ser_id = res_class.ser_id
			LEFT JOIN res_grade ON res_class.class_id = res_grade.class_id
			WHERE res_series.uid = '.$uid.' ORDER BY g_add_date';
			$arr=DB::select($sql);
			// 对象转数组
			$arr=array_map('get_object_vars', $arr);
			// print_r($arr);die;
			// 计算班级和系的成材率
			$data=$this->checkYi($arr);
			// 展示统计数据
			return view('yield.show',['arr'=>$data]);

		}
	}
	/**
	 * 计算系，班级的成材率
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function checkYi($data)
	{
		// print_r($data);die;
		$arr=array();
		foreach ($data as $key => $value) {
				$series=$value['ser_name'];
				$class=$value['class_name'];
				$time=$value['g_add_date'];
			//计算班级总人数
			if(isset($arr[$series][$time][$class]['num'])){
				(int)$arr[$series][$time][$class]['num']+=1;
				(int)$arr[$series][$time]['num']+=1;
			}else{
				(int)$arr[$series][$time][$class]['num']=1;
				(int)$arr[$series][$time]['num']=1;
			}
			// 计算及格人数
			if($value['theory']>=90&&$value['exam']>=90){
				if(isset($arr[$series][$time][$class]['pass'])){
					(int)$arr[$series][$time][$class]['pass']+=1;
					(int)$arr[$series][$time]['pass']+=1;
				}else{
					(int)$arr[$series][$time][$class]['pass']=1;
					(int)$arr[$series][$time]['pass']=1;
				}
			}else{
				if(isset($arr[$series][$time][$class]['unpass'])){
					(int)$arr[$series][$time][$class]['unpass']+=1;
					(int)$arr[$series][$time]['unpass']+=1;
				}else{
					(int)$arr[$series][$time][$class]['unpass']=1;
					(int)$arr[$series][$time]['unpass']=1;
				}
			}
			if($value['g_add_date']==""){
				unset($arr[$series][$time]);
			}
		}
		// 计算及格率
		foreach ($arr as $k => $v) {
			foreach ($v as $kk => $vv) {
				foreach ($vv as $kkk => $vvv) {
					// 计算班级成材率
					if(is_array($arr[$k][$kk][$kkk])){
						if($vvv['num']==0){
							(int)$arr[$k][$kk][$kkk]['passrate']=0;
						}else{
							(int)$arr[$k][$kk][$kkk]['passrate']=sprintf("%.2f",$vvv['pass']/$vvv['num']);	
						}
					}
				}
					if(is_array($arr[$k][$kk])){
						if($vv['num']==0){
							(int)$arr[$k][$kk]['passrate']=0;
						}else{
							$arr[$k][$kk]['passrate']=(float)sprintf("%.2f",$vv['pass']/$vv['num'])*100;	
						}
					}
			}
		}
		// 拼接数据
		$data=array();
		foreach ($arr as $k => $v) {
			$data['data']['name']=$k;
			foreach ($v as $kk => $vv) {
			$data['date'][]=$kk;
				(float)$data['data']['data'][]=$vv['passrate'];
			}
		}
		// 对数据进行格式化
		$data['data']=json_encode($data['data']);
		$data['date']="'".implode("','",$data['date'])."'";
		return $data;
	}

}