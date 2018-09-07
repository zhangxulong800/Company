<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .card_head{ background-color: #4bb2dd; }

    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    	<a href="./index.php?monxin=mall.my_cart" class=card_head>
        	<span class=big_num><?php echo $module['cart'];?></span>
            <span class=remark><?php echo self::$language['cart'];?></span>
        </a>
    	<div class=card_body>
        	<a href='./index.php?monxin=mall.my_collect' class=item>
            	<span class=name><?php echo self::$language['favorites']?></span>
            	<span class=value><?php echo $module['favorite'];?></span>
            </a><a href='./index.php?monxin=mall.my_visit' class=item>
            	<span class=name><?php echo self::$language['pages']['mall.my_visit']['name']?></span>
            	<span class=value><?php echo $module['visit'];?></span>
            </a><a href='./index.php?monxin=mall.my_order&state=0' class=item>
            	<span class=name><?php echo self::$language['order_state'][0]?><?php echo self::$language['order']?></span>
            	<span class=value><?php echo $module['order_0'];?></span>
            </a><a href='./index.php?monxin=mall.my_order&state=1' class=item>
            	<span class=name><?php echo self::$language['order_state'][1]?><?php echo self::$language['order']?></span>
            	<span class=value><?php echo $module['order_1'];?></span>
            </a><a href='./index.php?monxin=mall.my_order&state=2' class=item>
            	<span class=name><?php echo self::$language['goods_to_be_received']?><?php echo self::$language['order']?></span>
            	<span class=value><?php echo $module['order_2'];?></span>
            </a><a href='./index.php?monxin=mall.my_order&state=6' class=item>
            	<span class=name><?php echo self::$language['order_state'][6]?><?php echo self::$language['order']?></span>
            	<span class=value><?php echo $module['order_6'];?></span>
            </a>
        </div>
        <div class=other>
        	<a href="./index.php?monxin=mall.receiver"><span class=value><?php echo $module['receiver']?></span></a>
        	<a href="./index.php?monxin=mall.coupon_usable"><span class=value><?php echo $module['coupon_usable']?></span></a>
        </div>
        
    </div>
</div>