<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left style="display:<?php echo $module['module_show']?>" >
	<script>
	var show_car_timer=null;
	var old_mall_cart=null;
	var hidden_keys=eval('(<?php echo @$module['hidden_keys'];?>)');
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>").width(container_width*0.15);
		if('<?php echo $module['cart_show_independent']?>'=='0'){
			if(getCookie('monxin_nickname')!=''){
				$("#<?php echo $module['module_name'];?>_html .top_bar_cart").insertAfter(".user_info #nickname");
			}else{
				$("#<?php echo $module['module_name'];?>_html .top_bar_cart").insertAfter(".user_info #reg_user");	
			}
		}		
		$(window).focus(function(){
			update_cart_goods_sum();
		});
		$("#<?php echo $module['module_name'];?>_html .cart_goods_sum").css('top',$("#<?php echo $module['module_name'];?>_html .cart_button_hide_cart_div .m").offset().top-($("#<?php echo $module['module_name'];?>_html .cart_goods_sum").height()/2)-15).css('left',$("#<?php echo $module['module_name'];?>_html .cart_button_hide_cart_div .m").offset().left+20);
		update_cart_goods_sum();
		old_mall_cart=getCookie('mall_cart');
		if(old_mall_cart==false){$("#<?php echo $module['module_name'];?>_html #cart_is_null").css('display','block');$("#<?php echo $module['module_name'];?>_html #cart_goods_div").css('display','none');}
        $("#<?php echo $module['module_name'];?>_html #cart_button_div a").hover(function(){
			$("#<?php echo $module['module_name'];?> #cart_div").css('top',$(this).offset().top+$(this).height()-9).css('right',$(window).width()-$(this).width()-$(this).offset().left);
			var mall_cart=getCookie('mall_cart');
			if(mall_cart!=old_mall_cart){
				$("#<?php echo $module['module_name'];?> #cart_goods_div").html("<span class='fa fa-spinner fa-spin'></span>");
				$.get("<?php echo $module['action_url'];?>&act=update",function(data){
					
					$("#<?php echo $module['module_name'];?> #cart_goods_div").html(data);
					//alert(data);
					if(data==''){
						$("#<?php echo $module['module_name'];?>_html #cart_is_null").css('display','block');
						$("#<?php echo $module['module_name'];?>_html #cart_goods_div").css('display','none');
					}else{
						$("#<?php echo $module['module_name'];?>_html #cart_is_null").css('display','none');
						$("#<?php echo $module['module_name'];?>_html #cart_goods_div").css('display','block');						
					}
				});	
			}
			$(this).attr('class','cart_button_show_cart_div');	
			obj=$("#<?php echo $module['module_name'];?>_html #cart_div");
			if(obj.css('display')=='none'){
				obj.slideDown();
			}
		},function(){
			show_car_timer=setTimeout(function(){hide_cart_div();},200);
		}); 
		$("#<?php echo $module['module_name'];?>_html #cart_div").hover(function(){
			clearTimeout(show_car_timer);
		},function(){
			show_car_timer=setTimeout(function(){hide_cart_div();},200);
		}); 
		
		$(document).on('click',"#<?php echo $module['module_name'];?>_html .del",function(){
			del_cart_goods($(this).parent().attr('id'));
			return false;
		});
		
    });
	function hide_cart_div(){
		$("#<?php echo $module['module_name'];?>_html #cart_div").slideUp();
		$("#<?php echo $module['module_name'];?>_html #cart_button_div a").attr('class','cart_button_hide_cart_div');	
	}
	
	function del_cart_goods(id){
		$("#<?php echo $module['module_name'];?>_html #"+id).remove();
		id=id.replace(/cart__/,'');
		//alert(id);
		old_cart=getCookie('mall_cart');
		if(old_cart){
			old_cart=old_cart.replace(/%3A/g,':');
			old_cart=old_cart.replace(/%2C/g,',');
data=old_cart;
			old_cart=eval("("+data+")");
			str='';
			for(v in old_cart){
				if(v==id){continue;}
				str+='"'+v+'":{"quantity":"'+old_cart[v]['quantity']+'","time":"'+old_cart[v]['time']+'","price":"'+old_cart[v]['price']+'"},';	
			}
			str=str.substring(0,str.length-1);
			if(str!=''){str='{'+str+'}';}else{$("#<?php echo $module['module_name'];?>_html #cart_is_null").css('display','block');$("#<?php echo $module['module_name'];?>_html #cart_goods_div").css('display','none');}
			setCookie('mall_cart',str,30);
		}
		update_cart_goods_sum();
		$.get("./receive.php?target=mall::cart&act=update_cart");
	}
	
	function update_cart_goods_sum(){
		old_cart=getCookie('mall_cart');
		if(old_cart){
			old_cart=old_cart.replace(/%3A/g,':');
			old_cart=old_cart.replace(/%2C/g,',');
			data=old_cart;
			old_cart=eval("("+data+")");
			var cart_goods_sum=0;
			var cart_goods_money=0;
			for(v in old_cart){
				if(v==0){continue;}
				hid=false;
				for(v2 in hidden_keys){
					if(v==hidden_keys[v2]){hid=true;}
				}
				if(hid){
					console.log(v);
				}else{
					cart_goods_sum++;
					//alert(parseFloat(old_cart[v]['price'])+'*'+old_cart[v]['quantity']+'='+parseFloat(old_cart[v]['price'])*parseInt(old_cart[v]['quantity']));
					cart_goods_money+=parseFloat(old_cart[v]['price'])*parseFloat(old_cart[v]['quantity']);
				}
			}
			//cart_goods_sum=cart_goods_sum-<?php echo $module['hidden'];?>;
			$("#<?php echo $module['module_name'];?>_html .cart_goods_sum .m").html(cart_goods_sum);
			$("#index_top_bar .top_bar_cart .top_goods_sum").html('('+cart_goods_sum+')');
			$("#<?php echo $module['module_name'];?> .goods_count").html(cart_goods_sum);
			$("#<?php echo $module['module_name'];?> .money_count").html(cart_goods_money.toFixed(2));
		}else{
			$("#<?php echo $module['module_name'];?>_html .cart_goods_sum .m").html('0');
			$("#index_top_bar .top_bar_cart .top_goods_sum").html('(0)');
		}
		$("#<?php echo $module['module_name'];?>_html .cart_goods_sum").css('display','block');
		
	}
    </script>
    <style>
	#<?php echo $module['module_name'];?>{ vertical-align:top; width:130px; height:10rem; display:inline-block; vertical-align:top; padding-top:3rem; white-space:nowrap;z-index:99999999999999996;}    
	#<?php echo $module['module_name'];?> #cart_button_div a{ position:relative;  display:block; text-align:right;z-index:99999999999999996; }    
	#<?php echo $module['module_name'];?> .cart_button_hide_cart_div{}    
	#<?php echo $module['module_name'];?> #cart_button_div .cart_button_hide_cart_div .s{display:none;}    
	#<?php echo $module['module_name'];?> #cart_button_div .cart_button_hide_cart_div .m{ display:inline-block; vertical-align:top; height:40px; line-height:40px;  padding: 0 20px;margin-left: 32px;margin-bottom: 10px; background:#eee;color: #666;} 
	#<?php echo $module['module_name'];?> #cart_button_div .cart_button_hide_cart_div .m:before{font: normal normal normal 20px/1 FontAwesome;	margin-right:5px;	content: "\f07a";}   
	#<?php echo $module['module_name'];?> #cart_button_div .cart_button_hide_cart_div .e{display:none;} 
	  
	#<?php echo $module['module_name'];?> #cart_button_div .cart_button_show_cart_div{} 
	#<?php echo $module['module_name'];?> #cart_button_div .cart_button_show_cart_div .s{display:none;} 
	#<?php echo $module['module_name'];?> #cart_button_div .cart_button_show_cart_div .m{ display:inline-block; vertical-align:top; height:40px; line-height:40px;  padding: 0 20px;margin-left: 32px;margin-bottom: 10px;background:#eee;color: #666;} 
	#<?php echo $module['module_name'];?> #cart_button_div .cart_button_show_cart_div .m:before{font: normal normal normal 20px/1 FontAwesome;	margin-right:5px;	content: "\f07a";}   
	#<?php echo $module['module_name'];?> #cart_button_div .cart_button_show_cart_div .e{display:none;} 

	 
	#<?php echo $module['module_name'];?> #cart_div{ display:none;overflow:hidden;z-index:99999999999999996;  position: absolute; right:5%; top:-6px; border:1px solid #ddd; width:500px; box-shadow:0px 0px 5px 0px rgba(0,0,0,.2); background:#fff;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_is_null{ display:none;  height:80px; line-height:80px; }    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div{}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .lately{ display:inline-block; vertical-align:top; height:40px; line-height:40px;  border-bottom:1px solid #ddd; width:100%; padding-left:15px;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div{ max-height:400px; overflow-y:scroll;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div{ height:90px; border-bottom:1px dotted #ddd; }    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div:hover{ background:#eee; }    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div a{}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div .goods_info{width:430px; height:90px; vertical-align:top;  display:inline-block; vertical-align:top;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div .goods_info .img{ width:90px; height:90px; overflow:hidden; display:inline-block; vertical-align:top; vertical-align:top;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div .goods_info .img img{ width:60px; height:60px; margin:15px; border:0px;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div .goods_info .title_and_other{ vertical-align:top; width:300px; overflow:hidden; display:inline-block; vertical-align:top;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div .goods_info .title_and_other .title{ height:2rem; line-height:2rem; overflow:hidden; display:block; font-size:1rem;    white-space: nowrap;text-overflow: ellipsis;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div .goods_info .title_and_other .other{height:45px; line-height:45px; overflow:hidden; display:block; }    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div .goods_info .title_and_other .other .specifications{ display:inline-block; vertical-align:top; font-size:1rem;width:50%; overflow:hidden;color: #666;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div .goods_info .title_and_other .other .price{ display:inline-block; vertical-align:top; font-size:1rem;  width:50%; overflow:hidden;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div .del{ height:90px; line-height:90px; width:40px; overflow:hidden; vertical-align:top; display:inline-block; vertical-align:top;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}  
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .goods_list_div div .del:before{margin-right:8px; font: normal normal normal 1.5rem/1 FontAwesome; content:"\f014"; }
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .view_all{  border-bottom:1px solid #ddd; width:485px; padding-left:15px; display:inline-block; vertical-align:top; line-height:30px; height:30px;  font-size:1rem; text-align:center;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .sum_div{  box-shadow:0 5px 15px #999; display:inline-block; vertical-align: middle; height:80px; width:100%; padding-left:15px; line-height:80px; background:#eee;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .sum_div .goods_count{ font-weight:bold;   margin-left:3px; margin-right:3px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .sum_div .money_count_span{ margin-left:20px;}    
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .sum_div .money_count_span .money_count{ font-size:24px;  font-weight:bold;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}  
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .sum_div .go_w_cashier{ float:right; padding-right:30px; display:inline-block; vertical-align:top;   height:35px; border-radius:5px; line-height:35px;padding:0 20px; margin-top:22px; margin-right:20px;background:<?php echo $_POST['monxin_user_color_set']['button']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['button']['text']?>;  }  
	#<?php echo $module['module_name'];?> #cart_div #cart_goods_div .sum_div .go_w_cashier:hover{ background:<?php echo $_POST['monxin_user_color_set']['button_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['button_hover']['text']?>;}  
	
	#<?php echo $module['module_name'];?> .cart_goods_sum{ display:none; position:absolute;  z-index:99999999999999996; font-size:13px; cursor:pointer;}  
	#<?php echo $module['module_name'];?> .cart_goods_sum:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?> .cart_goods_sum .s{ display:none;}
	#<?php echo $module['module_name'];?> .cart_goods_sum .m{ display:block; min-width:2.2rem; line-height:1.6rem; text-align:center;    border-radius:15px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	#<?php echo $module['module_name'];?> .cart_goods_sum .e{transform:rotate(7deg);-webkit-transform:rotate(7deg); display:block; line-height:5px; height:5px;margin-top:-6px; margin-left:8px; font-weight:bold;}
	#<?php echo $module['module_name'];?> .cart_goods_sum .e:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f0d7";color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	
	#<?php echo $module['module_name'];?> .top_bar_cart{ display:none;}  
	.user_info .top_bar_cart{ display:inline-block;  margin-left:5px;  margin-right:5px; }
	.user_info .top_bar_cart:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	.user_info .top_bar_cart:before {font: normal normal normal 1rem/1 FontAwesome;margin-right: 3px;content: "\f07a"; opacity:0.8;}
	.user_info .top_bar_cart .top_goods_sum{   overflow:hidden;  border-radius:8px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <a href=./index.php?monxin=mall.my_cart class=top_bar_cart><?php echo self::$language['my_cart']?><span class=top_goods_sum>0</span></a>
      	<div id=cart_button_div><a href="./index.php?monxin=mall.my_cart" class="cart_button_hide_cart_div" ><span class=s> </span><span class=m><?php echo self::$language['my_cart'];?></span><span class=e></span></a></div>
        <div class=cart_goods_sum><span class=s> </span><span class=m> </span><span class=e> </span></div>
        <div id=cart_div>
       		<div id=cart_is_null><?php echo self::$language['cart_is_null'];?></div> 
       		<div id=cart_goods_div><?php echo $module['cart_html'];?></div> 
       	</div>
    </div>
</div>