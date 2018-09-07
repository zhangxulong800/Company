<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){	
	
});
</script>

<style>
#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block;vertical-align:top;position:relative; overflow:hidden;box-shadow:0px 0px 10px rgba(0,0,0,.5); margin:5px; margin-top:10px; border-radius:2px; border:2px solid #fff;}
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html .module_title{ font-size:2rem; text-align:center; display:inline-block; line-height:3rem; height:3rem; width:<?php echo $module['module_width'];?>; }
#<?php echo $module['module_name'];?>_html .list{line-height:2.5rem;}
#<?php echo $module['module_name'];?>_html .list a{ padding-left:1rem; display:block;overflow:hidden; border-bottom:1px dashed #aaa; text-overflow: ellipsis;height:2.5rem;}
#<?php echo $module['module_name'];?>_html .list a:hover{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}


</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin" >
	<div class=module_title><?php echo $module['title'];?></div>
	<div class=list><?php echo $module['list'];?></div>
</div>
</div>