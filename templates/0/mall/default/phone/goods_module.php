<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>"  goods_module="<?php echo $module['module_diy']?>" align=left >
<script>
var credits_rate=<?php echo $module['credits_rate']?>;
$(document).ready(function(){
	if('<?php echo @$module['scroll'];?>'=='left' || '<?php echo @$module['scroll'];?>'=='up'){
		if( '<?php echo @$module['scroll'];?>'=='up'){
			$('#<?php echo $module['module_name'];?>_html .list').css('height','<?php echo $module['module_height'];?>');
			if('<?php echo $module['module_height'];?>'=='auto'){
				$('#<?php echo $module['module_name'];?>_html .list').css('height','300px');
			}
		
		}else{
			$("#<?php echo $module['module_name'];?>_html .list  .goods").css('width',$("#<?php echo $module['module_name'];?>_html").width()*0.5);
			
		}
		
		$('#<?php echo $module['module_name'];?>_html .list').liMarquee({direction: '<?php echo @$module['scroll'];?>'});			
	}	
	$("#<?php echo $module['module_name'];?> .sub_type a").click(function(){
		return false;	
	});
	function show_goods_thumb(){
		$("#<?php echo $module['module_name'];?> img").each(function(index, element) {
           if($(window).scrollTop()+$(window).height()+$(window).height()>$(this).offset().top){$(this).attr('src',$(this).attr('wsrc'));}
        });	
	}
	
	$(window).scroll(function(){
		show_goods_thumb();
	});
	show_goods_thumb();
	$("#<?php echo $module['module_name'];?> .goods_a").unbind('click');
	$("#<?php echo $module['module_name'];?> .goods_a").click(function(){
		id=$(this).parent().attr('id');	
		module_bidding_log(id);	
	});
	$("#<?php echo $module['module_name'];?> .goods_img").unbind('click');
	$("#<?php echo $module['module_name'];?> .goods_img").click(function(){
		id=$(this).parent().attr('id');		
		module_bidding_log(id);	
	});
	$("#<?php echo $module['module_name'];?> .title").unbind('click');
	$("#<?php echo $module['module_name'];?> .title").click(function(){
		id=$(this).parent().parent().attr('id');		
		module_bidding_log(id);	
	});
	
	function module_bidding_log(id){
		id=id.replace(/g_/,'');
		if($("#<?php echo $module['module_name'];?> #g_"+id).attr('bidding')==1){
			$.post("./receive.php?target=mall::goods_list&act=bidding",{id:id,src_title:document.title,src_url:document.URL},function(data){
				//alert(data);	
			});	
		}
	}
	
	$("#<?php echo $module['module_name'];?> .sub_type").width($("#<?php echo $module['module_name'];?> .module_title").width()-$("#<?php echo $module['module_name'];?> .module_title .name").width()-10);
	
	if($("#<?php echo $module['module_name'];?> .cover_image").html()!=null){
		$("#<?php echo $module['module_name'];?> .cover_image img").css('height',$("#<?php echo $module['module_name'];?> .list").height()-2);
		$("#<?php echo $module['module_name'];?> .list").css('width',$("#<?php echo $module['module_name'];?>").width()-$("#<?php echo $module['module_name'];?> .cover_image").width()-7);
		$("#<?php echo $module['module_name'];?> .list .goods").css('width','100%');
		$("#<?php echo $module['module_name'];?> .sub_type").css('width',$("#<?php echo $module['module_name'];?> .list").width()-$("#<?php echo $module['module_name'];?> .more").width());
	}else{
		$("#<?php echo $module['module_name'];?> .list").css('width','100%');	
	}
	if($("#<?php echo $module['module_name'];?>_html .module_title .name span")){$("#<?php echo $module['module_name'];?>_html .module_title .name").css('text-align','left');}
	
	
	$("#<?php echo $module['module_name'];?> .sub_type a").hover(function(){
		$("#<?php echo $module['module_name'];?> .sub_type a").attr('class','');
		$(this).attr('class','sub_type_show');
		$("#<?php echo $module['module_name'];?> .list").css('display','none');
		
		$("#<?php echo $module['module_name'];?> #hover_"+$(this).attr('d_id')).css('display','inline-block');

		$("#<?php echo $module['module_name'];?> #hover_"+$(this).attr('d_id')+" img").each(function(index, element) {
            $(this).attr('src',$(this).attr('wsrc'));
        });
	});
	$("#<?php echo $module['module_name'];?> .module_title .name").hover(function(){
		$("#<?php echo $module['module_name'];?> .sub_type a").attr('class','');
		$("#<?php echo $module['module_name'];?> .list").css('display','none');
		$("#<?php echo $module['module_name'];?> .list:first").css('display','inline-block');
	});
	
	$("#<?php echo $module['module_name'];?>_html .add_cart").click(function(){
		if($(this).attr('option_enable')==0 || $(this).attr('s_id')!='0'){
			if($(this).attr('class')==''){return true;}
			if($(this).attr('s_id')=='0'){
				id=$(this).attr('href').replace(/\.\/index\.php\?monxin=mall\.goods&id=/,'');
				var price=$(this).parent().prev().children('.money_value').html();
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
temp=old_cart;
			old_cart=eval("("+temp+")");
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
		module_bidding_log(id);
	}
	
});
</script>

<style>
.container{ background:<?php echo $_POST['monxin_user_color_set']['container']['background']?> !important;}
#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block; vertical-align:top; overflow:hidden; margin-top:0px; padding-bottom:20px;border:1px solid #e7e7e7;   border:0px; background:none;}
#<?php echo $module['module_name'];?>_html{ white-space:nowrap;}
#<?php echo $module['module_name'];?> .success{}
#<?php echo $module['module_name'];?>_html .module_title{font-size:1.1rem; height:3rem;line-height:3rem;  border-bottom:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; padding-left:10px; padding-right:5px; }

#<?php echo $module['module_name'];?>_html .module_title .sub_type{ display:inline-block; padding-left:0.4rem; vertical-align:top;font-size:16px;  float:right; text-align:right; padding-top:0.3rem;}
#<?php echo $module['module_name'];?>_html .module_title .sub_type a{ padding-left:10px; padding-right:10px; font-size:0.9rem; display:inline-block; vertical-align:top; line-height:2.4rem;}
#<?php echo $module['module_name'];?>_html .module_title .sub_type a:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; border-bottom:3px solid<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .module_title .sub_type .sub_type_show{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;border-bottom:3px solid<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }


#<?php echo $module['module_name'];?>_html .module_title .name{ float:left;min-width:130px; width:<?php echo @$module['img_width'];?>;  }
#<?php echo $module['module_name'];?>_html .module_title .name span{    font-weight:bold;padding-left:5px; padding-right:5px; margin-right:5px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .module_title .more{ float:right; font-size:1.1rem; color:#999; display:none; }
#<?php echo $module['module_name'];?>_html .module_title .more:hover{  color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .g_content{clear:both;overflow-x:scroll;}


#<?php echo $module['module_name'];?>_html .cover_image{ display:inline-block; vertical-align:top;width:<?php echo @$module['img_width'];?>;}
#<?php echo $module['module_name'];?>_html .cover_image:hover{opacity:0.8; filter:alpha(opacity=80);}
#<?php echo $module['module_name'];?>_html .cover_image img{width:<?php echo @$module['img_width'];?>;border:none; padding-top:2px;}
#<?php echo $module['module_name'];?>_html .list { display:inline-block; vertical-align:top; white-space:normal;    border-right: 1px solid #f7f7f7;
 white-space:nowrap;} 
#<?php echo $module['module_name'];?>_html .list  .goods{ display:inline-block; vertical-align:top; vertical-align:top; width:30%; overflow:hidden; white-space:nowrap; padding-bottom:0.3rem; margin:1.5%; background:#fff;}
#<?php echo $module['module_name'];?>_html .list  .goods:nth-child(odd){ padding-right:1%;}
#<?php echo $module['module_name'];?>_html .list  .goods:nth-child(even){ padding-left:1%;}
#<?php echo $module['module_name'];?>_html .list  .goods:hover{  border:1px solid #28A03A;   }
#<?php echo $module['module_name'];?>_html .list  .goods:hover .button_div{ opacity:1; white-space:nowrap;}
#<?php echo $module['module_name'];?>_html .list  .goods .goods_a{ display:block; text-align:center; }
#<?php echo $module['module_name'];?>_html .list  .goods .goods_a img{ height:6rem; margin-top:0.3rem; border:none;}
#<?php echo $module['module_name'];?>_html .list  .goods .goods_a .title{ display:block; white-space:normal; text-align:left; padding:0.3rem; line-height:1.3rem; height:
2.6rem; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list  .goods .price_span{ display:block; text-align:center; vertical-align:top;  overflow:hidden; margin-left:10px; text-align:left; line-height:1.6rem;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .list  .goods .price_span .money_symbol{}
#<?php echo $module['module_name'];?>_html .list  .goods .price_span .money_value{}
#<?php echo $module['module_name'];?>_html .list .goods .button_div{   display:block; vertical-align:top; text-align: center;white-space:nowrap; line-height:2rem;}
#<?php echo $module['module_name'];?>_html .list .goods .button_div .add_cart{ padding-left:3px; padding-right:3px;}
#<?php echo $module['module_name'];?>_html .list .goods .button_div .add_cart:before{ display:none !important;}

#<?php echo $module['module_name'];?>_html .list  .goods .sum_div{ margin-top:0.5rem; display:block; overflow:hidden;  font-size:1rem;   font-family:Georgia; padding-left:0.5rem;}
#<?php echo $module['module_name'];?>_html .list  .goods .sum_div .monthly{ text-align:left; display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list  .goods .sum_div .monthly .m_label{ box-shadow:none;}
#<?php echo $module['module_name'];?>_html .list  .goods .sum_div .monthly .value{ padding-left:5px;}
#<?php echo $module['module_name'];?>_html .list  .goods .sum_div .satisfaction{display:inline-block; vertical-align:top; width:49%; text-align:right; overflow:hidden;}


#<?php echo $module['module_name'];?>_html .list  .line{width:100%; padding:0.3rem;border-bottom:1px solid #e7e7e7; overflow:hidden; background:#fff;  }
#<?php echo $module['module_name'];?>_html .list  .line:hover{ }
#<?php echo $module['module_name'];?>_html .list  .line .goods_img{ vertical-align:top;text-align:right;  display:inline-block; vertical-align:top; width:28%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list  .line .goods_img img{ height:6.5rem; margin:auto; overflow:hidden; border:none;}
#<?php echo $module['module_name'];?>_html .list  .line .good_info{ vertical-align:top; display:inline-block; vertical-align:top; padding-left:1%;overflow:hidden; width:71%;}
#<?php echo $module['module_name'];?>_html .list  .line .good_info:hover{}
#<?php echo $module['module_name'];?>_html .list  .line .good_info:hover .button_div{ opacity:1;}
#<?php echo $module['module_name'];?>_html .list  .line .good_info .title{ display:block; overflow:hidden; font-size:1rem; line-height:1.5rem;  height:3rem; overflow:hidden;}

#<?php echo $module['module_name'];?>_html .list  .line .sum_div{ display:block;  font-size:1rem; margin-top:0.5rem;   font-family:Georgia; padding-left:0.5rem;}
#<?php echo $module['module_name'];?>_html .list  .line .sum_div .monthly{ text-align:left; display:inline-block; vertical-align:top; width:54%; overflow:hidden; margin-bottom:0.5rem;}
#<?php echo $module['module_name'];?>_html .list  .line .sum_div .monthly .m_label{ box-shadow:none;}
#<?php echo $module['module_name'];?>_html .list  .line .sum_div .monthly .value{ padding-left:5px;}
#<?php echo $module['module_name'];?>_html .list  .line .sum_div .satisfaction{display:inline-block; vertical-align:top; width:40%; text-align:right; overflow:hidden;}

#<?php echo $module['module_name'];?>_html .hover_list{ display:none;}
#<?php echo $module['module_name'];?>_html .list  .line .price_span{display:inline-block; vertical-align:top; width:50%;  line-height:2rem;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .list .line .button_div{display:inline-block; vertical-align:top; width:50%;  text-align:right; line-height:2rem;white-space:nowrap;}
#<?php echo $module['module_name'];?>_html .list .add_cart{ display:inline-block;   height:2rem; line-height:2rem; border-radius:2px; font-size:1rem;  padding-right:10px; margin-right:10px;}
#<?php echo $module['module_name'];?>_html .list .add_cart:before{font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; padding:0 5px 0 10px;}
#<?php echo $module['module_name'];?>_html .list a .view{ font-size:1rem;}
#<?php echo $module['module_name'];?>_html .list .add_cart:hover{ opacity:0.9;}
.module_div_bottom_margin {margin-bottom: 0px;}
#<?php echo $module['module_name'];?>_html .normal_price{ text-decoration:line-through; opacity:0.3; padding-left:2rem;}

#<?php echo $module['module_name'];?>_html .money_symbol{ font-size:0.8rem; padding-left:2px; }
#<?php echo $module['module_name'];?>_html .unit{font-size:0.8rem; }

#<?php echo $module['module_name'];?>_html .yuan_2{ line-height:1rem; display:block; padding-left:10px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; font-size:0.8rem;}
#<?php echo $module['module_name'];?>_html .line .yuan_2{ line-height:1rem; display:block; padding-left:0px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; font-size:0.8rem;}

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=module_title style=" display:<?php echo $module['title_show'];?>; "><a class=name href=<?php echo $module['title_link']?>  target="<?php echo $module['target'];?>"><?php echo $module['title'];?></a><span class=sub_type><?php echo $module['sub_type'];?></span><a class=more href=<?php echo $module['title_link']?> target="<?php echo $module['target'];?>"><?php echo self::$language['more'];?></a></div>
	<div class=g_content>
		<?php echo $module['cover_image'];?>
        <div class=list ><?php echo $module['list'];?></div>
        <?php echo $module['hover_list'];?>
    </div>
    
</div>
</div>