<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .data_state").each(function(index, element) {
            $(this).val($(this).attr('monxin_v'));
        });
		$("#<?php echo $module['module_name'];?> .write_able").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .read_able").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .fore_list_show").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .back_list_show").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		
    });
    
    function update(id){
		write_able=($("#write_able_"+id).prop('checked'))?1:0;
		read_able=($("#read_able_"+id).prop('checked'))?1:0;
		fore_list_show=($("#fore_list_show_"+id).prop('checked'))?1:0;
		back_list_show=($("#back_list_show_"+id).prop('checked'))?1:0;
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{write_able:write_able,read_able:read_able,fore_list_show:fore_list_show,back_list_show:back_list_show,sequence:$("#sequence_"+id).val(),id:id}, function(data){
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
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .sequence{ width:40px;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    <div class="filter">
    <a href="./index.php?monxin=form.field_add&id=<?php echo $_GET['id'];?>"  class="add"><?php echo self::$language['add']?><?php echo self::$language['field']?></a>
    </div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['field_name']?></td>
                <td ><?php echo self::$language['type']?></td>
                <td ><?php echo self::$language['write_able']?></td>
                <td ><?php echo self::$language['read_able']?></td>
                <td ><?php echo self::$language['fore_list_show']?></td>
                <td ><?php echo self::$language['back_list_show']?></td>
                <td ><?php echo self::$language['sequence']?></td>
                <td  style=" width:550px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
