<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .card_head{background-color: #4bb2dd; }

    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    	<a href="./index.php?monxin=distribution.order" class=card_head>
        	<span class=big_num><?php echo $module['cumulative_commission_earn'];?></span>
            <span class=remark><?php echo self::$language['cumulative'];?><?php echo self::$language['commission_earn'];?></span>
        </a>
    	<div class=card_body>
        	<a  class=item>
            	<span class=name><?php echo self::$language['today']?><?php echo self::$language['visit']?></span>
            	<span class=value><?php echo $module['today_visit'];?></span>
            </a><a  class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['visit']?></span>
            	<span class=value><?php echo $module['cumulative_visit'];?></span>
            </a><a href='./index.php?monxin=distribution.distribution' class=item>
            	<span class=name><?php echo self::$language['subordinate']?><?php echo self::$language['distributor']?></span>
            	<span class=value><?php echo $module['distributor'];?></span>
            </a><a href='./index.php?monxin=distribution.order' class=item>
            	<span class=name><?php echo self::$language['level_1']?><?php echo self::$language['orders']?></span>
            	<span class=value><?php echo $module['level_1'];?></span>
            </a><a href='./index.php?monxin=distribution.order' class=item>
            	<span class=name><?php echo self::$language['level_2']?><?php echo self::$language['orders']?></span>
            	<span class=value><?php echo $module['level_2'];?></span>
            </a><a href='./index.php?monxin=distribution.order' class=item>
            	<span class=name><?php echo self::$language['level_3']?><?php echo self::$language['orders']?></span>
            	<span class=value><?php echo $module['level_3'];?></span>
            </a>
        </div>
        
        
    </div>
</div>