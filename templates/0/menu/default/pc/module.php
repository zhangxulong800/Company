<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	
	html='';
	temp='(<?php echo $module['data'];?>)';
	arr=eval(temp);
	index=1;
	page_size=99;
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
	
  var mySwiper = new Swiper('.swiper-container',{
    pagination: '.pagination',
    loop:true,
    grabCursor: true,
    paginationClickable: true
  })
	if($("#<?php echo $module['module_name'];?> .pagination span").length==1){$("#<?php echo $module['module_name'];?> .pagination").css('display','none');}
	$(".swiper-container").height(($("#<?php echo $module['module_name'];?> .swiper-container a").width()+60));
	//$("#<?php echo $module['module_name'];?>").css('height',$(document).height());
});
</script>
<script src="<?php echo get_template_dir(__FILE__);?>idangerous.swiper.js"></script>
<link rel="stylesheet" href="<?php echo get_template_dir(__FILE__);?>idangerous.swiper.css">
<style>
#<?php echo $module['module_name'];?>{ min-width:100px; width:100%; height:100%;  
	background-image:url(./program/menu/bg/<?php echo $module['bg'];?>);
	filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod='scale')";  
	-moz-background-size:100% 100%;  
    background-size:100% 100%;
	background-image:none;
	}
#<?php echo $module['module_name'];?>_html{min-height:200px;}

#<?php echo $module['module_name'];?>_html .swiper-wrapper{ padding-left:1%; padding-top:0.7%;}
#<?php echo $module['module_name'];?>_html .swiper-wrapper div{ }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div a{ display:inline-block; vertical-align:top; text-align:center; width:160px; margin:30px;    border-radius:8px;}
#<?php echo $module['module_name'];?>_html .swiper-wrapper div a span{ display:block;}
#<?php echo $module['module_name'];?>_html .swiper-wrapper div a .icon{}
#<?php echo $module['module_name'];?>_html .swiper-wrapper div a .icon img{ width:70%; border:none;}
#<?php echo $module['module_name'];?>_html .swiper-wrapper div a .name{ font-size:20px; padding:5px; padding-bottom:10px; padding-top:0px; overflow:hidden; }

#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_1{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_2{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_3{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_4{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_5{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_6{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_7{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_8{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_9{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_10{  }

#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_11{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_12{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_13{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_14{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_15{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_16{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_17{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_18{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_19{  }
#<?php echo $module['module_name'];?>_html .swiper-wrapper div .c_20{  }



.swiper-slide{ padding:0px; margin:0px; overflow:hidden;}

.swiper-container {
  width: 100%;
  overflow:hidden;
}
.content-slide {
  
 
}
.pagination { text-align:center;
  width: 100%;
}
.swiper-pagination-switch {
  display: inline-block;
  width:20px;
  height: 20px;
  border-radius: 20px;
  background: #999;
  box-shadow: 0px 2px 4px #555 inset;
  margin: 0 20px;
  cursor: pointer;
}
.swiper-active-switch {
  background: #fff ;
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