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
  <link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.custom.min.css" /> 
  <link rel="stylesheet" href="assets/css/chosen.css" /> 
  <link rel="stylesheet" href="assets/css/datepicker.css" /> 
  <link rel="stylesheet" href="assets/css/bootstrap-timepicker.css" /> 
  <link rel="stylesheet" href="assets/css/daterangepicker.css" /> 
  <link rel="stylesheet" href="assets/css/colorpicker.css" /> 
  <!-- fonts --> 
<!--   <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />  -->
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
    <a class="menu-toggler" id="menu-toggler" href="#"> <span class="menu-text"></span> </a> 

    <div class="main-content"> 
     <div class="breadcrumbs" id="breadcrumbs"> 
      <script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script> 
      <ul class="breadcrumb"> 
       <li> <i class="icon-home home-icon"></i> <a href="#">首页</a> </li> 
       <li> <a href="#">权限管理</a> </li> 
       <li class="active">添加权限</li> 
      </ul>
      <!-- .breadcrumb --> 
      <div class="nav-search" id="nav-search"> 
       <form class="form-search"> 
        <span class="input-icon"> <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" /> <i class="icon-search nav-search-icon"></i> </span> 
       </form> 
      </div>
      <!-- #nav-search --> 
     </div> 
     <div class="page-content"> 
      <div class="page-header"> 
       <h1> 权限管理 <small> <i class="icon-double-angle-right"></i> 添加权限 </small> </h1> 
      </div>
      <!-- /.page-header --> 
      <div class="row"> 
       <div class="col-xs-12"> 
        <!-- PAGE CONTENT BEGINS --> 
        <form class="form-horizontal" id="poweradd" role="form" method="post"> 
                 <div class="form-group">
    <label class="col-sm-3 control-label">父权限</label>
    <div class="col-sm-4">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <select id="fid" name="fid" class="selectpicker show-tick form-control"  data-live-search="false">
            <option value="0">请选择</option>
        @foreach($access as $v)
            <option value="{{$v['pid']}}">{{$v['power_name']}}</option>
            @foreach($v['son'] as $val)
            	<option value="{{$val['pid']}}">&nbsp;&nbsp;&nbsp;&nbsp;{{$val['power_name']}}</option>
            @endforeach
        @endforeach
        </select>
    </div>
</div>
         <div class="space-4"></div> 
         <div class="form-group"> 
          <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 控制器名 </label> 
          <div class="col-sm-9"> 
           <input type="text" name="controller" id="controller"  placeholder="controller" class="col-xs-10 col-sm-5" /> 
           <span id="s_controller"></span>
          </div> 
         </div> 
         <div class="space-4"></div> 
         <div class="form-group"> 
          <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 方法名 </label> 
          <div class="col-sm-9"> 
           <input type="text" name="action" id="action" placeholder="action" class="col-xs-10 col-sm-5" />
           <span id="s_action"></span> 
          </div> 
         </div> 
         <div class="space-4"></div> 
         <div class="form-group"> 
          <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 权限名 </label> 
          <div class="col-sm-9"> 
           <input type="text" name="power_name" id="power_name" placeholder="name" class="col-xs-10 col-sm-5" /> 
           <span id="s_name"></span>
          </div> 
         </div> 
         <div class="space-4"></div> 
		         <div class="form-group"> 
          <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 是否显示</label> 
           <div class="col-xs-3">
			<label>
			<input class="ace ace-switch ace-switch-4" type="checkbox" name="is_show">
			<span class="lbl"></span>
			</label>
          </div> 
         <div class="space-4"></div> 

      
         <div class="clearfix form-actions"> 
          <div class="col-md-offset-3 col-md-9"> 
           <button class="btn btn-info" type="submit"> <i class="icon-ok bigger-110"></i> 添加 </button> &nbsp; &nbsp; &nbsp; 
           <button class="btn" type="reset"> <i class="icon-undo bigger-110"></i> 取消 </button> 
          </div> 
         </div> 
