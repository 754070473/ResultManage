<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>表单提示验证 - Bootstrap后台管理系统模版Ace下载</title>
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

    <link rel="stylesheet" href="assets/css/select2.css" />

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
                        <a href="#">Home</a>
                    </li>

                    <li>
                        <a href="#">Forms</a>
                    </li>
                    <li class="active">Wizard &amp; Validation</li>
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
                        成绩管理
                        <small>
                            <i class="icon-double-angle-right"></i>
                            成绩审核
                        </small>
                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->

                        <h4 class="lighter">
                            <i class="icon-hand-right icon-animated-hand-pointer blue"></i>
                            <a href="#modal-wizard" data-toggle="modal" class="pink">成绩表 </a>
                        </h4>

                        <div class="hr hr-18 hr-double dotted"></div>

                        <div class="row-fluid">
                            <div class="span12">
                                <div class="widget-box">
                                    <center>
                                        <table border="1">
                                            <th>成绩表ID</th>
                                            <th>理论成绩</th>
                                            <th>机试成绩</th>
                                            <th>添加日期</th>
                                            <th>添加时间</th>
                                            <th>身份</th>
                                            <th>类型</th>
                                            @foreach($arr as $v)
                                                <tr>
                                                    <td>{{$v->gid}}</td>
                                                    <td>{{$v->theory}}</td>
                                                    <td>{{$v->exam}}</td>
                                                    <td>{{$v->add_date}}</td>
                                                    <td>{{$v->add_time}}</td>
                                                    <td>
                                                        @if($v->status==1)
                                                            学生
                                                        @elseif($v->status==2)
                                                            组长
                                                        @elseif($v->status==3)
                                                            学委
                                                        @elseif($v->status==4)
                                                            讲师
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($v->type==1)
                                                            日考
                                                        @elseif($v->type==2)
                                                            周考
                                                        @elseif($v->type==3)
                                                            月考
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </center>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="step-content row-fluid position-relative" id="step-container">
                                                <div class="step-pane active" id="step1">

                                                    <form class="form-horizontal" id="sample-form">

                                                    </form>

                                                    <form class="form-horizontal hide" id="validation-form" method="get">
                                                        <div class="form-group">
                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Email Address:</label>

                                                            <div class="col-xs-12 col-sm-9">
                                                                <div class="clearfix">
                                                                    <input type="email" name="email" id="email" class="col-xs-12 col-sm-6" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="space-2"></div>

                                                        <div class="form-group">
                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password">Password:</label>

                                                            <div class="col-xs-12 col-sm-9">
                                                                <div class="clearfix">
                                                                    <input type="password" name="password" id="password" class="col-xs-12 col-sm-4" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="space-2"></div>

                                                        <div class="form-group">
                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password2">Confirm Password:</label>

                                                            <div class="col-xs-12 col-sm-9">
                                                                <div class="clearfix">
                                                                    <input type="password" name="password2" id="password2" class="col-xs-12 col-sm-4" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="hr hr-dotted"></div>

                                                        <div class="form-group">
                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="name">Company Name:</label>

                                                            <div class="col-xs-12 col-sm-9">
                                                                <div class="clearfix">
                                                                    <input type="text" id="name" name="name" class="col-xs-12 col-sm-5" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="space-2"></div>

                                                        <div class="form-group">
                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="phone">Phone Number:</label>

                                                            <div class="col-xs-12 col-sm-9">
                                                                <div class="input-group">
																			<span class="input-group-addon">
																				<i class="icon-phone"></i>
																			</span>

                                                                    <input type="tel" id="phone" name="phone" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="space-2"></div>

                                                        <div class="form-group">
                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="url">Company URL:</label>

                                                            <div class="col-xs-12 col-sm-9">
                                                                <div class="clearfix">
                                                                    <input type="url" id="url" name="url" class="col-xs-12 col-sm-8" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="hr hr-dotted"></div>

                                                        <div class="form-group">
                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">Subscribe to</label>

                                                            <div class="col-xs-12 col-sm-9">
                                                                <div>
                                                                    <label>
                                                                        <input name="subscription" value="1" type="checkbox" class="ace" />
                                                                        <span class="lbl"> Latest news and announcements</span>
                                                                    </label>
                                                                </div>

                                                                <div>
                                                                    <label>
                                                                        <input name="subscription" value="2" type="checkbox" class="ace" />
                                                                        <span class="lbl"> Product offers and discounts</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="space-2"></div>

                                                        <div class="form-group">
                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">Gender</label>

                                                            <div class="col-xs-12 col-sm-9">
                                                                <div>
                                                                    <label class="blue">
                                                                        <input name="gender" value="1" type="radio" class="ace" />
                                                                        <span class="lbl"> Male</span>
                                                                    </label>
                                                                </div>

                                                                <div>
                                                                    <label class="blue">
                                                                        <input name="gender" value="2" type="radio" class="ace" />
                                                                        <span class="lbl"> Female</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="hr hr-dotted"></div>

                                                        <div class="form-group">
                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="state">State</label>

                                                            <div class="col-xs-12 col-sm-9">
                                                                <select id="state" name="state" class="select2" data-placeholder="Click to Choose...">
                                                                    <option value="">&nbsp;</option>
                                                                    <option value="AL">Alabama</option>
                                                                    <option value="AK">Alaska</option>
                                                                    <option value="AZ">Arizona</option>
                                                                    <option value="AR">Arkansas</option>
                                                                    <option value="CA">California</option>
                                                                    <option value="CO">Colorado</option>
                                                                    <option value="CT">Connecticut</option>
                                                                    <option value="DE">Delaware</option>
                                                                    <option value="FL">Florida</option>
                                                                    <option value="GA">Georgia</option>
                                                                    <option value="HI">Hawaii</option>
                                                                    <option value="ID">Idaho</option>
                                                                    <option value="IL">Illinois</option>
                                                                    <option value="IN">Indiana</option>
                                                                    <option value="IA">Iowa</option>
                                                                    <option value="KS">Kansas</option>
                                                                    <option value="KY">Kentucky</option>
                                                                    <option value="LA">Louisiana</option>
                                                                    <option value="ME">Maine</option>
                                                                    <option value="MD">Maryland</option>
                                                                    <option value="MA">Massachusetts</option>
                                                                    <option value="MI">Michigan</option>
                                                                    <option value="MN">Minnesota</option>
                                                                    <option value="MS">Mississippi</option>
                                                                    <option value="MO">Missouri</option>
                                                                    <option value="MT">Montana</option>
                                                                    <option value="NE">Nebraska</option>
                                                                    <option value="NV">Nevada</option>
                                                                    <option value="NH">New Hampshire</option>
                                                                    <option value="NJ">New Jersey</option>
                                                                    <option value="NM">New Mexico</option>
                                                                    <option value="NY">New York</option>
                                                                    <option value="NC">North Carolina</option>
                                                                    <option value="ND">North Dakota</option>
                                                                    <option value="OH">Ohio</option>
                                                                    <option value="OK">Oklahoma</option>
                                                                    <option value="OR">Oregon</option>
                                                                    <option value="PA">Pennsylvania</option>
                                                                    <option value="RI">Rhode Island</option>
                                                                    <option value="SC">South Carolina</option>
                                                                    <option value="SD">South Dakota</option>
                                                                    <option value="TN">Tennessee</option>
                                                                    <option value="TX">Texas</option>
                                                                    <option value="UT">Utah</option>
                                                                    <option value="VT">Vermont</option>
                                                                    <option value="VA">Virginia</option>
                                                                    <option value="WA">Washington</option>
                                                                    <option value="WV">West Virginia</option>
                                                                    <option value="WI">Wisconsin</option>
                                                                    <option value="WY">Wyoming</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="space-2"></div>

                                                        <div class="form-group">
                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="platform">Platform</label>

                                                            <div class="col-xs-12 col-sm-9">
                                                                <div class="clearfix">
                                                                    <select class="input-medium" id="platform" name="platform">
                                                                        <option value="">------------------</option>
                                                                        <option value="linux">Linux</option>
                                                                        <option value="windows">Windows</option>
                                                                        <option value="mac">Mac OS</option>
                                                                        <option value="ios">iOS</option>
                                                                        <option value="android">Android</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="space-2"></div>

                                                        <div class="form-group">
                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="comment">Comment</label>

                                                            <div class="col-xs-12 col-sm-9">
                                                                <div class="clearfix">
                                                                    <textarea class="input-xlarge" name="comment" id="comment"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="space-8"></div>

                                                        <div class="form-group">
                                                            <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                                                <label>
                                                                    <input name="agree" id="agree" type="checkbox" class="ace" />
                                                                    <span class="lbl"> I accept the policy</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="step-pane" id="step2">
                                                    <div class="row-fluid">
                                                        <div class="alert alert-success">
                                                            <button type="button" class="close" data-dismiss="alert">
                                                                <i class="icon-remove"></i>
                                                            </button>

                                                            <strong>
                                                                <i class="icon-ok"></i>
                                                                Well done!
                                                            </strong>

                                                            You successfully read this important alert message.
                                                            <br />
                                                        </div>

                                                        <div class="alert alert-danger">
                                                            <button type="button" class="close" data-dismiss="alert">
                                                                <i class="icon-remove"></i>
                                                            </button>

                                                            <strong>
                                                                <i class="icon-remove"></i>
                                                                Oh snap!
                                                            </strong>

                                                            Change a few things up and try submitting again.
                                                            <br />
                                                        </div>

                                                        <div class="alert alert-warning">
                                                            <button type="button" class="close" data-dismiss="alert">
                                                                <i class="icon-remove"></i>
                                                            </button>
                                                            <strong>Warning!</strong>

                                                            Best check yo self, you're not looking too good.
                                                            <br />
                                                        </div>

                                                        <div class="alert alert-info">
                                                            <button type="button" class="close" data-dismiss="alert">
                                                                <i class="icon-remove"></i>
                                                            </button>
                                                            <strong>Heads up!</strong>

                                                            This alert needs your attention, but it's not super important.
                                                            <br />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="step-pane" id="step3">
                                                    <div class="center">
                                                        <h3 class="blue lighter">This is step 3</h3>
                                                    </div>
                                                </div>

                                                <div class="step-pane" id="step4">
                                                    <div class="center">
                                                        <h3 class="green">Congrats!</h3>
                                                        Your product is ready to ship! Click finish to continue!
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /widget-main -->
                                    </div><!-- /widget-body -->
                                </div>
                            </div>
                        </div>

                        <div id="modal-wizard" class="modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header" data-target="#modal-step-contents">
                                        <ul class="wizard-steps">
                                            <li data-target="#modal-step1" class="active">
                                                <span class="step">1</span>
                                                <span class="title">Validation states</span>
                                            </li>

                                            <li data-target="#modal-step2">
                                                <span class="step">2</span>
                                                <span class="title">Alerts</span>
                                            </li>

                                            <li data-target="#modal-step3">
                                                <span class="step">3</span>
                                                <span class="title">Payment Info</span>
                                            </li>

                                            <li data-target="#modal-step4">
                                                <span class="step">4</span>
                                                <span class="title">Other Info</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="modal-body step-content" id="modal-step-contents">
                                        <div class="step-pane active" id="modal-step1">
                                            <div class="center">
                                                <h4 class="blue">Step 1</h4>
                                            </div>
                                        </div>

                                        <div class="step-pane" id="modal-step2">
                                            <div class="center">
                                                <h4 class="blue">Step 2</h4>
                                            </div>
                                        </div>

                                        <div class="step-pane" id="modal-step3">
                                            <div class="center">
                                                <h4 class="blue">Step 3</h4>
                                            </div>
                                        </div>

                                        <div class="step-pane" id="modal-step4">
                                            <div class="center">
                                                <h4 class="blue">Step 4</h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer wizard-actions">
                                        <button class="btn btn-sm btn-prev">
                                            <i class="icon-arrow-left"></i>
                                            Prev
                                        </button>

                                        <button class="btn btn-success btn-sm btn-next" data-last="Finish ">
                                            Next
                                            <i class="icon-arrow-right icon-on-right"></i>
                                        </button>

                                        <button class="btn btn-danger btn-sm pull-left" data-dismiss="modal">
                                            <i class="icon-remove"></i>
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- PAGE CONTENT ENDS -->
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

