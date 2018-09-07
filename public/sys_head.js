var touchAble=null;
var r_t;
function close_monxin_iframe(){
	$("#fade_div").css('display','none');
	$("#set_monxin_iframe_div").css('display','none');
}

function r_delayed_hidden(){
	$(".right_notice").css('right',40).css('display','none');
	$(".right_notice").animate({opacity:0},'slow');
}

function check_url(url){url=url.replace(/\/&/,'/?');url=url.replace(/\.php\&/,'.php?');return url;}
function inquiries_pay_state(v){
	if(v.state=='success'){
		
	}else{
		
	}	
}
function set_platform(){
	str=navigator.platform.split(" ");
	$("html").attr('platform',str[0]);
}
function set_browser(){
	$("html").attr('browser',get_browser());
}
function set_is_weixin(){
	if(isWeiXin()){is_weixin=1;}else{is_weixin=0;}
	$("body").attr('is_weixin',is_weixin);
}
function close_talk_iframe(close_window){
	$("#fade_div").css('display','none');
	$("#set_monxin_iframe_div").css('display','none');
	$("#set_monxin_iframe_div").removeClass('talk_iframe');
	$("#monxin_iframe").attr('scrolling','yes');
	if(close_window==1){$("#monxin_iframe").attr('src','');}
}
function flash_im_talk_show(){
	$("#im_talk_show").addClass('fadeIn animated infinite');
	$(".fixed_right_div #im_talk_show").addClass('fadeIn animated infinite');	
	if(getCookie('user_set_im_new')==1){$("#notice_audio").attr('src','./program/im/new.wav').removeAttr('loop');}
}
function monxin_iframe_is_open(){
	temp=$("#monxin_iframe").attr('src').split('index.php?monxin=im.talk');
	if($("#set_monxin_iframe_div").css('display')=='block' && temp[1]){return true;}else{return false;}
}

$(document).ready(function(){
	set_platform();
	set_is_weixin();
	set_browser()
	$(".btn-group .dropdown-menu").css('display','none');
	$(".btn-group").click(function(){
		if($(this).children('.dropdown-menu').css('display')=='none'){
			$(".btn-group .dropdown-menu").css('display','block');	
		}else{
			$(".btn-group .dropdown-menu").css('display','none');
		}
	});
	$("#im_talk_show").click(function(){
		if(!getCookie('monxin_id')){window.location.href='index.php?monxin=index.login';}
		if(getCookie('monxin_device')=='phone'){window.location.href='./index.php?monxin=im.talk&iframe=1'; return false;}
		set_iframe_position($(window).width()*0.6,'430');
		//monxin_alert(replace_file);
		$("#fade_div").css('display','block');
		$("#set_monxin_iframe_div").css('display','block');
		$("#set_monxin_iframe_div").addClass('talk_iframe');
		temp=$("#monxin_iframe").attr('src').split('index.php?monxin=im.talk');
		if(!temp[1]){$("#monxin_iframe").attr('src','./index.php?monxin=im.talk&iframe=1');}
		$("#monxin_iframe").attr('scrolling','no');
		$("#im_talk_show").removeClass('fadeIn animated infinite');	
		return false;	
	});
	
	$("[talk]").click(function(){
		if(!getCookie('monxin_id')){window.location.href='index.php?monxin=index.login';}
		if(getCookie('monxin_device')=='phone'){window.location.href='./index.php?monxin=im.talk&iframe=1&with='+$(this).attr('talk'); return false;}
		set_iframe_position($(window).width()*0.6,'430');
		//monxin_alert(replace_file);
		$("#fade_div").css('display','block');
		$("#set_monxin_iframe_div").css('display','block');
		$("#set_monxin_iframe_div").addClass('talk_iframe');
		$("#monxin_iframe").attr('src','./index.php?monxin=im.talk&iframe=1&with='+$(this).attr('talk'));
		$("#monxin_iframe").attr('scrolling','no');
		$("#im_talk_show").removeClass('fadeIn animated infinite');	
		return false;	
	});
	
	
	if(getCookie('monxin_device')=='phone'){$("input").focus(function(){$(window).scrollTop($(this).offset().top-40);});}
	$(".share_text_input").val($(".share_text").html());
	if(getCookie('monxin_id')){$(".share_text_input").val($(".share_text").html());}
	if(getCookie('im_new')==1 && getCookie('monxin_id')){flash_im_talk_show();}
	
	
	if($(".page_row").attr('max_page')){
		temp='';
		max_page=$(".page_row").attr('max_page');
		for(i=1;i<=max_page;i++){
			temp+='<option value='+i+'>'+i+'</option>';	
		}
		if(temp!=''){temp='<select class=set_page_go>'+temp+'</select>';}
		$(".page_row .set_page").html(temp);
		$(".page_row .set_page .set_page_go").change(function(){
			url=window.location.href;
			url=replace_get(url,'current_page',$(this).val());
			window.location.href=url;	
		});
		if(get_param('current_page')){$(".page_row .set_page .set_page_go").val(get_param('current_page'));}		
	}

	if($(window).height()/$(window).width()>1.5){
		$("body").addClass('pad_vertical');
	}
	$(".inquiries_pay_state").click(function(){
		id=$(this).attr('href');
		$("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('./receive.php?target=index.visitor_position&act=inquiries_pay_state',{id:id}, function(data){
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#state_"+id).html(v.info);
			$("#tr_"+id+" .state").html('success');
			try{inquiries_pay_state(v);}catch(exception){}
		});
		return false;	
	});
			
	
	$('.monxin_gif').each(function(index, element) {
		show_monxin_gif($(this).attr('id'));
		window.setInterval("show_monxin_gif('"+$(this).attr('id')+"')",$(this).attr('speed'));
		str='';
		for(i=0;i<$(this).children('.data_list').children('img').length;i++){
			str+='<a href=# index='+i+'>'+i+'</a>';	
		}
		$(this).children('.gif_progress').html(str); 
    });
	$(".monxin_gif img").click(function(){
		if($(this).parent().attr('play')=='1'){
			$(this).parent().attr('play',0);
		}else{
			$(this).parent().attr('play',1);
		}	
	});
	
	$(".monxin_gif a").click(function(){
		$(this).parent().parent().attr('play','0');
		$(this).parent().parent().children(".monxin_gif_show").attr('src',$(this).parent().parent().children('.data_list').children('img').eq($(this).index()).attr('src'));
		$(this).parent().parent().children('img').removeClass('current');
		$(this).parent().parent().children('img').eq($(this).index()).addClass('current');
		$(this).parent().parent().children('.crrent_title').html($(this).index()+'、'+$(this).parent().parent().children('.data_list').children('img').eq($(this).index()).attr('title'));
		$(this).parent().children('a').removeClass('current_index');
		$(this).addClass('current_index');
		return false;	
	});
	
	
	
	$(".weixin_share").click(function(){$(this).css('display','none');});
	if(get_param('search')!=''){
		search_key=decodeURI(get_param('search'));
		var reg=new RegExp("("+search_key+")","ig");   			
		$("[monxin_layout=full] tbody td").each(function(index, element) {if($(this).html().indexOf( "<" )==-1){$(this).html($(this).html().replace(reg,"<font color=red>$1</font>"));}});	
		$("[monxin_layout=full] a").each(function(index, element) {if($(this).html().indexOf( "<")==-1){$(this).html($(this).html().replace(reg,"<font color=red>$1</font>"));}});	
		$("[monxin_layout=full] span").each(function(index, element) {if($(this).html().indexOf( "<")==-1){$(this).html($(this).html().replace(reg,"<font color=red>$1</font>"));}});	
		$("[monxin_layout=full] div").each(function(index, element) {if($(this).html().indexOf( "<")==-1){$(this).html($(this).html().replace(reg,"<font color=red>$1</font>"));}});	
		$(".col-md-9 tbody td").each(function(index, element) {if($(this).html().indexOf( "<" )==-1){$(this).html($(this).html().replace(reg,"<font color=red>$1</font>"));}});	
		$(".col-md-9 a").each(function(index, element) {if($(this).html().indexOf( "<")==-1){$(this).html($(this).html().replace(reg,"<font color=red>$1</font>"));}});	
		$(".col-md-9 span").each(function(index, element) {if($(this).html().indexOf( "<")==-1){$(this).html($(this).html().replace(reg,"<font color=red>$1</font>"));}});	
		$(".col-md-9 div").each(function(index, element) {if($(this).html().indexOf( "<")==-1){$(this).html($(this).html().replace(reg,"<font color=red>$1</font>"));}});	
	}
	
	if(getCookie('monxin_device')=='phone'){$(".table_scroll").preventScroll();}
	$(document).on('click',".m_checkbox ",function(){
		if($(this).attr('checked')==='checked'){
			$(this).removeAttr('checked');
		}else{
			$(this).attr('checked','checked');
		}
		return false;	
	});
	$("#set_monxin_iframe_div").preventScroll();
	$("#close_button").click(function(){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		return false;
	});
	
	if($('body').height()<$(window).height()){$('.page-content').css('min-height',$(window).height()-$(".page-header").height()-$(".page-footer").height()-40);}
	container_width=$(".page-content .container").width();
	ie_warning=false;
	temp=window.navigator.userAgent;
	if(temp.indexOf("MSIE 6")>=0){ie_warning=true;}
	if(temp.indexOf("MSIE 7")>=0){ie_warning=true;}
	if(temp.indexOf("MSIE 8")>=0){ie_warning=true;}
	if(temp.indexOf("Trident/4")>=0){ie_warning=true;}
	//if(temp.indexOf("Trident/5")>=0){ie_warning=true;}
	//if(temp.indexOf("Trident/7")>=0){ie_warning=true;}
	if(ie_warning){
		//return false;
		$('.ie_warning').modal({  
		   backdrop:true,  
		   keyboard:true,  
		   show:true  
		});  
		$(".ie_warning").css('margin-top',($(window).height()-$(".ie_warning .modal-content").height())/3);		 		
	}
	if($("[m_container]").css('width')){$("[m_container]").addClass('w_'+$("[m_container]").css('width').replace(/px/,''));}
	$("body").addClass('w_'+window.screen.width+' h_'+window.screen.height);
	$(window).scroll(function(){
		//alert($(window).scrollTop());
		if($(window).scrollTop()>200){
			$("#return_top").css('display','block');	
		}else{
			$("#return_top").css('display','none');	
		}	
	});
	
	$(".fixed_right_div").css('padding-top',($(window).height()-$(".fixed_right_div_inner").height())/2);
	if(getCookie('monxin_device')=='phone'){
		$("body").attr('ontouchstart','display_fixed_right_div(0)');
		$("body").attr('ontouchcancel','delay_show_fixed_right_div()');
		$(".fixed_right_div").attr('ontouchstart','display_fixed_right_div(-1)');
		$(".fixed_right_div").attr('ontouchcancel','display_fixed_right_div(-1)');
	}else{
		$(".fixed_right_div_inner > a").hover(function(){
				if($(this).attr('id')!='wx' && $(this).attr('id')!='share_button' ){
					window.clearTimeout(r_t);
					$(".right_notice span").html($(this).attr('d_t'));
					$(".right_notice").animate({opacity:1},'fast');
					$(".right_notice").css('top',$(this).offset().top).css('display','block');
					$(".right_notice").animate({right:28},'slow');	
				}
			},function(){
				 r_t=window.setTimeout(r_delayed_hidden,300);
		});
	}		
	
	if(get_param('share')!=''){
		$.post('./receive.php?target=index.visitor_position&act=share',{url:window.location.href,title:$('title').html(),share:get_param('share')},function(data){
			//alert(data);
		});		 

	}
	$("input[type='checkbox']").addClass('input_checkbox');
	set_module_div_left_margin();
	//$(".module_div").css('display','inline').css('zoom',1);
	
	//monxin_alert($(window).width()+','+$(window).height());
	//monxin_alert(navigator.language+','+navigator.browerLanguage);
	
	if(get_param('show_single_module')!=''){show_single_module(get_param('show_single_module'));}
	
	show_tutorial_button();
	//monxin_alert($("textarea[id='content']").length);
	set_ie_placeholder();
	//
	$(".ajax").on('click',function(){
		$.get(this, function(data){
			//monxin_alert(data);
			callback=this.url.split("callback="); 
			if(callback[1]){callback=callback[1].split("&");eval(callback[0]+"('"+data+"')");}
		});
		return false;

	});
	
	touchAble='ontouchstart' in window;
	//monxin_alert(getCookie('monxin_device'));
	if(touchAble){
		setCookie('touch','1',300);
			
		$(".dropdown-menu").attr('class','dropdown-menu_touch');
		$(".actions .btn-group .btn").click(function(){
			if($(this).next().css('display')=='none'){
				$(this).next().css('display','block');
			}else{
				$(this).next().css('display','none');
			}
			
			return false;	
		});
			
	}else{
		setCookie('touch','0',300);
	}
	
	
	
	
	checkCookie();
	if(getCookie('user_set_page_auto_size')=='1' && getCookie('monxin_device')=='pc' && $(window).width()<1319){
		monxin_zoom();
		//window.onresize = function(){monxin_zoom();}
	}
	
	
	$("#monxin_form").keydown(function(event){
		if(event.keyCode==13 && event.target.tagName!='TEXTAREA'){return exe_check();}		  	
	});
	
	
	$("[general_search] input").on('keyup',function(event){
		keycode=event.which;
		if(keycode==13){
			if($(this).val()!=''){
				window.location.href=$(this).attr('url')+$(this).val();	
			}
		}	
	});
	$("[general_search] [search_button]").on('click',function(event){
	
		if($("[general_search] input").val()!=''){window.location.href=$("[general_search] input").attr('url')+$("[general_search] input").val();}
		return false;
	});
	
	
	$(".advanced_options").toggle(
		function () {
		  $("#advanced_options_div").css('display','block');
		  $("#advanced_options_div_state").attr('class','hide');
		  return false;
		},
		function () {
		  $("#advanced_options_div").css('display','none');
		  $("#advanced_options_div_state").attr('class','show');
		  return false;
		}
		
	);
});
function show_monxin_gif(id){
	if($("#"+id).attr('play')==0){return false;}
	if($("#"+id+" .data_list .current").next().attr('src')){
		$("#"+id+" .monxin_gif_show").attr('src',$("#"+id+" .data_list .current").next().attr('src'));
		$("#"+id+" .data_list img").removeAttr('current_next');
		$("#"+id+" .data_list .current").next().attr('current_next','1');
		$("#"+id+" .data_list img").removeClass('current');
		$("#"+id+" [current_next=1]").addClass('current');
	}else{
		$("#"+id+" .monxin_gif_show").attr('src',$("#"+id+" .data_list img").eq(0).attr('src'));
		$("#"+id+" .data_list img").removeClass('current');
		$("#"+id+" .data_list img").eq(0).addClass('current');
		$("#"+id+" .data_list img").removeAttr('current_next');
		$("#"+id+" .data_list img").eq(0).attr('current_next','1');
	}
	$("#"+id+" a").removeClass('current_index');
	$("#"+id+" a[index="+$("#"+id+" .data_list .current").index()+"]").addClass('current_index');
	$('#'+id+' .crrent_title').html($("#"+id+" .data_list .current").index()+'、'+$("#"+id+" .data_list .current").attr('title'));

}

