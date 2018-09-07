<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		exe_task();
		timer=setInterval(exe_task,<?php echo $module['second']*1000;?>);
	});	
	
	function exe_task(){
		$.get("<?php echo $module['action_url']?>",function(data){
			//monxin_alert(data);	
			            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#wait_exe").html(v.quantity);
			if(v.quantity==0){
				clearInterval(timer);
				$("#exe_ing").css('display','none');
				$("#exe_end").css('display','block');	
			}
		});
				
	} 
   </script>
	<style>
    #<?php echo $module['module_name'];?>_html{ text-align:center; padding-top:25%;}
    #<?php echo $module['module_name'];?>_html #exe_ing{ line-height:30px;}
    #<?php echo $module['module_name'];?>_html #exe_end{display:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
		<div id=exe_ing><span id="exe_state" class=loading><?php echo $module['task_info'];?>....   <?php echo self::$language['wait_exe'];?>: <b id=wait_exe></b></span> </div>
    	<div id=exe_end><span class="success"><?php echo self::$language['exe_end'];?></span></div>
    </div>
</div>





