<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
    });
    </script>
    <style>
    #<?php echo $module['module_name'];?> {}
	#<?php echo $module['module_name'];?> .default_value{ text-align:left; height:140px; line-height:140px;   margin:auto;}
	#<?php echo $module['module_name'];?> .default_value .s_logo{ display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?> .default_value .s_logo img{height:100px; margin:20px; border:none;border-radius:20px; overflow:hidden; border:#CCC solid 2px;}
	#<?php echo $module['module_name'];?> .default_value .s_name{display:inline-block; vertical-align:top;font-size:60px; font-weight:bold;}
	#<?php echo $module['module_name'];?> .default_value .s_name_postfix{display:inline-block; vertical-align:top;font-size:30px; padding-top:10px;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=0>
        <div id="agency_head">
            <div style="text-align:center;" class=container>
                <div class="default_value">
                    <a class="s_logo" href="index.php?monxin=distribution.index&id=<?php echo $_GET['id']?>"><img src="<?php echo $module['data']['icon'];?>"></a><span class="s_name"><?php echo $module['data']['nickname'];?></span><span class="s_name_postfix"><?php echo self::$language['the_store']?></span> 
                </div>
            </div>
        </div>    
        
    </div>
</div>

