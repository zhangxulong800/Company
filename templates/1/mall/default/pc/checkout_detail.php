<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
	
    $(document).ready(function(){
	
    });
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>{ padding-top:20px;}
    #<?php echo $module['module_name'];?> .order_div{ margin-bottom:30px;}
    #<?php echo $module['module_name'];?> .order_div .title{ white-space:nowrap;   line-height:100px; height:100px; overflow:hidden;}
    #<?php echo $module['module_name'];?> .order_div .title .time{ padding-left:20px; display:inline-block; vertical-align:top; width:30%; overflow:hidden;}
    #<?php echo $module['module_name'];?> .order_div .title .buyer{display:inline-block; vertical-align:top; text-align: center; width:30%;}
    #<?php echo $module['module_name'];?> .order_div .title .sum_money{display:inline-block; vertical-align:top; text-align:right; width:30%; overflow:hidden;}
    #<?php echo $module['module_name'];?> .order_div .title .symbol{display:inline-block; vertical-align:top;background-image:url(<?php echo get_template_dir(__FILE__);?>img/point.png); background-repeat:no-repeat; background-position:center right; width:5%;}
    #<?php echo $module['module_name'];?> .order_div .goods_div{ white-space:nowrap; }
    #<?php echo $module['module_name'];?> .order_div .goods_div .icon{ display:inline-block; vertical-align:top; width:200px; overflow:hidden; text-align:center;}
    #<?php echo $module['module_name'];?> .order_div .goods_div .icon img{ width:180px; height:180px; padding-top:10px;}
	#<?php echo $module['module_name'];?> .order_div .goods_div .other{ display:inline-block; vertical-align:top; white-space:normal; min-width:70%;}
	#<?php echo $module['module_name'];?> .order_div .goods_div .other .title{ background:none;  line-height:60px; height:120px; width:80%;white-space:normal; overflow:hidden;}
	#<?php echo $module['module_name'];?> .order_div .goods_div .other .price{ }
	#<?php echo $module['module_name'];?> .order_div .goods_div .other .price a{ }
	#<?php echo $module['module_name'];?> .order_state_out{ }
    #<?php echo $module['module_name'];?> .order_state_out a{ display:inline-block; vertical-align:top; border:#666 solid 1px; padding-left:10px; padding-right:10px; border-radius:10px; margin-right:20px; }
	#<?php echo $module['module_name'];?> .order_div .order_state{ display:inline-block; vertical-align:top; margin-right:20px;}
	#<?php echo $module['module_name'];?> .order_div .state_remark{ display:inline-block; vertical-align:top;margin-right:20px; }
	#<?php echo $module['module_name'];?> .order_div .state_remark br{ display:none;}
	#<?php echo $module['module_name'];?> .order_div .state_remark div{ display:inline-block; vertical-align:top;margin-right:20px;}
	
    #<?php echo $module['module_name'];?> .order_div .act_div{ text-align:right; padding-bottom:20px;}
    #<?php echo $module['module_name'];?> .order_div .act_div a{ display:inline-block; vertical-align:top; border:#666 solid 1px; padding-left:10px; padding-right:10px; border-radius:10px; margin-right:20px; }
	#<?php echo $module['module_name'];?> .order_div .act_div br{ display:none;}
    #<?php echo $module['module_name'];?> .order_div .bottom_div{ background-image:url(<?php echo get_template_dir(__FILE__);?>img/order_bottom.png); height:30px; }
	#<?php echo $module['module_name'];?> [monxin-table] .filter{ text-align:right; line-height:80px;}
	#<?php echo $module['module_name'];?> #search_filter{ width:70%;}
	#<?php echo $module['module_name'];?> #time_limit input{ width:150px;}
	#<?php echo $module['module_name'];?> .preferential_way div{ display:inline-block; vertical-align:top; margin-right:20px;}
	#<?php echo $module['module_name'];?> .big_money{ display:inline-block; vertical-align:top;margin-right:20px;}
	#<?php echo $module['module_name'];?> .other_info{padding-left:10px;  line-height:80px; border-bottom:3px solid #ccc;}
	#<?php echo $module['module_name'];?> .other_info div{ display:inline-block; vertical-align:top; margin-right:50px;}
	.buyer_address{ border-top:solid 3px #CCCCCC;padding-left:10px; padding-bottom:20px; line-height:70px; }
	
	
    #<?php echo $module['module_name'];?> .order_div .act_div{ text-align:right; padding-bottom:20px;}
    #<?php echo $module['module_name'];?> .order_div .act_div a{ display:inline-block; vertical-align:top; border:#666 solid 1px; padding-left:10px; padding-right:10px; border-radius:10px; margin-right:20px; }
	#<?php echo $module['module_name'];?> .order_div .act_div br{ display:none;}
    #<?php echo $module['module_name'];?> .order_div .bottom_div{ background-image:url(<?php echo get_template_dir(__FILE__);?>img/order_bottom.png); height:30px; }
	#<?php echo $module['module_name'];?> .remark{ padding-left:10px; font-style:oblique; text-decoration:underline;}
	
	#<?php echo $module['module_name'];?> .edit_a{ display:inline-block; height:60px; width:60px; background-image:url(<?php echo get_template_dir(__FILE__);?>img/edit.png); background-repeat:no-repeat;}
	#<?php echo $module['module_name'];?> .edit_b{ display:inline-block; height:60px; width:60px; background-image:url(<?php echo get_template_dir(__FILE__);?>img/edit.png); background-repeat:no-repeat;}
	#<?php echo $module['module_name'];?> .money_div{  display:inline-block; vertical-align:top; margin-right:20px;}
	#<?php echo $module['module_name'];?> .money_div div{ display:inline-block; vertical-align:top; margin-right:20px;}
	#<?php echo $module['module_name'];?> .change_price_reason{  display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?> .express{ display:inline-block; vertical-align:top; padding-left:20px;}
	#<?php echo $module['module_name'];?> .o_price{text-decoration: line-through; opacity:0.4; font-size:0.9rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <?php echo $module['list'];?>
    </div>
</div>
