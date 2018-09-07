<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$.post('<?php echo $module['action_url'];?>&act=update',{content:$(".phone_bottom_data").val()},function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
			});
			return false;	
		});
	});
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
    #<?php echo $module['module_name'];?> .phone_bottom_data{ width:100%; height:20rem;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html>
    <textarea class=phone_bottom_data ><?php echo $module['data']?></textarea>
    <br /><br />
    <a href="" class=submit><?php echo self::$language['submit']?></a> <span classs=state></span>
    
    </div>
</div>

