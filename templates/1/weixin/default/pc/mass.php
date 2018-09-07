<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    <script>
	var replace_file='';
    $(document).ready(function(){
		$('#icon_ele').insertBefore($('#icon_state'));
		$("#<?php echo $module['module_name'];?> .add").click(function(){
			$("#<?php echo $module['module_name'];?> #state_new").html('');
			is_null=false;
			$("#<?php echo $module['module_name'];?> .add_div input[class]").each(function(index, element) {
                if($(this).val()==''){alert($(this).attr('class'));is_null=true;return false;}
            });
			if(is_null){
				$("#<?php echo $module['module_name'];?> #state_new").html('<span class=fail><?php echo self::$language['is_null']?></span>');
				return false;
			}
			
			$("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add',{title:$("#<?php echo $module['module_name'];?> .add_div .title").prop('value'),icon:$("#<?php echo $module['module_name'];?> .add_div .icon").prop('value'),url:$("#<?php echo $module['module_name'];?> .add_div .url").prop('value')}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> #state_new").html(v.info);
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> #state_new").html(v.info+' <a class=refresh href="javascript:window.location.reload()"><?php echo self::$language['refresh']?></a>');
				}
		
			});
			return false;	
				
		});
		
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			$("img[src='"+replace_file+"']").attr('src',replace_file+"?&reflash="+Math.random());
            $.post('<?php echo $module['action_url'];?>&act=update_icon',{icon:replace_file}, function(data){
				console.log(data);
            });
			
			return false;
		});
		
		$('.icon_span img').click(function(){
			replace_file=$(this).attr('src');
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_img);
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','index.php?monxin=index.replace_file&path='+replace_file+'&width=0&height=0&max_size=1024&min_size=1');
			//$(this).html($("#monxin_iframe").attr('src'));
			return false;	
		});
		
		
    });
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				////alert(data);
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
    
	
    function mass_test(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        idss=ids;
        ids=ids.split("|");	
		index=0;
        for(id in ids){
            if(ids[id]!=''){index++;}	
        }
		if(index>8){$("#state_select").html("<span class=fail><?php echo self::$language['greater_than']?>8</span>");return false;}
		$.get('<?php echo $module['action_url'];?>&act=mass&test=1',{ids:idss}, function(data){
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#state_select").html(v.info);
			if(v.state=='success'){
				
			}
		});
        return false;	
    }
    
	
    function mass(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        idss=ids;
        ids=ids.split("|");	
		index=0;
        for(id in ids){
            if(ids[id]!=''){index++;}	
        }
		if(index>8){$("#state_select").html("<span class=fail><?php echo self::$language['greater_than']?>8</span>");return false;}
		$.get('<?php echo $module['action_url'];?>&act=mass',{ids:idss}, function(data){
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#state_select").html(v.info);
			if(v.state=='success'){
				
			}
		});
        return false;	
    }
    
	
    
    function update(id){
        var title=$("#<?php echo $module['module_name'];?> #title_"+id);	
        url=$("#<?php echo $module['module_name'];?> #url_"+id);	
        sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);
        if(title.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['title']?>');title.focus();return false;}	
        if(url.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['url']?>');url.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		//return false;
        $.get('<?php echo $module['action_url'];?>&act=update',{title:title.prop('value'),url:url.prop('value'),sequence:sequence.prop('value'),id:id}, function(data){
			//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        return false;	
        
    }
    
    </script>
  <style>
	#<?php echo $module['module_name'];?>_html { border-left:none; padding:0px;}
	#<?php echo $module['module_name'];?> .add_div{ text-align:right;}
	#<?php echo $module['module_name'];?> .info{ width:500px;}
	#<?php echo $module['module_name'];?> .sequence{ width:60px;}
	#<?php echo $module['module_name'];?> .info .icon_span{ display:inline-block; vertical-align:top;  width:20%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .info .icon_span img{ width:90%;}
	#<?php echo $module['module_name'];?> .info .title_url{display:inline-block; vertical-align:top;  width:80%; overflow:hidden;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    	<div class=add_div><?php echo self::$language['image']?>:<input type="hidden" id="icon" class=icon /><span id=icon_state></span> <?php echo self::$language['title']?>:<input type=text  class=title /> <?php echo self::$language['url']?>:<input type=text  class=url /> <a href=# class=add><?php echo self::$language['add']?></a> <span id=state_new></span></div>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="mass" onclick="return mass_test();"><?php echo self::$language['mass']?><?php echo self::$language['test']?></a></li> 
                    <li><a href="#" class="mass" onclick="return mass();"><?php echo self::$language['mass']?></a></li> 
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100" selected>100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"   placeholder="<?php echo self::$language['content']?>" class="form-control" ></m_label></div></div></div>
    
    
		
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td><?php echo self::$language['content'];?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sequence|desc" class="sorting"  asc="sequence|asc"><?php echo self::$language['sequence']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="visit|desc" class="sorting"  asc="visit|asc"><?php echo self::$language['visit']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="last_time|desc" class="sorting"  asc="last_time|asc"><?php echo self::$language['last_edit']?></a></td>
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