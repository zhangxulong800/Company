<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    var reg_email=<?php echo $module['reg_email']?>;
	var remain_time;
	var t1;
    $(document).ready(function(){
		if($(".phone_country").attr('class')){
			$(".phone_country").val($('.phone_country').attr('monxin_value'));
			$(".phone_country_switch").html('+'+$('.phone_country').attr('monxin_value'));
			$(".phone_country").css('left',$(".phone_country_switch").offset().left);
			$(".phone_country").attr('size','8');
			$(".phone_country_switch").click(function(){
				if($(".phone_country").css('display')=='none'){
					$(".phone_country").css('display','block');
					$(".phone_country").trigger('mousedown');
				}else{
					$(".phone_country").css('display','none');
				}
			});
			
			$(".phone_country").click(function(){
				$(".phone_country_switch").html('+'+$('.phone_country').val());
				$(".phone_country").css('display','none');
			});
		}
		
		$(".page-header").height($(window).height()-$(".page-footer").height()-40);
		
		
		//$("#<?php echo $module['module_name'];?>_html .form_div").css('margin-top',$("#<?php echo $module['module_name'];?>").height()/7);
		
		$("html,body").animate({scrollTop: $("#<?php echo $module['module_name'];?>").offset().top}, 1000);
		$("#username").focus();			

	group_id=get_param('group_id');
	if(group_id!=''){
		$("#<?php echo $module['module_name'];?>_html #group").prop('value',group_id);
		$("#<?php echo $module['module_name'];?>_html #group_id_div").css('display','none');
	}	
	$("#<?php echo $module['module_name'];?>_html #group").change(function(data){
		if($(this).prop("value")!=0){
			group_id=$(this).prop("value");
			$("#<?php echo $module['module_name'];?>_html #group_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=check_group',{group_id:group_id}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#<?php echo $module['module_name'];?>_html #group_state").html(v.info);
            if(v.state=='ok'){
				
            }else{
				
			}
			
          });
		}else{
			$("#<?php echo $module['module_name'];?>_html #group_state").html('');
		}	 
	});
	

	$("#<?php echo $module['module_name'];?>_html input").focus(function(data){
		$(this).addClass("focus");	 
	});
	$("#<?php echo $module['module_name'];?>_html input").blur(function(data){
		if(this.id=='username'){if($(this).prop('value')==''){$(this).prop('value','<?php echo self::$language['username_hint'];?>');}}
		$("#"+this.id+"_state").html('');
		$(this).removeClass("focus"); 
	});
	$(".get_verification_code").click(function(){
		if($("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity')!=1){return false;}
		window.clearInterval(t1);
		
		if($("#<?php echo $module['module_name'];?>_html #email").attr('type')){
			if(!reg_email.test($("#<?php echo $module['module_name'];?>_html #email").val()) ){		
				alert('<?php echo self::$language['email']?><?php echo self::$language['pattern_err']?>');
				$("#<?php echo $module['module_name'];?>_html #email").focus();
				return false;
			}
			
		}
		
			$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',0.3);
			//$("#<?php echo $module['module_name'];?> .get_verification_code").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			$.post('<?php echo $module['action_url'];?>&act=get_verification_code',{phone:$("#<?php echo $module['module_name'];?> #phone").val(),phone_country:$("#<?php echo $module['module_name'];?> #phone_country").val(),email:$("#<?php echo $module['module_name'];?> #email").val(),token:$("#<?php echo $module['module_name'];?> #token").val(),}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}				
				
				if(v.info=='weixin'){
					$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',1);
					$("#<?php echo $module['module_name'];?> .weixin_reg").html(v.html);
					
					return false;
				}
				if(v.info=='image'){
					$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',1);
					$("#<?php echo $module['module_name'];?> .get_verification_code").html('<img src=./lib/verification_code.class.php?'+Math.random()+' />');
					return false;
				}
				alert(v.info);
				if(v.state=='fail'){
					$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',1);
				}else{

					$("#<?php echo $module['module_name'];?> .get_verification_code").html('<?php echo self::$language['recapture']?>(<b>60</b>)');
					remain_time=60;

					t1 = window.setInterval(update_remain,1000);  

				}
				
			});
			return false;	

		
	});
	
	
    });
	
	
		function update_remain(){
			if(remain_time==0){
				$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',1);
				$("#<?php echo $module['module_name'];?> .get_verification_code").html('<?php echo self::$language['recapture']?>');
				window.clearInterval(t1);
			}
			$("#<?php echo $module['module_name'];?> .get_verification_code b").html(remain_time--);	
		}
    
	
	
    function clear_defaut_value(){
	username=$("#<?php echo $module['module_name'];?>_html #username");
	if(username.prop('value')=='<?php echo self::$language['username_hint'];?>'){username.prop('value','');}	
    }	
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
		is_null=false;
		$("#<?php echo $module['module_name'];?> input").each(function(index, element) {
			if($(this).val()==''){$(this).focus();is_null=true; return false;}
		});
		if(is_null){return false;}
       	group=$("#<?php echo $module['module_name'];?>_html #group");
        username=$("#<?php echo $module['module_name'];?>_html #username");
        password=$("#<?php echo $module['module_name'];?>_html #password");
        confirm_password=$("#<?php echo $module['module_name'];?>_html #confirm_password");
        authcode=$("#<?php echo $module['module_name'];?>_html #authcode");
        au_Div=$("#<?php echo $module['module_name'];?>_html #authCode_Div");
        if(group.prop('value')=='0'){group.focus();return false;}
        if(username.prop('value')=='' || username.prop('value')=='<?php echo self::$language['username_hint'];?>'){username.focus();return false;}
        if(password.prop('value')==''){password.focus();return false;}
        if(confirm_password.prop('value')==''){confirm_password.focus();return false;}
        if(password.prop('value').length<6){alert('<?php echo self::$language['password_min']?>');password.focus();return false;}
        if(password.prop('value')!=confirm_password.prop('value')){
          alert('<?php echo self::$language['twice_password_not_same']?>');password.focus();return false;
        }
        if(authcode.prop('value')==''){authcode.focus();return false;}
        
		
		if($("#<?php echo $module['module_name'];?>_html #email").attr('type')){
			if(!reg_email.test($("#<?php echo $module['module_name'];?>_html #email").val()) ){		
				
				alert('<?php echo self::$language['email']?><?php echo self::$language['pattern_err']?>');
				$("#<?php echo $module['module_name'];?>_html #email").focus();
				return false;
				}
			
		}
		
		if(!$("#<?php echo $module['module_name'];?> .input_checkbox").prop('checked')){
			alert('<?php echo self::$language['please_agreement']?>');
			return false;
		}
		
		
		
        $("#<?php echo $module['module_name'];?>_html #phone_state").html('');
        $("#<?php echo $module['module_name'];?>_html #email_state").html('');
        $("#<?php echo $module['module_name'];?>_html #username_state").html('');
        $("#<?php echo $module['module_name'];?>_html #password_state").html('');
        $("#<?php echo $module['module_name'];?>_html #confirm_password_state").html('');
        $("#<?php echo $module['module_name'];?>_html #authcode_state").html('');
        $("#<?php echo $module['module_name'];?>_html #submit_state").html('');
        $("#<?php echo $module['module_name'];?>_html #submit").css('display','none');
        $("#<?php echo $module['module_name'];?>_html #executing").css('display','inline-block');
        top_ajax_form('monxin_form','login_div','show_result');
        return false;
        }
        
    
    function show_result(){
        $("#<?php echo $module['module_name'];?>_html #executing").css('display','none');
        v=$("#<?php echo $module['module_name'];?>_html #login_div").html();
		//document.write(v);
        //alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
        if(json.errType!='exe_success'){$("#<?php echo $module['module_name'];?>_html #submit").css('display','inline-block');}
        if(json.errType=='exe_success'){monxin_alert(json.errInfo);window.location.href='index.php?monxin=index.login';return false;}
       // if(json.errType=='exe_fail'){monxin_alert(json.errInfo);}
        //monxin_alert(json.errType);
		
		
		
		monxin_alert(json.errInfo);
		$("#"+json.errType).focus();
		//$("#"+json.errType+"_state").html('<span class=fail>'+json.errInfo+'</span>');
		            
    }
    </script>
