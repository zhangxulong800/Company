<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	
});
</script>
<style>
#<?php echo $module['module_name'];?>{}
#<?php echo $module['module_name'];?>_html{ background:<?php echo $_POST['monxin_user_color_set']['container']['background']?>;}
#<?php echo $module['module_name'];?> .column{ display:block;}
#<?php echo $module['module_name'];?> .type_div{box-shadow: 0px 2px 2px 1px rgba(0, 0, 0, 0.1); margin-bottom:1rem; background-color:#fff; }
#<?php echo $module['module_name'];?> .type_div .parent{ display:block;  overflow:hidden;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; line-height:3rem;}
#<?php echo $module['module_name'];?> .type_div .parent .icon{display:inline-block; vertical-align:top; width:10%; overflow:hidden; text-align:center;  }
#<?php echo $module['module_name'];?> .type_div .parent .icon img{ height:1.5rem; border-radius:0.2rem;}
#<?php echo $module['module_name'];?> .type_div .parent .text{ padding-top:0.2rem; font-weight:bold; display:inline-block; vertical-align:top; width:90%; overflow:hidden;  }
#<?php echo $module['module_name'];?> .type_div .parent .text:after{ float:right; margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f105";}

#<?php echo $module['module_name'];?> .type_div .sub { line-height:2rem; padding:0.5rem; }
#<?php echo $module['module_name'];?> .type_div .sub a{ display:inline-block; vertical-align:top; width:24%; padding-right:1%; overflow:hidden; white-space:nowrap;text-overflow: ellipsis;}
</style>
<div id="<?php echo $module['module_name'];?>_html">
	<?php echo $module['data'];?>
</div>
</div>