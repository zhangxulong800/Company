/*  
*jQuery.crownSlide v1.0.0.beta
* REQUIRES: jquery.js (1.2.6 or later), Tween.js (modified by Da Xing,macrox)
* Copyright (c) 2009 Da Xing macrox@163.com
* download by http://www.jb51.net
*�÷���$(selector).crownSlide({options})
*��$.crownSlide(object,{options})
 
*options�е�����ѡ��(ȱʡΪ�ٶ�Ϊ10���仯��Ϊ100pixel��slideDownģʽ)��

type:
	slideDown:����֮�½��������ƶ�
	slideUp:�������Ͻ��������ƶ�
	slideInnerDown:����������չ��ĸ߶�
	slideInnerUp:��������������ĸ߶�
	slideOut:��������
	slideIn:���ڽ���
	Ĭ������½�����ʼ��Ϊ"slideDown"
speed:
	�˶��ٶȣ�����������ֵԽ�����ٶ�Խ��
current:
	��ǰʱ�䣬Ĭ��Ϊ0�������ĳ���ʱ������ɷ���
duration:
	����ʱ�䣬�����ĳ���ʱ�����������
beginning:
	��ʼֵ����Ĭ������»ᱻ_mx_GetBeginning������ʼ��
change:
	�仯������Ĭ������»ᱻ_mx_GetChange������ʼ������slideOut��slideIn�д���߶ȵı仯
$change:
	���ӱ仯������slideOut��slideIn�д����ȵı仯
callback:
	�ص����������ڻ���ִ����ɺ󱻵���

*******************Example:*************************
	
//��idΪdiv1��Ԫ�صĴ�С���ڽ������������С120���أ�����150���룬����ɽ����󽫸ò������ƶ�50���أ�����50����
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
