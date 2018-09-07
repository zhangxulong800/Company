<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>

$(document).ready(function(){
	$(".user_aera").html($(".user_info").html());
	$("#<?php echo $module['module_name'];?> #unlogin").on('click',function(){
		$("#index_top_bar #top_bar #unlogin").trigger('click');
		return false;

	});
	
	$(window).scroll(function(){
		if($(window).scrollTop()>$(window).height()){
			$("#<?php echo $module['module_name'];?>").css('display','block');
		}else{
			$("#<?php echo $module['module_name'];?>").css('display','none');
		}	
			
	});
	
	$("#<?php echo $module['module_name'];?> .top_search").attr('placeholder',$("#search").attr('placeholder'));
	
	$("#<?php echo $module['module_name'];?> .search_area .search_b").click(function(){
		if($("#<?php echo $module['module_name'];?> .top_search").val()==''){return false;}
		window.location.href='./index.php?monxin=mall.goods_list&search='+$("#<?php echo $module['module_name'];?> .top_search").val();
		return false;
	});
	
	
	$("#<?php echo $module['module_name'];?> .top_search").keyup(function(event){
		if(event.keyCode==13 && $(this).val()!=''){
			window.location.href='./index.php?monxin=mall.goods_list&search='+$("#<?php echo $module['module_name'];?> .top_search").val();
		}
	});
	
});

</script>
<style>
#<?php echo $module['module_name'];?>{ z-index:99999999; width:100%; background:rgba(255,255,255,0.96); ; position:fixed; top:0px;    box-shadow: rgba(0,0,0,.2) 0 1px 5px; height:50px; overflow:hidden; display:none;}
#<?php echo $module['module_name'];?>_html >div{ display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?> .logo_area{ display:inline-block; vertical-align:top; width:30%; overflow:hidden;}	
#<?php echo $module['module_name'];?> .logo_area img{ width:250px; margin-top:-24px;}	
#<?php echo $module['module_name'];?> .logo_area img:hover{ opacity:0.9;}

#<?php echo $module['module_name'];?> .search_area{ display:inline-block; vertical-align:top; width:40%; overflow:hidden;}	
#<?php echo $module['module_name'];?> .search_area .search_div{ height:34px; line-height:34px; border:1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; margin-top:8px;}

#<?php echo $module['module_name'];?> .search_area .search_div input{height:32px; line-height:32px; display:inline-block; vertical-align:top; width:85%; overflow:hidden;}
#<?php echo $module['module_name'];?> .search_area .search_div a{ height:34px; line-height:34px;display:inline-block; vertical-align:top; width:15%; overflow:hidden; text-align:center; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; cursor:pointer;}
#<?php echo $module['module_name'];?> .search_area .search_div a:hover{ opacity:0.9;}
#<?php echo $module['module_name'];?> .user_aera{width:30%;line-height:45px; text-align:right; padding-right:30px;}
#<?php echo $module['module_name'];?> .user_aera a{ display:inline-block; vertical-align:top; line-height:45px;}
#<?php echo $module['module_name'];?> .user_aera #icon_img{ margin-top:10px;line-height:50px;}
#<?php echo $module['module_name'];?> .user_aera .top_a{ display:none;}
#<?php echo $module['module_name'];?> .user_aera #icon_a{ }
#<?php echo $module['module_name'];?> .user_aera #nickname{ }
#<?php echo $module['module_name'];?> .user_aera #unlogin{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; display:inline-block; vertical-align:top; line-height:30px; height:30px; padding-left:1rem; padding-right:1rem; margin-top:8px; border-radius:3px; }
#<?php echo $module['module_name'];?> .user_aera #unlogin:before{ display:none;}
#<?php echo $module['module_name'];?> .user_aera #login{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?> .user_aera #login:before{ display:none;}
#<?php echo $module['module_name'];?> .user_aera #reg_user{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; display:inline-block; vertical-align:top; line-height:30px; height:30px; padding-left:1rem; padding-right:1rem; margin-top:8px; border-radius:3px; }
#<?php echo $module['module_name'];?> .user_aera #reg_user:before{ display:none;}

</style>
    <div id="<?php echo $module['module_name'];?>_html" class="container">
		<a href="./index.php" class=logo_area><img src=logo.png /></a><div class=search_area><div class=search_div><input type=text class=top_search  /><a class=search_b><?php echo self::$language['search']?></a></div></div><div class=user_aera>
        	
        </div>
    </div>
</div>
