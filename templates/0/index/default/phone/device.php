<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?>_html #pc,#<?php echo $module['module_name'];?>_html #phone").click(function(){
		url=window.location.href;
		url=replace_get(url,'monxin_device',$(this).attr('id'));
		window.location.href=url;		
		return false;		
	});	
	$("#<?php echo $module['module_name'];?>_html #"+getCookie('monxin_device')).addClass('a_current');
	
	
        
    });
    </script>
    

	<style>
	#qiao-wrap{ display:none !important;}
	.weixin_share{display:none;}
	#<?php echo $module['module_name'];?>{ width:100%;}
    #<?php echo $module['module_name'];?>_html{ line-height:2rem; text-align:center; width:100%; }
	#<?php echo $module['module_name'];?>_html a{}
    #<?php echo $module['module_name'];?>_html .a_current{ }
	#<?php echo $module['module_name'];?>_html .power_by{ display:inline-block; font-size:0.9rem;}
	#<?php echo $module['module_name'];?>_html .power_by a{ font-size:0.9rem;padding:0px;}
	#<?php echo $module['module_name'];?>_html a:hover{ font-weight:bold;}
	
	.page-footer #<?php echo $module['module_name'];?>_html{ }
	.page-footer #<?php echo $module['module_name'];?>_html a{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html" class="container">
<a href=./sitemap.php class=sitemap></a>
	<a href="#" id='phone'><?php echo self::$language['phone_device'];?></a>
	<a href="#" id='pc'><?php echo self::$language['pc_device'];?></a> 
    <div class=power_by>Powered by Sanshengshiye</div>

    </div>
</div>