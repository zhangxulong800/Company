<!---------------------------------------------------------------------------------------------slider_show_start-->
<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align="center"  style="display:inline-block;height:<?php echo $module['height']?>; ">
	<script>
	$(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .swipe-wrap a").each(function(i,e){
			$("#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html #position").html($("#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html #position").html()+'<li onClick="swipe_go('+i+')"></li>');
		});
		if('<?php echo $module['width']?>'=='100%'){
			$("#<?php echo $module['module_name'];?>").css('width',$("[m_container]").width());
			mySwiper.resizeFix();
			mySwiper.reInit();
		}
		
	});
	</script>
 <link rel="stylesheet" href="./public/idangerous.swiper.css">
	<style>
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html{width:<?php echo $module['width']?>;height:<?php echo $module['height']?>;}

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
  position: absolute;
  left: 0;
  text-align: center;
  bottom:-15px;
  width: 100%;
}
.swiper-pagination-switch {
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 10px;
  background: #999;
  box-shadow: 0px 1px 2px #555 inset;
  margin: 0 3px;
  cursor: pointer;
}
.swiper-active-switch {
  background: #fff;
}
.next_prev{position: relative; top:-55%;  z-index:999999999; }
.next_prev a{ width:2rem; height:3rem; line-height:3rem; border-radius:5px; display:inline-block; text-align:center;}
.next_prev a:hover{ }
.mySwiper-left{ float:left; margin-left:-3px; width:1rem; height:2rem;   left:0px;}
.mySwiper-left:before{font: normal normal normal 35px/1 FontAwesome;content:"\f104";}
.mySwiper-left:hover{ }
.mySwiper-right{ float:right; margin-right:3px; width:1rem; height:2rem;   left:0px;}
.mySwiper-right:before{font: normal normal normal 35px/1 FontAwesome;content:"\f105";}
.mySwiper-right:hover{ }
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
    paginationClickable: true
	
  })
  $(document).on('click','.mySwiper-left', function(e){
    e.preventDefault()
    mySwiper.swipePrev()
  })
  $(document).on('click','.mySwiper-right', function(e){
    e.preventDefault()
    mySwiper.swipeNext()
  })
</script>
   
    </div>
</div>
<!---------------------------------------------------------------------------------------------slider_show_end-->
