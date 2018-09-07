<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language'];?>&items=emoticons|image|multiimage|media|insertfile"></script>
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #type").val('<?php echo @$_GET['type'];?>');
		
		$("#<?php echo $module['module_name'];?> #authcode").focus(function(){
			if(!$("#<?php echo $module['module_name'];?> #authcode_img").attr('src')){
				$("#<?php echo $module['module_name'];?> #authcode_img").attr('src',$("#<?php echo $module['module_name'];?> #authcode_img").attr('wsrc'));	
			}
		});
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        var title=$("#<?php echo $module['module_name'];?> #title");
        var authcode=$("#<?php echo $module['module_name'];?> #authcode");
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content");
        if(title.prop('value')==''){alert('<?php echo self::$language['please_input']?><?php echo self::$language['title']?>');title.focus();return false;}
        if(authcode.prop('value')==''){alert('<?php echo self::$language['please_input']?><?php echo self::$language['authcode']?>');authcode.focus();return false;}
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");		
        top_ajax_form('monxin_form','submit_state','show_result');
        return false;
        }
        
    
    function show_result(){
        $("#<?php echo $module['module_name'];?> #submit_state").css("display","none");
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        //alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		

        if(json.state=='fail'){$("#<?php echo $module['module_name'];?> #submit_state").html(json.info);$("#<?php echo $module['module_name'];?> #submit_state").css("display","inline-block");}
        
            
    }
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
	#<?php echo $module['module_name'];?> .input_div{ line-height:50px;} 
	#<?php echo $module['module_name'];?> .input_div .m_label{ display:inline-block; width:100px; padding-right:5px; text-align:right; vertical-align:top;} 
	#<?php echo $module['module_name'];?> .input_div .input_span{ display:inline-block;} 
	#<?php echo $module['module_name'];?> .input_div #key{ width:600px;} 
    #<?php echo $module['module_name'];?> #title{ width:650px;}
    #<?php echo $module['module_name'];?> #content{}
	#<?php echo $module['module_name'];?> #email{ height:13px;} 
	#<?php echo $module['module_name'];?> #advanced_options_div_state{ height:18px;}
	#<?php echo $module['module_name'];?> #submit{ line-height:2rem; height:2rem;}
	#<?php echo $module['module_name'];?> #advanced_options_div{ padding:0px; margin:0px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    
            <div class=jc_div style="margin-left:90px;">
				<script>
				function set_copy_value(v){
					$("#<?php echo $module['module_name'];?> #title").val(v.title);
					editor.html(v.content);
				}
				
                $(document).ready(function(){
					
					$(".fast_move .fast_move_switch").click(function(){
						//alert($(".fast_move").parent().width());
						if($(".fast_move").width()<150){
							$(".fast_move").animate({width:500,height:180},'fast');
							$(".fast_move").css('background-color','#CCC');
						}else{
							$(".fast_move").animate({width:150,height:50},'fast',function(){$(".fast_move").css('background','none');});
							
						}
						return false;
					});
					
					$(".fast_move .agreement").click(function(){
						if($(".fast_move .move_url").val()==''){
							$(".fast_move .state").html('<span class=fail><?php echo self::$language['please_input']?></span>');
							$(".fast_move .move_url").focus();
							return false;	
						}
						$(".fast_move .state").html('<span class=\'fa fa-spinner fa-spin\'> </span>');
						$.post("<?php echo $module['action_url'];?>&act=fast_move",{move_url:$(".fast_move .move_url").val(),content_reg:$(".fast_move .content_reg").val()},function(data){
							try{v=eval("("+data+")");}catch(exception){alert(data);}
							$(".fast_move .state").html(v.info);
							if(v.state=='success'){
								$(".fast_move").animate({width:150,height:30},'fast',function(){$(".fast_move").css('background','none');});
								set_copy_value(v);
							}
							
						});	
								
						return false;	
					});
                });
                </script>            
				<style>
                .fast_move{  text-align:left; width:150px; height:50px; line-height:30px; overflow:hidden; padding:10px;}
                .fast_move .fast_move_switch{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>  !important;  height:30px; line-height:30px;  display:inline-block; border-radius:0px; padding-left:10px; padding-right:10px;}
                .fast_move .fast_move_detail{ text-align:left; padding-top:10px; white-space:nowrap;}
                .fast_move .fast_move_detail .agreement_t{ font-weight:bold; text-align:center;}
                .fast_move .fast_move_detail .agreement_c{ white-space:normal;}
                .fast_move .fast_move_detail .move_url{ width:45%!important;}
                .fast_move .fast_move_detail .content_reg{ width:25%!important;}
                .fast_move .fast_move_detail .agreement{ height:30px; line-height:30px;  display:inline-block; border-radius:0px; padding-left:10px; padding-right:10px;}
                </style>
                <div class=fast_move>
                    <a href=# class=fast_move_switch><?php echo self::$language['fast_copy']?></a>
                    <div class=fast_move_detail>
                        <div class=agreement_t><?php echo self::$language['use_agreement']?></div>
                        <div class=agreement_c><?php echo self::$language['agreement_content']?></div>
                        <input type="text" class=move_url placeholder="<?php echo self::$language['move_url_placeholder']?>" />
                        <input type="text" class=content_reg placeholder="<?php echo self::$language['content_reg']?>" />
                        <a href=# class=agreement><?php echo self::$language['consent_agreement']?></a> <span class=state></span>
                        
                    </div>
                </div>
                
            
            
            
            
            </div>
    
    
      <div class="input_div"><span class=m_label><span class="m_label_start">&nbsp;</span><span class="m_label_middle"><span class=require>*</span><?php echo self::$language['title'];?></span><span class="m_label_end">&nbsp;</span></span><span class=input_span><input type="text" name="title" id="title"/></span></div>
      <div class="input_div"><span class=m_label><span class="m_label_start">&nbsp;</span><span class="m_label_middle"><?php echo self::$language['content'];?></span><span class="m_label_end">&nbsp;</span></span><span class=input_span><textarea name="content" id="content" style="display:none; width:400px; height:300px;"></textarea></span></div>
      <div class="input_div"><span class=m_label>&nbsp;</span><span class=input_span><input type="checkbox" id="email" name="email" /><?php echo self::$language['when_replies_or_comments_remind_me'];?></span></div>
      <div class="input_div" ><span class=m_label>&nbsp;</span><span class=input_span><div><a href=# class="advanced_options"><?php echo self::$language['advanced_options'];?><span id=advanced_options_div_state class=show> </span></a></div><div id=advanced_options_div>key: <input type="text" name="key" id="key" /></div></span></div>
      <div class="input_div"><span class=m_label><span class="m_label_start">&nbsp;</span><span class="m_label_middle"><span class=require>*</span><?php echo self::$language['authcode'];?></span><span class="m_label_end">&nbsp;</span></span><span class=input_span><input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" /> <a href="#" onclick="return change_authcode();" title="<?php echo self::$language['click_change_authcode']?>"><img id="authcode_img" wsrc="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a></span></div>

	  <div class="input_div"><span class=m_label>&nbsp;</span><span class=input_span><input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span></span></div>
    
    
      
    </form>
    
    </div>
</div>

