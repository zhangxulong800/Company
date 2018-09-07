<script language="javascript" src="./public/Tween.js" type="text/javascript"></script>
<script language="javascript" src="./public/jquery.crownSlide.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
		$(window).scroll(function(){
			scrollTop=document.documentElement.scrollTop|document.body.scrollTop;
			//monxin_alert(scrollTop);
			distance=scrollTop-$("#<?php echo $module['module_name'];?>").offset().top+200;
			$("#<?php echo $module['module_name'];?>").stop().crownSlide({
				type : 'slideDonw',
				speed : 10,
				current : 0,
				duration : 10,
				beginning : 0,
				change : distance,
			});
		});
		
		$("#<?php echo $module['module_name'];?>_html .talk_switch").click(function(){
			customer_service_switch();
			return false;
		});
	
	});
	function customer_service_switch(){
		if($("#<?php echo $module['module_name'];?>").css('width')=='35px'){
			$("#<?php echo $module['module_name'];?>").animate({width: '13.5rem'}, "slow");
			setCookie('user_set_customer_service_switch','1');
		}else{
			
			$("#<?php echo $module['module_name'];?>").animate({width: '35px'}, "slow");
			setCookie('user_set_customer_service_switch','0');
		}
	}
	
</script>
<div id=<?php echo $module['module_name'];?>   monxin-module="<?php echo $module['module_name'];?>" >
	
	<style>
	#<?php echo $module['module_name'];?>{position: absolute; width:35px; right:0px; top:25%;overflow-x:hidden; text-align:right; z-index:9999; white-space:nowrap; }
    #<?php echo $module['module_name'];?>_html{  border-radius:0.7rem 0rem 0rem 0.8rem; width:13.5rem; height:20rem; overflow:hidden;min-height:20rem; }
	#<?php echo $module['module_name'];?>_html .talk_switch{ font-size:1.5rem; display:inline-block; vertical-align:top; width:28px; height:100%; overflow:hidden;  white-space:normal; padding-top:3rem; cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .talk_switch .customer_icon:before{ font: normal normal normal 1.6rem/1 FontAwesome; content: "\f1d6"; }
	#<?php echo $module['module_name'];?>_html .talk_switch .customer_state:before{ padding-right:0.2rem; font: normal normal normal 2rem/1 FontAwesome; content: "\f101"; }	
	#<?php echo $module['module_name'];?>_html .talk_switch .customer_title{ font-size:1.6rem; }
	
	#<?php echo $module['module_name'];?>_html .talk_list{background: #F7F7F7;border-radius: 0.5rem; display:inline-block; vertical-align:top; width:10rem; height:90%; margin:1rem;  overflow:hidden; white-space:normal; text-align:left; padding:0.5rem; line-height:2rem; }
	#<?php echo $module['module_name'];?>_html .talk_list a{}
	#<?php echo $module['module_name'];?>_html .talk_list .web_name{ text-align:center; font-weight:bold; }
	#<?php echo $module['module_name'];?>_html .talk_list .c_line{ white-space:nowrap; font-size:0.9rem;border-bottom: solid 1px #E6E4E4; text-align:left; line-height:3rem;}
	#<?php echo $module['module_name'];?>_html .talk_list .c_line img{ width:54%;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=talk_switch><i class=customer_icon></i><span class=customer_title>在线客服</span><i class=customer_state></i></div><div class=talk_list><?php echo $module['module_content'];?></div>
    	
    </div>

</div>
