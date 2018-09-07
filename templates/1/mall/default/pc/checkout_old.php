<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
	var checkout_id=0;
	var qr_timer;
	var temp_save_list=new Array();;
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>").height($(window).height());
		$("#<?php echo $module['module_name'];?> .hot_key").click(function(){
			if($(this).children('div').css('display')=='none'){
				$(this).children('div').css('display','block');
			}else{
				$(this).children('div').css('display','none');
			}
			return false;	
		});
		$(window).keydown(function(event){
			if(event.keyCode==32){
				if($("#<?php echo $module['module_name'];?> .received_money").val()==''){
					$("#<?php echo $module['module_name'];?> .received_money").val($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html());
				}
				submit_checkout();
				return false;
			}
			if(event.shiftKey && event.keyCode==81){
				$("#<?php echo $module['module_name'];?> .barcode").focus();
				return false;
			}
			if(event.shiftKey && event.keyCode==65){
				$("#<?php echo $module['module_name'];?> .user").focus();
				return false;
			}
			if(event.shiftKey && event.keyCode==90){
				$("#<?php echo $module['module_name'];?> .received_money").focus();
				return false;
			}
			if(event.shiftKey && event.keyCode==88){
				
				reset_desk();
				$("#<?php echo $module['module_name'];?> .barcode").focus();
				return false;
			}
				
		});
		
		$(window).focus(function(){
			$("#<?php echo $module['module_name'];?> .barcode").focus();
		});

		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});
		
		update_temp_save_list();
		update_import_select();

		$("#<?php echo $module['module_name'];?> .barcode").focus();
		$("#<?php echo $module['module_name'];?> .barcode").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){
				if($(this).val()=='00000000001'){
					$(this).val('');
					$("#<?php echo $module['module_name'];?> .received_money").focus();
					return false;
				}
				if( $(this).val()=='00000000002'){
					$(this).val('');
					$("#<?php echo $module['module_name'];?> .user").focus();
					return false;
				}
				if( $(this).val()=='00000000000'){
					reset_desk();
					$("#<?php echo $module['module_name'];?> .barcode").focus();
					return false;
				}
				
				
				$(this).next().html('');
				$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=submit',{barcode:$(this).val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#<?php echo $module['module_name'];?> .barcode").next().html(v.info);
					if(v.state=='success'){
						if(v.html){
							$("#<?php echo $module['module_name'];?> .barcode").val('');
							$("#<?php echo $module['module_name'];?> #tr_"+v.key).remove();
							if($("#<?php echo $module['module_name'];?> [monxin-table] tbody tr").length>0){
								$(v.html).insertBefore("#<?php echo $module['module_name'];?> [monxin-table] tbody tr:first");
							}else{
								$("#<?php echo $module['module_name'];?> [monxin-table] tbody").html(v.html);	
							}
							update_checkout_goods_sum();
							$("#<?php echo $module['module_name'];?> .barcode").focus();
						}
						if(v.act){
							set_iframe_position(1200,550);
							//monxin_alert(replace_file);
							$("#monxin_iframe").attr('scrolling','auto');
							$("#fade_div").css('display','block');
							$("#set_monxin_iframe_div").css('display','block');
							$("#monxin_iframe").attr('src','./index.php?monxin=mall.checkout_search&search='+$("#<?php echo $module['module_name'];?> .barcode").val());
						}
						
					}
				});
				return false;	
			}
        });
		
		$("#<?php echo $module['module_name'];?> .preferential_code").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){
				update_fulfil();
				//return false;	
			}
        });

		$("[monxin-table] thead a").unbind("click");
		$("#<?php echo $module['module_name'];?> .preferential_way").change(function(){
			switch($(this).val()){
				case '2':
					$(this).next().css('display','none');
					update_fulfil();
					$(".price_td .normal").removeClass('abandon');
					update_shop_group_discount();
					break;
				case '5':
					$(this).next().css('display','none');
					if($("#<?php echo $module['module_name'];?> #user_info .user_state .balance").html()==null){
						alert('<?php echo self::$language['member']?><?php echo self::$language['info']?><?php echo self::$language['err']?>');
						$("#<?php echo $module['module_name'];?> .preferential_way").val(2);
						update_fulfil();
						$(".price_td .normal").removeClass('abandon');
						update_shop_group_discount();
						$("#<?php echo $module['module_name'];?> .preferential_way").next().css('display','none');
						return false;
					}
					$(".price_td .normal").addClass('abandon');
					update_shop_group_discount();
					break;
				default:
					$("#<?php echo $module['module_name'];?> .preferential_code").val('');
					$("#<?php echo $module['module_name'];?> .preferential_code_span").css('display','inline-block');
					
					$("#<?php echo $module['module_name'];?> .decrease").html('');
					
					$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html($("#<?php echo $module['module_name'];?> .sum_info .goods_price").html());
					$(".price_td .normal").removeClass('abandon');
					update_shop_group_discount();
						
			}
			
		});
		
		
		
		$("#<?php echo $module['module_name'];?> .pay_method").change(function(){
			if(parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html())<=0){$("#<?php echo $module['module_name'];?> .pay_method").val('cash');return false;}
			if($(this).val()=='alipay' || $(this).val()=='weixin'){
				set_iframe_position(1200,550);
				//monxin_alert(replace_file);
				$("#monxin_iframe").attr('scrolling','auto');
				$("#fade_div").css('display','block');
				$("#set_monxin_iframe_div").css('display','block');
				$("#monxin_iframe").attr('src','./index.php?monxin=mall.checkout_search&act=scanpay&id='+$("#<?php echo $module['module_name'];?> .pay_method option[value='"+$(this).val()+"']").attr('account_id')+'&user='+$("#<?php echo $module['module_name'];?> .user").val()+'&money='+$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html());
				return false;
			}
			
			$("#<?php echo $module['module_name'];?> .pay_method_sub_div div").css('display','none');	
			$("#<?php echo $module['module_name'];?> .pay_method_sub_div ."+$(this).val()+"_div").css('display','inline-block');
			if($(this).val()=='shop_balance'){$("#<?php echo $module['module_name'];?> .pay_method_sub_div .balance_div").css('display','inline-block');}
			
			if((($(this).val()=='shop_balance' || $(this).val()=='balance')) && parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html())>0){
				
				//$("#<?php echo $module['module_name'];?> .pay_method_sub_div ."+$(this).val()+"_div img").attr('src','./program/mall/img/loading.gif');
				$.get('<?php echo $module['action_url'];?>&act=add_checkout&pay_method='+$(this).val(),{money:$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html(),username:$("#<?php echo $module['module_name'];?> .user").val(),}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> .pay_method_sub_div ."+$("#<?php echo $module['module_name'];?> .pay_method").val()+"_div img").css('display','none');
						//$("#<?php echo $module['module_name'];?> .pay_method_sub_div ."+$("#<?php echo $module['module_name'];?> .pay_method").val()+"_div img").attr('src','./plugin/qrcode/index.php?text='+v.url+'&logo=1');
						checkout_id=v.id;
						//update_qrcode_state();
						//qr_timer=window.setInterval(update_qrcode_state,15000);
					}
				});
				
				
			}else{window.clearInterval(qr_timer);}	
		});
		$("#<?php echo $module['module_name'];?> .temporary_storage,.import").click(function(){
			if($(this).next().css('display')=='none'){
				$(this).next().css('display','inline-block').css('vertical-align','top');
			}else{
				$(this).next().css('display','none');
			}
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .temp_name").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){
				if(getCookie('checkout_desk')==''){alert('<?php echo self::$language['goods']?><?php echo self::$language['is_null'];?>');return false;}
				if($.inArray($(this).val(),temp_save_list)!=-1){alert('<?php echo self::$language['exist_same']?>');return false;}
				setCookie('temp_save_'+$(this).val(),getCookie('checkout_desk'),30);
				if(getCookie('temp_save_list')){temp=getCookie('temp_save_list');}else{temp='';}
				setCookie('temp_save_list',temp+$(this).val()+',',30);
				update_temp_save_list();
				
				$("#<?php echo $module['module_name'];?> [monxin-table] tbody td").animate({opacity:0},"slow",function(){$("#<?php echo $module['module_name'];?> [monxin-table] tbody td").css('display','none');});
				setCookie('checkout_desk','',30);
				update_checkout_goods_sum();
				update_import_select();
				reset_desk()
				$("#<?php echo $module['module_name'];?> .temp_name").val('');
				return false;
			}
        });
		
		
		$("#<?php echo $module['module_name'];?> .import_select").change(function(){
			if($(this).val()==''){return false;}
			temp=getCookie('checkout_desk');
			if(temp!=''){alert('<?php echo self::$language['please_handle_the_existing_goods_empty_or_temporary'];?>');return false;}
				if($.inArray($(this).val(),temp_save_list)==-1){alert('<?php echo self::$language['not_exist']?>');return false;}
				if(getCookie('temp_save_'+$(this).val())){
					setCookie('checkout_desk',unescape(getCookie('temp_save_'+$(this).val())),30);
					document.cookie = 'temp_save_'+$(this).val()+"=;expires="+(new Date(0)).toGMTString();
				}
				
				if(getCookie('temp_save_list')){temp=unescape(getCookie('temp_save_list'));}else{temp='';}
				temp2=$(this).val()+',';
				setCookie('temp_save_list',temp.replace(eval("/" + temp2 + "/gi"),''),30);
				update_temp_save_list();
				window.location.reload();
        });

		$(document).on('click',"#<?php echo $module['module_name'];?> .quantity_div a",function(){
			if($(this).attr('class')=='decrease_quantity'){
				$("#<?php echo $module['module_name'];?> #"+$(this).parent().parent().attr('id')+" .quantity").val(parseFloat($("#<?php echo $module['module_name'];?> #"+$(this).parent().parent().attr('id')+" .quantity").val())-1);
				 format_quantity($(this).parent().parent().attr('id'));
			}else{
				$("#<?php echo $module['module_name'];?> #"+$(this).parent().parent().attr('id')+" .quantity").val(parseFloat($("#<?php echo $module['module_name'];?> #"+$(this).parent().parent().attr('id')+" .quantity").val())+1);
				 format_quantity($(this).parent().parent().attr('id'));
			}
			update_checkout_goods_sum();
			return false;	
		})
		$(document).on('change',"#<?php echo $module['module_name'];?> .quantity_div .quantity",function(){
			format_quantity($(this).parent().parent().attr('id'));
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?>_table .del",function(){
			// if(confirm("<?php echo self::$language['delete_confirm']?>")){
				del_checkout_goods($(this).parent().parent().attr('id'));
			// }
			return false;
		});
		
		
		
		
		$("#<?php echo $module['module_name'];?> .clear_all").click(function(){
			$("#<?php echo $module['module_name'];?> [monxin-table] tbody tr").remove();

			setCookie('checkout_desk','',30);
			update_checkout_goods_sum();
			reset_desk();
			$("#<?php echo $module['module_name'];?> .barcode").focus();
			return false;
		});
		
		
		$("#<?php echo $module['module_name'];?> .user").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){
				$(this).next().html('');
				$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=check_user',{username:$(this).val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#<?php echo $module['module_name'];?> .user").next().html(v.info);
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> .user").next().attr('g_id',v.group_id);
						$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method_2'];?>');
						if(parseFloat($("#<?php echo $module['module_name'];?> .balance").html())>=parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html())){
							$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method_full_no_shop'];?>');	
						}
						if(parseFloat($("#<?php echo $module['module_name'];?> .shop_balance").html())>=parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html())){
							$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method_full_no_web'];?>');	
						}
						if(parseFloat($("#<?php echo $module['module_name'];?> .balance").html())>=parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html()) && parseFloat($("#<?php echo $module['module_name'];?> .shop_balance").html())>=parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html())){
							$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method_full'];?>');	
						}
						$("#<?php echo $module['module_name'];?> .received_money").focus();
						if(v.group_name!=''){
							$("#<?php echo $module['module_name'];?> .preferential_way").html('<?php echo $module['preferential_way_option_2'];?>');
							$("#<?php echo $module['module_name'];?> .preferential_way option[value=5]").html(v.group_name+' '+v.group_discount+'<?php echo self::$language['discount']?>');
							$("#<?php echo $module['module_name'];?> .preferential_way option[value=5]").attr('discount',v.group_discount);
							if(v.group_discount<10){
								$("#<?php echo $module['module_name'];?> .preferential_way").val(5);
								$(".price_td .normal").addClass('abandon');
								update_shop_group_discount();
								$("#<?php echo $module['module_name'];?> .received_money").focus();
							}
							
						}else{
							$("#<?php echo $module['module_name'];?> .preferential_way").html('<?php echo $module['preferential_way_option'];?>');
							update_fulfil();
							$(".price_td .normal").removeClass('abandon');
							
						}
						
					}else{
						$("#<?php echo $module['module_name'];?> .preferential_way").html('<?php echo $module['preferential_way_option'];?>');
						$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method'];?>');
						$("#<?php echo $module['module_name'];?> .user").val('');
					}
				});
				return false;	
			}
        });
	
		
		$("#<?php echo $module['module_name'];?> .received_money").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){
				if(!$.isNumeric($(this).val())){
					alert('<?php echo  self::$language['must_be']?><?php echo self::$language['number'];?>');
					$("#<?php echo $module['module_name'];?> .return_money").html('');
					return false;	
				}
				if(parseFloat($("#<?php echo $module['module_name'];?> .received_money").val())<parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html())){
					alert('<?php echo  self::$language['must_be_greater_than']?>'+$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html());
					$("#<?php echo $module['module_name'];?> .return_money").html('');
					return false;	
				}
				temp=parseFloat($("#<?php echo $module['module_name'];?> .received_money").val())-parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html());
				temp=temp.toFixed(1);
				$("#<?php echo $module['module_name'];?> .return_money").html(temp);
				submit_checkout();
			}
        });
	
		$("#<?php echo $module['module_name'];?> .transaction_password").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){
				if($(this).val().length<6){alert('<?php echo self::$language['less_six'];?>');return false;}
				
				$(this).next().html('');
				$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=check_password',{password:$(this).val(),username:$("#<?php echo $module['module_name'];?> .user").val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#<?php echo $module['module_name'];?> .transaction_password").next().html(v.info);
					if(v.state=='success'){
						submit_checkout();
					}
				});
				return false;	
			}
        });
	
		$("#<?php echo $module['module_name'];?> .credit_remark").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){submit_checkout();}
        });
	
				
		update_checkout_goods_sum();
    });
	
	function scanpay_submit_checkout(id){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		$("#<?php echo $module['module_name'];?> .pay_method").attr('scanpay_id',id);
		submit_checkout();
	}
	
	function submit_checkout(){
		window.clearInterval(qr_timer);
		if($("#<?php echo $module['module_name'];?> #submit_checkout_state").html()=='<span class=\'fa fa-spinner fa-spin\'><?php echo self::$language['submitting'];?></span>'){return false;}
		if(parseFloat($("#<?php echo $module['module_name'];?> .sum_info .goods_price").html())<=0){alert('<?php echo self::$language['goods'];?><?php echo self::$language['is_null'];?>');return false;}
		pay_method=$("#<?php echo $module['module_name'];?> .pay_method").val();
		obj=new Object();
		obj.checkout_id=checkout_id;
		obj.pay_method=pay_method;
		obj.preferential_way=$("#<?php echo $module['module_name'];?> .preferential_way").val();
		obj.preferential_code=$("#<?php echo $module['module_name'];?> .preferential_code").val();
		obj.user=$("#<?php echo $module['module_name'];?> .user").val();
		obj.goods_money=$("#<?php echo $module['module_name'];?> .goods_price").html();
		obj.payable=$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html();
		
		if(pay_method=='cash'){
			obj.received_money=$("#<?php echo $module['module_name'];?> .received_money").val();
		}
		if(pay_method=='credit'){
			
			if($("#<?php echo $module['module_name'];?> .credit_div .credit_remark").val()==''){alert('<?php echo self::$language['please_input'];?><?php echo self::$language['pay_method']['credit'];?><?php echo self::$language['remark'];?>');$("#<?php echo $module['module_name'];?> .credit_div .credit_remark").focus();return false;}
			obj.credit_remark=$("#<?php echo $module['module_name'];?> .credit_div .credit_remark").val();
			obj.transaction_password=$("#<?php echo $module['module_name'];?> .credit_div .transaction_password").val();
		}
		if(pay_method=='balance'){
			obj.transaction_password=$("#<?php echo $module['module_name'];?> .balance_div .transaction_password").val();
		}
		if(pay_method=='shop_balance'){
			obj.transaction_password=$("#<?php echo $module['module_name'];?> .balance_div .transaction_password").val();
		}
		if(pay_method=='weixin'){
			obj.scanpay_id=$("#<?php echo $module['module_name'];?> .pay_method").attr('scanpay_id');
			if(!obj.scanpay_id){return false;}
		}
		if(pay_method=='alipay'){
			obj.scanpay_id=$("#<?php echo $module['module_name'];?> .pay_method").attr('scanpay_id');
			if(!obj.scanpay_id){return false;}
		}
		$("#<?php echo $module['module_name'];?> #submit_checkout_state").html('');
		$("#<?php echo $module['module_name'];?> #submit_checkout_state").html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['submitting'];?>');
		$.post('<?php echo $module['action_url'];?>&act=submit_checkout',obj, function(data){
			window.clearInterval(qr_timer);
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#<?php echo $module['module_name'];?> #submit_checkout_state").html(v.info);
			if(v.state=='success'){
				window.clearInterval(qr_timer);
				window.print_tag.set_and_print(v.html);
				$("#<?php echo $module['module_name'];?> .barcode").focus();
				$("#<?php echo $module['module_name'];?> .transaction_password").val('');
				$("#<?php echo $module['module_name'];?> .user").val('');
				reset_desk();
				
			}
			
		});
			
	}
	function update_temp_save_list(){
		if(getCookie('temp_save_list')!=''){
			temp=unescape(getCookie('temp_save_list'));
			//alert(temp);
			temp_save_list=temp.split(",")	
		}else{
			temp_save_list=new Array();
		}
	}
	function update_import_select(){
		temp='<option value=""><?php echo self::$language['please_select'];?></option>';
		for(v in temp_save_list){
			if(temp_save_list[v]==''){continue;}
			temp+='<option vlaue="'+temp_save_list[v]+'">'+temp_save_list[v]+'</option>';	
		}
		$("#<?php echo $module['module_name'];?> .import_select").html(temp);	
	}
	update_import_select();
	function update_qrcode_state(){
		//alert(checkout_id);	
		$.get('<?php echo $module['action_url'];?>&act=check_qr_state',{id:checkout_id}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			if(v.state==1){
				$("#<?php echo $module['module_name'];?> .qr_img").next().html('<span class=success><?php echo self::$language['qr_state'][1];?></span>');
				update_qrcode_state();
			}
			if(v.state==2){
				$("#<?php echo $module['module_name'];?> .qr_img").next().html('<span class=success><?php echo self::$language['qr_state'][2];?></span>');
				window.clearInterval(qr_timer);
				submit_checkout();
				window.clearInterval(qr_timer);
			}
		});
	}
	
	function add_checkout(id,id_type){
		//alert(id+','+id_type);
		$("#<?php echo $module['module_name'];?> .barcode").next().html('');
		$("#<?php echo $module['module_name'];?> .barcode").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('<?php echo $module['action_url'];?>&act=click',{id:id,id_type:id_type}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#<?php echo $module['module_name'];?> .barcode").next().html(v.info);
			if(v.state=='success'){
				if(v.html){
					$("#<?php echo $module['module_name'];?> #tr_"+v.key).remove();
					if($("#<?php echo $module['module_name'];?> [monxin-table] tbody tr").length>0){
						$(v.html).insertBefore("#<?php echo $module['module_name'];?> [monxin-table] tbody tr:first");
					}else{
						$("#<?php echo $module['module_name'];?> [monxin-table] tbody").html(v.html);	
					}
					update_checkout_goods_sum();
					$("#<?php echo $module['module_name'];?> .barcode").focus();
				}
				
			}
		});
	}
	
	function reset_desk(){
		setCookie('checkout_desk','',30);
		update_checkout_goods_sum();
		$("#<?php echo $module['module_name'];?> input").val('');
		$("#<?php echo $module['module_name'];?> [monxin-table] tbody tr").remove();
		$("#<?php echo $module['module_name'];?> .state,.return_money,#submit_checkout_state,.user_state,.decrease,#amount_payable_line .number").html('');
		$("#<?php echo $module['module_name'];?> #user_info .user_state").attr('g_id','');
		$("#<?php echo $module['module_name'];?> .qr_img").removeAttr('src');
		$("#<?php echo $module['module_name'];?> .barcode").focus();
		$("#<?php echo $module['module_name'];?> .preferential_way").html('<?php echo $module['preferential_way_option'];?>');
		$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method'];?>');
		$("#<?php echo $module['module_name'];?> .decrease").html('0');
		$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html('0');
		$("#<?php echo $module['module_name'];?> #"+id+" .subtotal").html('0');
		$("#<?php echo $module['module_name'];?> #use_method_line .decrease").html('0');
		$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html('0');
		$(".preferential_way").val(2);
		$(".pay_method").val('cash');
		
		update_fulfil();
	}
	
	function format_quantity(id){
		obj=$("#<?php echo $module['module_name'];?> #"+id+" .quantity");
		
		//obj.val(obj.val().replace(/ /g,''));
		//obj.val(obj.val().replace(/\+/,''));
		//obj.val(obj.val().replace(/g/,''));
		
		if(!$.isNumeric(obj.val())){obj.val('1');}	
		if(parseFloat(obj.val())<=0){obj.val('1');}
		//if(obj.val()>parseInt($(".inventory_m").html())){obj.val(parseInt($(".inventory_m").html()));}
		sub_total=obj.val()*$("#<?php echo $module['module_name'];?> #"+id+" .price").html();
		sub_total=sub_total.toFixed(2);
		$("#<?php echo $module['module_name'];?> #"+id+" .subtotal").html(sub_total);
		if($("#<?php echo $module['module_name'];?> #"+id+" .unit_gram").prop('value')==0){
			obj.val(Math.round(obj.val()));
		}		
		update_goods_quantity(id,obj.val());
	}

	function update_goods_quantity(id,quantity){
		//alert(id+','+quantity);
		id=id.replace(/tr_/,'');
		var checkout_desk=getCookie('checkout_desk');
		if(checkout_desk!=''){
			checkout_desk=checkout_desk.replace(/%3A/g,':');
			checkout_desk=checkout_desk.replace(/%2C/g,',');
			//alert(checkout_desk);
			checkout_desk=eval('('+checkout_desk+')');
			if(checkout_desk[id]){
				checkout_desk[id]['quantity']=quantity;	
			}
			//checkout_desk[id]['time']=Date.parse(new Date());
			checkout_desk[id]['time']=checkout_desk[id]['time'];
			str='';
			for(v in checkout_desk){
				str+='"'+v+'":{"quantity":"'+checkout_desk[v]['quantity']+'","time":"'+checkout_desk[v]['time']+'","price":"'+checkout_desk[v]['price']+'"},';	
			}
			str=str.substring(0,str.length-1);
			str='{'+str+'}';
		}
		//alert(str);
		setCookie('checkout_desk',str,30);
		update_checkout_goods_sum();
	}

	function del_checkout_goods(id){
		$("#<?php echo $module['module_name'];?>_html #"+id).remove();
		id=id.replace(/tr_/,'');
		//alert(id);
		checkout_desk=getCookie('checkout_desk');
		if(checkout_desk){
			checkout_desk=checkout_desk.replace(/%3A/g,':');
			checkout_desk=checkout_desk.replace(/%2C/g,',');
			checkout_desk=eval('('+checkout_desk+')');
			str='';
			for(v in checkout_desk){
				if(v==id){continue;}
				str+='"'+v+'":{"quantity":"'+checkout_desk[v]['quantity']+'","time":"'+checkout_desk[v]['time']+'","price":"'+checkout_desk[v]['price']+'"},';	
			}
			str=str.substring(0,str.length-1);
			//alert(str);
			if(str!=''){str='{'+str+'}';}
			setCookie('checkout_desk',str,30);
		}
		
		try{update_checkout_goods_sum();}catch(e){}
		update_checkout_goods_sum();
	}
	
	
	
	function update_checkout_goods_sum(){
		checkout_desk=getCookie('checkout_desk');
		if(checkout_desk){
			checkout_desk=checkout_desk.replace(/%3A/g,':');
			checkout_desk=checkout_desk.replace(/%2C/g,',');
			checkout_desk=eval('('+checkout_desk+')');
			var checkout_goods_sum=0;
			var checkout_goods_money=0;
			temp='';
			for(v in checkout_desk){
				if(checkout_desk[v]['price']){
					checkout_goods_sum++;
					//alert(parseFloat(checkout_desk[v]['price'])+'*'+checkout_desk[v]['quantity']+'='+parseFloat(checkout_desk[v]['price'])*parseInt(checkout_desk[v]['quantity']));
					checkout_goods_money+=parseFloat(checkout_desk[v]['price'])*parseFloat(checkout_desk[v]['quantity']);
					//alert(v+'='+checkout_desk[v]['quantity']);
				}
			}
			//alert(checkout_goods_money);
			$("#<?php echo $module['module_name'];?>_html .sum_info .goods_item").html(checkout_goods_sum);
			$("#<?php echo $module['module_name'];?> .sum_info .goods_price").html(checkout_goods_money.toFixed(2));
		}else{
			$("#<?php echo $module['module_name'];?>_html .sum_info .goods_item").html('0');
			$("#<?php echo $module['module_name'];?> .sum_info .goods_price").html('0');
		}
		
		update_fulfil();
	}
	
	function get_less_money(ful,money,type){
		//alert(money);
		if(ful['use_method']==0){
			//alert(ful['discount']);
			//打折
			return money*((10-ful['discount'])/10);
		}
		if(ful['use_method']==1){
			//减钱
			return ful['less_money'];
		}
		return 0;
	}
	function update_fulfil(){
		
		sum_money=parseFloat($("#<?php echo $module['module_name'];?> .sum_info .goods_price").html());
		
		promotion_money=0;
		$("#<?php echo $module['module_name'];?> .checkout_right .sales_promotion").each(function(index, element) {
			id=$(this).parent().parent().parent().attr('id');
            promotion_money+=parseFloat($("#<?php echo $module['module_name'];?> #"+id+" .subtotal").html());
        });
		inpromotion_money=sum_money-promotion_money;
		//alert(sum_money+'='+promotion_money+'+'+inpromotion_money);
	
		if($("#<?php echo $module['module_name'];?> .preferential_way").val()==2){
			fulfil=eval('('+$("#<?php echo $module['module_name'];?> .fulfil_json").html()+')');
			fulfil_money=new Array();
			index=0;
			for(v in fulfil){
				if(fulfil[v]['min_money']<=sum_money && fulfil[v]['join_goods']==1){fulfil_money[index]=get_less_money(fulfil[v],sum_money,'sum_money');index++;}	
				if(fulfil[v]['min_money']<=promotion_money && fulfil[v]['join_goods']==0){fulfil_money[index]=get_less_money(fulfil[v],promotion_money,'promotion_money');index++;}	
				if(fulfil[v]['min_money']<=inpromotion_money && fulfil[v]['join_goods']==2){fulfil_money[index]=get_less_money(fulfil[v],inpromotion_money,'inpromotion_money');index++;}	
				
				index++;
			}
			d_max=0;
			for(v in fulfil_money){
				//alert(fulfil_money[v]);
				if(fulfil_money[v]>d_max){d_max=fulfil_money[v];}
			}
			//alert(d_max);
			$("#<?php echo $module['module_name'];?> .decrease").html('-'+d_max);
			//alert($("#<?php echo $module['module_name'];?> .decrease").html());
			if(!$.isNumeric($("#<?php echo $module['module_name'];?> .decrease").html())){
				$("#<?php echo $module['module_name'];?> .decrease").html('');
				$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html(sum_money);
			}else{
				temp=parseFloat($("#<?php echo $module['module_name'];?> .decrease").html()).toFixed(2);
				$("#<?php echo $module['module_name'];?> .decrease").html(temp);
				$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html((sum_money+parseFloat(temp)).toFixed(2));
			}
			
		}else if($("#<?php echo $module['module_name'];?> .preferential_way").val()==5){
				
			if($("#<?php echo $module['module_name'];?> #user_info .user_state .balance").html()==null){
				alert('<?php echo self::$language['member']?><?php echo self::$language['info']?><?php echo self::$language['err']?>');
				$("#<?php echo $module['module_name'];?> .preferential_way").val(2);
				return false;
			}
			$(".price_td .normal").addClass('abandon');
		
			update_shop_group_discount();
		
		}else{
			if(sum_money==0){return false;}
			$("#<?php echo $module['module_name'];?> .decrease").html('');
			$("#<?php echo $module['module_name'];?> .decrease").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=preferential_code_'+$("#<?php echo $module['module_name'];?> .preferential_way").val(),{code:$("#<?php echo $module['module_name'];?> .preferential_code").val(),sum_money:sum_money,promotion_money:promotion_money}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> .decrease").html(v.info);
				if(v.state=='success'){
					temp=parseFloat($("#<?php echo $module['module_name'];?> .decrease").html()).toFixed(2);
					$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html((sum_money+parseFloat(temp)).toFixed(2));
				}
			});
		
			
		}
		
	}
	
	function update_shop_group_discount(){
		
		$("#<?php echo $module['module_name'];?> #submit_checkout_state").html('');
		//return false;
		g_id=$("#<?php echo $module['module_name'];?> #user_info .user_state").attr('g_id');
		shop_group_discount_sum=0;
		if($("#<?php echo $module['module_name'];?> .preferential_way").val()==5){
			
			$("#<?php echo $module['module_name'];?> tbody tr").each(function(index, element) {
				id=$(this).attr('id');
				if($("#"+id+" .sales_promotion").html()){
					discount=$("#<?php echo $module['module_name'];?> #"+id).attr('g_'+g_id);
					discount=discount/10;
					$("#"+id+" .group").html((discount*parseFloat($("#"+id+" .price_td .normal .price").html())).toFixed(2));
					$("#"+id+" .g_discount").html((discount*10)+'<?php echo self::$language['discount']?>');
					$("#"+id+" .subtotal").html((discount*parseFloat($("#"+id+" .price_td .normal .price").html()) *  parseFloat($("#"+id+" .quantity").val())).toFixed(2) );
					
				}else{
					$("#"+id+" .group").html($("#"+id+" .price_td .normal .price").html());
					$("#"+id+" .subtotal").html((parseFloat($("#"+id+" .price_td .normal .price").html()) *  parseFloat($("#"+id+" .quantity").val())).toFixed(2) );		
				}
				
				shop_group_discount_sum+=parseFloat($("#"+id+" .subtotal").html());
				
			});
		}else{
			
			return false;
			//alert(discount);
			$("#<?php echo $module['module_name'];?> tbody tr").each(function(index, element) {
				id=$(this).attr('id');
				shop_group_discount_sum+=parseFloat($("#"+id+" .price_td .normal .price").html());
				$("#"+id+" .subtotal").html(parseFloat($("#"+id+" .price_td .normal .price").html()) * parseFloat($("#"+id+" .quantity").val()) );
				$("#"+id+" .group").html('');
			});
		}
		shop_group_discount_sum=shop_group_discount_sum.toFixed(2);
		temp=shop_group_discount_sum-parseFloat($("#<?php echo $module['module_name'];?> .goods_price").html());
		
		$("#<?php echo $module['module_name'];?> .decrease").html(temp.toFixed(2));
		$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html(shop_group_discount_sum);
	}	
	
    </script>
    <style>
	.page-header{ display:none;}
	.fixed_right_div{ display:none;}
	#layout_full{ }	.container{ width:100%; padding:0px; margin:0px;}
	#edit_page_layout_div .edit_page_layout_button{display:none;}
	#<?php echo $module['module_name'];?>{  height:100%;} 
	#<?php echo $module['module_name'];?> .goods_info{display:block; width:400px; height:80px;  overflow:hidden;} 
	#<?php echo $module['module_name'];?> .goods_info .img{ vertical-align:top;display:inline-block; vertical-align:top; width:80px; height:80px; overflow:hidden;}	
	#<?php echo $module['module_name'];?> .goods_info img{width:70px; height:70px; margin:5px;}	
	#<?php echo $module['module_name'];?> .goods_info .title{ vertical-align:top;display:inline-block; vertical-align:top; width:310px; padding-left:10px; height:80px;line-height:25px; font-size:15px; overflow:hidden; white-space:normal;  }	
	#<?php echo $module['module_name'];?> .subtotal{ font-weight:bold; line-height:30px;}
	#<?php echo $module['module_name'];?> .quantity_div{ line-height:30px;}
	#<?php echo $module['module_name'];?> .decrease_quantity{text-align:center; display:inline-block;  width:30px; height:30px; vertical-align:top;background:#ddd;}
	#<?php echo $module['module_name'];?> .decrease_quantity:before{font: normal normal normal 1rem/1 FontAwesome; content: "\F068";}
	#<?php echo $module['module_name'];?> .decrease_quantity:hover{ opacity:0.8; }
	#<?php echo $module['module_name'];?> .quantity{ width:50px; text-align:center; height:30px; line-height:30px; border-radius:0px; border-left:0px; border-right:0px;padding:0px; display:inline-block; vertical-align:top;} 
	
	#<?php echo $module['module_name'];?> .add_quantity{ text-align:center; display:inline-block;  width:30px; height:30px; vertical-align:top;background:#ddd; }
	#<?php echo $module['module_name'];?> .add_quantity:before{font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; }	
	#<?php echo $module['module_name'];?> .add_quantity:hover{ opacity:0.8; }
	
	   
	#<?php echo $module['module_name'];?> [monxin-table] .del{ background:none; vertical-align:top; height:30px; line-height:30px; }    
	#<?php echo $module['module_name'];?> [monxin-table] .del:hover{ }    
	#<?php echo $module['module_name'];?>_html .title_div{ line-height:40px;}    
	#<?php echo $module['module_name'];?>_html .title_div .fulfil_preferential{ font-size:1rem;  display:inline-block; vertical-align:top; margin-left:10px;}   
	
	
	#<?php echo $module['module_name'];?> .act_div{ width:48%; display:inline-block; text-align:left;overflow:hidden;}
	#<?php echo $module['module_name'];?> [monxin-table] thead tr td{ background:none;   height:40px; line-height:40px; font-size:1rem; text-align:left;}    
	#<?php echo $module['module_name'];?> [monxin-table] thead tr td .operation_icon{ background:none;} 
	#<?php echo $module['module_name'];?> [monxin-table] tbody tr td{ border:none; border-bottom:1px solid #e7e7e7; background:none; text-align:left;}
	#<?php echo $module['module_name'];?> [monxin-table]{ background:none; border:none;}    
	#<?php echo $module['module_name'];?> [monxin-table] .even{ background:none; border:none;}    
	#<?php echo $module['module_name'];?> [monxin-table] .odd{ background:none; border:none;}   
	#<?php echo $module['module_name'];?> [monxin-table] tbody .del{ display:none;}
	#<?php echo $module['module_name'];?> [monxin-table] tbody tr:hover .del{display:inline-block;}
	
	
	
	
	
	#<?php echo $module['module_name'];?>_html{ white-space:nowrap;}   
	#<?php echo $module['module_name'];?>_html .checkout_left{ display:inline-block; vertical-align:top; white-space:nowrap; width:30%; padding:1rem; overflow:hidden; } 
	#<?php echo $module['module_name'];?>_html .checkout_left .logo{ width:100%; display:block;}  
	#<?php echo $module['module_name'];?>_html .checkout_left .logo img{ width:100%; border:none;}  
	#<?php echo $module['module_name'];?>_html .checkout_left .fulfil_preferential{ line-height:25px; white-space:normal;}
	#<?php echo $module['module_name'];?>_html .checkout_left .input_div{}
	#<?php echo $module['module_name'];?>_html .checkout_left .input_div .barcode_state{ text-align:right; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .checkout_left .input_div .barcode{ line-height:60px; padding-left:5px; height:60px; font-size:1.8rem; width:96%; }
	#<?php echo $module['module_name'];?>_html .checkout_left .sum_info{ line-height:80px; font-size:26px; text-align:right; }
	#<?php echo $module['module_name'];?>_html .checkout_left .sum_info .goods_item{ font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .checkout_left .sum_info .goods_price{ font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .checkout_left .submit_now{ display:inline-block; vertical-align:top; vertical-align:top; width:150px; height:40px;   text-align:center; line-height:40px; margin-right:20px;}
	
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div{ line-height:40px;}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div input{ padding-left:5px;}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .line{}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .line .m_label{}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .line .value{}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .balance,.decrease,.number{  font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .user{ width:9.2rem; font-size:0.5rem;}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .preferential_code{ width:6rem;}
	
	#<?php echo $module['module_name'];?>_html .checkout_left .act_div{ white-space:nowrap; width:100%; margin-top:20px;}
	#<?php echo $module['module_name'];?>_html .checkout_left .act_div a:hover{ opacity:0.7;}
	#<?php echo $module['module_name'];?>_html .checkout_left .act_div .act_left{ display:inline-block; vertical-align:top; width:50%; text-align:left;  }

	#<?php echo $module['module_name'];?>_html .checkout_left .act_div .act_right{ display:inline-block; vertical-align:top; width:50%; text-align:left; }
	
	#<?php echo $module['module_name'];?>_html .checkout_left .act_div .temporary_storage{margin-left:10px; display:inline-block; vertical-align:top;   padding:10px;border-radius:3px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .checkout_left .act_div .temp_name{ width:6rem;}
	#<?php echo $module['module_name'];?>_html .checkout_left .act_div .submit{ }
	#<?php echo $module['module_name'];?>_html .checkout_left .act_div .temp_name,.submit{}
	#<?php echo $module['module_name'];?>_html .checkout_left .act_div .import{margin-right:10px;display:inline-block; vertical-align:top;   padding:10px; border-radius:3px; overflow:hidden;}
	
	.pay_method_sub_div{ display:inline-block; vertical-align:top;}
	.pay_method_sub_div div{ display:inline-block; vertical-align:top;display:none;}
	.balance_div img{ width:200px;}
	.credit_div img{ width:200px;}
	.transaction_password{ width:120px;}
	#<?php echo $module['module_name'];?>_html .received_money{ width:4rem; }
	#<?php echo $module['module_name'];?>_html .checkout_right{ display:inline-block; vertical-align:top; width:70%; height:600px; overflow:scroll; overflow-x:hidden; white-space:nowrap;}   
   
	#<?php echo $module['module_name'];?>_html .clear_all{  display:inline-block;   display:inline-block; height:30px; line-height:30px; }
	#<?php echo $module['module_name'];?>_html .clear_all:before{margin-right:3px; font: normal normal normal 1rem/1 FontAwesome; content:"\f014";}
	#<?php echo $module['module_name'];?>_html .clear_all:hover{ font-weight:bold;}   
	.checkout_desk{  font-size:30px; padding:5px; padding-left:0px; font-weight:bold; text-align:left;}
	.checkout_desk img{ height:40px; padding-right:5px; padding-left:5px; display:inline-block; vertical-align:top;}
	.checkout_desk span{ height:40px; display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .sales_promotion{   padding-left:3px;padding-right:3px; margin-left:3px; border-radius:7px;}
	#submit_checkout_state{ text-align:right; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .print_div{ position:fixed; right:0px; top:200px; width:300px; height:500px; display:none;}
    #<?php echo $module['module_name'];?>_html .cashier{ font-style:oblique; line-height:50px; border-bottom: 1px #999999 solid; margin-bottom:10px;}
    #<?php echo $module['module_name'];?>_html .cashier a{ }
    #<?php echo $module['module_name'];?>_html .cashier a:after{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f101";}
	#<?php echo $module['module_name'];?>_html .cashier a:hover{ opacity:0.8;}
	.hot_key{ cursor:pointer;}
	.hot_key div{display:none;}
	.price_td{ line-height:30px;}
	.price_td .my_shop_group_discount{ display:none;}
	.shop_group .my_shop_group_discount{ display:block;}
	.shop_group .price{ text-decoration:line-through;}
	#<?php echo $module['module_name'];?>_html .unit{ padding-left:3px;}
	.abandon{text-decoration: line-through; opacity:0.6;}
	#<?php echo $module['module_name'];?>_html .group{ 	}
	.decrease .fail{ font-weight:normal; font-size:0.7rem;}
	#<?php echo $module['module_name'];?>_html .g_discount{ }
	#<?php echo $module['module_name'];?>_html .shop_balance{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    	<div class=checkout_left>
        	<div class=checkout_desk><img src='./program/mall/shop_icon/<?php echo $module['shop_id']?>.png' /><span><?php echo $module['shop_name'];?>-<?php echo self::$language['checkout_desk'];?></span></div>
            <div class=input_div>
            	<input type="text" class=barcode placeholder="<?php echo self::$language['goods_name_or_barcode']?>" /> 
                <div class=barcode_state> </div>
            </div>
            <div class=sum_info><?php echo self::$language['sum'];?>:<span class=goods_item>0</span> <?php echo self::$language['item'];?><?php echo self::$language['goods'];?> <span class=goods_price>0</span> <?php echo self::$language['yuan']?></div>
            
            <div id=option_div>
                <div class=line id=user_info><span class=m_label><?php echo self::$language['member']?><?php echo self::$language['info']?>：</span><span class=value><input type="password" class=user placeholder="<?php echo self::$language['phone']?>/<?php echo self::$language['membership']?><?php echo self::$language['enter']?>"  /> <span class=user_state></span></span></div>
                
                <div class=line id=use_method_line><span class=m_label><?php echo self::$language['use_method'];?>：</span><span class="value"><select class=preferential_way><?php echo $module['preferential_way_option'];?></select><span class=preferential_code_span style="display:none;"><input type="text" class="preferential_code" placeholder="<?php echo self::$language['please_input'];?> <?php echo self::$language['enter'];?>" /></span> <span class="decrease"></span> </span></div>
               
                <div class=line id=amount_payable_line><span class=m_label><?php echo self::$language['amount_payable'];?>：</span><span class="value"><span class="number"></span><?php echo self::$language['yuan'];?></span></div>

				<div class=line id=submit_checkout_state></div>
                <div class=line id=pay_method_div>
                    <?php echo self::$language['pay_method_str'];?>：<select class=pay_method><?php echo $module['pay_method'];?></select>
                    <div class=pay_method_sub_div>
                        <div class=cash_div style="display:inline-block;"><?php echo self::$language['received_money'];?> <input type="text" class=received_money placeholder="<?php echo self::$language['enter']?>" /> <?php echo self::$language['return_money'];?> <span class=return_money></span></div>
                        
                        <div class=credit_div><input type="text" class=credit_remark placeholder="<?php echo self::$language['remark']?>" /><br /><input type="password" class=transaction_password placeholder="<?php echo self::$language['transaction_password']?>" /> <span class=state></span><br />
                       
                        <img class=qr_img /><p class=state></p></div>
                        
                        <div class=balance_div><input type="password" class=transaction_password placeholder="<?php echo self::$language['transaction_password']?>" /> <span class=state></span><br /><img class=qr_img /><p class=state></p></div>
                    </div>
                </div>
                    
            </div>
           
            <div class="act_div">
            	<div class=act_left>
                    <a href="#" class="import"><?php echo self::$language['import'];?></a> 
                    <div style="display:none;"><select class=import_select></select></div>
                </div><div class=act_right>
                	<a href=# class="temporary_storage"><?php echo self::$language['temporary_storage'];?></a> 
                    <div style="display:none;"><input type="text" class="temp_name" onkeyup="value=value.replace(/[^\d]/g,'') "  /><span class=state></span></div>
                </div>
        	
            </div>
            
            <div class=fulfil_preferential><?php echo $module['fulfil_preferential'];?></div>

            <div class="cashier"><?php echo self::$language['cashier'];?>：<?php echo $module['username']?> , <a href="./index.php?monxin=index.user"><?php echo self::$language['return']?></a></div>
            <div class=hot_key>
            <b><?php echo self::$language['shortcut_key']?></b>
            <div>
            <?php echo self::$language['checkout_and_print']?>：<?php echo self::$language['space_key']?>(Space)<br />
            <?php echo self::$language['barcode_focus']?>：Shift+q<br />
            <?php echo self::$language['user_focus']?>：Shift+a<br />
            <?php echo self::$language['received_money_focus']?>：Shift+z<br />
            <?php echo self::$language['empty_checkout']?>：Shift+x<br />
            </div>
            
            </div>
        </div><div class=checkout_right>
            
        
            <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <td style="padding-left:10px;" ><?php echo self::$language['goods']?></td>
                        <td ><?php echo self::$language['unit_price']?></td>
                        <td  style=" padding-left:55px;" ><?php echo self::$language['quantity']?></td>
                        <td ><?php echo self::$language['subtotal']?></td>
                        <td  style=" width:170px;text-align:left;"><?php echo self::$language['operation']?> <a href="#" class=clear_all><?php echo self::$language['clear_all'];?></a></td>
                    </tr>
                </thead>
                <tbody>
            <?php echo $module['checkout_desk'];?>
                </tbody>
            </table></div>
            <div class=batch_operation_div style="display:none;">
                        <div class=act_div>
                        <span class="corner"> </span>
                        <a href="#" class="select_all" onclick="return select_all();"><span class=b_start> </span><span class=b_middle><?php echo self::$language['select_all']?></span><span class=b_end> </span></a>
                        <a href="#" class="reverse_select" onclick="return reverse_select();"><span class=b_start> </span><span class=b_middle><?php echo self::$language['reverse_select']?></span><span class=b_end> </span></a>
                         <?php echo self::$language['selected']?>
                         <a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a><a href="#"  onclick="return move_to_favorites();" class=selected_move_to_favorites><span class=b_start> </span><span class=b_middle><?php echo self::$language['move_to_favorites']?></span><span class=b_end> </span></a>
                          <span id="state_select"></span>
                          </div>
                          
             </div>
       	</div>
    <div class=print_div><iframe width="100%" id="print_tag" name="print_tag" height="600px;"  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="./index.php?monxin=mall.checkout_print" >
</iframe></div>
    </div>
</div>