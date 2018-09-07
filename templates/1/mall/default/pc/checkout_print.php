<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#edit_page_layout_div").remove();
    });
	function set_and_print(v){
		$("#<?php echo $module['module_name'];?>_html").html(v);
		$("#<?php echo $module['module_name'];?> .o_price").each(function(index, element) {
            //$(this).parent().css('line-height','1rem');
        });
		$("#<?php echo $module['module_name'];?> .goods span").each(function(index, element) {
            if(parseInt($(this).offset().left+$(this).width())<180){
				//$(this).css('padding-left',180-parseInt($(this).offset().left+$(this).width()));
				//if($(this).attr('style')=='padding-left: 180px;'){$(this).css('padding-left',0);}	
			}
        });
		setTimeout("window.print()",100);
	}
	
    </script>
	<style>
	body{  font-family:宋体;}
	#middle_layout_out{}
	.fixed_right_div{display:none;}

    #<?php echo $module['module_name'];?>{ } 
    #<?php echo $module['module_name'];?>_html{line-height:18px; font-size:10px;} 
    #<?php echo $module['module_name'];?>_html .a4{line-height:18px; font-size:1rem;} 
    #<?php echo $module['module_name'];?>_html .title{} 
    #<?php echo $module['module_name'];?>_html .money_info{ text-align:right; margin-bottom:5px;} 
    #<?php echo $module['module_name'];?>_html .actual_money{ text-align:right; margin-bottom:5px;font-weight:bold;} 
    #<?php echo $module['module_name'];?>_html .username_time{ border-top:solid #000 1px; white-space:nowrap;} 
    #<?php echo $module['module_name'];?>_html .username_time .username{ width:50%; display:inline-block; vertical-align:top;} 
    #<?php echo $module['module_name'];?>_html .username_time .time{ width:45%; text-align:right;  display:inline-block; vertical-align:top;} 
    #<?php echo $module['module_name'];?>_html .order{padding:0px; margin:0px; width:180px;overflow:hidden; margin-bottom:40px;} 
	#<?php echo $module['module_name'];?>_html .order .goods{ max-height:36px; border-bottom:#000  dashed 1px; margin-bottom:5px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .order .goods span{ font-style:oblique; font-weight:bold; }
	
	#<?php echo $module['module_name'];?> .order_div{ page-break-after: always; /*在标签后换页*/ margin-bottom:20px; } 
	#<?php echo $module['module_name'];?> .order_div:last-child{page-break-after:avoid;}
	#<?php echo $module['module_name'];?> .order_div .order_head{ } 
	#<?php echo $module['module_name'];?> .order_div .order_head .icon_name{width:33%; overflow:hidden; display:inline-block; vertical-align:top; text-align:center;}
	#<?php echo $module['module_name'];?> .order_div .order_head .icon_name img{width:80%; margin:auto;}
	#<?php echo $module['module_name'];?> .order_div .order_head .icon_name div{  font-weight:bold;}
	#<?php echo $module['module_name'];?> .order_div .order_head .info{width:33%; overflow:hidden; display:inline-block; vertical-align:top; }
	#<?php echo $module['module_name'];?> .order_div .order_head .info div{ line-height:30px;}
	#<?php echo $module['module_name'];?> .order_div .order_head .barcode{width:33%; overflow:hidden; display:inline-block; vertical-align:top; text-align:right; }
	#<?php echo $module['module_name'];?> .order_div .order_head .barcode img{ width:80%;}
	#<?php echo $module['module_name'];?> .order_div .order_head .receiver_info{ line-height:30px; border-top:1px dashed #333333;border-bottom:1px dashed #333333;}
	#<?php echo $module['module_name'];?> .order_div .order_body{} 
	#<?php echo $module['module_name'];?> .order_div .order_body .goods{line-height:1.2rem; border-bottom:#000  dashed 1px; margin-bottom:5px; overflow:hidden;} 
	#<?php echo $module['module_name'];?> .order_div .order_body .goods span{ display:inline-block; vertical-align:top; } 
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_id{ width:15%;}
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_name{ width:57%;}
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_price{ width:12%;}
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_price .o_price{padding-left:3px;}
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_quantity{ width:8%;}
	#<?php echo $module['module_name'];?> .order_div .order_body .goods .goods_money{ width:8%;}
	#<?php echo $module['module_name'];?> .order_div .order_foot{ text-align:right; padding-top:30px; } 
	#<?php echo $module['module_name'];?> .preferential_way{text-align:right;}
	#<?php echo $module['module_name'];?> .normal_price{text-align:right;}
	#<?php echo $module['module_name'];?> .shop_info{ border-top:1px dashed #ccc; padding-top:5px; margin-top:5px;}
	#<?php echo $module['module_name'];?> .o_price{text-decoration: line-through; opacity:0.8; }
	
	#<?php echo $module['module_name'];?>_html .order .g_head{border-bottom:#000  dashed 1px; margin-bottom:5px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .order .o span{ display:inline-block; vertical-align:top; }
	#<?php echo $module['module_name'];?>_html .order .o .g{ width:43%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .order .o .b{ width:43%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .order .o .q{ width:15%; overflow:hidden; text-align:center;}
	#<?php echo $module['module_name'];?>_html .order .o .p{ width:17%; overflow:hidden; }
	#<?php echo $module['module_name'];?>_html .order .o .s{ width:17%; overflow:hidden; text-align:right;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	
    </div>
</div>
