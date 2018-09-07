<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?> .search").focus();
	$("#<?php echo $module['module_name'];?> .append_option").css('width','500px').css('border','#F3F3F3 solid 4px');
	$("#<?php echo $module['module_name'];?> .append_option .goods_a").css('display','inline-block').css('padding','10px');
	
	$("#<?php echo $module['module_name'];?> .add_checkout").click(function(){
		g_id=$(this).parent().parent().attr('id');
		if($("#<?php echo $module['module_name'];?> #"+g_id).attr('class')!='goods'){
			if(!$("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id') || $("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id')==0){
				alert('<?php echo self::$language['please_select']?>'+$("#<?php echo $module['module_name'];?> #"+g_id+" .option_line_div .option_label").html()+' '+$("#<?php echo $module['module_name'];?> #"+g_id+" .color_line_div .color_label").html());
				return false;
			}
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			parent.add_checkout($("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id'),'s_id');
		}else{
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			parent.add_checkout(g_id.replace(/g_/,''),'g_id');
		}
		$(this).next().html('<span class=success><?php echo self::$language['success'];?></span>');
		return false;
	});
		$("#<?php echo $module['module_name'];?>_html .color_option a").click(function(){
			g_id=$(this).parent().parent().parent().parent().attr('id');
			
			if($(this).attr('class')=='selected'){
				$("#<?php echo $module['module_name'];?>_html .option_option a[class!='selected']").attr('class','');
				$(this).attr('class','');
				$("#color_selected_symbol").css('display','none');
				set_price_to_default(g_id);
				$("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id',0);
				
				return false;
			}			
			if($(this).attr('class')=='disable'){return false;}
			
			$("#<?php echo $module['module_name'];?>_html .color_option a[class!='disable']").attr('class','');
			$(this).attr('class','selected');
			img_path=$(this).children().attr('src');
			if(img_path){
				if(img_path.indexOf('img_thumb')!=-1){
					$("#<?php echo $module['module_name'];?> #"+g_id+" .goods_a img").attr('src',img_path.replace('img_thumb','img'));	
				}else{
					$("#<?php echo $module['module_name'];?> #"+g_id+" .goods_a img").attr('src',$("#<?php echo $module['module_name'];?> #"+g_id+" .goods_a img").attr('old'));
				}
			}else{
					$("#<?php echo $module['module_name'];?> #"+g_id+" .goods_a img").attr('src',$("#<?php echo $module['module_name'];?> #"+g_id+" .goods_a img").attr('old'));
			}
			if(getCookie('user_set_page_auto_size')=='1' && getCookie('monxin_device')=='pc' && $(window).width()<1319){
				$("#color_selected_symbol").css('display','none');
			}else{
				$("#color_selected_symbol").css('display','block').css('left',$(this).offset().left+$(this).width()-3).css('top',$(this).offset().top+27);			}
			
			if($("#<?php echo $module['module_name'];?>_html  #"+g_id+" .option_line_div").html()){
				set_price_inventory(g_id,$(this).attr('id'));
			}else{
				set_price_inventory2(g_id,$(this).attr('id'));
			}
			
			return false;	
		});
		
		
		$("#<?php echo $module['module_name'];?>_html .option_option a").click(function(){
			g_id=$(this).parent().parent().parent().parent().attr('id');
			if($(this).attr('class')=='selected'){
				$("#<?php echo $module['module_name'];?>_html .color_option a[class!='selected']").attr('class','');
				$(this).attr('class','');
				$("#option_selected_symbol").css('display','none');
				set_price_to_default(g_id);
				$("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id',0);
				return false;
			}
			if($(this).attr('class')=='disable'){return false;}
			$("#<?php echo $module['module_name'];?>_html .option_option a[class!='disable']").attr('class','');
			$(this).attr('class','selected');
			
			if(getCookie('user_set_page_auto_size')=='1' && getCookie('monxin_device')=='pc' && $(window).width()<1319){
				$("#option_selected_symbol").css('display','none');
			}else{
				$("#option_selected_symbol").css('display','block').css('left',$(this).offset().left+$(this).width()-5).css('top',$(this).offset().top+27);
			}
			
			
			if($("#<?php echo $module['module_name'];?>_html .color_option").html()){
				set_price_inventory(g_id,$(this).attr('id'));
			}else{
				set_price_inventory2(g_id,$(this).attr('id'));
			}
			return false;	
		});
		
	
	
	
	$("#<?php echo $module['module_name'];?> .search").keyup(function(event){
		if($(this).val()==''){return false;}
		if(event.keyCode==13 && $(this).val()!=''){
			window.location.href='./index.php?monxin=mall.checkout_search&search='+$(this).val();
		}
	});
	$("#<?php echo $module['module_name'];?> .search_div .submit").click(function(){
		window.location.href='./index.php?monxin=mall.checkout_search&search='+$("#<?php echo $module['module_name'];?> .search").val();
		return false;
	});
	
	var order=get_param('order');
	$("#<?php echo $module['module_name'];?>_html .left_label .order_div a").attr('class','order');
	 if(order!=''){
		$("a[desc='"+order+"']").attr('class','order_desc');
		$("a[asc='"+order+"']").attr('class','order_asc');			
	}else{
		$("a[desc='sequence|desc']").attr('class','order_desc');
	}
  	$("#<?php echo $module['module_name'];?>_html .left_label .order_div a").click(function(){
		url=window.location.href;
		if(order=='' || order!=$(this).attr('desc')){
			url=replace_get(url,"order",$(this).attr('desc'));
		}else{
			url=replace_get(url,"order",$(this).attr('asc'));	
		}
		window.location=url;	
		return false;
	});
	
	$("#<?php echo $module['module_name'];?>_html .left_label .set_price").click(function(){
		var min_price=$("#<?php echo $module['module_name'];?>_html .left_label #min_price").val();
		var max_price=$("#<?php echo $module['module_name'];?>_html .left_label #max_price").val();
		if(min_price>=max_price && (min_price!='' && max_price!='')){$(this).next().html('<span class=fail><?php echo self::$language['min_price']?><?php echo self::$language['must_be_less_than'];?><?php echo self::$language['max_price'];?></span>');$("#<?php echo $module['module_name'];?>_html .left_label #min_price").focus();return false;}
		url=window.location.href;
		url=replace_get(url,'min_price',min_price);
		url=replace_get(url,'max_price',max_price);
		window.location.href=url;	
		return false;	
	});
	
	function set_price_to_default(id){
		$("#<?php echo $module['module_name'];?> #"+id+" .price_span").html($("#<?php echo $module['module_name'];?> #"+id+" .price_span").attr('price'));
	}
	function set_price_inventory(g_id,id){
temp=$("#"+g_id+' .json').html();
		specifications=eval("("+temp+")");
		selected_option_id=$("#<?php echo $module['module_name'];?>_html .option_option .selected").attr('id');
		if(selected_option_id){selected_option_id=selected_option_id.replace(/option_/,'');}
		selected_color_id=$("#<?php echo $module['module_name'];?>_html .color_option .selected").attr('id');
		if(selected_color_id){selected_color_id=selected_color_id.replace(/color_/,'');}
		//alert(selected_option_id+','+selected_color_id);
		s_id=0;
		if(selected_option_id && selected_color_id){
			for( v in specifications ){
				if(specifications[v]['option_id']==selected_option_id && specifications[v]['color_id']==selected_color_id){s_id=v;break;}
			}	
		}
		//alert(specifications[s_id]['e_price']);
		if(s_id){
			$("#<?php echo $module['module_name'];?> #"+g_id+" .price_span").html('<span class=money_symbol><?php echo self::$language['money_symbol'];?></span><span class=money_value>'+specifications[s_id]['e_price']+'</span>');
			$("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id',s_id);
		}
		//alert(id.indexOf('color_'));
		if(id.indexOf('color_')==0){
			
			$("#<?php echo $module['module_name'];?>_html #"+g_id+" .option_option a").each(function(index, element) {
				exist_s=false;
				for( v in specifications ){
					if(specifications[v]['option_id']==$(this).attr('id').replace(/option_/,'') && specifications[v]['color_id']==id.replace(/color_/,'')){exist_s=true;break;}
				}
				if(exist_s){
					if($(this).attr('class')=='disable'){$(this).attr('class','');}	
				}else{
					$(this).attr('class','disable');
				}	
            });	
		}else{
			$("#<?php echo $module['module_name'];?>_html #"+g_id+" .color_option a").each(function(index, element) {
				exist_s=false;
				for( v in specifications ){
					if(specifications[v]['color_id']==$(this).attr('id').replace(/color_/,'') && specifications[v]['option_id']==id.replace(/option_/,'')){exist_s=true;break;}
				}
				if(exist_s){
					if($(this).attr('class')=='disable'){$(this).attr('class','');}	
				}else{
					$(this).attr('class','disable');
				}	
            });	
		}
	}
	function set_price_inventory2(g_id,id){
		specifications=eval('('+$("#"+g_id+' .json').html()+')');
		temp=id.replace(/color_/,'');
		temp=temp.replace(/option_/,'');
		s_id=0;
		if(id.indexOf('color_')==0){
			index_key='color_id';
		}else{
			index_key='option_id';
		}
		
		for( v in specifications ){
			if(specifications[v][index_key]==temp){s_id=v;break;}
		}
		
		if(s_id){
			$("#<?php echo $module['module_name'];?> #"+g_id+" .price_span").html('<span class=money_symbol><?php echo self::$language['money_symbol'];?></span><span class=money_value>'+specifications[s_id]['e_price']+'</span>');
			$("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id',s_id);
		}
	}



	function add_checkout(id,price){
		//alert(id+','+price);
		var old_cart=getCookie('mall_cart');
		if(old_cart!=''){
			old_cart=old_cart.replace(/%3A/g,':');
			old_cart=old_cart.replace(/%2C/g,',');
			//alert(old_cart);
			old_cart=eval('('+old_cart+')');
			if(old_cart[id]){
				old_cart[id]['quantity']=parseInt(old_cart[id]['quantity'])+1;	
			}else{
				old_cart[id]=new Array();
				old_cart[id]['quantity']=1;		
				old_cart[id]['price']=price;		
			}
			old_cart[id]['time']=Date.parse(new Date());
			str='';
			for(v in old_cart){
				str+='"'+v+'":{"quantity":"'+old_cart[v]['quantity']+'","time":"'+old_cart[v]['time']+'","price":"'+old_cart[v]['price']+'"},';	
			}
			str=str.substring(0,str.length-1);
			str='{'+str+'}';
		}else{
			str='{"'+id+'":{"quantity":"1","time":"'+Date.parse(new Date())+'","price":"'+price+'"}}';
		}
		//alert(str);
		setCookie('mall_cart',str,30);
		try{update_cart_goods_sum();}catch(e){}
		$.get("./receive.php?target=mall::cart&act=update_cart");
	}
	
});

</script>

<style>
.page-header{ display:none;}
.fixed_right_div{ display:none;}
#layout_full{ }
.container{ width:100%; padding:0px; margin:0px;}
#<?php echo $module['module_name'];?>{ min-height:520px;}
#<?php echo $module['module_name'];?>_html{}
#<?php echo $module['module_name'];?>_html .list{  border:1px solid #e7e7e7; padding-bottom:20px;}
#<?php echo $module['module_name'];?>_html .list .m_label_div{ display:inline-block; vertical-align:top; height:5rem;line-height:5rem;  border-bottom:1px solid #e7e7e7; width:100%;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label{ display:inline-block; vertical-align:top; width:80%; overflow:hidden; height:5rem; line-height:5rem; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div{display:inline-block; vertical-align:top;line-height:5rem;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div a{ display:inline-block; vertical-align:top; padding-right:20px; font-size:20px;  padding-left:20px;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div a:after {font: normal normal normal 20px/1 FontAwesome;margin-left:5px;	content: "\f0dc";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .current{ }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order{display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order:hover{ }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc{display:inline-block; vertical-align:top;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc{display:inline-block; vertical-align:top;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc:after{font: normal normal normal 20px/1 FontAwesome;margin-left:5px;content: "\f0d8";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc:after{font: normal normal normal 20px/1 FontAwesome;	margin-left:5px;	content: "\f0d7";}




#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .price_set_div{display:inline-block; vertical-align:top; margin-left:30px;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .price_set_div input{ width: 60px;vertical-align: middle;text-align: center;margin: 5px;line-height: 40px;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label{ display:inline-block; vertical-align:top; width:20%; text-align:right; overflow:hidden; line-height:5rem; height:5rem;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label a{ display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_grid{ display:inline-block; vertical-align:top; line-height:5rem; height:5rem; width:5rem;  text-align: center; padding-top:0.5rem; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_grid_default{ border:1px solid #e7e7e7; border-top:none;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_grid_default:hover{ border:1px solid #e7e7e7; border-top:none;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_grid_current{ border:1px solid #e7e7e7; border-top:none; text-align:center;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_grid:before {font: normal normal normal 2.2rem/1 FontAwesome;content: "\f009";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_line{ display:inline-block; vertical-align:top; height:5rem; width:5rem; line-height:5rem; text-align: center; padding-top:0.5rem;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_line:hove{}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label #show_line:before {font: normal normal normal 2.2rem/1 FontAwesome; content: "\f0c9";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_line_default{}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_line_default:hover{}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label .show_line_current{ }


#<?php echo $module['module_name'];?>_html .list .goods_list{}



#<?php echo $module['module_name'];?>_html .list .goods_list .goods{ display:inline-block; vertical-align:top; vertical-align:top; width:190px; min-height:300px; overflow:hidden; margin:1rem; margin-bottom:0px; border:4px solid #fff;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:hover{ border:4px solid #e7e7e7;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods:hover .button_div{ display:block;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a{ display:block; text-align:center; width:160px; margin:auto; padding-bottom:15px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a img{ width:160px; height:160px; margin-top:15px; border:none;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .title{ display:block; text-align:left;  height:28px; line-height:28px; overflow:hidden; font-size:15px;  width:160px; margin:auto;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span{ display:block; text-align:left; height:28px; line-height:28px; overflow:hidden;  font-size:15px; width:160px; margin:auto;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span .money_symbol{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .price_span .money_value{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div{ display:block;height:28px; line-height:28px; overflow:hidden;  font-size:1rem; width:160px; margin:auto; font-family:Georgia;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly{ text-align:left; display:inline-block; vertical-align:top; width:60%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly .m_label{ }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .monthly .value{ padding-left:5px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction{display:inline-block; vertical-align:top; width:40%; text-align:right; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction .m_label{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .goods_a .sum_div .satisfaction .value{}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div{ display:none; width:160px; margin:auto; white-space:nowrap;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div a{ }
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .view{ font-size:15px;}

#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .add_checkout{display:inline-block; vertical-align:top; float:right; display:inline-block; vertical-align:top; height:2rem; line-height:2rem; border-radius:2px;font-size:1rem;  padding-right:10px;}
#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div .add_checkout:hover{ opacity:0.9;}

#<?php echo $module['module_name'];?>_html .list .goods_list .goods .button_div  .add_checkout:before {font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; padding:0 5px 0 10px;}


#<?php echo $module['module_name'];?>_html .search_div{ text-align:left; padding-bottom:10px; }
#<?php echo $module['module_name'];?>_html .search_div .search{ width:40%; padding-left:5px; line-height:2.5rem; height:2.5rem; font-size:1.5rem;}
	
	.append_option{ width:500px; overflow:visible; white-space:nowrap; }
	.append_option .goods_a{ display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .specifications{ display:inline-block; vertical-align:top; margin-left:1rem;}
	#<?php echo $module['module_name'];?>_html .specifications .color_label{}
	#<?php echo $module['module_name'];?>_html .specifications .color_line_div{ margin-top:20px; margin-bottom:20px;}
	#<?php echo $module['module_name'];?>_html .specifications .color_option{ line-height:3rem; }
	#<?php echo $module['module_name'];?>_html .specifications .color_option a{ margin-left:4px; margin-right:4px; display:inline-block; vertical-align:top; line-height:30px;vertical-align:top; border:1px solid #ccc; overflow:hidden; padding:5px;  margin-bottom:10px;}
	#<?php echo $module['module_name'];?>_html .specifications .color_option a:hover{ border:1px solid #ff3200; }
	#<?php echo $module['module_name'];?>_html .specifications .color_option a:hover img{}
	#<?php echo $module['module_name'];?>_html .specifications .color_option .selected{border:1px solid #ff3200;}
	#<?php echo $module['module_name'];?>_html .specifications .color_option .disable{ opacity:0.1; filter:alpha(opacity=10); cursor:default;}
	#<?php echo $module['module_name'];?>_html .specifications .color_option .disable:hover{ border:1px solid #ccc;}
	#<?php echo $module['module_name'];?>_html .specifications .color_option a img{ height:30px; width:30px;}
	
	
	#<?php echo $module['module_name'];?>_html .specifications .json{ display:none;}
	#<?php echo $module['module_name'];?>_html .specifications .option_label{}
	#<?php echo $module['module_name'];?>_html .specifications .option_line_div{ margin-top:20px; margin-bottom:20px;}
	#<?php echo $module['module_name'];?>_html .specifications .option_option{ }
	#<?php echo $module['module_name'];?>_html .specifications .option_option a{ margin-bottom:10px;  margin-left:4px; margin-right:4px; padding-left:4px; padding-right:4px; display:inline-block; vertical-align:top; line-height:40px; height:40px; vertical-align:top;  overflow:hidden; border:1px solid #ddd;}
	#<?php echo $module['module_name'];?>_html .specifications .option_option a:hover{ border:1px solid #ff3200;}
	#<?php echo $module['module_name'];?>_html .specifications .option_option .selected{ border:1px solid #ff3200;}
	#<?php echo $module['module_name'];?>_html .specifications .option_option .disable{ opacity:0.1; filter:alpha(opacity=10); cursor:default;}
	#<?php echo $module['module_name'];?>_html .specifications .option_option .disable:hover{ border:1px solid #ccc;}
	
</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
<div id=color_selected_symbol> </div><div id=option_selected_symbol> </div>
<div class=search_div><input type="text"  class=search value="<?php echo @$_GET['search']?>" /> <a href="#" class="submit"><?php echo self::$language['search'];?></a></div>
    <div class=content>
		<div class=list>
			<div class=m_label_div>
            	<div class=left_label>
                	<div class=order_div>
                    	<a href=# desc="sequence|desc" class="sorting"  asc="sequence|asc" ><?php echo self::$language['default'];?></a><a href=# desc="monthly|desc" class="sorting"  asc="monthly|asc" ><?php echo self::$language['monthly'];?></a><a href=# desc="w_price|desc" class="sorting"  asc="w_price|asc" ><?php echo self::$language['price'];?></a><a href=# desc="satisfaction|desc" class="sorting"  asc="satisfaction|asc" ><?php echo self::$language['satisfaction'];?></a>
                    </div><div class=price_set_div>
                    	<?php echo self::$language['price_range'];?><input type="text" id=min_price value="<?php echo @$_GET['min_price'];?>" /> - <input type="text" id=max_price value="<?php echo @$_GET['max_price'];?>"  /> <a href="#" class=set_price><?php echo self::$language['submit'];?></a> <span></span>
                    </div>
                </div>
            </div>
			<div class=goods_list><?php echo $module['list'];?></div>
        </div>
    </div>
    <?php echo $module['page']?>
</div>
</div>