<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #id").change(function(){
			if($(this).val()>0){$("#<?php echo $module['module_name'];?> #title").val($.trim($(this).find("option:selected").text()));}
		});
		$(".input_span input[type='checkbox']").css('height',13);
		$("#<?php echo $module['module_name'];?> #id").val('<?php echo $module['id'];?>');
		$("#<?php echo $module['module_name'];?> #show_deep").val('<?php echo $module['show_deep'];?>');
		$("#<?php echo $module['module_name'];?> #target").val('<?php echo $module['target'];?>');
		$("#<?php echo $module['module_name'];?> #follow_type").val('<?php echo $module['follow_type'];?>');

		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			if($("#<?php echo $module['module_name'];?> #id").val()<0){$("#<?php echo $module['module_name'];?> #id").next('span').html('<span class=fail><?php echo self::$language['please_select'];?></span>');$("#<?php echo $module['module_name'];?> #id").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #id").next('span').html('')
			args='|'+'id:'+$("#<?php echo $module['module_name'];?> #id").val();
			
			if($("#<?php echo $module['module_name'];?> #width").val()==''){$("#<?php echo $module['module_name'];?> #width").next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');$("#<?php echo $module['module_name'];?> #width").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #width").next('span').html('')
			args+='|'+'width:'+check_module_size($("#<?php echo $module['module_name'];?> #width").val());
			
			if($("#<?php echo $module['module_name'];?> #height").val()==''){$("#<?php echo $module['module_name'];?> #height").next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');$("#<?php echo $module['module_name'];?> #height").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #height").next('span').html('')
			args+='|'+'height:'+check_module_size($("#<?php echo $module['module_name'];?> #height").val());
			args+='|'+'show_deep:'+$("#<?php echo $module['module_name'];?> #show_deep").val();
			args+='|'+'target:'+$("#<?php echo $module['module_name'];?> #target").val();
			args+='|'+'title:'+$("#<?php echo $module['module_name'];?> #title").val();
			args+='|'+'follow_type:'+$("#<?php echo $module['module_name'];?> #follow_type").val();
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
	#<?php echo $module['module_name'];?>  #id{ width:300px;}
	#<?php echo $module['module_name'];?>  #width{ width:80px; margin-left:10px; margin-right:15px;}
	#<?php echo $module['module_name'];?>  #height{ width:80px; margin-left:10px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
   	  <div><span class="m_label"><?php echo self::$language['module'];?><?php echo self::$language['title'];?></span><span class=input_span>
      		<input type="text" id="title" name="title" value="<?php echo $module['title'];?>" /> <span></span>
      		</span>
      </span></div> 
   	  <div><span class="m_label"><?php echo self::$language['module_size'];?></span><span class=input_span>
      		<span class=width_label><?php echo self::$language['module_width'];?></span><input type="text" id="width" name="width" value="<?php echo $module['width'];?>" /> <span></span>
      		<span class=height_label><?php echo self::$language['module_height'];?></span><input type="text" id="height" name="height" value="<?php echo $module['height'];?>" /> <span></span>
      </span></div> 
   	  <div><span class="m_label"><?php echo self::$language['data_src'];?></span><span class=input_span>
      		<select id="id" name="id"><option value="0"><?php echo self::$language['all'];?></option><?php echo $module['data_src_option'];?></select> <span></span> 
      </span></div> 
   	  <div><span class="m_label"><?php echo self::$language['follow_type'];?></span><span class=input_span>
      		<select id="follow_type" name="follow_type"><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span></span> 
      </span></div> 
   	  <div><span class="m_label"><?php echo self::$language['default_show_type_deep'];?></span><span class=input_span>
      		<select id="show_deep" name="show_deep"><option value="1">1</option><option value="2">2</option><option value="3">3</option></select> <span></span>
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

