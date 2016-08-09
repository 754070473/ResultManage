<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    
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
<div id="info">

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
                        <a href="#">首页</a>
                    </li>


                </ul><!-- .breadcrumb -->

                <div class="nav-search" id="nav-search">
                    <form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="icon-search nav-search-icon"></i>
								</span>
                    </form>
                </div><!-- #nav-search -->
            </div>

            <div class="page-content" id="list">
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
                                @if(!empty($list))
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
                                                    <button class="btn btn-xs btn-success" title="赋权" onclick="give({{$v->rid}})">
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
                                    @else
                                        @endif
                                        </tbody>
                                    </table>
                                    <?php echo $page?>
                                </div><!-- /.table-responsive -->
                            </div><!-- /span -->
                        </div><!-- /row -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div><!-- /.main-content -->
    </div><!-- /.main-container-inner -->

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>
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

<script type="text/javascript">
    /*  启用与未启用的状态修改  */
    function fun(id,status){
        $.ajax({
            type: "GET",
            url: "rolestatus",
            data: "id="+id+"&status="+status,
            success: function(msg){
                if(status==1){
                    var str = "<span class='label label-sm label-success'><a href=\"javascript:void(0)\" id='hehe"+id+"'  onclick=\"fun("+id+",0)\" >已启用</a></span>";
                }else{
                    var str = "<span class='label label-sm label-success'><a href=\"javascript:void(0)\" id='hehe"+id+"' onclick=\"fun("+id+",1)\" >未启用</a></span>";
                }
                if(msg==1){
                    jQuery("#list_"+id).html(str)
                    jQuery("#hehe"+id).attr('style','color:white;text-decoration:none');
                }
            }
        });
    }
    /*  修改角色名操作  */
    function update(id){
        $.ajax({
            type: "GET",
            url: "roleupdate",
            data: "id="+id,
            success: function(msg){
                jQuery("#list").html(msg)
            }
        });
    }
    /*  删除角色验证  */
    function del(id){
        $.ajax({
            type: "GET",
            url: "roledelete",
            data: "id="+id,
            success: function(msg){
                if(msg.error==1){
                    alert(msg.msg)
                }else{
                    dele(msg.data)
                }
            }
        });
    }
    function dele(id){
        if(confirm("确定要删除此用户吗?")){
            $.ajax({
                type: "GET",
                url: "roledel",
                data: "id="+id,
                success: function(msg){
                    if(msg==1){
                        jQuery("#info_"+id).remove()
                    }
                }
            });
        }
    }
    /*  赋权选项 */
    function give(id){
        $.ajax({
            type: "GET",
            url: "rolegive",
            data: "id="+id,
            success: function(msg){
                jQuery("#list").html(msg)
            }
        });
    }
    jQuery(function($){
        $.get("{{url('top')}}",function(m){
            $('.main-container').first().before(m);
        })
        $.get("{{url('left')}}",function(m){
            $('.main-content').first().before(m);
        })
    });
    jQuery(function($) {
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
    })
</script>
    <script type="text/javascript">
        $(document).on('click','.click',function(){
            var rid = $("#userid").val();
            var selects = $('.selected');
            var id = '';
            for( var i = 0 ; i < selects.length ; i++ ){
                id += ',' + selects.eq(i).attr('data-value');
            }
            id = id.substr(1);
            $.ajax({
                type: "GET",
                url: "rolegives",
                data: "rel="+rel+"&rid="+id,
                success: function(msg){
                    $("#list").html(msg)
                }
            })
    </script>
</div>
</body>
</html>
