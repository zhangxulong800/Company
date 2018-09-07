<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
    #statistics{ padding-left:30px; line-height:3rem; font-size:1.3rem; padding-top:1rem; padding-bottom:0.1rem;}
    #user_money{ display:block;}
    #user_money span{}
    #user_credits{display:block;}
    #user_credits span{}
	
    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    <div id=statistics>
        <span id=user_money><?php echo self::$language['user_money'];?>:<span><?php echo $module['user_money'];?></span></span><span id=user_credits><?php echo self::$language['credits'];?>:<span><?php echo $module['user_credits'];?></span></span>
    </div>
    
      <?php echo $module['list']?>
    </div>
</div>