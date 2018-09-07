<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        var addressee=$("#<?php echo $module['module_name'];?> #addressee");
        var title=$("#<?php echo $module['module_name'];?> #title");
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content");
        if(addressee.prop('value')==''){monxin_alert('<?php echo self::$language['please_select']?><?php echo self::$language['addressee']?>');addressee.focus();return false;}
        if(title.prop('value')==''){monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['title']?>');title.focus();return false;}
        if(content.prop('value')==''){monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['content']?>');}
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
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?> .ke-container{ border-radius:3px;}
    #<?php echo $module['module_name'];?> #title{ width:600px;}
    #<?php echo $module['module_name'];?> #content{}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
      <?php echo self::$language['addressee'];?>(<?php echo self::$language['username'];?>)：<a href='./index.php?monxin=index.admin_users'><?php echo self::$language['select_please'];?></a><br />
      <textarea name="addressee" id="addressee" style=" height:90px;width:99%;"><?php echo @$_POST['data']?></textarea>   <?php echo self::$language['addressee'];?><?php echo self::$language['separated_by_commas'];?>
<br /><br />
      <?php echo self::$language['title'];?>：<br />
      <input type="text" name="title" id="title" style="width:99%;" /><br /><br />
	  <?php echo self::$language['content'];?>：<br />
      
    <textarea name="content" id="content" style="display:none; width:99%; height:400px;"></textarea>
      <br /><input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span>
    </form>
    </div>
</div>

