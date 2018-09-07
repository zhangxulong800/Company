<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
	
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .view_logistics").each(function(index, element) {
            id=$(this).attr('order_id');
			$(this).attr('href',$("#<?php echo $module['module_name'];?> #head_"+id+" .express_code a").attr('href'));
        });
		
		if(get_param('state')!=''){$("#state").prop('value',get_param('state'));}
		if(get_param('pay_method')!=''){$("#pay_method").prop('value',get_param('pay_method'));}
		if(get_param('buy_method')!=''){$("#buy_method").prop('value',get_param('buy_method'));}
		if(get_param('preferential_way')!=''){$("#preferential_way").prop('value',get_param('preferential_way'));}
		if(get_param('invoice')!=''){$("#invoice").prop('value','<?php echo @$_GET['invoice'];?>');}
		if(get_param('express')!=''){$("#express").prop('value',get_param('express'));}
		
		
    });
    
    
    </script>
	<style>
	#set_monxin_iframe_div{top:40%; left:420px; }
	#monxin_iframe{ height:100px;width:500px; overflow:scroll;}
	
	#<?php echo $module['module_name'];?> .light{ background:<?php echo $_POST['monxin_user_color_set']['module']['background']?>;}
    #<?php echo $module['module_name'];?>{ background:none;}
	#<?php echo $module['module_name'];?> input {margin:0 5px;}
    #<?php echo $module['module_name'];?> .add_comment{ padding-left:10px; font-style:oblique;}
    #<?php echo $module['module_name'];?>  .filter{ line-height:50px; padding-bottom:1rem;} 
	
    #<?php echo $module['module_name'];?> #search_filter{ width:280px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info{  padding-left:10px; height:2.85rem; line-height:2.85rem; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info a{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
        #<?php echo $module['module_name'];?> .title_tr .buyer_info br{display:none;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .buyer{ display:inline-block; vertical-align:top; min-width:120px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .add_time{ display:inline-block; vertical-align:top; min-width:120px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .order_id{ display:inline-block; vertical-align:top; min-width:140px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .goods_money{ display:inline-block; vertical-align:top; min-width:180px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .express_cost_buyer{ display:inline-block; vertical-align:top; min-width:150px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .express_cost_seller{ display:inline-block; vertical-align:top; min-width:150px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .invoice{ display:inline-block; vertical-align:top; min-width:120px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address{padding-left:10px; font-size:1rem; height:2.2rem; line-height:2.2rem;  background: #EFEFEF;color:#999;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .delivery_time{  padding-left:20px; color: #888;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .express{  padding-left:20px; color: #888;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .express_code{  padding-left:10px; color: #888;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .express_code a{color: #888;}
	
	#<?php echo $module['module_name'];?> .order_tr{ white-space:nowrap;}
	#<?php echo $module['module_name'];?> .checkbox_td{ display:inline-block; vertical-align:top; width:2%; overflow:hidden; text-align:left;}
	#<?php echo $module['module_name'];?> .goods_td{ display:inline-block; vertical-align:top; width:50%;padding-left:1%; overflow:hidden; text-align:left;}
	#<?php echo $module['module_name'];?> .preferential_td{ display:inline-block; vertical-align:top; width:10%; padding-left:1%; padding-top:10px; overflow:hidden; border-left:#CCC dashed 1px;  text-align:center; white-space:normal;}
	#<?php echo $module['module_name'];?> .state_td{ display:inline-block; vertical-align:top; width:10%; padding-left:1%;padding-top:10px;border-left:#CCC dashed 1px; overflow:hidden;text-align:center;white-space:normal;}
	#<?php echo $module['module_name'];?> .operation_td{ display:inline-block; vertical-align:top; width:20%;padding-left:1%;padding-top:10px;border-left:#CCC dashed 1px;  overflow:hidden;white-space:normal;}
	#<?php echo $module['module_name'];?> .goods_info{ padding-top:10px;padding-bottom:10px; }
	#<?php echo $module['module_name'];?> .goods_info .goods{ padding-bottom:20px;  }
	#<?php echo $module['module_name'];?> .goods_info .goods .icon{ display:inline-block; vertical-align:top; width:60px; height:60px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .icon img{ width:60px; height:60px; border:none;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price{ padding-left:10px;  display:inline-block; vertical-align:top; width:600px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price .title{text-align:left; display:block; line-height:20px; height:40px; font-size:1rem; text-decoration:none; overflow:hidden; white-space: normal;text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price .price{ font-size:1rem; line-height:20px; text-align:left;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price .price a{ padding-right:30px;}
	
	#<?php echo $module['module_name'];?> .goods_info .goods .comment{ text-align:right; line-height:25px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .buyer{}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .seller{ margin-top:10px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .user{ display:inline-block; width:50px; text-align:left;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .user:before{margin-right:8px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da";}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content{background: #F90; display:inline-block; padding-left:10px;  padding-right:10px; border-radius:5px; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; font-size:1rem;  max-width:70%;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .edit{ width:20px; height:25px; display:inline-block;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .del{ width:20px; height:25px; display:inline-block;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .edit:before{margin-right:8px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da";}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .del:before{margin-right:8px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da";}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content a:hover{ text-decoration:none;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .time{ padding-right:10px; color:#CCC; font-size:13px;}
	
	
	#<?php echo $module['module_name'];?> .remark{ color: #777; font-size:1rem;}
	
	
	#<?php echo $module['module_name'];?> .checkbox_td{ vertical-align:top; padding-top:8px;}
	#<?php echo $module['module_name'];?> .preferential_way{ background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; margin-top:10px; padding-left:5px; padding-right:5px; border-radius:5px;}
	#<?php echo $module['module_name'];?> .money_div{}
	#<?php echo $module['module_name'];?> .money_div .sum_money{}
	#<?php echo $module['module_name'];?> .money_div .sum_money .value{}
	#<?php echo $module['module_name'];?> .money_div .actual_money{}
	#<?php echo $module['module_name'];?> .money_div .actual_money .value{}
	#<?php echo $module['module_name'];?> .change_price_reason{ font-style:oblique; font-size:1rem;}
	
	#<?php echo $module['module_name'];?> .preferential_way{ line-height:20px; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;display:inline-block; padding:5px;}
	
	#<?php echo $module['module_name'];?> .state_remark{}
	#<?php echo $module['module_name'];?> .state_remark .pay_method{  display:inline-block; padding:5px; line-height:20px; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;border-radius:5px;}
	
	#<?php echo $module['module_name'];?> .operation_td a{ font-size:16px;}
	#<?php echo $module['module_name'];?> .operation_td .time_limit {padding-left: 18px;font-size: 1rem;color: #808080;}
	#<?php echo $module['module_name'];?> .operation_td .time_limit:before{margin-right:8px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f017";}
	
	#<?php echo $module['module_name'];?> .edit_a{ display:inline-block; height:20px; width:20px; }
	#<?php echo $module['module_name'];?> .edit_b{ display:inline-block; height:20px; width:20px;}
	#<?php echo $module['module_name'];?> .edit_a:before{margin-left:3px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f044";}
	#<?php echo $module['module_name'];?> .edit_b:before{margin-left:3px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f040";}
	#<?php echo $module['module_name'];?> .filter #time_limit .submit .b_middle{background: #ccc;padding: 5px 10px;border-radius:2px;}
	#<?php echo $module['module_name'];?> .filter .search .b_middle{background: #ccc;padding: 5px 10px; border-radius:2px;}
	#<?php echo $module['module_name'];?> .order_state{ display:block; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;  cursor:pointer; margin-bottom:10px; border-radius:5px;}
	#<?php echo $module['module_name'];?> .go_pay{ display:block; background: #F60; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; padding-left:5px;}
	#<?php echo $module['module_name'];?> .big_money{ font-size:18px; font-weight:bold; text-align:center; line-height:40px;}
	#<?php echo $module['module_name'];?> .pay_time_limit{ line-height:22px; font-size:1rem; color: #666;}
	#<?php echo $module['module_name'];?> .view_logistics{ display:block;}
	#<?php echo $module['module_name'];?> .cancel_reason{display:none;}
	.right_notice{display:none;position:absolute;height:30px; line-height:30px; overflow:hidden; white-space:nowrap; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; z-index:9999;}
	.mall_order{ padding:0px !important; overflow:hidden; margin-bottom:30px;}
	.mall_order:hover{ opacity:0.9;}
	.sort{ z-index:99999; line-height:2rem; height:2rem; padding:0px !important; margin:0px;background-color:#fff; margin-top:15px;}
	.sort .sort_inner{ margin:auto;}
	.sort div{ padding-top:0px !important;}
	.credits_remark{ display:inline-block; vertical-align:top; float:right; padding-right:0.5rem;	}
	.goods_id{ display:none;}
	.refund{ margin-left:10px; opacity:0.5;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    
    <div class=right_notice><span class=s>&nbsp;</span><span class=m>&nbsp;wertgh 444</span><span class=e>&nbsp;</span></div>
    
    
    <div  class="portlet light" >
    	<div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?>(<?php echo self::$language['shop_name']?>)</div>
            <div class="actions">
                <span id=state_select></span>
                <div class="btn-group">
                    <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                        <li><a href="#" href_pre="./index.php?monxin=mall.order_print" class="print_order" target="_blank"><?php echo self::$language['print_order']?></a></li> 
                        <li><a href="#" href_pre="./index.php?monxin=mall.order_print_list" class="order_print_list" target="_blank"><?php echo self::$language['pages']['mall.order_print_list']['name']?></a></li> 
                        <li><a href="#" href_pre="./index.php?monxin=mall.express_print" class="express_print" target="_blank"><?php echo self::$language['express_print']?></a></li> 
                    </ul>
                </div>
            </div>
    	</div>
    
        <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['order_number']?>/<?php echo self::$language['buyer']?><?php echo self::$language['username']?>/<?php echo self::$language['receiver_info'];?>/<?php echo self::$language['express_code']?>/<?php echo self::$language['preferential_code'];?>/<?php echo self::$language['promotion'];?>/<?php echo self::$language['check_code'];?>" class="form-control" style="width:500px;" ></m_label></div></div></div>
		
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?><br /><span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
       <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>

        
    </div>
    <div class=sum_div>
		<?php echo self::$language['sum']?>：<span class=sum_value><?php echo $module['sum']['sum']?></span><?php echo self::$language['yuan']?>
    </div>
    
    </div>

    <div class="sort">
    	<div class="sort_inner">
        <div class=checkbox_td><input type="checkbox" group-checkable=1></div>
        <div class=goods_td><a href=#  title="<?php echo self::$language['order']?>" desc="add_time|desc" class="sorting"  asc="add_time|asc"><?php echo self::$language['time']?></a></div>
        <div class=preferential_td><a href=# title="<?php echo self::$language['order']?>" desc="actual_money|desc" class="sorting"  asc="actual_money|asc"><?php echo self::$language['money']?></a></div>
        <div class=state_td><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['state']?></a></div>
        <div class=operation_td><span class=operation_icon> </span><?php echo self::$language['operation']?></div>
        </div>
    </div>
    
    

	<?php echo $module['list']?>
    <?php echo $module['page']?>
    </div>
</div>
