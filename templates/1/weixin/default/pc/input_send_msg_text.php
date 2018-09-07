<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		$('#<?php echo $module['module_name'];?> #input_type_<?php echo $_GET['type'];?>').attr('class','current');
    });
    
    
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{  margin-top:10px;}
    #<?php echo $module['module_name'];?>_html .m_label{ margin-top:20px; display:inline-block; width:15%; padding-right:10px; text-align:right; vertical-align:top;}
    #<?php echo $module['module_name'];?>_html .input_span{ margin-top:20px; display:inline-block;width:80%;  }
    #<?php echo $module['module_name'];?>_html #answer_input_div{ width:100%; min-height:200px; border:1px solid #CCC; border-radius:5px; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html #key{ width:50%;}
    #<?php echo $module['module_name'];?>_html #type_select_div{ background-color:#ccc; line-height:2.5rem;  }
    #<?php echo $module['module_name'];?>_html #type_select_div a{ display:inline-block; padding-left:32px; padding-right:20px;}
    #<?php echo $module['module_name'];?>_html #type_select_div .current{ background-color:#FFF; }
    #<?php echo $module['module_name'];?>_html #input_div{ padding:20px;}
	#<?php echo $module['module_name'];?>_html #input_type_text:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c2"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_image:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c5"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_voice:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c7"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_video:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c8"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_single_news:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c4"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_news:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f0f6"; padding-right:2px;}
	#<?php echo $module['module_name'];?>_html #input_type_function:before{font:normal normal normal 1rem/1 FontAwesome;content:"\f1c9"; padding-right:2px;}
	.submit_div{ text-align:right; padding-right:2%; line-height:60px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        	<div id=answer_input_div>
            	<div id=type_select_div><?php echo $module['input_select'];?></div>
            	<div id=input_div>
<!-----------------------------------------------------------------------------------answer_content_input_start-->
					<script>
                    $(document).ready(function(){
                        $("#<?php echo $module['module_name'];?> #submit").click(function(){
							$("#<?php echo $module['module_name'];?> #text_state").html('');
							$("#<?php echo $module['module_name'];?> #submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
							
							$.post('<?php echo $module['action_url'];?>',{text:$("#<?php echo $module['module_name'];?> #text").val()}, function(data){
								//alert(data);
								try{v=eval("("+data+")");}catch(exception){alert(data);}
								
								
								if(v.state=='success'){
									$("#<?php echo $module['module_name'];?> #submit").css('display','none');
									$("#<?php echo $module['module_name'];?> #submit_state").html(v.info+'<a href=./index.php?monxin=weixin.dialog&wid=<?php echo @$_GET['wid'];?>&openid=<?php echo @$_GET['openid'];?> class=return_button><span class=b_start></span><span class=b_middle><?php echo self::$language['refresh'];?></a>');
								}else{
									if(v.id){
										$("#<?php echo $module['module_name'];?> #"+v.id+'_state').html(v.info);
									}
									$("#<?php echo $module['module_name'];?> #submit_state").html(v.info);
								}
							});
								
							return false; 
						});
                    });
                    
                    
                    </script>
                    
                    <style>
                    #<?php echo $module['module_name'];?>_html #input_div{}
                    #<?php echo $module['module_name'];?>_html #text{width:100%; height:100px;}
                    </style>
                                
                
               		<textarea name="text" id="text"></textarea> <span id=text_state></span>
<!-----------------------------------------------------------------------------------answer_content_input_end-->
                </div>
            </div>
            
            
   	  <div class=submit_div>
        	<a href="#" class="submit" id=submit><?php echo self::$language['send']?></a> <span id=submit_state></span>	
        </div>
        
        
        
  </div>
</div>

