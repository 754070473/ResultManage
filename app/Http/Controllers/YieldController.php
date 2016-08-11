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
		$role=DB::table('res_role')->where('rid',$role_id)->first();
		// print_r($role->role_name);die;
		$uid=Session::get('uid');
		if($role->role_name=='院长'){
			// 查询学院下的系和班级
			$sql='SELECT * FROM	res_college 
			LEFT JOIN res_series ON res_college.cid = res_series.cid
			LEFT JOIN res_class ON res_series.ser_id = res_class.ser_id
			LEFT JOIN res_grade ON res_class.class_id = res_grade.class_id
			WHERE res_college.uid = '.$uid.' ORDER BY g_add_date';
			$arr=DB::select($sql);
			// 对象转数组
			$arr=array_map('get_object_vars', $arr);
			$name=$arr[0]['college_name'];
			// 计算班级和系的成材率
			$data=$this->getSeries($arr);
			// print_r($data);die;
			// 展示统计数据
			return view('yield.show',['arr'=>$data,'name'=>$name]);

		}else if($role->role_name=='系主任'){
			// 查询系下的班级
			$sql='SELECT * FROM	res_series 
			LEFT JOIN res_class ON res_series.ser_id = res_class.ser_id
			LEFT JOIN res_grade ON res_class.class_id = res_grade.class_id
			WHERE res_series.uid = '.$uid.' ORDER BY g_add_date';
			$arr=DB::select($sql);
			// 对象转数组
			$arr=array_map('get_object_vars', $arr);
			$name=$arr[0]['ser_name'];
			// 计算班级和系的成材率
			$data=$this->getClass($arr);
			// print_r($data);die;
			// 展示统计数据
			return view('yield.show',['arr'=>$data,'name'=>$name]);

		}else if($role->role_name=='讲师'){
			// 查询系下的班级
			$sql='SELECT cl_pk_id FROM	 res_class LEFT JOIN res_class_pk on res_class.class_id=res_class_pk.cl_id WHERE uid = '.$uid.' limit 1';
			$arr=DB::select($sql);
			$pk_id=$arr[0]->cl_pk_id;
			$sql='SELECT uid FROM	 res_class  WHERE class_id = '.$pk_id.' limit 1';
			$arr=DB::select($sql);
			$uid.=",".$arr[0]->uid;
			$sql='SELECT * FROM	 res_class 
			LEFT JOIN res_grade ON res_class.class_id = res_grade.class_id
			WHERE res_class.uid in ('.$uid.')  ORDER BY g_add_date';
			$arr=DB::select($sql);
			// 对象转数组
			$arr=array_map('get_object_vars', $arr);

			// print_r($arr);die;
			// 计算班级和系的成材率
			$data=$this->getPieclass($arr);
			// print_r($data);die;
			// 展示统计数据
			return view('yield.show',['arr'=>$data,'name'=>$arr[0]['class_name']]);
		}
	}
	/**
	 * 计算系，班级的成材率
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function getSeries($data)
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
				if(isset($arr[$series][$time]['num'])){
					(int)$arr[$series][$time]['num']+=1;
				}else{
					(int)$arr[$series][$time]['num']=1;
				}
				(int)$arr[$series][$time][$class]['num']=1;
			}
			// 计算及格人数
			if($value['theory']>=90&&$value['exam']>=90){
				if(isset($arr[$series][$time][$class]['pass'])){
					(int)$arr[$series][$time][$class]['pass']+=1;
					(int)$arr[$series][$time]['pass']+=1;
				}else{
					if(isset($arr[$series][$time]['pass'])){
						(int)$arr[$series][$time]['pass']+=1;
					}else{
						(int)$arr[$series][$time]['pass']=1;
					}
					(int)$arr[$series][$time][$class]['pass']=1;
				}
			}else{
				if(isset($arr[$series][$time][$class]['unpass'])){
					(int)$arr[$series][$time][$class]['unpass']+=1;
					(int)$arr[$series][$time]['unpass']+=1;
				}else{
					if(isset($arr[$series][$time]['unpass'])){
						(int)$arr[$series][$time]['unpass']+=1;
					}else{
						(int)$arr[$series][$time]['unpass']=1;
					}
					(int)$arr[$series][$time][$class]['unpass']=1;
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
							(float)$arr[$k][$kk][$kkk]['passrate']=0;
						}else{
							$arr[$k][$kk][$kkk]['passrate']=(float)sprintf("%.2f",$vvv['pass']/$vvv['num'])*100;	
						}
					}
				}
					if(is_array($arr[$k][$kk])){
						if($vv['num']==0){
							(float)$arr[$k][$kk]['passrate']=0;
						}else{
							$arr[$k][$kk]['passrate']=(float)sprintf("%.2f",$vv['pass']/$vv['num'])*100;	
						}
					}
			}
		}
		$data=array();
		$i=0;
			foreach ($arr as $k => $v) {
				$data['data'][$i]['name']=$k;
				foreach ($v as $kk => $vv) {
					$data['date'][]=$kk;
					(float)$data['data'][$i]['data'][]=$vv['passrate'];
				}
				$i++;
			}
			
		return $this->result($data);
	}
	public function result($data,$type=0)
	{
		$data['date']=array_merge(array_unique($data['date']));
		// 对数据进行格式化
		$data['data']=json_encode($data['data']);
		$data['date']="'".implode("','",$data['date'])."'";
		return $data;
	}
	/**
	 * 计算班级
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function getClass($data)
	{
		// print_r($data);die;
		$arr=array();
		foreach ($data as $key => $value) {
				$class=$value['class_name'];
				$time=$value['g_add_date'];
			//计算班级总人数
			if(isset($arr[$class][$time]['num'])){
				(int)$arr[$class][$time]['num']+=1;
			}else{
				(int)$arr[$class][$time]['num']=1;
			}
			// 计算及格人数
			if($value['theory']>=90&&$value['exam']>=90){
				if(isset($arr[$class][$time]['pass'])){
					(int)$arr[$class][$time]['pass']+=1;
				}else{
					(int)$arr[$class][$time]['pass']=1;
				}
			}else{
				if(isset($arr[$class][$time]['unpass'])){
					(int)$arr[$class][$time]['unpass']+=1;
				}else{
					(int)$arr[$class][$time]['unpass']=1;
				}
			}
			if($value['g_add_date']==""){
				unset($arr[$class][$time]);
			}
		}
		// 计算及格率
		foreach ($arr as $k => $v) {
			foreach ($v as $kk => $vv) {
					// 计算班级成材率
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
		$i=0;
		foreach ($arr as $k => $v) {
			$data['data'][$i]['name']=$k;
			foreach ($v as $kk => $vv) {
			$data['date'][]=$kk;
			(float)$data['data'][$i]['data'][]=$vv['passrate'];
			}
			$i++;
		}
		return $this->result($data);
	}
	public function Pie(Request $request)
	{
		$time = $request->time;
		//获取用户角色和用户id
		$role_id=Session::get('user_info');
		$role=DB::table('res_role')->where('rid',$role_id)->first();
		$uid=Session::get('uid');
		if($role->role_name=='院长'){
			// 查询学院下的系和班级
			$sql='SELECT * FROM	res_college 
			LEFT JOIN res_series ON res_college.cid = res_series.cid
			LEFT JOIN res_class ON res_series.ser_id = res_class.ser_id
			LEFT JOIN res_grade ON res_class.class_id = res_grade.class_id
			WHERE res_college.uid = '.$uid.' and  g_add_date='."'".$time."'";
			$arr=DB::select($sql);
			// 对象转数组
			$arr=array_map('get_object_vars', $arr);
			// $name=$arr[0]['college_name'];
			// 计算班级和系的成材率
			$data=$this->getPie($arr);
			// print_r($arr);die;
			$data['data']=json_encode($data['data']);
			$data['arr']=json_encode($data['arr']);
			// 展示统计数据
			return view('yield.showpie',['arr'=>$data,'title'=>$data['name'],'subtitle'=>$time."未成才率分析图"]);

		}else{
			echo "<script>window.history.go(-1)</script>";
		}
		// else if($role->role_name=='学院'){
		// 	// 查询系下的班级
		// 	$sql='SELECT * FROM	res_series 
		// 	LEFT JOIN res_class ON res_series.ser_id = res_class.ser_id
		// 	LEFT JOIN res_grade ON res_class.class_id = res_grade.class_id
		// 	WHERE res_series.uid = '.$uid.' ORDER BY g_add_date';
		// 	$arr=DB::select($sql);
		// 	// 对象转数组
		// 	$arr=array_map('get_object_vars', $arr);
		// 	$name=$arr[0]['ser_name'];
		// 	// 计算班级和系的成材率
		// 	$data=$this->getClass($arr);
		// 	// print_r($data);die;
		// 	// 展示统计数据
		// 	return view('yield.show',['arr'=>$data,'name'=>$name]);

		// }

		// return view('yield.showpie');
	}
	public function getPie($data)
	{
		foreach ($data as $key => $value) {
				$series=$value['ser_name'];
				$class=$value['class_name'];
				$college=$value['college_name'];
			//计算班级总人数
			if(isset($arr[$college][$series][$class]['num'])){
				(int)$arr[$college]['num']+=1;
				(int)$arr[$college][$series]['num']+=1;
				(int)$arr[$college][$series][$class]['num']+=1;
			}else{
				if(isset($arr[$college]['num'])){
					(int)$arr[$college]['num']+=1;
				}else{
					(int)$arr[$college]['num']=1;
				}
				if(isset($arr[$college][$series]['num'])){
					(int)$arr[$college][$series]['num']+=1;
				}else{
					(int)$arr[$college][$series]['num']=1;
				}
				(int)$arr[$college][$series][$class]['num']=1;
			}
			// 计算及格人数
			if($value['theory']>=90&&$value['exam']>=90){
				if(isset($arr[$college][$series][$class]['pass'])){
					(int)$arr[$college]['pass']+=1;
					(int)$arr[$college][$series]['pass']+=1;
					(int)$arr[$college][$series][$class]['pass']+=1;
				}else{
					if(isset($arr[$college]['pass'])){
						(int)$arr[$college]['pass']+=1;
					}else{
						(int)$arr[$college]['pass']=1;
					}
					if(isset($arr[$college][$series]['pass'])){
						(int)$arr[$college][$series]['pass']+=1;
					}else{
						(int)$arr[$college][$series]['pass']=1;
					}
					(int)$arr[$college][$series][$class]['pass']=1;
				}
			}else{
				if(isset($arr[$college][$series][$class]['unpass'])){
					(int)$arr[$college]['unpass']+=1;
					(int)$arr[$college][$series]['unpass']+=1;
					(int)$arr[$college][$series][$class]['unpass']+=1;
				}else{
					if(isset($arr[$college]['unpass'])){
						(int)$arr[$college]['unpass']+=1;
					}else{
						(int)$arr[$college]['unpass']=1;
					}
					if(isset($arr[$college][$series]['unpass'])){
						(int)$arr[$college][$series]['unpass']+=1;
					}else{
						(int)$arr[$college][$series]['unpass']=1;
					}
					(int)$arr[$college][$series][$class]['unpass']=1;
				}
			}
			foreach ($arr as $key => $value) {
				foreach ($value as $kk => $vv) {
					if (is_array($vv)) {
						foreach ($vv as $k => $v) {
							if (isset($v['unpass'])) {
							$arr[$key][$kk][$k]['unpassrate']=(float)sprintf("%.2f",$v['unpass']/$value['unpass'])*100;
							}
						}
					}
					if(isset($vv['unpass'])){
						$arr[$key][$kk]['unpassrate']=(float)sprintf("%.2f",$vv['unpass']/$value['unpass'])*100;
					}
				}
			}
		}
		$data=array();
		$i=0;
		foreach ($arr as $k => $v) {
			$data['name']=$k;
			if(is_array($v)){
				foreach ($v as $kk => $vv) {
					if(is_array($vv)){
					$data['data'][$i]['name']=$kk;
					$data['data'][$i]['y']=isset($vv['unpassrate'])?$vv['unpassrate']:0;
					$data['data'][$i]['drilldown']=$kk;
					$data['arr'][]['name']=$kk;
					$data['arr'][$i]['id']=$kk;
						foreach ($vv as $key => $value) {
							if(is_array($value)){
								$data['arr'][$i]['data'][]=[$key,isset($value['unpassrate'])?$value['unpassrate']:0];
							}
						}
			$i++;
					}
				}			
			}
		}
			return $data;
	}
	public function getPieclass($data)
	{	
		foreach ($data as $key => $value) {
			$time=$value['g_add_date'];
			$class=$value['class_name'];
			//计算班级总人数
			if(isset($arr[$class][$time]['num'])){
				(int)$arr[$class][$time]['num']+=1;
			}else{
				(int)$arr[$class][$time]['num']=1;
			}
			// 计算及格人数
			if($value['theory']>=90&&$value['exam']>=90){
				if(isset($arr[$class][$time]['pass'])){
					(int)$arr[$class][$time]['pass']+=1;
				}else{
					(int)$arr[$class][$time]['pass']=1;
				}
			}else{
				if(isset($arr[$class][$time]['unpass'])){
					(int)$arr[$class][$time]['unpass']+=1;
				}else{
					(int)$arr[$class][$time]['unpass']=1;
				}
			}
		}
		foreach ($arr as $k => $v) {
			foreach ($v as $kk => $vv) {
					// 计算班级成材率
					if(is_array($arr[$k][$kk])){
						if($vv['num']==0){
							(float)$arr[$k][$kk]['passrate']=0;
						}else{
							$arr[$k][$kk]['passrate']=(float)sprintf("%.2f",$vv['pass']/$vv['num'])*100;	
						}
					}
				}
			}
		$data=array();
		$i=0;
			foreach ($arr as $k => $v) {
				$data['data'][$i]['name']=$k;
				foreach ($v as $kk => $vv) {
					$data['date'][]=$kk;
					(float)$data['data'][$i]['data'][]=$vv['passrate'];
				}
				$i++;
			}
	
		return $this->result($data);
		}
	}