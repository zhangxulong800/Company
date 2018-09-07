<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
				
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        editor.sync();
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
    #<?php echo $module['module_name'];?> #tag{ width:600px;}
    #<?php echo $module['module_name'];?> #link{ width:600px;}
    #<?php echo $module['module_name'];?> #content{}
	#replace_div{ display:none; vertical-align:top;}
	#html4_up_ele{ display:none !important;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <ul class="nav nav-tabs">
      <li role="presentation"><a href="./index.php?monxin=article.edit&id=<?php echo $_GET['id']?>&type=pc"><?php echo self::$language['pc_device'];?></a></li>
      <li role="presentation" class="active"><a href="./index.php?monxin=article.edit&id=<?php echo $_GET['id']?>&type=phone"><?php echo self::$language['phone_device'];?></a></li>
	</ul>
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>&id=<?php echo $_GET['id'];?>&device=phone" onSubmit="return exe_check();">
    
	  <?php echo self::$language['article_description'];?>      
      
    <textarea name="content" id="content" style="display:none; width:100%; height:400px;"><?php echo $module['phone_content']?></textarea>
    
    <br />
    
      <input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span>
    </form>
    
    </div>
</div>

