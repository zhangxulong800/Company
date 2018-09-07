<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		
		$("#<?php echo $module['module_name'];?>_html .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			obj=new Object();
			is_null=false;
			$("#<?php echo $module['module_name'];?> input").each(function(index, element) {
                if($(this).val()==''){
					$(this).next('.state').html('<span class=fail><?php echo self::$language['please_input']?></span>');
					$(this).focus();
					is_null=true;
					return false;	
				}
				obj[$(this).attr('id')]=$(this).val();
				
            });
			if(is_null){return false;}
			
			$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update',obj, function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?>_html .submit").next().html(v.info);
			});
			return false;	
		});
    });
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ }
    #<?php echo $module['module_name'];?>_html{ }
	#<?php echo $module['module_name'];?>_html .line{ line-height:50px;}
	#<?php echo $module['module_name'];?>_html .line a img{ height:100px; border:none;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; text-align:right; padding-right:1%; width:29%; }
	#<?php echo $module['module_name'];?>_html .line .input_span{ display:inline-block; vertical-align:top;  width:70%; }
	#<?php echo $module['module_name'];?>_html .line .input_span input{ width:50%;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
       
    </div>
    
    	<div class=line><span class=m_label><?php echo self::$language['express_layout']['shipper_name'];?></span><span class=input_span><input type="text" id="shipper_name" name="shipper_name" value="<?php echo $module['shipper_name'];?>"  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['express_layout']['shipper_tel'];?></span><span class=input_span><input type="text" id="shipper_tel" name="shipper_tel" value="<?php echo $module['shipper_tel'];?>"  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['express_layout']['shipper_phone'];?></span><span class=input_span><input type="text" id="shipper_phone" name="shipper_phone" value="<?php echo $module['shipper_phone'];?>"  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['express_layout']['shipper_company'];?></span><span class=input_span><input type="text" id="shipper_company" name="shipper_company" value="<?php echo $module['shipper_company'];?>"  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['express_layout']['shipper_address'];?></span><span class=input_span><input type="text" id="shipper_address" name="shipper_address" value="<?php echo $module['shipper_address'];?>"  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['express_layout']['shipper_city'];?></span><span class=input_span><input type="text" id="shipper_city" name="shipper_city" value="<?php echo $module['shipper_city'];?>"  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['express_layout']['shipper_postcode'];?></span><span class=input_span><input type="text" id="shipper_postcode" name="shipper_postcode" value="<?php echo $module['shipper_postcode'];?>"  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['express_layout']['shipper_signature'];?></span><span class=input_span><input type="text" id="shipper_signature" name="shipper_signature" value="<?php echo $module['shipper_signature'];?>"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label>&nbsp;</span><span class=input_span><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    
    </div>
</div>

