<!---------------------------------------------------------------------------------------------slider_show_start-->
<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align="center"  style="display:block;height:<?php echo $module['height']?>; "  monxin_slider=1>
	<script>
	$(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .swipe-wrap a").each(function(i,e){
			$("#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html #position").html($("#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html #position").html()+'<li onClick="swipe_go('+i+')"></li>');
		});
		if('<?php echo $module['width']?>'=='100%'){
			$("#<?php echo $module['module_name'];?>").css('width',$("#<?php echo $module['module_name'];?>").parent().width());
			$("#<?php echo $module['module_name'];?>").css('height',$("#<?php echo $module['module_name'];?>").parent().width()*<?php echo $module['height_int']?>/100);
			mySwiper.resizeFix();
			mySwiper.reInit();
					
			$(window).resize(function() {
					$("#<?php echo $module['module_name'];?>").css('width',$("#<?php echo $module['module_name'];?>").parent().width());
					$("#<?php echo $module['module_name'];?>").css('height',$("#<?php echo $module['module_name'];?>").parent().width()*<?php echo $module['height_int']?>/100);
					mySwiper.resizeFix();
					mySwiper.reInit();
		
			});	
		}
	});
	</script>
 <link rel="stylesheet" href="./public/idangerous.swiper.css">
	<style>
#index_navigation{ border-bottom:none; margin-bottom:0px;}
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html{width:100%; height:100%;}

    </style>
    <div id="<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html">
    



<style>
.swiper-container {
	width:100%;
	height:100%;
}
.swiper-container img{
	width:100%;
	height:100%;
}

.content-slide {
  padding: 20px;
  
}

.title {
  font-size: 25px;
  margin-bottom: 10px;
}
.pagination {
white-space:nowrap;
  position: absolute;
  left: 0;
  text-align: center;
  bottom:-15px;
  width: 100%;
}
.swiper-pagination-switch {
	opacity:0.3;
  display: inline-block;
  width: 1.2rem;
  height: 1.2rem;
  border-radius: 50%;
  background: #666;
  margin: 0 10px;
  cursor: pointer;
  border:2px solid  #666;
}
.swiper-pagination-switch:hover{ background: #fff;}
.swiper-active-switch {
  background: #fff;
}
.next_prev{position: relative; top:-55%;  z-index:999999999; padding-left:2rem; padding-right:2rem; }
.next_prev a{ width:2rem; height:3rem; line-height:3rem; border-radius:5px; display:inline-block; text-align:center; color:#fff !important;}
.next_prev a:hover{ background:#756f67; }
.mySwiper-left{ float:left; margin-left:-3px; width:1rem; height:2rem;   left:0px;}
.mySwiper-left:before{font: normal normal normal 35px/1 FontAwesome;content:"\f104";}
.mySwiper-left:hover{ }
.mySwiper-right{ float:right; margin-right:3px; width:1rem; height:2rem;   left:0px;}
.mySwiper-right:before{font: normal normal normal 35px/1 FontAwesome;content:"\f105";}
.mySwiper-right:hover{ }

#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text{ position:relative; top:-100%; color:#fff; padding-left:10%; }
#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text a{color:#fff;}
#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text .slider_name{ font-size:4rem; font-weight:bold; line-height:7.14rem; height:7.14rem!important; }
#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text .slider_description{ padding:1rem;  line-height:4rem; height:13rem!important; font-size:2rem; opacity:0; }
#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text .slider_summary{ line-height:3rem; height:3rem!important;  opacity:0;  }
#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text .slider_summary a{ display:inline-block; border:1px solid #FFF; border-radius:0.5rem; padding:0.5rem;font-size:2rem;}
</style>
<div id='mySwipe' class="swiper-container">
    <div class='swiper-wrapper'>
    	<?php echo $module['imgs']?>
    </div>
   <div class="pagination"></div>
    <div class=next_prev><a class="mySwiper-left" href="#"></a>     <a class="mySwiper-right" href="#"></a></div>
</div>
 
 <script src='./public/idangerous.swiper.js'></script>
  <script>
  var mySwiper = new Swiper('.swiper-container',{
    pagination: '.pagination',
	autoplay : 5000,
    loop:true,
    grabCursor: true,
	autoResize : true,
    paginationClickable: true,
	onInit: function(swiper){show_other(swiper.activeIndex);},
	onSlideChangeEnd: function(swiper){
			show_other(swiper.activeIndex);
    }	
  })
 
	function show_other(index){
		id=$('.swiper-wrapper .swiper-slide').eq(index).attr('id');
		$("#"+id+' .slider_description').animate({opacity:1},100,function(){$(this).next().animate({opacity:1},800);});
	}  
  
  $(document).on('click','.mySwiper-left', function(e){
    e.preventDefault()
    mySwiper.swipePrev()
  })
  $(document).on('click', '.mySwiper-right',function(e){
    e.preventDefault()
    mySwiper.swipeNext()
  })
	
</script>
   
    </div>
</div>
<!---------------------------------------------------------------------------------------------slider_show_end-->
