<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> td .submit").click(function(){
			id=$(this).attr('d_id');
			$("#<?php echo $module['module_name'];?> #tr_"+id+" .state").html('');
			s_info=$("#<?php echo $module['module_name'];?> #tr_"+id+" .s_info").val();
			if(s_info==''){$("#<?php echo $module['module_name'];?> #tr_"+id+" .state").html('<span class=fail><?php echo self::$language['is_null']?></span>');return false;}
			
			$("#<?php echo $module['module_name'];?> #tr_"+id+" .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update',{id:id,s_info:s_info}, function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> #tr_"+id+" .state").html(v.info);
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .data_state").html('<?php echo self::$language['exchange_state'][1]?>');	
				}
			});
			return false;
        });
		
    });
    
	
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//alert(data);
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
    #<?php echo $module['module_name'];?> .prize_info{}
	#<?php echo $module['module_name'];?> .prize_info img{ height:100px;}
	#<?php echo $module['module_name'];?> textarea{ width:200px; height:100px;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['name']?>" class="form-control" ></m_label></div></div></div>
    
    
    <div class="filter" style="display:none;"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['name']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['prize']?></td>
                <td ><?php echo self::$language['username']?></td>
                <td ><?php echo self::$language['exchange']?><?php echo self::$language['credit']?></td>
                <td ><?php echo self::$language['state']?></td>
                <td ><?php echo self::$language['r_info']?></td>
                <td ><?php echo self::$language['s_info']?></td>
                <td  style=" width:150px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
