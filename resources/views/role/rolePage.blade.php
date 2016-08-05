
    <div class="page-header">
        <h1>
            角色管理
            <small>
                <i class="icon-double-angle-right"></i>
                角色列表
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
                                <th>角色名称</th>
                                <th>是否启用</th>
                                <th></th>
                            </tr>
                            </thead>

                            <tbody>

                            @foreach($list as $v)
                                <tr id="info_{{$v->rid}}">
                                    <td class="center">
                                        <label>
                                            <input type="checkbox" class="ace" />
                                            <span class="lbl"></span>
                                        </label>
                                    </td>

                                    <td>
                                        <a href="#">{{$v->role_name}}</a>
                                    </td>
                                    <td class="hidden-480" id="list_{{$v->rid}}">
                                                <span class="label label-sm label-success">
                                                    @if($v->status)
                                                        <a href="javascript:void(0)" onclick="fun({{$v->rid}},0)" style="color:#ffffff; text-decoration:none;">已启用</a>
                                                    @else
                                                        <a href="javascript:void(0)" onclick="fun({{$v->rid}},1)" style="color:#ffffff; text-decoration:none;">未启用</a>
                                                    @endif
                                                </span>
                                    </td>

                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                            <center>
                                                <button class="btn btn-xs btn-success" title="赋权">
                                                    <i class="icon-ok bigger-120"></i>
                                                </button>

                                                <button class="btn btn-xs btn-info" title="修改" onclick="update({{$v->rid}})">
                                                    <i class="icon-edit bigger-120"></i>
                                                </button>

                                                <button class="btn btn-xs btn-danger" title="删除" onclick="del({{$v->rid}})">
                                                    <i class="icon-trash bigger-120"></i>
                                                </button>
                                            </center>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <?php echo $page?>
                    </div><!-- /.table-responsive -->
                </div><!-- /span -->
            </div><!-- /row -->

            <div id="modal-table" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header no-padding">
                            <div class="table-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    <span class="white">&times;</span>
                                </button>
                                Results for "Latest Registered Domains
                            </div>
                        </div>
                        <div class="modal-footer no-margin-top">
                            <button class="btn btn-sm btn-danger pull-left" data-dismiss="modal">
                                <i class="icon-remove"></i>
                                Close
                            </button>

                            <ul class="pagination pull-right no-margin">
                                <li class="prev disabled">
                                    <a href="#">
                                        <i class="icon-double-angle-left"></i>
                                    </a>
                                </li>

                                <li class="active">
                                    <a href="#">1</a>
                                </li>

                                <li>
                                    <a href="#">2</a>
                                </li>

                                <li>
                                    <a href="#">3</a>
                                </li>

                                <li class="next">
                                    <a href="#">
                                        <i class="icon-double-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
