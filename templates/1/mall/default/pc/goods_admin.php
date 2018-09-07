<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		if('stock_big'=='<?php echo @$_GET['act'];?>'){
			$("[monxin-table] tbody tr").each(function(index, element) {
				$(this).children('.operation_td').html("<a href='./index.php?monxin=mall.public_stock&act=big&ps_id=<?php echo @$_GET['ps_id']?>&goods_id="+$(this).attr('id').replace(/tr_/,'')+"' class=recommendation><?php echo self::$language['setting']?><?php echo self::$language['stock_big']?></a><br />");

            });	
		}
		if('stock_small'=='<?php echo @$_GET['act'];?>'){
			$("[monxin-table] tbody tr").each(function(index, element) {
				$(this).children('.operation_td').html("<a href='./index.php?monxin=mall.public_stock&act=small&ps_id=<?php echo @$_GET['ps_id']?>&goods_id="+$(this).attr('id').replace(/tr_/,'')+"' class=recommendation><?php echo self::$language['setting']?><?php echo self::$language['stock_small']?></a><br />");

            });	
		}
		if('agency'=='<?php echo @$_GET['act'];?>'){
			$("[monxin-table] tbody tr").each(function(index, element) {
				$(this).children('.operation_td').html("<a href='./index.php?monxin=agency.shop_goods&goods_id="+$(this).attr('id').replace(/tr_/,'')+"' class=recommendation><?php echo self::$language['set_agency']?></a><br />");

            });	
		}
		if('bargain'=='<?php echo @$_GET['act'];?>'){
			$("[monxin-table] tbody tr").each(function(index, element) {
				$(this).children('.operation_td').html("<a href='./index.php?monxin=bargain.goods&goods_id="+$(this).attr('id').replace(/tr_/,'')+"' class=recommendation><?php echo self::$language['set_bargain']?></a><br />");

            });	
		}
		if('gbuy'=='<?php echo @$_GET['act'];?>'){
			$("[monxin-table] tbody tr").each(function(index, element) {
				$(this).children('.operation_td').html("<a href='./index.php?monxin=gbuy.shop_goods&goods_id="+$(this).attr('id').replace(/tr_/,'')+"' class=recommendation><?php echo self::$language['set_gbuy']?></a><br />");

            });	
		}
		if('recommendation'=='<?php echo @$_GET['act'];?>'){
			$("[monxin-table] tbody tr").each(function(index, element) {
				$(this).children('.operation_td').html("<a href='./index.php?monxin=mall.recommendation_set&goods_id="+$(this).attr('id').replace(/tr_/,'')+"' class=recommendation><?php echo self::$language['support_recommendation']?></a><br />");

            });	
		}
		if('relevance_goods'=='<?php echo @$_GET['act'];?>'){
			$("[monxin-table] tbody tr").each(function(index, element) {
				if($(this).attr('id')=='tr_<?php echo @$_GET['goods_id']?>'){
					$(this).children('.operation_td').html('&nbsp;');
				}else{
					$(this).children('.operation_td').html('<a href="index.php?monxin=mall.relevance_goods&goods_id=<?php echo @$_GET['goods_id']?>&relevance_new='+$(this).attr('id').replace(/tr_/,'')+'" class=relevance><?php echo self::$language['relevance'];?></a>');

				}
            });	
		}
		if('relevance_package'=='<?php echo @$_GET['act'];?>'){
			if(''=='<?php echo  @$_GET['goods_ids'];?>'){
				$("[monxin-table] tbody tr").each(function(index, element) {
					$(this).children('.operation_td').html('<a href="index.php?monxin=mall.package_admin&package_id=<?php echo @$_GET['package_id']?>&relevance_new='+$(this).attr('id').replace(/tr_/,'')+'" class=relevance><?php echo self::$language['add_to_package'];?></a>');
				});	
			}else{
				temp='<?php echo  @$_GET['goods_ids'];?>';
				temp=temp.split(',');
				$("[monxin-table] tbody tr").each(function(index, element) {
					if($.inArray($(this).attr('id').replace(/tr_/,''),temp)!=-1){
						$(this).children('.operation_td').html('&nbsp;');
					}else{
						$(this).children('.operation_td').html('<a href="index.php?monxin=mall.package_admin&package_id=<?php echo @$_GET['package_id']?>&relevance_new='+$(this).attr('id').replace(/tr_/,'')+'" class=relevance><?php echo self::$language['add_to_package'];?></a>');
					}
					
				});	
			}
		}
		
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
    
    
    function print_shelf_label(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
		window.location.href='./index.php?monxin=mall.shelf_label&ids='+ids;
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
	
    function mass(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
		window.location.href='<?php echo $module['action_url'];?>&act=mass_select&ids='+ids;
        return false;	
    }
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .set{display:inline-block; vertical-align:top; width:30px; text-decoration:none;}
	#<?php echo $module['module_name'];?> .set:before{font: normal normal normal 15px/1 FontAwesome;content: "\f040";}
	#<?php echo $module['module_name'];?> [monxin-table] thead tr td{ white-space:nowrap;}
    #<?php echo $module['module_name'];?> #search_filter{ width:300px;}
	#<?php echo $module['module_name'];?>_table td{font-size:0.8rem;}
    #<?php echo $module['module_name'];?>_table .icon{ width:80px; overflow:hidden; text-align:left; display:block; }
    #<?php echo $module['module_name'];?>_table .icon img{ height:70px; width:70px; border:0px; margin-top:5px;}
    #<?php echo $module['module_name'];?>_table .title{ text-align:left; display:block; overflow:hidden; width:200px;  height:40px;}
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
	#<?php echo $module['module_name'];?>_table .storehouse{ text-align:left;font-size:1rem;}
	#<?php echo $module['module_name'];?>_table .bidding_show{ width:80px; display:block;}
	#<?php echo $module['module_name'];?> .bidding_show_notice{ }
	#<?php echo $module['module_name'];?> .sum_div{ text-align:right; line-height:50px; }
	#<?php echo $module['module_name'];?> .sum_div b{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
  &nbsp; &nbsp; <a href="index.php?monxin=mall.goods_add" target="_blank" class="add"><?php echo self::$language['add']?><?php echo self::$language['goods'];?></a> 
  &nbsp; &nbsp; <a href="<?php echo $module['action_url'];?>&act=export_led" target="_blank" ><?php echo self::$language['export_led'];?></a> 
  &nbsp; &nbsp; <a href="index.php?monxin=mall.batch_reset_price" ><?php echo self::$language['pages']['mall.batch_reset_price']['name'];?></a> 
  &nbsp; &nbsp; <a href="index.php?monxin=mall.goods_in_out" ><?php echo self::$language['bulk']?><?php echo self::$language['pages']['mall.goods_in_out']['name'];?></a> 
       &nbsp; &nbsp; <a href="<?php echo $module['action_url'];?>&act=export_weight_goods" target="_blank" class="export"><?php echo self::$language['export_weight_goods'];?>(<?php echo self::$language['all']?>)</a>          
       &nbsp; &nbsp; <a href="./index.php?monxin=mall.shelf_label" target="_blank" class="export"><?php echo self::$language['print_shelf_label'];?>(<?php echo self::$language['all']?>)</a>          
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#"  onclick="return show_select(1);" class=show><?php echo self::$language['goods_show']?></a></li> 
                    <li><a href="#" onclick="return show_select(0);" class=hide><?php echo self::$language['goods_hide']?></a></li> 
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                    <li><a href="#" class="print_shelf_label" onclick="return print_shelf_label();"><?php echo self::$language['print_shelf_label']?></a></li> 
                    <?php echo $module['mass'];?>
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['bar_code']?>/<?php echo self::$language['store_code']?>/<?php echo self::$language['detail']?>" class="form-control" ></m_label></div></div></div>
    
    
    <br />
    <div class=bidding_show_notice><?php echo self::$language['bidding_show_notice'];?></div>
    <br />
    <div class="filter"><?php echo self::$language['content_filter']?>:
       <?php echo $module['filter']?>
       <div class=sum_div>
       	<?php echo self::$language['sum']?><?php echo self::$language['inventory']?><b><?php echo $module['sum_inventory'];?></b><?php echo self::$language['piece']?> , <?php echo self::$language['inventory']?><?php echo self::$language['assets']?><b><?php echo $module['assets'];?></b><?php echo self::$language['yuan']?>
       </div>
        
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['cover_image']?></td>
                <td style="text-align:left;"><?php echo self::$language['goods_name']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sold|desc" class="sorting"  asc="sold|asc"><?php echo self::$language['sold']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="inventory|desc" class="sorting"  asc="inventory|asc"><?php echo self::$language['inventory']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="visit|desc" class="sorting"  asc="visit|asc"><?php echo self::$language['visit']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="bidding_show|desc" class="sorting"  asc="bidding_show|asc"><?php echo self::$language['bidding_show']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="shop_sequence|desc" class="sorting"  asc="shop_sequence|asc"><?php echo self::$language['sequence']?></a></td>
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
