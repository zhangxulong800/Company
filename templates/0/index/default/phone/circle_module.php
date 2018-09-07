<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		circle=get_param('circle');
		if(circle==''){circle=getCookie('circle');}
		if(circle!=0){
			setCookie('circle',circle,30);
			$(".monxin_bottom a[monxin='index.circle'] span").html($("#<?php echo $module['module_name'];?> a[circle='"+circle+"'] span").html());
		}else{
			setCookie('circle',0,30);
			$(".monxin_bottom a[monxin='index.circle'] span").html('<?php echo self::$language['circle']?>');
		}

		$("#<?php echo $module['module_name'];?> .list a").click(function(){
			if($(this).next('div').attr('class')=='sub_div'){
				if($(this).next().css('opacity')==0){
					$(this).next().css('opacity','1');
					return false;	
				}
			}
			
			setCookie('circle',$(this).attr('circle'),30);	
			url=window.location.href;
			url=replace_get(url,'circle',$(this).attr('circle'));
			window.location.href=url;
			return false;
		});
		
		$(".monxin_bottom a[monxin='index.circle']").click(function(){
			$(".monxin_bottom a").removeClass('current');
			$(".monxin_bottom  a[monxin='index.circle']").addClass('current');
			/*
			if($("#<?php echo $module['module_name'];?>").css('display')=='none'){
				$(".monxin_bottom  a[monxin='index.circle']").addClass('current');
				$("#<?php echo $module['module_name'];?>").css('display','block');	
			}else{
				$(".monxin_bottom  a[monxin='index.circle']").addClass('current');
				$("#<?php echo $module['module_name'];?>").css('display','none');
			}
			*/
			$('#myModal').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/10);		 		
			
			
			return false;	
		});
    });
    </script>
	<style>
	#<?php echo $module['module_name'];?>{width:0px; height:0px; overflow:hidden; }
    #<?php echo $module['module_name'];?>_html{text-align:center; margin-bottom:2rem;} 
    #<?php echo $module['module_name'];?>_html .option_title{  font-size:1.5rem; line-height:3rem;} 
    #<?php echo $module['module_name'];?>_html .list{ line-height:2rem;} 
    #<?php echo $module['module_name'];?>_html .list .circle_div{ display:inline-block; vertical-align:top; width:33%; overflow:hidden;} 
    #<?php echo $module['module_name'];?>_html .list .circle_div a{ display:block; margin-bottom:1rem;} 
    #<?php echo $module['module_name'];?>_html .list .circle_div a:hover{ opacity:0.8; border-bottom:3px <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> solid;} 
    #<?php echo $module['module_name'];?>_html .list .circle_div a img{ width:40%;} 
    #<?php echo $module['module_name'];?>_html .list .circle_div a span{ display:block; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;} 
    #<?php echo $module['module_name'];?>_html .list .circle_div .sub_div{ opacity:0;} 
	#<?php echo $module['module_name'];?>_html .list .circle_div:hover .sub_div{}
    #<?php echo $module['module_name'];?>_html .list .circle_div .sub_div a{ display:inline-block; width:50%;} 
    #<?php echo $module['module_name'];?>_html .list .circle_div .sub_div a img{} 
    #<?php echo $module['module_name'];?>_html .list .circle_div .sub_div a span{}
	#<?php echo $module['module_name'];?>_html .more{ display:none !important;}
	
	.modal-title{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	
.shequji_home:before{font: normal normal normal 1.6rem/1 monxin; display:block; content: "\f011";}
.current .shequji_home:before{font: normal normal normal 1.6rem/1 monxin; display:block; content: "\f010"; }
.shequji_jd:before{font: normal normal normal 1.6rem/1 monxin; display:block; content: "\f018";}
.current .shequji_jd:before{font: normal normal normal 1.6rem/1 monxin; display:block; content: "\f018"; }
.shequji_circle:before{font: normal normal normal 1.6rem/1 monxin; display:block; content: "\f013";}
.current .shequji_circle:before{font: normal normal normal 1.6rem/1 monxin; display:block; content: "\f012"; }
.shequji_cart:before{font: normal normal normal 1.6rem/1 monxin; display:block; content: "\f016";}
.current .shequji_cart:before{font: normal normal normal 1.6rem/1 monxin; display:block; content: "\f016"; }
.shequji_user:before{font: normal normal normal 1.6rem/1 monxin; display:block; content: "\f015";}
.current .shequji_user:before{font: normal normal normal 1.6rem/1 monxin; display:block; content: "\f014"; }

    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    
     
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style=" z-index:999999999999999;">
           <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" 
                       data-dismiss="modal" aria-hidden="true">
                          &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                       <b><?php echo self::$language['please_select_circle'];?></b>
                    </h4>
                 </div>
                 <div class="modal-body">
                     <div class=list><?php echo $module['list'];?></div>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" 
                       data-dismiss="modal"><?php echo self::$language['close']?>
                    </button>
                    
                 </div>
              </div>
        </div>
      </div>          
    	
    </div>
</div>
