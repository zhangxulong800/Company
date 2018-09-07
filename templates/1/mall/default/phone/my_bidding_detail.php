<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
    });
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> .goods_name{ display:block; max-width:300px; white-space:nowrap; overflow:hidden; text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?> .src_title{ display:block; max-width:160px; white-space:nowrap; overflow:hidden; text-overflow: ellipsis;}
    #<?php echo $module['module_name'];?>_table td{  padding-left:10px; text-align:left;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['click_man']?></td>
                <td ><?php echo self::$language['time']?></td>
                <td ><?php echo self::$language['goods_name']?></td>
                <td ><?php echo self::$language['src']?></td>
                <td ><?php echo self::$language['cost_sum']?></td>
                <td >IP</td>
            </tr>
        </thead>
        <tbody>
    <?php echo  $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
