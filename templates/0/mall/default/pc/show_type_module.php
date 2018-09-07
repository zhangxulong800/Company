<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	if($("#<?php echo $module['module_name'];?>").parent('div').width()<500){$("#<?php echo $module['module_name'];?>").css('display','block');}
	$("#<?php echo $module['module_name'];?> #type_"+get_param('type')).attr('class','current_type');
	$("#<?php echo $module['module_name'];?> #type_"+get_param('type')).next('.type_deep_2').css('display','block');
	$("#<?php echo $module['module_name'];?> .type a p").each(function(index, element) {
        if($("#"+$(this).parent().attr('id')+"_div").html().length==0){
			$(this).css('display','none');
		}else{
			if($("#"+$(this).parent().attr('id')+"_div").css('display')=='block'){
				$(this).attr('class','hide_sub');
			}else{
				$(this).attr('class','show_sub');
			}
		}
    });
	
	monxin=get_param('monxin');
	if(monxin=='shop.goods_list' && get_param('type')!=''){
		$("#<?php echo $module['module_name'];?> #type_"+get_param('type')).parent().css('display','block');
		temp=$("#<?php echo $module['module_name'];?> #type_"+get_param('type')).parent().attr('id');
		if(temp){
			temp=temp.replace(/_div/,'');
			$("#<?php echo $module['module_name'];?> #"+temp).attr('class','current_type');	
		}
			
		$("#<?php echo $module['module_name'];?> #type_"+get_param('type')).parent().parent().css('display','block');	
		temp=$("#<?php echo $module['module_name'];?> #type_"+get_param('type')).parent().parent().attr('id');
		if(temp){
			temp=temp.replace(/_div/,'');
			$("#<?php echo $module['module_name'];?> #"+temp).attr('class','current_type');	
		}
		
	}
	
	$("#<?php echo $module['module_name'];?> .type a p").click(function(){
		
		if($(this).parent().next('div').css('display')=='none'){
			$(this).parent().next('div').css('display','block');
			$(this).attr('class','hide_sub');	
		}else{
			$(this).parent().next('div').css('display','none');
			$(this).attr('class','show_sub');
		}
		return false;	
	});
	
	
	$("#<?php echo $module['module_name'];?> .type_deep_3").each(function(index, element) {
		if($(this).html().length>20){
			//$(this).css('width',$(this).prev().width()).css('margin-left',$(this).prev().offset().left-15);
			$(this).css('margin-left','20px');
			$(this).prev().css('width','88%');
		}
       
    });
});
</script>
    

<style>
#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block; vertical-align:top;vertical-align:top; overflow:hidden; background:#fff; padding:0px;border:1px solid #ddd; }
#<?php echo $module['module_name'];?>_html{ }
#<?php echo $module['module_name'];?>_html .type{ white-space:nowrap;}
#<?php echo $module['module_name'];?>_html .type p{ display:none;}
#<?php echo $module['module_name'];?>_html .type .n{ font-weight:lighter; display:inline-block; vertical-align:top; max-width:150px; overflow:hidden; vertical-align:middle;   }
#<?php echo $module['module_name'];?>_html .type .parent{font-size:1.71rem; height:4.28rem;line-height:4.28rem;  background-position:top;    padding-left:25px;   font-weight:bold;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .type a{ display:block;}
#<?php echo $module['module_name'];?>_html .type a .show_sub{ display:inline-block; width:2.85rem; height:2.85rem; line-height:2.85rem; background-repeat:no-repeat;}
#<?php echo $module['module_name'];?>_html .type a .show_sub:before{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da"; opacity:0.5;}
#<?php echo $module['module_name'];?>_html .type a .show_sub:hover{}
#<?php echo $module['module_name'];?>_html .type .image_type_deep_1{}
#<?php echo $module['module_name'];?>_html .type a .hide_sub{ display:inline-block; width:2.85rem; height:2.85rem; line-height:2.85rem;}
#<?php echo $module['module_name'];?>_html .type a .hide_sub:before{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0d7";opacity:0.5;}
#<?php echo $module['module_name'];?>_html .type a .hide_sub:hover{ }
#<?php echo $module['module_name'];?>_html .type .current_type{ font-weight:bolder; background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;  }
#<?php echo $module['module_name'];?>_html .type .type_deep_1{ padding-bottom:20px; padding-left:20px; padding-right:20px; margin-top:15px;}
#<?php echo $module['module_name'];?>_html .type .type_deep_2{display:<?php echo $module['type_deep_2'];?>;margin-left:20px; margin-top:10px;}
#<?php echo $module['module_name'];?>_html .type .type_deep_3{display:<?php echo $module['type_deep_3'];?>; margin-left:20px;line-height:30px;}
#<?php echo $module['module_name'];?>_html .type .type_deep_1 a{ padding-left:20px;border-bottom:1px solid #eee;font-size:1.2rem; line-height:2rem; font-weight:bold;text-overflow: ellipsis;}
#<?php echo $module['module_name'];?>_html .type .type_deep_1 a:hover{background:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['text']?>;  }
#<?php echo $module['module_name'];?>_html .type .type_deep_2 a{ display:inline-block; vertical-align:top; padding-left:15px;padding-right:15px; min-width:90px; font-size:16px;line-height:40px; height:40px; overflow:hidden;  }
#<?php echo $module['module_name'];?>_html .type .type_deep_2 a .n{ line-height:40px; height:40px; overflow:hidden; }
#<?php echo $module['module_name'];?>_html .type .type_deep_3 a{ display:inline-block; vertical-align:top; padding-left:15px;overflow:hidden; font-weight:1rem; font-weight:normal;line-height:35px; height:35px;min-width:70px; margin:0px;}
#<?php echo $module['module_name'];?>_html .type .type_deep_3 a .n{ line-height:35px; height:35px; overflow:hidden; }
#<?php echo $module['module_name'];?>_html .type .type_deep_2 .current_type{   }
#<?php echo $module['module_name'];?>_html .type .type_deep_3 .current_type{   }


</style>


<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=type><?php echo $module['list'];?></div>
</div>
</div>