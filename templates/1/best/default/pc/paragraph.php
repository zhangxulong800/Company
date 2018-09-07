<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #is_full").val(<?php echo $module['is_full']?>);		
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        editor.sync();
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
        top_ajax_form('monxin_form','submit_state','show_result');
        return false;
	}
        
    
    function show_result(){
        $("#<?php echo $module['module_name'];?> #submit_state").css("display","none");
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        //alert(v);
        json=eval("("+v+")");
        $("#<?php echo $module['module_name'];?> #submit_state").html(json.info);$("#<?php echo $module['module_name'];?> #submit_state").css("display","inline-block");		
		parent.set_p_id(json.id,<?php echo $_GET['index']?>);
    }
    </script>
    
    <style>
	.fixed_right_div{ display:none;}
    #<?php echo $module['module_name'];?>_html{}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>&id=<?php echo $_GET['id'];?>" onSubmit="return exe_check();">
    
    <textarea name="content" id="content" style="display:none; width:100%; height:300px;"><?php echo $module['c']?></textarea>
    
    <br />
    <?php echo self::$language['is_full']?>:<select id=is_full name=is_full><option value=1><?php echo self::$language['yes']?></option><option value=0><?php echo self::$language['no']?></option></select><br /><br />
    
      <input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span>
    </form>
    
    </div>
</div>

