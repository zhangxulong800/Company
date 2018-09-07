<div id=<?php echo $module['module_name'];?>  class="" monxin-module="<?php echo $module['module_name'];?>" align=left save_name="<?php echo $module['module_save_name'];?>"  >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language'];?>&items=emoticons|image|multiimage|media|insertfile"></script>
    <script>
    $(document).ready(function(){
		
		if(get_param('scroll')!=''){
			if($("#<?php echo $module['module_name'];?> #"+get_param('scroll')).attr('id')){$(window).scrollTop($("#<?php echo $module['module_name'];?> #"+get_param('scroll')).offset().top);}
			
		}
		
		$("#comment_input_div_close").click(function(){$("#comment_input_div").css('display','none');});
		
		$(document).on('click',".content_div .m_hide",function(){
			var id=$(this).attr('cid');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=hide',{cid:id}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);				
			});        	
			return false; 
		});
		$(document).on('click',".content_div .m_show",function(){
			var id=$(this).attr('cid');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=show',{cid:id}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);				
			});        	
			return false; 
		});
         $("#replay_input_div input").keyup(function(event){
            keycode=event.which;
            if(keycode==13){subimt_content();}	
        });
		 $("#comment_input_div input").keyup(function(event){
			keycode=event.which;
			if(keycode==13){submit_comment();}	
		});
		$(document).on('click',"#<?php echo $module['module_name'];?> .comment_button",function(){
			if(getCookie('monxin_nickname')==''){window.location.href='./index.php?index.login';}
				var position=$(this).offset();
				
				$("#<?php echo $module['module_name'];?> #comment_input_div").css('display','block').css('left',position.left+$(this).width()+5).css('top',position.top);
				if($("#<?php echo $module['module_name'];?> #comment_input_div").offset().top!=position.top){
					distance=position.top-$("#<?php echo $module['module_name'];?> #comment_input_div").offset().top;
					$("#<?php echo $module['module_name'];?> #comment_input_div").css('display','block').css('left',position.left+$(this).width()+5).css('top',position.top+distance);
				}
				$("#<?php echo $module['module_name'];?> #comment_input_div").attr('click_id',$(this).attr('click_id'));
				$("#<?php echo $module['module_name'];?> #comment_state").html('');
			
			
			return false;
		});
		
		
		$("#<?php echo $module['module_name'];?> .replay").click(function(){
			if(getCookie('monxin_nickname')==''){window.location.href='./index.php?index.login';}
			$(window).scrollTop($("#<?php echo $module['module_name'];?> #replay_input_div").offset().top);
			
		});
		
		$("#<?php echo $module['module_name'];?> #authcode").focus(function(){
			if(!$("#<?php echo $module['module_name'];?> #authcode_img").attr('src')){
				$("#<?php echo $module['module_name'];?> #authcode_img").attr('src',$("#<?php echo $module['module_name'];?> #authcode_img").attr('wsrc'));	
			}
		});
		
		$("#<?php echo $module['module_name'];?> #comment_auth").focus(function(){
			$("#<?php echo $module['module_name'];?> #comment_auth_img").attr('src',$("#<?php echo $module['module_name'];?> #comment_auth_img").attr('wsrc'));	
		});
		$.get("<?php echo $module['count_url']?>");
		setInterval("check_input_val()",1000);
		if(<?php echo $module['liveupdate']?>==1){
			setInterval("liveupdate()",2000);
		}
		
    });
    
	function liveupdate(){
		temp1=$("#<?php echo $module['module_name'];?> .content_div .content_div:last").attr('id');
		if(temp1){last_id=temp1.replace('content_','');}else{last_id=0;}
		$("#<?php echo $module['module_name'];?> .comment_div").each(function(index, element) {
            temp2=$(this).attr('id').replace('content_','');
			if(temp2>last_id){last_id=temp2;}
			
        });
        $.get('./receive.php?target=index::visitor_position&act=talk_content_new',{id:<?php echo $_GET['id']?>,type:<?php echo $module['type']?>,last_id:last_id}, function(data){
			//console.log(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			if(v.state=='success'){
				if(v.list!=''){
					$("#<?php echo $module['module_name'];?>_html > .content_div").append(v.list);
					$(window).scrollTop($("#<?php echo $module['module_name'];?>_html > .content_div").height()+$("#<?php echo $module['module_name'];?>_html > .content_div").offset().top-$(window).height()*0.5)
				}
				if(v.comemnt!=''){
					$("#<?php echo $module['module_name'];?> .temp_comment").html(v.comemnt);
					$("#<?php echo $module['module_name'];?> .temp_comment .comment_div").each(function(index, element) {
                        id=$(this).attr('for');
						$(this).appendTo($("#<?php echo $module['module_name'];?> #content_"+id+""));
					  });
					$("#<?php echo $module['module_name'];?> .temp_comment").html('');
				}
			}
        });
	}
	
	function check_input_val(){
		editor.sync();
		if($("#<?php echo $module['module_name'];?> #content").val()!='' &&　getCookie('monxin_nickname')=='')	{window.location.href='./index.php?index.login';}
	}
    
    function subimt_content(){
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content").val();
		if(content==''){$("#<?php echo $module['module_name'];?> #replay_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['content']?></span>');return false;}	
        var authcode=$("#<?php echo $module['module_name'];?> #authcode").val();
		if(authcode==''){$("#<?php echo $module['module_name'];?> #replay_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['authcode']?></span>');$("#<?php echo $module['module_name'];?> #authcode").focus();return false;}	
        var email=0;
		if($("#<?php echo $module['module_name'];?> #email").prop('checked')){email=1;}
        $("#<?php echo $module['module_name'];?> #replay_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=submit_content',{content:content,authcode:authcode,email:email}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #replay_state").html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> #replay_input_div .submit").css('display','none');
				window.location.href=$("#<?php echo $module['module_name'];?> #replay_state .view").attr('href');
			}
        });
        return false; 	
        
    }
	
    function submit_comment(){
		var for_id=$("#<?php echo $module['module_name'];?> #comment_input_div").attr('click_id');
        var comment_input=$("#<?php echo $module['module_name'];?> #comment_input").val();
		if(comment_input==''){$("#<?php echo $module['module_name'];?> #comment_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['content']?></span>');return false;}	
        var comment_auth=$("#<?php echo $module['module_name'];?> #comment_auth").val();
		if(comment_auth==''){$("#<?php echo $module['module_name'];?> #comment_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['authcode']?></span>');$("#<?php echo $module['module_name'];?> #comment_auth").focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #comment_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=submit_comment',{comment_input:comment_input,comment_auth:comment_auth,for_id:for_id,current_page:'<?php echo @$_GET['current_page'];?>'}, function(data){
           //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #comment_state").html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> #comment_input_div #comment_auth_img").attr('src',"./lib/authCode.class.php?save_name=comment_auth&r="+Math.random());
				$("#<?php echo $module['module_name'];?> #comment_input_div #comment_input").val('');
				$("#<?php echo $module['module_name'];?> #comment_input_div #comment_auth").val('');
				if(v.html){
					$(v.html).insertAfter("#<?php echo $module['module_name'];?> #content_"+for_id+" .content_content");
					$("#<?php echo $module['module_name'];?> #comment_input_div").css('display','none');
				}
				
			}
        });
        return false; 	
        
    }
	
    function del(id){
		$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('<?php echo $module['action_url'];?>&act=del',{cid:id}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
			if(v.state=='success'){
				$("#content_"+id).animate({opacity:0},"slow",function(){$("#content_"+id).css('display','none');});
			}
		});        	
        return false; 
    }

    </script>
	<style>
    #<?php echo $module['module_name'];?>{ padding:10px; margin-top:10px; background:none;}
    #<?php echo $module['module_name'];?>_html{ padding-bottom:20px;}
	#<?php echo $module['module_name'];?>_html #comment_auth_img{ height:27px;}
	#<?php echo $module['module_name'];?>_html #authcode_img{ height:27px;}
	#<?php echo $module['module_name'];?>_html #comment_input{ border:1px solid #ddd;}
	#<?php echo $module['module_name'];?>_html #comment_auth{ border:1px solid #ddd;}
	#<?php echo $module['module_name'];?>_html #authcode{box-shadow:1px 1px 3px 0px rgba(0,0,0,.1);}
	    
    #<?php echo $module['module_name'];?>_html .title_div{background:#fff; text-align:center; padding:1rem; padding-bottom:5px;}
	#<?php echo $module['module_name'];?>_html .title_div div{ display:inline-block;} 
	#<?php echo $module['module_name'];?>_html .title_div .username{ display:inline-block; margin-left:20px;}
	#<?php echo $module['module_name'];?>_html .title_div .time{ display:inline-block; margin-left:20px;}
    #<?php echo $module['module_name'];?>_html .title_div .username:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f007"; padding-right:2px;}
    #<?php echo $module['module_name'];?>_html .title_div .time:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f017";padding-right:2px;}
	
	#<?php echo $module['module_name'];?>_html .title_div .title{ display:inline-block;}
	#<?php echo $module['module_name'];?>_html .title_div .title:before{ display:block; font: normal normal normal 2rem/1 FontAwesome; content:"\f0d8";padding-right:2px;  padding-left:0.5rem; height:1.2rem;color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; display:none;}
	#<?php echo $module['module_name'];?>_html .title_div .title .v{   border-radius:0.4rem; border:1px dashed <?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>; border:none; font-size:1.3rem;}
	#<?php echo $module['module_name'];?>_html .content_div{ clear:both;}
	#<?php echo $module['module_name'];?>_html .content_div .content_div{ margin-bottom:1rem;;}
	#<?php echo $module['module_name'];?>_html .content_div .buttons{ opacity:0; margin-top:0.5rem;}
	#<?php echo $module['module_name'];?>_html .content_div .buttons a{ display:inline-block; vertical-align:top; padding:0.3rem; border-radius:0.3rem;  }
	#<?php echo $module['module_name'];?>_html .content_div .buttons a:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .content_div:hover .comment_div .buttons2 a{ opacity:0.8;  border-radius:0.3rem;  }
	#<?php echo $module['module_name'];?>_html .content_div:hover .comment_div .buttons2  a:hover{ opacity:0.8;}
	
	
	#<?php echo $module['module_name'];?>_html .content_div .content_content{  background:#fff; padding:0.5rem; }
	#<?php echo $module['module_name'];?>_html .content_div .content_content:hover{ }
	#<?php echo $module['module_name'];?>_html .content_div .content_content:hover .buttons{ opacity:1;}
	#<?php echo $module['module_name'];?>_html .content_div .content_content:hover .comment_div .buttons2{ opacity:1;}
	
	#<?php echo $module['module_name'];?>_html .content_div img{ max-width:100%;}
	
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .buttons2{ opacity:0; margin-right:1rem;}
	#<?php echo $module['module_name'];?>_html .content_div .comment_div{ padding-left:2rem; padding-bottom:0.5rem; text-align:left;  background:#fff;}
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .username{ height:20px; line-height:20px; display:inline-block; }
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .time{  height:20px; line-height:20px;display:inline-block; margin-left:20px;}
	
   #<?php echo $module['module_name'];?>_html .content_div .comment_div .username:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f007"; padding-right:2px;}
    #<?php echo $module['module_name'];?>_html .content_div .comment_div .time:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f017";padding-right:2px;}
	
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .comment_content{}
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .comemnt{ display:block; padding-left:1rem;}
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .comemnt:after{}
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .comemnt .v{ }
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .username{ opacity:0.6;}
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .time{ opacity:0.6;}

	
    #<?php echo $module['module_name'];?>_html .content_div  .content_div{ border-bottom:1px dashed <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; padding-bottom:5px;  border:none; padding-left:1rem; background:#fff;}
    #<?php echo $module['module_name'];?>_html .content_div .comment_div div{ display:inline-block;}
	#<?php echo $module['module_name'];?>_html .content_div .content_author{ padding-top:5px;}
	#<?php echo $module['module_name'];?>_html .content_div .content_author .username{ display:inline-block; vertical-align:top; width:50%; overflow:hidden; text-align:left;}
	#<?php echo $module['module_name'];?>_html .content_div .content_author .time{ display:inline-block; vertical-align:top; width:48%; overflow:hidden; text-align:right; }
    #<?php echo $module['module_name'];?>_html .content_div .content_author .username:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f007"; padding-right:2px;}
    #<?php echo $module['module_name'];?>_html .content_div .content_author .time:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f017";padding-right:2px;}
	
	
	#<?php echo $module['module_name'];?>_html .content_div .content_content{ margin-top:5px; clear:both;}
	#<?php echo $module['module_name'];?>_html .content_div .content_content .answer{ display:inline-block;}
	#<?php echo $module['module_name'];?>_html .content_div .content_content .answer:before{ display:none;}
	#<?php echo $module['module_name'];?>_html .content_div .content_content .answer .v{}
	
	
	
	#<?php echo $module['module_name'];?>_html .content_div .content_content .comment_button{ display:inline-block; margin-left:10px; }
	#<?php echo $module['module_name'];?>_html .m_hide{display:inline-block; margin-left:10px; width:auto; }
	
	#<?php echo $module['module_name'];?>_html #replay_input_div{ }
	#<?php echo $module['module_name'];?>_html .input_span{ }
	 
    #<?php echo $module['module_name'];?>_html #comment_input_div{ display:none; position:absolute;}
    #<?php echo $module['module_name'];?>_html #comment_input_div #comment_input{}
    #<?php echo $module['module_name'];?>_html #comment_input_div #comment_auth{ width:60px;}
    #<?php echo $module['module_name'];?>_html #comment_input_div .submit{  margin-right:20px;}
	
    #<?php echo $module['module_name'];?>_html #replay_input_div{ }
	#<?php echo $module['module_name'];?>_html .view{ }
	#<?php echo $module['module_name'];?>_html #email{ height:13px;}
	#<?php echo $module['module_name'];?>_html #comment_input_div_close{ cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .comment_div .m_hide{ display:none;}
	#<?php echo $module['module_name'];?>_html .comment_div .m_show{display:none;}
	
	#<?php echo $module['module_name'];?>_html .replay_a_div .replay{ margin-right:40px; display:inline-block;    border-radius:5px; padding:5px;border:1px solid <?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; border-radius:3px; background:none; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;}
    #<?php echo $module['module_name'];?>_html .replay_a_div .replay:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f044";padding-right:2px;}
	#<?php echo $module['module_name'];?>_html .replay_a_div .replay:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .title_div .username,#<?php echo $module['module_name'];?>_html .title_div .time,#<?php echo $module['module_name'];?>_html .title_div br{ display:none;}
	.replay_a_div{ background:#fff; text-align:right;}
	#<?php echo $module['module_name'];?>_html .v img{max-width:100%; }
	
	#<?php echo $module['module_name'];?>_html .comment_div:hover .buttons2{ opacity:1;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html" >
     <div class=title_div><?php echo $module['title']?></div>
      <div class=replay_a_div><a href="#replay_input_div" class="replay"><?php echo self::$language['replay'];?></a></div>             
    <div class=content_div><?php echo $module['list']?></div>              
    <?php echo $module['page']?>
    
    <div id=replay_input_div><?php echo self::$language['say_something']?><textarea name="content" id="content" style="display:none; width:100%; height:160px;"></textarea>
    <br />
     <span class=m_label> </span><span class=input_span><input type="checkbox" id="email" name="email" /><?php echo self::$language['when_comments_remind_me'];?></span>
	<br /><br />
    <?php echo self::$language['authcode'];?> <input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" />  <a href="#" onclick="return change_authcode();" title="<?php echo self::$language['click_change_authcode']?>"><img id="authcode_img" wsrc="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a>
    <br /><br /><a href="#" class="submit" onclick="return subimt_content();"><?php echo self::$language['submit']?><?php echo self::$language['replay'];?></a> <span id=replay_state></span>
    </div>
    
    <div id=comment_input_div><span class=s> </span><span class=m><input type=text id=comment_input maxlength="300" size="40"/>     <?php echo self::$language['authcode'];?> <input type=text id=comment_auth /> <img id="comment_auth_img" wsrc="./lib/authCode.class.php?save_name=comment_auth" style="vertical-align:middle; border:0px;" />      <a href=# onclick="return submit_comment()" class="submit"><?php echo self::$language['submit'];?></a> <span id=comment_state></span></span><span id=comment_input_div_close class="e"> </span>
    </div>
    <div class=temp_comment style="display:none;"></div>
    </div>
</div>