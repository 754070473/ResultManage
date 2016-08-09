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
        if( $per_num == '' || $start_date == '' || $end_date == '' ){
            echo "<script>alert('数据不能为空');window.history.go(-1)</script>";
        }
        $data = array( 
            'per_num' => $per_num , 
            'start_date' => $start_date , 
            'end_date' => $end_date ,
            'per_add_date' => $per_add_date
        );
        $re = $this -> databasesInsert( 'res_period' , $data );
        if( $re ){
            return redirect('periodList');
        }else{
            echo "<script>alert('新增失败，请稍后再试!');window.history.go(-1)</script>";
        }
    }

    /**
     * 考试安排详情页面
     * @param Request $request
     */
    public function periodExam(Request $request)
    {
        $per_id = $request -> per_id;
        $per_list = $this -> databasesSelect('res_period' , 'per_id='.$per_id , 1);
       /* $start_date = $per_list ->start_date;
        $end_date = $per_list ->end_date;
        $date = '2015-05-01';
        $end = '2015-05-31';
        $week = array('日','一','二','三','四','五','六');
        for($i=0;strtotime($date.'+'.$i.' days')<=strtotime($end)&&$i<365;$i++){
            $time = strtotime($date.'+'.$i.' days');
            echo date('Y-m-d',$time),'(',$week[date('w',$time)],")";
        }*/
    }
}
