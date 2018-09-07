<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		
    });
    </script>
    <style>
    #<?php echo $module['module_name'];?> {background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; margin:0px !important; padding:0px;}
    #<?php echo $module['module_name'];?>_html {  margin:0px !important; padding:0px;}
	#<?php echo $module['module_name'];?> .default_value{ text-align:center;  margin:auto; white-space:nowrap; color:#fff; padding-bottom:10px;}
	#<?php echo $module['module_name'];?> .default_value .s_logo{ display:block; text-align:center; padding-top:10px;}
	#<?php echo $module['module_name'];?> .default_value .s_logo img{height:50px; width:50px; border:none;border-radius:25px; overflow:hidden; border:#fff solid 2px;}
	#<?php echo $module['module_name'];?> .default_value .s_name{font-size:40px; font-weight:bold;}
	#<?php echo $module['module_name'];?> .default_value .s_name_postfix{font-size:20px; padding-top:10px; padding-left:3px;}
	#<?php echo $module['module_name'];?> .default_value span{ }
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

