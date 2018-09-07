<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .map{}
	#<?php echo $module['module_name'];?>_html .map .line{ line-height:40px;border-bottom:#CCC dashed 1px;padding:20px;}
	#<?php echo $module['module_name'];?>_html .map .line .parent{ display:inline-block;vertical-align:top;width:150px; overflow:hidden; white-space:nowrap; text-overflow: ellipsis; text-align:right; padding-right:10px; }
	#<?php echo $module['module_name'];?>_html .map .line .parent a{ text-decoration:none;background:#F60; padding:5px; padding-left:10px;padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .map .line .sub{ display:inline-block;vertical-align:top;width:1031px; overflow:hidden;  }
	#<?php echo $module['module_name'];?>_html .map .line .sub a{ display:inline-block; width:150px; padding-right:20px;  white-space:nowrap; text-overflow: ellipsis; text-decoration:none;}
	#<?php echo $module['module_name'];?>_html iframe{}
</style>	
    <div id="<?php echo $module['module_name'];?>_html">
		
		<div class=map>
			<?php echo $module['map'];?>
		</div>
		<div class=iframe></div>
    </div>
</div>