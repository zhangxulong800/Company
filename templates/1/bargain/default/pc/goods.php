<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		
    });
	
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false; 	
        
    }
    
	
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
        <div class="portlet-title">
            <div class="caption"><?php echo self::$language['pages']['bargain.goods']['name']?></div>
            <div class="actions"><a href=./index.php?monxin=mall.goods_admin&act=bargain class=increase><?php echo self::$language['increase'];?></a></div>
        </div>


    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['cover_image']?></td>
                <td style="text-align:left;"><?php echo self::$language['title']?></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="view|desc" class="sorting"  asc="view|asc"><?php echo self::$language['visit_sum']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="sum_sold|desc" class="sorting"  asc="sum_sold|asc"><?php echo self::$language['sum_sold']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="sum_money|desc" class="sorting"  asc="sum_money|asc"><?php echo self::$language['sum_money']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="start_time|desc" class="sorting"  asc="start_time|asc"><?php echo self::$language['start_time']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="end_time|desc" class="sorting"  asc="end_time|asc"><?php echo self::$language['end_time']?></a></td>
                <td><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['state']?></a></td>
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

