<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
header("Content-type: text/html; charset=utf-8"); 
class YieldController extends Controller
{
    /*public function Index(){
        return view('yield.show');
    }*/
	/**
	 * 根据用户登录的角色展示对应学院，系，班级成材率
	 */
	public function Index(Request $request)
	{
		//获取用户角色和用户id
		$role_id=$request->rid?:Session::get('user_info');
		$role=DB::table('res_role')->where('rid',$role_id)->first();
		$uid=$request->uid?:Session::get('uid');
//        print_r($role_id);die;
		if($role->role_name=='院长'){
			// 查询学院下的系和班级
			$sql='SELECT * FROM	res_college
			LEFT JOIN res_series ON res_college.cid = res_series.cid
			LEFT JOIN res_class ON res_series.ser_id = res_class.ser_id
			LEFT JOIN res_grade ON res_class.class_id = res_grade.class_id
			WHERE res_college.uid = '.$uid.' ORDER BY g_add_date';
			$arr=DB::select($sql);
//            print_r($arr);die;
			// 对象转数组
			$arr=array_map('get_object_vars', $arr);
            // 计算班级和系的成材率
            $result=$this->getAll($arr);
            $name=isset($arr[0]['college_name'])?$arr[0]['college_name']:"";
            $data=isset($result['series'])?$result['series']:"";
//            var_dump($data);die;
        }else if($role->role_name=='系主任'){
			// 查询系下的班级
			$sql='SELECT * FROM	res_series
			LEFT JOIN res_class ON res_series.ser_id = res_class.ser_id
			LEFT JOIN res_grade ON res_class.class_id = res_grade.class_id
			WHERE res_series.uid = '.$uid.' ORDER BY g_add_date';
			$arr=DB::select($sql);
			// 对象转数组
			$arr=array_map('get_object_vars', $arr);
            // 计算班级和系的成材率
            $result=$this->getAll($arr);
            // print_r($result);die;
            $name=isset($arr[0]['ser_name'])?$arr[0]['ser_name']:"";
            $data=isset($result['class'])?$result['class']:"";
			// print_r($data);die;
		}else if($role->role_name=='讲师'){
			// 查询系下的班级
			$sql='SELECT cl_pk_id FROM	 res_class LEFT JOIN res_class_pk on res_class.class_id=res_class_pk.cl_id WHERE uid = '.$uid.' limit 1';
			$arr=DB::select($sql);
			// print_r($arr);die;
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
			$result=$this->getAll($arr);
//			print_r($result);die;
            $name=isset($arr[0]['class_name'])?$arr[0]['class_name']:"";
            $data=isset($result['class'])?$result['class']:"";
            // 展示统计数据
		}else if($role->role_name=='教务'||$uid==1){
			// 查询学院下的系和班级
			$sql='SELECT * FROM	res_college
			LEFT JOIN res_series ON res_college.cid = res_series.cid
			LEFT JOIN res_class ON res_series.ser_id = res_class.ser_id
			LEFT JOIN res_grade ON res_class.class_id = res_grade.class_id
			 ORDER BY g_add_date';
			$arr=DB::select($sql);
			// 对象转数组
			$arr=array_map('get_object_vars', $arr);
			$result=$this->getAll($arr);
//            print_r($result);die;
            $data=isset($result['college'])?$result['college']:"";
            $name="八维学院";
//			print_r($data);die;
        }
        if($data!=""){
            if(Session::get('user_info')==1){
//                print_r($data);die;
                $nav=$this->getNav();
                return view('yield.show',['arr'=>$data,'name'=>$name,'title'=>"成材率统计图",'nav'=>$nav]);
            }else{
                return view('yield.showpie',['arr'=>$data,'name'=>$name,'title'=>"成材率统计图"]);
            }
        }else{
            echo "<script>alert('此分类下没有数据');history.go(-1)</script>";
        }
    }
    /*
     * 计算成材率
     * */
	public function getAll($data)
	{
		$college_array=array();
		$series_array=array();
		$class_array=array();
		foreach ($data as $key => $value) {
			$class=$value['class_name'];
			$time=$value['g_add_date'];
			if($time!=""){
				//计算班级总人数
				if(isset($class_array[$class][$time]['num'])){
					(int)$class_array[$class][$time]['num']+=1;
				}else{
					(int)$class_array[$class][$time]['num']=1;
				}
				if(isset($value['ser_name'])){
					$series=$value['ser_name'];
					// 计算系总人数
					if(isset($series_array[$series][$time]['num'])){
						(int)$series_array[$series][$time]['num']+=1;
					}else{
						(int)$series_array[$series][$time]['num']=1;
					}
				}
				if(isset($value['college_name'])){
					$college=$value['college_name'];
					//计算学院总人数
					if(isset($college_array[$college][$time]['num'])){
						(int)$college_array[$college][$time]['num']+=1;
					}else{
						(int)$college_array[$college][$time]['num']=1;
					}
				}
				if($value['theory']>=90&&$value['exam']>=90){
					//计算班级成才人数
					if(isset($class_array[$class][$time]['pass'])){
						(int)$class_array[$class][$time]['pass']+=1;
					}else{
						(int)$class_array[$class][$time]['pass']=1;
					}
					if(isset($value['college_name'])){
						//计算学院成才人数
						if(isset($college_array[$college][$time]['pass'])){
							(int)$college_array[$college][$time]['pass']+=1;
						}else{
							(int)$college_array[$college][$time]['pass']=1;
						}
					}
					if(isset($value['ser_name'])){
						// 计算系成才人数
						if(isset($series_array[$series][$time]['pass'])){
							(int)$series_array[$series][$time]['pass']+=1;
						}else{
							(int)$series_array[$series][$time]['pass']=1;
						}
					}
				}

			}
		}
			$data=array();
			$data['class']=$this->getCount($class_array);
		if(isset($series)){
			$data['series']=$this->getCount($series_array);
		}
		if(isset($college)){
			$data['college']=$this->getCount($college_array);
		}
		return $data;
	}
    function getNav(){
        $college=DB::table('res_college')->get();
        foreach($college as $key=>$value){
            $college[$key]->level=3;
            $college[$key]->son=array_map('get_object_vars',DB::table('res_series')->where('cid',$value->cid)->get());
        }
        $college=array_map('get_object_vars',$college);
        foreach($college as $key=>$value){
            foreach($value['son'] as $k=>$val){
                $college[$key]['son'][$k]['level']=4;
            }
        }
        return $college;
    }
    /*
     * 计算成材率
     * */
	public function  getCount($arr)
	{
		$arr_pass=array();
		$i=0;
		// 计算成才率
		foreach ($arr as $key => $value) {
			$arr_pass['data'][$i]['name']=$key; 
			$j=0;
			foreach ($value as $k => $val) {
				$arr_pass['date'][]=$k;
				if(isset($val['pass'])){
					$arr_pass['data'][$i]['data'][$j]=(float)sprintf("%.2f",$val['pass']/$val['num'])*100;
				}
				$j++;
			}
			$i++;
		}
		return $this->result($arr_pass);
	}
    /*
     * 格式化数据
     * */
	public function result($data)
	{
		if(empty($data)){
			return;
		}
		$data['date']=array_merge(array_unique($data['date']));
		// 对数据进行格式化
		$data['data']=json_encode($data['data']);
		$data['date']="'".implode("','",$data['date'])."'";
//		$data['date']=json_encode($data['date']);
		return $data;
	}
}