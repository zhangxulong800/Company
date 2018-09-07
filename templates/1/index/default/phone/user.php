<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		if('<?php echo $module['weixin_auto_login']?>'=='0' || !isWeiXin()){
			$("#<?php echo $module['module_name'];?> .unlogin").css('display','inline-block');
		}
		
		$("#<?php echo $module['module_name'];?> .search").focus(function(){
			$("html,body").animate({scrollTop: $(this).offset().top}, 10);
		});
		if($(".quick_button").html()<10){$(".quick_button").css('display','none');}
    });	
	
	</script>
    
    <style>
	#index_foot,#index_device{ display:none ;}
	.container{ }
    #<?php echo $module['module_name'];?>{background:<?php echo $_POST['monxin_user_color_set']['container']['background']?>; background:rgba(245,245,245,1);}
    #<?php echo $module['module_name'];?>_html{ margin:0px; margin-bottom:1rem; background:#fff; padding-bottom:0.3rem; }
	
	#<?php echo $module['module_name'];?>_html .head_user_info{ background-image:url('./program/index/img/user_bg.png');  background-size: 100%; padding-top:0.5rem; padding-bottom:0.3rem;}
	#<?php echo $module['module_name'];?>_html .head_user_info .bg{ max-height:11rem; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .head_user_info .bg img{ width:100%;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo{ }
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .icon{ display:inline-block; vertical-align:top; width:25%; overflow:hidden; text-align:center;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .icon img{ width:60px; height:60px; border-radius:30px; border:#FFF 3px solid; }
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo{display:inline-block; vertical-align:top; width:75%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top{  height:4.5rem; color:#fff;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top a{color:#fff; }
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top .m_nickname{ line-height:2.5rem; font-weight:bold; font-size:1.5rem; display:block; width:100%;overflow:hidden;    white-space: nowrap;    text-overflow: ellipsis;	}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top .m_nickname:after{font: normal normal normal 1rem/1 FontAwesome;margin-left: 10px;content: "\f040";}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top .group{ border-radius:3px; border:1px solid #fff; padding:2px;}
	#<?php echo $module['module_name'];?>_html .head_user_info .u_act{ text-align:right;}
	#<?php echo $module['module_name'];?>_html .head_user_info .u_act .user_c:after{font: normal normal normal 1.6rem/1 FontAwesome;margin-right: 1rem;content: "\f013"; color:#fff;}
	#<?php echo $module['module_name'];?>_html .head_user_info  .unlogin{ padding-right:0.5rem; display:none; color:#fff;}
	#<?php echo $module['module_name'];?>_html .head_user_info  .unlogin:after{font: normal normal normal 1.6rem/1 FontAwesome;margin-left: 5px;content: "\f08b";}
	
	#<?php echo $module['module_name'];?> .background_mode_1{list-style:none; line-height:2rem; padding-top:1rem; }
	#<?php echo $module['module_name'];?> .background_mode_1 ul{ list-style:none; background:#fff;}
	#<?php echo $module['module_name'];?> .background_mode_1 li{ list-style:none;background:#fff;  }
	#<?php echo $module['module_name'];?> .background_mode_1 li a{ background:#fff; color:#000; }
	#<?php echo $module['module_name'];?> .background_mode_1 li a .value_int{ display:inline-block; vertical-align:top;  border-radius:50%; text-indent:0px; width:1.5rem; text-align:center; height:1.5rem; line-height:1.5rem; margin-top:0.8rem; margin-right:0.8rem; float:right; font-size:1rem;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
	#<?php echo $module['module_name'];?> .background_mode_1 li a .value_str{ display:inline-block; vertical-align:top;height:2rem; line-height:2rem; margin-top:1rem; margin-right:0.8rem; float:right; opacity:0.3; }
	#<?php echo $module['module_name'];?> .background_mode_1 > li:first-child{ display:none;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li{ line-height:2rem; font-size:1rem; list-style:none;   margin-bottom:1rem; border-bottom:1px solid #d7d7d7; white-space:nowrap;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li:before{ font: normal normal normal 2rem/1 FontAwesome;margin-right: 5px;content:"\f04c";  margin-left:0px; display:inline-block; vertical-align:top; width:3%; overflow:hidden;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > a{border-bottom:1px solid #d7d7d7; display:inline-block; vertical-align:top; width:97%; overflow:hidden; margin-left:-3%; text-indent:1rem;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > a img{ display:none;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > a i{ display:none;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul{list-style:none; line-height:4rem; font-size:1.2rem; }
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li{ white-space:nowrap;list-style:none;border-bottom:1px  dashed #d7d7d7; display:block;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li:after{font: normal normal normal 2rem/1 FontAwesome;margin-right: 5px;content:"\f105";  }
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li:first-child{ display:none; }
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li a{ text-indent:2rem; display:inline-block; vertical-align:top; width:95%;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li a img{ width:2rem;  border-radius:20%; margin-right:0.4rem; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li >ul{ }
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li >ul > li{ white-space:nowrap;list-style:none;border-bottom:1px  dashed #d7d7d7; display:block;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li >ul > li:after{font: normal normal normal 2rem/1 FontAwesome;margin-right: 5px;content:"\f105";  }	
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li >ul > li:first-child{ display:block;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li >ul > li a{ text-indent:4rem; display:inline-block; vertical-align:top; width:95%;}

	.no_after:after{ display:none !important;}
	.no_after{ display:block !important;}
	.sum_card{ display:none;}
	.head_user_info{border-bottom:1px solid #f3f3f3;}
	.search_div_out{ }
	#<?php echo $module['module_name'];?> .search_div{border-radius:5px; border:1px solid #ccc; overflow:hidden; display:none; }
	#<?php echo $module['module_name'];?> .search_div input{ width:90%; border:none; }
	#<?php echo $module['module_name'];?> .search_div .search_button:before {font: normal normal normal 14px/1 FontAwesome;margin-left: 5px;content: "\f002"; color:#ccc; }
	#<?php echo $module['module_name'];?> .search_result_div{background-color:#fff; width:100%; overflow:hidden; text-align:left; border:1px solid #c5c5c5; borer-top:0px; text-align:center; margin:auto; width:85%;  padding-top:0.3rem; padding-bottom:0.3rem; position:fixed; top:2.5rem; z-index:999999; display:none; text-align:left;}
	#<?php echo $module['module_name'];?> .search_result_div a{ display:block; line-height:2rem; padding-left:5px;}
	#<?php echo $module['module_name'];?> .search_result_div a:hover{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:#fff;}
	#<?php echo $module['module_name'];?> .search_result_div a img{ display:none;}
	#<?php echo $module['module_name'];?> .search_result_div{}
	
	#<?php echo $module['module_name'];?>_html .u_bottom{ padding-top:0.2rem; padding-bottom:0rem;     white-space: nowrap;} 
	#<?php echo $module['module_name'];?>_html .u_bottom a{ display:inline-block; vertical-align:top; width:33.3%; text-align:center; overflow:hidden;} 
	#<?php echo $module['module_name'];?>_html .u_bottom a:last-child{ border:none;}
	#<?php echo $module['module_name'];?>_html .u_bottom a span{ display:block; } 
	#<?php echo $module['module_name'];?>_html .u_bottom a .value{font-size:1rem; color:#999;} 
	#<?php echo $module['module_name'];?>_html .u_bottom a .name{ } 
	#<?php echo $module['module_name'];?>_html .u_bottom .user_v:before {font: normal normal normal 14px/1 FontAwesome;margin-left: 5px;content: "\f157"; display:block; width:26px; height:26px; line-height:26px; border-radius:13px; margin:auto; background:rgba(246,56,48,1); color:#fff;}
	#<?php echo $module['module_name'];?>_html .u_bottom .credits_v:before {font: normal normal normal 14px/1 FontAwesome;margin-left: 5px;content:"\f1c0"; display:block; width:26px; height:26px; line-height:26px; border-radius:13px; margin:auto; background:rgba(239,193,78,1); color:#fff;}
	#<?php echo $module['module_name'];?>_html .u_bottom .im_v:before {font: normal normal normal 14px/1 FontAwesome;margin-left: 5px;content: "\f1d7"; display:block; width:26px; height:26px; line-height:26px; border-radius:13px; margin:auto; background:rgba(51,153,255,1); color:#fff;}
	
	#<?php echo $module['module_name'];?> .show_my_qr:before {font: normal normal normal 16px/1 FontAwesome;padding-left: 10px;padding-right: 10px;content:"\f029"; }

    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
        <div class=head_user_info>
        	<div class=u_act><a class=user_c href=./index.php?monxin=index.personal_center></a><a class="unlogin" href="./receive.php?target=index::user&act=unlogin" class="icon-logout"><span></span></a></div>
            <div class=icon_uinfo>
            	<div class=icon><a href="./index.php?monxin=index.personal_center"><img alt="" class="user_icon" src="./program/index/user_icon/default.png"></a></div><div class=uinfo>
                	<div class=u_top>
                    	<a href='./index.php?monxin=index.edit_user' class=m_nickname><?php echo $module['user']['nickname']?></a>
                        <span class=group><?php echo $module['user']['group']?></span> <a href=./index.php?monxin=index.my_recommend_qr class=show_my_qr></a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class=u_bottom>
            <a href="./index.php?monxin=index.financial_center" class=user_v><span class=name><?php echo self::$language['user_money']?></span><span class=value><?php echo $module['user']['money']?></span></a><a href="./index.php?monxin=index.financial_center" class=user_money><span class=credits_v><?php echo self::$language['credits']?></span><span class=value><?php echo $module['user']['credits']?></span></a><a href="./index.php?monxin=im.talk" class="im_v"><span class=name><?php echo self::$language['im_msg']?></span><span class=value><?php echo $module['msg'];?></span></a>
        </div>

    <div class=search_div_out >    
        <div class=search_div><input type="text" class=search placeholder="<?php echo self::$language['search']?>" /><a class=search_button></a></div>
        <div class=search_result_div></div>
    </div>
    
        
    </div>
    
    
<style>
.quick_button{ background:#fff; padding-top:1.5rem; margin-top:1rem;}
.quick_button a{ display:inline-block; width:25%; height:70px; text-align:center; overflow:hidden;    white-space: nowrap;  text-overflow: llipsis; line-height:2rem;  font-size:0.9rem;}
.quick_button a img{ display:block; margin:auto; width:40px; height:40px; background:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; border-radius:6px;}

.quick_button a:nth-child(1) img{ background:rgba(52,182,175,1);}
.quick_button a:nth-child(2) img{ background:rgba(242,161,47,1);}
.quick_button a:nth-child(3) img{ background:rgba(255,51,51,1);}
.quick_button a:nth-child(4) img{ background:rgba(239,194,79,1);}
.quick_button a:nth-child(5) img{ background:rgba(255,92,152,1);}
.quick_button a:nth-child(6) img{ background:rgba(255,144,82,1);}
.quick_button a:nth-child(7) img{ background:rgba(144,215,108,1);}
.quick_button a:nth-child(8) img{ background:rgba(43,193,2,1);}
.quick_button a:nth-child(9) img{ background:rgba(52,182,175,1);}
.quick_button a:nth-child(10) img{ background:rgba(242,161,47,1);}
.quick_button a:nth-child(11) img{ background:rgba(255,51,51,1);}
.quick_button a:nth-child(12) img{ background:rgba(239,194,79,1);}
.quick_button a:nth-child(13) img{ background:rgba(255,92,152,1);}
.quick_button a:nth-child(14) img{ background:rgba(255,144,82,1);}
.quick_button a:nth-child(15) img{ background:rgba(144,215,108,1);}
.quick_button a:nth-child(16) img{ background:rgba(43,193,2,1);}

</style>
<div class=quick_button><?php echo $module['quick_button'];?></div>    
    
    
    <ul class=background_mode_1></ul>
    
    <script>
    $(document).ready(function(){
		html='';
		temp='(<?php echo $module['data'];?>)';
		if(temp!='()'){
			arr=eval(temp);
			index=1;
			page_size=8;
			page=1;
			html_sub='';
			for(i in arr){
				if(!arr[i]['name']){continue;}
				html_sub+='<a class="c_'+index+'" href="'+arr[i]['url']+'" target="'+arr[i]['open_target']+'"><span class=icon><img src="'+arr[i]['icon_path']+'" /></span><span class=name>'+arr[i]['name']+'</span></a>';
				if(index%page_size==0){
					html+='<div class="page_'+page+' swiper-slide">'+html_sub+'</div>';
					page++;
					html_sub='';
				}
				index++;
			}
			index--;
			if(index%page_size!=0){
				html+='<div class="page_'+page+' swiper-slide">'+html_sub+'</div>';
			}
			if(index<5){$('.swiper-container').css('height',$('.swiper-container').height()/2+20);}
			$("#<?php echo $module['module_name'];?> .swiper-wrapper").html(html);
		}
		
		
		$(".head_search").keyup(function(){
			key=$(this).val();
			str='';
			if(key==''){
				
			}else{
				$("#<?php echo $module['module_name'];?> .swiper-slide span").each(function(index, element) {
					if($(this).html().indexOf(key)!=-1){
						str+='<a href='+$(this).parent().attr('href')+'>'+$(this).html()+'</a>';
					}
				});
			}
			//if(str==''){str='<a><?php echo self::$language['no_related_content']?></a>';}
			$("#<?php echo $module['module_name'];?> .search_result_div").html(str);
			if(str=='' ){
				$("#<?php echo $module['module_name'];?> .search_result_div").css('display','none');
			}else{
				$("#<?php echo $module['module_name'];?> .search_result_div").css('width',$(".head_search").width()+7);
				$("#<?php echo $module['module_name'];?> .search_result_div").css('left',$(".head_search").offset().left);
				$("#<?php echo $module['module_name'];?> .search_result_div").css('display','block');
			}
		});
		
		
		
		$("#<?php echo $module['module_name'];?> .show_sum_div a").click(function(){
			if($(".sum_card").attr('class')=='portlet light sum_card'){
				$(".sum_card").addClass('show_sum_card');
			}else{
				$(".sum_card").removeClass('show_sum_card');
			}
			return false;
		});
		
    });
    </script>

	<style>
	.swiper-slide{ margin-bottom:1rem; background:#fff; padding-top:0.5rem;}
	.swiper-slide a{ padding-left:1rem; display:block; border-bottom:1px dashed #ccc; padding-bottom:5px;margin-bottom:5px;}
	.swiper-slide a:after{font: normal normal normal 1rem/1 FontAwesome;margin-left: 10px;content:"\f105"; float:right; padding-right:5px;}
	.swiper-slide a img{ width:30px; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; margin-right:10px; border-radius:4px;}
	.swiper-slide a:last-child{ border-bottom:none;}
	.swiper-slide a:nth-child(1) img{ background:rgba(52,182,175,1);}
	.swiper-slide a:nth-child(2) img{ background:rgba(242,161,47,1);}
	.swiper-slide a:nth-child(3) img{ background:rgba(255,51,51,1);}
	.swiper-slide a:nth-child(4) img{ background:rgba(239,194,79,1);}
	.swiper-slide a:nth-child(5) img{ background:rgba(255,92,152,1);}
	.swiper-slide a:nth-child(6) img{ background:rgba(255,144,82,1);}
	.swiper-slide a:nth-child(7) img{ background:rgba(144,215,108,1);}
	.swiper-slide a:nth-child(8) img{ background:rgba(43,193,2,1);}
	.diy_sum_card .s_bottom{padding-left:1rem !important;}
	

.show_sum_card{ display:block; width:100%;}	

.show_sum_div{ text-align:center; line-height:3rem;}
.show_sum_div a:after{font: normal normal normal 1rem/1 FontAwesome;margin-left: 10px;content:"\f103"; padding-left:1px;}
.swiper-container{}
.show_sum_div{ display:none;}
    </style>
    
    
    <div class="swiper-container">
      <div class="swiper-wrapper">
      	
      </div>
     
    </div>
    <div class="pagination"></div>
    
	<div class=show_sum_div><a class=show_sum_a><?php echo self::$language['view_sum_module']?></a></div>
    
    
</div>

