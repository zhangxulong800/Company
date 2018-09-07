<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
	

wx.ready(function(){							
	wx.onMenuShareTimeline({
		title: '<?php echo $module['data']['invitation']?> '+$('title').html(), 
		link: check_url(window.location.href+'&share='+getCookie('monxin_id')+'&'), 
		imgUrl: get_share_img(), 
		success: function () {},
		cancel: function () {}
	});		
	
	wx.onMenuShareAppMessage({
		title: '<?php echo $module['data']['invitation']?> '+$('title').html(), 
		desc: '', 
		link: check_url(window.location.href+'&share='+getCookie('monxin_id')+'&'), 
		imgUrl: get_share_img(), 
		type: '', 
		dataUrl: '', 
		success: function () {},
		cancel: function () {}
	});	
	
	wx.onMenuShareQQ({
		title: '<?php echo $module['data']['invitation']?> '+$('title').html(), 
		desc: $('title').html(), 
		link: check_url(window.location.href+'&share='+getCookie('monxin_id')+'&'), 
		imgUrl: get_share_img(), 
		success: function () {},
		cancel: function () {}
	});
});	
    $(document).ready(function(){
		
		
		if($("html").attr('platform')=='Win32'){
			$("#<?php echo $module['module_name'];?> .u_g").width($("#<?php echo $module['module_name'];?> .u_g").parent().width()*0.9).css('margin-left','9px');
			$("#<?php echo $module['module_name'];?> .self_bargain_div").width($("#<?php echo $module['module_name'];?>").width()).css('left',$("#<?php echo $module['module_name'];?>").offset().left);
			$("#<?php echo $module['module_name'];?> .wx_qr_notice").width($("#<?php echo $module['module_name'];?>").width()).css('left',$("#<?php echo $module['module_name'];?>").offset().left);
		}
		$("#<?php echo $module['module_name'];?> .share_a").click(function(){
			v='<?php echo self::$language['share_text_2']?>';
			v=v.replace(/{money}/,$("#<?php echo $module['module_name'];?> .bargained").html());
			$("#<?php echo $module['module_name'];?> .share_text_2").html(v);
			$("#<?php echo $module['module_name'];?> .self_bargain_div").css('display','block');
			
		});
		
		
		
		if(<?php echo $module['bargain_money']?>>0){
			v='<?php echo self::$language['share_text_2']?>';
			v=v.replace(/{money}/,<?php echo $module['bargain_money']?>);
			$("#<?php echo $module['module_name'];?> .share_text_2").html(v);
			$("#<?php echo $module['module_name'];?> .self_bargain_div").css('display','block');
		}
		
		$("#<?php echo $module['module_name'];?> .return_a").click(function(){
			$("#<?php echo $module['module_name'];?> .self_bargain_div").css('display','none');
		});
		
		
		$("#<?php echo $module['module_name'];?>").height($(window).height());
		$("#<?php echo $module['module_name'];?>  .notice").css('padding-top',$("#<?php echo $module['module_name'];?> .u_g").height()+54);
		if('<?php echo $module['data']['type']?>'=='0'){
			$("#<?php echo $module['module_name'];?> .buy_a_div .buy_a").html('<?php echo $module['now_price'];?><?php echo self::$language['yuan'];?>'+$("#<?php echo $module['module_name'];?> .buy_a_div .buy_a").html());
			$("#<?php echo $module['module_name'];?> .buy_a_div").css('display','block');
			
		}
		
		if(<?php echo $module['count_down'];?><0){
			$("#<?php echo $module['module_name'];?> .share_a_div").css('display','none');
			$("#<?php echo $module['module_name'];?> .count_down").html('<?php echo self::$language['log_state_option'][2]?>');
		}
		
		$("#<?php echo $module['module_name'];?> .execute_bargain").click(function(){
			
			if($("#<?php echo $module['module_name'];?> .execute_bargain").attr('lock')==1){return false;}
			if(getCookie('monxin_id')!=''){
				
				$("#<?php echo $module['module_name'];?> .execute_bargain").attr('lock',1);
				
				$("#<?php echo $module['module_name'];?> .execute_bargain").html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.post('<?php echo $module['action_url'];?>&act=execute_bargain', function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#<?php echo $module['module_name'];?> .execute_bargain").html(v.info);
					if(v.state=='success'){
						temp='<?php echo self::$language['thank']?>';
						temp=temp.replace('{v}','<b>'+55+'</b>');
						$("#<?php echo $module['module_name'];?> .u_thank .r").html(temp);
						$('#myModal').modal({  
						   backdrop:true,  
						   keyboard:true,  
						   show:true  
						});  
						$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/9);		 		
					}else{
						if(v.key=='weixin'){
							$("#<?php echo $module['module_name'];?> .wx_qr_notice").css('display','block');
						}
					}
			
				});
				
			}else{
				if('<?php echo $module['log_qr']?>'==''){
					
					window.location.href='./index.php?monxin=index.login';
				}else{
					$("#<?php echo $module['module_name'];?> .wx_qr_notice").css('display','block');
				}
				
				
			}
			
		});
		
		$("#<?php echo $module['module_name'];?> .buy_a").click(function(){
			window.location.href='<?php echo $module['buy_url'];?>';
			
		});
		
		if(<?php echo $module['log_state']?>==1){show_count_down(<?php echo $module['count_down'];?>);}
		if(<?php echo $module['log_state']?>==2){$("#<?php echo $module['module_name'];?> .count_down").css('display','none').html('');return false;}
		if(<?php echo $module['log_state']?>==3){$("#<?php echo $module['module_name'];?> .count_down").css('display','none').html('');return false;}

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
	$("#<?php echo $module['module_name'];?> .count_down").html('<?php echo self::$language['count_down_a']?> '+limit_time+' <?php echo self::$language['count_down_b']?>');
    times--;
  },1000);
  if(times<=0){
    clearInterval(timer);
	$("#<?php echo $module['module_name'];?> .count_down").html('<?php echo self::$language['log_state_option'][2]?>');
	$("#<?php echo $module['module_name'];?> .share_a_div").css('display','none');
  }
}



	
    </script>
	<style>
	#<?php echo $module['module_name'];?>{ height:400px; background:red;background-image:url(<?php echo get_template_dir(__FILE__);?>/img/bg.png); background-repeat:no-repeat; background-size: cover; padding-top:2rem; color:#fff; }
    #<?php echo $module['module_name'];?>_html{ text-align:center; padding-bottom:2rem;} 
	
	#<?php echo $module['module_name'];?> .u_g{position:absolute; margin-top:2rem;	  text-align:center;  background:#fff; border-radius:6px;  width:90%; margin-left:5%; padding-right:5%;  padding:0.7rem; color:#000;}
	#<?php echo $module['module_name'];?> .u_g .u_icon{position:relative; text-align:center; margin-top:-35px;}
	#<?php echo $module['module_name'];?> .u_g .u_icon img{ width:50px; height:50px; border-radius:25px; border:2px solid #fff;}
	#<?php echo $module['module_name'];?> .u_g .u_name{ color:rgba(88,89,91,1); font-size:1.1rem;}
	#<?php echo $module['module_name'];?> .u_g .invitation{ line-height:2.5rem; font-size:1.2rem; font-weight:bold;}
	#<?php echo $module['module_name'];?> .u_g .goods_info{ background:rgba(242,242,242,1); display:block; border-radius:5px; padding:0.4rem; text-align:left;}
	
	#<?php echo $module['module_name'];?> .u_g .goods_info .goods_icon_span{ display:inline-block; vertical-align:top; width:25%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .u_g .goods_info .goods_icon_span img{ width:60px; height:60px;}
	#<?php echo $module['module_name'];?> .u_g .goods_info .g_other{display:inline-block; vertical-align:top; width:75%; overflow:hidden; text-align:left;}
	
	#<?php echo $module['module_name'];?> .u_g .goods_info .g_other .g_title{ line-height:1.5rem; height:3rem; overflow:hidden;}
	#<?php echo $module['module_name'];?> .u_g .goods_info .g_other .price_div{}
	#<?php echo $module['module_name'];?> .u_g .goods_info .g_other .price_div .normal{}
	#<?php echo $module['module_name'];?> .u_g .goods_info .g_other .price_div .normal .v{}
	#<?php echo $module['module_name'];?> .u_g .goods_info .g_other .price_div .final_price{}
	#<?php echo $module['module_name'];?> .u_g .goods_info .g_other .price_div .final_price .v{}
	
	#<?php echo $module['module_name'];?>  .notice{ padding-top:220px; line-height:2rem; font-size:1.2rem; color:#fff;}
	#<?php echo $module['module_name'];?>  .notice span{ color:rgba(254,237,93,1); font-size:1.6rem; font-weight:bold; }
	
	#<?php echo $module['module_name'];?> .share_a_div{ padding-top:5px; padding-bottom:5px;}
	#<?php echo $module['module_name'];?> .share_a_div .share_a{ display:block; width:90%; margin:auto; line-height:2.5rem; border-radius:5px; background:rgba(254,237,93,1); color:rgba(253,43,0,1); font-weight:bold;}
	
	#<?php echo $module['module_name'];?> .execute_bargain_div{ padding-top:5px; padding-bottom:5px;}
	#<?php echo $module['module_name'];?> .execute_bargain{  display:block; width:90%; margin:auto; line-height:2.5rem; border-radius:5px; background:rgba(254,237,93,1); color:rgba(253,43,0,1); font-weight:bold;}
	
	#<?php echo $module['module_name'];?> .count_down{ line-height:3rem;}
	
	#<?php echo $module['module_name'];?> .bargain_detail{ background:rgba(255,255,255,0.5); width:90%; margin:auto; border-radius:5px; padding:10px;}
	
	#<?php echo $module['module_name'];?> .bargain_title{ border-bottom:1px solid rgba(255,255,255,0.6); padding-bottom:5px;}
	
	#<?php echo $module['module_name'];?> .price_div{ color:red;}
	#<?php echo $module['module_name'];?> .price_div .price_div{ display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .price_div .final_price{display:inline-block; vertical-align:top; width:50%; overflow:hidden; text-align:right;}
	
	#<?php echo $module['module_name'];?> .buy_a_div{ display:none; padding-bottom:1rem;}
	#<?php echo $module['module_name'];?> .buy_a_div .buy_a{display:block; width:90%; margin:auto; line-height:2.5rem; border-radius:5px; background:rgba(255,255,255,0.6); color:rgba(255,255,255,1); font-weight:bold;}
	
	
	#<?php echo $module['module_name'];?> .self_bargain_div{ position: fixed; margin:auto; top:0px; left:0px; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:99999999999999999999999999999; display:none;}
	#<?php echo $module['module_name'];?> .self_bargain_div .arrow{ text-align:right; padding-top:5px; padding-right:5px;}
	#<?php echo $module['module_name'];?> .self_bargain_div .arrow img{ width:30%;}
	#<?php echo $module['module_name'];?> .self_bargain_div .share_text_2{ line-height:5rem;}
	#<?php echo $module['module_name'];?> .self_bargain_div .return_div{ line-height:3rem;}
	#<?php echo $module['module_name'];?> .self_bargain_div .return_div a{ padding:3px; color:#fff; border-radius:4px; border:1px #fff solid;}
    
	#<?php echo $module['module_name'];?> .bargain_detail{}
	#<?php echo $module['module_name'];?> .bargain_list{ text-align:left; }
	#<?php echo $module['module_name'];?> .bargain_list >div{ line-height:2rem; border-bottom:1px dashed #fff; padding-bottom:3px;}
	#<?php echo $module['module_name'];?> .bargain_list >div img{ width:26px; height:26px; border-radius:13px; margin-right:3px; border:2px solid #fff;	}
	#<?php echo $module['module_name'];?> .bargain_list .b_userinfo{ display:inline-block; vertical-align:top; width:50%; overflow:hidden;    white-space: nowrap;text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?> .bargain_list .bmoney{ display:inline-block; vertical-align:top; width:30%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .bargain_list .btime{ display:inline-block; vertical-align:top; width:20%; overflow:hidden; text-align:right; white-space:nowrap; font-size:0.8rem;}
	
	#<?php echo $module['module_name'];?> .wx_qr_notice{ position: fixed; margin:auto; top:0px; left:0px; width:100%; height:100%; background:rgba(0,0,0,0.9); z-index:999999999999999999999999999999; padding-top:90px; display:none; }
	
	#<?php echo $module['module_name'];?> .wx_qr_notice_in{ position: absolute;background:#fff; border-radius:6px; width:70%; margin-left:15%; margin-right:15%; color:#000;}
	#<?php echo $module['module_name'];?> .wx_qr_notice .u_icon{ }
	#<?php echo $module['module_name'];?> .wx_qr_notice .u_icon{position:relative; text-align:center; margin-top:-25px;}
	#<?php echo $module['module_name'];?> .wx_qr_notice .u_icon img{ width:50px; height:50px; border-radius:25px; border:2px solid #fff;}
	
	#<?php echo $module['module_name'];?> .wx_qr_notice .notice_text{ line-height:2.2rem;}
	#<?php echo $module['module_name'];?> .wx_qr_notice .bargaom_qr{ padding-bottom:1rem;}
	#<?php echo $module['module_name'];?> .wx_qr_notice .bargaom_qr img{ width:70%;}
	
	#<?php echo $module['module_name'];?> .thank_div .go_bargain a{ display:inline-block; vertical-align:top; width:70%;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:#fff; border-radius:7px; line-height:3rem;}
	
	#<?php echo $module['module_name'];?> #myModal{ color:#000 !important; text-align:left !important;}
	#<?php echo $module['module_name'];?> .thank_div .u_thank{ display:inline-block; width:75%; overflow:hidden; margin:auto;}
	#<?php echo $module['module_name'];?> .thank_div .u_thank .l{ display:inline-block; line-height:50px; vertical-align:top; width:25%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .thank_div .u_thank .l img{ width:50px; height:50px; border-radius:25px; border:2px solid #fff;}
	#<?php echo $module['module_name'];?> .thank_div .u_thank .r{display:inline-block; vertical-align:top; width:75%; overflow:hidden; text-align:left;line-height:50px;}
	#<?php echo $module['module_name'];?> .thank_div .u_thank .r b{ color:red;}
	
	#<?php echo $module['module_name'];?> .thank_div .go_bargain_list_notice{ line-height:3rem;}
	#<?php echo $module['module_name'];?> .thank_div .go_bargain{ text-align:center;}
	
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        
        <div class=u_g>
        	<div class=u_icon><img src="<?php echo $module['u_icon'];?>" /></div>
            <div class=u_name><?php echo $module['username']?></div>
            <div class=invitation><?php echo $module['data']['invitation']?></div>
            <a class=goods_info href="./index.php?monxin=mall.goods&id=<?php echo $module['data']['g_id']?>" target="_blank">
            	<span class=goods_icon_span><img src="<?php echo $module['data']['g_icon']?>" /></span><span class=g_other>
                	<div class=g_title><?php echo $module['data']['g_title']?></div>
                    <div class=price_div><span class=normal><?php echo self::$language['goods_price_2']?><span class=v><?php echo self::$language['money_symbol']?><?php echo $module['normal']?></span></span><span class=final_price><?php echo self::$language['final_price_2']?><span class=v><?php echo self::$language['money_symbol']?><?php echo $module['data']['final_price']?></span></span></div>
                </span>
            </a>
        </div>
        
        <div class=notice><?php echo $module['notice']?></div>
        
        <?php echo $module['act_button'];?>
        <div class=count_down ><?php echo self::$language['count_down_a'];?> <?php echo self::$language['count_down_b'];?></div>
		<div class=bargain_detail>
			<div class=bargain_title><?php echo self::$language['bargain_title']?></div>   
            <div class=bargain_list><?php echo $module['log_detail'];?></div>     
        </div>
		
        <div class=self_bargain_div>
        	<div class=arrow><img src="<?php echo get_template_dir(__FILE__);?>/img/arrow_2.png" /></div>
            <div class=share_text_2><?php echo self::$language['share_text_2']?></div>
            <div class=return_div><a class=return_a><?php echo  self::$language['i_see']?></a></div>	
        </div>
        
        <div class=wx_qr_notice>
        	 <div class=wx_qr_notice_in>
                 <div class=u_icon><img src="<?php echo $module['u_icon'];?>" /></div>
                 <div class=notice_text><?php echo self::$language['touch_wxqr_bargain']?></div>
                 <div class=bargaom_qr><img src="./plugin/qrcode/index.php?text=<?php echo $module['log_qr']?>" /></div>
             </div>

        </div>
		
		
		
		
        
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
                       <b><?php echo self::$language['bargain_success'];?></b>
                    </h4>
                 </div>
                 <div class="modal-body thank_div" style="text-align:center;">
                     <div class=u_thank><span class=l><img src="<?php echo $module['u_icon'];?>" /></span><span class=r><?php echo self::$language['thank']?></span></div>
                     <div class=go_bargain_list_notice><?php echo self::$language['go_bargain_list_notice']?></div>
                     <div class=go_bargain><a href=./index.php?monxin=bargain.list><?php echo self::$language['go_bargain_list']?></a></div>
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
