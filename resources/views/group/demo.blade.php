<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<script src="jquery-2.1.4.min.js"></script>
<script src="demo.css"></script>
<div id="main"><a href="javascript:showBg();">点击这里查看效果</a>
<div id="fullbg"></div>
<div id="dialog">
<p class="close"><a href="#" onclick="closeBg();">关闭</a></p>
<div>正在加载，请稍后....</div>
</div>
</div> 

<script type="text/javascript">
//显示灰色 jQuery 遮罩层
function showBg() {
var bh = $("body").height();
var bw = $("body").width();
$("#fullbg").css({
height:bh,
width:bw,
display:"block"
});
$("#dialog").show();
}
//关闭灰色 jQuery 遮罩
function closeBg() {
$("#fullbg,#dialog").hide();
}
</script>
</body>
</html>
