<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .card_head{background-color: #669966; }

    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    	<a href="./index.php?monxin=agency.shop_order" class=card_head>
        	<span class=big_num><?php echo $module['today_orders'];?></span>
            <span class=remark><?php echo self::$language['today'];?><?php echo self::$language['agency'];?><?php echo self::$language['orders'];?></span>
        </a>
    	<div class=card_body>
        	<a  class=item>
            	<span class=name><?php echo self::$language['today']?><?php echo self::$language['visit']?></span>
            	<span class=value><?php echo $module['today_visit'];?></span>
            </a><a  class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['visit']?></span>
            	<span class=value><?php echo $module['cumulative_visit'];?></span>
            </a><a href='./index.php?monxin=agency.shop_shop' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['distributor']?></span>
            	<span class=value><?php echo $module['distributor'];?></span>
            </a><a href='./index.php?monxin=agency.shop_order' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['orders']?></span>
            	<span class=value><?php echo $module['orders'];?></span>
            </a>
        </div>
        
        
    </div>
</div>