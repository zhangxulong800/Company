<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script src="./plugin/datePicker/index.php"></script>
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .join_goods").val($("#<?php echo $module['module_name'];?> .join_goods").attr('monxin_value'));
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');		
			if($("#<?php echo $module['module_name'];?> #rate").val()==''){$("#<?php echo $module['module_name'];?> #rate").focus().next('span').html('<span class=fail><?php echo self::$language['please_input']?></span>');return false;}
			if($("#<?php echo $module['module_name'];?> #start_time").val()==''){$("#<?php echo $module['module_name'];?> #start_time").focus().next('span').html('<span class=fail><?php echo self::$language['please_input']?></span>');return false;}
			if($("#<?php echo $module['module_name'];?> #end_time").val()==''){$("#<?php echo $module['module_name'];?> #end_time").focus().next('span').html('<span class=fail><?php echo self::$language['please_input']?></span>');return false;}
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			$.post('<?php echo $module['action_url'];?>', {join_goods:$("#<?php echo $module['module_name'];?> .join_goods").val(),rate:$("#<?php echo $module['module_name'];?> #rate").val(),start_time:$("#<?php echo $module['module_name'];?> #start_time").val(),end_time:$("#<?php echo $module['module_name'];?> #end_time").val()},function(data){
				//alert(data);	
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				if(v.id){
					$("#<?php echo $module['module_name'];?> #"+v.id).focus().next('span').html(v.info);
					$("#<?php echo $module['module_name'];?> #submit").next('span').html('<span class=fail><?php echo self::$language['fail'];?></span>');
				}else{
					$("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
				}
				
			});	
		});
	
    });
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .input_line{ line-height:50px;}
    #<?php echo $module['module_name'];?>_html .input_line .m_label{ display:inline-block; vertical-align:top; width:150px; text-align:right; padding-right:10px;}
    #<?php echo $module['module_name'];?>_html .input_line .input_span{ display:inline-block; vertical-align:top; }
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    	<div class=input_line><span class=m_label><?php echo self::$language['join_goods'];?></span><span class=input_span><select class=join_goods monxin_value="<?php echo $module['data']['join_goods']?>"><option value="1"><?php echo self::$language['join_goods_admin'][1]?></option><option value="0"><?php echo self::$language['join_goods_admin'][0]?></option></select> <span class=state></span></span></div>
    	<div class=input_line><span class=m_label><?php echo self::$language['discount_rate'];?></span><span class=input_span><input type="text" id="rate"  name="rate" value="<?php echo $module['data']['rate'];?>"  /> <span class=state></span></span></div>
    	<div class=input_line><span class=m_label><?php echo self::$language['discount_start_time'];?></span><span class=input_span><input type="text" name="start_time" id="start_time" class='start_time' onclick=show_datePicker(this.id,'date_time') onblur= hide_datePicker() value="<?php echo $module['data']['start_time'];?>"  /> <span class=state></span></span></div>
    	<div class=input_line><span class=m_label><?php echo self::$language['discount_end_time'];?></span><span class=input_span><input type="text" name="end_time" id="end_time" class='end_time' onclick=show_datePicker(this.id,'date_time') onblur= hide_datePicker() value="<?php echo $module['data']['end_time'];?>"  /> <span class=state></span></span></div>
    	<div class=input_line><span class=m_label>&nbsp;</span><span class=input_span>
        <a href="#" id=submit class="submit"><?php echo self::$language['submit'];?></a> <span class=state></span>
        </span></div>
    </div>

</div>
