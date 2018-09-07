<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$('#import_ele').insertBefore($('#import_state'));
		$("#<?php echo $module['module_name'];?> .visible").each(function(index, element) {
            if($(this).prop('value')==1){$(this).prop('checked',true);}
        });
        $("#<?php echo $module['module_name'];?> .visible").click(function(){
            id=this.id;
            id=id.replace("switch_","");
            if($(this).prop('checked')){visible=1;}else{visible=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_visible',{id:id,visible:visible});
        }); 
		
    });
    
    
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
    
	function submit_hidden(id){
		str=$("#"+id).val();
		$("#import_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post("<?php echo $module['action_url'];?>&act=import",{v:str},function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#import_state").html(v.info);			
        });	
	}
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>_table .name{ display:block; width:10rem !important;}
	#<?php echo $module['module_name'];?>_table .table{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="filter"><a href="index.php?monxin=copy.regular_add" class="add"><?php echo self::$language['add']?></a>  
    &nbsp; &nbsp;<?php echo self::$language['import'];?><?php echo self::$language['regular'];?> <span id=import_state></span>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><span class=name>&nbsp;<?php echo self::$language['name']?></span></td>
                <td ><?php echo self::$language['open']?></td>
                <td ><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
