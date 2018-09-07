<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >

	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language'];?>&items=emoticons|image|media|insertfile"></script>
    <script>
    $(document).ready(function(){
		$('#icon_ele').insertBefore($('#icon_state'));
		
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
            if($(this).attr('monxin_value')){$(this).val($(this).attr('monxin_value'));}
        });
		$("#<?php echo $module['module_name'];?> monxin_radio").each(function(index, element) {
            if($(this).attr('monxin_value')){
				$("#"+$(this).attr('id')+' input[value="'+$(this).attr('monxin_value')+'"]').prop('checked',true);	
			}
        });
		$("#<?php echo $module['module_name'];?> monxin_checkbox").each(function(index, element) {
            if($(this).attr('monxin_value')){
				temp=$(this).attr('monxin_value').split('/');
				for(v in temp){
					$("#"+$(this).attr('id')+' input[value="'+temp[v]+'"]').prop('checked',true);	
				}
			}
        });
		$("monxin_radio input").click(function(){
			$(this).parent('monxin_radio').attr('value',$(this).val());	
		});
		
		$("monxin_radio .radio_text").click(function(){
			$(this).prev().prop('checked',true);
			$(this).parent('monxin_radio').attr('value',$(this).prev().val());	
		});
		
		$("monxin_checkbox input").click(function(){
			id=$(this).parent('monxin_checkbox').attr('id');
			v='';
			$("#"+id+" input").each(function(index, element) {
                if($(this).prop('checked')){v+=$(this).val()+'/';}
            });
			$("#"+id).attr('value',v);
		});
		
		$("monxin_checkbox .checkbox_text").click(function(){
			if($(this).prev().prop('checked')){$(this).prev().prop('checked',false);}else{$(this).prev().prop('checked',true);}
			
			id=$(this).parent('monxin_checkbox').attr('id');
			v='';
			$("#"+id+" input").each(function(index, element) {
                if($(this).prop('checked')){v+=$(this).val()+'/';}
            });
			$("#"+id).attr('value',v);
		});
		
		
		$("#<?php echo $module['module_name'];?>_html input").keydown(function(event){
			if(event.keyCode==13 && event.target.tagName!='TEXTAREA'){return exe_monxin_form_submit();}		  	
		});
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			exe_monxin_form_submit();
			return false;
		});
		
        $("input[type='radio']").css('border','none');
        $("input[type='checkbox']").css('border','none');
		$("#<?php echo $module['module_name'];?> #set_negotiable_checkbox").change(function(){
			if($(this).prop('checked')){
				$("#<?php echo $module['module_name'];?> #price").val('<?php echo self::$language['negotiable'];?>');	
			}else{
				$("#<?php echo $module['module_name'];?> #price").val('');
			}	
		});
		
		
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
			set_iframe_position($(window).width()-100,$(window).height()-20);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','http://<?php echo $module['map_api'];?>.monxin.com/get_point.php?id='+$(this).attr('id')+'&point='+$(this).val());
			return false;	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> .set',function(){
			set_iframe_position($(window).width()-100,$(window).height()-20);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
    });
    
	function exe_monxin_form_submit(){
		
			err=false;
			try{if(editor){editor.sync();}}catch(e){}
			$("#<?php echo $module['module_name'];?> span").each(function(index, element) {
                if($(this).html()=='<?php echo self::$language['is_null'];?>' || $(this).html()=='<?php echo self::$language['not_match'];?>' || $(this).html()=='<?php echo self::$language['exist_same'];?>'){$(this).html('');}
            });
			$("#<?php echo $module['module_name'];?> span[class='state']").each(function(index, element) {
               $(this).html('');
            });
			var obj=new Object();
			$(".monxin_input").each(function(index, element){
				if($(this)[0].tagName=='MONXIN_RADIO' || $(this)[0].tagName=='MONXIN_CHECKBOX'){
					if($(this).attr('value')==undefined || $(this).attr('value')==$(this).attr('placeholder')){$(this).attr('value','');}
					if( $(this).attr('value')=='' && $(this).attr('monxin_required')==='1'){$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['is_null'];?></span>');$(this).focus();$(document).scrollTop($(this).offset().top-100);
	err=true;return false;}
					if($(this).attr('check_reg')!=''  && $(this).attr('monxin_required')==='1'){
						temp=$(this).attr('check_reg');
	　　					if($(this).attr('value').match(eval(temp))==null){$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['not_match'];?></span>');$(this).focus();err=true;return false;}
					}
				   obj[$(this).attr('id')]=$(this).attr('value');
					
				}else{
					if($(this).prop('value')==undefined || $(this).prop('value')==$(this).attr('placeholder')){$(this).prop('value','');}
					if( $(this).prop('value')=='' && $(this).attr('monxin_required')==='1'){$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['is_null'];?></span>');$(this).focus();$(document).scrollTop($(this).offset().top-100);
	err=true;return false;}
					if($(this).attr('check_reg')!=''  && $(this).attr('monxin_required')==='1'){
						temp=$(this).attr('check_reg');
	　　					if($(this).prop('value').match(eval(temp))==null){$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['not_match'];?></span>');$(this).focus();err=true;return false;}
					}
				   obj[$(this).attr('id')]=$(this).prop('value');
				}
				
			   //alert($(this).attr('id'));
            });
			
			
			
			
			
			obj['icon']=$("#<?php echo $module['module_name'];?>  #icon").val();
			
			if(err){return false;}
			var phone_reg=/^(1)[0-9]{10}$/;
			var tel_reg=/^[0-9-]{6,13}$/;
			if(!phone_reg.test(obj['contact']) && !tel_reg.test(obj['contact'])){$("#contact_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['mobile_or_tel'];?></span>');$("#contact").focus();err=true;return false;}
			if(err){return false;}
			//return false;
			
			$("#<?php echo $module['module_name'];?> #submit").next('span').html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['executing']?>');
			$("#<?php echo $module['module_name'];?> #submit").css('display','none');
			$.post("<?php echo $module['action_url'];?>&act=add",obj,function(data){
				$("#<?php echo $module['module_name'];?> #submit").next('span').html('');
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				if(v.state=='fail'){
					$("#<?php echo $module['module_name'];?> #submit").css('display','inline-block');
					if(v.id){
						$("#"+v.id).focus();
						$("#"+v.id+'_state').html(v.info);	
					}else{
						$("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
					}
				}else{
					$("#<?php echo $module['module_name'];?>_html").css('text-align','center');
					$("#<?php echo $module['module_name'];?>_html").html(v.info);
				}
				$("body").scrollTop(0);
			});	
	}
        
    </script>
    <script src="./plugin/datePicker/index.php"></script>

	<style>
    #<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> #gender input{ height:13px;}
	#<?php echo $module['module_name'];?> #authcode_img{ height:30px;}
    #<?php echo $module['module_name'];?> div{ line-height:2rem;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; vertical-align:top; width:24%; text-align:right; overflow:hidden; padding-right:10px; opacity:0.6;}
	#<?php echo $module['module_name'];?> .m_label .required{color:red; }
    #<?php echo $module['module_name'];?> .input_span{ display:inline-block; width:75%; overflow:hidden;}
    #<?php echo $module['module_name'];?> legend{}
	#<?php echo $module['module_name'];?> monxin_radio input{  }
	#<?php echo $module['module_name'];?> monxin_radio .radio_text{ display:inline-block; vertical-align:top; margin-right:20px; cursor:default; }
	#<?php echo $module['module_name'];?> monxin_checkbox input{ }
	#<?php echo $module['module_name'];?> monxin_checkbox .checkbox_text{ display:inline-block; vertical-align:top; margin-right:20px; cursor:default; }
	#<?php echo $module['module_name'];?> #set_negotiable_checkbox{}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <div><span class=m_label><span class="required">*</span><?php echo self::$language['circle']?></span><span class=input_span><select id=circle monxin_required="1"  class="monxin_input"><option value=""><?php echo self::$language['please_select']?></option><?php echo $module['circle']?></select> <span id=circle_state class=state></span></span></div>
    <div><span class=m_label><span class="required">*</span><?php echo $module['title_label']?></span><span class=input_span><input type="text" id=title monxin_required="1" placeholder="<?php echo $module['title_placeholder']?>"  class="monxin_input"  style="width:60%;" /> <span id=title_state class=state></span></span></div>
    <div><span class=m_label><?php echo $module['icon_label']?></span><span class=input_span> <span id=icon_state class=state></span> </span></div>
    <?php echo $module['fields'];?>
    <div><span class=m_label><?php echo $module['content_label']?></span><span class=input_span><textarea name="content" id="content" style="display:none; width:99%; height:400px;"  class="monxin_input"><?php echo $module['content_placeholder']?></textarea> <span id=content_state class=state></span></span></div>
    <div><span class=m_label><span class="required">*</span><?php echo self::$language['linkman']?></span><span class=input_span><input type="text" id=linkman monxin_required="1" value="<?php echo $module['linkman']?>"  class="monxin_input"/> <span id=linkman_state class=state></span></span></div>
    <div><span class=m_label><span class="required">*</span><?php echo self::$language['contact']?></span><span class=input_span><input type="text" id=contact monxin_required="1" value="<?php echo $module['contact']?>" placeholder="<?php echo self::$language['mobile_or_tel'];?>"  class="monxin_input"/> <span id=contact_state class=state></span></span></div>
    <?php echo $module['authcode'];?>
    <div><span class=m_label>&nbsp;</span><span class=input_span><a href="#" id=submit class="submit"><?php echo self::$language['release_confirmed'];?></a> <span></span></span></div>    
    </div>
</div>
