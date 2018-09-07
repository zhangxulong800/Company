<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> input[type='checkbox']").each(function(index, element) {
            if($(this).attr('monxin_value')==1){$(this).prop('checked',true);}
        });
    });
    
    function update(id){
		var obj=Object();
		obj['sequence']=$("#sequence_"+id).val();
		obj['screening_show']=($("#tr_"+id+" .screening_show").prop('checked'))?1:0;
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=update&id='+id,obj,function(data){
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
            ////alert(data);
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
    #<?php echo $module['module_name'];?> .warning{background-image:url(<?php echo get_template_dir(__FILE__);?>img/warning.png); background-repeat:no-repeat; padding-left:100px; height:100px; line-height:100px; font-size:26px;}
    #<?php echo $module['module_name'];?> .add_able_div{ display:inline-block; text-align:left; }
    #<?php echo $module['module_name'];?> .edit_able_div{display:inline-block;  text-align:left; }
    #<?php echo $module['module_name'];?> .list_able_div{display:inline-block;  text-align:left; }
    #<?php echo $module['module_name'];?> .detail_able_div{ display:inline-block; text-align:left; }
    #<?php echo $module['module_name'];?> input{ display:inline-block; vertical-align:top; padding-top:8px;}
    #<?php echo $module['module_name'];?> .group{ display:inline-block; vertical-align:top;}
	
	
	
    #<?php echo $module['module_name'];?> .sequence{ width:40px;}
	#<?php echo $module['module_name'];?> .preview{ margin-left:30px;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    <div class="filter">
    <a href="./index.php?monxin=ci.type_attribute_add&type=<?php echo $_GET['type'];?>" class="add"><?php echo self::$language['add']?><?php echo self::$language['attribute']?></a> <a href=./index.php?monxin=ci.add&type=<?php echo @$_GET['type'];?> target="_blank" class="preview"><?php echo self::$language['preview'];?></a>
    </div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['type']?></td>
                <td ><a href=# title="<?php echo self::$language['screening_show_long'];?>"><?php echo self::$language['screening_show']?></a></td>
                <td ><?php echo self::$language['sequence']?></td>
                <td  style=" width:350px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
