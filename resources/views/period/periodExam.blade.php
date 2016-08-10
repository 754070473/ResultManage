<div class="page-header">
    <h1>
        教学周期管理
        <small>
            <i class="icon-double-angle-right"></i>
            考试安排详情
        </small>
    </h1>
</div><!-- /.page-header -->
        <!-- PAGE CONTENT BEGINS -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        @if( $sign == 0 )
        <form class="form-horizontal" role="form" action="{{url('periodExamInfo')}}" method="get">
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>第{{$per_list->per_num}}教学周期</th>
                                <th>考试类型</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $exam_list as $key => $val )
                                <tr>
                                        <td>
                                            {{ $val -> exam_date }}
                                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                            {{$val -> week}}
                                        </td>
                                        <td>
                                            <input type="radio" name="{{ $val -> exam_id }}" value="0" @if( $val -> exam_type == 0 ) checked="checked" @endif >无考试&nbsp;&nbsp;
                                            <input type="radio" name="{{ $val -> exam_id }}" value="1" @if( $val -> exam_type == 1 ) checked="checked" @endif >日考&nbsp;&nbsp;
                                            <input type="radio" name="{{ $val -> exam_id }}" value="2" @if( $val -> exam_type == 2 ) checked="checked" @endif >周考&nbsp;&nbsp;
                                            <input type="radio" name="{{ $val -> exam_id }}" value="3" @if( $val -> exam_type == 3 ) checked="checked" @endif >月考&nbsp;&nbsp;
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="submit" value="修改" class="btn btn-success">
                        <input type="reset" value="重置" class="btn btn-success">
                    </div>
                </div>
        </form>
            @else
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>第{{$per_list->per_num}}教学周期</th>
                    <th>考试类型</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $exam_list as $key => $val )
                    <tr>
                        <td>
                            {{ $val -> exam_date }}
                            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                            {{$val -> week}}
                        </td>
                        <td>
                            @if( $val -> exam_type == 0 )
                            无考试
                            @elseif( $val -> exam_type == 1 )
                            日考
                            @elseif( $val -> exam_type == 2 )
                            周考
                            @elseif( $val -> exam_type == 3 )
                            月考
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @endif
    </div><!-- /.col -->
</div><!-- /.row -->