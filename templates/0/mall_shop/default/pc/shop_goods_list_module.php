<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
var credits_rate=<?php echo $module['credits_rate']?>;
$(document).ready(function(){
	
	$("#<?php echo $module['module_name'];?> .goods").each(function(index, element) {
		if($(this).next().attr('class')){
			if($(this).next().offset().top==$(this).offset().top ){$(this).addClass('right_border')}
		}
        
    });;
	$("#<?php echo $module['module_name'];?>").width($("#<?php echo $module['module_name'];?>").width()-4);
	if($("#<?php echo $module['module_name'];?> .cover_image").html()!=null){
		$("#<?php echo $module['module_name'];?> .cover_image img").css('height',$("#<?php echo $module['module_name'];?> .list").height()-2);
		$("#<?php echo $module['module_name'];?> .list").css('width',$("[m_container]").width()-$("#<?php echo $module['module_name'];?> .cover_image").width()+50);
	}else{
		$("#<?php echo $module['module_name'];?> .list").css('width','100%');	
	}
	
	if($("#<?php echo $module['module_name'];?>_html .module_title .name span")){$("#<?php echo $module['module_name'];?>_html .module_title .name").css('text-align','left');}
	
	$("#<?php echo $module['module_name'];?> .sub_type a").hover(function(){
		$("#<?php echo $module['module_name'];?> .sub_type a").attr('class','');
		$(this).attr('class','sub_type_show');
		$("#<?php echo $module['module_name'];?> .list").css('display','none');
		
			
		if($("#<?php echo $module['module_name'];?> .cover_image").html()!=null){
			$("#<?php echo $module['module_name'];?> #hover_"+$(this).attr('d_id')).css('display','inline-block');
		}else{
			$("#<?php echo $module['module_name'];?> #hover_"+$(this).attr('d_id')).css('display','inline-block');
			$("#<?php echo $module['module_name'];?> #hover_"+$(this).attr('d_id')).css('width','100%');	
		}
		
		
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
		if('<?php echo $module['shop_master']?>'=='<?php echo $module['username'];?>'){alert('<?php echo self::$language['can_not_buy_your_goods']?>');return false;}
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
			$(this).html(' <a href="./index.php?monxin=mall.my_cart" class=view><span class=success><?php echo self::$language['success']?></span><?php echo self::$language['view']?></a>');
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
	}
	
});
</script>

<style>
#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block; vertical-align:top;vertical-align:top; overflow:hidden;  margin-bottom:20px;  border:1px solid #e7e7e7; margin-left:0px; }
#<?php echo $module['module_name'];?>_html{ white-space:nowrap; }
#<?php echo $module['module_name'];?> .success{}
#<?php echo $module['module_name'];?>_html .module_title{font-size:1.4rem; height:4rem;line-height:4rem;  border-bottom:3px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; padding-right:25px; overflow:hidden;box-shadow:0px 1px 5px #ccc; text-indent:10px; box-shadow:none;}

#<?php echo $module['module_name'];?>_html .module_title .sub_type{ display:inline-block; vertical-align:top;font-size:1.2rem; line-height:3rem; padding-top:1rem;}
#<?php echo $module['module_name'];?>_html .module_title .sub_type a{ display:inline-block; vertical-align:top; min-width:219px; text-align:center; }
#<?php echo $module['module_name'];?>_html .module_title .sub_type a:hover{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;  }
#<?php echo $module['module_name'];?>_html .module_title .sub_type .sub_type_show{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;    }


#<?php echo $module['module_name'];?>_html .module_title .name{ float:left;min-width:18.5%; width:<?php echo @$module['img_width'];?>; text-align:center; }
#<?php echo $module['module_name'];?>_html .module_title .name span{   background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;    font-weight:bold; padding-left:5px; padding-right:5px; margin-right:5px;}
#<?php echo $module['module_name'];?>_html .module_title .more{ float:right; font-size:1rem; color:#999; }
#<?php echo $module['module_name'];?>_html .module_title .more:hover{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }


#<?php echo $module['module_name'];?>_html .cover_image{ display:inline-block; vertical-align:top;width:<?php echo @$module['img_width'];?>;}
#<?php echo $module['module_name'];?>_html .cover_image:hover{opacity:0.8; filter:alpha(opacity=80);}
#<?php echo $module['module_name'];?>_html .cover_image img{width:<?php echo @$module['img_width'];?>;border:none; padding-top:2px;}
#<?php echo $module['module_name'];?>_html .list { display:inline-block; vertical-align:top; white-space:normal; text-align:left; border-left: 1px solid #eee;}
#<?php echo $module['module_name'];?>_html .list  .goods{ display:inline-block; vertical-align:top; vertical-align:top;; width:20%; height:20.5rem; overflow:hidden;  border-bottom:1px solid #e7e7e7; white-space:nowrap; text-align:left; white-space:nowrap;}
#<?php echo $module['module_name'];?>_html .list .right_border{ border-right:1px solid #e7e7e7;}
#<?php echo $module['module_name'];?>_html .list  .goods:hover{background:#f9f9f9; }
#<?php echo $module['module_name'];?>_html .list  .goods:hover .button_div{ display:block;}
#<?php echo $module['module_name'];?>_html .list  .goods .goods_a{ display:block; text-align:center; margin:auto; padding-bottom:15px;}
#<?php echo $module['module_name'];?>_html .list  .goods .goods_a img{  height:13rem; margin-top:1rem; border:none;}
#<?php echo $module['module_name'];?>_html .list  .goods .goods_a .title{ display:block; text-align:left;  height:28px; line-height:28px; overflow:hidden; font-size:15px;  white-space: nowrap;text-overflow: ellipsis; padding-left:0.5rem;}
#<?php echo $module['module_name'];?>_html .list  .goods .price_span{ display:inline-block; vertical-align:top; text-align:left; height:28px; line-height:28px; overflow:hidden;  padding-left:10px;  width:60%; overflow:hidden; text-overflow: ellipsis;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list  .goods .price_span .money_symbol{}
#<?php echo $module['module_name'];?>_html .list  .goods .price_span .money_value{}




#<?php echo $module['module_name'];?>_html .list  .line{padding-top:15px; padding-bottom:15px; border-bottom:1px solid #e7e7e7; overflow:hidden;  }
#<?php echo $module['module_name'];?>_html .list  .line:hover{ background:#f9f9f9;}
#<?php echo $module['module_name'];?>_html .list  .line .goods_img{ vertical-align:top;text-align:right;  display:inline-block; vertical-align:top; width:14%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list  .line .goods_img img{ width:120px; height:120px; margin:auto; overflow:hidden; border:none;}
#<?php echo $module['module_name'];?>_html .list  .line .good_info{ vertical-align:top; display:inline-block; vertical-align:top; padding-left:1%;overflow:hidden; width:82%;}
#<?php echo $module['module_name'];?>_html .list  .line .good_info:hover{}
#<?php echo $module['module_name'];?>_html .list  .line .good_info .title{ display:block; ; overflow:hidden; font-size:18px;  line-height:30px; height:60px; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list  .line .good_info .price_span{ display:inline-block; vertical-align:top;  overflow:hidden; font-size:24px; font-family:Georgia;  font-weight:bold; height:60px; line-height:60px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}

#<?php echo $module['module_name'];?>_html .hover_list{ display:none;}

#<?php echo $module['module_name'];?>_html .list .goods .button_div{ padding-right:0px; display:inline-block; vertical-align:top; float:right;}
#<?php echo $module['module_name'];?>_html .list .line .button_div{ height:60px; overflow:hidden; line-height:60px; padding-right:50px; display:inline-block; vertical-align:top; float:right;}
#<?php echo $module['module_name'];?>_html .list .add_cart{  margin-right:20px;}
#<?php echo $module['module_name'];?>_html .list a .view{ font-size:0.8rem;}
#<?php echo $module['module_name'];?>_html .list a .view:before{ display:none;}
#<?php echo $module['module_name'];?>_html .add_cart:before {font: normal normal normal 1.2rem/1 FontAwesome;margin-right: 5px;content: "\f07a";color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .add_cart:hover{ opacity:0.9;}
.col-md-2 .button_div{ display:none !important;}

#<?php echo $module['module_name'];?>_html .price_span{ font-size:0.9rem;}
#<?php echo $module['module_name'];?>_html .price_span .money_value{ font-size:1rem;}
#<?php echo $module['module_name'];?>_html .price_span .money_symbol{ font-size:0.9rem; padding-left:1px;}

#<?php echo $module['module_name'];?>_html .yuan_2{ line-height:1rem;  padding-right:4px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; font-size:0.8rem; float:right; line-height:2rem;}

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=module_title style=" display:<?php echo $module['title_show'];?>; "><a class=name href=<?php echo $module['title_link']?>  target="<?php echo $module['target'];?>"><?php echo $module['title'];?></a><span class=sub_type><?php echo $module['sub_type'];?></span><a class=more href=<?php echo $module['title_link']?> target="<?php echo $module['target'];?>"><?php echo self::$language['more'];?></a></div>
	
    <?php echo $module['cover_image'];?>
    <div class=list ><?php echo $module['list'];?></div>
   	<?php echo $module['hover_list'];?>
    
</div>
</div>