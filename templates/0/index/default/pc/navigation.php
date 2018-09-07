<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>">
<script>
$(document).ready(function(){
	last_right=$('.nv_ul').width()-$("#<?php echo $module['module_name'];?> .nv_ul > li:last").offset().left;
	$("#<?php echo $module['module_name'];?> .nv ul li:last-child").children('ul').css('right',last_right);
	$("#<?php echo $module['module_name'];?> .nv ul li ul").each(function(index, element) {
        if($(this).children('li').length>3){
			$(this).addClass('multiple_columns');	
		}
    });
	if($("#<?php echo $module['module_name'];?> .nv_ul > li:last-child").children('ul').attr('class')=='multiple_columns'){
		
		$("#<?php echo $module['module_name'];?> .nv_ul > li:last-child").children('ul').css('right',last_right);
	}
	
	
	$("#<?php echo $module['module_name'];?> .multiple_columns li").each(function(index, element) {
        if($(this).children('ul').html()){
			$(this).addClass('have_three');	
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
				
				$(this).children('.multiple_columns').BlocksIt({
					numOfCol: 5,
					offsetX: 8,
					offsetY: 8,
					blockElement: 'li'
				});
			}
			$(this).children('.multiple_columns').css('left','0px');	
		}
			
	});
	if(touchAble){
		$("#<?php echo $module['module_name'];?> .nv_ul i").each(function(index, element) {
			if($(this).parent('a').next('ul').children('li').children('a').attr('href')!=$(this).parent('a').attr('href')){
				$(this).parent('a').next('ul').html('<li><a href='+$(this).parent('a').attr('href')+'>'+$(this).parent('a').children('span').html()+'</a></li>'+$(this).parent('a').next('ul').html());
				//alert($(this).parent('a').next('ul').html());
			}
        });
		$("#<?php echo $module['module_name'];?> .nv_ul i").parent('a').parent('li').hover(function(){
				$(this).parent('a').next().css('display','block');
			},function(){
				$(this).parent('a').next().css('display','none');	
		});	
		$("#<?php echo $module['module_name'];?> .nv_ul i").parent('a').click(function(){
			return false;
		});
		$("#<?php echo $module['module_name'];?> .nv_ul .fa-angle-down").parent('a').click(function(){
			if($(this).next('ul').children('li').children('a').attr('href')!=$(this).attr('href')){
				$(this).next('ul').html('<li><a href='+$(this).attr('href')+'>'+$(this).children('span').html()+'</a></li>'+$(this).next('ul').html());
			}
			return false;
		});
		$("#<?php echo $module['module_name'];?> .nv_ul .fa-angle-right").parent('a').click(function(){
			if($(this).next('ul').children('li').children('a').attr('href')!=$(this).attr('href')){
				$(this).next('ul').html('<li><a href='+$(this).attr('href')+'>'+$(this).children('span').html()+'</a></li>'+$(this).next('ul').html());
			}
			return false;
		});
	}
});
</script>
	<style>
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>  {}
#<?php echo $module['module_name'];?> .nv img{ display:none;}
#<?php echo $module['module_name'];?> .nv{ text-align:left; margin:0px; padding:0px; height:50px; height:3.572rem; line-height:50px;line-height:3.572rem;   font-size:1rem;   white-space:nowrap;}
#<?php echo $module['module_name'];?> .nv a{ white-space:nowrap;}
#<?php echo $module['module_name'];?> .nv .nv_ul{ width:100%;}
#<?php echo $module['module_name'];?> .nv > ul{  white-space:nowrap;}
#<?php echo $module['module_name'];?> .nv ul ul {display: none;}
#<?php echo $module['module_name'];?> .nv ul li:hover > ul {display: block;}
#<?php echo $module['module_name'];?> .nv ul {list-style: none;position: relative;display: inline-block;white-space:nowrap; z-index:9;}
#<?php echo $module['module_name'];?> .nv ul:after {content: ""; clear: both; display: block;}
#<?php echo $module['module_name'];?> .nv ul > li { display: inline-block;text-align: center; }
#<?php echo $module['module_name'];?> .nv ul li:hover {background:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
#<?php echo $module['module_name'];?> .nv ul li:hover a { color:#fff;}
#<?php echo $module['module_name'];?> .nv ul li a {display: block; text-decoration: none; padding-left:1.5rem; padding-right:1.5rem;}
#<?php echo $module['module_name'];?> .nv ul li a i{ padding-left:5px;}
#<?php echo $module['module_name'];?> .nv ul ul {line-height:40px;line-height:2.85rem;background:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; border-radius: 0px; padding: 0;position: absolute; top: 100%;}
#<?php echo $module['module_name'];?> .nv ul ul li { display:block; width:100%;float: none;position: relative; text-align:left;}
#<?php echo $module['module_name'];?> .nv ul ul li a {}	
#<?php echo $module['module_name'];?> .nv ul ul li a i{ float:right;line-height:40px;line-height:2.85rem; margin-left:10px;}
#<?php echo $module['module_name'];?> .nv ul ul li a .fa-angle-right{ padding-right:10px;	}
#<?php echo $module['module_name'];?> .nv ul ul li:hover {background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;}
#<?php echo $module['module_name'];?> .nv ul ul ul {width:100%;position: absolute; left: 100%; top:0; }
#<?php echo $module['module_name'];?> .nv ul ul ul li:hover{}
#<?php echo $module['module_name'];?> .nv ul li:last-child:hover >  ul li ul{ left:-100%; text-align:right;}
#<?php echo $module['module_name'];?> .nv ul li:last-child:hover >  ul li ul a{padding-right: 25px ;}

