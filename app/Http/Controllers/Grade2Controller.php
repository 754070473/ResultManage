<?php
//namespace App\Http\Controllers;
//use DB;
//use Session;
//use Illuminate\Http\Request;
//use Code;
//use Illuminate\Http\RedirectResponse;
//use mail;
//
//
//header("content-type:text/html;charset=utf-8");
//
///**
// * 本方法用于成绩列表
// * @auth  刘清白
// * @date 2016-8-8 9:21
// * Class GradeController
// * @package App\Http\Controllers
// */
//class Grade2Controller extends Controller
//{
//
//    /**
//     * 角色判断
//     */
//    public function gdList(){
//        $uid =  Session::get('uid');
//        $users = DB::table( 'res_user' )
//                   ->select('role_name')
//                    ->join( 'res_role' , 'res_role.rid' , '=' , 'res_user.rid' )
//                    ->where( 'uid' , $uid )
//                    ->get();
////        if( '教务' == $users[0]->role_name )
////            echo  $this->yuansheng();
////        if( '系主任' == $users[0]->role_name )
////            echo $this->xiDirectorList();
////        if( '讲师' == $users[0]->role_name ){
//           $class= DB::table( 'res_series','class_name')
//                ->select('class_id')
//                ->where( 'uid' , $uid )
//                ->get();
//           return view('grade.cljiangshi',['class'=>$class[0]]);
////        }
//
//    }
//        /**
//         * 教务
//         */
//        /*
//         * 程序可拆分使用，组合使用浪费资源
//        public function jwList(){
//        //查询所有学院
//        $college =  DB::table('res_college')->get();
//        //查询学院的所有系
//        foreach($college as $k=>$v)
//        {
//            //主表  系res_series
//            //联查表 学院表res_college  根据学院cid
//            $arr =  DB::table('res_series')
//                ->join('res_college', 'res_series.cid', '=', 'res_college.cid')
//                ->where("res_series.cid","=",$v->cid)
//                ->get();
////            print_r($arr);die;
//            //查询系中的所有班级
//            //主表  班级表 res_class
//            //联查表 系 res_series   根据系ser_id
//            foreach($arr as $kxi=>$vxi)
//            {
//                $arr[$kxi]->class  =  DB::table('res_class')
//                    ->select('class_id','class_name')
//                    ->join('res_series', 'res_class.ser_id', '=', 'res_series.ser_id')
//                    ->where("res_series.ser_id","=",$vxi->ser_id)
//                    ->get();
//                //查询班级的所有成绩
//                //主表  学生表
//                //联查表 班级表 res_class   成绩表 res_grade  根据班级 class_id
//                foreach($arr[$kxi]->class as $kgrade=>$vgrade)
//                {
//                    $Aa  = date('Y-m-d',time()-24*60*60);//小于今天
//                    $Ba = date('Y-m-d',time()-24*60*60*10);//大于前天
//                    $arr[$kxi]->class[$kgrade]->grade =  DB::table('res_students')
//                        ->select('*')
//                        ->join('res_class', 'res_class.class_id', '=', 'res_students.class_id')
//                        ->join('res_grade', 'res_grade.sid', '=', 'res_students.sid')
//                        ->where("res_students.class_id","=",$vgrade->class_id)
//                        ->where('g_add_date','<',"$Aa")
//                        ->where('g_add_date','>',"$Ba")
//                        ->get();
//                    if(!empty($arr[$kxi]->class[$kgrade]->grade)){
//                        $manNum=count($arr[$kxi]->class[$kgrade]->grade);//计算班级总人数
//                        $theory=0;
//                        $exam=0;
//                        foreach($arr[$kxi]->class[$kgrade]->grade as $vtheory=>$ktheory){
//                            if(intval($ktheory->theory) >= 90){
//                                $theory++;
//                            }
//                        }
//                        foreach($arr[$kxi]->class[$kgrade]->grade as $vexam=>$kexam){
//                            if(intval($kexam->exam) >= 90){
//                                $exam++;
//                            }
//                        }
////                        unset()
//                        $f= 2;//小数后几位
//                        $newtheory = sprintf("%.".$f."f",substr(sprintf("%.6f", (($theory/$manNum)*100)), 0, -2));//理论成绩成才
//                        $newexam=sprintf("%.".$f."f",substr(sprintf("%.6f", (($exam/$manNum)*100)), 0, -2));//机试成绩成才
//                    }else{
//                        $newtheory = 0;
//                        $newexam= 0;
//                    }
//                    $arr[$kxi]->class[$kgrade]->theory=$newtheory;
//                    $arr[$kxi]->class[$kgrade]->exam =$newexam;
//
//                }
//                unset($newtheory);
//                unset($newexam);
//                if(!empty($arr[$kxi]->class)){
//                    $manNum=count($arr[$kxi]->class);//计算班级总人数
//                    $theory2=0;
//                    $exam2=0;
//                    foreach($arr[$kxi]->class as $vtheory=>$ktheory){
//                        $theory2+=(float)$ktheory->theory;
//                    }
//                    foreach($arr[$kxi]->class as $vexam=>$kexam){
//                        $exam2+=(float)$kexam->exam;
//                    }
//                    $f= 2;//小数后几位
//                    $newtheory2 = sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory2/$manNum)), 0, -2));//理论成绩成才
//                    $newexam2=sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam2/$manNum)), 0, -2));//机试成绩成才
//                }else{
//                    $newtheory2 = 0;
//                    $newexam2= 0;
//                }
//                $arr[$kxi]->theory=$newtheory2;
//                $arr[$kxi]->exam =$newexam2;
//                unset($arr[$kxi]->class);//删除班级，释放内存
//            }
//            if(!empty($arr)){
//                $manNum=count($arr);//计算班级总人数
//                $theory3=0;
//                $exam3=0;
//                foreach($arr as $vtheory=>$ktheory){
//                    $theory3+=(float)$ktheory->theory;
//                }
//                foreach($arr as $vexam=>$kexam){
//                    $exam3+=(float)$kexam->exam;
//                }
//                $f= 2;//小数后几位
//                $newtheory3 = sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory3/$manNum)), 0, -2));//理论成绩成才
//                $newexam3=sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam3/$manNum)), 0, -2));//机试成绩成才
//            }else{
//                $newtheory3 = 0;
//                $newexam3= 0;
//            }
//            $college[$k]->theory=$newtheory3;
//            $college[$k]->exam =$newexam3;
//            unset($newtheory3);
//            unset($newexam3);
//            if(!empty($arr)){
//                $college[$k]->xi = $arr;
//                unset($arr);
//            }else{
//                $college[$k]->xi = [];;
//            }
//        }
//
////        print_r($college);die;
//        return view('grade.cljiaowu',['college'=>$college]);
//    }
//    */
//
//    public function sum_stu($arr){
//
//    }
//    /**
//     * 查询所有学院
//     * @return mixed
//     */
//    public function ajaxCollege()
//    {
//        return  DB::table('res_college')->get();
//    }
//
//    /**
//     * 根据学院id查询所有系
//     */
//    public function ajaxJwList($id="")
//    {
//        $college=$this->ajaxCollege();
//        foreach($college as $k=>$v) {
//            //主表  系res_series
//            //联查表 学院表res_college  根据学院cid
//            $arr = DB::table('res_series')
//                ->join('res_college', 'res_series.cid', '=', 'res_college.cid')
//                ->where("res_series.cid", "=", $v->cid)
//                ->get();
//        }
//
//    }
//
//    function yuansheng()
//    {
//        $sql = 'select * from res_grade
//                INNER JOIN res_students on res_grade.sid=res_students.sid
//                INNER JOIN res_class on res_students.class_id=res_class.class_id
//                INNER JOIN res_series on res_series.ser_id=res_class.ser_id
//                INNER JOIN res_college on res_series.cid=res_college.cid
//                where  res_college.cid in(SELECT res_college.cid FROM res_college)
//                ';
//        $arr = DB::select($sql);
//        $arr =json_decode(json_encode($arr),true);
//        $college = [];//学院
//        $series = [];//系
//        $class = [];//班级
//        $grade = [];//成绩
//        $college_id =[];
//        $series_id = [];
//        $class_id = [];
//        foreach($arr as $k=>$v)
//        {
//            //学院cid
//            $college[$k]['cid'] =$v['cid'];
//            //学院id  用于过滤
//            $college_id[] = $v['cid'];
//            //学院名字
//            $college[$k]['college_name'] =$v['college_name'];
//
//            //系ser_id
//            $series_id[$k]=$v['ser_id'];
//            $series[$k]['ser_id']=$v['ser_id'];
//            //系名字
//            $series[$k]['ser_name']=$v['ser_name'];
//            //系 学院id
//            $series[$k]['cid']=$v['cid'];
//
//            //班级id
//            $class_id[$k]=$v['class_id'];
//            $class[$k]['class_id']=$v['class_id'];
//            //班级   系id
//            $class[$k]['ser_id']=$v['ser_id'];
//            //班级名字
//            $class[$k]['class_name']=$v['class_name'];
//            //成绩
//            $grade[$k]['theory']=$v['theory'];
//            $grade[$k]['exam']=$v['exam'];
////            $grade[$k]['g_add_date']=$v['g_add_date'];
//            $grade[$k]['sid']=$v['sid'];
//            $grade[$k]['class_id']=$v['class_id'];
//        }
//        $college_id_uq =  array_unique($college_id);//学院唯一
//        $series_id_uq =  array_unique($series_id);//系唯一
//        $class_id_uq =  array_unique($class_id);//班级唯一
//        $college_all = [];
//        foreach($college_id_uq as $k=>$v)
//        {
//            $college_all[]=$college[$k];
//        }
//        unset($college_id_uq);
//
//        $series_all = [];
//        foreach ( $series_id_uq as $k => $v)
//        {
//            $series_all[]=$series[$k];
//        }
//        unset($series_id_uq);
//        $class_all = [];
//        foreach ( $class_id_uq as $k => $v)
//        {
//            $class_all[]=$class[$k];
//        }
//        unset($class_id_uq);
//        //$college_all 学院
//        //$series_all 系
//        //$class_all 班级
//
//        $cl = [];//所有班级加入cl
//        foreach ($class_all as $kclass =>$vclass)
//        {
//            foreach ($grade as $kgrade =>$vgrade)
//            {
//                if($vclass['class_id']==$vgrade['class_id'])
//                {
//                    $cl[$kclass]['class_name'] =$vclass['class_name'];;
//                    $cl[$kclass]['class_id']   =$vclass['class_id'];
//                    $cl[$kclass]['ser_id']     =$vclass['ser_id'];
//                    $cl[$kclass]['grade'][]    =  $vgrade;
//                }
//           }
//            if(!empty( $cl[$kclass]['grade'] ) )
//            {
//                $manNum=count( $cl[$kclass]['grade'] );//计算班级总人数
//                $theory3  = 0;
//                $exam3    = 0;
//                foreach( $cl[$kclass]['grade'] as $vtheory => $ktheory ){
//                    $theory3+=(float)$ktheory['theory'];
//                }
//                foreach($cl[$kclass]['grade'] as $vexam => $kexam){
//                       $exam3 += (float)$kexam['exam'];
//                }
//                $f= 2;//小数后几位
//                $newtheory3 = sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory3/$manNum)), 0, -2));//理论成绩成才
//                $newexam3=sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam3/$manNum)), 0, -2));//机试成绩成才
//            }
//            else
//            {
//                $newtheory3 = 0;
//                $newexam3= 0;
//            }
//            $cl[$kclass]['theory']=$newtheory3;
//            $cl[$kclass]['exam'] =$newexam3;
//            unset($cl[$kclass]['grade']);
//        }
//
//        foreach ($series_all as $kseries =>$vseries)
//        {
//            foreach ($cl as $kcl =>$vcl)
//            {
//                if($vseries['ser_id']==$vcl['ser_id'])
//                {
//                    $series_all[$kseries]['class'][]=$vcl;
//                }
//            }
//            if(!empty( $series_all[$kseries]['class'] ))
//            {
//                $manNum=count( $series_all[$kseries]['class']);//计算班级总人数
//                $theory3=0;
//                $exam3=0;
//                foreach($series_all[$kseries]['class'] as $vtheory=>$ktheory)
//                {
//                    $theory3+=(float)$ktheory['theory'];
//                }
//                foreach($series_all[$kseries]['class'] as $vexam=>$kexam)
//                {
//                    $exam3+=(float)$kexam['exam'];
//                }
//                $f= 2;//小数后几位
//                $newtheory3 = sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory3/$manNum)), 0, -2));//理论成绩成才
//                $newexam3=sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam3/$manNum)), 0, -2));//机试成绩成才
//            }
//            else
//            {
//                $newtheory3 = 0;
//                $newexam3= 0;
//            }
//            $series_all[$kseries]['theory']=$newtheory3;
//            $series_all[$kseries]['exam'] =$newexam3;
//        }
//        //从学院到系
//        $average=[];
//        foreach($college_all as $kcollege=>$vcollege)
//        {
//            $average[$kcollege]=$vcollege;
//            foreach($series_all as $kseries=>$vseries)
//            {
//                if($vseries['cid']==$vcollege['cid'])
//                {
//                    $average[$kcollege]['xi'][] = $vseries;
//                }
//            }
//            if(!empty( $average[$kcollege]['xi'] ))
//            {
//                $manNum=count( $average[$kcollege]['xi']);//计算班级总人数
//                $theory3=0;
//                $exam3=0;
//                foreach($average[$kcollege]['xi'] as $vtheory=>$ktheory)
//                {
//                    $theory3+=(float)$ktheory['theory'];
//                }
//                foreach($average[$kcollege]['xi'] as $vexam=>$kexam)
//                {
//                    $exam3+=(float)$kexam['exam'];
//                }
//                $f= 2;//小数后几位
//                $newtheory3 = sprintf("%.".$f."f",substr(sprintf("%.10f", ($theory3/$manNum)), 0, -2));//理论成绩成才
//                $newexam3=sprintf("%.".$f."f",substr(sprintf("%.10f", ($exam3/$manNum)), 0, -2));//机试成绩成才
//            }
//            else
//            {
//                $newtheory3 = 0;
//                $newexam3= 0;
//            }
//            $average[$kcollege]['theory']=$newtheory3;
//            $average[$kcollege]['exam'] =$newexam3;
//        }
//        return view('grade.cljiaowu',['college'=>$average]);
//    }
//
//    /**
//     * ajax点击加载学生成绩
//     */
//    function ajaxStudent(Request $request)
//    {
//        $id = intval($request['class_id']);
//        if(!empty($id)){
//
//            //查询时间表
//            $Aa  = date('Y-m-d',time()-24*60*60);//小于今天
//            $date = DB::table('res_period')
//                ->join('res_exam','res_period.per_id','=','res_exam.per_id')
//                ->where('start_date','<',"$Aa")
//                ->where('end_date','>',"$Aa")
//                ->get();
//            $dat=[];
//            $week = array('日','一','二','三','四','五','六');
//            foreach($date as $k=>$v){
//                $time = strtotime( $v -> exam_date );
//                 $arr =   DB::table('res_students')
//                    ->select('student_name','theory','exam','g_add_date')
//                    ->join('res_class', 'res_class.class_id', '=', 'res_students.class_id')
//                    ->join('res_grade', 'res_grade.sid', '=', 'res_students.sid')
//                    ->where("res_students.class_id","=",$id)
//                    ->where('g_add_date','=',$v->exam_date)
//                    ->orderBy('res_grade.sid','asc')
//                    ->get();
//                $arr['week'] = '星期'.$week[date('w',$time)];
//                $arr['date'] = $v -> exam_date;
//                if(!empty($arr)){
//                    $dat['arr'][] =$arr;
//                }else{
//                    $dat['arr'][] =[];
//                }
//
//            }
//            $dat['stu'] =  DB::table('res_students')->select('sid','student_name')->where('class_id','=',$id)->orderBy('sid','asc')->get();
//            $cc= json_decode(json_encode($dat),true);
//            return view('grade.studentgd',['student'=>$cc]);
//        }else{
//            echo 0;
//        }
//    }
//}
