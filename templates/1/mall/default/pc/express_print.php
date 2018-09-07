<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#edit_page_layout_div").remove();
		if(''!='<?php echo $module['ignore']?>'){alert('<?php echo $module['ignore'];?><?php echo self::$language['no_express_ignore']?>');}
		
		window.print();
    });
  
	
    </script>
	<style>
	
  	
	body{  font-family:宋体;}
	#middle_layout_out{}
	.fixed_right_div{display:none;}
    #<?php echo $module['module_name'];?>{ font-size:1.2rem; } 
    #<?php echo $module['module_name'];?>_html{line-height:18px;} 
    #<?php echo $module['module_name'];?>_html .order{ margin-bottom:1px;line-height:2rem; } 
	<?php echo $module['css'];?>
	@media print {
		#<?php echo $module['module_name'];?>_html .order{ margin-left:-4%;} 
	}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<?php echo $module['list'];?>
    </div>
</div>
