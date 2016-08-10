<?php
namespace App\Http\Controllers;
use DB;
use Session;
use Illuminate\Http\Request;

header("content-type:text/html;charset=utf-8");
class PeriodController extends Controller
{
    /**      教学周期列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function periodList()
    {
        $table = 'res_period';
        $where = 1;
        $order = 'per_id desc';
        $page = array( 'num' => 10 , 'p' => 1 , 'url' => 'periodPage' );
        $arr = $this -> databasesSelect( $table , $where , 0 , $order , $page );
        return view( 'period.periodList' , array( 'arr' => $arr ) );
    }

    /**      教学周期分页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function periodPage(Request $request)
    {
        $table = 'res_period';
        $where = 1;
        $order = 'per_id desc';
        $p = $request -> p ? $request -> p : 1;
        $page = array( 'num' => 10 , 'p' => $p , 'url' => 'periodPage' );
        $arr = $this -> databasesSelect( $table , $where , 0 , $order , $page );
        return view( 'period.periodPage' , array( 'arr' => $arr ) );
    }

    /**
     * 新增教学周期页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function periodAdd()
    {
        return view( 'period.periodAdd');
    }
    
    /**
     * 新增教学周期入库
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function periodInfo(Request $request)
    {
        $per_num = $request -> per_num ? $request -> per_num : '';
        $start_date = $request -> start_date ? $request -> start_date : '';
        $end_date = $request -> end_date ? $request -> end_date : '';
        $per_add_date = date('Y-m-d',time());
        if( $per_num == '' || $start_date == '' || $end_date == '' )
        {
            echo "<script>alert('数据不能为空');window.history.go(-1)</script>";
            exit;
        }
        $last_end_time = DB::select('select end_date from res_period order by per_id desc limit 1');
        $last_end_time = $last_end_time[0] -> end_date;
        if( strtotime($per_add_date) <= strtotime( $last_end_time ) )
        {
            echo "<script>alert('您所添加的开始时间在其他教学周期内');window.history.go(-1)</script>";
            exit;
        }
        $per = DB::select('select per_id from res_period where per_num= '.$per_num.' limit 1');
        if( !empty($per) )
        {
            echo "<script>alert('教学周期".$per_num."已存在,请重新输入');window.history.go(-1)</script>";
            exit;
        }
        $data = array( 
            'per_num' => $per_num , 
            'start_date' => $start_date , 
            'end_date' => $end_date ,
            'per_add_date' => $per_add_date
        );
        $re = $this -> databasesInsert( 'res_period' , $data ,1);
        if( $re ){
            for($i=0;strtotime($start_date.'+'.$i.' days')<=strtotime($end_date);$i++){
                $time = strtotime($start_date.'+'.$i.' days');
                $date[$i]['exam_date'] = date('Y-m-d',$time);
                $date[$i]['per_id'] = $re;
            }
            $this -> databasesInsert('res_exam',$date);
            return redirect('periodList');
        }else{
            echo "<script>alert('新增失败，请稍后再试!');window.history.go(-1)</script>";
            exit;
        }
    }

    /**
     * 考试安排详情页面
     * @param Request $request
     */
    public function periodExam(Request $request)
    {
        $per_id = $request -> per_id;
        $per_list = $this -> databasesSelect('res_period' , 'per_id='.$per_id , 1 );
        $exam_list = $this -> databasesSelect('res_exam' , 'per_id='.$per_id );
        $week = array('日','一','二','三','四','五','六');
        foreach( $exam_list as $key => $val)
        {
            $time = strtotime( $val -> exam_date );
            $exam_list[$key]->week = '星期'.$week[date('w',$time)];
        }
        $this_time = date('Y-m-d' , time());
        $sign = 0;
        if( strtotime( $per_list -> start_date ) <= strtotime( $this_time ) )
        {
            $sign = 1;
        }
        return view( 'period.periodExam' , array( 'per_list' => $per_list , 'exam_list' => $exam_list ,'sign' => $sign ) );
    }

    /**
     * 考试安排入库
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function periodExamInfo(Request $request)
    {
        $exam_id = $request -> all();
        $data = array();
        $data['exam_id'] = array_keys($exam_id);
        $data['exam_type'] = array_values($exam_id);
        $exam = $this -> databasesSelect('res_exam','exam_id='.$data['exam_id'][0],1);
        $per_id = $exam -> per_id;
        $exam_list = $this -> databasesSelect('res_exam','per_id='.$per_id);
        $k = array();

        foreach($exam_list as $key => $val)
        {
            if($data['exam_type'][$key] == $val -> exam_type)
            {
                $k[] = $key;
            }
        }

        foreach($k as $v)
        {
            unset($data['exam_id'][$v]);
            unset($data['exam_type'][$v]);
        }

        $arr = array();
        foreach($data['exam_id'] as $key => $val)
        {
            $arr['exam_id'][] = $val;
            $arr['exam_type'][] = $data['exam_type'][$key];
        }

        for( $i = 0 ; $i<count($arr['exam_id']) ; $i++ )
        {
            DB::table('res_exam')
                ->where('exam_id', $arr['exam_id'][$i])
                ->update(['exam_type' => $arr['exam_type'][$i]]);
        }

        return redirect('periodList');
    }
}
