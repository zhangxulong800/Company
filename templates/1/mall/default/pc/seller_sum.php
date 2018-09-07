<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		if($(".modal-body .expiration").html().length>10){
			$('#myModal').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/10);		 		
		}
		
		$(window).keydown(function(event){
			if(event.keyCode==32 || event.keyCode==13){
				
			}
				
		});
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .card_head{ background-color:#F60; }
    #<?php echo $module['module_name'];?> .goods_info{ display:block;line-height:2rem; width:22rem; height:2rem;overflow:hidden; white-space:nowrap;}
    #<?php echo $module['module_name'];?> .goods_info img{display:inline-block; vertical-align:top; height:2rem; border:none; margin-right:3px;}
    #<?php echo $module['module_name'];?> .goods_info span{display:inline-block; vertical-align:top; width:90%; overflow:hidden;text-overflow: ellipsis;}
    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    	<a href="./index.php?monxin=mall.order_admin&state=1" class=card_head>
        	<span class=big_num><?php echo $module['order_1'];?></span>
            <span class=remark><?php echo self::$language['order_state'][1]?><?php echo self::$language['order']?></span>
        </a>
    	<div class=card_body>
        	<a href='./index.php?monxin=mall.order_admin&state=0' class=item>
            	<span class=name><?php echo self::$language['order_state'][0]?><?php echo self::$language['order']?></span>
            	<span class=value><?php echo $module['order_0'];?></span>
            </a><a href='./index.php?monxin=mall.order_admin&state=8' class=item>
            	<span class=name><?php echo self::$language['order_state'][8]?><?php echo self::$language['order']?></span>
            	<span class=value><?php echo $module['order_8'];?></span>
            </a><a href='./index.php?monxin=mall.order_admin&state=6' class=item>
            	<span class=name><?php echo self::$language['order_state'][6]?><?php echo self::$language['order']?></span>
            	<span class=value><?php echo $module['order_6'];?></span>
            </a><a href='./index.php?monxin=mall.comment_admin' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['comment']?></span>
            	<span class=value><?php echo $module['comment'];?></span>
            </a><a href='./index.php?monxin=mall.goods_admin&order=inventory|asc' class=item>
            	<span class=name><?php echo self::$language['low_inventory_goods']?></span>
            	<span class=value><?php echo $module['low_inventory'];?></span>
            </a><a href='./index.php?monxin=mall.goods_admin' class=item>
            	<span class=name><?php echo self::$language['goods']?><?php echo self::$language['visit_sum']?></span>
            	<span class=value><?php echo $module['visit'];?></span>
            </a>
        </div>
        
          
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
                       <b><?php echo self::$language['shelf_life_notice'];?></b>
                    </h4>
                 </div>
                 <div class="modal-body">
                     <div class=expiration><?php echo $module['expiration'];?></div>
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-default" 
                       data-dismiss="modal">【ESC】<?php echo self::$language['close']?>
                    </button>
                    
                 </div>
              </div>
        </div>
      </div>          
          
      
      
        
    </div>
</div>