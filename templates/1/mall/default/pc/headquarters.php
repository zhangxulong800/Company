<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){

    });
    
    function add(){
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        usernameNew=$("#<?php echo $module['module_name'];?> #username_new");	
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(usernameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['username']?>');usernameNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),username:usernameNew.prop('value')}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
			if(v.state=='success'){$("#<?php echo $module['module_name'];?> #state_new").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');}
        });
        	
        return false;
    }
    
    
    function update(id){
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        var username=$("#<?php echo $module['module_name'];?> #username_"+id);	
        var sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(username.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['username']?>');username.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),username:username.prop('value'),sequence:sequence.prop('value'),id:id}, function(data){
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
                //alert(data);
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
    #<?php echo $module['module_name'];?> {}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
   	    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><?php echo self::$language['headquarters'];?><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['operator']?><?php echo self::$language['username']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="goods_sum|desc" class="sorting"  asc="goods_sum|asc"><?php echo self::$language['goods']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="branch_sum|desc" class="sorting"  asc="branch_sum|asc"><?php echo self::$language['branch']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                
                
                <td width="30%"  style="text-align:left;"><span class=operation_icon> </span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
           
            <tr id="<?php echo $module['module_name'];?>_new">
              <td ><input type="text" name="name_new" id="name_new" class='name' /></td>
              <td ><input type="text" name="username_new" id="username_new" class='username' /></td>
              <td id="new_td_last" style="text-align:left;" colspan=4><a href="#" onclick="return add()"  class='add'><span class=b_start> </span><span class=b_middle><?php echo self::$language['add']?></span><span class=b_end> </span></a> <span id=state_new  class='state'></span></td>
            </tr>
             <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>

</div>
