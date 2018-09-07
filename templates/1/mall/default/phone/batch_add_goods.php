<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
        $("[monxin-table] tbody tr").each(function(index, element) {
            $("#"+$(this).attr('id')+' .type').prop('value',$(this).attr('typeid'));
        });
		$("#<?php echo $module['module_name'];?> .type a").each(function(index, element) {
			if($(this).attr('class')!='set'){$(this).html($(this).html()+' >');}
        });
		
		$("#<?php echo $module['module_name'];?> .shop_type a").each(function(index, element) {
			if($(this).attr('class')!='set'){$(this).html($(this).html()+' >');}
        });
		
		$("#<?php echo $module['module_name'];?> .goods_up").click(function(){
			id=$(this).attr('d_id');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=goods_up',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .goods_up_all").click(function(){
			id=$(this).attr('d_id');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=goods_up_all',function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> .table_scroll").css('display','none');
                }
            });
			return false;	
		});
    });
    
    
    function show_select(flag){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        $.post('<?php echo $module['action_url'];?>&act=goods_up_select',{ids:ids}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#state_select").html(v.info);
			if(v.state=='success'){
				ids=ids.split('|');
				if(flag){goods_state='<?php echo self::$language['yes']?>';}else{goods_state='<?php echo self::$language['no']?>';}
				for(id in ids){$("#tr_"+ids[id]+" .goods_state").html(goods_state);}
                if(v.state=='success'){
					//alert(ids);	
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
				
			}
        });
         return false;	
    }
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .set{display:inline-block; vertical-align:top; width:30px; text-decoration:none;}
	 #<?php echo $module['module_name'];?> .set:before{font: normal normal normal 15px/1 FontAwesome;content: "\f040";}
	#<?php echo $module['module_name'];?> [monxin-table] thead tr td{ white-space:nowrap;}
    #<?php echo $module['module_name'];?> #search_filter{ width:300px;}
    #<?php echo $module['module_name'];?>_table .icon{ width:110px; overflow:hidden; text-align:left; display:block;}
    #<?php echo $module['module_name'];?>_table .icon img{ height:120px; width:120px; border:0px; margin-top:5px;}
    #<?php echo $module['module_name'];?>_table .title{ text-align:left; display:block; width:8rem; overflow:hidden;;  height:40px;}
    #<?php echo $module['module_name'];?>_table .type_tag{ text-align:left;  }
    #<?php echo $module['module_name'];?>_table .type_tag a{ }
    #<?php echo $module['module_name'];?>_table .type{ display:block;}
    #<?php echo $module['module_name'];?>_table .shop_type{display:block;}
    #<?php echo $module['module_name'];?>_table .tag{display:block;}
    #<?php echo $module['module_name'];?>_table .type a{ margin-right:10px; text-decoration:none;}
    #<?php echo $module['module_name'];?>_table .sequence{ width:50px;}
	#<?php echo $module['module_name'];?>_table .operation_td .edit{}
	#<?php echo $module['module_name'];?>_table .operation_td .relevance_goods:before{font: normal normal normal 15px/1 FontAwesome;content: "\f0c1";}
	
	#<?php echo $module['module_name'];?>_table .operation_td .relevance_package:before{
	font: normal normal normal 15px/1 FontAwesome;
	content: "\f0c1";}
	
	#<?php echo $module['module_name'];?>_table .operation_td .del{}
	#<?php echo $module['module_name'];?>_table .operation_td .relevance:before{font: normal normal normal 15px/1 FontAwesome;content: "\f0c1";}
	#<?php echo $module['module_name'];?>_table .operation_td .recommendation{}
	#<?php echo $module['module_name'];?>_table .operation_td .recommendation:before{font: normal normal normal 15px/1 FontAwesome;content: "\f067";}
	#<?php echo $module['module_name'];?>_table .supplier{ text-align:left;  font-size:1rem;}
	#<?php echo $module['module_name'];?>_table .position{ text-align:left;font-size:1rem;}
	#<?php echo $module['module_name'];?>_table .bidding_show{ width:100px; display:block;}
	#<?php echo $module['module_name'];?> .bidding_show_notice{ }
	#<?php echo $module['module_name'];?> .sum_div{ text-align:right; line-height:50px; }
	#<?php echo $module['module_name'];?> .sum_div b{ }
	#<?php echo $module['module_name'];?> .goods_up_all{}
	#<?php echo $module['module_name'];?> .goods_up_all:before{font: normal normal normal 15px/1 FontAwesome;content: "\f093";}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
<a href=# class="goods_up_all"><?php echo self::$language['goods_show_all'];?></a>   &nbsp; &nbsp; 
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#"  onclick="return show_select(1);" class=show><?php echo self::$language['goods_show']?><?php echo self::$language['store']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['bar_code']?>/<?php echo self::$language['detail']?>" class="form-control" ></m_label></div></div></div>
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
       <?php echo $module['filter']?>
        
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['cover_image']?></td>
                <td style="text-align:left;"><?php echo self::$language['goods_name']?></td>
                <td  style=" text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
