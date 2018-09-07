<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		if(7!=<?php echo $module['state'];?>  && 6!=<?php echo $module['state'];?>  && 2!=<?php echo $module['state'];?>  ){
			$("#<?php echo $module['module_name'];?> .submit").css('display','none');
			$("#<?php echo $module['module_name'];?> #voucher_div").css('display','none');
		}
		$('#voucher_ele').insertBefore($('#voucher_state'));
		$("#<?php echo $module['module_name'];?> .refund_reason").val('<?php echo $module['refund_reason']?>');
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			if($("#<?php echo $module['module_name'];?> .refund_reason").val()==''){
				$("#<?php echo $module['module_name'];?> .refund_reason").focus();
				$("#<?php echo $module['module_name'];?> .state").html('<span class=fail>'+$("#<?php echo $module['module_name'];?> .refund_reason").parent().prev().html()+'</span>');	
				return false;	
			}
			if($("#<?php echo $module['module_name'];?> .refund_amount").val()==''){
				$("#<?php echo $module['module_name'];?> .refund_amount").focus();
				$("#<?php echo $module['module_name'];?> .state").html('<span class=fail><?php echo self::$language['please_input']?>'+$("#<?php echo $module['module_name'];?> .refund_amount").parent().prev().html()+'</span>');
				return false;	
			}
			$("#<?php echo $module['module_name'];?> .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			url='<?php echo $module['action_url'];?>';
			obj=new Object();
			obj['refund_reason']=$("#<?php echo $module['module_name'];?> .refund_reason").val();
			obj['refund_amount']=$("#<?php echo $module['module_name'];?> .refund_amount").val();
			obj['refund_remark']=$("#<?php echo $module['module_name'];?> .refund_remark").val();
			obj['voucher']=$("#<?php echo $module['module_name'];?> #voucher").val();
			
			$.post(url,obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> .state").html(v.info);
				if(v.state=='success'){
					parent.update_state_7('<?php echo @$_GET['id'];?>');
					
				}
			});
				
			return false;
		});
    });    
    </script>
	<style>
	.fixed_right_div,.page-footer,#mall_cart,.cart_goods_sum{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
    #<?php echo $module['module_name'];?>{} 
    #<?php echo $module['module_name'];?> .process{ margin-bottom:20px; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; } 
    #<?php echo $module['module_name'];?> .process span{ width:25%; display:inline-block; vertical-align:top; overflow:hidden; text-align:center; height:50px;line-height:50px;} 
    #<?php echo $module['module_name'];?> .process span b{   width:30px; height:30px; margin-top:10px; margin-right:5px; line-height:30px; display:inline-block; border-radius:15px; overflow:hidden ; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; } 
	#<?php echo $module['module_name'];?> .process span n{ display:inline-block; vertical-align:top; margin-top:0px;}
	#<?php echo $module['module_name'];?> .process .p_1:after{ float:right; padding-top:1.3rem;  font: normal normal normal 1rem/1 FontAwesome; content:"\f105";}
	#<?php echo $module['module_name'];?> .process .p_2:after{ float:right; padding-top:1.3rem;  font: normal normal normal 1rem/1 FontAwesome; content:"\f105";}
	#<?php echo $module['module_name'];?> .process .p_3:after{ float:right; padding-top:1.3rem;  font: normal normal normal 1rem/1 FontAwesome; content:"\f105";}
	#<?php echo $module['module_name'];?> .process .p_4{}
	#<?php echo $module['module_name'];?> .line{ line-height:50px;}
	#<?php echo $module['module_name'];?> .line .m_label{ display:inline-block; vertical-align:top; width:20%; padding-right:10px; overflow:hidden; text-align:right;}
	#<?php echo $module['module_name'];?> .line .value{display:inline-block; vertical-align:top; width:75%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .line .value b{ }
	#<?php echo $module['module_name'];?> .refund_amount{ width:100px;}
	#<?php echo $module['module_name'];?> .refund_remark{ width:80%; height:100px;}
	#<?php echo $module['module_name'];?> required{  padding-right:5px;}
	#<?php echo $module['module_name'];?> .voucher_img{ width:200px; border:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=process><span class=p_1><b>1</b><n><?php echo self::$language['order_return_process'][0]?></n></span><span class=p_2><b>2</b><n><?php echo self::$language['order_return_process'][1]?></n></span><span class=p_3><b>3</b><n><?php echo self::$language['order_return_process'][2]?></n></span><span class=p_4><b>4</b><n><?php echo self::$language['order_return_process'][3]?></n></span></div>
        
       <div class=line><span class=m_label><?php echo self::$language['order_return'];?></span><span class=value><required>*</required><select class=refund_reason><option value=""> </option><?php echo $module['cancel_option'];?></select></span></div>
       
       <div class=line><span class=m_label><?php echo self::$language['refund_amount'];?></span><span class=value><required>*</required><input type="text" class=refund_amount value="<?php echo $module['refund_amount']?>" /> (<?php echo self::$language['actual_pay']?>：<b><?php echo $module['actual_money']?></b>,<?php echo self::$language['include_freight_costs']?>：<b><?php echo $module['express_cost']?></b>)</span></div>
       
       <div class=line><span class=m_label><?php echo self::$language['remark'];?></span><span class=value><required> </required><textarea class=refund_remark><?php echo $module['refund_remark'];?></textarea></span></div>
       
       <div class=line id=voucher_div><span class=m_label><?php echo self::$language['voucher'];?></span><required> </required><span class=value><?php echo $module['refund_voucher'];?> <span id=voucher_state></span></span></div>
       
       <div class=line><span class=m_label> </span><span class=value><a href="#" class=submit><span class=b_start> </span><span class=b_middle><?php echo self::$language['submit'];?></span><span class=b_end> </span></a> <span class=state></span></span></div>
        
    	
        
    </div>
</div>