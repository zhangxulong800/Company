<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		var position=get_param('position');
		var type=get_param('type');
		if(position!=''){$("#position_filter").prop("value",position);}
		if(type!=''){$("#type_filter").prop("value",type);}
		
		$(document).on('click',"#<?php echo $module['module_name'];?> [monxin-table] .loss", function() {
  			id=$(this).attr('d_id');
			loss=parseFloat($("#<?php echo $module['module_name'];?> #tr_"+id+" .quantity").html())-parseFloat($("#<?php echo $module['module_name'];?> #tr_"+id+" .stocktake").val());
			if($("#<?php echo $module['module_name'];?> #tr_"+id+" .time").html()=='<?php echo self::$language['none']?>' && $("#<?php echo $module['module_name'];?> #tr_"+id+" #state_"+id).html().length<10){alert('<?php echo self::$language['first_please']?><?php echo self::$language['submit']?>');return false;}
			
			//if(loss<0){confirm_return=confirm('<?php echo self::$language['confirm'];?><?php echo self::$language['increase'];?>'+Math.abs(loss)+' '+$("#<?php echo $module['module_name'];?> #tr_"+id+" .unit").html());}
			//if(loss==0){confirm_return=confirm('<?php echo self::$language['confirm'];?><?php echo self::$language['correction'];?>');}
			//if(loss>0){confirm_return=confirm('<?php echo self::$language['confirm'];?><?php echo self::$language['loss'];?> '+loss+' '+$("#<?php echo $module['module_name'];?> #tr_"+id+" .unit").html());}
			//if(confirm_return){
				$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.post('<?php echo $module['action_url'];?>&act=loss',{id:id,stocktake:$("#<?php echo $module['module_name'];?> #tr_"+id+" .stocktake").val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#state_"+id).html(v.info);
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=success><?php echo self::$language['success'];?></span>');
						$("#<?php echo $module['module_name'];?> #state_"+id).prev().css('display','none');
					}
				});
			//}
			return false;
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?> [monxin-table] .bulk_loss", function() {
  			id=$(this).attr('d_id');
			confirm_return=confirm('<?php echo self::$language['confirm'];?> '+$(this).html());
			if(confirm_return){
				$("#<?php echo $module['module_name'];?> .bulk_loss_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.post('<?php echo $module['action_url'];?>&act=bulk_loss', function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#state_"+id).html(v.info);
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> .bulk_loss_state").html('<?php echo self::$language['success'];?>');
						$("#<?php echo $module['module_name'];?> .bulk_loss").css('display','none');	
					}
				});
			}
			return false;
		});
		
		
    });
	
	
    function update(id){
        var stocktake=$("#<?php echo $module['module_name'];?> #stocktake_"+id);	
        if(stocktake.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=fail><?php echo self::$language['please_input']?></span>');stocktake.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=update',{stocktake:stocktake.prop('value'),id:id}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        	
       return false; 
    }
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_table .icon img{ height:50px; width:50px; border:0px; margin-top:5px;}
    #<?php echo $module['module_name'];?>_table .title{ text-align:left; display:block; overflow:hidden; width:350px; }
	#<?php echo $module['module_name'];?>_table .inventory{display:<?php echo $module['sum_display'];?>;}
	#<?php echo $module['module_name'];?> .sum_div{ text-align:right; line-height:50px; display:<?php echo $module['sum_display'];?>;}
	#<?php echo $module['module_name'];?> .sum_div b{ }
	
	#<?php echo $module['module_name'];?> .stocktake{ width:3rem;}
	#<?php echo $module['module_name'];?> .option{ display:inline-block; vertical-align:top; font-weight:normal;   padding-left:0.4rem;padding-right:0.4rem;}
	#<?php echo $module['module_name'];?> .bulk_loss{display:inline-block; font-weight:normal;   padding-left:0.4rem;padding-right:0.4rem; line-height:2rem;}
	#<?php echo $module['module_name'];?> .bulk_loss:hover{ opacity:0.7;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?> <?php echo $module['s_name'];?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><a href='./index.php?monxin=mall.stocktake_add&stocktake_id=<?php echo @$_GET['stocktake_id']?>' target=_blank><?php echo self::$language['barcode']?><?php echo self::$language['stocktake']?></a> &nbsp; <?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>" class="form-control" ></m_label></div></div></div>
    <div class="filter"><?php echo self::$language['content_filter']?>:
       <?php echo $module['filter']?>
       <div class=sum_div>
       	<?php echo self::$language['sum']?><?php echo self::$language['inventory']?><b><?php echo $module['sum_inventory'];?></b><?php echo self::$language['piece']?> , <?php echo self::$language['stocktaked']?><?php echo self::$language['quantity']?><b><?php echo $module['sum_quantity'];?></b><?php echo self::$language['piece']?> , <a href=# class=bulk_loss  user_color=button><?php echo self::$language['end_stocktake']?></a> <span class=bulk_loss_state></span>
       </div>
        
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['cover_image']?></td>
                <td style="text-align:left;"><?php echo self::$language['goods_name']?></td>
                <td class=inventory><?php echo self::$language['inventory']?><?php echo self::$language['data']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="stocktake|desc" class="sorting"  asc="stocktake|asc"><?php echo self::$language['stocktaked']?><?php echo self::$language['quantity']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="loss|desc" class="sorting"  asc="loss|asc"><?php echo self::$language['has']?><?php echo self::$language['loss']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['lately']?><?php echo self::$language['stocktake']?></a></td>
                <td  style=" width:170px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
