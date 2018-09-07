<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    	if(get_param('state')=='success'){
			if(get_param('info')==''){
				$("#submit_state").html('<span class=success><?php echo self::$language['success'];?></span>');	
			}else{
				$("#submit_state").html('<span class=success><?php echo self::$language['success'];?></span>,'+decodeURI(get_param('info')));	
			}
			
		}
		if(get_param('state')=='fail'){
			$("#submit_state").html('<span class=fail><?php echo self::$language['fail'];?>,<?php echo self::$language['reason']?>:'+decodeURI(get_param('info'))+'</span>');	
		}
	});
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
		if($("#replace_file").val()==''){}
		$("#submit_state").html('');
	}
	
	function e_submit(){
		$("#monxin_form").submit();	
	}
    </script>
    
    
    
    
    <style>
	body{  background-image: none; }
    #<?php echo $module['module_name'];?>_html{ margin:10px;}
    #<?php echo $module['module_name'];?>_html a{ }
    #<?php echo $module['module_name'];?>_html .name{}
    #<?php echo $module['module_name'];?>_html .size{ display:inline-block; padding-left:100px;}
    #<?php echo $module['module_name'];?>_html .time{ display:inline-block; padding-left:100px;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html>
    
    <form action="<?php echo $module['action_url'];?>" method="POST" enctype="multipart/form-data" name="monxin_form" id="monxin_form" onSubmit="return exe_check();">
    <input type="hidden" id="path" name="path" value="<?php echo $module['path'];?>" />
    <span><?php echo self::$language['current'];?><?php echo self::$language['file'];?></span>
    <hr />
    <?php echo $module['file'];?>
     <hr />
     <?php echo self::$language['replace_to']?>
     <input type="file" name="replace_file" id="replace_file" onchange="e_submit()"  />
     <span id=submit_state></span>
    </form>
    </div>
</div>
