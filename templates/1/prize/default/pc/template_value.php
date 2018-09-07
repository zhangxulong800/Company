<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
	var replace_file='';
    $(document).ready(function(){
		$('#pc_new_ele').insertBefore($('#pc_new_state'));
		$('#phone_new_ele').insertBefore($('#phone_new_state'));
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			$("img[src='"+replace_file+"']").attr('src',replace_file+"?&reflash="+Math.random());
			return false;
		});
		$('#<?php echo $module['module_name'];?> .img').click(function(){
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
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		//alert(name.prop('value'));return false;
        $.get('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),id:id}, function(data){
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

    
    function add(){
        pc_new=$("#<?php echo $module['module_name'];?> #pc_new");
        phone_new=$("#<?php echo $module['module_name'];?> #phone_new");
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");
        keyNew=$("#<?php echo $module['module_name'];?> #key_new");
		
		if(nameNew.prop('value')==''){alert('<?php echo self::$language['name']?><?php echo self::$language['is_null'];?>');return false;}	
		if(keyNew.prop('value')==''){alert('<?php echo self::$language['key']?><?php echo self::$language['is_null'];?>');return false;}	
        if(pc_new.prop('value')==''){alert('<?php echo self::$language['pc_device']?><?php echo self::$language['default']?><?php echo self::$language['image']?><?php echo self::$language['is_null'];?>');return false;}	
        if(phone_new.prop('value')==''){alert('<?php echo self::$language['phone_device']?><?php echo self::$language['default']?><?php echo self::$language['image']?><?php echo self::$language['is_null'];?>');return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),key:keyNew.prop('value'),pc_new:pc_new.prop('value'),phone_new:phone_new.prop('value')}, function(data){
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
    #<?php echo $module['module_name'];?> .img img{ max-width:200px;max-height:100px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?>(<?php echo $module['template_name']?>)</div>
        <div class="actions">
         </div>
    </div>
                        
    
    
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellspacing="0">
        <thead>
            <tr>
                <td width="1%"><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['key']?></td>
                <td ><?php echo self::$language['pc_device']?><?php echo self::$language['default']?><?php echo self::$language['image']?></td>
                <td ><?php echo self::$language['phone_device']?><?php echo self::$language['default']?><?php echo self::$language['image']?></td>
                <td style="width:200px;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody >
    <?php echo $module['list']?>
            <tr>
                <td>&nbsp;</td>
                <td ><input type="text" id=name_new /></td>
                <td ><input type="text" id=key_new /></td>
                <td><span id=pc_new_state></span></td>
                <td ><span id=phone_new_state></span></td>
                <td ><a href=# class=add  onclick="return add()" ><?php echo self::$language['add']?></a></td>
            </tr>
    
        </tbody>
    </table></div>
    </div>
</div>
