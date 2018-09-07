<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .state").click(function(){
            id=this.id;
            id=id.replace("state_","");
            if($(this).prop('checked')){state=1;}else{state=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_state',{id:id,state:state});
		});
        $("[monxin-table] tbody tr").each(function(index, element) {
            $("#"+$(this).attr('id')+' .parent').prop('value',$(this).attr('parentid'));
        });
    });
    
    function add(){
        parentNew=$("#<?php echo $module['module_name'];?> #parent_new");
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        sequenceNew=$("#<?php echo $module['module_name'];?> #sequence_new");
        if($("#<?php echo $module['module_name'];?> #state_new").prop('checked')){state=1;}else{state=0;}
    
        if(parentNew.prop('value')<0){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_select']?><?php echo self::$language['parent']?>');parentNew.focus();return false;}	
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(sequenceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{parent:parentNew.prop('value'),name:nameNew.prop('value'),sequence:sequenceNew.prop('value'),state:state}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
            if(v.state=='success'){
                var new_td_first=$("#new_td_first");
                var new_td_last=$("#new_td_last");
                var new_td_first_html=new_td_first.html();
                var new_td_last_html=new_td_last.html();
                new_td_first.html('&nbsp;');
                new_td_last.html('<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');
                newTr="<tr id='chinnel_"+v.id+"'>"+$("#<?php echo $module['module_name'];?>_new").html()+"</tr>";
                newTr=newTr.replace(/_new/g,"_"+v.id);
                //monxin_alert(newTr);
                $(newTr).insertAfter($('#<?php echo $module['module_name'];?>_new'));
                
                $("#<?php echo $module['module_name'];?> #parent_"+v.id).prop('value',parentNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #name_"+v.id).prop('value',nameNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #sequence_"+v.id).prop('value',sequenceNew.prop('value'));
                if($("#<?php echo $module['module_name'];?> #state_new").prop('checked')){$("#state_"+v.id).prop('checked',true);}else{$("#state_"+v.id).prop('checked',false);}
    
                
                parentNew.prop('value',-1);	
                nameNew.prop('value','');	
                sequenceNew.prop('value',0);
                
                new_td_first.html(new_td_first_html);
                new_td_last.html(new_td_last_html);
        
            }
    
        });
        	
        return false; 
    }
    
    
    function update(id){
        var parent=$("#<?php echo $module['module_name'];?> #parent_"+id);
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);
        if($("#<?php echo $module['module_name'];?> #state_"+id).prop('checked')){state=1;}else{state=0;}
        if(parent.prop('value')<0){$("#<?php echo $module['module_name'];?> #act_state_"+id).html('<?php echo self::$language['please_select']?><?php echo self::$language['parent']?>');parent.focus();return false;}	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #act_state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #act_state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #act_state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{parent:parent.prop('value'),name:name.prop('value'),sequence:sequence.prop('value'),id:id,state:state}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
            $("#<?php echo $module['module_name'];?> #act_state_"+id).html(v.info);
        });
        return false; 	
        
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #act_state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#<?php echo $module['module_name'];?> #act_state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
        return false; 
    }
    function subimt_select(){
        ids=get_ids();
        if(ids==''){$("#<?php echo $module['module_name'];?> #state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['parent']=$("#<?php echo $module['module_name'];?> #parent_"+ids[id]).prop('value');
            obj[id]['name']=$("#<?php echo $module['module_name'];?> #name_"+ids[id]).prop('value');
            obj[id]['sequence']=$("#<?php echo $module['module_name'];?> #sequence_"+ids[id]).prop('value');
            //monxin_alert(obj[id]['name']);
            $("#act_state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
                alert(ids+"=="+data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#<?php echo $module['module_name'];?> #state_select").html(v.info);
                success=v.ids.split("|");
                for(id in ids){
                    if(in_array(ids[id],success)){
                        $("#act_state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                    }else{
                        $("#act_state_"+ids[id]).html("<span class=success><?php echo self::$language['executed'];?></span>");	
                    }	
                }
        });	
        
         return false;
        
        	
    }
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#<?php echo $module['module_name'];?> #state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
            idss=ids;
            ids=ids.split("|");	
            for(id in ids){
                if(ids[id]!=''){$("#act_state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
            }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
               	//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#<?php echo $module['module_name'];?> #state_select").html(v.info);
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#act_state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                        $("#act_state_"+ids[id]).html("<?php echo self::$language['fail'];?>,<?php echo self::$language['have_sub'];?>");	
                    }	
                }
            });
        }	
         return false;	
    }
    
    function show_select(flag){
        ids=get_ids();
        if(ids==''){$("#<?php echo $module['module_name'];?> #state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(flag){state=true;}else{state=false;}
        $.get('<?php echo $module['action_url'];?>&act=operation_state&state='+flag,{ids:ids}, function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#<?php echo $module['module_name'];?> #state_select").html(v.info);
                if(v.state=='success'){
                    ids=ids.split('|');
                    for(id in ids){$("#<?php echo $module['module_name'];?> #state_"+ids[id]).prop('checked',state);}
                }
        });
         return false;	
    }
    
    </script>
    <style>
	.fixed_right_div,.page-footer,#mall_cart{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
	#<?php echo $module['module_name'];?>{ margin:0px; padding-bottom:5rem;}
    #<?php echo $module['module_name'];?>_table .parent{ float:left;}
    #<?php echo $module['module_name'];?>_table .name{float:right; width:4rem !important;}
    #<?php echo $module['module_name'];?>_table .sequence{width:40px;}
    #<?php echo $module['module_name'];?>_table .state{:#CCC}
	
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a></li> 
                    <li><a href="#"  onclick="return show_select(1);" class=show><?php echo self::$language['show']?></a></li> 
                    <li><a href="#" onclick="return show_select(0);" class=hide><?php echo self::$language['hide']?></a></li> 
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td width="4"><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['parent']?></td>
                <td ><?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['sequence']?></td>
                <td ><?php echo self::$language['open']?></td>
                <td  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <tr id="<?php echo $module['module_name'];?>_new">
                <td id="new_td_first"></td>
                <td><select name="parent_new" id="parent_new" class='parent'>
                <option value="-1"><?php echo self::$language['select_please']?></option>
                <option value="0">--<?php echo self::$language['none']?>--</option>
                <?php echo $module['parent']?>
                </select></td>
                <td ><input type="text" name="name_new" id="name_new" class='name' style="width:97%;" /></td>
              <td><input type="text" name="sequence_new" id="sequence_new" value="0" class='sequence' /></td>
              <td><input type='checkbox' name='state_new' id='state_new' checked="checked"  /></td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>

</div>
