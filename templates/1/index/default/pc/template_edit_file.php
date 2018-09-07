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
         $("#<?php echo $module['module_name'];?> #submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
   }
        
    
    </script>
    
    
    
    
    <style>
	body{  background-image: none; }
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?> #title{ width:150px;}
    #<?php echo $module['module_name'];?> #width{ width:50px;}
    #<?php echo $module['module_name'];?> #height{ width:50px;}
    #<?php echo $module['module_name'];?> #content{ padding:10px; width:100%; height:500px;}
    #<?php echo $module['module_name'];?> #save_path{width:300px;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html>
    
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    <input type="hidden" id="old_path" name="old_path" value="<?php echo $module['path'];?>" />
    <textarea name="content" id="content"><?php echo $module['content']?></textarea>
    <div><span><?php echo self::$language['file_name'];?></span><input id="save_path" name="save_path" type="text" value="<?php echo $module['path'];?>" /> <input type="submit" name="submit" id="submit" value="<?php echo self::$language['save']?>" /><span id=submit_state></span></div>
    </form>
    </div>
</div>

