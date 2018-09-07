<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$(document).on('click','#<?php echo $module['module_name'];?> .set_groups',function(){
			set_iframe_position($(window).width()-100,$(window).height()-20);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href')+'&ids='+$(this).prev().prev('.group_ids').val());
			return false;	
		});
    });
    
    function add(){
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        group_idsNew=$("#<?php echo $module['module_name'];?> #group_ids_0");
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),group_ids:group_idsNew.prop('value')}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
			if(v.state=='success'){$("#<?php echo $module['module_name'];?> #state_new").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');}
        });
        	
        return false;
    }
    
    
    function update(id){
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        var group_ids=$("#<?php echo $module['module_name'];?> #group_ids_"+id);	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),group_ids:group_ids.prop('value'),id:id}, function(data){
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
			

                $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
       return false; 
    }
	
	function set_groups(id,ids,names){
		$("#<?php echo $module['module_name'];?> #group_ids_"+id).prop('value',ids);
		$("#<?php echo $module['module_name'];?> #group_ids_"+id).next('.group_ids_name').html(names);
	}
    </script>
    <style>
	.fixed_right_div{ display:none !important;}
    #<?php echo $module['module_name'];?>_html .name{width:200px;}
	#<?php echo $module['module_name'];?> .set_groups{}
	#<?php echo $module['module_name'];?> .set_groups:before{margin-right:3px; font: normal normal normal 1rem/1 FontAwesome; content:"\f067";}
	#<?php echo $module['module_name'];?> .group_ids_name b{ font-weight:normal; padding-right:0.4rem;}
	#<?php echo $module['module_name'];?> .link{ font-style:oblique;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
   	    </div>
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['name']?>"  class="form-control" ></m_label></div></div></div>

	<div style="text-align:right;"><a class=submit href=./index.php?monxin=mall.interest_word&act=synchronization><?php echo self::$language['synchronization']?><?php echo self::$language['type']?></a></div>

    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['belong']?><?php echo self::$language['pages']['mall.interest_group']['name']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="day|desc" class="sorting"  asc="day|asc"><?php echo self::$language['d']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="week|desc" class="sorting"  asc="week|asc"><?php echo self::$language['w']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="month|desc" class="sorting"  asc="month|asc"><?php echo self::$language['m']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="year|desc" class="sorting"  asc="year|asc"><?php echo self::$language['Y']?></a></td>       
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sum|desc" class="sorting"  asc="sum|asc"><?php echo self::$language['sum']?><?php echo self::$language['user_quantity']?></a></td>
                <td width="30%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <tr id="<?php echo $module['module_name'];?>_new">
              <td ><input type="text" name="name_new" id="name_new" class='name' /></td>
              <td><input type="hidden" name="sgroup_ids_0" id="group_ids_0" value="0" class='group_ids' /><span class=group_ids_name></span> <a href='./index.php?monxin=mall.interest_word_grop&w_id=0' class=set_groups><?php echo self::$language['set']?></a></td>
              <td id="new_td_last" colspan="7" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=m_row><?php echo $module['page']?></div>
    </div>

</div>
