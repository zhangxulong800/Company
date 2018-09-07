<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#edit_page_layout_div").remove();
		$("#<?php echo $module['module_name'];?> .o_price").each(function(index, element) {
            //$(this).parent().css('line-height','1rem');
        });
		window.print();
    });
  
	
    </script>
	<style>
	
  	
	body{  font-family:宋体;}
	#middle_layout_out{}
	.fixed_right_div{display:none;}
	.container{ width:800px;}
    #<?php echo $module['module_name'];?>{ } 
    #<?php echo $module['module_name'];?>_html{} 
	
	#<?php echo $module['module_name'];?> .order_div{ font-size:18px; page-break-after: always; /*在标签后换页*/ margin-bottom:20px;} 
	#<?php echo $module['module_name'];?> .order_div:last-child{page-break-after:avoid;}
	#<?php echo $module['module_name'];?> .order_div .order_head{ } 
	#<?php echo $module['module_name'];?> .order_div .order_head .icon_name{width:33%; overflow:hidden; display:inline-block; vertical-align:top; text-align:center;}
	#<?php echo $module['module_name'];?> .order_div .order_head .icon_name img{width:80%; margin:auto; max-height:80px;}
	#<?php echo $module['module_name'];?> .order_div .order_head .icon_name div{ font-size:25px; font-weight:bold;}
	#<?php echo $module['module_name'];?> .order_div .order_head .info{width:33%; overflow:hidden; display:inline-block; vertical-align:top; }
	#<?php echo $module['module_name'];?> .order_div .order_head .info div{ line-height:30px;}
	#<?php echo $module['module_name'];?> .order_div .order_head .barcode{width:33%; overflow:hidden; display:inline-block; vertical-align:top; text-align:right;}
	#<?php echo $module['module_name'];?> .order_div .order_head .barcode img{ width:80%;}
	#<?php echo $module['module_name'];?> .order_div .order_head .receiver_info{ font-size:14px; line-height:30px; border-top:1px dashed #333333;border-bottom:1px dashed #333333;}
	#<?php echo $module['module_name'];?> .order_div .order_body{ font-size:14px;} 
	#<?php echo $module['module_name'];?> .order_div .order_body .goods{ border-bottom: 1px dashed #333333; line-height:30px; } 
	#<?php echo $module['module_name'];?> .order_div .order_body .goods span{ display:inline-block; vertical-align:top; } 
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_id{ width:15%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_name{ width:57%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_price{ width:12%; overflow:hidden;white-space:nowrap;}
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_price .o_price{padding-left:3px;}
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_quantity{ width:8%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_money{ width:8%;}
	#<?php echo $module['module_name'];?> .order_div .order_foot{ text-align:right; padding-top:30px; font-size:16px;} 
	#<?php echo $module['module_name'];?> .shop_info{ border-top:1px dashed #ccc; font-size:0.9rem; padding-top:5px; margin-top:5px;}
	#<?php echo $module['module_name'];?> .o_price{text-decoration: line-through; opacity:0.4; font-size:0.9rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<?php echo $module['list'];?>
    </div>
</div>
