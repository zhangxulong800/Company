<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left save_name="<?php echo $module['module_save_name'];?>"  >
    
    
    <script>
    $(document).ready(function(){
		//alert('xx');
		$("#current_position_text").css("color","#ffc07e");
		$("#<?php echo $module['module_name'];?> .answer_user").each(function(index, element) {
            if($(this).html()=='()'){$(this).parent('div').css('display','none');}
        });
		
    });
    
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .msg_div{border-top:1px solid #ccc;;  padding:10px; margin-top:2rem; padding-bottom:2rem;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info{ text-align:left;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info span{ display:inline-block; }
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .sender{ line-height:20px;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .time{line-height:20px;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .ip{line-height:20px;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .receive{line-height:20px;}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info .time{line-height:20px;}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info .answer_user{ line-height:20px;}
	
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .sender:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f007"; padding-right:2px;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .time:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f017";padding-right:2px;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .ip:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f041";padding-right:2px;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .receive:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f00d";padding-right:2px;}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info .time:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f017";padding-right:2px;}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info .answer_user:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f007";padding-right:2px;}
	
	
	
	
	#<?php echo $module['module_name'];?>_html .msg_div table tbody tr{ height:auto;}
	#<?php echo $module['module_name'];?>_html .msg_div table tbody tr td{ border:none; padding:0px; height:auto;}
    #<?php echo $module['module_name'];?>_html .msg_div .content_div{ text-align:left; margin-right:120px; margin-left:10px;}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_div{ margin-left:120px; margin-right:20px;}	
    #<?php echo $module['module_name'];?>_html .msg_div .content_div .v{ display:inline-block;   border-radius:0.5rem; padding:
	1rem;  margin-bottom:2rem;background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_div .v{ display:inline-block;   border-radius:0.5rem;padding:1rem;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}	
    #<?php echo $module['module_name'];?>_html .msg_div .content_div:before{font: normal normal normal 2rem/1 FontAwesome; content:"\f0d8"; padding-left:0.5rem;  height:1.2rem; display:block; overflow:hidden;color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; }
    #<?php echo $module['module_name'];?>_html .msg_div .answer_div:after{font: normal normal normal 2rem/1 FontAwesome; content:"\f0d7"; padding-right:1rem;  height:0.5rem; line-height:0.3rem; display:block; overflow:hidden;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
	
    #<?php echo $module['module_name'];?>_html .msg_div .answer_div .answer textarea{ width:500px; height:100px;}
    #<?php echo $module['module_name'];?>_html .msg_state{ height:13px;}
	
	
    #<?php echo $module['module_name'];?>_html .msg_div .answer_div{ display:block;}
	
	
    #<?php echo $module['module_name'];?>_html .msg_div .answer textarea{width:98%;}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info{ text-align:right;}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info span{ display:inline-block;}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info .answer_user{}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info .time{}	
	.alert-info{ margin:0px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html" >
     <?php echo $module['list']?>              
    <?php echo $module['page']?>
    </div>
</div>
