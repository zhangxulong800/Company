<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		var position=get_param('position');
		var type=get_param('type');
		if(position!=''){$("#position_filter").prop("value",position);}
		if(type!=''){$("#type_filter").prop("value",type);}
		$(document).on('click','#<?php echo $module['module_name'];?> .log',function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		
    });
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .set{display:inline-block; vertical-align:top; width:30px; text-decoration:none;}
	 #<?php echo $module['module_name'];?> .set:before{font: normal normal normal 15px/1 FontAwesome;content: "\f040";}
	#<?php echo $module['module_name'];?> [monxin-table] thead tr td{ white-space:nowrap;}
    #<?php echo $module['module_name'];?> #search_filter{ width:300px;}
    #<?php echo $module['module_name'];?>_table .icon{}
    #<?php echo $module['module_name'];?>_table .icon img{ height:50px; width:50px; border:0px; margin-top:5px;}
    #<?php echo $module['module_name'];?>_table .title{ text-align:left; display:block; overflow:hidden; width:10rem; }
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
	#<?php echo $module['module_name'];?> .bidding_show_notice{ }
	#<?php echo $module['module_name'];?> .sum_div{ text-align:right; line-height:50px; }
	#<?php echo $module['module_name'];?> .sum_div b{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['bar_code']?>/<?php echo self::$language['detail']?>" class="form-control" ></m_label></div></div></div>
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
                <td><?php echo self::$language['cumulative']?><?php echo self::$language['purchase']?></td>
                <td ><?php echo self::$language['issue']?></td>
                <td ><?php echo self::$language['existing']?><?php echo self::$language['inventory']?></td>
                <td ><?php echo self::$language['lately']?><?php echo self::$language['purchase']?></td>
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
