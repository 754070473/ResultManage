<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>八维成绩管理系统 - 管理员日志</title>
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
							<li class="active">管理员日志</li>
						</ul><!-- .breadcrumb -->
							<div style="float:right;">
								<input class="laydate-icon" id="search" onclick="laydate()" placeholder="点击选择日期">
								<button class="btn btn-xs" onclick="ckPage( 'logPage' , 1 )">
									搜索
								</button>
							</div>
					</div>
                    <button class="btn btn btn-block" style="width:150px;float:right;margin-right: 700px;margin-top: 3px" onclick="ckDeleteAll()">批量删除</button>
					<div class="page-content"  id="list">
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
																<input type="checkbox" class="ace ace1" />
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
                                                @if(!empty($arr))
                                                @foreach( $arr as $key => $val )
													<tr id="tr{{$val->log_id}}">
														<td class="center">
															<label>
																<input type="checkbox" class="ace ace2" value="{{$val->log_id}}"/>
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
				
				//ajax删除
				$(document).on('click','.btn-danger',function(){
                    var search = jQuery('#search').val();
                    if(!search){
                        search = '';
                    }
                    var log_id = $(this).attr('logid');
					var p = $('.current a').html();
                    if( search == '' ) {
                        $.ajax({
                            type: 'GET',
                            url: 'logDelete',
                            data: 'log_id=' + log_id + '&p=' + p,
                            success: function (msg) {
                                if (msg != 0) {
                                    $('#list').html(msg);
                                } else {
                                    alert('删除失败');
                                }
                            }
                        });
                    }else{
                        $.ajax({
                            type: 'GET',
                            url: 'logDelete',
                            data: 'log_id=' + log_id + '&p=' + p +'&search='+search,
                            success: function (msg) {
                                if (msg != 0) {
                                    $('#list').html(msg);
                                } else {
                                    alert('删除失败');
                                }
                            }
                        });
                    }
                });
			});
			function ckDeleteAll()
			{
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
					if( search == '' ) {
                        $.ajax({
                            type: 'GET',
                            url: 'logDelete',
                            data: 'log_id=' + log_id,
                            success: function (msg) {
                                if (msg != 0) {
                                    $('#list').html(msg);
                                } else {
                                    alert('删除失败');
                                }
                            }
                        });
                    }else{
                        $.ajax({
                            type: 'GET',
                            url: 'logDelete',
                            data: 'log_id=' + log_id + '&search='+search,
                            success: function (msg) {
                                if (msg != 0) {
                                    $('#list').html(msg);
                                } else {
                                    alert('删除失败');
                                }
                            }
                        });
                    }
				}
			}
		</script>
</body>
</html>
