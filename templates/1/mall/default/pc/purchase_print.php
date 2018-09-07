<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
	<script>
    $(document).ready(function(){
	
		var supplier=get_param('supplier');
		if(supplier!=''){$("#supplier_filter").prop("value",supplier);}
		var purchase_name=get_param('purchase_name');
		if(purchase_name!=''){$("#purchase_name_filter").prop("value",purchase_name);}
		
		$("#<?php echo $module['module_name'];?> .print").click(function(){
			window.print();
			
		});
		
		$("#<?php echo $module['module_name'];?> .pay_wait").click(function(){
			window.location.href=window.location.href+'&pay_wait=1';
		});
		
    });
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .goods_info{line-height:2rem;}
    #<?php echo $module['module_name'];?> .goods_info img{ height:2rem; border:none; margin-right:3px;}
	#<?php echo $module['module_name'];?> #time_limit input{ width:6rem;}
	#<?php echo $module['module_name'];?> .price{ width:50px;}
	#<?php echo $module['module_name'];?> .payment{ width:50px;}
	.pay_wait{ border:1px dashed #431112; border-radius:3px; padding:3px; cursor:pointer;}
	.pay_wait:hover{ font-weight:bold;}
	.sum_div b{ color:red;}
	.remark{ opacity:0.4;}
	.purchase_name{ width:90px;}
	#<?php echo $module['module_name'];?> .print{ padding:5px; border-radius:5px; cursor:pointer;}
	#<?php echo $module['module_name'];?> .print:before{font: normal normal normal 14px/1 FontAwesome;content: "\f02f"; padding-right:2px;	}
	#<?php echo $module['module_name'];?> .export{ padding:5px; border-radius:5px;cursor:pointer;}
	#<?php echo $module['module_name'];?> .export:before{font: normal normal normal 14px/1 FontAwesome;content:"\f1c3"; padding-right:2px;	}
	#<?php echo $module['module_name'];?> .riht_div{ float:right; text-align:right;}
	#<?php echo $module['module_name'];?> .no_print{ padding-bottom:1rem;}
	#<?php echo $module['module_name'];?> .head_info { }
	#<?php echo $module['module_name'];?> .head_info .shop_name{ text-align:center; font-size:2rem; font-weight:bold; line-height:4rem;}
	#<?php echo $module['module_name'];?> .head_info { }
   @media print {
	   #index_user_position,.page-header{ display:none;}
	   .light{ padding:0px;}
	   [m_container='m_container']{ padding:0px;}
	   #<?php echo $module['module_name'];?>{}
	   #<?php echo $module['module_name'];?>_html{}
	   #<?php echo $module['module_name'];?> .no_print{ display:none;}
	   .pay_wait{ display:none;}
	}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=no_print>
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
        </div>
                            
                            
                            
        <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label>
                <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
                <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
            </m_label></div></div></div>
            
        <div class="filter"><?php echo self::$language['content_filter']?>: <?php echo $module['filter']?></div>
        
            <div class=riht_div>
             <a user_color=button class=print><?php echo self::$language['print']?></a>             <a href=<?php echo $module['action_url']?>&act=export_csv&purchase_name=<?php echo @$_GET['purchase_name']?> target="_blank" user_color=button class=export><?php echo self::$language['export']?></a> 
            </div>
        
    </div>
    
    <div class=head_info>
    	<div class=shop_name><?php echo $module['shop_name'];?> <?php echo self::$language['purchase_bill']?></div>
        <div class=sum_div>
			<?php echo self::$language['total_purchase_cost']?>:<b><?php echo $module['data']['sum'];?></b><?php echo self::$language['yuan']?> , 
            <?php echo self::$language['pay_end']?>:<b><?php echo $module['data']['pay_end'];?></b><?php echo self::$language['yuan']?> , 
            <?php echo self::$language['pay_wait']?>:<b><?php echo $module['data']['pay_wait'];?></b><?php echo self::$language['yuan']?> <a class="pay_wait"><?php echo self::$language['view']?></a>
        </div>
        
    </div>    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['goods']?>/<?php echo self::$language['barcode']?></td>
                <td><?php echo self::$language['goods_supplier']?></td>
                <td><?php echo self::$language['cost_price']?></td>
                <td><?php echo self::$language['into_quantity']?></td>
                <td><?php echo self::$language['subtotal']?></td>
                <td><?php echo self::$language['purchase']?><?php echo self::$language['time']?></td>
                <td><?php echo self::$language['overdue']?><?php echo self::$language['time']?></td>
                <td><?php echo self::$language['money_settled']?></td>
                <td><?php echo self::$language['remark']?></td>
                <td><?php echo self::$language['storehouse']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
