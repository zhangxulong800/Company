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
    #<?php echo $module['module_name'];?>{ background:none; }
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .state_option{ background:#fff; margin-bottom:1rem; line-height:3rem;}
    #<?php echo $module['module_name'];?>_html .state_option a{ display:inline-block; vertical-align:top; margin-left:10px; margin-right:10px; padding-left:10px; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .state_option a:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html .state_option .current{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; border-bottom:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	
	
    #<?php echo $module['module_name'];?>_html .list{}
    #<?php echo $module['module_name'];?>_html .list .border{ background:#fff;margin-bottom:1rem;}
    #<?php echo $module['module_name'];?>_html .list .border .o_head{ line-height:2.5rem;padding-left:5px;padding-right:5px;}
    #<?php echo $module['module_name'];?>_html .list .border .o_head .h_left{ display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .list .border .o_head .h_right{display:inline-block; vertical-align:top; width:50%; overflow:hidden; text-align:right;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
    #<?php echo $module['module_name'];?>_html .list .border .goods{ background:rgba(249,249,249,1); padding-top:5px; padding-bottom:5px;}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_left{ display:inline-block; vertical-align:top; width:120px; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_left img{ height:100px;}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_right{display:inline-block; vertical-align:top; }
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_right .g_title{}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_right .price{ font-size:1.1rem; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; line-height:2rem;}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_right .group_list{}
    #<?php echo $module['module_name'];?>_html .list .border .goods .g_right .group_list img{ width:30px; height:30px; border-radius:15px; border:1px #ccc solid; margin-right:0.5rem; background:#fff;}
	
	
    #<?php echo $module['module_name'];?>_html .list .border .act_div{ text-align:right; line-height:2.5rem; padding-right:10px; padding-top:0.5rem;}
    #<?php echo $module['module_name'];?>_html .list .border .act_div a{ display:inline-block; vertical-align:top; border:1px solid #ccc; border-radius:3px; line-height:1.7rem; padding-left:5px; padding-right:5px; margin-right:1rem; cursor:pointer;}
	
	#<?php echo $module['module_name'];?>_html  .out_id{ padding-left:2.5rem;}
	#<?php echo $module['module_name'];?>_html .o_user{padding-right:2.5rem;}
    #<?php echo $module['module_name'];?> .go_detail{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
	#<?php echo $module['module_name'];?> .go_detail:before {font: normal normal normal 12px/1 FontAwesome; margin-right: 2px; content:"\f067";
}
    </style>
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=1>
    	<div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['title']?>/<?php echo self::$language['order_id']?>/<?php echo self::$language['username']?>" class="form-control" ></m_label></div></div></div>
        <div class=state_option><?php echo $module['state_option']?></div>
        <div class=list><?php echo $module['list']?></div>
        <?php echo $module['page']?>

    </div>
</div>