#<?php echo $module['module_name'];?> .nv ul li .have_three	{ font-weight:bold; margin-bottom:20px;  }
#<?php echo $module['module_name'];?> .nv ul li .have_three	li{ font-weight: normal;  }
#<?php echo $module['module_name'];?> .nv ul li .have_three:hover{ background:none; }
#<?php echo $module['module_name'];?> .nv ul li .have_three > a{ border-bottom:#fff 1px dashed;}
#<?php echo $module['module_name'];?> .nv ul li .have_three a:hover{background:#ff9900; }
#<?php echo $module['module_name'];?> .nv ul li .have_three	ul{background: #ff4a00;  }
#<?php echo $module['module_name'];?> .nv ul li .have_three	i{ display:none; }

#<?php echo $module['module_name'];?> .nv ul li .multiple_columns{ width:43rem; height:auto; white-space:normal; text-align:left; }
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li{display:inline-block;  height:auto; border-top:none; vertical-align:top; width:200px; padding-left:10px; }
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li a{ display:block; text-align:left;}
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li ul{ display:block; position:static;  height:auto; white-space:normal; }
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li ul li{  display:block; width:100%; height:32px; line-height:32px; height:2.3rem; line-height:2.3rem;}
#<?php echo $module['module_name'];?> .nv ul li:last-child:hover >  ul li ul a{padding-right: 25px ;}



#<?php echo $module['module_name'];?> #mall_type_all{    display:inline-block; vertical-align:top; width:17.95rem; text-align:left; font-size:18px; margin-right:20px;background:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; }
#<?php echo $module['module_name'];?> #mall_type_all a{ color:#fff;}
#<?php echo $module['module_name'];?> #mall_type_all:hover #mall_type_module_two{ display:block;}
#<?php echo $module['module_name'];?> #mall_type_all .text{ display:block;  padding-left:12px;}
#<?php echo $module['module_name'];?> #mall_type_all:hover{ }
#<?php echo $module['module_name'];?> #mall_type_module_two{ display:none; position:absolute; top:290px; left:6px; z-index:9999;}
</style>
    


    <div class=nv >
        <div class="container"><ul class=nv_ul ><li id=mall_type_all><a class=text href="./index.php?monxin=mall.show_type"><span>商品服务分类</span></a></li><?php echo $module['data'];?></ul></div>
    </div>
    
</div>