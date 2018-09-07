<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
	
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>").css('min-height',$(window).height());
    });
    
    
	
    </script>
	<style>
	.page-content{ }
	.page-header{ display:none;}
	.page-footer{ display:none;}
	.fixed_right_div{ display:none; }
	.container{ width:100%; padding:0px; margin:0px;}
	#<?php echo $module['module_name'];?>{ }
    #<?php echo $module['module_name'];?> .goods_title{ line-height:30px; padding-left:10px; font-weight:bold;}
    #<?php echo $module['module_name'];?> [monxin-table] .filter{ line-height:50px;} 
	#<?php echo $module['module_name'];?> [monxin-table] tbody tr{ line-height:30px; height:30px;}
	#<?php echo $module['module_name'];?> [monxin-table] .even td{ line-height:30px; height:30px;}
	#<?php echo $module['module_name'];?> [monxin-table] .odd td{ line-height:30px; height:30px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class=goods_title><?php echo self::$language['sold_log'];?> : <?php echo $module['data']['title']?></div>

    <div class="filter"><?php echo self::$language['content_filter']?>:
         <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>

        
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['time']?></td>
                <td><?php echo self::$language['quantity']?></td>
                <td><?php echo self::$language['option']?></td>
                <td><?php echo self::$language['in_price']?></td>
                <td><?php echo self::$language['out_price']?></td>
                <td><?php echo self::$language['gross_profit']?></td>
                <td><?php echo self::$language['buyer']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
