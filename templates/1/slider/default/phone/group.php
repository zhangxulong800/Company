<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
    });
    
    
    
    function monxin_table_filter(id){
            if($("#"+id).prop("value")!=-1){
                key=id.replace("_filter","");
                url=window.location.href;
                url=replace_get(url,key,$("#"+id).prop("value"));
                if(key!="search"){url=replace_get(url,"search","");}
                //monxin_alert(url);
                window.location.href=url;	
            }
    }
    
    
    
    function update(id){
        var duration=$("#duration_"+id);
        var delay=$("#delay_"+id);
        var width=$("#width_"+id);
        var height=$("#height_"+id);
        var title=$("#title_"+id);	
        var style=$("#style_"+id);	
        sequence=$("#sequence_"+id);
        if(title.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['title']?>');title.focus();return false;}	
        if(width.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['module_width']?>');width.focus();return false;}	
        if(height.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['module_height']?>');height.focus();return false;}	        
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{width:width.prop('value'),height:height.prop('value'),title:title.prop('value'),sequence:sequence.prop('value'),style:style.prop('value'),duration:duration.prop('value'),delay:delay.prop('value'),id:id}, function(data){
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#state_"+id).html(v.info);
        });
        return false;	
        
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
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
            obj[id]['duration']=$("#duration_"+ids[id]).prop('value');
            obj[id]['delay']=$("#delay_"+ids[id]).prop('value');
            obj[id]['width']=$("#width_"+ids[id]).prop('value');
            obj[id]['height']=$("#height_"+ids[id]).prop('value');
            obj[id]['title']=$("#title_"+ids[id]).prop('value');
            obj[id]['style']=$("#style_"+ids[id]).prop('value');
            //monxin_alert(obj[id]['visible']);
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
            //monxin_alert(data);
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

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
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;return false;}
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
    
    function add(){
        titleNew=$("#<?php echo $module['module_name'];?> #title_new");
        styleNew=$("#<?php echo $module['module_name'];?> #style_new");
        widthNew=$("#<?php echo $module['module_name'];?> #width_new");	
        heightNew=$("#<?php echo $module['module_name'];?> #height_new");	
        durationNew=$("#<?php echo $module['module_name'];?> #duration_new");	
        delayNew=$("#<?php echo $module['module_name'];?> #delay_new");	
       if(titleNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['title']?>');titleNew.focus();return false;}	
        if(widthNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['module_width']?>');widthNew.focus();return false;}	
        if(heightNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['module_height']?>');heightNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{title:titleNew.prop('value'),style:styleNew.prop('value'),width:widthNew.prop('value'),height:heightNew.prop('value'),duration:durationNew.prop('value'),delay:delayNew.prop('value')}, function(data){
			//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
            if(v.state=='success'){
				url="./index.php?monxin=slider.img&id="+v.id;
				window.location.href=url;
            }
    
        });
        return false;	
        
    }
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>_table .style{width:300px;}
    #<?php echo $module['module_name'];?>_table .title{width:300px;}
    #<?php echo $module['module_name'];?>_table .width{width:100px;}
    #<?php echo $module['module_name'];?>_table .height{width:100px;}
    #<?php echo $module['module_name'];?>_table .duration{width:100px;}
    #<?php echo $module['module_name'];?>_table .delay{width:100px;}
    #<?php echo $module['module_name'];?>_table .editor{width:100px;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['title']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="4%"><input type="checkbox" group-checkable=1></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="title|desc" class="sorting"  asc="title|asc"><?php echo self::$language['name']?></a></td>
                <td ><?php echo self::$language['animate_style']?></td>
                <td width="90" ><?php echo self::$language['module_width']?></td>
                <td ><?php echo self::$language['module_height']?></td>
                <td ><?php echo self::$language['slider_duration']?></td>
                <td ><?php echo self::$language['slider_delay']?></td>
                <td ><?php echo self::$language['editor']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td  style=" width:450px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="4%">&nbsp;</td>
                <td ><input id="title_new" name="title_new" class="title" /></td>
                <td ><select class="style" id=style_new name=style_new><?php echo $module['style_option'];?></select></td>
                <td ><input id="width_new" name="width_new" class="width" /></td>
                <td ><input id="height_new" name="height_new" class="height" /></td>
                <td ><input id="duration_new" name="duration_new" class="duration" value="20" /></td>
                <td ><input id="delay_new" name="delay_new" class="delay" value="20" /></td>
                <td style="display:none;">&nbsp;</td>
                <td style="display:none;">&nbsp;</td>
                <td class="operation_td"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=batch_operation_div>
    			<span class="corner">&nbsp;</span>
    
                <a href="#" class="select_all" onclick="return select_all();"><?php echo self::$language['select_all']?></a>
                <a href="#" class="reverse_select" onclick="return reverse_select();"><?php echo self::$language['reverse_select']?></a>
                 <?php echo self::$language['selected']?>:
                 <a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a> 
                 <a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a> 
                  <span id="state_select"></span>
                  </div>
    <?php echo $module['page']?>
    </div>
</div>
