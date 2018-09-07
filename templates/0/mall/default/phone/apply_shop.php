<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
	var remain_time;
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #agent").blur(function(){
			if($(this).val()==''){return false;}
			$("#<?php echo $module['module_name'];?> #agent").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=check_agent',{agent:$("#<?php echo $module['module_name'];?> #agent").val()}, function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> #agent").next().html(v.info);
				
			});
		});
		
		$("#<?php echo $module['module_name'];?> .get_verification_code").click(function(){
			if($("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity')!=1){return false;}
			if($("#<?php echo $module['module_name'];?> #phone").val()==''){
				alert('<?php echo self::$language['self_phone'];?><?php echo self::$language['is_null'];?>');
				$("#<?php echo $module['module_name'];?> #phone").focus();
				return false;	
			}
			if(!$("#<?php echo $module['module_name'];?> #phone").val().match(<?php echo $module['phone_reg'];?>)){
				alert('<?php echo self::$language['self_phone'];?><?php echo self::$language['pattern_err'];?>');
				$("#<?php echo $module['module_name'];?> #phone").focus();
				return false;	
			}
			$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',0.3);
			$("#<?php echo $module['module_name'];?> .get_verification_code").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=get_verification_code',{phone:$("#<?php echo $module['module_name'];?> #phone").val()}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .get_verification_code").next().html(v.info);
				
				if(v.state=='fail'){
					$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',1);
				}else{
					$("#<?php echo $module['module_name'];?> .get_verification_code").html('<?php echo self::$language['recapture']?>(<b>60</b>)');
					remain_time=60;
					var t1 = window.setInterval(update_remain,1000);  

				}
				
			});
			return false;	
		});
		function update_remain(){
			if(remain_time==0){
				
				$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',1);
				$("#<?php echo $module['module_name'];?> .get_verification_code").html('<?php echo self::$language['recapture']?>');
				window.clearInterval(t1);
			}
			$("#<?php echo $module['module_name'];?> .get_verification_code b").html(remain_time--);	
		}
		
		$("#<?php echo $module['module_name'];?> #sms_verification_code").blur(function(){
			if($(this).val()==''){return false;}
			$("#<?php echo $module['module_name'];?> #sms_verification_code").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=check_verification_code',{verification_code:$("#<?php echo $module['module_name'];?> #sms_verification_code").val()}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> #sms_verification_code").next().html(v.info);
			});
		});
		
		
		$('#icon_ele').insertBefore($('#icon_state'));
		$('#certificate_ele').insertBefore($('#certificate_state'));
		$('#self_certificate_ele').insertBefore($('#self_certificate_state'));
		$('#ticket_logo_ele').insertBefore($('#ticket_logo_state'));
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			t=$("#monxin_iframe").attr('src');
			t=t.split('?id=');
			t=t[1].split('&');
			t=t[0];
			temp=getCookie('map_'+t);
			if(temp){
				$("#<?php echo $module['module_name'];?> #"+t).val(getCookie('map_'+t).replace(/%2C/g,','));
			}
			return false;
		});
		$("#<?php echo $module['module_name'];?> input[monxin_type='map']").focus(function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','http://<?php echo $module['map_api'];?>.monxin.com/get_point.php?id='+$(this).attr('id')+'&point='+$(this).val());
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?>_html input[name='run_type_radio']").change(function(){
			$("#<?php echo $module['module_name'];?>_html .certificate_div").css('display','block');
			//alert($(this).prop('value'));
			$("#<?php echo $module['module_name'];?> #run_type").val($(this).val());
			
			if($(this).prop('value')==0){
				$("#<?php echo $module['module_name'];?> #certificate").parent().parent().prev().html('<?php echo self::$language['certificate_0'];?>');
				$("#<?php echo $module['module_name'];?> #certificate_id").parent().prev().html('<?php echo self::$language['certificate_id_0'];?>');
			}else{
				$("#<?php echo $module['module_name'];?> #certificate").parent().parent().prev().html('<?php echo self::$language['certificate_1'];?>');
				$("#<?php echo $module['module_name'];?> #certificate_id").parent().prev().html('<?php echo self::$language['certificate_id_1'];?>');
			}
			
		});
		
		$("#<?php echo $module['module_name'];?>_html .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			is_null=false;
			obj=new Object();
			$("#<?php echo $module['module_name'];?>_html input").each(function(index, element) {
				if($(this).attr('id')!='self_certificate_file' && $(this).attr('id')!='certificate_file' && $(this).attr('id')!='icon_file' && $(this).attr('id')!='ticket_logo_file'){
					if($(this).prop('value')==''){
						if($(this).attr('id')=='certificate' || $(this).attr('id')=='self_certificate' || $(this).attr('id')=='icon' || $(this).attr('id')=='ticket_logo'){
							$(this).parent().parent().children('.state').html('<span class=fail><?php echo self::$language['is_null']?></span>');
						}else{
							$(this).parent().children('.state').html('<span class=fail><?php echo self::$language['is_null']?></span>');
						}
						$(this).focus();
						is_null=true; return false;	
					}
					//alert($(this).attr('id'));
					obj[$(this).attr('id')]=$(this).val();
				}
            });
			if(is_null){return false;}
			if($("#<?php echo $module['module_name'];?> #circle").val()==''){
				$("#<?php echo $module['module_name'];?> #circle").next('.state').html('<span class=fail><?php echo self::$language['please_select']?></span>');
				return false;	
			}
			obj['circle']=$("#<?php echo $module['module_name'];?>_html #circle").val();
			obj['main_business']=$("#<?php echo $module['module_name'];?>_html #main_business").val();
			
			$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?>_html .submit").next().html(v.info);
				
				if(v.state=='fail'){
					if(v.key){
						if(v.key=='certificate' || v.key=='self_certificate'){
							$("#<?php echo $module['module_name'];?>_html #"+v.key).parent().parent().children('.state').html(v.info);
						}else{
							$("#<?php echo $module['module_name'];?>_html #"+v.key).parent().children('.state').html(v.info);
						}
						$("#<?php echo $module['module_name'];?>_html #"+v.key).focus();
						$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=fail><?php echo self::$language['fail']?></span>');
					}
					
				}else{
					$("#<?php echo $module['module_name'];?>_html").html(v.info).css('text-align','center').css('line-height','100px');
				}
				
			});
			return false;	
		});
    });
	
    function set_area(id,v){
        $("#"+id).prop('value',v);
        //submit_hidden(id);	
    }
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .line{ line-height:50px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align: middle; text-align:right; padding-right:1%; width:29%; box-shadow:none; white-space:nowrap; font-size:0.8rem;}
	#<?php echo $module['module_name'];?>_html .line .input_span{ display:inline-block; vertical-align:top;  width:70%; }
	#<?php echo $module['module_name'];?>_html .line .input_span .radio{vertical-align: middle;}
	#<?php echo $module['module_name'];?>_html .line .input_span .radio span:first-child {vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .line .input_span input{ width:50%;}
	#<?php echo $module['module_name'];?>_html .line .input_span textarea{ width:50%; height:100px; font-size: 16px;line-height: 30px;}
	#<?php echo $module['module_name'];?>_html #run_type_div input{ display:inline-block;width:30px;}
	#<?php echo $module['module_name'];?>_html #run_type_div m_label{ margin-right:20px;}
	#<?php echo $module['module_name'];?>_html .certificate_div{ display:none;}
	#<?php echo $module['module_name'];?>_html .agent_notice{ }
    </style>
	
    <div id="<?php echo $module['module_name'];?>_html">

    	<div class=line><span class=m_label><?php echo self::$language['apply_shop_code'];?></span><span class=input_span><input type="text" id="agent" name="agent" value="<?php echo $module['agent']?>"  style="width:100px;" /> <span class=state></span> <span class=agent_notice><?php echo self::$language['in_paper_right_bottom']?></span></span></div>
    
    	<div class=line id=run_type_div><span class=m_label><?php echo self::$language['run_type_name'];?></span><span class=input_span><input type="hidden" id="run_type" name="run_type"  /> <input type="radio" name="run_type_radio" id="run_type_0" value="0" /><m_label for=run_type_0><?php echo self::$language['run_type'][0]?></m_label> <input type="radio" name="run_type_radio" id="run_type_1" value="1" /><m_label for=run_type_1><?php echo self::$language['run_type'][1]?></m_label> <span class=state></span></span></div>
        <div class=certificate_div>
    	<div class=line><span class=m_label><?php echo self::$language['certificate_0'];?></span><span class=input_span> <span class=state id=certificate_state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['certificate_id_0'];?></span><span class=input_span><input type="text" id="certificate_id" name="certificate_id"  /> <span class=state></span></span></div>
		</div>
    	<div class=line><span class=m_label><?php echo self::$language['shop_name'];?></span><span class=input_span><input type="text" id="name" name="name"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['shop_icon'];?></span><span class=input_span> <span class=state id=icon_state></span></span></div>

    	<div class=line><span class=m_label><?php echo self::$language['ticket_logo'];?></span><span class=input_span> <span class=state id=ticket_logo_state></span></span></div>


    	<div class=line><span class=m_label><?php echo self::$language['self_certificate'];?></span><span class=input_span> <span class=state id=self_certificate_state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['self_certificate_id'];?></span><span class=input_span><input type="text" id="self_certificate_id" name="self_certificate_id"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['self_phone'];?></span><span class=input_span><input type="text" id="phone" name="phone"  style="width:200px;" /> <span class=state></span></span></div>
        
    	<div class=line style="display:none;"><span class=m_label><?php echo self::$language['sms_verification_code'];?></span><span class=input_span><input type="text" id="sms_verification_code" name="sms_verification_code"  value="123"  style="width:100px;"  /> <span class=state></span> <a href=# class=get_verification_code><?php echo self::$language['get_verification_code']?></a> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['self_email'];?></span><span class=input_span><input type="text" id="email" name="email"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['main_business'];?></span><span class=input_span><textarea id="main_business" name="main_business"  ></textarea> <span class=state></span></span></div>
        
    <span id="home_area_state" ></span>
    	<div class=line><span class=m_label><?php echo self::$language['in_area'];?></span><span class=input_span><input type="hidden" id="area" name="area"  /> <script src="area_js.php?callback=set_area&input_id=area&id=0&output=select" id='area_area_js'></script> <span class=state id=area_state></span></span></div>
    	
    	<div class=line><span class=m_label><?php echo self::$language['circle'];?></span><span class=input_span><select id="circle" name="circle"><option value=""><?php echo self::$language['please_select']?></option><?php echo $module['circle']?></select> <span class=state></span></span></div>
    	
        <div class=line><span class=m_label><?php echo self::$language['address_detail'];?></span><span class=input_span><input type="text" id="address" name="address"  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['in_position'];?></span><span class=input_span><input type="text" id="position" name="position" monxin_type="map" /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['online_talk'];?></span><span class=input_span><select type="text" id="talk_type" name="talk_type" ><?php echo $module['talk_option']?></select> <input type="text" id="talk_account" name="talk_account" /> <span class=state></span></span></div>

    	<div class=line><span class=m_label>&nbsp;</span><span class=input_span><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    
    </div>
</div>

