<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		
    });
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .store_name{}
    #<?php echo $module['module_name'];?>_html .store_name img{ height:2rem; padding-right:0.3rem;}
	#<?php echo $module['module_name'];?>_html [set='0']{ }
	#<?php echo $module['module_name'];?>_html [set='1']{ }
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['shop_name']?>/<?php echo self::$language['store_master']?>/<?php echo self::$language['referee']?>"  class="form-control" ></m_label></div></div></div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0" >
         <thead>
            <tr>
                <td><?php echo self::$language['shop_name']?></td>
                <td ><?php echo self::$language['goods']?></td>
                <td ><?php echo self::$language['orders']?></td>
                <td ><?php echo self::$language['sum_commission']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="rebate_2|desc" class="sorting"  asc="rebate_2|asc"><?php echo self::$language['level_2']?><?php echo self::$language['distributor']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="rebate_2|desc" class="sorting"  asc="rebate_3|asc"><?php echo self::$language['level_3']?><?php echo self::$language['distributor']?></a></td>
                <td><?php echo self::$language['store_master']?></td>
                <td><?php echo self::$language['referee']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=m_row><?php echo $module['page']?></div>
    </div>
    </div>

</div>
