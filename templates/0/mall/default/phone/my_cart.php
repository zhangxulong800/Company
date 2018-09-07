<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$(".monxin_head .refresh").css('display','none');
		$(".monxin_head").append('<a href=# class=show_edit_div><?php echo self::$language['edit']?></a>');
		$(".edit_div a").html('');
		$(".batch_operation_div").width($("#mall_my_cart").width());
		var old_mall_my_cart=getCookie('mall_cart');
		$(window).focus(function(){
			var mall_my_cart=getCookie('mall_cart');
			if(mall_my_cart!=old_mall_my_cart){
				window.location.reload();
			}
		});
		$(".show_edit_div").click(function(){
			if($(this).html()=='<?php echo self::$language['edit']?>'){
				$(this).html('<?php echo self::$language['complete']?>');
				$(".goods_other").css('display','none');
				$(".edit_div").css('display','block');
				$("#act_button .text").html('<?php echo self::$language['del']?>');
			}else{
				$(this).html('<?php echo self::$language['edit']?>');
				$(".goods_other").css('display','block');
				$(".edit_div").css('display','none');
				$("#act_button .text").html('<?php echo self::$language['settlement']?>');
			}
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .all_checkbox").click(function(){
			if($(this).attr('checked')=='checked'){
				$("#<?php echo $module['module_name'];?> .m_checkbox").removeAttr('checked');	
			}else{
				$("#<?php echo $module['module_name'];?> .m_checkbox").attr('checked','checked');
			}
			update_selected_goods_sum();
			return false;
		});	

		$("#<?php echo $module['module_name'];?> .shop_checkbox").click(function(){
			id=$(this).parent().parent().parent().attr('id');
			if($(this).attr('checked')=='checked'){
				$("#"+id+" .m_checkbox").removeAttr('checked');	
			}else{
				$("#"+id+" .m_checkbox").attr('checked','checked');
			}
			update_selected_goods_sum();
			return false;
		});	


		$("#<?php echo $module['module_name'];?> .goods_checkbox").click(function(){
			id=$(this).parent().parent().parent().parent().attr('id');
			if($(this).attr('checked')=='checked'){
				$("#"+id+" .shop_checkbox").removeAttr('checked');	
			}
			if($(this).attr('checked')==='checked'){
				$(this).removeAttr('checked');
			}else{
				$(this).attr('checked','checked');
			}
			
			update_selected_goods_sum();
			return false;
		});	


		if(old_mall_my_cart==''){$("#<?php echo $module['module_name'];?> [monxin-table] .batch_operation_div_out").css('display','none');}
		
		//$("#<?php echo $module['module_name'];?> .goods .id").prop('checked',true);
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
			var id=id=$(this).parent().parent().parent().attr('id');
			$.post("<?php echo $module['action_url'];?>&act=move_to_favorites&goods_id="+id.replace(/goods_/,''),function(data){
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
				$(this).parent().children('input').val(parseFloat($(this).parent().children('input').val())-1);
				 format_quantity($(this).parent().parent().parent().parent().attr('id'));
			}else{
				$(this).parent().children('input').val(parseFloat($(this).parent().children('input').val())+1);
				 format_quantity($(this).parent().parent().parent().parent().attr('id'));
			}
			update_selected_goods_sum();
			return false;	
		})
		$("#<?php echo $module['module_name'];?> .quantity_td .quantity").change(function(){
			format_quantity($(this).parent().parent().parent().parent().attr('id'));
		});
		
		$("#<?php echo $module['module_name'];?> .goods .del").click(function(){
			id=$(this).parent().parent().parent().attr('id');
			$("#"+id).animate({opacity:0},"slow",function(){$("#"+id).css('display','none');del_my_cart_goods(id);});
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> #act_button").click(function(){
			if($(this).attr('class')!=='m_active'){
				return false;	
			}
			if($(this).children('.text').html()=='<?php echo self::$language['del'];?>'){
				del_select();
				return false;	
			}
		});
		
		function set_batch_position(){
			$(".monxin_head").css('display','block');
			$(".page-container").css('padding-top',$(".monxin_head").height());
			//$("#<?php echo $module['module_name'];?> .batch_operation_div").css('bottom',$(".monxin_bottom").height());
		}
		set_batch_position();
		$(document).scroll(function(){
			set_batch_position();
		});
		
		update_selected_goods_sum();
		$("#<?php echo $module['module_name'];?> .shop_checkbox:first").trigger('click');
		
		$.get("./receive.php?target=mall::cart&act=update_cart");
    });
	
	
	function format_quantity(id){
		obj=$("#<?php echo $module['module_name'];?> #"+id+" .quantity");
		if(!$.isNumeric(obj.val())){obj.val('1');}	
		if(parseFloat(obj.val())<0){obj.val('1');}
		//if(obj.val()>parseInt($(".inventory_m").html())){obj.val(parseInt($(".inventory_m").html()));}
		sub_total=obj.val()*$("#<?php echo $module['module_name'];?> #"+id+" .subtotal").attr('price');
		sub_total=sub_total.toFixed(2);
		$("#<?php echo $module['module_name'];?> #"+id+" .subtotal").html(sub_total);
		if($("#<?php echo $module['module_name'];?> #"+id+" .unit_gram").prop('value')==0){
			obj.val(Math.round(obj.val()));
		}		
		update_goods_quantity(id,obj.val());
	}


	function update_goods_quantity(id,quantity){
		//alert(id+','+quantity);
		id=id.replace(/goods_/,'');
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
		id=id.replace(/goods_/,'');
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
		//alert('zz');
	}
	
	
    function del_select(){
		
        ids=get_ids();
        if(ids==''){return false;}
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			idss=ids;
			ids=ids.split("|");	
			for(id in ids){
				if(ids[id]==''){continue;}
				del_my_cart_goods("goods_"+ids[id]);
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
					del_my_cart_goods("goods_"+ids[id]);
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
				
				if($("#<?php echo $module['module_name'];?> #goods_"+v+" .goods_checkbox").attr('checked')=='checked'){
					
					cart_goods_sum++;
				//alert(parseFloat(old_cart[v]['price'])+'*'+old_cart[v]['quantity']+'='+parseFloat(old_cart[v]['price'])*parseInt(old_cart[v]['quantity']));
					cart_goods_money+=parseFloat(old_cart[v]['price'])*parseFloat(old_cart[v]['quantity']);
					//alert(v+'='+old_cart[v]['quantity']);
					temp+='"'+v+'":{"quantity":"'+old_cart[v]['quantity']+'","time":"'+old_cart[v]['time']+'"},';	
					$("#<?php echo $module['module_name'];?> #goods_"+v).addClass('selected');
				}else{
					$("#<?php echo $module['module_name'];?> #goods_"+v).removeClass('selected');
				}
			}
			temp=temp.substring(0,temp.length-1);
			if(temp!=''){temp='{'+temp+'}';}
			setCookie('selected_goods',temp,30);
			//alert(cart_goods_sum);
			$("#<?php echo $module['module_name'];?>_html .goods_count").html(cart_goods_sum);
			$("#<?php echo $module['module_name'];?>_html  .money_count").html(cart_goods_money.toFixed(2));
			if(cart_goods_sum){
				$("#<?php echo $module['module_name'];?> #act_button").addClass('m_active');
			}else{
				$("#<?php echo $module['module_name'];?> #act_button").removeClass('m_active');
			}
			
		}else{
			setCookie('selected_goods','',30);
			$("#<?php echo $module['module_name'];?>_html .goods_count").html('0');
			$("#<?php echo $module['module_name'];?>_html  .money_count").html('0');
			$
		}
		$.get("./receive.php?target=mall::cart&act=update_cart");
		//alert(getCookie('selected_goods'));
	}
    function get_ids(){
        ids='';
        $("#<?php echo $module['module_name'];?> .goods_checkbox").each(function(){
            if($(this).attr("checked")=='checked'){ids+=$(this).attr('d_id')+"|";}              
        });
        return ids;
    }
	
    </script>
    <style>
	.monxin_bottom,.cart_goods_sum,.fixed_right_div,#index_foot,#index_device,.monxin_bottom_switch{ display:none !important;}
	.page-container{ padding-bottom:0px;}
	.page-footer{background: #F6F6F6;}
	#<?php echo $module['module_name'];?>{background: #F6F6F6; margin:0px;min-height:500px;} 
	#<?php echo $module['module_name'];?>_html {} 
	#<?php echo $module['module_name'];?>_html .checkbox_td{ display:inline-block; vertical-align:top; width:10%; overflow:hidden;}
	
	 
	#<?php echo $module['module_name'];?>_html .shop_div{   margin-bottom:1rem;background-color: #fff;} 
	
	#<?php echo $module['module_name'];?>_html .shop_div .shop_info{ line-height:3rem; border-bottom: #CCC 1px solid;} 
	#<?php echo $module['module_name'];?>_html .shop_div .shop_info .shop_checkbox{ margin-top:0.7rem;}
	#<?php echo $module['module_name'];?>_html .shop_div .shop_info .text{ white-space:nowrap; display:inline-block; vertical-align:top; width:90%; overflow:hidden;} 
	#<?php echo $module['module_name'];?>_html .shop_div .shop_info .text .name{ font-weight:bold; display:inline-block;  width:50%; vertical-align:top;  white-space:nowrap; overflow:hidden;text-overflow: ellipsis} 
	#<?php echo $module['module_name'];?>_html .shop_div .shop_info .text .name:after{ padding-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f105";}
	#<?php echo $module['module_name'];?>_html .shop_div .shop_info .text .fulfil_preferential{  display:inline-block; width:50%; vertical-align:top; line-height:3rem; white-space:nowrap; overflow:hidden;text-overflow: ellipsis; color: #CCC; text-align:right; padding-right:3px;} 
	
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods{} 
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods{ height:5rem; border-bottom: 1px solid #ECE8E8; margin-top:10px;} 
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods:last-child{ border:none;}
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .goods_td{ display:inline-block; vertical-align:top; width:65%; overflow:hidden;} 
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .goods_td .icon{ display:inline-block; vertical-align:top; width:20%; overflow:hidden;} 
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .goods_td .icon img{ display:block; width:100%;} 
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .goods_td .goods_info{ display:inline-block; vertical-align:top; width:80%; overflow:hidden;} 
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .goods_td .goods_info .title{  display:block; padding-left:0.6rem; height:2.3rem; overflow:hidden; line-height:1.2rem;} 
	#<?php echo $module['module_name'];?> .quantity_td{ display:inline-block; margin-left:0.6rem; line-height:1.5rem;   border:1px solid #dadada;  } 
	#<?php echo $module['module_name'];?> .quantity_td .decrease_quantity{ display:inline-block;  width:2.5rem;text-align:center; vertical-align:top; }
	#<?php echo $module['module_name'];?> .quantity_td .decrease_quantity:before{font: normal normal normal 1rem/1 FontAwesome; content: "-";color:rgba(153,153,153,1);}
	#<?php echo $module['module_name'];?> .quantity_td .quantity{ display:inline-block; vertical-align:top; line-height:1.5rem; height:1.5rem; border-border-left:1px solid #dadada; border-right:1px solid #dadada;   text-align:center; width:3rem;  border-radius:0px;padding:0px; } 
	
	#<?php echo $module['module_name'];?> .quantity_td .add_quantity{ display:inline-block;  width:2.5rem;text-align:center;vertical-align:top;  }
	#<?php echo $module['module_name'];?> .quantity_td .add_quantity:before{font: normal normal normal 1rem/1 FontAwesome; content: "+"; color:rgba(153,153,153,1);}	
	#<?php echo $module['module_name'];?> .quantity_td .unit{ display:none;}
	#<?php echo $module['module_name'];?> .quantity_td .unit_gram{ display:none;}
	
	
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .act_td{display:inline-block; text-align:right; vertical-align:top; width:25%; overflow:hidden;} 
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .act_td div{ margin-right:3px;}
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .act_td .goods_other{ }
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .act_td .goods_other .model{  font-size:0.9rem; color:#ccc;}
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .act_td .subtotal{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .act_td .subtotal:after{ content:"<?php echo self::$language['yuan']?>"; font-size:0.8rem; font-weight:normal; padding-left:1px;}
	#<?php echo $module['module_name'];?>_html .shop_div .shop_goods .goods .act_td .edit_div{ display:none; line-height:2.5rem;} 

	#<?php echo $module['module_name'];?>_html .batch_operation_div{ position:fixed; width:100%; bottom:0px; line-height:3.5rem; height:3.5rem;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; } 
   	#<?php echo $module['module_name'];?>_html .batch_operation_div a{ }
	#<?php echo $module['module_name'];?>_html .batch_operation_div .sum_td{ display:inline-block; vertical-align:top; width:60%; overflow:hidden; white-space:nowrap;line-height:3.5rem;}
   	#<?php echo $module['module_name'];?>_html .batch_operation_div .act_td{ text-align:right; display:inline-block; vertical-align:top; width:30%; overflow:hidden; white-space:nowrap;line-height:3.5rem;}
	#<?php echo $module['module_name'];?>_html .batch_operation_div #act_button{ display:inline-block; margin-right:1rem; line-height:2rem;   border-radius:5px; padding:5px;background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>; }
   	
	#<?php echo $module['module_name'];?>_html .batch_operation_div .all_checkbox{ margin-top:0.6rem;}
   	#<?php echo $module['module_name'];?>_html .batch_operation_div .checkbox_td div{ font-size:0.8rem; line-height:1.5rem; text-align:center;}
	.edit_div a{ padding-right:0.6rem; width:100%;  display:inline-block; }
	.edit_div .move_to_favorites:before{font: normal normal normal 1.2rem/1 FontAwesome; content: "\f005";}	
	.edit_div .del:before{font: normal normal normal 1.2rem/1 FontAwesome; content: "\f014";}
	.show_edit_div{ font-size:1rem !important;}	
	.no_related_content_span{ display:block;  text-align:center; line-height:3rem;}
   	</style>
    <div id="<?php echo $module['module_name'];?>_html">
		<?php echo  $module['mall_cart'];?>
        <div class=batch_operation_div>
        	<div class=checkbox_td><span class='m_checkbox all_checkbox ' ></span><div><?php echo self::$language['select_all']?></div></div><div class=sum_td><?php echo $module['sum_info'];?></div><div class=act_td><a href="./index.php?monxin=mall.confirm_order&goods_src=selected_goods" id=act_button><span class=text><?php echo self::$language['settlement']?></span>(<span class=goods_count></span>)</a></div>
        </div>

    </div>
</div>