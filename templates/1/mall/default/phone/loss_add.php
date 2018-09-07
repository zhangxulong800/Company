<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
	
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .bar_code").focus();
		if(get_param('id')!=''){
			$("#<?php echo $module['module_name'];?> .goods_info").css('display','block');
			$("#<?php echo $module['module_name'];?> .quantity").focus();
			$("#<?php echo $module['module_name'];?> #bar_code_div").css('display','none');
		}
		
		$("#<?php echo $module['module_name'];?> #option_id").change(function(){
			if($(this).val()!=''){
				$("#<?php echo $module['module_name'];?> .price").val($("#<?php echo $module['module_name'];?> #option_id option[value="+$(this).val()+"]").attr('value'));
				$("#<?php echo $module['module_name'];?>  .goods_inventory b").html($("#<?php echo $module['module_name'];?> #option_id option[value="+$(this).val()+"]").attr('quantity'));
			}else{
				$("#<?php echo $module['module_name'];?>  .goods_inventory b").html(<?php echo @$module['data']['inventory']?>);
			}	
		});
		
		$("#<?php echo $module['module_name'];?> .bar_code").keyup(function(event){
			keycode=event.which;
			if(keycode==13){
				if($(this).val()!='' &&  $.isNumeric($(this).val())){
					$("#<?php echo $module['module_name'];?> .bar_code").next(".state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
					$.post('<?php echo $module['action_url'];?>&act=inquiry',{bar_code:$("#<?php echo $module['module_name'];?> .bar_code").val()}, function(data){
						//alert(data);
						try{v=eval("("+data+")");}catch(exception){alert(data);}
						
						$("#<?php echo $module['module_name'];?> .bar_code").next('.state').html(v.info);
						if(v.state=='success'){
							$("#<?php echo $module['module_name'];?> .id").val(v.id);
							 $("#<?php echo $module['module_name'];?> .goods_title").html(v.title);
							 $("#<?php echo $module['module_name'];?> .goods_icon").attr('src','./program/mall/img_thumb/'+v.icon);
							 $("#<?php echo $module['module_name'];?> .goods_inventory").html('<b>'+v.inventory+'</b> '+v.unit);
							 $("#<?php echo $module['module_name'];?> .goods_info").css('display','block');
							if($("#<?php echo $module['module_name'];?> .quantity").next('.q_unit').html()){
							 $("#<?php echo $module['module_name'];?> .quantity").next('.q_unit').html(' <span class=q_unit>'+v.unit+'</span>');
							}else{
							 $("#<?php echo $module['module_name'];?> .quantity").after(' <span class=q_unit>'+v.unit+'</span>'); 
							}
							 $("#<?php echo $module['module_name'];?> .supplier").val(v.supplier);
							 $("#<?php echo $module['module_name'];?> .reason_select").html(v.loss_reason_option);
							 if(v.loss_reason_option!=''){
								$("#<?php echo $module['module_name'];?> .reason_text").css('display','none');	
								$("#<?php echo $module['module_name'];?> .reason_select").css('display','inline-block');	
								$("#<?php echo $module['module_name'];?> .reason_text").val($("#<?php echo $module['module_name'];?> .reason_select").val());
							}
							$("#<?php echo $module['module_name'];?> #option_div").remove();
							 if(v.option_id){
								
								$("#<?php echo $module['module_name'];?> #supplier_div").before('<div class=line id=option_div><span class=m_label><?php echo self::$language['option']?></span><span class=m_value><select  id=option_id name=option_id value='+v.option_id+'><option value='+v.option_id+'>'+v.option_name+'</option></select></span></div>');	 
							}
							
							$("#<?php echo $module['module_name'];?> .quantity").focus();
						}
					});
				}
			}
		});
		
		$("#<?php echo $module['module_name'];?> .supplier").val($("#<?php echo $module['module_name'];?> .supplier").attr('monxin_value'));
		if($("#<?php echo $module['module_name'];?> .reason_select").val()==null){
			$("#<?php echo $module['module_name'];?> .reason_select").css('display','none');	
			$("#<?php echo $module['module_name'];?> .reason_text").css('display','inline-block');
		}else{
			$("#<?php echo $module['module_name'];?> .reason_text").val($("#<?php echo $module['module_name'];?> .reason_select").val());	
		}
		
		$("#<?php echo $module['module_name'];?> .reason_switch").click(function(){
			if($("#<?php echo $module['module_name'];?> .reason_text").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .reason_select").css('display','none');	
				$("#<?php echo $module['module_name'];?> .reason_text").css('display','inline-block');	
			}else{
				$("#<?php echo $module['module_name'];?> .reason_text").css('display','none');	
				$("#<?php echo $module['module_name'];?> .reason_select").css('display','inline-block');	
			}
			return false;	
		});
		
		$(document).on('change',"#<?php echo $module['module_name'];?> .reason_select",function(){
			if($(this).val()==0){
				$("#<?php echo $module['module_name'];?> .reason_select").css('display','none');	
				$("#<?php echo $module['module_name'];?> .reason_text").css('display','inline-block');
				$("#<?php echo $module['module_name'];?> .reason_text").val('');
			}else{
				$("#<?php echo $module['module_name'];?> .reason_text").val($(this).val());	
			}
			
		});
		
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			exe_purchase_add();
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .quantity").keyup(function(event){
			keycode=event.which;
			if(keycode==13){exe_purchase_add();}
		});
		
		
		
		
    });
    
	function exe_purchase_add(){
		if($("#<?php echo $module['module_name'];?> .submit").css('display')=='none'){return false;}
		$("#<?php echo $module['module_name'];?> .state").html('');
		if($("#<?php echo $module['module_name'];?> #option_id")){
			if($("#<?php echo $module['module_name'];?> #option_id").val()==''){
				$("#<?php echo $module['module_name'];?> #option_id").parent().children('.state').html('<span class=fail><?php echo self::$language['please_select']?></span>');
				
				return false;	
			}
		}
		
		if($("#<?php echo $module['module_name'];?> .reason_text").val()==''){
			$("#<?php echo $module['module_name'];?> .reason_text").parent().children('.state').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['reason']?></span>');
			
			return false;	
		}
		if($("#<?php echo $module['module_name'];?> .quantity").val()=='' ||  !$.isNumeric($("#<?php echo $module['module_name'];?> .quantity").val())){
			$("#<?php echo $module['module_name'];?> .quantity").next('.state').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['quantity']?></span>');
			$("#<?php echo $module['module_name'];?> .quantity").focus();
			return false;	
		}
		
		$("#<?php echo $module['module_name'];?> .submit").next(".state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.post('<?php echo $module['action_url'];?>&act=add',{id:$("#<?php echo $module['module_name'];?> .id").val(),option_id:$("#<?php echo $module['module_name'];?> #option_id").val(),supplier:$("#<?php echo $module['module_name'];?> .supplier").val(),quantity:$("#<?php echo $module['module_name'];?> .quantity").val(),reason:$("#<?php echo $module['module_name'];?> .reason_text").val()}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#<?php echo $module['module_name'];?> .submit").next('.state').html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> .submit").css("display",'none');
				$("#<?php echo $module['module_name'];?> .submit").next('.state').html(v.info+' <a href=./index.php?monxin=mall.loss><?php echo self::$language['view'];?></a>');
			}
		});
	}
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .line{ line-height:3rem;}
    #<?php echo $module['module_name'];?> .line .m_label{ display:inline-block; vertical-align:top; width:29%; text-align:right; margin-right:1%;}
    #<?php echo $module['module_name'];?> .line .m_value{ display:inline-block; vertical-align:top; width:70%;}
    #<?php echo $module['module_name'];?> .goods_icon{ height:100px; border:0.3rem #FFFFFF solid;}
	#<?php echo $module['module_name'];?> .goods_info{ display:none;}
	#<?php echo $module['module_name'];?> .or_link_into:hover{  }
	#<?php echo $module['module_name'];?> .reason_switch{}
	#<?php echo $module['module_name'];?> .reason_switch:hover{ }
	#<?php echo $module['module_name'];?> .reason_switch:before {font: normal normal normal 1rem/1 FontAwesome;margin-right: 5px;content:"\f0ec";}
	#<?php echo $module['module_name'];?> .reason_text{display:none;}
	#<?php echo $module['module_name'];?> .reason_select{}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    	<input type="hidden" class=id value="<?php echo @$_GET['id']?>" />
    	<div class=line id=bar_code_div><span class=m_label><?php echo self::$language['bar_code']?>:</span><span class=m_value><input type="text" class=bar_code  /> <span class=state></span> <a href=./index.php?monxin=mall.stock class=or_link_into><?php echo self::$language['or_link_into']?></a></span></div>
    	<div class=goods_info>
            <div class=line><span class=m_label><?php echo self::$language['name']?>:</span><span class=m_value><span class=goods_title><?php echo @$module['data']['title']?></span></div>
            <div class=line><span class=m_label><?php echo self::$language['image']?>:</span><span class=m_value><img src="./program/mall/img_thumb/<?php echo @$module['data']['icon']?>" class=goods_icon /></div>
            <div class=line><span class=m_label><?php echo self::$language['existing']?><?php echo self::$language['inventory']?>:</span><span class=m_value><span class=goods_inventory><b><?php echo @$module['data']['inventory']?></b> <?php echo @$module['data']['unit'];?></span></div>
            <?php echo @$module['goods_option'];?>
            <div class=line id=supplier_div><span class=m_label><?php echo self::$language['goods_supplier']?>:</span><span class=m_value><?php echo @$module['data']['supplier']?> <span class=state></span></span></div>
            <div class=line><span class=m_label><?php echo self::$language['loss']?><?php echo self::$language['reason']?>:</span><span class=m_value><input type="text" class=reason_text  /><select class=reason_select><?php echo $module['loss_reason_option']?></select> <a href=# class=reason_switch></a> <span class=state></span></span></div>
            <div class=line><span class=m_label><?php echo self::$language['loss']?><?php echo self::$language['quantity']?>:</span><span class=m_value><input type="text" class=quantity /> <?php echo @$module['data']['unit'];?> <span class=state></span></span></div>
            <div class=line><span class=m_label>&nbsp;</span><span class=m_value><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
        </div>
    </div>
</div>
