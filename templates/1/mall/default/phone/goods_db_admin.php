<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
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
		
    });
	
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
        
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['bar_code']?>/<?php echo self::$language['detail']?>" class="form-control" ></m_label></div></div></div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['cover_image']?></td>
                <td style="text-align:left;"><?php echo self::$language['goods_name']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['goods_show']?></a></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
