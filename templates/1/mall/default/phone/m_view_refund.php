<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });    
    </script>
	<style>
    #<?php echo $module['module_name'];?>{ width:1000px; overflow:hidden;} 
	#<?php echo $module['module_name'];?> .line{ line-height:40px;}
	#<?php echo $module['module_name'];?> .line .m_label{ display:inline-block; vertical-align:top; width:20%; padding-right:10px; overflow:hidden; text-align:right;}
	#<?php echo $module['module_name'];?> .line .value{display:inline-block; vertical-align:top; width:75%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .line .value b{ }
	#<?php echo $module['module_name'];?> .refund_amount{ width:100px;}
	#<?php echo $module['module_name'];?> .refund_remark{ width:80%; height:100px;}
	#<?php echo $module['module_name'];?> required{  padding-right:5px;}
	#<?php echo $module['module_name'];?> .voucher_img{ width:200px; border:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        
       <div class=line><span class=m_label><?php echo self::$language['add_time'];?>：</span><span class=value><?php echo $module['add_time']?></span></div>
       
       <div class=line><span class=m_label><?php echo self::$language['send_time'];?>：</span><span class=value><?php echo $module['send_time']?></span></div>
       
       <div class=line><span class=m_label><?php echo self::$language['receipt_time'];?>：</span><span class=value><?php echo $module['receipt_time']?></span></div>
       
       <div class=line><span class=m_label><?php echo self::$language['reason'];?>：</span><span class=value><?php echo $module['refund_reason']?></span></div>
       
       <div class=line><span class=m_label><?php echo self::$language['refund_amount'];?>：</span><span class=value><b><?php echo $module['refund_amount']?></b> (<?php echo self::$language['actual_pay']?>：<b><?php echo $module['actual_money']?></b>,<?php echo self::$language['include_freight_costs']?>：<b><?php echo $module['express_cost']?></b>)</span></div>
       
       <div class=line><span class=m_label><?php echo self::$language['remark'];?>：</span><span class=value><?php echo $module['refund_remark'];?></span></div>
       
       <div class=line><span class=m_label><?php echo self::$language['voucher'];?>：</span><required> </required><span class=value><?php echo $module['refund_voucher'];?> <span id=voucher_state></span></span></div>
       <div class=line><span class=m_label><?php echo self::$language['view_logistics'];?>：</span><required> </required><span class=value><?php echo $module['express_voucher'];?> <span id=voucher_state></span></span></div>
       
        
    </div>
</div>