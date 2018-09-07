<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left style="display:<?php echo $module['module_show']?>" >
	<script>
	var show_car_timer=null;
	var old_mall_cart=null;
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_html .cart_goods_sum").css('bottom',$('.monxin_bottom').height()-5).css('left','47%');
		//alert($(".fa-shopping-cart").offset().left);
		$(window).focus(function(){
			update_cart_goods_sum();
		});
		update_cart_goods_sum();
    });
	
	function update_cart_goods_sum(){
		old_cart=getCookie('mall_cart');
		if(old_cart){
			old_cart=old_cart.replace(/%3A/g,':');
			old_cart=old_cart.replace(/%2C/g,',');
temp=old_cart;
			old_cart=eval("("+temp+")");
			var cart_goods_sum=0;
			var cart_goods_money=0;
			for(v in old_cart){
				cart_goods_sum++;
				//alert(parseFloat(old_cart[v]['price'])+'*'+old_cart[v]['quantity']+'='+parseFloat(old_cart[v]['price'])*parseInt(old_cart[v]['quantity']));
				cart_goods_money+=parseFloat(old_cart[v]['price'])*parseFloat(old_cart[v]['quantity']);
			}
			cart_goods_sum=cart_goods_sum-<?php echo $module['hidden'];?>;
			$("#<?php echo $module['module_name'];?>_html .cart_goods_sum .m").html(cart_goods_sum);
			$("#index_top_bar .top_bar_cart .top_goods_sum").html(cart_goods_sum);
			$("#<?php echo $module['module_name'];?> .goods_count").html(cart_goods_sum);
			$("#<?php echo $module['module_name'];?> .money_count").html(cart_goods_money.toFixed(2));
			
		}else{
			$("#<?php echo $module['module_name'];?>_html .cart_goods_sum .m").html('0');
			$("#index_top_bar .top_bar_cart .top_goods_sum").html('0');
		}
		if($(".diy_car_icon").html()){reset_cart_sum();}
		
		$("#<?php echo $module['module_name'];?>_html .cart_goods_sum").css('display','block');
		
	}
    </script>
    <style>
	#<?php echo $module['module_name'];?>{ position: absolute; display:none; margin-top:-100px;}    
	#<?php echo $module['module_name'];?> .cart_goods_sum{ bottom:10%; z-index:9999999999999;  position: fixed;font-size:13px; cursor:pointer;}  
	#<?php echo $module['module_name'];?> .cart_goods_sum:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?> .cart_goods_sum .s{ display:none;}
	#<?php echo $module['module_name'];?> .cart_goods_sum .m{ display:block; min-width:1.5rem; line-height:1rem; text-align:center;    border-radius:15px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	#<?php echo $module['module_name'];?> .cart_goods_sum .e{transform:rotate(7deg);-webkit-transform:rotate(7deg); display:block; line-height:5px; height:5px;margin-top:-6px; margin-left:6px; font-weight:bold;}
	#<?php echo $module['module_name'];?> .cart_goods_sum .e:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f0d7"; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
		<div class=cart_goods_sum><span class=s> </span><span class=m> </span><span class=e> </span></div>
    </div>
</div>