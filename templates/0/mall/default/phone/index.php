<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
            
    });
    </script>
    

    <style>
    #<?php echo $module['module_name'];?> #icons li{ margin:1%; list-style-type:none; text-align:center; vertical-align:middle; width:14%; height:10.71rem; overflow:hidden; float:left;}
    #<?php echo $module['module_name'];?> #icons img{width:7.14rem; height:7.14rem; border:0px;}
    #<?php echo $module['module_name'];?> #icons span{ line-height:40px; font-size:20px;}
    #<?php echo $module['module_name'];?> #icons a{}
	#<?php echo $module['module_name'];?> #icons li a:hover{ }
	#<?php echo $module['module_name'];?> #icons li a:hover img{ width:7.64rem; height:7.64rem;}
    
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
      <?php echo $module['list']?>
    </div>
</div>