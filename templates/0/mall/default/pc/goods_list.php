<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left style="width:100%;" >
<script>
var credits_rate=<?php echo $module['credits_rate']?>;
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a").hover(function(){
		$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a").removeClass('show_sub');
		$("#<?php echo $module['module_name'];?> .circle_2 div").css('display','none');
		$("#<?php echo $module['module_name'];?> .circle_2 div[upid="+$(this).attr('circle')+"]").css('display','block');
	});
	$("#<?php echo $module['module_name'];?> .circle_2 div").hover(function(){
		$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a[circle="+$(this).attr('upid')+"]").addClass('show_sub');	
	});
	
	$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_list a[circle]").click(function(){
		window.location.href='./index.php?monxin=mall.goods_list&circle='+$(this).attr('circle');return false;
	});
	
	circle=get_param('circle');
	if(circle==''){circle=getCookie('circle');}
	$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").addClass('current');
	if($("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().attr('upid')){
		$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().css('display','block');
		$("#<?php echo $module['module_name'];?> a[circle='"+$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().attr('upid')+"']").addClass('show_sub');
	}
		
	
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
		url=window.location.href;
		url=replace_get(url,'current_page',1);
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
#<?php echo $module['module_name'];?>{ background:none; padding:0px;}
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html .top{ display:inline-block; vertical-align:top;  border:1px solid #e7e7e7; width:100%; margin-bottom:10px; padding-bottom:10px; background:#fff;}
#<?php echo $module['module_name'];?>_html .top > div{ border-bottom:1px dashed #ccc;margin-bottom:5px; margin-top:5px; }
#<?php echo $module['module_name'];?>_html .top .top_label{ display:inline-block; vertical-align:top; vertical-align:top; width:8%; white-space:nowrap; overflow:hidden; text-align:left; padding-left:10px;  line-height:25px; margin-top:5px; font-size:15px; padding-right:1%;}
#<?php echo $module['module_name'];?>_html .top .top_label:before {font: normal normal normal 18px/1 FontAwesome;margin-right: 5px; content:"\f0da"; color:#ccc;}
#<?php echo $module['module_name'];?>_html .top .top_html{ display:inline-block; vertical-align:top; vertical-align:top; overflow:hidden; width:90%;}
#<?php echo $module['module_name'];?>_html .top .top_html a{ display:inline-block; vertical-align:top; height:2rem; line-height:2rem;   padding-left:0.5rem; padding-right:0.5rem; width:12%; white-space:nowrap; overflow:hidden;text-overflow: ellipsis;}
#<?php echo $module['module_name'];?>_html .top .top_html a:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .top .top_html .current{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .top #type a{}
#<?php echo $module['module_name'];?>_html .list{ padding-bottom:20px;}
#<?php echo $module['module_name'];?>_html .list .m_label_div{ display:inline-block; vertical-align:top; height:3rem;line-height:3rem;   border-bottom:1px solid #e7e7e7; width:100%; background:#fff;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label{ display:inline-block; vertical-align:top; width:80%; overflow:hidden; }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div{display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div a{ display:inline-block; vertical-align:top; padding-right:20px; font-size:1.2rem;  padding-left:20px; color:#999; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div a:after {font: normal normal normal 1.2rem/1 FontAwesome;margin-left:5px;	content: "\f0dc";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .current{ }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order{display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order:hover{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc{display:inline-block; vertical-align:top; background:#fff;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc{display:inline-block; vertical-align:top; background:#fff; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc:after{font: normal normal normal 1.2rem/1 FontAwesome;margin-left:5px;content: "\f0d8";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc:after{font: normal normal normal 1.2rem/1 FontAwesome;	margin-left:5px;	content: "\f0d7";}



#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .price_set_div{display:inline-block; vertical-align:top; margin-left:30px;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .price_set_div input{ width: 60px;vertical-align: middle;text-align: center;margin: 5px;line-height: 40px;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label{ display:inline-block; vertical-align:top; width:20%; text-align:right; overflow:hidden;line-height:3rem; height:3rem; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label a{ display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_grid{ display:inline-block; vertical-align:top; line-height:3rem; height:3rem; width:3rem;  text-align: center; padding-top:0.5rem; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_grid_default{ border:1px solid #e7e7e7; border-top:none; color:#999;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_grid_default:hover{ border:1px solid #e7e7e7; border-top:none;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_grid_current{ border:1px solid #e7e7e7; border-top:none; text-align:center; background:#FFF;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_grid:before {font: normal normal normal 1.5rem/1 FontAwesome;content: "\f009";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_line{ display:inline-block; vertical-align:top; height:3rem; width:3rem; line-height:3rem; text-align: center; padding-top:0.5rem;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_line:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_line:before {font: normal normal normal 1.5rem/1 FontAwesome; content: "\f0c9";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_line_default{ color:#999;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_line_default:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_line_current{ border:1px solid #e7e7e7; border-top:none; text-align:center; background:#FFF;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}

#<?php echo $module['module_name'];?>_html .list .goods_list{}



#<?php echo $module['module_name'];?>_html .list .goods_list .goods{ display:inline-block; vertical-align:top; vertical-align:top; width:18.8%; height:22rem; overflow:hidden; margin:0.7%; border:0.3rem solid #fff; background:#fff;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:hover{ border: 1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;padding: 3px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:nth-child(1){ margin-left:0px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:nth-child(6){ margin-left:0px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:nth-child(11){ margin-left:0px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:nth-child(16){ margin-left:0px;}

#<?php echo $module['module_name'];?>_html .list .goods_list .goods:nth-child(5){ margin-right:0px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:nth-child(10){ margin-right:0px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:nth-child(15){ margin-right:0px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:nth-child(20){ margin-right:0px;}

#<?php echo $module['module_name'];?>_html .list .goods_list .goods:hover .button_div{ display:block;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a{ display:block; text-align:center;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a img{ width:13rem; height:13rem; margin-top:1rem; border:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .title{ display:block; text-align:left;  height:3rem; line-height:1.5rem; overflow:hidden;  width:100%; }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span{ text-align:left; height:2rem; line-height:2rem; overflow:hidden;  font-size:1rem; margin:auto; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; display:inline-block; float:left;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span .money_symbol{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span .money_value{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div{ display:block;height:2rem; line-height:2rem; overflow:hidden;  font-size:1rem;  font-family:Georgia; white-space:nowrap; font-size:0.9rem; opacity:0.7;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly{ text-align:left; display:inline-block; vertical-align:top; width:60%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly .m_label{ box-shadow:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly .value{ padding-left:5px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction{display:inline-block; vertical-align:top; width:40%; text-align:right; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction .m_label{box-shadow:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction .value{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div{ display:none; width:100%; margin:auto; margin-top:15px; clear:both;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div a{ }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .view{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .add_cart{ display:inline-block; vertical-align:top; display:inline-block; vertical-align:top; height:30px; line-height:30px; border-radius:3px; font-size:1rem;  padding-right:10px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .add_cart:before {font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; padding:0 5px 0 10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .add_cart:hover{ opacity:0.9;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .favorite{display:inline-block; vertical-align:top; float:right;  height:30px; line-height:30px; border-radius:2px;  font-size:1rem;  padding-right:10px; background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .favorite:before {font: normal normal normal 1rem/1 FontAwesome; content: "\f005"; padding:0 5px 0 10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .favorite:hover{ opacity:0.9;}




#<?php echo $module['module_name'];?>_html .list .goods_list .line{width:100%; padding-top:15px; padding-bottom:15px; border:4px solid #fff; border-bottom:1px solid #e7e7e7; overflow:hidden; margin-top:0.5rem; margin-bottom:3px; white-space:nowrap; background:#fff;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line:hover{ border:1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;padding: 18px 3px 18px 3px; margin-bottom:-3px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line:hover .button_div{ display:block;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .goods_img{ vertical-align:top;text-align:right;  display:inline-block; vertical-align:top; width:10%; min-width:9rem; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .goods_img img{ width:9rem; height:9rem; margin:auto; overflow:hidden; border:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info{ vertical-align:top; display:inline-block; vertical-align:top; padding-left:1%;width:89%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info:hover{}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info:hover .bottom .button_div{display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .top2{ height:7rem; line-height:3rem;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .top2 .title{ display:inline-block; vertical-align:top; width:70%; margin-right:5%; overflow:hidden; font-size:1.2rem;  line-height:2rem; height:4rem; white-space:normal; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .top2 .price_span{ text-align:right; display:inline-block; vertical-align:top; overflow:hidden; font-size:1.6rem; font-family:Georgia;  font-weight:bold; max-width:25%; height:4rem; line-height:2rem; white-space:nowrap;padding-left:5px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom{ height:3rem; line-height:3rem;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div{ display: inline-block; width:50%; overflow:hidden; font-size:1rem; }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .monthly{}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .monthly .m_label{ box-shadow:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .monthly .value{ padding-left:5px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .satisfaction{ margin-left:50px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .satisfaction .m_label{ box-shadow:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .satisfaction .value{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .sum_div .satisfaction{ padding-left:5px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div{  display:none; text-align:right;width:50%; overflow:hidden; line-height:2rem;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div a{ }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .view{ }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .add_cart{ display:inline-block; vertical-align:top; height:2rem; line-height:2rem; border-radius:3px;  font-size:1rem;  padding-right:10px; margin-right:20px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .add_cart:before{font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; padding:0 5px 0 10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .add_cart:hover{ opacity:0.9;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .favorite{display:inline-block; vertical-align:top; float:right;  height:30px; line-height:30px; border-radius:3px; font-size:1rem;  padding-right:10px; margin-right:20px;background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .favorite:before {font: normal normal normal 1rem/1 FontAwesome; content: "\f005"; padding:0 5px 0 10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .line .good_info .bottom .button_div .favorite:hover{ opacity:0.9;}
#<?php echo $module['module_name'];?>_html  .favorite span{ }
#<?php echo $module['module_name'];?>_html .ad{ margin-bottom:10px; background:#fff;}

	
#<?php echo $module['module_name'];?>_html .circle_filter{ line-height:2rem; display:none; }
#<?php echo $module['module_name'];?>_html .circle_filter .c_label{ display:inline-block; vertical-align:top; width:5%; overflow:hidden; text-align:right;   padding-right:1%; white-space:nowrap; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list{}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1{}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a{ }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 .c{   }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 .show_sub{ border-bottom:2px <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> solid;}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a:hover{  }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2{}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 { }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div{ display:none; }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div a{ }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div a:hover{  }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div .c{  }

#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span{ font-size:0.9rem; padding-left:2px; display:inline-block;}
#<?php echo $module['module_name'];?>_html .money_symbol{ font-size:0.9rem; padding-left:2px; }
#<?php echo $module['module_name'];?>_html .money_value{ font-size:1rem; }
#<?php echo $module['module_name'];?>_html .unit{font-size:0.9rem; }

#<?php echo $module['module_name'];?>_html .yuan_2{ float:right; padding-right:3px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; font-size:0.8rem; line-height:2rem;}
</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<?php echo $module['ad'];?>
    <div class=content>
        	
    	<?php echo $module['data']['top_html'];?>
		<div class=list>
			<div class=m_label_div>
            	<div class=left_label>
                	<div class=order_div>
                    	<a href=# desc="sequence|desc" class="sorting"  asc="sequence|asc" ><?php echo self::$language['composite'];?></a><a href=# desc="monthly|desc" class="sorting"  asc="monthly|asc" ><?php echo self::$language['monthly'];?></a><a href=# desc="w_price|desc" class="sorting"  asc="w_price|asc" ><?php echo self::$language['price'];?></a><a href=# desc="satisfaction|desc" class="sorting"  asc="satisfaction|asc" ><?php echo self::$language['satisfaction'];?></a>
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