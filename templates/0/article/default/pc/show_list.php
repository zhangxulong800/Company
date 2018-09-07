<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	
	if('<?php echo $module['title'];?>'==''){$("#<?php echo $module['module_name'];?> .module_title").css('display','none');}
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
	
	
	
	if('<?php echo $module['scroll'];?>'!='no' && '<?php echo $module['scroll'];?>'!='null'){
		$("#<?php echo $module['module_name'];?> .list").imgscroll({
			speed: 100,    //图片滚动速度
			amount: 0,    //图片滚动过渡时间
			width: 3,     //图片滚动步数
			dir: "<?php echo $module['scroll'];?>"   // "left" 或 "up" 向左或向上滚动
		});
		if('<?php echo $module['scroll'];?>'=='left'){
		
		}else{
			$("#<?php echo $module['module_name'];?> .module_title").css('display','none');
		}
	}

});
</script>

<style>
#<?php echo $module['module_name'];?>{ margin:5px; padding:0px;}
#<?php echo $module['module_name'];?>{ width:<?php echo $module['module_width'];?>; height:<?php echo $module['module_height'];?>;display:inline-block;vertical-align:top; overflow:hidden;}
#<?php echo $module['module_name'];?>_html{ padding:0.5rem;}
#<?php echo $module['module_name'];?>_html .module_title{ display:block; font-size:1.71rem; height:4.28rem;line-height:4.28rem;  background-position:top;   padding-left:25px;  font-weight:bold;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .list{}
#<?php echo $module['module_name'];?>_html .list a{  margin:5px; margin-bottom:1.42rem; display:inline-block;  width:<?php echo $module['sub_module_width'];?>; overflow:hidden; vertical-align:top; text-align:left;  border:1px solid #e7e7e7;}
#<?php echo $module['module_name'];?>_html .list a:hover{   box-shadow:0px 0px 5px 0px rgba(0,0,0,.2); border:1px solid #ddd;}
#<?php echo $module['module_name'];?>_html .list .current_page{ font-weight:bolder;}
#<?php echo $module['module_name'];?>_html .list .text{ display:inline-block; padding:5px; vertical-align:middle; width: 85%;margin-right: 10px;}
#<?php echo $module['module_name'];?>_html .list .text span{ display:block;}
#<?php echo $module['module_name'];?>_html .list .text span .m_label{ display: inline-block;}
#<?php echo $module['module_name'];?>_html .list .text .title{ font-weight:bold;line-height:2.14rem; margin-left:5px; margin-right:0.71rem; overflow:hidden; text-overflow: ellipsis; }
#<?php echo $module['module_name'];?>_html .list .text .content{ font-size:0.86rem; line-height:1.85rem; text-indent:1.78rem; margin-left:5px; overflow:hidden; text-overflow:ellipsis;}
#<?php echo $module['module_name'];?>_html .list .text .time{display:inline-block;font-size:0.86rem; width:65%;line-height:1.42rem; margin-left:5px; float:left; }

#<?php echo $module['module_name'];?>_html .list .text .visit{display:inline-block;font-size:0.86rem; width:30%;  line-height:1.42rem;text-align:right; float:right;}
#<?php echo $module['module_name'];?>_html .list .text .visit .visit_symbol{display:inline-block; line-height:1.42rem;}
#<?php echo $module['module_name'];?>_html .list .text .visit .visit_symbol:before{margin-left:5px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0a6"; opacity:0.6;}

#<?php echo $module['module_name'];?>_html .list .img{ display:inline-block; vertical-align:middle;padding:5px; text-align:right;overflow:hidden;  border:0px;}
#<?php echo $module['module_name'];?>_html .list .img img{ float:right; display:none; }
#<?php echo $module['module_name'];?>_html .list .title{ font-size:1rem; font-weight:normal !important;}


#<?php echo $module['module_name'];?>_html .hove_icon{}
#<?php echo $module['module_name'];?>_html .hove_icon .text{ display:inline-block; vertical-align:top; width:70%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .hove_icon .img{display:inline-block; vertical-align:top; width:26%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .hove_icon .img img{ display:block; width:100%;}

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin" >
	<div class=module_title><?php echo $module['title'];?></div>
	<div class=list id="toplist"><?php echo $module['list'];?></div>
</div>
</div>