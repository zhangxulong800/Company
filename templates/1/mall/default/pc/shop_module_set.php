<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$('#img_file_ele').insertBefore($('#img'));
		
		$(".input_span input[type='checkbox']").css('height',13);
		j_store_tag='<?php echo $module['store_tag']?>';
		if(j_store_tag!=''){
			temp=j_store_tag.split('/');
			for(v in temp){
				$("#<?php echo $module['module_name'];?> #store_tag_"+temp[v]).prop('checked',true);
			}	
		}
		$("#<?php echo $module['module_name'];?> #circle").val('<?php echo $module['circle'];?>');
		$("#<?php echo $module['module_name'];?> #sequence_field").val('<?php echo $module['sequence_field'];?>');
		$("#<?php echo $module['module_name'];?> #sequence_type").val('<?php echo $module['sequence_type'];?>');
		$("#<?php echo $module['module_name'];?> #target").val('<?php echo $module['target'];?>');
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			args='';
			
			
			store_tag='';
			$("#<?php echo $module['module_name'];?> #store_tags_div input").each(function(index, element) {
                if($(this).prop('checked')){
					store_tag+='/'+$(this).val();	
				}
            });
			store_tag=store_tag.replace(/\//,'');
			args+='|'+'store_tag:'+store_tag;
			
			if($("#<?php echo $module['module_name'];?> #width").val()==''){$("#<?php echo $module['module_name'];?> #width").next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');$("#<?php echo $module['module_name'];?> #width").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #width").next('span').html('')
			args+='|'+'width:'+check_module_size($("#<?php echo $module['module_name'];?> #width").val());
			
			if($("#<?php echo $module['module_name'];?> #height").val()==''){$("#<?php echo $module['module_name'];?> #height").next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');$("#<?php echo $module['module_name'];?> #height").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #height").next('span').html('');
			
			args+='|'+'height:'+check_module_size($("#<?php echo $module['module_name'];?> #height").val());
			args+='|'+'module_diy:'+$("#<?php echo $module['module_name'];?> #module_diy").val();
			args+='|'+'circle:'+$("#<?php echo $module['module_name'];?> #circle").val();
			args+='|'+'sequence_field:'+$("#<?php echo $module['module_name'];?> #sequence_field").val();
			args+='|'+'sequence_type:'+$("#<?php echo $module['module_name'];?> #sequence_type").val();
			args+='|'+'quantity:'+check_quantity($("#<?php echo $module['module_name'];?> #quantity").val());
			args+='|'+'target:'+$("#<?php echo $module['module_name'];?> #target").val();
			args+='|'+'title:'+$("#<?php echo $module['module_name'];?> #title").val();
			args=args.replace(/\|/,'');
			
			url='<?php echo $module['action_url'];?>('+args+')';
			//return false;
			//alert(url);
			
			
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			$.get('<?php echo $module['action_url_img'];?>&act=update_img&old_img='+$("#<?php echo $module['module_name'];?> #img").attr('old_value')+'&new_img='+$("#<?php echo $module['module_name'];?> #img").val(),function(data){});
			$.get(url,function(data){
				//alert(data);	
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
                if(v.state=='success'){
					alert('<?php echo self::$language['success'];?>');
                	window.location.href='./index.php?monxin='+get_param('url')+'&edit_page_layout=true&id='+get_param('id');
                }

			});	
			return false;
		});
		
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .del",function(){
			$("#<?php echo $module['module_name'];?> #img").val('');
			$(this).prev().css('display','none');
			$(this).css('display','none');
			return false;
		});
	});
	
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px;}
	#<?php echo $module['module_name'];?>_html input { }
	#<?php echo $module['module_name'];?>_html #img_file_ele{}
	#<?php echo $module['module_name'];?>_html .show_img{ vertical-align:top; }
    #<?php echo $module['module_name'];?>_html .show_img img{ border:none;  height:100px;}
    #<?php echo $module['module_name'];?>_html .del{vertical-align:top; }
    #<?php echo $module['module_name'];?>_html div{ line-height:60px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; vertical-align: middle;box-shadow: none; width:300px; text-align:right; padding-right:10px;}
    #<?php echo $module['module_name'];?> #content{}
	#<?php echo $module['module_name'];?>  #id{ width:300px;}
	#<?php echo $module['module_name'];?>  #width{ width:80px; margin-left:10px; margin-right:15px;}
	#<?php echo $module['module_name'];?>  #height{ width:80px; margin-left:10px;}
	#<?php echo $module['module_name'];?>  #search{ margin-right:10px;}
	#search_span{ display:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">


   	  <div><span class="m_label"><?php echo self::$language['module'];?><?php echo self::$language['title'];?></span><span class=input_span>
      		<input type="text" id="title" name="title" value="<?php echo $module['title'];?>" /> <span></span>
      		</span>
      </span></div> 
    
   	  <div><span class="m_label"><?php echo self::$language['module_diy_attribute'];?></span><span class=input_span>
      		<input type="text" id="module_diy" name="module_diy" value="<?php echo @$module['module_diy'];?>" /> <span></span>
      		</span>
      </span></div> 
    
    
   	  <div><span class="m_label"><?php echo self::$language['module_size'];?></span><span class=input_span>
      		<span class=width_label><?php echo self::$language['module_width'];?></span><input type="text" id="width" name="width" value="<?php echo $module['width'];?>" /> <span></span>
      		<span class=height_label><?php echo self::$language['module_height'];?></span><input type="text" id="height" name="height" value="<?php echo $module['height'];?>" /> <span></span>
      </span></div> 
      
      
   	  <div><span class="m_label"><?php echo self::$language['shop_filter'];?> <?php echo self::$language['tag'];?></span><span class=input_span id=store_tags_div>
      		<?php echo $module['store_tags'];?> <span id=store_tags_state></span>
      </span></div> 
   	  <div><span class="m_label"><?php echo self::$language['shop_filter'];?> <?php echo self::$language['circle'];?></span><span class=input_span>
      		<select id="circle" name="circle"><option value="0"><?php echo self::$language['all'];?></option><?php echo $module['circle_option'];?></select> <span></span> 
      </span></div> 
      

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

