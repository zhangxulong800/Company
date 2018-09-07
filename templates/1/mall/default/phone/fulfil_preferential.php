<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script src="./plugin/datePicker/index.php"></script>
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .out_fieldset").each(function(index, element) {
            f_id=$(this).attr('id');
			//alert($("#"+f_id+" .use_method").attr('monxin_value'));
			$("#"+f_id+" .join_goods").val($("#"+f_id+" .join_goods").attr('monxin_value'));
			$("#"+f_id+" .use_method").val($("#"+f_id+" .use_method").attr('monxin_value'));
			$("#"+f_id+" #use_method_"+$("#"+f_id+" .use_method").val()).css('display','block');
        });
		
		$("#<?php echo $module['module_name'];?> .use_method").change(function(){
			//alert($(this).parent().parent().parent().attr('id'));
			$("#<?php echo $module['module_name'];?> #"+$(this).parent().parent().parent().attr('id')+" fieldset").css('display','none');
			$("#"+$(this).parent().parent().parent().attr('id')+" #use_method_"+$(this).val()).css('display','block');
		});
		
		$("#<?php echo $module['module_name'];?> .submit,#<?php echo $module['module_name'];?> .add").click(function(){
			f_id=$(this).parent().parent().parent().attr('id');
			//alert(f_id);
			$("#"+f_id+" .state").html('');				
			if($("#"+f_id+" .start_time").val()==''){$("#"+f_id+" .start_time").focus().next('span').html('<span class=fail><?php echo self::$language['please_input']?></span>');return false;}
			if($("#"+f_id+" .end_time").val()==''){$("#"+f_id+" .end_time").focus().next('span').html('<span class=fail><?php echo self::$language['please_input']?></span>');return false;}
			if($("#"+f_id+" .min_money").val()==''){$("#"+f_id+" .min_money").focus().next('span').html('<span class=fail><?php echo self::$language['please_input']?></span>');return false;}
			if($("#"+f_id+" .use_method").val()==-1){$("#"+f_id+" .use_method").focus().next('span').html('<span class=fail><?php echo self::$language['please_select']?></span>');return false;}
			j_use_method=$("#"+f_id+" .use_method").val();
			
			if(j_use_method==0){
				if($("#"+f_id+" .discount").val()==''){$("#"+f_id+" .discount").focus().next('span').html('<span class=fail><?php echo self::$language['please_input']?></span>');return false;}
			}
			if(j_use_method==1){
				if($("#"+f_id+" .less_money").val()==''){$("#"+f_id+" .less_money").focus().next('span').html('<span class=fail><?php echo self::$language['please_input']?></span>');return false;}
				if(parseInt($("#"+f_id+" .less_money").val())>=parseInt($("#"+f_id+" .min_money").val())){$("#"+f_id+" .less_money").focus().next('span').html('<span class=fail><?php echo self::$language['must_be_less_than']?>'+$("#"+f_id+" .min_money").val()+'</span>');return false;}
				
				
			}
			
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			$.post('<?php echo $module['action_url'];?>&act=update', {id:f_id.replace(/f_/,''),min_money:$("#"+f_id+" .min_money").val(),start_time:$("#"+f_id+" .start_time").val(),end_time:$("#"+f_id+" .end_time").val(),use_method:$("#"+f_id+" .use_method").val(),join_goods:$("#"+f_id+" .join_goods").val(),discount:$("#"+f_id+" .discount").val(),less_money:$("#"+f_id+" .less_money").val()},function(data){
				//alert(data);	
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				if(v.id){
					$("#"+f_id+" ."+v.id).focus().next('span').html(v.info);
					$("#"+f_id+" #submit").next('span').html('<span class=fail><?php echo self::$language['fail'];?></span>');
				}else{
					$("#"+f_id+" #submit").next('span').html(v.info);
				}
				
			});	
			return false;
		});
	
    });
    
	
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#f_"+id+" .del").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				

                $("#f_"+id+" .del").next().html(v.info);
                if(v.state=='success'){
                $("#f_"+id).animate({opacity:0},"slow",function(){$("#f_"+id).css('display','none');});
                }
            });
        }
        return false; 	
        
    }
	
	
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .input_line{ line-height:50px;}
    #<?php echo $module['module_name'];?>_html .input_line .m_label{ display:inline-block; vertical-align:top; width:120px; text-align:right; padding-right:10px;}
    #<?php echo $module['module_name'];?>_html .input_line .input_span{ display:inline-block; vertical-align:top; }
	.out_fieldset{ display:inline-block; vertical-align:top; margin:10px; vertical-align:top;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title">
        	<div class="caption"><?php echo $module['name']?></div>
   		</div>
    <?php echo $module['data'];?>
    <fieldset id="f_new" class="out_fieldset"><legend><?php echo self::$language['full'];?><input type="text" class="min_money" value=""  /><?php echo self::$language['yuan'];?> <span class=state></span></legend>
    	<div class=input_line><span class=m_label><?php echo self::$language['join_goods'];?></span><span class=input_span><select class=join_goods ><option value="1"><?php echo self::$language['join_goods_admin'][1]?></option><option value="0"><?php echo self::$language['join_goods_admin'][0]?></option><option value="2"><?php echo self::$language['join_goods_admin'][2]?></option></select> <span class=state></span></span></div>
    	<div class=input_line><span class=m_label><?php echo self::$language['preferential_start_time'];?></span><span class=input_span><input type="text" id="start_time" class='start_time' onclick=show_datePicker(this.id,'date') onblur= hide_datePicker() value=""  /> <span class=state></span></span></div>
    	<div class=input_line><span class=m_label><?php echo self::$language['preferential_end_time'];?></span><span class=input_span><input type="text" id="end_time" class='end_time' onclick=show_datePicker(this.id,'date') onblur= hide_datePicker() value=""  /> <span class=state></span></span></div>
    	
    	<div class=input_line><span class=m_label><?php echo self::$language['use_method'];?></span><span class=input_span><select class=use_method ><option value="-1"><?php echo self::$language['please_select']?></option><?php echo $module['use_method_option'];?></select> <span class=state></span></span></div>
        <div class=input_line><span class=m_label>&nbsp;</span><span class=input_span id="use_method_div">
    		<fieldset id="use_method_0" style="display: none;"><legend><?php echo self::$language['use_method_option'][0]?></legend>
            <div class=input_line><span class=m_label style="width:60px;"><?php echo self::$language['discount_rate'];?></span><span class=input_span><input type="text" class='discount' value=""  style="width:100px;" /> <span class=state></span></span></div>
            </fieldset>
        
    		<fieldset id="use_method_1" style="display:none;"><legend><?php echo self::$language['use_method_option'][1]?></legend>
            <div class=input_line><span class=m_label style="width:60px;"><?php echo self::$language['decrease'];?></span><span class=input_span><input type="text" class='less_money' value=""  style="width:60px;" /><?php echo self::$language['yuan'];?> <span class=state></span></span></div>
            </fieldset>
        
        </span></div>
        
        <div class=input_line><span class=m_label>&nbsp;</span><span class=input_span>
        <a href="#" id=submit class="add"><?php echo self::$language['add'];?></a> <span class=state></span>
        </span></div>
        </fieldset>
        
    </div>

</div>
