<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	
});
</script>

<style>
#<?php echo $module['module_name'];?>{ padding-left:0px; padding-right:0px;}
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html  a{ display:inline-block; vertical-align:top; text-align:center; width:12.5%; text-align:center; margin-bottom:10px;}
#<?php echo $module['module_name'];?>_html  a span{ display:block;}
#<?php echo $module['module_name'];?>_html  a img{ width:123px; height:50px; border:none;}
#<?php echo $module['module_name'];?>_html  a img:hover{ opacity:0.7;}
#<?php echo $module['module_name'];?>_html  a span{ }


</style>
<div id="<?php echo $module['module_name'];?>_html">
   <?php echo $module['list'];?>
</div>

</div>