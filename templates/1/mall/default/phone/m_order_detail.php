<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
	
    $(document).ready(function(){
		
		$("#<?php echo $module['module_name'];?> .act_div .del").on('click', function() {
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
				id=$(this).parent().parent().attr('id').replace(/order_/,'');
				$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#state_"+id).html(v.info);
					if(v.state=='success'){
					$("#order_"+id+"").animate({opacity:0},"slow",function(){$("#order_"+id).css('display','none');});
					}
				});
			}
			return false; 	
		});
		
		
		$("#<?php echo $module['module_name'];?> .cancel").on('click', function() {
  			id=$(this).parent().parent().attr('id').replace(/order_/,'');
			confirm_return=true;
			
			if($("#<?php echo $module['module_name'];?> #order_"+id+" .order_state").html()=='<?php echo self::$language['order_state'][2];?>' && $("#<?php echo $module['module_name'];?> #tr_"+id+" .pay_method").html().indexOf('<?php echo self::$language['pay_method']['cash_on_delivery'];?>')==-1 && $("#<?php echo $module['module_name'];?> #head_"+id+" .buyer a").html()!=''){
				confirm_return=confirm('<?php echo self::$language['confirm_refund'];?>');
				
			}
			if(confirm_return){
				$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class'),{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#state_"+id).html(v.info);
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #order_"+id+" .order_state").html('<?php echo self::$language['order_state'][6];?>');
						if($("#<?php echo $module['module_name'];?> #order_"+id+" .del").html()){
							$("#<?php echo $module['module_name'];?> #order_"+id+" .cancel").css('display','none');	
						}else{
							$("#<?php echo $module['module_name'];?> #order_"+id+" .cancel").attr('class','del').html('<?php echo self::$language['del']?>');
						}
						
						
					}
				});
			}
			return false;
		});
		
		
		
		
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});
		$('#<?php echo $module['module_name'];?> .edit_c').on('click',function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.my_order&id='+$(this).attr('d_id')+'&act='+$(this).attr('act'));
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .add_comment").click(function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.buyer_comment&order_id='+$(this).parent().parent().parent().parent().attr('id').replace(/order_/,'')+'&goods_id='+$(this).parent().parent().parent().attr('goods_id'));
			//alert($("#monxin_iframe").attr('src'));
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .comment .edit").on('click',function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.buyer_comment&order_id='+$(this).parent().parent().parent().parent().parent().attr('id').replace(/order_/,'')+'&goods_id='+$(this).parent().parent().parent().parent().attr('goods_id'));
			//alert($("#monxin_iframe").attr('src'));
			return false;	
		});
		/*
		$("#<?php echo $module['module_name'];?> .comment .del").on('click',function(){
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
				$.get('<?php echo $module['action_url_buyer_comment'];?>&act=del&order_id='+$(this).parent().parent().parent().parent().parent().attr('id').replace(/order_/,'')+'&goods_id='+$(this).parent().parent().parent().parent().attr('goods_id'));
				$(this).parent().parent().animate({opacity:0},"slow");
			}
			return false;	
		});
		*/
    });
	
    function update_comment(order_id,goods_id,time,content){
		id='order_'+order_id+'_goods_'+goods_id;
		$("#<?php echo $module['module_name'];?> #"+id+ " .comment").html('<div class=buyer><span class=time>'+time+'</span><span class=content>'+content+'<a href=# title="<?php echo self::$language['edit'];?>" class=edit> </a> <a href=# title="<?php echo self::$language['del'];?>" class=del> </a></span><span class=user><?php echo self::$language['myself'];?></span></div>');
		$("#<?php echo $module['module_name'];?> #"+id+" .add_comment").css('display','none');
	}
    
    
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{ }
    #<?php echo $module['module_name'];?> .order_div{  }
    #<?php echo $module['module_name'];?> .order_div > .title{ white-space:nowrap;   line-height:3rem; height:3rem; overflow:hidden;background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
    #<?php echo $module['module_name'];?> .order_div .title .time{ padding-left:0.5rem; display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
    #<?php echo $module['module_name'];?> .order_div .title .sum_money{display:inline-block; vertical-align:top; text-align:right; width:48%; overflow:hidden;}
    #<?php echo $module['module_name'];?> .order_div .title .symbol{}
    #<?php echo $module['module_name'];?> .order_div .goods_div{ white-space:nowrap; border-top:solid 1px #CCCCCC;padding-top:10px;  }
    #<?php echo $module['module_name'];?> .order_div .goods_div .icon{ display:inline-block; vertical-align:top; width:20%; overflow:hidden; text-align:center;}
    #<?php echo $module['module_name'];?> .order_div .goods_div .icon img{ width:90%;}
	#<?php echo $module['module_name'];?> .order_div .goods_div .other{ display:inline-block; vertical-align:top; white-space:normal; width:80%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .order_div .goods_div .other .title{   line-height:1.5rem; height:3rem; overflow:hidden; white-space:normal;}
	#<?php echo $module['module_name'];?> .order_div .goods_div .other .price{  line-height:3rem;}
	#<?php echo $module['module_name'];?> .order_div .goods_div .other .price a{ }
	#<?php echo $module['module_name'];?> .order_div .order_state{ display:inline-block; vertical-align:top; margin-right:20px;font-weight:bold;}
	#<?php echo $module['module_name'];?> .order_div .state_remark{ display:inline-block; vertical-align:top;margin-right:20px; }
	#<?php echo $module['module_name'];?> .order_div .state_remark br{ display:none;}
	#<?php echo $module['module_name'];?> .order_div .state_remark div{ display:inline-block; vertical-align:top;margin-right:20px;}
	.state_remark a{ display:inline-block; margin-left:0.5rem; padding-left:0.5rem; padding-right:0.5rem; line-height:2rem border:none; border-radius:0.3rem;  }	
	
	
    #<?php echo $module['module_name'];?> .order_div .act_div{ display:none; text-align:right;  line-height:2rem; padding:0.5rem;}
	#<?php echo $module['module_name'];?> .order_div .act_div a{ display:inline-block; margin-left:0.5rem; padding-left:0.5rem; padding-right:0.5rem; line-height:2rem border:none; border-radius:0.3rem;  }	
	#<?php echo $module['module_name'];?> .order_div .act_div br{ display:none;}
    #<?php echo $module['module_name'];?> .order_div .bottom_div{  }
	#<?php echo $module['module_name'];?> [monxin-table] .filter{ text-align:right; line-height:80px;}
	#<?php echo $module['module_name'];?> #search_filter{ width:70%;}
	#<?php echo $module['module_name'];?> #time_limit input{ width:150px;}
	#<?php echo $module['module_name'];?> .preferential_way div{ display:inline-block; vertical-align:top; margin-right:20px;}
	#<?php echo $module['module_name'];?> .big_money{ display:inline-block; vertical-align:top;margin-right:20px;}
	#<?php echo $module['module_name'];?> .other_info{ line-height:3rem; padding:0.5rem;}
	.buyer_address{ border-top:solid 1px #CCCCCC;padding-left:10px; padding-bottom:20px; line-height:2rem; }
	
	
	
	#<?php echo $module['module_name'];?> .goods_div .comment{ text-align:right; line-height:60px; }
	#<?php echo $module['module_name'];?> .goods_div .comment .user{ width:100px; padding-left:12px; text-align:left;}
	#<?php echo $module['module_name'];?> .goods_div .comment .buyer{margin-bottom:10px;}
	#<?php echo $module['module_name'];?> .goods_div .comment .content{ display:inline-block; padding-left:30px;  padding-right:10px; border-radius:10px;   }
	#<?php echo $module['module_name'];?> .goods_div .comment .content .edit{ width:50px; height:50px; display:inline-block;}
	#<?php echo $module['module_name'];?> .goods_div .comment .content .del{width:50px; height:50px; display:inline-block;}
	#<?php echo $module['module_name'];?> .goods_div .comment .content a:hover{ text-decoration:none;}
	#<?php echo $module['module_name'];?> .goods_div .comment .time{ padding-right:10px;  font-size:40px;}
	
	#set_monxin_iframe_div{top:40%; left:420px; }
	#monxin_iframe{ height:100px;width:500px; overflow:scroll;}
	
	#<?php echo $module['module_name'];?> .remark{  font-style:oblique; text-decoration:underline;}
	.buyer_div{ padding-left:5px; margin-bottom:0.5rem;}
	[pay_method_remark=weixin]:before{margin-left:2px; font: normal normal normal 1rem/1 FontAwesome; content:"\f1d7";}
	[pay_method_remark=weixin_wap]:after{margin-left:2px; font: normal normal normal 1rem/1 FontAwesome; content:"\f1d7";}
	[pay_method_remark=weixin_wap]:before{margin-left:2px; font: normal normal normal 1rem/1 FontAwesome; content:"\f10b";}
	[pay_method_remark=alipay]:before{margin-left:2px; font: normal normal normal 1rem/1 monxin; content:"\f01d";}
	[pay_method_remark=alipay_wap]:before{margin-left:2px; font: normal normal normal 1rem/1 monxin; content:"\f01d";}
	[pay_method_remark=weixin_wap]:before{margin-left:2px; font: normal normal normal 1rem/1 FontAwesome; content:"\f10b";}
	#<?php echo $module['module_name'];?> .o_price{text-decoration: line-through; opacity:0.4; font-size:0.9rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        
    <?php echo $module['list'];?>
    
    
    </div>
</div>
