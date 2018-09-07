<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_html .set_1").click(function(){
			if(confirm("<?php echo self::$language['opration_confirm']?>")){
				id=$(this).attr('href');
				$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=set_1',{id:$(this).attr('href')}, function(data){
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#<?php echo $module['module_name'];?>_html .set_1[href='"+id+"']").html(v.info);
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?>_html .set_1[href='"+id+"']").prev().html('<?php echo self::$language['cash_state'][1]?>');
					}
				});
			}
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?>_html .add").click(function(){
				if($(this).prev().val()==''){$(this).prev().focus();return false;}
				$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=add',{username:$(this).prev().val(),prize:$(".actions .prize").val()}, function(data){
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#<?php echo $module['module_name'];?>_html .add").next().html(v.info);
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?>_html .add").next().html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');
					}
				});
			return false;	
		});
		
				
    });    
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> .add_div{ text-align:right;}	
	.err_input{ border-color:red !important;}
	#<?php echo $module['module_name'];?> .set_1{ border:#CCC 1px solid; border-radius:5px; padding-left:5px; padding-right:5px;}
	
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class=actions>
         	<?php echo self::$language['prize']?> <select class=prize><?php echo $module['prize_option']?></select> <?php echo self::$language['win_user']?> <input type="text" class="username" /> <a href=# class=add><?php echo self::$language['add_fiction']?></a> <span class=state></span>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['remark']?>/<?php echo self::$language['cash_prize_code']?>/<?php echo self::$language['win_user']?>"  class="form-control" ></m_label></div></div></div>
    

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['prize_time']?></td>
                <td ><?php echo self::$language['win_user']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="type|desc" class="sorting"  asc="type|asc"><?php echo self::$language['prize']?><?php echo self::$language['type']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="o_id|desc" class="sorting"  asc="o_id|asc"><?php echo self::$language['prize_name']?></a></td>
                <td ><?php echo self::$language['remark']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['state']?></a></td>
                <td ><?php echo self::$language['cash_time']?></td>
                <td ><?php echo self::$language['operator']?></td>
                <td ><?php echo self::$language['fiction']?></td>

            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    
            
    
    </div>
</div>
