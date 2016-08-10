<div class="page-header">
    <h1>
        教学周期管理
        <small>
            <i class="icon-double-angle-right"></i>
            考试安排详情
        </small>
    </h1>
</div><!-- /.page-header -->
        <!-- PAGE CONTENT BEGINS -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <form class="form-horizontal" role="form" action="{{url('periodInfo')}}" method="get">
            <div id="div2">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1" >第教学周期</label>
                </div>
                <div class="space-4"></div>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1" ></label>
                    <div class="col-sm-9">

                    </div>
                </div>
                <div class="space-4"></div>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <input type="submit" value="修改" class="btn btn-success">
                        <input type="reset" value="重置" class="btn btn-success">
                    </div>
                </div>
            </div>
        </form>
    </div><!-- /.col -->
</div><!-- /.row -->
<script>
    var start = {
        elem: '#start',
        format: 'YYYY/MM/DD',
        min: laydate.now(+1), //设定最小日期为当前日期
        max: laydate.now(+7), //最大日期
        istime: true,
        istoday: false,
        choose: function(datas){
            end.min = datas; //开始日选好后，重置结束日的最小日期
            end.start = datas //将结束日的初始值设定为开始日
        }
    };
    var end = {
        elem: '#end',
        format: 'YYYY/MM/DD',
        min: laydate.now(),
        max: '2099-06-16 23:59:59',
        istime: true,
        istoday: false,
    };
    laydate(start);
    laydate(end);
</script>