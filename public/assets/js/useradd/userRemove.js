jQuery(function () {
    show_page(1);
     token = $('#_token').val();
    $(document).on('click','#clk_page',function () {
        var t_page = $('#t_page').val();
        show_page(t_page)
    })



});
function show_page(page){
    $.ajax({
        type: "get",
        url: "/userListInfo",
        data: "page="+parseInt(page)+"&type=2",
        success: function(msg){
            var obj = eval("("+msg+")")
            var str='';
            $.each(obj['data'], function (n, value) {
               var i = value['uid'];
                str += "<tr class='update'  id='"+value['uid']+"'>";

                str += "<td ><input type='checkbox' class='ace2' value='"+value['uid']+"'/>&nbsp;&nbsp;&nbsp;"+(n+1)+"</td>";
                str += "<td class='up' ziduan='name' ><a href='javascript:void(0)'>"+value['username']+"</a></td>";
                str += "<td class='hidden-480' >";
                str += "<span class='label label-warning'>"+value['role_name']+"</span>";
                str += "</td>";
                str += "<td  ziduan='account'>"+value['accounts']+"</td>";
                str+="</tr>";
            });
            var html=$('.update').html();
            if(html!=""){
                $('.update').remove();
            }
            $('.thin-border-bottom tr:first').after(str);

            $('#page').html(
                "<input type='text' value='"+obj['dpage']+"' style='width: 50px;height:22px;' id='t_page'/>&nbsp;/"+obj['pageAll']+"<a href='javascript:void(0)' id='clk_page'>&nbsp;跳转</a>");

            //上一页下一页的隐藏与显示  4中情况
            //1第一页  下一页隐藏
            if(obj['disable'] == 'updisable'){
                $('#upbutton').css('display','none');
                $('#dnbutton').css('display','block');
            }

            //2最后一页  上一页隐藏
            if( obj['disable'] == 'dndisable' ){
                $('#dnbutton').css('display','none');
                $('#upbutton').css('display','block');
            }

            //没有数据  上一页  下一页都隐藏
            if(obj['disable'] == 'alldisable'){
                $('#dnbutton').css('display','none');
                $('#upbutton').css('display','none');
            }

            //正常  上一页  下一页  恢复显示
            if(obj['disable'] == 'normal'){
                $('#dnbutton').css('display','block');
                $('#upbutton').css('display','block');
            }
        }
    });
}

/**
 * 批量删除
 */
function ckDeleteAll()
{
    var ace2 = $('.ace2');
    var len = ace2.length;
    if( len >0 ){
        var search = jQuery('#search').val();
        if(!search){
            search = '';
        }
        var log_id = '';
        for( var i = 0 ; i < len ; i++ ){
            if( ace2.eq(i).prop( 'checked' ) == true ){
                log_id += ','+ace2.eq(i).val();
            }
        }
        log_id = log_id.substr(1);
            $.ajax({
                type: 'get',
                url: '/logDelete',
                data: 'id=' + log_id,
                success: function (msg) {
                    if (msg != 0) {
                        var t_page = $('#t_page').val();
                        show_page(t_page)
                    } else {

                    }
                }
            });
    }
}


/**
 * 批量还原
 */
function userRestore()
{
    var ace2 = $('.ace2');
    var len = ace2.length;
    if( len >0 ){
        var search = jQuery('#search').val();
        if(!search){
            search = '';
        }
        var log_id = '';
        for( var i = 0 ; i < len ; i++ ){
            if( ace2.eq(i).prop( 'checked' ) == true ){
                log_id += ','+ace2.eq(i).val();
            }
        }
        log_id = log_id.substr(1);
        $.ajax({
            type: 'get',
            url: '/userRestore',
            data: 'id=' + log_id+"&type=1",
            success: function (msg) {
                if (msg != 0) {
                    var t_page = $('#t_page').val();
                    show_page(t_page)
                } else {

                }
            }
        });
    }
}