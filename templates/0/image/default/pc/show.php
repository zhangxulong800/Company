<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
	function screentshot_go(v){
		if(v=='left' || v=='right'){
			event.preventDefault();
			window.location.href="<?php echo $module['go_url'];?>"+$('.'+v+'_div').attr('go');
		}
	}
	function operation_thumb(v){
		event.preventDefault();
		if(v=='up'){$('.list_div').animate({top:-120},"slow");}else{$('.list_div').animate({top:0},"slow");show_thumbs();}
	}

	
    $(document).ready(function(){
		
		
		$.get("<?php echo $module['count_url']?>");
		if(touchAble){
			$("body").attr('ontouchstart',"set_touch_start(event)");
			$("body").attr('ontouchmove',"exe_touch_move(event,'screentshot_go')");
			$("#top_div").attr('ontouchstart',"set_touch_start(event)");
			$("#top_div").attr('ontouchcancel',"exe_touch_move(event,'operation_thumb')");
		}
		
		$("#thumbs_div img").attr('src',"<?php echo get_template_dir(__FILE__);?>img/loading.gif");
		$("#go_right").click(function(){
			offset=$("#thumbs_div").offset();
			o_left=offset.left-$("#thumbs_out_div").width();
			//monxin_alert($("#thumbs_div").width()+o_left);
			if(($("#thumbs_div").width())<$("#thumbs_out_div").width()){
				 $("#go_right img").attr('src',"<?php echo get_template_dir(__FILE__);?>img/go_right_none.png");
				 	
			}
			now_right=$("#thumbs_div a:last").offset().left+$("#thumbs_div a:last").width();
			if($("#thumbs_out_div").width()-now_right<1){
				$("#thumbs_div").animate({left:o_left},"slow");
			}else{
				 $("#go_right img").attr('src',"<?php echo get_template_dir(__FILE__);?>img/go_right_none.png");
				 	
			}
			show_thumbs();	
			return false;
		});
		$("#go_left").click(function(){
			offset=$("#thumbs_div").offset();
			o_left=offset.left+$("#thumbs_out_div").width();
			if(o_left>$("#thumbs_out_div").width()){
				 $("#go_left img").attr('src',"<?php echo get_template_dir(__FILE__);?>img/go_left_none.png");
				 	
			}
			if(o_left>0 && o_left<=$("#thumbs_out_div").width()){
				o_left=0;
				$("#go_left img").attr('src',"<?php echo get_template_dir(__FILE__);?>img/go_left_none.png");
			}
			$("#thumbs_div").animate({left:o_left},"slow");
			show_thumbs();
			return false;
		});
		
		$("#go_left").mouseenter(function(e) {
            $("#go_left img").attr('src',"<?php echo get_template_dir(__FILE__);?>img/go_left_over.png");
        });
		$("#go_left").mouseleave(function(e) {
            $("#go_left img").attr('src',"<?php echo get_template_dir(__FILE__);?>img/go_left.png");
        });
		$("#go_right").mouseenter(function(e) {
            $("#go_right img").attr('src',"<?php echo get_template_dir(__FILE__);?>img/go_right_over.png");
        });
		$("#go_right").mouseleave(function(e) {
            $("#go_right img").attr('src',"<?php echo get_template_dir(__FILE__);?>img/go_right.png");
        });
		$(".return_div a").attr('href',$("#visitor_position a:last").attr('href'));
		show_html=$("#<?php echo $module['module_name'];?>").html();
		try{if(show_html.length>10){$("body").html(show_html);}}catch(e){}

		
		
		$(".induction_div").mouseenter(function(){
			 $(".list_div").animate({top: '+0px'}, "fast");	
		});
		$(".left_div").mouseenter(function(){
			$(".list_div").animate({top: '-150px'}, "fast");	
		});
		$(".right_div").mouseenter(function(){
			$(".list_div").animate({top: '-150px'}, "fast");	
		});
		$(".left_div").unbind("click").click(function(){
			//window.location.href="<?php echo $module['go_url'];?>"+$(this).attr('go');
			prev_img();
			return false;	
		});
		$(".right_div").unbind("click").click(function(event){
			//window.location.href="<?php echo $module['go_url'];?>"+$(this).attr('go');
			next_img();
			return false;
		});
		$(document).unbind("keydown").keydown(function(event){
			if(event.keyCode==37){prev_img();}
			if(event.keyCode==39){next_img();}
			  	
		});	
			
		function prev_img(){
			index=$("#thumbs_div a[id='"+$("#main_img").attr('img_id')+"']").index();
			if(index==0){$(".return_div").css('display','block');return false;}else{$(".return_div").css('display','none');}
			if(index>1){$(".reload").html($(".reload").html()+'<img src="'+$("#thumbs_div img").eq(index-2).attr('osrc').replace(/img_thumb/,'img')+'" />');}
			if(index>2){$(".reload").html($(".reload").html()+'<img src="'+$("#thumbs_div img").eq(index-3).attr('osrc').replace(/img_thumb/,'img')+'" />');}
			$("#main_img").attr('src',$("#thumbs_div img").eq(index-1).attr('osrc').replace(/img_thumb/,'img'));
			$("#main_img").attr('img_id',$("#thumbs_div img").eq(index-1).parent().attr('id'));
			$("title").html($("#thumbs_div img").eq(index-1).attr('title'));
			id=$("#thumbs_div img").eq(index-1).parent().attr('id');
			$.get('./receive.php?target=image.show&act=get_content&id='+id,function(data){
				$(".content").html(data);
			});	
		}
		
		function next_img(){
			index=$("#thumbs_div a[id='"+$("#main_img").attr('img_id')+"']").index();
			if($("#thumbs_div img").eq(index+1).attr('osrc')==undefined){$(".return_div").css('display','block');return false;}else{$(".return_div").css('display','none');}
			if($("#thumbs_div img").eq(index+2).attr('osrc')!=undefined){$(".reload").html($(".reload").html()+'<img src="'+$("#thumbs_div img").eq(index+2).attr('osrc').replace(/img_thumb/,'img')+'" />');}
			if($("#thumbs_div img").eq(index+3).attr('osrc')!=undefined){$(".reload").html($(".reload").html()+'<img src="'+$("#thumbs_div img").eq(index+3).attr('osrc').replace(/img_thumb/,'img')+'" />');}
			$("#main_img").attr('src',$("#thumbs_div img").eq(index+1).attr('osrc').replace(/img_thumb/,'img'));
			$("#main_img").attr('img_id',$("#thumbs_div img").eq(index+1).parent().attr('id'));
			$("title").html($("#thumbs_div img").eq(index+1).attr('title'));
			id=$("#thumbs_div img").eq(index+1).parent().attr('id');
			$.get('./receive.php?target=image.show&act=get_content&id='+id,function(data){
				$(".content").html(data);
			});	
			
		}
		
		$(".list_div").mouseleave(function(){
			 $(".list_div").animate({top: '-150px'}, "fast");	
		});
		$(window).scroll(function(){
			//$(".list_div").offset({ top:0, left: 0});	
		});
		var id=get_param('id');
		now_left=$("#"+id).offset().left;
		out_width=$("#thumbs_out_div").width();
		if(now_left>(out_width/2)){
			now_width=$("#"+id).width()/2;
			now_left=(out_width/2)-now_left-now_width;
			$("#thumbs_div").offset({left:now_left});				
		}
		
		if($("#"+id).prev("a").attr('id')!=undefined){
			prev_id=$("#"+id).prev("a").attr('id');
			$("#preparation_img_div").html($("#preparation_img_div").html()+'<img src='+$("#"+prev_id+" img").attr('osrc')+'>');
		}else{
			prev_id=id;
			//$(".left_div").css('cursor','default');
		}
		if($("#"+id).next("a").attr('id')!=undefined){
			next_id=$("#"+id).next("a").attr('id');
			$("#preparation_img_div").html($("#preparation_img_div").html()+'<img src='+$("#"+next_id+" img").attr('osrc')+'>');
		}else{
			next_id=id;
			//$(".right_div").css('cursor','default');
		}
		$("#preparation_img_div").html($("#preparation_img_div").html().toString().replace(/_thumb/g,''));
		//monxin_alert($("#preparation_img_div").html());
		$(".left_div").attr('go',prev_id);
		$(".right_div").attr('go',next_id);
		$("#top_div").width($(window).width());
		$("#thumbs_div").width($("#thumbs_div img").size()*($("#thumbs_div a").css('width').replace(/px/,'')));
    });
	
	function set_height(){
		if($(window).width()<$("#main_img").width()){$("#main_img").width($(window).width());}
		height=Math.max($("#main_img").height(),$(window).height());
		$(".left_div").css('height',height);
		$(".right_div").css('height',height);
		padding=(height-$("#main_img").height())/2;
		if($("#main_img").height()>$(window).height()){padding=0;}
		$("#main_img").css('margin-top',padding);
		show_thumbs();
	}
	
	
	function show_thumbs(){
		$("#thumbs_div img").each(function(index, element) {
			left=-200-$(window).width();
			right=$(window).width()*2;
            if($(this).offset().left>left && $(this).offset().left<right && $(this).offset().top<10){
				$(this).attr('src',$(this).attr('osrc'));	
			}
        });
	}
    </script>
    <style>
	body{ background:none;}
	#<?php echo $module['module_name'];?>_html{}
	.left_div{
		position:absolute;
		left:0px;
		cursor:url(<?php echo get_template_dir(__FILE__);?>img/left.cur),auto; 
		width:40%;
		height:100%;
		display:inline-block;
		z-index:980;
		
		filter:alpha(opacity=1);
		opacity:0.01;
	}
	.right_div{
		position:absolute;
		right:0px;
		cursor:url(<?php echo get_template_dir(__FILE__);?>img/right.cur),auto;
		width:40%;
		height:100%;
		display:inline-block;
		z-index:980;
		
		filter:alpha(opacity=1);
		opacity:0.01;
	}
	#top_div{ position: fixed;width:1170px; height:120px;  z-index:990;}
	.list_div{position:absolute;width:100%;  height:120px;top:-120px;overflow:hidden;  z-index:999;}
	#thumbs_out_div{ display:inline-block;width:80%; overflow:hidden; float:left;}
	#thumbs_div{ position:relative; display:inline-block;width:100%; }
	#thumbs_div a{display:inline-block;overflow:hidden;height:120px; width:120px; text-align:center;}
	#thumbs_div img{height:120px;border:0px;}
	.induction_div{
		width:100%; height:120px; z-index:999;
	}
	#main_img_div{ text-align:center;}
	#main_img{}
	
	#operator_div{float:right; width:20%; height:120px; display:inline-block; text-align:center;}
	#logo{ height:50px; }
	#logo img{ height:50px; border:0px; }
	#go_left{ display:inline-block; height:60px; font-size:60px; width:35%; height:40px; line-height:40px;}
	#go_right{display:inline-block; font-size:60px; height:25px; width:35%; height:40px; line-height:40px;}
	#go_left:before{font: normal normal normal 3rem/1 FontAwesome; content:"\f100"; text-shadow: -2px -2px 2px #0D0D0D, 0px 0px 5px #aaa;}
	#go_right:before{font: normal normal normal 3rem/1 FontAwesome; content:"\f101";text-shadow: -2px -2px 2px #0D0D0D, 0px 0px 5px #aaa;}
	#<?php echo $module['module_name'];?>_html .content{ text-align:center; padding:20px;}
	#operator_div a:hover{ opacity:0.8;}
	.return_div{ position:absolute; text-align:center; z-index:99999; height:100px; line-height:100px; top:40%;width:30%; left:35%;  display:none; border:10px solid #999; font-size:30px;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html>
    <div class="left_div">&nbsp;</div>
	<div class="right_div">&nbsp;</div>
	<div id=top_div>
    	<div class="list_div">
        <div id=thumbs_out_div><div id=thumbs_div><?php echo $module['thumbs'];?></div></div>
        <div id=operator_div>
    			<a href="./index.php" id=logo><img src=./logo.png></a>
        <br/><a href="#" id=go_left></a><a href="#" id=go_right></a>
        </div></div>
		<div class="induction_div">&nbsp;</div>
    </div>
    <div id=main_img_div><img id=main_img img_id=<?php echo @$_GET['id'];?> src=<?php echo $v['src']?> onload=set_height()></div>
	<div class="content"><?php echo $v['content'];?></div>
    </div>
    <div id=preparation_img_div  style="display:none;"></div>
    <div class=return_div><a href=#><?php echo self::$language['return'];?></a></div>
    <div class=reload style="display:block; height:1px; width:1px; padding:10px; overflow:hidden;"><br /><br /></div>
</div>
