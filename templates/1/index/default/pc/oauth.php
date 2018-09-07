<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){


    });	
	
	</script>
    
    
    
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px; }
	#online_div a{  margin:30px; display:inline-block; }
	#online_div img{border:none;display:block;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title" style="border-bottom: 1px solid #eee; margin-bottom:10px;">
        	<div class="caption" ><?php echo $module['monxin_table_name']?></div>
   	    </div>
        
		<div id=online_div><?php echo $module['online']?></div>
    
    
    </div>
</div>

