<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#attribute_source").val($("#attribute_source").attr('monxin_value'));
		$("#<?php echo $module['module_name'];?> .list_show").each(function(index, element) {
            if($(this).attr('monxin_value')==1){$(this).prop('checked',true);}
        });
		
		if($("#attribute_source").val()==1){$("#<?php echo $module['module_name'];?>_html").css('display','block');}
		$("#attribute_source").change(function(){
			
			if($(this).val()==1){
				$("#<?php echo $module['module_name'];?>_html").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?>_html").css('display','none');
			}
			
			
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=attribute_source',{attribute_source:$(this).val()}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#attribute_source").next().html(v.info);
			});
				
		});
    });
    
    function add(){
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        valuesNew=$("#<?php echo $module['module_name'];?> #values_new");	
        sequenceNew=$("#<?php echo $module['module_name'];?> #sequence_new");
        list_showNew=$("#<?php echo $module['module_name'];?> #list_show_new");
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(sequenceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
		 if(list_showNew.prop('checked')){list_showNew.prop('value',1);}else{list_showNew.prop('value',0);}
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),values:valuesNew.prop('value'),sequence:sequenceNew.prop('value'),list_show:list_showNew.prop('value')}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
			if(v.state=='success'){$("#<?php echo $module['module_name'];?> #state_new").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');}
        });
        	
        return false;
    }
    
    
    function update(id){
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        var values=$("#<?php echo $module['module_name'];?> #values_"+id);	
        var sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);	
        var list_show=$("#<?php echo $module['module_name'];?> #list_show_"+id);	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        if(list_show.prop('checked')){list_show.prop('value',1);}else{list_show.prop('value',0);}
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),values:values.prop('value'),sequence:sequence.prop('value'),list_show:list_show.prop('value'),id:id}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        	
       return false; 
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
       return false; 
    }
    </script>
    <style>
	#<?php echo $module['module_name'];?> .attribute_source_div{  padding:20px;}
    #<?php echo $module['module_name'];?>_html{ display:none;}
    #<?php echo $module['module_name'];?>_html .name{width:120px;}
    #<?php echo $module['module_name'];?>_html .sequence{width:50px;}
	.values{width:500px;}
    </style>
     <div class=attribute_source_div><?php echo self::$language['attribute_source'];?><select id=attribute_source monxin_value="<?php echo $module['attribute_source'];?>" ><option value="0"><?php echo self::$language['parent_attribute'];?></option><option value="1"><?php echo self::$language['self_attribute'];?></option></select> <span></span></div>

	<fieldset id="<?php echo $module['module_name'];?>_html"  monxin-table=1><legend><?php echo self::$language['self_attribute'];?></legend>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['option_values']?></td>
                <td><?php echo self::$language['sequence']?></td>
                <td><a title="<?php echo self::$language['screening_show_long']?>"><?php echo self::$language['screening_show']?></a></td>
                <td width="30%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
            <tr id="<?php echo $module['module_name'];?>_new">
              <td ><input type="text" name="name_new" id="name_new" class='name' /></td>
              <td><input type="text" name="values_new" id="values_new" class='values' /></td>
              <td><input type="text" name="sequence_new" id="sequence_new" value="0" class='sequence' /></td>
              <td><input type="checkbox" name="list_show_new" id="list_show_new"  class='list_show' checked="checked" /></td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
        </tbody>
    </table></div>
    </fieldset>

</div>
