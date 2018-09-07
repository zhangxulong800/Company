<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
<OBJECT id="tcom_OB" classid="clsid:987F8440-C95B-46EC-8CE5-C653E47593D5" width=0 height=0>
<embed id="tcom_EM" type="application/x-comm-nptcomm" width=0 height=0 pluginspage="/files/TComm.exe"></embed>
</OBJECT>
<script>
	var a_index=0;
	var u_index=0;
	var tcom=null;
	var scale_unit=1;
	function getobj(){
		var obj = document.getElementById("tcom_OB");
		try{
			obj.Register("");
			return obj;
		}catch(e){
			try{
				obj=document.getElementById("tcom_EM");
				obj.Register("");
				return obj;
			}catch(ee){
				//alert(ee);
				//anzhuang
				if(confirm("<?php echo self::$language['not_serial_port']?>")){
					location="http://file.monxin.com/other/monxincom.exe";
				}
				return null;
			}
		}
	}
	
	$(function(){
		scale_unit=getCookie('scale_unit');
		if(getCookie('scale_open')==1){tcom = getobj();}	
	})
	function autoRead(){
		tcom.onDataIn=function(dat){ //接收串口返回数据
			//console.log(dat);
			timestamp = Date.parse(new Date());
			$("#<?php echo $module['module_name'];?> .scale_set").attr('last_time',timestamp);
				dat2=dat.split("\n");
				dat3=dat2[dat2.length-2];
				if(dat3==''){dat3=dat;}
				console.log(dat3);
			$("#<?php echo $module['module_name'];?> .scale_set").attr('last_weight',parseFloat(dat3.replace(/[^\d.]/g,''))/scale_unit*1000);
			$("#<?php echo $module['module_name'];?> .weight_show").html($("#<?php echo $module['module_name'];?> .scale_set").attr('last_weight')+'g');
			return true;
		}
	}
	function clickRead(){
		
		tcom.onDataIn=undefined;
	//setInterval(function(){
		$("#t_dataIn").val($("#t_dataIn").val()+tcom.getData());
		//alert(tcom.getData());
	//},300);
	}
	function closeCom(){
		tcom.CloseCom();
	}
	function send(){
		if(CUR_SJT!="HEX")
			tcom.SendData($("#t_sdata").val()+"\r");//往端口发送数据
		else
			tcom.SendData($("#t_sdata").val());//往端口发送数据
	}
	//选择并打开端口
	var CUR_SJT = "utf-8";
	function selcomport(){
	try{
		var comNo=getCookie('scale_com');
		var comSet = "9600,N,8,1";//波特率,校验位,数据位,停止位
		tcom.DataType='utf-8';	
		if(comNo>0 && tcom.InitCom(comNo,comSet)){ //打开串口&& tcom.InitCom(comNo,comSet)
				autoRead();
				$("#<?php echo $module['module_name'];?> #scale_set .scale_state").html('<?php echo self::$language['yes']?>');
			}else{
				alert('<?php echo self::$language['scale_connect_fail']?>');
				$("#<?php echo $module['module_name'];?> #scale_set .scale_state").html('<?php echo self::$language['no']?>');
			}
		
		}catch(e){
			alert('<?php echo self::$language['scale_connect_fail']?>');
			$("#<?php echo $module['module_name'];?> #scale_set .scale_state").html('<?php echo self::$language['no']?>');
			/*
			if(confirm("<?php echo self::$language['not_serial_port']?>")){
				//location="http://file.monxin.com/other/monxincom.exe";
			}
			*/
		}
	}
	
	function　open_scal(){
		if(getCookie('scale_open')!=1){return false;}
		selcomport();
		autoRead();
		//clickRead();
	}
	
	function update_scale_sate(){
		if(getCookie('scale_open')!=1){return false;}
		closeCom();
		selcomport();
		autoRead();
	}
	function update_scale_time(){
		try{tcom.SendData('new');}catch(exception){
			if($("#<?php echo $module['module_name'];?> #scale_set .scale_state").html()!='<?php echo self::$language['yes']?>'){
				window.clearInterval(update_scale_time_interval);
			}
		}
		if($("#<?php echo $module['module_name'];?> .scale_set").attr('last_time') && $("#<?php echo $module['module_name'];?> .scale_set").attr('last_weight') ){
			console.log($("#<?php echo $module['module_name'];?> .scale_set").attr('last_time')+','+$("#<?php echo $module['module_name'];?> .scale_set").attr('last_weight'));
				timestamp = Date.parse(new Date());
				timestamp=timestamp-$("#<?php echo $module['module_name'];?> .scale_set").attr('last_time');
				timestamp=timestamp/1000;
				$("#<?php echo $module['module_name'];?> .scale_last").html(timestamp+'秒前');
		}else{
			$("#<?php echo $module['module_name'];?> .scale_last").html('');
		}	
	}
	
