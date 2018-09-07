<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .modify").click(function(){
			if($(this).prev('input').val()=='' || $(this).prev('input').val()=='<?php echo self::$language['none']?>'){alert('<?php echo self::$language['please_input']?>');return false;}
			id=$(this).attr('d_id');	
			$(this).next('.state').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update',{expiration:$(this).prev('input').val(),payment:$("#tr_"+id+" .payment").val(),id:id}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> a[d_id="+id+"]").next('.state').html(v.info);
			});
			
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .payment").blur(function(){
			if($(this).val()!='' &&　$.isNumeric($(this).val())){
				id=$(this).attr('d_id');
				$.post('<?php echo $module['action_url'];?>&act=update_payment',{id:id,v:$(this).val()}, function(data){
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .payment").css('background','green');  
					}else{
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .payment").css('background','white'); 
					}
				});
			}	
		});
		
		
    });
    
    function add(){
        if($("#<?php echo $module['module_name'];?> #option_id").html()!=null){
			if($("#<?php echo $module['module_name'];?> #option_id").val()==''){
				$("#<?php echo $module['module_name'];?> #state_new").html('<span class=fail><?php echo self::$language['please_select']?><?php echo self::$language['option']?></span>');
				$("#<?php echo $module['module_name'];?> #option_id").focus();
				
				return false;
			}
		}	
		if($("#<?php echo $module['module_name'];?> #quantity").val()==''){
			$("#<?php echo $module['module_name'];?> #state_new").html('<span class=fail><?php echo self::$language['please_select']?><?php echo self::$language['quantity']?></span>');
			$("#<?php echo $module['module_name'];?> #quantity").focus();
			
			return false;
		}
		if($("#<?php echo $module['module_name'];?> #price").val()==''){
			$("#<?php echo $module['module_name'];?> #state_new").html('<span class=fail><?php echo self::$language['please_select']?><?php echo self::$language['price']?></span>');
			$("#<?php echo $module['module_name'];?> #price").focus();
			
			return false;
		}

        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=add',{option_id:$("#<?php echo $module['module_name'];?> #option_id").val(),quantity:$("#<?php echo $module['module_name'];?> #quantity").val(),price:$("#<?php echo $module['module_name'];?> #price").val(),}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
			if(v.state=='success'){
				 $(v.html).insertAfter("#<?php echo $module['module_name'];?>_new");
				 $("#<?php echo $module['module_name'];?>_new select,#<?php echo $module['module_name'];?>_new input").val('');
				 parent.update_inventory('<?php echo $_GET['id']?>',v.sum);
			}
        });
        	
        return false;
    }
	
    </script>
	<style>
	.page-content{ }
	.page-footer{ display:none;}
	.fixed_right_div{ display:none; }
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .goods_title{ line-height:30px; padding-left:10px; font-weight:bold;}
    #<?php echo $module['module_name'];?> [monxin-table] .filter{ line-height:50px;} 
	#<?php echo $module['module_name'];?> [monxin-table] tbody tr{ line-height:30px; height:30px;}
	#<?php echo $module['module_name'];?> [monxin-table] .even td{ line-height:30px; height:30px;}
	#<?php echo $module['module_name'];?> [monxin-table] .odd td{ line-height:30px; height:30px;}
    #<?php echo $module['module_name'];?> [monxin-table] input{ width:80px;}
    #<?php echo $module['module_name'];?> [monxin-table] .expiration{ width:140px;}
    #<?php echo $module['module_name'];?> [monxin-table] .payment{ width:50px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=goods_title><?php echo self::$language['into_log'];?> : <?php echo $module['data']['title']?></div>
    <div class="filter"><?php echo self::$language['content_filter']?>:
         <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['into_time']?></td>
                <?php echo $module['head_td'];?>
                <td><?php echo self::$language['goods_supplier']?></td>
                <td><?php echo self::$language['into_quantity']?></td>
                <td><?php echo self::$language['money_settled']?></td>
                <td><?php echo self::$language['cost_price']?></td>
                <td><?php echo self::$language['left']?></td>
                <td><?php echo self::$language['sell_out_time']?></td>
                <td><?php echo self::$language['expiration']?></td>
            </tr>
        </thead>
        <tbody>
            <tr style="display:none;" id="<?php echo $module['module_name'];?>_new">
              <td >&nbsp;</td>
              <?php echo $module['add_option'];?>
              <td><input type="text" name="quantity" id="quantity" /></td>
              <td><input type="text" name="price" id="price" /></td>
              <td id="new_td_last" colspan="2"  style="text-align:left; height:60px;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['submit_into']?></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
