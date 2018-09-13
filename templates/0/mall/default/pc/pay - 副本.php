<style> #<?php echo $module['module_name'];?> .view{}</style>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
	var remain_time;
	var t1;
    $(document).ready(function(){
		var counter = 0;
		if (window.history && window.history.pushState) {
			 $(window).on('popstate', function () {
					window.history.pushState('forward', null, '#');
					window.history.forward(1);
					alert("不可回退");
				});
		 }
		  window.history.pushState('forward', null, '#'); //在IE中必须得有这两行
		  window.history.forward(1);
	
		$(window).focus(function(){
			if($("#<?php echo $module['module_name'];?> #balance_div").css('display')=='block' && $("#<?php echo $module['module_name'];?> .recharge_div").html()){
				window.location.reload();
			}
		});
		
		if(<?php echo $module['data']['pre_sale']?>==1 && <?php echo $module['data']['state']?>==13){
			$("#<?php echo $module['module_name'];?> .order_info").html($("#<?php echo $module['module_name'];?> .money").html());
			$("#<?php echo $module['module_name'];?> .order_info").css('height','100px').css('line-height','100px').css('font-size','30px');
		}
		
		$("#<?php echo $module['module_name'];?>_html .pay_method_option .option a:first").attr('class','selected');;
		$("#<?php echo $module['module_name'];?>_html .pay_method_body #"+$("#<?php echo $module['module_name'];?>_html .pay_method_option .option a:first").attr('id')+"_div").css('display','block');
		
		$.get("./receive.php?target=shop::cart&act=update_cart");
		$('#pay_photo_ele').insertBefore($('#pay_photo_state'));
		$('#pay_photo_ele').css('display','inline-block');

		$("#<?php echo $module['module_name'];?>_html .pay_method_option .option a").click(function(){
			$("#<?php echo $module['module_name'];?>_html .pay_method_option .option a").attr('class','');
			$(this).attr('class','selected');
			$("#<?php echo $module['module_name'];?>_html .pay_method_body .method_div").css('display','none');
			$("#<?php echo $module['module_name'];?>_html .pay_method_body #"+$(this).attr('id')+"_div").css('display','block');
			$(document).scrollTop($(this).offset().top-100);
			return false;
		});
			
		$("#<?php echo $module['module_name'];?> .get_verification_code").click(function(){
			if($("#<?php echo $module['module_name'];?> .get_verification_code").attr('lock')==1){return false;}
			window.clearInterval(t1);
			$("#<?php echo $module['module_name'];?> .get_verification_code").attr('lock',1);
			
			$.post('<?php echo $module['action_url'];?>&act=get_verification_code', function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}				
				
				//alert(v.info);
				if(v.state=='fail'){
					alert('<?php echo self::$language['fail']?>,'+v.reason);
					$("#<?php echo $module['module_name'];?> .get_verification_code").css('lock',0);
				}else{
	
					$("#<?php echo $module['module_name'];?> .get_verification_code").html('<?php echo self::$language['recapture']?>(<b>60</b>)');
					remain_time=60;
					t1 = window.setInterval(update_remain,1000);  
	
				}
				
			});
			return false;	
	
			
		});
			
		
		$("#<?php echo $module['module_name'];?> #balance_div .submit").click(function(){
			if($("#<?php echo $module['module_name'];?> #authcode").val()==''){
				$("#<?php echo $module['module_name'];?> #authcode").focus();
				$(this).next().html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['authcode']?></span>');	
				return false;
			}
			$("#<?php echo $module['module_name'];?> #balance_div .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['executing']?>');
			$("#<?php echo $module['module_name'];?> #balance_div .submit").css('display','none');
            $.post('<?php echo $module['action_url'];?>&pay_method=balance',{authcode:$("#<?php echo $module['module_name'];?> #authcode").val()},function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #balance_div .submit").next().html(v.info);
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?>").html(v.info).css('text-align','center').css('line-height','200px');		
				}else{
					//alert(data);
					$("#<?php echo $module['module_name'];?> #balance_div .submit").css('display','inline-block');
				}
            });
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> #cash_on_delivery_div .submit").click(function(){
			$("#<?php echo $module['module_name'];?> #cash_on_delivery_div .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['executing']?>');
			$("#<?php echo $module['module_name'];?> #cash_on_delivery_div .submit").css('display','none');
		    $.get('<?php echo $module['action_url'];?>&pay_method=cash_on_delivery',function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #cash_on_delivery_div .submit").next().html(v.info);
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?>").html(v.info).css('text-align','center').css('line-height','200px');		
				}else{
					alert(data);
					$("#<?php echo $module['module_name'];?> #cash_on_delivery_div .submit").css('display','inline-block');	
				}
            });
			return false;	
		});
				
        $(".payment").click(function(){
            json="{'money':'<?php echo $module['data']['actual_money'];?>','payment':'"+$(this).attr('payment')+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#online_payment_div").html("<span class=\'fa fa-spinner fa-spin\'></span>");
            $("#online_payment_div").load('<?php echo $module['action_url'];?>&pay_method=online_payment',json,function(data){
				$("#payment_form").submit();
            });
			return false;
        });
		
		
    });
		function update_remain(){
			if(remain_time==0){
				
				$("#<?php echo $module['module_name'];?> .get_verification_code").attr('lock',0);
				$("#<?php echo $module['module_name'];?> .get_verification_code").html('<?php echo self::$language['recapture']?>');
				window.clearInterval(t1);
			}
			$("#<?php echo $module['module_name'];?> .get_verification_code b").html(remain_time--);	
		}
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{} 
    #<?php echo $module['module_name'];?>_html .order_info{ padding-left:30px; height:150px;} 
    #<?php echo $module['module_name'];?>_html .order_info .act_state{ text-align:center; display:inline-block; vertical-align:top; line-height:10.71rem; height:10.71rem; width:12%;} 
	#<?php echo $module['module_name'];?>_html .order_info .act_state:before{font: normal normal normal 6rem/1 FontAwesome;line-height:10.71rem; content:"\f046";color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
    #<?php echo $module['module_name'];?>_html .order_info .info{ display:inline-block; vertical-align:top; height:150px; text-align:left;} 
    #<?php echo $module['module_name'];?>_html .order_info .info .state_title{ font-size:20px; font-weight:bold; padding-top:20px; line-height:30px;} 
    #<?php echo $module['module_name'];?>_html .order_info .info .time_limit{ padding-bottom:10px;} 
    #<?php echo $module['module_name'];?>_html .order_info .info .time_limit .time{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;} 
    #<?php echo $module['module_name'];?>_html .order_info .info .title{} 
    #<?php echo $module['module_name'];?>_html .order_info .info{ display:inline-block; vertical-align:top; height:200px;} 
    #<?php echo $module['module_name'];?>_html .title{ padding-left:50px; font-size:40px; font-weight:bold;} 
    #<?php echo $module['module_name'];?>_html .pay_method_option{ padding-left:30px; margin-top:20px; line-height:5rem; height:5rem;} 
    #<?php echo $module['module_name'];?>_html .pay_method_option .title{ font-weight:bold; font-size:30px;} 
    #<?php echo $module['module_name'];?>_html .pay_method_option .option{} 
    #<?php echo $module['module_name'];?>_html .pay_method_option .option a{ display: inline-block; vertical-align:top; text-align:center; margin-left:20px; margin-right:20px; width:15%;    font-size:20px;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;} 
	#<?php echo $module['module_name'];?>_html .pay_method_option .option a:hover{ opacity:0.8;}
		#<?php echo $module['module_name'];?>_html .pay_method_option .option .selected div{ background:#fff;}
    #<?php echo $module['module_name'];?>_html .pay_method_option .option .selected div:after {font: normal normal normal 1rem/1 FontAwesome;content: "\f0d7";font-size:3rem;  line-height:0.6rem;display:block; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
    #<?php echo $module['module_name'];?>_html .pay_method_option .option .selected:hover{} 
	#<?php echo $module['module_name'];?>_html .pay_method_body{ height:400px;} 
	#<?php echo $module['module_name'];?>_html .pay_method_body .method_div{ margin-left:50px; margin-top:20px; display:none;} 
	
	#<?php echo $module['module_name'];?>_html .pay_method_body .method_div .sub{ line-height:60px;}
	#<?php echo $module['module_name'];?>_html .pay_method_body .method_div .sub a:hover{ opacity:0.7;}
	#<?php echo $module['module_name'];?>_html .state{  }
	#<?php echo $module['module_name'];?>_html  #balance_div .recharge_div{ font-size:16px; line-height:30px; font-weight:normal; }
	#<?php echo $module['module_name'];?>_html  #balance_div .recharge_div .m_label{ display:inline-block; width:28%; text-align:right; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .payment{ display:block; line-height:3rem;border-bottom:rgba(236,236,236,1) solid 1px;}
	#<?php echo $module['module_name'];?>_html .payment img{ padding-right:3px; height:25px;}
	
	#<?php echo $module['module_name'];?>_html  #balance_div .state .view{ }
	#<?php echo $module['module_name'];?>_html .line{ line-height:60px; font-weight:normal; font-size:18px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; width:28%; text-align:right; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .line .value{ display:inline-block; width:70%; }
	.get_verification_code{font-size:1rem; display:inline-block; width:102px; text-align:left;}
	.get_verification_code img{vertical-align:middle;}
	#<?php echo $module['module_name'];?> .view{ }
	#<?php echo $module['module_name'];?> [lock='0']{}
	#<?php echo $module['module_name'];?> [lock='1']{ color:#CCC;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=order_info>
        	<div class=act_state></div><div class=info>
            	<div class=state_title><?php echo self::$language['your_order_submitted'];?></div>
            	<div class=time_limit><?php echo self::$language['please_in'];?><span class=time><?php echo $module['pay_time_limit'];?></span><?php echo self::$language['complete_payment'];?></div>
            	<div class=money><?php echo self::$language['amount'];?> : <?php echo $module['data']['actual_money'];?><?php echo self::$language['yuan'];?></div>
            	<div class=id><?php echo self::$language['order_id'];?> : <?php echo $module['data']['id'];?></div>
            	<div class=receiver><?php echo self::$language['dispatching'];?> : <?php echo $module['address'];?></div>
            </div>
        </div>
        <div class="portlet-title" style="margin-left:3.5rem;"><div class="caption"><?php echo self::$language['please_select'];?><?php echo self::$language['pay_method_str'];?></div></div>
        <div class=pay_method_option>
			<span class=option>
            	<?php echo $module['pay_method_option'];?>
            </span>
        </div>
        <div class=pay_method_body>
        	<div id=balance_div class='method_div'>
            	<div class=sub>
                	<div class=line><span class=m_label><?php echo self::$language['available_balance'];?>:</span><span class=value><?php echo @$module['user_money'];?><span class=unit><?php echo self::$language['yuan'];?></span></span></div>
  					<?php echo $module['balance_act'];?>
                </div>
            </div>
        	
            <div id=bank_transfer_div class='method_div'>
            	<?php echo $module['bank_transfer'];?>
                <div id=pay_info_div><br />
                <span class=m_label><?php echo self::$language['pay_photo'];?></span><span id=pay_photo_state></span><br /><br />
                <span class=m_label><?php echo self::$language['pay_info'];?></span><input type="text" id='pay_info' name='pay_info' value="<?php echo @$module['pay_info'];?>" style="width:700px;"><br />
                <br />
                <a href="#" class=submit><?php echo self::$language['submit']?></a> <span class=state></span>
                </div>                
            </div>
        	
            <div id=cash_on_delivery_div class='method_div'>
            	<div class=sub>
                	<?php echo @$module['cash_on_delivery'];?>
                    <br />
  <a href="#" class="submit"><?php echo self::$language['confirm']?><?php echo self::$language['pay_method']['cash_on_delivery']?></a> <span class=state></span> 
                </div>
            
            </div>
        	
            <div id=online_payment_div class='method_div'>
            	<div class="sub"><?php echo @$module['online'];?></div>
            </div>
        </div>
    </div>
</div>
