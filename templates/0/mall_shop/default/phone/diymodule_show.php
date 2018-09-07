<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  style="display:inline-block;width:<?php echo $module['width']?>;height:<?php echo $module['height']?>;display:inline-block;vertical-align:top; ">
    <script>
    $(document).ready(function(){
		if(1=='<?php echo $module['title_visible']?>'){$("#<?php echo $module['module_name'];?> .module_title").css('display','block');}
	
	});
	</script>
	<style>
	#<?php echo $module['module_name'];?>{display:inline;vertical-align: top; overflow: hidden; padding: 0;}
    #<?php echo $module['module_name'];?>_html{  width:<?php echo $module['width']?>;height:<?php echo $module['height']?>; }
    #<?php echo $module['module_name'];?>_html .module_title{font-size:24px; height:60px; background-position:top; line-height:60px;  background-image:url(<?php echo get_template_dir(__FILE__);?>img/title_bg.png); background-repeat:repeat-x; padding-left:25px;  font-weight:bold; display:none;}
    #<?php echo $module['module_name'];?>_html .content{}
	
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
      <div class='module_title'><?php echo $module['title']?></div>
      <div class='content'><?php echo $module['content']?></div>
    </div>
</div>