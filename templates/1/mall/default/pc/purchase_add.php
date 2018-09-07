<div id=<?php echo $module['module_name'];?>  class="portlet light"  monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
	var  blank_goods_info;
	setInterval('reget_focus(\'bar_code_input\')', 1000); 
    $(document).ready(function(){
		
		$("#<?php echo $module['module_name'];?> .switch_input").click(function(){
			if($("#<?php echo $module['module_name'];?> .purchase_name").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .purchase_name").css('display','inline-block');	
				$("#<?php echo $module['module_name'];?> .purchase_option").css('display','none');	
			}else{
				$("#<?php echo $module['module_name'];?> .purchase_name").css('display','none');	
				$("#<?php echo $module['module_name'];?> .purchase_option").css('display','inline-block');	
			}			
			return false;	
		});
		
		blank_goods_info=$("#<?php echo $module['module_name'];?> .goods_info").html();
		$("#<?php echo $module['module_name'];?> .bar_code").focus();
		if(get_param('id')!=''){
			$("#<?php echo $module['module_name'];?> .goods_info").css('display','block');
			$("#<?php echo $module['module_name'];?> .quantity").focus();
			$("#<?php echo $module['module_name'];?> #bar_code_div").css('display','none');
		}
		
		$("#<?php echo $module['module_name'];?> .quantity").keyup(function() {
            $("#<?php echo $module['module_name'];?> .payment").val($(this).val());
        });
		
		$("#<?php echo $module['module_name'];?> #option_id").change(function(){
			if($(this).val()!=''){
				$("#<?php echo $module['module_name'];?> .price").val($("#<?php echo $module['module_name'];?> #option_id option[value="+$(this).val()+"]").attr('value'));	
			}	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> .re_list a',function(){
			$("#<?php echo $module['module_name'];?> .id").val($(this).attr('href'));
			$("#<?php echo $module['module_name'];?> .re_list").html('');
			$("#<?php echo $module['module_name'];?> .bar_code").next(".state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=inquiry_id',{id:$(this).attr('href')}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .bar_code").next('.state').html(v.info);
				if(v.state=='fail'){
					$("#<?php echo $module['module_name'];?> .bar_code").val('');
					$("#<?php echo $module['module_name'];?> .bar_code").focus();
					$("#<?php echo $module['module_name'];?> .goods_info").css('display','none');
				}
				if(v.state=='success'){					
					$("#<?php echo $module['module_name'];?> .id").val(v.id);
					 $("#<?php echo $module['module_name'];?> .goods_title").html(v.title);
					 $("#<?php echo $module['module_name'];?> .goods_icon").attr('src','./program/mall/img_thumb/'+v.icon);
					 
					 $("#<?php echo $module['module_name'];?> .goods_info").css('display','block');
					 $("#<?php echo $module['module_name'];?> .quantity").after(' '+v.unit);
					 $("#<?php echo $module['module_name'];?> .supplier").val(v.supplier);
					 $("#<?php echo $module['module_name'];?> .price").val(v.cost_price);
					 $("#<?php echo $module['module_name'];?> .option_div").remove();	
					if(v.option_list){
						$("#<?php echo $module['module_name'];?> #supplier_div").before('<div class="line option_div"><span class=m_label><?php echo self::$language['option']?></span><span class=m_value><select  id=option_id name=option_id >'+v.option_list+'</select></span></div>');	
						$("#<?php echo $module['module_name'];?> #option_id").prop('value',$("#<?php echo $module['module_name'];?> #option_id option:first").attr('value'));
						$("#<?php echo $module['module_name'];?> .goods_inventory").html('<b>'+$("#<?php echo $module['module_name'];?> #option_id option:first").attr('quantity')+'</b> '+v.unit);
					}else{
						$("#<?php echo $module['module_name'];?> .goods_inventory").html('<b>'+v.inventory+'</b> '+v.unit);
						
					}
			
					
					
					
					$("#<?php echo $module['module_name'];?> .quantity").focus();
					return false;
				}
			});
			return false;	
		})
		
		$("#<?php echo $module['module_name'];?> .bar_code").keyup(function(event){
			keycode=event.which;
			if(keycode==13){
				if($(this).val()!=''){
					$("#<?php echo $module['module_name'];?> .bar_code").next(".state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
					$.post('<?php echo $module['action_url'];?>&act=inquiry',{bar_code:$("#<?php echo $module['module_name'];?> .bar_code").val()}, function(data){
						console.log(data);
						//alert(data);
						try{v=eval("("+data+")");}catch(exception){alert(data);}
						
						$("#<?php echo $module['module_name'];?> .bar_code").next('.state').html(v.info);
						if(v.state=='fail'){
							$("#<?php echo $module['module_name'];?> .re_list").html('');
							$("#<?php echo $module['module_name'];?> .bar_code").val('');
							$("#<?php echo $module['module_name'];?> .bar_code").focus();
							$("#<?php echo $module['module_name'];?> .goods_info").css('display','none');
						}
						if(v.state=='success'){
							if(v.list){
								$("#<?php echo $module['module_name'];?> .re_list").html(v.list);
								$("#<?php echo $module['module_name'];?> .goods_info").html(blank_goods_info);
								$("#<?php echo $module['module_name'];?> .goods_info").css('display','none');
								return ;
							}
							
							$("#<?php echo $module['module_name'];?> .id").val(v.id);
							 $("#<?php echo $module['module_name'];?> .goods_title").html(v.title);
							 $("#<?php echo $module['module_name'];?> .goods_icon").attr('src','./program/mall/img_thumb/'+v.icon);
							 $("#<?php echo $module['module_name'];?> .goods_info").css('display','block');
							 if($("#<?php echo $module['module_name'];?> .quantity").next('.q_unit').html()){
								 $("#<?php echo $module['module_name'];?> .quantity").next('.q_unit').html(' <span class=q_unit>'+v.unit+'</span>');
							 }else{
								 $("#<?php echo $module['module_name'];?> .quantity").after(' <span class=q_unit>'+v.unit+'</span>'); 
							 }
							
							 $("#<?php echo $module['module_name'];?> .supplier").val(v.supplier);
							 
							 
							 $("#<?php echo $module['module_name'];?> .option_div").remove();
							if(v.option_list){
								$("#<?php echo $module['module_name'];?> #supplier_div").before('<div class="line option_div"><span class=m_label><?php echo self::$language['option']?></span><span class=m_value><select  id=option_id name=option_id >'+v.option_list+'</select></span></div>');	
								$("#<?php echo $module['module_name'];?> #option_id").prop('value',$("#<?php echo $module['module_name'];?> #option_id option:first").attr('value'));
								$("#<?php echo $module['module_name'];?> .goods_inventory").html('<b>'+$("#<?php echo $module['module_name'];?> #option_id option:first").attr('quantity')+'</b> '+v.unit);
								$("#<?php echo $module['module_name'];?> .price").val($("#<?php echo $module['module_name'];?> #option_id option:first").attr('cost_price'));
							}else{
								$("#<?php echo $module['module_name'];?> .price").val(v.cost_price);
								$("#<?php echo $module['module_name'];?> .goods_inventory").html('<b>'+v.inventory+'</b> '+v.unit);
								
							}
							
							$("#<?php echo $module['module_name'];?> .quantity").focus();
						}
					});
				}
			}
		});
		
		$("#<?php echo $module['module_name'];?> .supplier").val($("#<?php echo $module['module_name'];?> .supplier").attr('monxin_value'));
		$("#<?php echo $module['module_name'];?> .supplier").val($("#<?php echo $module['module_name'];?> .supplier").attr('monxin_value'));
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .submit",function(){
			exe_purchase_add();
			return false;	
		});
		$(document).on('keyup',"#<?php echo $module['module_name'];?> .quantity",function(event){
			keycode=event.which;
			if(keycode==13){exe_purchase_add();}
		});
		
		$(document).on('change','#<?php echo $module['module_name'];?> #option_id',function(){
			$("#<?php echo $module['module_name'];?> .goods_inventory b").html($("#<?php echo $module['module_name'];?> #option_id option[value='"+$(this).val()+"']").attr('quantity'));
			$("#<?php echo $module['module_name'];?> .price").val($("#<?php echo $module['module_name'];?> #option_id option[value='"+$(this).val()+"']").attr('cost_price'));
				
		});
    });
    
	function exe_purchase_add(){
		if($("#<?php echo $module['module_name'];?> .submit").css('display')=='none'){return false;}
		$("#<?php echo $module['module_name'];?> .state").html('');
		if($("#<?php echo $module['module_name'];?> .quantity").val()=='' ||  !$.isNumeric($("#<?php echo $module['module_name'];?> .quantity").val())){
			$("#<?php echo $module['module_name'];?> .quantity").next('.state').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['quantity']?></span>');
			$("#<?php echo $module['module_name'];?> .quantity").focus();
			return false;	
		}
		//alert($("#<?php echo $module['module_name'];?> .id").val());
		if($("#<?php echo $module['module_name'];?> .purchase_name").css('display')!='none'){
			purchase_name=$("#<?php echo $module['module_name'];?> .purchase_name").val();
			if($("#<?php echo $module['module_name'];?> .purchase_name").val()==''){
				$("#<?php echo $module['module_name'];?> .purchase_name_div .state").html('<span class=fail><?php echo self::$language['is_null']?></span>');
				$("#<?php echo $module['module_name'];?> .purchase_name").focus();
				return false;
			}
			
		}else{
			purchase_name=$("#<?php echo $module['module_name'];?> .purchase_option").val();
		}
		
		$("#<?php echo $module['module_name'];?> .submit").next(".state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.post('<?php echo $module['action_url'];?>&act=add',{id:$("#<?php echo $module['module_name'];?> .id").val(),option_id:$("#<?php echo $module['module_name'];?> #option_id").val(),supplier:$("#<?php echo $module['module_name'];?> .supplier").val(),quantity:$("#<?php echo $module['module_name'];?> .quantity").val(),price:$("#<?php echo $module['module_name'];?> .price").val(),production_date:$("#<?php echo $module['module_name'];?> .production_date").val(),shelf_life:$("#<?php echo $module['module_name'];?> .shelf_life").val(),payment:$("#<?php echo $module['module_name'];?> .payment").val(),remark:$("#<?php echo $module['module_name'];?> .remark").val(),storehouse:$("#<?php echo $module['module_name'];?> .storehouse").val(),purchase_name:purchase_name}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#<?php echo $module['module_name'];?> .submit").next('.state').html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> .goods_info").html(blank_goods_info);
				$("#<?php echo $module['module_name'];?> .goods_info").css('display','none');
				$("#<?php echo $module['module_name'];?> .bar_code").val('');
				$("#<?php echo $module['module_name'];?> .bar_code").focus();
				//$("#<?php echo $module['module_name'];?> .submit").css("display",'none');
				$("#<?php echo $module['module_name'];?> .success_state").html(v.info+' <a href=./index.php?monxin=mall.purchase><?php echo self::$language['view'];?></a>');
			}
		});
	}
	
	
	function reget_focus(id){
		if($("#<?php echo $module['module_name'];?> .goods_info").css('display')=='none'){
			$("#"+id).focus();	
		}
	}
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>{ padding:0px; padding-bottom:2rem;}
    #<?php echo $module['module_name'];?> .line{ line-height:2.2rem;}
    #<?php echo $module['module_name'];?> .line .m_label{ display:inline-block; vertical-align:top; width:29%; text-align:right; margin-right:1%;}
    #<?php echo $module['module_name'];?> .line .m_value{ display:inline-block; vertical-align:top; width:70%;}
    #<?php echo $module['module_name'];?> .goods_icon{ height:60px; border:0.3rem #FFFFFF solid;}
	#<?php echo $module['module_name'];?> .goods_info{ display:none;}
	#<?php echo $module['module_name'];?> .or_link_into:hover{  }
	#<?php echo $module['module_name'];?> .success_state{ text-align:center; line-height:50px;}
	#<?php echo $module['module_name'];?> .re_list{ padding-left:30%; line-height:2rem;}
	#<?php echo $module['module_name'];?> .re_list a{ display: block; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?> .re_list a:hover{ font-weight:bold;}
	#<?php echo $module['module_name'];?> .purchase_name{ display:none;}
	#<?php echo $module['module_name'];?> .switch_input:hover{ opacity:0.7;}
	#<?php echo $module['module_name'];?> .switch_input:before{
		font: normal normal normal 18px/1 FontAwesome;
		content: "\f103";
		
	}
    </style>
    
    
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    	<input type="hidden" class=id value="<?php echo @$_GET['id']?>" />
    	<div class=line id=bar_code_div><span class=m_label><?php echo self::$language['bar_code']?>/<?php echo self::$language['store_code']?>:</span><span class=m_value><input type="text" class=bar_code id=bar_code_input /> <span class=state></span> <a href=./index.php?monxin=mall.stock class=or_link_into><?php echo self::$language['or_link_into']?></a></span></div>
        <div class=re_list></div>
    	<div class=goods_info>
            <div class=line><span class=m_label><?php echo self::$language['name']?>:</span><span class=m_value><span class=goods_title><?php echo @$module['data']['title']?></span></span></div>
            <div class=line><span class=m_label><?php echo self::$language['image']?>:</span><span class=m_value><img src="./program/mall/img_thumb/<?php echo @$module['data']['icon']?>" class=goods_icon /></span></div>
            <div class=line><span class=m_label><?php echo self::$language['existing']?><?php echo self::$language['inventory']?>:</span><span class=m_value><span class=goods_inventory><b><?php echo @$module['data']['inventory']?></b> <?php echo @$module['data']['unit'];?></span></span></div>
            <?php echo @$module['goods_option'];?>
            <div class=line id=supplier_div><span class=m_label><?php echo self::$language['goods_supplier']?>:</span><span class=m_value><?php echo @$module['data']['supplier']?> <span class=state></span></span></div>
            <div class=line><span class=m_label><?php echo self::$language['cost_price']?>:</span><span class=m_value><input type="text" class=price  value="<?php echo @$module['data']['cost_price'];?>" /> <span class=state></span></span></div>
            <div class=line><span class=m_label><?php echo self::$language['production_date']?>:</span><span class=m_value><input type="text" class=production_date id="production_date" name="production_date" value="" onclick="show_datePicker(this.id,'date')" onblur="hide_datePicker()" placeholder="<?php echo self::$language['optional']?>" /> <span class=state></span></span></div>
            <div class=line><span class=m_label><?php echo self::$language['shelf_life2']?>:</span><span class=m_value><input type="text"  placeholder="<?php echo self::$language['optional']?>" class=shelf_life /> <?php echo self::$language['d2'];?> <span class=state></span></span></div>
            <div class=line><span class=m_label><?php echo self::$language['increase']?><?php echo self::$language['inventory']?>:</span><span class=m_value><input type="text" class=quantity /> <?php echo @$module['data']['unit'];?> <span class=state></span></span></div>
            <div class=line><span class=m_label><?php echo self::$language['money_settled']?>:</span><span class=m_value><input type="text" class=payment /> <?php echo @$module['data']['unit'];?><span class=state></span></span></div>
            <div class=line><span class=m_label><?php echo self::$language['remark']?>:</span><span class=m_value><input type="text" class=remark /> <span class=state></span></span></div>
            <div class='line purchase_name_div'><span class=m_label><?php echo self::$language['purchase_name']?>:</span><span class=m_value><input type="text" class=purchase_name /><select class=purchase_option><?php echo $module['purchase_option']?></select> <a class=switch_input></a><span class=state></span></span></div>
            
            <div class=line><span class=m_label><?php echo self::$language['storehouse']?>:</span><span class=m_value><select class="storehouse" id="storehouse" name="storehouse" ><option value="0">&nbsp;</option><?php echo $module['storehouse'];?></select> <span class=state></span></span></div>
            
            
            <div class=line><span class=m_label>&nbsp;</span><span class=m_value><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
        </div>
        <div class=success_state></div>
    </div>
</div>
