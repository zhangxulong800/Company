<div id=<?php echo $module['module_name'];?>  class="" monxin-module="<?php echo $module['module_name'];?>" align=left style="width:100%;" save_name="<?php echo $module['module_save_name'];?>" >
<script>
$(document).ready(function(){
	p_id=get_param('p_id');
	if(p_id!=''){$("#<?php echo $module['module_name'];?> .top_nv a[p_id='"+p_id+"']").addClass('current');}else{$("#<?php echo $module['module_name'];?> .top_nv a:first").addClass('current');}
	if($("#<?php echo $module['module_name'];?> .b_right .current").next().next('a').html()){
		$("#<?php echo $module['module_name'];?>_html .continue").html('<a href='+$("#<?php echo $module['module_name'];?> .b_right .current").next().next('a').attr('href')+'><?php echo self::$language['continue_view']?> '+$("#<?php echo $module['module_name'];?> .b_right .current").next().next('a').html()+'</a>');
	}
	
	
	
	$(window).scroll(function(){
		if($(window).scrollTop()>$("#<?php echo $module['module_name'];?>").offset().top){
			$("#<?php echo $module['module_name'];?> .top_nv").addClass('top_fixed');
		}else{
			$("#<?php echo $module['module_name'];?> .top_nv").removeClass('top_fixed');
		}	
			
	});
	
	$.get("<?php echo $module['count_url']?>");
        
    });
    </script>
    

<style>

#<?php echo $module['module_name'];?>{ background:none;}
#<?php echo $module['module_name'];?>_html{	}
#<?php echo $module['module_name'];?>_html a{ }
#<?php echo $module['module_name'];?>_html .top_nv{ height:50px; line-height:50px; overflow:hidden; white-space:nowrap;     background-color: #f5f5f5;color: #616161;}
#<?php echo $module['module_name'];?>_html .top_nv a{color: #616161;}
#<?php echo $module['module_name'];?>_html .top_nv .b_left{ display:inline-block; vertical-align:top; width:30%; overflow:hidden; font-size:16px;}
#<?php echo $module['module_name'];?>_html .top_nv .b_right{ display:inline-block; vertical-align:top; width:70%; overflow:hidden; text-align:right;}
#<?php echo $module['module_name'];?>_html .top_nv .b_right a{ line-height:30px; height:30px; margin-top:10px; display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .top_nv .b_right a:last-child{ background: <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;color: <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; padding-left:30px; padding-right:30px;	}
#<?php echo $module['module_name'];?>_html .top_nv .b_right a:last-child:hover{ opacity:0.8;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .top_nv .b_right a:hover{color: <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .top_nv .b_right .current{color: <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
#<?php echo $module['module_name'];?>_html .top_nv .b_right .sep{ display:inline-block; vertical-align:top;color: #e0e0e0; width:30px; text-align:center;}
#<?php echo $module['module_name'];?>_html .top_fixed{ width:100%; position:fixed; top:0px; background:rgba(245,245,245,0.9);   box-shadow: 0 0 3px #b0b0b0;}

#<?php echo $module['module_name'];?>_html .content{ white-space:normal; line-height:30px;}
#<?php echo $module['module_name'];?>_html .content img{ max-width:100%;}
#<?php echo $module['module_name'];?>_html .continue{ text-align:center; line-height:30px; margin-top:30px;	}
#<?php echo $module['module_name'];?>_html .continue a{ display:inline-block; vertical-align:top; background: <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;color: <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; padding-left:30px; padding-right:30px;}
#<?php echo $module['module_name'];?>_html .continue a:hover{opacity:0.8;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }

.program_power{text-align:right; line-height:40px;}
.nav-tabs{ margin-top:20px;	}
#<?php echo $module['module_name'];?>_html .content [p_id]{ display:none !important; margin-top:20px;	}
#<?php echo $module['module_name'];?>_html a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}

</style>


    <div id="<?php echo $module['module_name'];?>_html" >
        <div id="show_count" style="display:none;"></div>
        <div class="top_nv"><div class=container>
        	<div class="b_left"><?php echo $module['data']['title'];?></div><div class=b_right><?php echo $module['data']['paragraph'];?></div>
        </div></div>
        <div class="content<?php echo $module['data']['is_full']?>"><?php echo $module['data']['content']?></div>
        <div class=continue></div>
        <div class="container program_power"><?php echo self::$language['program_power']?></div>
    </div>
</div>