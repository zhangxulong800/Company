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
			if(($("#payee").val()=="<?php echo self::$language['username'];?>" || $("#payee").val()=='')){$("#payee_state").html("<?php echo self::$language['payee'];?><?php echo self::$language['is_null'];?>");}
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
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
					$(this).html('');
                    $("#"+v.key+"_state").html(v.info);
					if(v.state=='success'){
						$(this).html(v.info+" <a href='./index.php?monxin=index.credits_log'><?php echo self::$language['view']?></a>");
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
    #<?php echo $module['module_name'];?>_html{ padding-top:10px; }
    #<?php echo $module['module_name'];?>_html #money_transfer_table{}
	#<?php echo $module['module_name'];?>_html input{ height:30px; line-height:30px; padding-left:5px;}
	#<?php echo $module['module_name'];?>_html tr td{ padding-bottom:20px;}
	#<?php echo $module['module_name'];?>_html tr > td:first-child{ padding-right:5px;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    <div id=pay_method>
    <table cellpadding="10" cellspacing="1" id="money_transfer_table">
    <tr ><td width="10%" align="right"><span><?php echo self::$language['available'];?><?php echo self::$language['credits'];?></span></td>
    <td width="90%"><?php echo $module['user_money'];?></td></tr>
    <tr ><td align="right"><span><?php echo self::$language['transfer'];?><?php echo self::$language['credits'];?></span></td>
    <td>
    <input type="text" id="money" name="money" /> <span id="money_state" class="input_state"></span>
    </td></tr>
    <tr id="offline_tr"><td align="right"><?php echo self::$language['transfer'];?><?php echo self::$language['remark'];?></td>
    <td>
   <input type="text" id='remark' name='remark' value="" style="width:800px;" />
   
    </td></tr>
    
    <tr ><td align="right"><span><?php echo self::$language['payee'];?></span></td>
    <td>
    <input type="text" id="payee" name="payee" placeholder="<?php echo self::$language['username']?>/<?php echo self::$language['phone']?>" /> <span id=real_name></span> <span id="payee_state" class="input_state"></span>
    </td></tr>
    <tr ><td align="right"><span><?php echo self::$language['transaction_password'];?></span></td>
    <td>
    <input type="password" id="transaction_password" name="transaction_password" /> <span id="transaction_password_state" class="input_state"></span>
    </td></tr>

    <tr id="offline_tr"><td align="right">&nbsp;</td>
    <td>
   <a href="#" id="submit" class="submit_button"  user_color='button'><?php echo self::$language['submit']?></a><span id=submit_state></span>
    </td></tr>
    </table>
    </div>
    
    </div>
</div>

