<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$(".monxin_head").css('display','block');
		$(".page-container").css('padding-top',$(".monxin_head").height());
		$(".monxin_head .refresh").css('display','none');
		$(".monxin_head").append('<a href=./index.php class=home><?php echo self::$language['home']?></a>');
		$(".monxin_head .page_name").html('<?php echo self::$language['selected_circle']?>:<span class=v><?php echo $module['circle_name'];?></span>');
		
		$("#<?php echo $module['module_name'];?> .circle_parent a").click(function(){
			circle=$(this).attr('circle');
			if($("#<?php echo $module['module_name'];?> #sub_c_"+circle).html().length>5){
				$("#myModal .modal-body").html($("#<?php echo $module['module_name'];?> #sub_c_"+circle).html());
				$('#myModal').modal({  
				   backdrop:true,  
				   keyboard:true,  
				   show:true  
				});  
				$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/6);	
			}else{
				url='./index.php?circle='+$(this).attr('circle');
				window.location.href=url;
			}
			
			return false;		
		});
		
		$(".circle_sub a").click(function(){
			setCookie('circle',$(this).attr('circle'),30);
			url='./index.php?circle='+$(this).attr('circle');
			window.location.href=url;
			return false;
		});
	
	
		$("#<?php echo $module['module_name'];?> .c_search").keyup(function(event){
			if(event.keyCode==38 || event.keyCode==40){return false;}
			key=$(this).val();
			key=key.toLowerCase();
			str='';
			if(key==''){
				
			}else{
				$("#<?php echo $module['module_name'];?> .circle_list_div span").each(function(index, element) {
					if($(this).html().indexOf(key)!=-1 || $(this).parent().attr('py').indexOf(key)!=-1){
						str+='<a href='+$(this).parent().attr('href')+' >'+$(this).html()+'</a>';
					}
				});
			}
			$("#<?php echo $module['module_name'];?> .search_result").html(str);
		});
		

    });
    </script>
	<style>
    #<?php echo $module['module_name'];?>{} 
    #<?php echo $module['module_name'];?> .c_search{ width:100%; text-align:center;} 
    #<?php echo $module['module_name'];?> .circle_parent{ padding-top:0.3rem;} 
    #<?php echo $module['module_name'];?> .circle_parent a{ display:inline-block; vertical-align:top; width:25%; text-align:center; overflow:hidden;    white-space: nowrap; text-overflow: ellipsis; line-height:2rem; } 
    #<?php echo $module['module_name'];?> .circle_sub{ display:none;} 
		
	.home {
		display: inline-block;
		vertical-align: top;
		width: 15%;
		padding-left: 5%;
		height: 100%;
		line-height: 3rem;
		font-size: 1.3rem;
		font-weight: 100;
		
	}
	
	.monxin_bottom{ display:none !important;}
	.monxin_bottom_switch{ display:none;}
	
	#<?php echo $module['module_name'];?> .modal-body{}
	#<?php echo $module['module_name'];?> .modal-body a{ display:inline-block; vertical-align:top; width:33%; line-height:2rem;}
	
	
	
	#<?php echo $module['module_name'];?> .c_top_info{ background:rgba(242,242,242,1); text-align:center; padding-bottom:0.4rem; text-align:center;}
	#<?php echo $module['module_name'];?> .c_top_info .c_search{ width:80%; border-radius:10px; margin-top:0.3rem;}
	.search_result{width:80%; margin:auto;}
	.search_result a{ display:block; border-bottom:1px dashed #ccc; background:#fff; line-height:2.2rem;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=c_top_info>
        	<input type="text" class=c_search placeholder="<?php echo self::$language['search']?><?php echo self::$language['city_or_py']?>" />
        	<div class=search_result></div>
        </div>
    	<div class=circle_list_div><?php echo $module['circle_list'];?></div>
        
        
        <!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               <b><?php echo self::$language['please_select'];?></b>
            </h4>
         </div>
         <div class="modal-body">
             
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal"><?php echo self::$language['close']?>
            </button>
            
         </div>
      </div>
</div></div>
        
        
        
    </div>
</div>
