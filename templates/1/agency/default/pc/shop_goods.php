<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		if('<?php echo $module['agency_mode']?>'==0){
			$("#<?php echo $module['module_name'];?> .first_stock").css('display','block');	
		}
		
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			id=$(this).parent().parent().attr('id');
			$("#<?php echo $module['module_name'];?> #"+id+" .act_state").html('');
			check_result=true;
			$("#<?php echo $module['module_name'];?> #"+id+"  input").each(function(index, element) {
                if($(this).val()==''){$("#<?php echo $module['module_name'];?> #"+id+" .act_state").html('<?php echo self::$language['is_null']?>');check_result=false;return false;}
                if(!$.isNumeric($(this).val())){$("#<?php echo $module['module_name'];?> #"+id+" .act_state").html('<?php echo self::$language['please_input']?><?php echo self::$language['number']?>');check_result=false;return false;}
				
            });
			if(!check_result){return false;}
			$("#<?php echo $module['module_name'];?> #"+id+" .act_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=update',{id:id.replace(/tr_/,''),rebate_1:$("#<?php echo $module['module_name'];?> #"+id+"  .rebate_1").val(),rebate_2:$("#<?php echo $module['module_name'];?> #"+id+"  .rebate_2").val(),rebate_3:$("#<?php echo $module['module_name'];?> #"+id+"  .rebate_3").val(),stock:$("#<?php echo $module['module_name'];?> #"+id+"  .stock").val()},function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> #"+id+" .act_state").html(v.info);
			});
			return false;
		});
		
    });
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ line-height:3rem; }
    #<?php echo $module['module_name'];?> table input{ text-align:center; width:3rem;}
    #<?php echo $module['module_name'];?> table .title{ width:15rem;}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .icon img{ width:5rem;	}
	#<?php echo $module['module_name'];?>_html .first_stock{ display:none; }
	#<?php echo $module['module_name'];?>_html .increase{ display:inline-block; line-height:2rem; padding:5px; border-radius:5px;  }
	#<?php echo $module['module_name'];?>_html .increase:hover{ }
	#<?php echo $module['module_name'];?>_html .increase:before{ font: normal normal normal 1rem/1 FontAwesome; content:"\f067"; padding-right:3px;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=1>
		<div class="alert alert-success" role="alert"><?php echo $module['agency_remark'];?></div>
        
        <div class="portlet-title">
            <div class="caption"><?php echo self::$language['pages']['agency.shop_goods']['name']?></div>
            <div class="actions"><a href=./index.php?monxin=mall.goods_admin&act=agency class=increase><?php echo self::$language['increase'];?></a></div>
        </div>


    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['cover_image']?></td>
                <td style="text-align:left;"><?php echo self::$language['title']?></td>
                <td><?php echo self::$language['rebate_1']?></td>
                <td><?php echo self::$language['rebate_2']?></td>
                <td><?php echo self::$language['rebate_3']?></td>
                <td class=first_stock><?php echo self::$language['first_stock']?></td>
                <td><?php echo self::$language['state']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="agency_shop|desc" class="sorting"  asc="agency_shop|asc"><?php echo self::$language['agency_shop']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="agency_sold|desc" class="sorting"  asc="agency_sold|asc"><?php echo self::$language['agency_sold']?></a></td>
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

