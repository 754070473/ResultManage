<!DOCTYPE html>
<html lang="en">
 <head> 
  <meta charset="utf-8" /> 
  <title>各院成材率</title>
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
       <li> <i class="icon-home home-icon"></i> <a href="#">首页</a> </li> 
       <li> <a href="#">成绩管理</a> </li>
       <li class="active">查看成绩</li>
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
       <h1> 成才率 <small> <i class="icon-double-angle-right"></i> 查看列表</small> </h1>
      </div>
      <!-- /.page-header --> 
      <div class="row"> 
       <div class="col-xs-12"> 
        <!-- PAGE CONTENT BEGINS --> 
        <div class="row"> 
         <div class="col-xs-12"> 
          <div class="table-responsive"> 
           <table id="sample-table-1" class="table table-striped table-bordered table-hover">
               @foreach($college as $k=>$val)
                       @foreach($val['xi'] as $k2=>$val2)
                           @if($val2['ser_id']==$ser_id)
                           <tr  class="xi_{{$val['cid']}}"  id="{{$val2['ser_id']}}"  onclick="clk2({{$val2['ser_id']}})">
                               <td  class="center">{{$val['college_name']}}---<a>{{$val2['ser_name']}}</a>---班级列表 </td>
                               <td  class="center"> {{$val2['theory']}} %</td>
                           </tr>
                           @foreach($val2['class'] as $k3=>$val3)
                               <tr  class="class_{{$val2['ser_id']}}" onclick="student({{$val3['class_id']}})">
                                   <td class="center" >{{$val3['class_name']}}</td>
                                   <td class="center"> {{$val3['theory']}} %</td>
                               </tr>
                               @if($k3==0)
                               <tr style="width:100%;display:none;"  id="student1_{{$val3['class_id']}}" class="none">
                                   <td class="center" colspan="2"><center><div id="student2_{{$val3['class_id']}}"></div></center></td>                                                                          </td>
                               </tr>
                                @endif
                           @endforeach
                           @endif
                       @endforeach

                   @endforeach
                  </table>

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
  <input type="hidden" id="token" value="{{ csrf_token() }}" />
  <script>
      var  _token = $("#token").val();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': _token
          }
      });
  </script>
  <script type="text/javascript">
// 树状图收缩

/**
 * 开启系
 * 关闭所有
 * @param a
 */
  function  clk(a){
      var  aa='xi_'+a;
    if($("."+aa).css('display')=='none'){
         $("."+aa).show(); //显示
    }else{
        var ace2 = $('.'+aa);
        var len = ace2.length;
        if( len >0 ) {
            for (var i = 0; i < len; i++) {
                    $(".class_" +ace2.eq(i).attr('id') ).hide();
            }
        }
            $("."+aa).hide(); //隐藏
            $('.none').hide()
    }

  }
function  clk2(a){
    var  aa='class_'+a;
    if($("."+aa).css('display')=='none'){
        $("."+aa).show(); //显示
    }else{
        $('.none').hide()
        $("."+aa).hide(); //隐藏
    }
}

function  student(a){
    var  aa='student1_'+a;
    if($("#"+aa).css('display')=='none'){
        $.ajax({
            type: 'post',
            url: 'ajaxStudent',
            data: 'class_id=' + a,
            success: function (msg) {
                if(msg!=0){
                    $("#student2_"+a).html(msg);
                    $("#"+aa).show(); //显示
                }
            }
        });
    }else{
        $("."+aa).hide(); //隐藏
        $('.none').hide();
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
        $("#hide").click(function(){
            $("p").hide();
        });

        $(".show_list").click(function(){
            $("p").show();
        });
		</script> 
  <div style="display:none">
   <!-- <script src="http://v7.cnzz.com/stat.php?id=155540&amp;web_id=155540" language="JavaScript" charset="gb2312"></script> -->
  </div>   
 </body>
</html>