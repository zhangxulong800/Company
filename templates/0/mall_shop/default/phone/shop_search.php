<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
            
    });
    </script>
    
    <style>
	#<?php echo $module['module_name'];?>{ width:540px; height:100px; margin-top:40px; display:inline-block; vertical-align:top;white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .search_input_div .start{ vertical-align:top;background-image:url(<?php echo get_template_dir(__FILE__);?>img/search_start_bg.png); background-repeat:no-repeat; display:inline-block; vertical-align:top; width:50px; height:50px; line-height:50px;}
	#<?php echo $module['module_name'];?>_html .search_input_div .search_middle{ vertical-align:top;background-image:url(<?php echo get_template_dir(__FILE__);?>img/search_middle_bg.png); background-repeat:repeat-x; display:inline-block; vertical-align:top; width:380px; height:50px; line-height:50px; }
	#<?php echo $module['module_name'];?>_html .search_input_div input{ border:none; height:30px; width:380px; background:none;}
	#<?php echo $module['module_name'];?>_html .search_input_div #imageField{padding: 0px; vertical-align:top; vertical-align:top; margin-left:-3px; display:inline-block; vertical-align:top; width:110px; height:50px; line-height:50px; border-radius:0px;}
	#<?php echo $module['module_name'];?>_html .search_hot_div{ position:relative; line-height:40px; height:40px; overflow:hidden; left:0px;}
	#<?php echo $module['module_name'];?>_html .search_hot_div a{ padding-right:10px;}
    #<?php echo $module['module_name'];?>_html #imageField:hover{opacity:0.5; filter:alpha(opacity=50); }
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
      <form id="shop_goods_search" name="shop_goods_search" method="get" action="./index.php">
        <div class="search_input_div"><span class=start> </span><input type="hidden" name="monxin" id="monxin" value="shop.goods_list" /><span class="search_middle"><input type="text" name="search" id="search" value="<?php echo @$_GET['search']?>" /></span><input type="image" name="imageField" id="imageField" src="<?php echo get_template_dir(__FILE__);?>img/search.png" /></div>
        <?php echo $module['hot_search_html'];?>
      </form>
    </div>
</div>