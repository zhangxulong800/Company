<script src="./plugin/datePicker/index.php"></script>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .limit a[href='./index.php?monxin=mall.reconciliation_log&start_time=<?php echo $_GET['start_time']?>&end_time=<?php echo $_GET['end_time']?>']").attr('class','current');
		$("#<?php echo $module['module_name'];?> .money_div .title").html($("#<?php echo $module['module_name'];?> .limit .current").html());
		if($("#<?php echo $module['module_name'];?> .limit .current").html()==null){
			$("#<?php echo $module['module_name'];?> .money_div .title").html('<?php echo $_GET['start_time']?>  <?php echo self::$language['to']?> <?php echo $_GET['end_time']?>');
		}
		
		$("#<?php echo $module['module_name'];?> .set_1").click(function(){
			id=$(this).attr('d_id');
			if(confirm("<?php echo self::$language['opration_confirm']?>")){
				$("#<?php echo $module['module_name'];?> #tr_"+id+" .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=set_1',{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#<?php echo $module['module_name'];?> #tr_"+id+" .state").html(v.info);
					if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .data_state").html('<?php echo self::$language['reconciliation_state'][1]?>');
						$("#<?php echo $module['module_name'];?> #tr_"+id+" .set_1").css('display','none');
					}
				});
			}
			return false;
		});
		
    });
    </script>
    
   <style>
    #<?php echo $module['module_name'];?> { }
    #<?php echo $module['module_name'];?>_html{ padding-top:20px;padding-bottom:20px;}
	#<?php echo $module['module_name'];?>_html .line{ display:inline-block; width:30%; line-height:50px;}
	#<?php echo $module['module_name'];?>_html .line .input input{}
	#<?php echo $module['module_name'];?>_html .sum{ text-align:right; line-height:3rem;}
	#<?php echo $module['module_name'];?>  .limit{display:inline-block; vertical-align:top; }
    #<?php echo $module['module_name'];?>  .limit a{ display:inline-block; margin-left:10px;margin-right:10px; padding-left:5px; padding-right:5px; }
    #<?php echo $module['module_name'];?>  .limit .current{ color:#FFF; background-color:#F30; }
	#<?php echo $module['module_name'];?> thead td{ font-size:0.9rem; padding:2px; white-space:nowrap;}
	#<?php echo $module['module_name'];?>  td{ font-size:0.9rem; padding:2px; white-space:nowrap; line-height:2.5rem;}
	#<?php echo $module['module_name'];?> .cash{ color:red; line-height:1.6rem;}
	#<?php echo $module['module_name'];?> .pay_2{ color:red;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=1>
        <div class="filter">
                <?php echo self::$language['content_filter']?>:
                
            <span id=time_limit class=limit><?php echo $module['days'];?>&nbsp; &nbsp;  <?php echo self::$language['custom_date']?>: <input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['inquiry']?></a></span>
        </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%;" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['cashier'];?></td>
                <td><?php echo self::$language['received_goods_money'];?></td>
                <td><?php echo self::$language['pay_method']['pos'];?></td>
                <td><?php echo self::$language['p_cash'];?></td>
                <td><?php echo self::$language['pay_method']['balance'];?></td>
                <td><?php echo self::$language['pay_method']['shop_balance'];?></td>
                <td><?php echo self::$language['pay_method']['weixin'];?></td>
                <td><?php echo self::$language['pay_method']['alipay'];?></td>
                <td><?php echo self::$language['pay_method']['meituan'];?></td>
                <td><?php echo self::$language['pay_method']['nuomi'];?></td>
                <td><?php echo self::$language['pay_method']['other'];?></td>
                <td><?php echo self::$language['credit'];?></td>
                <td><?php echo self::$language['sum'];?></td>
                <td><?php echo self::$language['state'];?></td>
                <td><?php echo self::$language['operation'];?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo @$module['list']?>
        </tbody>
    </table></div>
    
    </div>
</div>

