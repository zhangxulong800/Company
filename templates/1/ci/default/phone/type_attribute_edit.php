<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		
		$("#<?php echo $module['module_name'];?> #input_type").val('<?php echo $module['data']['input_type'];?>');
		$("#<?php echo $module['module_name'];?> #set_reg").val('<?php echo $module['data']['reg'];?>');
		$("#<?php echo $module['module_name'];?> #unique").val('<?php echo $module['data']['unique'];?>');
		$("#<?php echo $module['module_name'];?> #search_able").val('<?php echo $module['data']['search_able'];?>');
		$("#<?php echo $module['module_name'];?> #required").val('<?php echo $module['data']['required'];?>');

			v=$("#input_type").val();
			$("#<?php echo $module['module_name'];?> #args_div #args_"+v).css('display','block');

			switch (v){
			   case 'text':
				  $("#text_length").val('<?php echo @$module['args']['text_length']?>');
				  $("#text_default_value").val('<?php echo @$module['args']['text_default_value']?>');
				  break;
			   case 'textarea':
				  $("#textarea_allow_html").val('<?php echo @$module['args']['textarea_allow_html']?>');
				  $("#textarea_width").val('<?php echo @$module['args']['textarea_width']?>');
				  $("#textarea_height").val('<?php echo @$module['args']['textarea_height']?>');
				  break;
			  case 'editor':
				  $("#editor_height").val('<?php echo @$module['args']['editor_height']?>');
				  $("#editor_default_value").val('<?php echo @$module['args']['editor_default_value']?>');
				  $("#editor_open_image_mark").val('<?php echo @$module['args']['editor_open_image_mark']?>');
				  break;
			  case 'select':
				  $("#select_option").val('<?php echo @$module['args']['select_option']?>');
				  $("#select_default_value").val('<?php echo @$module['args']['select_default_value']?>');
				  break;
			  case 'radio':
				  $("#radio_option").val('<?php echo @$module['args']['radio_option']?>');
				  $("#radio_default_value").val('<?php echo @$module['args']['radio_default_value']?>');
				  break;
			  case 'checkbox':
				  $("#checkbox_option").val('<?php echo @$module['args']['checkbox_option']?>');
				  $("#checkbox_default_value").val('<?php echo @$module['args']['checkbox_default_value']?>');
				  break;
			  case 'img':img_allow_image_type
				  $("#img_allow_image_type").val('<?php echo @$module['args']['img_allow_image_type']?>');
				  $("#img_open_image_mark").val('<?php echo @$module['args']['img_open_image_mark']?>');
				  $("#img_width").val('<?php echo @$module['args']['img_width']?>');
				  $("#img_height").val('<?php echo @$module['args']['img_height']?>');
				  break;
			  case 'imgs':
				  $("#imgs_allow_image_type").val('<?php echo @$module['args']['imgs_allow_image_type']?>');
				  $("#imgs_open_image_mark").val('<?php echo @$module['args']['imgs_open_image_mark']?>');
				  $("#imgs_width").val('<?php echo @$module['args']['imgs_width']?>');
				  $("#imgs_height").val('<?php echo @$module['args']['imgs_height']?>');
				  break;
			  case 'file':
				  $("#file_allow_file_type").val('<?php echo @$module['args']['file_allow_file_type']?>');
				  break;
			  case 'files':
				  $("#files_allow_file_type").val('<?php echo @$module['args']['files_allow_file_type']?>');
				  break;
			  case 'number':
				  $("#number_min").val('<?php echo @$module['args']['number_min']?>');
				  $("#number_max").val('<?php echo @$module['args']['number_max']?>');
				  $("#number_decimal_places").val('<?php echo @$module['args']['number_decimal_places']?>');
				  $("#number_default_value").val('<?php echo @$module['args']['number_default_value']?>');
				  break;
			  case 'time':
				  $("#time_style").val('<?php echo @$module['args']['time_style']?>');
				  break;
			  case 'map':
				  break;
			  case 'area':
				  break;
			}			
		
		$("#<?php echo $module['module_name'];?> #input_type").change(function(){
			$("#<?php echo $module['module_name'];?> #args_div .args").css('display','none');
			$("#<?php echo $module['module_name'];?> #args_div #args_"+$(this).val()).css('display','block');
				
		});
		
		$("#<?php echo $module['module_name'];?> #set_reg").change(function(){
			$("#<?php echo $module['module_name'];?> #reg").val($(this).val());	
		});
		
		
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			j_name=$("#<?php echo $module['module_name'];?> #name");	
			$("#<?php echo $module['module_name'];?> .input_span span").html('');
			if(j_name.val()==''){j_name.next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');j_name.focus(); return false;}			
			args='';
			v=$("#input_type").val();
			switch (v){
			   case 'text':
				  args+='|text_length:'+$("#text_length").val();
				  args+='|text_default_value:'+$("#text_default_value").val();
				  break;
			   case 'textarea':
				  args+='|textarea_allow_html:'+$("#textarea_allow_html").val();
				  args+='|textarea_default_value:'+$("#textarea_default_value").val();
				  args+='|textarea_width:'+$("#textarea_width").val();
				  args+='|textarea_height:'+$("#textarea_height").val();
				  break;
			  case 'editor':
				  args+='|editor_height:'+$("#editor_height").val();
				  args+='|editor_default_value:'+$("#editor_default_value").val();
				  args+='|editor_open_image_mark:'+$("#editor_open_image_mark").val();
				  break;
			  case 'select':
				  args+='|select_option:'+$("#select_option").val();
				  args+='|select_default_value:'+$("#select_default_value").val();
				  break;
			  case 'radio':
				  args+='|radio_option:'+$("#radio_option").val();
				  args+='|radio_default_value:'+$("#radio_default_value").val();
				  break;
			  case 'checkbox':
				  args+='|checkbox_option:'+$("#checkbox_option").val();
				  args+='|checkbox_default_value:'+$("#checkbox_default_value").val();
				  break;
			  case 'img':img_allow_image_type
				  args+='|img_allow_image_type:'+$("#img_allow_image_type").val();
				  args+='|img_open_image_mark:'+$("#img_open_image_mark").val();
				  args+='|img_width:'+$("#img_width").val();
				  args+='|img_height:'+$("#img_height").val();
				  break;
			  case 'imgs':
				  args+='|imgs_allow_image_type:'+$("#imgs_allow_image_type").val();
				  args+='|imgs_open_image_mark:'+$("#imgs_open_image_mark").val();
				  args+='|imgs_width:'+$("#imgs_width").val();
				  args+='|imgs_height:'+$("#imgs_height").val();
				  break;
			  case 'file':
				  args+='|file_allow_file_type:'+$("#file_allow_file_type").val();
				  break;
			  case 'files':
				  args+='|files_allow_file_type:'+$("#files_allow_file_type").val();
				  break;
			  case 'number':
				  args+='|number_min:'+$("#number_min").val();
				  args+='|number_max:'+$("#number_max").val();
				  args+='|number_decimal_places:'+$("#number_decimal_places").val();
				  args+='|number_default_value:'+$("#number_default_value").val();
				  break;
			  case 'time':
				  args+='|time_style:'+$("#time_style").val();
				  break;
			  case 'map':
				  break;
			  case 'area':
				  break;
			}			
			//alert(args);
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			$.post('<?php echo $module['action_url'];?>&act=update',{name: j_name.val(),placeholder:$("#placeholder").val(),required:$("#required").val(),unique:$("#unique").val(),search_able:$("#search_able").val(),reg:$("#reg").val(),input_type:$("#input_type").val(),postfix:$("#postfix").val(),args:args} ,function(data){
				//alert(data);	
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				if(v.id){
					$("#<?php echo $module['module_name'];?> #"+v.id).next('span').html(v.info);
					$("#<?php echo $module['module_name'];?> #"+v.id).focus();
					$("#<?php echo $module['module_name'];?> #submit").next('span').html('<span class=fail><?php echo self::$language['fail'];?></span>');	
				}else{
					$("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
				}
				
                if(v.state=='success'){
					//alert('<?php echo self::$language['success'];?>');
                	window.location.href='./index.php?monxin=ci.type_attribute&type=<?php echo @$_GET['type'];?>';
                }

			});	
			return false;
		});
	


    });
    

 </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html div{ line-height:60px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:150px; text-align:right; padding-right:10px;}
    #<?php echo $module['module_name'];?> .m_label .required_item{ }
	#<?php echo $module['module_name'];?> #args_div{ margin-left:100px;}
	#<?php echo $module['module_name'];?> #args_div .args{display:none;}
    #<?php echo $module['module_name'];?> .warning{background-image:url(<?php echo get_template_dir(__FILE__);?>img/warning.png); background-repeat:no-repeat; padding-left:100px; height:100px; line-height:100px; font-size:26px;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html>
    	<div><span class=m_label><span class=required_item>*</span><?php echo self::$language['attribute'];?><?php echo self::$language['name'];?></span><span class=input_span><input type="text" id="name" value="<?php echo $module['data']['name'];?>" /><span></span></span></div>
    	<div><span class=m_label><?php echo self::$language['type'];?></span><span class=input_span><select id="input_type">
        <?php echo $module['field_type'];?>
        </select><span></span> </span>
        <div id=args_div>
        	<div id=args_text class=args>
    			<div><span class=m_label><?php echo self::$language['max_length'];?></span><span class=input_span><input type="text" id="text_length" /><span></span></span></div>               
            	<div><span class=m_label><?php echo self::$language['default_value'];?></span><span class=input_span><input type="text" id="text_default_value" /><span></span></span></div>
            </div>
            
        	<div id=args_textarea class=args>
    			<div><span class=m_label><?php echo self::$language['module_width'];?></span><span class=input_span><input type="text" id="textarea_width" /><span></span></span></div>               
    			<div><span class=m_label><?php echo self::$language['module_height'];?></span><span class=input_span><input type="text" id="textarea_height" /><span></span></span></div>               
            	<div><span class=m_label><?php echo self::$language['default_value'];?></span><span class=input_span><textarea id="textarea_default_value" ><?php echo @$module['args']['textarea_default_value']?></textarea><span></span></span></div>
            	<div><span class=m_label><?php echo self::$language['field_args']['allow_html'];?></span><span class=input_span><select id=textarea_allow_html ><option value="0"><?php echo self::$language['no'];?></option><option value="1"><?php echo self::$language['yes'];?></option></select><span></span></span></div>
            </div>
            
        	<div id=args_editor class=args>
    			<div><span class=m_label><?php echo self::$language['module_height'];?></span><span class=input_span><input type="text" id="editor_height" /><span></span></span></div>               
            	<div><span class=m_label><?php echo self::$language['default_value'];?></span><span class=input_span><textarea id="editor_default_value" ></textarea><span></span></span></div>
            	<div><span class=m_label><?php echo self::$language['open_image_mark'];?></span><span class=input_span><select id=editor_open_image_mark ><option value="0"><?php echo self::$language['no'];?></option><option value="1"><?php echo self::$language['yes'];?></option></select><span></span></span></div>

            </div>
            
        	<div id=args_select class=args>
    			<div><span class=m_label><?php echo self::$language['field_args']['option_list'];?></span><span class=input_span><textarea id="select_option" ><?php echo self::$language['field_args']['option_list_demo'];?></textarea><span></span></span></div>               
            	<div><span class=m_label><?php echo self::$language['default_value'];?></span><span class=input_span><input type="text" id="select_default_value" /><span></span></span></div>
            </div>
            
        	<div id=args_radio class=args>
    			<div><span class=m_label><?php echo self::$language['field_args']['option_list'];?><br /></span><span class=input_span><textarea id="radio_option" ><?php echo self::$language['field_args']['option_list_demo'];?></textarea><span></span></span></div>               
            	<div><span class=m_label><?php echo self::$language['default_value'];?></span><span class=input_span><input type="text" id="radio_default_value" /><span></span></span></div>
            </div>
            
        	<div id=args_checkbox class=args>
    			<div><span class=m_label><?php echo self::$language['field_args']['option_list'];?></span><span class=input_span><textarea id="checkbox_option" ><?php echo self::$language['field_args']['option_list_demo'];?></textarea><span></span></span></div>               
            	<div><span class=m_label><?php echo self::$language['default_value'];?></span><span class=input_span><input type="text" id="checkbox_default_value" /><span></span></span></div>
            </div>
            
        	<div id=args_img class=args>
            	<div><span class=m_label><?php echo self::$language['field_args']['allow_image_type'];?></span><span class=input_span><input type="text" id="img_allow_image_type" value="jpg,png,gif" /><span></span></span></div>
            	<div><span class=m_label><?php echo self::$language['open_image_mark'];?></span><span class=input_span><select id=img_open_image_mark ><option value="0"><?php echo self::$language['no'];?></option><option value="1"><?php echo self::$language['yes'];?></option></select><span></span></span></div>
    			<div><span class=m_label><?php echo self::$language['thumb'];?><?php echo self::$language['module_width'];?></span><span class=input_span><input type="text" id="img_width" /><span></span></span></div>               
    			<div><span class=m_label><?php echo self::$language['thumb'];?><?php echo self::$language['module_height'];?></span><span class=input_span><input type="text" id="img_height" /><span></span></span></div>               
            </div>
            
        	<div id=args_imgs class=args>
            	<div><span class=m_label><?php echo self::$language['field_args']['allow_image_type'];?></span><span class=input_span><input type="text" id="imgs_allow_image_type" value="jpg,png,gif" /><span></span></span></div>
            	<div><span class=m_label><?php echo self::$language['open_image_mark'];?></span><span class=input_span><select id=imgs_open_image_mark ><option value="0"><?php echo self::$language['no'];?></option><option value="1"><?php echo self::$language['yes'];?></option></select><span></span></span></div>
    			<div><span class=m_label><?php echo self::$language['thumb'];?><?php echo self::$language['module_width'];?></span><span class=input_span><input type="text" id="imgs_width" /><span></span></span></div>               
    			<div><span class=m_label><?php echo self::$language['thumb'];?><?php echo self::$language['module_height'];?></span><span class=input_span><input type="text" id="imgs_height" /><span></span></span></div>               
            </div>
            
        	<div id=args_file class=args>
            	<div><span class=m_label><?php echo self::$language['field_args']['allow_file_type'];?></span><span class=input_span><input type="text" id="file_allow_file_type" value="rar,zip,doc,docx" /><span></span></span></div>
            </div>
            
        	<div id=args_files class=args>
            	<div><span class=m_label><?php echo self::$language['field_args']['allow_file_type'];?></span><span class=input_span><input type="text" id="files_allow_file_type" value="rar,zip,doc,docx" /><span></span></span></div>
            </div>
            
        	<div id=args_number class=args>
    			<div><span class=m_label><?php echo self::$language['field_args']['the_range'];?></span><span class=input_span><input type="text" id="number_min" value="0" />-<input type="text" id="number_max" /><span></span></span></div>    
            	<div><span class=m_label><?php echo self::$language['field_args']['decimal_places'];?></span><span class=input_span><select id=number_decimal_places><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select><span></span></span></div>
            	<div><span class=m_label><?php echo self::$language['default_value'];?></span><span class=input_span><input type="text" id="number_default_value" /><span></span></span></div>
            </div>
            
        	<div id=args_time class=args>
            	<div><span class=m_label><?php echo self::$language['field_args']['time_style'];?></span><span class=input_span><select id=time_style><option value="Y-m-d"><?php echo self::$language['field_args']['date'];?></option><option value="Y-m-d H:i:s"><?php echo self::$language['field_args']['date_time'];?></option></select><span></span></span></div>
            </div>
            
            
        </div>       
        </div>      

    	<div><span class=m_label><?php echo self::$language['attribute_postfix'];?></span><span class=input_span><input type="text" id="postfix" value="<?php echo $module['data']['postfix'];?>" placeholder="<?php echo self::$language['optional'];?> <?php echo self::$language['example']?>㎡、㎞、㎏、元"  /><span></span></span></div>     
         
    	<div><span class=m_label><?php echo self::$language['field_hint'];?></span><span class=input_span><input type="text" id="placeholder" value="<?php echo $module['data']['placeholder'];?>" /><span></span></span></div>     
                  
                  
    	<div><span class=m_label><?php echo self::$language['check_reg'];?></span><span class=input_span><input type="text" id="reg" value="<?php echo $module['data']['reg'];?>" /><span></span> <select id=set_reg>
        	<option value=""><?php echo self::$language['diy'];?></option>
        	<option value="/^[0-9.-]+$/"><?php echo self::$language['reg_language']['decimal'];?></option>
        	<option value="/^[0-9-]+$/"><?php echo self::$language['reg_language']['integer'];?></option>
        	<option value="/^[a-z]+$/i"><?php echo self::$language['reg_language']['letter'];?></option>
        	<option value="/^[0-9a-z]+$/i"><?php echo self::$language['reg_language']['latter_decimal'];?></option>
        	<option value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/"><?php echo self::$language['reg_language']['e_mail'];?></option>
        	<option value="/^[0-9]{5,20}$/"><?php echo self::$language['reg_language']['qq'];?></option>
        	<option value="/^http:\/\//"><?php echo self::$language['reg_language']['url'];?></option>
        	<option value="/^(1)[0-9]{10}$/"><?php echo self::$language['reg_language']['phone_number'];?></option>
        	<option value="/^[0-9-]{6,13}$/"><?php echo self::$language['reg_language']['tel_number'];?></option>
        	<option value="/^[0-9]{6}$/"><?php echo self::$language['reg_language']['post_number'];?></option>
        </select></span></div>               
    	<div><span class=m_label><?php echo self::$language['unique'];?></span><span class=input_span><select id=unique ><option value="0"><?php echo self::$language['no'];?></option><option value="1"><?php echo self::$language['yes'];?></option></select><span></span></span></div>               
    	<div><span class=m_label><?php echo self::$language['required'];?></span><span class=input_span><select id=required ><option value="0"><?php echo self::$language['no'];?></option><option value="1"><?php echo self::$language['yes'];?></option></select><span></span></span></div>               
    	<div><span class=m_label><?php echo self::$language['search_able'];?></span><span class=input_span><select id=search_able ><option value="1"><?php echo self::$language['yes'];?></option><option value="0"><?php echo self::$language['no'];?></option></select><span></span></span></div>               
   	  <div><span class="m_label">&nbsp;</span><span >
      		<a href="#" id=submit class="submit"><?php echo self::$language['submit'];?></a> <span></span>
      </span></div> 

    </div>
</div>
