<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" >
<style>
li[pw='0']{ display:none !important;}
html,body{ height:100%; overflow:hidden; white-space:nowrap;}
.page-container{ background:rgba(239,243,238,1) !important;}
.page-header{ display:inline-block; vertical-align:top; width:14%;  height:100%; overflow:hidden;}
.page-container{display:inline-block; vertical-align:top; width:88%; margin-left:-5px; overflow:scroll; overflow-x:hidden;height:100%; padding-right:5%; }
.page-container .page-content{ width:100%; white-space:normal; }
.page-container .container{ width:100% !important; }
.page-footer{ display:none;}
#index_user_position{}
.page-header .container{ width:100%;}


#index_admin_nv{ width:108%; height:100%; overflow:scroll; overflow-x:hidden;}
.page-header-top .container{}
.page-header-top .container .page-logo{ display:block; text-align:center; background:rgba(69,66,70,1);; border-bottom:1px dashed #ccc;}
.page-header-top .container .page-logo .logo img{ border:none; width:90%; }
.page-header-top .container .top-menu{ display:block; }


.page-header-top{}
.page-header-top .page-logo{ height:100%;}
.page-header-top .page-logo img{ height:95%;}
.page-header-top .top-menu{ text-align:right;}
.page-header-top .top-menu a{color:#fff; opacity:0.7;}
.page-header-top .top-menu a:hover{ opacity:0.8;}
.page-header-top .top-menu > ul{ white-space:nowrap; position:relative; }
.page-header-top .top-menu > ul li{ display:block;}
.page-header-top .top-menu > ul li:hover ul{ display:block;}
.page-header-top .top-menu > ul li ul{ position:absolute; margin-left:150px;line-height:30px; box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1);
border: 0 !important;
border-radius: 2px;  z-index:999999099;text-align:left; }
.page-header-top .top-menu > ul li li{ display:block;padding-left:10px; padding-right:10px; }
.page-header-top .top-menu > ul li li a{ display:block; }
.page-header-top .top-menu > ul li li a i{ padding-right:5px;}
.page-header-top .top-menu > ul li li:hover{background:rgba(69,66,70,1); !important;   }
.page-header-top .top-menu > ul li li:hover a{ color:#fff; !important; }
.page-header-top .top-menu .user_msg a{ display:none; padding-left:5px; padding-right:5px; height:20px; line-height:20px; text-align:center;  margin-top:26px; font-weight:bold; min-width:20px;}
.page-header-top .top-menu .user_msg a:hover{ }
.page-header-top .top-menu .user_msg a:before{ font: normal normal normal 1rem/1 FontAwesome; content:"\f1d7"; padding-right:3px; }
.page-header-top .top-menu .user_info{ margin-top:0.5rem; padding-bottom:0.5rem;}
.page-header-top .top-menu .user_info > a{ text-align:center; display:block;}
.page-header-top .top-menu .user_info > ul{ display:none;}
.page-header-top .top-menu .user_info > a > img{ height:50px; width:50px; border-radius:25px;}
.page-header-top .top-menu .unlogin a{ }
.page-header-top .top-menu .unlogin span:before{font: normal normal normal 14px/1 FontAwesome;margin-right:5px;content:"\f08b";}
.user_edit_list{ background-color:#fff; color:#000; }

.page-logo{ display:block;}
.user_info_a{ text-align:center;}
.username{ display:block;}
.username .nickname{ width:80%; overflow:hidden; display:inline-block; vertical-align:top; white-space:nowrap;    white-space: nowrap;text-overflow: ellipsis;}
.user_edit_list{ display:none; position:absolute; top:50px; left:180px;}
.user_edit_list li{ list-style:none; }
.search_div{ margin-left:1rem;margin-right:1rem;line-height:25px; height:25px;border-radius:3px; border:1px solid #ccc;background:rgba(95,95,97,1);}
.search_div .search{ width:85%; line-height:20px; height:20px;  color:#fff; border:none;background:rgba(95,95,97,1);}
.search_div .search_button:before{font: normal normal normal 14px/1 FontAwesome;margin-right:5px;content:"\f002"; color:#ccc;}
.search_div .search_button{}
.search_div .search_button:hover{ opacity:0.8;}
</style>

<div class="page-header-top">
		<div class="container" style="z-index:9999999999;">
			<div class="page-logo">
				<a href="./index.php" class=logo><img src="./white_logo.png"></a>
			</div><div class="top-menu">
				<ul>
					<li class="user_info">
                    	<span class="fadeIn animated infinite  user_msg "><a href="./index.php?monxin=index.site_msg_addressee"></a></span>
                    	<a href="./index.php?monxin=index.user" class="user_info_a">
                            <img alt="" class="user_icon" src="./program/index/user_icon/default.png">
                            <span class="username username-hide-mobile"><span class=nickname></span> <i class="unlogin"><span href="./receive.php?target=index::user&act=unlogin" class="icon-logout" title="<?php echo self::$language['unlogin']?>"></span></i></span> 
						</a>
						
					</li>
				</ul>
			</div>
		</div>
	</div>
    <div class=search_div><input type="text" class=search placeholder="<?php echo self::$language['search']?>" /><a class=search_button></a></div>
    <div class=search_result_div></div>
<script>
    str='<?php echo $module['user_json']?>';
var user_info=eval("("+str+")"); 
 jQuery(document).ready(function() {
	 $("#<?php echo $module['module_name'];?> .username").hover(function(){
		if($("#<?php echo $module['module_name'];?> .user_edit_list").css('display')=='none'){
			$("#<?php echo $module['module_name'];?> .user_edit_list").css('display','block');
		}else{
			$("#<?php echo $module['module_name'];?> .user_edit_list").css('display','none');
		}
		 
	});
	 
	if($(".newest_user_msg").html()){
		user_info.msg=parseInt($(".newest_user_msg").html());
	}	
	 
	 if(user_info.msg>0){
		if($(".user_info .msg_div .user_msg").attr('href')){
			$(".user_info .user_msg").html(user_info.msg).css('display','block');
		}else{
			
			$(".user_msg a").html(user_info.msg).css('display','block');
		}
		
	 }else{$(".user_msg").css('display','none');}   
	  
     $('.user_info .nickname').html(user_info.nickname+'/'+user_info.group);
     $('.user_info .user_icon').attr('src',user_info.icon);   
     $('.unlogin span').click(function(){
        $.get($(this).attr('href'),function(data){unlogin(data);});
        return false;
     });
     $('.unlogin').click(function(){
        $.get($(this).attr('href'),function(data){unlogin(data);});
        return false;
     });
  });   
</script>










<script type="text/javascript">
var a_index=0;
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?> .nv ul li").hover(function(){
		if($("html").attr('browser')=='Edge'){
			$(this).children('ul').css('left',$(this).width()+7);	
		}else{
			$(this).children('ul').css('left',$(this).width()+12);	
		}
		
		if($(this).offset().top>$(window).height()*0.5 ){		
			$(this).children('ul').css('bottom',$(window).height()-$(this).offset().top-42);
			//$(this).children('ul').css('bottom','0px');
		}else{
			$(this).children('ul').css('top',$(this).offset().top);
		}
		
		if($(this).children('.more_ul').attr('class')){
			if(!$(this).children('.more_ul').attr('BlocksIt')){
				$("#<?php echo $module['module_name'];?> .more_ul").BlocksIt({
					numOfCol: 5,
					offsetX: 8,
					offsetY: 8,
					blockElement: 'li'
				});
				$(this).children('.more_ul').attr('BlocksIt','1');
			}
		}
	});
	$("#<?php echo $module['module_name'];?> .search").keydown(function(event){
		if(event.keyCode==13){
			if($("#<?php echo $module['module_name'];?> .search_result_div .current").attr('href')){
				window.location.href=$("#<?php echo $module['module_name'];?> .search_result_div .current").attr('href');
			}else{
				if($("#<?php echo $module['module_name'];?> .search_result_div a:first").attr('href')){
					window.location.href=$("#<?php echo $module['module_name'];?> .search_result_div a:first").attr('href');
				}
				
			}
			
		}
		if(event.keyCode==38){
			$("#<?php echo $module['module_name'];?> .search_result_div a").removeClass('current');
			if(a_index<0){a_index=$("#<?php echo $module['module_name'];?> .search_result_div a").length-1;}
			if($("#<?php echo $module['module_name'];?> .search_result_div a").length<a_index+1){
				a_index=0;
			}
			$("#<?php echo $module['module_name'];?> .search_result_div a").eq(a_index).addClass('current');
			a_index--;
		}
		if(event.keyCode==40){
			$("#<?php echo $module['module_name'];?> .search_result_div a").removeClass('current');
			if(a_index<1){a_index=0;}
			if($("#<?php echo $module['module_name'];?> .search_result_div a").length<a_index+1){
				a_index=0;
			}
			$("#<?php echo $module['module_name'];?> .search_result_div a").eq(a_index).addClass('current');
			a_index++;
		}
		
	});
	
	$("#<?php echo $module['module_name'];?> .search").keyup(function(event){
		if(event.keyCode==38 || event.keyCode==40){return false;}
		key=$(this).val();
		str='';
		if(key==''){
			
		}else{
			$("#<?php echo $module['module_name'];?> .nv_ul span").each(function(index, element) {
				if($(this).html().indexOf(key)!=-1){
					str+='<a href='+$(this).parent().attr('href')+'>'+$(this).html()+'</a>';
				}
			});
		}
		$("#<?php echo $module['module_name'];?> .search_result_div").html(str);
	});
	
	$("#<?php echo $module['module_name'];?> .search_result_div").css('width',$("#<?php echo $module['module_name'];?> .search").width()+7);
	
	if(!get_param('edit_page_layout')){
		$(".page-container .page-content .container").prepend($("#index_user_position"));
	}else{
		$("#index_user_position").css('display','none');
		$(".page-header").prepend($("#index_user_position"));
	}
	
	
	$("#index_admin_nv").width($(".page-header").width()+18);
	
	$(window).resize(function() {
		$("#index_admin_nv").width($(".page-header").width()+18);
	});	
	
	
});
</script>
<style>

#<?php echo $module['module_name'];?>  { text-align:left; background:rgba(69,66,70,1);;}
#<?php echo $module['module_name'];?> .nv{ padding-bottom:2rem; padding-top:0.5rem;}
#<?php echo $module['module_name'];?> .nv li{ list-style:none; }
#<?php echo $module['module_name'];?> .nv_ul > li > a{ white-space:nowrap; color:#fff; opacity:0.7; }
#<?php echo $module['module_name'];?> .nv_ul > li{ border-bottom:1px solid rgba(54,54,59,1) !important;}
#<?php echo $module['module_name'];?> .nv a img{ height:1.8rem;}
#<?php echo $module['module_name'];?> .nv .nv_ul{}
#<?php echo $module['module_name'];?> .nv ul li{ line-height:3rem;padding-left:1rem; height:3rem; overflow:hidden;}
#<?php echo $module['module_name'];?> .nv ul  ul {display: none; position:absolute; left:150px; width:600px; max-height:60%;  white-space:normal; background:rgba(95,95,97,1); color:#fff; overflow:scroll; overflow-x:hidden; z-index:999;    box-shadow: 2px 1px 2px 2px rgba(0, 0, 0, 0.1); }
#<?php echo $module['module_name'];?> .nv ul  ul>li{ display:inline-block; vertical-align:top; width:25%; }
#<?php echo $module['module_name'];?> .nv ul  ul>li i{ display:none;}
#<?php echo $module['module_name'];?> .nv ul li span{ color:#fff; padding-left:0.5rem;}
#<?php echo $module['module_name'];?> .nv ul  ul ul { display:block !important; box-shadow:none; border:dashed 1px #fff; padding-right:5px; border-radius:3px;}
#<?php echo $module['module_name'];?> .nv ul li:hover{background:rgba(95,95,97,1); }
#<?php echo $module['module_name'];?> .nv ul li:hover >a{ opacity:1; }
#<?php echo $module['module_name'];?> .nv ul li:hover > ul {display: block;}
#<?php echo $module['module_name'];?> .nv ul  ul>li:hover > a >span{ opacity:0.8;}
#<?php echo $module['module_name'];?> .nv ul li .fa-angle-down{float:right; line-height:3rem; opacity:0.6;}
#<?php echo $module['module_name'];?> .nv ul li .fa-angle-down:before{content:"\f105"; padding-right:10px; }
#<?php echo $module['module_name'];?> .nv a{ white-space:nowrap; overflow:hidden;}
[m_container='m_container']{ padding-left:1rem;}

#<?php echo $module['module_name'];?> .nv ul  .more_ul{ width:800px; height:800px !important; overflow:scroll; overflow-x:hidden; }
#<?php echo $module['module_name'];?> .nv ul  .more_ul ul{ display:block !important; position:static !important; width:100%; overflow:hidden;}
#<?php echo $module['module_name'];?> .nv ul  .more_ul ul li{ display:block; width:100%;}

#<?php echo $module['module_name'];?> .user_icon{}
#<?php echo $module['module_name'];?> .search_result_div{ margin-left:1rem; background-color:#fff; width:79%; overflow:hidden;}
#<?php echo $module['module_name'];?> .search_result_div a{ display:block; line-height:2rem; padding-left:5px;}
#<?php echo $module['module_name'];?> .search_result_div a:hover{ background:rgba(95,95,97,1); color:#fff;}
#<?php echo $module['module_name'];?> .search_result_div{}
#<?php echo $module['module_name'];?> .search_result_div .current{background:rgba(95,95,97,1); color:#fff;}

</style>

<div class=nv>
	<div class="container"><ul class=nv_ul ><li><a href=index.php><img src="./templates/1/index/default/page_icon/index.index.png" /> <span><?php echo self::$language['go_home']?></span></a></li><li><a href=./index.php?monxin=index.personal_center><img src="./templates/1/index/default/page_icon/index.personal_center.png" /><span><?php echo self::$language['personal_center']?></span><i class="fa fa-angle-down"></i></a><ul>
    <li><a href="./index.php?monxin=index.edit_user"><span><?php echo self::$language['pages']['index.edit_user']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.openid"><span><?php echo self::$language['pages']['index.openid']['name']?></span></a></li>							
    <li><a href="./index.php?monxin=index.edit_phone"><span><?php echo self::$language['pages']['index.edit_phone']['name']?></span></a></li>							
    <li><a href="./index.php?monxin=index.edit_email"><span><?php echo self::$language['pages']['index.edit_email']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.edit_user&field=password"><span><?php echo self::$language['pages']['index.edit_user&field=password']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.edit_user&field=transaction_password"><span><?php echo self::$language['pages']['index.edit_user&field=transaction_password']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.site_msg_addressee"><span><?php echo self::$language['pages']['index.site_msg_addressee']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.login_log"><span><?php echo self::$language['pages']['index.login_log']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.user_set"><span><?php echo self::$language['pages']['index.user_set']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.my_oauth"><span><?php echo self::$language['pages']['index.my_oauth']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.financial_center"><span><?php echo self::$language['pages']['index.financial_center']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.credits_log"><span><?php echo self::$language['pages']['index.credits_log']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.my_recommend_qr"><span><?php echo self::$language['pages']['index.my_recommend_qr']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.my_user_qr"><span><?php echo self::$language['pages']['index.my_user_qr']['name']?></span></a></li>
    <li><a href="./index.php?monxin=index.my_pay_qr"><span><?php echo self::$language['pages']['index.my_pay_qr']['name']?></span></a></li>
</ul></li><?php echo $module['map'];?></ul>
	</div></div>
</div>

        
</div>