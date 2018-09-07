<?
/*
变量说明：
-------------------------------------------------------------------------
$module['title']=模块标题no
$module['title_url']=模块标题URL
$module['data']=模块数据，二维数组，数组下标：url,name 使用示例请参考本软件的默认模板defuat
-------------------------------------------------------------------------
*/

?>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
var show_speed=300;
var hide_speed=500;
var timer_1=null;
var timer_2=null;
var navigation_3_width=0;
$(document).ready(function(){

	if(touchAble && getCookie('navigation_1')){
		position=$("#"+getCookie('navigation_1')).offset();
		position.width=$("#"+getCookie('navigation_1')).width();
		position.height=$("#"+getCookie('navigation_1')).height();
		navigation_show($("#"+getCookie('navigation_1')).attr('id'),position,'bottom');	
	}
	if(touchAble && getCookie('navigation_2')){
		position=$("#"+getCookie('navigation_2')).offset();
		position.width=$("#"+getCookie('navigation_2')).width();
		position.height=$("#"+getCookie('navigation_2')).height();
		navigation_show($("#"+getCookie('navigation_2')).attr('id'),position,'right');	
	}

	
	navigation_1_set_current();	
	if(getCookie('navigation_2')){$("#"+getCookie('navigation_2')).addClass('a_current');}
	if(getCookie('navigation_3')){$("#"+getCookie('navigation_3')).addClass('a_current');}
	
	$(".navigation_1 a").click(function(){
		setCookie('navigation_1',$(this).attr('id'));
		setCookie('navigation_2','');
		setCookie('navigation_3','');
	});
	$(".navigation_2 a").click(function(){
		temp=parseInt($(this).parent().attr('id'));
		setCookie('navigation_1',temp);
		setCookie('navigation_2',$(this).attr('id'));
		setCookie('navigation_3','');
	});
	$(".navigation_3 a").click(function(){
		temp=parseInt($(this).parent().attr('id'));
		setCookie('navigation_2',temp);
		temp=parseInt($("#"+temp).parent().attr('id'));
		setCookie('navigation_1',temp);
		setCookie('navigation_3',$(this).attr('id'));
	});

	$(".navigation_1 a").hover(function(){
		$(".navigation_1 a").attr('class','');
		clearTimeout(timer_1);
		clearTimeout(timer_2);
		navigation_hide();
		var position=$(this).offset();
		position.width=$(this).width();
		position.height=$(this).height();
		navigation_show($(this).attr('id'),position,'bottom');	
		
		
	},function(){
		timer_1=setTimeout(function(){navigation_hide();},200);
	});
	$(".navigation_2").hover(function(){
		clearTimeout(timer_1);
		clearTimeout(timer_2);
	},function(){
		timer_1=setTimeout(function(){navigation_hide();},200);
	});
	$(".navigation_2 a").hover(function(){
		$(".navigation_2 a").attr('class','');
		clearTimeout(timer_1);
		clearTimeout(timer_2);
		$(".navigation_3").css('display','none');
		var position=$(this).offset();
		position.width=$(this).width();
		position.height=$(this).height();
		navigation_show($(this).attr('id'),position,'right');
		if(navigation_3_width==0){
			temp=parseInt($("#"+$(this).attr('id')+'_sub').width());
			if(temp>0){navigation_3_width=temp;}
		}
	},function(){
		timer_2=setTimeout(function(){navigation_hide();},200);
	});
	$(".navigation_3").hover(function(){
		clearTimeout(timer_1);
		clearTimeout(timer_2);
	},function(){
		timer_2=setTimeout(function(){navigation_hide();},200);
	});
	$(".navigation_3 a").hover(function(){
		$("#"+$(this).next('a').attr('id')).addClass('a_next');	
	},function(){
		$("#"+$(this).next('a').attr('id')).removeClass('a_next');	
	}
	
	);
});