var show_fixed_right_div_timer;
function delay_show_fixed_right_div(){
	window.clearInterval(show_fixed_right_div_timer); 
	//alert('delay');
	show_fixed_right_div_timer = window.setTimeout('display_fixed_right_div(1)', 500); 
}
function display_fixed_right_div(v){
	
	window.clearInterval(show_fixed_right_div_timer); 
	if(v==-1){event.stopPropagation();return false;}
	if($(document).scrollTop()<$(window).height()){
		//$(".fixed_right_div #share_button").css('display','none');
		$(".fixed_right_div #return_top").css('display','none');
	}else{
		//$(".fixed_right_div #share_button").css('display','block');
		$(".fixed_right_div #return_top").css('display','block');
	}
	return false;
	if(v){
		$('.fixed_right_div').css('display','block');
	}else{
		$('.fixed_right_div').css('display','none');
	}
	//alert('xx');
}

function isWeiXin(){ 
	var ua = window.navigator.userAgent.toLowerCase(); 
	if(ua.match(/MicroMessenger/i) == 'micromessenger'){ 
		return true; 
	}else{ 
		return false; 
	} 
} 


function get_Browser_name(){
	v=navigator.userAgent;
	v=v.toLowerCase();
	temp=new Array('qqbrowser','ucbrowser','chrome','micromessenger','firefox','sogou','oupeng','leibao','baidu');
	for(i in temp){
		if(v.indexOf(temp[i])!=-1){return temp[i];}	
	}
	return 'other';	
}

function scalable_no_bug(){
	v=get_Browser_name();
	temp=new Array('qqbrowser','ucbrowser','chrome','micromessenger','firefox');
	if($.inArray(v,temp)!=-1){return true;}else{return false;}	
}

function set_module_div_left_margin(){
	last_top=999;
	$(".module_div").each(function(index, element) {
        if($(this).offset().top===last_top && $(this).attr('id')!='index_visitor_position' && $(this).attr('id')!='index_user_position'){
			$(this).addClass('module_div_left_margin');
		}
		last_top=$(this).offset().top;
		if($("#"+$(this).attr('id')+"_html").attr('class')=='module_div_bottom_margin'){
			$(this).css('margin-bottom',$("#"+$(this).attr('id')+"_html").css('margin-bottom'));	
		}
    });
	
}

function set_iframe_position(width,height){
	$("#set_monxin_iframe_div").css('left',($(window).width()-width) /2 ).css('top',($(window).height()-height)/2);
	$("#monxin_iframe").css('width',width).css('height',height);
}

function add_http(v){
	if(v==''){return '';}
	//v=v.toLowerCase();
	temp=v.split('http');
	temp2=v.split('HTTP');
	if(temp[1]==undefined && temp2[1]==undefined){return 'http://'+v;}	
	return v;
}


function monxin_alert(v){
	v=v.replace(/<\/?[^>]*>/g,''); //去除HTML tag	
	alert(v);
}

function check_module_size(v){
	if(v=='auto' || v=='' || v==0){return 'auto';}
	if($.isNumeric(v)){return v+'px';}
	v=v.toLowerCase();
	temp=v.split('px');
	if(temp[1]==='' && $.isNumeric(temp[0])){return temp[0]+'px';}
	temp=v.split('%');
	if(temp[1]==='' && $.isNumeric(temp[0])){return temp[0]+'%';}
	temp=v.split('rem');
	if(temp[1]==='' && $.isNumeric(temp[0])){return temp[0]+'rem';}
	return '100px';
}

function check_quantity(v){
	if($.isNumeric(v)){return v;}	
	return 10;
}

function show_tutorial_button(){
	if(top.location==location){
		if(getCookie('tutorial')==1 && getCookie('user_set_tutorial_button')==1){
			$("#tutorial_button_a").css('display','block');
			$("#tutorial_button_a").attr('href','http://www.monxin.com/index.php?monxin=talk.content&key=page_tutorial|'+get_param('monxin'));
		}	
	}
}

function mouse_over_sound(){
	if(getCookie('user_set_mouse_over_sound')==1 && getCookie('monxin_device')=='pc'){$("#notice_audio").attr('src','./sound/mouse_over.ogg').removeAttr('loop');}
}
function loading_sound(){
	if(getCookie('user_set_operation_sound')==1 && getCookie('monxin_device')=='pc'){$("#notice_audio").attr('src','./sound/loading.ogg').attr('loop','loop');}
}
function success_sound(){
	if(getCookie('user_set_operation_sound')==1 && getCookie('monxin_device')=='pc'){$("#notice_audio").attr('src','./sound/success.ogg').removeAttr('loop');}
}
function fail_sound(){
	if(getCookie('user_set_operation_sound')==1 && getCookie('monxin_device')=='pc'){$("#notice_audio").attr('src','./sound/fail.ogg').removeAttr('loop');}
}
function warning_sound(){
	if(getCookie('user_set_operation_sound')==1 && getCookie('monxin_device')=='pc'){$("#notice_audio").attr('src','./sound/warning.ogg').removeAttr('loop');}
}
function show_single_module(id){
	$("#"+id).css('position','absolute');
	$("#"+id).css('top',0);		
	$("#"+id).css('left',0);
	$(".module_div").css('display','none');
	$("#"+id).css('display','block');
}

function del_null(arr){
	na=new Array();
	var i=0;
	for(v in arr){if(arr[v]!='' && arr[v]!=null && arr[v]!=NaN){na[i]=arr[v];i++}}
	//monxin_alert(na.toString());
	return na;
}

function get_max(array){
	array=del_null(array);
	return Math.max.apply(Math,array);
}
function get_min(array){
	array=del_null(array);
	return Math.min.apply(Math,array);
}


function checkCookie(){  
	if(!window.navigator.cookieEnabled){monxin_alert("In order to properly access the website, please set your browser to receive COOKIE");}  
} 

function monxin_zoom(){
	return false;
	//alert(top.location+'='+location);
	if(top.location==location){
		zoom=($(window).width()-19)/1319;
		//alert(zoom);
		document.body.style.zoom=zoom;
		//monxin_alert(document.body.style.zoom);
		$("body").css('text-align','left');
	}
}


function unlogin(v){
	v=v.split("backurl=");
	if(v[1]){window.location.href=v[1];}
	}

function change_authcode(){
	document.getElementById("authcode_img").src="./lib/authCode.class.php?refresh="+Math.random();
	return false;
}

function is_passwd(s){
	var patrn=/^(\w){1,100}$/;
	if (!patrn.exec(s)) return false
	return true
}   

function get_param(v){
	var url=window.location.href;
	url=url.replace("#","&");
	t=url.split(v+"=");
	if(t.length>1){
		t=t[1].split("&");
		return t[0]; 	
	}else{
		return "";	
	}	
}

function replace_get(destiny, par, par_value){ 
	url=destiny;
	var pattern = par+'=([^&]*)'; 
	var replaceText = par+'='+par_value; 
	if (destiny.match(pattern)) { 
		var tmp = '/\\'+par+'=[^&]*/'; 
		tmp = destiny.replace(eval(tmp), replaceText); 
		if(tmp==url){tmp=replace_get_2(url,par,par_value);}
		return (tmp); 
	}else { 
		if (destiny.match('[\?]')) { 
			tmp=destiny+'&'+ replaceText; 
		}else { 
			tmp=destiny+'?'+replaceText; 
		} 
		if(tmp==url){tmp=replace_get_2(url,par,par_value);}
		return (tmp); 
	} 
	new_url=destiny+'\n'+par+'\n'+par_value; 
	if(new_url==url){new_url=replace_get_2(url,par,par_value);}
	return new_url;
} 

