<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        var type=$("#<?php echo $module['module_name'];?> #type");
        var title=$("#<?php echo $module['module_name'];?> #title");
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content");
        if(type.prop('value')<1){monxin_alert('<?php echo self::$language['please_select']?><?php echo self::$language['belong']?>');type.focus();return false;}
        if(title.prop('value')==''){monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['title']?>');title.focus();return false;}
        if(content.prop('value')==''){monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['content']?>');return false;}
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
        top_ajax_form('monxin_form','submit_state','show_result');
        return false;
        }
        
    
    function show_result(){
        $("#<?php echo $module['module_name'];?> #submit_state").css("display","none");
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        //monxin_alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		

        if(json.state=='fail'){$("#<?php echo $module['module_name'];?> #submit_state").html(json.info);$("#<?php echo $module['module_name'];?> #submit_state").css("display","inline-block");}
        
            
    }
    </script>
    
    
    
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
    #<?php echo $module['module_name'];?> #parent{}
    #<?php echo $module['module_name'];?> #title{ width:600px;}
    #<?php echo $module['module_name'];?> #content{}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    
      <?php echo self::$language['belong'];?>：<select id="type" name="type">
      <option value="-1"><?php echo self::$language['please_select']?></option>
      <?php echo $module['parent'];?></select> <a href="index.php?monxin=diypage.type"><?php echo self::$language['create']?></a><br /><br />
      <?php echo self::$language['title'];?>：<input type="text" name="title" id="title" /><br /><br />
      <?php echo self::$language['content'];?>：<br />
      
    <textarea name="content" id="content" style="display:none; width:100%; height:400px;"></textarea>
    
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

