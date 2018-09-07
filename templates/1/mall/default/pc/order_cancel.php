<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			if($("#<?php echo $module['module_name'];?> .cancel_reason").val()==''){
				$("#<?php echo $module['module_name'];?> .state").html('<span class=fail><?php echo self::$language['please_select']?></span>');	
				return false;	
			}
			$("#<?php echo $module['module_name'];?> .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			url='<?php echo $module['action_url'];?>&cancel_reason='+$("#<?php echo $module['module_name'];?> .cancel_reason").val();
			$.get(url, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> .state").html(v.info);
				if(v.state=='success'){
					parent.update_cancel_state('<?php echo @$_GET['id'];?>');
					
				}
			});
				
			return false;
		});
    });    
    </script>
	<style>
	.fixed_right_div{ display:none;}
    #<?php echo $module['module_name'];?>{ text-align:center; width:100%; overflow:hidden; margin-top:200px;} 
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <select class=cancel_reason><option value=""><?php echo self::$language['order_cancel'];?></option><?php echo $module['cancel_option'];?></select>
    	<a href="#" class=submit><?php echo self::$language['submit'];?></a> <span class=state></span>
        
    </div>
</div>
