<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    <style>
    #<?php echo $module['module_name'];?>_html{ }
    #<?php echo $module['module_name'];?>_html .m_label3{ display: inline-block;width:80px;}
    </style>
    
    
    <script>
    
    $(document).ready(function(){
        $.get("<?php echo $module['set_read_url']?>");
            
    });
    </script>
    

    <div id="<?php echo $module['module_name'];?>_html">
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
    <div id="show_count" style="display:none;"></div>
      <span class=m_label><?php echo self::$language['sender']?>: </span><?php echo $module['sender']?><br/><br/>
      <span class=m_label><?php echo self::$language['time']?>: </span><?php echo $module['time']?><br/><br/>
      <span class=m_label><?php echo self::$language['title']?>: </span><?php echo $module['title']?>
      <hr/>
      <?php echo $module['content']?>
    </div>
</div>