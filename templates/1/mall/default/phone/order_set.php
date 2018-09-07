<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .line select").each(function(index, element) {
            if($(this).attr('monxin_value')){$(this).val($(this).attr('monxin_value'));}
        });
		
        
        $("#<?php echo $module['module_name'];?> .line input").blur(function(){
			temp=$(this).attr('class');
            $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html("<span class='fa fa-spinner fa-spin'></span>");
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class')+'&v='+$(this).val(),function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html(v.info);
            });
        });
        $("#<?php echo $module['module_name'];?> .line select").change(function(){
			temp=$(this).attr('class');
            $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html("<span class='fa fa-spinner fa-spin'></span>");
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class')+'&v='+$(this).val(),function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html(v.info);
            });
        });
        
    });
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .line{  line-height:40px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; width:30%; text-align:right; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .line .value{ display:inline-block; vertical-align:top; width:60%;}
    </style>    
	<div id="<?php echo $module['module_name'];?>_html">
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
    
        <div class=line ><span class=m_label><?php echo self::$language['pay_ad_fees'];?><?php echo $module['ad_fees'];?>%</span><span class=value><select class="pay_ad_fees" monxin_value="<?php echo $module['config']['pay_ad_fees']?>" ><option value="1"><?php echo self::$language['yes'];?></option><option value="0"><?php echo self::$language['no'];?></option></select> <span class=state></span>  <?php echo self::$language['pay_ad_fees_remark'];?></span></div>
     
        <div class=line><span class=m_label><?php echo self::$language['credits_rate'];?></span><span class=value><input type="text" class="credits_rate" value="<?php echo $module['config']['credits_rate']?>" /> =1<?php echo self::$language['yuan']?> <span class=state></span></span></div>
       


        <div class=line><span class=m_label><?php echo self::$language['decrease_quantity'];?></span><span class=value><select class="decrease_quantity" monxin_value="<?php echo $module['config']['decrease_quantity']?>" ><option value="0"><?php echo self::$language['decrease_quantity_option'][0];?></option><option value="1"><?php echo self::$language['decrease_quantity_option'][1];?></option><option value="2"><?php echo self::$language['decrease_quantity_option'][2];?></option><option value="6"><?php echo self::$language['decrease_quantity_option'][6];?></option></select> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['order_notice_when'];?></span><span class=value><select class="order_notice_when" monxin_value="<?php echo $module['config']['order_notice_when']?>" ><option value="0"><?php echo self::$language['decrease_quantity_option'][0];?></option><option value="1"><?php echo self::$language['decrease_quantity_option'][1];?></option></select> <span class=state></span></span></div>
		
        <div class=line style=" display:none;"><span class=m_label><?php echo self::$language['order_notice_email'];?></span><span class=value><input type="text" class="order_notice_email" value="<?php echo $module['config']['order_notice_email']?>" /> <span class=state></span></span></div>
       
        <div class=line><span class=m_label><?php echo self::$language['print_supplier'];?></span><span class=value><select class="print_supplier" monxin_value="<?php echo $module['config']['print_supplier']?>" ><?php echo $module['print_supplier_option']?></select> <span class=state></span></span></div>
       
        <div class=line><span class=m_label><?php echo self::$language['print_partner'];?></span><span class=value><input type="text" class="print_partner" value="<?php echo $module['config']['print_partner']?>" /> <span class=state></span> </span></div>
       
        <div class=line><span class=m_label><?php echo self::$language['print_apikey'];?></span><span class=value><input type="text" class="print_apikey" value="<?php echo $module['config']['print_apikey']?>" /> <span class=state></span> </span></div>
       
        <div class=line><span class=m_label><?php echo self::$language['print_machine_code'];?></span><span class=value><input type="text" class="print_machine_code" value="<?php echo $module['config']['print_machine_code']?>" /> <span class=state></span> </span></div>
       
        <div class=line><span class=m_label><?php echo self::$language['print_msign'];?></span><span class=value><input type="text" class="print_msign" value="<?php echo $module['config']['print_msign']?>" /> <span class=state></span> </span></div>
       
        
        <div class=line style=" display:none;"><span class=m_label><?php echo self::$language['send_notice_email'];?></span><span class=value><select class="send_notice_email" monxin_value="<?php echo $module['config']['send_notice_email']?>" ><option value="1"><?php echo self::$language['yes'];?></option><option value="0"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>

        
        <div class=line style=" display:none;"><span class=m_label><?php echo self::$language['checkout_order_notice_email'];?></span><span class=value><select class="checkout_order_notice_email" monxin_value="<?php echo $module['config']['checkout_order_notice_email']?>" ><option value="1"><?php echo self::$language['yes'];?></option><option value="0"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>

        <div class=line><span class=m_label><?php echo self::$language['phone_goods_list_show_buy_button'];?></span><span class=value><select class="phone_goods_list_show_buy_button" monxin_value="<?php echo $module['config']['phone_goods_list_show_buy_button']?>" ><option value="1"><?php echo self::$language['yes'];?></option><option value="0"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>

        <div class=line style="display:none;"><span class=m_label><?php echo self::$language['support'];?><?php echo self::$language['pay_method']['cash_on_delivery'];?></span><span class=value><select class="cash_on_delivery" monxin_value="<?php echo $module['config']['cash_on_delivery']?>" ><option value="1"><?php echo self::$language['yes'];?></option><option value="0"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>

        <div class=line ><span class=m_label><?php echo self::$language['support'];?><?php echo self::$language['checkout_desk'];?><?php echo self::$language['pay_method']['credit'];?></span><span class=value><select class="credit" monxin_value="<?php echo $module['config']['credit']?>" ><option value="1"><?php echo self::$language['yes'];?></option><option value="0"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
    </div>

</div>
