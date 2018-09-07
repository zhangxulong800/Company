<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	//$("#<?php echo $module['module_name'];?> .list a").css('width',$('#<?php echo $module['module_name'];?>  .list a').width()-45);
	$("#<?php echo $module['module_name'];?> #diypage_show_"+get_param('id')).attr('class','current_diypage');
	if('<?php echo $module['title'];?>'==''){$("#<?php echo $module['module_name'];?> .module_title").css('display','none');}
	if('<?php echo $module['scroll'];?>'!='no'){
		$("#<?php echo $module['module_name'];?> .list").imgscroll({
			speed: 20,    //图片滚动速度
			amount: 0,    //图片滚动过渡时间
			width: 3,     //图片滚动步数
			dir: "<?php echo $module['scroll'];?>"   // "left" 或 "up" 向左或向上滚动
		});

		if('<?php echo $module['scroll'];?>'=='left'){
			$('body').attr('onload','reset_a()');
		}else{
			$("#<?php echo $module['module_name'];?> .module_title").css('display','none');
		}
	}

	
});
</script>
    

<style>
#<?php echo $module['module_name'];?>{ margin:5px; padding:0px; width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block;vertical-align:top; overflow:hidden;  background:#fff; border:1px solid #e7e7e7;}
#<?php echo $module['module_name'];?>_html{ line-height:50px;}
#<?php echo $module['module_name'];?>_html .module_title{ font-size:1.71rem; height:4.28rem;line-height:4.28rem;  background-position:top;   padding-left:25px;  font-weight:bold;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .list{ }
#<?php echo $module['module_name'];?>_html .list a{  display: inline-block;width:<?php echo $module['sub_module_width'];?>; overflow:hidden; border-bottom:1px solid #f3f3f3;  text-align:center;} 
#<?php echo $module['module_name'];?>_html .list a:hover{ border-bottom:1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .current_diypage{  border-bottom:1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .current_diypage:after{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da"; }
</style>


<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=module_title><?php echo $module['title'];?></div>
	<div class=list><?php echo $module['list'];?></div>
</div>
</div>