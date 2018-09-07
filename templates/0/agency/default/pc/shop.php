<link rel="stylesheet" href="<?php echo get_template_dir(__FILE__);?>/shop_style/<?php echo $module['template']?>/main.css" type="text/css">

<div id="agency_head">
    <div style="text-align:center;">
        <div class="default_value">
            <a class="s_logo" href="index.php?monxin=agency.shop&store_id=<?php echo $_GET['store_id']?>"><img src="program/agency/shop_icon/<?php echo $module['icon']?>"></a><span class="s_name"><?php echo $module['store_name'];?></span><span class="s_name_postfix"><?php echo self::$language['the_store']?></span> 
        </div>
    </div>
</div>    

<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		type=get_param('type');
		if(type!=''){$(".nav-tabs li").removeClass('active');$(".nav-tabs li[type="+type+"]").addClass('active');}
		$.get("<?php echo $module['count_url']?>");
    });
	
    </script>
    
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=1>
    <ul class="nav nav-tabs"><?php echo $module['type_option'];?></ul>
    <div class=goods_list><?php echo $module['list'];?></div>
    <?php echo $module['page']?>

    </div>
</div>

