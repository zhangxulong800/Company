<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
var ci_type_timer=null;
$(document).ready(function(){
	
	$("#<?php echo $module['module_name'];?>_html .parent_0_a").click(function(){
		if(touchAble && $("#ci_type_"+$(this).attr('id')).html().length>10){if(event.target.nodeName=='A'){return false;}}
		if($("#ci_type_"+$(this).attr('id')).html().length>10){return false;}
		
	});
	$("#<?php echo $module['module_name'];?>_html .sub2_a").click(function(){
		if($(this).next("div[class=sub_3]").html().length>10){return false;}
		
	});
	
	$("#<?php echo $module['module_name'];?> .parent_0_a").hover(function(){
		clearTimeout(ci_type_timer);
		$("#<?php echo $module['module_name'];?> .sub_2").css('display','none');
		
		$("#<?php echo $module['module_name'];?> #ci_type_"+$(this).attr('id')).css('display','block');
		t_position=$(this).offset();
		position_top=t_position.top+($(this).height()/2)-($("#<?php echo $module['module_name'];?> #ci_type_"+$(this).attr('id')).height()/2);
		position_top=Math.max(position_top,$("#<?php echo $module['module_name'];?>").offset().top);
		$("#<?php echo $module['module_name'];?> #ci_type_"+$(this).attr('id')).css('left',t_position.left+$(this).width()+10).css('top',position_top);
		
	},function(){
		ci_type_timer=setTimeout(function(){ci_type_hide();},200);
	});
	$("#<?php echo $module['module_name'];?> .sub_2").hover(function(){
		clearTimeout(ci_type_timer);
		id=$(this).attr('id').replace(/ci_type_/,'');
		$("#<?php echo $module['module_name'];?> #"+id).addClass('a_hover');
	},function(){
		$("#<?php echo $module['module_name'];?> #"+id).removeClass('a_hover');
		ci_type_timer=setTimeout(function(){ci_type_hide();},300);
	});
	
	
});
function ci_type_hide(){
	$("#<?php echo $module['module_name'];?> .sub_2").css('display','none');
}

</script>
<style>
.process{  line-height:60px; margin-bottom:10px;}
.process span{ display:inline-block; width:29%; border-bottom: #EAEAEA solid 3px; margin-right:2%;}
.process .current{ border-bottom:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> solid 3px;}
#<?php echo $module['module_name'];?>{  }
#<?php echo $module['module_name'];?>_html{ border:#CCC  1px solid; width:15rem;}
#<?php echo $module['module_name'];?>_html .parent_0{}
#<?php echo $module['module_name'];?>_html .parent_0 a{ display:block; text-align:left; height:40px; line-height:40px; border-bottom:1px dotted #e7e7e7; width:190px; overflow:hidden; padding-left:10px;}
#<?php echo $module['module_name'];?>_html .parent_0 a:hover{  background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .parent_0 .a_hover{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .parent_0 a:hover:after{ font: normal normal normal 1.5rem/1 FontAwesome; content:"\f0d9"; float:right; margin-top:0.5rem; margin-right:-1px;color:f9f9f9;}
#<?php echo $module['module_name'];?>_html .parent_0 .a_hover:after{font: normal normal normal 1.5rem/1 FontAwesome; content:"\f0d9"; float:right; margin-top:0.5rem; margin-right:-1px; color:f9f9f9;}
#<?php echo $module['module_name'];?>_html .parent_0 .icon { height:40px; display:inline-block; vertical-align:top; width:30px; border:0px;}
#<?php echo $module['module_name'];?>_html .parent_0 .icon img{ height:30px; width:30px; margin-top:5px; border:0px; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; border-radius:0.5rem;}
#<?php echo $module['module_name'];?>_html .parent_0 .name{ border-bottom:1px solid #f0f0f0; margin-left:10px; display:inline-block; vertical-align:top; line-height:40px; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .parent_0 .more{ line-height:40px;}
#<?php echo $module['module_name'];?>_html .parent_0 .more:hover{line-height:40px;   background-position:left;}

#<?php echo $module['module_name'];?>_html .sub_2{ display:none; position:absolute; z-index:999;  min-height:127px;  max-width:800px; box-shadow:1px 0px 3px 0px rgba(0,0,0,.2); padding-right:20px; border:1px solid #e7e7e7; border-left:none; white-space:nowrap; background:#f9f9f9;}
#<?php echo $module['module_name'];?>_html .sub_2 a:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .sub_2 .line{ display:block; line-height:30px;; line-height:40px; border-bottom:1px solid #f0f0f0;  }
#<?php echo $module['module_name'];?>_html .sub_2 .line:hover{ }
#<?php echo $module['module_name'];?>_html .sub_2 .sub2_a{display:inline-block; vertical-align:top; font-size:1rem; margin-left:10px; margin-right:5px;width:110px; text-align:right;  line-height:29px; margin-top:2px; font-weight:bold;}
#<?php echo $module['module_name'];?>_html .sub_2 .sub2_a:hover{ }
#<?php echo $module['module_name'];?>_html .sub_2 .sub_3{ display:inline-block; vertical-align:top; vertical-align:top; width:720px; line-height:25px; font-size:1rem; margin-top:6px; font-family:"SimSun"; margin-left:10px;white-space:normal;}
#<?php echo $module['module_name'];?>_html .sub_2 .sub_3 a{  display:inline-block; vertical-align:top; width:150px; padding-left:15px; padding-right:15px; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .sub_2 .sub_3 a:hover{ }

</style>
<div class="process"><span id=step_1 class=current><?php echo self::$language['step_1'];?></span><span id=step_2><?php echo self::$language['step_2'];?></span><span id=step_3><?php echo self::$language['step_3'];?></span></div>

<div id="<?php echo $module['module_name'];?>_html">
	<div class=parent_0>
	<?php echo $module['parent_0'];?>
    </div>
    <?php echo $module['sub'];?>
</div>
</div>