<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
	var  blank_goods_info;
	setInterval('reget_focus(\'bar_code_input\')', 1000); 
    $(document).ready(function(){
		blank_goods_info=$("#<?php echo $module['module_name'];?> .goods_info").html();
		$("#<?php echo $module['module_name'];?> .bar_code").focus();
		
		
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
				console.log(data);
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
						$("#<?php echo $module['module_name'];?> #inventory_div").before('<div class="line option_div"><span class=m_label><?php echo self::$language['option']?></span><span class=m_value><select  id=option_id name=option_id >'+v.option_list+'</select></span></div>');	
						$("#<?php echo $module['module_name'];?> #option_id").prop('value',$("#<?php echo $module['module_name'];?> #option_id option:first").attr('value'));
						
						if($("#<?php echo $module['module_name'];?> #option_id option:first").attr('stocktake')>0){$("#<?php echo $module['module_name'];?> .quantity").val($("#<?php echo $module['module_name'];?> #option_id option:first").attr('stocktake'));}
						$("#<?php echo $module['module_name'];?> .goods_inventory").html('<b>'+$("#<?php echo $module['module_name'];?> #option_id option:first").attr('quantity')+'</b> '+v.unit);
					}else{
						 $("#<?php echo $module['module_name'];?> .goods_inventory").html('<b>'+v.inventory+'</b> '+v.unit);
						if(v.stocktake>0){$("#<?php echo $module['module_name'];?> .quantity").val(v.stocktake);}
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
						//alert(data);
						try{v=eval("("+data+")");}catch(exception){alert(data);}
						$("#<?php echo $module['module_name'];?> .bar_code").next('.state').html(v.info);
						if(v.state=='fail'){
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
							 $("#<?php echo $module['module_name'];?> .unit").remove();
							 $("#<?php echo $module['module_name'];?> .quantity").val('');
							 $("#<?php echo $module['module_name'];?> .quantity").after(' '+'<span class=unit>'+v.unit+'</span>');
							 
							$("#<?php echo $module['module_name'];?> .option_div").remove();
									
							if(v.option_list){
								$("#<?php echo $module['module_name'];?> #inventory_div").before('<div class="line option_div"><span class=m_label><?php echo self::$language['option']?></span><span class=m_value><select  id=option_id name=option_id >'+v.option_list+'</select></span></div>');	
								$("#<?php echo $module['module_name'];?> #option_id").prop('value',$("#<?php echo $module['module_name'];?> #option_id option:first").attr('value'));
								if($("#<?php echo $module['module_name'];?> #option_id option:first").attr('stocktake')>0){$("#<?php echo $module['module_name'];?> .quantity").val($("#<?php echo $module['module_name'];?> #option_id option:first").attr('stocktake'));}
								$("#<?php echo $module['module_name'];?> .goods_inventory").html('<b>'+$("#<?php echo $module['module_name'];?> #option_id option:first").attr('quantity')+'</b> '+v.unit);
							}else{
								
								$("#<?php echo $module['module_name'];?> .goods_inventory").html('<b>'+v.inventory+'</b> '+v.unit);
								if(v.stocktake>0){$("#<?php echo $module['module_name'];?> .quantity").val(v.stocktake);}
								
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
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .reason_switch",function(){
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
		
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .submit",function(){
			exe_stocktake_submit();
			return false;	
		});
		$(document).on('keyup',"#<?php echo $module['module_name'];?> .quantity",function(event){
			keycode=event.which;
			if(keycode==13){exe_stocktake_submit();}
		});
		
		
		$(document).on('change','#<?php echo $module['module_name'];?> #option_id',function(){
			$("#<?php echo $module['module_name'];?> .goods_inventory b").html($("#<?php echo $module['module_name'];?> #option_id option[value='"+$(this).val()+"']").attr('quantity'));				
		});
		
		
    });
    
	function exe_stocktake_submit(){
		if($("#<?php echo $module['module_name'];?> .submit").css('display')=='none'){return false;}
		$("#<?php echo $module['module_name'];?> .state").html('');
		if($("#<?php echo $module['module_name'];?> .quantity").val()=='' ||  !$.isNumeric($("#<?php echo $module['module_name'];?> .quantity").val())){
			$("#<?php echo $module['module_name'];?> .quantity").next('.state').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['quantity']?></span>');
			$("#<?php echo $module['module_name'];?> .quantity").focus();
			return false;	
		}
		if($("#<?php echo $module['module_name'];?> #option_id").val()){$("#<?php echo $module['module_name'];?> .id").prop('value',$("#<?php echo $module['module_name'];?> #option_id").val());}
		//alert($("#<?php echo $module['module_name'];?> .id").val());return false;
		$("#<?php echo $module['module_name'];?> .submit").next(".state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.post('<?php echo $module['action_url'];?>&act=update',{id:$("#<?php echo $module['module_name'];?> .id").val(),quantity:$("#<?php echo $module['module_name'];?> .quantity").val()}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#<?php echo $module['module_name'];?> .submit").next('.state').html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> .id").val('');
				$("#<?php echo $module['module_name'];?> .goods_info").html(blank_goods_info);
				$("#<?php echo $module['module_name'];?> .goods_info").css('display','none');
				$("#<?php echo $module['module_name'];?> .bar_code").val('');
				$("#<?php echo $module['module_name'];?> .bar_code").focus();
				$("#<?php echo $module['module_name'];?> .success_state").html(v.info+' <a href=./index.php?monxin=mall.stocktake_list&stocktake_id=<?php echo $_GET['stocktake_id']?>><?php echo self::$language['view'];?></a>');
				/*				
				$("#<?php echo $module['module_name'];?> .goods_title").html('');
				$("#<?php echo $module['module_name'];?> .goods_icon").attr('src','');
				$("#<?php echo $module['module_name'];?> .goods_inventory").html('');
				$("#<?php echo $module['module_name'];?> .unit").remove();
				$("#<?php echo $module['module_name'];?> .quantity").after('');
				$("#<?php echo $module['module_name'];?> #option_div").remove();
				$("#<?php echo $module['module_name'];?> .quantity").val('');
				$("#<?php echo $module['module_name'];?> .bar_code").val('');
				$("#<?php echo $module['module_name'];?> .bar_code").focus();
				$("#<?php echo $module['module_name'];?> .submit").next('.state').html('');
				$("#<?php echo $module['module_name'];?> .goods_info").css("display",'none');
				$("#<?php echo $module['module_name'];?> .bar_code").next('.state').html(v.info+' <a href=./index.php?monxin=mall.stocktake_list&stocktake_id=<?php echo @$_GET['stocktake_id']?>><?php echo self::$language['return'];?></a>');
				*/
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
	#<?php echo $module['module_name'];?> .success_state{ text-align:center; line-height:50px;}
	#<?php echo $module['module_name'];?> .re_list{ padding-left:30%; line-height:2rem;}
	#<?php echo $module['module_name'];?> .re_list a{ display: block; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?> .re_list a:hover{ font-weight:bold;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    	<input type="hidden" class=id value="<?php echo @$_GET['id']?>" />
            <div class=line><span class=m_label><?php echo self::$language['belong']?><?php echo self::$language['stocktake']?><?php echo self::$language['plan']?>:</span><span class=m_value><?php echo @$module['s_name']?></span></div>
    	<div class=line id=bar_code_div><span class=m_label><?php echo self::$language['barcode']?>/<?php echo self::$language['store_code']?>:</span><span class=m_value><input type="text" class=bar_code  id=bar_code_input /> <span class=state></span> </span></div>
    	<div class=re_list></div>
        <div class=goods_info>
            <div class=line><span class=m_label><?php echo self::$language['name']?>:</span><span class=m_value><span class=goods_title><?php echo @$module['data']['title']?></span></span></div>
            <div class=line><span class=m_label><?php echo self::$language['image']?>:</span><span class=m_value><img src="./program/mall/img_thumb/<?php echo @$module['data']['icon']?>" class=goods_icon /></span></div>
            <div class=line id=inventory_div><span class=m_label><?php echo self::$language['inventory']?><?php echo self::$language['data']?>:</span><span class=m_value><span class=goods_inventory><b><?php echo @$module['data']['inventory']?></b> <?php echo @$module['data']['unit'];?></span></span></div>
            <?php echo @$module['goods_option'];?>
            <div class=line><span class=m_label><?php echo self::$language['stocktake']?><?php echo self::$language['quantity']?>:</span><span class=m_value><input type="text" class=quantity /> <?php echo @$module['data']['unit'];?> <span class=state></span></span></div>
            <div class=line><span class=m_label>&nbsp;</span><span class=m_value><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
        </div>
    	<div class=success_state></div>    
    </div>
</div>
