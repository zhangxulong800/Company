<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script src="./plugin/datePicker/index.php"></script>
    
    
    <script>
    $(document).ready(function(){
		
    });
    
    function add(){
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        numberNew=$("#<?php echo $module['module_name'];?> #number_new");	
        amountNew=$("#<?php echo $module['module_name'];?> #amount_new");	
        min_moneyNew=$("#<?php echo $module['module_name'];?> #min_money_new");	
        start_timeNew=$("#<?php echo $module['module_name'];?> #start_time_new");
        end_timeNew=$("#<?php echo $module['module_name'];?> #end_time_new");
        sum_quantityNew=$("#<?php echo $module['module_name'];?> #sum_quantity_new");
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(numberNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['vouchers_number']?>');numberNew.focus();return false;}	
        if(amountNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['vouchers_amount']?>');amountNew.focus();return false;}	
        if(min_moneyNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['vouchers_min_money']?>');min_moneyNew.focus();return false;}	
        if(start_timeNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['vouchers_start_time']?>');start_timeNew.focus();return false;}	
        if(end_timeNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['vouchers_end_time']?>');end_timeNew.focus();return false;}	
        if(sum_quantityNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sum_quantity']?>');sum_quantityNew.focus();return false;}	
       if(parseFloat(min_moneyNew.val())<parseFloat(amountNew.val())){
			$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['vouchers_min_money']?><?php echo self::$language['less_than']?><?php echo self::$language['vouchers_amount']?>');return false;
		}
	    $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),number:numberNew.prop('value'),amount:amountNew.prop('value'),min_money:min_moneyNew.prop('value'),start_time:start_timeNew.prop('value'),end_time:end_timeNew.prop('value'),sum_quantity:sum_quantityNew.prop('value'),join_goods:$("#<?php echo $module['module_name'];?>  #join_goods_new").val()}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
			if(v.state=='success'){$("#<?php echo $module['module_name'];?> #state_new").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');}
        });
        	
        return false;
    }
    
    
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
       return false; 
    }
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .name{width:200px;}
    #<?php echo $module['module_name'];?>_html .number{width:100px;}
    #<?php echo $module['module_name'];?>_html .amount{width:100px;}
    #<?php echo $module['module_name'];?>_html .min_money{width:100px;}
    #<?php echo $module['module_name'];?>_html .start_time{width:90px;}
    #<?php echo $module['module_name'];?>_html .end_time{width:90px;}
    #<?php echo $module['module_name'];?>_html .sum_quantity{width:50px;}
    #<?php echo $module['module_name'];?>_html .use_quantity{width:50px;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['vouchers_number']?></td>
                <td><?php echo self::$language['vouchers_amount']?></td>
                <td><?php echo self::$language['vouchers_min_money']?></td>
                <td><?php echo self::$language['period_of_use']?></td>
                <td><?php echo self::$language['range_of_use']?></td>
                <td><?php echo self::$language['sum_quantity']?></td>
                <td><?php echo self::$language['use_quantity']?></td>
                <td width="15%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <tr id="<?php echo $module['module_name'];?>_new">
              <td ><input type="text" name="name_new" id="name_new" class='name' /></td>
              <td ><input type="text" name="number_new" id="number_new" class='number' /></td>
              <td ><input type="text" name="amount_new" id="amount_new" class='amount' /></td>
              <td><input type="text" name="min_money_new" id="min_money_new" class='min_money' /></td>
              <td><input type="text" name="start_time_new" id="start_time_new" class='start_time' onclick=show_datePicker(this.id,'date') onblur= hide_datePicker() />-<input type="text" name="end_time_new" id="end_time_new" class='end_time' onclick=show_datePicker(this.id,'date') onblur= hide_datePicker() /></td>
              <td><select id="join_goods_new" ><option value="1"><?php echo self::$language['join_goods_admin'][1]?></option><option value="0"><?php echo self::$language['join_goods_admin'][0]?></option><option value="2"><?php echo self::$language['join_goods_admin'][2]?></option></select></td>
              <td ><input type="text" name="sum_quantity_new" id="sum_quantity_new" class='sum_quantity' /></td>
              <td >&nbsp;</td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>

</div>
