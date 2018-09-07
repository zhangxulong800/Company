<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){

			$('#myModal').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/5);		 		
		
    });
  
	
    
    </script>
	<style>
	#<?php echo $module['module_name'];?>{ height:400px;}
    #<?php echo $module['module_name'];?>_html{ } 
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        
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
                       <b><?php echo self::$language['please_use_weixin'];?></b>
                    </h4>
                 </div>
                 <div class="modal-body" style="text-align:center;">
                     <img src="./plugin/qrcode/index.php?text=<?php echo $module['qr_data']?>" />
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
