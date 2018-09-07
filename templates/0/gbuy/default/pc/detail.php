<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		if(<?php echo $module['data']['state']?>==1){show_count_down(<?php echo $module['count_down'];?>);}
		
		$("#<?php echo $module['module_name'];?> .inviting_friends").click(function(){
			if(isWeiXin()){
				
			}else{
	
				$('#myModal').modal({  
				   backdrop:true,  
				   keyboard:true,  
				   show:true  
				});  
				$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/5);		 		
		
			}
			
		});
    });
	
    
function show_count_down(times){
  var timer=null;
  timer=setInterval(function(){
    var day=0,
      hour=0,
      minute=0,
      second=0;//时间默认值
    if(times > 0){
      day = Math.floor(times / (60 * 60 * 24));
      hour = Math.floor(times / (60 * 60)) - (day * 24);
      minute = Math.floor(times / 60) - (day * 24 * 60) - (hour * 60);
      second = Math.floor(times) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
    }
    //if (day <= 9) day = '0' + day;
    if (hour <= 9) hour = '0' + hour;
    if (minute <= 9) minute = '0' + minute;
    if (second <= 9) second = '0' + second;
    //
    console.log(day+"天:"+hour+"小时："+minute+"分钟："+second+"秒");
	limit_time=hour+":"+minute+":"+second+"";
	
	if(day!='00'){limit_time=day+'<?php echo self::$language['d2']?>'+limit_time;}
	$("#<?php echo $module['module_name'];?> .count_down").html('<?php echo self::$language['close_gbuy_time']?> '+limit_time);
    times--;
  },1000);
  if(times<=0){
    clearInterval(timer);
	$("#<?php echo $module['module_name'];?> .count_down").html('<?php echo self::$language['group_state_option'][2]?>');
	$("#<?php echo $module['module_name'];?> .share_a_div").css('display','none');
  }
}


    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{ background:none; }
    #<?php echo $module['module_name'];?>_html{ width:30%; margin:auto; }
	
    #<?php echo $module['module_name'];?>_html .list{}
    #<?php echo $module['module_name'];?>_html .goods{ background:rgba(249,249,249,1);padding:5px; padding-top:5px; padding-bottom:5px;}
    #<?php echo $module['module_name'];?>_html .goods .g_left{ text-align:center; display:inline-block; vertical-align:top; width:30%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .goods .g_left img{ width:80%;}
    #<?php echo $module['module_name'];?>_html .goods .g_right{display:inline-block; vertical-align:top; width:70%; overflow:hidden; }
    #<?php echo $module['module_name'];?>_html .goods .g_right .g_title{ }
    #<?php echo $module['module_name'];?>_html .goods .g_right .price{ font-size:1.1rem; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; line-height:3rem;}
    #<?php echo $module['module_name'];?>_html .goods .g_right .group_list{}
    #<?php echo $module['module_name'];?>_html .goods .g_right .group_list img{ width:30px; height:30px; border-radius:15px; border:1px #ccc solid; margin-right:0.5rem; background:#fff;}
	
	#<?php echo $module['module_name'];?>_html .count_down{ line-height:3rem; text-align:center; font-style:normal;}
	#<?php echo $module['module_name'];?> .state_notice{ line-height:3rem; text-align:center; font-size:1.3rem;}
	#<?php echo $module['module_name'];?> .state_notice b{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	
	#<?php echo $module['module_name'];?> .gbuy_notice{ line-height:3rem; border-top:1px solid #ccc;}
	#<?php echo $module['module_name'];?> .gbuy_notice .n_left{ display:inline-block; vertical-align:top; width:40%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .gbuy_notice .n_right{ display:inline-block; vertical-align:top; width:60%; text-align:right; overflow:hidden;}
	
    #<?php echo $module['module_name'];?>_html .group_list{ text-align:center; padding-top:1rem; padding-bottom:1rem;}
    #<?php echo $module['module_name'];?>_html .group_list img{ width:30px; height:30px; border-radius:15px; border:1px #ccc solid; margin-right:0.5rem; background:#fff;}
	#<?php echo $module['module_name'];?>_html .go_detail{ display:none;}
	#<?php echo $module['module_name'];?>_html .act_div{ text-align:center; padding:10px;}
	#<?php echo $module['module_name'];?>_html .act_div a{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:#fff; display:inline-block; vertical-align:top; width:80%; border-radius:7px; line-height:3rem; font-size:1.2rem;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=1>
    	<?php echo $module['goods_info'];?>
        <div class=group_list><?php echo $module['group_list'];?></div>
        
        <div class=state_notice><?php echo $module['state_notice']?></div>
		<div class=act_div><?php echo $module['act'];?></div>
        <div class=gbuy_notice><span class=n_left><?php echo self::$language['gbuy_notice']?></span><span class=n_right><?php echo self::$language['gbuy_notice_v']?></span></div>
        
        
        
        
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
                       <b><?php echo self::$language['please_use_weixin_2'];?></b>
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

