<link type="text/css" rel="stylesheet" 	href="css/powerFloat.css" />
<link type="text/css" rel="stylesheet" 	href="css/xmenu.css" />

<div class="page-header">
    <h1>
        角色管理
        <small>
            <i class="icon-double-angle-right"></i>
            角色赋权
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <div id="main">
            <div id="lead" class="card">
                <h3>角色赋权</h3>
                <p>
                <div class="topnav">
                    <a id="selectdept" href="javascript:void(0);" class="as">
                        <span>选择权限</span>
                    </a>

                </div>
                </p>
                <input type="hidden" value="<?php echo $number?>" id="selectdeptidden" />
                <input type="hidden" id="userid" value="<?php echo $rid ?>"/><br/>
                <h4>已有权限</h4>

                @foreach($give as $v)
                    {{$v->power_name}}
                    @endforeach
            </div>
        </div>
        <div id="m2" class="xmenu" style="display: none;">
            <div class="select-info">
                <label class="top-label">权限列表：</label>
                <ul>
                </ul>
                <a  name="menu-confirm" href="javascript:void(0);" class="a-btn">
                    <span class="a-btn-text" id="give">确定</span>
                </a>
            </div>
           <?php
                foreach($list as $k => $v){
            ?>
            <dl>
                <dt class="open"><?php echo $v['power_name']?></dt>
                <dd>
                    <ul>
                        <?php
                            foreach($v['son'] as $key => $val){
                        ?>
                        <li rel="<?php echo $val['pid']?>" class="<?php echo $val['fid']?>"><?php echo $val['power_name']?></li>
                        <?php
                        }
                        ?>
                    </ul>
                </dd>
            </dl>
           <?php
            }
            ?>
        </div>
        <div id="modal-form" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger">Please fill the following form fields</h4>
                    </div>

                    <div class="modal-body overflow-visible">
                        <div class="row">
                            <div class="col-xs-12 col-sm-5">
                                <div class="space"></div>

                                <input type="file" />
                            </div>

                            <div class="col-xs-12 col-sm-7">
                                <div class="form-group">
                                    <label for="form-field-select-3">Location</label>

                                    <div>
                                        <select class="chosen-select" data-placeholder="Choose a Country...">
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

                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label for="form-field-username">Username</label>

                                    <div>
                                        <input class="input-large" type="text" id="form-field-username" placeholder="Username" value="alexdoe" />
                                    </div>
                                </div>

                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label for="form-field-first">Name</label>

                                    <div>
                                        <input class="input-medium" type="text" id="form-field-first" placeholder="First Name" value="Alex" />
                                        <input class="input-medium" type="text" id="form-field-last" placeholder="Last Name" value="Doe" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-sm" data-dismiss="modal">
                            <i class="icon-remove"></i>
                            Cancel
                        </button>

                        <button class="btn btn-sm btn-primary">
                            <i class="icon-ok"></i>
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div><!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script type="text/javascript">
       $("#give").click(function(){
           var rid = $("#userid").val();
           var arr = $(".select-info").children("ul").children();
           var rel = '';
           var len = arr.length
           for(var i = 0 ; i < len ; i++){
               rel += ',' + arr.eq(i).attr('rel');
           }
           rel = rel.substr( 1 );
           $.ajax({
               type: "GET",
               url: "rolegives",
               data: "rel="+rel+"&rid="+rid,
               success: function(msg){
                       $("#list").html(msg)
               }
           });
       })
</script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/jquery-powerFloat-min.js"></script>
<script type="text/javascript" src="js/jquery-xmenu.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $(document).on('#selectdept','click',function(){
            $('#m2').css({'left': '300px', 'top': '200px'});
        })
    });
</script>