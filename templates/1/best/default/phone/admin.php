<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
        $("#<?php echo $module['module_name'];?> .visible").click(function(){
            id=this.id;
            id=id.replace("visible_","");
            if($(this).prop('checked')){visible=1;}else{visible=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_visible',{id:id,visible:visible});
        });        
        var get_search=get_param('search');
        if(get_search.length<1){
            var visible=get_param('visible');
            var type=get_param('type');
            if(visible!=''){$("#visible_filter").prop("value",visible);}
            if(type!=''){$("#type_filter").prop("value",type);}
        }
        
        $("[monxin-table] tbody tr").each(function(index, element) {
            $("#"+$(this).attr('id')+' .type').prop('value',$(this).attr('typeid'));
        });
        
    });
    
    
    function update(id){
        var type=$("#type_"+id);
        var title=$("#title_"+id);	
        sequence=$("#sequence_"+id);
        if($("#visible_"+id).prop('checked')){visible=1;}else{visible=0;}
        if(title.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['title']?>');title.focus();return false;}	
        if(sequence.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{type:type.prop('value'),title:title.prop('value'),sequence:sequence.prop('value'),id:id,visible:visible}, function(data){
			
                        v=eval("("+data+")");
			

            $("#state_"+id).html(v.info);
        });
         return false;	
        
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//monxin_alert(data);
                v=eval("("+data+")");
			

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
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['type']=$("#type_"+ids[id]).prop('value');
            obj[id]['title']=$("#title_"+ids[id]).prop('value');
            obj[id]['sequence']=$("#sequence_"+ids[id]).prop('value');
            //monxin_alert(obj[id]['visible']);
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
                            v=eval("("+data+")");
			

                $("#state_select").html(v.info);
                //monxin_alert(ids);
                success=v.ids.split("|");
                for(id in ids){
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
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
                            v=eval("("+data+")");
			

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
    
    function show_select(flag){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(flag){visible=true;}else{visible=false;}
        $.get('<?php echo $module['action_url'];?>&act=operation_visible&visible='+flag,{ids:ids}, function(data){
                            v=eval("("+data+")");
			

                $("#state_select").html(v.info);
                if(v.state=='success'){
                    ids=ids.split('|');
                    for(id in ids){$("#visible_"+ids[id]).prop('checked',visible);}
                }
        });
         return false;	
    }
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>_table .type{width:100px;}
    #<?php echo $module['module_name'];?>_table .title{width:280px;}
    #<?php echo $module['module_name'];?>_table .editor{width:100px;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?>_table .sequence{width:40px;}
    #<?php echo $module['module_name'];?>_table .visible{:#CCC}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a></li> 
                    <li><a href="#"  onclick="return show_select(1);" class=show><?php echo self::$language['show']?></a></li> 
                    <li><a href="#" onclick="return show_select(0);" class=hide><?php echo self::$language['hide']?></a></li> 
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search" placeholder="<?php echo self::$language['title']?>/<?php echo self::$language['content']?>"  class="form-control" ></m_label></div></div></div>
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['belong']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="title|desc" class="sorting"  asc="title|asc"><?php echo self::$language['title']?></a></td>
                <td ><?php echo self::$language['editor']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sequence|desc" class="sorting"  asc="sequence|asc"><?php echo self::$language['sequence']?></a></td>
                <td ><?php echo self::$language['visible']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="visit|desc" class="sorting"  asc="visit|asc"><?php echo self::$language['visit']?></a></td>
                <td  style=" width:470px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
