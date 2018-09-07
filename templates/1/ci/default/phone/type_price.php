<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$(this).next().html('');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>',{price:$("#<?php echo $module['module_name'];?> .price").val(),junit:$("#<?php echo $module['module_name'];?> .unit").val()}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				
            });
			return false;	
		});
    });
    
    
    </script>
    
    <style>
	.page-footer,.fixed_right_div{ display:none;}
    #<?php echo $module['module_name'];?>_html{ padding:20px; padding-top:100px;}
    #<?php echo $module['module_name'];?>_html .line{ line-height:60px;}
    #<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; text-align:right; padding-right:10px;  width:30%; overflow:hidden; }
    #<?php echo $module['module_name'];?>_html .line .input_span{ display:inline-block; vertical-align:top;width:65%; overflow:hidden; }
	
	#<?php echo $module['module_name'];?>_html .price{ width:50%;}
	#<?php echo $module['module_name'];?>_html .unit{ width:44%;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=line><span class=m_label><?php echo self::$language['type_price'];?></span><span class=input_span><input type=text class=price value="<?php echo $module['price'];?>" placeholder="0-100,100-500,500-1000,1000以上" /> </span></div>
    	<div class=line><span class=m_label><?php echo self::$language['price_unit'];?></span><span class=input_span><input type=text class=unit value="<?php echo $module['unit'];?>" placeholder="<?php echo self::$language['optional'];?> <?php echo self::$language['example']?>㎡、㎞、㎏、件、个、盒" /> </span></div>
    	<div class=line><span class=m_label>&nbsp;</span><span class=input_span><a href=# class=submit><?php echo self::$language['submit']?></a> <span></span>  </span></div>
		  
    
    </div>
</div>

