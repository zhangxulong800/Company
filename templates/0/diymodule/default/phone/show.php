<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left  style="display:inline-block;width:<?php echo $module['width']?>;height:<?php echo $module['height']?>;display:inline-block;vertical-align:top; ">
<script>
$(document).ready(function(){
	if('<?php echo $module['title_visible'];?>'==1){$("#<?php echo $module['module_name'];?> .module_title").css('display','block');}

});
</script>
	<style>
	#<?php echo $module['module_name'];?>{margin:0px;padding:0px;}
	#<?php echo $module['module_name'];?> .module_title{ display:block; font-size:1.71rem; height:4.28rem;line-height:4.28rem;  background-position:top;   padding-left:25px;  font-weight:bold; margin-bottom:0.8rem; display:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html">
    <div class=module_title><?php echo $module['title'];?></div>
     <?php echo $module['content']?>
    </div>

</div>