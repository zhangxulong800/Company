<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script src="./plugin/datePicker/index.php"></script>

   <script>
	function check_recharge_state(){
		if($("#<?php echo $module['module_name'];?> #money").val()==''){return false;}
		$.post('<?php echo $module['action_url'];?>&act=check_state', function(data){
			try{v=eval("("+data+")");}catch(exception){alert(data);}				
			if(v.state=='fail'){
				
			}else{
				window.location.href='./index.php?monxin=index.credits_log';
			}
		});
	
	}
	
	function update_credits_to_money(){
		v=parseFloat($("#<?php echo $module['module_name'];?>_html .credits").val())*<?php echo $module['rate']?>;
		v=v.toFixed(2);
		$("#<?php echo $module['module_name'];?> .money").html(v);
		$("#<?php echo $module['module_name'];?> .money").attr('money',v);
		$("#<?php echo $module['module_name'];?> .money").html('<?php echo self::$language['money_symbol']?>'+$("#<?php echo $module['module_name'];?> .money").html()+'<?php echo self::$language['yuan']?>');
	}
	
    $(document).ready(function(){
		
		setInterval('check_recharge_state()',1000); 
		
		$("#<?php echo $module['module_name'];?>_html .credits").keyup(function(){
			update_credits_to_money();
		});
		update_credits_to_money();
		
        $(".payment").click(function(){		
			if(!$.isNumeric($("#<?php echo $module['module_name'];?> .money").attr('money'))){
				$("#<?php echo $module['module_name'];?> .credits").focus();$(".credits_state").html('<?php echo self::$language['please_input'];?>');return false;
			}
			if($("#<?php echo $module['module_name'];?> .money").attr('money')<0){
				$("#<?php echo $module['module_name'];?> .credits").focus();$(".credits_state").html('<?php echo self::$language['please_input'];?>');return false;
			}
            json="{'money':'"+$("#<?php echo $module['module_name'];?> .money").attr('money')+"','payment':'"+$(this).attr('payment')+"','return_url':'<?php echo @$_GET['return_url'];?>','notify_url':'<?php echo @$_GET['notify_url'];?>','credits':'"+$("#<?php echo $module['module_name'];?> .credits").val()+"'}";
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
	#<?php echo $module['module_name'];?> .portlet-title{}
    #<?php echo $module['module_name'];?>_html{ padding-top:10px; }
    #<?php echo $module['module_name'];?>_html .line{ line-height:3rem;}
    #<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top;overflow:hidden;  padding-right:5px;}
    #<?php echo $module['module_name'];?>_html .line .m_input{ display:inline-block; vertical-align:top; overflow:hidden;}
	
	#<?php echo $module['module_name'];?>_html .money{}
	
    #<?php echo $module['module_name'];?>_html .online_div{}
	#<?php echo $module['module_name'];?>_html .payment{ display:block; line-height:3rem;border-bottom:rgba(236,236,236,1) solid 1px;}
	#<?php echo $module['module_name'];?>_html .payment img{ padding-right:3px; height:25px;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
		
        <div class=line><span class=m_label><?php echo self::$language['recharge']?><?php echo self::$language['credits']?></span><span class=m_input><input type=text class=credits value="<?php echo @$_GET['money']?>" /> <span id=credits_state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['amount_required']?></span><span class=m_input><span class=money></span></span></div>
		
        <div class="portlet-title"><div class="caption"><?php echo self::$language['please_select'];?><?php echo self::$language['pay_method_str'];?></div></div>
   		<div id=online_div><?php echo $module['online']?></div>
     	<div style="height:110px;">  </div>
    
    </div>
</div>