function replace_get_2(url,key,v){
	var regExp = new RegExp(""+key+"=", 'gi');
	url=url.replace(regExp,'');
	url=url.replace(/\?&/,'?');
	temp=url.split("&");
	if(temp.length==1){
		symbol="?";
		temp=url.split("?");
		if(temp.length==1){return url+"?"+key+"="+v;}else{return url+"&"+key+"="+v;}	
	}else{
		symbol="&";	
	}
	url='';
	for(var i=0;i<temp.length;i++){
		temp2=temp[i].split("=");
		if(temp2[0]!=key && ( typeof(temp2[1])!="undefined" && temp2[1]!='')){url+=temp[i]+symbol;}	
	}
	url=url.substr(0,url.length-1);
	url+="&"+key+"="+v;
	url=url.replace(/#/g,'');
	url=url.replace(/&&/g,'&');
	return url;
}



function in_array(needle, haystack) {
 if(typeof needle =='string' || typeof needle == 'number') {
  for(var i in haystack) {
   if(haystack[i] == needle) {
     return true;
   }
  }
 }
 return false;
}


function exePrint(){
	//stop
	var exe_print=get_param("exe_print");
	var url=window.location.href;
	temp=url.split("?");
	if(temp.length==1){url+="?";}else{url+="&";}
	$("#print_a").attr("href",url+"exe_print=true");
	if(exe_print=='true'){
		print_id=get_param("monxin").replace(".","_");
		try{
			v=$("#"+print_id).html().replace("window.print()","");
			$("body").html("<div id="+print_id+">"+v+"</div>");
		}catch(exception){}


		window.print();
	}
}

function clearNoNum(obj){
		obj.value = obj.value.replace(/[^\d-.]/g,"");
		obj.value = obj.value.replace(/^\./g,"");
		obj.value = obj.value.replace(/\.{2,}/g,".");
		obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
}	

function isNumeric(code){
	//monxin_alert(code);
	if(code==8 || code==9 || code==46){return true;}
	if(code>95 && code<106){return true;}	
	if(code>47 && code<58){return true;}
	return false;	
}


function set_ie_placeholder(){
	//return false;
	if(!$.support.leadingWhitespace){
		$("input[type='text']").each(function(i,e){
			if($(this).attr('placeholder')!='' && $(this).prop('value')==''){
				$(this).prop('value',$(this).attr('placeholder'));
			}	
		});
		$("input[type='text']").focus(function(){
			if($(this).attr('placeholder')==$(this).prop('value')){
				$(this).prop('value','');
			}	
		});
		$("input[type='text']").blur(function(){
			if($(this).attr('placeholder')!='' && $(this).prop('value')==''){
				$(this).prop('value',$(this).attr('placeholder'));
			}	
		});
	}	
}

function enter_to_tab(){
	$("input").keydown(function(event){
		if($(this).attr('type')=='text' || $(this).attr('type')=='password'){
			if(event.keyCode==13){
				$(this).blur();
				var  e_id=$(this).attr('id');
				$('input[type="text"]').each(function(index, element) {
                    if($(this).attr('id')==e_id){
						inputs=$('input[type="text"]');
						//monxin_alert($(inputs[index+1]).attr('id'));
						try{inputs[index+1].focus();}catch(e){}
					}
                });
			}	
		}	
	return true;
	});
	
}

function hex2rgb(hex){
	hex=hex.replace("#","");
	r='';
	if(hex.length==3){
		r+=parseInt(hex.substr(0,1)+''+hex.substr(0,1),16)+',';
		r+=parseInt(hex.substr(1,1)+''+hex.substr(1,1),16)+',';
		r+=parseInt(hex.substr(2,1)+''+hex.substr(2,1),16)+',';
	}
	if(hex.length==6){
		r+=parseInt(hex.substr(0,2),16)+',';
		r+=parseInt(hex.substr(2,2),16)+',';
		r+=parseInt(hex.substr(4,2),16)+',';
	}
	return r.substr(0,r.length-1);
}

function get_days(Year,Month){
    var d = new Date(Year,Month,0);
    return d.getDate();
}

function replace_quot(v){
	v=v.replace(/'/g,'&#39;');	
	v=v.replace(/"/g,'&#34;');
	return v;	
}

function setCookie(name,value,expiresDays){ 
	var cookieString=name+"="+escape(value); 
	if(expiresDays>0){ 
		var date=new Date(); 
		date.setTime(date.getTime()+expiresDays*24*3600*1000); 
		cookieString+="; expires="+date.toGMTString(); 
	}
	document.cookie=cookieString;
	 
} 
function getCookie(name){ 
	var strCookie=document.cookie; 
	var arrCookie=strCookie.split("; "); 
	for(var i=0;i<arrCookie.length;i++){ 
		var arr=arrCookie[i].split("="); 
		if(arr[0]==name){
			//alert(arr[1]);
			return unescape(arr[1]);	
		} 
	}
	return false; 
} 

function get_device(){
	//monxin_alert(window.screen.availWidth+'>'+window.screen.availHeight);
	monxin_device_temp=getCookie('monxin_device');
	//alert('set='+getCookie('monxin_device_set'));
	if(!getCookie('monxin_device_set')){
		if( (window.screen.availWidth>window.screen.availHeight) ){
			setCookie('monxin_device','pc',30);
		}else{
			setCookie('monxin_device','phone',30);
		}
		//alert(getCookie('monxin_device')+'='+monxin_device_temp);
	}
	//alert(getCookie('monxin_device'));
	if(getCookie('monxin_device')!=monxin_device_temp){
		//monxin_alert(getCookie('monxin_device'));
		url= window.location.href;
		if(url.indexOf('?')!=-1){
			url= window.location.href+'&relaod='+ Math.round(Math.random()*100);
		}else{
			 url=window.location.href+'?&relaod='+ Math.round(Math.random()*100);
		}
		window.location.href =url;
	}
}
//alert('xx');
get_device();



function get_browser(){
  var v;
  if(window.navigator.userAgent.indexOf("Safari")>=0 && navigator.userAgent.toLowerCase().indexOf("version")>=0)
  {v="safari";}else if(window.navigator.userAgent.indexOf("Edge")>=0){v='Edge';}else if(window.navigator.userAgent.indexOf("Chrome")>=0){v="chrome";}else if(navigator.userAgent.toLowerCase().indexOf('msie')>=0){v="ie";}else if(navigator.userAgent.toLowerCase().indexOf('firefox')>=0){v="firefox";}else if(navigator.userAgent.toLowerCase().indexOf('opera')>=0){v="opera";} 
  return v;
}




var touch_start_X;
var touch_start_Y;
function set_touch_start(event){
	touch_start_Y=event.changedTouches[0].pageY;
	touch_start_X=event.changedTouches[0].pageX;
	//alert(touch_start_X);
}
function exe_touch_move(event,fun){
	
	have=false;
	try{parseInt(event.changedTouches[1].pageY);have=true;}catch(e){};
	if(!have){
		
		touch_end_Y=event.changedTouches[0].pageY;
		touch_end_X=event.changedTouches[0].pageX;
		
		touch_width=Math.abs(touch_end_X-touch_start_X);
		touch_height=Math.abs(touch_end_Y-touch_start_Y);
		//alert(touch_width+','+touch_height);
		if(touch_width>touch_height){
			if(touch_width<120){return false;}
			if(touch_start_X<touch_end_X){v='left'}else{;v='right';}	
		}else{
			if(touch_height<120){return false;}
			if(touch_start_Y<touch_end_Y){v='down';}else{v='up';}
		}
		//monxin_alert(v);
			eval(fun+"('"+v+"')");
	}
			
}
function get_touch_move(event){
	have=false;
	try{parseInt(event.changedTouches[1].pageY);have=true;}catch(e){};
	if(!have){
		touch_end_Y=event.changedTouches[0].pageY;
		touch_end_X=event.changedTouches[0].pageX;
		touch_width=Math.abs(touch_end_X-touch_start_X);
		touch_height=Math.abs(touch_end_Y-touch_start_Y);
		//alert(touch_width+','+touch_height);
		if(touch_width>touch_height){
			if(touch_width<80){return false;}
			if(touch_start_X<touch_end_X){v='left'}else{;v='right';}	
		}else{
			if(touch_height<20){return false;}
			if(touch_start_Y<touch_end_Y){v='down';}else{v='up';}
		}
		//alert(v);
		return v;
	}
			
}
function time_limit(){
		url=window.location.href;
		url=replace_get(url,'start_time',$("#start_time").val());
		url=replace_get(url,'end_time',$("#end_time").val());
		url=replace_get(url,'search','');
		url=replace_get(url,'current_page','1');
		//monxin_alert(url);
		window.location.href=url;	
		return false;
	}	

function sort_int(int1,int2){
    int1=parseInt(int1);
    int2=parseInt(int2);
    if(int1 < int2){return -1;}else if(int1 > int2){return 1;}else{return 0;}
}


/*var obj = {a:1,b:2,c:3}

for(var name in obj) {
    monxin_alert( "name:" + name + " value:" + obj[name] );
}
 */
function forbid_select(){
	return false;
}

function get_max_z_index(){
	z_index=new Array();
	$("div").each(function(index, element) {
        z_index[index]=parseInt($(this).css('z-index')) || 0;		
    });
	return get_max(z_index)+1;
}
 
 //=============================================================================================== drag start
var dragging=false;

var iX, iY,obj;

function  touch_drag_start(id) {
	var e =window.event || arguments.callee.caller.arguments[0];
	obj=$(id);
	obj.css('z-index',get_max_z_index());
		dragging=true;
		iX = e.changedTouches[0].pageX - obj.offset().left;
		iY = e.changedTouches[0].pageY - obj.offset().top;
		obj.setCapture && obj.setCapture();
		//monxin_alert('Y='+iY+',X='+iX);
		if($(e.target).attr('class')=='monxin_drag_div'){event.preventDefault();}
		return false;
}
function  touch_drag_move() {
	var e =window.event || arguments.callee.caller.arguments[0];
	if (dragging){
		t_x=e.changedTouches[0].pageX - iX;
		t_y=e.changedTouches[0].pageY - iY;
		obj.css({"left":t_x + "px", "top":t_y + "px"});
		//alert(Math.abs(t_x-iX));
		event.preventDefault();
		if($(e.target).attr('class')=='monxin_drag_div'){event.preventDefault();}
		return false;
	}
}
function  touch_drag_end() {
	var e =window.event || arguments.callee.caller.arguments[0];
	dragging= false;
	//obj[0].releaseCapture();
	//event.preventDefault();
	if($(e.target).attr('class')=='monxin_drag_div'){e.cancelBubble = true;event.preventDefault();}
}
function  touch_drag_stop(parent){
	dragging=false;
	event.preventDefault();
	if($(e.target).attr('class')=='monxin_drag_div'){event.preventDefault();}
	}




function drag_start(id) {
	var e =window.event || arguments.callee.caller.arguments[0];
	//monxin_alert(id);
	obj=$(id);
	obj.css('z-index',get_max_z_index());
		dragging=true;
		iX = e.clientX - obj.offset().left;
		iY = e.clientY - obj.offset().top;
		obj.setCapture && obj.setCapture();
		//monxin_alert('Y='+iY+',X='+iX);
		return false;
}

function drag_move() {
	var e =window.event || arguments.callee.caller.arguments[0];
	//obj=$(id);
	//monxin_alert(border_left+','+border_top+','+border_right+','+border_bottom);
	if (dragging){
		t_x=e.clientX - iX;
		t_y=e.clientY - iY;
		obj.css({"left":t_x + "px", "top":t_y + "px"});
		//if(oX==border_left || oX==border_right-obj.width()){drag_end(id);}
		//if(oY==border_top || oY==border_bottom-obj.height()){drag_end(id);}
		return false;
	}
}
function drag_end() {
	var e =window.event || arguments.callee.caller.arguments[0];
	dragging= false;
	//obj[0].releaseCapture();
	e.cancelBubble = true;
}
function drag_stop(parent){dragging=false;}
 //=============================================================================================== drag end


 
 
 //==================================================================================================================================monxin_table start
    $(document).ready(function(){
		//monxin_alert($(".no_related_content_span").html());
		if($(".no_related_content_span").length!=0){
			$("[monxin-table] .batch_operation_div").css('display','none');
			$("[monxin-table] .bulk_action_div").css('display','none');
		}
        $("[monxin-table] .filter select").change(function(){
            monxin_table_filter($(this).attr('id'));
        });
         $("[monxin-table] .filter #search_filter").keyup(function(event){
            keycode=event.which;
            if(keycode==13){monxin_table_filter('search_filter');}	
        });


		 var order=get_param('order');
		 set_current_order(order);
		 
        $("[monxin-table] [group-checkable]").change(function(){
			if($(this).prop("checked")){
				$("[monxin-table] .id").prop("checked",true);
			}else{
				$("[monxin-table] .id").prop("checked",false);
			}
		});
		 
        $("[monxin-table] thead a,.sort a").click(function(){
            url=window.location.href;
            if(order=='' || order!=$(this).attr('desc')){
                url=replace_get(url,"order",$(this).attr('desc'));
            }else{
                url=replace_get(url,"order",$(this).attr('asc'));	
            }
            window.location=url;
			return false;	
        });
		
			
        $("[monxin-table] .id").change(function(){
            if($(this).prop('checked')){
                $("#tr_"+this.id).addClass('checked');
            }else{
                $("#tr_"+this.id).removeClass('checked');
            }
        });
		
		
		if(get_param('search')){$("[monxin-table] [type=search]").val(decodeURI(get_param('search')));}
		$("[monxin-table] [type=search]").keyup(function(event){
			keycode=event.which;
			if(keycode==13){
				url=window.location.href;
				url=replace_get(url,'search',$(this).val());
				url=replace_get(url,'current_page','1');
				window.location.href=url;	
			}	
		});
		if(get_param('page_size')){$("[monxin-table] #page_size").val(get_param('page_size'));}
        $("[monxin-table] #page_size").change(function(){
			url=window.location.href;
			url=replace_get(url,'page_size',$(this).val());
			url=replace_get(url,'current_page','1');
			window.location.href=url;	
        });
		
        $("[monxin-table] tbody tr td").click(function(event){
			if(event.target.tagName=='TD'){
				temp=($(this).parent().attr('class'));
				if(temp!=undefined){
					temp=temp.split(' ');
					if($.inArray("checked",temp)>-1){
						$(this).parent().removeClass('checked');
						$(this).parent().children("td").children('input[class="id"]').prop('checked',false);
					}else{
						$(this).parent().addClass('checked');
						$(this).parent().children("td").children('input[class="id"]').prop('checked',true);
					}
				}
			}
        });
		
		
		$("#search_filter").keyup(function(event){
			keycode=event.which;
			if(keycode==13){e_search();}	
		});
		
		$("#username").keyup(function(event){
			keycode=event.which;
			if(keycode==13){
				try {show_username();} catch (e) {}
			}	
		});
		
		
    });    
    function monxin_table_filter(id){
		if($("#"+id).prop("value")!=-1){
			key=id.replace("_filter","");
			url=window.location.href;
			url=replace_get(url,key,$("#"+id).prop("value"));
			url=replace_get(url,"current_page","");
			if(key!="search"){url=replace_get(url,"search","");}else{url=replace_get(url,"current_page","1");url=replace_get(url,"current_page","");}
			//monxin_alert(url);
			window.location.href=url;	
		}
		return false;
    }
	function e_search(){
		monxin_table_filter('search_filter');	
	}
	
	function set_current_order(order){
        if(order!='' && $(".current_order").html()==null){
			$('.sorting_desc,.sorting_asc').attr('class','sorting');
            $("a[desc='"+order+"']").attr('class','sorting_desc');
            $("a[asc='"+order+"']").attr('class','sorting_asc');
        }
		return false;
	}
	
    function select_all(){
		//monxin_alert('select_all');
        $("[monxin-table] tbody .id").prop('checked',true);
        $("[monxin-table] tbody tr").addClass('checked');
        return false;	
    }
    function reverse_select(){
        $("[monxin-table] tbody .id").each(function(){
            $(this).prop("checked",!this.checked);
            if($(this).prop('checked')){
                $("#tr_"+this.id).addClass('checked');
            }else{
                $("#tr_"+this.id).removeClass('checked');
            }
                  
        });
       return false; 	
    }
    
    function get_ids(){
        ids='';
        $("[monxin-table] tbody .id").each(function(){
            if($(this).prop("checked")){ids+=this.id+"|";}              
        });
        return ids;
    }
 //==================================================================================================================================monxin_table_end
 
 
 
 
 
 
 
 
 
 
 
 //====================================================图片滚动 调用方法 imgscroll({speed: 30,amount: 1,dir: "up"});
$.fn.imgscroll = function(o){
	var defaults = {
		speed: 40,
		amount: 0,
		width: 1,
		dir: "left"
	};
	o = $.extend(defaults, o);
	
	return this.each(function(){
		var _li = $("a", this);
		_li.parent().css({overflow: "hidden", position: "relative"}); //div
		_li.parent().css({margin: "0", padding: "0", overflow: "hidden", position: "relative", "list-style": "none"}); //ul
		_li.css({position: "relative", overflow: "hidden"}); //li
		if(o.dir == "left") _li.css({float: "left"});
		
		//初始大小
		var _li_size = 0;
		for(var i=0; i<_li.size(); i++)
			_li_size += o.dir == "left" ? _li.eq(i).outerWidth(true) : _li.eq(i).outerHeight(true);
		
		//循环所需要的元素
		if(o.dir == "left") _li.parent().css({width: (_li_size*3)+"px"});
		_li.parent().empty().append(_li.clone()).append(_li.clone()).append(_li.clone());
		_li = $("a", this);

		//滚动
		var _li_scroll = 0;
		function goto(){
			_li_scroll += o.width;
			if(_li_scroll > _li_size)
			{
				_li_scroll = 0;
				_li.parent().css(o.dir == "left" ? { left : -_li_scroll } : { top : -_li_scroll });
				_li_scroll += o.width;
			}
				_li.parent().animate(o.dir == "left" ? { left : -_li_scroll } : { top : -_li_scroll }, o.amount);
		}
		
		//开始
		var move = setInterval(function(){ goto(); }, o.speed);
		_li.parent().hover(function(){
			clearInterval(move);
		},function(){
			clearInterval(move);
			move = setInterval(function(){ goto(); }, o.speed);
		});
	});
};


/*******************************

	* rollGallery
	* Copyright (c) yeso!
	* Date: 2010-10-13

说明：
	* 必须对包裹子元素的直接父元素应用该方法
	* example: $("#picturewrap").rollGallery({ direction:"top",speed:2000,showNum:4,aniMethod:"easeOutCirc"});
	* direction:移动方向。可取值为："left" "top"
	* speed:速度。单位毫秒
	* noStep:设置为：true  则按非步进方式滚动。非步进下动画效果失效。
	* speedPx:非步进滚动下的移动速度。单位像素
	* showNum:显示个数。即父元素能容纳的子元素个数
	* rollNum:一次滚动的个数。注意总个数必须为rollNum的倍数！
	* aniSpeed:动画速度
	* aniMethod:动画方法（需插件（如：easing）支持）
	* childrenSel:子元素筛选器
*******************************/

;(function($){
	
$.fn.rollGallery=function( options ){
	
	var opts=$.extend({},$.fn.rollGallery.defaults,options);
	
	return this.each(function(){
		var _this=$(this);
		var step=0;
		var maxMove=0;
		var animateArgu=new Object();
		_this.intervalRGallery=null;
		
		if( opts.noStep&&(!options.speed) ) opts.speed=30;
		
		if( opts.direction=="left"){
			step=_this.children( opts.childrenSel ).outerWidth(true);
		}else{
			step=_this.children( opts.childrenSel ).outerHeight(true);
		}
		
		maxMove=-(step*_this.children( opts.childrenSel ).length);
		_this[0].maxMove=maxMove;
		if( opts.rollNum ) step*=opts.rollNum;	
		animateArgu[ opts.direction ]="-="+step;	
				
		_this.children( opts.childrenSel ).slice( 0,opts.showNum ).clone(true).appendTo( _this );
		_this.mouseover( function(){ clearInterval( _this.intervalRGallery ); });
		_this.mouseout( function(){ _this.intervalRGallery=setInterval( function(){
				if( parseInt(_this.css( opts.direction ))<=maxMove ){
					_this.css( opts.direction , "0px");
				}
				if( opts.noStep ){
					_this.css( opts.direction, (parseInt(_this.css( opts.direction ))-opts.speedPx+"px") );
				}
				else{
					_this.animate( animateArgu ,opts.aniSpeed,opts.aniMethod );
				}
			}, opts.speed );});
		
		_this.mouseout();
	});
			
};

$.fn.rollGallery.defaults={
	direction : "left",
	speed : 3000,
	noStep : false,
	speedPx : 1,
	showNum : 1,
	aniSpeed:"slow",
	aniMethod:"swing",
	childrenSel:"*"
};

$.fn.extend({
	"preventScroll":function(){
		$(this).each(function(){
			var _this = this;
			if(navigator.userAgent.indexOf('Firefox') >= 0){   //firefox
				_this.addEventListener('DOMMouseScroll',function(e){
					_this.scrollTop += e.detail > 0 ? 60 : -60;   
					e.preventDefault();
				},false); 
			}else{
				_this.onmousewheel = function(e){   
					e = e || window.event;   
					_this.scrollTop += e.wheelDelta > 0 ? -60 : 60;   
					return false;
				};
			}
		})	
	}
});	
$.fn.toggle = function( fn, fn2 ) {
    var args = arguments,guid = fn.guid || $.guid++,i=0,
    toggler = function( event ) {
      var lastToggle = ( $._data( this, "lastToggle" + fn.guid ) || 0 ) % i;
      $._data( this, "lastToggle" + fn.guid, lastToggle + 1 );
      event.preventDefault();
      return args[ lastToggle ].apply( this, arguments ) || false;
    };
    toggler.guid = guid;
    while ( i < args.length ) {
      args[ i++ ].guid = guid;
    }
    return this.click( toggler );
  };
})(jQuery);

function get_share_img(){
	if(get_param('monxin')==''){
		imgUrl='http://'+window.location.host+'/favicon.ico';
	}else{
		first_img='';
		$(".page-container img").each(function(index, element) {
            if($(this).attr('src').length>10){first_img=$(this).attr('src');return false;}
        });
		if(first_img.length>10){
			imgUrl='http://'+window.location.host+'/'+first_img;
		}else{
			imgUrl='http://'+window.location.host+'/favicon.ico';
		}
	}
	return  imgUrl;
}

function get_remain_time(end){
	timestamp=Date.parse(new Date());
	timestamp=timestamp/1000;
	remain=end-timestamp;
	if(remain<=0){return false;}
	r=new Array();
	r['y']=0;r['m']=0;r['d']=0;r['h']=0;r['i']=0;r['s']=0;
	if(remain>=(86400*365)){r['y']=parseInt(remain/(86400*365));if(r['y']>0){remain-=86400*365*r['y'];}}
	if(remain>=(86400*30)){r['m']=parseInt(remain/(86400*30));if(r['m']>0){remain-=86400*30*r['m'];}}
	if(remain>=(86400*1)){r['d']=parseInt(remain/(86400*1));if(r['d']>0){remain-=86400*1*r['d'];}}
	if(remain>=3600){r['h']=parseInt(remain/3600);if(r['h']>0){remain-=3600*r['h'];}}
	if(remain>=60){r['i']=parseInt(remain/60);if(r['i']>0){remain-=60*r['i'];}}
	r['s']=remain;
	for(v in r){
		if(parseInt(r[v])<0){r[v]='0';}	
		if(parseInt(r[v])<10){r[v]='0'+r[v];}	
	}
	return r;
	//document.getElementById("remain").innerHTML=r['y']+' '+r['m']+' '+r['d']+' '+r['h']+' '+r['i']+' '+r['s'];
}



//get_unix_time('2016-04-05 00:22:11');
function get_unix_time(dateStr){
    var newstr = dateStr.replace(/-/g,'/'); 
    var date =  new Date(newstr); 
    var time_str = date.getTime().toString();
    return time_str.substr(0, 10);
}
/*  use_demo
	function update_remain001(end){
		remain=get_remain_time(end);
		if(remain){
			for(v in remain){
				if(remain[v]=='00'  && v!='h' && v!='i' && v!='s'){$("#remain001 [d="+v+"]").css('display','none');}else{$("#remain001 [d="+v+"]").css('display','inline-block');}
				$("#remain001 [d="+v+"] .v").html(remain[v]);	
			}	
		}else{
			$("#remain001").html('end');
		}
	}
$(document).ready(function(){
	end='2016-04-05 00:22:11';
	if(end==''){
		timestamp=Date.parse(new Date());
		timestamp+=Math.floor(Math.random()*10)*3000000;
		var d = new Date(timestamp );    //根据时间戳生成的时间对象
		var end = (d.getFullYear()) + "-" + 
				   (d.getMonth() + 1) + "-" +
				   (d.getDate()) + " " + 
				   (d.getHours()) + ":" + 
				   (d.getMinutes()) + ":" + 
				   (d.getSeconds());	
	}
	end=get_unix_time(end);
	update_remain001(end);
	setInterval( "update_remain001("+end+")",1000);
});

*/


!function(a,b){"function"==typeof define&&(define.amd||define.cmd)?define(function(){return b(a)}):b(a,!0)}(this,function(a,b){function c(b,c,d){a.WeixinJSBridge?WeixinJSBridge.invoke(b,e(c),function(a){g(b,a,d)}):j(b,d)}function d(b,c,d){a.WeixinJSBridge?WeixinJSBridge.on(b,function(a){d&&d.trigger&&d.trigger(a),g(b,a,c)}):d?j(b,d):j(b,c)}function e(a){return a=a||{},a.appId=E.appId,a.verifyAppId=E.appId,a.verifySignType="sha1",a.verifyTimestamp=E.timestamp+"",a.verifyNonceStr=E.nonceStr,a.verifySignature=E.signature,a}function f(a){return{timeStamp:a.timestamp+"",nonceStr:a.nonceStr,"package":a.package,paySign:a.paySign,signType:a.signType||"SHA1"}}function g(a,b,c){var d,e,f;switch(delete b.err_code,delete b.err_desc,delete b.err_detail,d=b.errMsg,d||(d=b.err_msg,delete b.err_msg,d=h(a,d),b.errMsg=d),c=c||{},c._complete&&(c._complete(b),delete c._complete),d=b.errMsg||"",E.debug&&!c.isInnerInvoke&&alert(JSON.stringify(b)),e=d.indexOf(":"),f=d.substring(e+1)){case"ok":c.success&&c.success(b);break;case"cancel":c.cancel&&c.cancel(b);break;default:c.fail&&c.fail(b)}c.complete&&c.complete(b)}function h(a,b){var e,f,c=a,d=p[c];return d&&(c=d),e="ok",b&&(f=b.indexOf(":"),e=b.substring(f+1),"confirm"==e&&(e="ok"),"failed"==e&&(e="fail"),-1!=e.indexOf("failed_")&&(e=e.substring(7)),-1!=e.indexOf("fail_")&&(e=e.substring(5)),e=e.replace(/_/g," "),e=e.toLowerCase(),("access denied"==e||"no permission to execute"==e)&&(e="permission denied"),"config"==c&&"function not exist"==e&&(e="ok"),""==e&&(e="fail")),b=c+":"+e}function i(a){var b,c,d,e;if(a){for(b=0,c=a.length;c>b;++b)d=a[b],e=o[d],e&&(a[b]=e);return a}}function j(a,b){if(!(!E.debug||b&&b.isInnerInvoke)){var c=p[a];c&&(a=c),b&&b._complete&&delete b._complete,console.log('"'+a+'",',b||"")}}function k(){0!=D.preVerifyState&&(u||v||E.debug||"6.0.2">z||D.systemType<0||A||(A=!0,D.appId=E.appId,D.initTime=C.initEndTime-C.initStartTime,D.preVerifyTime=C.preVerifyEndTime-C.preVerifyStartTime,H.getNetworkType({isInnerInvoke:!0,success:function(a){var b,c;D.networkType=a.networkType,b="http://open.weixin.qq.com/sdk/report?v="+D.version+"&o="+D.preVerifyState+"&s="+D.systemType+"&c="+D.clientVersion+"&a="+D.appId+"&n="+D.networkType+"&i="+D.initTime+"&p="+D.preVerifyTime+"&u="+D.url,c=new Image,c.src=b}})))}function l(){return(new Date).getTime()}function m(b){w&&(a.WeixinJSBridge?b():q.addEventListener&&q.addEventListener("WeixinJSBridgeReady",b,!1))}function n(){H.invoke||(H.invoke=function(b,c,d){a.WeixinJSBridge&&WeixinJSBridge.invoke(b,e(c),d)},H.on=function(b,c){a.WeixinJSBridge&&WeixinJSBridge.on(b,c)})}var o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H;if(!a.jWeixin)return o={config:"preVerifyJSAPI",onMenuShareTimeline:"menu:share:timeline",onMenuShareAppMessage:"menu:share:appmessage",onMenuShareQQ:"menu:share:qq",onMenuShareWeibo:"menu:share:weiboApp",onMenuShareQZone:"menu:share:QZone",previewImage:"imagePreview",getLocation:"geoLocation",openProductSpecificView:"openProductViewWithPid",addCard:"batchAddCard",openCard:"batchViewCard",chooseWXPay:"getBrandWCPayRequest"},p=function(){var b,a={};for(b in o)a[o[b]]=b;return a}(),q=a.document,r=q.title,s=navigator.userAgent.toLowerCase(),t=navigator.platform.toLowerCase(),u=!(!t.match("mac")&&!t.match("win")),v=-1!=s.indexOf("wxdebugger"),w=-1!=s.indexOf("micromessenger"),x=-1!=s.indexOf("android"),y=-1!=s.indexOf("iphone")||-1!=s.indexOf("ipad"),z=function(){var a=s.match(/micromessenger\/(\d+\.\d+\.\d+)/)||s.match(/micromessenger\/(\d+\.\d+)/);return a?a[1]:""}(),A=!1,B=!1,C={initStartTime:l(),initEndTime:0,preVerifyStartTime:0,preVerifyEndTime:0},D={version:1,appId:"",initTime:0,preVerifyTime:0,networkType:"",preVerifyState:1,systemType:y?1:x?2:-1,clientVersion:z,url:encodeURIComponent(location.href)},E={},F={_completes:[]},G={state:0,data:{}},m(function(){C.initEndTime=l()}),H={config:function(a){E=a,j("config",a);var b=E.check===!1?!1:!0;m(function(){var a,d,e;if(b)c(o.config,{verifyJsApiList:i(E.jsApiList)},function(){F._complete=function(a){C.preVerifyEndTime=l(),G.state=1,G.data=a},F.success=function(){D.preVerifyState=0},F.fail=function(a){F._fail?F._fail(a):G.state=-1};var a=F._completes;return a.push(function(){k()}),F.complete=function(){for(var c=0,d=a.length;d>c;++c)a[c]();F._completes=[]},F}()),C.preVerifyStartTime=l();else{for(G.state=1,a=F._completes,d=0,e=a.length;e>d;++d)a[d]();F._completes=[]}}),E.beta&&n()},ready:function(a){0!=G.state?a():(F._completes.push(a),!w&&E.debug&&a())},error:function(a){"6.0.2">z||B||(B=!0,-1==G.state?a(G.data):F._fail=a)},checkJsApi:function(a){var b=function(a){var c,d,b=a.checkResult;for(c in b)d=p[c],d&&(b[d]=b[c],delete b[c]);return a};c("checkJsApi",{jsApiList:i(a.jsApiList)},function(){return a._complete=function(a){if(x){var c=a.checkResult;c&&(a.checkResult=JSON.parse(c))}a=b(a)},a}())},onMenuShareTimeline:function(a){d(o.onMenuShareTimeline,{complete:function(){c("shareTimeline",{title:a.title||r,desc:a.title||r,img_url:a.imgUrl||"",link:a.link||location.href,type:a.type||"link",data_url:a.dataUrl||""},a)}},a)},onMenuShareAppMessage:function(a){d(o.onMenuShareAppMessage,{complete:function(){c("sendAppMessage",{title:a.title||r,desc:a.desc||"",link:a.link||location.href,img_url:a.imgUrl||"",type:a.type||"link",data_url:a.dataUrl||""},a)}},a)},onMenuShareQQ:function(a){d(o.onMenuShareQQ,{complete:function(){c("shareQQ",{title:a.title||r,desc:a.desc||"",img_url:a.imgUrl||"",link:a.link||location.href},a)}},a)},onMenuShareWeibo:function(a){d(o.onMenuShareWeibo,{complete:function(){c("shareWeiboApp",{title:a.title||r,desc:a.desc||"",img_url:a.imgUrl||"",link:a.link||location.href},a)}},a)},onMenuShareQZone:function(a){d(o.onMenuShareQZone,{complete:function(){c("shareQZone",{title:a.title||r,desc:a.desc||"",img_url:a.imgUrl||"",link:a.link||location.href},a)}},a)},startRecord:function(a){c("startRecord",{},a)},stopRecord:function(a){c("stopRecord",{},a)},onVoiceRecordEnd:function(a){d("onVoiceRecordEnd",a)},playVoice:function(a){c("playVoice",{localId:a.localId},a)},pauseVoice:function(a){c("pauseVoice",{localId:a.localId},a)},stopVoice:function(a){c("stopVoice",{localId:a.localId},a)},onVoicePlayEnd:function(a){d("onVoicePlayEnd",a)},uploadVoice:function(a){c("uploadVoice",{localId:a.localId,isShowProgressTips:0==a.isShowProgressTips?0:1},a)},downloadVoice:function(a){c("downloadVoice",{serverId:a.serverId,isShowProgressTips:0==a.isShowProgressTips?0:1},a)},translateVoice:function(a){c("translateVoice",{localId:a.localId,isShowProgressTips:0==a.isShowProgressTips?0:1},a)},chooseImage:function(a){c("chooseImage",{scene:"1|2",count:a.count||9,sizeType:a.sizeType||["original","compressed"],sourceType:a.sourceType||["album","camera"]},function(){return a._complete=function(a){if(x){var b=a.localIds;b&&(a.localIds=JSON.parse(b))}},a}())},previewImage:function(a){c(o.previewImage,{current:a.current,urls:a.urls},a)},uploadImage:function(a){c("uploadImage",{localId:a.localId,isShowProgressTips:0==a.isShowProgressTips?0:1},a)},downloadImage:function(a){c("downloadImage",{serverId:a.serverId,isShowProgressTips:0==a.isShowProgressTips?0:1},a)},getNetworkType:function(a){var b=function(a){var c,d,e,b=a.errMsg;if(a.errMsg="getNetworkType:ok",c=a.subtype,delete a.subtype,c)a.networkType=c;else switch(d=b.indexOf(":"),e=b.substring(d+1)){case"wifi":case"edge":case"wwan":a.networkType=e;break;default:a.errMsg="getNetworkType:fail"}return a};c("getNetworkType",{},function(){return a._complete=function(a){a=b(a)},a}())},openLocation:function(a){c("openLocation",{latitude:a.latitude,longitude:a.longitude,name:a.name||"",address:a.address||"",scale:a.scale||28,infoUrl:a.infoUrl||""},a)},getLocation:function(a){a=a||{},c(o.getLocation,{type:a.type||"wgs84"},function(){return a._complete=function(a){delete a.type},a}())},hideOptionMenu:function(a){c("hideOptionMenu",{},a)},showOptionMenu:function(a){c("showOptionMenu",{},a)},closeWindow:function(a){a=a||{},c("closeWindow",{},a)},hideMenuItems:function(a){c("hideMenuItems",{menuList:a.menuList},a)},showMenuItems:function(a){c("showMenuItems",{menuList:a.menuList},a)},hideAllNonBaseMenuItem:function(a){c("hideAllNonBaseMenuItem",{},a)},showAllNonBaseMenuItem:function(a){c("showAllNonBaseMenuItem",{},a)},scanQRCode:function(a){a=a||{},c("scanQRCode",{needResult:a.needResult||0,scanType:a.scanType||["qrCode","barCode"]},function(){return a._complete=function(a){var b,c;y&&(b=a.resultStr,b&&(c=JSON.parse(b),a.resultStr=c&&c.scan_code&&c.scan_code.scan_result))},a}())},openProductSpecificView:function(a){c(o.openProductSpecificView,{pid:a.productId,view_type:a.viewType||0,ext_info:a.extInfo},a)},addCard:function(a){var e,f,g,h,b=a.cardList,d=[];for(e=0,f=b.length;f>e;++e)g=b[e],h={card_id:g.cardId,card_ext:g.cardExt},d.push(h);c(o.addCard,{card_list:d},function(){return a._complete=function(a){var c,d,e,b=a.card_list;if(b){for(b=JSON.parse(b),c=0,d=b.length;d>c;++c)e=b[c],e.cardId=e.card_id,e.cardExt=e.card_ext,e.isSuccess=e.is_succ?!0:!1,delete e.card_id,delete e.card_ext,delete e.is_succ;a.cardList=b,delete a.card_list}},a}())},chooseCard:function(a){c("chooseCard",{app_id:E.appId,location_id:a.shopId||"",sign_type:a.signType||"SHA1",card_id:a.cardId||"",card_type:a.cardType||"",card_sign:a.cardSign,time_stamp:a.timestamp+"",nonce_str:a.nonceStr},function(){return a._complete=function(a){a.cardList=a.choose_card_info,delete a.choose_card_info},a}())},openCard:function(a){var e,f,g,h,b=a.cardList,d=[];for(e=0,f=b.length;f>e;++e)g=b[e],h={card_id:g.cardId,code:g.code},d.push(h);c(o.openCard,{card_list:d},a)},chooseWXPay:function(a){c(o.chooseWXPay,f(a),a)}},b&&(a.wx=a.jWeixin=H),H});
/*
 * jQuery liMarquee v 4.6
 *
 * Copyright 2013, Linnik Yura | LI MASS CODE | http://masscode.ru
 * http://masscode.ru/index.php/k2/item/44-limarquee
 * Free to use
 *
 * Last Update 20.11.2014
 */
(function ($) {
	var methods = {
		init: function (options) {
			var p = {
				direction: 'left', //Указывает направление движения содержимого контейнера (left | right | up | down)
				loop: -1, //Задает, сколько раз будет прокручиваться содержимое. "-1" для бесконечного воспроизведения движения
				scrolldelay: 0, //Величина задержки в миллисекундах между движениями
				scrollamount: 50, //Скорость движения контента (px/sec)
				circular: true, //Если "true" - строка непрерывная 
				drag: true, //Если "true" - включено перетаскивание строки
				runshort: true, //Если "true" - короткая строка тоже "бегает", "false" - стоит на месте
				hoverstop: true, //true - строка останавливается при наведении курсора мыши, false - строка не останавливается
				inverthover: false, //false - стандартное поведение. Если "true" - строка начинает движение только при наведении курсора
				xml: false //Путь к xml файлу с нужным текстом
			};
			if (options) {
				$.extend(p, options);
			}

			return this.each(function () {
				var enterEvent = 'mouseenter';
				var leaveEvent = 'mouseleave';
				if(p.inverthover){
					enterEvent = 'mouseleave';
					leaveEvent = 'mouseenter';	
				}
				
								
				var
					loop = p.loop,
					strWrap = $(this).addClass('str_wrap').data({scrollamount:p.scrollamount}),
					fMove = false;
					
				
				
				var strWrapStyle = strWrap.attr('style'); 
				
				if(strWrapStyle){
					var wrapStyleArr = strWrapStyle.split(';');
					var startHeight = false;
					for(var i=0; i < wrapStyleArr.length; i++){
						var str = $.trim(wrapStyleArr[i]);					
						var tested =  str.search(/^height/g);
						if(tested != -1){
							startHeight = parseFloat(strWrap.css('height'));
						}
					}
				}

				var code = function () {
					
					strWrap.off('mouseleave');
					strWrap.off('mouseenter');
					strWrap.off('mousemove');
					strWrap.off('mousedown');
					strWrap.off('mouseup');

					
					if(!$('.str_move',strWrap).length){
						strWrap.wrapInner($('<div>').addClass('str_move'));
					}
					
					var
					strMove = $('.str_move', strWrap).addClass('str_origin'),
					strMoveClone = strMove.clone().removeClass('str_origin').addClass('str_move_clone'),
					time = 0;

					if (!p.hoverstop) {
						strWrap.addClass('noStop');
					}

					var circCloneHor = function(){
						strMoveClone.clone().css({
							left:'100%',
							right:'auto',							
							width: strMove.width()
						}).appendTo(strMove);
						strMoveClone.css({
							right: '100%',
							left:'auto',
							width: strMove.width()
						}).appendTo(strMove);
					}
					
					var circCloneVert = function(){
						strMoveClone.clone().css({
							top: '100%',
							bottom:'auto',
							height: strMove.height()
						}).appendTo(strMove);
						strMoveClone.css({
							bottom: '100%',
							top:'auto',
							height:strMove.height()
						}).appendTo(strMove);
					}
					
					
					
					if (p.direction == 'left') {
						strWrap.height(strMove.outerHeight())
						if (strMove.width() > strWrap.width()) {
							var leftPos = -strMove.width();
							
							if (p.circular) {
								
								if (!p.xml) {
									circCloneHor()
									leftPos = -(strMove.width() + (strMove.width() - strWrap.width()));
								}
							}
							if (p.xml) {
								strMove.css({
									left:strWrap.width()	
								})
							}
							var
							strMoveLeft = strWrap.width(),
								k1 = 0,
								timeFunc1 = function () {
									var
									fullS = Math.abs(leftPos),
										time = (fullS / strWrap.data('scrollamount')) * 1000;
									if (parseFloat(strMove.css('left')) != 0) {
										fullS = (fullS + strWrap.width());
										time = (fullS - (strWrap.width() - parseFloat(strMove.css('left')))) / strWrap.data('scrollamount') * 1000;
									}
									return time;
								},
								moveFuncId1 = false,
								moveFunc1 = function () {
									if (loop != 0) {
										strMove.stop(true).animate({
											left: leftPos
										}, timeFunc1(), 'linear', function () {
											$(this).css({
												left: strWrap.width()
											});
											if (loop == -1) {
												moveFuncId1 = setTimeout(moveFunc1, p.scrolldelay);
											} else {
												loop--;
												moveFuncId1 = setTimeout(moveFunc1, p.scrolldelay);
											}
										});
									}
								};
								strWrap.data({
									moveId: moveFuncId1	,
									moveF : moveFunc1
								})
								if(!p.inverthover){
									moveFunc1();
								}
							
							if (p.hoverstop) {
								strWrap.on(enterEvent, function () {
									$(this).addClass('str_active');
									clearTimeout(moveFuncId1);
									strMove.stop(true);
								}).on(leaveEvent, function () {
									$(this).removeClass('str_active');
									$(this).off('mousemove');
									moveFunc1();
								});

								if (p.drag) {
									strWrap.on('mousedown', function (e) {
										if(p.inverthover){
											strMove.stop(true);
										}
										//drag
										var dragLeft;
										var dir = 1;
										var newX;
										var oldX = e.clientX;
										//drag
										
										strMoveLeft = strMove.position().left;
										k1 = strMoveLeft - (e.clientX - strWrap.offset().left);
										
										
										
										$(this).on('mousemove', function (e) {
											fMove = true;
											
											//drag
											newX = e.clientX;
											if(newX > oldX){
												dir = 1
											}else{
												dir = -1
											}
											oldX = newX	
											dragLeft = k1 + (e.clientX - strWrap.offset().left);
											
											if (!p.circular) {
												if(dragLeft < -strMove.width() && dir < 0){
													dragLeft = strWrap.width();
													strMoveLeft = strMove.position().left;
													k1 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}
												if(dragLeft > strWrap.width() && dir > 0){
													dragLeft = -strMove.width();
													strMoveLeft = strMove.position().left;
													k1 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}
											}else{
												if(dragLeft < -strMove.width() && dir < 0){
													dragLeft = 0;
													strMoveLeft = strMove.position().left;
													k1 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}
												if(dragLeft > 0 && dir > 0){
													dragLeft = -strMove.width();
													strMoveLeft = strMove.position().left;
													k1 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}
	
											}
											
											
											strMove.stop(true).css({
												left: dragLeft
											});
											//drag
											
										
											
										}).on('mouseup', function () {
											$(this).off('mousemove');
											if(p.inverthover){
												strMove.trigger('mouseenter')
											}
											setTimeout(function () {                             
												fMove = false
											}, 50)
											
										});
										return false;
									})
									.on('click', function () {
										if (fMove) {
											return false
										}
									});
								} else {
									strWrap.addClass('no_drag');
								};
							}
						} else {
							if (p.runshort) {
								strMove.css({
									left: strWrap.width()
								});
								var
								strMoveLeft = strWrap.width(),
									k1 = 0,
									timeFunc = function () {
										time = (strMove.width() + strMove.position().left) / strWrap.data('scrollamount') * 1000;
										return time;
									};
								var moveFunc = function () {
									var leftPos = -strMove.width();
									strMove.animate({
										left: leftPos
									}, timeFunc(), 'linear', function () {
										$(this).css({
											left: strWrap.width()
										});
										if (loop == -1) {
											setTimeout(moveFunc, p.scrolldelay);
										} else {
											loop--;
											setTimeout(moveFunc, p.scrolldelay);
										}
									});
								};
								strWrap.data({
									moveF : moveFunc
								})
								if(!p.inverthover){
									moveFunc();
								}
								if (p.hoverstop) {
									strWrap.on(enterEvent, function () {
										$(this).addClass('str_active');
										strMove.stop(true);
									}).on(leaveEvent, function () {
										$(this).removeClass('str_active');
										$(this).off('mousemove');
										moveFunc();
									});

									if (p.drag) {
										strWrap.on('mousedown', function (e) {
											if(p.inverthover){
												strMove.stop(true);
											}
											
											//drag
											var dragLeft;
											var dir = 1;
											var newX;
											var oldX = e.clientX;
											//drag
											
											strMoveLeft = strMove.position().left;
											k1 = strMoveLeft - (e.clientX - strWrap.offset().left);
											$(this).on('mousemove', function (e) {
												fMove = true;
												
												
												//drag
												newX = e.clientX;
												if(newX > oldX){
													dir = 1
												}else{
													dir = -1
												}
												oldX = newX	
												dragLeft = k1 + (e.clientX - strWrap.offset().left);
												
												if(dragLeft < -strMove.width() && dir < 0){
													dragLeft = strWrap.width();
													strMoveLeft = strMove.position().left;
													k1 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}
												if(dragLeft > strWrap.width() && dir > 0){
													dragLeft = -strMove.width();
													strMoveLeft = strMove.position().left;
													k1 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}
												
												
												strMove.stop(true).css({
													left: dragLeft
												});
												
												
												
											}).on('mouseup', function () {
												if(p.inverthover){
													strMove.trigger('mouseenter')
												}
												$(this).off('mousemove');
												setTimeout(function () {                             
													fMove = false
												}, 50)
											});
											return false;
										})
										.on('click', function () {
											if (fMove) {
												return false
											}
										});
									} else {
										strWrap.addClass('no_drag');
									};
								}
							} else {
								strWrap.addClass('str_static');
							}
						};
					};
					if (p.direction == 'right') {
						strWrap.height(strMove.outerHeight())
						strWrap.addClass('str_right');
						strMove.css({
							left: -strMove.width(),
							right: 'auto'
						})
						
						if (strMove.width() > strWrap.width()) {
							var leftPos = strWrap.width();
							strMove.css({
								left: 0
							})
							if (p.circular) {
								if (!p.xml) {
									circCloneHor()
									//Определяем крайнюю точку
									leftPos = strMove.width();
								}
							}
							
							var
							k2 = 0;
							timeFunc = function () {
								var
								fullS = strWrap.width(), //крайняя точка
									time = (fullS / strWrap.data('scrollamount')) * 1000; //время
								if (parseFloat(strMove.css('left')) != 0) {
									fullS = (strMove.width() + strWrap.width());
									time = (fullS - (strMove.width() + parseFloat(strMove.css('left')))) / strWrap.data('scrollamount') * 1000;
								}
								return time;
							};
							var moveFunc = function () {

								if (loop != 0) {
									strMove.animate({
										left: leftPos
									}, timeFunc(), 'linear', function () {
										$(this).css({
											left: -strMove.width()
										});
										if (loop == -1) {
											setTimeout(moveFunc, p.scrolldelay);
										} else {
											loop--;
											setTimeout(moveFunc, p.scrolldelay);
										};
									});
								};
							};
							strWrap.data({
								moveF : moveFunc
							})
					
							if(!p.inverthover){
								moveFunc();
							}
							if (p.hoverstop) {
								strWrap.on(enterEvent, function () {
									$(this).addClass('str_active');
									strMove.stop(true);
								}).on(leaveEvent, function () {
									$(this).removeClass('str_active');
									$(this).off('mousemove');
									moveFunc();
								});

								if (p.drag) {
									
									strWrap.on('mousedown', function (e) {
										if(p.inverthover){
											strMove.stop(true);
										}
										
										
										//drag
										var dragLeft;
										var dir = 1;
										var newX;
										var oldX = e.clientX;
										//drag
										
										strMoveLeft = strMove.position().left;
										k2 = strMoveLeft - (e.clientX - strWrap.offset().left);
										$(this).on('mousemove', function (e) {
											
											fMove = true;
											
											//drag
											newX = e.clientX;
											if(newX > oldX){
												dir = 1
											}else{
												dir = -1
											}
											oldX = newX	
											dragLeft = k2 + (e.clientX - strWrap.offset().left);


											if (!p.circular) {

												if(dragLeft < -strMove.width() && dir < 0){
													dragLeft = strWrap.width();
													strMoveLeft = strMove.position().left;
													k2 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}
												if(dragLeft > strWrap.width() && dir > 0){
													dragLeft = -strMove.width();
													strMoveLeft = strMove.position().left;
													k2 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}
											}else{
												if(dragLeft < -strMove.width() && dir < 0){
													dragLeft = 0;
													strMoveLeft = strMove.position().left;
													k2 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}
												if(dragLeft > 0 && dir > 0){
													dragLeft = -strMove.width();
													strMoveLeft = strMove.position().left;
													k2 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}
	
											}
											
											strMove.stop(true).css({
												left: dragLeft
											});
											

										}).on('mouseup', function () {
											if(p.inverthover){
												strMove.trigger('mouseenter')
											}
											$(this).off('mousemove');
											setTimeout(function () {                             
												fMove = false
											}, 50)
										});
										return false;
									})
									.on('click', function () {
										if (fMove) {
											return false
										}
									});
								} else {
									strWrap.addClass('no_drag');
								};
							}
						} else {
														
							if (p.runshort) {
								
								var k2 = 0;
								var timeFunc = function () {
									time = (strWrap.width() - strMove.position().left) / strWrap.data('scrollamount') * 1000;
									return time;
								};
								var moveFunc = function () {
									var leftPos = strWrap.width();
									strMove.animate({
										left: leftPos
									}, timeFunc(), 'linear', function () {
										$(this).css({
											left: -strMove.width()
										});
										if (loop == -1) {
											setTimeout(moveFunc, p.scrolldelay);
										} else {
											loop--;
											setTimeout(moveFunc, p.scrolldelay);
										};
									});
								};

								strWrap.data({
									moveF : moveFunc
								})

								if(!p.inverthover){
									moveFunc();
								}
								if (p.hoverstop) {
									strWrap.on(enterEvent, function () {
										$(this).addClass('str_active');
										strMove.stop(true);
									}).on(leaveEvent, function () {
										$(this).removeClass('str_active');
										$(this).off('mousemove');
										moveFunc();
									});

									if (p.drag) {
										strWrap.on('mousedown', function (e) {
											if(p.inverthover){
												strMove.stop(true);
											}
											
											//drag
											var dragLeft;
											var dir = 1;
											var newX;
											var oldX = e.clientX;
											//drag
											
											strMoveLeft = strMove.position().left;
											k2 = strMoveLeft - (e.clientX - strWrap.offset().left);
											$(this).on('mousemove', function (e) {
												fMove = true;
												
												
												
												//drag
												newX = e.clientX;
												if(newX > oldX){
													dir = 1
												}else{
													dir = -1
												}
												oldX = newX	
												dragLeft = k2 + (e.clientX - strWrap.offset().left);
												
												if(dragLeft < -strMove.width() && dir < 0){
													dragLeft = strWrap.width();
													strMoveLeft = strMove.position().left;
													k2 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}
												if(dragLeft > strWrap.width() && dir > 0){
													dragLeft = -strMove.width();
													strMoveLeft = strMove.position().left;
													k2 = strMoveLeft - (e.clientX - strWrap.offset().left);
												}

												strMove.stop(true).css({
													left:dragLeft
												});
												
											}).on('mouseup', function () {
												if(p.inverthover){
													strMove.trigger('mouseenter')
												}
												$(this).off('mousemove');
												setTimeout(function () {                             
													fMove = false
												}, 50)
											});
											return false;
										})
										.on('click', function () {
											if (fMove) {
												return false
											}
										});
									} else {
										strWrap.addClass('no_drag');
									};
								}
							} else {
								strWrap.addClass('str_static');
							}
						};
					};
					if (p.direction == 'up') {
						strWrap.addClass('str_vertical');
						
						if (strMove.height() > strWrap.height()) {
							var topPos = -strMove.height();
							if (p.circular) {
								if (!p.xml) {
									circCloneVert();									
									topPos = -(strMove.height() + (strMove.height() - strWrap.height()));
								}
							}
							if (p.xml) {
								strMove.css({
									top:strWrap.height()	
								})
							}
							var
							k2 = 0;
							timeFunc = function () {
								var
								fullS = Math.abs(topPos),
									time = (fullS / strWrap.data('scrollamount')) * 1000;
								if (parseFloat(strMove.css('top')) != 0) {
									fullS = (fullS + strWrap.height());
									time = (fullS - (strWrap.height() - parseFloat(strMove.css('top')))) / strWrap.data('scrollamount') * 1000;
								}
								
								return time;
							};
							var moveFunc = function () {
								if (loop != 0) {
									strMove.animate({
										top: topPos
									}, timeFunc(), 'linear', function () {
										$(this).css({
											top: strWrap.height()
										});
										if (loop == -1) {
											setTimeout(moveFunc, p.scrolldelay);
										} else {
											loop--;
											setTimeout(moveFunc, p.scrolldelay);
										};
									});
								};
							};
							
							strWrap.data({
								moveF : moveFunc
							})
							
							if(!p.inverthover){
								moveFunc();
							}
							if (p.hoverstop) {
								strWrap.on(enterEvent, function () {
									$(this).addClass('str_active');
									strMove.stop(true);
								}).on(leaveEvent, function () {
									$(this).removeClass('str_active');
									$(this).off('mousemove');
									moveFunc();
								});

								if (p.drag) {
									strWrap.on('mousedown', function (e) {
										if(p.inverthover){
											strMove.stop(true);
										}
										
										//drag
										var dragTop;
										var dir = 1;
										var newY;
										var oldY = e.clientY;
										//drag
										
										
										strMoveTop = strMove.position().top;
										k2 = strMoveTop - (e.clientY - strWrap.offset().top);
										$(this).on('mousemove', function (e) {
											
											fMove = true;

											//drag
											newY = e.clientY;
											if(newY > oldY){
												dir = 1
											}else{
												if(newY < oldY){
													dir = -1
												}
											}
											oldY = newY	
											dragTop = k2 + e.clientY - strWrap.offset().top;


											if (!p.circular){
												if(dragTop < -strMove.height() && dir < 0){
													dragTop = strWrap.height();
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}
												if(dragTop > strWrap.height() && dir > 0){
													dragTop = -strMove.height();
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}	
											}else{
												if(dragTop < -strMove.height() && dir < 0){
													dragTop = 0;
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}
												if(dragTop > 0 && dir > 0){
													dragTop = -strMove.height();
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}
											}


											strMove.stop(true).css({
												top: dragTop
											});
											//drag
											
											
											
											
											
											
											
											
											
											
											
											
										}).on('mouseup', function () {
											if(p.inverthover){
												strMove.trigger('mouseenter')
											}
											$(this).off('mousemove');
											setTimeout(function () {                             
												fMove = false
											}, 50)
										});
										return false;
									})
									.on('click', function () {
										if (fMove) {
											return false
										}
									});
								} else {
									strWrap.addClass('no_drag');
								};
							}
						} else {
							if (p.runshort) {
								strMove.css({
									top: strWrap.height()
								});
								var k2 = 0;
								var timeFunc = function () {
									
									time = (strMove.height() + strMove.position().top) / strWrap.data('scrollamount') * 1000;
									
									return time;
								};
								var moveFunc = function () {
									var topPos = -strMove.height();
									strMove.animate({
										top: topPos
									}, timeFunc(), 'linear', function () {
										$(this).css({
											top: strWrap.height()
										});
										if (loop == -1) {
											setTimeout(moveFunc, p.scrolldelay);
										} else {
											loop--;
											setTimeout(moveFunc, p.scrolldelay);
										};
									});
								};
								strWrap.data({
									moveF : moveFunc
								})
								if(!p.inverthover){
									moveFunc();
								}
								if (p.hoverstop) {
									strWrap.on(enterEvent, function () {
										$(this).addClass('str_active');
										strMove.stop(true);
									}).on(leaveEvent, function () {
										$(this).removeClass('str_active');
										$(this).off('mousemove');
										moveFunc();
									});

									if (p.drag) {
										strWrap.on('mousedown', function (e) {
											if(p.inverthover){
												strMove.stop(true);
											}
											
											//drag
											var dragTop;
											var dir = 1;
											var newY;
											var oldY = e.clientY;
											//drag
											
											strMoveTop = strMove.position().top;
											k2 = strMoveTop - (e.clientY - strWrap.offset().top);
											$(this).on('mousemove', function (e) {
												
												
												fMove = true;

												//drag
												newY = e.clientY;
												if(newY > oldY){
													dir = 1
												}else{
													if(newY < oldY){
														dir = -1
													}
												}
												oldY = newY	
												dragTop = k2 + e.clientY - strWrap.offset().top;
												
												if(dragTop < -strMove.height() && dir < 0){
													dragTop = strWrap.height();
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}
												if(dragTop > strWrap.height() && dir > 0){
													dragTop = -strMove.height();
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}	
												//*drag
												
												strMove.stop(true).css({
													top: dragTop
												});
												
												
											}).on('mouseup', function () {
												if(p.inverthover){
													strMove.trigger('mouseenter')
												}
												$(this).off('mousemove');
												setTimeout(function () {                             
													fMove = false
												}, 50)
											});
											return false;
										})
										.on('click', function () {
											if (fMove) {
												return false
											}
										});
									} else {
										strWrap.addClass('no_drag');
									};
								}
							} else {
								strWrap.addClass('str_static');
							}
						};
					};
					if (p.direction == 'down') {

						strWrap.addClass('str_vertical').addClass('str_down');
						strMove.css({
							top: -strMove.height(),
							bottom: 'auto'
						})
						if (strMove.height() > strWrap.height()) {
							var topPos = strWrap.height();
							if (p.circular) {
								if (!p.xml) {
									circCloneVert();									
									topPos = strMove.height();
								}
							}
							if (p.xml) {
								strMove.css({
									top:-strMove.height()
								})
							}
							var
							k2 = 0;
							timeFunc = function () {
								var
								fullS = strWrap.height(), //крайняя точка
									time = (fullS / strWrap.data('scrollamount')) * 1000; //время

								if (parseFloat(strMove.css('top')) != 0) {
									fullS = (strMove.height() + strWrap.height());
									time = (fullS - (strMove.height() + parseFloat(strMove.css('top')))) / strWrap.data('scrollamount') * 1000;
								}
								return time;
							};
							var moveFunc = function () {

								if (loop != 0) {
									strMove.animate({
										top: topPos
									}, timeFunc(), 'linear', function () {
										$(this).css({
											top: -strMove.height()
										});
										if (loop == -1) {

											setTimeout(moveFunc, p.scrolldelay);
										} else {
											loop--;
											setTimeout(moveFunc, p.scrolldelay);
										};
									});
								};
							};
							strWrap.data({
								moveF : moveFunc
							})
							if(!p.inverthover){
								moveFunc();
							}
							if (p.hoverstop) {
								strWrap.on(enterEvent, function () {
									$(this).addClass('str_active');
									strMove.stop(true);
								}).on(leaveEvent, function () {
									$(this).removeClass('str_active');
									$(this).off('mousemove');
									moveFunc();
								});

								if (p.drag) {
									strWrap.on('mousedown', function (e) {
										if(p.inverthover){
											strMove.stop(true);
										}
										
										//drag
										var dragTop;
										var dir = 1;
										var newY;
										var oldY = e.clientY;
										//drag
										
										
										strMoveTop = strMove.position().top;
										k2 = strMoveTop - (e.clientY - strWrap.offset().top);
										$(this).on('mousemove', function (e) {
											
											fMove = true;
											
											//drag
											newY = e.clientY;
											if(newY > oldY){
												dir = 1
											}else{
												if(newY < oldY){
													dir = -1
												}
											}
											oldY = newY	
											dragTop = k2 + e.clientY - strWrap.offset().top;


											if (!p.circular){
												if(dragTop < -strMove.height() && dir < 0){
													dragTop = strWrap.height();
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}
												if(dragTop > strWrap.height() && dir > 0){
													dragTop = -strMove.height();
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}	
											}else{
												if(dragTop < -strMove.height() && dir < 0){
													dragTop = 0;
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}
												if(dragTop > 0 && dir > 0){
													dragTop = -strMove.height();
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}
											}


											strMove.stop(true).css({
												top: dragTop
											});
											//drag



										}).on('mouseup', function () {
											if(p.inverthover){
												strMove.trigger('mouseenter')
											}
											$(this).off('mousemove');
											setTimeout(function () {                             
												fMove = false
											}, 50)
										});
										return false;
									})
									.on('click', function () {
										if (fMove) {
											return false
										}
									});
								} else {
									strWrap.addClass('no_drag');
								};
							}
						} else {
							if (p.runshort) {
								var k2 = 0;
								var timeFunc = function () {
									time = (strWrap.height() - strMove.position().top) / strWrap.data('scrollamount') * 1000;
									return time;
								};
								var moveFunc = function () {
									var topPos = strWrap.height();
									strMove.animate({
										top: topPos
									}, timeFunc(), 'linear', function () {
										$(this).css({
											top: -strMove.height()
										});
										if (loop == -1) {
											setTimeout(moveFunc, p.scrolldelay);
										} else {
											loop--;
											setTimeout(moveFunc, p.scrolldelay);
										};
									});
								};
								strWrap.data({
									moveF : moveFunc
								})
								if(!p.inverthover){
									moveFunc();
								}
								if (p.hoverstop) {
									strWrap.on(enterEvent, function () {
										$(this).addClass('str_active');
										strMove.stop(true);
									}).on(leaveEvent, function () {
										$(this).removeClass('str_active');
										$(this).off('mousemove');
										moveFunc();
									});

									if (p.drag) {
										strWrap.on('mousedown', function (e) {
											if(p.inverthover){
												strMove.stop(true);
											}
											
											//drag
											var dragTop;
											var dir = 1;
											var newY;
											var oldY = e.clientY;
											//drag
											
											strMoveTop = strMove.position().top;
											k2 = strMoveTop - (e.clientY - strWrap.offset().top);
											$(this).on('mousemove', function (e) {
												fMove = true;

												//drag
												newY = e.clientY;
												if(newY > oldY){
													dir = 1
												}else{
													if(newY < oldY){
														dir = -1
													}
												}
												oldY = newY	
												dragTop = k2 + e.clientY - strWrap.offset().top;
	
	
												if(dragTop < -strMove.height() && dir < 0){
													dragTop = strWrap.height();
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}
												if(dragTop > strWrap.height() && dir > 0){
													dragTop = -strMove.height();
													strMoveTop = strMove.position().top;
													k2 = strMoveTop - (e.clientY - strWrap.offset().top);
												}	
												//*drag
												
												strMove.stop(true).css({
													top: dragTop
												});
												
												
												
												
												
												
												
												
											}).on('mouseup', function () {
												if(p.inverthover){
													strMove.trigger('mouseenter')
												}
												$(this).off('mousemove');
												setTimeout(function () {                             
													fMove = false
												}, 50)
											})
											return false;
										})
										.on('click', function () {
											if (fMove) {
												return false
											}
										});
									} else {
										strWrap.addClass('no_drag');
									};
								}
							} else {
								strWrap.addClass('str_static');
							}
						};
					};
					
					
					
					
				}
				if (p.xml) {
					$.ajax({
						url: p.xml,
						dataType: "xml",
						success: function (xml) {
							var xmlTextEl = $(xml).find('text');
							var xmlTextLength = xmlTextEl.length;
							for(var i = 0; i < xmlTextLength; i++){
								var xmlElActive = xmlTextEl.eq(i);
								var xmlElContent = xmlElActive.text();
								var xmlItemEl = $('<span>').text(xmlElContent).appendTo(strWrap);
								
								if(p.direction == 'left' || p.direction == 'right'){
									xmlItemEl.css({display:'inline-block',textAlign:'right'});	
									if(i > 0){
										xmlItemEl.css({width:strWrap.width()+xmlItemEl.width()});	
									}
								}
								if(p.direction == 'down' || p.direction == 'up'){
									xmlItemEl.css({display:'block',textAlign:'left'});	
										if(i > 0){
											xmlItemEl.css({paddingTop:strWrap.height()});
										}
								}
								
							}
							code();
						}
					});
				} else {
					code();
				}
				strWrap.data({
					ini:code,
					startheight: startHeight	
				})
				
				
				
				
			});
		},
		update: function () {
			var el = $(this);
			var str_origin = $('.str_origin',el);
			var str_move_clone = $('.str_move_clone',el);
			str_origin.stop(true);
			str_move_clone.remove();
			el.data('ini')();
		},
		destroy: function () {
			
			var el = $(this);
			var elMove = $('.str_move',el);
			var startHeight = el.data('startheight');
			
			$('.str_move_clone',el).remove();
			el.off('mouseenter');
			el.off('mousedown');
			el.off('mouseup');
			el.off('mouseleave');
			el.off('mousemove');
			el.removeClass('noStop').removeClass('str_vertical').removeClass('str_active').removeClass('no_drag').removeClass('str_static').removeClass('str_right').removeClass('str_down');
			
			var elStyle = el.attr('style'); 
			if(elStyle){
				var styleArr = elStyle.split(';');
				for(var i=0; i < styleArr.length; i++){
					var str = $.trim(styleArr[i]);
					var tested =  str.search(/^height/g);
					if(tested != -1){
						styleArr[i] = '';	
					}
				}
				var newArr = styleArr.join(';');
				var newStyle =  newArr.replace(/;+/g,';')
			
				if(newStyle == ';'){
					el.removeAttr('style');	
				}else{
					el.attr('style',newStyle);	
				}
				
				if(startHeight){
					el.css({height:startHeight})	
				}
			}
			elMove.stop(true);

			if(elMove.length){
				var context = elMove.html();
				elMove.remove();
				el.html(context);
			}
	
		},
		pause: function(){	
			var el = $(this);
			var elMove = $('.str_move',el);
			elMove.stop(true);
		}, 
		play: function(){
			var el = $(this);
			$(this).off('mousemove');
			el.data('moveF')();	
		}
		
	};
	$.fn.liMarquee = function (method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Метод ' + method + ' в jQuery.liMarquee не существует');
		}
	};
})(jQuery);


