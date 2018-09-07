<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
	var replace_file='';
    $(document).ready(function(){
		$('#img_new_ele').insertBefore($('#img_temp'));
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			$("img[src='"+replace_file+"']").attr('src',replace_file+"?&reflash="+Math.random());
			return false;
		});
		$('.slider_img').click(function(){
			replace_file=$(this).attr('file');
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_img);
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','index.php?monxin=index.replace_file&path='+replace_file+'&width=0&height=0&max_size=1024&min_size=1');
			//$(this).html($("#monxin_iframe").attr('src'));
			return false;	
		});
		
    });
    
    
    
    function update(id){
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        url=$("#<?php echo $module['module_name'];?> #url_"+id);	
        target=$("#<?php echo $module['module_name'];?> #target_"+id);	
        sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);
        if($("#<?php echo $module['module_name'];?> #visible_"+id).prop('checked')){visible=1;}else{visible=0;}
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(url.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['url']?>');url.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		//return false;
        $.get('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),url:url.prop('value'),open_target:target.prop('value'),sequence:sequence.prop('value'),id:id}, function(data){
			//alert(data);
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
        if(ids==''){$("#<?php echo $module['module_name'];?> #state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['parent_id']=$("#<?php echo $module['module_name'];?> #parent_id_"+ids[id]).prop('value');
            obj[id]['name']=$("#<?php echo $module['module_name'];?> #name_"+ids[id]).prop('value');
            obj[id]['url']=$("#<?php echo $module['module_name'];?> #url_"+ids[id]).prop('value');
            obj[id]['target']=$("#<?php echo $module['module_name'];?> #target_"+ids[id]).prop('value');
            obj[id]['open_target']=$("#<?php echo $module['module_name'];?> #open_target_"+ids[id]).prop('value');
            obj[id]['sequence']=$("#<?php echo $module['module_name'];?> #sequence_"+ids[id]).prop('value');
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
        imgNew=$("#<?php echo $module['module_name'];?> #img_new");
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");
        urlNew=$("#<?php echo $module['module_name'];?> #url_new");	
        if(imgNew.prop('value')==''){alert('<?php echo self::$language['image'];?><?php echo self::$language['is_null'];?>');return false;}	
        if(nameNew.prop('value')==''){nameNew.prop('value','#');}	
        if(urlNew.prop('value')==''){urlNew.prop('value','#');}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),url:urlNew.prop('value'),img:imgNew.prop('value')}, function(data){
			//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
            if(v.state=='success'){
				window.location.reload();
            }
    
        });
        return false;	
        
    }
    
    </script>
    <style>
    #<?php echo $module['module_name'];?> .id{ overflow:hidden; text-align:right;}
	.slider_img{ display:block; width:700px; overflow-x:scroll;}
	.slider_img img{ border:0px; width:<?php echo $module['group_width'];?>;height:<?php echo $module['group_height'];?>;}
    #<?php echo $module['module_name'];?> .sequence{width:40px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; text-align:right; padding-right:5px;width:80px;}
	#group_info{ font-size:24px; line-height:60px; font-weight:bold; border-bottom:#ccc solid 1px; margin-bottom:20px;}
	#group_info span{ font-size:16px; }
	.operation_td a {}
	#<?php echo $module['module_name'];?> .operation_td .submit { margin-left:28%;}
	#<?php echo $module['module_name'];?> textarea{ width:95%; height:100px;}
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
    	<div id=group_info><?php echo $module['group_title'];?> <span><?php echo self::$language['module_width']?><?php echo $module['group_width'];?>*<?php echo self::$language['module_height']?><?php echo $module['group_height'];?></span></div>
    	<span ><?php echo self::$language['image'];?></span><span id=img_temp></span><br /><br /><span style="width:180px;"><?php echo self::$language['up_content'];?></span><input id=name_new name=name_new /> &nbsp;  &nbsp;  &nbsp;<span class=m_label><?php echo self::$language['url'];?></span><input id=url_new name=url_new /> <a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellspacing="0">
        <thead>
            <tr>
                <td width="1%"><input type="checkbox" group-checkable=1></td>
                <td width="10%"><?php echo self::$language['image']?></td>
                <td width="22%"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody >
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
