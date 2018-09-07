document.write("<div id=<?php echo $module['module_name'];?> monxin-module='<?php echo $module['module_name'];?>' align=center >"+
	"<style>"+
    "#<?php echo $module['module_name'];?>{  width:100%; border-bottom: #e6e6e6 solid 1px;}"+
    "#<?php echo $module['module_name'];?> #top_bar{    margin:auto;  position:relative;  z-index:999; clear:both; text-align:left; line-height:2rem; height:2rem; margin-left:auto; margin-right:auto;}"+
    "#<?php echo $module['module_name'];?> #top_bar .welcome{width:59%; font-size:1rem; padding-left:1%; overflow:hidden; text-align:left; display:inline-block; vertical-align:top;}"+
    "#<?php echo $module['module_name'];?> #top_bar .user_info{ width:40%; overflow:hidden; text-align:right;display:inline-block; vertical-align:top;}"+
    "#<?php echo $module['module_name'];?> #top_bar .icon{ height:26px; vertical-align:middle;}"+
    "#<?php echo $module['module_name'];?> #top_bar a{ display:inline-block; margin-right:0px; line-height:30px;vertical-align:top;}"+
	"#<?php echo $module['module_name'];?> #login{ height:25px; font-size:1rem; text-align:left;  margin-left:10px;}"+
	"#<?php echo $module['module_name'];?> #login:before{font: normal normal normal 18px/1 FontAwesome;margin-right:5px;content:'\\f007';}"+
	"#<?php echo $module['module_name'];?> #reg_user{ height:25px; font-size:1rem;  margin-left:10px;}"+
	"#<?php echo $module['module_name'];?> #reg_user:before{font: normal normal normal 18px/1 FontAwesome;margin-right:5px;content:'\\f040';}"+
	"#<?php echo $module['module_name'];?> #print_a{ display:none; }"+
	"#<?php echo $module['module_name'];?> #icon_a{ margin-right:0px; }"+
	"#<?php echo $module['module_name'];?> #icon_img{ display:block; height:1.8rem;border-radius:0.9rem; border:#FFF 2px solid;vertical-align:middle;}"+
	"#<?php echo $module['module_name'];?> #nickname{ margin-left:0px;padding-left:0px; font-size:1rem;}"+
	"#<?php echo $module['module_name'];?> #unlogin{ font-size:1rem; text-align:left;}"+
	"#<?php echo $module['module_name'];?> #unlogin:before{font: normal normal normal 18px/1 FontAwesome;margin-right:5px;content:'\\f08b';}"+
	"#<?php echo $module['module_name'];?> #hello{ font-size:1rem;vertical-align:top;}"+
	"#<?php echo $module['module_name'];?> #msg_show{ margin-left:10px;  text-align:left;font-size:1rem;  font-weight:bold;}"+
	"#<?php echo $module['module_name'];?> #msg_show:before{font: normal normal normal 18px/1 FontAwesome;margin-right:2px;content:'\\f0e0';}"+
    "</style>"+    
    "<div id=top_bar class=container><span class=welcome><?php echo $module['top_welcome_info'];?></span><span class=user_info>"+
    <?php echo $module['data'];?>
    +"</span></div>"+ 
"</div>");