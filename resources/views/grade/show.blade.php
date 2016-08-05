<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>八维成绩管理系统 - 管理成绩</title>
    <meta name="keywords" content="Bootstrap模版,Bootstrap模版下载,Bootstrap教程,Bootstrap中文" />
    <meta name="description" content="站长素材提供Bootstrap模版,Bootstrap教程,Bootstrap中文翻译等相关Bootstrap插件下载" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- basic styles -->

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />

    <!--[if IE 7]>
    <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->


    <!-- ace styles -->

    <link rel="stylesheet" href="assets/css/ace.min.css" />
    <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="assets/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->

    <script src="assets/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>

    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>


        <div class="main-content">
            <div class="breadcrumbs" id="breadcrumbs">
                <script type="text/javascript">
                    try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                </script>

                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home home-icon"></i>
                        <a href="index">首页</a>
                    </li>
                    <li class="active">成绩管理</li>
                </ul><!-- .breadcrumb -->

            </div>
            <div class="page-content"  id="list">
                <div class="page-header">
                    <h1>
                        成绩管理
                        <small>
                            <i class="icon-double-angle-right"></i>
                            查看成绩
                        </small>
                    </h1>
                </div><!-- /.page-header -->
                姓名&nbsp;&nbsp;<input type="text" id="username">
                 &nbsp;&nbsp;&nbsp;&nbsp;
                <select id="select">
                    <option value="1">理论成绩</option>
                    <option value="0">机试成绩</option>
                </select>
                &nbsp;&nbsp;<input type="text" id="exam1" style="width: 50px;"><span id="num1"></span>
                - - -
                <input type="text" id="exam2" style="width: 50px;"><span id="num2"></span>
                &nbsp;&nbsp;&nbsp;&nbsp; 日期&nbsp;&nbsp;<input class="laydate-icon" id="search" onclick="laydate()" placeholder="点击选择日期">
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
            </div><!-- /.page-content -->
        </div><!-- /.main-content -->
    </div><!-- /.main-container-inner -->
</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->


<!-- <![endif]-->

<!--[if IE]>
<![endif]-->

<!--[if !IE]> -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/typeahead-bs2.min.js"></script>

<!-- page specific plugin scripts -->

<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

<!-- ace scripts -->

