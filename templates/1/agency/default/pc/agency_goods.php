<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
            if($(this).attr('monxin_value')){$($(this).val($(this).attr('monxin_value')));}
        });
		
		$("#<?php echo $module['module_name'];?> input[type=checkbox]").each(function(index, element) {
            if($(this).attr('monxin_value')==1){$(this).prop('checked',true);}
        });
		
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			id=$(this).parent().parent().attr('id');
			if($("#<?php echo $module['module_name'];?> #"+id+" .state").prop('checked')){state=1;}else{state=0}
			//alert(state);
			$("#<?php echo $module['module_name'];?> #"+id+" .act_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=update',{id:id.replace(/tr_/,''),state:state,sequence:$("#<?php echo $module['module_name'];?> #"+id+"  .sequence").val(),type:$("#<?php echo $module['module_name'];?> #"+id+"  .type").val()},function(data){
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
                	if(v.state=='success'){$("#"+id+" td").animate({opacity:0},"slow",function(){$("#"+id).css('display','none');});}
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
	#<?php echo $module['module_name'];?>_html .restock{   border-radius:0.5rem; display:inline-block; line-height:1.2rem; padding:0.5rem;}
	#<?php echo $module['module_name'];?>_html .restock:hover{ opacity:0.8;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=1>
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
            <div class="actions"><a href=./index.php?monxin=agency.restock class=restock><?php echo self::$language['pages']['agency.restock']['name']?></a></div>
        </div>


    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['cover_image']?></td>
                <td style="text-align:left;"><?php echo self::$language['title']?></td>
                <td><?php echo self::$language['commission']?></td>
                <td><?php echo self::$language['supplier']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sold_sum|desc" class="sorting"  asc="sold_sum|asc"><?php echo self::$language['sold_sum']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="money_sum|desc" class="sorting"  asc="money_sum|asc"><?php echo self::$language['commission']?></a></td>
                <td><?php echo self::$language['goods_type']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sequence|desc" class="sorting"  asc="sequence|asc"><?php echo self::$language['sequence']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['goods_show']?></a></td>
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

