<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>").css('min-height',$(window).height());
    });
	
	
    </script>
	<style>
	.fixed_right_div,.page-footer,#mall_cart{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
	<?php echo $module['css'];?>
	
    #<?php echo $module['module_name'];?>{}
	.caption{ white-space:nowrap;}
    #<?php echo $module['module_name'];?> .goods_info{line-height:2rem;}
    #<?php echo $module['module_name'];?> .goods_info img{ height:2rem; border:none; margin-right:3px;}
	#<?php echo $module['module_name'];?> #time_limit input{ width:24%;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?> <?php echo $module['goods_title'];?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label>
    	<a href=./index.php?monxin=mall.deduct_stock_add class=add><?php echo self::$language['pages']['mall.deduct_stock_add']['name']?></a>
           
        </m_label></div></div></div>
 <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
            <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['goods']?></td>
                <td><?php echo self::$language['quantity']?></td>
                <td><?php echo self::$language['worth']?></td>
                <td><?php echo self::$language['reason']?></td>
                <td><?php echo self::$language['issue_2']?><?php echo self::$language['time']?></td>
            </tr>
        </thead>
        <tbody>
            <tr style="display:none;" id="<?php echo $module['module_name'];?>_new">
              <td >&nbsp;</td>
              <td><input type="text" name="quantity" id="quantity" /></td>
              <td><input type="text" name="price" id="price" /></td>
              <td id="new_td_last" colspan="2"  style="text-align:left; height:60px;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['submit_into']?></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
