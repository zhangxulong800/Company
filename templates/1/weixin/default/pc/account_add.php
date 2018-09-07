<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$('#qr_code_ele').insertBefore($('#qr_code_state'));
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");		
		$("#<?php echo $module['module_name'];?>_html .state").html('');
        top_ajax_form('monxin_form','submit_state','show_result');
        return false;
        }
        
    
    function show_result(){
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		
		$("#<?php echo $module['module_name'];?> #submit_state").html(json.info);
        if(json.state=='fail'){
			if(json.id){
				$("#<?php echo $module['module_name'];?> #submit_state").html('<?php echo self::$language['fail'];?>');
				$("#"+json.id+'_state').html(json.info);
			}
			$("#<?php echo $module['module_name'];?> #submit_state").css("display","inline-block");
		}else{
			$("#<?php echo $module['module_name'];?> #submit").css('display','none');
			$("#<?php echo $module['module_name'];?> #submit_state").html(json.info+'<a href=./index.php?monxin=weixin.account_list class=return_button><span class=b_start></span><span class=b_middle><?php echo self::$language['return'];?></a>');	
		}
        
            
    }
	
    function set_area(id,v){
        $("#"+id).prop('value',v);
    }
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
    #<?php echo $module['module_name'];?>_html #keyword{ width:800px;}
    #<?php echo $module['module_name'];?>_html #qr_code_file{ border:none;}
 	#<?php echo $module['module_name'];?>_html .line_div{ line-height:50px;}
 	#<?php echo $module['module_name'];?>_html .m_label{ display:inline-block; width:120px; text-align:right; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .m_label .required{ }
	#replace_div{ display:none; vertical-align:top;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    <div class=line_div><span class=m_label><span class=required>*</span><?php echo self::$language['weixin'];?><?php echo self::$language['qr_code'];?></span><span class=input><span id=qr_code_state class=state></span></span></div>
    <div class=line_div><span class=m_label><span class=required>*</span><?php echo self::$language['weixin_name'];?></span><span class=input><input type="text" name="name" id="name"><span id=name_state class=state></span></span></div>
    <div class=line_div><span class=m_label><span class=required>*</span><?php echo self::$language['weixin_account'];?></span><span class=input><input type="text" name="account" id="account"><span id=account_state class=state></span></span></div>
    <div class=line_div><span class=m_label><span class=required>*</span><?php echo self::$language['weixin_id'];?></span><span class=input><input type="text" name="wid" id="wid"><span id=wid_state class=state></span></span></div>
    <div class=line_div><span class=m_label><span class=required>*</span>token</span><span class=input><input type="text" name="token" id="token"><span id=token_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['AppId'];?></span><span class=input><input type="text" name="AppId" id="AppId"><span id=AppId_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['AppSecret'];?></span><span class=input><input type="text" name="AppSecret" id="AppSecret"><span id=AppSecret_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['area'];?></span><span class=input>
     <input type="hidden" id="area" name="area" />
    <script src="area_js.php?callback=set_area&input_id=area&id=0&output=select&level=4" id='area_area_js'></script>
    <span id=area_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['keyword'];?></span><span class=input><input type="text" name="keyword" id="keyword"><span id=keyword_state  class=state></span></span></div>
   
    
    
    <div class=line_div><span class=m_label>&nbsp;</span><span class=input><input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span></span></div>
    
      
    </form>
    
    </div>
</div>

