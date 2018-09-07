<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"   class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
            
    });
    </script>
    

    <style>
    #<?php echo $module['module_name'];?>{ padding:1rem;}
    #<?php echo $module['module_name'];?> .type_a{ display:block; width:100%; white-space:nowrap; margin-bottom:1rem; border-bottom:1px dashed #ccc; padding-bottom:1rem; line-height:2.2rem;}
    #<?php echo $module['module_name'];?> .type_a .icon_div{ display:inline-block; text-align:center; width:30%; vertical-align:top;}
    #<?php echo $module['module_name'];?> .type_a .icon_div:hover{ font-weight:bold;}
    #<?php echo $module['module_name'];?> .type_a .icon_div img{width:80%; box-shadow:1px 1px 8px 0px rgba(0,0,0,.3); border-radius:20px; border:2px solid #fff; margin:5px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
    #<?php echo $module['module_name'];?> .type_a .sum_div{display:inline-block; width:70%; vertical-align:top;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .day_title_sum{ line-height:2rem;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .v{ padding-left:3px;}
    #<?php echo $module['module_name'];?> .type_a .sum_div .name{ font-weight:bold;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
      <?php echo $module['list']?>
    </div>
</div>