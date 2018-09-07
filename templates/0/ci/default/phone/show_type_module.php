<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?> #type_"+get_param('type')).attr('class','current_type');
});
</script>
    

<style>
#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block; vertical-align:top;vertical-align:top; overflow:hidden; background:#fff;  border:1px solid #ddd; padding:0px;}
#<?php echo $module['module_name'];?> .type_div{ margin-bottom:1.42rem;}
#<?php echo $module['module_name'];?> .type_div .parent{display:block;  line-height:3.21rem; height:3.21rem; overflow:hidden; white-space:nowrap;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
#<?php echo $module['module_name'];?> .type_div .parent .icon{ display:inline-block; vertical-align:top; line-height:3.21rem; height:3.21rem;  }
#<?php echo $module['module_name'];?> .type_div .parent .icon img{ border:none; line-height:3rem; height:3rem;  }
#<?php echo $module['module_name'];?> .type_div .parent .text{ padding-left:10px; font-weight:bold; display:inline-block; vertical-align:top;line-height:3.21rem; height:3.21rem;   }
#<?php echo $module['module_name'];?> .type_div .sub{ padding:10px;overflow:hidden; white-space:normal; line-height:3.21rem;  }
#<?php echo $module['module_name'];?> .type_div .sub a{  display:inline-block; vertical-align:top; width:100%; white-space:nowrap;text-overflow: ellipsis;  overflow:hidden; }
#<?php echo $module['module_name'];?> .type_div .sub a:hover{  border-bottom: 1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?> .type_div .sub .current_type{ border-bottom: 1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?> .type_div .sub .current_type:after{margin-left:3px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da";}
</style>


<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=type><?php echo $module['list'];?></div>
</div>
</div>