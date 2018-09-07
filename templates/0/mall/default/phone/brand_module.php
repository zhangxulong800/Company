<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	
});
</script>

<style>
#<?php echo $module['module_name'];?>{}
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html  a{ display:inline-block; vertical-align:top; text-align:center; width:25%; text-align:center; margin-bottom:10px;}
#<?php echo $module['module_name'];?>_html  a span{ display:block;}
#<?php echo $module['module_name'];?>_html  a img{ width:62px; height:25px; border:none;}
#<?php echo $module['module_name'];?>_html  a img:hover{ opacity:0.7;}
#<?php echo $module['module_name'];?>_html  a span{ font-size:0.9rem; display:none;}


</style>
<div id="<?php echo $module['module_name'];?>_html">
   <?php echo $module['list'];?>
</div>

</div>