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
var navigation_2_width=0;
var navigation_3_width=0;

var navigation_2_default_show=false;//二级导航条，默认是否显示
var navigation_3_default_show=false;//三级导航条，默认是否显示
var navigation_3_arrangement='horizontal';//三级导航条，排列方式 vertical or horizontal
if(navigation_3_arrangement=='vertical'){navigation_3_default_show=false;}
$(document).ready(function(){
	
	if(navigation_2_default_show){$("#default_sub_2").css('display','block');}
	if(navigation_3_default_show){$("#default_sub_3").css('display','block');}
	if((touchAble || navigation_2_default_show) && (getCookie('navigation_1'))){
		position=$("#"+getCookie('navigation_1')).offset();
		position.width=$("#"+getCookie('navigation_1')).width();
		position.height=$("#"+getCookie('navigation_1')).height();
		navigation_show($("#"+getCookie('navigation_1')).attr('id'),position);	
	}
	if((touchAble || navigation_3_default_show) && (getCookie('navigation_2'))){
		position=$("#"+getCookie('navigation_2')).offset();
		position.width=$("#"+getCookie('navigation_2')).width();
		position.height=$("#"+getCookie('navigation_2')).height();
		navigation_show($("#"+getCookie('navigation_2')).attr('id'),position);	
	}
	
	//monxin_alert(getCookie('navigation_1'));
	if(getCookie('navigation_1')){$("#"+getCookie('navigation_1')).addClass('a_current');}else{$("#navigation_bar a:first").addClass('a_current');}
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
		$(".navigation_1 a").removeClass('a_current');
		$(this).addClass('a_current');
		clearTimeout(timer_1);
		clearTimeout(timer_2);
		navigation_hide(2);
		navigation_hide(3);
		var position=$(this).offset();
		position.width=$(this).width();
		position.height=$(this).height();
		navigation_show($(this).attr('id'),position);	
		if(navigation_2_width==0){
			temp=parseInt($("#"+$(this).attr('id')+'_sub a').width());
			if(temp>0){navigation_2_width=temp;}
		}
	},function(){
		timer_1=setTimeout(function(){navigation_hide(2);navigation_hide(3);},200);
	});
	$(".navigation_2").hover(function(){
		clearTimeout(timer_1);
		clearTimeout(timer_2);
	},function(){
		if(!navigation_2_default_show){timer_2=setTimeout(function(){navigation_hide(2);navigation_hide(3);},200);}
	});
	$(".navigation_2 a").hover(function(){
		$(".navigation_2 a").removeClass('a_current');
		$(this).addClass('a_current');
		clearTimeout(timer_1);
		clearTimeout(timer_2);
		$(".navigation_3").css('display','none');
		var position=$(this).offset();
		position.width=$(this).width();
		position.height=$(this).height();
		navigation_show($(this).attr('id'),position);
		if(navigation_3_width==0){
			temp=parseInt($("#"+$(this).attr('id')+'_sub a').width());
			if(temp>0){navigation_3_width=temp;}
		}
	},function(){
		//if(!navigation_2_default_show){timer_2=setTimeout(function(){navigation_hide(3);},200);}
	});
	
	
	$(".navigation_3").hover(function(){
		clearTimeout(timer_1);
		clearTimeout(timer_2);
	},function(){
		if(!navigation_2_default_show){timer_2=setTimeout(function(){navigation_hide(2);navigation_hide(3);},200);}
		if(!navigation_3_default_show){timer_2=setTimeout(function(){navigation_hide(3);},200);}
	});
	
	$(".navigation_3 a").hover(function(){
		$(".navigation_3 a").removeClass('a_current');	
	});
	
});

function navigation_hide(v){
	if(v==2){
		$(".navigation_2").css('display','none');
		//$('#state').html(navigation_2_default_show);
		if(!navigation_2_default_show){
			$("#default_sub_2").css('display','none');
		}else{
			$("#default_sub_2").css('display','block');
		}
	}
	if(v==3){
		$(".navigation_3").css('display','none');
		if(!navigation_3_default_show){
			$("#default_sub_3").css('display','none');
		}else{
			$("#default_sub_3").css('display','block');
		}
	}
	
}
function navigation_show(id,position){
	if($("#"+id+"_sub").html()!=null){
		//monxin_alert($("#"+id+"_sub").attr('class'));
		if($("#"+id+"_sub").attr('class')=='navigation_3'){
			$(".navigation_2").css('display','none');
			$("#"+id).parent().css('display','block');

			$("#default_sub_3").css('display','none');
			if(navigation_3_arrangement=='horizontal'){
				horizontal_show(id,position);	
			}else{
				vertical_show(id,position);	
			}
		}else{
			$("#default_sub_2").css('display','none');
			horizontal_show(id,position);
		}
	}else{
		if($("#"+id).parent().attr('class')=='navigation_2' && navigation_3_default_show){$("#default_sub_3").css('display','block');}
		if($("#"+id).parent().attr('class')=='navigation_1' && navigation_2_default_show){$("#default_sub_2").css('display','block');}
	}
	
}

