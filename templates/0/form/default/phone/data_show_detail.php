<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
		$.get("<?php echo $module['count_url']?>");
    });
    
        
    </script>

	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> div{ line-height:2rem; white-space:nowrap;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:24%; text-align:right; overflow:hidden; padding-right:5px; opacity:0.5;}
    #<?php echo $module['module_name'];?> .input_span{ display:inline-block; width:75%; overflow:hidden; white-space: normal;}
    #<?php echo $module['module_name'];?> legend{ }
    #<?php echo $module['module_name'];?> .img_thumb{ max-height:12rem; margin:10px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <?php echo $module['fields'];?>
    </div>
</div>
