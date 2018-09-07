<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
		$("#<?php echo $module['module_name'];?>_html .data_state").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
		
		$("#<?php echo $module['module_name'];?> .reset_token").click(function(){
			id=$(this).attr('d_id');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=reset_token',{id:id}, function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}			
                $("#state_"+id).html(v.info);
            });
			return false;
		});
				
				
    });    
    function del(id){
        if(confirm("<?php echo self::$language['del_account_confirm']?>")){
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
    #<?php echo $module['module_name'];?> .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?> .sequence{width:40px;}
	#<?php echo $module['module_name'];?> .info_div{ width:20rem; display:block;}
	#<?php echo $module['module_name'];?> .qr_code_img{ border:none; width:6rem;}
	#<?php echo $module['module_name'];?> .m_label{ display:inline-block; padding-right:5px; text-align:right; width:35%; font-weight:bold;}
	#<?php echo $module['module_name'];?> .operation_td a{ display:block; line-height:2.5rem; padding:0px; margin:0px;}	
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['name']?>/<?php echo self::$language['weixin_account']?>/<?php echo self::$language['weixin_id']?>" value="<?php echo @$_GET['search']?>"  style="width:60%;" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
        <br/><a href="index.php?monxin=<?php echo $module['class_name'];?>.account_add" class="add"><?php echo self::$language['add']?><?php echo self::$language['weixin_account']?></a>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="4%"><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['qr_code']?></td>
                <td ><?php echo self::$language['info']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td  ><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
