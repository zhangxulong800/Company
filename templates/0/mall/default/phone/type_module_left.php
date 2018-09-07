<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
var mall_type_timer=null;
$(document).ready(function(){
	type_module_left_set_next_div();
	setTimeout('type_module_left_set_next_div()',200);
	
	$("#<?php echo $module['module_name'];?>_html .parent_0_a").click(function(){
		if(touchAble){if(event.target.nodeName=='A'){return false;}}
	});
	
	$("#<?php echo $module['module_name'];?> .parent_0_a").hover(function(){
		clearTimeout(mall_type_timer);
		$("#<?php echo $module['module_name'];?> .sub_2").css('display','none');
		
		$("#<?php echo $module['module_name'];?> #mall_type_"+$(this).attr('id')).css('display','block');
		t_position=$(this).offset();
		position_top=t_position.top+($(this).height()/2)-($("#<?php echo $module['module_name'];?> #mall_type_"+$(this).attr('id')).height()/2);
		position_top=Math.max(position_top,$("#<?php echo $module['module_name'];?>").offset().top);
		$("#<?php echo $module['module_name'];?> #mall_type_"+$(this).attr('id')).css('left',t_position.left+$(this).width()+10).css('top',position_top);
		
	},function(){
		mall_type_timer=setTimeout(function(){mall_type_hide();},200);
	});
	$("#<?php echo $module['module_name'];?> .sub_2").hover(function(){
		clearTimeout(mall_type_timer);
		id=$(this).attr('id').replace(/mall_type_/,'');
		$("#<?php echo $module['module_name'];?> #"+id).addClass('a_hover');
	},function(){
		$("#<?php echo $module['module_name'];?> #"+id).removeClass('a_hover');
		mall_type_timer=setTimeout(function(){mall_type_hide();},300);
	});
	
	
});
function mall_type_hide(){
	$("#<?php echo $module['module_name'];?> .sub_2").css('display','none');
}

function type_module_left_set_next_div(){
	//alert($("#<?php echo $module['module_name'];?>").next('div').attr('id'));
	$("#<?php echo $module['module_name'];?>").next('div').css('display','inline-block').css('width',1081).css('overflow','hidden');
}
</script>
<style>
#<?php echo $module['module_name'];?>{ width:253px; height:450px; overflow:hidden; vertical-align:top;  border-top:1px solid #e7e7e7; border-bottom:1px solid #e7e7e7; display:inline-block; vertical-align:top; background-image:url(<?php echo get_template_dir(__FILE__);?>img/type_module_left_bg.png);}
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html .parent_0{}
#<?php echo $module['module_name'];?>_html .parent_0 a{ display:block; text-align:left; height:40px; line-height:40px; border-bottom:1px dotted #e7e7e7; width:240px; overflow:hidden; padding-left:10px;}
#<?php echo $module['module_name'];?>_html .parent_0 a:hover{background-image:url(<?php echo get_template_dir(__FILE__);?>img/type_module_left_hover.png); background-position:right;  border-bottom:1px solid #fff;}
#<?php echo $module['module_name'];?>_html .parent_0 .a_hover{background-image:url(<?php echo get_template_dir(__FILE__);?>img/type_module_left_hover.png); background-position:right;  border-bottom:1px solid #fff;}
#<?php echo $module['module_name'];?>_html .parent_0 .icon { height:40px; display:inline-block; vertical-align:top; width:30px; border:0px;}
#<?php echo $module['module_name'];?>_html .parent_0 .icon img{ height:30px; width:30px; margin-top:5px; border:0px;}
#<?php echo $module['module_name'];?>_html .parent_0 .name{ border-bottom:1px solid #f0f0f0; margin-left:10px; display:inline-block; vertical-align:top; line-height:40px; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .parent_0 .more{background-image:url(<?php echo get_template_dir(__FILE__);?>img/more_icon.png); background-repeat:no-repeat; line-height:40px;}
#<?php echo $module['module_name'];?>_html .parent_0 .more:hover{background-image:url(<?php echo get_template_dir(__FILE__);?>img/more_icon.png); background-repeat:no-repeat; line-height:40px;   background-position:left;}

#<?php echo $module['module_name'];?>_html .sub_2{ display:none; position:absolute; z-index:999;  min-height:127px;  max-width:800px; box-shadow:1px 0px 3px 0px rgba(0,0,0,.2); padding-right:20px; border:1px solid #e7e7e7; border-left:none; white-space:nowrap;}
#<?php echo $module['module_name'];?>_html .sub_2 .line{ display:block; line-height:30px;; line-height:40px; border-bottom:1px solid #f0f0f0;  }
#<?php echo $module['module_name'];?>_html .sub_2 .line:hover{ }
#<?php echo $module['module_name'];?>_html .sub_2 .sub2_a{display:inline-block; vertical-align:top; font-size:1rem; margin-left:10px; margin-right:5px;width:110px; text-align:right;  line-height:29px; margin-top:2px; font-weight:bold; overflow:hidden; white-space:nowrap;text-overflow:ellipsis;}
#<?php echo $module['module_name'];?>_html .sub_2 .sub2_a:hover{ }
#<?php echo $module['module_name'];?>_html .sub_2 .sub_3{ display:inline-block; vertical-align:top; vertical-align:top; width:720px; line-height:25px; font-size:1rem; margin-top:6px; font-family:"SimSun"; margin-left:10px;white-space:normal;}
#<?php echo $module['module_name'];?>_html .sub_2 .sub_3 a{  display:inline-block; vertical-align:top; width:150px; padding-left:15px; padding-right:15px; height:15px; line-height:15px; height:15px; overflow:hidden;  white-space:nowrap;text-overflow:ellipsis;}
#<?php echo $module['module_name'];?>_html .sub_2 .sub_3 a:hover{ }

</style>
<div id="<?php echo $module['module_name'];?>_html">
	<div class=parent_0>
	<?php echo $module['parent_0'];?>
    <a href="./index.php?monxin=mall.show_type" class=more><span class=icon>&nbsp;</span><span class=name><?php echo  self::$language['more']?><?php echo  self::$language['type']?></span></a>
    </div>
    <?php echo $module['sub'];?>
</div>
</div>