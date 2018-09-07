<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		
		$("#<?php echo $module['module_name'];?>_html .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			obj=new Object();
			obj['cashier']=$("#<?php echo $module['module_name'];?>_html #cashier").val();
			obj['storekeeper']=$("#<?php echo $module['module_name'];?>_html #storekeeper").val();
			
			$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?>_html .submit").next().html(v.info);
				
				if(v.state=='fail'){
					if(v.key){
						$("#<?php echo $module['module_name'];?>_html #"+v.key).parent().children('.state').html(v.info);
						$("#<?php echo $module['module_name'];?>_html #"+v.key).focus();
						$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=fail><?php echo self::$language['fail']?></span>');
					}
					
				}else{
					//$("#<?php echo $module['module_name'];?>_html").html(v.info).css('text-align','center').css('line-height','100px');
				}
				
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
    
    	<div class=line><span class=m_label><?php echo self::$language['cashier'];?><?php echo self::$language['username'];?>,<?php echo self::$language['multiple']?><?php echo self::$language['separated_by_commas']?></span><span class=input_span><input type="text" id="cashier" name="cashier" value="<?php echo $module['cashier'];?>"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['storekeeper'];?><?php echo self::$language['username'];?>,<?php echo self::$language['multiple']?><?php echo self::$language['separated_by_commas']?></span><span class=input_span><input type="text" id="storekeeper" name="storekeeper" value="<?php echo $module['storekeeper'];?>"  /> <span class=state></span></span></div>
        
        
    	<div class=line><span class=m_label>&nbsp;</span><span class=input_span><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    
    </div>
</div>

