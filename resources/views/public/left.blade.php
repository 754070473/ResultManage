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
        @foreach($access as $k=>$v)
        <li>
            <a href="javascript:void(0)" class="dropdown-toggle">
                <i class="{{$v['type']}}"></i>
                <span class="menu-text"> {{$v['power_name']}} </span>

                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                @foreach($v['son'] as $key=>$val)
                <li>
                    @if(isset($val['url']))
                        <a href="{{$val['url']}}">
                    @endif
                        <i class="icon-double-angle-right"></i>
                        {{$val['power_name']}}
                    </a>
                </li>
                @endforeach
            </ul>
        </li>
        @endforeach
        <li>
            <a href="{{url('exitProcess')}}">
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