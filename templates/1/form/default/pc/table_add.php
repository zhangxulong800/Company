<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			j_name=$("#<?php echo $module['module_name'];?> #name");	
			j_description=$("#<?php echo $module['module_name'];?> #description");
			$("#<?php echo $module['module_name'];?> .input_span span").html('');
			if(j_description.val()==''){j_description.next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');j_description.focus(); return false;}
			if(j_name.val()==''){j_name.next('span').html('<span class=fail><?php echo self::$language['please_input'];?></span>');j_name.focus(); return false;}			
			if(!is_passwd(j_name.val()) ){
				j_name.next('span').html('<span class=fail><?php echo self::$language['only_letters_numbers_underscores'];?></span>');j_name.focus(); return false;
			}
			
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			$.get('<?php echo $module['action_url'];?>&act=add',{ description:j_description.val(), name: j_name.val()} ,function(data){
				//alert(data);	
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				if(v.id){
					$("#<?php echo $module['module_name'];?> #"+v.id).next('span').html(v.info);	
				}else{
					$("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
				}
				
                if(v.state=='success'){
					alert('<?php echo self::$language['success'];?>');
                	window.location.href='./index.php?monxin=form.table_admin';
                }

			});	
		});
	


    });
    

 </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html div{ line-height:60px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:150px; text-align:right; padding-right:10px; }
    </style>
    <div id=<?php echo $module['module_name'];?>_html>
    	<div><span class=m_label><?php echo self::$language['name'];?></span><span class=input_span><input type="text" id="description" /><span></span></span></div>
    	<div><span class=m_label><?php echo self::$language['table_name'];?></span><span class=input_span><input type="text" id="name" placeholder="<?php echo self::$language['only_letters_numbers_underscores'];?>" /><span></span></span></div>       
        
   	  <div><span class="m_label">&nbsp;</span><span>
      		<a href="#" id=submit class="submit"><?php echo self::$language['submit'];?></a> <span></span>
      </span></div> 

    </div>
</div>