<script src="assets/js/ace-elements.min.js"></script>
<script src="assets/js/ace.min.js"></script>
<!-- inline scripts related to this page -->
<script src="laydate/laydate.js"></script>
<script type="text/javascript">
    //搜索
    function searchs(){
        //定义值  上面的id值
        var search = document.getElementById('search').value;
        var username = document.getElementById('username').value;
        var exam1 = document.getElementById('exam1').value;
        var exam2 = document.getElementById('exam2').value;
        var type = document.getElementById('select').value;
        /*var exam_reg = /^(^[1-9]\d$)|(^\d$)|(^100$)$/;
        if(exam_reg.test(exam1)){
            document.getElementById('num1').innerHTML="<font color='black'>√</font>";
            return true;
        }else{
            document.getElementById('num1').innerHTML="<font color='red'>必须输入大于等于0且小于等于100的整数</font>";
            return false;
        }
        if(exam_reg.test(exam2)){
            document.getElementById('num2').innerHTML="<font color='black'>√</font>";
            return true;
        }else{
            document.getElementById('num2').innerHTML="<font color='red'>必须输入大于等于0且小于等于100的整数</font>";
            return false;
        }*/
        var str = '';
        if( username != ''){
            str += '&'+'username='+username;
        }
        if( exam1 != '' ){
            str += '&'+'exam1='+exam1;
        }
        if( exam2 != '' ){
            str += '&'+'exam2='+exam2;
        }
        if( search != '' ){
            str += '&'+'search='+search;
        }
        if( exam1 != '' || exam2 != '' ){
            str += '&'+'type='+type;
        }
        str = str.substr(1);
        //创建ajax对象
        var ajax=new XMLHttpRequest();
        //ajax事件
        ajax.onreadystatechange=function(){
            if(ajax.readyState==4){
                document.getElementById('list').innerHTML=ajax.responseText;
            }
        }
        //与服务器连接  1、search要传入的值  2、上面定义的值
        ajax.open('get','{{url("search")}}?'+str);
        //处理请求
        ajax.send(null);
    }

    //删除
    function ajax_fun(gid){
        //创建ajax对象
        var ajax=new XMLHttpRequest();

        //与服务器连接
        ajax.open('get','gradeDelete?&gid='+gid);
        //处理服务器
        ajax.send(null);
        //ajax的事件
        ajax.onreadystatechange=function(){
            if(ajax.readyState==4){
                document.getElementById('list').innerHTML=ajax.responseText;
            }
        }
    }

    //修改理论成绩
    function change(id){
        document.getElementById('i'+id).style.display='block';
        document.getElementById('s'+id).innerHTML='';

    }
    function update(id){
        var v=document.getElementById('i'+id).value;
//        alert(v);
        $.ajax({
            type:'get',
            url:'updates',
            data:"id="+id+"&v="+v,
            success:function(i){
                if(i==1){
                    document.getElementById('i'+id).style.display='none';
                    location.href="show"
                }else{
                    alert('亲，还没修改呢');
                    if (confirm("您确定退出修改吗??")) {
                        location.href="show"
                    }
                }
            }
        })
    }

    //修改机试成绩
    function change1(id){
        document.getElementById('y'+id).style.display='block';
        document.getElementById('k'+id).innerHTML='';
    }
    function update1(id){
        var v=document.getElementById('y'+id).value;
        //alert(v);
            $.ajax({
                type:'get',
                url:'updatess',
                data:"id="+id+"&v="+v,
                success:function(i){
                    if(i==1){
                        document.getElementById('i'+id).style.display='none';
                        location.href="show"
                    }else{
                        alert('亲，还没修改呢');
                        if (confirm("您确定退出修改吗??")) {
                            location.href="show"
                        }
                    }
                }
            })

    }

    jQuery(function($) {
        $.get("{{url('left')}}",function(m){
            $('.main-content').first().before(m);
        });

        $.get("{{url('top')}}",function(m){
            $('.main-container').first().before(m);
        });

        var oTable1 = $('#sample-table-2').dataTable( {
            "aoColumns": [
                { "bSortable": false },
                null, null,null, null, null,
                { "bSortable": false }
            ] } );


        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                    .each(function(){
                        this.checked = that.checked;
                        $(this).closest('tr').toggleClass('selected');
                    });

        });


        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
        }





//
//        //ajax删除
//        $(document).on('click','.btn-danger',function(){
//            var search = jQuery('#search').val();
//            if(!search){
//                search = '';
//            }
//            var gid = $(this).attr('gid');
//            var p = $('.current a').html();
//            if( search == '' ) {
//                $.ajax({
//                    type: 'GET',
//                    url: 'gradeDelete',
//                    data: 'gid=' + gid + '&p=' + p,
//                    success: function (msg) {
//                        if (msg != 0) {
//                            $('#list').html(msg);
//                        } else {
//                            alert('删除失败');
//                        }
//                    }
//                });
//            }else{
//                $.ajax({
//                    type: 'GET',
//                    url: 'gradeDelete',
//                    data: 'gid=' + gid + '&p=' + p +'&search='+search,
//                    success: function (msg) {
//                        if (msg != 0) {
//                            $('#list').html(msg);
//                        } else {
//                            alert('删除失败');
//                        }
//                    }
//                });
//            }
//        });
    });
//    function ckDeleteAll()
//    {
//        var ace2 = $('.ace2');
//        var len = ace2.length;
//        if( len >0 ){
//            var search = jQuery('#search').val();
//            if(!search){
//                search = '';
//            }
//            var gid = '';
//            for( var i = 0 ; i < len ; i++ ){
//                if( ace2.eq(i).prop( 'checked' ) == true ){
//                    gid += ','+ace2.eq(i).val();
//                }
//            }
//            gid = gid.substr(1);
//            if( search == '' ) {
//                $.ajax({
//                    type: 'GET',
//                    url: 'gradeDelete',
//                    data: 'gid=' + gid,
//                    success: function (msg) {
//                        if (msg != 0) {
//                            $('#list').html(msg);
//                        } else {
//                            alert('删除失败');
//                        }
//                    }
//                });
//            }else{
//                $.ajax({
//                    type: 'GET',
//                    url: 'gradeDelete',
//                    data: 'gid=' + gid + '&search='+search,
//                    success: function (msg) {
//                        if (msg != 0) {
//                            $('#list').html(msg);
//                        } else {
//                            alert('删除失败');
//                        }
//                    }
//                });
//            }
//        }
//    }
</script>
</body>
</html>
