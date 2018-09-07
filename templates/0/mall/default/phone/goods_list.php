<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left style="width:100%;" >
<script>
var credits_rate=<?php echo $module['credits_rate']?>;
$(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_1 a").hover(function(){
			$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_1 a").removeClass('show_sub');
			$("#<?php echo $module['module_name'];?> .circle_2 div").css('display','none');
			$("#<?php echo $module['module_name'];?> .circle_2 div[upid="+$(this).attr('circle')+"]").css('display','block');
		});
		$("#<?php echo $module['module_name'];?> .circle_2 div").hover(function(){
			$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_1 a[circle="+$(this).attr('upid')+"]").addClass('show_sub');	
		});
		
		$("#<?php echo $module['module_name'];?>_html .circle_filter a[circle]").click(function(){
			$(this).parent().parent().prev('.top_label').html('<?php echo self::$language['circle']?>: '+$(this).html());
			$(this).parent().parent().parent().prev('.top_label').html('<?php echo self::$language['circle']?>: '+$(this).html());
			$("#<?php echo $module['module_name'];?> .top .circle_filter a").removeClass('current');
			$(this).addClass('current');
			$(".determine").attr('href',replace_get($(".determine").attr('href'),'circle',$(this).attr('circle')));
			return false;	
		});
		circle=get_param('circle');
		if(circle==''){circle=getCookie('circle');}
		$("#<?php echo $module['module_name'];?>  .circle_filter a[circle='"+circle+"']").addClass('current');
		
		if($("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().attr('upid')){
			$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().css('display','block');
			$("#<?php echo $module['module_name'];?> a[circle='"+$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().attr('upid')+"']").addClass('show_sub');
		}
		
		
	
	
	$("#visitor_position_reset").insertBefore("#<?php echo $module['module_name'];?> .top .diy_price");
	$("#visitor_position_reset").css('display','block');
	$("#<?php echo $module['module_name'];?> .determine").attr('href',window.location.href);
	$("#<?php echo $module['module_name'];?> .top #type a").click(function(){
		$(this).parent().prev('.top_label').html('<?php echo self::$language['type']?>: '+$(this).html());
		$("#<?php echo $module['module_name'];?> .top #type a").removeClass('current');
		$(this).addClass('current');
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'type',$(this).attr('id').replace(/type_a_/,'')));
		return false;	
	});
	$("#<?php echo $module['module_name'];?> .top #color a").click(function(){
		$(this).parent().prev('.top_label').html('<?php echo self::$language['color']?>: '+$(this).html());
		$("#<?php echo $module['module_name'];?> .top #color a").removeClass('current');
		$(this).addClass('current');
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'color',$(this).attr('color')));
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?> .top #brand a").click(function(){
		$(this).parent().prev('.top_label').html('<?php echo self::$language['brand']?>: '+$(this).html());
		$("#<?php echo $module['module_name'];?> .top #brand a").removeClass('current');
		$(this).addClass('current');
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'brand',$(this).attr('brand')));
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?> .top #option a").click(function(){
		$(this).parent().prev('.top_label').html('<?php echo self::$language['option_name']?>: '+$(this).html());
		$("#<?php echo $module['module_name'];?> .top #option a").removeClass('current');
		$(this).addClass('current');
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'option',$(this).attr('option')));
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?> .top #price a").click(function(){
		$(this).parent().prev('.top_label').html('<?php echo self::$language['type_price']?>: '+$(this).html());
		$("#<?php echo $module['module_name'];?> .top #price a").removeClass('current');
		$(this).addClass('current');
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'min_price',$(this).attr('min_price')));
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'max_price',$(this).attr('max_price')));
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?> .top .attribute a").click(function(){	
		$(this).parent().prev('.top_label').html($(this).parent().prev('.top_label').attr('old_name')+': '+$(this).html());
		$(this).parent().children('a').removeClass('current');
		$(this).addClass('current');
		if($(this).html()=='<?php echo self::$language['unlimited']?>'){
			$(".determine").attr('href',replace_get($(".determine").attr('href'),$(this).parent().parent().attr('id'),''));
		}else{
			$(".determine").attr('href',replace_get($(".determine").attr('href'),$(this).parent().parent().attr('id'),$(this).html()));
		}
		
		return false;
	});
	
	temp=get_param('brand');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #brand a[brand='"+temp+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #brand a[brand='0']").attr('class','current');}
	temp=get_param('color');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #color a[color='"+temp+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #color a[color='0']").attr('class','current');}
	temp=get_param('option');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #option a[option='"+temp+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #option a[option='0']").attr('class','current');}
	temp=get_param('min_price');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #price a[min_price='"+temp+"'][max_price='"+get_param('max_price')+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #price a[min_price='-1']").attr('class','current');}
	
	temp=get_param('min_price');
	if(!isNaN(temp)){$("#<?php echo $module['module_name'];?>_html .top .diy_price .min_price").val(temp);}
	temp=get_param('max_price');
	if(!isNaN(temp)){$("#<?php echo $module['module_name'];?>_html .top .diy_price .max_price").val(temp);}
	

	$("#<?php echo $module['module_name'];?> .attribute").each(function(index, element) {
		id=$(this).attr('id');
		temp=get_param($(this).attr('id'));
		if(temp!=''){
			temp=decodeURI(temp);
			$("#<?php echo $module['module_name'];?> #"+id+" a").each(function(index, element) {
			    if($(this).html()==temp){$(this).attr('class','current');}
            });
		}else{
			$("#<?php echo $module['module_name'];?> #"+id+" a["+id+"='0']").attr('class','current');
		}
    });
	
	$("#<?php echo $module['module_name'];?> .top_html .current").each(function(index, element) {
        $(this).parent().prev('.top_label').html( $(this).parent().prev('.top_label').html()+' '+$(this).html());
    });
	
	
	$("#<?php echo $module['module_name'];?> .determine").click(function(){
		
		var min_price=parseFloat($("#<?php echo $module['module_name'];?>_html .top .diy_price .min_price").val());
		var max_price=parseFloat($("#<?php echo $module['module_name'];?>_html .top .diy_price .max_price").val());
		if(min_price>=max_price && (min_price!='' && max_price!='')){max_price=min_price;}
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'current_page',1));
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'min_price',min_price));
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'max_price',max_price));
		
		
		if(!$("#<?php echo $module['module_name'];?> .top #type .current").attr('id')){
			$(this).attr('href',$(this).attr('href')+'&type='+get_param('type'));
		}
	});
	
	$("#<?php echo $module['module_name'];?> .left_return").click(function(){
		
		$("#<?php echo $module['module_name'];?> .top").animate({left:'-100%'},'fast');
		$("#<?php echo $module['module_name'];?> .top .confirm_div").animate({left:'-100%'},'fast');
		return false;
	});
	
	$("#<?php echo $module['module_name'];?> .goods_filters .option_div").click(function(){
		if(!$("#<?php echo $module['module_name'];?> .top").html()){
			window.history.back(-1);
		}else{
			$("#<?php echo $module['module_name'];?> .top").animate({left:'0px'},'fast');
			$("#<?php echo $module['module_name'];?> .top .confirm_div").animate({left:'0px'},'fast');
		}
		return false;
	});
	
	
	
	$("#<?php echo $module['module_name'];?> .top_label").click(function(){
		if($(this).next('.top_html').css('display')=='block'){
			$(this).next('.top_html').css('display','none');
		}else{
			$(this).next('.top_html').css('display','block');
		}
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?> .sort_div").click(function(){
		if($("#<?php echo $module['module_name'];?> .sort_options").height()==0){
			$("#<?php echo $module['module_name'];?> .sort_options").css('height','auto');
		}else{
			$("#<?php echo $module['module_name'];?> .sort_options").css('height','0');
		}
		return false;	
	});
	
	
	var order=get_param('order');
	if(order!=''){
	 $("#<?php echo $module['module_name'];?> .sort_div").html($("#<?php echo $module['module_name'];?> .sort_options a[order='"+order+"']").attr('show'));
		$("#<?php echo $module['module_name'];?> .sort_options a[order='"+order+"']").attr('class','used');
	}else{
		$("#<?php echo $module['module_name'];?> .sort_options a:first-child").attr('class','used');
	}
	
	$("#<?php echo $module['module_name'];?> .sort_options a").click(function(){
		url=window.location.href;
		url=replace_get(url,"order",$(this).attr('order'));	
		url=replace_get(url,'current_page',1);
		window.location=url;	
		return false;
	});
	
	$("#<?php echo $module['module_name'];?> .goods_list .goods_a").click(function(){
		id=$(this).parent().attr('id');	
		bidding_log(id);	
	});
	$("#<?php echo $module['module_name'];?> .goods_list .goods_img").click(function(){
		id=$(this).parent().attr('id');		
		bidding_log(id);	
	});
	$("#<?php echo $module['module_name'];?> .goods_list .title").click(function(){
		id=$(this).parent().parent().parent().attr('id');		
		bidding_log(id);	
	});
	
	function bidding_log(id){
		id=id.replace(/g_/,'');
		if($("#<?php echo $module['module_name'];?> #g_"+id).attr('bidding')==1){
			$.post("./receive.php?target=mall::goods_list&act=bidding",{id:id,src_title:document.title,src_url:document.URL},function(data){
				//alert(data);	
			});	
		}
	}
	
	if('<?php echo @$_GET['search'];?>'!=''){
		search_reg='/<?php echo @$_GET['search'];?>/g';
		$("#<?php echo $module['module_name'];?> .goods .title").each(function(index, element) {
			$(this).html($(this).html().replace(eval(search_reg),'<k><?php echo @$_GET['search'];?></k>'));
		});
	}
	
	
	if(touchAble){$("#<?php echo $module['module_name'];?> .button_div").css('display','block');}
	
	

	
	$("#<?php echo $module['module_name'];?> .favorite").click(function(){
		if($(this).parent().parent().attr('id')){
			id=$(this).parent().parent().attr('id').replace(/g_/,'');
		}else{
			id=$(this).parent().parent().parent().parent().attr('id').replace(/g_/,'');
		}
		
		$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('./receive.php?target=mall::goods&act=add_favorite&id='+id,function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#<?php echo $module['module_name'];?> #g_"+id+" .favorite").html(v.info).css('background','none');
			$("#<?php echo $module['module_name'];?> #g_"+id+" .favorite").html(v.info).css('padding','0');
			$("#<?php echo $module['module_name'];?> #g_"+id+" .favorite").html(v.info).css('margin','0');
			bidding_log(id);
		});
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?> #type_a_<?php echo @$_GET['type'];?>").addClass('current');
	if(''!='<?php echo @$_GET['show_method'];?>'){
		$("#<?php echo $module['module_name'];?>_html #<?php echo @$_GET['show_method'];?>").attr('class','<?php echo @$_GET['show_method'];?>_current');
	}else{
		$("#<?php echo $module['module_name'];?>_html #show_grid").attr('class','show_grid_current');
	}
	$("#<?php echo $module['module_name'];?>_html .show_method a").click(function(){
		url=window.location.href;
		url=replace_get(url,'show_method',$(this).attr("id"));
		window.location.href=url;
	    return false;
	});
	
	
	$("#<?php echo $module['module_name'];?>_html .add_cart").click(function(){
		if($(this).attr('option_enable')==0 || $(this).attr('s_id')!='0'){
			if($(this).attr('class')==''){return true;}
			if($(this).attr('s_id')=='0'){
				id=$(this).attr('href').replace(/\.\/index\.php\?monxin=mall\.goods&id=/,'');
				var price=$("#<?php echo $module['module_name'];?> #g_"+id+" .money_value").html();
			}else{
				id=$(this).attr('s_id');
				var price=$(this).attr('s_price');
			}
			add_cart(id,price);
			
			$(this).attr('class','');
			$(this).attr('user_color','');
			$(this).html('<span class=success><?php echo self::$language['success'];?></span> <a href="./index.php?monxin=mall.my_cart" class=view><?php echo self::$language['view']?><?php echo self::$language['cart']?></a>');
			return false;
		}
		
	});
	
	$("#<?php echo $module['module_name'];?> .price_span").each(function(index, element) {
        v=parseFloat($(this).children('.money_value').html())*credits_rate;
		$(this).after("<span class=yuan_2>"+v.toFixed(2)+"<?php echo self::$language['yuan_2']?></span>");
    });
	
	
	
	function add_cart(id,price){
		//alert(id+','+price);
		var old_cart=getCookie('mall_cart');
		if(old_cart!=''){
			old_cart=old_cart.replace(/%3A/g,':');
			old_cart=old_cart.replace(/%2C/g,',');
			//alert(old_cart);
			old_cart=eval('('+old_cart+')');
			if(old_cart[id]){
				old_cart[id]['quantity']=parseInt(old_cart[id]['quantity'])+1;	
			}else{
				old_cart[id]=new Array();
				old_cart[id]['quantity']=1;		
				old_cart[id]['price']=price;		
			}
			old_cart[id]['time']=Date.parse(new Date());
			str='';
			for(v in old_cart){
				str+='"'+v+'":{"quantity":"'+old_cart[v]['quantity']+'","time":"'+old_cart[v]['time']+'","price":"'+old_cart[v]['price']+'"},';	
			}
			str=str.substring(0,str.length-1);
			str='{'+str+'}';
		}else{
			str='{"'+id+'":{"quantity":"1","time":"'+Date.parse(new Date())+'","price":"'+price+'"}}';
		}
		//alert(str);
		setCookie('mall_cart',str,30);
		try{update_cart_goods_sum();}catch(e){}
		$.get("./receive.php?target=mall::cart&act=update_cart");
	}
	
});

