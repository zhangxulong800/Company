<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
    });
    
    </script>
	<style>    
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .sum_div{ float:right; text-align:right;}
	#<?php echo $module['module_name'];?> .sum_div .m_label{ }
	#<?php echo $module['module_name'];?> .sum_div .value{ font-weight:bold;padding-right:20px;}
	#<?php echo $module['module_name'];?> .title{ display:block; width:500px; overflow:hidden; text-align:left; white-space:nowrap; text-overflow: ellipsis; padding-left:15px; }
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['share_content']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
		<div class=sum_div><b><?php echo self::$language['sum']?> </b> <?php echo $module['sum'];?></div>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><span class=title><?php echo self::$language['share_content']?></span></td>
                <td ><?php echo self::$language['visit']?></td>
                <td ><?php echo self::$language['reg']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="contribution|desc" class="sorting"  asc="contribution|asc"><?php echo self::$language['contribution']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
