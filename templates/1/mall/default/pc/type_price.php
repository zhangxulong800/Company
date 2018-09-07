<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$(this).next().html('');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>',{price:$("#<?php echo $module['module_name'];?> .price").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				
            });
			return false;	
		});
    });
    
    
    </script>
    
    <style>
	.fixed_right_div{ display:none;}
    #<?php echo $module['module_name'];?>_html{ padding:20px; padding-left:200px; padding-top:100px;padding-bottom:100px;}
	#<?php echo $module['module_name'];?>_html .price{ width:50%;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
		<?php echo self::$language['type_price'];?> <input type=text class=price value="<?php echo $module['price'];?>" placeholder="0-100,100-500,500-1000,1000以上" /> <a href=# class=submit><?php echo self::$language['submit']?></a> <span></span>   
    
    </div>
</div>

