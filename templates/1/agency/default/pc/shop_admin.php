<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .set").click(function(){
			id=$(this).parent().parent().attr('id').replace(/tr_/,'');
			$("#<?php echo $module['module_name'];?> #tr_"+id+" .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=set',{id:id,set:$(this).attr('set')}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> #tr_"+id+" .state").html(v.info);
				if(v.state=='success'){
					if($("#<?php echo $module['module_name'];?> #tr_"+id+" .set").attr('set')==0){
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .set").html('<?php echo self::$language['set']?><?php echo self::$language['shop_state'][1]?>');
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .set").attr('set',1);
					}else{
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .set").html('<?php echo self::$language['set']?><?php echo self::$language['shop_state'][0]?>');
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .set").attr('set',0);
					}
				}
			});
			return false;
		});
		
    });
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
       return false; 
    }
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .store_name{}
    #<?php echo $module['module_name'];?>_html .store_name img{ height:2rem; padding-right:0.3rem;}
	#<?php echo $module['module_name'];?>_html [set='0']{ }
	#<?php echo $module['module_name'];?>_html [set='1']{ }
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['shop_name']?>/<?php echo self::$language['store_master']?>/<?php echo self::$language['referee']?>"  class="form-control" ></m_label></div></div></div>
    
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0" >
         <thead>
            <tr>
                <td><?php echo self::$language['shop_name']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="goods|desc" class="sorting"  asc="goods|asc"><?php echo self::$language['goods']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="order|desc" class="sorting"  asc="order|asc"><?php echo self::$language['orders']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sum_money|desc" class="sorting"  asc="sum_money|asc"><?php echo self::$language['sum_commission']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="visitor|desc" class="sorting"  asc="visitor|asc"><?php echo self::$language['visitor']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="rebate_2|desc" class="sorting"  asc="rebate_2|asc"><?php echo self::$language['level_2']?><?php echo self::$language['distributor']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="rebate_2|desc" class="sorting"  asc="rebate_3|asc"><?php echo self::$language['level_3']?><?php echo self::$language['distributor']?></a></td>
                <td><?php echo self::$language['store_master']?></td>
                <td><?php echo self::$language['referee']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td width="15%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=m_row><?php echo $module['page']?></div>
    </div>
    </div>

</div>
