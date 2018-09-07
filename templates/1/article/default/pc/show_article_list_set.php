<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$(".input_span input[type='checkbox']").css('height',13);
		$("#<?php echo $module['module_name'];?> #sequence_field").val('<?php echo $module['sequence_field'];?>');
		$("#<?php echo $module['module_name'];?> #sequence_type").val('<?php echo $module['sequence_type'];?>');
		$("#<?php echo $module['module_name'];?> #target").val('<?php echo $module['target'];?>');
		if($("#<?php echo $module['module_name'];?> input[value='content']").prop('checked')){$("#<?php echo $module['module_name'];?> #content_length_div").css('display','block');}
		$("#<?php echo $module['module_name'];?> input[value='content']").click(function(){
			if($(this).prop('checked')){
				$("#<?php echo $module['module_name'];?> #content_length_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> #content_length_div").css('display','none');
			}	
		});

		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			field='';
			args='';
			$("#<?php echo $module['module_name'];?> input[field='field']").each(function(index, element) {
                if($(this).prop('checked')){
					field+='/'+$(this).val();	
				}
            });
			field=field.replace(/\//,'');
			
			if(field==''){$("#<?php echo $module['module_name'];?> #filed_checkbox_state").html('<span class=fail><?php echo self::$language['please_select'];?></span>'); return false;}
			$("#<?php echo $module['module_name'];?> #filed_checkbox_state").html('');
			args+='|'+'field:'+field;
			
			args+='|'+'sequence_field:'+$("#<?php echo $module['module_name'];?> #sequence_field").val();
			args+='|'+'sequence_type:'+$("#<?php echo $module['module_name'];?> #sequence_type").val();
			args+='|'+'quantity:'+check_quantity($("#<?php echo $module['module_name'];?> #quantity").val());
			args+='|'+'target:'+$("#<?php echo $module['module_name'];?> #target").val();
			args+='|'+'sub_module_width:'+check_module_size($("#<?php echo $module['module_name'];?> #sub_module_width").val());
			args+='|'+'content_length:'+check_quantity($("#<?php echo $module['module_name'];?> #content_length").val());
			
			args=args.replace(/\|/,'');
			
			url='<?php echo $module['action_url'];?>('+args+')';
			//return false;
			//alert(url);
			
			
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			$.get(url,function(data){
				//alert(data);	
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
                if(v.state=='success'){
					alert('<?php echo self::$language['success'];?>');
                	window.location.href='./index.php?monxin='+get_param('url')+'&edit_page_layout=true&id='+get_param('id');
                }

			});	
		});
		
	});
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px;}
    #<?php echo $module['module_name'];?>_html div{ line-height:60px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:150px; text-align:right; padding-right:10px;}
	#search_span{ display:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">

   	  <div><span class="m_label"><?php echo self::$language['show_content'];?></span><span class=input_span>
      		<?php echo $module['field_checkbox'];?> <span id=filed_checkbox_state></span>
      </span></div> 
   	  <div id=content_length_div style="display:none" ><span class="m_label"><?php echo self::$language['content_length'];?></span><span class=input_span>
      		<input type="text" id="content_length" name="content_length" value="<?php echo $module['content_length'];?>" /> <span></span>
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['sub_module_width'];?></span><span class=input_span>
      		<input type="text" id="sub_module_width" name="sub_module_width" value="<?php echo $module['sub_module_width'];?>" /> <span></span>
      </div>
   	  <div><span class="m_label"><?php echo self::$language['the_maximum_number_of_display'];?></span><span class=input_span>
      		<input type="text" id="quantity" name="quantity" value="<?php echo $module['quantity'];?>" /> <span></span>
      		</span>
      </span></div> 

   	  <div><span class="m_label"><?php echo self::$language['sequence_for'];?></span><span class=input_span>
      		<select id="sequence_field" name="sequence_field"><?php echo $module['sequence_field_option'];?></select> <select id="sequence_type" name="sequence_type" value="<?php echo $module['sequence_type'];?>"><?php echo $module['sequence_field_type'];?></select> <span></span>
      		</span>
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['target'];?></span><span class=input_span>
      		<select id="target" name="target"><?php echo $module['target_option'];?></select><span></span>
      		</span>
      </span></div> 
      
   	  <div><span class="m_label">&nbsp;</span><span class=input_span>
      		<a href="#" id=submit class="submit"><?php echo self::$language['submit'];?></a> <span></span>
      </span></div> 


    </div>
</div>

