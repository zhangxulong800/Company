<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$('#import_file_ele').insertBefore($('#import_file_state'));
		$("#<?php echo $module['module_name'];?> .import").click(function(){
			if($("#<?php echo $module['module_name'];?> .import_div").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .import_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> .import_div").css('display','none');
			}
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .submit").next('span').html('');
			if($("#<?php echo $module['module_name'];?> #import_file").val()==''){
					$("#<?php echo $module['module_name'];?> .submit").next('span').html('<span class=fail><?php echo self::$language['please_upload']?></span>');	
					return false;
			}
			$("#<?php echo $module['module_name'];?> .submit").css('display','none');
			$("#<?php echo $module['module_name'];?> .submit").next('span').html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['executing']?>');
			$.post("<?php echo $module['action_url'];?>&act=import",{import_file:$("#<?php echo $module['module_name'];?> #import_file").val()},function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .submit").next('span').html(v.info);
				$("#<?php echo $module['module_name'];?> .submit").next('span').css('display','block').width('100%');
				if(v.state=='fail'){
					$("#<?php echo $module['module_name'];?> .submit").css('display','inline-block');
					
				}else{
					$("#<?php echo $module['module_name'];?> .submit").next('span').html(v.info);
				}
			});	
			
			return false;	
		});
		
    });
    
    
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .goods_in_out_notice{ text-align:center; line-height:3rem;  opacity:0.5;}
	#<?php echo $module['module_name'];?>_html .act_select{ line-height:5rem; text-align:center;}
	#<?php echo $module['module_name'];?>_html .act_select a{ display:inline-block; line-height:4rem; padding-left:2rem; padding-right:2rem;}
	#<?php echo $module['module_name'];?>_html .act_select .import{ margin-right:3rem; }
	
	#<?php echo $module['module_name'];?>_html .import_div{ display:none; line-height:3rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html" monxin-table='1'>
    	<div class=goods_in_out_notice><?php echo self::$language['goods_in_out_notice'];?></div>
        <div class=act_select><a href=# class=import  user_color=button><?php echo self::$language['import']?></a><a href=<?php echo $module['action_url'];?>&act=export class=export  user_color=button target="_blank"><?php echo self::$language['export']?></a></div>
    
		<div class=import_div>
			<?php echo self::$language['file']?> <?php echo self::$language['import_file_placeholder']?><?php echo self::$language['goods_in_out_field']?><br /> 
	 		<span id=import_file_state></span> <a class=submit><?php echo self::$language['submit']?></a> <span class=state></span>
        </div>
                        
                        

</div>




</div>



