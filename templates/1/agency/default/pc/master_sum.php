<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .card_head{background-color: #00CC66;}

    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    	<a href="./index.php?monxin=agency.goods_admin&current_page=1&order=state|asc" class=card_head>
        	<span class=big_num><?php echo $module['goods_state_0'];?></span>
            <span class=remark><?php echo self::$language['goods_state_option'][0];?><?php echo self::$language['agency'];?><?php echo self::$language['goods'];?></span>
        </a>
    	<div class=card_body>
        	<a  class=item>
            	<span class=name><?php echo self::$language['today']?><?php echo self::$language['visit']?></span>
            	<span class=value><?php echo $module['today_visit'];?></span>
            </a><a  class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['visit']?></span>
            	<span class=value><?php echo $module['cumulative_visit'];?></span>
            </a><a href='./index.php?monxin=agency.shop_admin' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['distributor']?></span>
            	<span class=value><?php echo $module['distributor'];?></span>
            </a><a href='./index.php?monxin=agency.order_admin' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['orders']?></span>
            	<span class=value><?php echo $module['orders'];?></span>
            </a>
        </div>
        
        
    </div>
</div>