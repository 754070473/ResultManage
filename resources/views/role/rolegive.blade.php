<link href="src/ui-choose.css" rel="stylesheet" />
<style>
    .demo-box {
        width: 100%;
        padding: 20px;
        border: 5px solid #ccc;
        background: #fafafa;
    }
    .demo-table {
        border-collapse: collapse;
        width: 100%;
    }
    .demo-table caption {
        border-bottom: 1px dashed #ccc;
        height: 40px;
        margin-bottom: 20px;
        font: 18px/1.2 normal 'microsoft yahei';
    }
    .demo-table tr td {
        padding: 8px 10px;
        font: 16px/1.8 normal 'microsoft yahei';
        vertical-align: top;
    }
    .ui-input {
        vertical-align: top;
        height: 18px;
        font-size: 16px;
        line-height: 20px;
        border: 1px solid #aaa;
        padding: 6px 8px;
        border-radius: 3px;
    }
</style>

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
    <!-- PAGE CONTENT BEGINS -->
    <div class="demo-box">
        <input type="hidden" id="userid" value="<?php echo $rid ?>"/>
        <table class="demo-table">
            <caption>
                请选择权限
            </caption>
            <?php
            foreach($list as $k => $v){
            ?>
            <tr>
                <td>
                <td>
                    <select class="ui-choose" multiple="multiple">
                        @if( $v['sign'] == 1 )
                        <option value="<?php echo $v['pid']?>" selected="selected"><?php echo $v['power_name']?></option>
                        @else
                        <option value="<?php echo $v['pid']?>"><?php echo $v['power_name']?></option>
                        @endif
                    </select>
                </td>
                </td>
                <td>
                    <select class="ui-choose" multiple="multiple">
                        <?php
                        foreach($v['son'] as $key => $val){
                        ?>
                            @if( $val['sign'] == 1 )
                                <option value="<?php echo $val['pid']?>" selected="selected"><?php echo $val['power_name']?></option>
                            @else
                                <option value="<?php echo $val['pid']?>"><?php echo $val['power_name']?></option>
                            @endif
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
        <center><button class="btn btn-info click">赋权</button></center>
    </div>
</div><!-- /.row -->
<script src="src/ui-choose.js"></script>
<script>
    jQuery(function($){
        // 将所有.ui-choose实例化
        $('.ui-choose').ui_choose();

        // uc_01 ul 单选
        var uc_01 = $('.ui-choose').$(this).data('ui-choose');
        uc_01.click = function (index, item) {
            console.log('click', index, item.text())
        }
        uc_01.change = function (index, item) {
            console.log('change', index, item.text())
        }
    })
</script>