<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){
        //if(get_param('id')==''){$("#<?php echo $module['module_name'];?>_html h2").css('display','none');}
    });
    </script>
    

	<style>
    #<?php echo $module['module_name'];?>_html{ text-align:center;}
    #<?php echo $module['module_name'];?>_html td{ text-align:left;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"   monxin-table=1>
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"></div></div>
    	<h2 style="display:<?php echo $module['username_display'];?>;"><?php echo $module['username']?>(<?php echo $module['real_name']?>)<?php echo self::$language['last_time']?></h2>
        
    	<div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%;" cellpadding="0" cellspacing="0">
        <thead><tr><td><?php echo self::$language['time']?></td><td><?php echo self::$language['place']?>/ip</td></tr></thead>
        <tbody><?php echo $module['list']?></tbody>
        </table></div>
     <?php echo $module['page'];?>
    </div>
</div>   
