<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" >
<script>
$(document).ready(function(){
	if(<?php echo $module['request_geolocation'];?>==1){
		if (navigator.geolocation){navigator.geolocation.getCurrentPosition(showPosition);}
		function showPosition(position){
			v=(position.coords.latitude+<?php echo $module['gps_y']?>)+','+(position.coords.longitude+<?php echo $module['gps_x']?>)+','+position.coords.accuracy;
			$.post('<?php echo $module['action_url'];?>&act=geolocation',{v:v}, function(data){
				//alert(data);
			});
		  
		}
	}
	$(".for_index_search .logo_span").html('<?php echo $module['search_left']?>');
	
	function set_monxin_bottom_current(){
		$('.monxin_bottom a').removeClass('current');
		if(get_param('monxin')!=''){
			$('.monxin_bottom [monxin="'+get_param('monxin')+'"]').addClass('current');
		}else{
			$('.monxin_bottom [monxin="index.index"]').addClass('current');
		}
	}
	set_monxin_bottom_current();
	
	if(get_param('show_monxin_head')!=''){
		if(get_param('show_monxin_head')=='1'){
			setCookie('show_monxin_head','1',300);	
		}else{
			setCookie('show_monxin_head','0',300);	
		}	
	}
	if(getCookie('show_monxin_head')==1 && get_param('monxin')!=''){$(".monxin_head").css('display','block');$(".page-container").css('padding-top',$(".monxin_head").height());}
	if((getCookie('monxin_bottom')===false || getCookie('monxin_bottom')=='')  && <?php echo $module['phone_show_monxin_bottom'];?>==1){setCookie('monxin_bottom','1',300);}
	
	if(getCookie('monxin_bottom')==1){
		$(".monxin_bottom").css('left','0px');
		$(".monxin_bottom_switch i").addClass('fa-angle-right');
		$(".monxin_bottom_switch i").removeClass('fa-angle-left');
	}else{
		$(".monxin_bottom").css('left','100%');
		$(".monxin_bottom_switch i").addClass('fa-angle-left');
		$(".monxin_bottom_switch i").removeClass('fa-angle-right');
	}
	if($(".page_name").html()==''){
		temp=$('title').html().split('_');
		if(!temp[1]){temp=$('title').html().split('-');}
		if(!temp[1]){temp=$('title').html().split(' ');}
		if(temp[0]=='' || temp[0]==' '){temp[0]=$('title').html();}
		$(".page_name").html(temp[0]);
	}
	
	$('.right_nv_div').append($('.nv_ul'));
	//$(".nv_ul").prepend('<li class="right_serach" general_search=1><input type="text"  placeholder="<?php echo $module['search_placeholder'];?>" url="<?php echo $module['search_url']?>" /><span class="fa fa-search"  search_button=1></span></li>');   
	$(".nv_ul").css('height',$(window).height()).css('width',$(".nv_ul").parent().width());
	$("#<?php echo $module['module_name'];?> .nv_ul a .fa-angle-right").each(function(index, element) {
        $(this).removeClass('fa-angle-right');
        $(this).addClass('fa-angle-down');
    });
	
	$(".monxin_bottom_switch").click(function(){
		//alert($(document).scrollLeft());
		if($(".monxin_bottom").offset().left-$(document).scrollLeft()==0){
			$(this).children('i').addClass('fa-angle-left');
			$(this).children('i').removeClass('fa-angle-right');
			$(".monxin_bottom").animate({left:'100%'},'fast');	
			$(".right_nv_div").animate({right:'-100%'},'fast');	
			$(".cart_goods_sum").css('display','none');
			setCookie('monxin_bottom','0',300);
		}else{
			$(".monxin_bottom").animate({left:'0'},'fast');
			$(this).children('i').addClass('fa-angle-right');
			$(this).children('i').removeClass('fa-angle-left');
			$(".cart_goods_sum").css('display','block');
			setCookie('monxin_bottom','1',300);
		}
		return false;	
	});
	
	$(".bottom_show_more").click(function(){
		//alert($(".nv_ul").css('right'));
		if($(".right_nv_div").css('right')=='0px'){
			$(".right_nv_div").animate({right:'-100%'},'fast');
			set_monxin_bottom_current();	
		}else{
			$(".right_nv_div").animate({right:'0px'},'fast');
			$('.monxin_bottom a').removeClass('current');
			$(this).addClass('current');
		}
		return false;	
	});
	
	
		$("#<?php echo $module['module_name'];?> .nv_ul i").each(function(index, element) {
			if($(this).parent('a').next('ul').children('li').children('a').attr('href')!=$(this).parent('a').attr('href')){
				if($(this).parent('a').children('span').html()){$(this).parent('a').next('ul').html('<li><a href='+$(this).parent('a').attr('href')+'>'+$(this).parent('a').children('span').html()+'</a></li>'+$(this).parent('a').next('ul').html()); 	}
				
				//alert($(this).parent('a').next('ul').html());
			}
        });
		$("#<?php echo $module['module_name'];?> .nv_ul i").parent('a').click(function(){
			if($(this).next('ul').css('display')=='none'){
				$(this).next('ul').css('display','block');
			}else{
				$(this).next('ul').css('display','none');
			}
			return false;
		});
	$(".right_nv_div").preventScroll();
	
	$("[general_search] input").keyup(function(event){
		keycode=event.which;
		if(keycode==13){
			if($(this).val()!=''){
				window.location.href=$(this).attr('url')+$(this).val();	
			}
		}	
	});
	$("[general_search] [search_button]").click(function(event){
		if($("[general_search] input").val()!=''){window.location.href=$("[general_search] input").attr('url')+$("[general_search] input").val();}
		return false;
	});
	
	if($("#<?php echo $module['module_name'];?> a[href='./index.php?monxin=mall.buyer']").html()){
		$("#<?php echo $module['module_name'];?> a[monxin='index.user']").addClass('current');	
	}
	
	
	$(document).on('click','.monxin_head .h_search',function(){
		if($(".monxin_head .h_search_div").css('display')=='none'){
			$(".monxin_head .h_search_div").css('display','inline-block');
			$(".monxin_head .page_name").css('display','none');
		}else{
			url=window.location.href;
			url=replace_get(url,'search',$(".monxin_head .h_search_div input").val());
			if($(".monxin_head .h_search_div input").attr('href')){
				url=$(".monxin_head .h_search_div input").attr('href')+'&search='+$(".monxin_head .h_search_div input").val();
			}
			window.location.href=url;	
		}
		return false;
	});
	
	$(".monxin_head .h_search_div input").keyup(function(event){
		keycode=event.which;
		if(keycode==13){
			url=window.location.href;
			url=replace_get(url,'search',$(".monxin_head .h_search_div input").val());
			if($(".monxin_head .h_search_div input").attr('href')){
				url=$(".monxin_head .h_search_div input").attr('href')+'&search='+$(".monxin_head .h_search_div input").val();
			}
			window.location.href=url;	
		}	
	});
	
	mx=get_param('monxin');
	if(mx!=''){
		mx=mx.replace('.','_');
		if($("#"+mx+" #search_filter").attr('type') ||  $("#"+mx+" .search").attr('type') ||  $("#"+mx+" input[type='search']").attr('type') ){
			$(".monxin_head .h_search").css('display','inline-block');
			if($("#"+mx+" #search_filter").attr('placeholder')){
				$(".monxin_head .h_search_div input").attr('placeholder',$("#"+mx+" #search_filter").attr('placeholder'));
			}else if($("#"+mx+" .search").attr('placeholder')){
				$(".monxin_head .h_search_div input").attr('placeholder',$("#"+mx+" .search").attr('placeholder'));
			}else if($("#"+mx+" input[type='search']").attr('placeholder')){
				$(".monxin_head .h_search_div input").attr('placeholder',$("#"+mx+" input[type='search']").attr('placeholder'));
			}
		}
	}
	
});
</script>
<style>
.monxin_head .h_search{display: inline-block;vertical-align: top; width: 15%;padding-left: 5%; height: 100%;line-height: 3rem;font-size: 1.3rem;  font-weight: 100;display:none;}
.monxin_head .h_search:before {font: normal normal normal 18px/1 FontAwesome;  margin-right: 5px;   content:"\f002";}

