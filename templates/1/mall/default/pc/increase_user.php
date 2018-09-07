<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
	var is_null=false;
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .username").blur(function(){
			if($("#<?php echo $module['module_name'];?> .username").val()!=''){
				$("#<?php echo $module['module_name'];?> .username").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.post('<?php echo $module['action_url'];?>&act=add_exist',{username: $("#<?php echo $module['module_name'];?> .username").val()}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> .line").css('display','none');
						$("#<?php echo $module['module_name'];?> .username").parent().parent().css('display','block');
						$("#<?php echo $module['module_name'];?> .username").next().html('<span class=success><?php echo self::$language['success']?></span> <a href=./index.php?monxin=mall.my_buyer&search='+$("#<?php echo $module['module_name'];?> .username").val()+'><?php echo self::$language['view']?></a>');
					}else{
						$("#<?php echo $module['module_name'];?> .username").next().html('');
					}
					
				});
			}
		});
		    
        $("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
		 	$("#<?php echo $module['module_name'];?> input").each(function(index, element) {
                if($(this).val()=='' && $(this).attr('class')!='email' && $(this).attr('class')!='chip' && $(this).attr('class')!='introducer' && $(this).attr('class')!='openid'){
					$(this).next().html('<span class=fail><?php echo self::$language['is_null']?></span>');	
					is_null=true;
					return false;
				}
            });
			if(is_null){return false;}
			
			var obj=new Object();
		 	$("#<?php echo $module['module_name'];?> input").each(function(index, element) {
				obj[$(this).attr('class')]=$(this).val();
            });
			
			$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				if(v.id){
					$("#<?php echo $module['module_name'];?> ."+v.id).next().html(v.info);
					$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=fail><?php echo self::$language['fail']?></span>');
				}else{
					$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				}
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> input").val('');
					$("#<?php echo $module['module_name'];?> .submit").next().html(v.info+' <a href=./index.php?monxin=mall.my_buyer&search='+$("#<?php echo $module['module_name'];?> .username").val()+'><?php echo self::$language['view']?></a>');
				}
				
			});
			return false;
        });
			
    });
    </script>
    

    
    
    
    
    <style>
    #<?php echo $module['module_name'];?> { }
    #<?php echo $module['module_name'];?>_html{ padding-top:20px;padding-bottom:20px;}
	#<?php echo $module['module_name'];?>_html .line{ line-height:50px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; width:16%; overflow:hidden; text-align:right; padding-right:1%;}
	#<?php echo $module['module_name'];?>_html .line .input{ display:inline-block; vertical-align:top; width:70%; overflow:hidden; }
	#<?php echo $module['module_name'];?>_html .line .input input{}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=line><span class=m_label><?php echo self::$language['username']?></span><span class=input> <input type="text" class=username placeholder="<?php echo self::$language['real_name']?>/<?php echo self::$language['phone']?>"> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['phone']?></span><span class=input> <input type="text" class=phone  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['email']?>(<?php echo self::$language['optional']?>)</span><span class=input> <input type="text" class=email  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['introducer']?>(<?php echo self::$language['optional']?>)</span><span class=input> <input type="text" class=introducer /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['login']?><?php echo self::$language['password']?></span><span class=input> <input type="text" class=password  value="<?php echo $module['random']?>" /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['transaction_password']?></span><span class=input> <input type="text" class=transaction_password  value="<?php echo $module['random']?>" /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['chip']?>(<?php echo self::$language['optional']?>)</span><span class=input> <input type="text" class=chip  /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['openid']?><?php echo self::$language['authcode']?>(<?php echo self::$language['optional']?>)</span><span class=input> <input type="text" class=openid  /> <span class=state></span>
        
        <?php echo $module['weixin_code'];?>
        </span></div>
        
    	<div class=line><span class=m_label>&nbsp;</span><span class=input> <a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    
    
    </div>
</div>

