<script src="./plugin/datePicker/index.php"></script>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .export").click(function(){
			if($("#<?php echo $module['module_name'];?> #export_div").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> #export_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> #export_div").css('display','none');
			}
			return false;	
		});
		$("#<?php echo $module['module_name'];?> #export_submit").click(function(){
			field_str='';
			$("#<?php echo $module['module_name'];?> #export_div input").each(function(index, element) {
                if($(this).prop('checked')){field_str+=$(this).attr('id').replace(/export_/,'')+'|';}
            });
			if(field_str==''){alert('<?php echo self::$language['is_null']?>');return false;}
			$("#<?php echo $module['module_name'];?> #export_form #field").val(field_str);
			
			$("#<?php echo $module['module_name'];?> #export_submit").next().submit();
			return false;	
		});
		
		if(get_param('publish')!=''){$("#publish").val(get_param('publish'))}
		$("#<?php echo $module['module_name'];?> .publish").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
    });
    
    function monxin_table_filter(id){
		if($("#"+id).prop("value")!=-1){
			key=id.replace("_filter","");
			url=window.location.href;
			url=replace_get(url,key,$("#"+id).prop("value"));
			if(key!="search"){url=replace_get(url,"search","");}else{
				url='./index.php?monxin=form.data_admin&search='+$("#search_filter").val()+'&order='+get_param('order')+'&table_id='+get_param('table_id');
			}
			url=replace_get(url,"current_page","1");
			//monxin_alert(url);
			window.location.href=url;	
		}
		return false;
    }
	
    function update(id){
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		publish=($("#publish_"+id).prop('checked'))?1:0;
        $.get('<?php echo $module['action_url'];?>&act=update',{publish:publish,sequence:$("#sequence_"+id).val(),id:id}, function(data){
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
				alert(data);
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
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['publish']=($("#publish_"+ids[id]).prop('checked'))?1:0
            obj[id]['sequence']=$("#sequence_"+ids[id]).prop('value');
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
            //alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                //monxin_alert(ids);
                success=v.ids.split("|");
                for(id in ids){
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['executed'];?>");	
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
            alert(data);
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
        
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> #export_div{ text-align:right; padding:10px; width:80%;}
	#<?php echo $module['module_name'];?> #export_div .checkbox_span{ display: inline-block;text-align:left; line-height:40px; width:15%; }
	#<?php echo $module['module_name'];?> #export_div input{ display:inline-block; vertical-align:top; margin-top:10px;}
	#<?php echo $module['module_name'];?> #export_div m_label{}
    #<?php echo $module['module_name'];?> .sequence{ width:30px;}
	#<?php echo $module['module_name'];?> #search_filter{ width:50%;}
	#<?php echo $module['module_name'];?> .map{ display:inline-block; width:30px; }
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
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"></div></div>
        
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?> 
        
         <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
        
        <br /><br /><input type="text" name="search_filter" id="search_filter" placeholder="<?php echo $module['search_placeholder']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> 
       &nbsp;  <a href="./index.php?monxin=form.data_add&table_id=<?php echo $_GET['table_id'];?>" target="_blank" class="add"><?php echo self::$language['add']?><?php echo self::$language['data']?></a> 
       &nbsp;  <?php echo $module['export'];?>
       <?php echo $module['export_div'];?>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <?php echo $module['head_field'];?>
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
