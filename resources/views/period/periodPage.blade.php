<div class="page-header">
    <h1>
        教学周期管理
        <small>
            <i class="icon-double-angle-right"></i>
            教学周期列表
        </small>
    </h1>
    <span style="float:right;margin-top: -35px"><button class="btn btn-info add">新增教学周期</button></span>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>教学周期</th>
                            <th>周期开始时间</th>
                            <th>周期结束时间</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @if( !empty($arr['arr']) )
                            @foreach($arr['arr'] as $key => $val )
                                <tr>
                                    <td>
                                        {{$key}}
                                    </td>
                                    <td>
                                        第{{ $val -> per_num }}周期
                                    </td>
                                    <td>{{ $val -> start_date }}</td>
                                    <td>{{ $val -> end_date }}</td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                            <center>
                                                <button class="btn btn-xs btn-success" title="查看详情" onclick="give({{$v->rid}})">
                                                    <i class="icon-ok bigger-120"></i>
                                                </button>
                                            </center>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <?php echo $arr['page']?>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
    </div><!-- /.col -->
</div><!-- /.row -->