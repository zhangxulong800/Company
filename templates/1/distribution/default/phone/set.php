<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$('#icon_ele').insertBefore($('#icon_state'));
		$('#banner_ele').insertBefore($('#banner_state'));
		$("#<?php echo $module['module_name'];?> #template").val($("#<?php echo $module['module_name'];?> #template").attr('monxin_value'));
		
		$("#<?php echo $module['module_name'];?>_html .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			is_null=false;
			obj=new Object();
			$("#<?php echo $module['module_name'];?>_html input").each(function(index, element) {
				if($(this).attr('id')!='icon_file' && $(this).attr('id')!='banner_file'){
					if($(this).prop('value')==''){
						if($(this).attr('id')=='icon' || $(this).attr('id')=='banner'){
							//$(this).parent().parent().children('.state').html('<span class=fail><?php echo self::$language['is_null']?></span>');
						}else{
							$(this).parent().children('.state').html('<span class=fail><?php echo self::$language['is_null']?></span>');
							$(this).focus();
							//alert($(this).attr('id'));
							is_null=true; return false;	
						}
					}
					
					obj[$(this).attr('id')]=$(this).val();
				}
            });
			if(is_null){return false;}
			obj['name']=$("#<?php echo $module['module_name'];?>_html #name").val();
			obj['template']=$("#<?php echo $module['module_name'];?>_html #template").val();
			$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?>_html .submit").next().html(v.info);
				
				if(v.state=='fail'){
					if(v.key){
						if(v.key=='certificate' || v.key=='self_certificate'){
							$("#<?php echo $module['module_name'];?>_html #"+v.key).parent().parent().children('.state').html(v.info);
						}else{
							$("#<?php echo $module['module_name'];?>_html #"+v.key).parent().children('.state').html(v.info);
						}
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
	
	function submit_hidden(input_id){
		$("#<?php echo $module['module_name'];?> ."+input_id+"_img").attr('src','./temp/'+$("#<?php echo $module['module_name'];?> #"+input_id).val());	
	}
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ }
    #<?php echo $module['module_name'];?>_html{ }
	#<?php echo $module['module_name'];?>_html .line{ line-height:50px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; text-align:right; padding-right:1%; width:17%; }
	#<?php echo $module['module_name'];?>_html .line .input_span{ display:inline-block; vertical-align:top;  width:81%; }
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
    	<div class=line><span class=m_label><?php echo self::$language['shop_name'];?></span><span class=input_span><input type="text" id="name" name="name" value="<?php echo $module['name'];?>"  /> <span class=state></span></span></div>
        

    	<div class=line><span class=m_label><?php echo self::$language['shop_icon'];?></span><span class=input_span> <span class=state id=icon_state></span><a href="./program/mall/shop_icon/<?php echo $module['id']?>.png"  target="_blank"><img src="./program/distribution/shop_icon/<?php echo $module['icon']?>" class=icon_img /></a></span></div>
        
		<hr />
        
    	<div class=line><span class=m_label><?php echo self::$language['shop_banner'];?></span><span class=input_span> <span class=state id=banner_state></span><a href="./program/mall/shop_icon/<?php echo $module['id']?>.png"  target="_blank"><img src="./program/distribution/banner/<?php echo $module['banner']?>" class=banner_img /></a></span></div>


    	<div class=line><span class=m_label><?php echo self::$language['shop_style'];?></span><span class=input_span><select id=template name=template monxin_value="<?php echo $module['template']?>"><?php echo $module['template_option']?></select> <span class=state></span></span></div>
        
        
        
    	<div class=line><span class=m_label>&nbsp;</span><span class=input_span><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    </div>
</div>

