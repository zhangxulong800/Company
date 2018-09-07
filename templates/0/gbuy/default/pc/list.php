<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		
		
    });
	
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ background:none;  padding:0px; margin:0px;}
    #<?php echo $module['module_name'];?> .goods_div{ text-align:left;}
    #<?php echo $module['module_name'];?> .goods_div .goods{ display:inline-block; vertical-align:top; width:18%; margin:1%; overflow:hidden; text-align:center; background:#fff; padding-top:10px; }
	#<?php echo $module['module_name'];?> .goods_div .goods:hover{ background:rgba(255,255,255,0.6);}
    #<?php echo $module['module_name'];?> .goods_div .goods img{ width:190px; height:190px; }
    #<?php echo $module['module_name'];?> .goods_div .goods .title{ padding-left:10px; padding-right:10px; line-height:2rem; height:2rem; overflow:hidden;     white-space: nowrap;text-overflow: ellipsis;}
    #<?php echo $module['module_name'];?> .goods_div .goods .price_div{ padding-left:10px; padding-right:10px; text-align:left; margin-bottom:1rem; }
	#<?php echo $module['module_name'];?> .goods_div .goods .price_div .l{ display:inline-block; vertical-align:top; width:50%; overflow:hidden; color:#ccc;}
	
	#<?php echo $module['module_name'];?> .goods_div .goods .price_div .l .v{ text-decoration: line-through;}
	#<?php echo $module['module_name'];?> .goods_div .goods .price_div .r{ text-align:right; display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .goods_div .goods .price_div .v{ color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=goods_div><?php echo $module['list']?></div>
    <?php echo $module['page']?>

    </div>
</div>

