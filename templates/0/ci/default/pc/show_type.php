<div id=<?php echo $module['module_name'];?>  class="light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){

});
</script>
<style>
#<?php echo $module['module_name'];?>{  padding-top:10px;background:<?php echo $_POST['monxin_user_color_set']['container']['background']?>;}
#<?php echo $module['module_name'];?>_html{white-space:nowrap; padding-left:10px;}
#<?php echo $module['module_name'];?> .column{ display:inline-block; vertical-align:top; width:<?php echo $module['width'];?>%;  margin-right:2%; min-height:1000px;  }
#<?php echo $module['module_name'];?> .column .type_div{ margin-bottom:1.42rem;  background-color:#FFF;}
#<?php echo $module['module_name'];?> .column .type_div .parent{display:block;  line-height:2.5rem; height:2.5rem; overflow:hidden; white-space:nowrap;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
#<?php echo $module['module_name'];?> .type_div .parent:hover{ opacity:0.8;}
#<?php echo $module['module_name'];?> .column .type_div .parent .icon{ display:inline-block; vertical-align:top; line-height:2.5rem; height:2.5rem; }
#<?php echo $module['module_name'];?> .column .type_div .parent .icon img{ border:none;  line-height:2.5rem; height:2.5rem;}
#<?php echo $module['module_name'];?> .column .type_div .parent .text{ margin-left:10px; font-weight:bold; display:inline-block; vertical-align:top; line-height:2.5rem; height:2.5rem; min-width:300px; }
#<?php echo $module['module_name'];?> .column .type_div .sub{ width:100%; overflow:hidden; white-space:normal;  line-height:2.5rem; padding:0.5rem;}
#<?php echo $module['module_name'];?> .column .type_div .sub a{ display:inline-block; vertical-align:top; width:100%;  line-height:2.5rem; overflow:hidden;  white-space:nowrap;text-overflow: ellipsis;text-indent:0.5rem;}
#<?php echo $module['module_name'];?> .column .type_div .sub a:hover{background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
#<?php echo $module['module_name'];?> .column .type_div .line_column_1 a{ width:100%; }
#<?php echo $module['module_name'];?> .column .type_div .line_column_2 a{ width:50%;}
#<?php echo $module['module_name'];?> .column .type_div .line_column_3 a{ width:33%;}
#<?php echo $module['module_name'];?> .column .type_div .line_column_4 a{ width:25%;}

</style>
<div id="<?php echo $module['module_name'];?>_html">
	<?php echo $module['data'];?>
</div>
</div>