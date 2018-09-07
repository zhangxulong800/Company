<?php echo $module['agency_store'];?>
<div id=<?php echo $module['module_name'];?>  save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script>
	var credits_rate=<?php echo $module['credits_rate']?>;
	function show_yuan(){
		v=parseFloat($('#<?php echo $module['module_name'];?> .price_value').html())*credits_rate;
		$("#<?php echo $module['module_name'];?> .price_div >div >span:last").after("<span class=yuan_2>"+v.toFixed(2)+"<?php echo self::$language['yuan_2']?><?php echo self::$language['more_than']?></span>");
	}
	function set_price_inventory(id){
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
				
				temp='<?php echo self::$language['selected']?>'+$("#<?php echo $module['module_name'];?>_html .option_option .selected").html()+',<?php echo self::$language['please_select']?>'+$("#<?php echo $module['module_name'];?>_html .color_label").html();
				$("#<?php echo $module['module_name'];?>_html #s_select_state span span").html(temp);	
			}else{
				
				temp='<?php echo self::$language['selected']?>'+$("#<?php echo $module['module_name'];?>_html .color_option .selected").attr('title')+',<?php echo self::$language['please_select']?>'+$("#<?php echo $module['module_name'];?>_html .option_label").html();
				$("#<?php echo $module['module_name'];?>_html #s_select_state span span").html(temp);	
			}
		}
		
		
		if(s_id){
			if($("#have_discount").html()){
				$("#have_discount .discount_price .price_value").html(specifications[s_id]['w_price']*$("#have_discount .discount_number").html()/10);
				$("#have_discount .discount_price .price_value").html(parseFloat($("#have_discount .discount_price .price_value").html()).toFixed(2));
				$("#have_discount .normal_price .price_value").html(specifications[s_id]['w_price']);
			}else{
				$("#no_discount .price_value").html(specifications[s_id]['w_price']);
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
			}else{
				$("#no_discount .price_value").html(specifications[s_id]['w_price']);
				$(".pre_price .price_value").html(specifications[s_id]['pre_price']);
				$(".old_price .value").html(specifications[s_id]['w_price']);
			}
			$(".inventory_m").html(specifications[s_id]['quantity']);
			format_quantity();
		}
		set_credits_value();
	}
	function set_price_to_default(){
		
		if($("#have_discount").html()){
			$("#have_discount .discount_price .price_value").html(have_discount_discount_price);
			$("#have_discount .normal_price .price_value").html(have_discount_normal_price);
		}else{
			$("#no_discount .price_value").html(no_discount_price_value);
			$(".pre_price .price_value").html($(".pre_price .price_value").attr('old'));
			$(".old_price .value").html($(".old_price .value").attr('old'));
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
			$("#<?php echo $module['module_name'];?> .m_button .buy_now").css('display','none');
			$("#<?php echo $module['module_name'];?> .m_button .add_cart").css('display','none');
			$("#<?php echo $module['module_name'];?> .m_button").html('<?php echo self::$language['just_show_it']?>'+$("#<?php echo $module['module_name'];?> .m_button").html());
		}
		
		$("#<?php echo $module['module_name'];?>_html .goods_qr img").attr('src','./plugin/qrcode/index.php?text='+ window.location.href.replace(/&/g,'|||')+'&logo=1');
		
		$("#<?php echo $module['module_name'];?> .show_goods_qr").hover(function(){
			if($("#<?php echo $module['module_name'];?> .goods_qr").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .goods_qr").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> .goods_qr").css('display','none');
			}
			
		});
		
		if($("#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .fulfil_preferential .fulfil_value").html()){
			$("#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .fulfil_preferential").css('display','block');
		}
		set_credits_value();
		if(<?php echo $module['data']['share']?>==1){
			$("#<?php echo $module['module_name'];?> .m_button,.position").css('display','none');
		}
		$("#<?php echo $module['module_name'];?> #act_div").width($("#<?php echo $module['module_name'];?> #act_div").parent().width()-$("#<?php echo $module['module_name'];?> #act_div").prev().width()-30);
		if(<?php echo $module['data']['state']?>==1){
			$("#<?php echo $module['module_name'];?> .add_cart").css('display','none');	
			$("#<?php echo $module['module_name'];?> .buy_now").html('<?php echo self::$language['goods_state_act'][1]?>');
		}
		if(<?php echo $module['data']['state']?>==3){
			$("#<?php echo $module['module_name'];?> .add_cart").css('display','none');	
			$("#<?php echo $module['module_name'];?> .buy_now").html('<?php echo self::$language['goods_state_act'][3]?>');
		}
		
		
		$("#<?php echo $module['module_name'];?> .pre_sale_rules").hover(function(){
			if($(".col-md-10").html()){
				$(".pre_sale_rules_description").css('top',$(this).offset().top-180);
			}else{
				$(".pre_sale_rules_description").css('top',$(this).offset().top+30);
			}
			
			$(".pre_sale_rules_description").css('display','block');
		},function(){
			$(".pre_sale_rules_description").css('display','none');
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
			
		$("#<?php echo $module['module_name'];?> .add_favorite").click(function(){
			if($(this).attr('class')!='add_favorite'){return true;}
			$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=add_favorite',function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .add_favorite").attr('href','./index.php?monxin=mall.my_collect');
				$("#<?php echo $module['module_name'];?> .add_favorite").html(v.info).attr('class','');
				
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
			
		 
		 /*if($(window).width()<1336){
			 if($.browser.msie){
				$("#<?php echo $module['module_name'];?> #goods_act_div #act_div .fulfil_preferential").css('width',$("#<?php echo $module['module_name'];?> #goods_act_div").width()-$("#<?php echo $module['module_name'];?> #goods_act_div #thumb_img_div").width()+60);
				 
			}else{
				$("#<?php echo $module['module_name'];?> #goods_act_div #act_div").css('width',$("#<?php echo $module['module_name'];?> #goods_act_div").width()-$("#<?php echo $module['module_name'];?> #goods_act_div #thumb_img_div").width()-15);
				$("#<?php echo $module['module_name'];?> #goods_act_div #act_div .fulfil_preferential").css('width',$("#<?php echo $module['module_name'];?> #goods_act_div").width()-$("#<?php echo $module['module_name'];?> #goods_act_div #thumb_img_div").width()-30);

			}
		}else{
			$("#<?php echo $module['module_name'];?> #goods_act_div #act_div").css('width',$("#<?php echo $module['module_name'];?> #goods_act_div").width()-$("#<?php echo $module['module_name'];?> #goods_act_div #thumb_img_div").width()-10);
			$("#<?php echo $module['module_name'];?> #goods_act_div #act_div .fulfil_preferential").css('width',$("#<?php echo $module['module_name'];?> #goods_act_div").width()-$("#<?php echo $module['module_name'];?> #goods_act_div #thumb_img_div").width()-30);

		}*/
		
		
		
		
		if(specifications){
			
			temp='<?php echo self::$language['please_select']?>:'+$("#<?php echo $module['module_name'];?>_html .color_label").html()+'、'+$("#<?php echo $module['module_name'];?>_html .option_label").html();
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
				temp='<?php echo self::$language['please_select']?>:'+$("#<?php echo $module['module_name'];?>_html .color_label").html();
				$("#<?php echo $module['module_name'];?>_html #s_select_state span span").html(temp);	
				return false;
			}			
			if($(this).attr('class')=='disable'){return false;}
			
			$("#<?php echo $module['module_name'];?>_html .color_option a[class!='disable']").attr('class','');
			$(this).attr('class','selected');
			img_path=$(this).children().attr('src');
			if(!img_path){img_path=$("#<?php echo $module['module_name'];?>_html #auto_width_div a:first img").attr('src');}
			if(img_path.indexOf('img_thumb')==-1){
				img_path=$("#<?php echo $module['module_name'];?>_html #auto_width_div a:first img").attr('src');
			}	
			img_path=img_path.replace(/img_thumb/,'img');
			$("#show_thumb_div img").attr('src',img_path);
			$("#show_thumb_div").attr('href',img_path);
			$("#auto_width_div a").attr('class','');
			if(img_path==$("#<?php echo $module['module_name'];?>_html #auto_width_div a:first img").attr('src').replace(/img_thumb/,'img')){
				$("#<?php echo $module['module_name'];?>_html #auto_width_div a:first").attr('class','current');	
			}
			$('.jqzoom').imagezoom();
			
			
			
			
			
			
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
				temp='<?php echo self::$language['please_select']?>:'+$("#<?php echo $module['module_name'];?>_html .option_label").html();
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
		
		$("#<?php echo $module['module_name'];?> #show_left").click(function(){
			show_left();
			return false;	
		});
		$("#<?php echo $module['module_name'];?> #show_right").click(function(){
			show_right();
			return false;	
		});
		if(touchAble){
			$("#auto_width_div").attr('ontouchstart',"set_touch_start(event)");
			$("#auto_width_div").attr('ontouchcancel',"exe_touch_move(event,'touch_right_and_left')");
		}
		
		$("#auto_width_div a").click(function(){
			$("#show_thumb_div img").attr('src',$(this).children().attr('src').replace(/img_thumb/,'img'));
			$("#show_thumb_div img").attr('rel',$(this).children().attr('src').replace(/img_thumb/,'img'));
			$("#auto_width_div a").attr('class','');
			$(this).attr('class','current');
			$('.jqzoom').imagezoom();
			return false;	
		});
		$("#auto_width_div a").hover(function(){
			$("#show_thumb_div img").attr('src',$(this).children().attr('src').replace(/img_thumb/,'img'));
			$("#show_thumb_div  img").attr('rel',$(this).children().attr('src').replace(/img_thumb/,'img'));
			$("#auto_width_div a").attr('class','');
			$(this).attr('class','current');
			$('.jqzoom').imagezoom();
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
			if('<?php echo $module['shop_master']?>'=='<?php echo $module['username'];?>'){alert('<?php echo self::$language['can_not_buy_your_goods']?>');return false;}
			if(specifications){
				if(s_id==0){
					$("#<?php echo $module['module_name'];?>_html #s_select_state").addClass('flash animated tips');
					setTimeout(function(){$("#<?php echo $module['module_name'];?>_html #s_select_state").removeClass('flash animated tips');;},1000);
					return false;
				}				
			}
			if(parseFloat($(".inventory_m").html())==0){alert('<?php echo self::$language['inventory_shortage_cannot_buy'];?>');return false;}
        	$("#<?php echo $module['module_name'];?>_html .cart_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
			$("#<?php echo $module['module_name'];?>_html .cart_state").html('<span class=success><?php echo self::$language['success'];?></span> <a href="./index.php?monxin=mall.my_cart" class=view user_color=button><?php echo self::$language['view']?><?php echo self::$language['my_cart']?></a>');
			$("#<?php echo $module['module_name'];?>_html .cart_state").addClass('bounce animated infinite');
			window.setTimeout(remove_cart_state_animate,1000); 
			if(s_id){
				add_cart('<?php echo $_GET['id'];?>_'+s_id,$("#<?php echo $module['module_name'];?>_html .quantity_div #quantity").val());
			}else{
				add_cart('<?php echo $_GET['id'];?>',$("#<?php echo $module['module_name'];?>_html .quantity_div #quantity").val());
			}
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?>_html .buy_now").click(function(){
			if(specifications){
				if(s_id==0){
					setTimeout(function(){$("#<?php echo $module['module_name'];?>_html #s_select_state").removeClass('flash animated tips');},1000);
					$("#<?php echo $module['module_name'];?>_html #s_select_state").addClass('flash animated tips');
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
		
		$('.jqzoom').imagezoom();
		show_yuan();
		
		$.get("<?php echo $module['count_url']?>");
		<?php echo $module['agency_count_url'];?>
    });
	
	function remove_cart_state_animate(){
		$("#<?php echo $module['module_name'];?>_html .cart_state").removeClass('bounce animated infinite');
		$("#<?php echo $module['module_name'];?>_html .cart_state").html('<a href="./index.php?monxin=mall.my_cart" class=view user_color=button><?php echo self::$language['view']?><?php echo self::$language['my_cart']?></a>');
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
		
	
    #<?php echo $module['module_name'];?>{ overflow:hidden;  }
#<?php echo $module['module_name'];?> a{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html #goods_act_div{ width:100%;  white-space:nowrap;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div{vertical-align:top;  width:450px; height:500px; display:inline-block; vertical-align:top; text-align:center; padding-left:10px; padding-top:10px; margin-right:20px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #show_thumb_div_out{ text-align:center; width:100%; height:380px; line-height:380px; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #show_thumb_div_out #wrap{ width:100%;  }
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #show_thumb_div{ display:block; text-align:center;height:380px; line-height:380px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #show_thumb_div img{ max-height:340px; max-width:440px; padding:0px; margin:0px; overflow:hidden; margin:auto;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div{text-align:center; width:100%; height:100px; line-height:100px; margin-top:10px;}
	
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div #show_left{vertical-align:top; display:inline-block; vertical-align:top; height:100%; width:10px; margin:0px; border:none;  opacity:1.0;}
	
	#<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_left_able{ color:<?php echo $_POST['monxin_user_color_set']['button']['background']?>;}}
	#<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_left_able:hover{ color:<?php echo $_POST['monxin_user_color_set']['button_hover']['background']?>;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_left_able:before{
	font: normal normal normal 25px/1 FontAwesome;
	content: "\f0d9";}
	#<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_left_disable{ color: #ccc;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_left_disable:hover{}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_left_disable:before{
	font: normal normal normal 25px/1 FontAwesome;
	content: "\f0d9";}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div #show_right{vertical-align:top;   display:inline-block; vertical-align:top; height:100%; width:15px; margin:0px; border:0px;  opacity:1.0;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_right_able:before{
	font: normal normal normal 25px/1 FontAwesome;
	margin-left:5px;
	content: "\f0da";}
	#<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_right_able{color:<?php echo $_POST['monxin_user_color_set']['button']['background']?>;}
     #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_right_able:hover{ color:<?php echo $_POST['monxin_user_color_set']['button_hover']['background']?>; }
   #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_right_disable{color: #ccc;}
   #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_right_disable:before{
	font: normal normal normal 25px/1 FontAwesome;
	margin-left:5px;
	content: "\f0da";}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div #fix_width_div{width:415px; overflow:hidden;  display:inline-block; vertical-align:top; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div #auto_width_div{white-space:nowrap; position:relative; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div a{vertical-align:top; text-align:center;  display:inline-block; vertical-align:top; width:95px; height:95px; overflow:hidden; margin-left:5px; margin-right:5px; border:1px solid #ddd;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .current{ border:3px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; padding:5px; width:89px; height:95px; opacity:1.0;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .current img{ display:block; vertical-align:top; width:73px; height:79px; padding:0px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div a img{ height:95px; width:95px;border:none; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div{vertical-align:top; padding-bottom:20px;display:inline-block; vertical-align:top;  width:48%; min-height:500px; white-space:normal; z-index:9;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .title{display:inline-block; vertical-align:top;  overflow:hidden;  font-size:16px;  line-height:30px; width:99%; margin-top:10px; margin-left:10px; padding-right:5px; text-overflow: ellipsis;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .advantage{ /*font-family:"SimSun"; */font-size:1rem;  line-height:20px; max-height:39px; overflow:hidden; margin-bottom:10px; margin-left:10px; padding-right:20px; text-indent:30px; color:#999;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info{ height:100px; margin-right:-1px; overflow:hidden;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div{ }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #no_discount{ line-height:100%; height:100%; line-height:100px; font-size:20px; margin-left:18px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #no_discount .price_label{ }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #no_discount .price_value{ font-weight:bold;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount{ line-height:40px; margin-top:10px; margin-left:20px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price{ white-space:nowrap; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price .price_label{  font-size:18px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price .money_symbol{ font-size:12px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price .price_value{ font-size:24px; font-weight:bold;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price .discount_value{ font-size:24px; font-weight:bold; margin-left:20px; display:none;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price .discount_value .discount_number{ display:inline-block; vertical-align:top; width:3rem; overflow:hidden; white-space:nowrap;    text-overflow: ellipsis;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .discount_price .discount_time{ display:inline-block;  border-radius:15px; padding-left:15px; padding-right:15px;vertical-align:top; height:30px; line-height:30px;  margin-left:10px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .normal_price{}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .normal_price .sold_sum{  font-size:1rem; margin-left:25px; margin-right:25px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .normal_price .comment_sum{  font-size:1rem; text-align:right;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .normal_price .price_label{ font-size:1rem;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .price_info .price_div #have_discount .normal_price .price_value{ font-size:1rem; text-decoration:line-through;}
	#<?php echo $module['module_name'];?>_html .sold_sum{padding-left:10px; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .comment_sum{padding-left:10px; padding-right:10px;}

    #<?php echo $module['module_name'];?>_html .log_div{ margin-top:5px; margin-bottom:5px; white-space:nowrap; border-bottom:#CCC dashed 1px; padding-bottom:5px; font-size:0.9rem;}
    #<?php echo $module['module_name'];?>_html .log_div a{ display:block;  display:inline-block; vertical-align:top; width:33%; text-align:center; border-right:1px #CCCCCC dashed; }
	#<?php echo $module['module_name'];?>_html .log_div a:last-child{ border-right:none;}
	#<?php echo $module['module_name'];?>_html .log_div a:hover{ opacity:0.8; font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .log_div .m_label{  padding-right:3px; color:#999;}
	#<?php echo $module['module_name'];?>_html .log_div .value{ font-weight:bold; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .fulfil_preferential{  display:none; line-height:35px; padding-left:20px; font-size:15px; width:100%;background-color: #d8d8d8; white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .fulfil_preferential .fulfil_label{ }	
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications{}
	
	
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .color_label{ display:inline-block; vertical-align:top; line-height:35px; vertical-align:top; text-align:right; padding-right:10px; width:15%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .color_line_div{ margin-top:20px; margin-bottom:20px;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .color_option{ display:inline-block; vertical-align:top; vertical-align:top; overflow:hidden; width:82%;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .color_option a{display:inline-block; vertical-align:top;  overflow:hidden; /*line-height:40px; height:40px; */padding:3px; border:1px solid #ccc; margin:0 4px; margin-bottom:10px; }
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .color_option a:hover{ border:1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .color_option a:hover img{}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .color_option .selected{border:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .color_option .disable{ opacity:0.1; filter:alpha(opacity=10); cursor:default;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .color_option .disable:hover{ border:1px solid #ccc;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .color_option a img{ height:30px;}
	
	
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .option_label{ display:inline-block; vertical-align:top; line-height:32px; vertical-align:top; text-align:right; width:15%; overflow:hidden; white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .option_line_div{ margin-top:20px; margin-bottom:20px;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .option_option{ display:inline-block; vertical-align:top; vertical-align:top;overflow:hidden; width:82%;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .option_option a{ margin-bottom:10px;  margin-left:4px; margin-right:4px; padding-left:4px; padding-right:4px; display:inline-block; vertical-align:top; line-height:40px; min-width:30px; text-align:center; height:40px; vertical-align:top;  overflow:hidden; border:1px solid #ddd;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .option_option a:hover{ border:1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .option_option .selected{ border:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .option_option .disable{ opacity:0.1; filter:alpha(opacity=10); cursor:default;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .specifications .option_option .disable:hover{ border:1px solid #ccc;}

	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div{ margin-top:20px;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div .quantity_label{ display:inline-block; vertical-align:top; line-height:30px; vertical-align:top; text-align:right; padding-right:10px; width:15%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div .quantity_value{ display:inline-block; vertical-align:top; vertical-align:top;  overflow:hidden;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div .quantity_value .decrease_quantity{ display:inline-block;  width:38px; height:38px; border:1px solid #ccc; vertical-align:top; background:#ccc;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div .quantity_value .decrease_quantity:before {font: normal normal normal 1rem/1 FontAwesome; content: "\F068"; padding:0 5px 0 10px;vertical-align: top;line-height: 38px;margin-left: 3px;}	
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div .quantity_value .decrease_quantity:hover{ background:#eaeaea; border:1px solid #ccc;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div .quantity_value #quantity{ width:70px; text-align:center; height:38px; line-height:38px; border:1px solid #ccc; border-radius:0px; border-left:0px; border-right:0px;padding:0px;} 
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div .quantity_value .add_quantity{display:inline-block;  width:38px; height:38px;  border:1px solid #ccc; vertical-align:top;  background:#ccc;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div .quantity_value .add_quantity:before {font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; padding:0 5px 0 10px;vertical-align: top;line-height: 38px;margin-left: 3px;}	
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div .quantity_value .add_quantity:hover{ background:#eaeaea; border:1px solid #ccc;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div .quantity_value .unit{ display:inline-block;margin-left:5px; margin-right:5px;}
	#<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity_div .quantity_value .inventory{ display:inline-block; }

    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .quantity{}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div #s_select_state{ display:none; margin-left:17%;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div #s_select_state .default{display:inline-block; vertical-align:top; padding:2px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .tips{ border:1px solid #F00; font-weight:bold; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .tips .default span{ }
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
	
		
img{vertical-align:top;border:0;}
/* box */
.box{width:610px;margin:100px auto;}
.tb-pic a{display:table-cell;text-align:center;vertical-align:middle;}
.tb-pic a img{vertical-align:middle;}
.tb-pic a{*display:block;*font-family:Arial;*line-height:1;}
.tb-thumb{margin:10px 0 0;overflow:hidden;}
.tb-thumb li{background:none repeat scroll 0 0 transparent;float:left;height:42px;margin:0 6px 0 0;overflow:hidden;padding:1px;}
.tb-s310, .tb-s310 a{height:450px;width:450px;}
.tb-s310, .tb-s310 img{max-height:450px;max-width:450px;}
.tb-s310 a{*font-size:271px;}
.tb-s40 a{*font-size:35px;}
.tb-s40, .tb-s40 a{height:40px;width:40px;}
.tb-booth{border:1px solid #CDCDCD;position:relative;z-index:1;}
.tb-thumb .tb-selected{background:none repeat scroll 0 0 #C30008;height:40px;padding:2px;}
.tb-thumb .tb-selected div{border:medium none;}
.tb-thumb li div{border:1px solid #CDCDCD;}
div.zoomDiv{z-index:999;position:absolute;top:0px;left:0px;width:200px;height:200px;background:#ffffff;border:1px solid #CCCCCC;display:none;text-align:center;overflow:hidden;}
div.zoomMask{position:absolute;background:url("<?php echo get_template_dir(__FILE__);?>img/mask.png") repeat scroll 0 0 transparent;cursor:move;z-index:1;}
	
	
	
	

	#<?php echo $module['module_name'];?>_html #relevance_package_div{  border:1px solid #e7e7e7; white-space:normal;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .relevance_package{  border-bottom:1px solid #e7e7e7; height:60px; line-height:60px; display:inline-block; vertical-align:top; width:100%; font-size:20px;  padding-left:2%;}	
	#<?php echo $module['module_name'];?>_html #relevance_package_div .package_div{ display:inline-block; vertical-align:top; margin-top:20px; min-width:640px; padding-left:28px;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .add_symbol{  text-align:center; display:inline-block; width:35px;height:35px;color: #CCC;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .add_symbol:before{
	font: normal normal normal 35px/1 FontAwesome;
	content: "\f067";}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .equal_symbol{  text-align:center;  display:inline-block; vertical-align:top; width:60px; height:50px;vertical-align:middle;color: #CCC;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .equal_symbol:before{
	font: normal normal normal 35px/1 monxin;
	content: "\f00C";}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div{ display:inline-block; vertical-align:top;vertical-align: middle; height:165px; line-height:35px; overflow:hidden; text-align:left;padding:20px;color: #666;} 
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .normal_price {}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .normal_price .money_symbol{ text-decoration:line-through; }
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .normal_price .value{ text-decoration:line-through; }
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .normal_price .more_than{ text-decoration:line-through;  font-size:12px; margin-left:3px;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .package_price .money_symbol{}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .package_price .value{ font-weight:bold;color: <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .package_price .more_than{ font-size:12px; margin-left:3px; margin-left:3px; }
	#<?php echo $module['module_name'];?>_html #relevance_package_div .money_symbol{ font-size:0.9rem; padding-left:2px;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .save_money .value{ font-weight:bold;color: <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .save_money .more_than{ font-size:12px; margin-left:3px; }
	#<?php echo $module['module_name'];?>_html #relevance_package_div .result_div .view{   display:inline-block; vertical-align:top; border-radius:3px; height:25px; line-height:25px; font-size:15px; padding-left:10px; padding-right:10px; text-align:center;}
	
    #<?php echo $module['module_name'];?>_html #relevance_package_div .goods_div{ display:inline-block; vertical-align:top; vertical-align: middle; height:165px;  width:150px; overflow:hidden; line-height:20px; text-align:center;}
    #<?php echo $module['module_name'];?>_html #relevance_package_div .goods_div .goods_a{ display:block;overflow:hidden; font-size:1rem; line-height:19px;}
    #<?php echo $module['module_name'];?>_html #relevance_package_div .goods_div .goods_a:hover img{ max-width:115px; height:115px;}
    #<?php echo $module['module_name'];?>_html #relevance_package_div .goods_div .goods_a img{ max-width:120px; height:120px;}
    #<?php echo $module['module_name'];?>_html .goods_div .money_symbol{   font-size:12px;}
    #<?php echo $module['module_name'];?>_html .goods_div .money_value{color: <?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>;}
    #<?php echo $module['module_name'];?>_html .goods_div .money_symbol{color: <?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; font-size:0.9rem; padding-left:2px;  }
	
    #<?php echo $module['module_name'];?>_html .goods_div .goods_name{ display:block; width:100%; overflow: hidden;  white-space: nowrap; text-overflow: ellipsis;}



	#<?php echo $module['module_name'];?>_html #relevance_goods_div{ border:1px solid #e7e7e7; margin-top:15px; white-space:normal;}	
    #<?php echo $module['module_name'];?>_html #relevance_goods_div .relevance_package{  border-bottom:1px solid #e7e7e7; height:60px; line-height:60px; display:inline-block; vertical-align:top; width:100%; font-size:20px;  padding-left:2%;}
    #<?php echo $module['module_name'];?>_html #relevance_goods_div{}
    #<?php echo $module['module_name'];?>_html #relevance_goods_div .goods_a{ display:inline-block; vertical-align:top; width:150px; height:165px; margin:36px; text-align:center;}
    #<?php echo $module['module_name'];?>_html #relevance_goods_div .goods_a img{ max-width:150px; height:150px;}
    #<?php echo $module['module_name'];?>_html #relevance_goods_div .goods_a:hover img{ max-width:145px; height:145px;}
    #<?php echo $module['module_name'];?>_html #relevance_goods_div a .money_symbol{color: <?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; font-size:0.9rem; padding-left:2px;  }
    #<?php echo $module['module_name'];?>_html #relevance_goods_div a .money_value{color: <?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; }
    #<?php echo $module['module_name'];?>_html #relevance_goods_div a .title{  display:inline-block; vertical-align:top; height:20px; overflow:hidden; line-height:19px; font-size:1rem; width:100%; text-align:left;}

	
	
	#<?php echo $module['module_name'];?>_html #goods_detail_div{ margin-top:15px; }
	#<?php echo $module['module_name'];?>_html #goods_detail_div img{ max-width:100%;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div{ border:1px solid #e7e7e7; height:45px; line-height:45px; display:inline-block; vertical-align:top; width:100%; font-size:15px; background-color: #f3f3f3; padding-left:6px;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div a{ display:inline-block; vertical-align:top; width:160px; text-align:center; border-top:3px solid #f3f3f3;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div a:hover{ font-weight:bold;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div .current{   border-top:3px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; background:#fff;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail{}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail .attribute{ padding:0px; margin:0px; margin-bottom:20px; color:#999;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail .attribute li{display:inline-block; vertical-align:top; width:30%;  display:inline-block; vertical-align:top; height:30px; line-height:30px; white-space:nowrap; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute{ width:92%; padding:2%;   border-top:none; margin:2%; border:1px solid #e7e7e7;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute div{ display:inline-block; vertical-align:top; width:33%;  display:inline-block; vertical-align:top; height:30px; line-height:30px; overflow:hidden; white-space:nowrap; text-overflow: ellipsis;} 
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute div .a_label{ display:inline-block; vertical-align:top; margin-right:8px; width:6rem; text-align:right; overflow:hidden; height:30px; vertical-align:top;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute div .a_value{  vertical-align:top;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_detail_html{ margin-top:20px; line-height:30px; width:100%; padding:2%}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_detail_html img{}

	
	#<?php echo $module['module_name'];?>_html #comment_div{ margin-top:15px; background:#fff;}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_title{ border-bottom:#ccc solid 1px; line-height:2rem;}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_title:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f1d7"; opacity:0.5;}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_label{}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_label a{ display:inline-block; vertical-align:top; height:2rem; line-height:2rem;  border:1px solid #ddd; padding-left:20px; padding-right:20px; margin:15px;background-color: #f3f3f3;}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_label a:hover{   border:none;background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;  }
	#<?php echo $module['module_name'];?>_html #comment_div .comment_label .selected{  border:none;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	#<?php echo $module['module_name'];?>_html #comment_div .comment_content{ padding:15px;}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_content .cooment_line{ padding-top:15px; padding-bottom:15px; }
	#<?php echo $module['module_name'];?>_html #comment_div .comment_content .cooment_line{}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_page{ display:none;}
	#<?php echo $module['module_name'];?>_html #comment_div .comment_page_div{ display:none;}
	
    #<?php echo $module['module_name'];?> .buyer{ text-align:left; line-height:25px;}
    #<?php echo $module['module_name'];?> .buyer .username{text-align:left;}
    #<?php echo $module['module_name'];?> .buyer .point{  display:inline-block; width:6px; vertical-align:top; overflow:hidden; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
    #<?php echo $module['module_name'];?> .buyer .point:after {
	font: normal normal normal 24px/1 FontAwesome;
	content: "\f0d9";}
    #<?php echo $module['module_name'];?> .buyer .content{ display:inline-block; vertical-align:top; padding-left:10px;  padding-right:10px; border-radius:5px;  font-size:1rem;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
    #<?php echo $module['module_name'];?> .buyer .level{ padding-left:10px;}
    #<?php echo $module['module_name'];?> .buyer .time{padding-left:10px;  font-size:13px; color:#999;}

    #<?php echo $module['module_name'];?> .buyer .content .seller{ font-style:oblique;}
    #<?php echo $module['module_name'];?> .buyer .content .seller .username{ }
    #<?php echo $module['module_name'];?> .buyer .content .seller .time{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	
	#<?php echo $module['module_name'];?>_html #comment_div .comment_content .comment_page{}
	
	#<?php echo $module['module_name'];?>_html #sold_div{margin-top:15px;   }
	#<?php echo $module['module_name'];?>_html #sold_div .sold_title{ border-bottom:#ccc solid 1px; line-height:2rem;}
	#<?php echo $module['module_name'];?>_html #sold_div .sold_title:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f036"; opacity:0.5;}
	
	
	#<?php echo $module['module_name'];?>_html #sold_div table{ }	
	#<?php echo $module['module_name'];?>_html #sold_div #sold_table{ margin-top:10px;width:100%; white-space:nowrap; overflow: hidden; text-overflow: ellipsis;}	
	#<?php echo $module['module_name'];?>_html #sold_div #sold_table thead{ box-shadow:0px 2px 0px 0px rgba(221,226,231,.9); line-height:2rem;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}	
	#<?php echo $module['module_name'];?>_html #sold_div #sold_table thead tr td{ width:20%; text-align:center;}	
	#<?php echo $module['module_name'];?>_html #sold_div #sold_table tbody tr td{ width:20%; text-align:center; padding-bottom:15px; padding-top:15px; border-bottom:1px solid #e7e7e7;}	
	#<?php echo $module['module_name'];?>_html #sold_div #sold_table tbody tr:hover td{ border-bottom:solid 1px <?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;  }	
	#<?php echo $module['module_name'];?>_html #sold_div .sold_page{ display:block; text-align:center;}
	
	#<?php echo $module['module_name'];?>_html .position{  border-bottom:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;font-weight:bold;padding-left:15px;  margin-bottom:10px; margin-top:5px;  margin:auto;}
	#<?php echo $module['module_name'];?>_html .position a{ display:inline-block;    line-height:30px;  height:30px; font-weight:lighter; }
	#<?php echo $module['module_name'];?>_html .position a:after{font-family:"FontAwesome"; font-size:5px; padding:5px; content: "\f105";}
	#<?php echo $module['module_name'];?>_html .position a:hover{ font-weight:bold;}
	
	
	#<?php echo $module['module_name'];?>_html #pre_sale{ line-height:30px; padding-left:10px;}
	#<?php echo $module['module_name'];?>_html #pre_sale .price_label { display:inline-block; width:60px;}
	#<?php echo $module['module_name'];?>_html #pre_sale .old_price .value{ text-decoration:line-through;}
	#<?php echo $module['module_name'];?>_html #pre_sale .pre_price .price_value{ font-size:18px; font-weight:bold;}
	#<?php echo $module['module_name'];?>_html #pre_sale .pre_deposit .deposit_value{ font-size:24px; font-weight:bold; }
	#<?php echo $module['module_name'];?>_html #pre_sale .pre_deposit .reduction_div{ padding:10px;}
	#<?php echo $module['module_name'];?>_html .pre_sale_rules{ display:inline-block; float:right; text-align:right; padding-right:10px; color:#fff; }
	#<?php echo $module['module_name'];?>_html .pre_sale_rules:after{
		font: normal normal normal 12px/1 FontAwesome;
		margin-left:3px;
		 content: "\f078"; font-weight:100;
	}
	.pre_sale_rules_description{  text-align:left; padding:10px; right:30px; width:400px; border:1px solid #CCC; z-index:9999; position: absolute;  display:none; background:#fff; white-space:normal;box-shadow: 0 0 5px #888;}
	#<?php echo $module['module_name'];?>_html .transaction_progress{ height:100px; line-height:100px;  margin-top:10px;  margin-bottom:10px; padding-left:20px; white-space:nowrap; }
	#<?php echo $module['module_name'];?>_html .transaction_progress .name{ display:inline-block; vertical-align:top; width:60px;font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .transaction_progress .step{ font-weight:bold; }
	#<?php echo $module['module_name'];?>_html .transaction_progress .start{display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .transaction_progress .middle{display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .transaction_progress .end{display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .transaction_progress .end:before{
		font: normal normal normal 45px/1 monxin;
		margin-left:10px;
		margin-right:10px;
		line-height:60px;
		content: "\f005";
		
		opacity:0.1;
	}
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_1{ display:inline-block; vertical-align:top; width:23%; line-height:30px; margin-top:15px;}
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_2{ display:inline-block; vertical-align:top; width:27%; line-height:30px; margin-top:15px;}
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_3{ display:inline-block; vertical-align:top; width:22%; line-height:60px; margin-top:16px; }
	#<?php echo $module['module_name'];?>_html .transaction_progress .order_step_4{ display:inline-block; vertical-align:top; width:22%; line-height:30px; margin-top:15px;}
	
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
	#goods_detail{ white-space:normal;}
	#<?php echo $module['module_name'];?>_html .goods_qr_div{ display:inline-block; vertical-align:top; }
	#<?php echo $module['module_name'];?>_html .goods_qr_div .show_goods_qr{ min-width:30px; color:#999;}
	#<?php echo $module['module_name'];?>_html .goods_qr_div .show_goods_qr:before {font: normal normal normal 2.5rem/1 FontAwesome; content: "\f029"; cursor: pointer; }
	#<?php echo $module['module_name'];?>_html .goods_qr_div .goods_qr{ position: absolute; border:2px solid #ccc; display:none; background:#fff;  text-align:center; padding-bottom:1rem; z-index:9999999;}
	#<?php echo $module['module_name'];?>_html .goods_qr_div .goods_qr img{ }
	#<?php echo $module['module_name'];?>_html .money_symbol{ padding-left:2px; font-size:0.9rem;}
	#<?php echo $module['module_name'];?>_html .yuan_2{ line-height:100px;  padding-right:8px;color:#fff; font-size:0.8rem; float:right; }
	
    </style>
    <script src=<?php echo get_template_dir(__FILE__);?>/zoom.js></script>
    
    <div id="<?php echo $module['module_name'];?>_html">
       <div class=position><?php echo $module['position'];?></div>
    	<div id="goods_act_div">
        	<div id="thumb_img_div">
            	<div id=show_thumb_div_out class="easyzoom easyzoom--adjacent"><a id=show_thumb_div href="./program/mall/img/<?php echo $module['data']['icon']?>" ><img src="./program/mall/img/<?php echo $module['data']['icon']?>" rel="./program/mall/img/<?php echo $module['data']['icon']?>"  class="jqzoom"  /></a></div>
                <div id=thumb_list_div><a href="" id=show_left class="show_left_disable"> </a><div id=fix_width_div><div id=auto_width_div><?php echo $module['data']['thumb_list'];?></div></div><a href="" id=show_right class="show_right_able"> </a></div>
                
            </div><div id="act_div">
            	<div class=title><?php echo $module['data']['title'];?></div>
            	<div class=advantage><?php echo $module['data']['advantage'];?></div>
            	
                <div class=price_info><?php echo @$module['data']['price_info'];?>
                	<div class=price_div>
                    	<?php echo $module['price_div_html'];?>
                    </div>
                </div>
                
                <div class=fulfil_preferential><span class=fulfil_label><?php echo self::$language['fulfil_preferential'];?></span><span class=fulfil_value><?php echo $module['fulfil_preferential'];?></span></div>
                <div class=log_div><?php echo $module['log_div_html'];?></div>
                
            	<div class=specifications><?php echo @$module['option_html'];?></div>
                
            	<div class=quantity_div><span class=quantity_label><?php echo self::$language['quantity'];?></span><div class="quantity_value"><a href="#" class=decrease_quantity title="-1"> </a><input type="text" id=quantity value="1" /><a href="#" class=add_quantity title="+1"> </a><span class=unit><?php echo $module['unit'];?></span><span class=inventory><span class=s><?php echo self::$language['inventory'];?></span><span class=inventory_m><?php echo $module['inventory'];?></span><span class=e><?php echo $module['unit'];?></span></span><span class=unit_gram value=<?php echo $_POST['temp_unit_gram'];?>></span><?php echo $module['data']['limit']?></div></div>
            	
                <div id=s_select_state><span class="default"><span> </span></span></div>
                
                <div class=m_button>
                	<a href="./index.php?monxin=mall.confirm_order&goods_src=goods_id&id=<?php echo $_GET['id']?>" rel="nofollow" id=submit class="buy_now"><?php echo self::$language['buy_now']?></a>
                    <a href="#" id=submit class="add_cart"><?php echo self::$language['add_cart']?></a> <span class=cart_state></span>
                   
                    <a href="#" id=submit class="add_favorite"><?php echo self::$language['favorite']?></a>
                    <div class=goods_qr_div><a class=show_goods_qr></a><div class=goods_qr><img /><div><?php echo self::$language['scan_code_purchase']?></div></div></div>
                </div>
                <?php echo $module['data']['out_delivered'];?>
            </div>
        </div>
    	
    	<?php echo $module['transaction_progress'];?>

    	<?php echo $module['html'];?>
       
    	
    </div>
</div>
<div class=pre_sale_rules_description><?php echo self::$language['pre_sale_rules_description'];?></div>