.page-footer{padding-bottom:3.5rem;}	
#<?php echo $module['module_name'];?>{}
#<?php echo $module['module_name'];?>_html{}
.monxin_bottom{ width:100%; height:3.57rem; line-height:3.57rem; position:fixed; bottom:0px; left:100%; box-shadow: 0px -2px 1px 1px rgba(0, 0, 0, 0.1); z-index:999999; background:#fff;color: #777;}
.monxin_bottom a{ padding-top:3px; display:inline-block; vertical-align:top; width:19%; text-align:center;color: #777; }
.monxin_bottom a i{ font-size:1.6rem;  display:block; }
.monxin_bottom .current{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;  }
.monxin_bottom a span{ line-height:1.2rem; display:block; font-size:0.8rem; }
.monxin_bottom_switch{ position:fixed; bottom:0px;right:0px;height:3.57rem; width:2.57rem; text-align:center; line-height:3.57.rem; font-size:2.5rem; z-index:999999999999999999;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> !important;}
.right_nv_div{ position:fixed;  height:100%;  overflow:scroll;  width:60%;right:-100%; top:0px;z-index:99999; background:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; }
.nv_ul{ margin:0px; padding-left:1rem; padding-bottom:3.57rem; overflow: visible;  width:100%; vertical-align:bottom; display: table-cell;}
.nv_ul a{ white-space:nowrap;}
.nv_ul a i{ padding-left:2px;}
.nv_ul li{list-style:none; }
.nv_ul li ul{display:none; padding-left:3rem;}
.nv_ul > li{ display:block; list-style:none; line-height:3rem; border-bottom:#ccc 1px dashed;}
.nv_ul > li > a{display:block;}
.nv_ul li  a  img{ display:none;}
.nv_ul > li > a > span{ }
.nv_ul > li > ul > li{  display:block; list-style:none; line-height:2.5rem; border-bottom:#ccc 1px dashed; }

.right_serach{ line-height:3rem; height:3rem;}
.right_serach input{ width:70%;}
.right_serach span{ padding-left:1rem;display:inline-block; width:25%; line-height:3rem;}

.monxin_head{ display:none; position:fixed;top:0px; width:100%; white-space:nowrap; line-height:3rem; height:3rem;text-align:center;  box-shadow: 0px 2px 1px 1px rgba(0, 0, 0, 0.1); z-index:9; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
.monxin_head a{ font-size:2rem;}
.monxin_head a:hover{ }
.monxin_head .return_last_page{ display: inline-block; vertical-align:top; width:15%; padding-right:5%; height:100%; line-height:3rem;}
.monxin_head .page_name{ display: inline-block; vertical-align:top; width:70%; overflow:hidden; height:100%; line-height:3rem;text-overflow: ellipsis;}
.monxin_head .h_search_div{ display: inline-block; vertical-align:top; width:70%; overflow:hidden; height:100%; line-height:3rem;text-overflow: ellipsis;display:none;}
.monxin_head .h_search_div input{ width:100%; border-radius:5px; color:#000; background:rgba(255,255,255,1);}
.monxin_head .refresh{ display: inline-block; vertical-align:top; width:15%;padding-left:5%;   height:100%; line-height:3rem; font-size:1.3rem; font-weight:100; }
.monxin_head .home{ text-align:left; display: inline-block; vertical-align:top; width:15%;padding-left:2%;   height:100%; line-height:3rem; font-size:1rem; font-weight:100; }
.monxin_head .home:before{margin-right:2px; font: normal normal normal 1.1rem/1 FontAwesome; content:"\f015";}
.go_circle{ color:#fff !important; text-align:center !important; display:block; line-height:2rem;     white-space: nowrap;
    text-overflow: ellipsis; overflow:hidden;}
.go_circle:after{ font: normal normal normal 1.1rem/1 FontAwesome; content:"\f0d7"; padding-left:3px;}
.h_search{ }
</style>
    <div id="<?php echo $module['module_name'];?>_html">  
    	<div class=monxin_head><a href="javascript:history.back(-1)" class="fa fa-angle-left return_last_page"></a><span class=page_name></span> <div class=h_search_div><input type=text class=head_search value="<?php echo @$_GET['search']?>" placeholder="<?php echo $module['search_placeholder'];?>" /></div><a class="h_search"></a><a href="javascript:window.location.reload();" class="fa fa-refresh refresh"></a>
        	
        </div>
       
		<div class=right_nv_div></div>
	 	<div class=monxin_bottom>
       
        	<?php echo $module['data'];?>
        </div>
        
        <a class=monxin_bottom_switch><i class="fa fa-angle-right"></i></a>
    </div>
</div>

