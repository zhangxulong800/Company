<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
       $("#<?php echo $module['module_name'];?> .data_state").each(function(index, element) {
            if($(this).prop('value')==1){$(this).prop('checked',true);}
        });
		
		$("#<?php echo $module['module_name'];?> .data_state").click(function(){
			if($(this).prop('checked')){state=1;}else{state=0;}
			$.post("<?php echo $module['action_url'];?>&act=state",{state:state,id:$(this).attr('d_id')},function(data){
				//alert(data);
			});	
		});
		
		$("#<?php echo $module['module_name'];?> .pass").click(function(){
			$(this).parent().prev('td').html($(this).parent().prev('td').html()+'<br />'+$(this).prev('span').html());
			$(this).prev('span').css('display','none');
			$(this).css('display','none');
				
			$.post("<?php echo $module['action_url'];?>&act=pass",{api:$(this).prev('span').html(),id:$(this).attr('d_id')},function(data){
				
			});	
		});
		
		$("#<?php echo $module['module_name'];?> .unpass").click(function(){
			$(this).prev('span').css('display','none');
			$(this).css('display','none');
				
			$.post("<?php echo $module['action_url'];?>&act=unpass",{api:$(this).prev('span').html(),id:$(this).attr('d_id')},function(data){
				
			});	
		});
    });
    
    function submit_select(target){
        ids=get_ids();
        if(ids==''){$("#<?php echo $module['module_name'];?> #state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        $.post("<?php echo $module['action_url'];?>&act=submit_select",{ids:ids,target:target},function(data){
                //monxin_//alert(ids+"=="+data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#<?php echo $module['module_name'];?> #state_select").html(v.info);
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
                //monxin_//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#<?php echo $module['module_name'];?> #state_select").html(v.info);
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_//alert(ids[id]);
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
    
	
	
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .pass{ cursor:pointer;}
    #<?php echo $module['module_name'];?> .pass:hover{ font-weight:bold;}
	 #<?php echo $module['module_name'];?> .unpass:before {content: "\f014";margin-left: 2px;margin-right: 6px; cursor:pointer;    font: normal normal normal 14px/1 FontAwesome;}
	
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#"  onclick="return submit_select(2);">API<?php echo self::$language['pass']?></a></li> 
                    <li><a href="#"  onclick="return submit_select(1);"><?php echo self::$language['enable']?></a></li> 
                    <li><a href="#"  onclick="return submit_select(0);"><?php echo self::$language['disable']?></a></li> 
                    <li><a href="#"  onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"   placeholder="<?php echo self::$language['username']?>" class="form-control" ></m_label></div></div></div>

    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['username']?></td>
                <td width="11%"><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['enable']?></a></td>
                <td ><?php echo self::$language['api_state']['api_exist']?></td>
                <td ><?php echo self::$language['api_state']['api_application']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>

</div>
