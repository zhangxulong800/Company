	<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .pay_time_limit").blur(function(){
			$("#<?php echo $module['module_name'];?> .pay_time_limit_state").html('');
			if($(this).prop('value')==''){$("#<?php echo $module['module_name'];?> .pay_time_limit_state").html('<span class=fail><?php echo self::$language['please_input']?></span>');$("#<?php echo $module['module_name'];?> .pay_time_limit").focus();return false;}	
			
			$("#<?php echo $module['module_name'];?> .pay_time_limit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=pay_time_limit',{pay_time_limit:$(this).prop('value')}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
	
				$("#<?php echo $module['module_name'];?> .pay_time_limit_state").html(v.info);
			});
		});
		$("#<?php echo $module['module_name'];?> #cash_on_delivery_remark .submit").click(function(){
			$(this).next().html('');
			if($("#<?php echo $module['module_name'];?> .cash_on_delivery").val()==''){$(this).next().html('<span class=fail><?php echo self::$language['is_null']?></span>');$("#<?php echo $module['module_name'];?> .cash_on_delivery").focus();return false;}	
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=cash_on_delivery',{cash_on_delivery:$("#<?php echo $module['module_name'];?> .cash_on_delivery").val()}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
	
				$("#<?php echo $module['module_name'];?> #cash_on_delivery_remark .submit").next().html(v.info);
			});
			return false;	
		});
    });
    
    
    function update(id){
		if($("#<?php echo $module['module_name'];?> #visible_"+id).prop('checked')){visible=1;}else{visible=0;}
        var sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{visible:visible,sequence:sequence.prop('value'),id:id}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        	
       return false; 
    }
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html .name{width:200px;}
    #<?php echo $module['module_name'];?>_html .sequence{width:50px;}
	#<?php echo $module['module_name'];?>_html .pay_time_limit_div{ line-height:100px;}
	#<?php echo $module['module_name'];?>_html .cash_on_delivery{width:95%; height:120px;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
   	    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['open']?></td>
                <td><?php echo self::$language['sequence']?></td>
                <td width="30%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    
    <div class=pay_time_limit_div><?php echo self::$language['pay_time_limit']?>:<input type="text" class="pay_time_limit"  value="<?php echo $module['pay_time_limit']?>" /><?php echo self::$language['pay_time_limit_post_fix']?>  <span class=pay_time_limit_state></span></div>
    
    <div id=cash_on_delivery_remark>
    	<?php echo self::$language['pay_method']['cash_on_delivery']?> <?php echo self::$language['remark']?><br />
        <textarea class=cash_on_delivery><?php echo $module['cash_on_delivery'];?></textarea>
        <br />
        <a href="#" class=submit><?php echo self::$language['submit'];?></a>  <span class=state></span>
    </div>
    </div>

</div>
