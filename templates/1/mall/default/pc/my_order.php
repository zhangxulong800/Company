<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
	
    $(document).ready(function(){
		if(get_param('state')!=''){
			$("#<?php echo $module['module_name'];?> .state_option a").removeClass('current');
			$("#<?php echo $module['module_name'];?> .state_option a[state='"+get_param('state')+"']").addClass('current');
		}
		$("#<?php echo $module['module_name'];?> .view_logistics").each(function(index, element) {
            id=$(this).attr('order_id');
			$(this).attr('href',$("#<?php echo $module['module_name'];?> #head_"+id+" .express_code a").attr('href'));
        });
		if(get_param('state')!=''){$("#state").prop('value',get_param('state'));}
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?> [monxin-table] .operation_td .del", function() {
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
				id=$(this).parent().parent().attr('id').replace(/tr_/,'');
				$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#state_"+id).html(v.info);
					if(v.state=='success'){
						$("#tr_"+id).parent().animate({opacity:0},"slow",function(){$("#tr_"+id).parent().css('display','none');});
					}
				});
			}
			return false; 	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> [monxin-table] .cancel',function(){
			set_iframe_position(800,500);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.order_cancel&id='+$(this).attr('d_id'));
			return false;	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> [monxin-table] .apply_refund',function(){
			set_iframe_position(1000,500);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.apply_refund&id='+$(this).attr('d_id'));
			return false;	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> [monxin-table] .upload_refund_voucher',function(){
			set_iframe_position(1000,500);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.refund_express_voucher&id='+$(this).attr('d_id'));
			return false;	
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?> [monxin-table] .confirm_receipt", function() {
  			id=$(this).attr('d_id');
			confirm_return=confirm('<?php echo self::$language['confirm_receipt_alert'];?>');
			if(confirm_return){
				$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class'),{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#state_"+id).html(v.info);
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][6];?>');
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .confirm_receipt").css('display','none');	
					}
				});
			}
			return false;
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?> [monxin-table] .undo_refund", function() {
  			id=$(this).attr('d_id');
			confirm_return=confirm('<?php echo self::$language['opration_confirm_2'];?>');
			if(confirm_return){
				$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class'),{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#state_"+id).html(v.info);
					alert(v.order_state);
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html(v.order_state);
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .undo_refund").css('display','none');	
					}
				});
			}
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .add_comment").click(function(){
			set_iframe_position(800,500);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.buyer_comment&order_id='+$(this).parent().parent().parent().parent().parent().parent().attr('id').replace(/tr_/,'')+'&goods_id='+$(this).parent().parent().parent().attr('goods_id'));
			//alert($("#monxin_iframe").attr('src'));
			return false;	
		});
		$(document).on('click',"#<?php echo $module['module_name'];?> .comment .edit",function(){
			set_iframe_position(800,500);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.buyer_comment&order_id='+$(this).parent().parent().parent().parent().parent().parent().parent().attr('id').replace(/tr_/,'')+'&goods_id='+$(this).parent().parent().parent().parent().attr('goods_id'));
			//alert($("#monxin_iframe").attr('src'));
			return false;	
		});
		$(document).on('click',"#<?php echo $module['module_name'];?> .comment .del",function(){
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
				$.get('<?php echo $module['action_url']?>&act=del_comment&comment_id='+$(this).attr('d_id'),function(data){
				});
				$(this).parent().parent().animate({opacity:0},"slow");
			}
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .order_state").hover(function(){
			if($(this).children('.cancel_reason').html()){
				$("#<?php echo $module['module_name'];?> .right_notice .m").html($(this).children('.cancel_reason').html());
				$("#<?php echo $module['module_name'];?> .right_notice").css('display','block').css('left',$(this).offset().left+$(this).width()+5).css('top',$(this).offset().top);
			}	
			},function(){
			if($(this).children('.cancel_reason').html()){
				$("#<?php echo $module['module_name'];?> .right_notice").css('display','none');
			}	
		});
		
		
		$(window).scroll(function(){
			if($(window).scrollTop()>350){
				$(".sort .sort_inner").css('width',$("#<?php echo $module['module_name'];?>").width());
				$(".sort").css('width','100%').css('left','0px');
				$(".sort").css('position','fixed').css('top','0px').css('margin-top','0px').css('box-shadow','0 0 5px #888');
			}else{
				$(".sort").css('position','static').css('margin-top','10px').css('box-shadow','none');
			}		
		});


		$("#<?php echo $module['module_name'];?> .order_tr").each(function(index, element) {
            $(this).children('div').css('height',$(this).height());
        });
    });
    function update_comment(order_id,goods_id,time,content){
		id='order_'+order_id+'_goods_'+goods_id;
		if(!$("#<?php echo $module['module_name'];?> #"+id+ " .comment .buyer").html()){
			$("#<?php echo $module['module_name'];?> #"+id+ " .title_price").append('<div class=comment><div class=buyer></div></div>');
		}
		$("#<?php echo $module['module_name'];?> #"+id+ " .comment .buyer").html('<div class=buyer><span class=time>'+time+'</span><span class=content>'+content+'<a href=# title="<?php echo self::$language['edit'];?>" class=edit> </a> <a href=# title="<?php echo self::$language['del'];?>" class=del> </a></span><span class=user><?php echo self::$language['myself'];?></span></div>');
		$("#<?php echo $module['module_name'];?> #"+id+" .add_comment").css('display','none');
	}
	
	function update_cancel_state(id){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .pay_time_limit").css('display','none');	
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .go_pay").css('display','none');	
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][4];?>');
		if($("#<?php echo $module['module_name'];?> #tr_"+id+" .del").html()){
			$("#<?php echo $module['module_name'];?> #tr_"+id+" .cancel").css('display','none');	
			$("#<?php echo $module['module_name'];?> #tr_"+id+" .state_remark").css('display','none');	
		}else{
			$("#<?php echo $module['module_name'];?> #tr_"+id+" .cancel").attr('class','del').html('<?php echo self::$language['del']?>');
		}
	}
		
	function update_state_7(id){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][7];?>');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .apply_refund").html('<?php echo self::$language['edit'];?><?php echo self::$language['apply'];?>');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .del").css('display','none');	
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .confirm_receipt").css('display','none');	
	}
    
	function update_state_9(id){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][9];?>');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .upload_refund_voucher").html('<?php echo self::$language['edit_refund_voucher'];?>');
	}
    
    </script>
	<style>
	#set_monxin_iframe_div{top:40%; left:420px; }
	#monxin_iframe{ height:100px;width:500px; overflow:scroll;}
	
	#<?php echo $module['module_name'];?> .light{ background:<?php echo $_POST['monxin_user_color_set']['module']['background']?>;}
    #<?php echo $module['module_name'];?>{ background:none;}
	#<?php echo $module['module_name'];?> input {margin:0 5px;}
    #<?php echo $module['module_name'];?> .add_comment{ padding-left:10px; font-style:oblique;}
    #<?php echo $module['module_name'];?> [monxin-table] .filter{ line-height:50px;} 
	
    #<?php echo $module['module_name'];?> #search_filter{ width:280px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info{  padding-left:10px; height:2.85rem; line-height:2.85rem; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info a{color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
        #<?php echo $module['module_name'];?> .title_tr .buyer_info br{display:none;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .buyer{ display:inline-block; vertical-align:top; min-width:120px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .add_time{ display:inline-block; vertical-align:top; min-width:120px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .order_id{ display:inline-block; vertical-align:top; min-width:140px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .goods_money{ display:inline-block; vertical-align:top; min-width:180px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .express_cost_buyer{ display:inline-block; vertical-align:top; min-width:150px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .express_cost_seller{ display:inline-block; vertical-align:top; min-width:150px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_info .invoice{ display:inline-block; vertical-align:top; min-width:120px; margin-right:20px;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address{padding-left:10px; font-size:1rem; line-height:2.2rem;  background: #EFEFEF;color:#999; }
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .delivery_time{  padding-left:20px; color: #888;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .express{  padding-left:20px; color: #888;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .express_code{  padding-left:10px; color: #888;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .express_code a{color: #888;}
	
	#<?php echo $module['module_name'];?> .order_tr{ white-space:nowrap;}
	#<?php echo $module['module_name'];?> .goods_td{ display:inline-block; vertical-align:top; width:54%;padding-left:1%; overflow:hidden; text-align:left;}
	#<?php echo $module['module_name'];?> .preferential_td{ display:inline-block; vertical-align:top; width:10%; padding-left:1%; padding-top:10px; overflow:hidden; border-left:#CCC dashed 1px;  text-align:center; white-space:normal;}
	#<?php echo $module['module_name'];?> .state_td{ display:inline-block; vertical-align:top; width:10%; padding-left:1%;padding-top:10px;border-left:#CCC dashed 1px; overflow:hidden;text-align:center;white-space:normal;}
	#<?php echo $module['module_name'];?> .operation_td{ display:inline-block; vertical-align:top; width:20%;padding-left:1%;padding-top:10px;border-left:#CCC dashed 1px;  overflow:hidden;white-space:normal; line-height:25px;}
	#<?php echo $module['module_name'];?> .goods_info{ padding-top:10px;padding-bottom:10px; }
	#<?php echo $module['module_name'];?> .goods_info .goods{ padding-bottom:20px;  }
	#<?php echo $module['module_name'];?> .goods_info .goods .icon{ display:inline-block; vertical-align:top; width:60px; height:60px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .icon img{ width:60px; height:60px; border:none;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price{ padding-left:10px;  display:inline-block; vertical-align:top; width:600px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price .title{text-align:left; display:block; line-height:20px; height:40px; font-size:1rem; text-decoration:none; overflow:hidden; white-space: normal;text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price .price{ font-size:1rem; line-height:20px; text-align:left;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price .price a{ padding-right:30px;}
	
	#<?php echo $module['module_name'];?> .goods_info .goods .comment{ text-align:right; line-height:25px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .buyer{}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .seller{ margin-top:10px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .user{ display:inline-block; width:50px; text-align:left;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .user:before{margin-right:8px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da";color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content{display:inline-block; white-space:normal; text-align:left; padding-left:10px;  padding-right:10px; border-radius:5px; background:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['text']?>; font-size:1rem;  max-width:70%;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .edit{ width:20px; height:25px; display:inline-block;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .del{ width:20px; height:25px; display:inline-block;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .edit:before{margin-left:8px; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; font: normal normal normal 1rem/1 FontAwesome; content:"\f040";}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .del:before{margin-left:8px; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; font: normal normal normal 1rem/1 FontAwesome; content:"\f014";}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content a:hover{ text-decoration:none;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .time{ padding-right:10px; color:#CCC; font-size:13px;}
	
	
	#<?php echo $module['module_name'];?> .remark{ color: #777; font-size:1rem;}
	
	
	#<?php echo $module['module_name'];?> .checkbox_td{ vertical-align:top; padding-top:8px;}
	#<?php echo $module['module_name'];?> .preferential_way{ background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; margin-top:10px; padding-left:5px; padding-right:5px; border-radius:5px;}
	#<?php echo $module['module_name'];?> .money_div{}
	#<?php echo $module['module_name'];?> .money_div .sum_money{}
	#<?php echo $module['module_name'];?> .money_div .sum_money .value{}
	#<?php echo $module['module_name'];?> .money_div .actual_money{}
	#<?php echo $module['module_name'];?> .money_div .actual_money .value{}
	#<?php echo $module['module_name'];?> .change_price_reason{ font-style:oblique; font-size:1rem;}
	
	#<?php echo $module['module_name'];?> .preferential_way{ line-height:20px; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;display:inline-block; padding:5px;}
	
	#<?php echo $module['module_name'];?> .state_remark{}
	#<?php echo $module['module_name'];?> .state_remark .pay_method{  display:inline-block; padding:5px; line-height:20px; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;border-radius:5px;}
	
	#<?php echo $module['module_name'];?> .operation_td a{ font-size:16px;}
	#<?php echo $module['module_name'];?> .operation_td .time_limit {padding-left: 18px;font-size: 1rem;color: #808080;}
	#<?php echo $module['module_name'];?> .operation_td .time_limit:before{margin-right:8px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f017";}
	
	#<?php echo $module['module_name'];?> .edit_a{ display:inline-block; height:20px; width:20px; }
	#<?php echo $module['module_name'];?> .edit_b{ display:inline-block; height:20px; width:20px;}
	#<?php echo $module['module_name'];?> .edit_a:before{margin-right:8px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f044";}
	#<?php echo $module['module_name'];?> .edit_b:before{margin-right:8px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f040";}
	#<?php echo $module['module_name'];?> .filter #time_limit .submit .b_middle{background: #ccc;padding: 5px 10px;border-radius:2px;}
	#<?php echo $module['module_name'];?> .filter .search .b_middle{background: #ccc;padding: 5px 10px; border-radius:2px;}
	#<?php echo $module['module_name'];?> .order_state{ display:block; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;  cursor:pointer; margin-bottom:10px; border-radius:5px;}
	#<?php echo $module['module_name'];?> .go_pay{ display:block; background: #F60; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; padding-left:5px;}
	#<?php echo $module['module_name'];?> .big_money{ font-size:18px; font-weight:bold; text-align:center; line-height:40px;}
	#<?php echo $module['module_name'];?> .pay_time_limit{ line-height:22px; font-size:1rem; color: #666;}
	#<?php echo $module['module_name'];?> .view_logistics{ display:block;}
	#<?php echo $module['module_name'];?> .cancel_reason{}
	.right_notice{display:none;position:absolute;height:30px; line-height:30px; overflow:hidden; white-space:nowrap; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; z-index:9999;}
	.mall_order{ padding:0px !important; overflow:hidden; margin-bottom:30px;}
	.mall_order:hover{ opacity:0.9;}
	.sort{ z-index:99999; line-height:2rem; height:2rem; padding:0px !important; margin:0px;background-color:#fff; margin-top:15px;}
	.sort .sort_inner{ margin:auto;}
	.sort div{ padding-top:0px !important;}
	.credits_remark{ display:inline-block; vertical-align:top;padding-left:0.5rem;	}
	.refund{ margin-left:10px; opacity:0.5;}
	
	[pay_method_remark=weixin]:before{margin-left:2px; font: normal normal normal 1rem/1 FontAwesome; content:"\f1d7";}
	[pay_method_remark=weixin_wap]:after{margin-left:2px; font: normal normal normal 1rem/1 FontAwesome; content:"\f1d7";}
	[pay_method_remark=weixin_wap]:before{margin-left:2px; font: normal normal normal 1rem/1 FontAwesome; content:"\f10b";}
	[pay_method_remark=alipay]:before{margin-left:2px; font: normal normal normal 1rem/1 monxin; content:"\f01d";}
	[pay_method_remark=alipay_wap]:before{margin-left:2px; font: normal normal normal 1rem/1 monxin; content:"\f01d";}
	[pay_method_remark=weixin_wap]:before{margin-left:2px; font: normal normal normal 1rem/1 FontAwesome; content:"\f10b";}
	#<?php echo $module['module_name'];?> .o_price{text-decoration: line-through; opacity:0.4; font-size:0.9rem;}
	
	#<?php echo $module['module_name'];?> .buyer_remark .paper{ font-size:1.3rem;} 
	#<?php echo $module['module_name'];?> .buyer_remark .docs .doc_div{ line-height:2rem;} 
	#<?php echo $module['module_name'];?> .buyer_remark .docs .doc_div .t{ display:inline-block; vertical-align:top; width:80%; overflow:hidden;} 
	#<?php echo $module['module_name'];?> .buyer_remark .docs .doc_div .p{ display:inline-block; vertical-align:top; width:5%; overflow:hidden;} 
	#<?php echo $module['module_name'];?> .buyer_remark .docs .doc_div .q{ display:inline-block; vertical-align:top; width:5%; overflow:hidden;} 
	#<?php echo $module['module_name'];?> .buyer_remark .docs .doc_div .d{ display:inline-block; vertical-align:top; width:5%; overflow:hidden;} 
   
    #<?php echo $module['module_name'];?>_html .state_option{ border-bottom:1px solid #ccc; background:#fff; margin-bottom:1rem; line-height:3rem; white-space:nowrap; width:100%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .state_option a{ display:inline-block; vertical-align:top; margin-left:5px; margin-right:5px; padding-left:5px; padding-right:5px;}
	#<?php echo $module['module_name'];?>_html .state_option a:hover{color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html .state_option .current{ color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; border-bottom:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div  class="portlet light" >
       

        <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['order_number']?>/<?php echo self::$language['receiver_info'];?>" class="form-control" ></m_label></div></div></div>
		 <div class=state_option><?php echo $module['state_option']?></div>
    </div>

    <div class="sort">
    	<div class="sort_inner">
        <div class=goods_td><a href=#  title="<?php echo self::$language['order']?>" desc="add_time|desc" class="sorting"  asc="add_time|asc"><?php echo self::$language['time']?>     </a></div>
        <div class=preferential_td><a href=# title="<?php echo self::$language['order']?>" desc="actual_money|desc" class="sorting"  asc="actual_money|asc"><?php echo self::$language['money']?></a></div>
        <div class=state_td><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['state']?></a></div>
        <div class=operation_td><span class=operation_icon> </span><?php echo self::$language['operation']?></div>
        </div>
    </div>
    <?php echo $module['list']?>
    <?php echo $module['page']?>
    </div>
</div>