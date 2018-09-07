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
    	<a href="./index.php?monxin=feedback.admin" class=card_head>
        	<span class=big_num><?php echo $module['sum'];?></span>
            <span class=remark><?php echo self::$language['program_name'];?></span>
        </a>
    	<div class=card_body>
        	<a href='./index.php?monxin=feedback.admin&state=0' class=item>
            	<span class=name><?php echo self::$language['feedback_state'][0]?></span>
            	<span class=value><?php echo $module['sum_0'];?></span>
            </a><a href='./index.php?monxin=feedback.admin&state=1' class=item>
            	<span class=name><?php echo self::$language['feedback_state'][1]?></span>
            	<span class=value><?php echo $module['sum_1'];?></span>
            </a><a href='./index.php?monxin=feedback.admin&state=2' class=item>
            	<span class=name><?php echo self::$language['feedback_state'][2]?></span>
            	<span class=value><?php echo $module['sum_2'];?></span>
            </a><a href='./index.php?monxin=feedback.admin&state=3' class=item>
            	<span class=name><?php echo self::$language['feedback_state'][3]?></span>
            	<span class=value><?php echo $module['sum_3'];?></span>
            </a><a href='./index.php?monxin=feedback.admin' class=item>
            	<span class=name><?php echo self::$language['lately']?><?php echo self::$language['feedback_sender']?></span>
            	<span class=value><?php echo $module['sender'];?></span>
            </a><a href='./index.php?monxin=feedback.admin' class=item>
            	<span class=name><?php echo self::$language['lately']?><?php echo self::$language['time']?></span>
            	<span class=value><?php echo $module['time'];?></span>
            </a>
        </div>
        
        
    </div>
</div>