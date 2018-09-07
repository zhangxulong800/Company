<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"   class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
            
    });
    </script>
    

    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .type_a{ display:inline-block; width:25%; white-space:nowrap; overflow:hidden;}
	#<?php echo $module['module_name'];?> .type_a:hover{ opacity:0.7;}
    #<?php echo $module['module_name'];?> .type_a .icon_div{ display:inline-block;  vertical-align:top;text-align:center; width:128px; height:170px; overflow:hidden;}
    #<?php echo $module['module_name'];?> .type_a .icon_div:hover{ font-weight:bold;}
    #<?php echo $module['module_name'];?> .type_a .icon_div img{width:113px; box-shadow:1px 1px 8px 0px rgba(0,0,0,.3); border-radius:20px; border:2px solid #fff; margin:5px; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
    #<?php echo $module['module_name'];?> .type_a .sum_div{ display:inline-block; vertical-align:top; text-align:left;padding-left:10px; line-height:44px; overflow:hidden; }
	#<?php echo $module['module_name'];?> .type_a .sum_div .v{ padding-left:5px;}
	#<?php echo $module['module_name'];?> .type_a .sum_div .name{ font-weight:bold; width:100%; overflow:hidden; text-overflow: ellipsis;}
    
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
      <?php echo $module['list']?>
    </div>
</div>