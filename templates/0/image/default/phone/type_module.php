<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
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
	function reset_a(){
		$("#<?php echo $module['module_name'];?> .list a img").each(function(index, element) {
			$(this).parent().css('width',$(this).width());
			$(this).css('margin',0);
		});	
	}
});

</script>

<style>
#<?php echo $module['module_name'];?>{ margin:5px; padding:0px; width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;vertical-align:top; overflow:hidden; margin-left:auto; margin-right:auto;}


#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html .module_title{ display:none;}
#<?php echo $module['module_name'];?>_html .list{ padding:10px;}
#<?php echo $module['module_name'];?>_html .list a{ display:inline-block;  text-align:center; width:33.33%; overflow:hidden; text-align:center; }
#<?php echo $module['module_name'];?>_html .list img{ vertical-align:middle;width:60%; border:none;}
#<?php echo $module['module_name'];?>_html .list span{ display:block; line-height:30px; margin:5px;    white-space: nowrap;    text-overflow: ellipsis; overflow:hidden;}

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=module_title><?php echo $module['title'];?></div>
	<div class=list ><?php echo $module['list'];?></div>
</div>
</div>