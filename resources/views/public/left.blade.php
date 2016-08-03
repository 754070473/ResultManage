<div class="sidebar" id="sidebar">
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
                <i class="icon-signal"></i>
            </button>

            <button class="btn btn-info">
                <i class="icon-pencil"></i>
            </button>

            <button class="btn btn-warning">
                <i class="icon-group"></i>
            </button>

            <button class="btn btn-danger">
                <i class="icon-cogs"></i>
            </button>
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- #sidebar-shortcuts -->

    <ul class="nav nav-list">
        <li class="active">
            <a href="index">
                <i class="icon-dashboard"></i>
                <span class="menu-text"> 首页 </span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="icon-desktop"></i>
                <span class="menu-text"> 权限管理 </span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li>
                    <a href="elements.html">
                        <i class="icon-double-angle-right"></i>
                        权限添加
                    </a>
                </li>

                <li>
                    <a href="buttons.html">
                        <i class="icon-double-angle-right"></i>
                        权限列表
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="icon-list"></i>
                <span class="menu-text"> 管理员管理 </span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li>
                    <a href="tables.html">
                        <i class="icon-double-angle-right"></i>
                        管理员添加
                    </a>
                </li>

                <li>
                    <a href="jqgrid.html">
                        <i class="icon-double-angle-right"></i>
                        管理员列表
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="icon-edit"></i>
                <span class="menu-text"> 角色管理 </span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li>
                    <a href="form-elements.html">
                        <i class="icon-double-angle-right"></i>
                        角色添加
                    </a>
                </li>
                <li>
                    <a href="form-wizard.html">
                        <i class="icon-double-angle-right"></i>
                        角色列表
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="icon-list-alt"></i>
                <span class="menu-text"> 成绩管理 </span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li>
                    <a href="form-elements.html">
                        <i class="icon-double-angle-right"></i>
                        成绩录入
                    </a>
                </li>
                <li>
                    <a href="form-wizard.html">
                        <i class="icon-double-angle-right"></i>
                        查看成绩
                    </a>
                </li>
                <li>
                    <a href="form-wizard.html">
                        <i class="icon-double-angle-right"></i>
                        成绩审核
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="icon-calendar"></i>
                <span class="menu-text"> 组建管理 </span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li>
                    <a href="form-elements.html">
                        <i class="icon-double-angle-right"></i>
                        创建学院
                    </a>
                </li>
                <li>
                    <a href="form-wizard.html">
                        <i class="icon-double-angle-right"></i>
                        创建班级
                    </a>
                </li>
                <li>
                    <a href="form-wizard.html">
                        <i class="icon-double-angle-right"></i>
                        创建小组
                    </a>
                </li>
                <li>
                    <a href="form-wizard.html">
                        <i class="icon-double-angle-right"></i>
                        组员录入
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="userlog">
                <i class="icon-user"></i>
                <span class="menu-text"> 管理员日志 </span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0)">
                <i class="icon-off"></i>
                <span class="menu-text"> 退出 </span>
            </a>
        </li>
    </ul><!-- /.nav-list -->

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>

    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        jQuery(function($){
            $('.dropdown-toggle').click(function(){
                var sub = $(this).next('.submenu');
                var open = sub.attr('class');
                if(open.indexOf('open') < 0) {
                    $('.open').slideUp('slow');
                    $('.open').attr("class", "submenu");
                    sub.slideDown('slow');
                    sub.attr("class", "submenu open");
                }else{
                    sub.slideUp('slow');
                    sub.attr("class", "submenu");
                }
            });
        });
    </script>
</div>