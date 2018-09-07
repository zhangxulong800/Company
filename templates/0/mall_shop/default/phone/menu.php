<?
/*
变量说明：
-------------------------------------------------------------------------
$module['title']=模块标题no
$module['title_url']=模块标题URL
$module['data']=模块数据，二维数组，数组下标：url,name 使用示例请参考本软件的默认模板defuat
-------------------------------------------------------------------------
*/

?>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=center>
<script>
$(document).ready(function(){
	$(".monxin_head .refresh").css('display','none');
	$(".monxin_head .page_name").html($("#<?php echo $module['module_name'];?> .shop_goods_type .title").html());
	$(".monxin_head").append('<a href=./index.php class=home><?php echo self::$language['home']?></a>');
	$(".monxin_head").css('display','block');	
	$(".page-container").css('padding-top',$(".monxin_head").height());	
	
	$("#<?php echo $module['module_name'];?> .shop_goods_type").height($(window).height()-$(".for_mall").height()-$("#mall_menu").height());
	$(document).scroll(function(event){
		$("#<?php echo $module['module_name'];?> .shop_goods_type").height($(window).height()-$(".for_mall").height()-$("#mall_menu").height());
    });	
	$("#<?php echo $module['module_name'];?> .shop_goods_type .contents").scroll(function(event){
        event.stopPropagation();
    });	
	$("#<?php echo $module['module_name'];?> .shop_goods_type .m_close a").click(function(){
		$("#<?php echo $module['module_name'];?> .shop_goods_type").animate({left: '-100%'}, "normal",function(){
			$("#<?php echo $module['module_name'];?> #menu_start").attr('class','type_hide');
		});
		return false;
	});
	$("#<?php echo $module['module_name'];?> .shop_goods_type .contents .list .type_1 .name").click(function(){
		
		if($(this).next('.type_2').html()){
			if($(this).next('.type_2').css('display')!='none'){$(this).next('.type_2').css('display','none');return false;}
			$("#<?php echo $module['module_name'];?> .shop_goods_type .contents .list .type_1 .type_2").css('display','none');
			$(this).next('.type_2').css('display','block');	
		}else{
			window.location.href=$(this).parent().attr('href');	
		}
		
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?> #menu_start").attr('class','type_hide');
	$("#<?php echo $module['module_name'];?> #menu_start").click(function(){
		if($("#<?php echo $module['module_name'];?> .shop_goods_type").css('left')!='0px'){
			$("#<?php echo $module['module_name'];?> .shop_goods_type").animate({left: '0px'}, "normal");
			$("#<?php echo $module['module_name'];?> #menu_start").attr('class','type_show');
		}else{
			$("#<?php echo $module['module_name'];?> .shop_goods_type").animate({left: '-100%'}, "normal",function(){
			$("#<?php echo $module['module_name'];?> #menu_start").attr('class','type_hide');
			});
		}
		return false;
	});
	$("#<?php echo $module['module_name'];?> .menu_2").each(function(index, element) {
        $(this).css('left',$("#<?php echo $module['module_name'];?> #"+$(this).attr('id').replace(/_sub/g,'')).offset().left)
        $(this).css('width',$("#<?php echo $module['module_name'];?> #"+$(this).attr('id').replace(/_sub/g,'')).width())
    });
	
	$(document).click(function(event){
		if($(this).parent().attr('class')!='menu_2'){
			$("#<?php echo $module['module_name'];?> .menu_2").css('display','none');
		}
			
	});
	$("#<?php echo $module['module_name'];?> .menu_1 a").unbind('click');
	$("#<?php echo $module['module_name'];?> .menu_1 a").each(function(index, element) {
    	if($("#"+$(this).attr('id')+"_sub").html()!=null){
			$(this).addClass('have_sub');
		}  
    });
	$("#<?php echo $module['module_name'];?> .menu_1 a").click(function(){
		$("#<?php echo $module['module_name'];?> .menu_1 a").removeClass('current');
		if($("#"+$(this).attr('id')+"_sub").html()!=null){
			if($("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+"_sub").css('display')=='block'){
				$(this).removeClass('current');
				$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+"_sub").css('display','none');
			}else{
				$("#<?php echo $module['module_name'];?> .menu_2").css('display','none');
				$(this).addClass('current');
				$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+"_sub").css('display','block');	
			}
			return false;
		}
		
	});
	
	$("#<?php echo $module['module_name'];?> .shop_goods_type .contents").preventScroll();
});

</script>
<style>
.monxin_bottom,.cart_goods_sum,.monxin_bottom_switch{ display:none !important; }
#index_device{ margin-bottom:120px;}
#index_navigation_html #navigation_swtich{ display:none; width:0px; height:0px;}
#<?php echo $module['module_name'];?>{ position:fixed; width:100%; bottom:0px; z-index:99999;}
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html #menu_bar{ white-space:nowrap; width:100%; height:3rem; line-height:3rem; box-shadow: 0px -2px 1px 1px rgba(0, 0, 0, 0.1);z-index:999;}
#<?php echo $module['module_name'];?>_html .menu_1{ display:inline-block; vertical-align:top; width:90%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .menu_1 a{ display:inline-block; vertical-align:top; width:33%; text-align:center; border-right:#ccc 2px solid;}
#<?php echo $module['module_name'];?>_html .menu_1 .current{  }
#<?php echo $module['module_name'];?>_html .menu_1 .have_sub{ background-image:url(<?php echo get_template_dir(__FILE__);?>img/menu_have_sub.png); background-repeat:no-repeat; background-position:right;}
#<?php echo $module['module_name'];?>_html #menu_start{ display: inline-block; vertical-align:top; width:10%; overflow:hidden;background-position:center; background-repeat:no-repeat;}
#<?php echo $module['module_name'];?>_html #menu_start:before{ font: normal normal normal 1rem/1 FontAwesome; content:"\f036"; }
#<?php echo $module['module_name'];?>_html .type_hide{}
#<?php echo $module['module_name'];?>_html .type_show{  }
#<?php echo $module['module_name'];?>_html #menu_end{ display:none;}

#<?php echo $module['module_name'];?>_html .menu_2{ display:none; position: fixed; bottom:105px; line-height:120px; width:33%; text-align:center; box-shadow: 0px -2px 5px 0px #666; }
#<?php echo $module['module_name'];?>_html .menu_2 a{ display:block;}

#<?php echo $module['module_name'];?> .shop_goods_type{ position: fixed; top:0px; left:-100%; width:60%;  text-align:left; overflow:hidden; }
#<?php echo $module['module_name'];?> .shop_goods_type .contents{ display:inline-block; vertical-align:top; width:80%;height:100%;padding:0.5rem;overflow:hidden;   text-align:left; overflow-y:scroll;}
#<?php echo $module['module_name'];?> .shop_goods_type .contents .title{ border-bottom:#FFF solid 1px; padding-bottom:10px;}
#<?php echo $module['module_name'];?> .shop_goods_type .contents .list{ line-height:2rem; width:120%; }
#<?php echo $module['module_name'];?> .shop_goods_type .contents .list .type_1{ }
#<?php echo $module['module_name'];?> .shop_goods_type .contents .list .type_1 .name{ }
#<?php echo $module['module_name'];?> .shop_goods_type .contents .list .type_1 .type_2{ display:none;}
#<?php echo $module['module_name'];?> .shop_goods_type .contents .list .type_1 .type_2 a{ display:block; line-height:70px;  text-indent:100px; }

#<?php echo $module['module_name'];?> .shop_goods_type .m_close{ display:inline-block; width:3rem; vertical-align:top; }
#<?php echo $module['module_name'];?> .shop_goods_type .m_close a{position: absolute;top:45%;  display:block; height:3rem; width:3rem;}
#<?php echo $module['module_name'];?> .shop_goods_type .m_close a:before{ font: normal normal normal 3rem/1 FontAwesome; content:"\f100"; margin-left:3px;}

</style>
    <div id="<?php echo $module['module_name'];?>_html" align="center">
    <?php echo $module['data'];?>
    
    </div>
</div>

