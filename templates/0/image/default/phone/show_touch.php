<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script>
    $(document).ready(function(){
		$(".return_div").attr('href',$("#visitor_position_reset a:last").attr('href'));
	$("#<?php echo $module['module_name'];?> .touch_position .sum").html($("#<?php echo $module['module_name'];?>_html .swipe-wrap li").length);
	
	$("#<?php echo $module['module_name'];?>_html .swipe-wrap li").each(function(i,e){
		if($(this).children('img').attr('osrc')=='<?php echo $v['src'];?>'){
			$(this).children('img').attr('src',$(this).children('img').attr('osrc'));
			swipe_go(i);
		}
	});
		
    });
    </script>

    <style>
	#index_visitor_position{ display:none;}
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{ padding-top:10px;}
    #mySwipe {
        max-width: 100%;
        margin: 0 auto;
    }

    #mySwipe div b {
        position: absolute;
        width: 100%;
        bottom: 0;
        display: block;
        font-weight: bold;
        
        font-size: 1rem;
        text-align: left;
        /*margin-top: 200px;*/
        padding: 5px 0;
        /*padding-left: 10px;*/
        /*box-shadow: 0 1px #EBEBEB;*/
        background: rgba(0, 0, 0, 0.6);
    }

    .swipe {
        overflow: hidden;
        visibility: hidden;
        position: relative;
    }

    .swipe-wrap {
        overflow: hidden;

        position: relative;
    }

    .swipe-wrap > li {
        float: left;
        width: 100%;
        position: relative;
		list-style:none;
    }

    #position {
		width:100%;
        position: fixed;
        bottom: 20px;
        text-align: center;
        list-style: none;
        margin: auto;
        padding: auto;
    }

    #position li {
		
        display: inline-block;
        width: 20px;
        height: 20px;
        /* border-radius: 10px;*/
        background: #ffffff;
		opacity:0.5;
        /*box-shadow: inset 0 1px 3px black,0 0 1px 1px #0f6b00;*/
        margin: 0 10px;
        cursor: pointer;
    }

    #position li.on {
        box-shadow: inset 0 1px 3px -1px #f2cd01, 0 1px 2px rgba(0, 0, 0, .5);
        
        background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #f2cd01), color-stop(100%, #b0970c));
        background-image: -webkit-linear-gradient(top, #f2cd01, #b0970c);
        background-image: -moz-linear-gradient(top, #f2cd01, #b0970c);
        background-image: -ms-linear-gradient(top, #f2cd01, #b0970c);
        background-image: -o-linear-gradient(top, #f2cd01, #b0970c);
        background-image: linear-gradient(top, #f2cd01, #b0970c);
    }

    .img img {
        display: block;
        /*height: 174px;*/
    }
	.swipe-wrap li{ display:block; min-height:1300px;}
	.swipe-wrap img{ width:100%;}
	#index_navigation{ display:none;}
	.touch_position{ opacity:0.6; position:fixed; bottom:3.5rem;   width:100%; white-space:nowrap;line-height:2rem;}
	.touch_position_left{  padding-left:0.5rem; display:inline-block; vertical-align:top; width:80%;padding-right:1%; overflow:hidden;}
	.touch_position .return_div{ display:inline-block; vertical-align:top; text-align:right; width:19%; overflow:hidden; padding-right:0.5rem;;}
	.touch_position span{ margin-right:10px;}
	#<?php echo $module['module_name'];?>_html .content{ text-align:center; padding:20px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    <div id='mySwipe' class='swipe'>
        <div class='swipe-wrap'>
          <?php echo $module['img_list'];?>
        </div>
        <ul id="position"></ul>
    </div>
    <div class=touch_position><div class=touch_position_left><span class="current"></span>/<span class=sum></span><span class=title></span></div><a href=# class=return_div><?php echo self::$language['return'];?></a></div>

<script src='<?php echo get_template_dir(__FILE__);?>swipe.js'></script>
<script>
    var elem = document.getElementById('mySwipe');
    var bullets = document.getElementById('position').getElementsByTagName('li');
    window.mySwipe = Swipe(elem, {
        startSlide: 0,
        auto: 0,
        continuous: false,
         transitionEnd: function(index, element) {
			$("title").html($("#<?php echo $module['module_name'];?> .swipe-wrap li").eq(index).children('img').attr('title'));
		 }
		
    });

function swipe_go(i){
	  $(".swipe-wrap li").eq(i).prev().children('img').attr('src',$(".swipe-wrap li").eq(i).prev().children('img').attr('osrc'));
	  $(".swipe-wrap li").eq(i).next().children('img').attr('src',$(".swipe-wrap li").eq(i).next().children('img').attr('osrc'));
	  $(".touch_position .current").html(i+1);
	  //$(".swipe-wrap").css('height',$(".swipe-wrap li").eq(index).next().children('img').height());
	  // alert($(".swipe-wrap li").eq(index).children('img').attr('title'));
	  if($(".swipe-wrap li").eq(i).children('img').attr('title')=='/'){$(".swipe-wrap li").eq(i).children('img').attr('title','');}
	  //$(".touch_position .title").html($(".swipe-wrap li").eq(i).children('img').attr('title'));
	  //$("title").html($(".touch_position .title").html());
	$(".swipe-wrap img").eq(i).attr('src',$(".swipe-wrap img").eq(i).attr('osrc'));
	id=$(".swipe-wrap li").eq(i).children('img').attr('id');
	if($("#"+id).next('.content').html()==null){
		$.get('./receive.php?target=image.show&act=get_content&id='+id,function(data){
			$("<div class=content>"+data+"</div>").insertAfter("#"+id);
		});	
	}
	mySwipe.slide(i,1);
	return  false;	
}

$("#<?php echo $module['module_name'];?> .touch_position .sum").html($("#<?php echo $module['module_name'];?>_html .swipe-wrap li").length);

$("#<?php echo $module['module_name'];?>_html .swipe-wrap li").each(function(i,e){
	if($(this).children('img').attr('osrc')=='<?php echo $v['src'];?>'){swipe_go(i);}
});
</script>
    
    </div>
</div>

