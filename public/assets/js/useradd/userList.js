jQuery(function () {
    show_page(1);
  //  $('#t_page').attr('value',1);
    $(document).on('click','#clk_page',function () {
        var t_page = $('#t_page').val();
        show_page(t_page)
    })

    //即点即改
    $(document).on('click','.up',function(){
        var td=$(this);
        var old_val=$(this).text();
        var id=$(this).parent().attr('id');
        var input=$("<input type='text'/>");
        $(this).html(input);
        input.focus().val($.trim(old_val));
        input.click(function(){
            return  false;
        });
        input.blur(function(){
            var new_val=$(this).val();
            var ziduan=$(this).parent().attr('ziduan');
            if(new_val!=old_val){
                $.ajax({
                    type: "POST",
                    url: "/userListUpdate",
                    data: "id="+id+"&value="+new_val+"&ziduan="+ziduan,
                    success: function(msg){
                        if(msg==1){
                            td.text(new_val);
                        }else{
                            td.text(old_val);
                        }
                    }
                });
            }else{
                td.text(old_val);
            }
        });
    });

});
function show_page(page){
    $.ajax({
        type: "get",
        url: "/userListInfo",
        data: "page="+parseInt(page),
        success: function(msg){
            var obj = eval("("+msg+")")
            var str='';

            $.each(obj['data'], function (n, value) {

                str += "<tr class='update'  id='"+value['uid']+"'>";

                str += "<td ><input type='checkbox' class='ace2' value='"+value['uid']+"'/>&nbsp;&nbsp;&nbsp;"+(n+1)+"</td>";
                str += "<td class='up' ziduan='name' ><a href='javascript:void(0)'>"+value['username']+"</a></td>";
                str += "<td class='hidden-480' >";
                str += "<span class='label label-warning'>"+value['role_name']+"</span>";
                str += "</td>";
                str += "<td  ziduan='account'>"+value['accounts']+"</td>";
                str += "<td >"+getLocalTime(value['add_date']);+"</td>";
                str+="</tr>";
            });
            var html=$('.update').html();
            if(html!=""){
                $('.update').remove();
            }
            $('.thin-border-bottom tr:first').after(str);

            //删除按钮
            $('#page').html(
                "<input type='text' value='"+obj['dpage']+"' style='width: 50px;height:22px;' id='t_page'/>&nbsp;/"+obj['pageAll']+"<a href='javascript:void(0)' id='clk_page'>&nbsp;跳转</a>"
            );

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
 * 批量放入回收站
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
                type: 'post',
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
 * 时间戳格式化为时间
 * @param nS
 * @returns {string}
 */
function getLocalTime(nS) {
    return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
}

