<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>用户列表</title>
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
        <style>
            .up{
                width: 200px;
                height: 35px;
            }
        </style>
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
								<a href="#">组建管理</a>
							</li>
							<li class="active">分配小组</li>
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
	@if(!isset($arr))
					<div class="page-content">
						<div class="page-header">
							<h1>
								
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
									<div class="col-xs-12 col-sm-6 " style="width:100%">
										<div class="widget-box">
											<div class="widget-header header-color-blue">
												<h5 class="bigger lighter">
													<i class="icon-table"></i>
													{{$classname}}  班级总人数:{{$count}}人
												</h5>
											</div>
											<div class="widget-body">
												<div class="widget-main no-padding">
                                                   
                                                </div>


                                            </div>
										</div>
           								 <div class="form-group">
				    <label class="col-sm-3 control-label">可以分为：</label>
				      <div class="col-sm-4">
				         <select id="select1" name="usertype" class="selectpicker show-tick form-control"  data-live-search="false">

				                <option value="4">4组</option>
				                <option value="6">6组</option>
				                <option value="8">8组</option>
				                <option value="10">10组</option>
				                <option value="12">12组</option>
				         </select>
				     </div>
				     <button type="button" class="width-10 pull-lift btn btn-sm btn-primary" id='butt'>
						<!-- <i class="icon-key"></i> -->
						分组
					</button>
				</div>

								<div class="space-24"></div>


								<div class="space-24"></div>


								<div class="space"></div>


								<div class="space"></div>


								<div class="space-24"></div>

							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
					@else
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
                                            <th>小组名称</th>
                                            <th>组长</th>
                                            <th>小组成员</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                @foreach($arr as $key => $var)
                                        <tr>                               
                                        	<td>
                                        		@if(isset($var[0]->group_name))
                                                {{$var[0]->group_name}}
                                                @else
                                                第{{$var}}组
                                                @endif
                                            </td> 
                                            <td>
                                            	@if(isset($var[0]->student_name))
                                            	<font color='red' size='3'>{{$var[0]->student_name}}</font>
                                            	@else
                                            	暂无组长
                                            	@endif
                                            </td>                                          
                                            <td>
                                            @if(isset( $var[1]->student_name ))
	                                            @foreach($var as $k => $v)
	                                            @if($k != 0)
	                                            {{$v->student_name}}&nbsp;&nbsp;
	                                            @endif
	                                            @endforeach
	                                        @else
	                                        	暂无成员
	                                        @endif
                                            </td>
                                            <td>
                                            	@if(!isset( $var[1]->student_name ))
                                            	<a href="{{url('buildIndex')}}?gr_id={{$var}}">添加成员</a>
                                            	@endif
                                            </td>
                                        </tr>
                                    
                                @endforeach
                                        </tbody>
                                    </table>
                                   
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
            </div><!-- /.page-content -->
            @endif
				</div><!-- /.main-content -->

				<div class="ace-settings-container" id="ace-settings-container">
					<div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
						<i class="icon-cog bigger-150"></i>
					</div>

					<div class="ace-settings-box" id="ace-settings-box">
						<div>
							<div class="pull-left">
								<select id="skin-colorpicker" class="hide">
									<option data-skin="default" value="#438EB9">#438EB9</option>
									<option data-skin="skin-1" value="#222A2D">#222A2D</option>
									<option data-skin="skin-2" value="#C6487E">#C6487E</option>
									<option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
								</select>
							</div>
							<span>&nbsp; Choose Skin</span>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
							<label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
							<label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
							<label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
							<label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
						</div>

						<div>
							<input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
							<label class="lbl" for="ace-settings-add-container">
								Inside
								<b>.container</b>
							</label>
						</div>
					</div>
				</div><!-- /#ace-settings-container -->
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

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/jquery.slimscroll.min.js"></script>

		<!-- ace scripts -->

		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
        <script src="assets/js/userAdd/userList.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
            jQuery(function($){
                $.get("{{url('top')}}",function(m){
                    $('.main-container').first().before(m);
                })
            });
            jQuery(function($){
                $.get("{{url('left')}}",function(m){
                    $('.main-content').first().before(m);
                })
            });
			jQuery(function($) {

				$('#simple-colorpicker-1').ace_colorpicker({pull_right:true}).on('change', function(){
					var color_class = $(this).find('option:selected').data('class');
					var new_class = 'widget-header';
					if(color_class != 'default')  new_class += ' header-color-'+color_class;
					$(this).closest('.widget-header').attr('class', new_class);
				});


				$('.slim-scroll').each(function () {
					var $this = $(this);
					$this.slimScroll({
						height: $this.data('height') || 100,
						railVisible:true
					});
				});
			    $('.widget-container-span').sortable({
			        connectWith: '.widget-container-span',
					items:'> .widget-box',
					opacity:0.8,
					revert:true,
					forceHelperSize:true,
					placeholder: 'widget-placeholder',
					forcePlaceholderSize:true,
					tolerance:'pointer'
			    });

			});
            function updateRole()
            {

                var role_update = $('#role_update').val();
                var ace2 = $('.ace2');
                var len = ace2.length;
                if( len >0 ){
                    var search = jQuery('#search').val();
                    if(!search){
                        search = '';
                    }
                    var log_id = '';
                    for( var i = 0 ; i < len ; i++ ){
                        if( ace2.eq(i).prop( 'checked' ) == true ){
                            log_id += ','+ace2.eq(i).val();
                        }
                    }
                    log_id = log_id.substr(1);
                    $.ajax({
                        type: 'get',
                        url: 'roleUpdate',
                        data: 'id=' + log_id+"&date="+role_update,
                        success: function (msg) {
                            if (msg != 0) {
                                var t_page = $('#t_page').val();
                                show_page(t_page)
                            } else {

                            }
                        }
                    });
                }
            }
		</script>
        <input type="hidden" id="token" value="{{ csrf_token() }}" />
        <script>
            var  _token = $("#token").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': _token
                }
            });
        </script>
        @if(!isset($arr))
        <script>
			$('#butt').click(function(){
				
				// alert(1)
				var bulid = $('#select1 option:selected').val();
				// alert(bulid);
				$.ajax({
		             type: "get",
		             url: "{{url('buildAdd')}}",
		             data: 'bulid='+bulid,
		             success: function(msg){
			              if (msg==0) 
			              {
			              	  location.href="{{url('build')}}"
			              }
		             }
		           });
			})
		</script>
		@endif
</body>
</html>


