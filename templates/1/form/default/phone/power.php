<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){
		ids='<?php echo $module['ids']?>';
		if(ids!=''){
			ids=ids.split('|');
			for(id in ids){
				$("#"+ids[id]).prop('checked',true);	
       		}	
		}
    });
    
    
    function subimt_select(){
        ids=get_ids();
		$("#state_select").html('<span class=\'fa fa-spinner fa-spin\'></span>');	
        $.post("<?php echo $module['action_url'];?>&act=submit_select",{ids:ids},function(data){
            //alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#state_select").html(v.info);
        });	
        
        
        return false;
        	
    }
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>_table .id{float:left;margin-left:10px; width:20px;}
	#<?php echo $module['module_name'];?>_table .blank{ display:none;}
    #<?php echo $module['module_name'];?>_table .name{float:right; text-align:left; display:inline-block;  }
    .blank{ width:70%;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=batch_operation_div>
    			<span class="corner">&nbsp;</span>
    
                <a href="#" class="select_all" onclick="return select_all();"><?php echo self::$language['select_all']?></a>
                <a href="#" class="reverse_select" onclick="return reverse_select();"><?php echo self::$language['reverse_select']?></a>
                 <?php echo self::$language['selected']?>:
                 <a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a> 
                  <span id="state_select"></span>
                  <a href="./index.php?monxin=form.table_admin" class="set"><?php echo self::$language['return']?></a>
                  </div>
    </div>

</div>
