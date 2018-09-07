<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		if(get_param('state')!=''){
			$("#<?php echo $module['module_name'];?> .state_option a").removeClass('current');
			$("#<?php echo $module['module_name'];?> .state_option a[state='"+get_param('state')+"']").addClass('current');
		}
		
    });
	
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+"").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false; 	
        
    }
    
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ background:rgba(244,244,244,1); }
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .state_option{ border-bottom:1px solid #ccc; background:#fff; margin-bottom:1rem; line-height:3rem; white-space:nowrap;}
    #<?php echo $module['module_name'];?>_html .state_option a{ display:inline-block; vertical-align:top; margin-left:5px; margin-right:5px; padding-left:3px; padding-right:3px;}
	#<?php echo $module['module_name'];?>_html .state_option a:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html .state_option .current{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; border-bottom:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	
	
    #<?php echo $module['module_name'];?>_html .list{}
    #<?php echo $module['module_name'];?>_html .list .border{ background:#fff;margin-bottom:1rem;}
    #<?php echo $module['module_name'];?>_html .list .border .o_head{ line-height:2.5rem;padding-left:5px;padding-right:5px;}
    #<?php echo $module['module_name'];?>_html .list .border .o_head .h_left{ display:inline-block; vertical-align:top; width:70%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .list .border .o_head .h_right{display:inline-block; vertical-align:top; width:30%; overflow:hidden; text-align:right;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
    #<?php echo $module['module_name'];?>_html .list .border .goods{ background:rgba(249,249,249,1); padding-top:5px; padding-bottom:5px;}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_left{ display:inline-block; vertical-align:top; width:30%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_left img{ height:100px;}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_right{display:inline-block; vertical-align:top;width:70%; overflow:hidden; }
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_right .g_title{}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_right .price{ font-size:1.1rem; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_right .group_list{}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_right .group_list img{ width:30px; height:30px; border-radius:15px; border:1px #ccc solid; margin-right:0.5rem; background:#fff;}
	
	
    #<?php echo $module['module_name'];?>_html .list .border .act_div{ text-align:right; line-height:2.5rem; padding-right:10px; padding-top:0.5rem;}
    #<?php echo $module['module_name'];?>_html .list .border .act_div a{ display:inline-block; vertical-align:top; border:1px solid #ccc; border-radius:3px; line-height:1.7rem; padding-left:5px; padding-right:5px; cursor:pointer; margin-left:1rem;}
	
	#<?php echo $module['module_name'];?>_html  .out_id{ padding-left:2.5rem;}
	
    #<?php echo $module['module_name'];?> .go_detail{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
	#<?php echo $module['module_name'];?> .go_detail:before {font: normal normal normal 12px/1 FontAwesome; margin-right: 2px; content:"\f067";
    
    </style>
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=1>
        <div class=state_option><?php echo $module['state_option']?></div>
        <div class=list><?php echo $module['list']?></div>
        <?php echo $module['page']?>

    </div>
</div>

