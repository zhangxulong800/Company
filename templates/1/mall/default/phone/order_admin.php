<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .view_logistics").each(function(index, element) {
            id=$(this).attr('order_id');
			$(this).attr('href',$("#<?php echo $module['module_name'];?> #tr_"+id+" .express_code a").attr('href'));
        });
		if(get_param('state')!=''){$("#state").prop('value',get_param('state'));}
		if(get_param('pay_method')!=''){$("#pay_method").prop('value',get_param('pay_method'));}
		if(get_param('buy_method')!=''){$("#buy_method").prop('value',get_param('buy_method'));}
		if(get_param('preferential_way')!=''){$("#preferential_way").prop('value',get_param('preferential_way'));}
		if(get_param('invoice')!=''){$("#invoice").prop('value','<?php echo @$_GET['invoice'];?>');}
		if(get_param('express')!=''){$("#express").prop('value',get_param('express'));}
		if(get_param('pay_method_remark')!=''){$("#pay_method_remark").prop('value',get_param('pay_method_remark'));}		
		
		$("#<?php echo $module['module_name'];?> .edit_a[act='edit_quantity']").each(function(index, element) {
            $(this).attr('d_id',$(this).next('input').attr('id'));
        });
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});
		$(document).on('click','#<?php echo $module['module_name'];?> .edit_a,#<?php echo $module['module_name'];?> .edit_b,#<?php echo $module['module_name'];?> .edit_c',function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			url='./index.php?monxin=mall.order_edit&id='+$(this).attr('d_id')+'&act='+$(this).attr('act');
			//window.location.href=url;
			$("#monxin_iframe").attr('src',url);
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .goods_td").click(function(event){
			if(event.target.tagName!='A'){
				id=$(this).parent().attr('id').replace(/tr_/,'');
				window.location.href='./index.php?monxin=mall.order_detail&id='+id;
				return false;	
			}
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
		
		$(document).on('click',"#<?php echo $module['module_name'];?>  .confirm_refund", function() {
			if(confirm("<?php echo self::$language['confirm_refund_notice']?>")){
				id=$(this).attr('d_id');
				$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=confirm_refund',{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					
					$("#state_"+id).html(v.info);
					if(v.state=='success'){
						$("#tr_"+id+" .operation_td").html('');
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][10];?>');
					}
				});
			}
			return false; 	
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?>  .cash_on_delivery", function() {
  			id=$(this).parent().parent().attr('id').replace(/tr_/,'');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class'),{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][1];?>');
					$("<div class=state_remark><div class=pay_method><?php echo self::$language['pay_method_str'];?><br /><?php echo self::$language['pay_method']['cash_on_delivery'];?></div></div>").insertAfter("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state");
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .pay_time_limit").css('display','none');	
                	$("#<?php echo $module['module_name'];?> #tr_"+id+" .cash_on_delivery").css('display','none');
                	
                }
            });
			return false;
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?>  .cancel',function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.order_cancel_seller&id='+$(this).attr('d_id'));
			return false;	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?>  .view_apply',function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.view_refund&id='+$(this).attr('d_id'));
			return false;	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?>  .view_refund_voucher',function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=mall.view_refund_express&id='+$(this).attr('d_id'));
			return false;	
		});
		
		
		$(document).on('click', "#<?php echo $module['module_name'];?>  .order_state_0",function() {
  			id=$(this).parent().parent().attr('id').replace(/tr_/,'');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class'),{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][0];?>') .prop('value','<?php echo self::$language['order_state'][0];?>'); 
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state_2").attr('class','cancel').html('<?php echo self::$language['cancel']?><?php echo self::$language['order_id'];?>');             	
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state_0").attr('class','cash_on_delivery').html('<?php echo self::$language['set_to']?><?php echo self::$language['cash_on_delivery'];?>'); 
					           	
                	
                }
            });
			return false;
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?>  .order_state_2", function() {
  			id=$(this).parent().parent().attr('id').replace(/tr_/,'');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class'),{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state_2").attr('class','cancel').html('<?php echo self::$language['cancel']?><?php echo self::$language['order_id'];?>');             	
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state_0").attr('class','edit_c').html('<?php echo self::$language['set_to']?><?php echo self::$language['order_state'][3]?>').attr('act','order_state_3').attr('d_id',id);
					
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][2];?>');
					$("<div class=state_remark><div class=pay_method><?php echo self::$language['pay_method_str'];?><br /></div></div>").insertAfter("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state");
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .del").css('display','none'); 
                	
                	
                }
            });
			return false;
		});
		
		$(document).on('click', "#<?php echo $module['module_name'];?>  .order_state_4",function() {
  			id=$(this).parent().parent().attr('id').replace(/tr_/,'');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class'),{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state_4").attr('class','del').html('<?php echo self::$language['del']?>');             	
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state_8").css('display','none');
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][4];?>');                	
                }
            });
			return false;
		});
		
		$(document).on('click', "#<?php echo $module['module_name'];?>  .order_state_8",function() {
  			id=$(this).parent().parent().attr('id').replace(/tr_/,'');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class'),{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state_4").css('display','none');             	
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state_8").css('display','none');					
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][8];?>');
                }
            });
			return false;
		});
		
		
		$("#<?php echo $module['module_name'];?>  .print_order").click(function(){
			ids=get_ids();
			if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
			$("#state_select").html('');
			$(this).attr('href',$(this).attr('href_pre')+"&ids="+ids);
				
		});
		
		$("#<?php echo $module['module_name'];?>   .print_tag").click(function(){
			ids=get_goods_ids();
			if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
			$("#state_select").html('');
			$(this).attr('href',$(this).attr('href_pre')+"&ids="+ids);
				
		});
		
        $(" .id").change(function(){
            if($(this).prop('checked')){
                $("#tr_"+this.id).addClass('checked');
				$("#tr_"+this.id+" .goods_id").prop('checked',true);
            }else{
                $("#tr_"+this.id).removeClass('checked');
				$("#tr_"+this.id+" .goods_id").prop('checked',false);
            }
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
    
    
    
    
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
		
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
               //alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_select").html(v.info);
                if(v.state=='success'){
                //alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).parent().css('display','none');
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
                }
                }
            });
        }	
         return false;	
    }
    
	function update_express_cost_buyer(id,v){
		$("#<?php echo $module['module_name'];?> #head_"+id+" .express_cost_buyer .value").html(v);
	}
	function update_actual_money(id,v){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .actual_money .value").html(v);
	}
	function update_sum_money(id,v){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .sum_money .value").html(v);
	}
	function update_express_cost_seller(id,v){
		$("#<?php echo $module['module_name'];?> #head_"+id+" .express_cost_seller .value").html(v);
	}
	function update_seller_remark(id,v){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .seller_remark .value").html(v);
	}
	function update_change_price_reason(id,v){
		if($("#<?php echo $module['module_name'];?> #tr_"+id+" .change_price_reason").html()){
			$("#<?php echo $module['module_name'];?> #tr_"+id+" .change_price_reason").html(v);
		}else{
			$("<div class=change_price_reason>"+v+"</div>").insertAfter("#<?php echo $module['module_name'];?> #tr_"+id+" .actual_money");
		}
	}
	
	function update_receiving_extension(id,v){$("#<?php echo $module['module_name'];?> #tr_"+id+" .day").html(v);}
	function update_express(id,v){$("#<?php echo $module['module_name'];?> #head_"+id+" .express").html(v);}
	function update_express_code(id,v){$("#<?php echo $module['module_name'];?> #head_"+id+" .express_code").html(v);}
	function update_action_button_2(id){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][2];?>');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .operation_td").html("<a href='#' class=edit_c d_id="+id+" act='order_state_2'><?php echo self::$language['edit'];?><?php echo self::$language['express_2'];?></a><br /><a href='#' class=cancel><?php echo self::$language['cancel'];?><?php echo self::$language['order_id'];?></a>");
	}
	
    function select_all(){
		//monxin_alert('select_all');
        $(" tbody .id").prop('checked',true);
        $(" tbody .goods_id").prop('checked',true);
        $(" tbody tr").addClass('checked');
        return false;	
    }
    function reverse_select(){
        $(" tbody .id").each(function(){
            $(this).prop("checked",!this.checked);
            if($(this).prop('checked')){
                $("#tr_"+this.id).addClass('checked');
				$("#tr_"+this.id+" .goods_id").prop('checked',true);
            }else{
                $("#tr_"+this.id).removeClass('checked');
				$("#tr_"+this.id+" .goods_id").prop('checked',false);
            }
                  
        });
       return false; 	
    }
    
    function get_ids(){
        ids='';
        $("#<?php echo $module['module_name'];?> .id").each(function(){
            if($(this).prop("checked")){ids+=this.id+"|";}              
        });
        return ids;
    }
    function get_goods_ids(){
        ids='';
        $("#<?php echo $module['module_name'];?> .goods_id").each(function(){
            if($(this).prop("checked")){ids+=this.id+"|";}              
        });
        return ids;
    }
	
	function update_order_goods_quantity(id,quantity,money){
		window.location.reload();		
	}
	
	function update_cancel_state(id,state){
		if(state=='success'){
			$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][5];?>');
				$("#<?php echo $module['module_name'];?> #tr_"+id+" .edit_c").css('display','none');	
				$("#<?php echo $module['module_name'];?> #tr_"+id+" .cash_on_delivery").css('display','none');	
				$("#<?php echo $module['module_name'];?> #tr_"+id+" .cancel").css('display','none');	
			if($("#<?php echo $module['module_name'];?> #tr_"+id+" .del").html()){
				
			}else{
				$("#<?php echo $module['module_name'];?> #tr_"+id+" .cancel").attr('class','del').html('<?php echo self::$language['del']?>');
			}
		}
	}
	
	function update_state_8(id){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .order_state").html('<?php echo self::$language['order_state'][8];?>');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .view_apply").css('display','none');	
	}
	
    </script>
	<style>
	#<?php echo $module['module_name'];?> .light{ background:<?php echo $_POST['monxin_user_color_set']['module']['background']?>;}
    #<?php echo $module['module_name'];?>{background:<?php echo $_POST['monxin_user_color_set']['container']['background']?>  !important;}
	#<?php echo $module['module_name'];?> input {margin:0 5px;}
    #<?php echo $module['module_name'];?> .add_comment{ padding-left:10px; font-style:oblique;}
    #<?php echo $module['module_name'];?> .m_row,.filter{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; padding:0.3rem;} 
    #<?php echo $module['module_name'];?> .filter{} 
	
	
	.mall_order{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; margin-top:1rem;margin-bottom:1rem;box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1);padding:0.5rem;}
	.mall_order .order_head{ line-height:2rem; border-bottom: 1px solid  #EEE; }
	.mall_order .order_head .shop_name{ display:inline-block; vertical-align:top; width:50%;}
	.mall_order .order_head .shop_name:after{margin-left:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f105"; }
	.mall_order .order_head .order_state{display:inline-block; vertical-align:top; width:50%; text-align:right; font-weight:bold; color:red;}
	.preferential_td{text-align:right; line-height:3rem;}
	.preferential_td div{ display:inline-block;}
	.preferential_td .big_money{ color:#F00; }
	.operation_td{ text-align:right;}
	.goods_td{}
	.goods_td .goods_info{ padding:0.3rem;  margin-bottom:0.5rem;}
	.goods_td .goods_info .goods_div{ border-bottom: 1px #CCCCCC dashed; padding-top:0.3rem; padding-bottom:0.3rem;}
	.goods_td .goods_info .icon{ display:inline-block; vertical-align:top; width:20%; text-align:center;}
	.goods_td .goods_info .icon img{ width:80%;}
	.goods_td .goods_info .other{display:inline-block; vertical-align:top; width:80%; color:#999; }
	.goods_td .goods_info .other a{ color:#999; }
	.goods_td .goods_info .other .title{ line-height:1.5rem; height:3rem; overflow:hidden; }
	.goods_td .goods_info .other .price{ 		}
	.state_remark{ display: block; text-align:right; line-height:3rem;}	
	.state_remark br{ display:none;}	
	.state_remark div{  display:inline-block;}	
	.state_remark a{ display:inline-block; margin-left:0.5rem; padding-left:0.5rem; padding-right:0.5rem; line-height:2rem; border-radius:0.3rem; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?> !important;}	
	.preferential_way{ padding-right:1rem;}
	.preferential_way br{ display:none;}
	.right_notice{ display:none;}
	.express_code{ display:none;}
	#<?php echo $module['module_name'];?> .edit_a{ display:inline-block; height:20px; width:20px; }
	#<?php echo $module['module_name'];?> .edit_b{ display:inline-block; height:20px; width:20px;}
	#<?php echo $module['module_name'];?> .edit_a:before{margin-left:3px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f044";}
	#<?php echo $module['module_name'];?> .edit_b:before{margin-left:3px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f040";}
    .refund{ margin-left:10px; opacity:0.5;}
	#<?php echo $module['module_name'];?> .o_price{text-decoration: line-through; opacity:0.4; font-size:0.9rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    
    <div class=right_notice><span class=s>&nbsp;</span><span class=m>&nbsp;wertgh 444</span><span class=e>&nbsp;</span></div>
    
    
    <div  class="portlet light" style="background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; padding-bottom:0.5rem;">
    	<div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
           
    	</div>
    
        <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['order_number']?>/<?php echo self::$language['buyer']?><?php echo self::$language['username']?>/<?php echo self::$language['receiver_info'];?>/<?php echo self::$language['express_code']?>/<?php echo self::$language['preferential_code'];?>/<?php echo self::$language['promotion'];?>/<?php echo self::$language['check_code'];?>" class="form-control" style="width:500px;" ></m_label></div></div></div>
		
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?><br /><span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
       <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>

        
    </div>
    <div class=sum_div>
		<?php echo self::$language['sum']?>：<span class=sum_value><?php echo $module['sum']['sum']?></span><?php echo self::$language['yuan']?>
    </div>
    
    </div>

    <div class=order_div>
    	 <?php echo $module['list']?>
    </div>
   
    <?php echo $module['page']?>
    </div>
</div>
