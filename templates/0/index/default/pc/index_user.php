<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>

$(document).ready(function(){
	
	$("#<?php echo $module['module_name'];?>").css('width',$(".container").width()*0.18);
	$("#<?php echo $module['module_name'];?>").css('top',$("[monxin_slider=1]").offset().top);
	$("#<?php echo $module['module_name'];?>").css('height',$("[monxin_slider=1]").height());
	$("#<?php echo $module['module_name'];?>").css('right',$(window).width()-($("#mall_cart").offset().left+$("#mall_cart").width()));
	$(".r_user_state").html($(".user_info").html());
	if(!$(".user_info #nickname").html()){$(".r_user_state").html('<div class=default_user_icon></div><span class=welcome_to_come><?php echo $module['welcome_to_come']?></span>'+$(".user_info").html());}
	
	$("#<?php echo $module['module_name'];?> .r_article").css('height',$("#<?php echo $module['module_name'];?>").height()-$("#<?php echo $module['module_name'];?> .r_user_state").height()-$("#<?php echo $module['module_name'];?> .r_icons").height()-42);
	$("#<?php echo $module['module_name'];?>").animate({opacity:1});
	$("#<?php echo $module['module_name'];?> #unlogin").click(function(){
		$("#index_top_bar #unlogin").trigger('click');
		return false;
	});	
	
	$(window).resize(function() {
		$("#<?php echo $module['module_name'];?>").css('top',$("[monxin_slider=1]").offset().top);
		$("#<?php echo $module['module_name'];?>").css('height',$("[monxin_slider=1]").height());
		$("#<?php echo $module['module_name'];?>").css('right',$(window).width()-($("#mall_cart").offset().left+$("#mall_cart").width()));
		$("#<?php echo $module['module_name'];?> .r_article").css('height',$("#<?php echo $module['module_name'];?>").height()-$("#<?php echo $module['module_name'];?> .r_user_state").height()-$("#<?php echo $module['module_name'];?> .r_icons").height()-37);
		
	});	
	
	$("#<?php echo $module['module_name'];?> .r_article .list").imgscroll({
		speed: 200,    //图片滚动速度
		amount: 0,    //图片滚动过渡时间
		width: 3,     //图片滚动步数
		dir: "up"   // "left" 或 "up" 向左或向上滚动
	});

});

</script>
<style>
#<?php echo $module['module_name'];?> { height:320px; width:18%; right:5%;  top:225px; border-top:1px solid #ccc; overflow:hidden;white-space:normal; position: absolute; z-index:1; background:rgba(255,255,255,0.97); opacity:0; }
#<?php echo $module['module_name'];?>_html >div{}
#<?php echo $module['module_name'];?> .r_user_state{ text-align:center; padding-bottom:15px;}
#<?php echo $module['module_name'];?> .r_user_state .mall_home{ display:none; }
#<?php echo $module['module_name'];?> .r_user_state .my_order{ display:none; }
#<?php echo $module['module_name'];?> .r_user_state .my_collection{ display:none; }
#<?php echo $module['module_name'];?> .r_user_state #hello{ display:none; }
#<?php echo $module['module_name'];?> .r_user_state a{ display:block; }
#<?php echo $module['module_name'];?> .r_user_state #icon_img{ display:block; margin:auto; width:60px; height:60px; border-radius:30px; margin-top:1rem; border:2px solid #fff; }
#<?php echo $module['module_name'];?> .r_user_state #nickname span{ display:none;}
#<?php echo $module['module_name'];?> .r_user_state #nickname{ line-height:2rem; display:block; vertical-align:top; width:100%; text-align:center;}
#<?php echo $module['module_name'];?> .r_user_state #unlogin{ display:inline-block; vertical-align:top; width:6rem; text-align:center; background:<?php echo $_POST['monxin_user_color_set']['nv_3']['background']?>; color:#fff; border-radius:12px; line-height:1.8rem;}
#<?php echo $module['module_name'];?> .r_user_state a{ margin:0px; padding:0px;}
#<?php echo $module['module_name'];?> .r_user_state a:hover{ color:<?php echo $_POST['monxin_user_color_set']['nv_3']['background']?>; opacity:0.8;}
#<?php echo $module['module_name'];?> .r_user_state a:before{ display:none;}
#<?php echo $module['module_name'];?> .r_user_state .default_user_icon{display:block; margin:auto; width:60px; height:60px; border-radius:30px; margin-top:1rem; background: rgba(237,237,237,1.00);}
#<?php echo $module['module_name'];?> .r_user_state .default_user_icon:before {font: normal normal normal 60px/1 FontAwesome; margin-right: 5px;
    content:"\f2e4"; color:#ccc;}
#<?php echo $module['module_name'];?> .r_user_state #login{ display:inline-block; vertical-align:top; border-radius:12px; box-shadow: 6px 8px 20px rgba(45,45,45,.15); text-align:center; width:5rem; margin-right:5px;}
#<?php echo $module['module_name'];?> .r_user_state #reg_user{ display:inline-block; vertical-align:top; background:<?php echo $_POST['monxin_user_color_set']['nv_3']['background']?>; color:#fff; width:5rem; margin-left:5px;border-radius:12px;}
#<?php echo $module['module_name'];?> .r_user_state .welcome_to_come{ line-height:3rem;}

#<?php echo $module['module_name'];?> .r_article{ padding:10px; height:100px; overflow:hidden; margin-left:1rem;}
#<?php echo $module['module_name'];?> .r_article a:before {font: normal normal normal 3px/0.3 FontAwesome; margin-right: 5px; content: "\f0c8"; color:#ccc; font-size:3px;}

#<?php echo $module['module_name'];?> .r_article a{ display:block;white-space: nowrap; text-overflow: ellipsis; overflow:hidden; line-height:2.5rem; border-bottom:1px dashed #ccc;}
#<?php echo $module['module_name'];?> .r_icons{ padding-top:0.5rem;  }
#<?php echo $module['module_name'];?> .r_icons a{ text-align:center; display:inline-block; vertical-align:top; width:33.33%; overflow:hidden;    }
#<?php echo $module['module_name'];?> .r_icons a:hover{ opacity:0.7;}
#<?php echo $module['module_name'];?> .r_icons a img{ width:40%; }
#<?php echo $module['module_name'];?> .r_icons a span{ display:block; font-size:0.8rem; margin-top:0.5rem; margin-bottom:0.5rem; }
.next_prev{ display:none;}
</style>
    <div id="<?php echo $module['module_name'];?>_html">
		<div class=r_user_state></div>
        <div class=r_article><ul class=list><?php echo $module['article']?></ul></div>
        <div class=r_icons><?php echo $module['menu']?></div>

    </div>
</div>
