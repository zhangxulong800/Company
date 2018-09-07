<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
	
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .state_remark").each(function(index, element) {
            if(!$(this).children('a').attr('href')){
				$(this).css('display','none');
			}
        });
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
		
		$("#<?php echo $module['module_name'];?> .goods_td").click(function(){
			id=$(this).parent().attr('id').replace(/tr_/,'');
			//window.location.href='./index.php?monxin=mall.m_order_detail&id='+id;
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
						$("#tr_"+id).animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
					}
				});
			}
			return false; 	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> [monxin-table] .cancel',function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.order_cancel&id='+$(this).attr('d_id'));
			return false;	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> [monxin-table] .apply_refund',function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.apply_refund&id='+$(this).attr('d_id'));
			return false;	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> [monxin-table] .upload_refund_voucher',function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
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
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.buyer_comment&order_id='+$(this).parent().parent().parent().parent().parent().parent().attr('id').replace(/tr_/,'')+'&goods_id='+$(this).parent().parent().parent().attr('goods_id'));
			//alert($("#monxin_iframe").attr('src'));
			return false;	
		});
		$(document).on('click',"#<?php echo $module['module_name'];?> .comment .edit",function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
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
				$.get('receive.php?target=mall::my_order&act=del_comment&comment_id='+$(this).attr('d_id'),function(data){
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
				$(".sort").css('position','fixed').css('top','0px').css('margin-top','0px');
			}else{
				$(".sort").css('position','static').css('margin-top','10px');
			}		
		});

		$("#<?php echo $module['module_name'];?> .order_tr").each(function(index, element) {
            $(this).children('div').css('height',$(this).height());
        });
    });
    
    function update_comment(order_id,goods_id,time,content){
		id='order_'+order_id+'_goods_'+goods_id;
		$("#<?php echo $module['module_name'];?> #"+id+ " .comment").html('<div class=buyer><span class=time>'+time+'</span><span class=content>'+content+'<a href=# title="<?php echo self::$language['edit'];?>" class=edit> </a> <a href=# title="<?php echo self::$language['del'];?>" class=del> </a></span><span class=user><?php echo self::$language['myself'];?></span></div>');
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
	
    #<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> input {margin:0 5px;}
    #<?php echo $module['module_name'];?> .add_comment{ padding-left:10px; font-style:oblique;}
    #<?php echo $module['module_name'];?> .m_row,.filter{  padding:0.3rem;} 
    #<?php echo $module['module_name'];?> .filter{box-shadow: 0px 2px 5px 1px rgba(0, 0, 0, 0.1);} 
	
	
	.mall_order{  margin-top:1rem;margin-bottom:1rem;box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1);padding:0.5rem;}
	.mall_order .order_head{ line-height:2rem; border-bottom: 1px solid  #EEE; }
	.mall_order .order_head .shop_name{ display:inline-block; vertical-align:top; width:50%;}
	.mall_order .order_head .shop_name:after{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f105"; }
	.mall_order .order_head .order_state{display:inline-block; vertical-align:top; width:50%; text-align:right; font-weight:bold; }
	.preferential_td{text-align:right; line-height:3rem;}
	.preferential_td div{ display:inline-block;}
	.preferential_td .big_money{  }
	.operation_td{ text-align:right;}
	.goods_td{}
	.goods_td .goods_info{ padding:0.3rem;  margin-bottom:0.5rem;}
	.goods_td .goods_info .goods_div{ border-bottom: 1px #CCCCCC dashed; padding-top:0.3rem; padding-bottom:0.3rem;}
	.goods_td .goods_info .icon{ display:inline-block; vertical-align:top; width:20%; text-align:center;}
	.goods_td .goods_info .icon img{ width:80%;}
	.goods_td .goods_info .other{display:inline-block; vertical-align:top; width:80%;  }
	.goods_td .goods_info .other a{  }
	.goods_td .goods_info .other .title{ line-height:1.5rem; height:3rem; overflow:hidden; }
	.goods_td .goods_info .other .price{ 		}
	.state_remark{ display: block; text-align:right; line-height:3rem;}	
	.state_remark br{ display:none;}	
	.state_remark div{  display:inline-block;}	
	.state_remark a{ display:inline-block; margin-left:0.5rem; padding-left:0.5rem; padding-right:0.5rem; line-height:2rem; border-radius:0.3rem;  }	
	.preferential_way{ padding-right:1rem;}
	.preferential_way br{ display:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div  class="portlet light" >
        <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['order_number']?>/<?php echo self::$language['buyer']?><?php echo self::$language['username']?>/<?php echo self::$language['receiver_info'];?>/<?php echo self::$language['express_code']?>/<?php echo self::$language['preferential_code'];?>/<?php echo self::$language['promotion'];?>/<?php echo self::$language['check_code'];?>" class="form-control" style="width:500px;" ></m_label></div></div></div>
		
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>     
                 <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
       <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>

    <div class=sum_div>
		<?php echo self::$language['sum']?>：<span class=sum_value><?php echo $module['sum']['sum']?></span><?php echo self::$language['yuan']?>
    </div>
    </div>
    
    </div>
    <div class=order_div>
    	 <?php echo $module['list']?>
    </div>
   
    <?php echo $module['page']?>
    </div>
</div>