</form>
         <div class="hr hr-24"></div> 
         
         <div class="space-24"></div> 
        
   
   </div>
   <!-- /.main-container-inner --> 
   <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> 
  </div>
  <!-- /.main-container --> 
  <!-- basic scripts --> 
  <!--[if !IE]> --> 
  <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>  -->
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
  <script src="assets/js/bootstrap.min.js"></script> 
  <script src="assets/js/typeahead-bs2.min.js"></script> 
  <!-- page specific plugin scripts --> 
  <!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]--> 
  <script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script> 
  <script src="assets/js/jquery.ui.touch-punch.min.js"></script> 
  <script src="assets/js/chosen.jquery.min.js"></script> 
  <script src="assets/js/fuelux/fuelux.spinner.min.js"></script> 
  <script src="assets/js/date-time/bootstrap-datepicker.min.js"></script> 
  <script src="assets/js/date-time/bootstrap-timepicker.min.js"></script> 
  <script src="assets/js/date-time/moment.min.js"></script> 
  <script src="assets/js/date-time/daterangepicker.min.js"></script> 
  <script src="assets/js/bootstrap-colorpicker.min.js"></script> 
  <script src="assets/js/jquery.knob.min.js"></script> 
  <script src="assets/js/jquery.autosize.min.js"></script> 
  <script src="assets/js/jquery.inputlimiter.1.3.1.min.js"></script> 
  <script src="assets/js/jquery.maskedinput.min.js"></script> 
  <script src="assets/js/bootstrap-tag.min.js"></script> 
  <!-- ace scripts --> 
  <script src="assets/js/ace-elements.min.js"></script> 
  <script src="assets/js/ace.min.js"></script> 
  <!-- inline scripts related to this page --> 
  <script type="text/javascript">
  jQuery("#fid").change(function () {
  	var val=jQuery(this).val();
  	jQuery.ajax({
  		url:"{{url('getcont')}}",
  		data:"id="+val,
  		type:"GET",
  		success:function (msg) {
  			jQuery('#controller').val(msg);
  		}
  	})
  })
  // 验证控制器
  jQuery("#controller").blur(function () {
  		checkcontroller();
  })
  function checkcontroller() {
  		var value=$("#controller").val();
  		if(value==''){
  			$("#s_controller").html('<font color="red">控制器不能为空</font>');
  			return false;
  		}else{
  			var reg=/^[a-z]{4,16}$/i;
  			if(!reg.test(value)){
  				$("#s_controller").html('<font color="red">控制器只能由4-32位字母组成</font>');
  				return false;
  			}else{
  				$("#s_controller").html('<font color="red">可以使用</font>');
  				return true;
  			}
  		}
  }
    // 验证方法名
  jQuery("#action").blur(function () {
  		checkaction();
  })
  				var flag1=false;
  function checkaction() {
      var value=$("#action").val();
      if(value==''){
        $("#s_action").html('<font color="red">方法名不能为空</font>');
      }else{
        var reg=/^[a-z]{4,16}$/i;
        if(!reg.test(value)){
          $("#s_action").html('<font color="red">方法名只能由4-32位字母组成</font>');
        }else{
  				$.ajax({
				   type: "GET",
				   url: "ajaxone",
				   data: "value="+value+"&name=action",
				   success: function(msg){
				      if(msg=='1'){
				      	$("#s_action").html('<font color="red">此方法已存在</font>');
				      }else{
				      	$("#s_action").html('<font color="red">可以使用</font>');
				      	flag1=true;
				      }
				   }
				});  				
        }
      }
  				return flag1;
  }
  // 验证权限名称
  jQuery("#power_name").blur(function () {
  		checkpower_name();
  })
  		var flag2=false;
  function checkpower_name() {
      var value=$("#power_name").val();
      if(value==''){
        $("#s_name").html('<font color="red">权限名称不能为空</font>');
      }else{
        var reg=/^[\u4E00-\u9FA5]{2,10}$/;
        if(!reg.test(value)){
          $("#s_name").html('<font color="red">权限名称只能为2-10位汉字</font>');
        }else{
    				$.ajax({
  				   type: "GET",
  				   url: "ajaxone",
  				   data: "value="+value+"&name=power_name",
  				   success: function(msg){
  				     if(msg=='1'){
  				      	$("#s_name").html('<font color="red">此权限名称已存在</font>');
  				      	
  				      }else{
  				      	flag2=true;
                  $("#s_name").html('<font color="red">可以使用</font>');
  				      }
  				   }
  				});
  			}
  		}
          return flag2;
  }

  	jQuery("#poweradd").submit(function() {
      // alert(checkpower_name());
      // alert(checkaction());
		if(checkcontroller()&checkaction()&checkpower_name()){
			return true;
		}else{
			return false;
		}
	})
  </script>
  <script type="text/javascript">
   jQuery(function($){
        $.get("{{URL::to('top')}}",function(m){
            $('.main-container').first().before(m);
        })
    });
    jQuery(function($){
        $.get("{{URL::to('left')}}",function(m){
            $('.main-content').first().before(m);
        })
    });
			jQuery(function($) {
				$('#id-disable-check').on('click', function() {
					var inp = $('#form-input-readonly').get(0);
					if(inp.hasAttribute('disabled')) {
						inp.setAttribute('readonly' , 'true');
						inp.removeAttribute('disabled');
						inp.value="This text field is readonly!";
					}
					else {
						inp.setAttribute('disabled' , 'disabled');
						inp.removeAttribute('readonly');
						inp.value="This text field is disabled!";
					}
				});
			
			
				$(".chosen-select").chosen(); 
				$('#chosen-multiple-style').on('click', function(e){
					var target = $(e.target).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
					 else $('#form-field-select-4').removeClass('tag-input-style');
				});
			
			
				$('[data-rel=tooltip]').tooltip({container:'body'});
				$('[data-rel=popover]').popover({container:'body'});
				
				$('textarea[class*=autosize]').autosize({append: "\n"});
				$('textarea.limited').inputlimiter({
					remText: '%n character%s remaining...',
					limitText: 'max allowed : %n.'
				});
			
				$.mask.definitions['~']='[+-]';
				$('.input-mask-date').mask('99/99/9999');
				$('.input-mask-phone').mask('(999) 999-9999');
				$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
				$(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
			
			
			
				$( "#input-size-slider" ).css('width','200px').slider({
					value:1,
					range: "min",
					min: 1,
					max: 8,
					step: 1,
					slide: function( event, ui ) {
						var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
						var val = parseInt(ui.value);
						$('#form-field-4').attr('class', sizing[val]).val('.'+sizing[val]);
					}
				});
			
				$( "#input-span-slider" ).slider({
					value:1,
					range: "min",
					min: 1,
					max: 12,
					step: 1,
					slide: function( event, ui ) {
						var val = parseInt(ui.value);
						$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
					}
				});
				
				
				$( "#slider-range" ).css('height','200px').slider({
					orientation: "vertical",
					range: true,
					min: 0,
					max: 100,
					values: [ 17, 67 ],
					slide: function( event, ui ) {
						var val = ui.values[$(ui.handle).index()-1]+"";
			
						if(! ui.handle.firstChild ) {
							$(ui.handle).append("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>");
						}
						$(ui.handle.firstChild).show().children().eq(1).text(val);
					}
				}).find('a').on('blur', function(){
					$(this.firstChild).hide();
				});
				
				$( "#slider-range-max" ).slider({
					range: "max",
					min: 1,
					max: 10,
					value: 2
				});
				
				$( "#eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
					// read initial values from markup and remove that
					var value = parseInt( $( this ).text(), 10 );
					$( this ).empty().slider({
						value: value,
						range: "min",
						animate: true
						
					});
				});
			
				
				$('#id-input-file-1 , #id-input-file-2').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false //| true | large
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				});
				
				$('#id-input-file-3').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'icon-cloud-upload',
					droppable:true,
					thumbnail:'small'//large | fit
					//,icon_remove:null//set null, to hide remove/reset button
					/**,before_change:function(files, dropped) {
						//Check an example below
						//or examples/file-upload.html
						return true;
					}*/
					/**,before_remove : function() {
						return true;
					}*/
					,
					preview_error : function(filename, error_code) {
						//name of the file that failed
						//error_code values
						//1 = 'FILE_LOAD_FAILED',
						//2 = 'IMAGE_LOAD_FAILED',
						//3 = 'THUMBNAIL_FAILED'
						//alert(error_code);
					}
			
				}).on('change', function(){
					//console.log($(this).data('ace_input_files'));
					//console.log($(this).data('ace_input_method'));
				});
				
			
				//dynamically change allowed formats by changing before_change callback function
				$('#id-file-format').removeAttr('checked').on('change', function() {
					var before_change
					var btn_choose
					var no_icon
					if(this.checked) {
						btn_choose = "Drop images here or click to choose";
						no_icon = "icon-picture";
						before_change = function(files, dropped) {
							var allowed_files = [];
							for(var i = 0 ; i < files.length; i++) {
								var file = files[i];
								if(typeof file === "string") {
									//IE8 and browsers that don't support File Object
									if(! (/\.(jpe?g|png|gif|bmp)$/i).test(file) ) return false;
								}
								else {
									var type = $.trim(file.type);
									if( ( type.length > 0 && ! (/^image\/(jpe?g|png|gif|bmp)$/i).test(type) )
											|| ( type.length == 0 && ! (/\.(jpe?g|png|gif|bmp)$/i).test(file.name) )//for android's default browser which gives an empty string for file.type
										) continue;//not an image so don't keep this file
								}
								
								allowed_files.push(file);
							}
							if(allowed_files.length == 0) return false;
			
							return allowed_files;
						}
					}
					else {
						btn_choose = "Drop files here or click to choose";
						no_icon = "icon-cloud-upload";
						before_change = function(files, dropped) {
							return files;
						}
					}
					var file_input = $('#id-input-file-3');
					file_input.ace_file_input('update_settings', {'before_change':before_change, 'btn_choose': btn_choose, 'no_icon':no_icon})
					file_input.ace_file_input('reset_input');
				});
			
			
			
			
				$('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
				.on('change', function(){
					//alert(this.value)
				});
				$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'icon-caret-up', icon_down:'icon-caret-down'});
				$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'icon-plus smaller-75', icon_down:'icon-minus smaller-75', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
			
			
				
				$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				$('input[name=date-range-picker]').daterangepicker().prev().on(ace.click_event, function(){
					$(this).next().focus();
				});
				
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				$('#colorpicker1').colorpicker();
				$('#simple-colorpicker-1').ace_colorpicker();
			
				
				$(".knob").knob();
				
				
				//we could just set the data-provide="tag" of the element inside HTML, but IE8 fails!
				var tag_input = $('#form-field-tags');
				if(! ( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase())) ) 
				{
					tag_input.tag(
					  {
						placeholder:tag_input.attr('placeholder'),
						//enable typeahead by specifying the source array
						source: ace.variable_US_STATES,//defined in ace.js >> ace.enable_search_ahead
					  }
					);
				}
				else {
					//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
					tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
					//$('#form-field-tags').autosize({append: "\n"});
				}
				
				
				
			
				/////////
				$('#modal-form input[type=file]').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'icon-cloud-upload',
					droppable:true,
					thumbnail:'large'
				})
				
				//chosen plugin inside a modal will have a zero width because the select element is originally hidden
				//and its width cannot be determined.
				//so we set the width after modal is show
				$('#modal-form').on('shown.bs.modal', function () {
					$(this).find('.chosen-container').each(function(){
						$(this).find('a:first-child').css('width' , '210px');
						$(this).find('.chosen-drop').css('width' , '210px');
						$(this).find('.chosen-search input').css('width' , '200px');
					});
				})
				/**
				//or you can activate the chosen plugin after modal is shown
				//this way select element becomes visible with dimensions and chosen works as expected
				$('#modal-form').on('shown', function () {
					$(this).find('.modal-chosen').chosen();
				})
				*/
			
			});
		</script> 
  <div style="display:none">
   <!-- <script src="http://v7.cnzz.com/stat.php?id=155540&amp;web_id=155540" language="JavaScript" charset="gb2312"></script> -->
  </div>   
 </body>
</html>