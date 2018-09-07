<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .visible").click(function(){
            id=this.id;
            id=id.replace("visible_","");
            if($(this).prop('checked')){visible=1;}else{visible=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_visible',{id:id,visible:visible});
			return false;
        });
         
    });
    
    function add(){
        usernameNew=$("#<?php echo $module['module_name'];?> #username_new");
        passwordNew=$("#<?php echo $module['module_name'];?> #password_new");	
        urlNew=$("#<?php echo $module['module_name'];?> #url_new");	
        if(usernameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['username']?>');usernameNew.focus();return false;}	
        if(passwordNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['password']?>');passwordNew.focus();return false;}	
        if(urlNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['url']?>');urlNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{username:usernameNew.prop('value'),password:passwordNew.prop('value'),url:urlNew.prop('value')}, function(data){
          	//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
            if(v.state=='success'){
                var new_td_first=$("#<?php echo $module['module_name'];?> #new_td_first");
                var new_td_last=$("#<?php echo $module['module_name'];?> #new_td_last");
                var new_td_first_html=new_td_first.html();
                var new_td_last_html=new_td_last.html();
                new_td_first.html('&nbsp;');
                new_td_last.html('<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');
                newTr="<tr id='<?php echo $module['module_name'];?>_"+v.id+"'>"+$("#new").html()+"</tr>";
                newTr=newTr.replace(/_new/g,"_"+v.id);
                //monxin_alert(newTr);
                $(newTr).insertAfter($('#<?php echo $module['module_name'];?> #new'));
                
                $("#<?php echo $module['module_name'];?> #username_"+v.id).prop('value',usernameNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #password_"+v.id).prop('value',passwordNew.prop('value'));
                $("#<?php echo $module['module_name'];?> #url_"+v.id).prop('value',urlNew.prop('value'));
    
                
                usernameNew.prop('value','');	
                passwordNew.prop('value','');	
                urlNew.prop('value','');	
                
                new_td_first.html(new_td_first_html);
                new_td_last.html(new_td_last_html);
        
            }
    
        });
        	
        return false;
    }
    
    
    function update(id){
        username=$("#<?php echo $module['module_name'];?> #username_"+id);
        password=$("#<?php echo $module['module_name'];?> #password_"+id);	
        url=$("#<?php echo $module['module_name'];?> #url_"+id);	
        if(username.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['username']?>');username.focus();return false;}	
        if(password.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['password']?>');password.focus();return false;}	
        if(url.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['url']?>');url.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{username:username.prop('value'),password:password.prop('value'),url:url.prop('value'),id:id}, function(data){
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
			

                $("#state_"+id).html(v.info);
				
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
        return false;
    }
    function test(id){
		 $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('<?php echo $module['action_url'];?>&act=test',{id:id}, function(data){
			//monxin_alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#state_"+id).html(v.info);
		});
        return false;	
        
    }
    
    
    
    function get_ids(){
        ids='';
        $("#<?php echo $module['module_name'];?> .id").each(function(){
            if($(this).prop("checked")){ids+=this.id+"|";}              
        });
        return ids;
    }
    
    function subimt_select(){
        ids=get_ids();
        if(ids==''){$("#<?php echo $module['module_name'];?> #state_select").html("<?php echo self::$language['select_null']?>");}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['username']=$("#<?php echo $module['module_name'];?> #username_"+ids[id]).prop('value');
            obj[id]['password']=$("#<?php echo $module['module_name'];?> #password_"+ids[id]).prop('value');
            obj[id]['url']=$("#<?php echo $module['module_name'];?> #url_"+ids[id]).prop('value');
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
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
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
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?> .url{width:300px;}
    #<?php echo $module['module_name'];?> .username{width:150px;}
    #<?php echo $module['module_name'];?> .password{width:150px;}
    #<?php echo $module['module_name'];?> .time{ width:40px;}    
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['name']?>/<?php echo self::$language['url']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td width="10%"><?php echo self::$language['url']?></td>
                <td width="18%"><?php echo self::$language['username']?></td>
                <td width="22%"><?php echo self::$language['password']?></td>
                <td width="22%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <tr id="new">
                <td id="new_td_first"></td>
			 	<td><input type="text" name="url_new" id="url_new" class='url' /></td>
			 	<td><input type="text" name="username_new" id="username_new" class='username' /></td>
			 	<td><input type="text" name="password_new" id="password_new" class='password' /></td>
			 	<td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
