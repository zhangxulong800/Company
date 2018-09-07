<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
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
			$(this).parent().parent().prev('.top_label').html('<?php echo self::$language['circle']?>: '+$(this).html());
			$(this).parent().parent().parent().prev('.top_label').html('<?php echo self::$language['circle']?>: '+$(this).html());
			$("#<?php echo $module['module_name'];?> .top .circle_filter a").removeClass('current');
			$(this).addClass('current');
			$(".determine").attr('href',replace_get($(".determine").attr('href'),'circle',$(this).attr('circle')));
			return false;	
		});
		circle=get_param('circle');
		if(circle==''){circle=getCookie('circle');}
		$("#<?php echo $module['module_name'];?>  .circle_filter a[circle='"+circle+"']").addClass('current');
		
		if($("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().attr('upid')){
			$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().css('display','block');
			$("#<?php echo $module['module_name'];?> a[circle='"+$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().attr('upid')+"']").addClass('show_sub');
		}
		
		
		
	
	
	$("#<?php echo $module['module_name'];?> .reflash").each(function(index, element) {
		$(this).prev().children('.other').html('<span class=reflash_time>'+$(this).html()+'</span>'+$(this).prev().children('.other').html());
        //	$(this).appendTo($(this).prev().children('.other').children('span:first-child'));
    });
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
	
	temp=get_param('min_price');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #price a[min_price='"+temp+"'][max_price='"+get_param('max_price')+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #price a[min_price='-1']").attr('class','current');}

	
	temp=get_param('min_price');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #price a[min_price='"+temp+"'][max_price='"+get_param('max_price')+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #price a[min_price='-1']").attr('class','current');}
	
	
	$("#<?php echo $module['module_name'];?> #type_a_<?php echo @$_GET['type'];?>").addClass('current');
	if(''!='<?php echo @$_GET['show_method'];?>'){
		$("#<?php echo $module['module_name'];?>_html #<?php echo @$_GET['show_method'];?>").attr('class','<?php echo @$_GET['show_method'];?>_current');
	}else{
		$("#<?php echo $module['module_name'];?>_html #show_grid").attr('class','show_grid_current');
	}
	
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
	
	
	$("#<?php echo $module['module_name'];?> .top_icon").click(function(){
		if($(this).attr('href')!='' && $(this).attr('href')!='#'){window.location.href=$(this).attr('href');}
		return false;	
	});	
	
	$("#visitor_position_reset").insertBefore("#<?php echo $module['module_name'];?> .top .diy_price");
	$("#visitor_position_reset").css('display','block');
	
	$("#<?php echo $module['module_name'];?> .determine").attr('href',window.location.href);
	$("#<?php echo $module['module_name'];?> .top #type a").click(function(){
		$(this).parent().prev('.top_label').html('<?php echo self::$language['type']?>: '+$(this).html());
		$("#<?php echo $module['module_name'];?> .top #type a").removeClass('current');
		$(this).addClass('current');
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'type',$(this).attr('id').replace(/type_a_/,'')));
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?> .top #price a").click(function(){
		$(this).parent().prev('.top_label').html('<?php echo self::$language['type_price']?>: '+$(this).html());
		$("#<?php echo $module['module_name'];?> .top #price a").removeClass('current');
		$(this).addClass('current');
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'min_price',$(this).attr('min_price')));
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'max_price',$(this).attr('max_price')));
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?> .top .attribute a").click(function(){	
		$(this).parent().prev('.top_label').html($(this).parent().prev('.top_label').attr('old_name')+': '+$(this).html());
		$(this).parent().children('a').removeClass('current');
		$(this).addClass('current');
		if($(this).html()=='<?php echo self::$language['unlimited']?>'){
			$(".determine").attr('href',replace_get($(".determine").attr('href'),$(this).parent().parent().attr('id'),''));
		}else{
			$(".determine").attr('href',replace_get($(".determine").attr('href'),$(this).parent().parent().attr('id'),$(this).html()));
		}
		
		return false;
	});
	
	temp=get_param('min_price');
	if(temp!=''){$("#<?php echo $module['module_name'];?> #price a[min_price='"+temp+"'][max_price='"+get_param('max_price')+"']").attr('class','current');}else{$("#<?php echo $module['module_name'];?> #price a[min_price='-1']").attr('class','current');}
	
	temp=get_param('min_price');
	if(!isNaN(temp)){$("#<?php echo $module['module_name'];?>_html .top .diy_price .min_price").val(temp);}
	temp=get_param('max_price');
	if(!isNaN(temp)){$("#<?php echo $module['module_name'];?>_html .top .diy_price .max_price").val(temp);}
	

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
	
	$("#<?php echo $module['module_name'];?> .top_html .current").each(function(index, element) {
        $(this).parent().prev('.top_label').html( $(this).parent().prev('.top_label').html()+' '+$(this).html());
    });
	
	
	
	
	
	$("#<?php echo $module['module_name'];?> .option_div").click(function(){
		
		if(!$("#<?php echo $module['module_name'];?> .top").html()){
			window.history.back(-1);
		}else{
			$("#<?php echo $module['module_name'];?> .top").animate({left:'0px'},'fast');
			$("#<?php echo $module['module_name'];?> .top .confirm_div").animate({left:'0px'},'fast');
		}
		return false;
	});
	
	$("#<?php echo $module['module_name'];?> .determine").click(function(){
		
		var min_price=parseFloat($("#<?php echo $module['module_name'];?>_html .top .diy_price .min_price").val());
		var max_price=parseFloat($("#<?php echo $module['module_name'];?>_html .top .diy_price .max_price").val());
		if(min_price>=max_price && (min_price!='' && max_price!='')){max_price=min_price;}
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'current_page',1));
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'min_price',min_price));
		$(".determine").attr('href',replace_get($(".determine").attr('href'),'max_price',max_price));
		
		
		if(!$("#<?php echo $module['module_name'];?> .top #type .current").attr('id')){
			$(this).attr('href',$(this).attr('href')+'&type='+get_param('type'));
		}
	});
	
	$("#<?php echo $module['module_name'];?> .left_return").click(function(){
		
		$("#<?php echo $module['module_name'];?> .top").animate({left:'-100%'},'fast');
		$("#<?php echo $module['module_name'];?> .top .confirm_div").animate({left:'-100%'},'fast');
		return false;
	});
	
	
});

