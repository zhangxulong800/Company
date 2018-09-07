<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" >

<style>

.page-header-top{text-align:left; height:5.35rem; line-height:5.35rem;}
.page-header-top .container{}
.page-header-top .container .page-logo{ display:inline-block; vertical-align:top;  width:60%; }
.page-header-top .container .page-logo .logo img{ border:none; width:225px;}
.page-header-top .container .page-logo .head_diy_container{ display:inline-block; vertical-align:top;}
.page-header-top .container .top-menu{ display:inline-block; vertical-align:top;  width:40%; ;}



.page-header-top{ height:75px; line-height:75px;}
.page-header-top .page-logo{}
.page-header-top .top-menu{ text-align:right;}
.page-header-top .top-menu a{}
.page-header-top .top-menu > ul{ white-space:nowrap; position:relative; }
.page-header-top .top-menu > ul li{ display:inline-block;list-style:none; vertical-align:top;}
.page-header-top .top-menu > ul li:hover ul{ display:block;}
.page-header-top .top-menu > ul li ul{ position:absolute; margin-left:50px;line-height:30px; box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1);
border: 0 !important;
border-radius: 2px;  z-index:999999099;text-align:left; }
.page-header-top .top-menu > ul li li{ display:block;padding-left:10px; padding-right:10px; }
.page-header-top .top-menu > ul li li a{ display:block;}
.page-header-top .top-menu > ul li li a i{ padding-right:5px;}
.page-header-top .top-menu > ul li li:hover{  }
.page-header-top .top-menu > ul li li:hover a{  }
.page-header-top .top-menu .user_msg a{ display:none; padding-left:5px; padding-right:5px; height:20px; line-height:20px; text-align:center;  margin-top:26px; font-weight:bold; min-width:20px;}
.page-header-top .top-menu .user_msg a:hover{ opacity:0.8;}
.page-header-top .top-menu .user_msg a:before{ font: normal normal normal 1rem/1 FontAwesome; content:"\f1d7"; padding-right:3px; }
.page-header-top .top-menu .user_info > a{}
.page-header-top .top-menu .user_info > ul{ display:none;}
.page-header-top .top-menu .user_info > a > img{ height:40px; width:40px; border-radius:20px;}
.page-header-top .top-menu .unlogin a{ }
.page-header-top .top-menu .unlogin a:before{font: normal normal normal 18px/1 FontAwesome;margin-right:5px;content:"\f08b";}
</style>

<div class="page-header-top">
		<div class="container" style="z-index:9999999999;">
			<div class="page-logo">
				<a href="./index.php" class=logo><img src="./logo.png"></a>
                <div class=head_diy_container>
                
                </div>
			</div><div class="top-menu">
				<ul>
					
					<li class="user_info">
                    	<a href="./index.php?monxin=index.user">
                            <img alt="" class="user_icon" src="./program/index/user_icon/default.png">
                            <span class="username username-hide-mobile"><span class=nickname></span></span>
						</a>
						<ul class="user_edit_list">
							<li><a href="./index.php?monxin=index.edit_user"><?php echo self::$language['pages']['index.edit_user']['name']?></a></li>
							<li><a href="./index.php?monxin=index.edit_phone"><?php echo self::$language['pages']['index.edit_phone']['name']?></a></li>							
							<li><a href="./index.php?monxin=index.edit_email"><?php echo self::$language['pages']['index.edit_email']['name']?></a></li>
							<li><a href="./index.php?monxin=index.edit_user&field=password"><?php echo self::$language['pages']['index.edit_user&field=password']['name']?></a></li>
							<li><a href="./index.php?monxin=index.edit_user&field=transaction_password"><?php echo self::$language['pages']['index.edit_user&field=transaction_password']['name']?></a></li>
							<li><a href="./index.php?monxin=index.site_msg_addressee"><?php echo self::$language['pages']['index.site_msg_addressee']['name']?></a></li>
							<li><a href="./index.php?monxin=index.login_log"><?php echo self::$language['pages']['index.login_log']['name']?></a></li>
							<li><a href="./index.php?monxin=index.user_set"><?php echo self::$language['pages']['index.user_set']['name']?></a></li>
							<li><a href="./index.php?monxin=index.my_oauth"><?php echo self::$language['pages']['index.my_oauth']['name']?></a></li>
							<li><a href="./index.php?monxin=index.financial_center"><?php echo self::$language['pages']['index.financial_center']['name']?></a></li>
						</ul>
					</li>
                    <li class="fadeIn animated infinite  user_msg "><a href="./index.php?monxin=index.site_msg_addressee"></a></li>
                    <li class="unlogin"><a href="./receive.php?target=index::user&act=unlogin" class="icon-logout"></a>
	                </li>
				</ul>
			</div>
		</div>
	</div>
