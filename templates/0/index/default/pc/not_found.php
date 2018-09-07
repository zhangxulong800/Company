<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script>window.location.href='./index.php';</script>
	<style>
	body{ background-image:url(<?php echo get_template_dir(__FILE__);?>img/1.png);}
    #<?php echo $module['module_name'];?>_html{width:100%; text-align:center; margin-top:10%;}
	#<?php echo $module['module_name'];?> #index_head_html{ height:70px; margin-top:30px;}
	#<?php echo $module['module_name'];?> #sorry{ height:110px; margin-top:30px; display:inline-block;  line-height:110px; font-size:28px; }
	#<?php echo $module['module_name'];?> #back_index_icon{ background-image:url(<?php echo get_template_dir(__FILE__);?>img/home_icon.png); width:40px; height:40px; display:inline-block; background-repeat:no-repeat; line-height:40px;}
	#<?php echo $module['module_name'];?> #back_index_text{ line-height:30px;  display:inline-block; font-size:20px;}
	#<?php echo $module['module_name'];?> #back_index_text a{ line-height:30px;  }
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        
<div class=table_scroll><table width="100%" border="0">
  <tr>
    <td rowspan="2" align="right" width="40%"><a href="index.php"><img src="<?php echo get_template_dir(__FILE__);?>img/no_related_content_icon.png"/></a></td>
    <td align="left"><div id="sorry"><?php echo self::$language['not_found'];?><br/></div></td>
  </tr>
  <tr>
    <td align="left"><a href="index.php"><span id="back_index_icon">&nbsp;</span><span id="back_index_text"><?php echo self::$language['go_home'];?></span></a></td>
  </tr>
</table></div>
        
        
	
    </div>
</div>






