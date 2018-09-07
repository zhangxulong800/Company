<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
	var last_icon=0;
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .visible").click(function(){
            id=this.id;
            id=id.replace("visible_","");
            if($(this).prop('checked')){visible=1;}else{visible=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_visible',{id:id,visible:visible});
		});
        $("[monxin-table] tbody tr").each(function(index, element) {
            $("#"+$(this).attr('id')+' .parent').prop('value',$(this).attr('parentid'));
        });
		
		$('.icon').click(function(){
			last_icon=$(this).attr('id');
			replace_file=$("#"+$(this).attr('id')+" img").attr('src');
			replace_file=replace_file.split('?');
			replace_file=replace_file[0];
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','index.php?monxin=index.replace_file&path='+replace_file+'&width=256&height=256');
			return false;	
		});
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			$("#<?php echo $module['module_name'];?> #"+last_icon+" img").attr('src',$("#<?php echo $module['module_name'];?> #"+last_icon+" img").attr('src')+'?re='+Math.random());
			return false;
		});
		$("#<?php echo $module['module_name'];?> .remark,.type_price").click(function(){
			set_iframe_position(1200,500);
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
    });
    
    function add(){
        parentNew=$("#<?php echo $module['module_name'];?> #parent_new");
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        urlNew=$("#<?php echo $module['module_name'];?> #url_new");	
        sequenceNew=$("#<?php echo $module['module_name'];?> #sequence_new");
        if($("#<?php echo $module['module_name'];?> #visible_new").prop('checked')){visible=1;}else{visible=0;}
    
        if(parentNew.prop('value')<0){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_select']?><?php echo self::$language['parent']?>');parentNew.focus();return false;}	
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(sequenceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{parent:parentNew.prop('value'),name:nameNew.prop('value'),url:urlNew.prop('value'),t_cid:$("#<?php echo $module['module_name'];?> #t_cid_new").prop('value'),sequence:sequenceNew.prop('value'),visible:visible}, function(data){
            //monxin_//alert(data);
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
                
                $("#<?php echo $module['module_name'];?> #parent_"+v.id).prop('value',parentNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #name_"+v.id).prop('value',nameNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #url_"+v.id).prop('value',urlNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #t_cid_"+v.id).prop('value',$("#<?php echo $module['module_name'];?> #t_cid_new").prop('value'));
                $("#<?php echo $module['module_name'];?> #sequence_"+v.id).prop('value',sequenceNew.prop('value'));
                if($("#<?php echo $module['module_name'];?> #visible_new").prop('checked')){$("#visible_"+v.id).prop('checked',true);}else{$("#visible_"+v.id).prop('checked',false);}
    
                
                //parentNew.prop('value',-1);	
                nameNew.prop('value','');	
                urlNew.prop('value','');	
                sequenceNew.prop('value',0);
                $("#<?php echo $module['module_name'];?> #t_cid_new").prop('value','0');
                new_td_first.html(new_td_first_html);
                new_td_last.html(new_td_last_html);
        
            }
    
        });
        	
        return false; 
    }
    
    
    function update(id){
        var parent=$("#<?php echo $module['module_name'];?> #parent_"+id);
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        var url=$("#<?php echo $module['module_name'];?> #url_"+id);	
        sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);
        if($("#<?php echo $module['module_name'];?> #visible_"+id).prop('checked')){visible=1;}else{visible=0;}
        if(parent.prop('value')<0){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_select']?><?php echo self::$language['parent']?>');parent.focus();return false;}	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{parent:parent.prop('value'),name:name.prop('value'),url:url.prop('value'),t_cid:$("#<?php echo $module['module_name'];?> #t_cid_"+id).prop('value'),sequence:sequence.prop('value'),id:id,visible:visible}, function(data){
            //monxin_//alert(data);
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
            obj[id]['url']=$("#<?php echo $module['module_name'];?> #url_"+ids[id]).prop('value');
            obj[id]['t_cid']=$("#<?php echo $module['module_name'];?> #t_cid_"+ids[id]).prop('value');
            obj[id]['sequence']=$("#<?php echo $module['module_name'];?> #sequence_"+ids[id]).prop('value');
            //monxin_alert(obj[id]['name']);
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
                //monxin_alert(ids+"=="+data);
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#<?php echo $module['module_name'];?> #state_select").html(v.info);
                success=v.ids.split("|");
                for(id in ids){
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                    }else{
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['executed'];?></span>");	
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
                if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
            }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
                //alert(data);
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#<?php echo $module['module_name'];?> #state_select").html(v.info);
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>,<?php echo self::$language['have_sub'];?>");	
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
        if(flag){visible=true;}else{visible=false;}
        $.get('<?php echo $module['action_url'];?>&act=operation_visible&visible='+flag,{ids:ids}, function(data){
			//monxin_//alert(data);
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#<?php echo $module['module_name'];?> #state_select").html(v.info);
                if(v.state=='success'){
                    ids=ids.split('|');
                    for(id in ids){$("#<?php echo $module['module_name'];?> #visible_"+ids[id]).prop('checked',visible);}
                }
        });
         return false;	
    }
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>_table .parent{ width:200px; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .name{float:right;width:100px;}
    #<?php echo $module['module_name'];?>_table .url{width:100px;}
    #<?php echo $module['module_name'];?>_table .sequence{width:40px;}
    #<?php echo $module['module_name'];?>_table .visible{}
	#<?php echo $module['module_name'];?> .icon{background:#ff9600; border-radius:3px; display:inline-block; vertical-align:top; width:30px; height:30px; padding:2px; margin-right:5px;}
	#<?php echo $module['module_name'];?> .icon img{ width:30px; height:30px; border:0px;}
	#<?php echo $module['module_name'];?> .t_cid{ width:80px;}
	
#set_monxin_iframe_div{top:40%; left:420px; }
#monxin_iframe{ height:100px;width:500px;}
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
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"></div></div>
    

    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td width="14%"><?php echo self::$language['parent']?></td>
                <td width="20%"><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['type_icon']?></td>
                <td><?php echo self::$language['url']?></td>
                <td><?php echo self::$language['t_cid']?></td>
                <td ><?php echo self::$language['sequence']?></td>
                <td ><?php echo self::$language['visible']?></td>
                <td width="20%"  style="text-align:left;"><span class=operation_icon> </span><?php echo self::$language['operation']?></td>
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
                <td> </td>
                <td ><input type="text" name="url_new" id="url_new" class='url'/></td>
                <td ><input type="text" name="t_cid_new" id="t_cid_new" class='t_cid' value=0 /></td>
              <td><input type="text" name="sequence_new" id="sequence_new" value="0" class='sequence' /></td>
              <td><input type='checkbox' name='visible_new' id='visible_new' checked="checked"  /></td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><span class=b_start> </span><span class=b_middle><?php echo self::$language['add']?></span><span class=b_end> </span></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>

</div>
