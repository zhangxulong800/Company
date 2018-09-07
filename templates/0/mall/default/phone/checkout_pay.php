<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			exe_checkout_pay();
			return false;	
        });
		$("#<?php echo $module['module_name'];?> .password").keydown(function(event){
			if(event.keyCode==13){exe_checkout_pay();}	
			  	
		});
    });
    
	function exe_checkout_pay(){
		$("#<?php echo $module['module_name'];?> .submit").next().html('');
		if($("#<?php echo $module['module_name'];?> .password").val()==''){$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['transaction_password']?></span>');return false;}
		
		$("#<?php echo $module['module_name'];?> .submit").next().html('');
		$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=loading>&nbsp;</span>');
		$.get('<?php echo $module['action_url'];?>&act=check_password',{id:'<?php echo @$_GET['id']?>',password:$("#<?php echo $module['module_name'];?> .password").val()}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> .submit,.password").css('display','none');
			}
		});
	}
	
    </script>
    <style>
	#mall_cart,#shop_search{ display:none;}
	#top_layout_out{ display:none;}
	#bottom_layout_out{ display:none;}
    #<?php echo $module['module_name'];?>_html{ text-align:center; padding-top:50px;}
    #<?php echo $module['module_name'];?>_html .logo_div img{ width:80%; border:none;}
	#<?php echo $module['module_name'];?>_html .line{ line-height:3rem;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; text-align:right; width:30%; padding-right:10px; }
	#<?php echo $module['module_name'];?>_html .line .value{ display:inline-block; vertical-align:top; text-align:left; width:65%;}
	</style>
	<div id="<?php echo $module['module_name'];?>_html">
		<div class=logo_div><a href="./index.php" target="_blank"><img src=./logo.png></a></div>
		<div class=line><span class=m_label><?php echo self::$language['username']?></span><span class="value"><?php echo $module['data']['username']?></span></div>
		<div class=line><span class=m_label><?php echo self::$language['money']?></span><span class="value"><?php echo $module['data']['money']?></span></div>
		<div class=line><span class=m_label><?php echo self::$language['transaction_password']?></span><span class="value"><input type="password" class=password /></span></div>
		<div class=line><span class=m_label>&nbsp;</span><span class="value"><a href="#" class=submit><?php echo self::$language['submit']?></a> <span class="state"></span></span></div>
        
    </div>

</div>
