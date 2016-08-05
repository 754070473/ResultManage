<div class="page-header">
    <h1>
        成绩管理
        <small>
            <i class="icon-double-angle-right"></i>
            查看成绩
        </small>
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
                                    <input type="checkbox" class="ace" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            {{--<th>成绩表ID</th>--}}
                            <th>姓名</th>
                            <th class="hidden-480">账号</th>

                            <th>
                                理论成绩
                            </th>
                            <th class="hidden-480">机试成绩</th>

                            <th>添加日期</th>
                            {{--<th>添加时间</th>--}}
                            <th>录入人</th>
                            <th>身份</th>
                            <th>类型</th>
                            <th>操作</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(!empty($arr))
                            @foreach($arr as $v)
                                <tr id="tr{{$v->gid}}">
                                    <td class="center">
                                        <label>
                                            <input type="checkbox" class="ace" />
                                            <span class="lbl"></span>
                                        </label>
                                    </td>

                                    {{--<td>{{$v->gid}}</td>--}}
                                    <td>{{$v->username}}</td>
                                    <td>{{$v->accounts}}</td>
                                    <td>{{$v->theory}}</td>
                                    <td>{{$v->exam}}</td>
                                    <td>{{$v->add_date}}</td>
                                    {{--<td>{{$v->add_time}}</td>--}}
                                    <td>{{$v->name}}</td>
                                    <td>
                                        @if($v->status==1)
                                            学生
                                        @elseif($v->status==2)
                                            组长
                                        @elseif($v->status==3)
                                            学委
                                        @elseif($v->status==4)
                                            讲师
                                        @elseif($v->status==5)
                                            教务
                                        @endif
                                    </td>
                                    <td>
                                        @if($v->type==1)
                                            日考
                                        @elseif($v->type==2)
                                            周考
                                        @elseif($v->type==3)
                                            月考
                                        @endif
                                    </td>

                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                            <button class="btn btn-xs btn-info" gid="{{$v->gid}}">
                                                <i class="icon-edit bigger-120"></i>
                                            </button>

                                            <button class="btn btn-xs btn-danger">
                                                <i class="icon-trash bigger-120"></i>
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
