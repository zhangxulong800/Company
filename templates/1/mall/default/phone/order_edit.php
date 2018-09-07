<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
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
					parent.update_express_code(<?php echo @$_GET['id']?>,v.express_code);
					parent.update_action_button_2(<?php echo @$_GET['id']?>);			
				}
            });
			return false;	
		});
    });
    
    </script>
    <style>
	.fixed_right_div,.page-footer,#mall_cart{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
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
	
    </style>
	<div id="<?php echo $module['module_name'];?>_html">

		<?php echo $module['html'];?>
        
    </div>

</div>
