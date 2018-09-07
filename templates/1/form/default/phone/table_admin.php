<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .write_state").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .read_state").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .default_publish").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .authcode").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .sms_inform").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .email_inform").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		
		if(get_param('id')!=''){$("[monxin-table] .filter").css('display','none');}
		
    });
    
    function update(id){
        var j_name=$("#name_"+id);
        var j_description=$("#description_"+id);
		if(j_description.val()==''){$("#state_"+id).html('<span class=fail><?php echo self::$language['please_input'];?></span>');j_description.focus(); return false;}
		if(j_name.val()==''){$("#state_"+id).html('<span class=fail><?php echo self::$language['please_input'];?></span>');j_name.focus(); return false;}			
		if(!is_passwd(j_name.val()) ){
			$("#state_"+id).html('<span class=fail><?php echo self::$language['table_name'];?><?php echo self::$language['only_letters_numbers_underscores'];?></span>');j_name.focus(); return false;
		}
		write_state=($("#write_state_"+id).prop('checked'))?1:0;
		read_state=($("#read_state_"+id).prop('checked'))?1:0;
		default_publish=($("#default_publish_"+id).prop('checked'))?1:0;
		authcode=($("#authcode_"+id).prop('checked'))?1:0;
		sms_inform=($("#sms_inform_"+id).prop('checked'))?1:0;
		email_inform=($("#email_inform_"+id).prop('checked'))?1:0;
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{description:j_description.val(), name: j_name.val(),inform_user: $("#inform_user_"+id).val(),write_state:write_state,read_state:read_state,default_publish:default_publish,authcode:authcode,sms_inform:sms_inform,email_inform:email_inform,id:id}, function(data){
			//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#state_"+id).html(v.info);
        });
        return false;	
        
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
            //alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false;	
        
    }
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html a:hover{ }
	#<?php echo $module['module_name'];?>_html .m_label{ }
	#<?php echo $module['module_name'];?>_html input{ width:5rem;}
    #<?php echo $module['module_name'];?> .edit_none{ margin-left:20%;}
	#<?php echo $module['module_name'];?> #sms_inform_27{}
	#<?php echo $module['module_name'];?> #email_inform_27{}
    #<?php echo $module['module_name'];?> .inform_user{ }
	#<?php echo $module['module_name'];?> .inform_div{ }
	
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['name']?>/<?php echo self::$language['table_name']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> &nbsp; <a href="./index.php?monxin=form.table_add"  class="add"><?php echo self::$language['add']?><?php echo self::$language['form']?></a>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['table_name']?></td>
                <td ><?php echo self::$language['write_able']?></td>
                <td ><?php echo self::$language['read_able']?></td>
                <td ><?php echo self::$language['default']?><?php echo self::$language['publish']?></td>
                <td ><?php echo self::$language['authcode']?></td>
                <td ><?php echo self::$language['input_inform']?></td>
                <td  style=" width:250px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
