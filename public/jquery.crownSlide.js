/*  
*jQuery.crownSlide v1.0.0.beta
* REQUIRES: jquery.js (1.2.6 or later), Tween.js (modified by Da Xing,macrox)
* Copyright (c) 2009 Da Xing macrox@163.com
* download by http://www.jb51.net
*用法：$(selector).crownSlide({options})
*或：$.crownSlide(object,{options})
 
*options中的配置选项(缺省为速度为10，变化量为100pixel的slideDown模式)：

type:
	slideDown:从至之下将整个层移动
	slideUp:从下至上将整个层移动
	slideInnerDown:从上至下扩展层的高度
	slideInnerUp:从下至上缩减层的高度
	slideOut:向外扩张
	slideIn:向内紧缩
	默认情况下将被初始化为"slideDown"
speed:
	运动速度（步长），数值越大，则速度越慢
current:
	当前时间，默认为0，缓动的持续时间与其成反比
duration:
	持续时间，缓动的持续时间与其成正比
beginning:
	初始值，在默认情况下会被_mx_GetBeginning函数初始化
change:
	变化量，在默认情况下会被_mx_GetChange函数初始化，在slideOut和slideIn中代表高度的变化
$change:
	附加变化量，在slideOut和slideIn中代表宽度的变化
callback:
	回调函数，将在缓动执行完成后被调用

*******************Example:*************************
	
//将id为div1的元素的大小向内紧缩，长宽均减小120像素，持续150毫秒，当完成紧缩后将该层向左移动50像素，持续50毫秒
<html>
	<head>
		<title>---[Example][jQuery.crownSlide][v1.0.0.beta]</title>
	</head>
	<body>
		<div id="div1" style="display:block;height:200px;width:200px;background:#ccc"></div>
	</body>
</html>
<script language="javascript" src="jQuery.js" type="text/javascript"></script>
<script language="javascript" src="Tween.js" type="text/javascript"></script>
<script language="javascript" src="jquery.crownSlide.js" type="text/javascript"></script>
<script>
$("#div1").crownSlide({
	type : "slideIn",
	speed : 10,
	current : 0,
	duration : 150,
	beginning : 0,
	change : 120,
	$change : 120,
	callback : function(){
		$("#div1").crownSlide({
			type : "slideLeft",
			duration : 50,
			change : 50
		});	
	}
});
</script>

****************************************************
*/
(function($){
	var _mx_CrownSlide_defaultOptions = {
		type : "slideDown",
		speed : 10,
		current : 0,
		duration : 150,
		beginning : 0,
		change : 100,
		$change : 100,
		callback : function(){}
	};
	$.fn.extend({
		crownSlide:function(option,callback){
			return this.each(function(){return $.crownSlide(this,option);});
		}
	});
	$.crownSlide = function(obj,option){
		var obj = $(obj);
		var isCompleted = 0;
		var slideStyle = null;
		var opts = $.extend({},_mx_CrownSlide_defaultOptions,option);
		var t = opts.current , d = opts.duration, b = _mx_GetBeginning(opts.type), c = _mx_GetChange(opts.type,opts.change,opts.$change);
		if(isCompleted==0){_mx_CrownSlide();}
		
		function _mx_CrownSlide(){
			_mx_GetSlideStyle(opts.type);
   			if(t<d){t++; setTimeout(_mx_CrownSlide, opts.speed);}
			else{
				isCompleted=1;
				if(typeof(opts.callback)!="undefined")opts.callback();
			}
		}
		function _mx_GetBeginning(_type){
			switch(_type){
				case "slideDown" :
					return obj.offset().top;
				case "slideUp" :
					return obj.offset().top;
				case "slideInnerDown" :
					return obj.height();
				case "slideInnerUp" :
					return obj.height();
				case "slideRight" :
					return obj.offset().left;
				case "slideLeft" :
					return obj.offset().left;
				case "slideInnerRight" :
					return obj.width();
				case "slideInnerLeft" :
					return obj.width();
				case "slideOut" :
					return [obj.offset().top,obj.offset().left,obj.height(),obj.width()];
				case "slideIn" :
					return [obj.offset().top,obj.offset().left,obj.height(),obj.width()];
				default :
					return obj.offset().top;
			}
		}
		function _mx_GetChange(_type,_change,_$change){
			switch(_type){
				case "slideDown" :
					return _change;
				case "slideUp" :
					return -_change;
				case "slideInnerDown" :
					return _change;
				case "slideInnerUp" :
					return -_change;
				case "slideRight" :
					return _change;
				case "slideLeft" :
					return -_change;
				case "slideInnerRight" :
					return _change;
				case "slideInnerLeft" :
					return -_change;
				case "slideOut" :
					return [-_change/2,-_$change/2,_change,_$change];
				case "slideIn" :
					return [_change/2,_$change/2,-_change,-_$change];
				default :
					return _change;
			}
		}
		function _mx_GetSlideStyle(_type){
			switch(_type){
				case "slideDown" :
					return obj.css({top:Math.ceil(_mx_Tween.Quint.easeIn(t,b,c,d)) + "px"});
				case "slideUp" :
					return obj.css({top:Math.ceil(_mx_Tween.Quint.easeIn(t,b,c,d)) + "px"});
				case "slideInnerDown" :
					return obj.css({height:Math.ceil(_mx_Tween.Quint.easeIn(t,b,c,d)) + "px"});
				case "slideInnerUp" :
					return obj.css({height:Math.ceil(_mx_Tween.Quint.easeIn(t,b,c,d)) + "px"});
				case "slideRight" :
					return obj.css({left:Math.ceil(_mx_Tween.Quint.easeIn(t,b,c,d)) + "px"});
				case "slideLeft" :
					return obj.css({left:Math.ceil(_mx_Tween.Quint.easeIn(t,b,c,d)) + "px"});
				case "slideInnerRight" :
					return obj.css({width:Math.ceil(_mx_Tween.Quint.easeIn(t,b,c,d)) + "px"});
				case "slideInnerLeft" :
					return obj.css({width:Math.ceil(_mx_Tween.Quint.easeIn(t,b,c,d)) + "px"});
				case "slideOut" :
					obj.css({top:Math.ceil(_mx_Tween.Quint.easeIn(t,b[0],c[0],d)) + "px"});
					obj.css({left:Math.ceil(_mx_Tween.Quint.easeIn(t,b[1],c[1],d)) + "px"});
					obj.css({height:Math.ceil(_mx_Tween.Quint.easeIn(t,b[2],c[2],d)) + "px"});
					obj.css({width:Math.ceil(_mx_Tween.Quint.easeIn(t,b[3],c[3],d)) + "px"});
					return true;
				case "slideIn" :
					obj.css({top:Math.ceil(_mx_Tween.Quint.easeIn(t,b[0],c[0],d)) + "px"});
					obj.css({left:Math.ceil(_mx_Tween.Quint.easeIn(t,b[1],c[1],d)) + "px"});
					obj.css({height:Math.ceil(_mx_Tween.Quint.easeIn(t,b[2],c[2],d)) + "px"});
					obj.css({width:Math.ceil(_mx_Tween.Quint.easeIn(t,b[3],c[3],d)) + "px"});
					return true;
				default :
					return obj.css({top:Math.ceil(_mx_Tween.Quint.easeIn(t,b,c,d)) + "px"});
			}
		}
	}
})(jQuery);
