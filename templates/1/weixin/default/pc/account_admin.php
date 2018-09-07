<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
		$("#<?php echo $module['module_name'];?>_html .data_state").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
		
    });    
    
    function update(id){
        sequence=$("#sequence_"+id);
        if(sequence.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{state:$("#data_state_"+id).prop('value'),username:$("#username_"+id).prop('value'),sequence:sequence.prop('value'),id:id}, function(data){
			////alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#state_"+id).html(v.info);
        });
        return false;	
        
    }
    function del(id){
        if(confirm("<?php echo self::$language['del_account_confirm']?>")){
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
    
    
    
    
    
    function subimt_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;return false;}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['state']=$("#data_state_"+ids[id]).prop('value');
            obj[id]['sequence']=$("#sequence_"+ids[id]).prop('value');
            obj[id]['username']=$("#username_"+ids[id]).prop('value');
            //monxin_//alert(obj[id]['visible']);
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_select").html(v.info);
                //monxin_//alert(ids);
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
        if(confirm("<?php echo self::$language['del_account_confirm']?>")){
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
				//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                if(v.state=='success'){
                //monxin_//alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_//alert(ids[id]);
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
    #<?php echo $module['module_name'];?> .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?> .sequence{width:40px;}
	#<?php echo $module['module_name'];?> .qr_code_img{ border:none; width:160px;}
	#<?php echo $module['module_name'];?> .m_label{ display:inline-block; padding-right:5px; text-align:right; width:100px;}
	
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a></li> 
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['name']?>/<?php echo self::$language['weixin_account']?>/<?php echo self::$language['username']?>/<?php echo self::$language['weixin_id']?>" class="form-control" ></m_label></div></div></div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['qr_code']?></td>
                <td ><?php echo self::$language['info']?></td>
                <td ><?php echo self::$language['user']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sequence|desc" class="sorting"  asc="sequence|asc"><?php echo self::$language['sequence']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['state']?></a></td>
                <td  style=" width:370px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
