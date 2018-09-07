<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$('#banner_ele').insertBefore($('#banner_state'));
		
		$("#<?php echo $module['module_name'];?> .type").change(function(){
			if($(this).val()==''){
				$("#<?php echo $module['module_name'];?> #type_data").css('height',0).attr('src','');	
			}else{
				$("#<?php echo $module['module_name'];?> #type_data").attr('src','./scanpay_type/'+$(this).val()+'/config_panel.php');	
				
			}	
		});
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			if($("#<?php echo $module['module_name'];?> #banner").val()==''){
				$("#<?php echo $module['module_name'];?> #banner_state").html('<span class=fail><?php echo self::$language['please_upload']?></span>');
				return false;
			}
			if($("#<?php echo $module['module_name'];?> .name").val()==''){
				$("#<?php echo $module['module_name'];?> .name").next('.state').html('<span class=fail><?php echo self::$language['please_input']?></span>');
				$("#<?php echo $module['module_name'];?> .name").focus();
				return false;
			}
			if($("#<?php echo $module['module_name'];?> .type").val()==''){
				$("#<?php echo $module['module_name'];?> .type").next('.state').html('<span class=fail><?php echo self::$language['please_select']?></span>');
				$("#<?php echo $module['module_name'];?> .type").focus();
				return false;
			}
			if(!$("#type_data")[0].contentWindow.check_config_content()){
				return false;	
			}else{
				data=$("#type_data")[0].contentWindow.assemble_data();
			}
			obj=new Object();
			obj['banner']=$("#<?php echo $module['module_name'];?> #banner").val();
			obj['name']=$("#<?php echo $module['module_name'];?> .name").val();
			obj['operator']=$("#<?php echo $module['module_name'];?> .operator").val();
			obj['type']=$("#<?php echo $module['module_name'];?> .type").val();
			obj['data']=data;
			$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> .submit").css('display','none');
					$("#<?php echo $module['module_name'];?> .submit").next().html(v.info+'<a href="./index.php?monxin=scanpay.pay&id='+v.data_id+'" class=view><?php echo self::$language['view']?></a>');
				}else{
					if(v.id){$("#<?php echo $module['module_name'];?> ."+v.id).next('.state').html(v.info);}	
				}
			});
			
			return false;	
		});
		
    });
    function set_type_data_height(v){
		$("#<?php echo $module['module_name'];?> #type_data").css('height',v);
	}
	function return_exits_data(){
		//data='{"appid":"11111","key":"kkkkkkkkkkkkk"}';
		data='';
		if(data!=''){return eval('('+data+')');}else{return '';}
	}
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
	
	#<?php echo $module['module_name'];?> .line{ line-height:3rem;}
	#<?php echo $module['module_name'];?> .line .m_label{ display: inline-block; vertical-align:top; width:18%; padding-right:5px; text-align:right;}
	#<?php echo $module['module_name'];?> .line .m_input{  display: inline-block; vertical-align:top; width:80%;}
	
	#<?php echo $module['module_name'];?> .line .m_input input{ width:65%;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class=line><span class=m_label><?php echo self::$language['account_banner']?>:</span><span class=m_input><span class=state id=banner_state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['account_name']?>:</span><span class=m_input><input type=text class=name  placeholder="<?php echo self::$language['account_name_placeholder']?>" /> <span class=state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['account_operator']?>:</span><span class=m_input><input type=text class=operator  placeholder="<?php echo self::$language['account_operator_placeholder']?>" /> <span class=state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['account_type']?>:</span><span class=m_input><select class=type ><?php echo $module['type_option'];?></select> <span class=state></span></span></div>
        
        <div class=line><iframe id=type_data  width="100%"  scrolling="no" frameborder="no"></iframe></div>
        
        <div class=line><span class=m_label>&nbsp;</span><span class=m_input><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state id=state></span></span></div>
    </div>
</div>