<style>
	.page-container{ display:none;}
	.page-footer{ background:#fff !important; color:#999 !important; clear:both;}
	.page-footer a{  color:#999 !important;}
	#<?php echo $module['module_name'];?>{  line-height:2.5rem; width:100%; height:88%;  background-image:url(regist_bg.png); background-position:center; background-repeat:no-repeat; background-size:cover;  border:2px solid #FFF; font-size:1.15rem; font-family: "Microsoft YaHei"; text-align:right;}
	#<?php echo $module['module_name'];?>_html .form_div{ width:400px; margin:3rem; box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1); float:right; text-align:left; background:#fff; border-radius:0.6rem; overflow:hidden; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body{ padding:1rem;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login_logo_div{ display:none;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login_logo_div img{ width:100%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div{  margin-left:1rem; margin-right:1rem; border:#CCC 1px solid; text-align:left; padding:1rem;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body  input{  width:100%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body  input:focus{  }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .username_div{ border-bottom:#CCC 1px solid;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .username_div:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:'\f007';   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .password_div{}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .password_div:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f023";   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div{ text-align:left;margin-left:1rem; margin-right:1rem;margin-top:1rem; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div{ border:1px #CCCCCC solid; padding-left:1rem; display:inline-block; vertical-align:top; width:50%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div input{ width:60%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:'\f007';   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div .authcode_img_a{display:inline-block; padding-left:1rem; vertical-align:top; width:40%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div .authcode_img_a img{ height:3rem; }
	
	
	
	
	#<?php echo $module['module_name'];?>_html .form_div .f_body #get_password{ display:block; text-align:left; padding-left:1rem; text-align:center;}
	#<?php echo $module['module_name'];?>_html .form_div  #reg_button_true{display:block;   font-weight:bold; line-height:4rem; text-align:center;  margin-bottom:1rem; }
	#<?php echo $module['module_name'];?>_html .form_div  #reg_button_true #submit{font-size:1.2rem; display:inline-block;   border-radius:0.3rem; padding-left:1rem; padding-right:1rem; line-height:2.5rem; height:2.5rem; font-weight:normal;}
	#<?php echo $module['module_name'];?>_html .form_div  #reg_button_true #submit:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f046"; padding-right:3px; display:none;}
	#<?php echo $module['module_name'];?>_html .form_div #reg_button_true #submit:hover{ }
	#<?php echo $module['module_name'];?>_html #submit_state{ }
  
	#<?php echo $module['module_name'];?>_html .line{ text-align:left;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; width:30%; text-align:right; padding-right:5px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .line .input_span{display:inline-block; vertical-align:top; width:50%; white-space:nowrap;}


.get_verification_code{font-size:1rem; display:inline-block; width:102px; text-align:left;}
.get_verification_code img{vertical-align:middle;}
.title_div{ line-height:3rem; width:85%; margin:auto; }
.title_div span{ display: inline-block; vertical-align:top; width:55%; font-weight:bold; overflow:hidden;}
.title_div a{ display: inline-block; vertical-align:top; width:35%; text-align:right; padding-right:1rem; font-size:0.8rem; overflow:hidden;color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
.title_div a:hover{opacity:0.8;}
#<?php echo $module['module_name'];?>_html .line .agreement{ width:1rem !important;}
.agreement_div{color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
.agreement_div a{color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}

.phone_input_div{border: 1px solid #e4e4e4;border-radius: 3px;}
.phone_input_div .phone_country_switch{ display:inline-block; vertical-align:top; width:50px; cursor:pointer;}
#<?php echo $module['module_name'];?>_html .phone_input_div #phone{ display:inline-block; vertical-align:top; width:130px; border:none;}
.phone_input_div .phone_country_switch:after{ padding-left:3px; font: normal normal normal 1rem/1 FontAwesome;content:"\f0d7";margin-right: 5px;}
.phone_country{ position:absolute; display:none;}
.phone_country option:hover{ background:rgba(200,200,200,1);}
</style>

    <div id=<?php echo $module['module_name'];?>_html  class="container">
        <div class=form_div>
        	<div class=f_body>
                        	
        		<div class=title_div><span><?php echo self::$language['welcome_reg']?></span><a href="./index.php?monxin=index.login"><?php echo self::$language['existing_account']?></a></div>

            	<div id=login_logo_div><img src='logo.png'></div>
                <form id="monxin_form" name="monxin_form" method="GET" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
                
                  <div id=group_id_div><span class="m_label"><?php echo self::$language['user_group'];?>：</span><span class=input_span><select id="group" name="group"><?php echo $module['group'];?></select></span><span id=group_state></span><br /></div>
                  
                  
                  <div class=line><span class="m_label"><?php echo self::$language['account'];?>：</span><span class=input_span><input class="input_text" type="text" name="username" id="username" title="<?php echo self::$language['username_hint'];?>" value="<?php echo self::$language['username_hint'];?>" onfocus="clear_defaut_value();" /></span><span id=username_state></span></div>
                  
                  <div class=line><span class="m_label"><?php echo self::$language['password'];?>：</span><span class=input_span><input class="input_text" type="password" name="password" id="password" /></span><span id=password_state></span></div>
                  
                  <div class=line><span class="m_label"><?php echo self::$language['confirm'];?><?php echo self::$language['password'];?>：</span><span class=input_span><input class="input_text" type="password" name="confirm_password" id="confirm_password" /></span><span id=confirm_password_state></span></div>
                  <?php echo $module['ohter_input'];?>
                        
                  <div class=line><span class="m_label"><?php echo self::$language['authcode'];?>：</span><span class=input_span><span id="authcode_box"><input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle; width:40%;" /> <span id=authcode_state></span> <a href=# class=get_verification_code><?php echo self::$language['get_verification_code']?></a> <span class=state></span></span></span></div>
                  
                  <div class=weixin_reg style="line-height:20px; text-align:center; padding-top:10px;"></div>
                </form>
                  <div class="line agreement_div"><span class="m_label">&nbsp;</span><span class=input_span><input type="checkbox" class=agreement /><?php echo self::$language['agreement']?><a href="<?php echo $module['user_agreement_url'];?>" target="_blank" id=user_agreement><?php echo self::$language['user_agreement'];?></a></span></div>

                
            </div>
             <div id="reg_button_true"><span class="reg_button">&nbsp;<a href="#" onclick="return exe_check();" name="submit" id="submit"><?php echo self::$language['register_immediately']?></a></span><span class=loading id=executing  style="display:none;"><span class='fa fa-spinner fa-spin'></span></span><span id=submit_state></span></div>
        </div>
        
    
    
    
    <div id=login_div style="display:none;" ></div>
   
    
    </div>
    </div>
</div>