<script src="assets/js/fuelux/fuelux.wizard.min.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/additional-methods.min.js"></script>
<script src="assets/js/bootbox.min.js"></script>
<script src="assets/js/jquery.maskedinput.min.js"></script>
<script src="assets/js/select2.min.js"></script>

<!-- ace scripts -->

<script src="assets/js/ace-elements.min.js"></script>
<script src="assets/js/ace.min.js"></script>

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

        $('[data-rel=tooltip]').tooltip();

        $(".select2").css('width','200px').select2({allowClear:true})
                .on('change', function(){
                    $(this).closest('form').validate().element($(this));
                });


        var $validation = false;
        $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
            if(info.step == 1 && $validation) {
                if(!$('#validation-form').valid()) return false;
            }
        }).on('finished', function(e) {
            bootbox.dialog({
                message: "Thank you! Your information was successfully saved!",
                buttons: {
                    "success" : {
                        "label" : "OK",
                        "className" : "btn-sm btn-primary"
                    }
                }
            });
        }).on('stepclick', function(e){
            //return false;//prevent clicking on steps
        });


        $('#skip-validation').removeAttr('checked').on('click', function(){
            $validation = this.checked;
            if(this.checked) {
                $('#sample-form').hide();
                $('#validation-form').removeClass('hide');
            }
            else {
                $('#validation-form').addClass('hide');
                $('#sample-form').show();
            }
        });



        //documentation : http://docs.jquery.com/Plugins/Validation/validate


        $.mask.definitions['~']='[+-]';
        $('#phone').mask('(999) 999-9999');

        jQuery.validator.addMethod("phone", function (value, element) {
            return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{4}( x\d{1,6})?$/.test(value);
        }, "Enter a valid phone number.");

        $('#validation-form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            rules: {
                email: {
                    required: true,
                    email:true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                password2: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                name: {
                    required: true
                },
                phone: {
                    required: true,
                    phone: 'required'
                },
                url: {
                    required: true,
                    url: true
                },
                comment: {
                    required: true
                },
                state: {
                    required: true
                },
                platform: {
                    required: true
                },
                subscription: {
                    required: true
                },
                gender: 'required',
                agree: 'required'
            },

            messages: {
                email: {
                    required: "Please provide a valid email.",
                    email: "Please provide a valid email."
                },
                password: {
                    required: "Please specify a password.",
                    minlength: "Please specify a secure password."
                },
                subscription: "Please choose at least one option",
                gender: "Please choose gender",
                agree: "Please accept our policy"
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                $('.alert-danger', $('.login-form')).show();
            },

            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },

            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error').addClass('has-info');
                $(e).remove();
            },

            errorPlacement: function (error, element) {
                if(element.is(':checkbox') || element.is(':radio')) {
                    var controls = element.closest('div[class*="col-"]');
                    if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
                    else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                }
                else if(element.is('.select2')) {
                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                }
                else if(element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                }
                else error.insertAfter(element.parent());
            },

            submitHandler: function (form) {
            },
            invalidHandler: function (form) {
            }
        });




        $('#modal-wizard .modal-header').ace_wizard();
        $('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');
    })
</script>
</body>
</html>
