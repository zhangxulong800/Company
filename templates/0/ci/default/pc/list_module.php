<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>"  ci_module="<?php echo $module['module_diy']?>" align=left >
<script>
$(document).ready(function(){
	if($("#<?php echo $module['module_name'];?> .cover_image").html()!=null){
		$("#<?php echo $module['module_name'];?> .cover_image img").css('height',$("#<?php echo $module['module_name'];?> .list").height()-2);
		$("#<?php echo $module['module_name'];?> .list").css('width',$("#<?php echo $module['module_name'];?>").width()-$("#<?php echo $module['module_name'];?> .cover_image").width());
	}
	
	$("#<?php echo $module['module_name'];?> .icon img").each(function(index, element) {
		if($(this).attr('wsrc')!='./program/ci/img_thumb/'){$(this).attr('src',$(this).attr('wsrc'));}else{$(this).attr('src','./no_picture.png');}
	});
	$("#<?php echo $module['module_name'];?> .attributes").each(function(index, element) {
        $(this).children("span:last").css('background-image','none');
    });
});
</script>

<style>
#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block; vertical-align:top;vertical-align:top; overflow:hidden;  margin-bottom: 20px;
margin: 20px 0.34%;  border:1px solid #e7e7e7; padding:0px;}
#<?php echo $module['module_name'];?>_html{ white-space:nowrap;overflow: hidden;height: 90%;}


#<?php echo $module['module_name'];?>_html .module_title{font-size:20px; height:50px;line-height:50px;  border-bottom:3px solid #87B829; padding-right:25px; overflow:hidden;box-shadow:0px 1px 5px #ccc;}
#<?php echo $module['module_name'];?>_html .module_title .name{ float:left;min-width:100px; width:<?php echo @$module['img_width'];?>; text-align:center; padding-right:5px;}
#<?php echo $module['module_name'];?>_html .module_title .name span{    font-weight:bold; padding-left:5px; padding-right:5px; margin-right:10px; margin-left:10px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .module_title .more{ float:right; font-size:14px;  font-family:"微软雅黑", "宋体";}
#<?php echo $module['module_name'];?>_html .module_title .more:hover{ float:right; font-size:14px; }


#<?php echo $module['module_name'];?>_html .cover_image{ display:inline-block; vertical-align:top;width:<?php echo @$module['img_width'];?>;}
#<?php echo $module['module_name'];?>_html .cover_image:hover{opacity:0.8; filter:alpha(opacity=80);}
#<?php echo $module['module_name'];?>_html .cover_image img{width:<?php echo @$module['img_width'];?>;border:none; padding-top:2px;}


#<?php echo $module['module_name'];?>_html .list{ display:inline-block; vertical-align:top; max-width:100%;height:100%;white-space:normal; }
#<?php echo $module['module_name'];?>_html .list .line{display:inline-block; border-bottom:dashed 1px  #EEEEEE; vertical-align:top;  overflow:hidden; padding:10px; width:<?php echo $module['i_width'];?> ;}
#<?php echo $module['module_name'];?>_html .list .line:hover{ background:#f3f3f3; }
#<?php echo $module['module_name'];?>_html .list .line .icon{ display:inline-block; vertical-align:top; width:35%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .line .icon img{ width:90%; max-height:65px; border:none;}
#<?php echo $module['module_name'];?>_html .list .line .middle{ display:inline-block; vertical-align:top;  overflow:hidden; }
#<?php echo $module['module_name'];?>_html .list .line .middle .title{  display:block; height:25px; overflow:hidden; font-size:16px;white-space:nowrap;text-overflow: ellipsis;  }
#<?php echo $module['module_name'];?>_html .list .line .middle .attributes{ height:22px; font-size:1rem;  overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .line .middle .attributes span{ display:inline-block; padding-right:10px; vertical-align:top;background-image:url(<?php echo get_template_dir(__FILE__);?>img/dividing_line.png); background-repeat:no-repeat; background-position:right; }
#<?php echo $module['module_name'];?>_html .list .line .middle .other .reflash{ display:inline-block; vertical-align:top; margin-right:10px;  overflow:hidden; }
#<?php echo $module['module_name'];?>_html .list .line .middle .other .price{ display:inline-block; vertical-align:top; margin-right:10px;   overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .line .middle .other .price .number{ font-weight:bold;}
</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=module_title style=" display:<?php echo $module['title_show'];?>; "><a class=name href=<?php echo $module['title_link']?>  target="<?php echo $module['target'];?>"><?php echo $module['title'];?></a><a class=more href=<?php echo $module['title_link']?> target="<?php echo $module['target'];?>"><?php echo self::$language['more'];?></a></div>
	
    <?php echo $module['cover_image'];?><div class=list ><?php echo $module['list'];?></div>
    
</div>
</div>