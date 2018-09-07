<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#edit_page_layout_div").remove();
    });
  
	function set_and_print(v){
		$("#<?php echo $module['module_name'];?>_html").html(v);
		$("#<?php echo $module['module_name'];?> .goods span").each(function(index, element) {
            if(parseInt($(this).offset().left+$(this).width())<180){
				//$(this).css('padding-left',180-parseInt($(this).offset().left+$(this).width()));
				//if($(this).attr('style')=='padding-left: 180px;'){$(this).css('padding-left',0);}	
			}
        });
		window.print();
	}
	
    </script>
	<style>
	body{  font-family:宋体;}
	#middle_layout_out{}
	.fixed_right_div{display:none;}

    #<?php echo $module['module_name'];?>{ } 
    #<?php echo $module['module_name'];?>_html{line-height:18px;} 
    #<?php echo $module['module_name'];?>_html .title{ font-weight:bold; margin-bottom:5px; border-bottom:2px solid #000;} 
    #<?php echo $module['module_name'];?>_html .money_info{ text-align:right; margin-bottom:5px;} 
    #<?php echo $module['module_name'];?>_html .actual_money{ text-align:right; margin-bottom:5px;font-weight:bold;} 
    #<?php echo $module['module_name'];?>_html .username_time{ border-top:solid #000 1px; white-space:nowrap;} 
    #<?php echo $module['module_name'];?>_html .username_time .username{ width:50%; display:inline-block; vertical-align:top;} 
    #<?php echo $module['module_name'];?>_html .username_time .time{ width:45%; text-align:right; font-size:10px; display:inline-block; vertical-align:top;} 
    #<?php echo $module['module_name'];?>_html .order{padding:0px; margin:0px; width:180px; font-size:13px; overflow:hidden; margin-bottom:40px;} 
	#<?php echo $module['module_name'];?>_html .order .goods{ max-height:36px; border-bottom:#000  dashed 1px; margin-bottom:5px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .order .goods span{ font-style:oblique; font-weight:bold; }
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	
    </div>
</div>
