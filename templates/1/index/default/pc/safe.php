<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){

    });
  
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .line{ line-height:3rem;}
    #<?php echo $module['module_name'];?>_html .line:hover{ }
    #<?php echo $module['module_name'];?>_html .line .path{ display:inline-block; vertical-align:top; width:60%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .line .code{ display:inline-block; vertical-align:top; width:30%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .line .view{ display:inline-block; vertical-align:top; width:10%; overflow:hidden;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
		<?php echo $module['list']?>
    </div>
</div>
