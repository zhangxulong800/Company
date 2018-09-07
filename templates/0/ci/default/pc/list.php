<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left style="width:98%;" >
<script>
$(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_1 a").hover(function(){
			$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_1 a").removeClass('show_sub');
			$("#<?php echo $module['module_name'];?> .circle_2 div").css('display','none');
			$("#<?php echo $module['module_name'];?> .circle_2 div[upid="+$(this).attr('circle')+"]").css('display','block');
		});
		$("#<?php echo $module['module_name'];?> .circle_2 div").hover(function(){
			$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_1 a[circle="+$(this).attr('upid')+"]").addClass('show_sub');	
		});
		
		$("#<?php echo $module['module_name'];?>_html .circle_filter a[circle]").click(function(){
			url=window.location.href;
			url=replace_get(url,'circle',$(this).attr('circle'));
			window.location.href=url;
			//window.location.href='./index.php?monxin=mall.shop_list&circle='+$(this).attr('circle');
			return false;
		});
		circle=get_param('circle');
		if(circle==''){circle=getCookie('circle');}
		$("#<?php echo $module['module_name'];?>  .circle_filter a[circle='"+circle+"']").addClass('current');
		
		if($("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().attr('upid')){
			$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().css('display','block');
			$("#<?php echo $module['module_name'];?> a[circle='"+$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().attr('upid')+"']").addClass('show_sub');
		}
		
		
		
	
	if('<?php echo @$_GET['search'];?>'!=''){
		search_reg='/<?php echo @$_GET['search'];?>/g';
		$("#<?php echo $module['module_name'];?> .info_list .title").each(function(index, element) {
temp=search_reg;
			$(this).html($(this).html().replace(eval(temp),'<k><?php echo @$_GET['search'];?></k>'));
		});
	}
	$("#<?php echo $module['module_name'];?> .info_list .other").each(function(index, element) {
        $(this).children("span:last").css('background-image','none');
    });
	$("#<?php echo $module['module_name'];?> .icon img").each(function(index, element) {
		if($(this).attr('wsrc')!='./program/ci/img_thumb/'){$(this).attr('src',$(this).attr('wsrc'));}else{$(this).attr('src','./no_picture.png');}
	});
	
	$("#<?php echo $module['module_name'];?> #price a").click(function(){
		url=window.location.href;
		url=replace_get(url,'max_price',$(this).attr('max_price'));
		url=replace_get(url,'current_page',1);
		window.location.href=replace_get(url,'min_price',$(this).attr('min_price'));
		return false;
	});
	temp=get_param('min_price');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #price a[min_price='"+temp+"'][max_price='"+get_param('max_price')+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #price a[min_price='-1']").attr('class','current');}

	
	temp=get_param('min_price');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #price a[min_price='"+temp+"'][max_price='"+get_param('max_price')+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #price a[min_price='-1']").attr('class','current');}
	$("#<?php echo $module['module_name'];?> .attribute a").click(function(){
		key=$(this).parent().parent().attr('id');
		url=window.location.href;
		url=replace_get(url,'current_page',1);
		if($(this).html()=='<?php echo self::$language['unlimited'];?>'){$(this).html('');}
		window.location.href=replace_get(url,key,$(this).html());
		return false;
	});
	$("#<?php echo $module['module_name'];?> .attribute").each(function(index, element) {
		id=$(this).attr('id');
		temp=get_param($(this).attr('id'));
		if(temp!=''){
			temp=decodeURI(temp);
			$("#<?php echo $module['module_name'];?> #"+id+" a").each(function(index, element) {
			    if($(this).html()==temp){$(this).attr('class','current');}
            });
		}else{
			$("#<?php echo $module['module_name'];?> #"+id+" a["+id+"='0']").attr('class','current');
		}
    });

	
	
	$("#<?php echo $module['module_name'];?> #type_a_<?php echo @$_GET['type'];?>").addClass('current');
	if(''!='<?php echo @$_GET['show_method'];?>'){
		$("#<?php echo $module['module_name'];?>_html #<?php echo @$_GET['show_method'];?>").attr('class','<?php echo @$_GET['show_method'];?>_current');
	}else{
		$("#<?php echo $module['module_name'];?>_html #show_grid").attr('class','show_grid_current');
	}
	$("#<?php echo $module['module_name'];?>_html .right_label a").click(function(){
		url=window.location.href;
		url=replace_get(url,'current_page',1);
		url=replace_get(url,'show_method',$(this).attr("id"));
		window.location.href=url;	
	});
	
	 var order=get_param('order');
	$("#<?php echo $module['module_name'];?>_html .left_label .order_div a").attr('class','order');
	 if(order!=''){
		$("a[desc='"+order+"']").attr('class','order_desc');
		$("a[asc='"+order+"']").attr('class','order_asc');			
	}else{
		$("#<?php echo $module['module_name'];?>_html .left_label .order_div a:first").attr('class','order_desc');
	}
  	$("#<?php echo $module['module_name'];?>_html .left_label .order_div a").click(function(){
		url=window.location.href;
		url=replace_get(url,'current_page',1);
		if(order=='' || order!=$(this).attr('desc')){
			url=replace_get(url,"order",$(this).attr('desc'));
		}else{
			url=replace_get(url,"order",$(this).attr('asc'));	
		}
		window.location=url;	
		return false;
	});
	
	$("#<?php echo $module['module_name'];?>_html .left_label .set_price").click(function(){
		var min_price=$("#<?php echo $module['module_name'];?>_html .left_label #min_price").val();
		var max_price=$("#<?php echo $module['module_name'];?>_html .left_label #max_price").val();
/*		if(min_price==''){$(this).next().html('<span class=fail><?php echo self::$language['please_input'];?><?php echo self::$language['min_price']?></span>');$("#<?php echo $module['module_name'];?>_html .left_label #min_price").focus(); return false;}
		if(max_price==''){$(this).next().html('<span class=fail><?php echo self::$language['please_input'];?><?php echo self::$language['max_price']?></span>');$("#<?php echo $module['module_name'];?>_html .left_label #max_price").focus();return false;}
		if(!$.isNumeric(min_price)){$(this).next().html('<span class=fail><?php echo self::$language['min_price']?><?php echo self::$language['must_be'];?><?php echo self::$language['number'];?></span>');$("#<?php echo $module['module_name'];?>_html .left_label #min_price").focus(); return false;}
		if(!$.isNumeric(max_price)){$(this).next().html('<span class=fail><?php echo self::$language['max_price']?><?php echo self::$language['must_be'];?><?php echo self::$language['number'];?></span>');$("#<?php echo $module['module_name'];?>_html .left_label #max_price").focus();return false;}
*/		
		if(min_price>=max_price && (min_price!='' && max_price!='')){$(this).next().html('<span class=fail><?php echo self::$language['min_price']?><?php echo self::$language['must_be_less_than'];?><?php echo self::$language['max_price'];?></span>');$("#<?php echo $module['module_name'];?>_html .left_label #min_price").focus();return false;}
		url=window.location.href;
		url=replace_get(url,'min_price',min_price);
		url=replace_get(url,'max_price',max_price);
		url=replace_get(url,'current_page',1);
		window.location.href=url;	
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?>_html .left_label #max_price").keyup(function(event){
		 if(event.keyCode==13){
			var min_price=$("#<?php echo $module['module_name'];?>_html .left_label #min_price").val();
			var max_price=$("#<?php echo $module['module_name'];?>_html .left_label #max_price").val();
			if(min_price>=max_price && (min_price!='' && max_price!='')){$(this).next().html('<span class=fail><?php echo self::$language['min_price']?><?php echo self::$language['must_be_less_than'];?><?php echo self::$language['max_price'];?></span>');$("#<?php echo $module['module_name'];?>_html .left_label #min_price").focus();return false;}
			url=window.location.href;
			url=replace_get(url,'min_price',min_price);
			url=replace_get(url,'max_price',max_price);
			url=replace_get(url,'current_page',1);
			window.location.href=url;	
			return false;	
		}
	});
	
	$("#<?php echo $module['module_name'];?> .top_icon").click(function(){
		if($(this).attr('href')!='' && $(this).attr('href')!='#'){window.location.href=$(this).attr('href');}
		return false;	
	});	
});

