<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
	var is_null=false;
    $(document).ready(function(){
		$('#phones_ele').insertBefore($('#phones_state'));
		$("#<?php echo $module['module_name'];?> [type='radio']").click(function(){
			$("#<?php echo $module['module_name'];?> .source_div > div").css('display','none');
			$("#<?php echo $module['module_name'];?> ."+$(this).attr('id')).css('display','block');
		});		    
        $("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			var obj=new Object();
		 	
			if($("#<?php echo $module['module_name'];?> .source_div .prefix_div").css('display')=='block'){
				$("#<?php echo $module['module_name'];?> .prefix_div input").each(function(index, element) {
					if($(this).val()=='' && $(this).attr('class')!='email' && $(this).attr('class')!='chip' && $(this).attr('class')!='introducer'){
						$(this).next().html('<span class=fail><?php echo self::$language['is_null']?></span>');	
						is_null=true;
						return false;
					}
				});
				if(is_null){return false;}
				obj['source']='diy';
			}else{
				if($("#<?php echo $module['module_name'];?> #phones").val()==''){
					$("#<?php echo $module['module_name'];?> .phones_div").css('display','block');
					$("#<?php echo $module['module_name'];?> #phones_ele").next().html('<span class=fail><?php echo self::$language['is_null']?></span>');
					return false;	
				}
				obj['source']='phones';
				obj['phones']=$("#<?php echo $module['module_name'];?> #phones").val();
			}
			
			$("#<?php echo $module['module_name'];?> .other input").each(function(index, element) {
                if($(this).val()=='' && $(this).attr('class')!='email' && $(this).attr('class')!='chip' && $(this).attr('class')!='introducer'){
					$(this).next().html('<span class=fail><?php echo self::$language['is_null']?></span>');	
					is_null=true;
					return false;
				}
            });
			
			if(is_null){return false;}
			
			
			
			
			
			
			
			
		 	$("#<?php echo $module['module_name'];?>  input").each(function(index, element) {
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
					$("#<?php echo $module['module_name'];?> .submit").next().html(v.info+' <a href=./index.php?monxin=mall.create_card_list><?php echo self::$language['view']?></a>');
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
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align:top; width:26%; overflow:hidden; text-align:right; padding-right:1%;}
	#<?php echo $module['module_name'];?>_html .line .input{ display:inline-block; vertical-align:top; width:70%; overflow:hidden; }
	#<?php echo $module['module_name'];?>_html .line .input input{}
	.prefix_div{ display:none;}
	.phones_div{ display:none;}
	.create_card_list{ padding:0.5rem;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    	<div style="text-align:right"><a href=./index.php?monxin=mall.create_card_list user_color="button" class=create_card_list><?php echo self::$language['pages']['mall.create_card_list']['name']?></a></div>
    	<div class=line><span class=m_label><?php echo self::$language['username_source']?></span><span class=input> <input type="radio" value=prefix_div id=prefix_div name=source><?php echo self::$language['diy_prefix']?> &nbsp; &nbsp; <input type="radio" id=phones_div value="phones_div" name=source><?php echo self::$language['upload_phones']?>  <span class=state></span></span></div>
        
        <div class=source_div>
        	<div class=prefix_div>
    			<div class="line"><span class=m_label><?php echo self::$language['username']?><?php echo self::$language['diy_prefix']?></span><span class=input> <input type="text" class=username placeholder="<?php echo self::$language['diy_prefix_placeholder']?>"> <span class=state></span></span></div>
    			<div class="line"><span class=m_label><?php echo self::$language['quantity']?></span><span class=input> <input type="text" class=quantity placeholder="<?php echo self::$language['quantity']?>"> <span class=state></span></span></div>
            </div>
    		<div class="line phones_div"><span class=m_label><?php echo self::$language['upload_phones']?></span><span class=input>  <span class=state id=phones_state></span></span></div>
        </div>
        <div class=other>
    	<div class=line><span class=m_label><?php echo self::$language['default']?><?php echo self::$language['balance']?></span><span class=input> <input type="text" class=balance  /> <span class=state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['diy_chip_start']?></span><span class=input> <input type="text" class=diy_chip_start   /> <span class=state></span></span></div>
        
    	<div class=line><span class=m_label>&nbsp;</span><span class=input> <a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    
    
    </div>
</div>

