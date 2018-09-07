<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#edit_page_layout_div").remove();
		
		window.print();
    });
  
	
    </script>
	<style>
	
  	
	body{  font-family:宋体;}
	#middle_layout_out{}
	.fixed_right_div{display:none;}
    #<?php echo $module['module_name'];?>{ } 
    #<?php echo $module['module_name'];?>_html{line-height:18px;} 
    #<?php echo $module['module_name'];?>_html .title{ } 
    #<?php echo $module['module_name'];?>_html .money_info{ text-align:right; margin-bottom:5px;} 
    #<?php echo $module['module_name'];?>_html .actual_money{ text-align:right; margin-bottom:5px;} 
    #<?php echo $module['module_name'];?>_html .username_time{ border-top:solid #000 1px; white-space:nowrap;} 
    #<?php echo $module['module_name'];?>_html .username_time .username{ width:50%; display:inline-block; vertical-align:top;} 
    #<?php echo $module['module_name'];?>_html .username_time .time{ width:45%; text-align:right; font-size:10px; display:inline-block; vertical-align:top;} 
    #<?php echo $module['module_name'];?>_html .order{padding:0px; margin:0px; width:180px; font-size:13px; overflow:hidden; margin-bottom:40px;} 
	#<?php echo $module['module_name'];?>_html .order .goods{ line-height:1.2rem; font-size:12px; border-bottom:#000  dashed 1px; margin-bottom:5px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .order .g_head{border-bottom:#000  dashed 1px; margin-bottom:5px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .order .o span{ display:inline-block; vertical-align:top; }
	#<?php echo $module['module_name'];?>_html .order .o .g{ width:50%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .order .o .b{ width:50%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .order .o .q{ width:15%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .order .o .p{ width:15%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .order .o .s{ width:20%; overflow:hidden; text-align:right;}
	.preferential_way{ text-align:right;}
	.normal_price{ text-align:right;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<?php echo $module['list'];?>
    </div>
</div>
