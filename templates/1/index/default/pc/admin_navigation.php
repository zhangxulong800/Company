<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
	var replace_file='';
    $(document).ready(function(){
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			$("img[src='"+replace_file+"']").attr('src',replace_file+"?&reflash="+Math.random());
			return false;
		});
		$('.icon').click(function(){
			replace_file=$("#"+$(this).attr('id')+" img").attr('src');
			//monxin_alert(replace_img);
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','index.php?monxin=index.replace_file&path='+replace_file+'&width=128&height=128');
			return false;	
		});
		
        $("#<?php echo $module['module_name'];?> .visible").click(function(){
            id=this.id;
            id=id.replace("visible_","");
            if($(this).prop('checked')){visible=1;}else{visible=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_visible',{id:id,visible:visible});
        });
    });
    
    
    function add(){
        parent_idNew=$("#<?php echo $module['module_name'];?> #parent_id_new");
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        urlNew=$("#<?php echo $module['module_name'];?> #url_new");	
        open_targetNew=$("#<?php echo $module['module_name'];?> #open_target_new");	
        sequenceNew=$("#<?php echo $module['module_name'];?> #sequence_new");
        if($("#<?php echo $module['module_name'];?> #visible_new").prop('checked')){visible=1;}else{visible=0;}
    
        if(parent_idNew.prop('value')<0){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_select']?><?php echo self::$language['parent']?>');parent_idNew.focus();return false;}	
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(urlNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['url']?>');urlNew.focus();return false;}	
        if(sequenceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{parent_id:parent_idNew.prop('value'),name:nameNew.prop('value'),url:urlNew.prop('value'),open_target:open_targetNew.prop('value'),sequence:sequenceNew.prop('value'),visible:visible}, function(data){
                        try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
            if(v.state=='success'){
                var new_td_first=$("#<?php echo $module['module_name'];?> #new_td_first");
                var new_td_last=$("#<?php echo $module['module_name'];?> #new_td_last");
                var new_td_first_html=new_td_first.html();
                var new_td_last_html=new_td_last.html();
                new_td_first.html('&nbsp;');
                new_td_last.html('<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');
                newTr="<tr id='chinnel_"+v.id+"'>"+$("#new").html()+"</tr>";
                newTr=newTr.replace(/_new/g,"_"+v.id);
                //monxin_alert(newTr);
                $(newTr).insertAfter($('#<?php echo $module['module_name'];?> #new'));
                
                $("#<?php echo $module['module_name'];?> #parent_id_"+v.id).prop('value',parent_idNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #name_"+v.id).prop('value',nameNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #url_"+v.id).prop('value',urlNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #sequence_"+v.id).prop('value',sequenceNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #open_target_"+v.id).prop('value',open_targetNew.prop('value'));
                if($("#<?php echo $module['module_name'];?> #visible_new").prop('checked')){$("#<?php echo $module['module_name'];?> #visible_"+v.id).prop('checked',true);}else{$("#<?php echo $module['module_name'];?> #visible_"+v.id).prop('checked',false);}
    
                
                parent_idNew.prop('value',-1);	
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
        parent_id=$("#<?php echo $module['module_name'];?> #parent_id_"+id);
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        url=$("#<?php echo $module['module_name'];?> #url_"+id);	
        open_target=$("#<?php echo $module['module_name'];?> #open_target_"+id);	
        sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);
        if($("#<?php echo $module['module_name'];?> #visible_"+id).prop('checked')){visible=1;}else{visible=0;}
        if(parent_id.prop('value')<0){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_select']?><?php echo self::$language['parent']?>');parent_id.focus();return false;}	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(url.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['url']?>');url.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		//return false;
        $.get('<?php echo $module['action_url'];?>&act=update',{parent_id:parent_id.prop('value'),name:name.prop('value'),url:url.prop('value'),open_target:open_target.prop('value'),sequence:sequence.prop('value'),id:id,visible:visible}, function(data){
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
			

                $("#state_"+id).html(v.info);
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
            obj[id]['parent_id']=$("#<?php echo $module['module_name'];?> #parent_id_"+ids[id]).prop('value');
            obj[id]['name']=$("#<?php echo $module['module_name'];?> #name_"+ids[id]).prop('value');
            obj[id]['url']=$("#<?php echo $module['module_name'];?> #url_"+ids[id]).prop('value');
            obj[id]['open_target']=$("#<?php echo $module['module_name'];?> #open_target_"+ids[id]).prop('value');
            obj[id]['sequence']=$("#<?php echo $module['module_name'];?> #sequence_"+ids[id]).prop('value');
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
				//monxin_alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
                $("#state_select").html(v.info);
                //monxin_alert(ids);
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
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                if(v.state=='success'){
                //monxin_alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
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
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?> .id{ overflow:hidden; text-align:right;}
    #<?php echo $module['module_name'];?> .parent_id{ margin-right:10px;}
    #<?php echo $module['module_name'];?> .name{float:right;}
    #<?php echo $module['module_name'];?> .url{width:200px;}
    #<?php echo $module['module_name'];?> .target{}
    #<?php echo $module['module_name'];?> .sequence{width:40px;}
    #<?php echo $module['module_name'];?> .visible{ width:40px;}
	#<?php echo $module['module_name'];?> .filter{ }
    #<?php echo $module['module_name'];?> #visible_filter{ height:26px;}
	#<?php echo $module['module_name'];?> #open_target_filter{ height:26px;}
	#<?php echo $module['module_name'];?> .icon{float:right; background:#ff9600; border-radius:3px; display:inline-block; width:30px; height:30px; padding:2px; margin-right:5px;}
	#<?php echo $module['module_name'];?> .icon img{ width:30px; height:30px; border:0px;}
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
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                    <li><a href="#" class="show"  onclick="return show_select(1);"><?php echo self::$language['show']?></a></li> 
                    <li><a href="#" class="hide" onclick="return show_select(0);"><?php echo self::$language['hide']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['name']?>/<?php echo self::$language['url']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"   id="<?php echo $module['module_name'];?>_table_a" style="width:100%" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td width="10%"><?php echo self::$language['parent']?></td>
                <td width="22%"><?php echo self::$language['name']?></td>
                <td width="18%"><?php echo self::$language['url']?></td>
                <td width="10%"><?php echo self::$language['target']?></td>
                <td width="6%"><?php echo self::$language['sequence']?></td>
                <td width="6%"><?php echo self::$language['visible']?></td>
                <td width="22%"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody >
            <tr id="new">
                <td id="new_td_first"></td>
                <td><select name="parent_id_new" id="parent_id_new" class='parent_id'>
                <option value="-1"><?php echo self::$language['select_please']?></option>
                <option value="0">--<?php echo self::$language['none']?>--</option>
                <?php echo $module['parent']?>
                </select></td>
                <td width="168"><input type="text" name="name_new" id="name_new" style="width:98%;" class='name' /></td>
              <td><input type="text" name="url_new" id="url_new" class='url' /></td>
              <td><select name="open_target_new" id="open_target_new" class='target' />
              <?php echo $module['target']?>
              </select></td>
              <td><input type="text" name="sequence_new" id="sequence_new" value="0" class='sequence' /></td>
              <td><input type='checkbox' name='visible_new' id='visible_new' checked="checked"  /></td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
