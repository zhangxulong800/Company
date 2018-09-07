<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$(".p_close_button").click(function(){
			window.parent.close_monxin_iframe();
		});
		$('body').preventScroll();
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			is_null=false;
			$("#<?php echo $module['module_name'];?> input").each(function(index, element) {
                if($(this).val()=='' && $(this).attr('id')!='post_code' &&  $(this).attr('id')!='tag' && $(this).attr('id')!='area_id'){
					$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')).focus();
					$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')).next().html('<span class=fail><?php echo self::$language['is_null'];?></span>');	
					$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=fail><?php echo self::$language['fail'];?></span>');
					is_null=true;
					return false;
				}
            });
			if(is_null){return false;}
			$(this).css('display','none');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=edit',{name:$("#<?php echo $module['module_name'];?> #name").val(),phone:$("#<?php echo $module['module_name'];?> #phone").val(),area_id:$("#<?php echo $module['module_name'];?> #area_id").val(),detail:$("#<?php echo $module['module_name'];?> #detail").val(),post_code:$("#<?php echo $module['module_name'];?> #post_code").val(),tag:$("#<?php echo $module['module_name'];?> #tag").val(),authcode:$("#<?php echo $module['module_name'];?> #authcode").val()}, function(data){
				
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				if(v.id){
					$("#<?php echo $module['module_name'];?> #"+v.id).focus();
					$("#<?php echo $module['module_name'];?> #"+v.id).next().html(v.info);	
					$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=fail><?php echo self::$language['fail'];?></span>');
				}else{
					$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				}
				if(v.state=='success'){
					parent.close_select_window2();	
				}else{
					$("#<?php echo $module['module_name'];?> .submit").css('display','inline-block');
				}
				
			});
			
			return false;
		});
		$("#mall_cart").html('');
    });
  
	
	
    function set_area(id,v){
        $("#"+id).prop('value',v);
    }
	
    </script>
	<style>
	.fixed_right_div,.page-footer,#mall_cart{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
	#<?php echo $module['module_name'];?>{ margin:0px; overflow:scroll; font-size:0.9rem;}
    #<?php echo $module['module_name'];?>_html{ } 
    #<?php echo $module['module_name'];?>_html .line{ line-height:2.5rem;white-space:nowrap;} 
    #<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align: middle; width:25%; text-align:right;  box-shadow:none;} 
    #<?php echo $module['module_name'];?>_html .line .value{ display:inline-block; vertical-align:top; width:75%; white-space:normal; } 
    #<?php echo $module['module_name'];?>_html .line .value input{ width:80%;} 
    #<?php echo $module['module_name'];?>_html .line .value select{ max-width:80%;} 
    #<?php echo $module['module_name'];?>_html {} 
	
	.page-container{ padding-top:0px !important;}
	.p_caption{ display: inline-block;vertical-align: top; width:90%; text-align:center;overflow:hidden;}
	.p_close_button{ display: inline-block;vertical-align: top; width:10%; overflow:hidden;}
	.p_close_button:after {font: normal normal normal 1.8rem/1 FontAwesome;content: "\f104"; opacity: 0.6;overflow: hidden;line-height: 2rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
       <div class="portlet-title">
            <a class=p_close_button></a><div class="p_caption"><?php echo $module['monxin_table_name']?></div>
   	    </div>

    	<div class=line><span class=m_label><?php echo self::$language['receiver_name'];?>：</span><span class=value><input type="text" id=name value="<?php echo $module['data']['name'];?>" /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['phone'];?>：</span><span class=value><input type="text" id="phone" value="<?php echo $module['data']['phone'];?>" /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['belongs_area'];?>：</span><span class=value>
        <input type="hidden" id="area_id" name="area_id" value="<?php echo $module['data']['area_id'];?>" /><span class=state></span>
    <script src="area_js.php?callback=set_area&input_id=area_id&id=<?php echo $module['data']['area_id'];?>&output=select" id='area_id_area_js'></script>
       </span></div>
    	<div class=line><span class=m_label><?php echo self::$language['address_detail'];?>：</span><span class=value><input type="text" id=detail placeholder="<?php echo self::$language['address_detail_placeholder'];?>" value="<?php echo $module['data']['detail'];?>" /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['post_code'];?>：</span><span class=value><input type="text" id=post_code placeholder="<?php echo self::$language['optional'];?>" value="<?php echo $module['data']['post_code'];?>" /> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['tag'];?>：</span><span class=value><input type="text" id=tag maxlength="10" placeholder="<?php echo self::$language['optional'];?> <?php echo self::$language['adddress_tag_placeholder'];?>" value="<?php echo $module['data']['tag'];?>" /> <span class=state></span></span></div>
    	<div class=line><span class=m_label>&nbsp;</span><span class=value><a href="#" class=submit><?php echo self::$language['submit'];?></a> <span class=state></span></span></div>
        
    </div>
</div>
