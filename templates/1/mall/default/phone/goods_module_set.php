<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$('#img_file_ele').insertBefore($('#img'));
		
		$(".input_span input[type='checkbox']").css('height',13);
		j_tag='<?php echo $module['tag']?>';
		if(j_tag!=''){
			temp=j_tag.split('/');
			for(v in temp){
				$("#<?php echo $module['module_name'];?> #tag_"+temp[v]).prop('checked',true);
			}	
		}
		j_store_tag='<?php echo $module['store_tag']?>';
		if(j_store_tag!=''){
			temp=j_store_tag.split('/');
			for(v in temp){
				$("#<?php echo $module['module_name'];?> #store_tag_"+temp[v]).prop('checked',true);
			}	
		}
		$("#<?php echo $module['module_name'];?> #scroll").val('<?php echo @$module['scroll'];?>');
		$("#<?php echo $module['module_name'];?> #id").val('<?php echo $module['id'];?>');
		$("#<?php echo $module['module_name'];?> #first").val('<?php echo $module['first'];?>');
		$("#<?php echo $module['module_name'];?> #show_sold_satisfaction").val('<?php echo $module['show_sold_satisfaction'];?>');
		$("#<?php echo $module['module_name'];?> #sequence_field").val('<?php echo $module['sequence_field'];?>');
		$("#<?php echo $module['module_name'];?> #sequence_type").val('<?php echo $module['sequence_type'];?>');
		$("#<?php echo $module['module_name'];?> #show_method").val('<?php echo $module['show_method'];?>');
		$("#<?php echo $module['module_name'];?> #target").val('<?php echo $module['target'];?>');
		$("#<?php echo $module['module_name'];?> #pc_buy_button").val('<?php echo @$module['pc_buy_button'];?>');
		$("#<?php echo $module['module_name'];?> #phone_buy_button").val('<?php echo @$module['phone_buy_button'];?>');
		$("#<?php echo $module['module_name'];?> #follow_type").val('<?php echo $module['follow_type'];?>');
		$("#<?php echo $module['module_name'];?> #follow_page").val('<?php echo $module['follow_page'];?>');
		
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			args='|'+'id:'+$("#<?php echo $module['module_name'];?> #id").val();
			field='';
			$("#<?php echo $module['module_name'];?> input[field='field']").each(function(index, element) {
                if($(this).prop('checked')){
					field+='/'+$(this).val();	
				}
            });
			field=field.replace(/\//,'');
			args+='|'+'field:'+field;
			
			tag='';
			$("#<?php echo $module['module_name'];?> #tags_div input").each(function(index, element) {
                if($(this).prop('checked')){
					tag+='/'+$(this).val();	
				}
            });
			tag=tag.replace(/\//,'');
			
			
			store_tag='';
			$("#<?php echo $module['module_name'];?> #store_tags_div input").each(function(index, element) {
                if($(this).prop('checked')){
					store_tag+='/'+$(this).val();	
				}
            });
			store_tag=store_tag.replace(/\//,'');
			
			$("#<?php echo $module['module_name'];?> #tags_state").html('');
			args+='|'+'tag:'+tag;
			args+='|'+'store_tag:'+store_tag;
			
			if($("#<?php echo $module['module_name'];?> #width").val()==''){$("#<?php echo $module['module_name'];?> #width").next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');$("#<?php echo $module['module_name'];?> #width").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #width").next('span').html('')
			args+='|'+'width:'+check_module_size($("#<?php echo $module['module_name'];?> #width").val());
			
			if($("#<?php echo $module['module_name'];?> #height").val()==''){$("#<?php echo $module['module_name'];?> #height").next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');$("#<?php echo $module['module_name'];?> #height").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #height").next('span').html('');
			args+='|'+'height:'+check_module_size($("#<?php echo $module['module_name'];?> #height").val());
			args+='|'+'first:'+$("#<?php echo $module['module_name'];?> #first").val();
			args+='|'+'module_diy:'+$("#<?php echo $module['module_name'];?> #module_diy").val();
			args+='|'+'show_sold_satisfaction:'+$("#<?php echo $module['module_name'];?> #show_sold_satisfaction").val();
			args+='|'+'sequence_field:'+$("#<?php echo $module['module_name'];?> #sequence_field").val();
			args+='|'+'sequence_type:'+$("#<?php echo $module['module_name'];?> #sequence_type").val();
			args+='|'+'quantity:'+check_quantity($("#<?php echo $module['module_name'];?> #quantity").val());
			args+='|'+'show_method:'+$("#<?php echo $module['module_name'];?> #show_method").val();
			args+='|'+'target:'+$("#<?php echo $module['module_name'];?> #target").val();
			args+='|'+'pc_buy_button:'+$("#<?php echo $module['module_name'];?> #pc_buy_button").val();
			args+='|'+'phone_buy_button:'+$("#<?php echo $module['module_name'];?> #phone_buy_button").val();
			args+='|'+'title:'+$("#<?php echo $module['module_name'];?> #title").val();
			args+='|'+'show_sub:'+$("#<?php echo $module['module_name'];?> #show_sub").val();
			args+='|'+'img:'+$("#<?php echo $module['module_name'];?> #img").val().replace(/\./g,'*');
			args+='|'+'img_link:'+$("#<?php echo $module['module_name'];?> #img_link").val().replace(/\./g,'*').replace(/:/g,'!').replace(/#/g,'').replace(/&/g,'andand');
			args+='|'+'img_width:'+$("#<?php echo $module['module_name'];?> #img_width").val();
			args+='|'+'follow_type:'+$("#<?php echo $module['module_name'];?> #follow_type").val();
			args+='|'+'follow_page:'+$("#<?php echo $module['module_name'];?> #follow_page").val();
			args+='|'+'scroll:'+$("#<?php echo $module['module_name'];?> #scroll").val();
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
	
	function submit_hidden(id){
		
		$("#<?php echo $module['module_name'];?> #img").val($("#<?php echo $module['module_name'];?> #"+id).val());
		if($("#<?php echo $module['module_name'];?> .show_img").html()){
			$("#<?php echo $module['module_name'];?> .show_img img").attr('src','./temp/'+$("#<?php echo $module['module_name'];?> #"+id).val());
			$("#<?php echo $module['module_name'];?> .show_img").css('display','inline-block');
			$("#<?php echo $module['module_name'];?> .show_img").next().css('display','inline-block');
			
		}else{
			
			$("<a href='./temp/"+$("#<?php echo $module['module_name'];?> #"+id).val()+"' target=_blank class=show_img><img src='./temp/"+$("#<?php echo $module['module_name'];?> #"+id).val()+"' ></a> <a href=# class=del><?php echo self::$language['del'];?></a>").insertAfter("#<?php echo $module['module_name'];?> #img_file_ele");
		}	
	}
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px; padding-left:10px;}
	#<?php echo $module['module_name'];?>_html .m_label{ display:block; text-align:left;}
	#<?php echo $module['module_name'];?>_html .input_span{ display:block; border-bottom:#CCC 1px dashed; margin-bottom:0.5rem; padding-bottom:0.5rem;}
	#<?php echo $module['module_name'];?>_html input { }
	#<?php echo $module['module_name'];?>_html #img_file_ele{}
	#<?php echo $module['module_name'];?>_html .show_img{ vertical-align:top; }
    #<?php echo $module['module_name'];?>_html .show_img img{ border:none;  height:100px;}
    #<?php echo $module['module_name'];?>_html .del{vertical-align:top; }
    #<?php echo $module['module_name'];?>_html div{ line-height:2rem;}
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
      
   	  <div><span class="m_label"><?php echo self::$language['append'];?></span><span class=input_span>
      		<?php echo $module['field_checkbox'];?> <span id=filed_checkbox_state></span>
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['show_sub_type'];?></span><span class=input_span>
      		<input type="text" id="show_sub" name="show_sub" value="<?php echo $module['show_sub'];?>" /> <span></span><span></span>
      		</span>
      </span></div> 

   	  <div><span class="m_label"><?php echo self::$language['module_cover_image'];?></span><span class=input_span>
      		<input type="hidden" id="img" name="img" old_value="<?php echo @$module['img'];?>" value="<?php echo @$module['img'];?>" /> <span></span>
            <?php echo $module['img_show'];?>
      		</span>
      </span></div> 
    
   	  <div><span class="m_label"><?php echo self::$language['cover_image_width'];?></span><span class=input_span>
      		<input type="text" id="img_width" name="img_width" value="<?php echo @$module['img_width'];?>" /> <span></span>
      		</span>
      </span></div> 
    
   	  <div><span class="m_label"><?php echo self::$language['cover_image_link'];?></span><span class=input_span>
      		<input type="text" id="img_link" name="img_link" value="<?php echo @$module['img_link'];?>" /> <span></span>
      		</span>
      </span></div> 
    
   	  <div><span class="m_label"><?php echo self::$language['first_content'];?></span><span class=input_span>
      		<select id="first" name="first"><option value="0"><?php echo self::$language['default'];?></option><?php echo $module['first_option'];?></select> <span></span> 
      </span></div> 
      
    
   	  <div><span class="m_label"><?php echo self::$language['module_size'];?></span><span class=input_span>
      		<span class=width_label><?php echo self::$language['module_width'];?></span><input type="text" id="width" name="width" value="<?php echo $module['width'];?>" /> <span></span>
      		<span class=height_label><?php echo self::$language['module_height'];?></span><input type="text" id="height" name="height" value="<?php echo $module['height'];?>" /> <span></span>
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['tag_filter'];?></span><span class=input_span id=tags_div>
      		<?php echo $module['tags'];?> <span id=tags_state></span>
      </span></div> 
   	  <div id=image_height_div style="display:none" ><span class="m_label"><?php echo self::$language['image_height'];?></span><span class=input_span>
      		<input type="text" id="image_height" name="image_height" value="<?php echo $module['image_height'];?>" /> <span></span>
      </span></div> 
   	  <div><span class="m_label"><?php echo self::$language['data_src'];?></span><span class=input_span>
      		<select id="id" name="id"><option value="0"><?php echo self::$language['all'];?></option><?php echo $module['data_src_option'];?></select> <span></span> 
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['shop_filter'];?> <?php echo self::$language['tag'];?></span><span class=input_span id=store_tags_div>
      		<?php echo $module['store_tags'];?> <span id=store_tags_state></span>
      </span></div> 
      

   	  <div><span class="m_label"><?php echo self::$language['follow_type'];?></span><span class=input_span>
      		<select id="follow_type" name="follow_type"><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span></span> 
      </span></div> 

   	  <div><span class="m_label"><?php echo self::$language['follow_page'];?></span><span class=input_span>
      		<select id="follow_page" name="follow_page"><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span></span> 
      </span></div> 
   	  <div><span class="m_label"><?php echo self::$language['the_maximum_number_of_display'];?></span><span class=input_span>
      		<input type="text" id="quantity" name="quantity" value="<?php echo $module['quantity'];?>" /> <span></span>
      		</span>
      </span></div> 

   	  <div><span class="m_label"><?php echo self::$language['sequence_for'];?></span><span class=input_span>
      		<select id="sequence_field" name="sequence_field"><?php echo $module['sequence_field_option'];?></select> <select id="sequence_type" name="sequence_type" value="<?php echo $module['sequence_type'];?>"><?php echo $module['sequence_field_type'];?></select> <span></span>
      		</span>
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['show_method'];?></span><span class=input_span>
      		<select id="show_method" name="show_method"><option value="show_grid"><?php echo self::$language['show_grid'];?></option><option value="show_line"><?php echo self::$language['show_line'];?></option></select><span></span>
      		</span>
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['pc_buy_button'];?></span><span class=input_span>
      		<select id="pc_buy_button" name="pc_buy_button"><option value="1"><?php echo self::$language['yes'];?></option><option value="0"><?php echo self::$language['no'];?></option></select><span></span>
      		</span>
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['phone_buy_button'];?></span><span class=input_span>
      		<select id="phone_buy_button" name="phone_buy_button"><option value="1"><?php echo self::$language['yes'];?></option><option value="0"><?php echo self::$language['no'];?></option></select><span></span>
      		</span>
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['show_sold_satisfaction'];?></span><span class=input_span>
      		<select id="show_sold_satisfaction" name="show_sold_satisfaction"><option value="1"><?php echo self::$language['yes'];?></option><option value="0"><?php echo self::$language['no'];?></option></select><span></span>
      		</span>
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['target'];?></span><span class=input_span>
      		<select id="target" name="target"><?php echo $module['target_option'];?></select><span></span>
      		</span>
      </span></div> 
      
   	  <div><span class="m_label"><?php echo self::$language['scroll_display'];?></span><span class=input_span>
      		<select id="scroll" name="scroll"><option value="no"><?php echo self::$language['no'];?></option><option value="up"><?php echo self::$language['go_up'];?></option><option value="left"><?php echo self::$language['go_left'];?></option></select><span></span>
      		</span>
      </span></div> 
      
            
   	  <div><span class="m_label">&nbsp;</span><span class=input_span>
      		<a href="#" id=submit class="submit"><?php echo self::$language['submit'];?></a> <span></span>
      </span></div> 


    </div>
</div>

