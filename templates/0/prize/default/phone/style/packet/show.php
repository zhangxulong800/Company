<!---------------------------------------------------------------------------------------------prize_show_start-->
<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align="center">
	<script src="<?php echo get_template_dir(__FILE__)?>shake.js" ></script>
    <audio id="shakemusic" src="<?php echo get_template_dir(__FILE__)?>red-01.mp3" style="display: none;"></audio>
    <audio id="openmusic" src="<?php echo get_template_dir(__FILE__)?>red-02.mp3" style="display: none;"></audio>
	<script>
	wx.ready(function(){							
		wx.onMenuShareTimeline({
			title: '<?php echo $module['data']['share_title']?>', 
			link: window.location.href+'#&share='+getCookie('monxin_id')+'&', 
			imgUrl: '<?php echo $module['data']['share_icon']?>', 
			success: function () {$("#<?php echo $module['module_name'];?>").attr('share','ok');},
			cancel: function () {}
		});		
	});
	
	
	
	var is_confirm=false;
	var shaked=false;
	
	function update_remain(){
		if(remain_time==0){
			window.clearInterval(t1);
			$("#<?php echo $module['module_name'];?>_html").css('display','block');
			$("#<?php echo $module['module_name'];?> .ad").css('display','none');
			shaked=false;
		}
		$("#<?php echo $module['module_name'];?> .ad_second").html(remain_time--);	
	}
	
	function remove_shake_css(){
		$("#shake_img").removeClass('shake animated');	
	}
	
	var t1;
	var remain_time=<?php echo $module['data']['ad_second']?>;
	
	$(document).ready(function(){
		
		//create a new instance of shake.js.
		var myShakeEvent = new Shake({
			threshold: 15
		});
	
		// start listening to device motion
		myShakeEvent.start();
	
		// register a shake event
		window.addEventListener('shake', shakeEventDidOccur, false);
	
		//shake event callback
		function shakeEventDidOccur () {
			//alert(shaked);
			if(shaked){return false;}
			$('#shakemusic').trigger('play');
			$("#shake_img").addClass('shake animated');
			var t=setTimeout(remove_shake_css,1000);
			
			
			switch(<?php echo $module['data']['try_mode']?>){
				case 0:
					is_confirm=true;
					break;	
				case 1:
					if($("#<?php echo $module['module_name'];?>").attr('type_value')==undefined || $("#<?php echo $module['module_name'];?>").attr('type_value')==''){
						$('#try_mode_1').modal({  
						   backdrop:true,  
						   keyboard:true,  
						   show:true  
						});  
						$("#try_mode_1").css('margin-top',($(window).height()-$("#try_mode_1 .modal-content").height())/5);	
					}else{
						is_confirm=true;
					}							
					break;	
				case 2:
					if($("#<?php echo $module['module_name'];?>").attr('share')!='ok' ){
						alert('<?php echo self::$language['before_weixin_share']?>');	
					}else{
						is_confirm=true;
					}
					break;	
				case 3:
					//alert(getCookie('monxin_nickname'));
					if(!is_confirm){if(confirm("<?php echo self::$language['try_mode_3_notice']?>")){is_confirm=true;}else{is_confirm=false;}}
					break;	
				case 4:
					if(!is_confirm){if(confirm("<?php echo self::$language['try_mode_4_notice']?>")){is_confirm=true;}else{is_confirm=false;}}
					break;	
				case 5:
					if($("#<?php echo $module['module_name'];?>").attr('type_value')==undefined || $("#<?php echo $module['module_name'];?>").attr('type_value')==''){
						$('#try_mode_5').modal({  
						   backdrop:true,  
						   keyboard:true,  
						   show:true  
						});  
						$("#try_mode_5").css('margin-top',($(window).height()-$("#try_mode_5 .modal-content").height())/5);	
					}else{
						is_confirm=true;
					}
							
					break;	
			}
			if(!is_confirm){
				return false;
			
			}
			
			shaked=true;
				
			$.post('<?php echo $module['action_url'];?>&act=try',{try_mode_value:$("#<?php echo $module['module_name'];?>").attr('type_value')},function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				if(v.state=='success'){
					$('#openmusic').trigger('play');
					if($("#<?php echo $module['module_name'];?> #try_mode_5 input").val()!=''){
						$("#<?php echo $module['module_name'];?>").attr('type_value','');
						$("#<?php echo $module['module_name'];?> #try_mode_5 input").prop('value','');
					}
					$("#<?php echo $module['module_name'];?> .prize_name").html(v.prize_index);
					if(v.type!=0){
						$(".modal-body div").css('display','none');
						$('#myModal').modal({  
						   backdrop:true,  
						   keyboard:true,  
						   show:true  
						});  
						$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/5);	
						$("#myModal .modal-title").html('<?php echo self::$language['win_prize'];?>');
						if(v.type==1){
							$(".modal-body .prize_type_"+v.type+" .prize_name").html(v.prize_name);
							$(".modal-body .prize_type_"+v.type+" .prize_name").attr('new_id',v.new_id);
							$(".modal-body .prize_type_"+v.type+" input").val('');		
						}
						if(v.type==2){$(".modal-body .prize_type_"+v.type).html($(".modal-body .prize_type_"+v.type).attr('value')+' '+v.prize_name+' '+v.type_2);}
						if(v.type>2){$(".modal-body .prize_type_"+v.type).html(v.prize_name+' '+$(".modal-body .prize_type_"+v.type).attr('value'));}
						$(".modal-body .prize_type_"+v.type).css('display','block');
					}else{
						$("#<?php echo $module['module_name'];?> #no_prize .modal-title b").html('<?php echo self::$language['this_time_did_not_win']?>: '+v.prize_index);
						$('#no_prize').modal({  
						   backdrop:true,  
						   keyboard:true,  
						   show:true  
						});  
						$("#no_prize").css('margin-top',($(window).height()-$("#no_prize .modal-content").height())/5);	
					}
					
					
				}else{
					monxin_alert(v.info);
					if(v.try_mode_value=='clear'){
						$("#<?php echo $module['module_name'];?>").attr('type_value','');
						$("#<?php echo $module['module_name'];?> #try_mode_1 input").prop('value','');
						$("#<?php echo $module['module_name'];?> #try_mode_5 input").prop('value','');
					}	
				} 
			  	shaked=false;
			});
				
			
			
		}
		
			
		
		
		
		$(document).on('touchstart','.shake_div',function(e){
			e.stopPropagation(); 
			return false;
		});
		$(document).on('touchend','.shake_div',function(e){
			e.stopPropagation(); 
			return false;
		});
		$(document).on('touchstart','.again',function(e){
			window.location.reload();
			return false;
		});
		
		$(".container").height($(window).height());
		if($("#<?php echo $module['module_name'];?>_html .over_limit").html().length>0){
			$('#over_limit').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#over_limit").css('margin-top',($(window).height()-$("#over_limit .modal-content").height())/3);	
			$("#over_limit .modal-title").html($("#<?php echo $module['module_name'];?>_html .over_limit").html());
		}
		
		$("#<?php echo $module['module_name'];?> #try_mode_1 .submit").click(function(){
			if($("#<?php echo $module['module_name'];?> #try_mode_1 .name").val()==''){
				$("#<?php echo $module['module_name'];?> #try_mode_1 .name").focus();
				return false;	
			}
			if($("#<?php echo $module['module_name'];?> #try_mode_1 .phone").val()==''){
				$("#<?php echo $module['module_name'];?> #try_mode_1 .phone").focus();
				return false;	
			}
			if(!$("#<?php echo $module['module_name'];?> #try_mode_1 .phone").val().match(<?php echo $module['phone_reg'];?>)){
				alert('<?php echo self::$language['phone'];?><?php echo self::$language['pattern_err'];?>');
				$("#<?php echo $module['module_name'];?> #try_mode_1 .phone").focus();
				return false;	
			}
			
			$("#<?php echo $module['module_name'];?>").attr('type_value',$("#<?php echo $module['module_name'];?> #try_mode_1 .name").val()+'|||'+$("#<?php echo $module['module_name'];?> #try_mode_1 .phone").val());
			$('#try_mode_1').modal('hide'); 
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> #try_mode_5 .submit").click(function(){
			if($("#<?php echo $module['module_name'];?> #try_mode_5 input").val()==''){
				$("#<?php echo $module['module_name'];?> #try_mode_5 input").focus();
				return false;	
			}
			$("#<?php echo $module['module_name'];?>").attr('type_value',$("#<?php echo $module['module_name'];?> #try_mode_5 input").val());
			$('#try_mode_5').modal('hide'); 
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?>_html .receiver_div .submit").click(function(){
			$("#<?php echo $module['module_name'];?>_html .receiver_div input").removeClass('err_input');
			$("#<?php echo $module['module_name'];?>_html .receiver_div .submit").next().html('');
			is_null=false;
			$("#<?php echo $module['module_name'];?>_html .receiver_div input").each(function(index, element) {
                if($(this).val()==''){
					$(this).addClass('err_input');
					$(this).focus();
					is_null=true;
					return false;	
				}
				
            });
			if(is_null){
				$("#<?php echo $module['module_name'];?>_html .receiver_div .submit").next().html('<span class=fail><?php echo self::$language['is_null']?></span>');
				return false;	
			}
			if(!$(".modal-body .receiver_div .prize_name").attr('new_id')){
				$("#<?php echo $module['module_name'];?>_html .receiver_div .submit").next().html('<span class=fail>new_id <?php echo self::$language['is_null']?></span>');
				return false;	
			}
			if(!$("#<?php echo $module['module_name'];?>_html .receiver_div .phone").val().match(<?php echo $module['phone_reg'];?>)){
				alert('<?php echo self::$language['phone'];?><?php echo self::$language['pattern_err'];?>');
				$("#<?php echo $module['module_name'];?>_html .receiver_div .phone").addClass('err_input');
				return false;	
			}
			
			
			$("#<?php echo $module['module_name'];?>_html .receiver_div .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add_receiver',{new_id:$(".modal-body .receiver_div .prize_name").attr('new_id'),name:$("#<?php echo $module['module_name'];?>_html .receiver_div .name").val(),phone:$("#<?php echo $module['module_name'];?>_html .receiver_div .phone").val(),address:$("#<?php echo $module['module_name'];?>_html .receiver_div .address").val()}, function(data){
			   
			   try{v=eval("("+data+")");}catch(exception){alert(data);}
			   $("#<?php echo $module['module_name'];?>_html .receiver_div .submit").next().html(v.info);
			   if(v.state=='success'){$("#<?php echo $module['module_name'];?>_html .receiver_div .submit").css('display','none');}
				 
			});
			
			return false;	
		});
		
		$(document).on('touchstart',"#<?php echo $module['module_name'];?> #myCanvas",function(){
			if(shaked){return false;}
				
		});	
		var prize=new Array(<?php echo $modue['prize_names'];?>);	
		var prize_data='';
		for(i in prize){
			prize_data+="{value:1, name:"+prize[i]+",itemStyle:{normal:{color: 'rgba(255, 101, 0, 1)',label: {textStyle: {fontSize: 30}}}}},";
		}
		prize_data='['+prize_data+']';
		//alert(prize_data);
		//prize_data=eval("("+prize_data+")");
		
		
		
		if(remain_time>0){
			shaked=true;
			$("#<?php echo $module['module_name'];?> .ad").css('display','block');
			$("#<?php echo $module['module_name'];?>_html").css('display','none');
			var t1 = window.setInterval(update_remain,1000);
			
		}



	});
	</script>
	<style>
	.page-footer{ height:0px; padding:0px !important;}
	#index_foot,#index_device{ display:none;}
	body,.page-container,.page-content,.container{ width:100%;  margin:0px; padding:0px;}
	.container{}
	.container{}
    #<?php echo $module['module_name'];?>{ width:100%; padding-bottom:50px; background:<?php echo $module['data']['bg_color']?>; background:url(<?php echo $module['data']['phone_bg']?>); background-size:cover; padding-top:<?php echo $module['data']['phone_padding_top']?>;}
	 #<?php echo $module['module_name'];?>_html{}
	 
	 .pointer_div_out{ position:relative; top:-100%; height:100%;  padding-top:26%; }
    #<?php echo $module['module_name'];?> .shake_div{}
    #<?php echo $module['module_name'];?> .wheel_img{ width:30%;}
    #<?php echo $module['module_name'];?> .pointer_div{ display:inline-block; width:13%;  }
    #<?php echo $module['module_name'];?> .pointer_img{ width:100%;}
	.modal-body div{ display:none;}
	.receiver_div{ display:inline-block;  margin:auto; width:200px; text-align:left; line-height:40px;}
	.err_input{ border-color:red !important;}
	[rotate='1']{
		-webkit-animation:circle 0.3s infinite linear;/*匀速 循环*/
	}
	[rotate='0']{
		-webkit-animation:circle 10s infinite ease-out 10s 1;/*匀速 循环*/
	}
	@-webkit-keyframes circle{
	0%{ transform:rotate(0deg); }
	100%{ transform:rotate(360deg); }
	}
	
	
	#try_mode_1 .modal-body{ width:50%; margin:auto; text-align:left; line-height:40px;}	
	#try_mode_5 .modal-body{ width:50%; margin:auto; text-align:left; line-height:40px;}	
	.prize_info{  text-align:left; opacity:0.8; line-height:20px;}
	.shake_div{ text-align:center;  -webkit-user-select:none;
    -moz-user-select:none;
    -ms-user-select:none;
    user-select:none;
	}
	
	.prize_winner{}
	.winner_list{ background-color:#fff; border-radius:10px; padding:10px; height:120px;}
	.winner_list span{ display:inline-block; vertical-align:top;}
	.winner_list div{ border-bottom:1px dashed #CCCCCC; color:#999;}
	.winner_list .username{ width:30%; white-space:nowrap;text-overflow:ellipsis; overflow:hidden;}
	.winner_list .o_name{ width:40%; white-space:nowrap;text-overflow:ellipsis; overflow:hidden;}
	.winner_list .time{ width:30%; white-space:nowrap;text-overflow:ellipsis; overflow:hidden; line-height:25px;}
	
	#<?php echo $module['module_name'];?> .item_name{ border-bottom:1px solid #fff; line-height:30px;}
	#<?php echo $module['module_name'];?> .prize_winner .item_name{ border:none;}

	
	#<?php echo $module['module_name'];?> .prize_info{ color:#FFF; }
	#<?php echo $module['module_name'];?> .prize_info marquee{ margin:0px; }
	#<?php echo $module['module_name'];?> .prize_info > div { width:80%; margin:auto; margin-bottom:20px; }
	.prize_quantity .content{}
	#<?php echo $module['module_name'];?> .ad{ width:100%; height:100%;position:absolute;top:0px; display:none; }
	#<?php echo $module['module_name'];?> .ad img{width:100%; height:100%;}
	#<?php echo $module['module_name'];?> .ad .count_down{ position:absolute;top:0px;right:20px; margin:10px;z-index:9999999999999999; background-color:rgba(255,255,255,0.7); opacity:0.5; padding:5px; color:#FFF; border-radius:5px;}
    
    .shake_div{ padding-top:12%;}
    .shake_div img{ width:40%;}
    .shake_div .m_label{ font-size:30px; margin-bottom:10px; color:#FFF;}
    .shake_div .scratch_area{ width:200px;  height:50px; margin:auto; border-radius:5px; overflow:hidden;}
	.shake_div .scratch_area .prize_name{ width:100%; height:100%; background-color:#FFF; color:red; line-height:50px; font-size:20px;}
	#myCanvas{ position: relative; top:-50px;  cursor: pointer; z-index:999; border-radius:5px; }
	#myCanvas:hover{ border:1px dashed  #FF9900; height:49px; width:199px;}
	.again{  color:#FFF !important;}
    </style>
    <?php echo $module['data']['diy_css'];?>
    <div id="<?php echo $module['module_name'];?>_html" >
    	
        <div class=over_limit style="display:none;"><?php echo $module['over_limit']?></div>
   		<div class=shake_div>
            <img id=shake_img src=<?php echo get_template_dir(__FILE__)?>shake.png />
        </div>
   		
		<div class=prize_info>
        	<div class=prize_quantity>
            	<div class=item_name><?php echo self::$language['prize']?><?php echo self::$language['set']?></div>
                <div class=content><?php echo $module['prize_set'];?></div>
            </div>
            <div class=prize_remark>
            	<div class=item_name><?php echo self::$language['prize_remark']?></div>
                <div class=content><?php echo $module['prize_remark'];?></div>
            </div>
            <div class=prize_winner>
            	<div class=item_name><?php echo self::$language['latest_winner']?></div>
                <marquee class=winner_list direction=up behavior=scroll loop=0 scrollamount=1 scrolldelay=10 align=top hspace=20 vspace=10 onmouseover=this.stop() onmouseout=this.start()><?php echo $module['latest_winner'];?></marquee>
            </div>
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
                   <b></b>
                </h4>
             </div>
             <div class="modal-body">
                 <div class=prize_type_1 >
                 	<span class=receiver_div>
                        <p><?php echo self::$language['prize_type'][1]?>:<span class=prize_name></span></p>
                        <p><input type="text" class=name placeholder="<?php echo self::$language['receiver'];?>" /></p>
                        <p><input type="text" class=phone placeholder="<?php echo self::$language['phone'];?>" /></p>
                        <p><input type="text" class=address placeholder="<?php echo self::$language['address'];?>" /></p>
                        <p><a href=# class=submit><?php echo self::$language['submit'];?></a> <span class=state></span></p>
                    </span>
                 </div>
                 <div class=prize_type_2 value='<?php echo self::$language['prize_type'][2]?>:'></div>
                 <div class=prize_type_3 value='<?php echo self::$language['sys_auto_sent']?>'></div>
                 <div class=prize_type_4 value='<?php echo self::$language['sys_auto_sent']?>'></div>
                 <div class=prize_type_5 value='<?php echo self::$language['sys_auto_sent']?>'></div>
             </div>
             <div class="modal-footer"><a href=./index.php?monxin=prize.my target=_blank><?php echo self::$language['pages']['prize.my']['name']?></a> &nbsp; 
                <button type="button" class="btn btn-default" 
                   data-dismiss="modal"><?php echo self::$language['close']?>
                </button>
                
             </div>
          </div>
    	</div>
    </div>
       
    <div class="modal fade" id="over_limit" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal" aria-hidden="true">
                      &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                   <b></b>
                </h4>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-default" 
                   data-dismiss="modal"><?php echo self::$language['close']?>
                </button>
                
             </div>
          </div>
    	</div>
    </div>
            
       
    <div class="modal fade" id="try_mode_1" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal" aria-hidden="true">
                      &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                   <b><?php echo self::$language['before_input_contact']?></b>
                </h4>
             </div>
             <div class="modal-body">
             	<input type="text" class=name placeholder="<?php echo self::$language['name']?>" /><br />
             	<input type="text" class=phone placeholder="<?php echo self::$language['phone']?>" /><br />
                <a href=# class=submit><?php echo self::$language['submit']?></a>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-default" 
                   data-dismiss="modal"><?php echo self::$language['close']?>
                </button>
                
             </div>
          </div>
    	</div>
    </div>
            
            
       
    <div class="modal fade" id="try_mode_5" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal" aria-hidden="true">
                      &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                   <b><?php echo self::$language['before_input_code']?></b>
                </h4>
             </div>
             <div class="modal-body">
             	<input type="text" class=code placeholder="<?php echo self::$language['try_mode_5']?>" /><br />
                <a href=# class=submit><?php echo self::$language['submit']?></a>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-default" 
                   data-dismiss="modal"><?php echo self::$language['close']?>
                </button>
                
             </div>
          </div>
    	</div>
    </div>
  
  
            
       
    <div class="modal fade" id="no_prize" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal" aria-hidden="true">
                      &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                   <b></b>
                </h4>
             </div>
             <div class="modal-footer"><a href=./index.php?monxin=prize.my target=_blank><?php echo self::$language['pages']['prize.my']['name']?></a> &nbsp; 
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo self::$language['close']?>
                </button>
                
             </div>
          </div>
    	</div>
    </div>
            
   
	</div>
   <div class=ad>
   	<div class=ad_content><?php echo $module['data']['phone_ad']?></div>
    <div class=count_down><?php echo self::$language['ad_count_down']?> <b class=ad_second><?php echo $module['data']['ad_second']?></b> <?php echo self::$language['s']?></div>
   </div>
    
</div>




<!---------------------------------------------------------------------------------------------prize_show_end-->
