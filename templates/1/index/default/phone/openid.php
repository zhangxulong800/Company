<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?>").css('min-height',$(window).height());
	$(document).on('click',"#<?php echo $module['module_name'];?> .weixin_scan_img_demo",function(){
		$('#myModal').modal({  
		   backdrop:true,  
		   keyboard:true,  
		   show:true  
		});  
		return false;
	});

	$("#<?php echo $module['module_name'];?> .change").click(function(){
		if($("#<?php echo $module['module_name'];?> .bind").css('display')=='none'){
			$("#<?php echo $module['module_name'];?> .bind").css('display','block');
		}else{
			$("#<?php echo $module['module_name'];?> .bind").css('display','none');	
		}
		return false;	
	});
	
	$("#<?php echo $module['module_name'];?> .submit").click(function(){
		$("#<?php echo $module['module_name'];?> .state").html('');
		if($("#<?php echo $module['module_name'];?> .authcode").val()==''){$(this).focus();return false;}
		
		$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
		$.post('<?php echo $module['action_url'];?>&act=update',{authcode:$("#<?php echo $module['module_name'];?> .authcode").val()}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}				
			$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);	
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?>").html('<div style="line-height:200px;text-align:center;">'+v.info+' <a href=./index.php?monxin=index.openid><?php echo self::$language['refresh']?></a></div>');
			}
		});
		
		return false;
	});
});
	
</script>
<style>
#<?php echo $module['module_name'];?>{}
#<?php echo $module['module_name'];?>_html{padding-top:20px; text-align:center; margin-bottom:4rem; }
#<?php echo $module['module_name'];?>_html .exist_div{ line-height:3rem; margin-bottom:2rem;}
#<?php echo $module['module_name'];?>_html .exist_div img{ height:2rem; border-radius:1rem; margin-right:3px;}
#<?php echo $module['module_name'];?>_html .exist_div a{ }
#<?php echo $module['module_name'];?>_html .exist_div a:hover{ opacity:0.8;}
#<?php echo $module['module_name'];?>_html .bind{ line-height:1.5rem; }
#<?php echo $module['module_name'];?>_html .bind .authcode{ width:90px;}
</style>
    <div id=<?php echo $module['module_name'];?>_html>
    	<div class=exist_div style="display:<?php echo $module['exist_div']?>;"><?php echo self::$language['bound']?>: <?php echo $module['weixin_name'];?> <a href=# class=change><?php echo self::$language['change_2'];?></a></div>
	  <div class=bind style="display:<?php echo $module['bind']?>;">
	  	<?php echo $module['html'];?>
      	<div><input type="text" class=authcode placeholder="<?php echo self::$language['authcode']?>" /> <a href=# class=submit><?php echo $module['act_name']?></a> <span class=state></span></div>
      </div>
      
    <div class="qr_modal modal fade" id="myModal" tabindex="-1" role="dialog" 
       aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal" aria-hidden="true">
                      &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                   <b><?php echo self::$language['weixin_scan_img_demo'];?></b>
                </h4>
             </div>
             <div class="modal-body" style="text-align:center;">
                 <img class="qr_img" src=weixin_scan_img_demo.gif width="80%" />
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