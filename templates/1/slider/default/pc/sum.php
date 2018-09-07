<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .card_head{ }
	#<?php echo $module['module_name'];?>_html .top{}
	#<?php echo $module['module_name'];?>_html .top div{ white-space:nowrap; line-height:2.5rem;}
	#<?php echo $module['module_name'];?>_html .top div:hover{ }
	#<?php echo $module['module_name'];?>_html .top div a{ display:inline-block; vertical-align:top; width:80%; overflow:hidden; text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?>_html .top div span{display:inline-block; vertical-align:top; width:20%; overflow:hidden; text-overflow: ellipsis; text-align:right;}
    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    	<a href="./index.php?monxin=slider.group" class=card_head>
        	<span class=big_num><?php echo $module['visit'];?></span>
            <span class=remark><?php echo $module['visit_remark'];?></span>
        </a>
    	<div class=card_body>
        	<a href='./index.php?monxin=slider.group' class=item>
            	<span class=name><?php echo self::$language['content_sum']?></span>
            	<span class=value><?php echo $module['content_sum'];?></span>
            </a><a href='./index.php?monxin=slider.group&order=time|desc' class=item>
            	<span class=name><?php echo self::$language['last_edit']?></span>
            	<span class=value><?php echo $module['last_edit'];?></span>
            </a>
            <div class=top>
            	<?php echo $module['top'];?>
            </div>
        </div>
        
        
    </div>
</div>