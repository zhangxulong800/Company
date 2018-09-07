<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		
		
    });
	
	
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ background:none;  padding:0px; margin:0px;}
	#<?php echo $module['module_name'];?>_html .module_title { text-align:center;  line-height:40px; font-size:1.2rem; font-weight:bold;}
#<?php echo $module['module_name'];?>_html .module_title:before{ content:"——"; font-weight:bold;  padding-right:1rem; color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
#<?php echo $module['module_name'];?>_html .module_title:after{  content:"——"; font-weight:bold;  padding-left:1rem;color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
	
    #<?php echo $module['module_name'];?>{ background:none;  padding:0px; margin:0px;}
    #<?php echo $module['module_name'];?> .goods_div{ text-align:left;}
    #<?php echo $module['module_name'];?> .goods_div .goods{ display:block;  margin-top:0.5rem; background:#fff; }
	#<?php echo $module['module_name'];?> .goods_div .goods:hover{ background:rgba(255,255,255,0.6);}
	
	#<?php echo $module['module_name'];?> .goods_div .goods .l_info{ display:inline-block; vertical-align:top; width:25%; overflow:hidden; text-align:center;}
	#<?php echo $module['module_name'];?> .goods_div .goods .r_info{ display:inline-block; vertical-align:top; width:75%; overflow:hidden;}
	
    #<?php echo $module['module_name'];?> .goods_div .goods img{ width:90%; }
    #<?php echo $module['module_name'];?> .goods_div .goods .title{ padding-left:10px; padding-right:10px; line-height:2rem; height:4rem; overflow:hidden;    text-overflow: ellipsis;}
    #<?php echo $module['module_name'];?> .goods_div .goods .price_div{ padding-left:10px; padding-right:10px; text-align:left; margin-bottom:1rem; }
	#<?php echo $module['module_name'];?> .goods_div .goods .price_div .l{ display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .goods_div .goods .price_div .r{ text-align:right; display:inline-block; vertical-align:top; width:50%; overflow:hidden; color:#ccc;}
	#<?php echo $module['module_name'];?> .goods_div .goods .price_div .v{ color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=module_title><?php echo self::$language['limit_time_bargain']?></div>
    	<div class=goods_div><?php echo $module['list']?></div>
    <?php echo $module['page']?>

    </div>
</div>