function horizontal_show(id,position){
	sub_size=$("#"+id+"_sub a").size();
	if($("#"+id+"_sub").attr('class')=='navigation_2'){
		temp_width=(navigation_2_width==0)?$("#"+id).width():navigation_2_width;
	}else{
		temp_width=(navigation_3_width==0)?$("#"+id).width():navigation_3_width;
	}
	sub_width=sub_size*temp_width;	
	parent_offset=$("#"+id+"_sub").parent().offset();	
	if($("#"+id+"_sub").attr('class')=='navigation_2' && !navigation_2_default_show){
		$("#"+id+"_sub").css('position','absolute').css('top',position.top+position.height);
		$("#"+id+"_sub").css('left',parseInt(parent_offset.left));			
	}
	if($("#"+id+"_sub").attr('class')=='navigation_3' && !navigation_3_default_show){
		$("#"+id+"_sub").css('position','absolute').css('top',position.top+position.height);
	}
	parent_in=((position.left+(position.width/2))>( $('#navigation_bar').width() /2))?'right':'left';
	padding_left=0;
	if(sub_size==1){padding_left=position.left;}
	if(parent_in=='left'){
		if(sub_size==2){padding_left=position.left;}
		if(sub_size==3){padding_left=(position.left>=temp_width)?position.left-temp_width:position.left;}
		if(sub_size>3){padding_left=$("#navigation_bar a:first").offset().left;}
	}else{
		if(sub_size==2){padding_left=position.left-temp_width;}
		if(sub_size==3){padding_left=( (position.left+(position.width*2))>=$('#navigation_bar').width())?position.left-(temp_width*2):position.left-temp_width;}
		if(sub_size>3){
			padding_left=Math.min($('#navigation_bar').width(),$("#navigation_bar a:last").offset().left+temp_width)-(sub_size*temp_width);
			padding_left=Math.max(padding_left,$("#navigation_bar a:first").offset().left);
			}

	}
	$("#"+id+"_sub a:first").css({'margin-left':padding_left-parseInt(parent_offset.left)});
	
	//$("#"+id+"_sub").slideDown(show_speed);
	$("#"+id+"_sub").css('display','block');
	$("#"+id+"_sub").css('left',parent_offset.left);

}
function vertical_show(id,position){
	$("#"+id+"_sub").css('position','absolute').css('left',position.left).css('top',position.top+position.height).slideDown(show_speed);
}
</script>
	<style>
	/*注意 子栏目宽度不能大于父栏目,建议宽度一致. 所有标签的margin设置为0px;*/
    #<?php echo $module['module_name'];?>_html{width:100%;}
#navigation_bar{margin:0px; padding:0px; width:990px; height:40px; overflow:hidden; }
#navigation_bar #navigation_start{margin:0px; padding:0px; float:left; display:inline-block;width:40px;height:40px;}
#navigation_bar .navigation_1{ z-index:999;margin:0px; padding:0px;float:none; display:inline-block;width:910px;;height:40px; }
#navigation_bar #navigation_end{margin:0px; padding:0px;float:right; display:inline-block;width:40px;height:40px; }

#navigation_bar .navigation_1 .a_current{ display:inline-block; width:150px; height:100%; line-height:40px;     text-align:center; overflow:hidden;}
#navigation_bar .navigation_1 a{ display:inline-block; width:150px; height:100%; line-height:40px;     text-align:center; overflow:hidden;}
#navigation_bar .navigation_1 a:hover{ }
.navigation_2{ margin:0px; padding:0px;z-index:999;display:none; width:990px; height:35px; overflow:hidden; }
.navigation_2 .a_current{margin:0px; padding:0px; display:inline-block; width:150px; height:35px; line-height:35px;   overflow:hidden;  text-align:center;}
.navigation_2 a{margin:0px; padding:0px; display:inline-block; width:150px; height:35px; line-height:35px;   overflow:hidden;  text-align:center;}
.navigation_2 a:hover{ }
.navigation_3{margin:0px; padding:0px;z-index:999; display:none; width:990px; height:35px; overflow:hidden;}
.navigation_3 .a_current{margin:0px; padding:0px; display:inline-block; width:150px; height:35px; line-height:35px;   overflow:hidden;  text-align:center;}
.navigation_3 a{margin:0px; padding:0px; display:inline-block; width:150px; height:35px; line-height:35px;   overflow:hidden;  text-align:center;}
.navigation_3 a:hover{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <?php echo $module['data'];?>
 <div class="navigation_2" id="default_sub_2"><?php echo $module['default_sub_2_data']?></div>   
 <div class="navigation_2" id="default_sub_3"><?php echo $module['default_sub_3_data']?></div>   
    </div>
</div>

