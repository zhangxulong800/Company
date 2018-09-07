<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>").height($(window).height());
		$("#edit_page_layout_div").remove();
		
    });
  
	function set_and_print(v){
		$("#<?php echo $module['module_name'];?>_html").html(v);
		window.print();
	}
    </script>
	<style>
	.page-header{ display:none;}
	.fixed_right_div{ display:none;}
	#layout_full{ }
	.container{ width:100%; padding:0px; margin:0px;}
	#<?php echo $module['module_name'];?>{  padding:0px; margin:0px;}
	body{  font-family:宋体; font-size:13px;width:180px;  overflow-x:hidden;}
	#middle_layout_out{}
	.fixed_right_div{display:none;}
    #<?php echo $module['module_name'];?>{ } 
    #<?php echo $module['module_name'];?>_html{line-height:18px;}
    #<?php echo $module['module_name'];?>_html img{width:170px;}
	#<?php echo $module['module_name'];?>_html .goods{ padding-left:5px; padding-right:4px; padding-top:5px; width:170px; height:151px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .goods img{ display:block;}
	#<?php echo $module['module_name'];?>_html .goods .title{ height:36px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .goods .price{ text-align:right; padding-right:5px; white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .goods .other{ white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .goods .other .icon{ display:inline-block; vertical-align:top; width:40px; overflow:hidden; padding-right:5px;}
	#<?php echo $module['module_name'];?>_html .goods .other .icon img{ width:40px; height:40px;}
	#<?php echo $module['module_name'];?>_html .goods .other .remark{display:inline-block; vertical-align:top; width:120px; line-height:20px;}
	#<?php echo $module['module_name'];?>_html .goods .other .remark .order_id{}
	#<?php echo $module['module_name'];?>_html .goods .other .remark .time{ font-size:12px; }
    </style>
    <div id="<?php echo $module['module_name'];?>_html"></div>
</div>
