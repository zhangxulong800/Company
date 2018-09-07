<div id=<?php echo $module['module_name'];?>  monxin-module="<?php echo $module['module_name'];?>" align=left class="portlet title" >
    <script>
	function update_refund_money(){
		refund_money=0;
		$("#<?php echo $module['module_name'];?> .quantity").each(function(index, element) {
			if($(this).val()!='' && $.isNumeric($(this).val())){
				refund_money+=parseFloat($(this).val())*parseFloat($(this).parent().children(".g_price").html());
				
			}
		});
		
		if(refund_money>parseFloat($("#<?php echo $module['module_name'];?> .actual_money .value").html())){refund_money=$("#<?php echo $module['module_name'];?> .actual_money .value").html();}
		
		$("#<?php echo $module['module_name'];?> .return_money").val(refund_money);
		
		
	}
	
    $(document).ready(function(){		
		
		$("#<?php echo $module['module_name'];?> .price .quantity").change(function(){
				left=parseFloat($(this).parent().children('.g_quantity').html());

			if($(this).parent().children('.refund').children('.refund_v').html()){
				left=parseFloat($(this).parent().children('.g_quantity').html())-parseFloat($(this).parent().children('.refund').children('.refund_v').html());
			}
			if(parseFloat($(this).val())>left){
				$(this).val(left);
			}
			if(parseFloat($(this).val())<0 || !$.isNumeric($(this).val())){$(this).val('');}
			update_refund_money();
				
		});
		
		$("#<?php echo $module['module_name'];?> #myModal .submit").click(function(){
			if($("#<?php echo $module['module_name'];?> .return_money").val()==''){
				$("#<?php echo $module['module_name'];?> .return_money").focus();
				$("#<?php echo $module['module_name'];?> .return_money").next('.state').html('<span class=fail><?php echo self::$language['please_input']?></span>');
				$("#<?php echo $module['module_name'];?> #myModal .submit_state").html('<span class=fail><?php echo self::$language['please_input']?></span>');
				return 	false;
			}
			
			object=new Object();
			$("#<?php echo $module['module_name'];?> .quantity").each(function(index, element) {
                if($(this).val()!='' && $.isNumeric($(this).val())){
					object[$(this).attr('og')]=$(this).val();
					is_null=false;
				}
            });
			
			$("#<?php echo $module['module_name'];?> #myModal .submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=refund&return_money='+$("#<?php echo $module['module_name'];?> .return_money").val()+'&return_type='+$("#<?php echo $module['module_name'];?> .return_type").val()+'&reason='+$("#<?php echo $module['module_name'];?> .reason").val(),object, function(data){
               	//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> #myModal .submit_state").html(v.info);
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> #myModal .submit").css('display','none');
				}
				
            });
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .act_div .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .act_div .state").html('');
			is_null=true;
			object=new Object();
			$("#<?php echo $module['module_name'];?> .quantity").each(function(index, element) {
                if($(this).val()!='' && $.isNumeric($(this).val())){
					object[$(this).attr('og')]=$(this).val();
					is_null=false;
				}
            });
			if(is_null){
				$("#<?php echo $module['module_name'];?> .act_div .state").html('<span class=fail><?php echo self::$language['please_input'];?><?php echo self::$language['return_goods'];?><?php echo self::$language['quantity'];?></span>');
				return false;	
			}
			update_refund_money();
			$('#myModal').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/4);		 		
			return false;
			
			
			
			
			
			return false;	
		});
		
    });
    
    </script>
	<style>
	
    #<?php echo $module['module_name'];?>{ padding:10px;}
	#<?php echo $module['module_name'];?> input {margin:0 5px;}
    #<?php echo $module['module_name'];?> .add_comment{ padding-left:10px; font-style:oblique;}
    #<?php echo $module['module_name'];?>  .filter{ line-height:50px; padding-bottom:1rem;} 
	
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
	#<?php echo $module['module_name'];?> .title_tr .buyer_address{padding-left:10px; font-size:1rem; height:2.2rem; line-height:2.2rem;  background: #EFEFEF;color:#999;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .delivery_time{  padding-left:20px; color: #888;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .express{  padding-left:20px; color: #888;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .express_code{  padding-left:10px; color: #888;}
	#<?php echo $module['module_name'];?> .title_tr .buyer_address .express_code a{color: #888;}
	
	#<?php echo $module['module_name'];?> .order_tr{ white-space:nowrap;}
	#<?php echo $module['module_name'];?> .checkbox_td{ display:inline-block; vertical-align:top; width:2%; overflow:hidden; text-align:left;}
	#<?php echo $module['module_name'];?> .goods_td{ display:inline-block; vertical-align:top; width:50%;padding-left:1%; overflow:hidden; text-align:left;}
	#<?php echo $module['module_name'];?> .preferential_td{ display:inline-block; vertical-align:top; width:10%; padding-left:1%; padding-top:10px; overflow:hidden; border-left:#CCC dashed 1px;  text-align:center; white-space:normal;}
	#<?php echo $module['module_name'];?> .state_td{ display:inline-block; vertical-align:top; width:10%; padding-left:1%;padding-top:10px;border-left:#CCC dashed 1px; overflow:hidden;text-align:center;white-space:normal;}
	#<?php echo $module['module_name'];?> .operation_td{ display:inline-block; vertical-align:top; width:20%;padding-left:1%;padding-top:10px;border-left:#CCC dashed 1px;  overflow:hidden;white-space:normal;}
	#<?php echo $module['module_name'];?> .goods_info{ padding-top:10px;padding-bottom:10px; }
	#<?php echo $module['module_name'];?> .goods_info .goods{ padding-bottom:20px;  }
	#<?php echo $module['module_name'];?> .goods_info .goods .icon{ display:inline-block; vertical-align:top; width:60px; height:60px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .icon img{ width:60px; height:60px; border:none;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price{ padding-left:10px;  display:inline-block; vertical-align:top; width:350px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price .title{text-align:left; display:block; line-height:20px; height:40px; font-size:1rem; text-decoration:none; overflow:hidden; white-space: normal;text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price .price{ font-size:1rem; line-height:20px; text-align:left;}
	#<?php echo $module['module_name'];?> .goods_info .goods .title_price .price a{ padding-right:30px;}
	
	#<?php echo $module['module_name'];?> .goods_info .goods .comment{ text-align:right; line-height:25px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .buyer{}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .seller{ margin-top:10px;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .user{ display:inline-block; width:50px; text-align:left;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .user:before{margin-right:8px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da";}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content{background: #F90; display:inline-block; padding-left:10px;  padding-right:10px; border-radius:5px; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; font-size:1rem;  max-width:70%;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .edit{ width:20px; height:25px; display:inline-block;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .del{ width:20px; height:25px; display:inline-block;}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .edit:before{margin-right:8px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da";}
	#<?php echo $module['module_name'];?> .goods_info .goods .comment .content .del:before{margin-right:8px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f0da";}
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
	#<?php echo $module['module_name'];?> .edit_a:before{margin-left:3px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f044";}
	#<?php echo $module['module_name'];?> .edit_b:before{margin-left:3px; color:#F90; font: normal normal normal 1rem/1 FontAwesome; content:"\f040";}
	#<?php echo $module['module_name'];?> .filter #time_limit .submit .b_middle{background: #ccc;padding: 5px 10px;border-radius:2px;}
	#<?php echo $module['module_name'];?> .filter .search .b_middle{background: #ccc;padding: 5px 10px; border-radius:2px;}
	#<?php echo $module['module_name'];?> .order_state{ display:block; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;  cursor:pointer; margin-bottom:10px; border-radius:5px;}
	#<?php echo $module['module_name'];?> .go_pay{ display:block; background: #F60; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; padding-left:5px;}
	#<?php echo $module['module_name'];?> .big_money{ font-size:18px; font-weight:bold; text-align:center; line-height:40px;}
	#<?php echo $module['module_name'];?> .pay_time_limit{ line-height:22px; font-size:1rem; color: #666;}
	#<?php echo $module['module_name'];?> .view_logistics{ display:block;}
	#<?php echo $module['module_name'];?> .cancel_reason{display:none;}
	.right_notice{display:none;position:absolute;height:30px; line-height:30px; overflow:hidden; white-space:nowrap; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; z-index:9999;}
	.mall_order{ padding:0px !important; overflow:hidden; }
	.mall_order:hover{ opacity:0.9;}
	.sort{ z-index:99999; line-height:2rem; height:2rem; padding:0px !important; margin:0px;}
	.sort .sort_inner{ margin:auto;}
	.sort div{ padding-top:0px !important;}
	.credits_remark{ display:inline-block; vertical-align:top; float:right; padding-right:0.5rem;	}
	.buyer_address{ display:none;}
	.quantity{ width:80px; float:right; border-radius:6px; text-align:center; padding-left:0px !important;}
	.act_div{ text-align:left; padding:20px; padding-top:0px;}
	.remark{  display:none;}
	
	.line{ line-height:40px;}
	.line .m_label{ display:inline-block; vertical-align:top; width:20%; text-align:right;}
	.line .m_input{ display:inline-block; vertical-align:top; width:80%; text-align:left;}
	.return_type{ margin-left:5px;}
	.refund{ margin-left:10px; opacity:0.5;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    	<div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
            
            <div class="actions"><input type="search"  placeholder="<?php echo self::$language['please_input']?><?php echo self::$language['order_number']?>" class="form-control" style="width:200px;" ></div>
    	</div>

	<?php echo $module['list']?>
    <?php echo $module['act_div'];?>
    
    
    
        
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
                   <b><?php echo self::$language['return_goods'];?></b>
                </h4>
             </div>
             <div class="modal-body">
             	<div class="line"><span class=m_label><?php echo self::$language['refund_amount']?></span><span class=m_input><input type="text" class="return_money" /> <span class=state></span></span></div>
             	<div class="line"><span class=m_label><?php echo self::$language['refund_method']?></span><span class=m_input><select class="return_type"><option value="cash"><?php echo self::$language['pay_method']['cash']?></option><option value="balance"><?php echo self::$language['pay_method']['balance']?></option></select> <span class=state></span></span></div>
             	<div class="line"><span class=m_label><?php echo self::$language['return_goods']?><?php echo self::$language['reason']?></span><span class=m_input><input type="text" class="reason" /> <span class=state></span></span></div>
             	<div class="line"><span class=m_label></span><span class=m_input>&nbsp; <a href=# class=submit><?php echo self::$language['submit']?></a> <span class=submit_state></span></span></div>
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
</div>
