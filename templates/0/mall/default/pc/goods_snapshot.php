<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script>
    $(document).ready(function(){

	$("#<?php echo $module['module_name'];?> #show_left").click(function(){
		show_left();
		return false;
	});
	$("#<?php echo $module['module_name'];?> #show_right").click(function(){
		show_right();
		return false;
	});
	if(touchAble){
		$("#auto_width_div").attr('ontouchstart',"set_touch_start(event)");
		$("#auto_width_div").attr('ontouchcancel',"exe_touch_move(event,'touch_right_and_left')");
	}

	$("#auto_width_div a").click(function(){
		$("#show_thumb_div img").attr('src',$(this).children().attr('src').replace(/img_thumb/,'img'));
		$("#show_thumb_div").attr('href',$(this).children().attr('src').replace(/img_thumb/,'img'));
		$("#auto_width_div a").attr('class','');
		$(this).attr('class','current');
		$('.cloud-zoom').CloudZoom();
		return false;
	});
	$("#auto_width_div a").hover(function(){
		$("#show_thumb_div img").attr('src',$(this).children().attr('src').replace(/img_thumb/,'img'));
		$("#show_thumb_div").attr('href',$(this).children().attr('src').replace(/img_thumb/,'img'));
		$("#auto_width_div a").attr('class','');
		$(this).attr('class','current');
		$('.cloud-zoom').CloudZoom();
		return false;
	});


    });

	function touch_right_and_left(v){
		if(v=='left' || v=='right'){
			//alert(v);
			if(v=='left'){
				show_left();
			}else{
				show_right();
			}
			event.preventDefault();
		}
	}
	function show_left(){
		thumb_left=$("#<?php echo $module['module_name'];?> #auto_width_div").offset().left;
		if(thumb_left>=0){return false;}
		$("#<?php echo $module['module_name'];?> #auto_width_div").css('left',Math.min(0,thumb_left+$("#fix_width_div").width()+30));
		$("#<?php echo $module['module_name'];?> #show_right").attr('class','show_right_able');
		if(thumb_left+$("#fix_width_div").width()>=0){$("#<?php echo $module['module_name'];?> #show_left").attr('class','show_left_disable');}
		return false;
	}
	function show_right(){
		thumb_left=$("#<?php echo $module['module_name'];?> #auto_width_div").offset().left;
		if(Math.abs(thumb_left)-$("#<?php echo $module['module_name'];?> #auto_width_div").width()>=0){return false;}
		$("#<?php echo $module['module_name'];?> #show_left").attr('class','show_left_able');
		$("#<?php echo $module['module_name'];?> #auto_width_div").css('left',thumb_left-$("#fix_width_div").width()-30);
		if(Math.abs(thumb_left-$("#fix_width_div").width())>=$("#<?php echo $module['module_name'];?> #auto_width_div").width()){$("#<?php echo $module['module_name'];?> #show_right").attr('class','show_right_disable');}
		return false;
	}

    </script>
    <style>
    #<?php echo $module['module_name'];?>{ overflow:hidden;}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html #goods_act_div{ white-space:nowrap; width:98%; margin:10px;  box-shadow:0px 0px 10px 0px rgba(0,0,0,.3);}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div{vertical-align:top;  width:500px; height:500px; display:inline-block; vertical-align:top; text-align:center; padding-left:10px; padding-top:10px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #show_thumb_div_out{ text-align:center; width:100%; height:380px; line-height:380px; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #show_thumb_div{ display:block; text-align:center;height:380px; line-height:380px; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #show_thumb_div img{ max-height:340px; max-width:500px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div{text-align:center; width:100%; height:100px; line-height:100px; margin-top:10px;}

    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div #show_left{vertical-align:top; display:inline-block; vertical-align:top; height:100%; width:25px; margin:0px; border:none;  opacity:1.0;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_left_able{background-image:url(<?php echo get_template_dir(__FILE__);?>img/show_left.png);}
	#<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_left_able:hover{background-image:url(<?php echo get_template_dir(__FILE__);?>img/show_left_hover.png);}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_left_disable{background-image:url(<?php echo get_template_dir(__FILE__);?>img/show_left.png);}
	#<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_left_disable:hover{background-image:url(<?php echo get_template_dir(__FILE__);?>img/show_left.png);}

    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div #show_right{vertical-align:top;   display:inline-block; vertical-align:top; height:100%; width:25px; margin:0px; border:0px;  opacity:1.0;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_right_able{background-image:url(<?php echo get_template_dir(__FILE__);?>img/show_right.png);}
     #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_right_able:hover{background-image:url(<?php echo get_template_dir(__FILE__);?>img/show_right_hover.png);}
   #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_right_disable{background-image:url(<?php echo get_template_dir(__FILE__);?>img/show_right.png);}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .show_right_disable:hover{background-image:url(<?php echo get_template_dir(__FILE__);?>img/show_right.png);}

    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div #fix_width_div{width:450px; overflow:hidden;  display:inline-block; vertical-align:top; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div #auto_width_div{white-space:nowrap; position:relative; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div a{vertical-align:top; text-align:center;  display:inline-block; vertical-align:top; width:100px; height:100px; overflow:hidden; margin-left:5px; margin-right:5px; border:1px solid #ddd;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .current{ border:3px solid #ff3200; padding:5px; width:86px; height:86px; opacity:1.0;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div .current img{ width:86px; height:86px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #thumb_img_div #thumb_list_div a img{ height:100px; width:100px;border:none; }
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div{vertical-align:top; white-space:normal; padding-bottom:20px;display:inline-block; vertical-align:top;  width:799px; min-height:500px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .title{ font-size:24px;  line-height:40px; display:inline-block; vertical-align:top; height:40px; overflow:hidden; margin-top:10px; margin-left:10px;}
    #<?php echo $module['module_name'];?>_html #goods_act_div #act_div .advantage{ /*font-family:"SimSun"; */font-size:15px;  line-height:20px; max-height:39px; overflow:hidden; margin-bottom:10px; margin-left:10px; padding-right:20px; text-indent:30px;}


	/* 这是下方的鼠标指针的移动镜头平方米。 */
	.cloud-zoom-lens {border: 4px solid #888;margin:-4px;cursor:move;}
	/* 这是标题文本 */
	.cloud-zoom-title {font-family:Arial, Helvetica, sans-serif;position:absolute !important;padding:3px;width:100%;text-align:center;font-weight:bold;font-size:10px;top:0px;}
	/* 这是缩放窗口。 */
	.cloud-zoom-big {border:4px solid #ccc;overflow:hidden;}
	/* 这是加载消息。 */
	.cloud-zoom-loading {background:#222;padding:3px;border:1px solid #000;}



	#<?php echo $module['module_name'];?>_html #goods_detail_div{ margin-top:15px;  border:1px solid #e7e7e7; border-top:0px;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div img{ max-width:100%;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div{ border:1px solid #e7e7e7; height:60px; line-height:60px; display:inline-block; vertical-align:top; width:99.8%; font-size:20px; }
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div a{ display:inline-block; vertical-align:top; width:160px; text-align:center; border-top:3px solid #f3f3f3;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div a:hover{ font-weight:bold;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #m_label_div .current{   border-top:3px solid #ff3200;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail{}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute{ width:92%; padding:2%;   border-top:none; margin:2%; border:1px solid #e7e7e7;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute div{ display:inline-block; vertical-align:top; width:33%;  display:inline-block; vertical-align:top; height:30px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute div .a_label{ display:inline-block; vertical-align:top; margin-right:8px; width:70px; text-align:right; overflow:hidden; height:30px; vertical-align:top;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_attribute div .a_value{  vertical-align:top;}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_detail_html{ margin-top:20px; width:95.8%; padding:2%}
	#<?php echo $module['module_name'];?>_html #goods_detail_div #goods_detail #goods_detail_html img{}
	#<?php echo $module['module_name'];?>_html .snapshot_div{ line-height:80px; padding-left:10px; font-style:oblique;}
	#<?php echo $module['module_name'];?>_html .view_newest{ line-height:30px; padding-left:10px;}
	#<?php echo $module['module_name'];?>_html .view_newest a{ display:inline-block;   text-align:center; padding:10px;}
    </style>
    <script src=<?php echo get_template_dir(__FILE__);?>/zoom.js></script>

    <div id="<?php echo $module['module_name'];?>_html">
    	<div id=color_selected_symbol>&nbsp;</div><div id=option_selected_symbol>&nbsp;</div>
    	<div id="goods_act_div">
        	<div id="thumb_img_div">
            	<div id=show_thumb_div_out><a id=show_thumb_div href="./program/mall/img/<?php echo $module['data']['icon']?>"  class = 'cloud-zoom'><img src="./program/mall/img/<?php echo $module['data']['icon']?>" /></a></div>
                <div id=thumb_list_div><a href="" id=show_left class="show_left_disable">&nbsp;</a><div id=fix_width_div><div id=auto_width_div><?php echo $module['data']['thumb_list'];?></div></div><a href="" id=show_right class="show_right_able">&nbsp;</a></div>
            </div><div id="act_div">
            	<div class=title><?php echo $module['data']['title'];?></div>
            	<div class=advantage><?php echo $module['data']['advantage'];?></div>
                <div class=snapshot_div><span class=m_label><?php echo self::$language['goods_snapshot']?>: </span><span class=value><?php echo $module['time_limit'];?></span></div>
                <div class=view_newest><a href="./index.php?monxin=mall.goods&id=<?php echo $module['data']['goods_id']?>"><?php echo self::$language['view_newest'];?></a></div>
            </div>
        </div>
    	<div id="goods_detail_div">
        	<div id=m_label_div><a href="#" id=detail_label class=current><?php echo self::$language['goods_detail'];?></a></div>
            <div id=goods_detail>
            	<div id=goods_attribute>
                	<?php echo $module['data']['attribute'];?>
                </div>
                <div id=goods_detail_html><?php echo $module['data']['detail'];?></div>
            </div>
        </div>
    </div>
</div>

