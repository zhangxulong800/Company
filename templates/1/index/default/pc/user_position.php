<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>"  align=left >
	<style>
	#<?php echo $module['module_name'];?> { background:none !important; background-color:none !important;}
	#<?php echo $module['module_name'];?>_html {}
	#<?php echo $module['module_name'];?>_html a{ }
	#<?php echo $module['module_name'];?>_html a:hover{ font-weight:bold; }
    #<?php echo $module['module_name'];?>_html #user_position{  margin:auto; line-height:30px;}
    #<?php echo $module['module_name'];?>_html #user_position a:after{ font-family:"FontAwesome"; font-size:5px; padding:5px; content: "\f105";}
	#user_position_icon{ display:none !important;}
    </style>
    <script>
    $(document).ready(function(){
        if($("#user_position_reset").length>0){
            $('#user_position').html($('#user_position_reset').html());
			$("#user_position_icon").parent().css('display','none');
        }else if($("#user_position_append").length>0){
			
			$("#user_position .text").css('display','none');
            $('#user_position').html($('#user_position').html()+'<span id="user_position_append">'+$("#user_position_append").html()+'<span>');

        }
		
       //$("#<?php echo $module['module_name'];?>_html #user_position a:last").css("background-image","url(<?php echo get_template_dir(__FILE__);?>img/position_bg2.png)");        
    });
    </script>
    

    <div id=<?php echo $module['module_name'];?>_html>
    	<div id=user_position class="container"><?php echo $module['list']?></div>
        <!--
        附加位置条信息
        <div  style="display:none;" id="user_position_append"><a href="#">my is append a</a><span class=text>my is append text</span></div>
        
        重置位置条信息
        <div id="user_position_reset" style="display:none;"><a href='index.php'><span id=user_position_icon>&nbsp;</span>网站名称</a><a href='index.php?monxin=index.user'>用户中心</a><span class=text>position 1</span></div>
        -->
    </div>
</div>