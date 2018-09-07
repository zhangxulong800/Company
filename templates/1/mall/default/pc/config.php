<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){		
		
		$("#<?php echo $module['module_name'];?> .line select").each(function(index, element) {
            if($(this).attr('monxin_value')){$(this).val($(this).attr('monxin_value'));}
        });
		
        
        $("#<?php echo $module['module_name'];?> .line input").blur(function(){
			temp=$(this).attr('class');
            $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html("<span class='fa fa-spinner fa-spin'></span>");
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class')+'&v='+$(this).val().replace('&','|||'),function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html(v.info);
            });
        });
        $("#<?php echo $module['module_name'];?> .line select").change(function(){
			temp=$(this).attr('class');
            $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html("<span class='fa fa-spinner fa-spin'></span>");
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class')+'&v='+$(this).val().replace('&','|||'),function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html(v.info);
            });
        });
        
    });
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .line{  line-height:30px; height:50px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align: middle; width:30%; text-align:right; padding-right:10px; box-shadow:none; }
	#<?php echo $module['module_name'];?>_html .line .value{ display:inline-block; vertical-align: middle; width:60%;}
	#<?php echo $module['module_name'];?>_html .line .value input {text-align: right;}
    </style>    
	<div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
   	    </div>

		
        <div class=line><span class=m_label><?php echo self::$language['pay_mode'];?></span><span class=value><select class="pay_mode" monxin_value="<?php echo $module['config']['pay_mode']?>" ><option value="money"><?php echo self::$language['pay_mode_option']['money'];?></option><option value="credits"><?php echo self::$language['pay_mode_option']['credits'];?></option></select> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['cart_show_independent'];?></span><span class=value><select class="cart_show_independent" monxin_value="<?php echo $module['config']['cart_show_independent']?>" ><option value="1"><?php echo self::$language['yes'];?></option><option value="0"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
    
		<div class=line><span class=m_label><?php echo self::$language['pay_time_limit'];?></span><span class=value><input type="text" class="pay_time_limit" value="<?php echo $module['config']['pay_time_limit']?>" /><?php echo self::$language['pay_time_limit_post_fix'];?> <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['online_pay_fees'];?></span><span class=value><input type="text" class="online_pay_fees" value="<?php echo $module['config']['online_pay_fees']?>" style=" text-align:right; padding-right:5px;" />% <span class=state></span></span></div>
	
		<div class=line><span class=m_label><?php echo self::$language['min_deposit'];?></span><span class=value><input type="text" class="min_deposit" value="<?php echo $module['config']['min_deposit']?>" style=" text-align:right; padding-right:5px;" /><?php echo self::$language['yuan'];?> <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['shop_year_fees'];?></span><span class=value><input type="text" class="shop_year_fees" value="<?php echo $module['config']['shop_year_fees']?>" style=" text-align:right; padding-right:5px;" /><?php echo self::$language['yuan'];?> <span class=state></span></span></div>
		
		
		<div class=line><span class=m_label><?php echo self::$language['default'];?><?php echo self::$language['annual_shop_order_fees'];?></span><span class=value><input type="text" class="annual_shop_order_fees" value="<?php echo $module['config']['annual_shop_order_fees']?>" style=" text-align:right; padding-right:5px;" />% <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['default'];?><?php echo self::$language['times_shop_order_fees'];?></span><span class=value><input type="text" class="times_shop_order_fees" value="<?php echo $module['config']['times_shop_order_fees']?>" style=" text-align:right; padding-right:5px;" />% <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['ad_fees'];?></span><span class=value><input type="text" class="ad_fees" value="<?php echo $module['config']['ad_fees']?>" style=" text-align:right; padding-right:5px;" />% <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['manage_fees'];?></span><span class=value><input type="text" class="manage_fees" value="<?php echo $module['config']['manage_fees']?>" style=" text-align:right; padding-right:5px;" />% <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['agent_add_shop_fedds'];?> (<?php echo self::$language['mall_pay'];?>)</span><span class=value><input type="text" class="agent_add_shop_fedds" value="<?php echo $module['config']['agent_add_shop_fedds']?>" style=" text-align:right; padding-right:5px;" /> <?php echo self::$language['yuan']?> <span class=state></span></span></div>

		<div class=line><span class=m_label><?php echo self::$language['agent_transaction_fees_percentage'];?> (<?php echo self::$language['mall_pay'];?>)</span><span class=value><input type="text" class="agent_transaction_fees_percentage" value="<?php echo $module['config']['agent_transaction_fees_percentage']?>" style=" text-align:right; padding-right:5px;" />% <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['agent_annual_percentage'];?> (<?php echo self::$language['mall_pay'];?>)</span><span class=value><input type="text" class="agent_annual_percentage" value="<?php echo $module['config']['agent_annual_percentage']?>" style=" text-align:right; padding-right:5px;" />% <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['receipt_time_limit'];?></span><span class=value><input type="text" class="receipt_time_limit" value="<?php echo $module['config']['receipt_time_limit']?>" /><?php echo self::$language['days'];?> <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['refund_time_limit'];?></span><span class=value><input type="text" class="refund_time_limit" value="<?php echo $module['config']['refund_time_limit']?>" /><?php echo self::$language['days'];?> <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['comment_time_limit'];?></span><span class=value><input type="text" class="comment_time_limit" value="<?php echo $module['config']['comment_time_limit']?>" /><?php echo self::$language['days'];?> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['show_sold'];?></span><span class=value><select class="show_sold" monxin_value="<?php echo $module['config']['show_sold']?>" ><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['show_comment'];?></span><span class=value><select class="show_comment" monxin_value="<?php echo $module['config']['show_comment']?>" ><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
       
        <div class=line><span class=m_label><?php echo self::$language['comment_check'];?></span><span class=value><select class="comment_check" monxin_value="<?php echo $module['config']['comment_check']?>" ><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['goods_check'];?></span><span class=value><select class="goods_check" monxin_value="<?php echo $module['config']['goods_check']?>" ><option value="0"><?php echo self::$language['yes'];?></option><option value="1"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['phone_goods_list_show_buy_button'];?></span><span class=value><select class="phone_goods_list_show_buy_button" monxin_value="<?php echo $module['config']['phone_goods_list_show_buy_button']?>" ><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['unlogin_buy'];?></span><span class=value><select class="unlogin_buy" monxin_value="<?php echo $module['config']['unlogin_buy']?>" ><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['agency'];?></span><span class=value><select class="agency" monxin_value="<?php echo $module['config']['agency']?>" ><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['distribution'];?></span><span class=value><select class="distribution" monxin_value="<?php echo $module['config']['distribution']?>" ><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['online_forbid_show'];?></span><span class=value><select class="online_forbid_show" monxin_value="<?php echo $module['config']['online_forbid_show']?>" ><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['shop_master'];?><?php echo self::$language['sms_fees'];?></span><span class=value><input type="text" class="sms_fees" value="<?php echo $module['config']['sms_fees']?>" style=" text-align:right; padding-right:5px;" /><?php echo self::$language['yuan'];?> <span class=state></span></span></div>
		
		
		<div class=line><span class=m_label><?php echo self::$language['mall_master_email'];?></span><span class=value><input type="text" class="mall_master_email" value="<?php echo $module['config']['mall_master_email']?>" /> <span class=state></span></span></div>
		
		
		<div class=line><span class=m_label><?php echo self::$language['mall_master_phone'];?></span><span class=value><input type="text" class="mall_master_phone" value="<?php echo $module['config']['mall_master_phone']?>" /> <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['hot_search'];?></span><span class=value><input type="text" class="hot_search" value="<?php echo $module['config']['hot_search']?>" /> <span class=state></span></span></div>	
		
		<div class=line><span class=m_label><?php echo self::$language['search_placeholder'];?></span><span class=value><input type="text" class="search_placeholder" value="<?php echo $module['config']['search_placeholder']?>" /> <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['search_placeholder_url'];?></span><span class=value><input type="text" class="search_placeholder_url" value="<?php echo $module['config']['search_placeholder_url']?>" /> <span class=state></span></span></div>
		
		
		<div class=line><span class=m_label><?php echo self::$language['give_credits'];?></span><span class=value><input type="text" class="give_credits" value="<?php echo $module['config']['give_credits']?>"  style="text-align:left;" /> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['near_default'];?></span><span class=value><select class="near_default" monxin_value="<?php echo $module['config']['near_default']?>" ><?php echo $module['near_option']?></select> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['show_type_deep'];?></span><span class=value><select class="show_type_deep" monxin_value="<?php echo $module['config']['show_type_deep']?>" ><option value="2"><?php echo self::$language['class_2']?></option><option value="3"><?php echo self::$language['class_3']?></option></select> <span class=state></span></span></div>
		
    </div>

</div>
