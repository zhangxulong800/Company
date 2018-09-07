<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
		if('<?php echo $module['email'];?>'==1){$("#email").prop('checked',true);}
        $("#replay_input_div input").keyup(function(event){
            keycode=event.which;
            if(keycode==13){subimt_content();}	
        });
		$("#<?php echo $module['module_name'];?> #authcode").focus(function(){
			if(!$("#<?php echo $module['module_name'];?> #authcode_img").attr('src')){
				$("#<?php echo $module['module_name'];?> #authcode_img").attr('src',$("#<?php echo $module['module_name'];?> #authcode_img").attr('wsrc'));	
			}
		});
    });
    
    function subimt_content(){
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content").val();
		if(content==''){$("#<?php echo $module['module_name'];?> #replay_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['content']?></span>');return false;}	
        var authcode=$("#<?php echo $module['module_name'];?> #authcode").val();
		if(authcode==''){$("#<?php echo $module['module_name'];?> #replay_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['authcode']?></span>');$("#<?php echo $module['module_name'];?> #authcode").focus();return false;}	
        var email=0;
		if($("#<?php echo $module['module_name'];?> #email").prop('checked')){email=1;}
        $("#<?php echo $module['module_name'];?> #replay_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=submit_content',{content:content,authcode:authcode,email:email}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #replay_state").html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> #replay_input_div .submit").css('display','none');
				
				
			}
        });
        return false; 	
        
    }
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{  border:1px solid #e3d1b9; padding-bottom:20px;}
	
	#<?php echo $module['module_name'];?>_html #replay_input_div{}
	#<?php echo $module['module_name'];?>_html .view{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html" >
    <div id=replay_input_div><textarea name="content" id="content" style="display:none; width:100%; height:200px;"><?php echo $module['content'];?></textarea>
    <br />
     <span class=m_label>&nbsp;</span><span class=input_span><input type="checkbox" id="email" name="email" /><?php echo self::$language['when_comments_remind_me'];?></span>
	<br /><br />
    <?php echo self::$language['authcode'];?> <input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" />  <a href="#" onclick="return change_authcode();" title="<?php echo self::$language['click_change_authcode']?>"><img id="authcode_img" wsrc="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a>
    <br /><br /><a href="#" class="submit" onclick="return subimt_content();"><?php echo self::$language['submit']?></a> <span id=replay_state></span>
    </div>

    </div>
</div>
