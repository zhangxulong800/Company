<style> #<?php echo $module['module_name'];?> .view{}</style>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
	var remain_time;
	var t1;
    $(document).ready(function(){
		var counter = 0;
		/*
		if (window.history && window.history.pushState) {
			 $(window).on('popstate', function () {
					window.history.pushState('forward', null, '#');
					window.history.forward(1);
					alert("不可回退");
				});
		 }
		  window.history.pushState('forward', null, '#'); //在IE中必须得有这两行
		  window.history.forward(1);
		*/
		if(isWeiXin()){
			$("#<?php echo $module['module_name'];?> .sub .payment").each(function(index, element) {
                if($(this).attr('payment')=='alipay_wap' || $(this).attr('payment')=='scanpay_alipay' || $(this).attr('payment')=='wxh5_wap'){$(this).css('display','none');}
            });
		}else{
			$("#<?php echo $module['module_name'];?> .sub .payment").each(function(index, element) {
                if($(this).attr('payment')=='weixin_wap'){$(this).css('display','none');}
            });
		}
				


		$("#<?php echo $module['module_name'];?>_html .pay_method_option .option a").click(function(){
			$("#<?php echo $module['module_name'];?>_html .pay_method_option .option a").attr('class','');
			$(this).attr('class','selected');
			$("#<?php echo $module['module_name'];?>_html .pay_method_body .method_div").css('display','none');
			$("#<?php echo $module['module_name'];?>_html .pay_method_body #"+$(this).attr('id')+"_div").css('display','block');
			$(document).scrollTop($(this).offset().top-100);
			return false;
		});
			
        $(".payment").click(function(){
			
            json="{'money':'<?php echo $module['data']['price'];?>','payment':'"+$(this).attr('payment')+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#online_payment_div").html("<span class=\'fa fa-spinner fa-spin\'></span>");
            $("#online_payment_div").load('<?php echo $module['action_url'];?>&pay_method=online_payment',json,function(data){
				$("#payment_form").submit();
            });
			return false;
        });
		
		
    });
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{ } 
    #<?php echo $module['module_name'];?> .goods_info{ background:rgba(245,245,245,1); padding-top:1rem; padding-bottom:1rem; } 
    #<?php echo $module['module_name'];?> .goods_info .icon_div{ display:inline-block; vertical-align:top; width:25%; overflow:hidden; text-align:center;} 
	#<?php echo $module['module_name'];?> .goods_info .icon_div img{ width:80%;}
    #<?php echo $module['module_name'];?> .goods_info .info_div{ display:inline-block; vertical-align:top; width:75%; overflow:hidden;} 
	#<?php echo $module['module_name'];?> .goods_info .info_div .g_title{ line-height:1.8rem;}
	#<?php echo $module['module_name'];?> .goods_info .info_div .price_div{ color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; font-weight:bold; line-height:2rem; font-size:1.2rem;}
	
	#<?php echo $module['module_name'];?> .please{ line-height:2rem; padding-left:10px;	background:rgba(245,245,245,1); }
	#<?php echo $module['module_name'];?> .sub{ padding:10px;}
	#<?php echo $module['module_name'];?> .sub a{ display:block; line-height:3rem; padding-top:0.3rem;padding-bottom:0.3rem; border-bottom:rgba(236,236,236,1) solid 1px; }
	#<?php echo $module['module_name'];?> .sub a img{ width:25px; padding-right:3px; }
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=goods_info>
        	<div class=icon_div><img src="./program/mall/img_thumb/<?php echo $module['data']['icon']?>" /></div><div class=info_div>
            	<div class=g_title><?php echo $module['data']['title']?></div>
                <div class=price_div><?php echo self::$language['money_symbol']?><?php echo $module['data']['price']?></div>
            </div>
        </div>
        <div class=please><?php echo self::$language['please_choose_payment']?></div>
        <div class=pay_method_body>
            <div id=online_payment_div class='method_div'>
            	<div class="sub"><?php echo @$module['online'];?></div>
            </div>
        </div>
    </div>
</div>
