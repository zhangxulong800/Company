<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .out_div .grid:last").css('border-right','none').css('padding-right','0px');
    });
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .out_div{white-space:nowrap; }
    #<?php echo $module['module_name'];?> .out_div .grid{   display:inline-block; vertical-align:top;width:16%;; padding:0.6%; border-right: <?php echo $_POST['monxin_user_color_set']['nv_3_hover']['text']?> dashed 1px; white-space:normal; text-align:center;}
	#<?php echo $module['module_name'];?> .out_div .grid a:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?> .out_div .grid .title{ display:block; font-size:16px; line-height:30px; width:100%; overflow:hidden;  margin:0px !important;}
	#<?php echo $module['module_name'];?> .out_div .grid .list{display:block;  line-height:22px;  width:100%; overflow:hidden; opacity:0.8;}
	#<?php echo $module['module_name'];?> .out_div .grid .list:hover{opacity:1;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    	<div class="container out_div">
        <?php echo $module['html'];?>
        </div>
    </div>

</div>
