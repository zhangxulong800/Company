<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){
		
    });

    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .store_name{}
    #<?php echo $module['module_name'];?>_html .store_name img{ height:2rem; padding-right:0.3rem;}
	#<?php echo $module['module_name'];?>_html .order_state_0{ }
	#<?php echo $module['module_name'];?>_html .order_state_1{ }
	#<?php echo $module['module_name'];?>_html .order_state_2{ }
	#<?php echo $module['module_name'];?>_html .sum_div{ margin-top:1rem; margin-bottom:1rem;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['buyer']?>"  class="form-control" ></m_label></div></div></div>
    
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
		<span id=time_limit><span class=start_time_span><?php echo self::$language['pay']?><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
		
		<?php echo $module['sum_html']?>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0" >
         <thead>
            <tr>
                <td><?php echo self::$language['buyer']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="order_distribution_money|desc" class="sorting"  asc="order_distribution_money|asc"><?php echo self::$language['order_distribution_money']?></a></td>
                <td><?php echo self::$language['supplier']?></td>
                <td><?php echo self::$language['order_id']?></td>
                <td ><?php echo self::$language['commission']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="success_time|desc" class="sorting"  asc="success_time|asc"><?php echo self::$language['success_time']?></a></td>
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