</script>

<style>
#<?php echo $module['module_name'];?>{}
#<?php echo $module['module_name'];?> k{ }
#<?php echo $module['module_name'];?>_html{}

#<?php echo $module['module_name'];?>_html .top{ width:100%; height:100%; padding:1rem; position:fixed; left:-100%; z-index:9999999999999999999999999; padding-bottom:8rem;  overflow:scroll; background:#fff;}

#<?php echo $module['module_name'];?>_html .top .diy_price{ line-height:2rem; }
#<?php echo $module['module_name'];?>_html .top .diy_price input{ width:35%; padding:2px; }
#<?php echo $module['module_name'];?>_html .top .diy_price span:first-child{ display:inline-block; vertical-align:top; width:35%; overflow:hidden; text-align:left; }
#<?php echo $module['module_name'];?>_html .top .diy_price span:last-child{ display:inline-block; vertical-align:top; width:65%; overflow:hidden; text-align:right; }

#<?php echo $module['module_name'];?>_html .top .top_label{ line-height:2rem; display:block; border-bottom: 1px solid #333; margin-top:1rem; margin-bottom:1rem;}
#<?php echo $module['module_name'];?>_html .top .top_label:after{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f078"; float:right; margin-top:0.5rem;}
#<?php echo $module['module_name'];?>_html .top .top_html{ }
#<?php echo $module['module_name'];?>_html .top .top_html a{ white-space:nowrap; overflow:hidden;text-overflow: ellipsis; display:inline-block;  border-radius:6px; margin:5px; padding:5px; background:#f2f2f2;}
#<?php echo $module['module_name'];?>_html .top .top_html a:hover{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;  }
#<?php echo $module['module_name'];?>_html .top .top_html .current{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }

#<?php echo $module['module_name'];?>_html .top #type a{ width:47%;}


#<?php echo $module['module_name'];?>_html .top .confirm_div{  width:100%; z-index:99999999999999999999999999999; position: fixed; width:100%; bottom:0px; left:-100%; text-align:right; border-top: #dadada solid 1px; line-height:4rem; font-size:1.2rem; background:#fff;}
#<?php echo $module['module_name'];?>_html .top .confirm_div a{ display:inline-block; vertical-align:top; width:50%; text-align:center;}
#<?php echo $module['module_name'];?>_html .top .confirm_div a:hover{ opacity:0.5;}
#<?php echo $module['module_name'];?>_html .top .confirm_div a:last-child{  }
#<?php echo $module['module_name'];?>_html .top .confirm_div .left_return:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f053";}

