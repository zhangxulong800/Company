<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left save_name="<?php echo $module['module_save_name'];?>"   style="width:100%;">
    <script>
    $(document).ready(function(){
        
    });
    
    
    </script>
	<style>
	#<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> .icons{}
	#<?php echo $module['module_name'];?> .icons a{ display:inline-block; vertical-align:top; text-align:center; width:200px; height:300px; overflow:hidden; padding:20px;}
	#<?php echo $module['module_name'];?> .icons a img{ border:none; height:70%; }
	#<?php echo $module['module_name'];?> .icons a span{ display:block;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
    <div class="icons"><?php echo $module['list']?></div>
    <?php echo $module['page']?>
    </div>
</div>
