<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
var mall_type_timer=null;
$(document).ready(function(){
	url=window.location.href;
	if(url.indexOf('monxin=mall.index')>0 || url.indexOf('monxin=')<0){
		type_module_left_set_next_div();
		setTimeout('type_module_left_set_next_div()',200);
	}else{
		$("#mall_type_module_two").insertAfter("#index_navigation #mall_type_all .text");
		$("#mall_type_module_two").css('left',$("#mall_type_all").offset().left);
		$("#mall_type_module_two").css('top',$("#mall_type_all").offset().top+$("#mall_type_all").height());
	}
});
function type_module_left_set_next_div(){
	//alert($("#<?php echo $module['module_name'];?>").next('div').attr('id'));
	$("#<?php echo $module['module_name'];?>").next('div').css('display','inline-block').css('width',$("[m_container]").width()-$("#<?php echo $module['module_name'];?>").width()+4).css('overflow','hidden').css('margin-left','-12px').css('margin-top','-1px');
	$("#<?php echo $module['module_name'];?>").next('div').css('height',$("#<?php echo $module['module_name'];?>").height());
	$('#mySwipe').css('height',$("#<?php echo $module['module_name'];?>").height());
	$(".w_1680 #<?php echo $module['module_name'];?>").next('div').css('display','inline-block').css('width',$("[m_container]").width()-$("#<?php echo $module['module_name'];?>").width()+6).css('overflow','hidden').css('margin-left','-18px');
	$("#mySwipe").width($("#<?php echo $module['module_name'];?>").next('div').width()).css('margin-left',0);
	$(".w_1680 #mySwipe").width($("#<?php echo $module['module_name'];?>").next('div').width()).css('margin-left',-200);
	$(".swiper-container").width($("#mySwipe").width()).height($("#mySwipe").height());
	$(".swiper-container .swiper-wrapper div").width($("#mySwipe").width()).height($("#mySwipe").height());
	$(".swiper-container .swiper-wrapper div img").width($("#mySwipe").width()).height($("#mySwipe").height());
	mySwiper.resizeFix();
 	mySwiper.reInit();
	
}
</script>
<style>
#<?php echo $module['module_name'];?>{font-weight:normal; text-indent:0px;  width:17.85rem; height:32.14rem; vertical-align:top;  border-top:1px solid #e8e8e8; border-bottom:1px solid #e8e8e8; display:inline-block; vertical-align:top; padding:0px;box-shadow:none;margin:0px;}
#<?php echo $module['module_name'];?>_html{}

#<?php echo $module['module_name'];?>_html .more{ padding-left:8px; line-height:30px;}
#<?php echo $module['module_name'];?>_html .parent{  height:4.9rem; line-height:2rem; border-bottom: #e8e8e8 1px solid; }
#<?php echo $module['module_name'];?>_html .parent .level_1_div{ padding-left:10px;}

#<?php echo $module['module_name'];?>_html .parent:hover{position: relative;z-index:991;border-left:0.15rem solid #F00;  }
#<?php echo $module['module_name'];?>_html .parent:hover .part_b_div{ display:block;}
#<?php echo $module['module_name'];?>_html .parent:hover .level_1_div .level_1:after{ display:none;}

#<?php echo $module['module_name'];?>_html .parent:hover  .level_1_div{ }
#<?php echo $module['module_name'];?>_html .parent:hover  .level_1_div .level_1{background-image:none; }

#<?php echo $module['module_name'];?>_html .parent:hover .part_a_div{ }

#<?php echo $module['module_name'];?>_html .parent .level_1_div .level_1{ display:block; font-size:16px; position: relative; z-index:991;}
#<?php echo $module['module_name'];?>_html .parent .level_1_div .level_1:after{margin-right:8px; float:right; font: normal normal normal 1rem/1 FontAwesome; content:"\f105"; padding-top:5px; }

#<?php echo $module['module_name'];?>_html .parent .level_1_div .level_1 a{}
#<?php echo $module['module_name'];?>_html .parent .level_1_div .part_a_div a{}




#<?php echo $module['module_name'];?>_html .parent .level_1_div .part_a_div{position: relative;z-index:991; width:100%; padding-bottom:0.8rem;  }
#<?php echo $module['module_name'];?>_html .parent .level_1_div .part_a_div .level_2{font-size:15px; display:inline-block; vertical-align:top; height:25px; width:29%;margin-right:4%; overflow:hidden;white-space:nowrap;text-overflow:ellipsis;}
#<?php echo $module['module_name'];?>_html .parent .level_1_div .part_a_div:hover{ }
#<?php echo $module['module_name'];?>_html .parent .level_1_div .part_a_div .level_2:hover{ display:inline-block;}

#<?php echo $module['module_name'];?>_html .parent .part_b_div{ padding-left:20px; display:none; position: relative; padding-top:25px; left:17.5rem; top:-4.85rem; min-height:4.9rem; width:32.14rem;  z-index:99;  border:1px solid #e8e8e8; white-space:normal;}
#<?php echo $module['module_name'];?>_html .parent  .part_b_div .level_2{ font-size:15px; display:inline-block; vertical-align:top; width:120px; margin-right:20px; height:35px; line-height:35px;  overflow:hidden;white-space:nowrap;text-overflow:ellipsis;}
#<?php echo $module['module_name'];?>_html .parent  .part_b_div .level_2:hover{}
</style>
<script>
	url=window.location.href;
	if(url.indexOf('monxin=mall.index')>0 || url.indexOf('monxin=')<0){
		document.write('<style>#<?php echo $module['module_name'];?>{display:inline-block; vertical-align:top;}</style>');
	}else{
		//document.write('<style>#<?php echo $module['module_name'];?>{ display:none;}</style>');	
	}
</script>    
<div id="<?php echo $module['module_name'];?>_html">
    <?php echo $module['html'];?>
	<a href="./index.php?monxin=mall.show_type" class=more><span class=icon> </span><span class=name><?php echo  self::$language['more']?><?php echo  self::$language['type']?></span></a>
</div>
</div>