<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #talk_type").val($("#<?php echo $module['module_name'];?> #talk_type").attr('monxin_value'));
		$("#<?php echo $module['module_name'];?> #shop_c_password").val($("#<?php echo $module['module_name'];?> #shop_c_password").attr('monxin_value'));
		$("#<?php echo $module['module_name'];?> #barcode_repeat").val($("#<?php echo $module['module_name'];?> #barcode_repeat").attr('monxin_value'));
		$("#<?php echo $module['module_name'];?> #circle").val($("#<?php echo $module['module_name'];?> #circle").attr('monxin_value'));
		$('#icon_ele').insertBefore($('#icon_state'));
		$('#ticket_logo_ele').insertBefore($('#ticket_logo_state'));
		$('#certificate_ele').insertBefore($('#certificate_state'));
		$('#self_certificate_ele').insertBefore($('#self_certificate_state'));
		$('#wxkf_ele').insertBefore($('#wxkf_state'));
		$("#<?php echo $module['module_name'];?> #template").val($("#<?php echo $module['module_name'];?> #template").attr('monxin_value'));
		
		if(<?php echo $module['run_type_old']?>==0){
			$("#<?php echo $module['module_name'];?> #certificate").parent().parent().prev().html('<?php echo self::$language['certificate_0'];?>');
			$("#<?php echo $module['module_name'];?> #certificate_id").parent().prev().html('<?php echo self::$language['certificate_id_0'];?>');
		}else{
			$("#<?php echo $module['module_name'];?> #certificate").parent().prev().parent().html('<?php echo self::$language['certificate_1'];?>');
			$("#<?php echo $module['module_name'];?> #certificate_id").parent().prev().html('<?php echo self::$language['certificate_id_1'];?>');
		}
			
		
		
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
			set_iframe_position(600,400);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','http://<?php echo $module['map_api'];?>.monxin.com/get_point.php?id='+$(this).attr('id')+'&point='+$(this).val());
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?>_html .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			is_null=false;
			obj=new Object();
			$("#<?php echo $module['module_name'];?>_html input").each(function(index, element) {
				if($(this).attr('id')!='self_certificate_file' && $(this).attr('id')!='head' && $(this).attr('id')!='certificate_file' && $(this).attr('id')!='icon_file' && $(this).attr('id')!='ticket_logo_file' && $(this).attr('id')!='wxkf_file'){
					if($(this).prop('value')==''){
						if($(this).attr('id')=='certificate' || $(this).attr('id')=='self_certificate' || $(this).attr('id')=='icon' || $(this).attr('id')=='ticket_logo' || $(this).attr('id')=='wxkf'){
							//$(this).parent().parent().children('.state').html('<span class=fail><?php echo self::$language['is_null']?></span>');
						}else{
							$(this).parent().children('.state').html('<span class=fail><?php echo self::$language['is_null']?></span>');
							$(this).focus();
							//alert($(this).attr('id'));
							is_null=true; return false;	
						}
					}
					
					obj[$(this).attr('id')]=$(this).val();
				}
            });
			if(is_null){return false;}
			
			if($("#<?php echo $module['module_name'];?> #circle").val()==''){
				$("#<?php echo $module['module_name'];?> #circle").next('.state').html('<span class=fail><?php echo self::$language['please_select']?></span>');
				return false;	
			}
			obj['circle']=$("#<?php echo $module['module_name'];?>_html #circle").val();
			
			obj['barcode_repeat']=$("#<?php echo $module['module_name'];?>_html #barcode_repeat").val();
			obj['head']=$("#<?php echo $module['module_name'];?>_html #head").val();
			obj['main_business']=$("#<?php echo $module['module_name'];?>_html #main_business").val();
			obj['template']=$("#<?php echo $module['module_name'];?>_html #template").val();
			obj['talk_type']=$("#<?php echo $module['module_name'];?>_html #talk_type").val();
			obj['shop_c_password']=$("#<?php echo $module['module_name'];?>_html #shop_c_password").val();
			$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update',obj, function(data){
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
					//$("#<?php echo $module['module_name'];?>_html").html(v.info).css('text-align','center').css('line-height','100px');
				}
				
			});
			return false;	
		});
    });
	
    function set_area(id,v){
        $("#"+id).prop('value',v);
        //submit_hidden(id);	
    }
	function submit_hidden(input_id){
		$("#<?php echo $module['module_name'];?> ."+input_id+"_img").attr('src','./temp/'+$("#<?php echo $module['module_name'];?> #"+input_id).val());	
	}
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ }
    #<?php echo $module['module_name'];?>_html{ }
	#<?php echo $module['module_name'];?>_html .line{ line-height:50px;}
	#<?php echo $module['module_name'];?>_html .line a img{ height:100px; border:none;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; text-align:right; padding-right:1%; width:29%; }
	#<?php echo $module['module_name'];?>_html .line .input_span{ display:inline-block; vertical-align:top;  width:70%; }
	#<?php echo $module['module_name'];?>_html .line .input_span input{ width:50%;}
	#<?php echo $module['module_name'];?>_html .line .input_span textarea{ width:50%; height:100px;}
	#<?php echo $module['module_name'];?>_html #run_type_div input{ display:inline-block; vertical-align:top; margin-top:1rem;width:20px;}
	#<?php echo $module['module_name'];?>_html #run_type_div m_label{ margin-right:20px;}
	#<?php echo $module['module_name'];?>_html .certificate_div{}
	#<?php echo $module['module_name'];?>_html .icon_img{ height:50px;}
	#<?php echo $module['module_name'];?>_html .ticket_logo_img{ height:50px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
         <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
		</div>
    	<div class=line><span class=m_label><?php echo self::$language['headquarters'];?></span><span class=input_span><input type="text" id="head" name="head" value="<?php echo $module['head'];?>" placeholder="<?php echo self::$language['shop_head_nitice']?>"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['shop_name'];?></span><span class=input_span><input type="text" id="name" name="name" value="<?php echo $module['name'];?>"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['shop_domain'];?></span><span class=input_span><input type="text" id="domain" name="domain" value="<?php echo $module['domain'];?>"  style="width:150px; text-align:right;" />.<?php echo $module['host']?> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['shop_style'];?></span><span class=input_span><select id=template name=template monxin_value="<?php echo $module['template']?>"><?php echo $module['template_option']?></select> <span class=state></span></span></div>

    	<div class=line><span class=m_label><?php echo self::$language['shop_icon'];?></span><span class=input_span> <span class=state id=icon_state></span><a href="./program/mall/shop_icon/<?php echo $module['id']?>.png"  target="_blank"><img src="./program/mall/shop_icon/<?php echo $module['id']?>.png" class=icon_img /></a></span></div>

    	<div class=line><span class=m_label><?php echo self::$language['ticket_logo'];?></span><span class=input_span> <span class=state id=ticket_logo_state></span><a href="./program/mall/ticket_logo/<?php echo $module['id']?>.png"  target="_blank"><img src="./program/mall/ticket_logo/<?php echo $module['id']?>.png" class=ticket_logo_img /></a></span></div>

    	<div class=line><span class=m_label><?php echo self::$language['wxkf'];?></span><span class=input_span> <span class=state id=wxkf_state></span><a href="./program/mall/wxkf/<?php echo $module['id']?>.png"  target="_blank"><img src="./program/mall/wxkf/<?php echo $module['id']?>.png" class=wxkf_img /></a></span></div>

    	<div class=line><span class=m_label><?php echo self::$language['self_phone'];?></span><span class=input_span><input type="text" id="phone" name="phone" value="<?php echo $module['phone'];?>"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['self_email'];?></span><span class=input_span><input type="text" id="email" name="email" value="<?php echo $module['email'];?>" /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['main_business'];?></span><span class=input_span><textarea id="main_business" name="main_business"  ><?php echo $module['main_business'];?></textarea> <span class=state></span></span></div>
        
    <span id="home_area_state" ></span>
    	<div class=line><span class=m_label><?php echo self::$language['in_area'];?></span><span class=input_span><input type="hidden" id="area" name="area" value="<?php echo $module['area'];?>"  /> <script src="area_js.php?callback=set_area&input_id=area&id=<?php echo $module['area'];?>&output=select" id='area_area_js'></script> <span class=state id=area_state></span></span></div>
    	
    	<div class=line><span class=m_label><?php echo self::$language['circle'];?></span><span class=input_span><select id="circle" name="circle" monxin_value="<?php echo $module['circle']?>"><option value=""><?php echo self::$language['please_select']?></option><?php echo $module['circle_option']?></select> <span class=state></span></span></div>
    	
        
    	<div class=line><span class=m_label><?php echo self::$language['address_detail'];?></span><span class=input_span><input type="text" id="address" name="address" value="<?php echo $module['address'];?>"  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['in_position'];?></span><span class=input_span><input type="text" id="position" name="position" monxin_type="map" value="<?php echo $module['position'];?>"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['online_talk'];?></span><span class=input_span><select type="text" id="talk_type" name="talk_type" monxin_value="<?php echo $module['talk_type']?>" ><?php echo $module['talk_option']?></select> <input type="text" id="talk_account" name="talk_account" value="<?php echo $module['talk_account'];?>"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['advance_notice'];?></span><span class=input_span><input type="text" id="expiration" name="expiration" value="<?php echo $module['expiration'];?>"  /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['barcode_repeat'];?></span><span class=input_span><select id="barcode_repeat" name="barcode_repeat" monxin_value="<?php echo $module['barcode_repeat']?>"><option value="0"><?php echo self::$language['no']?></option><option value="1"><?php echo self::$language['yes']?></option></select> <span class=state></span></span></div>
    	
        <div class=line><span class=m_label><?php echo self::$language['shop_c_password'];?></span><span class=input_span><select id="shop_c_password" name="shop_c_password" monxin_value="<?php echo $module['shop_c_password']?>"><option value="0"><?php echo self::$language['no']?></option><option value="1"><?php echo self::$language['yes']?></option></select> <span class=state></span></span></div>
    	
        
    	<div class=line><span class=m_label>&nbsp;</span><span class=input_span><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    
   <fieldset id=web ><legend><?php echo self::$language['can_not_change'];?><?php echo self::$language['info'];?></legend>
    
    	<div class=line><span class=m_label><?php echo self::$language['shop_master'];?>(<?php echo self::$language['username']?>)</span><span class=input_span><?php echo $module['username'];?> <span class=state></span></span></div>
    	<div class=line id=run_type_div><span class=m_label><?php echo self::$language['run_type_name'];?></span><span class=input_span><?php echo $module['run_type'];?> <span class=state></span></span></div>
        <div class=certificate_div>
    	<div class=line><span class=m_label><?php echo self::$language['certificate_0'];?></span><span class=input_span> <span class=state id=certificate_state></span><a href=./program/mall/certificate/<?php echo $module['id']?>.png target="_blank"><img src="./program/mall/certificate/<?php echo $module['id']?>.png" class=certificate_img /></a></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['certificate_id_0'];?></span><span class=input_span><?php echo $module['certificate_id'];?> <span class=state></span></span></div>
		</div>
    	<div class=line><span class=m_label><?php echo self::$language['self_certificate'];?></span><span class=input_span> <span class=state id=self_certificate_state></span><a href="./program/mall/certificate/self_<?php echo $module['id']?>.png" target="_blank"><img src="./program/mall/certificate/self_<?php echo $module['id']?>.png" class=self_certificate_img /></a></span></div>
        
    	<div class=line><span class=m_label><?php echo self::$language['self_certificate_id'];?></span><span class=input_span><?php echo $module['self_certificate_id'];?> <span class=state></span></span></div>
        
    </fieldset>    
    </div>
</div>

