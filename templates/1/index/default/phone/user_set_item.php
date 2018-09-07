<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){

    });
    
    function add(){
        variableNew=$("#<?php echo $module['module_name'];?> #variable_new");	
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        optionsNew=$("#<?php echo $module['module_name'];?> #options_new");	
        default_valueNew=$("#<?php echo $module['module_name'];?> #default_value_new");
        sequenceNew=$("#<?php echo $module['module_name'];?> #sequence_new");
    
        if(variableNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['variable']?>');variableNew.focus();return false;}	
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(optionsNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['option']?>');optionsNew.focus();return false;}	
        if(default_valueNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['default_value']?>');default_valueNew.focus();return false;}	
        if(sequenceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{default_value:default_valueNew.prop('value'),name:nameNew.prop('value'),variable:variableNew.prop('value'),options:optionsNew.prop('value'),sequence:sequenceNew.prop('value')}, function(data){
           // monxin_alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
			if(v.state=='success'){$("#<?php echo $module['module_name'];?> #state_new").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');}
        });
        	
        return false;
    }
    
    
    function update(id){
        var variable=$("#<?php echo $module['module_name'];?> #variable_"+id);	
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        var options=$("#<?php echo $module['module_name'];?> #options_"+id);	
        var default_value=$("#<?php echo $module['module_name'];?> #default_value_"+id);	
        var sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);	
        if(variable.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['variable']?>');variable.focus();return false;}	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(options.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['option']?>');options.focus();return false;}	
        if(default_value.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['default_value']?>');default_value.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{options:options.prop('value'),variable:variable.prop('value'),name:name.prop('value'),default_value:default_value.prop('value'),sequence:sequence.prop('value'),id:id}, function(data){
            //monxin_alert(data);
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
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .name{width:200px;}
    #<?php echo $module['module_name'];?>_html .variable{width:200px;}
    #<?php echo $module['module_name'];?>_html .options{width:200px;}
    #<?php echo $module['module_name'];?>_html .default_value{width:100px;}
    #<?php echo $module['module_name'];?>_html .sequence{width:50px;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
        	<div class="caption" ><?php echo $module['monxin_table_name']?></div>
   	    </div>

    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><?php echo self::$language['variable']?></td>
                <td><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['option']?></td>
                <td><?php echo self::$language['default_value']?></td>
                <td><?php echo self::$language['sequence']?></td>
                <td width="30%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
            <tr id="<?php echo $module['module_name'];?>_new">
              <td ><input type="text" name="variable_new" id="variable_new" class='variable' /></td>
              <td ><input type="text" name="name_new" id="name_new" class='name' /></td>
              <td><input type="text" name="options_new" id="options_new" class='options' /></td>
              <td><input type="text" name="default_value_new" id="default_value_new" class='default_value' /></td>
              <td><input type="text" name="sequence_new" id="sequence_new" value="0" class='sequence' /></td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
        </tbody>
    </table></div>
    </div>

</div>
