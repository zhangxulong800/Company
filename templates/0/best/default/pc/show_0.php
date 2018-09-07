<div id=<?php echo $module['module_name'];?>  class="" monxin-module="<?php echo $module['module_name'];?>" align=left style="width:100%;" save_name="<?php echo $module['module_save_name'];?>" >
<script>
$(document).ready(function(){
	
		$("#<?php echo $module['module_name'];?> .b_right a").click(function(){
			
			$("#<?php echo $module['module_name'];?> .b_right a").attr('class','');
			$(this).attr('class','current');
			id=$(this).attr('p_id');
			$(window).scrollTop($("#<?php echo $module['module_name'];?> #p_"+id).offset().top-50);
			
			return false;	
		});
	
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

.program_power{text-align:right; line-height:40px;}
.nav-tabs{ margin-top:20px;	}
#<?php echo $module['module_name'];?>_html .content [p_id]{ display:none !important; margin-top:20px;	}
#<?php echo $module['module_name'];?>_html a .thumb_img{ vertical-align:middle;width:70% !important; max-width:70% !important; margin:0.5rem; margin-bottom:0px;}

#<?php echo $module['module_name'];?> .paragraph{ clear:both; margin-bottom:1.5rem;}
#<?php echo $module['module_name'];?> .paragraph .p_title{ border-bottom:1px dashed #ccc; color: <?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; font-size:1.2rem;}
#<?php echo $module['module_name'];?> .paragraph .p_title:before {content: ' '; display:inline-block; vertical-align:top; width:10px; height:20px; background: <?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; margin-right:5px; margin-top:5px;}
#<?php echo $module['module_name'];?> .paragraph .p_content{}

.xmjs{ padding-top:0.5rem;}
.xmjs .line_1{}
.xmjs .line_1 .left_icon{ display:inline-block; vertical-align:top; width:30%;}
.xmjs .line_1 .left_icon img{width:100%;}
.xmjs .line_1 .right_info{display:inline-block; vertical-align:top; width:65%; padding-left:1rem;}
.xmjs .line_1 .right_info .djs{}
.xmjs .line_1 .right_info .other >div{ border-bottom:1px dashed #ccc; line-height:3rem; }
.xmjs .line_1 .right_info .other .l_name{font-weight:bold !important;}
.xmjs .line_1 .right_info .other .l_value{ color:#999;}
.xmjs .line_1 .right_info .other .sssj:before{font: normal normal normal 1.2rem/1 FontAwesome; margin-right:2px;content: "\f017"; color:#ccc;}
.xmjs .line_1 .right_info .other .mzff:before{font: normal normal normal 1.2rem/1 FontAwesome; margin-right:2px;content: "\f2d6"; color:#ccc;}
.xmjs .line_1 .right_info .other .ryqk:before{font: normal normal normal 1.2rem/1 FontAwesome; margin-right:2px;content: "\f0f8"; color:#ccc;}
.xmjs .line_1 .right_info .other .hfsj:before{font: normal normal normal 1.2rem/1 FontAwesome; margin-right:2px;content: "\f1ae"; color:#ccc;}


</style>


    <div id="<?php echo $module['module_name'];?>_html" >
        <div id="show_count" style="display:none;"></div>
        <div class="top_nv"><div class=container>
        	<div class="b_left"><?php echo $module['data']['title'];?></div><div class=b_right><?php echo $module['data']['paragraph'];?></div>
        </div></div>
        <div class="content container"><?php echo $module['data']['content']?></div>
    </div>
</div>