function navigation_hide(){
	//$("#"+id.next('a').attr('id')).removeClass('a_next');
	$(".navigation_3").slideUp(hide_speed);$(".navigation_2").slideUp(hide_speed);
}
function navigation_show(id,position,direction){
	set_first();
	$("#"+id).addClass('a_current');
	$("#"+$("#"+id).next('a').attr('id')).addClass('a_next');
	if(direction=='right'){
		width=(navigation_3_width==0)?position.width:navigation_3_width;
		left=((position.left+position.width+width)>$('#navigation_bar').width())?position.left-width:position.left+position.width;
		$("#"+id+"_sub").css('left',left).css('top',position.top).slideDown(show_speed);		
	}else{
		$("#"+id+"_sub").css('left',position.left).css('top',position.top+position.height).slideDown(show_speed);
	}
	
}

function navigation_1_set_current(){
	set_first();
	if(getCookie('navigation_1')){
		$("#"+getCookie('navigation_1')).addClass('a_current');
		$("#"+$("#"+getCookie('navigation_1')).next('a').attr('id')).addClass('a_next');
	}else{
		$("#navigation_bar a:first").addClass('a_current');
		$("#"+$("#navigation_bar a:first").next('a').attr('id')).addClass('a_next');
	}

}

function set_first(){
		$("#navigation_bar a:first").addClass('a_next');
		$(".navigation_2").each(function(i,e){
			$("#"+$(this).attr('id')+" a:first").addClass('a_next');
		});
		$(".navigation_3").each(function(i,e){
			$("#"+$(this).attr('id')+" a:first").addClass('a_next');
		});
}


</script>
	<style>
    #<?php echo $module['module_name'];?>_html{width:100%; background-image:url(<?php echo get_template_dir(__FILE__);?>
img/navigation-bg.png); margin-bottom:10px; box-shadow:1px 3px rgba(0,0,0,.2);}
#navigation_bar{padding:0px; width:1170px; height:80px; overflow:hidden;}
#navigation_bar #navigation_start{margin:0px; padding:0px; float:left; display:inline-block;width:0px;height:80px;}
#navigation_bar .navigation_1{ z-index:999;margin:0px; padding:0px;float:none; display:inline-block;width:1170px;;height:80px; text-align:center; font-family:"Microsoft YaHei" font-size:18px; font-weight:bold;}
#navigation_bar #navigation_end{margin:0px; padding:0px;float:right; display:inline-block;width:0px;height:80px; }

#navigation_bar .navigation_1 .a_current{ display:inline-block; width:223px; height:100%; line-height:80px;   text-align:center; overflow:hidden; background-image:url(<?php echo get_template_dir(__FILE__);?>
img/navigation_hover_bg.png);   background-repeat:repeat-x;}
#navigation_bar .navigation_1 .a_next{ background-position:-2px;}

#navigation_bar .navigation_1 a{ background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation-line.png); background-repeat:no-repeat; display:inline-block; width:223px; height:100%; line-height:80px;    text-align:center; overflow:hidden;}
#navigation_bar .navigation_1 a:hover{ background-image:url(<?php echo get_template_dir(__FILE__);?>
img/navigation_hover_bg.png);  background-repeat:repeat-x;}
.navigation_2{ z-index:999;display:none; width:223px; position:absolute; font-family:"Microsoft YaHei";  background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation2_bg.png); }
.navigation_2 .a_current{margin:0px; padding:0px; display:block; width:100%; height:60px; line-height:60px;  overflow:hidden;  text-align:center;}
.navigation_2 .a_next{ background-position:0px -2px;}
.navigation_2 a{margin:0px; padding:0px; display:block; width:100%; height:60px; line-height:60px; overflow:hidden;  text-align:center; background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation2_line.png); background-repeat:no-repeat; }
.navigation_2 a:hover{ background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation2_hover_bg.png);  line-height:60px;}
.navigation_3{ z-index:999;display:none; width:223px; position:absolute; font-family:"Microsoft YaHei";  background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation2_bg.png); }
.navigation_3 .a_current{margin:0px; padding:0px; display:block; width:100%; height:60px; line-height:60px;  overflow:hidden;  text-align:center;}
.navigation_3 .a_next{ background-position:0px -1px;}
.navigation_3 a{margin:0px; padding:0px; display:block; width:100%; height:60px; line-height:60px; overflow:hidden;  text-align:center; background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation2_line.png); background-repeat:no-repeat; }
.navigation_3 a:hover{ background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation2_hover_bg.png);  line-height:60px;background-position:0px 0px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    <?php echo $module['data'];?>
    
    </div>
</div>

