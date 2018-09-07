<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
		$(document).ready(function(){
			
			$('#myModal').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/3);		 		
			
			$("#<?php echo $module['module_name'];?> .code").keyup(function(event){
				if(event.keyCode==13){$("#<?php echo $module['module_name'];?> .submit").trigger('click');}
			});
			
			
			$("#<?php echo $module['module_name'];?> .submit").click(function(){
				if($("#<?php echo $module['module_name'];?> .code").val()!=''){
					$("#<?php echo $module['module_name'];?> .submit").next('.state').html('<span class=\'fa fa-spinner fa-spin\'></span>');
					url='<?php echo $module['action_url'];?>&act=check&code='+$("#<?php echo $module['module_name'];?>_html .code").val();
					$.get(url,function(data){
						try{v=eval("("+data+")");}catch(exception){alert(data);}
						$("#<?php echo $module['module_name'];?> .submit").next('.state').html(v.info);
						if(v.state=='success'){
							window.location.href='http://<?php echo $module['url'];?>&authorize_code='+$("#<?php echo $module['module_name'];?> .code").val();
						}else{
							
						}
						
					});
					
				}
				return false;
			});
			
			
		});
    </script>
    <style>
	#<?php echo $module['module_name'];?>{ text-align:center;}
	#<?php echo $module['module_name'];?> input{ width:70%;}
	#<?php echo $module['module_name'];?> .submit{ cursor:pointer;}
  
  </style>
  <div id=<?php echo $module['module_name'];?>_html class="container">
        
                <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog"  
           aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
              <div class="modal-content">

                 <div class="modal-body">
                     <input type=text class=code placeholder="<?php echo self::$language['pages']['index.authorize_code']['name'];?>" /> <a class=submit><?php echo self::$language['submit']?></a> <span class=state></span>
                 </div>
              </div>
        </div></div>
                
        
  </div>
</div>
