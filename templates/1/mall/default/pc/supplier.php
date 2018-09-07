<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){

    });
    
    function add(){
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        link_manNew=$("#<?php echo $module['module_name'];?> #link_man_new");	
        contactNew=$("#<?php echo $module['module_name'];?> #contact_new");	
        sequenceNew=$("#<?php echo $module['module_name'];?> #sequence_new");
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(link_manNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['link_man']?>');link_manNew.focus();return false;}	
        if(contactNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['contact']?>');contactNew.focus();return false;}	
        if(sequenceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),link_man:link_manNew.prop('value'),contact:contactNew.prop('value'),sequence:sequenceNew.prop('value')}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
			if(v.state=='success'){$("#<?php echo $module['module_name'];?> #state_new").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');}
        });
        	
        return false;
    }
    
    
    function update(id){
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        var link_man=$("#<?php echo $module['module_name'];?> #link_man_"+id);	
        var contact=$("#<?php echo $module['module_name'];?> #contact_"+id);	
        var sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),link_man:link_man.prop('value'),contact:contact.prop('value'),sequence:sequence.prop('value'),id:id}, function(data){
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
    #<?php echo $module['module_name'];?>_html .name{width:200px;}
    #<?php echo $module['module_name'];?>_html .sequence{width:50px;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['link_man']?></td>
                <td><?php echo self::$language['contact']?></td>
                <td><?php echo self::$language['sequence']?></td>
                <td><?php echo self::$language['total_purchase_cost']?></td>
                <td><?php echo self::$language['pay_end']?></td>
                <td><?php echo self::$language['pay_wait']?></td>
                <td width="30%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
            <tr id="<?php echo $module['module_name'];?>_new">
              <td ><input type="text" name="name_new" id="name_new" class='name' /></td>
              <td ><input type="text" name="link_man_new" id="link_man_new" class='link_man' /></td>
              <td ><input type="text" name="contact_new" id="contact_new" class='contact' /></td>
              <td><input type="text" name="sequence_new" id="sequence_new" value="0" class='sequence' /></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
        </tbody>
    </table></div>
    </div>

</div>
