<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?>_html .parent").css('width',$(window).width()-$("#<?php echo $module['module_name'];?>_html .show_sub_div_out").width());
	$("#<?php echo $module['module_name'];?>_html").height($(window).height());
	$("#<?php echo $module['module_name'];?>_html .parent:first").addClass('parent_current');
	$("#<?php echo $module['module_name'];?> .show_sub_div .title").html('<a href='+$("#<?php echo $module['module_name'];?>_html .parent:first").attr('href')+'>'+$("#<?php echo $module['module_name'];?>_html .parent:first").html()+'</a>');
	$("#<?php echo $module['module_name'];?> .show_sub_div .content").html($("#<?php echo $module['module_name'];?>_html .sub_div:first").html());
	$("#<?php echo $module['module_name'];?> .show_sub_div a img").each(function(index, element) {
		$(this).attr('src',$(this).attr('wsrc'));
	});


	$("#<?php echo $module['module_name'];?> .sub_3").each(function(index, element) {
		if($(this).html()==''){
			$(this).prev().attr('class','sub2_a_no_sub');	
			$(this).parent().css('padding','0px').css('margin','0px').css('height','100px');
		}
    });
	
	$("#<?php echo $module['module_name'];?>_html .parent").hover(function(){
		$(".show_sub_div_out .show_sub_div").scrollTop(0)
		$("#<?php echo $module['module_name'];?>_html .parent").removeClass('parent_current');
		$(this).addClass('parent_current');
		$("#<?php echo $module['module_name'];?> .show_sub_div .title").html('<a href='+$(this).attr('href')+'>'+$(this).html()+'</a>');
		$("#<?php echo $module['module_name'];?> .show_sub_div .content").html($(this).next('.sub_div').html());
		$("#<?php echo $module['module_name'];?> .show_sub_div a img").each(function(index, element) {
            $(this).attr('src',$(this).attr('wsrc'));
        });
		return false;	
	});
	
	//$("#<?php echo $module['module_name'];?>_html .parent_type_out").preventScroll();
	//$("#<?php echo $module['module_name'];?>_html .show_sub_div_out").preventScroll();
});
</script>
<style>
#<?php echo $module['module_name'];?>{ margin:0px; padding:0px;}
#<?php echo $module['module_name'];?>_html{  }
#<?php echo $module['module_name'];?>_html .parent{ display:block; line-height:3.5rem; height:3.5rem; overflow:hidden; padding-left:1rem;}
#<?php echo $module['module_name'];?>_html .parent_current{  border-right:none; border-left:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> 3px solid; margin-left:1px; background:#fff;}
#<?php echo $module['module_name'];?>_html .parent .icon{ display:none;}
#<?php echo $module['module_name'];?>_html .parent .icon img{display:none;}
#<?php echo $module['module_name'];?>_html .parent .name{ display:inline-block; vertical-align:top; margin-left:8px;}

#<?php echo $module['module_name'];?>_html .title{ height:40px; padding-left:10px; line-height:40px; border-top:#F00 2px solid;  box-shadow: 0px 1px 2px;}
#<?php echo $module['module_name'];?>_html .title .icon{ display:inline-block; vertical-align:top;  vertical-align:middle;}
#<?php echo $module['module_name'];?>_html .title .icon img{ width:40px; height:40px; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .title .name{ display:inline-block; vertical-align:top; margin-left:8px;}

#<?php echo $module['module_name'];?>_html .sub_div{ display:none; width:100%; }
#<?php echo $module['module_name'];?>_html .sub_2{ border-bottom:1px dotted #e7e7e7; padding-bottom:10px; padding-top:10px;}
#<?php echo $module['module_name'];?>_html .sub_2:hover{ }
#<?php echo $module['module_name'];?>_html .sub2_a{ display:block; font-weight:bold;}
#<?php echo $module['module_name'];?>_html .sub2_a:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f009";}
#<?php echo $module['module_name'];?>_html .sub2_a:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;  }

#<?php echo $module['module_name'];?>_html .sub2_a_no_sub{  text-align:right; margin-left:2%; line-height:35px; display:inline-block; vertical-align:top; vertical-align:top; width:23%;  font-weight:bold;}
#<?php echo $module['module_name'];?>_html .sub2_a_no_sub:hover{ }


#<?php echo $module['module_name'];?>_html .sub_3{ display:block; white-space:normal; padding-left:0px !important; margin-left:0px !important; }
#<?php echo $module['module_name'];?>_html .sub_3 .sub3_a{ display:inline-block; vertical-align:top; width:15%; margin-right:1.5%; height:6rem;  white-space:nowrap; overflow:hidden;text-overflow: ellipsis;text-align:center; margin-top:0.6rem; margin-bottom:0.6rem; line-height:1.5rem; padding:5px;}
#<?php echo $module['module_name'];?>_html .sub_3 .sub3_a:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .sub_3 .sub3_a img{ display:block; margin:auto;   height:75%; }
#<?php echo $module['module_name'];?>_html .sub_3 .sub3_a img:hover{ opacity:0.8;}
#<?php echo $module['module_name'];?>_html{ white-space:nowrap;}
.parent_type_out{display:inline-block; vertical-align:top; width:20.4%; overflow:hidden; height:100%;background-color: #f3f4f6; }
.show_sub_div_out{display:inline-block; vertical-align:top; width:75%; overflow:hidden; height:100%;}
.parent_type_out .parent_type{ width:120%; height:100%; overflow:hidden; overflow-y:scroll;  }
#<?php echo $module['module_name'];?>_html .parent_type .parent{ display:block;border-bottom:#e0e0e0  1px solid;border-right:#e0e0e0  1px solid;}
.show_sub_div{width:110%; height:100%; overflow:hidden; overflow-y:scroll; padding:0.4rem; white-space:normal;}
.show_sub_div .title{ display:none;}
.show_sub_div .remark img{ max-width:100%;}

#<?php echo $module['module_name'];?>_html .sub_2_2{ display:inline-block; vertical-align:top; width:25%; overflow:hidden; text-align:center; margin-top:0.5rem;margin-bottom:0.5rem;}
#<?php echo $module['module_name'];?>_html .sub_2_2 a{ display:block;}
#<?php echo $module['module_name'];?>_html .sub_2_2 a:hover{ color:red;}
#<?php echo $module['module_name'];?>_html .sub_2_2 a img{ background:#ccc; display:block; margin:auto; width:60px; height:60px; border-radius:30px; overflow:hidden; }

</style>
<div id="<?php echo $module['module_name'];?>_html">
	<div class=parent_type_out><div class=parent_type><?php echo $module['data'];?></div></div><div class=show_sub_div_out>
    	<div class=show_sub_div>
            <div class=title></div>
            <div class=content></div>
    	</div>
    </div>
</div>
</div>