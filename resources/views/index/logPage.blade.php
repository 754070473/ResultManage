<div class="page-header">
    <h1>
        管理员日志
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
                            <th>管理员账号</th>
                            <th>操作内容</th>
                            <th class="hidden-480">操作时间</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @if( !empty($arr) )
                        @foreach( $arr as $key => $val )
                            <tr id="tr{{$val->log_id}}">
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" />
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td>
                                    {{$val->accounts}}
                                </td>
                                <td>{{$val->content}}</td>
                                <td class="hidden-480">{{$val->log_addtime}}</td>
                                <td>
                                    <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                        <button class="btn btn-xs btn-danger" logid="{{$val->log_id}}">
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
