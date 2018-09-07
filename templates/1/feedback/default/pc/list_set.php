<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$(".input_span input[type='checkbox']").css('height',13);

		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			args='|'+'id:'+$("#<?php echo $module['module_name'];?> #id").val();
			
			field='';
			$("#<?php echo $module['module_name'];?> input[field='field']").each(function(index, element) {
                if($(this).prop('checked')){
					field+='/'+$(this).val();	
				}
            });
			field=field.replace(/\//,'');
			
			$("#<?php echo $module['module_name'];?> #filed_checkbox_state").html('');
			args+='|'+'field:'+field;	
			args+='|'+'quantity:'+check_quantity($("#<?php echo $module['module_name'];?> #quantity").val());
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
    #<?php echo $module['module_name'];?> #content{}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
   	  <div><span class="m_label"><?php echo self::$language['show_content'];?></span><span class=input_span>
      		<?php echo $module['field_checkbox'];?> <span id=filed_checkbox_state></span>
      </span></div> 

   	  <div><span class="m_label"><?php echo self::$language['the_maximum_number_of_display'];?></span><span class=input_span>
      		<input type="text" id="quantity" name="quantity" value="<?php echo $module['quantity'];?>" /> <span></span>
      		</span>
      </span></div> 
   	  <div><span class="m_label">&nbsp;</span><span class=input_span>
      		<a href="#" id=submit class="submit"><?php echo self::$language['submit'];?></a> <span></span>
      </span></div> 


    </div>
</div>

