<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	html='';
temp='(<?php echo $module['data'];?>)';	
	arr=eval(temp);
	index=1;
	page_size=10;
	page=1;
	html_sub='';
	for(i in arr){
		html_sub+='<a class="c_'+index+'" href="'+arr[i]['url']+'" target="'+arr[i]['open_target']+'"><span class=icon><img src="./program/menu/icon/'+arr[i]['id']+'.png" /></span><span class=name>'+arr[i]['name']+'</span></a>';
		if(index%page_size==0){
			html+='<div class="page_'+page+' swiper-slide">'+html_sub+'</div>';
			page++;
			html_sub='';
		}
		index++;
	}
	index--;
	if(index%page_size!=0){
		html+='<div class="page_'+page+' swiper-slide">'+html_sub+'</div>';
	}
	//alert(index);
	$("#<?php echo $module['module_name'];?> .swiper-wrapper").html(html);
	
  var menu_mySwiper = new Swiper('#<?php echo $module['module_name'];?> .swiper-container',{
    pagination: '#<?php echo $module['module_name'];?> .pagination',
    loop:true,
    grabCursor: true,
    paginationClickable: true
  })
	if($("#<?php echo $module['module_name'];?> .pagination span").length==1){$("#<?php echo $module['module_name'];?> .pagination").css('display','none');}
	
	if($("#<?php echo $module['module_name'];?> .page_1:first a").length<5){
		$("#<?php echo $module['module_name'];?> .swiper-container").height(($("#<?php echo $module['module_name'];?> .swiper-container a").width()+10)*1);
	}else{
		$("#<?php echo $module['module_name'];?> .swiper-container").height(($("#<?php echo $module['module_name'];?> .swiper-container a").width()+10)*2);
	}
});
</script>
     <script src='./public/idangerous.swiper.js'></script>
 <link rel="stylesheet" href="./public/idangerous.swiper.css">
<style>
#<?php echo $module['module_name'];?>{ min-width:100px; width:100%; 
	background-image:url(./program/menu/bg/<?php echo $module['bg'];?>);
	filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale')";  
	-moz-background-size:100% 100%;  
    background-size:100% 100%;
	background-image:none;
	}
#<?php echo $module['module_name'];?>_html{ }

#<?php echo $module['module_name'];?>_html .swiper-wrapper{ padding-left:1%; padding-top:0.7%;}
#<?php echo $module['module_name'];?>_html .swiper-wrapper div{ }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div a{ display:inline-block; vertical-align:top; text-align:center; width:18%; margin:1%;}
#<?php echo $module['module_name'];?>_html .swiper-wrapper div a span{ display:block;}
#<?php echo $module['module_name'];?>_html .swiper-wrapper div a .icon{}
#<?php echo $module['module_name'];?>_html .swiper-wrapper div a .icon img{ width:60%; border:none;}
#<?php echo $module['module_name'];?>_html .swiper-wrapper div a .name{ font-size:0.9rem; padding:0.3rem; padding-bottom:0.7rem; padding-top:0px; line-height:2rem; height:2rem; overflow:hidden; }




#<?php echo $module['module_name'];?> .swiper-slide{ padding:0px; margin:0px; overflow:hidden; text-align:center;}
#<?php echo $module['module_name'];?> .swiper-container { 
  width: 100%;
  height:14.57rem;
  overflow:hidden;
}
#<?php echo $module['module_name'];?> .content-slide {
  
 
}
#<?php echo $module['module_name'];?> .pagination { text-align:center; width: 100%;margin-top:-80px;}
#<?php echo $module['module_name'];?> .swiper-pagination-switch {
	display: inline-block;
	width: 8px;
	height: 8px ;
	border-radius: 8px;
	background: #999;
	box-shadow: 0px 1px 2px #555 inset;
	margin: 0 8px;
	cursor: pointer;
}
#<?php echo $module['module_name'];?> .swiper-active-switch {
  background: #fff;
}

</style>
<div id="<?php echo $module['module_name'];?>_html">
    <div class="swiper-container">
      <div class="swiper-wrapper">
      	<div style="text-align:center;"><span class="loading"></span></div>
      </div>
     
    </div>
    <div class="pagination"></div>
</div>

</div>