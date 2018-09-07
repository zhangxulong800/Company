<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#payee").blur(function(){
			json="{'payee':'"+$("#payee").val()+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
			$("#real_name").load('<?php echo $module['action_url'];?>&act=show_name',json,function(){
				
			});
		});
		
        $("#submit").click(function(){
			if(($("#payee").val()=="<?php echo self::$language['username'];?>" || $("#payee").val()=='')){$("#payee_state").html("<?php echo self::$language['remittee'];?><?php echo self::$language['is_null'];?>");}
			if(!$.isNumeric($("#money").val())){$("#money_state").html('<?php echo self::$language['must_be'];?><?php echo self::$language['number'];?>');$("#money").focus();return false;}
			if($("#money").val()<1){$("#money_state").html('<?php echo self::$language['less_than'];?>1');$("#money").focus();return false;}
			
			if($("#money").val()><?php echo $module['user_money']?>){$("#money_state").html('<?php echo self::$language['must_be_less_than']?><?php echo self::$language['user_money'];?>');$("#money").focus();return false;}
			if($("#transaction_password").val()==''){$("#transaction_password_state").html("<?php echo self::$language['is_null'];?>");$("#transaction_password").focus();return false;}
			
            json="{'money':'"+$("#money").val()+"','payee':'"+$("#payee").val()+"','transaction_password':'"+$("#transaction_password").val()+"','remark':'"+$("#remark").val()+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}

            $("#submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
			$("#submit").css('display','none');
			$(".input_state").html('');
            $("#submit_state").load('<?php echo $module['action_url'];?>&act=submit',json,function(){
                if($(this).html().length>10){
					//alert($(this).html());
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
					$(this).html('');
                    $("#"+v.key+"_state").html(v.info);
                    $("#submit_state").html(v.info);
					if(v.state=='success'){
						$(this).html(v.info);
						parent.update_balance(<?php echo @$_GET['shop_id']?>,$("#<?php echo $module['module_name'];?> #money").val());	
					}else{
						$("#submit").css('display','inline-block');	
					}
				}
            });
			return false;
        });
		
		
            
    });
    </script>
    

    
    
    
    
    <style>
	.container{ width:100% !important;}
	.fixed_right_div{ display:none;}
    #<?php echo $module['module_name'];?>_html{ }
    #<?php echo $module['module_name'];?>_html #money_transfer_table{}
	#<?php echo $module['module_name'];?>_html input{ height:30px; line-height:30px; padding-left:5px;}
	#<?php echo $module['module_name'];?>_html tr td{ padding-bottom:20px;}
	#<?php echo $module['module_name'];?>_html tr > td:first-child{ padding-right:5px;}
	#<?php echo $module['module_name'];?>_html h1{ text-align:center; border-bottom:1px solid #CCC; margin-bottom:1rem;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    <h1><?php echo $module['shop_name']?></h1>
    <div id=pay_method>
    <table cellpadding="10" cellspacing="1" id="money_transfer_table">
    <tr ><td width="50%" align="right"><span><?php echo self::$language['store'];?><?php echo self::$language['user_money'];?></span></td>
    <td width="50%"><?php echo $module['user_money'];?></td></tr>
    <tr ><td align="right"><span><?php echo self::$language['transfer'];?><?php echo self::$language['amount'];?></span></td>
    <td>
    <input type="text" id="money" name="money" /> <span id="money_state" class="input_state"></span>
    </td></tr>
    <tr id="offline_tr"><td align="right"><?php echo self::$language['transfer'];?><?php echo self::$language['remark'];?></td>
    <td>
   <input type="text" id='remark' name='remark' value="" />
   
    </td></tr>
    
    <tr ><td align="right"><span><?php echo self::$language['remittee'];?></span></td>
    <td>
    <input type="text" id="payee" name="payee" placeholder="<?php echo self::$language['username']?>" /> <span id=real_name></span> <span id="payee_state" class="input_state"></span>
    </td></tr>
    <tr ><td align="right"><span><?php echo self::$language['transaction_password'];?></span></td>
    <td>
    <input type="password" id="transaction_password" name="transaction_password" /> <span id="transaction_password_state" class="input_state"></span>
    </td></tr>

    <tr id="offline_tr"><td align="right">&nbsp;</td>
    <td>
    <div class="submit_button"  user_color='button'><a href="#" id="submit"><?php echo self::$language['submit']?></a></div><span id=submit_state></span>
    </td></tr>
    </table>
    </div>
    
    </div>
</div>

