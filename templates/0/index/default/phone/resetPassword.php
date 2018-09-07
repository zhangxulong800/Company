<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    function clear_defaut_value(){
        username=$("#<?php echo $module['module_name'];?>_html #username");
        if(username.prop('value')=='<?php echo self::$language['resetPassword_hint'];?>'){username.prop('value','');}
    }
    function reset_deault_value(){
        username=$("#<?php echo $module['module_name'];?>_html #username");
        if(username.prop('value')==''){username.prop('value','<?php echo self::$language['resetPassword_hint'];?>');}		
    }	
    function send_checkcode(){
        authcode=$("#<?php echo $module['module_name'];?>_html #authcode");
        username=$("#<?php echo $module['module_name'];?>_html #username");
        usernameErr=$("#<?php echo $module['module_name'];?>_html #username_state");
        if(authcode.prop('value')==''){authcode.focus();return false;}
        if(username.prop('value')==''){username.focus();return false;}
        $("#<?php echo $module['module_name'];?>_html #authcode_state").html('');
        $("#<?php echo $module['module_name'];?>_html #send_checkcode_div").css('display','none');
        usernameErr.html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['send_url'];?>',{authcode:authcode.prop('value'),username:username.prop('value')}, function(data){
            //alert(data);
             try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			
            if(v.errType=='authcode'){
                authcode.focus();
				monxin_alert(v.errInfo);
                $("#<?php echo $module['module_name'];?>_html #authcode_state").html(v.errInfo);usernameErr.html('');
                $("#<?php echo $module['module_name'];?>_html #send_checkcode_div").css('display','inline-block');
            }
            if(v.errType=='username'){
                username.focus();
				monxin_alert(v.errInfo);
                $("#<?php echo $module['module_name'];?>_html #username_state").html(v.errInfo);
                $("#<?php echo $module['module_name'];?>_html #send_checkcode_div").css('display','inline-block');
            }
            if(v.errType=='none'){
                if(v.state=='fail'){$("#<?php echo $module['module_name'];?>_html #send_checkcode_div").css('display','inline-block');}
                $("#<?php echo $module['module_name'];?>_html #username_state").html(v.info);
                $("#<?php echo $module['module_name'];?>_html #newPassword_div").css('display','block');
                }
        });
        return false;	
    }
    
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
    
        
        authcode=$("#<?php echo $module['module_name'];?>_html #authcode");
        identifying=$("#<?php echo $module['module_name'];?>_html #identifying");
        username=$("#<?php echo $module['module_name'];?>_html #username");
        password=$("#<?php echo $module['module_name'];?>_html #password");
        confirm_password=$("#<?php echo $module['module_name'];?>_html #confirm_password");
        if(authcode.prop('value')==''){authcode.focus();return false;}
        if(username.prop('value')=='' || username.prop('value')=='<?php echo self::$language['resetPassword_hint'];?>'){username.focus();return false;}
        if(identifying.prop('value')==''){identifying.focus();return false;}
        if(password.prop('value')==''){password.focus();return false;}
        if(confirm_password.prop('value')==''){confirm_password.focus();return false;}
        if(password.prop('value').length<6){alert('<?php echo self::$language['password_min']?>');password.focus();return false;}
        if(password.prop('value')!=confirm_password.prop('value')){
            alert('<?php echo self::$language['twice_password_not_same']?>');password.focus();return false;
        }
        $("#<?php echo $module['module_name'];?>_html #username_state").html('');
        $("#<?php echo $module['module_name'];?>_html #password_state").html('');
        $("#<?php echo $module['module_name'];?>_html #confirm_password_state").html('');
        $("#<?php echo $module['module_name'];?>_html #identifying_state").html('');
        $("#<?php echo $module['module_name'];?>_html #authcode_state").html('');
        $("#<?php echo $module['module_name'];?>_html #executing").css('display','inline-block');
        $("#<?php echo $module['module_name'];?>_html #submit").css('display','none');
        top_ajax_form('monxin_form','act_div','show_result');
        return false;
        }
    
    
    function show_result(){
        $("#<?php echo $module['module_name'];?>_html #executing").css('display','none');
        v=$("#<?php echo $module['module_name'];?>_html #act_div").html();
		//monxin_alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		
		monxin_alert(json.errInfo);
        if(json.errType=='authcode'){$("#<?php echo $module['module_name'];?>_html #authcode").focus();}
        if(json.errType=='username'){$("#<?php echo $module['module_name'];?>_html #username").focus();}
        if(json.errType=='identifying'){$("#<?php echo $module['module_name'];?>_html #identifying").focus();}
        if(json.errType=='none'){window.location.href="index.php?monxin=index.login&backurl=index.php?monxin=index.user";}else{
            $("#<?php echo $module['module_name'];?>_html #submit").css('display','inline-block');
        }
        return false;    
    }
    $(document).ready(function(){
		//$("#<?php echo $module['module_name'];?>_html #authcode").focus();return false;
		$("#<?php echo $module['module_name'];?>_html input").focus(function(data){
			$(this).addClass("focus");	 
		});
		$("#<?php echo $module['module_name'];?>_html input").blur(function(data){
			if(this.id=='username'){if($(this).prop('value')==''){$(this).prop('value','<?php echo self::$language['resetPassword_hint'];?>');}}
			$("#"+this.id+"_state").html('');
			$(this).removeClass("focus"); 
		});
            
    });
    </script>
    

    <div id=<?php echo $module['module_name'];?>_html>
    <div id=act_div style="display:none;" ></div>
	<style>
    #<?php echo $module['module_name'];?>_html{ line-height:2rem;}
    #<?php echo $module['module_name'];?>_html .input_text{width:220px; height:30px; line-height:30px; border-radius:3px;}
	#<?php echo $module['module_name'];?>_html #authcode{width:130px; height:30px; line-height:30px; border-radius:3px; }
	#<?php echo $module['module_name'];?>_html #authcode_img{width:100px; height:30px; }
	#<?php echo $module['module_name'];?>_html #send_checkcode_div{ }
	#<?php echo $module['module_name'];?>_html #submit{ display:inline-block; width:83%; height:3rem; line-height:3rem; text-align:center; font-size:1.2rem; font-family:"SimHei"; margin-top:0.5rem;}
    #<?php echo $module['module_name'];?>_html .m_label{ display: block; }
	#<?php echo $module['module_name'];?>_html .logo_div{ text-align:center;}
	#<?php echo $module['module_name'];?>_html .logo_div img{ width:70%;}
	
	#<?php echo $module['module_name'];?>_html .authcode_icon:before{font-family: "FontAwesome";font-size: 1.2rem; opacity:0.5; padding: 5px;content:"\f132";}
	#<?php echo $module['module_name'];?>_html .username_icon:before{font-family: "FontAwesome";font-size: 1.8rem; opacity:0.5; padding: 5px;content:"\f10b";}
	#<?php echo $module['module_name'];?>_html .identifying_icon:before{font-family: "FontAwesome";font-size: 1.2rem; opacity:0.5; padding: 5px;content:"\f132";}
	#<?php echo $module['module_name'];?>_html .password_icon:before{font-family: "FontAwesome";font-size: 1.2rem; opacity:0.5; padding: 5px;content:"\f023";}

	#<?php echo $module['module_name'];?>_html .line{ text-align:center; margin-bottom:0.5rem;}
	#<?php echo $module['module_name'];?>_html .line .icon{ width:20px; display:inline-block; vertical-align:top; padding-top:3px;}
	#<?php echo $module['module_name'];?>_html .line .input_line{ display:inline-block; width:70%; border-bottom: 1px solid #ccc;text-align:left; padding-bottom:3px;}
	#<?php echo $module['module_name'];?>_html .line input{ border:none; }
	
	#<?php echo $module['module_name'];?>_html  #newPassword_div input{ display:inline-block; width:90%;}
	#<?php echo $module['module_name'];?>_html  #username{ width:60%;}
	#<?php echo $module['module_name'];?>_html #send_checkcode_div{ border:1px solid #ccc; padding:3px;}
	#<?php echo $module['module_name'];?>_html .submit:before{ display:none;}
    </style>
    <form id="monxin_form" name="monxin_form" method="GET" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
		<div class=logo_div><img src="./logo.png" /></div>
       
        <div class=line><span class="icon authcode_icon"></span><span class=input_line><input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" placeholder="<?php echo self::$language['authcode'];?>" /> <a href="#" onclick="return change_authcode();" title="<?php echo self::$language['change_authcode'];?>"><img id="authcode_img" src="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a> <span id=authcode_state style="vertical-align:middle;"></span></span></div>
        
        <div class=line style="white-space:nowrap;"><span class="icon username_icon"></span><span class=input_line><input type="text" class="input_text" title="<?php echo self::$language['resetPassword_hint'];?>" name="username" id="username" value="<?php echo self::$language['resetPassword_hint'];?>" onfocus="clear_defaut_value();" />  <a href="#" id="send_checkcode_div" onclick="return send_checkcode()"><?php echo self::$language['send'];?><?php echo self::$language['identifying'];?></a> <span id=username_state></span></span></div>

      
      <div id=newPassword_div style="display:none;">
        <div class=line><span class="icon identifying_icon"></span><span class=input_line><input type="text" class="input_text" name="identifying" id="identifying" placeholder="<?php echo self::$language['identifying'];?>" /><span id=identifying_state></span></span></div>
        <div class=line><span class="icon password_icon"></span><span class=input_line><input type="password" class="input_text" name="password" id="password"  placeholder="<?php echo $module['field_name'];?>"  /><span id=password_state></span></span></div>
        <div class=line><span class="icon password_icon"></span><span class=input_line><input type="password" class="input_text" name="confirm_password" id="confirm_password" placeholder="<?php echo self::$language['confirm'];?><?php echo $module['field_name'];?>" /><span id=confirm_password_state></span></span></div>
		<div class=line style="text-align:center;"><a href="#" onclick="return exe_check();" name="submit" id="submit" class=submit><?php echo self::$language['submit'];?></a> <span class=loading id=executing  style="display:none;">&nbsp;</span><span id=submit_state></span></div>
      </div>
    </form>
    <br /><br />
    </div>

</div>