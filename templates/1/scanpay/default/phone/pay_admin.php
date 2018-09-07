<script src="./plugin/datePicker/index.php"></script>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		var a_id=get_param('a_id');
		if(a_id!=''){$("#a_id").prop('value',a_id);}
		var state=get_param('state');
		if(state!=''){$("#state").prop('value',state);}
		var settlement=get_param('settlement');
		if(settlement!=''){$("#settlement").prop('value',settlement);}
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
                //monxin_alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                    }	
                }
                }
            });
        }	
         return false;	
    }

    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{}
    
    #<?php echo $module['module_name'];?>_table .username{width:100px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .operator{width:100px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:80px;display:inline-block;}
    #<?php echo $module['module_name'];?>_table .time a{  }
    #<?php echo $module['module_name'];?>_table .money{width:60px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .before_money{width:90px;display:inline-block;overflow:hidden; display:none;}
    #<?php echo $module['module_name'];?>_table .after_money{width:90px;display:inline-block;overflow:hidden;display:none;}
    #<?php echo $module['module_name'];?>_table .reason{width:250px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .program{width:100px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .state{width:50px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .operation_state{display:inline-block;}
	#username{ height:25px; width:200px; line-height:25px;}
	.top_div{line-height:3rem;}
	#<?php echo $module['module_name'];?> .before_operation_switch{ cursor:pointer;}
	#<?php echo $module['module_name'];?> .after_operation_switch{ cursor:pointer;}
	#<?php echo $module['module_name'];?> .add_money{ }
	#<?php echo $module['module_name'];?> .decrease_money{ }
	#<?php echo $module['module_name'];?> .sum_div{ text-align:right; padding-right:1rem;}
	#<?php echo $module['module_name'];?> .sum_div b{ }
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?><?php echo self::$language['log']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
    
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['operator']?>/<?php echo self::$language['pay_barcode']?>/<?php echo self::$language['out_id']?>" class="form-control" ></m_label></div></div></div>

    <div class="filter"><?php echo self::$language['content_filter']?>:
    <?php echo $module['filter']?>
        <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
        <div class=sum_div><?php echo self::$language['cumulative']?><?php echo self::$language['money']?>:<b><?php echo $module['sum_money']?></b></div>
    </div>

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="money|desc" class="sorting"  asc="money|asc"><?php echo self::$language['money']?></a></td>
                <td ><?php echo self::$language['pay_money']?><?php echo self::$language['state']?></td>
                <td ><?php echo self::$language['account_name']?>/<?php echo self::$language['pay_username']?>/<?php echo self::$language['pay_reason']?></td>
                <td ><?php echo self::$language['pay_barcode']?></td>
                <td ><?php echo self::$language['out_id']?></td>
                <td ><?php echo self::$language['success_fun']?></td>
                <td ><?php echo self::$language['settlement']?></td>
                <td ><?php echo self::$language['operator']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
