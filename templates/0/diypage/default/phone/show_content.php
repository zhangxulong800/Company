<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
     if($('#<?php echo $module['module_name'];?> .title').html()==''){$("#<?php echo $module['module_name'];?> .title").css('display','none');}   
     if($('#<?php echo $module['module_name'];?> .content').html()==''){$("#<?php echo $module['module_name'];?> .content").css('display','none');}   
});
</script>
    

<style>
#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block;vertical-align:top; overflow:hidden;  border:1px solid #e7e7e7; margin-top:7px;}
#<?php echo $module['module_name'];?>_html{  padding-left:50px; padding-right:50px;}
#<?php echo $module['module_name'];?> .title{ font-size:3rem;  font-family:"SimHei"; text-align:center; height:6rem; line-height:6rem; border-bottom:1px solid #ccc; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .content{  margin-top:2rem; line-height:1.78rem; }
#<?php echo $module['module_name'];?>_html img{ margin-right:20px; max-width:100%;}
</style>


<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=title><?php echo $module['title'];?></div>
	<div class=content><?php echo $module['content'];?></div>
</div>
</div>