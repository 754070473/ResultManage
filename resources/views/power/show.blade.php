<!DOCTYPE html>
<html lang="en">
 <head> 
  <meta charset="utf-8" /> 
  <title>Bootstrap表格插件 - Bootstrap后台管理系统模版Ace下载</title> 
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
    <a class="menu-toggler" id="menu-toggler" href="#"> <span class="menu-text"></span> </a> 

    <div class="main-content"> 
     <div class="breadcrumbs" id="breadcrumbs"> 
      <script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script> 
      <ul class="breadcrumb"> 
       <li> <i class="icon-home home-icon"></i> <a href="#">Home</a> </li> 
       <li> <a href="#">Tables</a> </li> 
       <li class="active">Simple &amp; Dynamic</li> 
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
       <h1> Tables <small> <i class="icon-double-angle-right"></i> Static &amp; Dynamic Tables </small> </h1> 
      </div>
      <!-- /.page-header --> 
      <div class="row"> 
       <div class="col-xs-12"> 
        <!-- PAGE CONTENT BEGINS --> 
        <div class="row"> 
         <div class="col-xs-12"> 
          <div class="table-responsive"> 
           <table id="sample-table-1" class="table table-striped table-bordered table-hover"> 
            <thead> 
             <tr> 
              <th class="center"> <label> <input type="checkbox" class="ace" /> <span class="lbl"></span> </label> </th> 
              <th></th>
              <th>权限名称</th> 
              <th>控制器</th> 
              <th class="hidden-480">方法</th> 
              <th>是否显示</th> 
              <th class="hidden-480">操作</th> 
             </tr> 
            </thead> 
            <tbody> 
            @foreach($access as $k=>$val)
             <tr  class="tree-folder-header" id="{{$val['pid']}}"> 
              <td class="center"> <input type="checkbox" class="ace check" s="{{$val['pid']}}"/> <span class="lbl"></span> </td> 
              <td class="center"> @if($val['son'])<label> <i onclick="func12({{$val['pid']}})"id="s_{{$val['pid']}}"   class="icon-plus"/></i> <span class="lbl"></span> </label>@endif </td> 
              <td class="up" ziduan="power_name">{{$val['power_name']}}</td> 
              <td class="up" ziduan="controller" class="hidden-480">{{$val['controller']}}</td> 
              <td class="up" ziduan="action">{{$val['action']}}</td> 
              <td class="hidden-480" id="status_{{$val['pid']}}" status="{{$val['status']}}">
              @if($val['status']==1)
              <span class="label label-sm label-success">显示</span>
              @else
              <span class="label label-sm label-warning">未显示</span>
              @endif
              </td> 
              <td> 
               <div class="visible-md visible-lg hidden-sm hidden-xs btn-group"> 
                <button class="btn btn-xs btn-danger delete" pid="{{$val['pid']}}"> <i class="icon-trash bigger-120"></i> </button> 
                <button class="btn btn-xs btn-info save"  pid="{{$val['pid']}}">
                <i class="icon-exchange"></i>
                </button>
               </div> 
               </div> </td>
               </tr>
             	@foreach($val['son'] as $value)
             
             <tr class="clk_{{$val['pid']}}" id="{{$value['pid']}}" style="display: none;"> 
              <td class="center">  <input type="checkbox" class="ace check" s="{{$value['pid']}}" /> <span class="lbl"> </td> 
              <td class="center"> <label>  <span class="lbl"></span> </label> </td> 
              <td class="up" ziduan="power_name">{{$value['power_name']}}</td> 
              <td class="up" ziduan="controller" class="hidden-480">{{$value['controller']}}</td> 
              <td class="up" ziduan="action">{{$value['action']}}</td> 
              <td class="hidden-480" id="status_{{$value['pid']}}" status="{{$value['status']}}">
              	@if($value['status']==1)
              <span class="label label-sm label-success">显示</span>
              @else
              <span class="label label-sm label-warning">未显示</span>
              @endif
              </td> 
              <td> 
               <div class="visible-md visible-lg hidden-sm hidden-xs btn-group"> 
                <button class="btn btn-xs btn-danger delete" pid="{{$value['pid']}}"> <i class="icon-trash bigger-120"></i> </button> 
                <button class="btn btn-xs btn-info save" pid="{{$value['pid']}}">
                <i class="icon-exchange"></i>
                </button>
               </div> 
            </td> 
             </tr>
            
             	@endforeach
             @endforeach 
            </tbody> 
           </table> 
           <input type="button" id="delall" value="批量删除">
          </div>
          <!-- /.table-responsive --> 
         </div>
         <!-- /span --> 
        </div>
        <!-- /row --> 

        <!-- PAGE CONTENT ENDS --> 
       </div>
       <!-- /.col --> 
      </div>
      <!-- /.row --> 
     </div>
     <!-- /.page-content --> 
    </div>
    <!-- /.main-content --> 
    <div class="ace-settings-container" id="ace-settings-container"> 
     <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn"> 
      <i class="icon-cog bigger-150"></i> 
     </div> 
     <div class="ace-settings-box" id="ace-settings-box"> 
      <div> 
       <div class="pull-left"> 
        <select id="skin-colorpicker" class="hide"> <option data-skin="default" value="#438EB9">#438EB9</option> <option data-skin="skin-1" value="#222A2D">#222A2D</option> <option data-skin="skin-2" value="#C6487E">#C6487E</option> <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option> </select> 
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
       <label class="lbl" for="ace-settings-add-container"> Inside <b>.container</b> </label> 
      </div> 
     </div> 
    </div>
    <!-- /#ace-settings-container --> 
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
  <script src="assets/js/jquery.dataTables.min.js"></script> 
  <script src="assets/js/jquery.dataTables.bootstrap.js"></script> 
  <!-- ace scripts --> 
  <script src="assets/js/ace-elements.min.js"></script> 
  <script src="assets/js/ace.min.js"></script> 
  <!-- inline scripts related to this page --> 
  <script type="text/javascript">
  	 //即点即改
    $(document).on('click','.up',function(){
        var td=$(this);
        var old_val=$(this).text();
        var id=$(this).parent().attr('id');
        var input=$("<input type='text' />");
        $(this).html(input);
        input.focus().val($.trim(old_val));
        input.click(function(){
            return  false;
        })
        input.blur(function(){
            var new_val=$(this).val();
            var ziduan=$(this).parent().attr('ziduan');
            if(new_val!=old_val){
                $.ajax({
                    type: "GET",
                    url: "{{url('uppower')}}",
                    data: "id="+id+"&value="+new_val+"&ziduan="+ziduan,
                    success: function(msg){
                        if(msg==1){
                            td.text(new_val);
                        }else{
                        	if(msg!=0){
                        		alert(msg);
                            td.text(old_val);
                        	}
                        	
                        }
                    }
                });
            }else{
                td.text(old_val);
            }
        });
    });
    // 节点删除
    $(".delete").click(function () {
    	var pid=$(this).attr('pid');
    	$.ajax({
          type: "GET",
          url: "{{url('depower')}}",
          data: "pid="+pid,
          success: function(msg){
              if(msg==1){
                  $("#"+pid).remove();
              }else{
                 alert(msg);
              }
          }
        });
    })
    // 修改状态 
    $(document).on('click','.save',function () {
     var pid=$(this).attr('pid');
     var status=$("#status_"+pid).attr("status");
     // alert(status);
     if(status==1){
      status=0;
     }else{
      status=1;
     }
      $.ajax({
          type: "GET",
          url: "{{url('savepower')}}",
          data: "pid="+pid+"&status="+status,
          success: function(msg){
              if(msg=="1"){
                  if(status==1){
                     $("#status_"+pid).html('<span class="label label-sm label-success">显示</span>');
                     $("#status_"+pid).attr("status",1);
                  }else{
                      $("#status_"+pid).html('<span class="label label-sm label-warning">未显示</span>');
                      $("#status_"+pid).attr("status",0);
                  }
              }else{
                
              }
          }
        });
    })
