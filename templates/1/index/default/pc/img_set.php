<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
	var replace_file='';
    $(document).ready(function(){
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			$("img[src='"+replace_file+"']").attr('src',replace_file+"?&reflash="+Math.random());
			return false;
		});
		$('.replace').click(function(){
			replace_file=$(this).attr('file');
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','index.php?monxin=index.replace_file&path='+replace_file+'&width='+$(this).attr('img_width')+'&height='+$(this).attr('img_height'));
			return false;	
		});
		
            
    });
    </script>
    

    <style>
	#<?php echo $module['module_name'];?>_html{ }
	#<?php echo $module['module_name'];?> fieldset{ margin:20px; display:inline-block; text-align:center;}
	#set_monxin_iframe_div{top:40%; left:420px; }
	#monxin_iframe{ height:100px;width:500px;}
	legend{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    	<fieldset><legend><?php echo self::$language['web_logo'];?>(400*150 png) <a href=# class="replace" file='./logo.png' img_width='400' img_height='150' ><?php echo self::$language['replace'];?></a></legend>
        <img src="./logo.png">
        </fieldset>
    	<fieldset><legend><?php echo self::$language['white'];?><?php echo self::$language['web_logo'];?>(400*150 png) <a href=# class="replace" file='./white_logo.png' img_width='400' img_height='150' ><?php echo self::$language['replace'];?></a></legend>
        <img src="./white_logo.png">
        </fieldset>
    	<fieldset><legend><?php echo self::$language['phone_logo'];?>(360*160 png) <a href=# class="replace" file='./phone_logo.png' img_width='360' img_height='160' ><?php echo self::$language['replace'];?></a></legend>
        <img src="./phone_logo.png">
        </fieldset>
    	<fieldset><legend><?php echo self::$language['web_icon'];?>(128*128 ico) <a href=# class="replace" file='./favicon.ico' img_width='' img_height='' ><?php echo self::$language['replace'];?></a></legend>
        <img src="./favicon.ico" width="128px">
        </fieldset>
    	<fieldset><legend><?php echo self::$language['pc_user_position_icon'];?>(25*25 png) <a href=# class="replace" file='./pc_user_position_icon.png' img_width='25' img_height='25' ><?php echo self::$language['replace'];?></a></legend>
        <img src="./pc_user_position_icon.png">
        </fieldset>
    
    	<fieldset><legend><?php echo self::$language['phone_user_position_icon'];?>(50*50 png) <a href=# class="replace" file='./phone_user_position_icon.png' img_width='50' img_height='50' ><?php echo self::$language['replace'];?></a></legend>
        <img src="./phone_user_position_icon.png">
        </fieldset>
    
    	<fieldset><legend><?php echo self::$language['qr_icon'];?>(28*28 png) <a href=# class="replace" file='./qr_icon.png' img_width='28' img_height='28' ><?php echo self::$language['replace'];?></a></legend>
        <img src="./qr_icon.png">
        </fieldset>
    
    	<fieldset><legend><?php echo self::$language['qr_icon'];?>(32*32 png) <a href=# class="replace" file='./plugin/qrcode/qr_logo.png' img_width='32' img_height='32' ><?php echo self::$language['replace'];?></a></legend>
        <img src="./plugin/qrcode/qr_logo.png">
        </fieldset>
    
    	<fieldset><legend><?php echo self::$language['login_bg'];?>(png) <a href=# class="replace" file='./login_bg.png' img_width='0' img_height='0' ><?php echo self::$language['replace'];?></a></legend>
        <img src="./login_bg.png" style="width:100%;">
        </fieldset>
        
    	<fieldset><legend><?php echo self::$language['regist_bg'];?>(png) <a href=# class="replace" file='./regist_bg.png' img_width='0' img_height='0' ><?php echo self::$language['replace'];?></a></legend>
        <img src="./regist_bg.png" style="width:100%;">
        </fieldset>
    </div>
</div>
