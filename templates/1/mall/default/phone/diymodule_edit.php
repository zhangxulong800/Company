<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language'];?>"></script>
    <script>
    $(document).ready(function(){
    
	});
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        var title=$("#<?php echo $module['module_name'];?> #title");
        var width=$("#<?php echo $module['module_name'];?> #width");
        var height=$("#<?php echo $module['module_name'];?> #height");
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content");
        if(title.prop('value')==''){monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');title.focus();return false;}
        if(width.prop('value')==''){monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['module_width']?>');width.focus();return false;}
        if(height.prop('value')==''){monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['module_height']?>');height.focus();return false;}
        if(content.prop('value')==''){monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['content']?>');return false;}
		if($("#<?php echo $module['module_name'];?> #title_visible").prop('checked')){
			$("#<?php echo $module['module_name'];?> #title_visible").val(1);
		}else{
			$("#<?php echo $module['module_name'];?> #title_visible").val(0);
		}
		
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
		width.val(check_module_size(width.val()));
		height.val(check_module_size(height.val()));
        top_ajax_form('monxin_form','submit_state','show_result');
        return false;
        }
        
    
    function show_result(){
        $("#<?php echo $module['module_name'];?> #submit_state").css("display","none");
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        //alert(v);
		try{json=eval("("+v+")");}catch(exception){alert(v);}
		

        if(json.state=='fail'){$("#<?php echo $module['module_name'];?> #submit_state").html(json.info);$("#<?php echo $module['module_name'];?> #submit_state").css("display","inline-block");}
        
            
    }
    </script>
    
    
    
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
    #<?php echo $module['module_name'];?>_html #title_visible{ height:13px;}
    #<?php echo $module['module_name'];?> #title{ width:150px;}
    #<?php echo $module['module_name'];?> #width{ width:50px;}
    #<?php echo $module['module_name'];?> #height{ width:50px;}
    #<?php echo $module['module_name'];?> #content{}
    </style>
    <div id=<?php echo $module['module_name'];?>_html>
    
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>&id=<?php echo $_GET['id']?>" onSubmit="return exe_check();">
      <?php echo self::$language['name'];?>：<input type="text" name="title" id="title" value="<?php echo $module['title']?>" /> <input type="checkbox" name="title_visible"  id="title_visible" value="<?php echo $module['title_visible'];?>" <?php echo $module['title_visible_checked'];?> /><?php echo self::$language['visible'];?><?php echo self::$language['name'];?>
      <br /><br /><?php echo self::$language['module_width'];?>：<input type="text" name="width" id="width" value="<?php echo $module['width']?>" /> 
      &nbsp;&nbsp;&nbsp;&nbsp;<?php echo self::$language['module_height'];?>：<input type="text" name="height" id="height" value="<?php echo $module['height']?>" /> 
      
      <br /><br />
      <?php echo self::$language['content'];?>：<br />
    <textarea name="content" id="content" style="display:none; width:100%; height:400px;"><?php echo $module['content']?></textarea>
    
    <br />
    <div><a href=# class="advanced_options"><?php echo self::$language['advanced_options'];?><span id=advanced_options_div_state class=show>&nbsp;</span></a></div>
    <div id=advanced_options_div>
      <span class="m_label"><?php echo self::$language['open_image_mark'];?>：</span><select id="image_mark" name="image_mark">
      <?php echo $module['image_mark_option'];?>
      </select><br /><br />
	</div>
    <br />
    
    <input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span>
    </form>
    </div>
</div>

