<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .submit").click(function(){			
			$(this).next().html('');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=update',{answer:$("#<?php echo $module['module_name'];?> #answer").val()},function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				if(v.state=='success'){
					parent.update_comment(<?php echo $_GET['id'];?>,$("#<?php echo $module['module_name'];?> #answer").val());	
				}
            });
			return false;	
		});
		
		
    });
    
    </script>
    <style>
	.fixed_right_div{ display:none;}
	#top_layout_out{ display:none;}
	#bottom_layout_out{ display:none;}
	#<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{margin-left:50px; margin-top:30px; }
    #<?php echo $module['module_name'];?>_html .goods_title{ line-height:40px;}
    #<?php echo $module['module_name'];?>_html #answer{ width:600px; height:100px;}
    #<?php echo $module['module_name'];?>_html .submit_div{ margin-top:20px;}
	#<?php echo $module['module_name'];?> .buyer{ margin-bottom:20px;}
    #<?php echo $module['module_name'];?> .buyer .username{text-align:left;}
    #<?php echo $module['module_name'];?> .buyer .point{ display:inline-block;  vertical-align:top;}
	#<?php echo $module['module_name'];?> .buyer .point:after{ color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f0d9"; color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>;}
    #<?php echo $module['module_name'];?> .buyer .content{ line-height:25px; display:inline-block; vertical-align:top; padding-left:10px;  padding-right:10px; border-radius:5px; font-size:1rem;background:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['text']?>;}
    #<?php echo $module['module_name'];?> .buyer .level{ padding-left:10px;}
    #<?php echo $module['module_name'];?> .buyer .time{padding-left:10px; color:#CCC; font-size:13px;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    	<div class=goods_title><?php echo $module['data']['title'];?></div>
        <div class=buyer><span class=username><?php echo $module['data']['buyer']?></span><span class=point>&nbsp;</span><span class=content><?php echo $module['data']['content']?></span><span class=level><?php echo $moduel['data']['level']?></span><span class=time><?php echo $module['data']['time']?></span></div>
        <textarea id=answer><?php echo $module['data']['answer']?></textarea>
        <div class=submit_div><a href="#" class=submit><?php echo self::$language['submit'];?></a><span class=state></span></div>
		
        
    </div>

</div>
