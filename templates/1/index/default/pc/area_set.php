<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #country").val(get_param('country'));
		$("#<?php echo $module['module_name'];?> #province").val(get_param('province'));
		$("#<?php echo $module['module_name'];?> #city").val(get_param('city'));
		$("#<?php echo $module['module_name'];?> #county").val(get_param('county'));
		$("#<?php echo $module['module_name'];?> #twon").val(get_param('twon'));
		$("#<?php echo $module['module_name'];?> #village").val(get_param('village'));
		$("#<?php echo $module['module_name'];?> #group").val(get_param('group'));
		
		$("#<?php echo $module['module_name'];?> input[monxin_type='map']").each(function(index, element) {
            if($(this).val()=='0.000000,0.000000'){$(this).val('');}
        });
		
		$("#<?php echo $module['module_name'];?> .copy_url").keyup(function(){
			if(event.keyCode==13){
				if($(this).val()!=''){
					id=$(this).attr('d_id');
					$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
					$.get('<?php echo $module['action_url'];?>&act=copy_sub',{upid:$(this).attr('d_id'),url:$(this).prop('value')}, function(data){
						try{v=eval("("+data+")");}catch(exception){alert(data);}
						$("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
						
					});
				}
			}
				
		});
		
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			t=$("#monxin_iframe").attr('src');
			t=t.split('?id=');
			t=t[1].split('&');
			t=t[0];
			temp=getCookie('map_'+t);
			if(temp){
				$("#<?php echo $module['module_name'];?> #"+t).val(getCookie('map_'+t).replace(/%2C/g,','));
			}
			return false;
		});
		$("#<?php echo $module['module_name'];?> input[monxin_type='map']").focus(function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','http://<?php echo $module['map_api'];?>.monxin.com/get_point.php?id='+$(this).attr('id')+'&point='+$(this).val()+'&zoom=5');
			return false;	
		});
		
		
		
    });

    function set_area(id,v){
		//alert(id+','+v);
        $("#"+id).prop('value',v);
        //submit_hidden(id);	
    }
	
    function monxin_table_filter(id){
		if($("#"+id).prop("value")!=-1){
			key=id.replace("_filter","");
			if($("#"+id).prop("value")==''){
				if(key=='country'){window.location.href='./index.php?monxin=index.area_set';}
				key=$("#"+id).prev('select').attr('id').replace("_filter","");
				id=$("#"+id).prev('select').attr('id');
			}
			url=window.location.href;
			url=replace_get(url,key,$("#"+id).prop("value"));
			if(key=='country'){url=replace_get(url,"upid","country");url=replace_get(url,"province","");url=replace_get(url,"city","");url=replace_get(url,"county","");url=replace_get(url,"twon","");url=replace_get(url,"village","");url=replace_get(url,"group","");}
			if(key=='province'){url=replace_get(url,"upid","province");url=replace_get(url,"city","");url=replace_get(url,"county","");url=replace_get(url,"twon","");url=replace_get(url,"village","");url=replace_get(url,"group","");}
			if(key=='city'){url=replace_get(url,"upid","city");url=replace_get(url,"county","");url=replace_get(url,"twon","");url=replace_get(url,"village","");url=replace_get(url,"group","");}
			if(key=='county'){url=replace_get(url,"upid","county");url=replace_get(url,"twon","");url=replace_get(url,"village","");url=replace_get(url,"group","");}
			if(key=='twon'){url=replace_get(url,"upid","twon");url=replace_get(url,"village","");url=replace_get(url,"group","");}
			if(key=='village'){url=replace_get(url,"upid","village");url=replace_get(url,"group","");}
			if(key=='group'){url=replace_get(url,"upid","group");}
			window.location.href=url;	
		}
    }
    
    function add(){
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        sequenceNew=$("#<?php echo $module['module_name'];?> #sequence_new");
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(sequenceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
		upid=get_param(get_param('upid'));
		if(upid==''){upid=0;}
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),sequence:sequenceNew.prop('value'),upid:upid}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
			if(v.state=='success'){$("#<?php echo $module['module_name'];?> #state_new").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');}
        });
        	
        return false; 
    }
    
    
    function update(id){
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);
        if($("#<?php echo $module['module_name'];?> #visible_"+id).prop('checked')){visible=1;}else{visible=0;}
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),sequence:sequence.prop('value'),id:id,center:$("#<?php echo $module['module_name'];?> #center_"+id).val()}, function(data){
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        return false;        
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
        return false; 
    }
    function subimt_select(){
        ids=get_ids();
        if(ids==''){$("#<?php echo $module['module_name'];?> #state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['name']=$("#<?php echo $module['module_name'];?> #name_"+ids[id]).prop('value');
            obj[id]['sequence']=$("#<?php echo $module['module_name'];?> #sequence_"+ids[id]).prop('value');
            obj[id]['center']=$("#<?php echo $module['module_name'];?> #center_"+ids[id]).prop('value');
            //monxin_alert(obj[id]['name']);
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
                //monxin_alert(ids+"=="+data);
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#<?php echo $module['module_name'];?> #state_select").html(v.info);
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
        if(ids==''){$("#<?php echo $module['module_name'];?> #state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
            idss=ids;
            ids=ids.split("|");	
            for(id in ids){
                if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
            }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #state_select").html(v.info);
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_alert(ids[id]);
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
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html{}
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
                        
                        
                        
    <div class="filter">
    <span class=m_label><?php echo self::$language['select_area']?></span><?php echo $module['filter']?>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td class="name">&nbsp;<?php echo self::$language['name']?></td>
                <td><?php echo self::$language['regional_central_coordinate']?></td>
                <td ><?php echo self::$language['sequence'];?></td>
                <td  style=" width:470px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>&nbsp;</td>
            <td><input type='text' name='name_new' id='name_new' class='name' /></td>
          <td><input type='text' name='sequence_new' id='sequence_new' value='0' class='sequence' /></td>
          <td class=operation_td><a href='#' onclick='return add()'  class='add'><?php echo self::$language['add'];?></a> <span id=state_new class='state'></span></td>
        </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
