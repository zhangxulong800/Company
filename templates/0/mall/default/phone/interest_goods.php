<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left>
<script>
var credits_rate=<?php echo $module['credits_rate']?>;
$(document).ready(function(){
	
	$("#<?php echo $module['module_name'];?> .price_span").each(function(index, element) {
        v=parseFloat($(this).children('.money_value').html())*credits_rate;
		$(this).after("<span class=yuan_2>"+v.toFixed(2)+"<?php echo self::$language['yuan_2']?></span>");
    });
	/*
	v=$("#<?php echo $module['module_name'];?> .goods_list .goods").length%3;
	if(v==1){$("#<?php echo $module['module_name'];?> .goods_list .goods:last-child").css('display','none');}
	if(v==2){
		$("#<?php echo $module['module_name'];?> .goods_list .goods:last-child").css('display','none');
		$("#<?php echo $module['module_name'];?> .goods_list .goods:last-child").prev().css('display','none');
	}
	*/
	
});

</script>

<style>

#middle_malllayout_inner {background:none;}
.container{ background:<?php echo $_POST['monxin_user_color_set']['container']['background']?> !important;}
#<?php echo $module['module_name'];?> {background:none; margin-top:1rem; white-space:normal; padding:0px; clear:both; }
#<?php echo $module['module_name'];?> a{ }
#<?php echo $module['module_name'];?> k{ }
#<?php echo $module['module_name'];?>_html{}

#<?php echo $module['module_name'];?>_html .list .goods_list{}

#<?php echo $module['module_name'];?>_html .module_title_div{  line-height:2rem; border-bottom:1px solid #E6E6E6;}
#<?php echo $module['module_name'];?>_html .module_title_div .name{padding-left:0.5rem; font-size:1rem;}
#<?php echo $module['module_name'];?>_html .module_title_div .name:hover{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> !important;}
#<?php echo $module['module_name'];?>_html .module_title_div .more{ float:right; padding-right:0.5rem;}
#<?php echo $module['module_name'];?>_html .module_title_div .more:hover{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> !important;}
#<?php echo $module['module_name'];?>_html .content{ overflow-x:scroll; background:#fff;}
#<?php echo $module['module_name'];?>_html .list .goods_list { white-space:nowrap;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods{ display:inline-block; vertical-align:top; vertical-align:top;  width:30%; height:11.2rem;  overflow:hidden; border:1px solid #fff; margin:1.5%; background:#fff;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:hover{ border:1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:hover .button_div{ display:block;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a{ display:block; text-align:center;margin:auto; padding-bottom:15px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a img{  height:6rem; margin-top:0.3rem; border:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .title{ display:block; text-align:center; padding-left:5px;  height:2rem; line-height:2rem; font-size:1rem; overflow:hidden; margin:auto;white-space: nowrap;text-overflow: ellipsis;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span{ display:block; padding-left:4px; text-align:left;height:1.3rem; line-height:1.3rem; overflow:hidden;  font-size:0.9rem; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> !important; }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span .money_symbol{font-size:0.8rem; padding-left:2px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span .money_value{font-size:1rem;}
#<?php echo $module['module_name'];?>_html .yuan_2{ display:block; text-align:left; padding-left:4px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;height:1.2rem; line-height:1.2rem; font-size:0.8rem;}

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
    <div class=module_title_div><a href="./index.php?monxin=mall.interest_goods_list" class=name><?php echo self::$language['functions']['mall.interest_goods']['description']?></a><a  href="./index.php?monxin=mall.interest_goods_list" class=more><?php echo self::$language['more']?></a></div>
    <div class=content>
		<div class=list>
			<div class=goods_list><?php echo $module['list'];?></div>
        </div>
    </div>
</div>
</div>