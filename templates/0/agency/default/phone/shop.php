<link rel="stylesheet" href="<?php echo get_template_dir(__FILE__);?>/shop_style/<?php echo $module['template']?>/main.css" type="text/css">

<div id="agency_head">
	<img class=store_banner src="./program/agency/banner/<?php echo $module['banner']?>"  />
    <div class="default_value">
        <a class="s_logo" href="index.php?monxin=agency.shop&store_id=<?php echo $_GET['store_id']?>"><img src="program/agency/shop_icon/<?php echo $module['icon']?>"></a><div class=info>
        	<div class=store_name><span class="s_name"><?php echo $module['store_name'];?></span><span class="s_name_postfix"><?php echo self::$language['the_store']?></span> </div>
            <div class=buttons>
            	<a href=# class=goods_type><?php echo self::$language['goods_type']?></a><a href=# class=fav_store><?php echo self::$language['fav_store']?></a><a href=./index.php?monxin=agency.spread&store_id=<?php echo $_GET['store_id']?> class=qr_code><?php echo self::$language['qr_code']?></a>
            </div>
        </div>
         <ul class=store_type><?php echo $module['type_option'];?></ul>
         <div class=fav_store_div><img src=<?php echo get_template_dir(__FILE__);?>/img/favorite.png></div>
         <?php echo $module['set_button'];?>
    </div>
   
</div>    

<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		type=get_param('type');
		if(type==''){type=0;}
		$(".default_value .buttons .goods_type").html($(".default_value .store_type li[type="+type+"] a").html());
		
		$(".default_value .buttons .goods_type").click(function(){
			if($(".default_value .store_type").css('display')=='none'){
				$(".default_value .store_type").css('display','block');
			}else{
				$(".default_value .store_type").css('display','none');
			}
			
			return false;
		});
		$(".default_value .buttons .fav_store").click(function(){
			if(isWeiXin()){
				$(".default_value .fav_store_div").css('display','block');
				
			}else{
				alert('<?php echo self::$language['in_weixin_use'];?>');	
			}
			return false;
		});
		$(".default_value .fav_store_div").click(function(){
			$(".default_value .fav_store_div").css('display','none');
			return false;
		});
		
		
		$.get("<?php echo $module['count_url']?>");
    });
	
    </script>
    
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=1>
    
    <div class=goods_list><?php echo $module['list'];?></div>
    <?php echo $module['page']?>

    </div>
    
</div>

