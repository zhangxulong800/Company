<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  style="width:100%;" save_name="<?php echo $module['module_save_name'];?>" >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?>_html div").each(function(index, element) {
        if($(this).html().length==0){$(this).css('display','none');}
    });
	$.get("<?php echo $module['count_url']?>");
        
    });
    </script>
    

<style>
#<?php echo $module['module_name'];?>{ border:1px solid #e7e7e7;margin:5px; }
#<?php echo $module['module_name'];?>_html{ padding-left:1rem; padding-right:1rem;}
#<?php echo $module['module_name'];?>_html a{ }
#<?php echo $module['module_name'];?> .title{ font-size:3rem;  font-family:"SimHei"; text-align:center; height:6rem; line-height:6rem; border-bottom:1px solid #ccc; overflow:hidden;}
#<?php echo $module['module_name'];?> .tag{ text-align:center; line-height:3.57rem; }
#<?php echo $module['module_name'];?> .tag span{ display:inline-block; padding-right:3.57rem;}
#<?php echo $module['module_name'];?> .content{  margin-top:2rem; line-height:2rem;}
#<?php echo $module['module_name'];?> .content img{max-width:100%;}
#<?php echo $module['module_name'];?> .img img{max-width:100%;}
</style>


<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
<div id="show_count" style="display:none;"></div>
<div class=title><?php echo $module['title']?></div>
<div class=tag><?php echo $module['tag']?></div>
<div class=img><?php echo $module['img']?></div>
<div class=content><?php echo $module['content']?></div>
</div>
</div>