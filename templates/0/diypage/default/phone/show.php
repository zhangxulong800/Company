<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left style="width:100%;" save_name="<?php echo $module['module_save_name'];?>" >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?>_html div").each(function(index, element) {
        if($(this).html().length==0){$(this).css('display','none');}
    });
	
	$.get("<?php echo $module['count_url']?>");
        
    });
    </script>
    

<style>
#<?php echo $module['module_name'];?>{ padding:0.5rem;}
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html a{ }
#<?php echo $module['module_name'];?> .title{ text-align:center; line-height:3rem; font-size:1.5rem; }
#<?php echo $module['module_name'];?> .tag{ line-height:3rem; text-align:center; }
#<?php echo $module['module_name'];?> .tag span{ padding-right:1rem; }
#<?php echo $module['module_name'];?> .content{ line-height:2rem;}
#<?php echo $module['module_name'];?> .content img{max-width:100%;}
</style>


<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
<div id="show_count" style="display:none;"></div>
<div class=title><?php echo $module['title']?></div>
<div class=tag><?php echo $module['tag']?></div>
<div class=content><?php echo $module['content']?></div>
</div>
</div>