<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .credits").blur(function(){
			$(".state").html('');
			id=$(this).attr('d_id');
			$("[d_id="+id+"]").next('.state').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update',{id:$(this).attr('d_id'),credits:$(this).val()}, function(data){
			  // alert(id);
			   try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("[d_id="+id+"]").next('.state').html(v.info);
			});
				
		});
    });
    
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_table .id{float:left;margin-left:10px; width:20px;}
    #<?php echo $module['module_name'];?> #index_admin_group_table a:hover{ }
    #<?php echo $module['module_name'];?> #parent_new{ margin-bottom:5px; margin-top:5px; }
    #<?php echo $module['module_name'];?> #name_new{ margin-bottom:5px;}
    #<?php echo $module['module_name'];?>_table .name{float:right; }
    #<?php echo $module['module_name'];?>_table .sequence{width:40px;}   
    #<?php echo $module['module_name'];?>_table .credits{width:60px;}   
    
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
   	    </div>

    
    
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['buy_credits_multiple']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    
    </div>

</div>
