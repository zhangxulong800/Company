<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<style>
    #<?php echo $module['module_name'];?>_html{ display:inline-block;  width:100%;}
    #<?php echo $module['module_name'];?>_html .cry{ display:inline-block; background-image:url(<?php echo get_template_dir(__FILE__);?>img/cry.png); width:65px; height:65px; background-repeat:no-repeat;  position:absolute; }
    #<?php echo $module['module_name'];?>_html .text{  display:inline-block; height:30px; line-height:30px;  vertical-align:bottom; width:100%;; padding-left:70px; margin-top:40px; font-size:18px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
       <div class="cry" colspan="2">&nbsp;</div>
       <div class="text"><?php echo self::$language['need_login'];?></div>     	
    </div>
</div>

