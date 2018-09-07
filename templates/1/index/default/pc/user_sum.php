<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .card_head {background-color: #f4756e;}
    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    	<a href="./index.php?monxin=index.money_log" class=card_head>
        	<span class=big_num><?php echo $module['user_money'];?></span>
            <span class=remark><?php echo self::$language['user_money'];?></span>
        </a>
    	<div class=card_body>
        	<a href='./index.php?monxin=index.login_log' class=item>
            	<span class=name><?php echo self::$language['last_login_time']?></span>
            	<span class=value><?php echo $module['last_login_time'];?></span>
            </a><a href='./index.php?monxin=index.login_log' class=item>
            	<span class=name><?php echo self::$language['last_login_site']?></span>
            	<span class=value><?php echo $module['last_login_position'];?></span>
            </a><a href='./index.php?monxin=index.site_msg_addressee' class=item>
            	<span class=name><?php echo self::$language['unread_site_msg']?></span>
            	<span class=value><?php echo $module['unread_site_msg'];?></span>
            </a><a href='./index.php?monxin=index.credits_log' class=item>
            	<span class=name><?php echo self::$language['credits']?></span>
            	<span class=value><?php echo $module['credits'];?></span>
            </a><a href='./index.php?monxin=index.recharge_log' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['success']?><?php echo self::$language['recharge']?></span>
            	<span class=value><?php echo $module['recharge'];?></span>
            </a><a href='./index.php?monxin=index.withdraw_log' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['success']?><?php echo self::$language['withdraw']?></span>
            	<span class=value><?php echo $module['withdraw'];?></span>
            </a>
        </div>
        
        
    </div>
</div>