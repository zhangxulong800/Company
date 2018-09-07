<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?> .type .type_name a").each(function(index, element) {
         $(this).html($(this).html()+' > ');
    });
});
</script>
<style>
#<?php echo $module['module_name'];?>{}
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html .type{ margin-bottom:30px; padding-bottom:10px;}
#<?php echo $module['module_name'];?>_html .type .type_name{  border-bottom:2px solid #F60; height:50px; line-height:50px; padding-left:13px; font-size:18px;}
#<?php echo $module['module_name'];?>_html .type .type_name a{ display:inline-block; vertical-align:top; font-weight:bold; }
#<?php echo $module['module_name'];?>_html .type .goods{  padding-left:1%; padding-top:10px; padding-bottom:20px;}
#<?php echo $module['module_name'];?>_html .type .bottom{  height:15px; }
#<?php echo $module['module_name'];?>_html .type .goods a{ display:inline-block; vertical-align:top; height:40px; line-height:40px;  width:27%; overflow:hidden; margin-right:4%; border-right:#F60  dashed 1px;}
#<?php echo $module['module_name'];?>_html .type .goods .title{ display:inline-block; vertical-align:top;width:70%; overflow:hidden; }
#<?php echo $module['module_name'];?>_html .type .goods .title:hover{ font-weight:bold;}
#<?php echo $module['module_name'];?>_html .type .goods .price{ display:inline-block; vertical-align:top; width:30%; overflow:hidden; }
</style>
<div id="<?php echo $module['module_name'];?>_html">
	<?php echo $module['data'];?>
</div>
</div>