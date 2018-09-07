<!---------------------------------------------------------------------------------------------slider_show_start-->
<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align="center"  style="display:inline-block;height:<?php echo $module['height']?>; "  monxin_slider=1>
	<script>
	$(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .swipe-wrap a").each(function(i,e){
			$("#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html #position").html($("#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html #position").html()+'<li onClick="swipe_go('+i+')"></li>');
		});
		if('<?php echo $module['width']?>'=='100%'){
			$("#<?php echo $module['module_name'];?>").css('width',$("#<?php echo $module['module_name'];?>").parent().width());
			mySwiper.resizeFix();
			mySwiper.reInit();
			setTimeout('reset_swiper_wrapper_height()',100);
			
		}
		
	});
	function reset_swiper_wrapper_height(){
		$("#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .swiper-container").css('height',$("#<?php echo $module['module_name'];?>").height());
	}
	</script>
 <link rel="stylesheet" href="./public/idangerous.swiper.css">
	<style>
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html{width:<?php echo $module['width']?>;height:<?php echo $module['height']?>; overflow:hidden;}

    </style>
    <div id="<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html">
    

    
    
    <style>
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .swiper-container {
        width:100%;
        height:100%;
    }
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .swiper-container img{
        width:100%;
        height:100%;
    }
    
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .content-slide {
      padding: 20px;
      
    }
    
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .title {
      font-size: 25px;
      margin-bottom: 10px;
    }
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .pagination {
      position: absolute;
      left: 0;
      text-align: center;
      bottom:-15px;
      width: 100%;
    }
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .swiper-pagination-switch {
      display: inline-block;
      width: 8px;
      height: 8px ;
      border-radius: 12px;
      background: #999;
      box-shadow: 0px 1px 2px #555 inset;
      margin: 0 8px;
      cursor: pointer;
    }
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .swiper-active-switch {
      background: #fff;
    }
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .next_prev{position: relative; top:-55%;  z-index:999999999; }
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .next_prev a{ width:2rem; height:3rem; line-height:3rem; border-radius:5px; display:inline-block; text-align:center;color:#fff !important;}
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .next_prev a:hover{background:#756f67;}
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .mySwiper-left{ float:left; margin-left:-3px; width:1rem; height:2rem;   left:0px;}
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .mySwiper-left:before{font: normal normal normal 35px/1 FontAwesome;content:"\f104";}
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .mySwiper-left:hover{ }
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .mySwiper-right{ float:right; margin-right:3px; width:1rem; height:2rem;   left:0px;}
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .mySwiper-right:before{font: normal normal normal 35px/1 FontAwesome;content:"\f105";}
    #<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .mySwiper-right:hover{ }
	
#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text{ position:relative; top:-100%;color:#fff; }
#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text a{color:#fff;}
#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text .slider_name{ margin-top:20px; font-size:2rem; font-weight:bold; line-height:30px; height:30px!important; }
#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text .slider_description{ padding:0.5rem;  line-height:1.4rem; height:70px!important; font-size:1rem; opacity:0; }
#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text .slider_summary{ line-height:30px height:30px!important;  opacity:0;  }
#<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html .up_text .slider_summary a{ display:inline-block; border:1px solid #FFF; border-radius:0.5rem; padding:0.5rem;font-size:1.2rem;}
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
      var mySwiper = new Swiper('#<?php echo $module['module_name'];?> .swiper-container',{
        pagination: '#<?php echo $module['module_name'];?> .pagination',
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
