    $(document).ready(function(){
		circle=get_param('circle');
		if(circle==''){circle=getCookie('circle');}
		$(".circle_list_for_position a[circle='"+circle+"']").addClass('c');
		if(circle!=0){
			setCookie('circle',circle,30);
			$(".circle_position").html($(".circle_list_for_position a[circle='"+circle+"']").html());
			
			//$(".circle_list_for_position .circle_head .c_head_name .sub_name").addClass('current')
			if($(".circle_list_for_position .c").parent().attr("class")=='sub_c'){
				$(".circle_list_for_position .sub_name").html($(".circle_position").html());
				p_id=$(".circle_list_for_position .c").parent().attr("id").replace('sub_c_','');
				$(".circle_list_for_position a[circle='"+p_id+"']").addClass('c');
				$(".circle_list_for_position .parent_name").html($(".circle_list_for_position a[circle='"+p_id+"']").html());
				$(".circle_list_for_position .c").parent().css('display','block');
			}else{
				$(".circle_list_for_position .parent_name").html($(".circle_position").html());
			}
		}else{
			setCookie('circle',0,30);
			$(".circle_position").html('<?php echo self::$language['location']?>');
		}
		
		
		
		$(".circle_list_for_position .circle_head .head_close a").click(function(){
			$(".circle_list_for_position").css('display','none');
			$(".circle_position").removeClass('c_show');
			return false;
		});
		
		$(".circle_position").click(function(){
			$(".circle_list_for_position").css('left',$(this).offset().left-7);
			$(".circle_list_for_position").css('top','2.4rem');
			if($(".circle_list_for_position").css('display')=='none'){
				$(".circle_list_for_position").css('display','block');
				$(this).addClass('c_show');
			}else{
				$(".circle_list_for_position").css('display','none');
				$(this).removeClass('c_show');
			}
			return false;
		});
		
		$(".circle_list_for_position .circle_head .c_head_name a").click(function(){
			$(".circle_list_for_position .circle_head .c_head_name a").removeClass('current');
			$(this).addClass('current');
			
			if($(this).attr('d')=='parent'){
				$(".circle_parent").css('display','block');
				$(".circle_sub").css('display','none');
			}else{
				$(".circle_parent").css('display','none');
				$(".circle_sub").css('display','block');
			}
			return false;
		});
		
		$(".circle_list_for_position .circle_parent a").click(function(){
			setCookie('circle',$(this).attr('circle'),30);
			if($(".circle_sub #sub_c_"+$(this).attr('circle')).html().length>10){
				$(".circle_parent").css('display','none');
				$(".circle_sub").css('display','block');
				$(".circle_sub .sub_c").css('display','none');
				$(".circle_sub #sub_c_"+$(this).attr('circle')).css('display','block');
				$(".parent_name").html($(this).html());
				$(".sub_name").html('<?php echo  self::$language['please_select']?>');
				$(".circle_list_for_position .circle_head .c_head_name a").removeClass('current');
				$(".circle_list_for_position .circle_head .c_head_name .sub_name").addClass('current');
				
			}else{
				url=window.location.href;
				url=replace_get(url,'circle',$(this).attr('circle'));
				window.location.href=url;
			}
			return false;
		});
		$(".circle_list_for_position .circle_sub a").click(function(){
			setCookie('circle',$(this).attr('circle'),30);
            url=window.location.href;
            url=replace_get(url,'circle',$(this).attr('circle'));
            window.location.href=url;
            return false;
		});
				

		
		
    });


