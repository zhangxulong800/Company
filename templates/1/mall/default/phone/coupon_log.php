<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
	
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .order_id").each(function(index, element) {
            if(parseFloat($(this).html())>0){$(this).html('<a href=./index.php?monxin=mall.order_admin&id='+$(this).html()+' target=_blank>'+$(this).html()+'</a>');}
        });
    });
    
    function add(){
        if($("#<?php echo $module['module_name'];?> #option_id").html()!=null){
			if($("#<?php echo $module['module_name'];?> #option_id").val()==''){
				$("#<?php echo $module['module_name'];?> #state_new").html('<span class=fail><?php echo self::$language['please_select']?><?php echo self::$language['option']?></span>');
				$("#<?php echo $module['module_name'];?> #option_id").focus();
				
				return false;
			}
		}	
		if($("#<?php echo $module['module_name'];?> #quantity").val()==''){
			$("#<?php echo $module['module_name'];?> #state_new").html('<span class=fail><?php echo self::$language['please_select']?><?php echo self::$language['quantity']?></span>');
			$("#<?php echo $module['module_name'];?> #quantity").focus();
			
			return false;
		}
		if($("#<?php echo $module['module_name'];?> #price").val()==''){
			$("#<?php echo $module['module_name'];?> #state_new").html('<span class=fail><?php echo self::$language['please_select']?><?php echo self::$language['price']?></span>');
			$("#<?php echo $module['module_name'];?> #price").focus();
			
			return false;
		}

        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=add',{option_id:$("#<?php echo $module['module_name'];?> #option_id").val(),quantity:$("#<?php echo $module['module_name'];?> #quantity").val(),price:$("#<?php echo $module['module_name'];?> #price").val(),}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
			if(v.state=='success'){
				 $(v.html).insertAfter("#<?php echo $module['module_name'];?>_new");
				 $("#<?php echo $module['module_name'];?>_new select,#<?php echo $module['module_name'];?>_new input").val('');
				 parent.update_inventory('<?php echo $_GET['id']?>',v.sum);
			}
        });
        	
        return false;
    }
	
    </script>
	<style>
	.page-content{ }
	.page-footer{ display:none;}
	.fixed_right_div{ display:none; }
    #<?php echo $module['module_name'];?>{ width:790px;}
    #<?php echo $module['module_name'];?> .goods_title{ line-height:30px; padding-left:10px; font-weight:bold;}
    #<?php echo $module['module_name'];?> [monxin-table] .filter{ line-height:50px;} 
	#<?php echo $module['module_name'];?> [monxin-table] tbody tr{ line-height:30px; height:30px;}
	#<?php echo $module['module_name'];?> [monxin-table] .even td{ line-height:30px; height:30px;}
	#<?php echo $module['module_name'];?> [monxin-table] .odd td{ line-height:30px; height:30px;}
    #<?php echo $module['module_name'];?> [monxin-table] input{ width:80px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=goods_title><?php echo $module['data']['title']?> <?php echo self::$language['pages']['mall.coupon_log']['name'];?></div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['username']?></td>
                <td><?php echo self::$language['draws'];?><?php echo self::$language['time']?></td>
                <td><?php echo self::$language['use'];?><?php echo self::$language['time']?></td>
                <td><?php echo self::$language['use_order_id']?></td>
            </tr>
        </thead>
        <tbody>
    	<?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
