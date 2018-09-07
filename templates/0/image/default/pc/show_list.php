<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	if('<?php echo $module['title'];?>'==''){$("#<?php echo $module['module_name'];?> .module_title").css('display','none');}
	if('<?php echo $module['scroll'];?>'!='no'){
		if('<?php echo $module['scroll'];?>'=='left'){
			//$("#<?php echo $module['module_name'];?>_html .list a").css('margin','0px').css('padding','0px');
		}
		
		$("#<?php echo $module['module_name'];?> .list").imgscroll({
			speed: 20,    //图片滚动速度
			amount: 0,    //图片滚动过渡时间
			width: 3,     //图片滚动步数
			dir: "<?php echo $module['scroll'];?>"   // "left" 或 "up" 向左或向上滚动
		});

		if('<?php echo $module['scroll'];?>'=='left'){
			$("#<?php echo $module['module_name'];?>_html .list a").css('margin','10px').css('padding','10px');
			$('body').attr('onload','reset_a()');
		}else{
			$("#<?php echo $module['module_name'];?> .module_title").css('display','none');
		}
	}
});

	function reset_a(){
		$("#<?php echo $module['module_name'];?> .list a img").each(function(index, element) {
			$(this).parent().css('width',$(this).width());
			$(this).css('margin',0);
		});	
	}
</script>

<style>
#<?php echo $module['module_name'];?>{ margin:5px; padding:0px; width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block;vertical-align:top; overflow:hidden;  background:#fff; border:1px solid #e7e7e7;}
#<?php echo $module['module_name'];?>_html{	}
#<?php echo $module['module_name'];?>_html .module_title{ font-weight:bold;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; text-align:center; display:block; line-height:3rem; font-size:1.2rem;}
#<?php echo $module['module_name'];?>_html .module_title:before{ content:"——————"; padding-right:1rem;}
#<?php echo $module['module_name'];?>_html .module_title:after{  content:"——————";  padding-left:1rem;}
#<?php echo $module['module_name'];?>_html .list{}
#<?php echo $module['module_name'];?>_html .list a{  margin-bottom:3.57rem; margin-top:1.42rem; margin-left:2%; margin-right:2%;  display:inline-block; vertical-align:top;  width:<?php echo $module['sub_module_width'];?>; overflow:hidden; text-align:center;  border:1px solid #e7e7e7; }
#<?php echo $module['module_name'];?>_html .list a:hover{ border:1px solid #ddd; }
#<?php echo $module['module_name'];?>_html .list img:hover{ opacity:0.8;}
#<?php echo $module['module_name'];?>_html .list .current_page{ font-weight:bolder;}
#<?php echo $module['module_name'];?>_html .list img{   vertical-align:middle;height:<?php echo $module['image_height'];?>;max-width:<?php echo $module['image_height'];?>; margin:0.5rem; margin-bottom:0px;}
#<?php echo $module['module_name'];?>_html .list span{ display:block; line-height:2.14rem; margin:5px;}
#<?php echo $module['module_name'];?>_html .list .title{ display:block; font-size:1.1rem; height:2.14rem; line-height:2.14rem; display:block; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list div{}
#<?php echo $module['module_name'];?>_html .time .time_symbol{display:inline-block;  display:none;}
#<?php echo $module['module_name'];?>_html .list .time{ display:inline-block; float:left; padding-left:10px; }
#<?php echo $module['module_name'];?>_html .visit .visit_symbol{display:inline-block; width:2.14rem height:1.42rem;  line-height:1.42rem;}
#<?php echo $module['module_name'];?>_html .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0a6"; opacity:0.6;}
#<?php echo $module['module_name'];?>_html .list .visit{display:inline-block; float:right; padding-right:10px;}
#<?php echo $module['module_name'];?>_html .list span .m_label{ display: inline-block;}

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<a href='./index.php?monxin=image.show_thumb&type=<?php echo $module['type_id'];?>' class=module_title><?php echo $module['title'];?></a>
	<div class=list ><?php echo $module['list'];?></div>
</div>
</div>