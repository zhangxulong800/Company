<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_html .check_state").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
		
		$("#<?php echo $module['module_name'];?> .check_state").change(function(){
			id=$(this).parent().parent().attr('id').replace(/tr_/,'');
			//alert(id);return false;
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=update_state',{id:id,state:$(this).val()}, function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#state_"+id).html(v.info);
				
            });
		});
		
				
    });    
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
    
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> .add_div{ text-align:right;}
	#<?php echo $module['module_name'];?> .qr{ display:inline-block; vertical-align:top; width:100px;}
	#<?php echo $module['module_name'];?> .name_url{ display:inline-block; vertical-align:top; width:220px; white-space: normal; line-height:20px; padding-left:5px;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['name']?>" value="<?php echo @$_GET['search']?>"  style="width:40%;" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
        
        
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['qr_code']?>/<?php echo self::$language['name']?>/<?php echo self::$language['link']?></td>
                <td ><?php echo self::$language['type']?></td>
                <td ><?php echo self::$language['activity']?><?php echo self::$language['start_time']?></td>
                <td ><?php echo self::$language['activity']?><?php echo self::$language['end_time']?></td>
                <td ><?php echo self::$language['state']?></td>
                <td ><?php echo self::$language['check_state']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['last_edit']?></a></td>
                <td><?php echo self::$language['won_sum']?></td>
                <td><?php echo self::$language['visit_count']?></td>
                <td><?php echo self::$language['try_sum']?></td>
                <td  style=" width:50px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
