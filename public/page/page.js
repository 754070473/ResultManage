/**
 * Created by chenhao on 2016/6/15.
 */
function ck_page(p){
    var search = $('#search').val();
    if(search == "") {
        $.ajax({
            type: 'POST',
            data: 'p=' + p,
            success: function (msg) {
                $('#list').html(msg)
            }
        })
    }else{
        $.ajax({
            type: 'POST',
            data: 'p=' + p+'&search='+search,
            success: function (msg) {
                $('#list').html(msg);
                $('#search').val(search);
            }
        })
    }
}