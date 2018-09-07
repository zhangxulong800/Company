<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$(".batch_operation_div").width($("#mall_my_cart").width());
		var old_mall_my_cart=getCookie('mall_cart');
		$(window).focus(function(){
			var mall_my_cart=getCookie('mall_cart');
			if(mall_my_cart!=old_mall_my_cart){
				window.location.reload();
			}
		});
		$("#<?php echo $module['module_name'];?> .tr .model").each(function(index, element) {
            if($(this).html().length==0){
				$(this).prev().css('margin-top',($(this).parent().parent().height()-$(this).prev().height())/2-10);	
			}
        });
		if(old_mall_my_cart==''){
			$("#<?php echo $module['module_name'];?> [monxin-table] .batch_operation_div_out").css('display','none');
			$(".batch_operation_div_out").css('display','none');
			
		}
		
		//$("#<?php echo $module['module_name'];?> .tr .id").prop('checked',true);
		$("#<?php echo $module['module_name'];?> .shop_id").click(function(){
			id=$(this).parent().parent().attr('id');
			//alert($(this).prop('checked'));
			if($(this).prop('checked')){
				$("#<?php echo $module['module_name'];?> #"+id+" .id").prop('checked',true);
			}else{
				$("#<?php echo $module['module_name'];?> #"+id+" .id").prop('checked',false);
			}
			update_selected_goods_sum();
		});
		$("#<?php echo $module['module_name'];?> .tr .id").click(function(){
			update_selected_goods_sum();
		});
		$("#<?php echo $module['module_name'];?> .select_all").click(function(){
			$("#<?php echo $module['module_name'];?> .id").prop('checked',true);
			update_selected_goods_sum();
			return false;
		});
		$("#<?php echo $module['module_name'];?> .reverse_select").click(function(){
			$("#<?php echo $module['module_name'];?> .id").each(function(index, element) {
                $(this).prop('checked',!$(this).prop('checked'));
            });
			update_selected_goods_sum();
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .move_to_favorites").click(function(){
			$(this).html("<span class=\'fa fa-spinner fa-spin\'></span>");
			
			var id=$(this).parent().parent().attr('id');
			$.post("<?php echo $module['action_url'];?>&act=move_to_favorites&goods_id="+id,function(data){
				//alert(data);
				try{json=eval("("+data+")");}catch(exception){alert(data);}
				
				if(json.state=='success'){
					$("#"+id).animate({opacity:0},"slow",function(){$("#"+id).css('display','none');del_my_cart_goods(id);});
				}else{
					$("#<?php echo $module['module_name'];?> #"+id+" .move_to_favorites").html(json.info);
				}
			});	
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .quantity_td a").click(function(){
			if($(this).attr('class')=='decrease_quantity'){
				$("#<?php echo $module['module_name'];?> #"+$(this).parent().parent().attr('id')+" .quantity").val(parseFloat($("#<?php echo $module['module_name'];?> #"+$(this).parent().parent().attr('id')+" .quantity").val())-1);
				 format_quantity($(this).parent().parent().attr('id'));
			}else{
				$("#<?php echo $module['module_name'];?> #"+$(this).parent().parent().attr('id')+" .quantity").val(parseFloat($("#<?php echo $module['module_name'];?> #"+$(this).parent().parent().attr('id')+" .quantity").val())+1);
				 format_quantity($(this).parent().parent().attr('id'));
			}
			update_selected_goods_sum();
			return false;	
		})
		$("#<?php echo $module['module_name'];?> .quantity_td .quantity").change(function(){
			format_quantity($(this).parent().parent().attr('id'));
		});
		
		$("#<?php echo $module['module_name'];?> .tr .del").click(function(){
			// if(confirm("<?php echo self::$language['delete_confirm']?>")){
				id=$(this).parent().parent().attr('id');
				$("#"+id).animate({opacity:0},"slow",function(){$("#"+id).css('display','none');del_my_cart_goods(id);});
			// }
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .go_w_cashier").click(function(){
			if(getCookie('selected_goods')==''){
				alert('<?php echo self::$language['at_least_to_select_a_commodity_to_settlement'];?>');
				return false;		
			}
			
		});
		
		function set_batch_position(){
			
			batch_top=$(".batch_operation_div_out").offset().top;
			cart_bottom=(parseFloat($("#mall_my_cart_html").offset().top)+parseFloat($("#mall_my_cart_html").height()));
			if(cart_bottom>batch_top+10){
				//position:fixed; bottom:0px; left:0px;
				$(".batch_operation_div_out").css('position','fixed').css('bottom','0px').css('left','0px').addClass('in_bottom');
			}else{
				$(".batch_operation_div_out").css('position','inherit').css('bottom','').css('left','').removeClass('in_bottom');
			}	
		}
		set_batch_position();
		$(document).scroll(function(){
			set_batch_position();
		});
		set_batch_position();
		update_selected_goods_sum();
		$("#<?php echo $module['module_name'];?> .shop_id:first").trigger('click');
		$.get("./receive.php?target=mall::cart&act=update_cart");
    });
	
	
	function format_quantity(id){
		obj=$("#<?php echo $module['module_name'];?> #"+id+" .quantity");
		if(!$.isNumeric(obj.val())){obj.val('1');}	
		if(parseFloat(obj.val())<0){obj.val('1');}
		//if(obj.val()>parseInt($(".inventory_m").html())){obj.val(parseInt($(".inventory_m").html()));}
		sub_total=obj.val()*$("#<?php echo $module['module_name'];?> #"+id+" .price").html();
		sub_total=sub_total.toFixed(2);
		$("#<?php echo $module['module_name'];?> #"+id+" .subtotal").html(sub_total);
		if($("#<?php echo $module['module_name'];?> #"+id+" .unit_gram").prop('value')==0){
			obj.val(Math.round(obj.val()));
		}		
		update_goods_quantity(id,obj.val());
	}


	function update_goods_quantity(id,quantity){
		//alert(id+','+quantity);
		id=id.replace(/tr_/,'');
		var old_cart=getCookie('mall_cart');
		if(old_cart!=''){
			old_cart=old_cart.replace(/%3A/g,':');
			old_cart=old_cart.replace(/%2C/g,',');
			//alert(old_cart);
			old_cart=eval('('+old_cart+')');
			if(old_cart[id]){
				old_cart[id]['quantity']=quantity;	
			}
			//old_cart[id]['time']=Date.parse(new Date());
			old_cart[id]['time']=old_cart[id]['time'];
			str='';
			for(v in old_cart){
				str+='"'+v+'":{"quantity":"'+old_cart[v]['quantity']+'","time":"'+old_cart[v]['time']+'","price":"'+old_cart[v]['price']+'"},';	
			}
			str=str.substring(0,str.length-1);
			str='{'+str+'}';
		}
		//alert(str);
		setCookie('mall_cart',str,30);
		update_selected_goods_sum();
		$.get("./receive.php?target=mall::cart&act=update_cart");
	}

	function del_my_cart_goods(id){
		$("#<?php echo $module['module_name'];?>_html #"+id).css('display','none');
		//alert(id);
		id=id.replace(/tr_/,'');
		//alert(id);
		old_cart=getCookie('mall_cart');
		if(old_cart){
			old_cart=old_cart.replace(/%3A/g,':');
			old_cart=old_cart.replace(/%2C/g,',');
			old_cart=eval('('+old_cart+')');
			str='';
			for(v in old_cart){
				if(v==id){continue;}
				str+='"'+v+'":{"quantity":"'+old_cart[v]['quantity']+'","time":"'+old_cart[v]['time']+'","price":"'+old_cart[v]['price']+'"},';	
			}
			str=str.substring(0,str.length-1);
			//alert(str);
			if(str!=''){str='{'+str+'}';}
			setCookie('mall_cart',str,30);
		}
		
		try{update_cart_goods_sum();}catch(e){}
		update_selected_goods_sum();
		$.get("./receive.php?target=mall::cart&act=update_cart");
	}
	
	
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<span class=fail><?php echo self::$language['select_null']?></span>");return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			idss=ids;
			ids=ids.split("|");	
			for(id in ids){
				if(ids[id]==''){continue;}
				del_my_cart_goods("tr_"+ids[id]);
			}
        }	
		$.get("./receive.php?target=mall::cart&act=update_cart");
         return false;	
    }
	
    function move_to_favorites(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<span class=fail><?php echo self::$language['select_null']?></span>");return false;}
		$("#state_select").html('');
		$.post("<?php echo $module['action_url'];?>&act=selected_move_to_favorites",{ids:ids},function(data){	
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#state_select").html(v.info);
			if(v.state=='success'){
				//alert(v.state);
				idss=ids;
				ids=ids.split("|");	
				for(id in ids){
					del_my_cart_goods("tr_"+ids[id]);
				}
			}
		});
		update_selected_goods_sum();	
		$.get("./receive.php?target=mall::cart&act=update_cart");
       	return false;	
    }
	
	function update_selected_goods_sum(){
		old_cart=getCookie('mall_cart');
		if(old_cart){
			old_cart=old_cart.replace(/%3A/g,':');
			old_cart=old_cart.replace(/%2C/g,',');
			old_cart=eval('('+old_cart+')');
			var cart_goods_sum=0;
			var cart_goods_money=0;
			temp='';
			for(v in old_cart){
				
				if($("#<?php echo $module['module_name'];?> #tr_"+v+" .id").prop('checked')){
					cart_goods_sum++;
					//alert(parseFloat(old_cart[v]['price'])+'*'+old_cart[v]['quantity']+'='+parseFloat(old_cart[v]['price'])*parseInt(old_cart[v]['quantity']));
					cart_goods_money+=parseFloat(old_cart[v]['price'])*parseFloat(old_cart[v]['quantity']);
					//alert(v+'='+old_cart[v]['quantity']);
					temp+='"'+v+'":{"quantity":"'+old_cart[v]['quantity']+'","time":"'+old_cart[v]['time']+'"},';	
					$("#<?php echo $module['module_name'];?> #tr_"+v).addClass('selected');
				}else{
					$("#<?php echo $module['module_name'];?> #tr_"+v).removeClass('selected');
				}
			}
			temp=temp.substring(0,temp.length-1);
			if(temp!=''){temp='{'+temp+'}';}
			setCookie('selected_goods',temp,30);
			//alert(cart_goods_sum);
			$("#<?php echo $module['module_name'];?>_html .sum_div .goods_count").html(cart_goods_sum);
			//alert(cart_goods_money.toFixed(2));
			$("#<?php echo $module['module_name'];?> .sum_div .money_count").html(cart_goods_money.toFixed(2));
		}else{
			setCookie('selected_goods','',30);
			$("#<?php echo $module['module_name'];?> .sum_div .money_count").html('0');
			$("#<?php echo $module['module_name'];?>_html .sum_div .goods_count").html('0');
		}
		$.get("./receive.php?target=mall::cart&act=update_cart");
		//alert(getCookie('selected_goods'));
	}
    function get_ids(){
        ids='';
        $("#<?php echo $module['module_name'];?> .id").each(function(){
            if($(this).prop("checked")){ids+=this.id+"|";}              
        });
        return ids;
    }
	
    </script>
    <style>
	#<?php echo $module['module_name'];?>{background:#fff;} 
	
	#<?php echo $module['module_name'];?> .batch_operation_div_out{ width:100%; text-align:center; z-index:999;   background:#fff;}
	#<?php echo $module['module_name'];?>_html .batch_operation_div{width:100%;margin:auto; line-height:1.8rem; height:1.8rem;}    
	#<?php echo $module['module_name'];?>_html .batch_operation_div a:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .batch_operation_div .act_div{ display:inline-block; vertical-align:top; width:40%; text-align:left; }    
	#<?php echo $module['module_name'];?>_html .batch_operation_div .sum_div{ display:inline-block; vertical-align:top; width:60%; text-align:right; }    

	#<?php echo $module['module_name'];?>_html .batch_operation_div .continue_mallping{display:inline-block; vertical-align:top; padding-left:10px; padding-right:10px; border:1px #CCCCCC solid; border-radius:3px;}
	#<?php echo $module['module_name'];?>_html .batch_operation_div .continue_mallping:hover{}
	#<?php echo $module['module_name'];?>_html .batch_operation_div .go_w_cashier{ display:inline-block; vertical-align:top; padding-left:10px; padding-right:10px;   border-radius:3px;}
	#<?php echo $module['module_name'];?>_html .batch_operation_div .go_w_cashier:hover{ }
	#<?php echo $module['module_name'];?>_html .batch_operation_div .goods_count{ font-weight:bold; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
	#<?php echo $module['module_name'];?>_html .batch_operation_div .money_count{ font-weight:bold; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
	#<?php echo $module['module_name'];?>_html .in_bottom{ box-shadow: 0px -1px 2px 2px rgba(0, 0, 0, 0.1); padding:5px;}
	
	#<?php echo $module['module_name'];?>_html .batch_operation_div .del:before{ font: normal normal normal 1rem/1 FontAwesome; content:"\f014"; padding-right:3px;}
	#<?php echo $module['module_name'];?>_html .batch_operation_div .selected_move_to_favorites:before{ font: normal normal normal 1rem/1 FontAwesome; content:"\f005"; padding-right:3px;}
	
	#<?php echo $module['module_name'];?>_html .sales_promotion{   padding-left:3px;padding-right:3px; margin-left:3px; border-radius:7px;background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;}
	  
	  
	  
	  
	  
	  
	  
	  
	  
	#<?php echo $module['module_name'];?> .quantity_td .decrease_quantity{ display:inline-block;  width:40px; height:40px; vertical-align:top; margin-top:40px;border: 1px solid #ddd; border-right:none;}
	#<?php echo $module['module_name'];?> .quantity_td .decrease_quantity:before{font: normal normal normal 1rem/1 FontAwesome; content: "\F068"; padding:0 5px 0 10px;vertical-align: top; color:#999;line-height: 40px;margin-left: 5px;}
	#<?php echo $module['module_name'];?> .quantity_td .decrease_quantity:hover{ opacity:0.8; }
	#<?php echo $module['module_name'];?> .quantity_td .quantity{ width:40px; text-align:center; height:40px; line-height:40px; border-radius:0px; border-left:0px; border-right:0px;padding:0px; display:inline-block; vertical-align:top; margin-top:40px;} 
	
	#<?php echo $module['module_name'];?> .quantity_td .add_quantity{ display:inline-block;  width:40px; height:40px; vertical-align:top; margin-top:40px;  border: 1px solid #ddd; border-left:none; }
	#<?php echo $module['module_name'];?> .quantity_td .add_quantity:before{font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; padding:0 5px 0 10px;vertical-align: top;color:#999;line-height: 40px;margin-left: 5px;}	
	#<?php echo $module['module_name'];?> .quantity_td .add_quantity:hover{ opacity:0.8; }
	 
	#<?php echo $module['module_name'];?>_html .tr .subtotal_td{  font-weight: bold; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;} 
	
	#<?php echo $module['module_name'];?> .move_to_favorites{}    
	#<?php echo $module['module_name'];?> .move_to_favorites:before{ font: normal normal normal 1rem/1 FontAwesome; content:"\f005"; padding-right:3px;}
	#<?php echo $module['module_name'];?> .operation_td .move_to_favorites:hover{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}    
	#<?php echo $module['module_name'];?> .operation_td .del{}    
	#<?php echo $module['module_name'];?> .operation_td .del:before{font: normal normal normal 1rem/1 FontAwesome;content: "\f014"; padding-right:3px; }	
	#<?php echo $module['module_name'];?> .operation_td .del:hover{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}    
	  
	  
	 #<?php echo $module['module_name'];?> { }
	 #<?php echo $module['module_name'];?>_html .checkbox_td{ display:inline-block; vertical-align:top; width:2%; text-align:center;  overflow:hidden;} 
	 #<?php echo $module['module_name'];?>_html .goods_td{ display:inline-block; vertical-align:top; width:50%; overflow:hidden;} 
	 #<?php echo $module['module_name'];?>_html .unit_price_td{display:inline-block; vertical-align:top; width:10%; overflow:hidden; text-align:center;} 
	 #<?php echo $module['module_name'];?>_html .quantity_td{display:inline-block; vertical-align:top;  width:17%;  overflow:hidden; text-align:left;} 
	 #<?php echo $module['module_name'];?>_html .thead .quantity_td {text-align:center;}
	 #<?php echo $module['module_name'];?>_html .shop_goods .quantity_td {padding-left:35px;}
	 #<?php echo $module['module_name'];?>_html .subtotal_td{display:inline-block; vertical-align:top;  width:10%;  overflow:hidden; text-align:center;} 
	#<?php echo $module['module_name'];?>_html .operation_td{display:inline-block; vertical-align:top;  width:10%; overflow:hidden; text-align:left;} 

	 #<?php echo $module['module_name'];?>_html .thead{    margin-top:10px; padding:8px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;} 
	 #<?php echo $module['module_name'];?>_html .shop_div{ margin-top:10px; margin-bottom:10px;} 
	 #<?php echo $module['module_name'];?>_html .shop_div .shop_info{  line-height:30px;} 
	 #<?php echo $module['module_name'];?>_html .shop_div .shop_info input{  } 
	 #<?php echo $module['module_name'];?>_html .shop_div .shop_info .name_l{ display:inline-block; vertical-align:top; display:none; } 
	 #<?php echo $module['module_name'];?>_html .shop_div .shop_info .name_v{ display:inline-block; vertical-align:top; margin-right:30px; } 
	 #<?php echo $module['module_name'];?>_html .shop_div .shop_info .satisfaction_l{ display:inline-block; vertical-align:top; } 
	 #<?php echo $module['module_name'];?>_html .shop_div .shop_info .satisfaction_v{ display:inline-block; vertical-align:top; margin-right:30px; } 
 	 #<?php echo $module['module_name'];?>_html .shop_div .shop_goods{ border: #CCC solid 1px;background-color: #FCFCFC;} 
	 #<?php echo $module['module_name'];?>_html .shop_div .shop_info .fulfil_preferential{ display:inline-block; vertical-align:top; padding-left:8px; padding-right:8px; line-height:1.5rem;   border-radius:8px;background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;}
 	 #<?php echo $module['module_name'];?>_html .shop_div .tr{ height:120px; line-height:120px; border-bottom:1px  solid  #EBEBEB;} 
 	 #<?php echo $module['module_name'];?>_html .shop_div .selected{ } 
	 #<?php echo $module['module_name'];?>_html .shop_div .tr .goods_td{white-space:nowrap;} 
	 #<?php echo $module['module_name'];?>_html .shop_div .tr .goods_td .goods_info{ display:block; } 
	 #<?php echo $module['module_name'];?>_html .shop_div .tr .goods_td .goods_info img{ display:inline-block; vertical-align: middle; border:none; height:100px; width:100px; margin:0px; padding:10px; border:none;} 
	 #<?php echo $module['module_name'];?>_html .shop_div .tr .goods_td .goods_info .title_model{ display:inline-block; vertical-align:top; width:70%; line-height:30px; margin-top:10px;white-space: normal; } 
	 #<?php echo $module['module_name'];?>_html .shop_div .tr .goods_td .goods_info .title_model .title{ } 
	 #<?php echo $module['module_name'];?>_html .shop_div .tr .goods_td .goods_info .title_model .model{ font-style:oblique;} 
	
	
	#<?php echo $module['module_name'];?> .no_related_content_span{ display:block; text-align:center;line-height:50px;}
	
	#<?php echo $module['module_name'];?>_html .tr .operation_td{ display:none;  line-height:2rem; padding-top:2rem;} 
	#<?php echo $module['module_name'];?>_html .tr:hover .operation_td{display:inline-block; }
	
	#<?php echo $module['module_name'];?> .price:after{ content:"<?php echo self::$language['yuan']?>"; font-size:0.8rem; padding-left:1px;}
	#<?php echo $module['module_name'];?> .subtotal:after{ content:"<?php echo self::$language['yuan']?>"; font-size:0.8rem; font-weight:normal; padding-left:1px;}
	 
   	</style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class=thead>
            <div class=goods_td><?php echo self::$language['goods']?></div><div class=unit_price_td><?php echo self::$language['unit_price']?></div><div class=quantity_td><?php echo self::$language['quantity']?></div><div class=subtotal_td><?php echo self::$language['subtotal']?></div><div class=operation_td><?php echo self::$language['operation']?></div>
        </div>
		<?php echo $module['mall_cart'];?>
        
    <div class=batch_operation_div_out>
    <div class=batch_operation_div>
        <div class=act_div>
        <span class="corner"> </span>
        <a href="#" class="select_all" onclick="return select_all();"><?php echo self::$language['select_all']?></a>
        <a href="#" class="reverse_select" onclick="return reverse_select();"><?php echo self::$language['reverse_select']?></a>
         <?php echo self::$language['selected']?>
         <a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a>
         <a href="#"  onclick="return move_to_favorites();" class=selected_move_to_favorites><?php echo self::$language['move_to_favorites']?></a>
          <span id="state_select"></span>
          </div><?php echo $module['sum_info'];?>
                  
     </div>
     </div>
	<br />
	<br />

    </div>
</div>