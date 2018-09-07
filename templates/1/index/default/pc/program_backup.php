<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){  
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['executing'];?><?php echo self::$language['need_long_time'];?>');
			$(this).css('display','none');
			//return false;
			$.post("<?php echo $module['action_url'];?>&act=backup",obj,function(data){
				$("#<?php echo $module['module_name'];?> #submit").next('span').html('');
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
				
				if(v.state=='fail'){
					$("#<?php echo $module['module_name'];?> #submit").css('display','inline-block');
				}
	
			});	
			return false;
		});
    });
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{line-height:60px; text-align:center;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
		<a href="#" id=submit class="submit"><?php echo self::$language['start'];?><?php echo self::$language['backup'];?></a> 
		<span></span>
    </div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</div>