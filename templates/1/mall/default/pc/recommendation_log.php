<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> #search_filter{ width:200px;}
    #<?php echo $module['module_name'];?> .hot_search{width:600px;}
    #<?php echo $module['module_name'];?> .keyword{ text-align:left;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['recommender']?>"  class="form-control" ></m_label></div></div></div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['buyer']?></td>
                <td ><?php echo self::$language['order_id']?></td>
                <td ><?php echo self::$language['goods_info']?></td>
                <td ><?php echo self::$language['recommender']?></td>
                <td ><?php echo self::$language['recommendation_money']?></td>
                <td ><?php echo self::$language['order_state'][6]?><?php echo self::$language['time']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo  $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
