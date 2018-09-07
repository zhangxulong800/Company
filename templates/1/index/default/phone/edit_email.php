<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
var reg_email=<?php echo $module['reg_email']?>;
var remain_time;
var t1;
$(document).ready(function(){
	if($("#<?php echo $module['module_name'];?> #email").val()==''){
		document.title=document.title.replace(/<?php echo self::$language['modify']?>/,'<?php echo self::$language['perfecting']?>');	
		if($("#user_position .text").html()){
			$("#user_position .text").html($("#user_position .text").html().replace(/<?php echo self::$language['modify']?>/,'<?php echo self::$language['perfecting']?>'));	
		}
	}
	$("#<?php echo $module['module_name'];?> .get_verification_code").click(function(){
		if($("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity')!=1){return false;}
		window.clearInterval(t1);
		if(!reg_email.test($("#<?php echo $module['module_name'];?>_html #email").val())){		
			
			alert('<?php echo self::$language['email']?><?php echo self::$language['pattern_err']?>');
			$("#<?php echo $module['module_name'];?>_html #email").focus();
			return false;
		}
		

		$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',0.3);
		
		$.post('<?php echo $module['action_url'];?>&act=get_verification_code',{email:$("#<?php echo $module['module_name'];?> #email").val()}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}				
			
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
	
	$("#<?php echo $module['module_name'];?> .submit").click(function(){
		$("#<?php echo $module['module_name'];?> .state").html('');
		if(!reg_email.test($("#<?php echo $module['module_name'];?>_html #email").val())){	  
			$(this).next().html('<span class=fail><?php echo self::$language['email']?><?php echo self::$language['pattern_err']?></span>');
			$(this).focus();
			return false;
		}
		if($("#<?php echo $module['module_name'];?> #authcode").val()==''){
			
			$("#<?php echo $module['module_name'];?> .get_verification_code").next().html('<span class=fail><?php echo self::$language['is_null'];?></span>');
			
			$(this).focus();
			return false;
		}
		
		$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
		$.post('<?php echo $module['action_url'];?>&act=update',{email:$("#<?php echo $module['module_name'];?> #email").val(),authcode:$("#<?php echo $module['module_name'];?> #authcode").val()}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}				
			$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);		
			if(v.state=='success'){alert('<?php echo self::$language['success']?>');window.location.href='./index.php?monxin=index.user';return false;}
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
</script>
<style>
#<?php echo $module['module_name'];?>_html{padding-top:20px;}
#<?php echo $module['module_name'];?>_html .line{ line-height:60px;}
#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; width:30%; text-align:right; padding-right:10px;}
#<?php echo $module['module_name'];?>_html .line .value{ display:inline-block; width:60%; }
.get_verification_code{font-size:1rem; display:inline-block; width:102px; text-align:left;}
.get_verification_code img{vertical-align:middle;}
</style>
    <div id=<?php echo $module['module_name'];?>_html align="left">
	  <div class=line><span class="m_label"><?php echo self::$language['email'];?>：</span><span class=value><input  type="text" name="email" id="email" value="<?php echo $module['email']?>"  /> <span class=state></span></span></div>
	  
	  <div class=line><span class="m_label"><?php echo self::$language['authcode'];?>：</span><span class=value id="authcode_box"><input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" /> <span id=authcode_state></span> <a href=# class=get_verification_code><?php echo self::$language['get_verification_code']?></a> <span class=state></span></span></div>
			
	  <div class=line><span class="m_label">&nbsp;</span><span class=value><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    </div>
</div>