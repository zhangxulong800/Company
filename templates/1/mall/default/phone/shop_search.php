<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
  
		$("#<?php echo $module['module_name'];?> #search").keyup(function(event){
			keycode=event.which;
			if(keycode==13){
				url=$("#<?php echo $module['module_name'];?> .search_shop").attr('href')+'&search='+encodeURI($("#<?php echo $module['module_name'];?> #search").val());
				window.location.href=url;
			}	
		});	
       $("#<?php echo $module['module_name'];?> .search_shop").click(function(){
			$(this).attr('href',$(this).attr('href')+'&search='+encodeURI($("#<?php echo $module['module_name'];?> #search").val()));
		});     
       $("#<?php echo $module['module_name'];?> .search_mall").click(function(){
		   	$(this).attr('target','_blank');
			$(this).attr('href',$(this).attr('href')+'&search='+encodeURI($("#<?php echo $module['module_name'];?> #search").val()));
		});     
    });
    </script>
    
    <style>
	#<?php echo $module['module_name'];?>{ width:35%; height:100px; margin-top:30px; display:inline-block; vertical-align:top;white-space:nowrap; overflow:hidden; box-shadow: none;}
	
	#<?php echo $module['module_name'];?>_html .search_input_div .start{ vertical-align:top;background-image:url(<?php echo get_template_dir(__FILE__);?>img/search_start_bg.png); background-repeat:no-repeat; display:inline-block; vertical-align:top; width:50px; height:50px; line-height:50px;  display:none;}
	#<?php echo $module['module_name'];?>_html .search_input_div .search_middle{vertical-align:top;  display:inline-block;  width:300px; height:40px; line-height:40px; border:#28A03A solid 2px; }
	#<?php echo $module['module_name'];?>_html .search_input_div input{ border:none; height:30px; width:290px; background:none;}
	#<?php echo $module['module_name'];?>_html .search_input_div #imageField{padding: 0px; vertical-align:top; vertical-align:top; margin-left:-3px; display:inline-block; vertical-align:top; width:110px; height:50px; line-height:50px; border-radius:0px;}
	#<?php echo $module['module_name'];?>_html .search_hot_div{ position:relative; line-height:40px; height:40px; overflow:hidden; left:0px;}
	#<?php echo $module['module_name'];?>_html .search_hot_div a{ padding-right:10px;}
    #<?php echo $module['module_name'];?>_html #imageField:hover{opacity:0.5; filter:alpha(opacity=50); }
	
	
	#<?php echo $module['module_name'];?>_html .search_input_div .search_input_div_one {display:inline-block; width:79px; height:40px; line-height:44px; background:#28A03A; text-align:center; size:16px;border:#28A03A solid 2px; border-left:0px; }
	#<?php echo $module['module_name'];?>_html .search_input_div .search_input_div_one a{vertical-align: top;line-height: 36px;}
	#<?php echo $module['module_name'];?>_html .search_input_div .search_input_div_one:hover{background:#ff4000;}
	#<?php echo $module['module_name'];?>_html .search_input_div .search_input_div_two {display:inline-block;  width:80px; height:40px; line-height:48px; background:#444;text-align:center;size:16px; margin-left:2px;}
	#<?php echo $module['module_name'];?>_html .search_input_div .search_input_div_two a{vertical-align: top;line-height: 40px;}
	#<?php echo $module['module_name'];?>_html .search_input_div .search_input_div_two:hover{background:#444044;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="search_input_div"><span class=start> </span><span class="search_middle"><input type="text" name="search" id="search" value="<?php echo @$_GET['search']?>" /></span><div class="search_input_div_one"><a href="./index.php?monxin=mall.shop_goods_list&shop_id=<?php echo $module['shop_id']?>" class=search_shop><?php echo self::$language['search_shop']?></a> </div><div class="search_input_div_two"><a href="./index.php?monxin=mall.goods_list&shop_id=<?php echo  $module['shop_id']?>" class=search_mall><?php echo self::$language['search_mall']?></a></div>
        </div>
        <?php echo $module['hot_search_html'];?>
    </div>
</div>