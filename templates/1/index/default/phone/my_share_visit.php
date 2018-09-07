<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
    });
    
    
    </script>
	<style>    
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .title{ line-height:60px; }
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
	<div class=title>
		 <?php echo $module['time']?>&nbsp; &nbsp;  <?php echo self::$language['share_content']?> : <?php echo $module['share_content']?> 
	</div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['visit']?></td>
                <td ><?php echo self::$language['time']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>

    <?php echo $module['page']?>
    </div>
</div>
