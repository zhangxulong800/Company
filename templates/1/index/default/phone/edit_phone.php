<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
var remain_time;
var t1;
$(document).ready(function(){
	$(".phone_country option").each(function(index, element) {
		$(this).attr('old',$(this).html());
	});
	$(".phone_country").val($('.phone_country').attr('monxin_value'));
	$(".phone_country option[value='"+$(".phone_country").val()+"']").html('+'+$(".phone_country").val());
	$(".phone_country").change(function(){
		 reset_phone_country_option_html();
		$(".phone_country option[value='"+$(this).val()+"']").html('+'+$(this).val());
	});
	function reset_phone_country_option_html(){
		$(".phone_country option").each(function(index, element) {
			$(this).html($(this).attr('old'));
		});
	}
	
	
	if($("#<?php echo $module['module_name'];?> #phone").val()==''){
		document.title=document.title.replace(/<?php echo self::$language['modify']?>/,'<?php echo self::$language['perfecting']?>');	
		if($("#user_position .text").html()){
			$("#user_position .text").html($("#user_position .text").html().replace(/<?php echo self::$language['modify']?>/,'<?php echo self::$language['perfecting']?>'));
		}
	}
	$("#<?php echo $module['module_name'];?> .get_verification_code").click(function(){
		if($("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity')!=1){return false;}
		window.clearInterval(t1);
		$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',0.3);
		
		$.post('<?php echo $module['action_url'];?>&act=get_verification_code',{phone:$("#<?php echo $module['module_name'];?> #phone").val(),phone_country:$("#<?php echo $module['module_name'];?> #phone_country").val()}, function(data){
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
		if($("#<?php echo $module['module_name'];?> #authcode").val()==''){
			
			$("#<?php echo $module['module_name'];?> .get_verification_code").next().html('<span class=fail><?php echo self::$language['is_null'];?></span>');
			
			$(this).focus();
			return false;
		}
		
		$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
		$.post('<?php echo $module['action_url'];?>&act=update',{phone:$("#<?php echo $module['module_name'];?> #phone").val(),phone_country:$("#<?php echo $module['module_name'];?> #phone_country").val(),authcode:$("#<?php echo $module['module_name'];?> #authcode").val()}, function(data){
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

.phone_input_div{border: 1px solid #e4e4e4;border-radius: 3px;  line-height:30px; height:30px; display:inline-block; width:190px;}
.phone_input_div .phone_country_switch{ display:inline-block; vertical-align:top; width:50px; cursor:pointer;}
#<?php echo $module['module_name'];?>_html .phone_input_div #phone{ display:inline-block; vertical-align:top; width:120px; border:none; line-height:28px; height:28px;}
.phone_country{ width:60px; overflow:hidden; border:none;}
</style>
    <div id=<?php echo $module['module_name'];?>_html align="left">
	  <?php echo $module['phone_input'];?>
	  <div class=line><span class="m_label"><?php echo self::$language['authcode'];?>：</span><span class=value id="authcode_box"><input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" /> <span id=authcode_state></span> <a href=# class=get_verification_code><?php echo self::$language['get_verification_code']?></a> <span class=state></span></span></div>
			
	  <div class=line><span class="m_label">&nbsp;</span><span class=value><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    </div>
</div>