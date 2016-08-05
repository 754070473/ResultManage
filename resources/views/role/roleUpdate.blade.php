
<div class="page-header">
    <h1>
        角色管理
        <small>
            <i class="icon-double-angle-right"></i>
            角色名修改
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <form class="form-horizontal" role="form" action="roleupdates" method="post" onsubmit=" return fun()">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 角色名称 </label>

                <div class="col-sm-9">
                    <input type="text" value="{{$list[0]->role_name}}" name="role_name" id="form-field-1" placeholder="Rolename" class="col-xs-10 col-sm-5" /><font color="red"><span id="error"></span></font>
                    <input type="hidden" name="rid" value="{{$list[0]->rid}}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>

                <div class="col-sm-9">
                    @if($list[0]->status)
                    <input type="checkbox" name="status" value="1" checked="checked"/>启用
                        @else
                        <input type="checkbox" name="status" value="1"/>启用
                        @endif
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="icon-ok bigger-110"></i>
                        修改
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="button" onclick="backup()">
                        <i class="icon-undo bigger-110"></i>
                        返回
                    </button>
                </div>
            </div>
        </form>
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
    var sum = 1;
    function backup(){
        location.href="rolelist";
    }
    function fun(){
        if(sum){
            return false;
        }else{
            return true;
        }
    }
    jQuery("#form-field-1").blur(function(){
        var val = jQuery(this).val();
        jQuery.ajax({
            type: "GET",
            url: "roleadd",
            data: "role="+val,
            success: function(msg){
                if(msg.error==1){
                    jQuery("#error").html(msg.msg)
                    sum = 1;
                }else{
                    jQuery("#error").html(msg.msg)
                    sum = 0;
                }
            }
        });
    })
</script>
