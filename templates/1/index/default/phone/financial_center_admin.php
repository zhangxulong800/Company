<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
            
    });
    </script>
    

	<style>
    #<?php echo $module['module_name'];?>_html{}
    #statistics{ line-height:2.5rem; padding:1rem;}
	#<?php echo $module['module_name'];?>_html .line{}	
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; width:40%; text-align:right;}	
	#<?php echo $module['module_name'];?>_html .line .m_value{display:inline-block; vertical-align:top; width:58%; margin-left:2%;text-align:left; }	
    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    <div id=statistics>
        <div class=line><span class=m_label>&nbsp;</span><span class=m_value><?php echo self::$language['statistics'];?></span></div>
        <div class=line><span class=m_label><?php echo self::$language['recharge'];?>:</span><span class=m_value><?php echo $module['recharge'];?></span></div>
        <div class=line><span class=m_label><?php echo self::$language['withdraw'];?>:</span><span class=m_value><?php echo $module['withdraw'];?></span></div>
        <div class=line><span class=m_label><?php echo self::$language['user_money'];?>:</span><span class=m_value><?php echo $module['user_money'];?></span></div>
    </div>
    
      <?php echo $module['list']?>
    </div>
</div>