<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$('#new_file_ele').insertBefore($('#replace_state'));
    });
	
	function submit_hidden(input_id){
		$('#new_file_span').css('display','none');	
		$('#new_file_icon').css('display','none');
		
		if(get_param('width')=='' || get_param('height')=='' || get_param('width')=='0' || get_param('height')=='0'){
			$("#replace_state").html('<span class="success" ><?php echo self::$language['success'];?></span>');
			
			parent.update_img_src('<?php echo $_GET['path']?>');
			return false;
			//monxin_alert('no_resize');
				
		}	
		//monxin_alert($("#"+input_id).val());
		$.get('<?php echo $module['action_url'];?>&path=<?php echo @$_GET['path'];?>&name'+$("#"+input_id).val()+'&width=<?php echo @$_GET['width']?>&height=<?php echo @$_GET['height']?>&act=resize',function(data){
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#replace_state").html(v.info);
					
		});	
	}
	
	</script>
    <style>
    #<?php echo $module['module_name'];?>_html{width:500px; height:100px; margin-top:20px; margin-left:20px; text-align:center;}
	input{ border:none;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    <span id=replace_state></span>
    </div>
</div>

