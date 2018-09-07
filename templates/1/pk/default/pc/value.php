<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .pk_checkbox").each(function(index, element) {
            if($(this).attr('monxin_value')==1){$(this).prop('checked',true);}
        });
		if(<?php echo $module['item_deep'];?>==3){
			td_max=3
			$("#<?php echo $module['module_name'];?> tbody tr").each(function(index, element) {
                td_max=Math.max(td_max,$(this).children('td').length);
            });
			$("#<?php echo $module['module_name'];?> tbody tr").each(function(index, element) {
               i=($(this).children('.object:first').index()-1);
			   if($(this).children('td:eq('+i+')').attr('class')=='level_2'){$(this).children('td:eq('+i+')').attr('colspan',2);}
			   if($(this).children('td:eq('+i+')').attr('class')=='level_1'){$(this).children('td:eq('+i+')').attr('colspan',3);}
            });
		}
		if(<?php echo $module['item_deep'];?>==2){
			td_max=3
			$("#<?php echo $module['module_name'];?> tbody tr").each(function(index, element) {
                td_max=Math.max(td_max,$(this).children('td').length);
            });
			$("#<?php echo $module['module_name'];?> tbody tr").each(function(index, element) {
               i=($(this).children('.object:first').index()-1);
			   if($(this).children('td:eq('+i+')').attr('class')=='level_2'){$(this).children('td:eq('+i+')').attr('colspan',1);}
			   if($(this).children('td:eq('+i+')').attr('class')=='level_1'){$(this).children('td:eq('+i+')').attr('colspan',2);}
            });
		}
		
		
		$("#<?php echo $module['module_name'];?> .pk_checkbox").change(function(){
			if($(this).prop('checked')){checked=1;}else{checked=0;}	
			$.get('<?php echo $module['action_url'];?>&act=checked',{checked:checked,object_id:$(this).parent().attr('object_id'),item_id:$(this).parent().attr('item_id')}, function(data){
				//alert(data);
			});
		});
		
		$("#<?php echo $module['module_name'];?> .pk_value").blur(function(){
			$.get('<?php echo $module['action_url'];?>&act=value',{value:$(this).val(),object_id:$(this).parent().attr('object_id'),item_id:$(this).parent().attr('item_id')}, function(data){
				//alert(data);
			});
		});
		
		
		
    });

    function update(id){
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        var sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        if($("#state_"+id).prop('checked')){state=1;}else{state=0;}	
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),sequence:sequence.prop('value'),state:state,id:id}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        	
       return false; 
    }
    </script>
    <style>
	.container{width:100% !important; padding:0px;}
	.fixed_right_div{ display:none;}
	#<?php echo $module['module_name'];?>{ margin:0px; padding-bottom:5rem;}
	#<?php echo $module['module_name'];?> .pk_value{ margin-left:3px; padding-left:3px; width:80%;}
	#<?php echo $module['module_name'];?> td{ vertical-align: middle;}
	#<?php echo $module['module_name'];?> td[rowspan]{ width:1rem;word-wrap:break-word; padding:1rem;}
	#<?php echo $module['module_name'];?> td[rowspan='0']{ min-width:5rem;}
	#<?php echo $module['module_name'];?> td[rowspan='1']{ min-width:5rem;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr><?php echo $module['thead']?></tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>

</div>
