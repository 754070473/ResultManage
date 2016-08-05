<div class="page-header">
    <h1>
        成绩审核
    </h1>
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
                            <th class="center">
                                <label>
                                    <input type="checkbox" class="ace ace1" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th>学生姓名</th>
                            <th>学院</th>
                            <th>班级</th>
                            <th>理论成绩</th>
                            <th>机试成绩</th>
                            <th>提交时间</th>
                            <th>提交人</th>
                            <th>考试类型</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(!empty($arr))
                            @foreach( $arr as $key => $val )
                                <tr id="tr{{$val->gid}}">
                                    <td class="center">
                                        <label>
                                            <input type="checkbox" class="ace ace2" value="{{$val->gid}}"/>
                                            <span class="lbl"></span>
                                        </label>
                                    </td>
                                    <td>
                                        {{$val->name}}
                                    </td>
                                    <td>{{$val->college_name}}</td>
                                    <td>{{$val->class_name}}</td>
                                    <td>{{$val->theory}}</td>
                                    <td>{{$val->exam}}</td>
                                    <td>{{$val->add_date}}</td>
                                    <td>{{$val->username}}</td>
                                    <td>
                                        @if($val -> type == 1)
                                            日考
                                        @elseif($val -> type == 2)
                                            周考
                                        @else
                                            月考
                                        @endif
                                    </td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                            <button class="btn btn-xs btn-info" gid="{{$val->gid}}">
                                                通过
                                            </button>
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <button class="btn btn-xs btn-danger" gid="{{$val->gid}}">
                                                不通过
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
    </div><!-- /.col -->
</div><!-- /.row -->
<?php echo $page?>