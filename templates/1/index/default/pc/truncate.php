<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .truncate").click(function(){
			tables='';
			table_names='';
			$("#<?php echo $module['module_name'];?> .l input").each(function(index, element) {
                if($(this).prop('checked')){
					tables+=$(this).attr('t')+',';
					table_names+=$(this).parent().next().children('.c').children('.n').html()+',';
				}
            });
			if(tables==''){$("#<?php echo $module['module_name'];?> #state_select").html('<span class=fail><?php echo self::$language['select_null']?></span>'); return false;}
			if(confirm("<?php echo self::$language['make_sure_to_empty_the_table']?>"+table_names)){
				$("#<?php echo $module['module_name'];?> #state_select").html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.post('<?php echo $module['action_url'];?>&act=truncate',{tables:tables}, function(data){
					//monxin_alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#<?php echo $module['module_name'];?> #state_select").html(v.info);
					 if(v.state=='success'){
						tables=tables.split(',');
						for(v2 in tables){
							if(tables[v2]==''){continue;}
							$("#<?php echo $module['module_name'];?> .l [t='"+tables[v2]+"']").parent().next().children('.c').children('.rows').html('(0)');
						}
					}
				});
			}
			return false;
		});
    });

    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .tables{}
    #<?php echo $module['module_name'];?> .tables .t{ display:inline-block; vertical-align:top; width:30%; overflow:hidden; white-space:nowrap; margin:1%; border:1px solid #ccc; padding:5px;}
	 #<?php echo $module['module_name'];?> .tables .t .l{display:inline-block; vertical-align:top; width:10%;  overflow:hidden;}
	 #<?php echo $module['module_name'];?> .tables .t .r{display:inline-block; vertical-align:top; width:90%;  overflow:hidden;}
	 #<?php echo $module['module_name'];?> .tables .t .r .e{ display:block;}
	 #<?php echo $module['module_name'];?> .tables .t .r .c{display:block;}
	 #<?php echo $module['module_name'];?> .tables .t .r .c .length{ opacity:0.3;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
        	<div class="caption" ><?php echo $module['monxin_table_name']?></div>
            <div class=actions>
                <span id=state_select></span>
                <div class="btn-group" >
                    <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="truncate" ><?php echo self::$language['pages']['index.truncate']['name']?></a></li> 
                    </ul>
                </div>
            </div>
		</div>
		<div class=return_false><?php echo  self::$language['in_order_to_avoid_data_loss_caused_by_accidental_please_backup_the_database_then_execute_the_operation']?></div>
        <div class=tables><?php echo $module['list'];?></div>

    </div>
</div>

