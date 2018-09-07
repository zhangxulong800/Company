<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	if($("#<?php echo $module['module_name'];?>").parent('div').width()<500){$("#<?php echo $module['module_name'];?>").css('display','block');}
	$("#<?php echo $module['module_name'];?> #page_type_"+get_param('type')).attr('class','current_type');
	$("#<?php echo $module['module_name'];?> .type a span").each(function(index, element) {
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
	if(monxin=='image.show_thumb' && get_param('type')!=''){
		$("#<?php echo $module['module_name'];?> #page_type_"+get_param('type')).parent().css('display','block');	
		$("#<?php echo $module['module_name'];?> #page_type_"+get_param('type')).parent().parent().css('display','block');	
	}
	
	$("#<?php echo $module['module_name'];?> .type a span").click(function(){
		if($(this).parent().next('div').css('display')=='none'){
			$(this).parent().next('div').css('display','block');
			$(this).attr('class','hide_sub');	
		}else{
			$(this).parent().next('div').css('display','none');
			$(this).attr('class','show_sub');
		}
		return false;	
	});
});
</script>
    

<style>
#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block;vertical-align:top; overflow:hidden; background:#fff;margin:5px; border:1px solid #e7e7e7;padding:0px;}
#<?php echo $module['module_name'];?>_html{ line-height:3.57rem;}
#<?php echo $module['module_name'];?>_html .type{}
#<?php echo $module['module_name'];?>_html .type .parent{font-size:1.71rem; height:4.28rem;line-height:4.28rem;  background-position:top;    padding-left:25px;   font-weight:bold;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .type a{  display:block;}
#<?php echo $module['module_name'];?>_html .type a .show_sub{ display:inline-block; width:2.85rem; height:2.85rem; line-height:2.85rem; background-repeat:no-repeat;}
#<?php echo $module['module_name'];?>_html .type a .show_sub:before{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da"; opacity:0.5;}
#<?php echo $module['module_name'];?>_html .type a .show_sub:hover{}
#<?php echo $module['module_name'];?>_html .type .page_type_deep_1{}
#<?php echo $module['module_name'];?>_html .type a .hide_sub{ display:inline-block; width:2.85rem; height:2.85rem; line-height:2.85rem;}
#<?php echo $module['module_name'];?>_html .type a .hide_sub:before{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0d7";opacity:0.5;}
#<?php echo $module['module_name'];?>_html .type a .hide_sub:hover{ }
#<?php echo $module['module_name'];?>_html .type .current_type{ }
#<?php echo $module['module_name'];?>_html .type .current_type:after{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da"; }
#<?php echo $module['module_name'];?>_html .type .page_type_deep_2{display:<?php echo $module['page_type_deep_2'];?>;}
#<?php echo $module['module_name'];?>_html .type .page_type_deep_3{display:<?php echo $module['page_type_deep_3'];?>;}
#<?php echo $module['module_name'];?>_html .type .page_type_deep_1 a{padding-left:25px; border-bottom:1px solid #f3f3f3;font-size:1.28rem; line-height:3.57rem;}
#<?php echo $module['module_name'];?>_html .type .page_type_deep_1 a:hover{  border-bottom:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> 1px solid;}
#<?php echo $module['module_name'];?>_html .type .page_type_deep_2 a{ padding-left:65px;}
#<?php echo $module['module_name'];?>_html .type .page_type_deep_2 a:hover{}
#<?php echo $module['module_name'];?>_html .type .page_type_deep_3 a{ padding-left:105px;}
#<?php echo $module['module_name'];?>_html .type .page_type_deep_3 a:hover{}
</style>


<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=type><?php echo $module['list'];?></div>
</div>
</div>