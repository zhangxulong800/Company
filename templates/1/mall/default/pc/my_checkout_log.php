<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    
    
    <script>
	
    $(document).ready(function(){
		if(get_param('cashier')!=''){$("#cashier").prop('value','<?php echo @$_GET['cashier'];?>');}
		if(get_param('pay_method')!=''){$("#pay_method").prop('value',get_param('pay_method'));}
		if(get_param('preferential_way')!=''){$("#preferential_way").prop('value',get_param('preferential_way'));}
		
		$("#<?php echo $module['module_name'];?> .yun_print").click(function(){
			id=$(this).parent().parent().attr('id').replace(/tr_/,'');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=yun_print',{id:id}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#state_"+id).html(v.info);
			});
			return false;
		});
		
		$(document).on('click', "#<?php echo $module['module_name'];?> [monxin-table] .cancel",function() {
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
				id=$(this).parent().parent().attr('id').replace(/tr_/,'');
				$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=cancel',{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#state_"+id).html(v.info);
					if(v.state=='success'){
						$("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
					}
				});
			}
			return false; 	
		});
		
    });
    
    
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> [monxin-table] .filter{ line-height:50px;} 
	
    #<?php echo $module['module_name'];?> #search_filter{ width:680px;}
	#<?php echo $module['module_name'];?> .sum_div{ text-align:right; line-height:50px; padding-right:10px;}
	#<?php echo $module['module_name'];?> .sum_div .sum_value{ font-weight:bold; }
	#<?php echo $module['module_name'];?> .sum_div .item{ padding-left:30px; }
	#<?php echo $module['module_name'];?> .sum_div .item .value{font-weight:bold;  }
	#<?php echo $module['module_name'];?> .yun_print{ cursor:pointer;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['order_number']?>/<?php echo self::$language['buyer']?><?php echo self::$language['username']?>" class="form-control" ></m_label></div></div></div>
    
    
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
       
         <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>

    </div>
    <div class=sum_div>
		<?php echo self::$language['sum']?>：<span class=sum_value><?php echo $module['sum']['sum']?></span><?php echo self::$language['yuan']?>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><a href=#  title="<?php echo self::$language['order']?>" desc="id|desc" class="sorting"  asc="id|asc"><?php echo self::$language['order_number']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="buyer|desc" class="sorting"  asc="buyer|asc"><?php echo self::$language['buyer']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="actual_money|desc" class="sorting"  asc="actual_money|asc"><?php echo self::$language['money']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="pay_method|desc" class="sorting"  asc="pay_method|asc"><?php echo self::$language['pay_method_str']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="preferential_way|desc" class="sorting"  asc="preferential_way|asc"><?php echo self::$language['use_method']?></a></td>
                <td><a href=#  title="<?php echo self::$language['order']?>" desc="add_time|desc" class="sorting"  asc="add_time|asc"><?php echo self::$language['time']?></a></td>
                <td  style=" width:220px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
