<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
        var state=get_param('state');
		if(state){$("#<?php echo $module['module_name'];?> #state_filter").val(state);}
		$('#import_ele').insertBefore($('#import_state'));
		
		$("#<?php echo $module['module_name'];?> .import").click(function(){
			if($(this).prev().css('display')=='none'){
				$(this).prev().css('display','inline-block');
			}else{
				$(this).prev().css('display','none');	
			}
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .add").click(function(){
			if($("#<?php echo $module['module_name'];?> .add_quantity").val()=='' || !$.isNumeric($("#<?php echo $module['module_name'];?> .add_quantity").val()) || parseInt($("#<?php echo $module['module_name'];?> .add_quantity").val())<0){
				$("#<?php echo $module['module_name'];?> .add_quantity").focus();
				
				return false;	
			}
			$("#<?php echo $module['module_name'];?> .add_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=add',{quantity:$("#<?php echo $module['module_name'];?> .add_quantity").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#<?php echo $module['module_name'];?> .add_state").html('<span class=success><?php echo self::$language['success']?></span><a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');
            });
			
			
			return false;	
		});
			
    });
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//monxin_alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
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
    
    function export_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        idss=ids;
		$("#<?php echo $module['module_name'];?> .export_select").attr('target','_blank');
		$("#<?php echo $module['module_name'];?> .export_select").attr('href','<?php echo $module['action_url'];?>&act=export_select&ids='+idss);
    }
    
	function submit_hidden(id){
		if($("#<?php echo $module['module_name'];?> #import").val()!=''){
			$("#<?php echo $module['module_name'];?> #import_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=import',{v:$("#<?php echo $module['module_name'];?> #import").val()}, function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> #import_state").html(v.info);
			});
		}
		
		
	}
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> .act_div{ text-align:right;}
	.add_quantity{ width:80px;}
	.import_div{ display:inline-block; vertical-align:top; display:none;}
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
                    <li><a href="#" class="export_select" onclick="return export_select();"><?php echo self::$language['export']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search" placeholder="<?php echo self::$language['try_mode_5']?>"  class="form-control" ></m_label></div></div></div>
    
    <div class=act_div>
    	 <a href=<?php echo $module['action_url']?>&act=export target=_blank class=export><?php echo self::$language['export']?></a> &nbsp;  &nbsp; 
    	 <div class=import_div><span id=import_state></span></div> <a href=# class=import><?php echo self::$language['import']?></a> &nbsp;  &nbsp; 
    
    	<?php echo self::$language['generate'];?><?php echo self::$language['try_mode_5'];?> <input type=text class=add_quantity placeholder="<?php echo self::$language['quantity']?>" maxlength="4" /> <span class=add_state></span> <a href=# class=add><?php echo self::$language['add']?></a>
    </div>
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['generate']?><?php echo self::$language['time']?></td>
                <td ><?php echo self::$language['try_mode_5']?></td>
                <td ><?php echo self::$language['state']?></td>
                <td ><?php echo self::$language['use_time']?></td>
                <td ><?php echo self::$language['use_username']?></td>
                <td  style=" width:270px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