<script>
    str='<?php echo $module['user_json']?>';
var user_info=eval("("+str+")"); 
 jQuery(document).ready(function() {
	 //user_info.msg=5;
	 if(user_info.msg>0){
		if($(".msg_div .user_msg").attr('href')){
			$(".user_msg").html(user_info.msg).css('display','block');
		}else{
			
			$(".user_msg a").html(user_info.msg).css('display','block');
		}
			 
	 }else{$(".user_msg").css('display','none');}    
     $('#<?php echo $module['module_name'];?> .nickname').html(user_info.nickname+'/'+user_info.group);
     $('.user_icon').attr('src',user_info.icon);   
     $('.unlogin a').click(function(){
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
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?> .nv > div > ul > li > ul").each(function(index, element) {
        if($(this).children('li').length>10){
			$(this).addClass('multiple_columns');	
		}
    });
	
	$("#<?php echo $module['module_name'];?> .multiple_columns li").each(function(index, element) {
        if($(this).children('ul').html()){
			$(this).addClass('have_three');	
		}
    });
	$("#<?php echo $module['module_name'];?> .nv li").hover(function(){
		
		if($(this).children('ul').html()){
			if($(this).children('ul').width()<$(this).width()){$(this).children('ul').css('width',$(this).width());}	
		}	
	});
	
	$("#<?php echo $module['module_name'];?> .multiple_columns").parent().hover(function(){
		
		if(!$(this).next('li').html()){
			//$(this).children('.multiple_columns').css('left',$(this).width());	
		}
		if($(this).children('.multiple_columns').height()>$(window).height()){
			$(this).children('.multiple_columns').css('width',$(window).width()-200);
			if($(this).children('.multiple_columns').css('left')!='0px'){
				
			}
			$(this).children('.multiple_columns').css('left','0px');	
		}
			
	});
	if(touchAble){
		$("#<?php echo $module['module_name'];?> .nv_ul i").each(function(index, element) {
			if($(this).parent('a').next('ul').children('li').children('a').attr('href')!=$(this).parent('a').attr('href')){
				if($(this).parent('a').children('span').html()){$(this).parent('a').next('ul').html('<li><a href='+$(this).parent('a').attr('href')+'>'+$(this).parent('a').children('span').html()+'</a></li>'+$(this).parent('a').next('ul').html());}
				
				//alert($(this).parent('a').next('ul').html());
			}
        });
		$("#<?php echo $module['module_name'];?> .nv_ul i").parent('a').parent('li').hover(function(){
				$(this).parent('a').next().css('display','block');
			},function(){
				$(this).parent('a').next().css('display','none');	
		});	
		$("#<?php echo $module['module_name'];?> .nv_ul .fa-angle-down").parent('a').click(function(){
			if($(this).next('ul').children('li').children('a').attr('href')!=$(this).attr('href')){
				if($(this).children('span').html()){$(this).next('ul').html('<li><a href='+$(this).attr('href')+'>'+$(this).children('span').html()+'</a></li>'+$(this).next('ul').html());}
				
			}
			return false;
		});
		$("#<?php echo $module['module_name'];?> .nv_ul .fa-angle-right").parent('a').click(function(){
			if($(this).next('ul').children('li').children('a').attr('href')!=$(this).attr('href')){
				if($(this).children('span').html()){$(this).next('ul').html('<li><a href='+$(this).attr('href')+'>'+$(this).children('span').html()+'</a></li>'+$(this).next('ul').html());}
			}
			return false;
		});
	}
	
	
	
	
});
</script>
<style>
#<?php echo $module['module_name'];?>  {}
#<?php echo $module['module_name'];?> .nv{ text-align:left; margin:0px; padding:0px; height:50px; height:3.572rem; line-height:50px;line-height:3.572rem;   font-size:1rem;   white-space:nowrap;}
#<?php echo $module['module_name'];?> .nv a{ white-space:nowrap;}
#<?php echo $module['module_name'];?> .nv .nv_ul{ width:75%;}
#<?php echo $module['module_name'];?> .nv > ul{  white-space:nowrap;}
#<?php echo $module['module_name'];?> .nv ul ul {display: none;}
#<?php echo $module['module_name'];?> .nv ul li:hover > ul {display: block;}
#<?php echo $module['module_name'];?> .nv ul {list-style: none;position: relative;display: inline-block;white-space:nowrap;}
#<?php echo $module['module_name'];?> .nv ul:after {content: ""; clear: both; display: block;}
#<?php echo $module['module_name'];?> .nv ul > li { display: inline-block;text-align: center; }
#<?php echo $module['module_name'];?> .nv ul li:hover {background: #0b7cd2;}
#<?php echo $module['module_name'];?> .nv ul li:hover a {}
#<?php echo $module['module_name'];?> .nv ul li a {display: block; text-decoration: none; padding-left:20px; padding-right:20px;}
#<?php echo $module['module_name'];?> .nv ul li a i{ padding-left:5px;}
#<?php echo $module['module_name'];?> .nv ul ul {line-height:40px;line-height:2.85rem;background: #0b7cd2; border-radius: 0px; padding: 0;position: absolute; top: 100%;}
#<?php echo $module['module_name'];?> .nv ul ul li { display:block; width:100%;float: none;position: relative; text-align:left;}
#<?php echo $module['module_name'];?> .nv ul ul li a {}	
#<?php echo $module['module_name'];?> .nv ul ul li a i{ float:right;line-height:40px;line-height:2.85rem; margin-left:10px;}
#<?php echo $module['module_name'];?> .nv ul ul li a .fa-angle-right{ padding-right:10px;	}
#<?php echo $module['module_name'];?> .nv ul ul li:hover {background:#84adff;}
#<?php echo $module['module_name'];?> .nv ul ul ul {width:100%;position: absolute; left: 100%; top:0; }
#<?php echo $module['module_name'];?> .nv ul ul ul li:hover{}
#<?php echo $module['module_name'];?> .nv ul li:last-child:hover >  ul li ul{ left:-100%; text-align:right;}
#<?php echo $module['module_name'];?> .nv ul li:last-child:hover >  ul li ul a{padding-right: 25px ;}

