<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
       $("#<?php echo $module['module_name'];?> .submit").click(function(){
		id=$(this).parent().parent().attr('id');
		$("#"+id+" .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.post('<?php echo $module['action_url'];?>&act=update',{id:id.replace('tr_',''),discount:$("#"+id+" .discount").val()}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#"+id+" .state").html(v.info);
		});

		return false;
		}); 
    });
    </script>
    <style>
	.fixed_right_div,.page-footer,#mall_cart{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
	#<?php echo $module['module_name'];?>_html{}
    
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
        	<div class="caption"><?php echo $module['monxin_table_name']?></div>
   		</div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['default']?><?php echo self::$language['join_goods_front'][0]?><?php echo self::$language['rebate']?></td>
                <td><?php echo self::$language['goods_membership_discount']?></td>
                <td width="30%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    
    </div>

</div>
