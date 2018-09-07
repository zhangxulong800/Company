<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_html .submit").click(function(){
			var quantity=parseInt($("#quantity").val());
			if(quantity==0){$("#quantity").focus();return false;}
			$("#submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get("<?php echo $module['action_url'];?>&act=update&quantity="+quantity, function(data){
 				//monxin_alert("Data Loaded: " + data);
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#submit_state").html(v.info);
			});
			return false;	
		});
    });
    </script>
    <style>
	.fixed_right_div{ display:none;}
    #<?php echo $module['module_name'];?>_html{width:500px; height:100px; padding-top:10px; text-align:center;}
    #<?php echo $module['module_name'];?>_html #quantity{ padding-left:5px; width:100px; height:30px; line-height:30px;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    <input name=quantity id=quantity value="<?php echo $module['pagesize'];?>"> <a href=# class=submit><?php echo self::$language['submit'];?></a><span id=submit_state></span>
    </div>
</div>

