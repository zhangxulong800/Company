<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		if(''!='<?php echo @$module['data']['level'];?>'){
			$("#<?php echo $module['module_name'];?> .level_div input[value='<?php echo @$module['data']['level'];?>']").prop('checked','checked');	
		}
		$("#<?php echo $module['module_name'];?> .level_div input").click(function(){
			$(this).parent().parent().prop('value',$(this).val());	
		});
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			if($("#<?php echo $module['module_name'];?> .level_div").prop('value')==''){
				alert('<?php echo self::$language['please_select']?> <?php echo self::$language['comment_option'][0]?>、<?php echo self::$language['comment_option'][1]?> <?php echo self::$language['or']?> <?php echo self::$language['comment_option'][2]?>');
				return false;	
			}
			if($("#<?php echo $module['module_name'];?> #content").val()==''){
				alert('<?php echo self::$language['please_input']?><?php echo self::$language['comment']?><?php echo self::$language['content']?>');
				return false;	
			}
			
			$(this).next().html('');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=comment',{level:$("#<?php echo $module['module_name'];?> .level_div").val(),content:$("#<?php echo $module['module_name'];?> #content").val()},function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
               $("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				if(v.state=='success'){
					parent.update_comment(<?php echo @$_GET['order_id']?>,<?php echo @$_GET['goods_id']?>,'<?php echo self::$language['a_moment_ago'];?>',$("#<?php echo $module['module_name'];?> #content").val());	
				}
            });
			return false;	
		});
		
		
    });
    
    </script>
    <style>
	.fixed_right_div,.page-footer,#mall_cart{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
	#<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{margin-left:50px; margin-top:30px; }
    #<?php echo $module['module_name'];?>_html .goods_title{ line-height:40px;}
    #<?php echo $module['module_name'];?>_html .level_div{ line-height:50px;}
    #<?php echo $module['module_name'];?>_html .level_div .option{ margin-right:20px;}
    #<?php echo $module['module_name'];?>_html .level_div .option input{ }
    #<?php echo $module['module_name'];?>_html .level_div .option .text{ display:inline-block; vertical-align:top;}
    #<?php echo $module['module_name'];?>_html #content{ width:600px; height:100px;}
    #<?php echo $module['module_name'];?>_html .submit_div{ margin-top:20px;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    	<div class=goods_title><?php echo $module['data']['title'];?></div>
		<div class=level_div value='<?php echo $module['data']['level'];?>'>
        	<span class=option><input type="radio" id=level_0 name=level value="0" /><m_label for=level_0 class=text><?php echo self::$language['comment_option'][0]?></m_label></span> 
        	<span class=option><input type="radio" id=level_1 name=level value="1" /><m_label for=level_1 class=text><?php echo self::$language['comment_option'][1]?></m_label></span> 
        	<span class=option><input type="radio" id=level_2 name=level value="2" /><m_label for=level_2 class=text><?php echo self::$language['comment_option'][2]?></m_label></span> 
        </div>
        <textarea id=content placeholder="<?php echo self::$language['comment_content_placeholder'];?>"><?php echo @$module['data']['content']?></textarea>
        <div class=submit_div><a href="#" class=submit><?php echo self::$language['submit'];?></a><span class=state></span></div>
		
        
    </div>

</div>
