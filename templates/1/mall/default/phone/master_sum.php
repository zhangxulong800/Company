<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .card_head{ background-color:#C0F; }

    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    	<a href="./index.php?monxin=mall.m_order_admin" class=card_head>
        	<span class=big_num><?php echo $module['turnover'];?></span>
            <span class=remark><?php echo self::$language['cumulative']?><?php echo self::$language['turnover']?></span>
        </a>
    	<div class=card_body>
        
        	<a href='./index.php?monxin=mall.m_order_admin' class=item>
            	<span class=name><?php echo self::$language['today']?><?php echo self::$language['turnover']?></span>
            	<span class=value><?php echo $module['today_turnover'];?></span>
            </a><a href='./index.php?monxin=mall.m_order_admin' class=item>
            	<span class=name><?php echo self::$language['yesterday']?><?php echo self::$language['turnover']?></span>
            	<span class=value><?php echo $module['yesterday_turnover'];?></span>
            </a><a href='./index.php?monxin=mall.shop_admin&state=0' class=item>
            	<span class=name><?php echo self::$language['shop_state'][0]?><?php echo self::$language['shop']?></span>
            	<span class=value><?php echo $module['shop'];?></span>
            </a><a href='./index.php?monxin=mall.m_order_admin' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['order']?></span>
            	<span class=value><?php echo $module['order_6'];?></span>
            </a><a href='./index.php?monxin=mall.m_goods_admin' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['goods']?></span>
            	<span class=value><?php echo $module['goods'];?></span>
            </a><a href='./index.php?monxin=mall.m_comment_admin' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['comment']?></span>
            	<span class=value><?php echo $module['comment'];?></span>
            </a>
        </div>
        
        
    </div>
</div>