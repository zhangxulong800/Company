<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> input[type='checkbox']").each(function(index, element) {
            if($(this).attr('monxin_value')==1){$(this).prop('checked',true);}
        });
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			id=$(this).parent().parent().attr('id').replace(/tr_/,'');
			//alert(id);
			if($("#<?php echo $module['module_name'];?> #tr_"+id+" input[type='checkbox']").prop('checked')){span_circle=1;}else{span_circle=0;}
			$("#<?php echo $module['module_name'];?> #tr_"+id+" .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update',{id:id,span_circle:span_circle}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> #tr_"+id+" .state").html(v.info);
			});
			return false;
		});

    });

    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['shop_name']?>/<?php echo self::$language['username']?>/<?php echo self::$language['main_business']?>/<?php echo self::$language['phone']?>/<?php echo self::$language['email']?>"  class="form-control" ></m_label></div></div></div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0" >
         <thead>
            <tr>
                <td ><?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['pages']['mall.span_shop']['name']?></td>
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
