<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  style="display:inline-block;width:<?php echo $module['width']?>;height:<?php echo $module['height']?>; ">
	<style>
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html{width:<?php echo $module['width']?>;height:<?php echo $module['height']?>;  overflow:hidden; padding:10px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html">
      <?php echo $module['content']?>
    </div>
</div>