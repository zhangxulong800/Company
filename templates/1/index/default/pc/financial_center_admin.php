<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
            
    });
    </script>
    

	<style>
    #<?php echo $module['module_name'];?>_html{}
    #statistics{ text-align:center; line-height:150px;}
    #statistics_txt{ font-size:50px; font-weight:bold;}
    #recharge span{font-weight:bold; padding-right:20px; display:inline-block;}
    #withdraw span{font-weight:bold; padding-right:20px; display:inline-block;}
    #user_money span{font-weight:bold; padding-right:20px; display:inline-block;}
	
    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    <div id=statistics>
        <span id=statistics_txt><?php echo self::$language['statistics'];?></span>
        <span id=recharge><?php echo self::$language['recharge'];?>:<span><?php echo $module['recharge'];?></span></span>
        <span id=withdraw><?php echo self::$language['withdraw'];?>:<span><?php echo $module['withdraw'];?></span></span>
        <span id=user_money><?php echo self::$language['user_money'];?>:<span><?php echo $module['user_money'];?></span></span>
    </div>
    
      <?php echo $module['list']?>
    </div>
</div>