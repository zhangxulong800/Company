<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		
		$("#<?php echo $module['module_name'];?> .data_state").each(function(index, element) {
            if($(this).prop('value')==1){$(this).prop('checked',true);}
        });
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
		
        $("#<?php echo $module['module_name'];?> .sequence").blur(function(){
            id=this.id;
            id=id.replace("sequence_","");
            $.get('<?php echo $module['action_url'];?>&act=update_sequence',{id:id,sequence:$(this).val()},function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                
			});
        });        
		
        $("#<?php echo $module['module_name'];?> .bidding_show").blur(function(){
            id=this.id;
            id=id.replace("bidding_show_","");
			$("#<?php echo $module['module_name'];?> #price_state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=update_bidding_show',{id:id,bidding_show:$(this).val()},function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #price_state_"+id).html(v.info);
                
			});
        });        
		
        $("#<?php echo $module['module_name'];?> .data_state").click(function(){
            id=this.id;
            id=id.replace("data_state_","");
            if($(this).prop('checked')){visible=1;}else{visible=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_state',{id:id,state:visible});
        });        
		
        var get_search=get_param('search');
        if(get_search.length<1){
            var tag=get_param('tag');
            var position=get_param('position');
            var supplier=get_param('supplier');
            var type=get_param('type');
            if(tag!=''){$("#tag_filter").prop("value",tag);}
            if(position!=''){$("#position_filter").prop("value",position);}
            if(supplier!=''){$("#supplier_filter").prop("value",supplier);}
            if(type!=''){$("#type_filter").prop("value",type);}
        }
        
        $("[monxin-table] tbody tr").each(function(index, element) {
            $("#"+$(this).attr('id')+' .type').prop('value',$(this).attr('typeid'));
        });
		$("#<?php echo $module['module_name'];?> .type a").each(function(index, element) {
			if($(this).attr('class')!='set'){$(this).html($(this).html()+' >');}
        });
		
		$("#<?php echo $module['module_name'];?> .shop_type a").each(function(index, element) {
			if($(this).attr('class')!='set'){$(this).html($(this).html()+' >');}
        });
		
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> .set',function(){
			set_iframe_position(850,500);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		$(document).on('click','#<?php echo $module['module_name'];?> .sold,#<?php echo $module['module_name'];?> .inventory,#<?php echo $module['module_name'];?> .group_discount',function(){
			set_iframe_position(850,600);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
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
               	//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_select").html(v.info);
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
            });
        }	
         return false;	
    }
    
    function show_select(flag){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(flag){visible=true;}else{visible=false;}
        $.get('<?php echo $module['action_url'];?>&act=operation_visible&visible='+flag,{ids:ids}, function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#state_select").html(v.info);
                if(v.state=='success'){
                    ids=ids.split('|');
					if(flag){goods_state='<?php echo self::$language['yes']?>';}else{goods_state='<?php echo self::$language['no']?>';}
                    for(id in ids){$("#tr_"+ids[id]+" .goods_state").html(goods_state);}
                }
        });
         return false;	
    }
	function update_type(id,c){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .type_tag .type").html(c);
	}
	function update_shop_type(id,c){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .type_tag .shop_type").html(c);
	}
	function update_tag(id,c){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .type_tag .tag").html(c);
	}
	function update_inventory(id,c){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .inventory").html(c);
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
    #<?php echo $module['module_name'];?>_table .title{ text-align:left; display:block; overflow:hidden; width:250px;  height:40px;}
    #<?php echo $module['module_name'];?>_table .type_tag{ text-align:left;  }
    #<?php echo $module['module_name'];?>_table .type_tag a{ }
    #<?php echo $module['module_name'];?>_table .type{ display:block;}
    #<?php echo $module['module_name'];?>_table .shop_type{display:block;}
    #<?php echo $module['module_name'];?>_table .tag{display:block;}
    #<?php echo $module['module_name'];?>_table .type a{ margin-right:10px; text-decoration:none;}
    #<?php echo $module['module_name'];?>_table .time{ width:100px; display:block;}

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
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
  &nbsp; &nbsp; <a href="index.php?monxin=mall.goods_add" target="_blank" class="add"><?php echo self::$language['add']?><?php echo self::$language['goods'];?></a> 
  &nbsp; &nbsp; <a href="index.php?monxin=mall.goods_in_out" ><?php echo self::$language['bulk']?><?php echo self::$language['pages']['mall.goods_in_out']['name'];?></a> 
       &nbsp; &nbsp; <a href="<?php echo $module['action_url'];?>&act=export_weight_goods" target="_blank" class="export"><?php echo self::$language['export_weight_goods'];?></a>          
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#"  onclick="return show_select(1);" class=show><?php echo self::$language['goods_show']?></a></li> 
                    <li><a href="#" onclick="return show_select(0);" class=hide><?php echo self::$language['goods_hide']?></a></li> 
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['bar_code']?>/<?php echo self::$language['store_code']?>/<?php echo self::$language['detail']?>" class="form-control" ></m_label></div></div></div>
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
       <?php echo $module['filter']?>
        
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['cover_image']?></td>
                <td style="text-align:left;"><?php echo self::$language['goods_name']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['goods_show']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="mall_state|desc" class="sorting"  asc="mall_state|asc"><?php echo self::$language['state']?></a></td>
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