function ckAll()
{
    var ace2 = $('.check');
    var len = ace2.length;
        var log_id = '';
        for( var i = 0 ; i < len ; i++ ){
            if( ace2.eq(i).prop( 'checked' ) == true ){
                log_id += ','+ace2.eq(i).attr('s');
            }
        }
    log_id = log_id.substr(1);
    return log_id;
}
$("#delall").click(function () {
  var id=ckAll();
  if(id==''){
    alert('请选择');
    return false;
  }
  pid=id.split(',');
  for (var i = 0;i<pid.length ; i++) {
    var tr=$(".clk_"+pid[i]).html();
    if(tr!=undefined){
      alert('此权限下有子权限,不能删除');
      return false;
    }
  }
  $.ajax({
      type: "GET",
      url: "{{url('depower')}}",
      data: "pid="+id,
      success: function(msg){
          if(msg==1){
              for (var i = 0;i<pid.length ; i++) {
                  $("#"+pid[i]).remove();
                }
          }else{
             alert(msg);
          }
      }
  });
})
  </script>
  <script type="text/javascript">
// 树状图收缩
  function  func12(a){ 
      var  aa='clk_'+a;
    if($("."+aa).css('display')=='none'){
    	 $("#s_"+a).addClass("icon-minus");
    	 $("#s_"+a).removeClass("icon-plus");
         $("."+aa).show(); //显示  
    }else{
    	 $("#s_"+a).removeClass("icon-minus");
    	 $("#s_"+a).addClass("icon-plus");
    	 $("."+aa).hide(); //隐藏  
    }
     
      
  
  }
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
			})
		</script> 
  <div style="display:none">
   <!-- <script src="http://v7.cnzz.com/stat.php?id=155540&amp;web_id=155540" language="JavaScript" charset="gb2312"></script> -->
  </div>   
 </body>
</html>