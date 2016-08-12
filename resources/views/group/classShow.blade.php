<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>jquery网格插件 - Bootstrap后台管理系统模版Ace下载</title>

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

		<link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.full.min.css" />
		<link rel="stylesheet" href="assets/css/datepicker.css" />
		<link rel="stylesheet" href="assets/css/ui.jqgrid.css" />

		<!-- fonts -->

		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

		<!-- ace styles -->

		<link rel="stylesheet" href="assets/css/ace.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
		<link rel="stylesheet" href="theme.css" media="all">

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
								<a href="#">Home</a>
							</li>

							<li>
								<a href="#">Tables</a>
							</li>
							<li class="active">jqGrid plugin</li>
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

					<div class="page-content">
						<div class="page-header">
							<h1>
								组建管理
								<small>
									<i class="icon-double-angle-right"></i>
                                    创建班级
								</small>
							</h1>
						</div><!-- /.page-header -->
		
						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="alert alert-info">
									<i class="icon-hand-right"></i>

								
									<button class="close" data-dismiss="alert">
										<i class="icon-remove"></i>
									</button>
								</div>
							   <center>
									<table >
				                          <tr>
						                        	<td>
						                          		<h3>创建班级 ： &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3></td>
						                          		<input type="hidden" id="hidden" value="{{$ser_id}}">
						                          	<td>
						                          		<input type="text" placeholder="请输入班级..." id="class_name"><span id="tishi"></span>
						                          	</td>
													<br>
				                          		</tr>           
				                              <tr>
				                              	<td colspan="2"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				                             	 <button type="button" class="btn btn-primary" id="new_class" data-toggle="button"> 创建
				                                 </button>
													</td>
				                              </tr>         
			                        </table>
                      	 		</center>
		</div>
					<table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>id</th>
                                <th>学院名称</th>
                                <th>系名称</th>
                                <th class="hidden-480">班级名称</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $arr as $key => $val )
                                <tr id="remove_{{$val->class_id}}">
                                    <td class="center">
                                        <label>
                                            <input type="checkbox" class="ace" />
                                            <span class="lbl"></span>
                                        </label>
                                    </td>
                                    <td id="{{$val->class_id}}">
                                        {{$val->class_id}}
                                    </td>
                                    <td>{{$val->college_name}}</td>
                                    <td>{{$val->ser_name}}</td>
                                    <td>{{$val->class_name}}</td>
                                     <td>
									    <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">

									        <button class="btn btn-xs btn-danger delete" attr="{{$val->class_id}}">
									            <i class="icon-trash bigger-120"></i>
									        </button>
									        <div style="display: none" id="tian">
									        	<h2>1</h2>
									        </div>
									         <a cc="{{$val->class_id}}" class="change btn btn-primary btn-large theme-login" href="javascript:;">选择PK班级</a>
									         <form action="group_excel" method="post" enctype="multipart/form-data">
									         	  <input type="hidden" name="_token" id="_token" value="{{ csrf_token()}}">
                                                 <button type="button" class="btn btn-xs btn-danger" id="excel_add">导入学生</button>
                                                 <input type="file" name="myfile" id="myfile" style="display:none;"/>
                                                 <input type="hidden" name="classid" value="{{$val->class_id}}"/>
                                                 <button type="submit" class="btn btn-xs btn-danger" id="excel_submit" style="display: none;">
                                    导入
                                </button>


								</form>
									    </div>
								 </td>
                               </tr>
                            @endforeach
                            </tbody>
                        </table>
		<div class="theme-popover">
		     <div class="theme-poptit">
		          <a href="javascript:;" title="关闭" class="close">×</a>
		          <h3>欢迎  选择PK  班级</h3>
		     </div>
		     <div class="theme-popbod dform">
		           <form class="theme-signin" name="loginform" action="" method="post">
		                <ol>
	                     <li><strong>选择PK班：</strong>

							<select id="clapk">
							<option value="0">请选择</option>
							@foreach ($clapk as $k=>$v)
								<option value="{{$v->class_id}}">{{$v->class_name}}</option>
								@endforeach
							</select>
							<span id="clati"></span>
	                     </li>
	                     <li><input class="btn btn-primary" id="confirm" type="button"  value=" 确认 " /></li>
	                </ol>
	           </form>
	     	 </div>
					<div id="grid-pager"></div>
								<script type="text/javascript">
									var $path_base = "/";//this will be used in gritter alerts containing images
								</script>
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
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
			</div><!-

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

		<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> -->

		<!-- <![endif]-->

		<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
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
            jQuery(".delete").click(function(){
                var id = jQuery(this).attr("attr");
                $.ajax({
                    url: "{{URL('groupdelete')}}",
                    type: "get",
                    data: "class_id="+id,
                    success: function (msg) {
                        if(msg.error==0){
                           jQuery("#remove_"+id).remove();
                        }else{
                            alert(msg.msg)
                        }
                    }
                })
            })
            jQuery("#excel_add").click(function(){
                jQuery(this).hide();
                jQuery("#excel_submit").show();
                jQuery("#myfile").show();
            })
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
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/jqGrid/jquery.jqGrid.min.js"></script>
		<script src="assets/js/jqGrid/i18n/grid.locale-en.js"></script>

		<!-- ace scripts -->

		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script>
		
		jQuery(document).ready(function($) {
			$('.theme-login').click(function(){
				$('.theme-popover-mask').fadeIn(100);
				$('.theme-popover').slideDown(200);
			})
			$('.theme-poptit .close').click(function(){
				$('.theme-popover-mask').fadeOut(100);
				$('.theme-popover').slideUp(200);
			})

		})
		</script>

</body>
</html>
<script>
	function  creatGroup(id){
        $('#div_' + id).show()
        $('#cr_group_' + id).hide()
    }
    function  creatGroupPro(id) {
        var gid = $('#group_' + id).val()
        if (gid != null) {
            $.ajax({
                url: "{{URL('groupManAdd')}}",
                type: "get",
                data: "class_id=" + id + "&num=" + gid,
                success: function (msg) {
                    // alert(msg)
                    location.href = "{{URL('collShow')}}";
                }
            })
        } else {
            alert('请选择创建个数')
        }
    }
   $("#new_class").click(function(){
   		var ser_id=$("#hidden").val();
   		var class_name=$("#class_name").val();
   		var reg=/^[0-9]\w{5,20}$/i;
        if(!reg.test(class_name)){
             jQuery("#tishi").html("<font color='red'>格式不正确</font>");
        }else{
            $.ajax({
                url: "{{URL('groupClaShow')}}",
                type: "get",
                data: "class_name=" + class_name + "&ser_id=" + ser_id,
                success: function (msg) {
                    if(msg==1){
                        location.href = "{{URL('groupClaShow')}}";
                    }

                }
            })
        }
   })
    $(".change").click(function(){
        c_id=$(this).attr('cc');
    })
    /*
   	添加pk班级
    */
   $("#confirm").click(function(){
   	var clapk=$("#clapk").val()
   	$.ajax({
            url:"{{URL('pkAdd')}}",
            type:"get",
            data:"c_id="+c_id+"&clapk="+clapk,
            success:function(msg)
            {
                // alert(msg)
                    // location.href="{{URL('groupClaShow')}}";
                if(msg==1)
                {
                    $("#clati").html("<font color='red'>你已经有PK班级</font>")
                }else if(msg==2)
                {
                    $("#clati").html("<font color='red'>你不能和自己PK</font>")
                }else
                {
                    location.href="{{URL('groupClaShow')}}"
                }
            }
        })
   })
</script>