#<?php echo $module['module_name'];?>_html .top #type a{ width:47%;}



#<?php echo $module['module_name'];?>_html .list{  border:1px solid #e7e7e7; padding-bottom:20px;}
#<?php echo $module['module_name'];?>_html .list .m_label_div{ display:inline-block; vertical-align:top; height:3rem;  border-bottom:1px solid #e7e7e7; width:100%; line-height:3rem;background:#f3f3f3;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label{ display:inline-block; vertical-align:top; width:80%; overflow:hidden; }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div{display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div a{ display:inline-block; vertical-align:top; padding-right:20px; font-size:1rem;  padding-left:1rem;color:#999;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div a:after {font: normal normal normal 1rem/1 FontAwesome;margin-left:5px;	content: "\f0dc";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .current{ }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order{display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order:hover{ }

#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc{display:inline-block; vertical-align:top;background:#fff;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;   }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc{display:inline-block; vertical-align:top; background:#fff;color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;  }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_asc:after{font: normal normal normal 1rem/1 FontAwesome;margin-left:5px;content: "\f0d8";}
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .order_div .order_desc:after{font: normal normal normal 1rem/1 FontAwesome;	margin-left:5px;	content: "\f0d7";}





#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .price_set_div{display:inline-block; vertical-align:top; margin-left:30px; }
#<?php echo $module['module_name'];?>_html .list .m_label_div .left_label .price_set_div input{ width:60px;}
#<?php echo $module['module_name'];?>_html .list .m_label_div .right_label{ display:inline-block; vertical-align:top; width:20%; text-align:right; overflow:hidden; }
#<?php echo $module['module_name'];?>_html .right_label .option_div{ display:inline-block; vertical-align:top; padding-right:0.5rem; overflow:hidden;text-align:right;}
#<?php echo $module['module_name'];?>_html .right_label .option_div:after{ padding-left:2px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da";}

#<?php echo $module['module_name'];?>_html .ad{ margin-bottom:10px;}

#<?php echo $module['module_name'];?>_html .list .info_list{ }
#<?php echo $module['module_name'];?>_html .list .info_list .line{ white-space:nowrap;  overflow:hidden; padding:10px;border-bottom:dashed 1px  #CCCCCC;}

#<?php echo $module['module_name'];?>_html .list .info_list .line .icon{ display:inline-block; vertical-align:top; width:20%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .icon img{ width:96%; border:none;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle{ display:inline-block; vertical-align:top; width:80% !important;  overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .price{line-height:110px; display:inline-block; vertical-align:top; width:10%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .price .number{ font-weight:bold;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .title{ display:block; white-space:nowrap;text-overflow:ellipsis; width:100%; height:1.6rem;  overflow:hidden; }
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .content{ font-size:1rem;  height:1.6rem; text-indent:30px; white-space:nowrap;text-overflow: ellipsis; overflow:hidden;}
#layout_left #<?php echo $module['module_name'];?>_html .list .info_list .line .middle .content{ height:25px;}
#layout_right #<?php echo $module['module_name'];?>_html .list .info_list .line .middle .content{ height:25px;}
#layout_left #<?php echo $module['module_name'];?>_html .list .info_list .line{ height:85px;}
#layout_right #<?php echo $module['module_name'];?>_html .list .info_list .line{ height:85px;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .other{}
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .other span{ margin-right:10px; padding-right:15px; display:inline-block;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .other span:after{margin-left:5px;content:"/"; opacity:0.5; }
#<?php echo $module['module_name'];?>_html .list .info_list .line .middle .other span:last-child:after{ display:none;}
#<?php echo $module['module_name'];?>_html .list .info_list .line .reflash{ display:none;}
#<?php echo $module['module_name'];?>_html .top_icon{ font-size:1rem;   border-radius: 5px; overflow:hidden; padding-left:5px; padding-right:5px; }

#visitor_position_reset{ display:block; line-height:2rem; border-bottom:#e8e8e8 solid 1px; margin-bottom:1rem;}
#visitor_position_reset #current_position_text{ display:none;}
#visitor_position_reset a[href='./index.php']{ display:none;}
#visitor_position_reset a:after{ font: normal normal normal 1rem/1 FontAwesome;	margin:0 5px;	content: "\f105";}


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
                    </div>
                </div><div class=right_label><a href=# class=option_div><?php echo self::$language['screening'];?></a>
                </div>
            </div>
			<div class=info_list><?php echo $module['list'];?></div>
        </div>
    </div>
    <?php echo $module['page']?>
</div>
</div>