document.write("<div id=<?php echo $module['module_name'];?> monxin-module='<?php echo $module['module_name'];?>' align=center >"+
	"<style>"+
    "#<?php echo $module['module_name'];?>{ background-color:rgba(237,233,233,1); width:100%; border-bottom: #e6e6e6 solid 1px;}"+
    "#<?php echo $module['module_name'];?> #top_bar{ background-color:rgba(237,233,233,1);  margin:auto;  position:relative;  z-index:999; clear:both; text-align:left; line-height:2.5rem; height:2.5rem; margin-left:auto; margin-right:auto;}"+
    "#<?php echo $module['module_name'];?> #top_bar .top_left{display:inline-block; vertical-align:top;width:39%; font-size:1rem; padding-left:1%; overflow:hidden; text-align:left; }"+
    "#<?php echo $module['module_name'];?> #top_bar .user_info{ width:60%; overflow:hidden; text-align:right;display:inline-block; vertical-align:top;}"+
    "#<?php echo $module['module_name'];?> #top_bar .user_info .top_a{ display:inline-block; vertical-align:top;}"+
    "#<?php echo $module['module_name'];?> #top_bar .user_info .top_a a{ display:inline-block; vertical-align:top; margin-right:1.5rem;}"+
    "#<?php echo $module['module_name'];?> #top_bar .user_info .top_a .mall_home:before{font: normal normal normal 1.2rem/1 FontAwesome;margin-right:1px;content:'\\f015'; opacity:0.7; padding-top:4px;}"+
    "#<?php echo $module['module_name'];?> #top_bar .icon{ height:26px; vertical-align:middle;}"+
    "#<?php echo $module['module_name'];?> #top_bar a{ display:inline-block; margin-right:0px; vertical-align:top;}"+
	" #login{ height:25px; font-size:1rem; text-align:left;  margin-left:10px;}"+
	" #login:before{font: normal normal normal 18px/1 FontAwesome;margin-right:5px;content:'\\f007';}"+
	" #reg_user{ height:25px; font-size:1rem;  margin-left:10px;}"+
	" #reg_user:before{font: normal normal normal 18px/1 FontAwesome;margin-right:5px;content:'\\f040';}"+
	"#<?php echo $module['module_name'];?> #print_a{ display:none; }"+
	" #icon_a{ margin-right:0px; }"+
	" #icon_img{ display:block; height:1.8rem;width:1.8rem;border-radius:0.9rem; border:#FFF 2px solid; margin-top:0.3rem;}"+
	" #nickname{ margin-left:0px;padding-left:0px; font-size:1rem;}"+
	" #unlogin{ font-size:1rem; text-align:left;}"+
	" #unlogin:before{font: normal normal normal 18px/1 FontAwesome;margin-right:5px;content:'\\f08b';}"+
	"#<?php echo $module['module_name'];?> #hello{ font-size:1rem;vertical-align:top;}"+
	"#<?php echo $module['module_name'];?> #msg_show{ margin-left:10px;  text-align:left;font-size:1rem; color: #F60; font-weight:bold;}"+
	"#<?php echo $module['module_name'];?> #msg_show:before{font: normal normal normal 1rem/1 FontAwesome;margin-right:2px;content:'\\f1d7';}"+
	"#<?php echo $module['module_name'];?> .circle_position:before{font: normal normal normal 1rem/1 FontAwesome;margin-right:5px;content:'\\f041'; opacity:0.7;color:#fa0;}"+
	"#<?php echo $module['module_name'];?> .circle_position:after{font: normal normal normal 1rem/1 FontAwesome;margin-left:5px;;content:'\\f107  ';padding-right:1rem;}"+
	".circle_position{ display:inline-block; vertical-align:top;  cursor:pointer; padding-left:0.5rem; }"+
	".circle_position:hover{ background-color:#fff;}"+
	".c_show{ background-color:#fff;}"+
	".c_show span{ background-color:#fff;}"+
	".circle_position:hover >span{  background-color:#fff; display:inline-block;}"+
	".circle_position:hover .circle_position_list{ display:block;}"+
	"#index_top_bar #top_bar .welcome{ display:inline-block; vertical-align:top; width:35%; opacity:<?php echo $module['welcome_opacity']?>;}"+
	".circle_position img{ display:none;}"+
	".circle_position_list{ display:none;}"+
	".circle_position_list .list_in{ width:120%;height:190px; overflow-y: scroll; line-height:2rem; }"+
	".circle_list_for_position{ position:absolute; top:2.4rem; width:600px; height:190px; background:#fff;   margin-left:0.5rem;overflow:hidden; text-align:left;box-shadow: 0px 2px 4px rgba(0,0,0,.3);  z-index:999999; display:none;}"+
	".circle_list_for_position .circle_head{ white-space:nowrap; padding-left:1.5rem; padding-top:5px; height:30px; z-index:999999; }"+
	".circle_list_for_position .circle_head .c_head_name{ display:inline-block; vertical-align:top; width:80%; overflow:hidden;}"+
	".circle_list_for_position .circle_head .c_head_name a{ float:left; line-height:24px; display:inline-block; vertical-align:top; background:#fff; padding-left:0.5rem; padding-right:0.5rem; cursor:pointer;}"+
	".circle_list_for_position .circle_head .parent_name{ border:1px rgba(237,233,233,1) solid; margin-right:2rem; }"+
	".circle_list_for_position .circle_head .sub_name{ border:1px rgba(237,233,233,1)  solid; }"+
	".circle_list_for_position .circle_head .c_head_name .current{ line-height:25px; z-index:9999;border-bottom:0px;}"+
	".circle_list_for_position .circle_head .head_close{display:inline-block; vertical-align:top;width:20%; overflow:hidden; text-align:right;}"+
	".circle_list_for_position .circle_head .head_close a{ font-size:1.6rem; padding-right:5px; cursor:pointer;}"+
	".circle_list_for_position .circle_head .head_close a:before2 {font: normal normal normal 14px/1 FontAwesome;margin-right: 5px; content: '\\f00d'; font-weight:100;}"+
	".circle_list_for_position .circle_head .head_close a:hover{ color:red;}"+
	".circle_list_for_position .circle_parent{border-top:1px rgba(237,233,233,1) solid; white-space:normal; padding-left:1rem; padding-top:0.5rem;}"+
	".circle_list_for_position .circle_parent a{ display:inline-block; vertical-align:top; width:5rem; overflow:hidden; white-space:nowrap;text-overflow: ellipsis; line-height:2rem; }"+
	".circle_list_for_position .circle_parent a:hover{ color:red;}"+
	".circle_list_for_position .circle_sub a:hover{ color:red;}"+
	".circle_list_for_position .circle_sub{border-top:1px rgba(237,233,233,1) solid; display:none; padding-left:1rem;padding-top:0.5rem;}"+
	".circle_list_for_position .circle_sub .sub_c{ display:none; white-space:normal;}"+
	".circle_list_for_position .circle_sub .sub_c a{ display:inline-block; vertical-align:top; width:5rem; overflow:hidden; white-space:nowrap;text-overflow: ellipsis; line-height:2rem; }"+
	".circle_list_for_position .c span{ background-color:#fa0; color:#fff; padding: 0 4px;    border-radius: 4px;}"+
    "</style>"+    
    "<div id=top_bar class=container><span class=top_left><?php echo $module['circle']?><span class=welcome><?php echo $module['top_welcome_info'];?></span></span><span class=user_info><div class=top_a><a href=./index.php class=mall_home><?php echo self::$language['mall_home']?></a><a href=index.php?monxin=mall.my_order class=my_order><?php echo self::$language['my_order']?></a><a href=index.php?monxin=mall.my_collect class=my_collection><?php echo self::$language['my_collection']?></a></div>"+
    <?php echo $module['data'];?>
    +"</span></div>"+ 
"</div>");
document.write("<?php echo  $module['circle_list'];?>");