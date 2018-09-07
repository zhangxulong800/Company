<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .online_forbid").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .online_forbid").click(function(){
			if($(this).prop('checked')==true){$(this).val(1);}else{$(this).val(0);}	
			$.get('<?php echo $module['action_url'];?>&act=update',{id:$(this).attr('id').replace(/online_forbid_/,''),online_forbid:$(this).val()}, function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
			});
		});
		
    });
    function update(id){
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{id:id,online_forbid:$("#online_forbid_"+id).val()}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        	
       return false; 
    }
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .online_forbid{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['bar_code']?>/<?php echo self::$language['store_code']?>/<?php echo self::$language['detail']?>" class="form-control" ></m_label></div></div></div>
    
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td style="text-align:left;"><?php echo self::$language['goods_name']?></td>
                <td ><?php echo self::$language['price']?></td>
                <td ><?php echo self::$language['online_forbid']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
