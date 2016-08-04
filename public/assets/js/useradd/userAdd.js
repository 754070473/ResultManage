/**
 * Created by Administrator on 2016/8/3 0003.
 */

/**
 * 下拉菜单样式
 */
jQuery(function ($) {
    $("#submit").click(function () {
      var  name = $("#name").val();
      var  pwd = $("#pwd").val();
      var  usertype = $("#usertype").val();
      var  accounts = $("#accounts").val();
        /*
        jquery验证
        */
        $.post(
            "/useraddpro",
            {
                username:name,
                usertype:usertype
            },
            function (msg) {
              if( 'false' == msg){
               var html =   $( '#inser_show').html()
                if(html==""){
                    $( '#inser_show').html(
                        '<tr>' +
                        '<td>' +
                        '未能创建成功' +
                        '</td>' +
                        '</tr>'
                    )

                }else{
                    $( '#inser_show tr:first').before(
                        '<tr>' +
                        '<td>' +
                        '未能创建成功' +
                        '</td>' +
                        '</tr>'
                    )

                }
              }else{
                  $('#table_show').attr('display','block')
                  var html =   $( '#inser_show').html()
                  if(html==""){
                      $( '#inser_show').html(
                          '<tr>' +
                          '<td>' +
                          msg +
                          '</td>' +
                          '</tr>'
                      )
                      $("#name").val('');

                  }else{
                      $( '#inser_show tr:first').before(
                          '<tr>' +
                          '<td>' +
                          msg +
                          '</td>' +
                          '</tr>'
                      )
                      $("#name").val('');

                  }
              }
        })
    })
})

