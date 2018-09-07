<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			url='<?php echo $module['action_url'];?>';
			$("#<?php echo $module['module_name'];?> .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post(url, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> .state").html(v.info);
				if(v.state=='success'){
					parent.update_state_8('<?php echo @$_GET['id'];?>');
					$("#<?php echo $module['module_name'];?> .submit").css('display','none');
					
				}
			});
				
			return false;
		});
    });    
    </script>
	<style>
	.fixed_right_div,.page-footer,#mall_cart,.cart_goods_sum{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
    #<?php echo $module['module_name'];?>{  text-align:center;} 
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<?php echo $module['express_voucher'];?>        
    </div>
</div>