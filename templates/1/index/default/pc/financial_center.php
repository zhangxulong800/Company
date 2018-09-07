<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
    #statistics{ padding-left:30px; line-height:5rem; font-size:1.6rem; padding-top:1rem; padding-bottom:4rem; font-weight:bold;}
    #user_money{ display: inline-block; vertical-align:top; width:48%; text-align:right; padding-right:2%;}
    #user_money span{}
    #user_credits{ display: inline-block; vertical-align:top; width:50%; text-align:left;}
    #user_credits span{}
	
    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    <div id=statistics>
        <span id=user_money><?php echo self::$language['user_money'];?>:<span><?php echo $module['user_money'];?></span></span><span id=user_credits><?php echo self::$language['credits'];?>:<span><?php echo $module['user_credits'];?></span></span>
    </div>
    
      <?php echo $module['list']?>
    </div>
</div>