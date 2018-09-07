<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		
    });
    </script>
    <style>
	.fixed_right_div{ display:none !important;}
    #<?php echo $module['module_name'];?>_html .name{width:200px;}
	#<?php echo $module['module_name'];?> .set_groups{}
	#<?php echo $module['module_name'];?> .set_groups:before{margin-right:3px; font: normal normal normal 1rem/1 FontAwesome; content:"\f067";}
	#<?php echo $module['module_name'];?> .group_ids_name b{ font-weight:normal; padding-right:0.4rem;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
   	    </div>
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['username']?>"  class="form-control" ></m_label></div></div></div>

    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><?php echo self::$language['username']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="frequency|desc" class="sorting"  asc="frequency|asc"><?php echo self::$language['frequency']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="last_time|desc" class="sorting"  asc="last_time|asc"><?php echo self::$language['last_time_visit']?></a></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=m_row><?php echo $module['page']?></div>
    </div>

</div>
