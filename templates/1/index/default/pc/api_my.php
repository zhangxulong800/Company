<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .apply").click(function(){
			id=$(this).attr('d_id');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=add',{id:id}, function(data){
			   //alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> a[d_id="+id+"]").parent().html('<?php echo self::$language['api_state']['api_application']?>');
				}
				
			});
			return false;
		});
		
    });
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .apply{ margin-left:10px; border:1px dashed #ccc; padding:3px; border-radius:3px;}
	#<?php echo $module['module_name'];?> .doc_url{}
	#<?php echo $module['module_name'];?> .doc_url:hover{ font-weight:bold;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
     apikey: <?php echo $module['data']['key']?>                   
                        
    <div class="m_row"><div class="half">&nbsp;</div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"   placeholder="<?php echo self::$language['name']?>/api" class="form-control" ></m_label></div></div></div>

    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td>API</td>
                <td><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['apply_2']?><?php echo self::$language['state']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>

</div>
