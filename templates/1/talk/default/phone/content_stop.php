<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left save_name="<?php echo $module['module_save_name'];?>"  >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
		$(".content_div .hide").click(function(){
			var id=$(this).attr('cid');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=hide',{cid:id}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);				
			});        	
			return false; 
		});
		$(".content_div .show").click(function(){
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
		$("#<?php echo $module['module_name'];?> .comment_button").click(function(){
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
			$("#<?php echo $module['module_name'];?> #replay_input_div").css('display','block');
		});
		
    });
    
    function subimt_content(){
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content").val();
		if(content==''){$("#<?php echo $module['module_name'];?> #replay_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['content']?></span>');return false;}	
        var authcode=$("#<?php echo $module['module_name'];?> #authcode").val();
		if(authcode==''){$("#<?php echo $module['module_name'];?> #replay_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['authcode']?></span>');$("#<?php echo $module['module_name'];?> #authcode").focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #replay_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=submit_content',{content:content,authcode:authcode}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #replay_state").html(v.info);
			if(v.state=='success'){$("#<?php echo $module['module_name'];?> #replay_input_div .submit").css('display','none');}
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
        $.post('<?php echo $module['action_url'];?>&act=submit_comment',{comment_input:comment_input,comment_auth:comment_auth,for_id:for_id}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #comment_state").html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> #comment_input_div #comment_auth_img").attr('src',"./lib/authCode.class.php?save_name=comment_auth&r="+Math.random());
				$("#<?php echo $module['module_name'];?> #comment_input_div #comment_input").val('');
				$("#<?php echo $module['module_name'];?> #comment_input_div #comment_auth").val('');
				
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
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .title_div{   height:165PX; display:inline-block; width:100%; border:1px solid #e3d1b9;} 
	#<?php echo $module['module_name'];?>_html .title_div .username{}
    #<?php echo $module['module_name'];?>_html .title_div div{ display:inline-block;}
    #<?php echo $module['module_name'];?>_html .content_div{}
    #<?php echo $module['module_name'];?>_html .content_div .comment_div div{ display:inline-block;}
	
    #<?php echo $module['module_name'];?>_html #comment_input_div{ display:none; position:absolute;}
    #<?php echo $module['module_name'];?>_html #comment_input_div #comment_input{}
    #<?php echo $module['module_name'];?>_html #comment_input_div #comment_auth{ width:60px;}
    #<?php echo $module['module_name'];?>_html #comment_input_div .submit{ }
	
    #<?php echo $module['module_name'];?>_html #replay_input_div{ display:none;}
	#<?php echo $module['module_name'];?>_html .view{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html" >
     <div class=title_div><?php echo $module['title']?><a href="#replay_input_div" class="replay"><?php echo self::$language['replay'];?></a></div>             
     <div class=content_div><?php echo $module['list']?></div>              
    <?php echo $module['page']?>
    
    <a href="#replay_input_div" class="replay"><?php echo self::$language['replay'];?></a>
    <div id=replay_input_div><textarea name="content" id="content" style="display:none; width:100%; height:200px;"></textarea>
    <br />
    <?php echo self::$language['authcode'];?> <input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" />  <a href="#" onclick="return change_authcode();" title="<?php echo self::$language['click_change_authcode']?>"><img id="authcode_img" src="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a>
    <br /><br /><a href="#" class="submit" onclick="return subimt_content();"><?php echo self::$language['submit']?></a> <span id=replay_state></span>
    </div>
    
    <div id=comment_input_div><input type=text id=comment_input /> &nbsp; &nbsp; <?php echo self::$language['authcode'];?><input type=text id=comment_auth /> <img id="comment_auth_img" src="./lib/authCode.class.php?save_name=comment_auth" style="vertical-align:middle; border:0px;" />  &nbsp; &nbsp; <a href=# onclick="return submit_comment()" class="submit"><?php echo self::$language['submit'];?></a> <span id=comment_state></span>
    </div>
    </div>
</div>
