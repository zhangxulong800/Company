<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .barcode").keyup(function(event){
            if(event.keyCode==13 && $(this).val()!=''){pay_submit();}
		});
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			pay_submit();
			return false;	
		});
		
		if("<?php echo @$_POST['money']?>"!=''){
			$("#<?php echo $module['module_name'];?> input").attr('disabled','disabled');
			$("#<?php echo $module['module_name'];?> .barcode").removeAttr('disabled');
			$("#<?php echo $module['module_name'];?> .barcode").focus();	
		}
		
		
    });
	
	function pay_submit(){
		$("#<?php echo $module['module_name'];?> .state").html('');
		if($("#<?php echo $module['module_name'];?> .money").val()==''){
			$("#<?php echo $module['module_name'];?> .money").next('.state').html('<span class=fail><?php echo self::$language['please_input']?></span>');
			$("#<?php echo $module['module_name'];?> .money").focus();
			return false;
		}
		if($("#<?php echo $module['module_name'];?> .barcode").val()==''){
			$("#<?php echo $module['module_name'];?> .barcode").next('.state').html('<span class=fail><?php echo self::$language['please_input']?></span>');
			$("#<?php echo $module['module_name'];?> .barcode").focus();
			return false;
		}
		obj=new Object();
		obj['money']=$("#<?php echo $module['module_name'];?> .money").val();
		obj['payer']=$("#<?php echo $module['module_name'];?> .payer").val();
		obj['reason']=$("#<?php echo $module['module_name'];?> .reason").val();
		obj['barcode']=$("#<?php echo $module['module_name'];?> .barcode").val();
		obj['success_fun']=$("#<?php echo $module['module_name'];?> .success_fun").val();
		$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.post('<?php echo $module['action_url'];?>&act=pay',obj, function(data){
			//alert(data);
			//$("#<?php echo $module['module_name'];?> .submit").next('.state').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			//$("#<?php echo $module['module_name'];?> #pay_form").submit();
			
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> .submit").css('display','none');
				window.location.href=v.url;
				
			}else{
				if(v.id){$("#<?php echo $module['module_name'];?> ."+v.id).next('.state').html(v.info);}	
			}
			
		});
	}
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?> .banner{ text-align:center;}
    #<?php echo $module['module_name'];?> .name{ text-align:center; font-family:"微软雅黑", "宋体"; font-size:20px; margin-top:-25px;}
	#<?php echo $module['module_name'];?> .name img{ height:2.4rem; padding-right:5px;}
	
	#<?php echo $module['module_name'];?> .line{ margin-top:15px; line-height:2rem;}
	#<?php echo $module['module_name'];?> .line .m_label{ display: inline-block; vertical-align:top; width:30%; padding-right:5px; text-align:right;}
	#<?php echo $module['module_name'];?> .line .m_input{  display: inline-block; vertical-align:top; width:68%;}
	
	#<?php echo $module['module_name'];?> .line .m_input input{ width:65%;}
	#<?php echo $module['module_name'];?> .banner_show{ height:9rem; }
	#<?php echo $module['module_name'];?> .submit { background:#009944; border-radius:2px; padding:5px 27px; line-height:20px; font-family:"微软雅黑", "宋体"; font-size:16px; }
	#<?php echo $module['module_name'];?> .submit:before{display:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class=banner><img class=banner_show src="./program/scanpay/banner/<?php echo $module['data']['banner']?>" /></div>
        <div class=name><img src=<?php echo get_template_dir(__FILE__);?>img/<?php echo $module['data']['type']?>.png /><?php echo $module['data']['name']?></div>
        <input type="hidden"  value="<?php echo @$_POST['success_fun'];?>" class="success_fun" />
        <div class=line><span class=m_label><?php echo self::$language['pay_money']?><?php echo self::$language['money']?>:</span><span class=m_input><input type=text class=money value="<?php echo @$_POST['money'];?>"  /> <span class=state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['pay_username']?>:</span><span class=m_input><input type=text class=payer  placeholder="<?php echo self::$language['optional']?>,<?php echo self::$language['username']?>" value="<?php echo @$_POST['payer'];?>"  /> <span class=state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['pay_reason']?>:</span><span class=m_input><input type=text class=reason  placeholder="<?php echo self::$language['optional']?>"  value="<?php echo @$_POST['reason'];?>"  /> <span class=state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['pay_barcode']?>:</span><span class=m_input><input type=text class=barcode  placeholder="<?php echo self::$language['pay_barcode_placeholder']?>"   /> <span class=state></span></span></div>
        
        <div class=line><span class=m_label>&nbsp;</span><span class=m_input><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state id=state></span></span></div>
    </div>
</div>

