<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left save_name="<?php echo $module['module_save_name'];?>"  >
    <script>
    $(document).ready(function(){
		
    });
    </script>
	<style>
	#top_layout_out{ display:none;}
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
	</style>
    <div id="<?php echo $module['module_name'];?>_html" >
     <?php echo $module['data']?>              
    </div>
</div>