</script>



	<script>
	
	var checkout_id=0;
	var qr_timer;
	var temp_save_list=new Array();
	var submit_lock=false;
	var update_scale_time_interval;
	var credits=0;
    $(document).ready(function(){
		update_scale_time_interval=window.setInterval('update_scale_time()',500);
		if(get_browser()!='firefox'){
			$('#checkout_browser').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#checkout_browser").css('margin-top',($(window).height()-$("#checkout_browser .modal-content").height())/9);		
		}
		window.setTimeout(open_scal,1000);
		
		
	$(document).on('click','#<?php echo $module['module_name'];?> .search_result_div a',function(){
		$("#<?php echo $module['module_name'];?> .search_result_div").html('');
		$("#<?php echo $module['module_name'];?> .barcode").val('');
		obj=$("#<?php echo $module['module_name'];?> .gs a[key='"+$(this).attr('href')+"']");
		add_checkout(obj.attr('goods_id'),obj.attr('id_type'),1);		
		
		return false;
	});	
		
		
	$("#<?php echo $module['module_name'];?> .barcode").keydown(function(event){
		v=$(this).val();
		var reg = /^[A-Za-z]*$/;
		//if (reg.test(v)){
			if(event.keyCode==13){
				if($("#<?php echo $module['module_name'];?> .search_result_div .current").attr('href')){
					obj=$("#<?php echo $module['module_name'];?> .gs a[key='"+$("#<?php echo $module['module_name'];?> .search_result_div .current").attr('href')+"']");
					add_checkout(obj.attr('goods_id'),obj.attr('id_type'),1);		
		
					$("#<?php echo $module['module_name'];?> .search_result_div").html('');
					$("#<?php echo $module['module_name'];?> .barcode").val('');
					
				}else{
					
					if($("#<?php echo $module['module_name'];?> .search_result_div a:first").attr('href')){
						obj=$("#<?php echo $module['module_name'];?> .gs a[key='"+$("#<?php echo $module['module_name'];?> .search_result_div a:first").attr('href')+"']+']");
						add_checkout(obj.attr('goods_id'),obj.attr('id_type'),1);	
						$("#<?php echo $module['module_name'];?> .search_result_div").html('');
						$("#<?php echo $module['module_name'];?> .barcode").val('');
						
					}
					
				}
				
			}
			if(event.keyCode==38){
				$("#<?php echo $module['module_name'];?> .search_result_div a").removeClass('current');
				if(a_index<0){a_index=$("#<?php echo $module['module_name'];?> .search_result_div a").length-1;}
				if($("#<?php echo $module['module_name'];?> .search_result_div a").length<a_index+1){
					a_index=0;
				}
				$("#<?php echo $module['module_name'];?> .search_result_div a").eq(a_index).addClass('current');
				a_index--;
			}
			if(event.keyCode==40){
				$("#<?php echo $module['module_name'];?> .search_result_div a").removeClass('current');
				if(a_index<1){a_index=0;}
				if($("#<?php echo $module['module_name'];?> .search_result_div a").length<a_index+1){
					a_index=0;
				}
				$("#<?php echo $module['module_name'];?> .search_result_div a").eq(a_index).addClass('current');
				a_index++;
			}
		//}
		
	});
	
	$("#<?php echo $module['module_name'];?> .barcode").keyup(function(event){
		if(event.keyCode==38 || event.keyCode==40){return false;}
		key=$(this).val();
		str='';
		if(key==''){
			
		}else{
			$("#<?php echo $module['module_name'];?> .gs a[py]").each(function(index, element) {
				if($(this).parent().attr('id')=='g_module_quick'){return true;}
				if($(this).attr('py').toLowerCase().indexOf(key.toLowerCase())!=-1 || $(this).html().indexOf(key.toLowerCase())!=-1){
					str+='<a href='+$(this).attr('key')+'>'+$(this).html()+'</a>';
				}
			});
		}
		$("#<?php echo $module['module_name'];?> .search_result_div").html(str);
	});
	
		
		$("#<?php echo $module['module_name'];?> .search_result_div").css('top',$("#<?php echo $module['module_name'];?> .barcode").offset().top+50).css('left',$("#<?php echo $module['module_name'];?> .barcode").offset().left);

		
		$("#<?php echo $module['module_name'];?> .switch_address_div").click(function(){
			$('#address_div').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#address_div").css('margin-top',($(window).height()-$("#address_div .modal-content").height())/9);		
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .use_credit").keyup(function(){
			v=$(this).val();
			if(!$.isNumeric(v) || v=='' || v<0){
				$(this).val('');	
				$("#<?php echo $module['module_name'];?> .use_credit_div .credit_money").html('');	
				credits=0;
			}else{
				max_v=parseFloat($("#<?php echo $module['module_name'];?> .credits_div .use b").html());
				rate=parseFloat($("#<?php echo $module['module_name'];?> .credits_div .use b").attr('rate'));
				v=parseFloat($(this).val());
				if(v>max_v){$(this).val(max_v);v=max_v;}
				credit_money=v*rate;
				credits=credit_money.toFixed(2);
				if(credits-parseFloat($("#amount_payable_line .number").html())>0){
					v=parseFloat($(".sum_info .goods_price").html())/rate;
					$(this).val(v);
					credits=$(".sum_info .goods_price").html();
				}
				$("#<?php echo $module['module_name'];?> .use_credit_div .credit_money").html('-'+credits);	
						
			}
			credits_update_payable();
		});
		
		$("#<?php echo $module['module_name'];?> .shop_credit a").click(function(){
			$("#<?php echo $module['module_name'];?> .credits_div .use").removeClass('use');
			if($("#<?php echo $module['module_name'];?> .use_credit_div").css('display')=='none' || $("#<?php echo $module['module_name'];?> .use_credit_div").css('text-align')=='right'){
				$(this).parent().addClass('use');
				$("#<?php echo $module['module_name'];?> .use_credit_div").css('display','block').css('text-align','left');
			}else{
				$("#<?php echo $module['module_name'];?> .use_credit_div").css('display','none');
			}
			$("#<?php echo $module['module_name'];?> .use_credit").val('');
			$("#<?php echo $module['module_name'];?> .use_credit_div .credit_money").html('');
			credits=0;
			credits_update_payable();
			return false;
		});
		$("#<?php echo $module['module_name'];?> .web_credit a").click(function(){
			$("#<?php echo $module['module_name'];?> .credits_div .use").removeClass('use');
			if($("#<?php echo $module['module_name'];?> .use_credit_div").css('display')=='none' || $("#<?php echo $module['module_name'];?> .use_credit_div").css('text-align')=='left'){
				$(this).parent().addClass('use');
				$("#<?php echo $module['module_name'];?> .use_credit_div").css('display','block').css('text-align','right');
			}else{
				$("#<?php echo $module['module_name'];?> .use_credit_div").css('display','none');
			}
			$("#<?php echo $module['module_name'];?> .use_credit").val('');
			$("#<?php echo $module['module_name'];?> .use_credit_div .credit_money").html('');
			credits=0;
			credits_update_payable();
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .scale_set").click(function(){
			$('#scale_set').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#scale_set").css('margin-top',($(window).height()-$("#scale_set .modal-content").height())/9);		
			return false;			
		});
		
		$("#<?php echo $module['module_name'];?> #scale_set .line select").each(function(index, element) {
            v=getCookie($(this).attr('class'));
			$(this).val(v);
        });
		
		$("#<?php echo $module['module_name'];?> #scale_set .line select").change(function(){
			setCookie($(this).attr('class'),$(this).val(),365);
		});
		
		$("#<?php echo $module['module_name'];?> #scale_set .scale_com").change(function(){
			update_scale_sate();
		});
		$("#<?php echo $module['module_name'];?> #scale_set .scale_open").change(function(){
			update_scale_sate();
		});
		
		if(getCookie('scale_auto_input')==1){
			$(document).on('focus',"#<?php echo $module['module_name'];?> .quantity_div .quantity",function(){
				weight_input_quantity($(this));
			});
		}
		
		$(document).on('keydown',"#<?php echo $module['module_name'];?> .quantity_div .quantity",function(event){
			if(event.keyCode==13){weight_input_quantity($(this));}
		});
		$(document).on('keyup',"#<?php echo $module['module_name'];?> .quantity_div .quantity",function(event){
			if(event.shiftKey && event.keyCode==32){
				update_fulfil();
				submit_checkout();
				return false;
			}
		});
		$("#<?php echo $module['module_name'];?> .quick_goods_list a").click(function(){
			if($("#<?php echo $module['module_name'];?> #tr_"+$(this).attr('key')).html()){
				if($("#<?php echo $module['module_name'];?> #tr_"+$(this).attr('key')+" .quantity").attr('kg_rate')!=0){
					$("#<?php echo $module['module_name'];?> #tr_"+$(this).attr('key')+" .quantity").val('');
					$("#<?php echo $module['module_name'];?> #tr_"+$(this).attr('key')+" .quantity").focus();
					return fals
				}
				$("#<?php echo $module['module_name'];?> #tr_"+$(this).attr('key')+" .quantity").val(parseFloat($("#<?php echo $module['module_name'];?> #tr_"+$(this).attr('key')+" .quantity").val())+1);
				format_quantity($("#<?php echo $module['module_name'];?> #tr_"+$(this).attr('key')).attr('id'));
				update_checkout_goods_sum();
				$("#<?php echo $module['module_name'];?> #tr_"+$(this).attr('key')+" .quantity").focus();
				$("#<?php echo $module['module_name'];?> #tr_"+$(this).attr('key')+" .quantity").select();
			}else{
				add_checkout($(this).attr('goods_id'),$(this).attr('id_type'),1);
			}
			$("#<?php echo $module['module_name'];?> #tr_"+$(this).attr('key')+" .quantity").focus();
			$("#<?php echo $module['module_name'];?> #tr_"+$(this).attr('key')+" .quantity").select();
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .quick_goods_switch").hover(function(){
			$("#<?php echo $module['module_name'];?> .quick_goods_div").css('display','block');
		});
		$("#<?php echo $module['module_name'];?> .quick_goods_switch").click(function(){
			if($("#<?php echo $module['module_name'];?> .quick_goods_div").css('display')=='block'){
				$("#<?php echo $module['module_name'];?> .quick_goods_div").css('display','none');
			}else{
				$("#<?php echo $module['module_name'];?> .quick_goods_div").css('display','block');
			}
			
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .quick_goods_div").mouseleave(function(){
			$("#<?php echo $module['module_name'];?> .quick_goods_div").css('display','none');
		});
		if(getCookie('checkout_print_set')){
			$("#<?php echo $module['module_name'];?> .print_set").val(getCookie('checkout_print_set'));
		}else{
			setCookie('checkout_print_set',1,365);
			$("#<?php echo $module['module_name'];?> .print_set").val(1);
		}
		
		$("#<?php echo $module['module_name'];?> .print_set").change(function(){
			setCookie('checkout_print_set',$(this).val(),365);
		});
		
		$("#<?php echo $module['module_name'];?> .preferential_code").blur(function(){
			if($("#<?php echo $module['module_name'];?> .preferential_way").val()==8){
				update_fulfil();
			}
			
		});	
		
		$("#<?php echo $module['module_name'];?> .add_goods").click(function(){
			set_iframe_position($(window).width()*0.9,$(window).height()*0.9);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			$("#<?php echo $module['module_name'];?> .barcode").val('');
			return false;	
		});
		
		 $('.unlogin').click(function(){
			$.get($(this).attr('href'),function(data){unlogin(data);});
			return false;
		 });
		//$("#<?php echo $module['module_name'];?>_html .thead").css('width',$("#<?php echo $module['module_name'];?> .table_scroll").width());
		$("#<?php echo $module['module_name'];?> #hot_key_switch").click(function(){
			if($(this).parent().parent().css('left')=='0px'){
				$(this).addClass('hot_key_hide');
				$(this).parent().parent().css('left','-100%');
			}else{
				$(this).removeClass('hot_key_hide');
				$(this).parent().parent().css('left','0px');
			}
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?>").height($(window).height());
		$("#<?php echo $module['module_name'];?> .hot_key").click(function(){
			return false;
			if($(this).children('div').css('display')=='none'){
				$(this).children('div').css('display','block');
			}else{
				$(this).children('div').css('display','none');
			}
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .hot_key .space_key").click(function(){
			submit_checkout();
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .hot_key .shift_q").click(function(){
			$("#<?php echo $module['module_name'];?> .barcode").focus();
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .hot_key .shift_a").click(function(){
			$("#<?php echo $module['module_name'];?> .user").focus();
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .hot_key .shift_z").click(function(){
			$("#<?php echo $module['module_name'];?> .received_money").focus();
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .hot_key .shift_x").click(function(){
			reset_desk();
			$("#<?php echo $module['module_name'];?> .barcode").focus();
			return false;	
		});
		$(window).keydown(function(event){
			if(event.keyCode==27){
				$("#fade_div").css('display','none');
				$("#set_monxin_iframe_div").css('display','none');
				$("#<?php echo $module['module_name'];?> .barcode").focus();
			}
			if(event.shiftKey && event.keyCode==32 && $(event.target).attr('class')=='preferential_code'){
				update_fulfil();
				submit_checkout();
				return false;
			}
			
			if(event.shiftKey && event.keyCode==32 && $(event.target).attr('class')!=='received_money' && $(event.target).attr('class')!=='address'){
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
			$("#<?php echo $module['module_name'];?> .barcode").focus();
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
				
				
				$(this).parent().next().html('');
				$(this).parent().next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=submit',{barcode:$(this).val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#<?php echo $module['module_name'];?> .barcode").parent().next().html(v.info);
					if(v.state=='success'){
						if(v.html){
							$("#<?php echo $module['module_name'];?> .barcode").val('');
							$("#<?php echo $module['module_name'];?> #tr_"+v.key).remove();
							if($("#<?php echo $module['module_name'];?> [monxin-table] tbody tr").length>0){
								$(v.html).insertBefore("#<?php echo $module['module_name'];?> [monxin-table] tbody tr:first");
							}else{
								$("#<?php echo $module['module_name'];?> [monxin-table] tbody").html(v.html);	
							}
							weight_input_quantity($("#<?php echo $module['module_name'];?> #tr_"+v.key+" .quantity"));
							update_checkout_goods_sum();
							$("#<?php echo $module['module_name'];?> .barcode").focus();
						}
						if(v.act){
							
							set_iframe_position($(window).width()*0.9,$(window).height()*0.9);
							//monxin_alert(replace_file);
							$("#monxin_iframe").attr('scrolling','auto');
							$("#fade_div").css('display','block');
							$("#set_monxin_iframe_div").css('display','block');
							$("#monxin_iframe").attr('src','./index.php?monxin=mall.checkout_search&search='+$("#<?php echo $module['module_name'];?> .barcode").val());
							$("#<?php echo $module['module_name'];?> .barcode").val('');
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
					
					$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html(parseFloat($("#<?php echo $module['module_name'];?> .sum_info .goods_price").html())-credits);
					$(".price_td .normal").removeClass('abandon');
					update_shop_group_discount();
						
			}
			
		});
		
		
		
		$("#<?php echo $module['module_name'];?> .pay_method").change(function(){
			if(parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html())<=0){$("#<?php echo $module['module_name'];?> .pay_method").val('cash');return false;}
			if($(this).val()=='alipay' || $(this).val()=='weixin'){
				$("#<?php echo $module['module_name'];?> .pay_method_sub_div .balance_div").css('display','none');
				set_iframe_position($(window).width()*0.9,$(window).height()*0.9);
				//monxin_alert(replace_file);
				$("#monxin_iframe").attr('scrolling','auto');
				$("#fade_div").css('display','block');
				$("#set_monxin_iframe_div").css('display','block');
				$("#monxin_iframe").attr('src','./index.php?monxin=mall.checkout_search&act=scanpay&id='+$("#<?php echo $module['module_name'];?> .pay_method option[value='"+$(this).val()+"']").attr('account_id')+'&user='+$("#<?php echo $module['module_name'];?> .user").val()+'&money='+$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html());
				return false;
			}
			
			$("#<?php echo $module['module_name'];?> .pay_method_sub_div div").css('display','none');	
			$("#<?php echo $module['module_name'];?> .pay_method_sub_div ."+$(this).val()+"_div").css('display','inline-block');
			if($(this).val()=='meituan' || $(this).val()=='nuomi' || $(this).val()=='other'){
				$(".pos_div").css('display','block');
			}
			
			if($(this).val()=='shop_balance'){$("#<?php echo $module['module_name'];?> .pay_method_sub_div .balance_div").css('display','inline-block');}
			if(($(this).val()=='shop_balance' || $(this).val()=='balance')){
				if($(this).val()=='balance'){
					if(<?php echo $module['web_c_password']?>==0){
						$("#<?php echo $module['module_name'];?> .pay_method_sub_div .balance_div").css('display','inline-block');
					}else{
						$("#<?php echo $module['module_name'];?> .pay_method_sub_div .balance_div").css('display','none');
					}
					remaining=parseFloat($("#amount_payable_line .number").html())-parseFloat($(".user_state .balance").html());
					if(remaining>0){
						str='<?php echo self::$language['web_balance_insufficient']?>';
						alert(str.replace('{remaining}',remaining.toFixed(2)));
					}
				}else{
					if(<?php echo $module['shop_c_password']?>==0){
						$("#<?php echo $module['module_name'];?> .pay_method_sub_div .balance_div").css('display','inline-block');
					}else{
						$("#<?php echo $module['module_name'];?> .pay_method_sub_div .balance_div").css('display','none');
					}
					remaining=parseFloat($("#amount_payable_line .number").html())-parseFloat($(".user_state .shop_balance").html());
					if(remaining>0){
						str='<?php echo self::$language['shop_balance_insufficient']?>';
						alert(str.replace('{remaining}',remaining.toFixed(2)));
					}
					
				}
				
				
			}
			
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
		
		$("#<?php echo $module['module_name'];?> .user").next('a').click(function(){
			var e = jQuery.Event( "keyup", { keyCode: 13} );
			$("#<?php echo $module['module_name'];?> .user").trigger(e);//模拟按下回车			
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .temp_name").next('a').click(function(){
			var e = jQuery.Event( "keyup", { keyCode: 13} );
			$("#<?php echo $module['module_name'];?> .temp_name").trigger(e);//模拟按下回车			
			return false;	
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?> #address_div .receiver input",function(){
			$("#<?php echo $module['module_name'];?> #address_div .address").html($(this).next('span').html());
		});
		
		$("#<?php echo $module['module_name'];?> .user_search_result_div a").click(function(){
			$("#<?php echo $module['module_name'];?> .user").val($(this).attr('user_n'));
		});
		
		
		$("#<?php echo $module['module_name'];?> .user").keydown(function(event){
			v=$(this).val();
			if(event.keyCode==13){
				if($("#<?php echo $module['module_name'];?> .user_search_result_div .current").attr('user_n')){
					$("#<?php echo $module['module_name'];?> .user").val($("#<?php echo $module['module_name'];?> .user_search_result_div .current").attr('user_n'));
					//$("#<?php echo $module['module_name'];?> .user").trigger('keyup');
					$("#<?php echo $module['module_name'];?> .user_search_result_div a").attr('m_show',0);
					$("#<?php echo $module['module_name'];?> .user_search_result_div a").removeClass('current');
					
				}				
			}
			if(event.keyCode==38){
				$("#<?php echo $module['module_name'];?> .user_search_result_div a").removeClass('current');
				if(u_index<0){u_index=$("#<?php echo $module['module_name'];?> .user_search_result_div [m_show='1']").length-1;}
				if($("#<?php echo $module['module_name'];?> .user_search_result_div [m_show='1']").length<u_index+1){
					u_index=0;
				}
				$("#<?php echo $module['module_name'];?> .user_search_result_div [m_show='1']").eq(u_index).addClass('current');
				u_index--;
			}
			if(event.keyCode==40){
				$("#<?php echo $module['module_name'];?> .user_search_result_div a").removeClass('current');
				if(u_index<1){u_index=0;}
				if($("#<?php echo $module['module_name'];?> .user_search_result_div [m_show='1']").length<u_index+1){
					u_index=0;
				}
				$("#<?php echo $module['module_name'];?> .user_search_result_div [m_show='1']").eq(u_index).addClass('current');
				u_index++;
			}
			
		});
		
			
		
		
		$("#<?php echo $module['module_name'];?> .user").keyup(function(event){
			//==============================================================================本地查询
			if(event.keyCode==38 || event.keyCode==40){return false;}
			key=$(this).val();
			if(key==''){
				$("#<?php echo $module['module_name'];?> .user_search_result_div a").attr('m_show',0);
			}else{
				$("#<?php echo $module['module_name'];?> .user_search_result_div").css('left',$(this).offset().left);
				$("#<?php echo $module['module_name'];?> .user_search_result_div a").attr('m_show',0);
				$("#<?php echo $module['module_name'];?> .user_search_result_div a").each(function(index, element) {
					if($(this).attr('upy').toLowerCase().indexOf(key.toLowerCase())!=-1 || $(this).html().indexOf(key.toLowerCase())!=-1){
						$(this).attr('m_show',1);
					}
				});
			}
			$("#<?php echo $module['module_name'];?> .user_search_result_div").css('left',$(this).offset().left);
		
			
			//
			//===============================================================================到服务器查询
			
            if(event.keyCode==13 && $(this).val()!=''){
				$("#<?php echo $module['module_name'];?> .user_search_result_div a").attr('m_show',0);
				$(this).parent().next().html('');
				$(this).parent().next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=check_user',{username:$(this).val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#<?php echo $module['module_name'];?> .user").parent().next().html(v.info);
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #address_div .address").html(v.checkout_address);
						$("#<?php echo $module['module_name'];?> #address_div .receiver").html(v.address);
						if(v.checkout_address==''){
							//$("#<?php echo $module['module_name'];?> #address_div .address").html($("#<?php echo $module['module_name'];?> #address_div .receiver div:first-child span").html());	
						}
						
						$("#<?php echo $module['module_name'];?> .shop_credit b").html(v.shop_credits);
						$("#<?php echo $module['module_name'];?> .web_credit b").html(v.web_credits);
						$("#<?php echo $module['module_name'];?> .credits_div").css('display','block');						
						$("#<?php echo $module['module_name'];?> .user").parent().next().attr('g_id',v.group_id);
						$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method_2'];?>');
						$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method_full'];?>');
						
						/*
						if(parseFloat($("#<?php echo $module['module_name'];?> .balance").html())>=parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html())){
							$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method_full_no_shop'];?>');	
						}
						if(parseFloat($("#<?php echo $module['module_name'];?> .shop_balance").html())>=parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html())){
							$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method_full_no_web'];?>');	
						}
						if(parseFloat($("#<?php echo $module['module_name'];?> .balance").html())>=parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html()) && parseFloat($("#<?php echo $module['module_name'];?> .shop_balance").html())>=parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html())){
							$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method_full'];?>');	
						}
						*/
						$("#<?php echo $module['module_name'];?> .received_money").focus();
						//alert(v.group_name);
						if(v.group_name!=''){
							$("#<?php echo $module['module_name'];?> .preferential_way").html('<?php echo $module['preferential_way_option_2'];?>');
							$("#<?php echo $module['module_name'];?> .preferential_way option[value=5]").html(v.group_name);
							$("#<?php echo $module['module_name'];?> .preferential_way option[value=5]").attr('discount',v.group_discount);
							
							if(v.group_discount<11){
								$("#<?php echo $module['module_name'];?> .preferential_way").val(5);
								$(".price_td .normal").addClass('abandon');
								$(".preferential_code_span").css('display','none');
								update_shop_group_discount();
								$("#<?php echo $module['module_name'];?> .received_money").focus();
							}
							
						}else{
							$("#<?php echo $module['module_name'];?> .preferential_way").html('<?php echo $module['preferential_way_option'];?>');
							update_fulfil();
							$(".price_td .normal").removeClass('abandon');
							
						}
						$("#<?php echo $module['module_name'];?> .pay_method").prop('value','');
					}else{
						$("#<?php echo $module['module_name'];?> #address_div .address").html('');
						$("#<?php echo $module['module_name'];?> #address_div .receiver").html('');
						$("#<?php echo $module['module_name'];?> .shop_credit b").html();
						$("#<?php echo $module['module_name'];?> .web_credit b").html();
						$("#<?php echo $module['module_name'];?> .credits_div").css('display','none');						
						$("#<?php echo $module['module_name'];?> .preferential_way").html('<?php echo $module['preferential_way_option'];?>');
						$("#<?php echo $module['module_name'];?> .pay_method").html('<?php echo $module['pay_method'];?>');
						$("#<?php echo $module['module_name'];?> .user").val('');
					}
					
					
								$("#<?php echo $module['module_name'];?> .preferential_way").val(5);
								$(".price_td .normal").addClass('abandon');
								$(".preferential_code_span").css('display','none');
								update_shop_group_discount();
								$("#<?php echo $module['module_name'];?> .received_money").focus();
					
					
				});
				
				if($(".preferential_code_span").css('display')=='none'){
					$("#<?php echo $module['module_name'];?> .preferential_way").html(5);
					$(".price_td .normal").addClass('abandon');
					$(".preferential_code_span").css('display','none');
					update_shop_group_discount();
					$("#<?php echo $module['module_name'];?> .received_money").focus();
				}
				
				//update_checkout_goods_sum();
				
				return false;	
			}
        });
		
		$("#<?php echo $module['module_name'];?> .received_money").keydown(function(event){
			if(event.keyCode==32){return false;}	
		});
		
		$("#<?php echo $module['module_name'];?> .received_money").keyup(function(event){
            if((event.keyCode==13 || event.keyCode==32) && $(this).val()!=''){
				$(this).val($(this).val().replace(/\s/,''));
				if(!$.isNumeric($(this).val())){
					submit_checkout();
					//alert('<?php echo  self::$language['must_be']?><?php echo self::$language['number_2'];?>');
					//$("#<?php echo $module['module_name'];?> .return_money").html('');
					return false;	
				}
				
				if(parseFloat($("#<?php echo $module['module_name'];?> .received_money").val())<parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html())){
					alert('<?php echo  self::$language['must_be_greater_than']?>'+$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html());
					$("#<?php echo $module['module_name'];?> .return_money").html('');
					return false;	
				}
				temp=parseFloat($("#<?php echo $module['module_name'];?> .received_money").val())-parseFloat($("#<?php echo $module['module_name'];?> #amount_payable_line .number").html());
				temp=temp.toFixed(1);
				//alert(temp);
				$("#<?php echo $module['module_name'];?> .return_money").html(temp);
				submit_checkout();
			}
        });
	
		
		$("#<?php echo $module['module_name'];?> .reference_number").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){
				submit_checkout();
			}
        });
	
		$("#<?php echo $module['module_name'];?> .transaction_password").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){
				if($(this).val().length<6){alert('<?php echo self::$language['less_six'];?>');return false;}
					
				if($(".pay_method").val()=='shop_balance' || $(".pay_method").val()=='balance'){
					if($(".pay_method").val()=='balance'){
						remaining=parseFloat($("#amount_payable_line .number").html())-parseFloat($(".user_state .balance").html());
						
						if(remaining>0){
							str='<?php echo self::$language['web_balance_insufficient']?>';
							alert(str.replace('{remaining}',remaining.toFixed(2)));
						}
					}else{
						remaining=parseFloat($("#amount_payable_line .number").html())-parseFloat($(".user_state .shop_balance").html());
						if(remaining>0){
							str='<?php echo self::$language['shop_balance_insufficient']?>';
							alert(str.replace('{remaining}',remaining.toFixed(2)));
						}
					}
				}
					
				
				$(this).next().html('');
				$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=check_password',{password:$(this).val(),username:$("#<?php echo $module['module_name'];?> .user").val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#<?php echo $module['module_name'];?> .transaction_password").next().html(v.info);
					if(v.state=='success'){
						submit_checkout();
					}else{
						if(v.qr_pay){
							monxin_alert(v.info);
						}
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
	
	function credits_update_payable(){
		goods_price=parseFloat($("#<?php echo $module['module_name'];?> .sum_info .goods_price").html());
		decrease=parseFloat($("#<?php echo $module['module_name'];?> #use_method_line .decrease").html());
		//alert(goods_price+'+'+decrease+'-'+credits);
		v=goods_price+decrease-credits;
		v=v.toFixed(2);
		if(v>=0){
			$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html(v);
		}
	}
	
	function scanpay_submit_checkout(id){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		$("#<?php echo $module['module_name'];?> .pay_method").attr('scanpay_id',id);
		submit_checkout();
	}
	
	function submit_checkout(){
		if(submit_lock){return false;}
		
		window.clearInterval(qr_timer);
		if($("#<?php echo $module['module_name'];?> #submit_checkout_state").html()=='<span class=\'fa fa-spinner fa-spin\'><?php echo self::$language['submitting'];?></span>'){return false;}
		if(parseFloat($("#<?php echo $module['module_name'];?> .sum_info .goods_price").html())<=0){alert('<?php echo self::$language['goods'];?><?php echo self::$language['is_null'];?>');return false;}
		//alert($("#<?php echo $module['module_name'];?> .preferential_way").val()	);
		if($("#<?php echo $module['module_name'];?> .preferential_way").val()==null){alert('<?php echo self::$language['please_select']?><?php echo self::$language['preferential']?>');return false;}
		pay_method=$("#<?php echo $module['module_name'];?> .pay_method").val();
		if(pay_method==null){
			$("#<?php echo $module['module_name'];?> .checkout_act_div").css('display','inline-block');
			alert('<?php echo self::$language['please_select']?><?php echo self::$language['pay_method_str']?>');return false;
		}
		obj=new Object();
		obj.checkout_id=checkout_id;
		obj.pay_method=pay_method;
		obj.preferential_way=$("#<?php echo $module['module_name'];?> .preferential_way").val();
		obj.preferential_code=$("#<?php echo $module['module_name'];?> .preferential_code").val();
		obj.user=$("#<?php echo $module['module_name'];?> .user").val();
		obj.goods_money=$("#<?php echo $module['module_name'];?> .goods_price").html();
		obj.payable=$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html();
		obj.credits_money=credits;
		obj.credits_use=$("#<?php echo $module['module_name'];?> .use_credit").val();
		obj.credits_type='';
		if($("#<?php echo $module['module_name'];?> .credits_div .use").attr('class')){
			obj.credits_type=$("#<?php echo $module['module_name'];?> .credits_div .use").attr('class').replace(/ use/,'');
		}
		
		
		if(pay_method=='cash'){
			obj.received_money=$("#<?php echo $module['module_name'];?> .received_money").val();
		}
		obj.reference_number=$("#<?php echo $module['module_name'];?> .reference_number").val();
		if(pay_method=='pos'){
			obj.reference_number=$.trim(obj.reference_number);
			if(obj.reference_number==''){alert('<?php echo self::$language['please_input']?><?php echo self::$language['reference_number']?>');$("#<?php echo $module['module_name'];?> .reference_number").focus();return false;}
			
		}
		if(pay_method=='credit'){
			
			//if($("#<?php echo $module['module_name'];?> .credit_div .credit_remark").val()==''){alert('<?php echo self::$language['please_input'];?><?php echo self::$language['pay_method']['credit'];?><?php echo self::$language['remark'];?>');$("#<?php echo $module['module_name'];?> .credit_div .credit_remark").focus();return false;}
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
		obj.stocking=$("#<?php echo $module['module_name'];?> .stocking").val();
		submit_lock=true;
		$("#<?php echo $module['module_name'];?> #submit_checkout_state").html('');
		$("#<?php echo $module['module_name'];?> #submit_checkout_state").html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['submitting'];?>');
		obj.address=$("#<?php echo $module['module_name'];?> #address_div .address").val();
		$.post('<?php echo $module['action_url'];?>&act=submit_checkout',obj, function(data){
			submit_lock=false;
			window.clearInterval(qr_timer);
			console.log(data);
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#<?php echo $module['module_name'];?> #submit_checkout_state").html(v.info);
			if(v.state=='success'){
				window.clearInterval(qr_timer);
				alert('<?php echo self::$language['return_money'];?>:'+$("#<?php echo $module['module_name'];?> .return_money").html()+'<?php echo self::$language['yuan'];?>');
				if(v.html!=''){window.print_tag.set_and_print(v.html);}
				
				$("#<?php echo $module['module_name'];?> .barcode").focus();
				$("#<?php echo $module['module_name'];?> .transaction_password").val('');
				$("#<?php echo $module['module_name'];?> .user").val('');
				
				window.setTimeout(reset_desk,10); 
			}else{
				if(v.qr_pay){
					monxin_alert(v.info);
				}
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
	
	function add_checkout(id,id_type,quantity){
		//alert(id+','+id_type+','+quantity);
		$("#<?php echo $module['module_name'];?> .barcode").parent().next().html('');
		$("#<?php echo $module['module_name'];?> .barcode").parent().next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('<?php echo $module['action_url'];?>&act=click',{id:id,id_type:id_type,quantity:quantity}, function(data){
			console.log(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#<?php echo $module['module_name'];?> .barcode").parent().next().html(v.info);
			if(v.state=='success'){
				if(v.html){
					$("#<?php echo $module['module_name'];?> #tr_"+v.key).remove();
					if($("#<?php echo $module['module_name'];?> [monxin-table] tbody tr").length>0){
						$(v.html).insertBefore("#<?php echo $module['module_name'];?> [monxin-table] tbody tr:first");
					}else{
						$("#<?php echo $module['module_name'];?> [monxin-table] tbody").html(v.html);	
					}
					$("#<?php echo $module['module_name'];?> #tr_"+v.key+" .quantity").focus();
					$("#<?php echo $module['module_name'];?> #tr_"+v.key+" .quantity").select();
					
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
		$("#<?php echo $module['module_name'];?> .subtotal").html('0');
		$("#<?php echo $module['module_name'];?> #use_method_line .decrease").html('0');
		$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html('0');
		$(".preferential_way").val(2);
		$(".pay_method").val('cash');
		$(".sum_info .goods_price").html('0');
		$("#amount_payable_line .number").html('0');
		credits=0;
		$("#<?php echo $module['module_name'];?> .credits_div b").html('');
		$("#<?php echo $module['module_name'];?> .credits_div").css('display','none');
		$("#<?php echo $module['module_name'];?> .credits_div .use_credit_div").css('display','none');
		$("#<?php echo $module['module_name'];?> .credits_div .use").removeClass('use');
		$("#<?php echo $module['module_name'];?> .credits_div .use_credit_div .use_credit").val('');
		$("#<?php echo $module['module_name'];?> .credits_div .use_credit_div .credit_money").html('');
		$("#<?php echo $module['module_name'];?> .stocking").prop('value',6);
		$("#<?php echo $module['module_name'];?> .balance_div").css('display','none');
		
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
					if($("#<?php echo $module['module_name'];?> #tr_"+v).html()){
						checkout_goods_money+=parseFloat(checkout_desk[v]['price'])*parseFloat(checkout_desk[v]['quantity']);
					}
					
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
				$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html(sum_money-credits);
			}else{
				temp=parseFloat($("#<?php echo $module['module_name'];?> .decrease").html()).toFixed(2);
				$("#<?php echo $module['module_name'];?> .decrease").html(temp);
				$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html((sum_money+parseFloat(temp)).toFixed(2)-credits);
			}
			
		}else if($("#<?php echo $module['module_name'];?> .preferential_way").val()==5){
				
			if($("#<?php echo $module['module_name'];?> #user_info .user_state .balance").html()==null){
				alert('<?php echo self::$language['member']?><?php echo self::$language['info']?><?php echo self::$language['err']?>');
				$("#<?php echo $module['module_name'];?> .preferential_way").val(2);
				return false;
			}
			$(".price_td .normal").addClass('abandon');
		
			update_shop_group_discount();
		
		}else if($("#<?php echo $module['module_name'];?> .preferential_way").val()==8){
			$("#<?php echo $module['module_name'];?> .decrease").html($("#<?php echo $module['module_name'];?> .preferential_code").val()-$("#<?php echo $module['module_name'];?> .goods_price").html());
			
			temp=parseFloat($("#<?php echo $module['module_name'];?> .decrease").html()).toFixed(2);
			$("#<?php echo $module['module_name'];?> .decrease").html(temp);
			$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html((sum_money+parseFloat(temp)).toFixed(2));
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
					$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html((sum_money+parseFloat(temp)).toFixed(2)-credits);
				}
			});
		
			
		}
		
	}
	
	function update_shop_group_discount(){
		$("#<?php echo $module['module_name'];?> #submit_checkout_state").html('');
		//return false;
		g_id=$("#<?php echo $module['module_name'];?> #user_info .user_state").attr('g_id');
		shop_group_discount_sum=0;
		goods_price=0;
		if($("#<?php echo $module['module_name'];?> .preferential_way").val()==5){
			
			$("#<?php echo $module['module_name'];?> tbody tr").each(function(index, element) {
				id=$(this).attr('id');
				if($("#"+id+" .sales_promotion").html()){
					discount=$("#<?php echo $module['module_name'];?> #"+id).attr('g_'+g_id);
					discount=discount/10;
					$("#"+id+" .group").html((discount*parseFloat($("#"+id+"").attr('normal_price'))).toFixed(2));
					$("#"+id+" .g_discount").html((discount*10)+'<?php echo self::$language['discount']?>');
					$("#"+id+" .subtotal").html((discount*parseFloat($("#"+id+"").attr('normal_price')) *  parseFloat($("#"+id+" .quantity").val())).toFixed(2) );
					$("#"+id+" .price_td .normal .price").html($("#"+id+"").attr('normal_price'));
				}else{
					$("#"+id+" .group").html($("#"+id+"").attr('normal_price'));
					$("#"+id+" .subtotal").html((parseFloat($("#"+id+"").attr('normal_price')) *  parseFloat($("#"+id+" .quantity").val())).toFixed(2) );		
				}
				
				shop_group_discount_sum+=parseFloat($("#"+id+" .subtotal").html());
				goods_price+=parseFloat($("#"+id).attr('normal_price') )* parseFloat($("#"+id+" .quantity").val());
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
		
		$("#<?php echo $module['module_name'];?> .goods_price").html(goods_price);
		
		temp=shop_group_discount_sum-parseFloat($("#<?php echo $module['module_name'];?> .goods_price").html());
		
		$("#<?php echo $module['module_name'];?> .decrease").html(temp.toFixed(2));
		$("#<?php echo $module['module_name'];?> #amount_payable_line .number").html(shop_group_discount_sum-credits);
	}	
	
	function close_checkout_search(){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		$("#<?php echo $module['module_name'];?> .barcode").focus();
	}
	
	function weight_input_quantity(obj){
		weight=parseInt($("#<?php echo $module['module_name'];?> .scale_set").attr('last_weight'));
		if(!weight || obj.attr('kg_rate')==0 || (obj.val()!=1 && obj.val()!='')){return false;}
		if(parseInt($("#<?php echo $module['module_name'];?> .scale_set").attr('last_time'))+60000< Date.parse(new Date()) ){return false;}
		$("#<?php echo $module['module_name'];?> .scale_set").attr('last_weight',0);
		quantity=weight*obj.attr('kg_rate')/1000;
		obj.val(quantity);
		format_quantity(obj.parent().parent().attr('id'));	
	}
	
    </script>
    <style>
	body{ height:100%; overflow:hidden; }
	.page-header{ display:none;}
	.fixed_right_div{ display:none;}
	#layout_full{ background-color:#FFF;}	.container{ width:100%; padding:0px; margin:0px;}
	#edit_page_layout_div .edit_page_layout_button{display:none;}
	#<?php echo $module['module_name'];?>{ background-color:#FFF; height:100%;} 
	#<?php echo $module['module_name'];?> .input_div{ display:inline-block; vertical-align:middle; background-color:#FFF; height:1.8rem;  line-height:1.8rem; overflow:hidden; padding:0px;}
	#<?php echo $module['module_name'];?> .input_div input{ display:inline-block; vertical-align:top; margin:0px; border:none; outline:none;height:1.7rem;  line-height:1.7rem; color:#333;}
	#<?php echo $module['module_name'];?> .input_div a{ display:inline-block; background-color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; border:1px #FFFFFF solid; height:1.78rem; overflow:hidden; padding-left:0.5rem; padding-right:0.5rem;}
	
	#<?php echo $module['module_name'];?> .line{ line-height:3.5rem; border-bottom:#CCC 1px solid;}
	#<?php echo $module['module_name'];?> .line .m_label{ display:inline-block; vertical-align:top; width:10%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .line .value{ display:inline-block; vertical-align:top; width:90%; overflow:hidden;}
	
	#<?php echo $module['module_name'];?> .line .input_div{ display:inline-block; vertical-align:middle; background-color:#FFF; height:3.5rem;  line-height:3.5rem; overflow:hidden; padding:0px; font-size:1.6rem;}
	#<?php echo $module['module_name'];?> .line .input_div input{ display:inline-block; vertical-align:top; margin:0px; border:none; outline:none;height:3.48rem;  line-height:3.48rem; color:#333; font-size:1.6rem;}
	#<?php echo $module['module_name'];?> .line .input_div a{ display:inline-block; background-color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?> border:1px #FFFFFF solid; height:3.48rem; overflow:hidden; padding-left:0.5rem; padding-right:0.5rem;}
	
	
	#<?php echo $module['module_name'];?> .checkout_header{  position:fixed; top:0px;left:0px; width:100%; height:6rem; background-color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1']['text']?>; color:#FFF; border-bottom:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> solid 0.3rem;}
	#<?php echo $module['module_name'];?> .checkout_header a{ color:#FFF;}
	#<?php echo $module['module_name'];?> .checkout_header .icon{ display:inline-block; vertical-align:top; width:8%; border-right:1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; overflow:hidden; text-align:center; height:100%;}
	#<?php echo $module['module_name'];?> .checkout_header .icon a{ display:block;}
	#<?php echo $module['module_name'];?> .checkout_header .icon a img{ width:4rem; height:4rem; margin-top:1rem; border-radius:4rem; background-color:#2da23a; border:2px solid #FFFFFF;}
	#<?php echo $module['module_name'];?> .checkout_header .other{ display:inline-block; vertical-align:top; width:92%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .checkout_header .other .shop_info{ padding-left:2rem; line-height:2.5rem; border-bottom:1px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?> .checkout_header .other .shop_info .info_fulfil{ display:inline-block; vertical-align:top; width:60%; overflow:hidden; white-space:nowrap; text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?> .checkout_header .other .shop_info .shop_name{ display:inline-block; vertical-align:top; margin-right:2rem;}
	#<?php echo $module['module_name'];?> .checkout_header .other .shop_info .fulfil_preferential{ display:inline-block; vertical-align:top; margin-right:2rem;}
	#<?php echo $module['module_name'];?> .checkout_header .other .shop_info .cashier{ display:inline-block; vertical-align:top; width:39%; margin-right:1rem; text-align:right;overflow:hidden; white-space:nowrap; text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?> .checkout_header .other .shop_info .cashier a:hover{ font-weight:bold;}
	#<?php echo $module['module_name'];?> .checkout_header .other .shop_info .cashier .unlogin{ display:inline-block; line-height:2rem; padding-left:0.5rem; padding-right:0.5rem; border-radius:5px; background-color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>;}
	#<?php echo $module['module_name'];?> .checkout_header .other .shop_info .cashier .unlogin:hover{ background-color:#F60;}
	
	#<?php echo $module['module_name'];?> .checkout_header .other .user_act{ padding-left:2rem;line-height:3.5rem;}
	#<?php echo $module['module_name'];?> .checkout_header .other .user_act #user_info{ display:inline-block; vertical-align:top; width:70%;}
	#<?php echo $module['module_name'];?> .checkout_header .other .user_act .act_div{  width:29%; text-align:right; padding-right:1rem; display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?> .checkout_header .other .user_act .act_div div{ display:inline-block;}
	#<?php echo $module['module_name'];?> .checkout_header .other .user_act .act_div .act_left{ width:50%; display:inline-block; vertical-align:top; text-indent:3px;}
	#<?php echo $module['module_name'];?> .checkout_header .other .user_act .act_div .act_right{width:50%; display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?> .checkout_header .other .user_act .act_div .act_right input{ width:5rem;}
	
	
	#<?php echo $module['module_name'];?> .checkout_middle{ background-color:#dfe2e7; padding-top:6.3rem; padding-bottom:3rem;}
	#<?php echo $module['module_name'];?> .checkout_middle{}
	
	#<?php echo $module['module_name'];?> .checkout_footer{ padding-left:3rem; position:fixed; bottom:0px;left:0px; width:100%; height:3rem; line-height:3rem; background-color:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; color:#FFF;}
	#<?php echo $module['module_name'];?> .checkout_footer a{ display:inline-block; vertical-align:top; line-height:2rem; margin-top:0.5rem; margin-right:5px; padding-left:5px; padding-right:5px; background-color:<?php echo $_POST['monxin_user_color_set']['nv_2']['background']?>; color:#FFF; border-radius:5px;}
	#<?php echo $module['module_name'];?> .checkout_footer a:hover{ background-color:#F60;}
	#<?php echo $module['module_name'];?> .checkout_footer #hot_key_switch{ position:fixed; left:0.5rem; bottom:0.5rem; text-align:center;}
	#<?php echo $module['module_name'];?> .checkout_footer .hot_key_show{}
	#<?php echo $module['module_name'];?> .checkout_footer .hot_key_show:before {font: normal normal normal 1rem/1 FontAwesome;margin-right: 5px;content: "\f100";}
	#<?php echo $module['module_name'];?> .checkout_footer .hot_key_hide:before {font: normal normal normal 1rem/1 FontAwesome;margin-right: 5px;content: "\f101";}
	#<?php echo $module['module_name'];?> .goods_info{display:block;  height:80px;  overflow:hidden;} 
	#<?php echo $module['module_name'];?> .goods_info .img{ vertical-align:top;display:inline-block; vertical-align:top; width:80px; height:80px; overflow:hidden;}	
	#<?php echo $module['module_name'];?> .goods_info img{width:70px; height:70px; margin:5px;}	
	#<?php echo $module['module_name'];?> .goods_info .title{ vertical-align:top;display:inline-block; vertical-align:top; width:280px; padding-left:10px; height:80px;line-height:25px; font-size:1rem; overflow:hidden; white-space:normal;  }	
	#<?php echo $module['module_name'];?> .subtotal{ font-weight:bold; line-height:30px;}
	#<?php echo $module['module_name'];?> .quantity_div{ line-height:30px;}
	#<?php echo $module['module_name'];?> .decrease_quantity{text-align:center; display:inline-block;  width:30px; height:30px; vertical-align:top;background:#ddd;color:#999;}
	#<?php echo $module['module_name'];?> .decrease_quantity:before{font: normal normal normal 1rem/1 FontAwesome; content: "\F068";}
	#<?php echo $module['module_name'];?> .decrease_quantity:hover{ opacity:0.8; }
	#<?php echo $module['module_name'];?> .quantity{ width:50px; text-align:center; height:30px; line-height:30px; border-radius:0px; border-left:0px; border-right:0px;padding:0px; display:inline-block; vertical-align:top;} 
	
	#<?php echo $module['module_name'];?> .add_quantity{ text-align:center; display:inline-block;  width:30px; height:30px; vertical-align:top;background:#ddd; color:#999;}
	#<?php echo $module['module_name'];?> .add_quantity:before{font: normal normal normal 1rem/1 FontAwesome; content: "\F067"; }	
	#<?php echo $module['module_name'];?> .add_quantity:hover{ opacity:0.8; }
	
	   
	#<?php echo $module['module_name'];?> [monxin-table] .del{ background:none; vertical-align:top; height:30px; line-height:30px; }    
	#<?php echo $module['module_name'];?> [monxin-table] .del:hover{ color:#ff9600;}    
	#<?php echo $module['module_name'];?>_html .title_div{ line-height:40px;}    
	#<?php echo $module['module_name'];?>_html .title_div .fulfil_preferential{ font-size:1rem; color:#8c8c8c; display:inline-block; vertical-align:top; margin-left:10px;}   
	
	
	#<?php echo $module['module_name'];?> [monxin-table] thead tr td{ background:none; background-color:#f0f0f0; color:#333; height:40px; line-height:40px; font-size:1rem; text-align:left;}    
	#<?php echo $module['module_name'];?> [monxin-table] thead tr td .operation_icon{ background:none;} 
	#<?php echo $module['module_name'];?> [monxin-table] tbody tr td{ border:none; border-bottom:1px solid #e7e7e7; background:none; text-align:left;}
	#<?php echo $module['module_name'];?> [monxin-table]{ background:none; border:none;}    
	#<?php echo $module['module_name'];?> [monxin-table] .even{ background:none; border:none;}    
	#<?php echo $module['module_name'];?> [monxin-table] .odd{ background:none; border:none;}   
	#<?php echo $module['module_name'];?> [monxin-table] tbody .del{ display:none;}
	#<?php echo $module['module_name'];?> [monxin-table] tbody tr:hover .del{display:inline-block;}
	
	
	
	
	
	#<?php echo $module['module_name'];?>_html{ white-space:nowrap;}   
	#<?php echo $module['module_name'];?>_html .checkout_left{ position:fixed; display:inline-block; vertical-align:top; white-space:nowrap; width:30%; padding:1rem; overflow:hidden;background-color:#dfe2e7; height:100%; } 
	#<?php echo $module['module_name'];?>_html .checkout_left .logo{ width:100%; display:block;}  
	#<?php echo $module['module_name'];?>_html .checkout_left .logo img{ width:100%; border:none;}  
	#<?php echo $module['module_name'];?>_html .checkout_left .fulfil_preferential{ line-height:25px; white-space:normal;}
	#<?php echo $module['module_name'];?>_html .checkout_left .input_div{}
	#<?php echo $module['module_name'];?>_html  .input_div a{ cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .checkout_left .input_div .barcode_state{ text-align:right; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .checkout_left .input_div .barcode{ height:3rem; line-height:3rem; width:76%;}
	#<?php echo $module['module_name'];?>_html .checkout_left .input_div .add_goods{width:24%; text-align:center;}
	#<?php echo $module['module_name'];?>_html .checkout_left .sum_info{ line-height:80px; font-size:26px; text-align:right; }
	#<?php echo $module['module_name'];?>_html .checkout_left .sum_info .goods_item{ color:#F00;font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .checkout_left .sum_info .goods_price{ color:#F00;font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .checkout_left .submit_now{ display:inline-block; vertical-align:top; vertical-align:top; width:150px; height:40px; color:#FFF; background-color:#FF4A00; text-align:center; line-height:40px; margin-right:20px;}
	
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div{ line-height:40px;}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div input{ padding-left:5px;}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .line{}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .line .m_label{}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .line .value{}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .balance,.decrease,.number{ color:#F00; font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .user{ width:9.2rem; font-size:0.5rem; }
	#<?php echo $module['module_name'];?>_html .checkout_left #option_div .preferential_code{ width:6rem;}
	
	
	.pay_method_sub_div{ display:inline-block; vertical-align:top;}
	.pay_method_sub_div div{ display:inline-block; vertical-align:top;display:none;}
	.balance_div img{ width:200px;}
	.credit_div img{ width:200px;}
	.transaction_password{ width:120px;}
	#<?php echo $module['module_name'];?>_html .received_money{ width:4rem; }
	#<?php echo $module['module_name'];?>_html .checkout_right{position:fixed; right:0px; display:inline-block; vertical-align:top; width:70%; height:600px; overflow:scroll; overflow-x:hidden; white-space:nowrap;background-color:#dfe2e7; height:100%;}   
   
	#<?php echo $module['module_name'];?>_html .clear_all{ }
	#<?php echo $module['module_name'];?>_html .clear_all:hover{ font-weight:bold;}   
	.checkout_desk{  font-size:30px; padding:5px; padding-left:0px; font-weight:bold; text-align:left;}
	.checkout_desk img{ height:40px; padding-right:5px; padding-left:5px; display:inline-block; vertical-align:top;}
	.checkout_desk span{ height:40px; display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .sales_promotion{ color:#fff; background-color: #F60; padding-left:3px;padding-right:3px; margin-left:3px; border-radius:7px;}
	#submit_checkout_state{ text-align:right; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .print_div{ position:fixed; right:0px; top:200px; width:300px; height:500px; display:none;}
	.hot_key{ cursor:pointer; font-size:0.9rem;}
	.hot_key div{display:none;}
	.price_td{ line-height:30px;}
	.price_td .my_shop_group_discount{ display:none;}
	.shop_group .my_shop_group_discount{ display:block;}
	.shop_group .price{ text-decoration:line-through;}
	#<?php echo $module['module_name'];?>_html .unit{ padding-left:3px;}
	.abandon{text-decoration: line-through; opacity:0.6;}
	#<?php echo $module['module_name'];?>_html .group{ color:#F00;	}
	.decrease .fail{ font-weight:normal; font-size:0.7rem;}
	#<?php echo $module['module_name'];?>_html .g_discount{ color:#999; display:none;}
	#<?php echo $module['module_name'];?>_html .shop_balance{ color:#FF0;}
	#<?php echo $module['module_name'];?>_html .thead{ position:fixed; white-space:nowrap; height:2rem; line-height:2rem; width:80%; background-color:#dee2e7; }
	#<?php echo $module['module_name'];?>_html .thead span{ display:inline-block; vertical-align:top; text-align:center;}
	#<?php echo $module['module_name'];?>_html .table_scroll{ padding-top:2rem; background-color:#f0f1f3;margin-top:0px; border:none;}
	
	#<?php echo $module['module_name'];?>_html .goods_td{ width:45%; overflow:hidden; white-space:nowrap; text-align:left !important;}
	#<?php echo $module['module_name'];?>_html .price_td{ width:5%; overflow:hidden; white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .quantity_div{ width:18%; overflow:hidden; white-space:nowrap; text-align:center !important; padding-left:0px; padding-right:0px;}
	#<?php echo $module['module_name'];?>_html .subtotal_td{ width:7%; overflow:hidden; white-space:nowrap;text-align:left !important;}
	#<?php echo $module['module_name'];?>_html .operation_td{ width:10%; overflow:hidden; white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html select{ color:#666;}
	#<?php echo $module['module_name'];?> .user{ padding-left:3px;}
	.return_money{ color:red;}
	#<?php echo $module['module_name'];?> .print_set_div{ display:inline-block; vertical-align:top;text-align:right;}
	.credit_div{ display:none !important;}
	.hot_key{ display:inline-block; vertical-align:top; width:80%; overflow:hidden;}
	.quick_goods_switch{ display:inline-block; vertical-align:top; width:20%; overflow:hidden; text-align:center;}
	.quick_goods_div{ position:fixed; bottom:3rem; right:0px; height:78%; width:20%; background:#fff; display:none; overflow:hidden;}
	.quick_goods_list{ height:100%; overflow:scroll; white-space:normal;}
	.quick_goods_div a{ display:inline-block; vertical-align:top; width:50%; height:100px;  overflow:hidden; text-align:center; cursor:pointer; border:1px #ccc dashed;background:#EFE9E9;} 
	.quick_goods_div .img_div{ height:100px; width:100%; overflow:hidden; text-align:center;}
	.quick_goods_div img{  width:100%; }
	.quick_goods_div a:hover .img_div{ display:none; }
	.quick_goods_div a:hover{ background-color:#ff6709; color:#fff;}
	.quick_goods_div a:hover span{ background-color:#ff6709; color:#fff;}
	.quick_goods_div a .e_price{ }
	.quick_goods_div span{ display:block; background:#ccc; height:70px; font-size:0.9rem; line-height:1.2rem; padding:5px;}
	#<?php echo $module['module_name'];?> #scale_set .line{ line-height:30px;}
	#<?php echo $module['module_name'];?> #scale_set .line .m_label{ display:inline-block; width:46%; text-align:right; padding-right:1%;}
	#<?php echo $module['module_name'];?> #scale_set .line .m_input{ display:inline-block; width:50%;}
	
   .credits_div{ line-height:1.6rem; font-size:0.9rem; padding-top:3px; display:none;}
   .credits_div > span{ display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
   .credits_div > span >a{ display:inline-block; vertical-align:top; padding-left:3px; padding-right:3px; cursor:pointer; border-radius:3px;}
   .credits_div .shop_credit{}
   .credits_div .web_credit{ text-align:right;}
   .credits_div .use_credit_div{ display:none; padding-top:3px;}
   .credits_div .use_credit_div .use_credit{ width:8rem;}
   .credits_div .use_credit_div .credit_money{color:red;}
	
	#<?php echo $module['module_name'];?> .switch_address_div{}
	#<?php echo $module['module_name'];?> .switch_address_div:before {font: normal normal normal 1rem/1 FontAwesome;margin-left: 5px;content: "\f041";}
	#<?php echo $module['module_name'];?> #address_div{ text-align:left;}
	#<?php echo $module['module_name'];?> .address{ width:100%; height:4rem;}
	#<?php echo $module['module_name'];?> .receiver{ }
	#<?php echo $module['module_name'];?>_html .transaction_password{ font-size:0.7rem;}
	
	
#<?php echo $module['module_name'];?> .search_result_div{ position:absolute;top:50px; left:0px;  background-color:#fff; overflow:hidden; width:60%; min-height:0px; z-index:99999999999;    box-shadow: 0 0 5px #888; }
#<?php echo $module['module_name'];?> .search_result_div a{ display:block; line-height:2rem; padding-left:5px; font-size:1rem; white-space:nowrap; width:100%; overflow:hidden; text-overflow: ellipsis;}
#<?php echo $module['module_name'];?> .search_result_div a:hover{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:#fff;}
#<?php echo $module['module_name'];?> .search_result_div a i{ opacity:0.6; font-style:normal !important;}
#<?php echo $module['module_name'];?> .search_result_div{}
#<?php echo $module['module_name'];?> .search_result_div .current{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:#fff;}
	
.user_search_result_div{ position:absolute; top:5.3rem; left:0px; background-color:#fff; z-index:99999999999; min-width:11rem;    box-shadow: 0 0 5px #888; }
.user_search_result_div a{ padding:0.2rem; cursor:pointer;}
.user_search_result_div a:hover{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:#fff;}
.user_search_result_div .current{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:#fff;}
.user_search_result_div [m_show='1']{ display:block;}
.user_search_result_div [m_show='0']{ display:none;}

#<?php echo $module['module_name'];?> .gs i{}	
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    	<div class=checkout_header>
        	<div class=icon><a href=./index.php  target="_blank"><img src='./program/mall/shop_icon/<?php echo $module['shop_id']?>.png' /></a></div><div class=other>
            	<div class=shop_info>
                	<div class=info_fulfil>
						<a class=shop_name href=./index.php?monxin=mall.shop_index&shop_id=<?php echo $module['shop_id']?> target="_blank"><?php echo $module['shop_name'];?>-<?php echo self::$language['checkout_desk'];?></a>
                  		<?php echo $module['fulfil_preferential'];?>
                 	</div>
                    <div class="cashier"><span class=scale_last></span> <span class=weight_show></span>  <a href=# class=scale_set><?php echo self::$language['scale_set']?></a> &nbsp;  &nbsp; 
					<?php echo self::$language['cashier'];?>：<a href="./index.php?monxin=index.user" target="_blank" class=cashier_username><?php echo $module['username']?></a> <a  class="unlogin" id="unlogin" href="./receive.php?target=index::user&act=unlogin"><?php echo self::$language['unlogin_short']?></a></div>
                </div>
                <div class=user_act>
                	<div id=user_info><?php echo self::$language['member']?><?php echo self::$language['info']?>：<span class=value><div class=input_div><input type="text" class=user placeholder="<?php echo self::$language['username']?>/<?php echo self::$language['phone']?>/<?php echo self::$language['membership']?>"  /><a><?php echo self::$language['enter']?></a></div> <span class=user_state></span></span> <a class=switch_address_div href=#></a></div><div class="act_div">
                        <div class=act_right>
                        	
                            <a href=# class="temporary_storage"><?php echo self::$language['temporary_storage'];?></a> 
                            <div ><div class=input_div><input type="text" maxlength="4" class="temp_name"  placeholder="4 <?php echo self::$language['bit_words']?>" onkeyup="value=value.replace(/[^\d]/g,'') "  /><a><?php echo self::$language['enter']?></a></div><span class=state></span></div>
                        </div><div class=act_left>
                            <a href="#" class="import"><?php echo self::$language['recover'];?></a> 
                            <div ><select class=import_select><option value=""><?php echo self::$language['please_select']?></option></select></div>
                        </div>
                    
                    </div>
                        
                </div>
            </div>
        </div>
    	<div class=checkout_middle>
            
            <div class=checkout_left>
               <div class=line><span class=m_label><?php echo self::$language['barcode']?>:</span><span class=value>
                   <div class=input_div>
                        <input type="text" class=barcode placeholder="<?php echo self::$language['sweep_barcode']?>/<?php echo self::$language['name']?>/<?php echo self::$language['first_pinyin']?>" /><a href="./index.php?monxin=mall.checkout_search" style="color:#FFF;" class=add_goods><?php echo self::$language['add']?></a></div>
                        <div class=barcode_state> </div>
                        <div class=sum_info><?php echo self::$language['sum'];?>:<span class=goods_item>0</span> <?php echo self::$language['item'];?><?php echo self::$language['goods'];?> <span class=goods_price>0</span> <?php echo self::$language['yuan']?></div>
                    </div>
               </span>
                
                
                
                <div id=option_div>
                    
                    
                    <div class=line id=use_method_line><span class=m_label><?php echo self::$language['preferential'];?>：</span><span class="value"><select class=preferential_way><?php echo $module['preferential_way_option'];?></select> <span class=preferential_code_span style="display:none;"> <input type="text" class="preferential_code" placeholder="<?php echo self::$language['please_input'];?>" /></span> <span class="decrease"></span> </span></div>
                   <div class=credits_div>
				   		<span class=shop_credit><?php echo self::$language['store'];?><?php echo self::$language['credits'];?> <b rate="<?php echo $module['shop_credits_rate']?>"></b> <a user_color=button><?php echo self::$language['use']?></a></span>
				   		<span class=web_credit><?php echo self::$language['site'];?><?php echo self::$language['credits'];?> <b rate="<?php echo $module['web_credits_rate']?>"></b> <a user_color=button><?php echo self::$language['use']?></a></span>
                        <div class=use_credit_div><input type="text" class=use_credit placeholder="<?php echo self::$language['input_use_integral']?>" /> <span class=credit_money></span></div>
                   </div>
                   
                    <div class=line id=amount_payable_line><span class=m_label><?php echo self::$language['need_pay'];?>：</span><span class="value"><span class="number"></span><?php echo self::$language['yuan'];?></span></div>
    
                    <div class=line id=submit_checkout_state></div>
                    <div class=line id=pay_method_div>
                        <?php echo self::$language['method'];?>：<select class=pay_method><?php echo $module['pay_method'];?></select>
                        <div class=pay_method_sub_div>
                            <div class=cash_div style="display:inline-block;"><?php echo self::$language['received_money'];?> <input type="text" class=received_money placeholder="<?php echo self::$language['please_input']?>" /> <?php echo self::$language['return_money'];?> <span class=return_money></span></div>
                            <div class=pos_div style="display:inline-none;"><?php echo self::$language['reference_number'];?> <input type="text" class=reference_number placeholder="<?php echo self::$language['please_input']?>" /></div>
                            
                            <div class=credit_div style="display:none !important;"><input type="text" class=credit_remark placeholder="<?php echo self::$language['remark']?>" /><br /><input type="password" class=transaction_password placeholder="<?php echo self::$language['transaction_password']?><?php echo self::$language['or_scan_code']?>" /> <span class=state></span><br />
                           
                            <img class=qr_img /><p class=state></p></div>
                            
                            <div class=balance_div><input type="password" class=transaction_password placeholder="<?php echo self::$language['transaction_password']?><?php echo self::$language['or_scan_code']?>" /> <span class=state></span><br /><img class=qr_img /><p class=state></p></div>
                        </div>
                    </div>
                        
                </div>
               
               <div class=stocking_div>
               		<?php echo self::$language['stocking']?>：<select class=stocking><option value=6><?php echo self::$language['stocking_option'][6]?></option><option value=0><?php echo self::$language['stocking_option'][0]?></option><option value=1><?php echo self::$language['stocking_option'][1]?></option></select>
               </div>
                
                
    
                

            </div><div class=checkout_right>
                
             <div class=thead>

                <span class=goods_td><?php echo self::$language['goods']?></span>
                <span class=price_td><?php echo self::$language['unit_price']?></span>
                <span class=quantity_div ><?php echo self::$language['quantity']?></span>
                <span class=subtotal_td><?php echo self::$language['subtotal']?></span>
                <span class=operation_td><?php echo self::$language['operation']?> <a href="#" class=clear_all><?php echo self::$language['clear_all'];?></a></span>
            </div>
                    
                <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%; " cellpadding="0" cellspacing="0">
                   
                    <tbody style="">
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
        
        </div>
    	<div class=checkout_footer>
        	<div class=hot_key>
            	<a href=# id=hot_key_switch class=hot_key_show></a>
                <b><?php echo self::$language['shortcut_key']?></b>
                <a class=space_key><?php echo self::$language['checkout_and_print']?>：Shift+<?php echo self::$language['space_key']?>(Space)</a>
                <a class=shift_q><?php echo self::$language['barcode_focus']?>：Shift+q</a>
                <a class=shift_a><?php echo self::$language['user_focus']?>：Shift+a</a>
                <a class=shift_z><?php echo self::$language['received_money_focus']?>：Shift+z</a>
                <a class=shift_x><?php echo self::$language['empty_checkout']?>：Shift+x</a>
                <div class=print_set_div><?php echo self::$language['print']?><?php echo self::$language['set']?> <select class=print_set><?php echo $module['print_set_list'];?></select></div>
                
            </div><a class=quick_goods_switch><?php echo self::$language['quick_goods']?></a>        
        </div>
    	<div class=quick_goods_div><div class=quick_goods_list><?php echo $module['quick_goods'];?></div></div>
    <div class=print_div><iframe width="100%" id="print_tag" name="print_tag" height="600px;"  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="./index.php?monxin=mall.checkout_print" >
</iframe></div>

	
    
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="scale_set" tabindex="-1" role="dialog" 
           aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" 
                       data-dismiss="modal" aria-hidden="true">
                          &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       <b><?php echo self::$language['scale_set'];?></b>
                    </h4>
                 </div>
                 <div class="modal-body">
                     <div class=line><span class=m_label><?php echo self::$language['scale_open']?></span><span class=m_input><select class=scale_open><option value=0><?php echo self::$language['no']?></option><option value=1><?php echo self::$language['yes']?></option></select></span></div>
                     
                     <div class=line><span class=m_label><?php echo self::$language['scale_com']?></span><span class=m_input><select class=scale_com>
                        <option value="-1">选择串口</option>
                        <option value="1">COM1</option>
                        <option value="2">COM2</option>
                        <option value="3">COM3</option>
                        <option value="4">COM4</option>
                        <option value="5">COM5</option>
                        <option value="6">COM6</option>
                        <option value="7">COM7</option>
                        <option value="8">COM8</option>
                        <option value="9">COM9</option>
                        <option value="10">COM10</option>
                        <option value="11">COM11</option>
                        <option value="12">COM12</option>
                        <option value="13">COM13</option>
                        <option value="14">COM14</option>
                        </select></span></div>
                     <div class=line><span class=m_label><?php echo self::$language['scale_state']?></span><span class=m_input><span class=scale_state style="background:#ccc;"></span></span></div>
                     <div class=line><span class=m_label><?php echo self::$language['scale_auto_input']?></span><span class=m_input><select class=scale_auto_input><option value=0><?php echo self::$language['no']?></option><option value=1><?php echo self::$language['yes']?></option></select></span></div>
                     <div class=line><span class=m_label><?php echo self::$language['scale_unit']?></span><span class=m_input><select class=scale_unit><option value=1000>g</option><option value=1>kg</option></select></span></div>
                     <div class=line><span class=m_label><?php echo self::$language['get_weihgt_shortcut_key']?></span><span class=m_input> Enter</span></div>
                     <div style="text-align:center;"><a href=http://www.monxin.com/comset.php>串口设备高级设置调试</a></div>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" 
                       data-dismiss="modal"><?php echo self::$language['close']?>
                    </button>
                    
                 </div>
              </div>
        </div></div>
                
    
    
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="address_div" tabindex="-1" role="dialog" 
           aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" 
                       data-dismiss="modal" aria-hidden="true">
                          &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       <b><?php echo self::$language['receiving_information'];?></b>
                    </h4>
                 </div>
                 <div class="modal-body" style=" line-height:30px;">
                     <textarea class=address></textarea>
                     
                    <div><?php echo self::$language['quick_call']?></div>                     
                    <div class="receiver"></div>                     
                     
                     
                     
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" 
                       data-dismiss="modal"><?php echo self::$language['close']?>
                    </button>
                    
                 </div>
              </div>
        </div></div>
                
    
    
    
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="checkout_browser" tabindex="-1" role="dialog" 
           aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" 
                       data-dismiss="modal" aria-hidden="true">
                          &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       <b><?php echo self::$language['recommend_checkout_browser'];?></b>
                    </h4>
                 </div>
                 <div class="modal-body" style=" text-align:center; line-height:50px;">
                     <a href=./收银台.zip target="_blank" class=download><?php echo self::$language['click']?><?php echo self::$language['download']?></a>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" 
                       data-dismiss="modal"><?php echo self::$language['close']?>
                    </button>
                    
                 </div>
              </div>
        </div></div>
                
    

    </div>
   
    <div class=search_result_div></div>
    <div class=user_search_result_div><?php echo $module['user'];?></div>
	<div class=gs style="display:none;"><?php echo $module['goods']?></div>
    
</div>