<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>八维学生成绩录入系统</title>
		<!-- <meta name="keywords" content="BootstrapÄ£°æ,BootstrapÄ£°æÏÂÔØ,Bootstrap½Ì³Ì,BootstrapÖÐÎÄ" />
		<meta name="description" content="Õ¾³¤ËØ²ÄÌá¹©BootstrapÄ£°æ,Bootstrap½Ì³Ì,BootstrapÖÐÎÄ·­ÒëµÈÏà¹ØBootstrap²å¼þÏÂÔØ" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
 -->
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

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<i class="icon-leaf green"></i>
									<span class="red">八维</span>
									<span class="white">学生成绩录入系统</span>
								</h1>
								<h4 class="blue">&copy; 八维集团</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="icon-coffee green"></i>
												请输入你的信息
											</h4>
										<!-- 错误信息提示 -->
											<font id="div" color='red'></font>
										<!-- 错误信息提示end -->
											<div class="space-6"></div>

											<form>
												<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="账号" id='accounts'/>
															<i class="icon-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="密码" id='password'/>
															<i class="icon-lock"></i>
														</span>
													</label>
													<!-- 验证码 -->
														<img src="captcha_code" alt="" onclick="this.src='captcha_code?'+Math.random()" width="100" height="30" style="float:right"/>
													<label class="block clearfix" style="width:180px" float="left">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="验证码" id='yzm'/>
															<i class="icon-lock"></i>
														</span>
													</label>
													<!-- 验证码end -->
													
													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" class="ace" />
															<span class="lbl"> 记住密码</span>
														</label>

														<button type="button" class="width-35 pull-right btn btn-sm btn-primary" id='butt'>
															<i class="icon-key"></i>
															登录
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>

											<div class="social-or-login center">
												<span class="bigger-110">Or Login Using</span>
											</div>

											<div class="social-login center">
												<a class="btn btn-primary">
													<i class="icon-facebook"></i>
												</a>

												<a class="btn btn-info">
													<i class="icon-twitter"></i>
												</a>

												<a class="btn btn-danger">
													<i class="icon-google-plus"></i>
												</a>
											</div>
										</div><!-- /widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
													<i class="icon-arrow-left"></i>
													找回密码
												</a>
											</div>

											
										</div>
									</div><!-- /widget-body -->
								</div><!-- /login-box -->
					<!-- 找回密码 -->
								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="icon-key"></i>
												找回密码
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
											</p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="email" class="form-control" placeholder="Email" />
															<i class="icon-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="button" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="icon-lightbulb"></i>
															Send Me!
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /widget-main -->

										<div class="toolbar center">
											<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
												返回登录
												<i class="icon-arrow-right"></i>
											</a>
										</div>
									</div><!-- /widget-body -->
								</div><!-- /forgot-box -->

								
							</div><!-- /position-relative -->
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->


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
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			function show_box(id) {
			 jQuery('.widget-box.visible').removeClass('visible');
			 jQuery('#'+id).addClass('visible');
			}
		</script>
</body>
</html>
<script type="text/javascript">
	$("#butt").click(function(){
		// alert(1);
		var _token = $("#_token").val();
		// alert(_token);
		var accounts = $("#accounts").val();
		var password = $("#password").val();
		var yzm = $("#yzm").val();
		// alert(password);
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
		   type: "POST",
		   url: "{{url('login')}}",
		   data: "accounts="+accounts+"&password="+password+"&yzm="+yzm+"&_token="+_token,
		   success: function(msg){
		     // alert(msg);
		     if (msg==0) 
		     {
		     	location.href="{{url('index')}}"
		     }
		     else if (msg==1) 
		     {
		     	$("#div").html('密码错误');
		     }
		     else if (msg==2)
		     {
		     	$("#div").html('账号错误');
		     }
		     else
		     {
		     	$("#div").html('验证码错误');
		     }
		   }
		});
	})
</script>
