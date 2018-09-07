<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    var login_count=0;
	var t1;
	var remain_time;
	function update_remain(){
		if(remain_time==0){
			$("#<?php echo $module['module_name'];?>_html .get_sms").removeClass('count_down');
			$("#<?php echo $module['module_name'];?> .get_sms").html("<?php echo self::$language['resend']?> <span class=get_sms_state></span>");	
			window.clearInterval(t1);
		}
		$("#<?php echo $module['module_name'];?> .get_sms").html("<?php echo self::$language['resend']?> (<span class=get_sms_state>"+(remain_time--)+"</span>)");	
	}

    $(document).ready(function(){
		$(".page-header").height($(window).height()-$(".page-footer").height()-40);
		//$(".page-footer").height($(window).height()-$(".page-header").height());
		$("#<?php echo $module['module_name'];?>_html .form_div").css('margin-top',$("#<?php echo $module['module_name'];?>").height()/7);
		$("#<?php echo $module['module_name'];?> .get_sms_div").click(function(){$("#<?php echo $module['module_name'];?> .sms").focus();});
		$("#<?php echo $module['module_name'];?> #login_logo_div a").click(function(){
			if($(this).attr('class')=='password_login current' || $(this).attr('class')=='password_login' ){
				$("#<?php echo $module['module_name'];?> #input_div").css('display','block');
				$("#<?php echo $module['module_name'];?> #authCode_Div").css("display",authCodeStyle);
				$("#<?php echo $module['module_name'];?> .sms_login_div").css('display','none');
			}else{
				$("#<?php echo $module['module_name'];?> #input_div").css('display','none');
				$("#<?php echo $module['module_name'];?> #authCode_Div").css('display','none');
				$("#<?php echo $module['module_name'];?> .sms_login_div").css('display','block');
			}
			
			$("#<?php echo $module['module_name'];?> #login_logo_div a").removeClass('current');
			$(this).addClass('current');
			return false;
		});
		
		
		$("#<?php echo $module['module_name'];?>_html .form_div .f_body .sms_login_div .sms_div .get_sms").click(function(){
			if($(this).attr('class')=='get_sms count_down'){return false;}
			if($("#<?php echo $module['module_name'];?> .phone").val()==''){
				$("#<?php echo $module['module_name'];?> .phone").focus();
				return false;	
			}
			$("#<?php echo $module['module_name'];?>_html .get_sms").addClass('count_down');
			$("#<?php echo $module['module_name'];?>_html .get_sms .get_sms_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=get_sms',{phone:$("#<?php echo $module['module_name'];?>_html .phone").val(),phone_country:$("#<?php echo $module['module_name'];?>_html .phone_country").val()}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?>_html .get_sms .get_sms_state").html(' ('+v.info+')');
				if(v.state=='fail'){
					$("#<?php echo $module['module_name'];?>_html .get_sms").removeClass('count_down');
				}else{
					$("#<?php echo $module['module_name'];?>_html .get_sms").html("<?php echo self::$language['resend']?><span class=get_sms_state>(60)</span>");
					$("#<?php echo $module['module_name'];?>_html .get_sms").addClass('count_down');
					
					remain_time=60;

					t1 = window.setInterval(update_remain,1000);  
					
				}
			});

			
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> input").keydown(function(event){
			if(event.keyCode==13){
				if($("#<?php echo $module['module_name'];?> .sms_login_div").css('display')=='none'){
					exe_check();
				}else{
					sms_login();
				}
			}	
			if($(this).attr('id')=='password' && event.keyCode==9 && $("#authCode_Div").css('display')=='none'){$("#<?php echo $module['module_name'];?> #login").focus(); return false;}	  	
			if($(this).attr('id')=='authcode' && event.keyCode==9){$("#<?php echo $module['module_name'];?> #login").focus(); return false;}	  	
		});
		
		$(window).focus(function(){
			//alert(getCookie('monxin_nickname'));
				if(getCookie('monxin_nickname')!=''){
					//alert('zz');
					window.location.href='<?php echo $module['backurl_2'];?>';
				}
		});
		$(".oauth_switch").click(function(){
			return false;
			$(this).css('display','none');
			$(".icons").css('display','block');
			return false;
		});
		$(".oauth_div .icons").click(function(event){
			if(event.target.tagName=='DIV'){
				return false;
				$(this).css('display','none');
				$(".oauth_switch").css('display','block');
				return false;	
			}
		});

		
		$("html,body").animate({scrollTop: $("#<?php echo $module['module_name'];?>").offset().top}, 1000);
       	$("#<?php echo $module['module_name'];?> #authCode_Div").css("display",authCodeStyle);
        $("#<?php echo $module['module_name'];?> #username").focus();
        $("#<?php echo $module['module_name'];?> input").focus(function(data){
			$("#"+this.id+"_state").html('');
        });
		
        $("#<?php echo $module['module_name'];?> input").blur(function(data){
            $("#"+this.id+"_state").html('');
        });
    	
		$("#<?php echo $module['module_name'];?> #login").click(function(){
			if($("#<?php echo $module['module_name'];?> .sms_login_div").css('display')=='none'){
				exe_check();
			}else{
				sms_login();
			}
			
			return false;	
		});
		
		
    });
        
    <?php echo $module['authCodeStyle'];?>
    
    function sms_login(){
		if($("#<?php echo $module['module_name'];?> .sms_login_div .phone").val()==''){
			$("#<?php echo $module['module_name'];?> .sms_login_div .phone").focus();
			return false;
		}
		if($("#<?php echo $module['module_name'];?> .sms_login_div .sms").val()==''){
			$("#<?php echo $module['module_name'];?> .sms_login_div .sms").focus();
			return false;
		}
		
        $("#<?php echo $module['module_name'];?> #submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$("#<?php echo $module['module_name'];?> #login").attr('disabled',true).addClass('btn btn-default btn-lg disabled');
        $.post('<?php echo $module['action_url'];?>&act=sms_login',{phone:$("#<?php echo $module['module_name'];?> .sms_login_div .phone").prop('value'),phone_country:$("#<?php echo $module['module_name'];?> .sms_login_div .phone_country").prop('value'),sms:$("#<?php echo $module['module_name'];?> .sms_login_div .sms").prop('value')}, function(data){
			try{v=eval("("+data+")");}catch(exception){console.log(data);}
			$("#submit_state").html(v.info);
			if(v.state=='fail'){
				$("#<?php echo $module['module_name'];?> #login").attr('disabled',false).removeClass('btn btn-default btn-lg disabled');
			}else{
				window.location.href='<?php echo $module['backurl_2'];?>';
				$("#submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>  loading....');
			}
		});
        return false;
     }
        
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        var username=$("#<?php echo $module['module_name'];?> #username");
        var password=$("#<?php echo $module['module_name'];?> #password");
        var au_Div=$("#<?php echo $module['module_name'];?> #authCode_Div");
        if(username.prop('value')=='' || username.prop('value')=='<?php echo self::$language['username_hint'];?>'){username.focus();return false;}
        if(password.prop('value')==''){password.focus();return false;}
         
		var authcode=$("#<?php echo $module['module_name'];?> #authcode");
        if(au_Div.css('display')=='block'){
            if(authcode.prop('value')==''){authcode.focus();return false;}	
        }
        
        $("#<?php echo $module['module_name'];?> #username_state").html('');
        $("#<?php echo $module['module_name'];?> #password_state").html('');
        $("#<?php echo $module['module_name'];?> #authcode_state").html('');
        $("#<?php echo $module['module_name'];?> #submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$("#<?php echo $module['module_name'];?> #login").attr('disabled',true).addClass('btn btn-default btn-lg disabled');
        $.get('<?php echo $module['action_url'];?>',{username:username.prop('value'),password:password.prop('value'),authcode:authcode.prop('value')}, function(data){
            //alert(data);
			v=data;
			v=v.split("|");
			temp=v[0];
			try{json=eval("("+temp+")");}catch(exception){alert(temp);}
			if(json.errType!='none'){$("#<?php echo $module['module_name'];?> #submit").css('display','inline-block');login_count++;}
			if(login_count>3){$("#<?php echo $module['module_name'];?> #authCode_Div").css('display','block');}
			if(json.errType!='none'){
				$("#submit_state").html(json.errInfo);
				$("#<?php echo $module['module_name'];?> #login").attr('disabled',false).removeClass('btn btn-default btn-lg disabled');
				$("#<?php echo $module['module_name'];?> #"+json.errType).focus();
				$("#<?php echo $module['module_name'];?> #"+json.errType+"_state").html('<span class=fail title="'+json.errInfo+'"> </span>');
				monxin_alert($("#<?php echo $module['module_name'];?> #"+json.errType+"_state span").attr('title'));
			}else{
				//window.location.href=v[1];
				$("#submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>  loading....'+v[1]);
				
			}
		});
        return false;
     }
        
    </script>
    <style>
	.page-header{ height:100%; }
	.page-container{ display:none; }
	.page-footer{ background:#fff !important; color:#999 !important;}
	.page-footer a{  color:#999 !important;}
	#<?php echo $module['module_name'];?>{ line-height:2rem; width:100%; background-image:url(login_bg.png); background-position:center; background-repeat:no-repeat; background-size:cover; height:82%; font-size:1.15rem; font-family: "Microsoft YaHei"; text-align:right;}
	#<?php echo $module['module_name'];?>_html{ height:100%; }
	#<?php echo $module['module_name'];?>_html .form_div{ width:350px; margin:3rem; margin-top:2.5rem !important; box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1); float:right; text-align:left; background:#fff; border-radius:0.3rem; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body{ padding:1rem;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body input{ line-height:2.8rem;}
	#<?php echo $module['module_name'];?>_html  #password{ height:31px;}
	#<?php echo $module['module_name'];?>_html #authcode{}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login_logo_div{ }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login_logo_div img{ width:100%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div{ border-radius:0.3rem; border: 1px solid #ccc; line-height:2.8rem; margin-bottom:0.3rem; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body .sms_login_div{ border-radius:0.3rem; border: 1px solid #ccc; line-height:2.8rem; margin-bottom:0.3rem; display:none; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body .sms_login_div input{ width:60%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body .sms_login_div .sms_div{ border-top:1px #ccc solid;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body .sms_login_div .phone_div:before{ font: normal normal normal 1.6rem/1 FontAwesome; content:"\f10b";   border-radius:50%;  display:inline-block; width:2rem; height:2.8rem; line-height:2.8rem; text-align:center;color:#ccc; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body .sms_login_div .sms_div:before{ font: normal normal normal 1.2rem/1 FontAwesome; content:"\f132";   border-radius:50%;  display:inline-block; width:2rem; height:2.8rem; line-height:2.8rem; text-align:center;color:#ccc; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body .sms_login_div .sms_div input{ width:20%; vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body .sms_login_div .sms_div .get_sms{ display:inline-block; background:rgba(255,153,0,1); color:#fff; border-radius:9rem; line-height:1.8rem; padding-left:1rem; padding-right:1rem; font-size:0.8rem; cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body .sms_login_div .sms_div .get_sms:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body .sms_login_div .sms_div .get_sms_div{ display:inline-block; width:67%; vertical-align:top; overflow:hidden; text-align:right;}




	#<?php echo $module['module_name'];?>_html .form_div .f_body  input{ border:none; outline-width:0px;  width:85%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body  input:focus{  border:none; outline-width:0px; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .username_div{ border-bottom:0px;overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .username_div:before{ font: normal normal normal 1.2rem/1 FontAwesome; content:'\f007';   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;color:#ccc; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .password_div{ border-top: 1px solid #ccc; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .password_div input{ padding-left:5px;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .password_div:before{font: normal normal normal 1.2rem/1 FontAwesome; content:'\f084';   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;color:#ccc;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div{ text-align:left;margin-top:1rem; white-space:nowrap; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div{ display:inline-block; vertical-align:top;  border-radius:0.3rem; margin-bottom:0.3rem;border: 1px solid #ccc; overflow:hidden; width:50%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div input{ width:60%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div:before{font: normal normal normal 1rem/1 FontAwesome; content:'\f14a';   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;color:#ccc;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div .authcode_img_a{display:inline-block; padding-left:1rem; vertical-align:top; width:40%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div .authcode_img_a img{ height:2.5rem; }
	
	
	
	#<?php echo $module['module_name'];?>_html .form_div .f_body #get_password{ display:inline-block; color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; vertical-align:top; width:50%; text-align:left;font-size:1rem; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login{display:block; width:100%; margin:auto; text-align:center; margin-top:0.1rem; margin-bottom:0.1rem;border-radius:0.3rem; line-height:2.6rem !important;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .form_div #register{display:inline-block; vertical-align:top; width:50%; text-align:right;color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; font-size:1rem; }
	#<?php echo $module['module_name'];?>_html .form_div #register:hover{}
	
	#<?php echo $module['module_name'];?>_html .oauth_div { text-align:center;}
	#<?php echo $module['module_name'];?>_html .oauth_div .oauth_switch{ color:#ccc; font-size:0.9rem; } 
	#<?php echo $module['module_name'];?>_html .oauth_div .oauth_switch:after{ display:none; }
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons{  }
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons a{ margin:0.3rem;}
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons a img{ width:2rem; height:2rem;}
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons a img:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html #submit_state{ display:block; color:red;  text-align:center;}
	#<?php echo $module['module_name'];?>_html  #login_div{ text-align:center;}
  	
	#<?php echo $module['module_name'];?>_html #login_logo_div{ border-bottom:1px solid #ccc; margin-bottom:1.5rem;}
  	#<?php echo $module['module_name'];?>_html #login_logo_div a{ display:inline-block; vertical-align:top; padding-left:0.5rem; padding-right:0.5rem; margin-right:1rem; font-weight:normal; font-size:1rem; padding-bottom:0.5rem; color:#ccc; cursor:pointer;}
	#<?php echo $module['module_name'];?>_html #login_logo_div a:hover{ color:red; opacity:0.5;}
	#<?php echo $module['module_name'];?>_html #login_logo_div .current{ color:#000; border-bottom:1px solid #000;}
	.phone_country{ width:90px; overflow:hidden;}
	
	#<?php echo $module['module_name'];?>_html .count_down{ opacity:0.5; background:#ccc !important;}
  </style>
        <div id=<?php echo $module['module_name'];?>_html class="container">
        
        <div class=form_div>
        	<div class=f_body>
            	<div id=login_logo_div>
                	<a class="password_login current"><?php echo self::$language['password_login'];?></a><a class=sms_login><?php echo self::$language['sms_login'];?></a>
                </div>
                <div class=sms_login_div>
                	<div class=phone_div><input type=text class=phone placeholder="<?php echo self::$language['phone']?>" /><?php echo $module['phone_country_select'];?></div>
                	<div class=sms_div><input type=text class=sms placeholder="<?php echo self::$language['authcode']?>" /> <div class=get_sms_div><a class=get_sms><?php echo self::$language['get_verification_code']?><span class=get_sms_state></span></a></div></div>
                </div>
                <div id=input_div>
                  <div class=username_div><input  type="text" name="username" id="username" title="<?php echo self::$language['username_hint'];?>" placeholder="<?php echo self::$language['username_hint'];?>" /><span id=username_state></span></div>
                  <div class=password_div><input type="password" name="password" id="password"  placeholder="<?php echo self::$language['password'];?>"  /><span id=password_state></span></div>
                </div>
                <div id="authCode_Div" style=" display:none;" >
					<div id="authcode_div"><input type="text" name="authcode" id="authcode" size="8"   placeholder="<?php echo self::$language['authcode'];?>"  /><span id=authcode_state style="vertical-align:middle;"></span></div><a href="#" class=authcode_img_a onclick="return change_authcode();" title="<?php echo self::$language['change_authcode'];?>"><img id="authcode_img" src="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a>
                </div>
                
                <a href="./index.php?monxin=index.resetPassword&field=password" id=get_password><?php echo self::$language['get_password']?></a><a href="./index.php?monxin=index.reg_user&group_id=<?php echo $module['default_group_id'];?>" id="register"><?php echo self::$language['register']?></a>
                <a href="#" type="submit" name="submit" id="login" user_color=button><?php echo self::$language['login']?></a>
                <span id=submit_state></span>
                <?php echo $module['oauth'];?>
                
            </div>
            
        </div>
        
        <div id=login_div style="display:none;" ></div>
        </div>
</div>
