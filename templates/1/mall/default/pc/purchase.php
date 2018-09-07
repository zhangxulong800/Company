<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
	<script>
    $(document).ready(function(){
		
            var supplier=get_param('supplier');
            if(supplier!=''){$("#supplier_filter").prop("value",supplier);}
            var purchase_name=get_param('purchase_name');
            if(purchase_name!=''){$("#purchase_name_filter").prop("value",purchase_name);}
		
		$("#<?php echo $module['module_name'];?> .purchase_name").blur(function(){
			if($(this).val()!='' &&　$.isNumeric($(this).val())){
				id=$(this).attr('d_id');
				$.post('<?php echo $module['action_url'];?>&act=purchase_name',{id:id,v:$(this).val()}, function(data){
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .purchase_name").css('background','green');  
					}else{
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .purchase_name").css('background','white'); 
					}
				});
			}	
		});
		
		$("#<?php echo $module['module_name'];?> .price").blur(function(){
			if($(this).val()!='' &&　$.isNumeric($(this).val())){
				id=$(this).attr('d_id');
				$.post('<?php echo $module['action_url'];?>&act=update',{id:id,v:$(this).val()}, function(data){
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .price").css('background','green');  
					}else{
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .price").css('background','white'); 
					}
				});
			}	
		});
		
		$("#<?php echo $module['module_name'];?> .payment").blur(function(){
			if($(this).val()!='' &&　$.isNumeric($(this).val())){
				id=$(this).attr('d_id');
				$.post('<?php echo $module['action_url'];?>&act=update_payment',{id:id,v:$(this).val()}, function(data){
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .payment").css('background','green');  
					}else{
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .payment").css('background','white'); 
					}
				});
			}	
		});
		
		$("#<?php echo $module['module_name'];?> .pay_wait").click(function(){
			window.location.href=window.location.href+'&pay_wait=1';
		});
		
		if(get_param('pay_wait')==1){
			
			
		}
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
	#<?php echo $module['module_name'];?> .print{ padding:5px; border-radius:5px;}
	#<?php echo $module['module_name'];?> .print:before{font: normal normal normal 18px/1 FontAwesome;content: "\f02f";	}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label>
            <span id=time_limit> <a href=./index.php?monxin=mall.purchase_add class=add><?php echo self::$language['pages']['mall.purchase_add']['name']?></a> &nbsp;<span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
            <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
        </m_label></div></div></div>
        
        <div class="filter"><?php echo self::$language['content_filter']?>: <?php echo $module['filter']?> <a href=./index.php?monxin=mall.purchase_print target="_blank" user_color=button class=print><?php echo self::$language['print']?>&<?php echo self::$language['export']?></a></div>
        
        <div class=sum_div>
			<?php echo self::$language['total_purchase_cost']?>:<b><?php echo $module['data']['sum'];?></b><?php echo self::$language['yuan']?> , 
            <?php echo self::$language['pay_end']?>:<b><?php echo $module['data']['pay_end'];?></b><?php echo self::$language['yuan']?> , 
            <?php echo self::$language['pay_wait']?>:<b><?php echo $module['data']['pay_wait'];?></b><?php echo self::$language['yuan']?> <a class="pay_wait"><?php echo self::$language['view']?></a>
        </div>
        
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['goods']?></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="supplier|desc" class="sorting"  asc="supplier|asc"><?php echo self::$language['goods_supplier']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="quantity|desc" class="sorting"  asc="quantity|asc"><?php echo self::$language['into_quantity']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="left|desc" class="sorting"  asc="left|asc"><?php echo self::$language['left']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="payment|desc" class="sorting"  asc="payment|asc"><?php echo self::$language['money_settled']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="price|desc" class="sorting"  asc="price|asc"><?php echo self::$language['cost_price']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="add_time|desc" class="sorting"  asc="add_time|asc"><?php echo self::$language['purchase']?><?php echo self::$language['time']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="expiration|desc" class="sorting"  asc="expiration|asc"><?php echo self::$language['expiration']?></a></td>
            </tr>
        </thead>
        <tbody>
            <tr style="display:none;" id="<?php echo $module['module_name'];?>_new">
              <td >&nbsp;</td>
              <td><input type="text" name="quantity" id="quantity" /></td>
              <td><input type="text" name="price" id="price" /></td>
              <td id="new_td_last" colspan="2"  style="text-align:left; height:60px;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['submit_into']?></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
