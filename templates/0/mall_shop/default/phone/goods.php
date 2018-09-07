<div id=<?php echo $module['module_name'];?>  save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script>
	var credits_rate=<?php echo $module['credits_rate']?>;
	function show_yuan(){
		v=parseFloat($('#<?php echo $module['module_name'];?> .price_value').html())*credits_rate;
		$("#<?php echo $module['module_name'];?> .price_div >div >span:last").after("<span class=yuan_2>"+v.toFixed(2)+"<?php echo self::$language['yuan_2']?><?php echo self::$language['more_than']?></span>");
	}

	function get_share_img(){
		if(get_param('monxin')==''){
			imgUrl='http://'+window.location.host+'/phone_menu_icon.png';
		}else{
			first_img='';
			$(".swiper-slide img").each(function(index, element) {
				if($(this).attr('src').length>10){first_img=$(this).attr('src');return false;}
			});
			if(first_img.length>10){
				imgUrl='http://'+window.location.host+'/'+first_img;
			}else{
				imgUrl='http://'+window.location.host+'/phone_menu_icon.png';
			}
		}
		//alert(imgUrl);
		return  imgUrl;
	}

	function set_price_inventory(id){
		$("#<?php echo $module['module_name'];?> .add_cart").html('<?php echo self::$language['add_cart']?>');
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
				
			temp='<?php echo self::$language['selected']?>'+$("#<?php echo $module['module_name'];?>_html .color_option .selected").attr('title')+'、'+$("#<?php echo $module['module_name'];?>_html .option_option .selected").html();
			$("#<?php echo $module['module_name'];?>_html #s_select_state span span").html(temp);	
		}else{
			if(selected_option_id){
				
				temp='<?php echo self::$language['selected']?>'+$("#<?php echo $module['module_name'];?>_html .option_option .selected").html()+',<?php echo self::$language['select_2']?>'+$("#<?php echo $module['module_name'];?>_html .color_label").html();
				$("#<?php echo $module['module_name'];?>_html #s_select_state span span").html(temp);	
			}else{
				
				temp='<?php echo self::$language['selected']?>'+$("#<?php echo $module['module_name'];?>_html .color_option .selected").attr('title')+',<?php echo self::$language['select_2']?>'+$("#<?php echo $module['module_name'];?>_html .option_label").html();
				$("#<?php echo $module['module_name'];?>_html #s_select_state span span").html(temp);	
			}
		}
		
		if(s_id){
			if($("#have_discount").html()){
				$("#have_discount .discount_price .price_value").html(specifications[s_id]['w_price']*$("#have_discount .discount_number").html()/10);
				$("#have_discount .discount_price .price_value").html(parseFloat($("#have_discount .discount_price .price_value").html()).toFixed(2));
				$(".goods_option_div .goods_content .price").html($("#have_discount .discount_price .price_value").html());
				$("#have_discount .normal_price .price_value").html(specifications[s_id]['w_price']);
			}else{
				$("#no_discount .price_value").html(specifications[s_id]['w_price']);
				$(".goods_option_div .goods_content .price").html($("#no_discount .price_value").html());
			}
			$(".inventory_m").html(specifications[s_id]['quantity']);
			format_quantity();
		}
		//alert(id.indexOf('color_'));
		if(id.indexOf('color_')==0){
			$("#<?php echo $module['module_name'];?>_html .option_option a").each(function(index, element) {
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
			$("#<?php echo $module['module_name'];?>_html .color_option a").each(function(index, element) {
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
		set_credits_value();
	}
	function set_price_inventory2(id){
		$("#<?php echo $module['module_name'];?> .add_cart").html('<?php echo self::$language['add_cart']?>');
		temp=id.replace(/color_/,'');
		temp=temp.replace(/option_/,'');
		s_id=0;
		if(id.indexOf('color_')!=-1){
			index_key='color_id';
			$("#<?php echo $module['module_name'];?>_html #s_select_state span span").html('<?php echo self::$language['selected']?>'+$("#<?php echo $module['module_name'];?>_html .color_option .selected").attr('title'));	

		}else{
			index_key='option_id';
			$("#<?php echo $module['module_name'];?>_html #s_select_state span span").html('<?php echo self::$language['selected']?>'+$("#<?php echo $module['module_name'];?>_html .option_option .selected").html());	
		}
		for( v in specifications ){
			if(specifications[v][index_key]==temp){s_id=v;break;}
		}
		if(s_id){
			if($("#have_discount").html()){
				$("#have_discount .discount_price .price_value").html(specifications[s_id]['w_price']*$("#have_discount .discount_number").html()/10);
				$("#have_discount .discount_price .price_value").html(parseFloat($("#have_discount .discount_price .price_value").html()).toFixed(2));
				$("#have_discount .normal_price .price_value").html(specifications[s_id]['w_price']);
				$(".goods_option_div .goods_content .price").html(specifications[s_id]['w_price']);
			}else{
				$("#no_discount .price_value").html(specifications[s_id]['w_price']);
				$(".pre_price .price_value").html(specifications[s_id]['pre_price']);
				$(".old_price .value").html(specifications[s_id]['w_price']);
				
				$(".goods_option_div .goods_content .price").html(specifications[s_id]['w_price']);
			}
			$(".inventory_m").html(specifications[s_id]['quantity']);
			format_quantity();
		}
		set_credits_value();
	}
	function set_price_to_default(){
		$("#<?php echo $module['module_name'];?> .add_cart").html('<?php echo self::$language['add_cart']?>');
		if($("#have_discount").html()){
			$("#have_discount .discount_price .price_value").html(have_discount_discount_price);
			$("#have_discount .normal_price .price_value").html(have_discount_normal_price);
			$(".goods_option_div .goods_content .price").html($("#have_discount .discount_price .price_value").html());
		}else{
			
			$("#no_discount .price_value").html(no_discount_price_value);
			$(".pre_price .price_value").html($(".pre_price .price_value").attr('old'));
			$(".old_price .value").html($(".old_price .value").attr('old'));
			if($(".pre_price .price_value").html()){
				$(".goods_option_div .goods_content .price").html($(".pre_price .price_value").html());
			}else{
				$(".goods_option_div .goods_content .price").html(no_discount_price_value);
			}
		}
		$(".inventory_m").html('<?php echo $module['inventory'];?>');
		set_credits_value();
	}
	
	function set_credits_value(){
		return false;
	}
	
	var have_discount_discount_price;
	var have_discount_normal_price;
	var no_discount_price_value;
	var s_id=0;
	if(''!='<?php echo @$module['specifications'];?>'){var specifications=eval('(<?php echo @$module['specifications'];?>)');}
    $(document).ready(function(){
		
		if(<?php echo $module['data']['online_forbid']?>==1){
			$("#<?php echo $module['module_name'];?> .goods_bottom_div .buy_now").css('display','none');
			$("#<?php echo $module['module_name'];?> .goods_bottom_div .add_cart").css('display','none');
			$("#<?php echo $module['module_name'];?> .goods_bottom_div").html($("#<?php echo $module['module_name'];?> .goods_bottom_div").html()+'<?php echo self::$language['just_show_it']?>');
		}
		
		if($("#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .fulfil_preferential .fulfil_value").html()){
			$("#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .fulfil_preferential").css('display','block');
		}
		
		
		if(<?php echo $module['data']['share']?>==1){
			$("#<?php echo $module['module_name'];?> .goods_bottom_div,.position").css('display','none');
		}
		if($("#<?php echo $module['module_name'];?> .s_logo").attr('href')){
			$("#<?php echo $module['module_name'];?> .enter_store").attr('href',$("#<?php echo $module['module_name'];?> .s_logo").attr('href'));	
		}
		//$("#<?php echo $module['module_name'];?> .talk").attr('href',$("#<?php echo $module['module_name'];?> .talks a:first-child").attr('href'));
		//$("#<?php echo $module['module_name'];?> .talk").attr('talk',$("#<?php echo $module['module_name'];?> .talks a:last-child").attr('talk'));
		$(".monxin_head .refresh").css('display','none');
		$(".monxin_head .page_name").html('<?php echo self::$language['pages']['mall.goods']['name']?>');
		$(".monxin_head").append('<a href=./index.php class=home><?php echo self::$language['home']?></a>');
		$(".monxin_head").css('display','block');	
		$(".page-container").css('padding-top',$(".monxin_head").height());	
		set_credits_value();
		if(<?php echo $module['data']['state']?>==1){
			$("#<?php echo $module['module_name'];?> .add_cart").css('display','none');	
			$("#<?php echo $module['module_name'];?> .buy_now").html('<?php echo self::$language['goods_state_act'][1]?>').css('width','66.66%');
		}
		if(<?php echo $module['data']['state']?>==3){
			$("#<?php echo $module['module_name'];?> .add_cart").css('display','none');	
			$("#<?php echo $module['module_name'];?> .buy_now").html('<?php echo self::$language['goods_state_act'][3]?>').css('width','66.66%');
		}
		
		$("#<?php echo $module['module_name'];?> .pre_sale_rules").appendTo(".price_div");
		
		$("#<?php echo $module['module_name'];?> .pre_sale_rules").click(function(){
			if($(".pre_sale_rules_description").css('display')=='block'){
				$(".pre_sale_rules_description").css('display','none');
			}else{
				$(".pre_sale_rules_description").css('display','block');	
			}
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> #s_select_state").click(function(){
			show_goods_option_div(1);
			return false;	
		});
		
		function show_goods_detail_img(){
			$("#goods_detail_html img").each(function(index, element) {
			   if($(window).scrollTop()+($(window).height()*1.5)>$(this).offset().top){$(this).attr('src',$(this).attr('wsrc'));}
			});	
		}
		
		$(window).scroll(function(){
			show_goods_detail_img();
		});
		show_goods_detail_img();
			
		$("#<?php echo $module['module_name'];?> .favorite").click(function(){
			if($(this).html()!='<?php echo self::$language['favorite'];?>'){return true;}
			//$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=add_favorite',function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				if(v.info=='login'){window.location.href='./index.php?monxin=index.login';return false;}
				monxin_alert(v.info);
				//if(v.state=='success'){monxin_alert(v.info);}
				//$("#<?php echo $module['module_name'];?> .add_favorite").attr('href','./index.php?monxin=mall.my_collect');
				if(v.state=='success'){$("#<?php echo $module['module_name'];?> .favorite").html('<a href="./index.php?monxin=mall.my_collect"><?php echo self::$language['view']?></a>');}
				
				
			});
			return false;	
		});
		 $("#<?php echo $module['module_name'];?> .comment_label a").click(function(){
				$("#<?php echo $module['module_name'];?> .comment_label a").attr('class','');
				$("#<?php echo $module['module_name'];?> .comment_content .comment_page_div").css('display','none');
				$("#<?php echo $module['module_name'];?> #div_"+$(this).attr('id')).css("display",'block');
		 		$(this).attr('class','selected');
				return false;
		 });
		 if(<?php echo $module['data']['sum_comment']?>> $("#<?php echo $module['module_name'];?> .comment_content #div_comment_all .cooment_line").length){
			$("#<?php echo $module['module_name'];?> .comment_content #div_comment_all .comment_page").css('display','block'); 
		 }
		 if(<?php echo $module['data']['comment_0']?>> $("#<?php echo $module['module_name'];?> .comment_content #div_comment_0 .cooment_line").length){
			$("#<?php echo $module['module_name'];?> .comment_content #div_comment_0 .comment_page").css('display','block'); 
		 }
		 if(<?php echo $module['data']['comment_1']?>> $("#<?php echo $module['module_name'];?> .comment_content #div_comment_1 .cooment_line").length){
			$("#<?php echo $module['module_name'];?> .comment_content #div_comment_1 .comment_page").css('display','block'); 
		 }
		 if(<?php echo $module['data']['comment_2']?>> $("#<?php echo $module['module_name'];?> .comment_content #div_comment_2 .cooment_line").length){
			$("#<?php echo $module['module_name'];?> .comment_content #div_comment_2 .comment_page").css('display','block'); 
		 }
		
		$("#<?php echo $module['module_name'];?> .comment_content .comment_page").click(function(){
			$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=get_comment&level='+$(this).parent().attr('id').replace(/div_comment_/,''),{last_id:$(this).prev().attr('id')}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                if(v.html!=''){
					$(v.html).insertBefore("#<?php echo $module['module_name'];?> .comment_content #div_comment_"+v.level+" .comment_page");
                	$("#<?php echo $module['module_name'];?> .comment_content #div_comment_"+v.level+" .comment_page").html('<?php echo self::$language['more'];?>');
                }else{
					$("#<?php echo $module['module_name'];?> .comment_content #div_comment_"+v.level+" .comment_page").attr('class','').html('<?php echo self::$language['without']?>');
				}
            });
			return false;	
		});
			
		$("#<?php echo $module['module_name'];?> #sold_div .sold_page").click(function(){
			$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=get_sold',{last_id:$("#<?php echo $module['module_name'];?>  #sold_table tr").last().attr('id')}, function(data){
				//alert(data);
                if(data!=''){
					$(data).insertAfter("#<?php echo $module['module_name'];?>  #sold_table #"+$("#<?php echo $module['module_name'];?>  #sold_table tr").last().attr('id'));
                	$("#<?php echo $module['module_name'];?> #sold_div .sold_page").html('<?php echo self::$language['more'];?>');
                }else{
					$("#<?php echo $module['module_name'];?> #sold_div .sold_page").html('<?php echo self::$language['without']?>');
				}
            });
			return false;	
		});
			
		
		
		
		if(specifications){
			
			temp='<?php echo self::$language['select_2']?>:'+$("#<?php echo $module['module_name'];?>_html .color_label").html()+'、'+$("#<?php echo $module['module_name'];?>_html .option_label").html();
			temp=temp.replace(/、null/,'');
			temp=temp.replace(/null、/,'');
			temp=temp.replace(/、undefined/,'');
			temp=temp.replace(/undefined、/,'');
			$("#<?php echo $module['module_name'];?>_html #s_select_state span span").html(temp);	
			$("#<?php echo $module['module_name'];?>_html #s_select_state").css('display','block');
		}
		
		if($("#have_discount").html()){
			have_discount_discount_price=$("#have_discount .discount_price .price_value").html();
			have_discount_normal_price=$("#have_discount .normal_price .price_value").html();
		}else{
			no_discount_price_value=$("#no_discount .price_value").html();
		}
		
		
		$("#<?php echo $module['module_name'];?>_html #auto_width_div a:first").attr('class','current');
		$("#<?php echo $module['module_name'];?>_html .color_option a").click(function(){
			if($(this).attr('class')=='selected'){
				$("#<?php echo $module['module_name'];?>_html .option_option a[class!='selected']").attr('class','');
				$(this).attr('class','');
				set_price_to_default();
				s_id=0;
				temp='<?php echo self::$language['select_2']?>:'+$("#<?php echo $module['module_name'];?>_html .color_label").html();
				$("#<?php echo $module['module_name'];?>_html #s_select_state span span").html(temp);	
				return false;
			}			
			if($(this).attr('class')=='disable'){return false;}
			
			$("#<?php echo $module['module_name'];?>_html .color_option a[class!='disable']").attr('class','');
			$(this).attr('class','selected');
			
			
			
			
			if($("#<?php echo $module['module_name'];?>_html .option_option").html()){
				set_price_inventory($(this).attr('id'));
			}else{
				set_price_inventory2($(this).attr('id'));
			}
			
			return false;	
		});
		$("#<?php echo $module['module_name'];?>_html .option_option a").click(function(){
			if($(this).attr('class')=='selected'){
				$("#<?php echo $module['module_name'];?>_html .color_option a[class!='selected']").attr('class','');
				$(this).attr('class','');
				set_price_to_default();
				s_id=0;
				temp='<?php echo self::$language['select_2']?>:'+$("#<?php echo $module['module_name'];?>_html .option_label").html();
				$("#<?php echo $module['module_name'];?>_html #s_select_state span span").html(temp);	
				return false;
			}
			if($(this).attr('class')=='disable'){return false;}
			$("#<?php echo $module['module_name'];?>_html .option_option a[class!='disable']").attr('class','');
			$(this).attr('class','selected');
			
			
			
			
			
			if($("#<?php echo $module['module_name'];?>_html .color_option").html()){
				set_price_inventory($(this).attr('id'));
			}else{
				set_price_inventory2($(this).attr('id'));
			}
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .quantity_div .quantity_value a").click(function(){
			if($(this).attr('class')=='decrease_quantity'){
				$("#<?php echo $module['module_name'];?> .quantity_div .quantity_value #quantity").val(parseFloat($("#<?php echo $module['module_name'];?> .quantity_div .quantity_value #quantity").val())-1);
				 format_quantity();
			}else{
				$("#<?php echo $module['module_name'];?> .quantity_div .quantity_value #quantity").val(parseFloat($("#<?php echo $module['module_name'];?> .quantity_div .quantity_value #quantity").val())+1);
				 format_quantity();
			}
			return false;	
		})
		$("#<?php echo $module['module_name'];?> .quantity_div .quantity_value #quantity").change(function(){
			format_quantity();
		});
		
		$("#<?php echo $module['module_name'];?>_html .add_cart").click(function(){
			if($(this).html()=='<?php echo self::$language['add_cart']?>'){
				if('<?php echo $module['shop_master']?>'=='<?php echo $module['username'];?>'){alert('<?php echo self::$language['can_not_buy_your_goods']?>');return false;}
				if(specifications){
					if(s_id==0){
						show_goods_option_div(1);
						if($("#<?php echo $module['module_name'];?> .goods_option_div").css('right')=='0px'){
							$("#<?php echo $module['module_name'];?>_html #s_select_state").addClass('flash animated tips');
							setTimeout(function(){$("#<?php echo $module['module_name'];?>_html #s_select_state").removeClass('flash animated tips');;},1000);
						}
						return false;
					}				
				}
				
				if(parseFloat($(".inventory_m").html())==0){alert('<?php echo self::$language['inventory_shortage_cannot_buy'];?>');return false;}
				$("#<?php echo $module['module_name'];?>_html .add_cart").html("<span class=\'fa fa-spinner fa-spin\'></span>");
				$("#<?php echo $module['module_name'];?>_html .add_cart").html('<div class=cart_state><span class=success><?php echo self::$language['success'];?></span><a href="./index.php?monxin=mall.my_cart"><?php echo self::$language['view']?></a></div>');
				$("#<?php echo $module['module_name'];?>_html .cart_state").addClass('bounce animated infinite');
				window.setTimeout(remove_cart_state_animate,1000); 
				if(s_id){
					add_cart('<?php echo $_GET['id'];?>_'+s_id,$("#<?php echo $module['module_name'];?>_html .quantity_div #quantity").val());
				}else{
					add_cart('<?php echo $_GET['id'];?>',$("#<?php echo $module['module_name'];?>_html .quantity_div #quantity").val());
				}
				return false;	
			}
		});
		
		$("#<?php echo $module['module_name'];?>_html .buy_now").click(function(){
			if(specifications){
				if(s_id==0){
					show_goods_option_div(1);
					if($("#<?php echo $module['module_name'];?> .goods_option_div").css('right')=='0px'){
						setTimeout(function(){$("#<?php echo $module['module_name'];?>_html #s_select_state").removeClass('flash animated tips');},1000);
						$("#<?php echo $module['module_name'];?>_html #s_select_state").addClass('flash animated tips');
					}
					return false;
				}
				
				$(this).attr('href',$(this).attr('href')+'&s_id='+s_id);				
			}
			if(parseFloat($(".inventory_m").html())==0 && <?php echo $module['data']['state']?>==2){alert('<?php echo self::$language['inventory_shortage_cannot_buy'];?>');return false;}
			$(this).attr('href',$(this).attr('href')+'&quantity='+$("#<?php echo $module['module_name'];?>_html .quantity_div #quantity").val());				
			
		});
		
		$("#<?php echo $module['module_name'];?>_html #m_label_div a").click(function(){
			$("#<?php echo $module['module_name'];?>_html #m_label_div a").attr('class','');
			id=$(this).attr('id');
			$(this).attr('class','current');
			switch(id){
				case 'detail_label':
				 	$("#<?php echo $module['module_name'];?>_html #sold_div").css('display','block');
				 	$("#<?php echo $module['module_name'];?>_html #goods_detail").css('display','block');
				 	$("#<?php echo $module['module_name'];?>_html #comment_div").css('display','block');
				  break;
				case 'sold_label':
				 	$("#<?php echo $module['module_name'];?>_html #sold_div").css('display','block');
				 	$("#<?php echo $module['module_name'];?>_html #goods_detail").css('display','none');
				 	$("#<?php echo $module['module_name'];?>_html #comment_div").css('display','none');
				  break;
				case 'comment_label':
				 	$("#<?php echo $module['module_name'];?>_html #sold_div").css('display','none');
				 	$("#<?php echo $module['module_name'];?>_html #goods_detail").css('display','none');
				 	$("#<?php echo $module['module_name'];?>_html #comment_div").css('display','block');
				  break;
			}			
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .goods_option_div .goods_content img").attr('src',$("#<?php echo $module['module_name'];?> .swiper-wrapper img:first-child").attr('src'));
		$("#<?php echo $module['module_name'];?> .goods_option_div .goods_content .title").html($("#<?php echo $module['module_name'];?> #act_div .title").html());
		set_price_to_default();		
		$("#<?php echo $module['module_name'];?> .return_goods").click(function(){
			show_goods_option_div(0);
			return false;	
		});
		show_yuan();
		
		$.get("<?php echo $module['count_url']?>");
    });
	
	function remove_cart_state_animate(){
		$("#<?php echo $module['module_name'];?>_html .cart_state").removeClass('bounce animated infinite');
		$("#<?php echo $module['module_name'];?>_html .cart_state").html('<a href="./index.php?monxin=mall.my_cart" ><?php echo self::$language['view']?><?php echo self::$language['my_cart']?></a>');
	}
	
	
	function add_cart(id,quantity){
		var price=0;
		if($("#<?php echo $module['module_name'];?> #no_discount .price_value").html()){
			price=$("#<?php echo $module['module_name'];?> #no_discount .price_value").html();	
		}else{
			price=$("#<?php echo $module['module_name'];?> .discount_price .price_value").html();	
		}
		//alert(price);
		//alert(id+','+quantity);
		var old_cart=getCookie('mall_cart');
		if(old_cart!=''){
			old_cart=old_cart.replace(/%3A/g,':');
			old_cart=old_cart.replace(/%2C/g,',');
			//alert(old_cart);
			old_cart=eval('('+old_cart+')');
			if(old_cart[id]){
				old_cart[id]['quantity']=parseFloat(old_cart[id]['quantity'])+parseFloat(quantity);	
			}else{
				old_cart[id]=new Array();
				old_cart[id]['quantity']=quantity;		
				old_cart[id]['price']=price;		
			}
			if(old_cart[id]['quantity']<0){old_cart[id]['quantity']=1;}
			old_cart[id]['time']=Date.parse(new Date());
			str='';
			for(v in old_cart){
				str+='"'+v+'":{"quantity":"'+old_cart[v]['quantity']+'","time":"'+old_cart[v]['time']+'","price":"'+old_cart[v]['price']+'"},';	
			}
			str=str.substring(0,str.length-1);
			str='{'+str+'}';
		}else{
			str='{"'+id+'":{"quantity":"'+quantity+'","time":"'+Date.parse(new Date())+'","price":"'+price+'"}}';
		}
		//alert(str);
		setCookie('mall_cart',str,30);
		try{update_cart_goods_sum();}catch(e){}
		$.get("./receive.php?target=mall::cart&act=update_cart");
	}
	
	function show_goods_option_div(v){
		if(v==0){
			$("#<?php echo $module['module_name'];?> .monxin_head").css('display','none');
			$("#<?php echo $module['module_name'];?> .pagination").css('display','block');
			$("#<?php echo $module['module_name'];?> .goods_option_div").animate({right:'-100%'});	
		}else{
			$("#<?php echo $module['module_name'];?> .monxin_head").css('display','none');
			$("#<?php echo $module['module_name'];?> .pagination").css('display','none');
			$("#<?php echo $module['module_name'];?> .goods_option_div").animate({right:'0px'});
		}
		if(!$("#<?php echo $module['module_name'];?> .goods_option_div .pre_deposit").html()){
			if($("#<?php echo $module['module_name'];?> .pre_div .pre_deposit").html()){
				 $("#<?php echo $module['module_name'];?> .goods_option_div .goods_content > div").append($("#<?php echo $module['module_name'];?> .pre_div .pre_deposit").clone());
			}
		}
			
	}
	
	function format_quantity(){
		if(parseFloat($(".limit_v").html())<parseFloat($("#<?php echo $module['module_name'];?> .quantity_div .quantity_value #quantity").val())){
			$(".limit").addClass('flash animated tips');
			setTimeout(function(){$("#<?php echo $module['module_name'];?>_html .limit").removeClass('flash animated tips');},1000);
			$("#<?php echo $module['module_name'];?> .quantity_div .quantity_value #quantity").val($(".limit_v").html());
		}
		obj=$("#<?php echo $module['module_name'];?> .quantity_div .quantity_value #quantity");
		if(!$.isNumeric(obj.val())){obj.val('1');}	
		if(parseFloat(obj.val())<0){obj.val('1');}
		if(obj.val()>parseFloat($(".inventory_m").html())){obj.val(parseFloat($(".inventory_m").html()));}
		if($("#<?php echo $module['module_name'];?> .unit_gram").prop('value')==0){
			obj.val(Math.round(obj.val()));
		}		
	}
	function touch_right_and_left(v){
		if(v=='left' || v=='right'){
			//alert(v);
			if(v=='left'){
				show_left();
			}else{
				show_right();
			}
			event.preventDefault();
		}
	}
	function show_left(){
		thumb_left=$("#<?php echo $module['module_name'];?> #auto_width_div").offset().left;
		if(thumb_left>=0){return false;}
		$("#<?php echo $module['module_name'];?> #auto_width_div").css('left',Math.min(0,thumb_left+$("#fix_width_div").width()+30));
		$("#<?php echo $module['module_name'];?> #show_right").attr('class','show_right_able');
		if(thumb_left+$("#fix_width_div").width()>=0){$("#<?php echo $module['module_name'];?> #show_left").attr('class','show_left_disable');}
		return false;
	}
	function show_right(){
		thumb_left=$("#<?php echo $module['module_name'];?> #auto_width_div").offset().left;
		if(Math.abs(thumb_left)-$("#<?php echo $module['module_name'];?> #auto_width_div").width()>=0){return false;}
		$("#<?php echo $module['module_name'];?> #show_left").attr('class','show_left_able');
		$("#<?php echo $module['module_name'];?> #auto_width_div").css('left',thumb_left-$("#fix_width_div").width()-30);
		if(Math.abs(thumb_left-$("#fix_width_div").width())>=$("#<?php echo $module['module_name'];?> #auto_width_div").width()){$("#<?php echo $module['module_name'];?> #show_right").attr('class','show_right_disable');}
		return false;
	}
	
    </script>
    <style>
	.monxin_bottom,.monxin_bottom_switch,#mall_cart,#mall_menu{ display:none !important;}
    #<?php echo $module['module_name'];?>{ overflow:hidden;  background:<?php echo $_POST['monxin_user_color_set']['container']['background']?>;  }
	#<?php echo $module['module_name'];?> a{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html #goods_act_div{ width:100%;  box-shadow: 0px 1px 1px 1px rgba(0, 0, 0, 0.1); background-color:#FFF;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div{ padding:0.5rem;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .title{display:block;  line-height:1.5rem; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .advantage{ color:#999; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info{  font-weight:bold; padding-top:0.5rem; padding-bottom:0.5rem;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div{ }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #no_discount{}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #no_discount .price_label{ }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #no_discount .price_value{ font-weight:bold;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount{ }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price{ white-space:nowrap; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price .price_label{  font-size:18px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price .money_symbol{ font-size:14px;  }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price .price_value{ font-size:24px; font-weight:bold;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price .discount_value{ font-size:24px; font-weight:bold; margin-left:20px; display:none;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price .discount_time{ display:inline-block;  border-radius:15px; padding-left:15px; padding-right:15px;vertical-align:top; height:30px; line-height:30px;  margin-left:10px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .normal_price{}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .normal_price .sold_sum{  font-size:1rem; margin-left:25px; margin-right:25px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .normal_price .comment_sum{  font-size:1rem; text-align:right;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .normal_price .price_label{ font-size:1rem;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .normal_price .price_value{ font-size:1rem; text-decoration:line-through;}
	#<?php echo $module['module_name'];?>_html .sold_sum{padding-left:10px; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .comment_sum{padding-left:10px; padding-right:10px;}

    #<?php echo $module['module_name'];?>_html .log_div{ margin-top:5px; margin-bottom:5px; white-space:nowrap; border-top:#CCC dashed 1px;border-bottom:#CCC dashed 1px; padding-bottom:5px; padding-top:5px; font-size:0.9rem;}
    #<?php echo $module['module_name'];?>_html .log_div a{ display:block;  display:inline-block; vertical-align:top; width:33%; text-align:center; border-right:1px #CCCCCC dashed; }
	#<?php echo $module['module_name'];?>_html .log_div a:last-child{ border-right:none;}
	#<?php echo $module['module_name'];?>_html .log_div a:hover{ opacity:0.8; font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .log_div .m_label{  padding-right:3px;color: #999;}
	#<?php echo $module['module_name'];?>_html .log_div .value{ font-weight:bold;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .fulfil_preferential{ display:none;    padding:0.5rem;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .fulfil_preferential .fulfil_label{}	

    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div #s_select_state{ line-height:2rem; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div #s_select_state:before{margin-right:8px; margin-top:0.5rem; float:right; font: normal normal normal 1.5rem/1 FontAwesome; content:"\f105";}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div #s_select_state .default{display:inline-block; vertical-align:top; padding:2px;}
    #<?php echo $module['module_name'];?>_html .tips{ border:1px solid #F00; font-weight:bold; }
    #<?php echo $module['module_name'];?>_html .tips .default span{ }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .m_button{ white-space:nowrap; overflow:hidden;}
	
    #<?php echo $module['module_name'];?>_html .m_button{ margin-top:20px; margin-left:20px;}
    #<?php echo $module['module_name'];?>_html .m_button a{ display:inline-block; line-height:40px; height:40px; min-width:100px;   margin-right:20px; font-size:18px; border-radius:5px; padding-left:5px; padding-right:5px; text-align:center;}
	#<?php echo $module['module_name'];?>_html .m_button a:hover{ opacity:0.8;}
    #<?php echo $module['module_name'];?>_html .m_button .buy_now{}
    #<?php echo $module['module_name'];?>_html .m_button .add_cart:before{
		font: normal normal normal 18px/1 FontAwesome;
		margin-right:5px;
		content: "\f07a";
	}
    #<?php echo $module['module_name'];?>_html .m_button .add_favorite:before{
		font: normal normal normal 18px/1 FontAwesome;
		margin-right:5px;
		content: "\f08a";
	}
    #<?php echo $module['module_name'];?>_html .m_button .{ }
	
		
	
	/* 这是下方的鼠标指针的移动镜头平方米。 */
	.cloud-zoom-lens {border: 4px solid #888;margin:-4px;cursor:move; }
	/* 这是标题文本 */
	.cloud-zoom-title {font-family:Arial, Helvetica, sans-serif;position:absolute !important;padding:3px;width:100%;text-align:center;font-weight:bold;font-size:10px;top:0px;}
	/* 这是缩放窗口。 */
	.cloud-zoom-big {border:4px solid #ccc;overflow:hidden; }
	/* 这是加载消息。 */
	.cloud-zoom-loading {background:#222;padding:3px;border:1px solid #000; width:0px; height:0px;  overflow:hidden}
	
	
	
	
	
	
	
	

	#<?php echo $module['module_name'];?>_html #relevance_package_div{  box-shadow: 0px 1px 1px 1px rgba(0, 0, 0, 0.1); background:#fff;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .relevance_package{  border-bottom:1px solid #e7e7e7; height:60px; line-height:60px; display:inline-block; vertical-align:top; width:100%; font-size:20px;  padding-left:2%;}	
	#<?php echo $module['module_name'];?>_html #relevance_package_div .package_div{}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .add_symbol{ display:none;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .add_symbol:before{	font: normal normal normal 35px/1 FontAwesome;	content: "\f067";}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .equal_symbol{  text-align:center;  display:inline-block; vertical-align:top; width:60px; height:50px;vertical-align:middle;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .equal_symbol:before{
	font: normal normal normal 35px/1 monxin;
	content: "\f00C";}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div{ display:inline-block; vertical-align:top;vertical-align: middle; height:165px; line-height:35px; overflow:hidden; text-align:left;padding:20px;} 
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .normal_price .money_symbol{ text-decoration:line-through; }
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .normal_price .value{ text-decoration:line-through; }
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .normal_price .more_than{ text-decoration:line-through;  font-size:12px; margin-left:3px;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .package_price .money_symbol{}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .package_price .value{ font-weight:bold;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .package_price .more_than{ font-size:12px; margin-left:3px; margin-left:3px; }
	#<?php echo $module['module_name'];?>_html #relevance_package_div .money_symbol{ font-size:0.9rem; padding-left:2px;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .value{ font-weight:bold;color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .save_money .more_than{ font-size:12px; margin-left:3px; }
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .view{   display:inline-block; vertical-align:top; border-radius:3px; height:25px; line-height:25px; font-size:15px; padding-left:10px; padding-right:10px; text-align:center;}
	
    #<?php echo $module['module_name'];?>_html #relevance_package_div .goods_div{ display:block; }
    #<?php echo $module['module_name'];?>_html #relevance_package_div .goods_div .goods_a{ }
    #<?php echo $module['module_name'];?>_html #relevance_package_div .goods_div .goods_a img{ display:inline-block; vertical-align:top; width:15%; margin:2%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html #relevance_package_div .goods_div .goods_a div{display:inline-block; line-height:2rem; vertical-align:top; width:80%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html #relevance_package_div .goods_div .goods_a div .goods_name{display:inline-block; width:100%; height:1.5rem; overflow:hidden; white-space:nowrap;text-overflow: ellipsis;}
    #<?php echo $module['module_name'];?>_html .goods_div .money_value{color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>;}
    #<?php echo $module['module_name'];?>_html .goods_div .money_symbol{color: <?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; font-size:0.9rem; padding-left:2px;  }
    #<?php echo $module['module_name'];?>_html .goods_div .goods_name{  display:inline-block; vertical-align:top; height:20px; overflow:hidden;}



	#<?php echo $module['module_name'];?>_html #relevance_goods_div{ margin-top:15px;box-shadow: 0px 1px 1px 1px rgba(0, 0, 0, 0.1); background:#fff;}	
    #<?php echo $module['module_name'];?>_html #relevance_goods_div .relevance_package{  border-bottom:1px solid #e7e7e7; height:60px; line-height:60px; display:inline-block; vertical-align:top; width:100%; font-size:20px;  padding-left:2%;}
    #<?php echo $module['module_name'];?>_html #relevance_goods_div{}
    #<?php echo $module['module_name'];?>_html #relevance_goods_div .goods_a{ display:inline-block; vertical-align:top; width:50%; overflow:hidden; text-align:center; margin-top:0.5rem;}
    #<?php echo $module['module_name'];?>_html #relevance_goods_div .goods_a img{ width:80%; margin:auto;}
    #<?php echo $module['module_name'];?>_html #relevance_goods_div .goods_a div{ padding:0.5rem; text-align:center;}
    #<?php echo $module['module_name'];?>_html #relevance_goods_div a .money_symbol{color: <?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; font-size:0.9rem; padding-left:2px;  }
    #<?php echo $module['module_name'];?>_html #relevance_goods_div a .money_value{color: <?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; }
    #<?php echo $module['module_name'];?>_html #relevance_goods_div a .title{  display:inline-block; vertical-align:top; height:20px; overflow:hidden; line-height:19px; font-size:1rem; width:100%; text-align:left; white-space:nowrap; text-overflow: ellipsis;
}

	
	
	#<?php echo $module['module_name'];?>_html #goods_detail_div{ margin-top:15px;  border:1px solid #e7e7e7; border-top:0px;box-shadow: 0px 1px 1px 1px rgba(0, 0, 0, 0.1); background:#fff;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div img{ max-width:100% !important;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div{ border:1px solid #e7e7e7; height:3rem; line-height:3rem; display:inline-block; vertical-align:top; width:100%;background-color: #f3f3f3;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div a{ display:inline-block; vertical-align:top; width:33.33%; text-align:center; border-top:3px solid #f3f3f3;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div a:hover{ font-weight:bold;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div .current{   border-top:3px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; background:#fff;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail{}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail .attribute{ padding:0px; margin:0px; margin-bottom:20px;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail .attribute li{display:inline-block; vertical-align:top; width:48%;  display:inline-block; vertical-align:top; height:2rem; line-height:2rem; white-space:nowrap; overflow:hidden;text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute{}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute div{ display:inline-block; vertical-align:top; width:49%;  display:inline-block; vertical-align:top; height:25px; line-height:25px; white-space:nowrap;overflow:hidden; white-space:nowrap; text-overflow: ellipsis;} 
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute div .a_label{ display:inline-block; vertical-align:top; margin-right:8px; width:70px; text-align:right; overflow:hidden; height:30px; vertical-align:top;opacity:0.5;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute div .a_value{  vertical-align:top;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_detail_html{ margin-top:20px; line-height:30px;  padding:2%}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_detail_html img{ max-width:100%;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_detail_html table{ width:100% !important;}
	
	#<?php echo $module['module_name'];?>_html #comment_div{ margin-top:15px; background:#fff;}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_title{ height:3rem; line-height:3rem;   padding-left:2%; width:100%; font-size:1.2rem;background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>; }
	#<?php echo $module['module_name'];?>_html #comment_div .comment_label{ line-height:2rem; text-align:center;}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_label a{ display:inline-block; vertical-align:top; width:20%; margin:0.5rem; border-radius:0.3rem; background-color: #f3f3f3;}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_label a:hover{   }
	#<?php echo $module['module_name'];?>_html #comment_div .comment_label .selected{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	#<?php echo $module['module_name'];?>_html #comment_div .comment_content{ padding:15px;}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_content .cooment_line{ padding-top:15px; padding-bottom:15px; }
	#<?php echo $module['module_name'];?>_html #comment_div .comment_content .cooment_line{}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_page{ display:none;}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_page_div{ display:none;}
	
    #<?php echo $module['module_name'];?> .buyer{ text-align:left; line-height:25px;}
    #<?php echo $module['module_name'];?> .buyer .username{text-align:left;}
    #<?php echo $module['module_name'];?> .buyer .point{  display:inline-block; width:6px; vertical-align:top; overflow:hidden; color: <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
    #<?php echo $module['module_name'];?> .buyer .point:after {
	font: normal normal normal 24px/1 FontAwesome;
	content: "\f0d9";}
    #<?php echo $module['module_name'];?> .buyer .content{ display:inline-block; vertical-align:top; padding-left:10px;  padding-right:10px; border-radius:5px;  font-size:1rem;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
    #<?php echo $module['module_name'];?> .buyer .level{ padding-left:10px;}
    #<?php echo $module['module_name'];?> .buyer .time{padding-left:10px;  font-size:13px; color:#999;}
	
    #<?php echo $module['module_name'];?> .buyer .content .seller{ font-style:oblique;}
    #<?php echo $module['module_name'];?> .buyer .content .seller .username{ }
    #<?php echo $module['module_name'];?> .buyer .content .seller .time{ }
	
	#<?php echo $module['module_name'];?>_html #comment_div .comment_content .comment_page{}
	
	#<?php echo $module['module_name'];?>_html #sold_div{margin-top:15px; background:#fff;}
	#<?php echo $module['module_name'];?>_html #sold_div .sold_title{ height:3rem; line-height:3rem;   padding-left:2%; width:100%; font-size:1.2rem;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	
	#<?php echo $module['module_name'];?>_html #sold_div table{ color:#999; }	
	#<?php echo $module['module_name'];?>_html #sold_div #sold_table{ margin-top:10px;  }	
	#<?php echo $module['module_name'];?>_html #sold_div #sold_table thead{ height:3rem;  box-shadow:0px 2px 0px 0px rgba(221,226,231,.9); line-height:3rem;}	
	#<?php echo $module['module_name'];?>_html #sold_div #sold_table thead tr td{ width:20%; text-align:left; padding-left:3px;}	
	#<?php echo $module['module_name'];?>_html #sold_div #sold_table tbody tr td{ width:20%; text-align:left;padding-left:3px; padding-bottom:15px; padding-top:15px; border-bottom:1px solid #e7e7e7;}	
	#<?php echo $module['module_name'];?>_html #sold_div #sold_table tbody tr:hover{ }	
	#<?php echo $module['module_name'];?>_html #sold_div .sold_page{ display:block; text-align:center;}
	
	#<?php echo $module['module_name'];?>_html .position{ display:none;  border-bottom:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;font-weight:bold;padding-left:15px;  margin-bottom:10px; margin-top:5px;  margin:auto;}
	#<?php echo $module['module_name'];?>_html .position a{ display:inline-block;    line-height:30px;  height:30px; font-weight:lighter; }
	#<?php echo $module['module_name'];?>_html .position a:after{font-family:"FontAwesome"; font-size:5px; padding:5px; content: "\f105";}
	#<?php echo $module['module_name'];?>_html .position a:hover{ font-weight:bold;}
	
	
	#<?php echo $module['module_name'];?>_html #pre_sale{ }
	#<?php echo $module['module_name'];?>_html #pre_sale .price_label { display:inline-block; width:60px;}
	#<?php echo $module['module_name'];?>_html #pre_sale .old_price .value{ text-decoration:line-through;}
	#<?php echo $module['module_name'];?>_html #pre_sale .pre_price .price_value{ font-size:18px; font-weight:bold;}
	#<?php echo $module['module_name'];?>_html #pre_sale .pre_deposit .deposit_value{ font-size:24px; font-weight:bold;}
	#<?php echo $module['module_name'];?>_html #pre_sale .pre_deposit .reduction_div{ padding:10px;}
	#<?php echo $module['module_name'];?>_html .pre_sale_rules{ display:block;  line-height:2rem; font-weight:normal;}
	#<?php echo $module['module_name'];?>_html .pre_sale_rules:after{
		font: normal normal normal 12px/1 FontAwesome;
		margin-left:3px;
		 content: "\f078"; font-weight:100;
	}
	.pre_sale_rules_description{ display:none;   font-weight:normal; padding:0.5rem; line-height:1.3rem;}
	#<?php echo $module['module_name'];?>_html .transaction_progress{  margin-top:10px;  margin-bottom:10px; padding:0.5rem; white-space:nowrap; box-shadow: 0px 1px 1px 1px rgba(0, 0, 0, 0.1);}
	#<?php echo $module['module_name'];?>_html .transaction_progress .name{ display:block;font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .transaction_progress .step{ font-weight:bold; }
	#<?php echo $module['module_name'];?>_html .transaction_progress .start{display:inline-block; vertical-align:top; }
	#<?php echo $module['module_name'];?>_html .transaction_progress .middle{display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .transaction_progress .end{display:inline-block; vertical-align:top;  display:none;}
	#<?php echo $module['module_name'];?>_html .transaction_progress .end:before{
		font: normal normal normal 45px/1 monxin;
		margin-left:10px;
		margin-right:10px;
		line-height:60px;
		content: "\f005";
		
		opacity:0.1;
	}
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_1{ display:block; vertical-align:top; width:23%; line-height:30px; margin-top:15px;}
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_2{ display:block; vertical-align:top; width:27%; line-height:30px; margin-top:15px;}
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_3{ display:block; vertical-align:top; width:22%; line-height:60px; margin-top:16px; }
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_4{ display:block; vertical-align:top; width:22%; line-height:30px; margin-top:15px;}
	
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_1 .start:before{
	font: normal normal normal 45px/1 monxin;
	margin-right:10px;
	line-height:60px;
	content: "\f001";
	
	}
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_2 .start:before{
	font: normal normal normal 45px/1 monxin;
	margin-right:10px;
	line-height:60px;
	content: "\f002";
	
	}
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_3 .start:before{
	font: normal normal normal 45px/1 monxin;
	margin-right:10px;
	line-height:60px;
	content: "\f003";
	
	}
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_4 .start:before{
	font: normal normal normal 45px/1 monxin;
	margin-right:10px;
	line-height:60px;
	content: "\f004";
	
	}
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_4 .end{ display:none;}
	#<?php echo $module['module_name'];?>_html .out_delivered{ line-height:40px; padding-left:20px;}
	#<?php echo $module['module_name'];?>_html .out_delivered .value{  font-weight:bold;}
	
	#<?php echo $module['module_name'];?>_html .limit{ margin-left:10px; }
	#<?php echo $module['module_name'];?>_html .limit .limit_v{ font-weight:bold; padding-left:3px; padding-right:3px;}
	.goods_imgs{ padding-top:1rem;bottom-top:2rem; box-shadow: 0px 1px 1px 1px rgba(0, 0, 0, 0.1); background:#fff;}
	.goods_bottom_div{ background:#fff;}
	.goods_bottom_div{ z-index:99999; width:100%; height:3.57rem; line-height:3.57rem; position:fixed; bottom:0px;  box-shadow: 0px -2px 1px 1px rgba(0, 0, 0, 0.1); z-index:999999;}
	.goods_bottom_div a{ display:inline-block; width:33.3%; vertical-align:top;  text-align:center;}
	.goods_bottom_div .talk{width:11.1%; line-height:1.5rem; margin-top:0.8rem;  font-size:0.8rem;color: #999 !important;}
	.goods_bottom_div .talk:before{ display:block; font: normal normal normal 1rem/1 FontAwesome; content:"\f0e6";}
	.goods_bottom_div .enter_store{width:11.1%; line-height:1.5rem; margin-top:0.8rem; font-size:0.8rem;color: #999 !important;}
	.goods_bottom_div .enter_store:before{ display:block; font: normal normal normal 1rem/1 FontAwesome; content:"\f187";}
	.goods_bottom_div .favorite{width:11.1%; line-height:1.5rem; margin-top:0.8rem; font-size:0.8rem;color: #999 !important;}
	.goods_bottom_div .favorite:before{ display:block; font: normal normal normal 1rem/1 FontAwesome; content:"\f006";}
	.goods_bottom_div .enter_store{ border-left:1px solid #e4e4e4;}
	.goods_bottom_div .favorite{ border-left:1px solid #e4e4e4 ;}
	.goods_bottom_div .add_cart{background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?> !important;  }
	.goods_bottom_div .favorite a{  }
	.goods_bottom_div .add_cart a{ }
	.goods_bottom_div .buy_now{  }

	.goods_option_div{ z-index:99;   position:fixed; width:100%; height:100%; top:0px; right:-100%; background-color:#fff;}
	.goods_option_div #s_select_state{ margin-left:15%; line-height:2rem; margin-top:1rem; padding:0.5rem; display:inline-block; width:50%;}
	.goods_option_div .option_head{ line-height:3rem; height:3rem;box-shadow: 0px 2px 1px 1px rgba(0, 0, 0, 0.1);}	
	.goods_option_div .option_head .return_goods{ display:inline-block; vertical-align:top; width:20%; overflow:hidden;padding-top:3px; }	
	.goods_option_div .option_head .return_goods:before{ font: normal normal normal 2rem/1 FontAwesome; content:"\f104"; padding-left:0.5rem;}	
	.goods_option_div .option_head .this_name{ display:inline-block; vertical-align:top; width:60%; margin-right:20%; overflow:hidden; text-align:center;}	
	
	.goods_option_div .goods_content{ line-height:2rem; border-bottom:#CCC 1px solid; margin-top:10px;}
	.goods_option_div .goods_content img{ display:inline-block; vertical-align:top; width:20%; margin-left:5%;margin-right:5%; overflow:hidden;}
	.goods_option_div .goods_content div{ display:inline-block; vertical-align:top; width:70%; overflow:hidden;}
	.goods_option_div .goods_content div span{ display:block;}
	.goods_option_div .goods_content div .price{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
	.goods_option_div .goods_content div .price:before{ font: normal normal normal 1rem/1 FontAwesome; content:"<?php echo self::$language['money_symbol'];?>"; padding-right:2px; display:none;}	
	
	.goods_option_div .specifications{}
	.goods_option_div .specifications .color_label{ display:inline-block; vertical-align:top; line-height:35px; vertical-align:top; text-align:right; padding-right:10px; width:15%; overflow:hidden;}
	.goods_option_div .specifications .color_line_div{ margin-top:20px; margin-bottom:20px;}
	.goods_option_div .specifications .color_option{ display:inline-block; vertical-align:top; vertical-align:top; overflow:hidden; width:82%;}
	.goods_option_div .specifications .color_option a{display:inline-block; vertical-align:top;  overflow:hidden; /*line-height:40px; height:40px; */padding:3px; border:1px solid #ccc; margin:0 4px; margin-bottom:10px; }
	.goods_option_div .specifications .color_option a:hover img{}
	.goods_option_div .specifications .color_option .selected{border:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	.goods_option_div .specifications .color_option .disable{ opacity:0.1; filter:alpha(opacity=10); cursor:default;}
	.goods_option_div .specifications .color_option .disable:hover{ border:1px solid #ccc;}
	.goods_option_div .specifications .color_option a img{ height:30px;}
	
	
	.goods_option_div .specifications .option_label{ display:inline-block; vertical-align:top; line-height:32px; vertical-align:top; text-align:right; width:15%; overflow:hidden; white-space:nowrap;}
	.goods_option_div .specifications .option_line_div{ margin-top:20px; margin-bottom:20px;}
	.goods_option_div .specifications .option_option{ display:inline-block; vertical-align:top; vertical-align:top;overflow:hidden; width:82%;}
	.goods_option_div .specifications .option_option a{ margin-bottom:10px;  margin-left:4px; margin-right:4px; padding-left:4px; padding-right:4px; display:inline-block; vertical-align:top; line-height:40px; min-width:30px; text-align:center; height:40px; vertical-align:top;  overflow:hidden; border:1px solid #ddd;}
	.goods_option_div .specifications .option_option .selected{ border:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	.goods_option_div .specifications .option_option .disable{ opacity:0.1; filter:alpha(opacity=10); cursor:default;}
	.goods_option_div .specifications .option_option .disable:hover{ border:1px solid #ccc;}

	.goods_option_div .quantity_div{ margin-top:20px;}
	.goods_option_div .quantity_div .quantity_label{ display:inline-block; vertical-align:top; line-height:30px; vertical-align:top; text-align:right; padding-right:10px; width:15%; overflow:hidden;}
	.goods_option_div .quantity_div .quantity_value{ display:inline-block; vertical-align:top; vertical-align:top;  overflow:hidden;}
	.goods_option_div .quantity_div .quantity_value .decrease_quantity{ display:inline-block;  width:38px; height:38px; border:1px solid #ccc; vertical-align:top; background:#ccc;}
	.goods_option_div .quantity_div .quantity_value .decrease_quantity:before {font: normal normal normal 1rem/1 FontAwesome; content: "\F068"; padding:0 5px 0 10px;vertical-align: top;line-height: 38px;margin-left: 3px;}	
	.goods_option_div .quantity_div .quantity_value .decrease_quantity:hover{ background:#eaeaea; border:1px solid #ccc;}
	.goods_option_div .quantity_div .quantity_value #quantity{ width:70px; text-align:center; height:38px; line-height:38px; border:1px solid #ccc; border-radius:0px; border-left:0px; border-right:0px;padding:0px;} 
	.goods_option_div .quantity_div .quantity_value .add_quantity{display:inline-block;  width:38px; height:38px;  border:1px solid #ccc; vertical-align:top;  background:#ccc;}
	.goods_option_div .quantity_div .quantity_value .add_quantity:before {font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; padding:0 5px 0 10px;vertical-align: top;line-height: 38px;margin-left: 3px;}	
	.goods_option_div .quantity_div .quantity_value .add_quantity:hover{ background:#eaeaea; border:1px solid #ccc;}
	.goods_option_div .quantity_div .quantity_value .unit{ display:inline-block;margin-left:5px; margin-right:5px;}
	.goods_option_div .quantity_div .quantity_value .inventory{ display:inline-block; }
	
	.shop_info{  margin-top:1rem;margin-bottom:1rem; box-shadow: 0px 1px 1px 1px rgba(0, 0, 0, 0.1); padding:0.8rem; background:#fff;}
	.shop_info .info_div{}
	.shop_info .info_div .shop_icon{ display:inline-block; vertical-align:top; width:30%; border:#CCC 1px solid;  margin-right:4%; overflow:hidden; }
	.shop_info .info_div .info{display:inline-block; vertical-align:top; width:65%; overflow:hidden; line-height:1.3rem;}
	.shop_info .info_div .info .shop_name{ font-weight:bold;}
	.shop_info .info_div .info .deposit_satisfaction{}
	.shop_info .info_div .info .deposit_satisfaction .value{  font-weight:bold;}
	.shop_info .info_div .info .talks{}
	.shop_info .info_div .info .talks a{ margin-right:1rem;}
	.shop_info .a_div{text-align:left;  line-height:2rem; padding-top:10px;}
	.shop_info .a_div a{ text-align:center; display:inline-block; vertical-align:top; width:40%; margin-right:6%;    border-radius:3px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?> !important;  }
	.cart_state{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?> !important; white-space:nowrap; text-align:left; padding-left:0.5rem;}
	.cart_state a{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?> !important;}
	
	#<?php echo $module['module_name'];?>_html .talk:before{font: normal normal normal 1.2rem/1 FontAwesome; content:"\f0e6"; cursor:pointer; }
  	#<?php echo $module['module_name'];?>_html .talk:hover{ color:red;}
	#<?php echo $module['module_name'];?>_html .money_symbol{ padding-left:2px; font-size:0.9rem;}
	#<?php echo $module['module_name'];?> #goods_detail_html img{ height:auto !important;}
	
	#<?php echo $module['module_name'];?> .goods_option_div .goods_content .pre_deposit .price_label{ display:inline-block;}
	#<?php echo $module['module_name'];?> .goods_option_div .goods_content .pre_deposit .deposit_value{ display:inline-block;}
	#<?php echo $module['module_name'];?> .goods_option_div .goods_content .pre_deposit .money_symbol{ display:inline-block;}
	#<?php echo $module['module_name'];?> .goods_option_div .goods_content .pre_deposit .reduction_div >span{ display:inline-block;}
	#<?php echo $module['module_name'];?>_html .yuan_2{   padding-right:8px;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; font-size:0.9rem; float:right; }
	
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
        <div class=goods_option_div>
        	<div class=option_head><a href=# class=return_goods></a><span class=this_name><?php echo self::$language['select_2'];?><?php echo self::$language['option'];?></span></div>
        	<div class=goods_content>
            	<img src= /><div>
                	<span class=title></span>
                    <span class=price></span>
                </div>
            </div>
            <div class=specifications><?php echo @$module['option_html'];?></div>
            <div class=quantity_div><span class=quantity_label><?php echo self::$language['quantity'];?></span><div class="quantity_value"><a href="#" class=decrease_quantity title="-1"> </a><input type="text" id=quantity value="1" /><a href="#" class=add_quantity title="+1"> </a><span class=unit><?php echo $module['unit'];?></span><span class=inventory><span class=s><?php echo self::$language['inventory'];?></span><span class=inventory_m><?php echo $module['inventory'];?></span><span class=e><?php echo $module['unit'];?></span></span><span class=unit_gram value=<?php echo $_POST['temp_unit_gram'];?>></span><?php echo $module['data']['limit']?></div></div>
       		<div id=s_select_state><span class="default"><span> </span></span></div>
        </div>
    
		<div class=goods_bottom_div>
        	<a class=talk talk="<?php echo $module['shop_master'];?>" title="<?php echo self::$language['site_msg']?>" ><?php echo self::$language['talk']?></a><a href="./index.php?monxin=mall.shop_index&shop_id=<?php echo $module['shop_id'];?>" class=enter_store><?php echo self::$language['enter_store']?></a><a href="" class=favorite><?php echo self::$language['favorite']?></a><a href="" class=add_cart><?php echo self::$language['add_cart']?></a><a  href="./index.php?monxin=mall.confirm_order&goods_src=goods_id&id=<?php echo $_GET['id']?>" rel="nofollow" id=submit class=buy_now><?php echo self::$language['buy_now']?></a>
        </div>
       <div class=position><?php echo $module['position'];?></div>
       <div class=goods_imgs>
       
	<script src="./public/idangerous.swiper.js"></script>
    <link rel="stylesheet" href="./public/idangerous.swiper.css">
    <script>
    $(document).ready(function(){
	  var mySwiper = new Swiper('.swiper-container',{
		pagination: '.pagination',
		loop:true,
		grabCursor: true,
		paginationClickable: true
	  })
    });
    </script>

	<style>
    
	#<?php echo $module['module_name'];?> .swiper-wrapper div a{ display:inline-block; vertical-align:top; text-align:center;  width:25%; }
	#<?php echo $module['module_name'];?> .swiper-wrapper div a:hover{  }
	#<?php echo $module['module_name'];?> .swiper-wrapper div a span{ display:block;}
	#<?php echo $module['module_name'];?> .swiper-wrapper div a .icon{ }
	#<?php echo $module['module_name'];?> .swiper-wrapper div a .icon img{ width:70%; border:0px;}
	#<?php echo $module['module_name'];?> .swiper-wrapper div a .name{ }

	
		
	.swiper-slide{ padding:0px; margin:0px; overflow:hidden;}
	.swiper-container li{ list-style:none;}
	.swiper-container li img{ max-width:100%;}
	.swiper-container {
		height:30rem;
	  width: 100%;
	  overflow:hidden;
	}
	.content-slide {
	  
	 
	}
	.pagination { text-align:center; margin:auto; z-index:999;	  width: 100%; margin-top:-2rem; position: absolute; top:33.5rem;	}
	.swiper-pagination-switch {
	  display: inline-block;
	  width:8px;
	  height: 8px;
	  border-radius: 8px;
	  background: #999;
	  box-shadow: 0px 2px 4px #555 inset;
	  margin: 0 8px;
	  cursor: pointer;
	}
	.swiper-active-switch {
	  background: #fff;
	}

	
    </style>
       
            <div class="swiper-container">
              <div class="swiper-wrapper">
					<?php echo $module['data']['img_list'];?>
              </div>
             
            </div>
            <div class="pagination"></div>
       </div>
       
    	<div id="goods_act_div">
        	<div id="act_div">
            	<div class=title><?php echo $module['data']['title'];?></div>
            	<div class=advantage><?php echo $module['data']['advantage'];?></div>
            	
                <div class=price_info><?php echo @$module['data']['price_info'];?>
                	<div class=price_div>
                    	<?php echo $module['price_div_html'];?>
                    </div>
                    <div class=pre_sale_rules_description><?php echo self::$language['pre_sale_rules_description'];?></div>
                </div>
                
                <div class=fulfil_preferential><span class=fulfil_label><?php echo self::$language['fulfil_preferential'];?></span><span class=fulfil_value><?php echo $module['fulfil_preferential'];?></span></div>
                <div class=log_div><?php echo $module['log_div_html'];?></div>
                
                <div id=s_select_state><span class="default"><span> </span></span></div>
                
                <?php echo $module['data']['out_delivered'];?>
            </div>
        </div>
    	<?php echo $module['transaction_progress'];?>
		<?php echo $module['agency_store'];?>
        <div class=shop_info>
        	<div class=info_div><img src='./program/mall/shop_icon/<?php echo $module['shop_id'];?>.png' class=shop_icon /><div class=info>
            	<div class=shop_name><?php echo $module['shop_name'];?></div>
            	<div class=deposit_satisfaction><div class=deposit><span class=m_label><?php echo self::$language['deposit']?>:</span><span class="value"><?php echo $module['deposit']?><?php echo self::$language['yuan_2']?></span></div><div class=satisfaction><span class=m_label><?php echo self::$language['satisfaction']?>:</span><span class="value"><?php echo $module['satisfaction']?>%</span></div></div>
				<div class=talks><?php echo $module['talk'];?></div>
            	<div class=a_div><a href="./index.php?monxin=mall.shop_goods_list&shop_id=<?php echo $module['shop_id'];?>"><?php echo self::$language['view_goods_all']?></a><a href="./index.php?monxin=mall.shop_index&shop_id=<?php echo $module['shop_id'];?>"><?php echo self::$language['enter_store2']?></a></div>
            </div></div>
        </div>
        
    	<?php echo $module['html'];?>
       
    	
    </div>
</div>
