<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$("#type_select_div a").click(function(){
			j_key=$("#<?php echo $module['module_name'];?>_html #key").val();
			if(j_key!='<?php echo $_GET['key'];?>'){
				$(this).attr('href',$(this).attr('href')+'&key='+encodeURI(j_key));	
			}
		});
		
		$('#<?php echo $module['module_name'];?> #input_type_<?php echo $_GET['type'];?>').attr('class','current');
    });
    
    
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{  margin-top:10px;}
    #<?php echo $module['module_name'];?>_html .m_label{ display:block; margin-bottom:1rem;}
    #<?php echo $module['module_name'];?>_html .input_span{ }
    #<?php echo $module['module_name'];?>_html #answer_input_div{ width:100%; min-height:200px; border:1px solid #CCC; border-radius:5px; overflow:hidden; white-space:nowrap;}
    #<?php echo $module['module_name'];?>_html #key{ width:50%;}
    #<?php echo $module['module_name'];?>_html #type_select_div{ background-color:#ccc; line-height:2.5rem;  }
    #<?php echo $module['module_name'];?>_html #type_select_div a{ display:inline-block; padding-left:0.3rem; padding-right:0.3rem;}
    #<?php echo $module['module_name'];?>_html #type_select_div .current{ background-color:#FFF; }
    #<?php echo $module['module_name'];?>_html #input_div{ padding:20px;}
	#<?php echo $module['module_name'];?>_html #input_type_text:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c2"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_image:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c5"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_voice:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c7"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_video:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c8"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_single_news:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c4"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_news:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f0f6"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_function:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c9"; padding-right:2px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=key_div><span class=m_label><?php echo self::$language['keyword'];?></span><span class=input_span>
       	<input type="text" id=key value="<?php echo $module['data']['key'];?>" /> <span id=key_state></span>
        </span></div>
    	<div class=answer_div><span class=m_label><?php echo self::$language['answer_content'];?></span><span class=input_span>
        	<div id=answer_input_div>
            	<div id=type_select_div><?php echo $module['input_select'];?></div>
            	<div id=input_div>
<!-----------------------------------------------------------------------------------answer_content_input_start-->
					<script>
                    $(document).ready(function(){
						$('#img_ele').insertBefore($('#img_state'));	
						$("#<?php echo $module['module_name'];?> .replace").toggle(
						  function () {
							$(this).next('div').css('display','inline-block');
						  },
						  function () {
							$(this).next('div').css('display','none');
						  }
						);
						if('<?php echo $module['single_news']['img'];?>'==''){
							$("#replace_div").css('display','block');
							$("#<?php echo $module['module_name'];?> .replace").css('display','none');
						}
						
											
                        $("#<?php echo $module['module_name'];?> #submit").click(function(){
							$("#<?php echo $module['module_name'];?> #key_state").html('');
							$("#<?php echo $module['module_name'];?> #img_state").html('');
							$("#<?php echo $module['module_name'];?> #title_state").html('');
							$("#<?php echo $module['module_name'];?> #url_state").html('');
							$("#<?php echo $module['module_name'];?> #description_state").html('');
							
							
							
							$("#<?php echo $module['module_name'];?> #submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
							
							$.post('<?php echo $module['action_url'];?>',{key:$("#<?php echo $module['module_name'];?> #key").val(),img:$("#<?php echo $module['module_name'];?> #img").val(),title:$("#<?php echo $module['module_name'];?> #title").val(),description:$("#<?php echo $module['module_name'];?> #description").val(),url:$("#<?php echo $module['module_name'];?> #url").val()}, function(data){
								//alert(data);
								try{v=eval("("+data+")");}catch(exception){alert(data);}
								
								
								if(v.state=='success'){
									$("#<?php echo $module['module_name'];?> #submit").css('display','none');
									$("#<?php echo $module['module_name'];?> #submit_state").html(v.info+'<a href=./index.php?monxin=weixin.auto_answer_list&wid=<?php echo @$_GET['wid'];?> class=return_button><span class=b_start></span><span class=b_middle><?php echo self::$language['return'];?></a>');
								}else{
									if(v.id){
										$("#<?php echo $module['module_name'];?> #"+v.id+'_state').html(v.info);
									}
									$("#<?php echo $module['module_name'];?> #submit_state").html('<span class=fail><?php echo self::$language['fail'];?></span>');
								}
							});
								
							return false; 
						});
                    });
                    
                    
                    </script>
                    
                    <style>
                    #<?php echo $module['module_name'];?>_html #input_div{}
                    #<?php echo $module['module_name'];?>_html #title{width:80%;}
                    #<?php echo $module['module_name'];?>_html #description{width:80%; height:100px;}
                    #<?php echo $module['module_name'];?>_html #url{width:80%; }
					#replace_div{ display:none; vertical-align:top;}
                    </style>
                	<div><span class=m_label><?php echo self::$language['title'];?></span><span class=input_span><input type="text" id="title" name="title" value="<?php echo $module['single_news']['title'];?>" /> <span id=title_state></span></span></div>
                	<div><span class=m_label><?php echo self::$language['image'];?></span><span class=input_span>
						<?php echo $module['single_news']['img'];?>
                    	<a href=# class="replace"><?php echo self::$language['replace'];?></a>  <div id=replace_div><span id=img_state></span></div>                    
                    </span></div>
                	<div><span class=m_label><?php echo self::$language['detail'];?></span><span class=input_span><textarea name="description" id="description"><?php echo $module['single_news']['description'];?></textarea> <span id=description_state></span></span></div>
                	<div><span class=m_label><?php echo self::$language['url'];?></span><span class=input_span><input type="text" id="url" name="url" value="<?php echo $module['single_news']['url'];?>" /> <span id=url_state></span></span></div>
                    
               		
<!-----------------------------------------------------------------------------------answer_content_input_end-->
                </div>
            </div>
            
            
        </span></div>
   	  <div class=submit_div><span class=m_label>&nbsp;</span><span class=input_span>
        	<a href="#" class="submit" id=submit><?php echo self::$language['submit']?></a> <span id=submit_state></span>	
        </span></div>
        
        
        
  </div>
</div>

