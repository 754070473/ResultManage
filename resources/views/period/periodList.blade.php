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
                                                            {{$key+1}}
                                                        </td>
                                                        <td>
                                                            第{{ $val -> per_num }}周期
                                                        </td>
                                                        <td>{{ $val -> start_date }}</td>
                                                        <td>{{ $val -> end_date }}</td>
                                                        <td>
                                                            <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                                                <center>
                                                                    <button class="btn btn-xs btn-success" title="查看详情" per_id="{{$val -> per_id}}" />
                                                                        考试安排详情
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

    <script src="laydate/laydate.js"></script>

    <!-- inline scripts related to this page -->

    <script type="text/javascript">
        jQuery(function($){
            $.get("{{url('top')}}",function(m){
                $('.main-container').first().before(m);
            })
            $.get("{{url('left')}}",function(m){
                $('.main-content').first().before(m);
            })
            $('.add').click(function(){
                $.get("{{url('periodAdd')}}",function(m){
                    $('#list').html(m);
                })
            });
            $('.btn-success').click(function(){
                var per_id = $(this).attr('per_id');
                $.get({
                    type : 'get' ,
                    url : 'periodExam' ,
                    data : 'per_id='+per_id ,
                    success : function(msg){
                        $('#list').html(msg);
                    }
                })
            });
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
</div>
</body>
</html>
