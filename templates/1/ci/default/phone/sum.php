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
    	<a href="./index.php?monxin=ci.info_admin" class=card_head>
        	<span class=big_num><?php echo $module['sum'];?></span>
            <span class=remark><?php echo self::$language['program_name'];?> <?php echo self::$language['content_sum'];?></span>
        </a>
    	<div class=card_body>
        	<a href='./index.php?monxin=ci.info_admin&state=0' class=item>
            	<span class=name><?php echo self::$language['info_state'][0]?></span>
            	<span class=value><?php echo $module['state_0'];?></span>
            </a><a href='./index.php?monxin=ci.info_admin&state=0&search=&order=visit|desc' class=item>
            	<span class=name><?php echo self::$language['sum_visit']?></span>
            	<span class=value><?php echo $module['s_visit'];?></span>
            </a><a href='./index.php?monxin=ci.info_admin' class=item>
            	<span class=name><?php echo self::$language['user']?></span>
            	<span class=value><?php echo $module['usernames'];?></span>
            </a><a href='./index.php?monxin=index.money_log_admin&program=ci' class=item>
            	<span class=name><?php echo self::$language['profit']?></span>
            	<span class=value><?php echo $module['money'];?><?php echo self::$language['yuan']?></span>
            </a><a href='./index.php?monxin=ci.search_log' class=item>
            	<span class=name><?php echo self::$language['search']?></span>
            	<span class=value><?php echo $module['search_sum'];?></span>
            </a><a href='./index.php?monxin=ci.info_admin' class=item>
            	<span class=name><?php echo self::$language['last_edit']?></span>
            	<span class=value><?php echo $module['last_edit'];?></span>
            </a>
        </div>
        
        
    </div>
</div>