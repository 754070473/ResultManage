/*
 * X-Menu 下拉框多选组件
 * 依赖jquery.powerFloat.js 
 * 整合powerFloat
 * 浏览器支持 FF Chrome Opera IE9 IE8一下不兼容
 * @author yelingfeng
 * @email  yelingfeng521@gmail.com 
 */
 jQuery(document).ready(function($) {
		var sh_languages = {};function sh_isEmailAddress(a){return/^mailto:/.test(a)?!1:a.indexOf("@")!==-1}function sh_setHref(a,b,c){var d=c.substring(a[b-2].pos,a[b-1].pos);d.length>=2&&d.charAt(0)==="<"&&d.charAt(d.length-1)===">"&&(d=d.substr(1,d.length-2)),sh_isEmailAddress(d)&&(d="mailto:"+d),a[b-2].node.href=d}function sh_konquerorExec(a){var b=[""];return b.index=a.length,b.input=a,b}function sh_highlightString(a,b){if(/Konqueror/.test(navigator.userAgent)&&!b.konquered){for(var c=0;c<b.length;c++)for(var d=0;d<b[c].length;d++){var e=b[c][d][0];e.source==="$"&&(e.exec=sh_konquerorExec)}b.konquered=!0}var f=document.createElement("a"),g=document.createElement("span"),h=[],i=0,j=[],k=0,l=null,m=function(b,c){var d=b.length;if(d===0)return;if(!c){var e=j.length;if(e!==0){var m=j[e-1];m[3]||(c=m[1])}}if(l!==c){l&&(h[i++]={pos:k},l==="sh_url"&&sh_setHref(h,i,a));if(c){var n;c==="sh_url"?n=f.cloneNode(!1):n=g.cloneNode(!1),n.className=c,h[i++]={node:n,pos:k}}}k+=d,l=c},n=/\r\n|\r|\n/g;n.lastIndex=0;var o=a.length;while(k<o){var p=k,q,r,s=n.exec(a);s===null?(q=o,r=o):(q=s.index,r=n.lastIndex);var t=a.substring(p,q),u=[];for(;;){var v=k-p,w,x=j.length;x===0?w=0:w=j[x-1][2];var y=b[w],z=y.length,A=u[w];A||(A=u[w]=[]);var B=null,C=-1;for(var D=0;D<z;D++){var E;if(D<A.length&&(A[D]===null||v<=A[D].index))E=A[D];else{var F=y[D][0];F.lastIndex=v,E=F.exec(t),A[D]=E}if(E!==null&&(B===null||E.index<B.index)){B=E,C=D;if(E.index===v)break}}if(B===null){m(t.substring(v),null);break}B.index>v&&m(t.substring(v,B.index),null);var G=y[C],H=G[1],I;if(H instanceof Array)for(var J=0;J<H.length;J++)I=B[J+1],m(I,H[J]);else I=B[0],m(I,H);switch(G[2]){case-1:break;case-2:j.pop();break;case-3:j.length=0;break;default:j.push(G)}}l&&(h[i++]={pos:k},l==="sh_url"&&sh_setHref(h,i,a),l=null),k=r}return h}function sh_getClasses(a){var b=[],c=a.className;if(c&&c.length>0){var d=c.split(" ");for(var e=0;e<d.length;e++)d[e].length>0&&b.push(d[e])}return b}function sh_addClass(a,b){var c=sh_getClasses(a);for(var d=0;d<c.length;d++)if(b.toLowerCase()===c[d].toLowerCase())return;c.push(b),a.className=c.join(" ")}function sh_extractTagsFromNodeList(a,b){var c=a.length;for(var d=0;d<c;d++){var e=a.item(d);switch(e.nodeType){case 1:if(e.nodeName.toLowerCase()==="br"){var f;/MSIE/.test(navigator.userAgent)?f="\r":f="\n",b.text.push(f),b.pos++}else b.tags.push({node:e.cloneNode(!1),pos:b.pos}),sh_extractTagsFromNodeList(e.childNodes,b),b.tags.push({pos:b.pos});break;case 3:case 4:b.text.push(e.data),b.pos+=e.length}}}function sh_extractTags(a,b){var c={};return c.text=[],c.tags=b,c.pos=0,sh_extractTagsFromNodeList(a.childNodes,c),c.text.join("")}function sh_mergeTags(a,b){var c=a.length;if(c===0)return b;var d=b.length;if(d===0)return a;var e=[],f=0,g=0;while(f<c&&g<d){var h=a[f],i=b[g];h.pos<=i.pos?(e.push(h),f++):(e.push(i),b[g+1].pos<=h.pos?(g++,e.push(b[g]),g++):(e.push({pos:h.pos}),b[g]={node:i.node.cloneNode(!1),pos:h.pos}))}while(f<c)e.push(a[f]),f++;while(g<d)e.push(b[g]),g++;return e}function sh_insertTags(a,b){var c=document,d=document.createDocumentFragment(),e=0,f=a.length,g=0,h=b.length,i=d;while(g<h||e<f){var j,k;e<f?(j=a[e],k=j.pos):k=h;if(k<=g){if(j.node){var l=j.node;i.appendChild(l),i=l}else i=i.parentNode;e++}else i.appendChild(c.createTextNode(b.substring(g,k))),g=k}return d}function sh_highlightElement(a,b){sh_addClass(a,"sh_sourceCode");var c=[],d=sh_extractTags(a,c),e=sh_highlightString(d,b),f=sh_mergeTags(c,e),g=sh_insertTags(f,d);while(a.hasChildNodes())a.removeChild(a.firstChild);a.appendChild(g)}function sh_getXMLHttpRequest(){if(window.ActiveXObject)return new ActiveXObject("Msxml2.XMLHTTP");if(window.XMLHttpRequest)return new XMLHttpRequest;throw"No XMLHttpRequest implementation available"}function sh_load(language,element,prefix,suffix){if(language in sh_requests){sh_requests[language].push(element);return}sh_requests[language]=[element];var request=sh_getXMLHttpRequest(),url=prefix+"sh_"+language+suffix;request.open("GET",url,!0),request.onreadystatechange=function(){if(request.readyState===4)try{if(!!request.status&&request.status!==200)throw"HTTP error: status "+request.status;eval(request.responseText);var elements=sh_requests[language];for(var i=0;i<elements.length;i++)sh_highlightElement(elements[i],sh_languages[language])}finally{request=null}},request.send(null)}function sh_highlightDocument(a,b){var c=document.getElementsByTagName("pre");for(var d=0;d<c.length;d++){var e=c.item(d),f=sh_getClasses(e);for(var g=0;g<f.length;g++){var h=f[g].toLowerCase();if(h==="sh_sourcecode")continue;if(h.substr(0,3)==="sh_"){var i=h.substring(3);if(i in sh_languages)sh_highlightElement(e,sh_languages[i]);else if(typeof a=="string"&&typeof b=="string")sh_load(i,e,a,b);else throw'Found <pre> element with class="'+h+'", but no such language exists';break}}}}var sh_requests={};sh_languages.javascript=[[[/\/\/\//g,"sh_comment",1],[/\/\//g,"sh_comment",7],[/\/\*\*/g,"sh_comment",8],[/\/\*/g,"sh_comment",9],[/\b(?:abstract|break|case|catch|class|const|continue|debugger|default|delete|do|else|enum|export|extends|false|final|finally|for|function|goto|if|implements|in|instanceof|interface|native|new|null|private|protected|prototype|public|return|static|super|switch|synchronized|throw|throws|this|transient|true|try|typeof|var|volatile|while|with)\b/g,"sh_keyword",-1],[/(\+\+|--|\)|\])(\s*)(\/=?(?![*\/]))/g,["sh_symbol","sh_normal","sh_symbol"],-1],[/(0x[A-Fa-f0-9]+|(?:[\d]*\.)?[\d]+(?:[eE][+-]?[\d]+)?)(\s*)(\/(?![*\/]))/g,["sh_number","sh_normal","sh_symbol"],-1],[/([A-Za-z$_][A-Za-z0-9$_]*\s*)(\/=?(?![*\/]))/g,["sh_normal","sh_symbol"],-1],[/\/(?:\\.|[^*\\\/])(?:\\.|[^\\\/])*\/[gim]*/g,"sh_regexp",-1],[/\b[+-]?(?:(?:0x[A-Fa-f0-9]+)|(?:(?:[\d]*\.)?[\d]+(?:[eE][+-]?[\d]+)?))u?(?:(?:int(?:8|16|32|64))|L)?\b/g,"sh_number",-1],[/"/g,"sh_string",10],[/'/g,"sh_string",11],[/~|!|%|\^|\*|\(|\)|-|\+|=|\[|\]|\\|:|;|,|\.|\/|\?|&|<|>|\|/g,"sh_symbol",-1],[/\{|\}/g,"sh_cbracket",-1],[/\b(?:Math|Infinity|NaN|undefined|arguments)\b/g,"sh_predef_var",-1],[/\b(?:Array|Boolean|Date|Error|EvalError|Function|Number|Object|RangeError|ReferenceError|RegExp|String|SyntaxError|TypeError|URIError|decodeURI|decodeURIComponent|encodeURI|encodeURIComponent|eval|isFinite|isNaN|parseFloat|parseInt)\b/g,"sh_predef_func",-1],[/\b(?:applicationCache|closed|Components|content|controllers|crypto|defaultStatus|dialogArguments|directories|document|frameElement|frames|fullScreen|globalStorage|history|innerHeight|innerWidth|length|location|locationbar|menubar|name|navigator|opener|outerHeight|outerWidth|pageXOffset|pageYOffset|parent|personalbar|pkcs11|returnValue|screen|availTop|availLeft|availHeight|availWidth|colorDepth|height|left|pixelDepth|top|width|screenX|screenY|scrollbars|scrollMaxX|scrollMaxY|scrollX|scrollY|self|sessionStorage|sidebar|status|statusbar|toolbar|top|window)\b/g,"sh_predef_var",-1],[/\b(?:alert|addEventListener|atob|back|blur|btoa|captureEvents|clearInterval|clearTimeout|close|confirm|dump|escape|find|focus|forward|getAttention|getComputedStyle|getSelection|home|moveBy|moveTo|open|openDialog|postMessage|print|prompt|releaseEvents|removeEventListener|resizeBy|resizeTo|scroll|scrollBy|scrollByLines|scrollByPages|scrollTo|setInterval|setTimeout|showModalDialog|sizeToContent|stop|unescape|updateCommands|onabort|onbeforeunload|onblur|onchange|onclick|onclose|oncontextmenu|ondragdrop|onerror|onfocus|onkeydown|onkeypress|onkeyup|onload|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onpaint|onreset|onresize|onscroll|onselect|onsubmit|onunload)\b/g,"sh_predef_func",-1],[/(?:[A-Za-z]|_)[A-Za-z0-9_]*(?=[ \t]*\()/g,"sh_function",-1]],[[/$/g,null,-2],[/(?:<?)[A-Za-z0-9_\.\/\-_~]+@[A-Za-z0-9_\.\/\-_~]+(?:>?)|(?:<?)[A-Za-z0-9_]+:\/\/[A-Za-z0-9_\.\/\-_~]+(?:>?)/g,"sh_url",-1],[/<\?xml/g,"sh_preproc",2,1],[/<!DOCTYPE/g,"sh_preproc",4,1],[/<!--/g,"sh_comment",5],[/<(?:\/)?[A-Za-z](?:[A-Za-z0-9_:.-]*)(?:\/)?>/g,"sh_keyword",-1],[/<(?:\/)?[A-Za-z](?:[A-Za-z0-9_:.-]*)/g,"sh_keyword",6,1],[/&(?:[A-Za-z0-9]+);/g,"sh_preproc",-1],[/<(?:\/)?[A-Za-z][A-Za-z0-9]*(?:\/)?>/g,"sh_keyword",-1],[/<(?:\/)?[A-Za-z][A-Za-z0-9]*/g,"sh_keyword",6,1],[/@[A-Za-z]+/g,"sh_type",-1],[/(?:TODO|FIXME|BUG)(?:[:]?)/g,"sh_todo",-1]],[[/\?>/g,"sh_preproc",-2],[/([^=" \t>]+)([ \t]*)(=?)/g,["sh_type","sh_normal","sh_symbol"],-1],[/"/g,"sh_string",3]],[[/\\(?:\\|")/g,null,-1],[/"/g,"sh_string",-2]],[[/>/g,"sh_preproc",-2],[/([^=" \t>]+)([ \t]*)(=?)/g,["sh_type","sh_normal","sh_symbol"],-1],[/"/g,"sh_string",3]],[[/-->/g,"sh_comment",-2],[/<!--/g,"sh_comment",5]],[[/(?:\/)?>/g,"sh_keyword",-2],[/([^=" \t>]+)([ \t]*)(=?)/g,["sh_type","sh_normal","sh_symbol"],-1],[/"/g,"sh_string",3]],[[/$/g,null,-2]],[[/\*\//g,"sh_comment",-2],[/(?:<?)[A-Za-z0-9_\.\/\-_~]+@[A-Za-z0-9_\.\/\-_~]+(?:>?)|(?:<?)[A-Za-z0-9_]+:\/\/[A-Za-z0-9_\.\/\-_~]+(?:>?)/g,"sh_url",-1],[/<\?xml/g,"sh_preproc",2,1],[/<!DOCTYPE/g,"sh_preproc",4,1],[/<!--/g,"sh_comment",5],[/<(?:\/)?[A-Za-z](?:[A-Za-z0-9_:.-]*)(?:\/)?>/g,"sh_keyword",-1],[/<(?:\/)?[A-Za-z](?:[A-Za-z0-9_:.-]*)/g,"sh_keyword",6,1],[/&(?:[A-Za-z0-9]+);/g,"sh_preproc",-1],[/<(?:\/)?[A-Za-z][A-Za-z0-9]*(?:\/)?>/g,"sh_keyword",-1],[/<(?:\/)?[A-Za-z][A-Za-z0-9]*/g,"sh_keyword",6,1],[/@[A-Za-z]+/g,"sh_type",-1],[/(?:TODO|FIXME|BUG)(?:[:]?)/g,"sh_todo",-1]],[[/\*\//g,"sh_comment",-2],[/(?:<?)[A-Za-z0-9_\.\/\-_~]+@[A-Za-z0-9_\.\/\-_~]+(?:>?)|(?:<?)[A-Za-z0-9_]+:\/\/[A-Za-z0-9_\.\/\-_~]+(?:>?)/g,"sh_url",-1],[/(?:TODO|FIXME|BUG)(?:[:]?)/g,"sh_todo",-1]],[[/"/g,"sh_string",-2],[/\\./g,"sh_specialchar",-1]],[[/'/g,"sh_string",-2],[/\\./g,"sh_specialchar",-1]]];

		sh_highlightDocument();	
		
		$("#selectpos").xMenu({
			width :800,
			eventType: "click", //事件类型 支持focus click hover
			dropmenu:"#m1",//弹出层
			hiddenID : "selectposhidden"//隐藏域ID
		});
		
		
		$("#selectdept").xMenu({
			width :800,
			eventType: "click", //事件类型 支持focus click hover
			dropmenu:"#m2",//弹出层
			hiddenID : "selectdeptidden"//隐藏域ID		
			
		});
				
	});
(function($) {

	var defaults  = {
		width :580, //可选参数：inherit，数值(px)
		eventType: "click", //事件类型，其他可选参数有：click, focus
		dropmenu:".xmenu",//弹出层div
		hiddenID : "selectposhidden",//隐藏域ID
		emptytext: "请选择"
	};
	
	$.fn.xMenu = function(options) {
		return $(this).each(function() {
		
			var owl = $.extend({}, defaults, options || {});
			//触发按钮
			var $this = $(this);
			//span
			var $span = $this.find("span");
			//浮动层主div
			var $dropmenu= $(owl.dropmenu);
			//触发隐藏域 存职位ID
			var $Hd = $("#"+owl.hiddenID);
			//主li
			var $mli = $("dl li",$dropmenu);
			//关闭按钮
			var $closebtn =$(".m-close", $dropmenu);			
			//已选在职位div
			var $selectinfo = $(".select-info",$dropmenu);
			//已选在职位ul
			var $selectUl = $("ul",$selectinfo);
			//确认按钮
			var $okbtn = $("a[name='menu-confirm']",$selectinfo);
			
			
			//伸缩事件绑定
			$("dl dt",$dropmenu).toggle(function(){
				var $this = $(this);
				if($this.hasClass('open')){
					$this.removeClass('open').next().slideUp('fast');
				}else{
					$this.addClass('open').next().slideDown('fast');
				}				
			} , function(){
				$(this).removeClass('open').next().slideUp('fast');
			});
			
			//绑定关闭
			$closebtn.click(function(){
				 $.powerFloat.hide();
			});
			//绑定保存
			$okbtn.click(function(){
				var $li =$selectUl.find("li");
				var name = "";
				var id = "";			
				$li.each(function(){
					_this = $(this);
					name += _this.text()+",";
					id +=  _this.attr("rel")+",";
				})
				name = name.substring(0,name.length-1);
				id = id.substring(0,id.length-1);
				
				if(name.length>10){
					$span.attr({"title":name});
					name =name.substring(0,10)+"...";
				}
				
				$span.text(name);
				$Hd.val(id);
				$.powerFloat.hide();
			});
			
			
			//绑定每一个职位
			$mli.click(function(){
				var $li = $(this);
				var val  =$li.text();
				var id  = $li.attr("rel");
				if($selectinfo.is(":hidden")){
					$selectinfo.show();
				}
				if($li.hasClass("current")){
					$selectUl.find("li[rel='"+id+"']").remove();					
					$li.removeClass("current");
				}else{					
					$("<li rel='"+id+"' class='current'>"+val+"</li>").appendTo($selectUl);
					$li.addClass("current");
				}				
				if($selectUl.children("li").length==0){
					$selectinfo.hide();
				}
			});
			
			//绑定已选区li事件
			$("li",$selectUl).live('click',function(){
				var $li = $(this);
				var id  = $li.attr("rel");
				$mli.filter("li[rel='"+id+"']").removeClass("current");	
				$li.remove();
				if($selectUl.children("li").length==0){
					$selectinfo.hide();
				}
			});
			
			
			
			
			
			
			//绑定power浮动层
			$this.powerFloat({
				width: owl.width,
				eventType: owl.eventType,
				offsets: {
					x: 0,
					y: -150
				},
				target: $dropmenu, 	 		
				showCall: function(){ 				
					//标注已选职位
					setCurrentItem($Hd.val());					
					$this.addClass("menu-open");
				},
				hideCall:function(){
					$this.removeClass("menu-open");
					if($selectUl.children("li").length==0){
						$span.text(owl.emptytext);
						$Hd.val("");
					}
				}
			});
			//选中已选的职位
			var setCurrentItem = function (val){				
				if(val&&val!=""){
					$mli.removeClass("current");
					var array = val.split(",");
					$selectUl.empty();
					for(var i=0;i<array.length;i++){
						var $cli = $mli.filter("li[rel='"+array[i]+"']");
						$cli.addClass("current");
						$("<li rel='"+array[i]+"' class='current'>"+$cli.text()+"</li>").appendTo($selectUl);
					}					
				}else{
					$selectinfo.hide();
				}
				
			}			
		});
	};
	

	
	
})(jQuery);