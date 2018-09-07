<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=center >
	<style>
	#<?php echo $module['module_name'];?>{ margin-bottom:1.5rem;}
    #<?php echo $module['module_name'];?>_html{width:100%;; border-top:#ccc  dashed 1px; padding-top:10px; }
	#<?php echo $module['module_name'];?>_html .tel{ display:inline-block; vertical-align:top;  }
	#<?php echo $module['module_name'];?>_html .tel:before {font: normal normal normal 1.3rem/1 FontAwesome; content: "\f098";margin-right: 5px; }
	#<?php echo $module['module_name'];?>_html .address{ display:inline-block; vertical-align:top; 	 }
	#<?php echo $module['module_name'];?>_html .address:before{font: normal normal normal 1.3rem/1 FontAwesome; content: "\f041";margin-right: 5px; 
	}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
	<?php echo $module['module_content'];?>
    </div>

</div>