<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$(".input_span input[type='checkbox']").css('height',13);
		$("#search_switch").toggle(
			function () {
			  $("#search_span").css('display','inline-block');
			},
			function () {
			  $("#search_span").css('display','none');
			}
		);
		$("#<?php echo $module['module_name'];?> #id").val('<?php echo $module['id'];?>');
		
		
		
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			if($("#<?php echo $module['module_name'];?> #id").val()<1){$("#<?php echo $module['module_name'];?> #id").next('span').html('<span class=fail><?php echo self::$language['please_select'];?></span>');$("#<?php echo $module['module_name'];?> #id").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #id").next('span').html('')
			args='|'+'id:'+$("#<?php echo $module['module_name'];?> #id").val();
			
			field='';
			$("#<?php echo $module['module_name'];?> input[field='field']").each(function(index, element) {
                if($(this).prop('checked')){
					field+='/'+$(this).val();	
				}
            });
			field=field.replace(/\//,'');
			
			if(field==''){$("#<?php echo $module['module_name'];?> #filed_checkbox_state").html('<span class=fail><?php echo self::$language['please_select'];?></span>'); return false;}
			$("#<?php echo $module['module_name'];?> #filed_checkbox_state").html('');
			args+='|'+'field:'+field;
			
			if($("#<?php echo $module['module_name'];?> #width").val()==''){$("#<?php echo $module['module_name'];?> #width").next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');$("#<?php echo $module['module_name'];?> #width").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #width").next('span').html('')
			args+='|'+'width:'+check_module_size($("#<?php echo $module['module_name'];?> #width").val());
			
			if($("#<?php echo $module['module_name'];?> #height").val()==''){$("#<?php echo $module['module_name'];?> #height").next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');$("#<?php echo $module['module_name'];?> #height").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #height").next('span').html('')
			args+='|'+'height:'+check_module_size($("#<?php echo $module['module_name'];?> #height").val());
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

function e_search(){
	url=window.location.href;
	url=replace_get(url,'search',$("#search").val());
	//monxin_alert(url);
	window.location.href=url;	
	return false;
}	

	
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px;}
    #<?php echo $module['module_name'];?>_html div{ line-height:60px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:100px; text-align:right; padding-right:10px;}
    #<?php echo $module['module_name'];?> #content{}
	#<?php echo $module['module_name'];?>  #id{ width:300px;}
	#<?php echo $module['module_name'];?>  #width{ width:80px; margin-left:10px; margin-right:15px;}
	#<?php echo $module['module_name'];?>  #height{ width:80px; margin-left:10px;}
	#<?php echo $module['module_name'];?>  #search{ margin-right:10px;}
	#search_span{ display:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
   	  <div><span class="m_label"><?php echo self::$language['module_size'];?></span><span class=input_span>
      		<span class=width_label><?php echo self::$language['module_width'];?></span><input type="text" id="width" name="width" value="<?php echo $module['width'];?>" /> <span></span>
      		<span class=height_label><?php echo self::$language['module_height'];?></span><input type="text" id="height" name="height" value="<?php echo $module['height'];?>" /> <span></span>
      </span></div> 
   	  <div><span class="m_label"><?php echo self::$language['show_content'];?></span><span class=input_span>
      		<?php echo $module['field_checkbox'];?> <span id=filed_checkbox_state></span>
      </span></div> 
   	  <div><span class="m_label"><?php echo self::$language['data_src'];?></span><span class=input_span>
      		<select id="id" name="id"><option value="-1"><?php echo self::$language['please_select'];?></option><?php echo $module['data_src_option'];?></select> <span></span> <a href=# id=search_switch><?php echo self::$language['more']?></a> <span id=search_span><input type="text" id="search" name="search" value="<?php echo @$_GET['submit'];?>" /><a href="#" onclick="return e_search()" class="search"><?php echo self::$language['search'];?></a></span>
      </span></div> 
   	  <div><span class="m_label">&nbsp;</span><span class=input_span>
      		<a href="#" id=submit class="submit"><?php echo self::$language['submit'];?></a> <span></span>
      </span></div> 


    </div>
</div>

