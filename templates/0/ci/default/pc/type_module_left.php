<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
var ci_type_timer=null;
$(document).ready(function(){
	$(".page-header #<?php echo $module['module_name'];?>").css('left',$("#mall_type_all").offset().left+1).css('top',$("#mall_type_all").offset().top+$("#mall_type_all").height());
	$("#mall_type_all").html('<a href=./index.php?monxin=ci.show_type><span><?php echo self::$language['info']?><?php echo self::$language['type']?></span></a>');
	type_module_left_set_next_div();
	setTimeout('type_module_left_set_next_div()',200);
	
	$("#<?php echo $module['module_name'];?>_html .parent_0_a").click(function(){
		if(touchAble){if(event.target.nodeName=='A'){return false;}}
	});
	
	if($(".page-header #<?php echo $module['module_name'];?> .parent_0_a").html()){
		$(".page-header #<?php echo $module['module_name'];?> .parent_0_a").hover(function(){
			clearTimeout(ci_type_timer);
			$("#<?php echo $module['module_name'];?> .sub_2").css('display','none');
			$("#<?php echo $module['module_name'];?>_html .parent_0 a").removeClass('a_hover');
			$("#<?php echo $module['module_name'];?> #ci_type_"+$(this).attr('id')).css('display','block');
			t_position=$(this).offset();
			position_top=$(this).index()*$(this).height();
			if(parseInt(position_top)+parseInt($("#<?php echo $module['module_name'];?> #ci_type_"+$(this).attr('id')).height() )<parseInt($(this).parent().height())){
			}else{
				position_top=0;	
			}
			$("#<?php echo $module['module_name'];?> #ci_type_"+$(this).attr('id')).css('left',$(this).parent().width()-1).css('top',position_top);
			
		},function(){
			ci_type_timer=setTimeout(function(){ci_type_hide();},200);
		});
	}else{
		$("#<?php echo $module['module_name'];?> .parent_0_a").hover(function(){
			clearTimeout(ci_type_timer);
			$("#<?php echo $module['module_name'];?> .sub_2").css('display','none');
			$("#<?php echo $module['module_name'];?>_html .parent_0 a").removeClass('a_hover');
			$("#<?php echo $module['module_name'];?> #ci_type_"+$(this).attr('id')).css('display','block');
			t_position=$(this).offset();
			position_top=t_position.top+($(this).height()/2)-($("#<?php echo $module['module_name'];?> #ci_type_"+$(this).attr('id')).height()/2);
			position_top=Math.max(position_top,$("#<?php echo $module['module_name'];?>").offset().top);
			$("#<?php echo $module['module_name'];?> #ci_type_"+$(this).attr('id')).css('left',t_position.left+$(this).width()+9).css('top',position_top);
			
		},function(){
			ci_type_timer=setTimeout(function(){ci_type_hide();},200);
		});
	}
	
	
	
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

function type_module_left_set_next_div(){
	//alert($("#<?php echo $module['module_name'];?>").next('div').attr('id'));
	$("#<?php echo $module['module_name'];?>").next('div').css('display','inline-block').css('width',$("[m_container]").width()-$("#<?php echo $module['module_name'];?>").width()-3).css('overflow','hidden').css('margin-left','-5px').css('margin-top','-1px');
	$("#<?php echo $module['module_name'];?>").next('div').css('height',$("#<?php echo $module['module_name'];?>").height());
	$('#mySwipe').css('height',$("#<?php echo $module['module_name'];?>").height());
	$(".w_1680 #<?php echo $module['module_name'];?>").next('div').css('display','inline-block').css('width',$("[m_container]").width()-$("#<?php echo $module['module_name'];?>").width()+6).css('overflow','hidden').css('margin-left','-18px');
$(".w_1400 #<?php echo $module['module_name'];?>").next('div').css('display','inline-block').css('width',$("[m_container]").width()-$("#<?php echo $module['module_name'];?>").width()+6).css('overflow','hidden').css('margin-left','-18px');
	$("#mySwipe").width($("#<?php echo $module['module_name'];?>").next('div').width()).css('margin-left',0);
	$(".w_1680 #mySwipe").width($("#<?php echo $module['module_name'];?>").next('div').width()).css('margin-left',-200);
	$(".w_1400 #mySwipe").width($("#<?php echo $module['module_name'];?>").next('div').width()).css('margin-left',-90);
	$(".swiper-container").width($("#mySwipe").width()).height($("#mySwipe").height());
	$(".swiper-container .swiper-wrapper div").width($("#mySwipe").width()).height($("#mySwipe").height());
	$(".swiper-container .swiper-wrapper div img").width($("#mySwipe").width()).height($("#mySwipe").height());
	mySwiper.resizeFix();
 	mySwiper.reInit();
	
}
</script>
<style>
#<?php echo $module['module_name'];?>{font-weight:normal; text-indent:0px;  width:17.85rem; height:32.14rem; vertical-align:top;  border-top:1px solid #e8e8e8; border-bottom:1px solid #e8e8e8; display:inline-block; vertical-align:top; background-color:#fcfcfc;padding:0px;box-shadow:none;margin:0px;}
.page-header #<?php echo $module['module_name'];?>{ position:absolute;left:90px; top:228px; z-index:9999999999999999999999999999999999; background:rgba(255,255,255,0.8);}
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html .parent_0{}
#<?php echo $module['module_name'];?>_html .parent_0 a{ display:block; text-align:left; height:2.85rem line-height:2.85rem; border-bottom:1px dashed #fff; overflow:hidden; padding-left:10px; white-space:nowrap;}
#<?php echo $module['module_name'];?>_html .parent_0 a:hover{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .parent_0 a:hover:after{font: normal normal normal 3rem/1 FontAwesome; content:"\f0d9";color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .parent_0 .a_hover{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .parent_0 .a_hover:after{font: normal normal normal 3rem/1 FontAwesome; content:"\f0d9";color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .parent_0 .icon { text-align:right; height:2.85rem; display:inline-block; vertical-align:top; width:15%; overflow:hidden; border:0px;}
#<?php echo $module['module_name'];?>_html .parent_0 .icon img{ height:30px; width:30px; margin-top:5px; border:0px; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; border-radius:25%;}
#<?php echo $module['module_name'];?>_html .parent_0 .name{  margin-left:10px; display:inline-block; vertical-align:top; line-height:2.85rem; width:75%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .parent_0 .more{}
#<?php echo $module['module_name'];?>_html .parent_0 .more:hover{}

#<?php echo $module['module_name'];?>_html .sub_2{ display:none; position:absolute; z-index:999;  min-height:127px;  max-width:800px; box-shadow:1px 0px 3px 0px rgba(0,0,0,.2); padding-right:20px; border-left:none; white-space:nowrap;background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .sub_2 a{ display:inline-block; line-height:2rem; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .sub_2 .line{ display:block; line-height:30px;; line-height:2.85rem; border-bottom:1px dashed #fff;  }
#<?php echo $module['module_name'];?>_html .sub_2 .line:hover{ }
#<?php echo $module['module_name'];?>_html .sub_2 .sub2_a{display:inline-block; vertical-align:top;margin-left:10px; margin-right:5px;width:110px; text-align:right;  line-height:29px; margin-top:2px; overflow:hidden; white-space:nowrap;text-overflow:ellipsis; font-size:1.1rem;}
#<?php echo $module['module_name'];?>_html .sub_2 .sub2_a:hover{background:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .sub_2 .sub_3{ display:inline-block; vertical-align:top; vertical-align:top; width:720px; line-height:25px; font-size:1rem; margin-top:6px; font-family:"SimSun"; margin-left:10px;white-space:normal;}
#<?php echo $module['module_name'];?>_html .sub_2 .sub_3 a{  display:inline-block; vertical-align:top; width:150px; padding-left:15px; padding-right:15px;  overflow:hidden;  white-space:nowrap;text-overflow:ellipsis; font-size:1rem;}
#<?php echo $module['module_name'];?>_html .sub_2 .sub_3 a:hover{background:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['text']?>; }

</style>
<div id="<?php echo $module['module_name'];?>_html">
	<div class=parent_0>
	<?php echo $module['parent_0'];?>
    <a href="./index.php?monxin=ci.show_type" class=more><span class=icon><img src=./program/ci/type_icon/more.png /></span><span class=name><?php echo  self::$language['more']?><?php echo  self::$language['type']?></span></a>
    </div>
    <?php echo $module['sub'];?>
</div>
</div>