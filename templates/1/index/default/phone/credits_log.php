<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		var type=get_param('type');
		if(type!=''){$("#type").prop('value',type);}
    });
    </script>
	<style>    
	#<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_table .title{width:280px; display:inline-block; overflow:hidden;}
    #<?php echo $module['module_name'];?> #index_admin_site_msg_table a:hover{ text-decoration:underline; }
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?>_table .sender{width:250px; display:inline-block; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .addressee{width:150px; display:inline-block; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .state{width:80px;}
	.sum_div{ float:right;}
	.sum_div span{ margin-right:1rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['reason']?>" class="form-control" ></m_label></div></div></div>
    <div class="filter"><?php echo self::$language['content_filter']?>:
     <?php echo $module['filter']?>
     <div class=sum_div><span class=increase>+ <?php echo $module['increase']?></span> <span class=decrese><?php echo $module['decrese']?></span></div>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['time']?></td>
                <td ><?php echo self::$language['credits']?></td>
                <td ><?php echo self::$language['type']?></td>
                <td ><?php echo self::$language['reason']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
