<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$(".input_span input[type='checkbox']").css('height',13);
		$("#<?php echo $module['module_name'];?> #detail_show_method").val('<?php echo $module['detail_show_method'];?>');
		$("#<?php echo $module['module_name'];?> #sequence_field").val('<?php echo $module['sequence_field'];?>');
		$("#<?php echo $module['module_name'];?> #sequence_type").val('<?php echo $module['sequence_type'];?>');
		$("#<?php echo $module['module_name'];?> #target").val('<?php echo $module['target'];?>');
		if($("#<?php echo $module['module_name'];?> input[value='src']").prop('checked')){$("#<?php echo $module['module_name'];?> #image_height_div").css('display','block');}
		$("#<?php echo $module['module_name'];?> input[value='src']").click(function(){
			if($(this).prop('checked')){
				$("#<?php echo $module['module_name'];?> #image_height_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> #image_height_div").css('display','none');
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
			args+='|'+'image_height:'+check_module_size($("#<?php echo $module['module_name'];?> #image_height").val());
			args+='|'+'detail_show_method:'+$("#<?php echo $module['module_name'];?> #detail_show_method").val();
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
   	  <div><span class="m_label"><?php echo self::$language['detail_show_method']?></span><span class=input_span>
      		<select id="detail_show_method" name="detail_show_method" ><option value='show'><?php echo self::$language['detail_show_method_option']['show']?></option><option value='product'><?php echo self::$language['detail_show_method_option']['product']?></option></select> <span></span>
      		</span>
      </span></div> 
      
   	  <div id=image_height_div style="display:none" ><span class="m_label"><?php echo self::$language['image_height'];?></span><span class=input_span>
      		<input type="text" id="image_height" name="image_height" value="<?php echo $module['image_height'];?>" /> <span></span>
      </span></div> 
   	  <div><span class="m_label"><?php echo self::$language['sub_module_width'];?></span><span class=input_span>
      		<input type="text" id="sub_module_width" name="sub_module_width" value="<?php echo $module['sub_module_width'];?>" /> <span></span>
            </span>
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

