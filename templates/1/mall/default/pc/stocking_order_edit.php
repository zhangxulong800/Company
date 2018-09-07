<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .pay_method a").click(function(){
			$("#<?php echo $module['module_name'];?> .pay_method a").removeClass('current');
			$("#<?php echo $module['module_name'];?> .input_div div").css('display','none');
			if($(this).attr('href')=='pos' || $(this).attr('href')=='meituan' || $(this).attr('href')=='nuomi' || $(this).attr('href')=='other'){
				$("#<?php echo $module['module_name'];?> .reference_number_div").css('display','block');
			}
			if($(this).attr('href')=='balance' || $(this).attr('href')=='shop_balance'){
				$("#<?php echo $module['module_name'];?> .transaction_password_div").css('display','block');
			}
			$(this).addClass('current');
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .pay_method_div .submit").click(function(){
			v='';
			$("#<?php echo $module['module_name'];?> .pay_method_div .submit").next().html('');
			pay_method=$("#<?php echo $module['module_name'];?> .pay_method .current").attr('href');
			if(!pay_method){
					$("#<?php echo $module['module_name'];?> .pay_method_div .submit").next().html('<span class=fail><?php echo self::$language['please_select']?><?php echo self::$language['pay_method_str']?></span>');
					return false;
				
			}
			if(pay_method=='alipay' || pay_method=='weixin'){
				window.location.href=$("#<?php echo $module['module_name'];?> .pay_method .current").attr('lhref');
				return false;
			}
			
			if(pay_method=='pos' || pay_method=='meituan' || pay_method=='nuomi' || pay_method=='other'){
				$("#<?php echo $module['module_name'];?> .reference_number_div").css('display','block');
				v=$("#<?php echo $module['module_name'];?> .reference_number").val();
				if(v==''){
					$("#<?php echo $module['module_name'];?> .reference_number").focus();
					$("#<?php echo $module['module_name'];?> .pay_method_div .submit").next().html('<span class=fail><?php echo self::$language['please_input']?></span>');
					return false;
				}
				
			}
			if(pay_method=='balance' || pay_method=='shop_balance'){
				$("#<?php echo $module['module_name'];?> .transaction_password_div").css('display','block');
				v=$("#<?php echo $module['module_name'];?> .transaction_password").val();
				if(v==''){
					$("#<?php echo $module['module_name'];?> .transaction_password").focus();
					$("#<?php echo $module['module_name'];?> .pay_method_div .submit").next().html('<span class=fail><?php echo self::$language['please_input']?></span>');
					return false;
				}
			}
			
			
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>',{v:v,pay_method:pay_method}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#<?php echo $module['module_name'];?> .pay_method_div .submit").next().html(v.info);
				if(v.state=='success'){
					parent.update_state();
				}
            });
			
			return false;
		});
		
		
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
             if($(this).attr('monxin_value')){$(this).val($(this).attr('monxin_value'));}
        });
		
		$("#<?php echo $module['module_name'];?> .edit_goods_quantity .submit").click(function(){
			$(this).next().html('');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>',{v:$("#<?php echo $module['module_name'];?> .edit_goods_quantity input").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .edit_goods_quantity .submit").next().html(v.info);
				if(v.state=='success'){
					if(v.change_quantity){
						parent.update_order_goods_quantity(<?php echo @$_GET['id']?>,v.change_quantity,v.change_price);	
					}
				}
            });
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .express_cost_buyer .submit").click(function(){
			$(this).next().html('');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>',{v:$("#<?php echo $module['module_name'];?> .express_cost_buyer input").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .express_cost_buyer .submit").next().html(v.info);
				if(v.state=='success'){
					parent.update_express_cost_buyer(<?php echo @$_GET['id']?>,v.express_cost_buyer);	
					parent.update_actual_money(<?php echo @$_GET['id']?>,v.actual_money);	
					parent.update_sum_money(<?php echo @$_GET['id']?>,v.sum_money);	
				}
            });
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .express_cost_seller .submit").click(function(){
			$(this).next().html('');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>',{v:$("#<?php echo $module['module_name'];?> .express_cost_seller input").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .express_cost_seller .submit").next().html(v.info);
				if(v.state=='success'){
					parent.update_express_cost_seller(<?php echo @$_GET['id']?>,v.express_cost_seller);	
				}
            });
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .receiving_extension .submit").click(function(){
			$(this).next().html('');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>',{v:$("#<?php echo $module['module_name'];?> .receiving_extension input").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .receiving_extension .submit").next().html(v.info);
				if(v.state=='success'){
					parent.update_receiving_extension(<?php echo @$_GET['id']?>,v.day);	
				}
            });
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .seller_remark .submit").click(function(){
			$(this).next().html('');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>',{v:$("#<?php echo $module['module_name'];?> .seller_remark input").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .seller_remark .submit").next().html(v.info);
				if(v.state=='success'){
					parent.update_seller_remark(<?php echo @$_GET['id']?>,$("#<?php echo $module['module_name'];?> .seller_remark input").val());	
				}
            });
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .actual_money_div .submit").click(function(){
			$(this).next().html('');
			if($("#<?php echo $module['module_name'];?> .actual_money_div #actual_money").val()==''){$("#<?php echo $module['module_name'];?> .actual_money_div .submit").next().html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['actual_money']?></span>');return false;}
			if($("#<?php echo $module['module_name'];?> .actual_money_div #change_price_reason").val()==''){$("#<?php echo $module['module_name'];?> .actual_money_div .submit").next().html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['change_price_reason']?></span>');return false;}
			
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>',{actual_money:$("#<?php echo $module['module_name'];?> .actual_money_div #actual_money").val(),change_price_reason:$("#<?php echo $module['module_name'];?> .actual_money_div #change_price_reason").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .actual_money_div .submit").next().html(v.info);
				if(v.state=='success'){
					parent.update_actual_money(<?php echo @$_GET['id']?>,v.actual_money);		
					parent.update_change_price_reason(<?php echo @$_GET['id']?>,v.change_price_reason);		
				}
            });
			return false;	
		});
		
		
		
		$("#<?php echo $module['module_name'];?> .express_div .submit").click(function(){
			$(this).next().html('');
			if($("#<?php echo $module['module_name'];?> .express_div #express_code").val()==''){$("#<?php echo $module['module_name'];?> .express_div .submit").next().html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['express_code']?></span>');return false;}
			
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>',{express_code:$("#<?php echo $module['module_name'];?> .express_div #express_code").val(),express:$("#<?php echo $module['module_name'];?> .express_div #express").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .express_div .submit").next().html(v.info);
				if(v.state=='success'){
					parent.update_express(<?php echo @$_GET['id']?>,$("#<?php echo $module['module_name'];?> .express_div #express").find("option:selected").text());		
					parent.update_express_code(<?php echo @$_GET['id']?>,$("#<?php echo $module['module_name'];?> .express_div #express_code").val());
					parent.update_action_button_2(<?php echo @$_GET['id']?>);			
				}
            });
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .container_div .submit").click(function(){
			$(this).next().html('');
			if($("#<?php echo $module['module_name'];?> .container_div .container_info").val()==''){$("#<?php echo $module['module_name'];?> .container_div .submit").next().html('<span class=fail><?php echo self::$language['please_input']?></span>');return false;}
			
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>',{express_code:$("#<?php echo $module['module_name'];?> .container_div .container_info").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){console.log(data);}
				
                $("#<?php echo $module['module_name'];?> .container_div .submit").next().html(v.info);
				if(v.state=='success'){
					parent.update_state();			
				}
            });
			return false;	
		});
		
		
		
		if(get_param('act')=='order_state_2'){
			frist_show='container_div';
			$("#<?php echo $module['module_name'];?> ."+frist_show).css('display','block');
			$("#<?php echo $module['module_name'];?> [show='"+frist_show+"']").addClass('current');
			
			$("#<?php echo $module['module_name'];?>  .top_label a").click(function(){
				$("#<?php echo $module['module_name'];?>  .top_label a").removeClass('current');
				$("#<?php echo $module['module_name'];?> .express_div").css('display','none');
				$("#<?php echo $module['module_name'];?> .container_div").css('display','none');
				$(this).addClass('current');
				$("#<?php echo $module['module_name'];?> ."+$(this).attr('show')).css('display','block');
				return false;
			});
			
			$("#<?php echo $module['module_name'];?> .container_info").focus(function(){
				if($(this).val()==''){$(this).val('<?php echo self::$language['container_default']?>');}
			});
		}
    });
    
    </script>
    <style>
	.fixed_right_div{ display:none;}
	#<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?>_html .m_label{ display:inline-block; vertical-align:top; width:30%; padding-right:10px; text-align:right;line-height:60px; }
	#<?php echo $module['module_name'];?>_html .input{ display:inline-block; vertical-align:top; width:68%; text-align:left; line-height:60px;}

	
    #<?php echo $module['module_name'];?>_html{ text-align:center;}
	#<?php echo $module['module_name'];?>_html .express_cost_buyer{}
	#<?php echo $module['module_name'];?>_html .express_cost_seller{ }
	#<?php echo $module['module_name'];?>_html .seller_remark{}
	#<?php echo $module['module_name'];?>_html .seller_remark input{ width:60%;}
	#<?php echo $module['module_name'];?>_html .actual_money_div{ text-align:left;  line-height:80px;}
	#<?php echo $module['module_name'];?>_html .express_div{ text-align:left;   line-height:80px;}
	#<?php echo $module['module_name'];?>_html .show_bank_transfer{ text-align:left; ; margin-left:50px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html .show_bank_transfer img{}	
	#<?php echo $module['module_name'];?> .view_logistics{ display:block;}
	
	#<?php echo $module['module_name'];?> .order_state_2{}
	#<?php echo $module['module_name'];?> .order_state_2 .top_label{ line-height:2rem; cursor:pointer; border-bottom:3px solid #ECECEC; margin-bottom:1rem;}
	#<?php echo $module['module_name'];?> .order_state_2 .top_label a{ display:inline-block; vertical-align:top; width:100px; margin-left:1rem;  margin-right:1rem; }
	#<?php echo $module['module_name'];?> .order_state_2 .top_label a:hover{ background:#ECECEC;}
	#<?php echo $module['module_name'];?> .order_state_2 .top_label .current{ background:#ECECEC;border:1px solid #ECECEC; border-bottom:none;}
	#<?php echo $module['module_name'];?> .order_state_2 .express_div{ display:none;}
	#<?php echo $module['module_name'];?> .order_state_2 .container_div{ display:none;}
	#<?php echo $module['module_name'];?> .order_state_2 .container_div .container_info{ height:8rem; width:90%;}
	.submit_container_div{ text-align:left; padding-left:40%;}
	
	#<?php echo $module['module_name'];?> .pay_method_div{ }
	#<?php echo $module['module_name'];?> .pay_method_div .title{ text-align-last:center; line-height:3rem;}
	#<?php echo $module['module_name'];?> .pay_method_div .pay_method{}
	#<?php echo $module['module_name'];?> .pay_method_div .pay_method a{ display:inline-block; width:18%; margin-left:1%; margin-right:1%; margin-bottom:1rem; border:1px solid #E1E1E1; line-height:3rem; }
	#<?php echo $module['module_name'];?> .pay_method_div .pay_method a:hover{ background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	#<?php echo $module['module_name'];?> .pay_method_div .pay_method .current{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
	
	#<?php echo $module['module_name'];?> .input_div{ line-height:4rem;}
	#<?php echo $module['module_name'];?> .input_div >div{ display:none;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">

		<?php echo $module['html'];?>
        
    </div>

</div>
