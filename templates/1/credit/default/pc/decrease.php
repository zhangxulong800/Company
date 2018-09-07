<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
	var is_null=false;
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			is_null=false;
			$("#<?php echo $module['module_name'];?> .line input").each(function(index, element) {
                if($(this).val()==''){$(this).focus();$(this).next().html('<span class=fail><?php echo self::$language['please_input'];?></span>');is_null=true;return false;}
            });
			if(is_null){return false;}
			money=$("#<?php echo $module['module_name'];?> .money").val();
			if(money=='' || !$.isNumeric(money)  || money==0){
				$("#<?php echo $module['module_name'];?> .money").val('');
				$("#<?php echo $module['module_name'];?> .money").focus();
				return false;	
			}
			
			
			var obj=new Object();
			obj['money']=money;
			obj['username']=$("#<?php echo $module['module_name'];?> .username").val();
			obj['reason']=$("#<?php echo $module['module_name'];?> .reason").val();
			$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				if(v.state=='success'){
					parent.re_set_credit(v.id,v.value);
				}
				$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				
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
    	<div class=line><span class=m_label><?php echo self::$language['username']?></span><span class=input><input type="text" class=username value="<?php echo $module['username']?>" /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['decrease']?><?php echo self::$language['amount']?></span><span class=input> <input type="text" class=money value=""  /> <span class=state></span></span></div>        
    	<div class=line><span class=m_label><?php echo self::$language['decrease']?><?php echo self::$language['reason']?></span><span class=input> <input type="text" class=reason value=""  /> <span class=state></span></span></div>        
    	<div class=line><span class=m_label>&nbsp;</span><span class=input> <a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    
    
    </div>
</div>

