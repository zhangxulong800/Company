<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .quantity").blur(function(){
			$.get('<?php echo $module['action_url'];?>&act=update',{id:$(this).parent().attr('id').replace(/p_/,''),quantity:$(this).val()}, function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				monxin_alert(v.info);
			});
			
		});
		
		$("#<?php echo $module['module_name'];?> .p_group i b").click(function(){
			window.location.href=$(this).attr('href');
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(index, element){
			var id=$(this).parent().parent().parent().attr('id');
			var discount=$("#"+id+" .discount");
			if(discount.val()==''){discount.focus();$("#"+id+" .state").html('<span class=fail><?php echo self::$language['is_null'];?></span>');return false;}
			if(!$.isNumeric(discount.val())){discount.focus();$("#"+id+" .state").html('<span class=fail><?php echo self::$language['must_be'];?><?php echo self::$language['number'];?></span>');return false;}
			
			var ids='';
			$("#"+id+" .goods_div").each(function(index, element) {
				if($(this).attr('id')){ids+=','+$(this).attr('id').replace(/goods_div_/,'');}
			});       
			//alert(ids); 
			$("#"+id+" .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=update',{ids:ids,free_shipping:$("#"+id+" .free_shipping").val(),discount:discount.val(),id:id.replace(/public_stock_div_/,'')}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#"+id+" .state").html(v.info);
			});
				
		   return false; 
        });
		$("#<?php echo $module['module_name'];?> .del").click(function(index, element){
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
			var id=$(this).parent().parent().attr('id');
			$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=del',{id:id.replace(/p_/,'')}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#"+id+" .del").html(v.info);
                if(v.state=='success'){
                	$("#"+id).animate({opacity:0},"slow",function(){$("#"+id).css('display','none');});
                }
			});
			}
		   return false; 
        });
    });
    
    


    </script>
    <style>
    #<?php echo $module['module_name'];?>_html{}
	
	#<?php echo $module['module_name'];?> .p_group{ display:inline-block; vertical-align:top; width:100%; margin-right:1%; margin-bottom:10px;  height:200px; text-align:center; border:1px dashed #ccc; padding:10px; white-space:nowrap;}
	#<?php echo $module['module_name'];?> .p_group:hover{border-color:red;}
	#<?php echo $module['module_name'];?> .p_group:hover b{ display:inline;}
	#<?php echo $module['module_name'];?> .p_group img{ width:90%;}
	#<?php echo $module['module_name'];?> .p_group i{ display:block; font-style:normal; opacity:0.4; line-height:25px;}
	#<?php echo $module['module_name'];?> .p_group b{  font-weight:normal; background-color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; border-radius:3px; padding-left:3px; padding-right:3px;}
	#<?php echo $module['module_name'];?> .p_group b:hover{ opacity:0.5;}
	#<?php echo $module['module_name'];?> .p_group span{ display:block; width:100%; overflow:hidden;    text-overflow: ellipsis; font-size:0.8rem;}
	#<?php echo $module['module_name'];?> .p_group .stock_big{ display:inline-block; vertical-align:top; width:48%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .p_group .stock_big img{width:55%; }
	#<?php echo $module['module_name'];?> .p_group .equal{display:inline-block; vertical-align:top; margin-top:70px; width:10%; opacity:0.4;}
	#<?php echo $module['module_name'];?> .p_group .equal:before{font: normal normal normal 2rem/1 monxin; content:"\f00c";}
	#<?php echo $module['module_name'];?> .p_group .quantity{ display:inline-block; vertical-align:top;margin-top:70px; width:10%;}
	#<?php echo $module['module_name'];?> .p_group .stock_small{display:inline-block; vertical-align:top; width:28%;margin-top:25px; overflow:hidden;}
	#<?php echo $module['module_name'];?> .p_group .stock_small img{width:60%;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    	<?php echo $module['list'];?>
    	
       
       
       <?php echo $module['page'];?>
    </div>

</div>
