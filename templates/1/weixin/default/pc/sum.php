<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .card_head{background-color: #CCCC33; }
	
    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    	<a href="./index.php?monxin=weixin.account_admin" class=card_head>
        	<span class=big_num><?php echo $module['sum'];?></span>
            <span class=remark><?php echo self::$language['pages']['weixin.account_admin']['name'];?></span>
        </a>
    	<div class=card_body>
        	<a  class=item>
            	<span class=name><?php echo self::$language['user']?></span>
            	<span class=value><?php echo $module['user'];?></span>
            </a><a  class=item>
            	<span class=name><?php echo self::$language['receive_msg']?></span>
            	<span class=value><?php echo $module['dialog'];?></span>
            </a><a class=item>
            	<span class=name><?php echo self::$language['auto_answer']?><?php echo self::$language['sum_display']?></span>
            	<span class=value><?php echo $module['visit'];?></span>
            </a><a  class=item>
            	<span class=name><?php echo self::$language['lately']?><?php echo self::$language['receive_msg']?></span>
            	<span class=value><?php echo $module['last_edit']?></span>
            </a>
        </div>
        
        
    </div>
</div>