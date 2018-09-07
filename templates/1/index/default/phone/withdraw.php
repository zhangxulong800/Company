<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #money").blur(function(){
			if($(this).val()!='' && $.isNumeric($(this).val()) ){
				$("#<?php echo $module['module_name'];?> .rate").html(($(this).val()*$(this).attr('rate')/100).toFixed(2)+'<?php echo self::$language['yuan']?>');
			}
			money=parseFloat($("#money").val());
			if(parseFloat(((money*$("#money").attr('rate')/100)).toFixed(2))+parseFloat(money)><?php echo $module['user_money']?>){
				$("#money").focus();
			 	$("#submit_state").html('<span class=fail><?php echo self::$language['withdraw'];?>+<?php echo self::$language['withdraw_rate'];?> <?php echo self::$language['must_be_less_than']?><?php echo self::$language['user_money'];?></span>');
			}else{
				$("#submit_state").html('');
			}
				
		});
		
		
		if('<?php echo $module['withdraw_method_1'];?>'==''){
			$("#<?php echo $module['module_name'];?> .withdraw_method").val('0');	
			$("#<?php echo $module['module_name'];?> .withdraw_method_div").css('display','none');	
			$("#<?php echo $module['module_name'];?> .method_0").css('display','block');	
		}
		
		$("#<?php echo $module['module_name'];?> .radio").click(function(){
			$("#<?php echo $module['module_name'];?> .withdraw_method").val($(this).val());
			$("#<?php echo $module['module_name'];?> .method_0").css('display','none');	
			$("#<?php echo $module['module_name'];?> .method_1").css('display','none');	
			$("#<?php echo $module['module_name'];?> .method_"+$(this).val()).css('display','block');	
		});
		
        $("#<?php echo $module['module_name'];?> #submit").click(function(){
			if(!$.isNumeric($("#money").val())){$("#money").focus();return false;}
			if($("#money").val()<0){$("#money").focus();return false;}
			money=parseFloat($("#money").val());
			if(parseFloat(((money*$("#money").attr('rate')/100)).toFixed(2))+parseFloat(money)><?php echo $module['user_money']?>){
				$("#money").focus();
			 	$("#submit_state").html('<span class=fail><?php echo self::$language['withdraw'];?>+<?php echo self::$language['withdraw_rate'];?> <?php echo self::$language['must_be_less_than']?><?php echo self::$language['user_money'];?></span>');
				//alert(parseFloat(((money*$("#money").attr('rate')/100)).toFixed(2))+parseFloat(money));
			return false;
			}
			
			if($("#money").val()><?php echo $module['user_money']?>){$("#money").focus();$("#submit_state").html('<span class=fail><?php echo self::$language['must_be_less_than']?><?php echo self::$language['user_money'];?></span>');return false;}
			
			if($("#<?php echo $module['module_name'];?> .withdraw_method").val()==''){
				$("#submit_state").html('<span class=fail><?php echo self::$language['please_select']?><?php echo self::$language['withdraw_method'];?></span>');return false;	
			}
			if($("#<?php echo $module['module_name'];?> .withdraw_method").val()==0){
				if(($("#billing_info").val()=="<?php echo self::$language['billing_info_template_old'];?>" || $("#billing_info").val()=='')){$("#submit_state").html("<span class=fail><?php echo self::$language['billing_info'];?><?php echo self::$language['is_null'];?></span>");return false;}
				billing_info=$("#billing_info").val();
			}else{
				billing_info='<?php echo $module['weixin_name'];?>';
			}
            json="{'money':'"+$("#money").val()+"','billing_info':'"+billing_info+"','method':'"+$(".withdraw_method").val()+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
			
			if(json.method==0){
				if(parseFloat(json.money)<parseFloat(<?php echo $module['withdraw_set']['min']?>)){
					$("#submit_state").html("<span class=fail><?php echo self::$language['config_language']['withdraw_set']['min']?><?php echo $module['withdraw_set']['min'];?></span>");
					$("#money").focus();
					return false;
				}
			}
			
				
            $("#submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#submit_state").load('<?php echo $module['action_url'];?>&act=submit',json,function(){
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
                    $(this).html(v.info);
					if(v.state=='success'){
						if(json.method==0){alert('<?php echo self::$language['submit']?><?php echo self::$language['success']?>,<?php echo $module['withdraw_set']['remark']?>');}
						window.location.href='./index.php?monxin=index.withdraw_log';
					}
				}
            });
			return false;
        });
		

            
    });
    </script>
    

    
    
    
    
    <style>
    #<?php echo $module['module_name'];?>{ }
    #<?php echo $module['module_name'];?> #withdraw_table{}
	#<?php echo $module['module_name'];?> .line{  line-height:30px; }
	#<?php echo $module['module_name'];?> .line .m_label{ display:inline-block; vertical-align: middle; width:30%; text-align:right; padding-right:10px; box-shadow:none; }
	#<?php echo $module['module_name'];?> .line .value{ display:inline-block; vertical-align: middle; width:70%;}
	#<?php echo $module['module_name'];?> .line .value input {}
	#<?php echo $module['module_name'];?> .radio{ display:inline;}
	#<?php echo $module['module_name'];?> .method_1{ display:none;}
	#<?php echo $module['module_name'];?> .method_0{ display:none;}
	#<?php echo $module['module_name'];?> .open_icon{ width:30px;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    <div id=pay_method>
    	<div class=line><span class=m_label><?php echo self::$language['user_money'];?></span><span class=value><?php echo $module['user_money'];?></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['withdraw'];?><?php echo self::$language['amount'];?></span><span class=value><input type="text" id="money" name="money" rate="<?php echo $module['withdraw_set']['rate']?>" /></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['withdraw_rate'];?>(<?php echo $module['withdraw_set']['rate']?>%)</span><span class=value><span class=rate></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['payee'];?></span><span class=value><?php echo $module['real_name'];?></span></div>
    	<div class="line withdraw_method_div"><span class=m_label><?php echo self::$language['withdraw_method'];?></span><span class=value><input type="hidden" class=withdraw_method /> <input type="radio" name=radio class=radio value=0 /><?php echo self::$language['other']?> &nbsp;  <?php echo $module['withdraw_method_1'];?> </span></div>
    	<div class="line method_0"><span class=m_label><?php echo self::$language['billing_info']?></span><span class=value><input type="text" id='billing_info' name='billing_info' value="<?php echo self::$language['billing_info_template'];?>"  /></span></div>
        
        
    	<div class="line method_1"><span class=m_label><?php echo self::$language['openid']?></span><span class=value><?php echo $module['weixin_name']?></span></div>
    	
        
        <div class="line"><span class=m_label></span><span class=value><a href="#" id=submit class="submit_button" user_color='button'><?php echo self::$language['submit']?></a><span id=submit_state></span></span></div>
    </div>
    
    </div>
</div>