#<?php echo $module['module_name'];?> .nv ul li .have_three	{ font-weight:bold; margin-bottom:20px;  }
#<?php echo $module['module_name'];?> .nv ul li .have_three	li{ font-weight: normal;  }
#<?php echo $module['module_name'];?> .nv ul li .have_three:hover{ background:none; }
#<?php echo $module['module_name'];?> .nv ul li .have_three > a{ border-bottom:#fff 1px dashed;}
#<?php echo $module['module_name'];?> .nv ul li .have_three a:hover{background:#84adff; }
#<?php echo $module['module_name'];?> .nv ul li .have_three	ul{background: #0b7cd2;  }
#<?php echo $module['module_name'];?> .nv ul li .have_three	i{ display:none; }

#<?php echo $module['module_name'];?> .nv ul li .multiple_columns{ width:600px; height:auto; white-space:normal; text-align:left; }
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li{display:inline-block;  height:auto; border-top:none; vertical-align:top; width:200px; padding-left:10px; }
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li a{ display:block; text-align:left;}
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li ul{ display:block; position:static;  height:auto; white-space:normal; }
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li ul li{  display:block; width:100%; height:32px; line-height:32px; height:2.3rem; line-height:2.3rem;}
#<?php echo $module['module_name'];?> .nv ul li:last-child:hover >  ul li ul a{padding-right: 25px ;}
#<?php echo $module['module_name'];?> .nv .nv_search{ display:inline-block; vertical-align:top; width:25%; }
#<?php echo $module['module_name'];?> .nv .nv_search .input-group { margin-top:8px;margin-top:0.57rem; width:80%; float:right;}
#<?php echo $module['module_name'];?> .nv .nv_search .input-group button { margin-top:-16px;}
#<?php echo $module['module_name'];?> .nv .nv_search .input-group input { height:2.4rem;}
@media (min-width:1900px){
	#<?php echo $module['module_name'];?> .nv .nv_search .input-group { margin-top:12px;margin-top:0.8rem; }
	#<?php echo $module['module_name'];?> .nv .nv_search .input-group button {margin-top:-1.2rem; height:2.45rem; }
}
.user_edit_list{ }
</style>

<div class=nv>
	<div class="container"><ul class=nv_ul ><li><a href=index.php?monxin=index.user><span><?php echo self::$language['user_center']?></span></a></li><li><a href=./index.php?monxin=index.personal_center><img src="./templates/1/index/default/page_icon/index.personal_center.png" /><span><?php echo self::$language['personal_center']?></span><i class="fa fa-angle-down"></i></a><ul>
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
</ul></li><?php echo $module['map'];?></ul><div class=nv_search general_search=1>
    	 <div class="input-group">
      <input type="text" class="form-control" placeholder="<?php echo $module['search_placeholder'];?>" url="<?php echo $module['search_url']?>">
      <span class="input-group-btn">
        <button class="btn btn-default" type="button"  search_button=1><?php echo self::$language['search']?></button>
      </span>
    </div>
	</div></div>
</div>
</div>