<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script src="./plugin/datePicker/index.php"></script>

   <script>
	function check_recharge_state(){
		if($("#<?php echo $module['module_name'];?> #money").val()==''){return false;}
		$.post('<?php echo $module['action_url'];?>&act=check_state', function(data){
			try{v=eval("("+data+")");}catch(exception){alert(data);}				
			if(v.state=='fail'){
				
			}else{
				window.location.href='./index.php?monxin=index.financial_center';
			}
		});
	
	}
    $(document).ready(function(){
		
		setInterval('check_recharge_state()',1000); 
		
		
		if("<?php echo $module['offline_state'];?>"=="closed"){
			$("#offline_tr td").css('display','none');	
		}
		if("<?php echo $module['online'];?>"==""){
			$("#online_tr td").css('display','none');	
		}
		if("<?php echo $module['online'];?>"=="" && "<?php echo $module['offline_state'];?>"=="closed"){
			$("#<?php echo $module['module_name'];?>_html").html('<div id=not_enabled><?php echo self::$language['not_enabled']?></div>');
			$('#pay_photo_ele').html('');
		}
		
		
		$('#pay_photo_ele').insertBefore($('#pay_photo_state'));
		$('#pay_photo_ele').css('display','inline-block');
		$("#submit_pay_info").click(function(){
			if($("#pay_info_div").css('display')=='none'){$("#pay_info_div").css('display','block');}else{$("#pay_info_div").css('display','none');}	
			return false;
		});
		
        $("#submit_offline").click(function(){
			if(($("#pay_info").val()=="<?php echo $module['pay_info'];?>" || $("#pay_info").val()=='') && $("#pay_photo").val()==''){monxin_alert("<?php echo self::$language['pay_photo'];?>/<?php echo self::$language['pay_info'];?> <?php echo self::$language['whole_is_null'];?>");return false;}
			
			if(!$.isNumeric($("#money").val())){$("#money").val('');$("#money").focus();$("#money_state").html('<?php echo self::$language['please_input'];?>');alert('<?php echo self::$language['please_input'];?><?php echo self::$language['recharge'];?><?php echo self::$language['amount'];?>');return false;}
			if($("#money").val()<0){$("#money").val('');$("#money").focus();$("#money_state").html('<?php echo self::$language['please_input'];?>');alert('<?php echo self::$language['please_input'];?><?php echo self::$language['recharge'];?><?php echo self::$language['amount'];?>');return false;}
			if($("#pay_info").val()=="<?php echo $module['pay_info'];?>"){$("#pay_info").val('');}
            json="{'money':'"+$("#money").val()+"','pay_info':'"+$("#pay_info").val()+"','pay_photo':'"+$("#pay_photo").val()+"','return_url':'<?php echo @$_GET['return_url'];?>'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}

            $("#submit_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
            $("#submit_state").load('<?php echo $module['action_url'];?>',json,function(){
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


					
                    $(this).html(v.info);
					if(v.state=='success'){
						$("#online_tr").css('display','none');
						$("#submit_offline").css('display','none');
						}
                }
            });
			return false;
        });
		
        $(".payment").click(function(){		
			if(!$.isNumeric($("#money").val())){$("#money").val('');$("#money").focus();$("#money_state").html('<?php echo self::$language['please_input'];?>');alert('<?php echo self::$language['please_input'];?><?php echo self::$language['recharge'];?><?php echo self::$language['amount'];?>');return false;}
			if($("#money").val()<0){$("#money").val('');$("#money").focus();$("#money_state").html('<?php echo self::$language['please_input'];?>');alert('<?php echo self::$language['please_input'];?><?php echo self::$language['recharge'];?><?php echo self::$language['amount'];?>');return false;}
            json="{'money':'"+$("#money").prop('value')+"','payment':'"+$(this).attr('payment')+"','return_url':'<?php echo @$_GET['return_url'];?>','notify_url':'<?php echo @$_GET['notify_url'];?>'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}

            $("#online_div").html("<span class=\'fa fa-spinner fa-spin\'></span>");
            $("#online_div").load('<?php echo $module['action_url'];?>',json,function(){
				$("#payment_form").submit();
            });
			return false;
        });


            
    });
    </script>
    

    
    
    
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px; }
    #<?php echo $module['module_name'];?>_html #pay_photo_ele input{ border:none;}
    #<?php echo $module['module_name'];?> #content{ width:240px; height:180px;}
	#offline{ width:800px; height:80px;}
	input{ height:30px; line-height:30px;}
	#offline_div{width:900px;  padding:10px; border:1px #ccc solid; border-radius:3px;}
	#offline_div #offlie_info{ display:inline-block; width:700px; overflow:hidden;}
	#online_div{width:900px; padding:10px; border:1px #ccc solid; border-radius:3px;}
	#online_div .payment{ display:inline-block; vertical-align:top; width:20%; text-align:center; overflow:hidden; }
	#online_div img{ border:0px;width:130px;margin:10px;}
	#input_money{ text-align:center;}
	#submit_pay_info{ float:right;}
	#not_enabled{ text-align:center; font-size:40px; margin-top:50px;}
	#<?php echo $module['module_name'];?>_html tr td{ padding-bottom:20px;}
	#<?php echo $module['module_name'];?>_html tr > td:first-child{ padding-right:5px;}
	.provider_name{ display:none;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    <div id=pay_method>
    <table cellpadding="10" cellspacing="1">
    <tr ><td width="10%" align="right"><span><?php echo self::$language['recharge'];?><?php echo self::$language['amount'];?></span></td>
    <td width="90%">
    <input type="text" id="money" value="<?php echo @$_GET['money']?>"><span id=money_state></span>
    </td></tr>

    <tr id="offline_tr"><td width="10%" align="right"><?php echo self::$language['offline_payment']?></td>
    <td width="90%">
	<div id=offline_div>
    <div style="line-height:30px;"><span id=offlie_info><?php echo $module['offline'];?></span><a href="#" id='submit_pay_info' class="submit"><?php echo self::$language['submit_pay_info']?></a></div>
   	
    <div id=pay_info_div style="display:none;"><br />
    <span class=m_label><?php echo self::$language['pay_photo'];?></span><span id=pay_photo_state></span><br /><br />
    <span class=m_label><?php echo self::$language['pay_info'];?></span><input type="text" id='pay_info' name='pay_info' value="<?php echo $module['pay_info'];?>" style="width:700px;"><br />
    <br />
    <div class="submit_button"  user_color='button'><a href="#" id="submit_offline"><?php echo self::$language['submit']?></a></div><span id=submit_state></span>
    </div>
    </div>
    </td></tr>
    <tr id="online_tr"><td align="right" valign="top"><br/><?php echo self::$language['online_payment']?></td>
    <td>
    <div id=online_div><?php echo $module['online']?></div>
    </td></tr>
    </table>
    </div>
    
    <div style="height:110px;">  </div>
    </div>
</div>

