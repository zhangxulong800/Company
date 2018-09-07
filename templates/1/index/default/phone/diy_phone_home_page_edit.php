<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language'];?>"></script>
    <script>
    $(document).ready(function(){
    
	});
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
		//monxin_alert('xx');
         $("#<?php echo $module['module_name'];?> #submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
		 editor.sync();
        top_ajax_form('monxin_form','submit_state','show_result');
        return false;
        }
        
    
    function show_result(){
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        //monxin_alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		
        $("#<?php echo $module['module_name'];?> #submit_state").html(json.info);    
    }
    </script>
    
    
    
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
    #<?php echo $module['module_name'];?> #content{ width:720px; height:1280px; overflow:hidden;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html>
    
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    <textarea name="content" id="content" style="display:none; width:720px; height:1280px;"><?php echo $module['data']?></textarea>
    <br /><input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span>
    </form>
    </div>
</div>

