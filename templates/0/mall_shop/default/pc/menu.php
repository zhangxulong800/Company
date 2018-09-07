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
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=center  style=" width:100%;min-width:1170px; ">
<script>
var show_speed=300;
var hide_speed=500;
var timer_1=null;
var timer_2=null;
var navigation_3_width=0;
$(document).ready(function(){
	if(!touchAble){
		$("#<?php echo $module['module_name'];?> .navigation_2").each(function(index, element) {
			$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" a:first").next().css('background-image','url(<?php echo get_template_dir(__FILE__);?>img/navigation2_first_bg.png)');
		});
	}else{
		$("#<?php echo $module['module_name'];?> .navigation_2").each(function(index, element) {
			$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" a:first").css('background-image','url(<?php echo get_template_dir(__FILE__);?>img/navigation2_first_bg.png)');
		});
	}
	if(!touchAble){$('.for_touch').remove();}
	navigation_1_set_current();	
	if(getCookie('navigation_2')){$("#"+getCookie('navigation_2')).addClass('a_current');}
	if(getCookie('navigation_3')){$("#"+getCookie('navigation_3')).addClass('a_current');}
	
	$(".navigation_1 a").click(function(){
		if(touchAble && $("#"+$(this).attr('id')+"_sub").css('display')=='block' && $("#"+$(this).attr('id')+"_sub").html()!=null){
			navigation_hide();
			return false;
		}else{
			$(".navigation_1 a").attr('class','');
			clearTimeout(timer_1);
			clearTimeout(timer_2);
			navigation_hide();
			
			var position=$(this).offset();
			position.width=$(this).width();
			position.height=$(this).height();
			navigation_show($(this).attr('id'),position,'bottom');	
		}
		setCookie('navigation_1',$(this).attr('id'));
		setCookie('navigation_2','');
		setCookie('navigation_3','');
		if(touchAble && $("#"+$(this).attr('id')+"_sub").html()!=null){
			return false;
		}
	});
	$(".navigation_2 a").click(function(){
		if(touchAble && $("#"+$(this).attr('id')+"_sub").css('display')=='block' && $("#"+$(this).attr('id')+"_sub").html()!=null){
			$(".navigation_3").slideUp(hide_speed);
			return false;
		}else{
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
		}
		temp=parseInt($(this).parent().attr('id'));
		setCookie('navigation_1',temp);
		setCookie('navigation_2',$(this).attr('id'));
		setCookie('navigation_3','');
		if(touchAble && $("#"+$(this).attr('id')+"_sub").html()!=null){return false;}
	});
	$(".navigation_3 a").click(function(){
		temp=parseInt($(this).parent().attr('id'));
		setCookie('navigation_2',temp);
		temp=parseInt($("#"+temp).parent().attr('id'));
		setCookie('navigation_1',temp);
		setCookie('navigation_3',$(this).attr('id'));
	});

	if(!touchAble){
		$(".navigation_1 a").hover(function(){
			$(".navigation_1 a").attr('class','');
			$(".navigation_1 a").css('background-image','none');
			clearTimeout(timer_1);
			clearTimeout(timer_2);
			navigation_hide();
			//alert($(this).offset().left);
			var position=$(this).offset();
			position.width=$(this).width();
			position.height=$(this).height();
			navigation_show($(this).attr('id'),position,'bottom');	
			if($("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+'_sub').length>0){
				$(this).css('background-image','url(<?php echo get_template_dir(__FILE__);?>img/navigation_have_sub_hover_bg.png)');	
			}else{
				$(this).css('background-image','url(<?php echo get_template_dir(__FILE__);?>
img/navigation_hover_bg.png)');
			}
			
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
			if($("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+'_sub').length>0){
				if($(this).css('background-image').indexOf("<?php echo get_template_dir(__FILE__);?>img/navigation2_first_bg.png")>-1 || $(this).css('background-image').indexOf("<?php echo get_template_dir(__FILE__);?>img/navigation2_first_sub_hover_bg.png")>-1){
					$(this).css('background-image','url(<?php echo get_template_dir(__FILE__);?>img/navigation2_first_sub_hover_bg.png)');
				}else{
					$(this).css('background-image','url(<?php echo get_template_dir(__FILE__);?>img/navigation2_have_sub_hover_bg.png)');	
				}
				
			}else{
				if($(this).css('background-image').indexOf("<?php echo get_template_dir(__FILE__);?>img/navigation2_first_bg.png")>-1){
					$(this).css('background-image','url(<?php echo get_template_dir(__FILE__);?>img/navigation2_first_hover_bg.png)');

				}else{
					$(this).css('background-image','url(<?php echo get_template_dir(__FILE__);?>img/navigation2_hover_bg.png)');	
				}
			}
			
		},function(){
			if($("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+'_sub').length>0){
				if($(this).css('background-image').indexOf("<?php echo get_template_dir(__FILE__);?>img/navigation2_first_sub_hover_bg.png")>-1){
					//$(this).css('background-image','url(<?php echo get_template_dir(__FILE__);?>img/navigation2_first_bg.png)');
				}else{
					$(this).css('background-image','url(<?php echo get_template_dir(__FILE__);?>img/navigation2_have_sub_hover_bg.png)');	
				}
			}else{
				if($(this).css('background-image').indexOf("<?php echo get_template_dir(__FILE__);?>img/navigation2_first_hover_bg.png")>-1){
					$(this).css('background-image','url(<?php echo get_template_dir(__FILE__);?>img/navigation2_first_bg.png)');

				}else{
					$(this).css('background-image','url(<?php echo get_template_dir(__FILE__);?>img/navigation2_bg.png)');	
				}
			}
			
			
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


		
	}
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
#<?php echo $module['module_name'];?>_html{width:100%; background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation_bg.png); margin-bottom:5px; box-shadow:0px 0px 5px 0px rgba(0,0,0,.3);}
#<?php echo $module['module_name'];?>_html img{height:40px; vertical-align:middle; margin-top:-7px; display:none;}
#<?php echo $module['module_name'];?>_html #navigation_bar{padding:0px; width:100%; height:60px; overflow:hidden;}
#<?php echo $module['module_name'];?>_html #navigation_bar #navigation_start{margin:0px; padding:0px; float:left; display:inline-block;width:0px;height:60px;}
#<?php echo $module['module_name'];?>_html #navigation_bar .navigation_1{ z-index:999;margin:0px; padding:0px;float:none; display:inline-block;width:1170px;;height:60px; }
#<?php echo $module['module_name'];?>_html #navigation_bar #navigation_end{margin:0px; padding:0px;float:right; display:inline-block;width:0px;height:60px; }

#<?php echo $module['module_name'];?>_html #navigation_bar .navigation_1 .a_current{ background-image:url(<?php echo get_template_dir(__FILE__);?>
img/navigation_hover_bg.png);background-repeat:no-repeat; }
#<?php echo $module['module_name'];?>_html #navigation_bar .navigation_1 .a_next{ background-position:-2px;}

#<?php echo $module['module_name'];?>_html #navigation_bar .navigation_1 a{ /*background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation-line.png); background-repeat:no-repeat;*/ display:inline-block;width:210px;  height:100%; line-height:60px;  overflow:hidden;  font-size:20px; text-align:center; }
#<?php echo $module['module_name'];?>_html #navigation_bar .navigation_1 span{ margin-left:5px;}
#<?php echo $module['module_name'];?>_html #navigation_bar .navigation_1 a:hover{ background-image:url(<?php echo get_template_dir(__FILE__);?>
img/navigation_hover_bg.png);background-repeat:no-repeat;  }
#<?php echo $module['module_name'];?>_html .navigation_2{ z-index:999;display:none; width:200px; position:absolute;  margin-left:6px;} 
#<?php echo $module['module_name'];?>_html .navigation_2 .a_current{margin:0px; padding:0px; display:block; width:100%; height:60px; line-height:60px;  overflow:hidden; }
#<?php echo $module['module_name'];?>_html .navigation_2 .a_next{ background-position:0px 0px;}
#<?php echo $module['module_name'];?>_html .navigation_2 a{display:block; width:100%; height:60px; line-height:60px; overflow:hidden; font-size:20px;  background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation2_bg.png); background-repeat:no-repeat; text-align:center;}
#<?php echo $module['module_name'];?>_html .navigation_2 a:hover{/* background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation2_hover_bg.png);*/  line-height:60px; background-repeat:no-repeat;}
#<?php echo $module['module_name'];?>_html .navigation_2 span{ margin-left:5px;}
#<?php echo $module['module_name'];?>_html .navigation_3{ z-index:999;display:none; width:200px; position:absolute;}
#<?php echo $module['module_name'];?>_html .navigation_3 .a_current{margin:0px; padding:0px; display:block; width:100%; height:60px; line-height:60px;  overflow:hidden; padding-left:5px;}
#<?php echo $module['module_name'];?>_html .navigation_3 .a_next{ background-position:0px 0px;}
#<?php echo $module['module_name'];?>_html .navigation_3 a{margin:0px; padding:0px; display:block; width:100%; height:60px; line-height:60px; overflow:hidden; background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation3_bg.png); background-repeat:no-repeat; font-size:20px; text-align:left; padding-left:40px;}
#<?php echo $module['module_name'];?>_html .navigation_3 a:hover{ background-image:url(<?php echo get_template_dir(__FILE__);?>img/navigation3_hover_bg.png); background-repeat:no-repeat; line-height:60px;background-position:0px 0px;}
#<?php echo $module['module_name'];?>_html .navigation_3 span{ margin-left:5px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html" align="center">
    
    <?php echo $module['data'];?>
    
    </div>
</div>

