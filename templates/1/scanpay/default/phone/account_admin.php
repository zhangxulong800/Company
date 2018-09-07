<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_html .data_state").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
		$("#<?php echo $module['module_name'];?>_html .is_web").each(function(index, element) {
            if($(this).attr('monxin_value')==1){$(this).prop('checked',true);}
        });
		
		$("#<?php echo $module['module_name'];?> .is_web").click(function(){
			type=$(this).attr('a_type');
			if($(this).prop('checked')){
				$("#<?php echo $module['module_name'];?> input[a_type='"+type+"']").prop('checked',false);	
				$(this).prop('checked',true);
			}
		});
				
    });    
    function update(id){
		$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		if($("#tr_"+id+" .is_web").prop('checked')){is_web=1;}else{is_web=0;}
		$.post('<?php echo $module['action_url'];?>&act=update',{id:id,state:$("#tr_"+id+" .data_state").val(),is_web:is_web,username:$("#tr_"+id+" .username").val()}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#state_"+id).html(v.info);
		});
        return false;	
        
    }
    
    function del(id){
        if(confirm("<?php echo self::$language['del_account_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
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
            $.post('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#state_select").html(v.info);
                if(v.state=='success'){
                //monxin_alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                    }	
                }
                }
            });
        }	
         return false;	
    }

    </script>
    <style>
    #<?php echo $module['module_name'];?>{ font-size:12px;	}
    #<?php echo $module['module_name'];?> .sequence{width:3rem;  text-align:center;}
	#<?php echo $module['module_name'];?> .banner_div img{ height:7rem;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?><?php echo self::$language['log']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['type']?></td>
                <td ><?php echo self::$language['cumulative']?><?php echo self::$language['receive_money']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><?php echo self::$language['state']?></td>
                <td ><?php echo self::$language['is_web']?></td>
                <td  style=" width:170px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
