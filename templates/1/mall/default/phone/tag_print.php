<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#edit_page_layout_div").remove();
		$("#<?php echo $module['module_name'];?> .goods").each(function(index, element) {
            if($(this).children('.title').height()<60){
				$(this).children('.title').css('padding-top',(60-$(this).children('.title').height())/2);	
			}
        });
		window.print();
    });
  
	
    </script>
	<style>
	.fixed_right_div{display:none;}
	body{  font-family:宋体; font-size:13px;width:180px;  overflow:hidden;}
    #<?php echo $module['module_name'];?>{} 
    #<?php echo $module['module_name'];?>_html{line-height:20px;}
    #<?php echo $module['module_name'];?>_html img{width:170px;}
	#<?php echo $module['module_name'];?>_html .goods{ padding-left:5px; padding-right:4px; width:170px; height:156px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .goods .title{ max-height:40px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .goods .price{ text-align:right; padding-right:5px; white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .goods .other{ white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .goods .other .icon{ display:inline-block; vertical-align:top; width:50px; overflow:hidden; padding-right:5px;}
	#<?php echo $module['module_name'];?>_html .goods .other .icon img{ width:50px; height:50px;}
	#<?php echo $module['module_name'];?>_html .goods .other .remark{display:inline-block; vertical-align:top; width:120px;}
	#<?php echo $module['module_name'];?>_html .goods .other .remark .order_id{}
	#<?php echo $module['module_name'];?>_html .goods .other .remark .time{ font-size:12px; }
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<?php echo $module['list'];?>
        
    </div>
</div>
