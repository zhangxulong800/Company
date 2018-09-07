<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_html .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			is_null=false;
			obj=new Object();
			obj['real_name']=$("#<?php echo $module['module_name'];?>_html #real_name").val();
			if(obj['real_name']==''){$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=fail><?php echo self::$language['is_null']?></span>');return false;}
			
			$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=submit',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?>_html .submit").next().html(v.info);
				
				if(v.state=='fail'){
					
				}else{
					$("#real_name_div").css('display','none');
					$$("#<?php echo $module['module_name'];?>_html .submit").css('display','none');
				}
				
			});
			return false;	
		});
    });
	
	function submit_hidden(input_id){
		$("#<?php echo $module['module_name'];?> ."+input_id+"_img").attr('src','./temp/'+$("#<?php echo $module['module_name'];?> #"+input_id).val());	
	}
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ }
    #<?php echo $module['module_name'];?>_html{ }
	#<?php echo $module['module_name'];?>_html .line{ line-height:50px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; text-align:right; padding-right:1%; width:29%; }
	#<?php echo $module['module_name'];?>_html .line .input_span{ display:inline-block; vertical-align:top;  width:70%; }
	#<?php echo $module['module_name'];?>_html .line .input_span input{ width:50%;}
	#<?php echo $module['module_name'];?>_html .line .input_span textarea{ width:50%; height:100px;}
	#<?php echo $module['module_name'];?>_html #run_type_div input{ display:inline-block; vertical-align:top; margin-top:1rem;width:20px;}
	#<?php echo $module['module_name'];?>_html #run_type_div m_label{ margin-right:20px;}
	#<?php echo $module['module_name'];?>_html .icon_img{ height:50px;}
	#<?php echo $module['module_name'];?>_html .banner_img{ height:12rem;}
	#<?php echo $module['module_name'];?>_html  #icon_state{ display:block;}
	#<?php echo $module['module_name'];?>_html  #banner_state{ display:block;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
         <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
		</div>
    	<div class=line  id=real_name_div><span class=m_label><?php echo self::$language['real_name'];?></span><span class=input_span><input type="text" id="real_name" name="real_name" value="<?php echo $module['data']['real_name'];?>"  /> <span class=state></span></span></div>
        
        
    	<div class=line><span class=m_label>&nbsp;</span><span class=input_span><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    </div>
</div>

