<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .card_head{background-color: #00CCCC; }
	#<?php echo $module['module_name'];?>_html .top{}
	#<?php echo $module['module_name'];?>_html .top div{ white-space:nowrap; line-height:2.5rem;}
	#<?php echo $module['module_name'];?>_html .top div:hover{ }
	#<?php echo $module['module_name'];?>_html .top div a{ display:inline-block; vertical-align:top; width:80%; overflow:hidden; text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?>_html .top div span{display:inline-block; vertical-align:top; width:20%; overflow:hidden; text-overflow: ellipsis; text-align:right;}
    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    	<a href="./index.php?monxin=form.table_admin" class=card_head>
        	<span class=big_num><?php echo $module['table'];?></span>
            <span class=remark><?php echo self::$language['program_name'];?><?php echo self::$language['quantity'];?></span>
        </a>
    	<div class=card_body>
            <div class=top>
            	<?php echo $module['top'];?>
            </div>
        </div>
        
        
    </div>
</div>