<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
	var last_icon=0;
    $(document).ready(function(){

    });
    
    function add(){
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        sequenceNew=$("#<?php echo $module['module_name'];?> #sequence_new");
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(sequenceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),sequence:sequenceNew.prop('value')}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
            if(v.state=='success'){
                var new_td_first=$("#new_td_first");
                var new_td_last=$("#new_td_last");
                var new_td_first_html=new_td_first.html();
                var new_td_last_html=new_td_last.html();
                new_td_first.html(' ');
                new_td_last.html('<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');
                newTr="<tr id='chinnel_"+v.id+"'>"+$("#<?php echo $module['module_name'];?>_new").html()+"</tr>";
                newTr=newTr.replace(/_new/g,"_"+v.id);
                //monxin_alert(newTr);
                $(newTr).insertAfter($('#<?php echo $module['module_name'];?>_new'));
                
                $("#<?php echo $module['module_name'];?> #name_"+v.id).prop('value',nameNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #sequence_"+v.id).prop('value',sequenceNew.prop('value'));
   
                
                //parentNew.prop('value',-1);	
                nameNew.prop('value','');	
                urlNew.prop('value','');	
                sequenceNew.prop('value',0);
                
                new_td_first.html(new_td_first_html);
                new_td_last.html(new_td_last_html);
        
            }
    
        });
        	
        return false; 
    }
    
    
    function update(id){
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);
        if($("#<?php echo $module['module_name'];?> #visible_"+id).prop('checked')){visible=1;}else{visible=0;}
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),sequence:sequence.prop('value'),id:id}, function(data){
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
                if(v.state=='success'){$("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});}
            });
        }
        	
        return false; 
    }
    </script>
    <style>
    #<?php echo $module['module_name'];?>_table .sequence{width:40px;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
        </div>
    </div>
                        
                        
    

    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td width="20%"><?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['sequence']?></td>
                <td width="35%"  style="text-align:left;"><span class=operation_icon> </span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <tr id="<?php echo $module['module_name'];?>_new">
                <td ><input type="text" name="name_new" id="name_new" class='name' /></td>
              <td><input type="text" name="sequence_new" id="sequence_new" value="0" class='sequence' /></td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><span class=b_start> </span><span class=b_middle><?php echo self::$language['add']?></span><span class=b_end> </span></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>

</div>
