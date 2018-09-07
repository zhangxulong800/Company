<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left style="width:100%;">
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?> #content").focus(function(){
		$("#<?php echo $module['module_name'];?> #next").css('display','block');
	});
	$("#<?php echo $module['module_name'];?> #content").blur(function(){
		if($(this).val()==''){$("#<?php echo $module['module_name'];?> #next").css('display','none');}
	});
	$("#<?php echo $module['module_name'];?> #submit").click(function(){		
		if($("#<?php echo $module['module_name'];?> #content").val()==''){$("#<?php echo $module['module_name'];?> #content").focus();$(this).next('span').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['feedback_content'];?></span>');return false;}
		if($("#<?php echo $module['module_name'];?> #authcode").val()==''){$("#<?php echo $module['module_name'];?> #authcode").focus();$(this).next('span').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['authcode'];?></span>');return false;}
		$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
		$.post('<?php echo $module['action_url'];?>&act=add', {content:$("#<?php echo $module['module_name'];?> #content").val(),feedback_sender:$("#<?php echo $module['module_name'];?> #feedback_sender").val(),feedback_receive:$("#<?php echo $module['module_name'];?> #feedback_receive").val(),authcode:$("#<?php echo $module['module_name'];?> #authcode").val()},function(data){
			//alert(data);	
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?>_html").css('text-align','center');
				$("#<?php echo $module['module_name'];?>_html").html(v.info);	
			}
		});	
		return false;
	});
	
	

});
</script>
    

<style>
    #<?php echo $module['module_name'];?>_html{ padding:10px; }
    #<?php echo $module['module_name'];?>_html div{ line-height:2.5rem; vertical-align:top;}
    #<?php echo $module['module_name'];?>_html #next{ display:none;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:30%;  text-align:right; padding-right:5px;vertical-align:top;}
    #<?php echo $module['module_name'];?> .input_span input{ width:30%;}
    #<?php echo $module['module_name'];?> .input_span #content{ width:70%; height:100px; border:1px #ccc solid;}
    #<?php echo $module['module_name'];?> .input_span #authcode{width:100px;}
    #<?php echo $module['module_name'];?>_html #authcode_img{ height:25px;}
    #<?php echo $module['module_name'];?>_html .feedback_icon{ display:inline-block; vertical-align:top; height:8.57rem;  width:15%; text-align:right; padding-right:10px;}
    #<?php echo $module['module_name'];?>_html .feedback_icon:before{font: normal normal normal 3rem/1 FontAwesome; content:"\f1d7";line-height:6.57rem; opacity:0.8;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
</style>


<div id="<?php echo $module['module_name'];?>_html">
      <div><span class=feedback_icon ></span><span class=input_span>
        <textarea name="content" id="content" placeholder="<?php echo self::$language['program_name'];?>:<?php echo self::$language['feedback_content_placeholder'];?>"></textarea>
      </span></div>
      <div id=next>
          <div><span class=m_label><?php echo self::$language['feedback_sender'];?>:</span><span class=input_span>
          <input type="text" name="feedback_sender" id="feedback_sender" placeholder="<?php echo self::$language['feedback_sender_placeholder'];?>"  />
          </span></div>
          <div><span class=m_label><?php echo self::$language['feedback_receive'];?>:</span><span class=input_span>
          <input type="text" name="feedback_receive" id="feedback_receive" placeholder="<?php echo self::$language['feedback_receive_placeholder'];?>"  />
          </span></div>
          <div><span class=m_label><?php echo self::$language['authcode'];?>:</span><span class=input_span>
         <input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" /> <a href="#" onclick="return change_authcode();" title="<?php echo self::$language['click_change_authcode']?>"><img id="authcode_img" src="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a>
          </span></div>
          <div><span class="m_label">&nbsp;</span><span class=input_span>
                <a href="#" id=submit class="submit"><?php echo self::$language['submit'];?><?php echo self::$language['feedback'];?></a> <span></span>
          </span></div>
      </div> 

</div>
</div>