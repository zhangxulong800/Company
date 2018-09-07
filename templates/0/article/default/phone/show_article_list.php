<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left style="width:100%;" >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?>  .list a").each(function(index, element) {
        if($(this).children(".img").html().length==0){
			$(this).children(".img").css('display','none');
			$(this).children(".text").css('width','98%');
		}else{
			$(this).parent().addClass('hove_icon');
			/*
			$(this).children(".img").css('width',$(this).width()-$(this).children('.text').width()-30);
			$(this).children(".img").children('img').css('height',$(this).height()-10).css('width',$(this).height()-10).css('display','block');	
			$(this).children(".img").css('width',$(this).children(".img").children('img').width());
			$(this).children(".text").css('width',$(this).width()-$(this).children(".img").children('img').width()-10);
			*/
		}
    });
});

function reset_a(){
	$("#<?php echo $module['module_name'];?> .list a img").each(function(index, element) {
        $(this).parent().css('width',$(this).width());
    });	
}
</script>

<style>

#<?php echo $module['module_name'];?>{ padding:0px;}
#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block;vertical-align:top; overflow:hidden;}
#<?php echo $module['module_name'];?>_html{ }
#<?php echo $module['module_name'];?>_html .module_title{ font-weight:bolder; font-size:1.57rem;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .list{}
#<?php echo $module['module_name'];?>_html .list a{ margin-bottom:1rem;  margin-bottom:1.42rem; display:inline-block;  width:<?php echo $module['sub_module_width'];?>; overflow:hidden; vertical-align:top; text-align:left; box-shadow: 0px 1px 1px 1px rgba(0, 0, 0, 0.1);}
#<?php echo $module['module_name'];?>_html .list a:hover{   box-shadow:0px 0px 5px 0px rgba(0,0,0,.2); border:1px solid #ddd;}
#<?php echo $module['module_name'];?>_html .list .current_page{ font-weight:bolder;}
#<?php echo $module['module_name'];?>_html .list .text{ display:inline-block; padding:5px; vertical-align:middle; width: 85%;margin-right: 10px; }
#<?php echo $module['module_name'];?>_html .list .text span{ display:block;}
#<?php echo $module['module_name'];?>_html .list .text span .m_label{ display: inline-block;}
#<?php echo $module['module_name'];?>_html .list .text .title{ font-weight:bold;line-height:2.14rem; margin-left:5px; margin-right:0.71rem; overflow:hidden; text-overflow: ellipsis; }
#<?php echo $module['module_name'];?>_html .list .text .content{ font-size:0.86rem; line-height:1.85rem; text-indent:1.78rem; margin-left:5px; overflow:hidden; text-overflow:ellipsis;display:none;}
#<?php echo $module['module_name'];?>_html .list .text .time{display:inline-block;font-size:0.86rem; width:65%;line-height:1.42rem; margin-left:5px; float:left; }

#<?php echo $module['module_name'];?>_html .list .text .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:1.42rem;text-align:right; float:right;}
#<?php echo $module['module_name'];?>_html .list .text .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
#<?php echo $module['module_name'];?>_html .list .text .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0a6"; opacity:0.6;}

#<?php echo $module['module_name'];?>_html .list .img{ display:inline-block; vertical-align:middle;padding:5px; text-align:right;overflow:hidden;  border:0px;}
#<?php echo $module['module_name'];?>_html .list .img img{ float:right; display:none; }
.page_row{ padding-left:0.5rem; padding-right:0.5rem;}


#<?php echo $module['module_name'];?>_html .hove_icon{}
#<?php echo $module['module_name'];?>_html .hove_icon .text{ display:inline-block; vertical-align:top; width:70%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .hove_icon .img{display:inline-block; vertical-align:top; width:26%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .hove_icon .img img{ display:block; width:100%;}
</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=list ><?php echo $module['list'];?></div>
    <?php echo $module['page']?>
</div>
</div>