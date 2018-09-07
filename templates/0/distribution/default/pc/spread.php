<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
            
    });
    </script>
    

    <style>
    #<?php echo $module['module_name'];?>{ padding-top:2rem;}
    #<?php echo $module['module_name'];?> .qr_img_div{ text-align:center;}
    #<?php echo $module['module_name'];?> .url_div{ line-height:40px; margin-bottom:2rem; text-align:center;}
    
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class=qr_img_div>
        	<div><?php echo self::$language['store_2'];?>: <?php echo $module['store_name'];?> 	<?php echo self::$language['qr_code'];?></div>
        	<img width=250px src='<?php echo $module['qr_path'];?>' />
        </div>
        <div class=url_div><?php echo self::$language['share_notice']?><br /><?php echo $module['store_url'];?></div>
    </div>
</div>