</script>

<style>
#middle_malllayout_inner {background:none;}
#<?php echo $module['module_name'];?> a{ }
#<?php echo $module['module_name'];?> k{ }
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html .top{ width:100%; height:100%; padding:1rem; position:fixed; left:-100%; z-index:9999999999999999999999999; padding-bottom:8rem;  overflow:scroll;  background:#fff;}

#<?php echo $module['module_name'];?>_html .top .diy_price{ line-height:2rem; }
#<?php echo $module['module_name'];?>_html .top .diy_price input{ width:35%; padding:2px; }
#<?php echo $module['module_name'];?>_html .top .diy_price span:first-child{ display:inline-block; vertical-align:top; width:35%; overflow:hidden; text-align:left; }
#<?php echo $module['module_name'];?>_html .top .diy_price span:last-child{ display:inline-block; vertical-align:top; width:65%; overflow:hidden; text-align:right; }

#<?php echo $module['module_name'];?>_html .top .top_label{ line-height:2rem; display:block; border-bottom: 1px solid #333; margin-top:1rem; margin-bottom:1rem;}
#<?php echo $module['module_name'];?>_html .top .top_label:after{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f078"; float:right; margin-top:0.5rem;}
#<?php echo $module['module_name'];?>_html .top .top_html{ }
#<?php echo $module['module_name'];?>_html .top .top_html a{ white-space:nowrap; overflow:hidden;text-overflow: ellipsis; display:inline-block;  border-radius:6px; margin:5px; padding:5px;background-color: #f2f2f2;}
#<?php echo $module['module_name'];?>_html .top .top_html a:hover{  }
#<?php echo $module['module_name'];?>_html .top .top_html .current{  background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;  }

#<?php echo $module['module_name'];?>_html .top #type a{ width:47%;}


#<?php echo $module['module_name'];?>_html .top .confirm_div{  width:100%; z-index:99999999999999999999999999999; position: fixed; width:100%; bottom:0px; left:-100%; text-align:right; border-top: #dadada solid 1px; line-height:4rem; font-size:1.2rem; background:#fff;}
#<?php echo $module['module_name'];?>_html .top .confirm_div a{ display:inline-block; vertical-align:top; width:50%; text-align:center;}
#<?php echo $module['module_name'];?>_html .top .confirm_div a:hover{ opacity:0.5;}
#<?php echo $module['module_name'];?>_html .top .confirm_div a:last-child{  }
#<?php echo $module['module_name'];?>_html .top .confirm_div .left_return:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f053";}

#<?php echo $module['module_name'];?>_html .list{  border:1px solid #e7e7e7; padding-bottom:20px;}

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order{display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order:hover{ }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc{display:inline-block; vertical-align:top;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc{display:inline-block; vertical-align:top;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc:after{font: normal normal normal 20px/1 FontAwesome;margin-left:5px;content: "\f0d8";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc:after{font: normal normal normal 20px/1 FontAwesome;	margin-left:5px;	content: "\f0d7";}




#<?php echo $module['module_name'];?>_html .list .goods_list{}



#<?php echo $module['module_name'];?>_html .list .goods_list   .goods{ display:inline-block; vertical-align:top; line-height:2rem; width:50%; overflow:hidden; border-left:1px solid #f7f7f7; border-bottom:1px solid #f7f7f7; white-space:nowrap;border:1px solid #f7f7f7; padding-bottom:1rem; padding:0.4rem;}



#<?php echo $module['module_name'];?>_html .list .goods_list .goods:hover .button_div{ display:block;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a{ display:block; text-align:center; }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a img{ width:80%; margin:auto;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .title{ display:block; text-align:left; white-space:nowrap; text-overflow: ellipsis; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span{ display:inline-block;text-align:left; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; float:left; }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span .money_symbol{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span .money_value{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div{ display:block;font-size:0.9rem; opacity:0.7;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly{ text-align:left; display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly .m_label{ box-shadow:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly .value{ padding-left:5px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction{display:inline-block; vertical-align:top; width:50%; text-align:right; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction .m_label{box-shadow:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction .value{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div{ display:none; width:100%; margin:auto; margin-top:15px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div a{ }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .view{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .add_cart{ display:inline-block; vertical-align:top; display:inline-block; vertical-align:top; height:30px; line-height:30px; border-radius:3px; font-size:1rem;  padding-right:10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .add_cart:before {font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; padding:0 5px 0 10px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .add_cart:hover{ opacity:0.9;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .favorite{display:inline-block; vertical-align:top; float:right;  height:30px; line-height:30px; border-radius:2px;  font-size:1rem;  padding-right:10px;background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;  }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .favorite:before {font: normal normal normal 1rem/1 FontAwesome; content: "\f005"; padding:0 5px 0 10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .favorite:hover{ opacity:0.9;}




#<?php echo $module['module_name'];?>_html .list .goods_list .line{width:97%; padding-top:1rem; padding-bottom:1rem; border:4px solid #fff; border-bottom:1px solid #e7e7e7; overflow:hidden; margin:1%; margin-bottom:3px; white-space:nowrap;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line:hover{ border:1px solid #f60;padding: 18px 3px 18px 3px; margin-bottom:-3px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line:hover .button_div{ display:block;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .goods_img{ vertical-align:top;text-align:right;  display:inline-block; vertical-align:top; width:25%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .goods_img img{ width:90%;  margin:auto; overflow:hidden; border:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info{ vertical-align:top; display:inline-block; vertical-align:top; padding-left:1%;width:75%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info:hover{}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info:hover .bottom .button_div{display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .top2{}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .top2 .title{ display:block; white-space:normal; line-height:1.6rem; height:3.2rem; overflow:hidden; }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .top2 .price_span{ display:inline-block; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom{ }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div{ display:block; font-size:1rem; }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .monthly{}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .monthly .m_label{ box-shadow:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .monthly .value{ padding-left:5px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .satisfaction{ margin-left:50px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .satisfaction .m_label{ box-shadow:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .satisfaction .value{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .satisfaction{ padding-left:5px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div{  display:none; text-align:right;width:50%; overflow:hidden; line-height:30px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div a{ }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .view{ font-size:15px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .add_cart{ display:inline-block; vertical-align:top; height:30px; line-height:30px; border-radius:3px;  font-size:1rem;  padding-right:10px; margin-right:20px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .add_cart:before{font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; padding:0 5px 0 10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .add_cart:hover{ opacity:0.9;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .favorite{display:inline-block; vertical-align:top; float:right;  height:30px; line-height:30px; border-radius:3px; font-size:1rem;  padding-right:10px; margin-right:20px;background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .favorite:before {font: normal normal normal 1rem/1 FontAwesome; content: "\f005"; padding:0 5px 0 10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .favorite:hover{ opacity:0.9;}
#<?php echo $module['module_name'];?>_html  .favorite span{ }
#<?php echo $module['module_name'];?>_html .ad{ margin-bottom:10px; display:none;}

#<?php echo $module['module_name'];?>_html .goods_filters{ line-height:3rem; height:3rem; overflow:hidden; border-bottom:#dadada solid 1px; }
#<?php echo $module['module_name'];?>_html .goods_filters .sort_div{ display:inline-block; vertical-align:top; width:65%; overflow:hidden; text-indent:1rem;}
#<?php echo $module['module_name'];?>_html .goods_filters .sort_div:after{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0d7"; opacity:0.5; }
#<?php echo $module['module_name'];?>_html .goods_filters .option_div{ display:inline-block; vertical-align:top; width:15%; overflow:hidden;text-align:right;}
#<?php echo $module['module_name'];?>_html .goods_filters .option_div:after{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0d7";opacity:0.5;}

#<?php echo $module['module_name'];?>_html .goods_filters .show_method{ display:inline-block; dvertical-align:top; width:20%; overflow:hidden; text-align:right;}

#<?php echo $module['module_name'];?>_html .goods_filters .show_method a{ display:inline-block; vertical-align:top; padding:0.3rem; padding-right:0.7rem;color:#ccc;}
#<?php echo $module['module_name'];?>_html .goods_filters .show_method a:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .goods_filters .show_method #show_grid{  }
#<?php echo $module['module_name'];?>_html .goods_filters .show_method .show_grid_default{ }
#<?php echo $module['module_name'];?>_html .goods_filters .show_method .show_grid_current{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .goods_filters .show_method #show_grid:before {font: normal normal normal 1.5rem/1 FontAwesome;content: "\f009";}
#<?php echo $module['module_name'];?>_html .goods_filters .show_method #show_line{ padding:0.3rem;}
#<?php echo $module['module_name'];?>_html .goods_filters .show_method #show_line:before {font: normal normal normal 1.5rem/1 FontAwesome; content: "\f0c9";}
#<?php echo $module['module_name'];?>_html .goods_filters .show_method .show_line_default{}
#<?php echo $module['module_name'];?>_html .goods_filters .show_method .show_line_current{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }

#<?php echo $module['module_name'];?>_html .sort_options{ line-height:3rem; height:0px; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .sort_options a{ display:block; border-bottom:1px dashed #d8d8d8; margin-left:1rem; margin-right:1rem;}
#<?php echo $module['module_name'];?>_html .sort_options a:last-child{}
#<?php echo $module['module_name'];?>_html .sort_options .used{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .sort_options .used:after{margin-right:8px; margin-top:1rem; float:right; font: normal normal normal 1rem/1 FontAwesome; content:"\f00c";}
#<?php echo $module['module_name'];?>_html .sort_options a:hover{ }
#<?php echo $module['module_name'];?>_html .sort_options a:hover:after{margin-right:8px; margin-top:1rem; float:right; font: normal normal normal 1rem/1 FontAwesome; content:"\f00c";}

#visitor_position_reset{ display:block; line-height:2rem; border-bottom:#e8e8e8 solid 1px; margin-bottom:1rem;}
#visitor_position_reset #current_position_text{ display:none;}
#visitor_position_reset a[href='./index.php']{ display:none;}
#visitor_position_reset a:after{ font: normal normal normal 1rem/1 FontAwesome;	margin:0 5px;	content: "\f105";}

	
#<?php echo $module['module_name'];?>_html .circle_filter{ line-height:2rem; display:none; }
#<?php echo $module['module_name'];?>_html .circle_filter .c_label{ display:inline-block; vertical-align:top; width:5%; overflow:hidden; text-align:right;   padding-right:1%; white-space:nowrap; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list{}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1{}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a{ display:inline-block; vertical-align:top;  width:22%; text-align:center; margin-right:1%; white-space:nowrap; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 .c{   }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 .show_sub{ border-bottom:2px <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> solid;}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a:hover{  }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2{}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 { }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div{ display:none; }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div a{ display:inline-block; vertical-align:top;  width:22%; margin-right:1%; text-align:center;  white-space:nowrap; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div a:hover{  }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div .c{  }

#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span{ font-size:0.8rem; padding-left:2px; }
#<?php echo $module['module_name'];?>_html .money_symbol{ font-size:0.8rem; padding-left:2px; }
#<?php echo $module['module_name'];?>_html .money_value{ font-size:1rem; }
#<?php echo $module['module_name'];?>_html .unit{font-size:0.8rem; }
#<?php echo $module['module_name'];?>_html .yuan_2{ line-height:1rem;  padding-left:0px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; font-size:0.8rem; float:right; line-height:2rem;}

</style>
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<input type=text style="display:none;" class=search />
	<?php echo $module['ad'];?>
    <div class=content>
    	<?php echo $module['data']['top_html'];?>
		<div class=list>
			<div class=goods_filters>
            	<a href="#" class=sort_div><?php echo self::$language['composite'];?><?php echo self::$language['sequence'];?></a><a href=# class=option_div><?php echo self::$language['screening'];?></a><div class=show_method>
                	<a href="#" id=show_grid class="show_grid_default" title="<?php echo self::$language['show_grid'];?>"></a><a href="#" id=show_line class=show_line_default title="<?php echo self::$language['show_line'];?>"></a>
                </div>
            </div>
            <div class=sort_options>
            	<a href="#" order='' show='<?php echo self::$language['goods_sort_option_show']['composite'];?>'><?php echo self::$language['goods_sort_option']['composite'];?></a>
            	<a href="#" order='monthly|desc' show='<?php echo self::$language['goods_sort_option_show']['monthly_desc'];?>'><?php echo self::$language['goods_sort_option']['monthly_desc'];?></a>
            	<a href="#" order='w_price|desc' show='<?php echo self::$language['goods_sort_option_show']['w_price_desc'];?>'><?php echo self::$language['goods_sort_option']['w_price_desc'];?></a>
            	<a href="#" order='w_price|asc' show='<?php echo self::$language['goods_sort_option_show']['w_price_asc'];?>'><?php echo self::$language['goods_sort_option']['w_price_asc'];?></a>
            	<a href="#" order='satisfaction|desc' show='<?php echo self::$language['goods_sort_option_show']['satisfaction_desc'];?>'><?php echo self::$language['goods_sort_option']['satisfaction_desc'];?></a>
            	<a href="#" style="display:none;" order='position|asc' show='<?php echo self::$language['goods_sort_option_show']['position_desc'];?>'><?php echo self::$language['goods_sort_option']['position_desc'];?></a>
            </div>
			<div class=goods_list><?php echo $module['list'];?></div>
        </div>
    </div>
    <?php echo $module['page']?>
</div>
</div>