</script>

<style>
#<?php echo $module['module_name'];?>{}
#<?php echo $module['module_name'];?> k{ }
#<?php echo $module['module_name'];?>_html{ padding-left:10px;}
#<?php echo $module['module_name'];?>_html .top{ display:inline-block; vertical-align:top;  border:1px solid #e7e7e7; border-top:3px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; width:100%; margin-bottom:10px; padding-bottom:10px;}
#<?php echo $module['module_name'];?>_html .top .top_label{ display:inline-block; vertical-align:top; vertical-align:top; width:12%; overflow:hidden; text-align:right; padding-right:10px;  line-height:25px; margin-top:5px; font-size:15px; padding-right:1%; white-space:nowrap; opacity:0.6;}
#<?php echo $module['module_name'];?>_html .top .top_html{ display:inline-block; vertical-align:top; vertical-align:top; overflow:hidden; width:88%;}
#<?php echo $module['module_name'];?>_html .top .top_html a{ display:inline-block; vertical-align:top; height:2rem; line-height:2rem;  margin-bottom:5px; margin-top:5px; font-size:15px; padding-left:0.5rem; padding-right:0.5rem; width:14%; white-space:nowrap; overflow:hidden;text-overflow: ellipsis;}
#<?php echo $module['module_name'];?>_html .top .top_html a:hover{background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;}
#<?php echo $module['module_name'];?>_html .top .top_html .current{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
#<?php echo $module['module_name'];?>_html .list{  border:1px solid #e7e7e7; padding-bottom:20px;}
#<?php echo $module['module_name'];?>_html .list .m_label_div{ display:inline-block; vertical-align:top; height:50px;  border-bottom:1px solid #e7e7e7; width:100%; line-height:50px; background:#f3f3f3;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label{ display:inline-block; vertical-align:top; width:80%; overflow:hidden; height:50px; line-height:50px;}

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div{display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div a{ display:inline-block; vertical-align:top; padding-right:20px; font-size:1.2rem;  padding-left:20px; color:#999; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div a:after {font: normal normal normal 1.2rem/1 FontAwesome;margin-left:5px;	content: "\f0dc";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .current{ }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order{display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order:hover{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc{display:inline-block; vertical-align:top; background:#fff;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc{display:inline-block; vertical-align:top; background:#fff; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc:after{font: normal normal normal 1.2rem/1 FontAwesome;margin-left:5px;content: "\f0d8";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc:after{font: normal normal normal 1.2rem/1 FontAwesome;	margin-left:5px;	content: "\f0d7";}





#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .price_set_div{display:inline-block; vertical-align:top; margin-left:30px; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .price_set_div input{ width:60px;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label{ display:inline-block; vertical-align:top; width:20%; text-align:right; overflow:hidden; }
#<?php echo $module['module_name'];?>_html .ad{ margin-bottom:10px;}

#<?php echo $module['module_name'];?>_html .list .info_list{ }
#<?php echo $module['module_name'];?>_html .list .info_list .line{ white-space:nowrap; height:110px; overflow:hidden; padding:10px;border-bottom:dashed 1px   #E0E0E0;}
#<?php echo $module['module_name'];?>_html .list .info_list .line:hover{ }
#<?php echo $module['module_name'];?>_html .list .info_list .line .icon{ display:inline-block; vertical-align:top; width:12%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .icon img{ width:90%; max-height:110px; border:none;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle{ display:inline-block; vertical-align:top;  overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .price{line-height:110px; display:inline-block; vertical-align:top; width:10%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .price .number{ font-weight:bold;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .title{  padding-bottom:20px;white-space:nowrap;text-overflow: ellipsis;  overflow:hidden; font-size:18px; }
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .content{ height:50px; font-size:1rem;  text-indent:30px; white-space:nowrap;text-overflow: ellipsis; overflow:hidden;}
#layout_left #<?php echo $module['module_name'];?>_html .list .info_list .line .middle .content{ height:25px;}
#layout_right #<?php echo $module['module_name'];?>_html .list .info_list .line .middle .content{ height:25px;}
#layout_left #<?php echo $module['module_name'];?>_html .list .info_list .line{ height:85px;}
#layout_right #<?php echo $module['module_name'];?>_html .list .info_list .line{ height:85px;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .other{}
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .other span{ margin-right:10px; padding-right:15px; display:inline-block;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .other span:after{margin-left:5px;content:"/"; opacity:0.5; }
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .other span:last-child:after{ display:none;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .reflash{  line-height:110px; display:inline-block; vertical-align:top; width:10%; overflow:hidden; }
#<?php echo $module['module_name'];?>_html .top_icon{ font-size:1rem;   border-radius: 5px; overflow:hidden; padding-left:5px; padding-right:5px; }

#<?php echo $module['module_name'];?>_html .circle_filter .circle_1{}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_1 a{ margin-bottom:0px; }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_1 .c{   }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_1 .show_sub{ border-bottom:2px #28A03A solid; }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_1 a:hover{  }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_2{margin-bottom:0.5rem;}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_2 { margin-top:0.5rem; line-height:2rem;}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_2 div{ display:none; }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_2 div a{}
#<?php echo $module['module_name'];?>_html .circle_filter .circle_2 div a:hover{  }
#<?php echo $module['module_name'];?>_html .circle_filter .circle_2 div .c{  }

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<?php echo $module['ad'];?>
    <div class=content>
       
    	<?php echo $module['data']['top_html'];?>
		<div class=list>
			<div class=m_label_div>
            	<div class=left_label>
                	<div class=order_div>
                    	<a href=# desc="" class="sorting"  asc="" ><?php echo self::$language['default'];?></a><a href=# desc="add_time|desc" class="sorting"  asc="add_time|asc" ><?php echo self::$language['add_time'];?></a><a href=# desc="visit|desc" class="sorting"  asc="visit|asc" ><?php echo self::$language['click_quantity'];?></a>
                    </div><div class=price_set_div>
                    	<?php echo self::$language['price_range'];?><input type="text" id=min_price value="<?php echo @$_GET['min_price'];?>" /> - <input type="text" id=max_price value="<?php echo @$_GET['max_price'];?>"  /> <a href="#" class=set_price><?php echo self::$language['submit'];?></a> <span></span>
                    </div>
                </div><div class=right_label>
                </div>
            </div>
			<div class=info_list><?php echo $module['list'];?></div>
        </div>
    </div>
    <?php echo $module['page']?>
</div>
</div>