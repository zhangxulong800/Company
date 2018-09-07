<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left>
<script>
var credits_rate=<?php echo $module['credits_rate']?>;
$(document).ready(function(){
	if('<?php echo @$_GET['search'];?>'!=''){
		search_reg='/<?php echo @$_GET['search'];?>/g';
		$("#<?php echo $module['module_name'];?> .goods .title").each(function(index, element) {
			$(this).html($(this).html().replace(eval(search_reg),'<k><?php echo @$_GET['search'];?></k>'));
		});
	}

	
	if(touchAble){$("#<?php echo $module['module_name'];?> .button_div").css('display','block');}
	$("#<?php echo $module['module_name'];?> #brand a").click(function(){
		key=$(this).parent().parent().attr('id');
		url=window.location.href;
		url=replace_get(url,'current_page',1);
		window.location.href=replace_get(url,key,$(this).attr(key));
		return false;
	});
	temp=get_param('brand');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #brand a[brand='"+temp+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #brand a[brand='0']").attr('class','current');}

	$("#<?php echo $module['module_name'];?> #color a").click(function(){
		key=$(this).parent().parent().attr('id');
		url=window.location.href;
		url=replace_get(url,'current_page',1);
		window.location.href=replace_get(url,key,$(this).attr(key));
		return false;
	});
	temp=get_param('color');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #color a[color='"+temp+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #color a[color='0']").attr('class','current');}

	$("#<?php echo $module['module_name'];?> #option a").click(function(){
		key=$(this).parent().parent().attr('id');
		url=replace_get(url,'current_page',1);
		url=window.location.href;
		window.location.href=replace_get(url,key,$(this).attr(key));
		return false;
	});
	temp=get_param('option');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #option a[option='"+temp+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #option a[option='0']").attr('class','current');}

	$("#<?php echo $module['module_name'];?> #price a").click(function(){
		url=window.location.href;
		url=replace_get(url,'current_page',1);
		url=replace_get(url,'max_price',$(this).attr('max_price'));
		window.location.href=replace_get(url,'min_price',$(this).attr('min_price'));
		return false;
	});
	temp=get_param('min_price');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #price a[min_price='"+temp+"'][max_price='"+get_param('max_price')+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #price a[min_price='-1']").attr('class','current');}


	$("#<?php echo $module['module_name'];?> .attribute a").click(function(){
		key=$(this).parent().parent().attr('id');
		url=window.location.href;
		url=replace_get(url,'current_page',1);
		if($(this).html()=='<?php echo self::$language['unlimited'];?>'){$(this).html('');}
		window.location.href=replace_get(url,key,$(this).html());
		return false;
	});
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
			$("#<?php echo $module['module_name'];?> #g_"+id+" .favorite").html(v.info).css('background-image','none');
		});
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?> #type_a_<?php echo @$_GET['type'];?>").addClass('current');
	if(''!='<?php echo @$_GET['show_method'];?>'){
		$("#<?php echo $module['module_name'];?>_html #<?php echo @$_GET['show_method'];?>").attr('class','<?php echo @$_GET['show_method'];?>_current');
	}else{
		$("#<?php echo $module['module_name'];?>_html #show_grid").attr('class','show_grid_current');
	}
	$("#<?php echo $module['module_name'];?>_html .right_label a").click(function(){
		url=window.location.href;
		url=replace_get(url,'show_method',$(this).attr("id"));
		window.location.href=url;
		return false;		
	});
	
	 var order=get_param('order');
	$("#<?php echo $module['module_name'];?>_html .left_label .order_div a").attr('class','order');
	 if(order!=''){
		$("a[desc='"+order+"']").attr('class','order_desc');
		$("a[asc='"+order+"']").attr('class','order_asc');			
	}else{
		$("a[desc='sequence|desc']").attr('class','order_desc');
	}
  	$("#<?php echo $module['module_name'];?>_html .left_label .order_div a").click(function(){
		url=window.location.href;
		if(order=='' || order==$(this).attr('desc')){
			url=replace_get(url,"order",$(this).attr('asc'));
		}else{
			url=replace_get(url,"order",$(this).attr('desc'));	
		}
		url=replace_get(url,'current_page',1);
		window.location=url;	
		return false;
	});
	
	$("#<?php echo $module['module_name'];?>_html .left_label .set_price").click(function(){
		var min_price=parseFloat($("#<?php echo $module['module_name'];?>_html .left_label #min_price").val());
		var max_price=parseFloat($("#<?php echo $module['module_name'];?>_html .left_label #max_price").val());
		if(min_price>=max_price && (min_price!='' && max_price!='')){$(this).next().html('<span class=fail><?php echo self::$language['min_price']?><?php echo self::$language['must_be_less_than'];?><?php echo self::$language['max_price'];?></span>');$("#<?php echo $module['module_name'];?>_html .left_label #min_price").focus();return false;}
		url=window.location.href;
		url=replace_get(url,'current_page',1);
		url=replace_get(url,'min_price',min_price);
		url=replace_get(url,'max_price',max_price);
		window.location.href=url;	
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?>_html .left_label #max_price").keyup(function(event){
		 if(event.keyCode==13){
			var min_price=parseFloat($("#<?php echo $module['module_name'];?>_html .left_label #min_price").val());
			var max_price=parseFloat($("#<?php echo $module['module_name'];?>_html .left_label #max_price").val());
			if(min_price>=max_price && (min_price!='' && max_price!='')){$(this).next().html('<span class=fail><?php echo self::$language['min_price']?><?php echo self::$language['must_be_less_than'];?><?php echo self::$language['max_price'];?></span>');$("#<?php echo $module['module_name'];?>_html .left_label #min_price").focus();return false;}
			url=window.location.href;
			url=replace_get(url,'current_page',1);
			url=replace_get(url,'min_price',min_price);
			url=replace_get(url,'max_price',max_price);
			window.location.href=url;	
			return false;	
		}
	});
	
	$("#<?php echo $module['module_name'];?>_html .add_cart").click(function(){
		if('<?php echo $module['shop_master']?>'=='<?php echo $module['username'];?>'){alert('<?php echo self::$language['can_not_buy_your_goods']?>');return false;}

	$("#<?php echo $module['module_name'];?>_html .add_cart").click(function(){
		if('<?php echo $module['shop_master']?>'=='<?php echo $module['username'];?>'){alert('<?php echo self::$language['can_not_buy_your_goods']?>');return false;}		
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
	
	
	
	
	
	
	});
	
	$("#<?php echo $module['module_name'];?> .price_span").each(function(index, element) {
        v=parseFloat($(this).children('.money_value').html())*credits_rate;
		$(this).after("<span class=yuan_2>"+v.toFixed(2)+"<?php echo self::$language['yuan_2']?></span>");
    });
	
	
	function add_cart(id,price){
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
#<?php echo $module['module_name'];?> { margin-top:5px;}
#<?php echo $module['module_name'];?> a{ }
#<?php echo $module['module_name'];?> k{ }
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html .top{ display:inline-block; vertical-align:top;  border:1px solid #e7e7e7; border-top:3px solid #ff9600; width:100%; margin-bottom:10px; padding-bottom:10px;}
#<?php echo $module['module_name'];?>_html .top .top_label{ display:inline-block; vertical-align:top; vertical-align:top; width:7%; overflow:hidden; text-align:right; padding-right:10px;  line-height:25px; margin-top:5px; font-size:15px; padding-right:1%;}
#<?php echo $module['module_name'];?>_html .top .top_html{ display:inline-block; vertical-align:top; vertical-align:top; overflow:hidden; width:90%;}
#<?php echo $module['module_name'];?>_html .top .top_html a{ display:inline-block; vertical-align:top; height:25px; line-height:25px; border-bottom:3px solid #fff; margin-bottom:5px; margin-top:5px; font-size:15px; margin-right:20px;}
#<?php echo $module['module_name'];?>_html .top .top_html a:hover{  font-weight:bold; }
#<?php echo $module['module_name'];?>_html .top .top_html .current{ font-weight:bold; }
#<?php echo $module['module_name'];?>_html .list{  border:1px solid #e7e7e7; padding-bottom:20px;}
#<?php echo $module['module_name'];?>_html .list .m_label_div{ display:inline-block; vertical-align:top; height:3rem;line-height:3rem;  border-bottom:1px solid #e7e7e7; width:100%;background-color: #f3f3f3; color:#999;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label{ display:inline-block; vertical-align:top; width:75%; overflow:hidden; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div{display:inline-block; vertical-align:top; white-space: nowrap;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div a{ display:inline-block; vertical-align:top; padding-right:1rem; font-size:1rem;  padding-left:1rem;color:#999;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div a:after {font: normal normal normal 1rem/1 FontAwesome;margin-left:5px;	content: "\f0dc";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .current{ }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order{display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;  }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc{display:inline-block; vertical-align:top;background:#fff; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc{display:inline-block; vertical-align:top;background:#fff; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc:after{font: normal normal normal 20px/1 FontAwesome;margin-left:5px;content: "\f0d8";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc:after{font: normal normal normal 20px/1 FontAwesome;	margin-left:5px;	content: "\f0d7";}



#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .price_set_div{display:none; vertical-align:top; margin-left:30px;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .price_set_div input{ width:60px; text-align:center;}

#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label{ display:inline-block; vertical-align:top; width:25%; text-align:right; overflow:hidden; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label a{ display:inline-block; vertical-align:top; color:#999;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_grid{ display:inline-block; vertical-align:top;  width:3rem;  text-align: center;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_grid_default{ border:1px solid #e7e7e7; border-top:none;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_grid_current{ border:1px solid #e7e7e7; border-top:none; text-align:center;background:#fff;  color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_grid:before {font: normal normal normal 1.5rem/1 FontAwesome;content: "\f009";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_line{ display:inline-block; vertical-align:top; width:3rem;  text-align: center; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_line:hover{}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_line:before {font: normal normal normal 1.5rem/1 FontAwesome; content: "\f0c9";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_line_default{}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_line_current{ background:#fff;  color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}

#<?php echo $module['module_name'];?>_html .list .goods_list{ padding-top:10px; padding-left:10px;}



#<?php echo $module['module_name'];?>_html .list .goods_list .goods{ display:inline-block; vertical-align:top; vertical-align:top;  width:50%; height:24rem;  overflow:hidden; border:4px solid #fff; margin-bottom:1rem;	}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:hover{ border:4px solid #e7e7e7;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:hover .button_div{ display:block; clear:both;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a{ display:block; text-align:center;margin:auto; padding-bottom:15px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a img{  height:13rem; margin-top:1rem; border:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .title{ display:block; text-align:left; padding-left:5px;  height:2rem; line-height:2rem;font-size:1.1rem;  overflow:hidden; margin:auto;white-space: nowrap;text-overflow: ellipsis;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span{ display:inline-block; text-align:left; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> !important; float:left; line-height:2rem; }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span .money_symbol{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span .money_value{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div{ display:block;  font-size:1rem;font-family:Georgia; white-space:nowrap;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly{ text-align:left; display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly .m_label{ }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly .value{ padding-left:5px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction{display:inline-block; vertical-align:top; width:50%; text-align:right; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction .m_label{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction .value{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div{ }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div a{ }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .view{ font-size:0.9rem;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .add_cart{ display:inline-block; vertical-align:top; height:2rem; line-height:2rem; border-radius:2px;  font-size:1rem;  padding-right:10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .add_cart:hover{ opacity:0.9;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .favorite{display:inline-block; vertical-align:top; float:right; display:inline-block; vertical-align:top; height:2rem; line-height:2rem; border-radius:2px;font-size:1rem;  padding-right:10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .favorite:hover{ opacity:0.9;}

#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div  .add_cart:before {font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; padding:0 5px 0 10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div  .favorite:before {font: normal normal normal 1rem/1 FontAwesome; content: "\f005"; padding:0 5px 0 10px;}




#<?php echo $module['module_name'];?>_html .list .goods_list .line{width:97%; padding-top:15px; padding-bottom:15px; border:4px solid #fff; border-bottom:1px solid #e7e7e7; overflow:hidden; margin:1%; margin-bottom:3px; white-space:nowrap;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line:hover{ border:4px solid #e7e7e7; margin-bottom:-3px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line:hover .button_div{ display:block;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .goods_img{ vertical-align:top;text-align:right;  display:inline-block; vertical-align:top; width:10%; min-width:120px; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .goods_img img{ width:120px; height:120px; margin:auto; overflow:hidden; border:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info{ vertical-align:top; display:inline-block; vertical-align:top; padding-left:1%;width:89%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info:hover{}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info:hover .bottom .button_div{display:block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .top2{ height:88px; line-height:40px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .top2 .title{ display:block; vertical-align:top; width:70%; margin-right:5%; overflow:hidden;  line-height:30px; height:60px; white-space:normal; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .top2 .price_span{display:inline-block !important; vertical-align:top; overflow:hidden;font-family:Georgia;  font-weight:bold;  overflow:hidden; height:30px; line-height:30px; white-space:nowrap;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> !important;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom{  height:40px; line-height:40px;}

#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .sum_div .monthly{ display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .sum_div .satisfaction{ display:inline-block; vertical-align:top; width:50%; overflow:hidden;}

#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .button_div{ vertical-align:top; width:40%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .button_div .view{}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info  .button_div .add_cart{ display:inline-block; vertical-align:top; display:inline-block; vertical-align:top; height:30px; line-height:30px; border-radius:3px; font-size:1rem;  padding-right:10px; padding-left:5px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info  .button_div .add_cart:before {display:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info  .button_div .add_cart:hover{ opacity:0.9;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info  .button_div .favorite{display:inline-block; vertical-align:top; float:right;  height:30px; line-height:30px; border-radius:2px;  font-size:1rem;  padding-right:10px; }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info  .button_div .favorite:before {font: normal normal normal 1rem/1 FontAwesome; content: "\f005"; padding:0 5px 0 10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info  .button_div .favorite:hover{ opacity:0.9;}


#<?php echo $module['module_name'];?>_html .ad{ margin-bottom:10px;}

#<?php echo $module['module_name'];?>_html .position{ display:none; clear:both; border-bottom:2px solid #ff9600;margin:auto; font-weight:bold; padding-bottom:5px; margin-top:5px; padding-left:15px;  margin-bottom:10px;}
#<?php echo $module['module_name'];?>_html .position a{ display:inline-block;  line-height:1rem;  height:1rem; padding-right:1rem; margin-right:5px; font-weight:lighter; }
#<?php echo $module['module_name'];?>_html .position a:after{ font: normal normal normal 1rem/1 FontAwesome;	margin:0 5px;	content: "\f105";}
#<?php echo $module['module_name'];?>_html .position a:hover{ font-weight:bold;}

#<?php echo $module['module_name'];?>_html .price_span{ font-size:0.8rem;}
#<?php echo $module['module_name'];?>_html .price_span .money_value{ font-size:1rem;}
#<?php echo $module['module_name'];?>_html .price_span .money_symbol{ font-size:0.8rem; padding-left:1px;}

#<?php echo $module['module_name'];?>_html .yuan_2{ line-height:1rem;  padding-left:0px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; font-size:0.8rem; float:right; line-height:2rem;}
#<?php echo $module['module_name'];?>_html .line .yuan_2{ display:inline-block; float:none; padding-left:2rem; padding-top:-10px;}

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=position><?php echo $module['position'];?></div>
	<?php echo $module['ad'];?>
    <div class=content>
		<div class=list>
			<div class=m_label_div>
            	<div class=left_label>
                	<div class=order_div>
                    	<a href=# desc="sequence|desc" class="sorting"  asc="sequence|asc" ><?php echo self::$language['default'];?></a><a href=# desc="monthly|desc" class="sorting"  asc="monthly|asc" ><?php echo self::$language['monthly'];?></a><a href=# desc="w_price|desc" class="sorting"  asc="w_price|asc" ><?php echo self::$language['price'];?></a><a href=# desc="satisfaction|desc" class="sorting"  asc="satisfaction|asc" ><?php echo self::$language['satisfaction'];?></a>
                    </div><div class=price_set_div>
                    	<?php echo self::$language['price_range'];?><input type="text" id=min_price value="<?php echo @$_GET['min_price'];?>" /> - <input type="text" id=max_price value="<?php echo @$_GET['max_price'];?>"  /> <a href="#" class=set_price><?php echo self::$language['submit'];?></a> <span></span>
                    </div>
                </div><div class=right_label>
                	<a href="#" id=show_grid class="show_grid_default" title="<?php echo self::$language['show_grid'];?>"></a><a href="#" id=show_line class=show_line_default title="<?php echo self::$language['show_line'];?>"></a>
                </div>
            </div>
			<div class=goods_list><?php echo $module['list'];?></div>
        </div>
    </div>
    <?php echo $module['page']?>
</div>
</div>