<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .out_div .grid:last").css('border-right','none').css('padding-right','0px');
    });
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .out_div{ }
    #<?php echo $module['module_name'];?> .out_div .grid{   display:inline-block; vertical-align:top;width:32%;; padding:0.6%; border: #999 dashed 1px; border-left:none; border-top:none; white-space:normal; }
	#<?php echo $module['module_name'];?> .out_div .grid .title{ display:block; font-size:1.2rem;  line-height:30px; width:100%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .out_div .grid .list{display:block;   width:100%; white-space:nowrap; line-height:1.5rem; overflow:hidden;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    	<div class=out_div>
        <?php echo $module['html'];?>
        </div>
    </div>

</div>
