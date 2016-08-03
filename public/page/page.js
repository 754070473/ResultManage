/**
 * Created by chenhao on 2016/6/15.
 */
function ckPage(url,p){
    var search = jQuery('#search').val();
    if(!search){
        search = '';
    }
    if(search == "") {
        jQuery.ajax({
            type: 'GET',
            data: 'p=' + p,
            url : url,
            success: function (msg) {
                jQuery('#list').html(msg)
            }
        })
    }else{
        jQuery.ajax({
            type: 'GET',
            data: 'p=' + p+'&search='+search,
            success: function (msg) {
                jQuery('#list').html(msg);
                jQuery('#search').val(search);
            }
        })
    }
}