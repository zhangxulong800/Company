<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #shop_type").val($("#<?php echo $module['module_name'];?> #shop_type").attr('monxin_value'));
		
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=submit',{shop_type:$("#<?php echo $module['module_name'];?>_html #shop_type").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
                if(v.state=='success'){
                	parent.update_shop_type(<?php echo $_GET['c_id']?>,v.html);
                }
            });
		});
		
    });
    
    </script>
    <style>
	.fixed_right_div,.page-footer,#mall_cart{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
    #<?php echo $module['module_name'];?>_html{ }
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
    
    <?php echo self::$language['belong']?><?php echo self::$language['store']?><?php echo self::$language['type']?><select id=shop_type name=shop_type monxin_value=<?php echo @$_GET['id']?> ><?php echo $module['type_option']?></select>  <a href=# class=submit><?php echo self::$language['submit'];?></a> <span></span>
    </div>

</div>
