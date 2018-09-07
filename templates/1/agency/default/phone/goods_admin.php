<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		if('<?php echo $module['agency_mode']?>'==0){
			$("#<?php echo $module['module_name'];?> .first_stock").css('display','block');	
		}
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
            if($(this).attr('monxin_value')){$($(this).val($(this).attr('monxin_value')));}
        });
		
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			id=$(this).parent().parent().attr('id');
			$("#<?php echo $module['module_name'];?> #"+id+" .act_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=update',{id:id.replace(/tr_/,''),state:$("#<?php echo $module['module_name'];?> #"+id+"  .state").val(),sequence:$("#<?php echo $module['module_name'];?> #"+id+"  .sequence").val()},function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> #"+id+" .act_state").html(v.info);
			});
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .del").click(function(){
			confirm_return=confirm('<?php echo self::$language['opration_confirm'];?>');
			if(confirm_return){
				id=$(this).parent().parent().attr('id');
				$("#<?php echo $module['module_name'];?> #"+id+" .act_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.post('<?php echo $module['action_url'];?>&act=del',{id:id.replace(/tr_/,'')},function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#<?php echo $module['module_name'];?> #"+id+" .act_state").html(v.info);
				});
			}
			return false;
		});
		
    });
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ line-height:3rem; }
    #<?php echo $module['module_name'];?> table input{ text-align:center; width:3rem;}
    #<?php echo $module['module_name'];?> table .title{ width:10rem;}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .icon img{ width:5rem;	}
	#<?php echo $module['module_name'];?>_html .first_stock{ display:none; }
	#<?php echo $module['module_name'];?>_html .increase{ display:inline-block; line-height:2rem; padding:5px; border-radius:5px;  }
	#<?php echo $module['module_name'];?>_html .increase:hover{ }
	#<?php echo $module['module_name'];?>_html .increase:before{ font: normal normal normal 1rem/1 FontAwesome; content:"\f067"; padding-right:3px;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=1>
        <div class="portlet-title">
            <div class="caption"><?php echo self::$language['pages']['agency.shop_goods']['name']?></div>
            <div class="actions"></div>
        </div>

    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods']?>ID" class="form-control" ></m_label></div></div></div>

    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['cover_image']?></td>
                <td style="text-align:left;"><?php echo self::$language['title']?></td>
                <td><?php echo self::$language['commission']?></td>
                <td class=first_stock><?php echo self::$language['first_stock']?></td>
                <td><?php echo self::$language['supplier']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="agency_shop|desc" class="sorting"  asc="agency_shop|asc"><?php echo self::$language['agency_shop']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="agency_sold|desc" class="sorting"  asc="agency_sold|asc"><?php echo self::$language['sold']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['state']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sequence|desc" class="sorting"  asc="sequence|asc"><?php echo self::$language['sequence']?></a></td>
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

