<div class="page-header">
    <h1>
        成绩管理
        <small>
            <i class="icon-double-angle-right"></i>
            查看成绩
        </small>
    </h1>
</div><!-- /.page-header -->
姓名&nbsp;&nbsp;<input type="text" id="username" value="{{$username}}">
&nbsp;&nbsp;&nbsp;&nbsp;
<select id="select">
    <option value="1">理论成绩</option>
    @if($type == 0)
    <option value="0" selected="selected">机试成绩</option>
    @else
    <option value="0">机试成绩</option>
    @endif
</select>
&nbsp;&nbsp;
<input type="text" id="exam1" style="width: 50px;" value="{{$exam1}}"><span id="num1"></span>
- - -
<input type="text" id="exam2" style="width: 50px;" value="{{$exam2}}"><span id="num2"></span>
&nbsp;&nbsp;&nbsp;&nbsp; 日期&nbsp;&nbsp;<input class="laydate-icon" id="search" onclick="laydate()" placeholder="点击选择日期" value="{{$search}}">
<input type="button" value="搜索" onclick='searchs()' class="btn btn-xs btn-info">
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
                            <th>学生姓名</th>
                            <th>学院</th>
                            <th>班级</th>
                            <th>理论成绩</th>
                            <th>机试成绩</th>
                            <th>提交时间</th>
                            <th>提交人</th>
                            <th>考试类型</th>
                            <th>操作</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if(!empty($arr))
                            @foreach($arr as $v)
                                <tr id="tr{{$v->gid}}">
                                    <td class="center">
                                        <label>
                                            <input type="checkbox" class="ace"  name="gid" value="{{$v->gid}}"/>
                                            <span class="lbl"></span>
                                        </label>
                                    </td>
                                    <td>
                                        {{$v->name}}
                                    </td>
                                    <td>{{$v->college_name}}</td>
                                    <td>{{$v->class_name}}</td>
                                    <td>{{$v->theory}}</td>
                                    <td>{{$v->exam}}</td>
                                    <td>{{$v->g_add_date}}</td>
                                    <td>{{$v->username}}</td>
                                    <td>
                                        @if($v -> type == 1)
                                            日考
                                        @elseif($v -> type == 2)
                                            周考
                                        @else
                                            月考
                                        @endif
                                    </td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">

                                            <button class="btn btn-xs btn-danger" onclick="ajax_fun({{$v->gid}})" href="javascript:void(0)">
                                                <i class="icon-trash bigger-120"></i>
                                            </button>

                                            {{--<a href="javascript:void(0)" onclick="ajax_fun()"></a>--}}

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