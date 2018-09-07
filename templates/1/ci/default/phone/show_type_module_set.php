<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #id").change(function(){
			if($(this).val()>0){$("#<?php echo $module['module_name'];?> #title").val($.trim($(this).find("option:selected").text()));}
		});
		$(".input_span input[type='checkbox']").css('height',13);
		$("#<?php echo $module['module_name'];?> #id").val('<?php echo $module['id'];?>');
		$("#<?php echo $module['module_name'];?> #target").val('<?php echo $module['target'];?>');
		$("#<?php echo $module['module_name'];?> #follow_type").val('<?php echo $module['follow_type'];?>');

		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			if($("#<?php echo $module['module_name'];?> #id").val()<0){$("#<?php echo $module['module_name'];?> #id").next('span').html('<span class=fail><?php echo self::$language['please_select'];?></span>');$("#<?php echo $module['module_name'];?> #id").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #id").next('span').html('')
			args='|'+'id:'+$("#<?php echo $module['module_name'];?> #id").val();
			
			if($("#<?php echo $module['module_name'];?> #width").val()==''){$("#<?php echo $module['module_name'];?> #width").next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');$("#<?php echo $module['module_name'];?> #width").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #width").next('span').html('')
			args+='|'+'width:'+check_module_size($("#<?php echo $module['module_name'];?> #width").val());
			args+='|'+'sub_width:'+check_module_size($("#<?php echo $module['module_name'];?> #sub_width").val());
			args+='|'+'follow_type:'+$("#<?php echo $module['module_name'];?> #follow_type").val();
			args+='|'+'quantity:'+$("#<?php echo $module['module_name'];?> #quantity").val();
			
			if($("#<?php echo $module['module_name'];?> #height").val()==''){$("#<?php echo $module['module_name'];?> #height").next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');$("#<?php echo $module['module_name'];?> #height").focus(); return false;}
			$("#<?php echo $module['module_name'];?> #height").next('span').html('')
			args+='|'+'height:'+check_module_size($("#<?php echo $module['module_name'];?> #height").val());
			args+='|'+'target:'+$("#<?php echo $module['module_name'];?> #target").val();
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
	#<?php echo $module['module_name'];?>_html .submit {white-space: nowrap;font-size: 1rem;border-radius: 5px;padding: 3px 17px;}
    #<?php echo $module['module_name'];?>_html{ padding-top:10px;}
    #<?php echo $module['module_name'];?>_html div{ line-height:60px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; vertical-align: middle; width:20%; text-align:right; padding-right:10px; box-shadow:none;}
	#<?php echo $module['module_name'];?>  #id{ width:300px;}
	#<?php echo $module['module_name'];?>  #width{ width:80px; margin-left:10px; margin-right:15px;}
	#<?php echo $module['module_name'];?>  #height{ width:80px; margin-left:10px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs font-green-sharp"></i>
                <span class="caption-subject font-green-sharp bold uppercase"><?php echo $module['monxin_table_name']?></span>
            </div>
            <div class="actions btn-set"  style=" display:none;">
                <div class="btn-group">
                    <a class="btn yellow btn-circle" href="javascript:;" data-toggle="dropdown">
                    <i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-right" >
                        <li><a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a></li> 
                        <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                        <li style=" display:none;"><a href="#"  onclick="return show_select(1);" class=show><?php echo self::$language['show']?></a></li> 
                        <li style=" display:none;"><a href="#" onclick="return show_select(0);" class=hide><?php echo self::$language['hide']?></a></li> 
                    </ul>
                </div>
            </div>
   	    </div>
    
    
   	  <div><span class="m_label"><?php echo self::$language['module_size'];?></span><span class=input_span>
      		<span class=width_label><?php echo self::$language['module_width'];?></span><input type="text" id="width" name="width" value="<?php echo $module['width'];?>" /> <span></span>
      		<span class=height_label><?php echo self::$language['module_height'];?></span><input type="text" id="height" name="height" value="<?php echo $module['height'];?>" /> <span></span>
      </span></div>
       
   	  <div><span class="m_label"><?php echo self::$language['type_name_width'];?></span><span class=input_span>
      		<input type="text" id="sub_width" name="sub_width" value="<?php echo $module['sub_width'];?>" /> <span></span> 
      </span></div> 
       
   	  <div><span class="m_label"><?php echo self::$language['default_data_src'];?></span><span class=input_span>
      		<select id="id" name="id"><option value="0"><?php echo self::$language['all'];?></option><?php echo $module['data_src_option'];?></select> <span></span> 
      </span></div> 

   	  <div><span class="m_label"><?php echo self::$language['follow_type'];?></span><span class=input_span>
      		<select id="follow_type" name="follow_type"><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span></span> 
      </span></div> 

   	  <div><span class="m_label"><?php echo self::$language['data_quantity'];?></span><span class=input_span>
      		<input type="text" id="quantity" name="quantity" value="<?php echo $module['quantity'];?>" /> <span></span> 
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

