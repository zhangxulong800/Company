<script src="./plugin/datePicker/index.php"></script>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#monxin_table_filter select").change(function(){
			monxin_table_filter($(this).attr('id'));	
		});
		$("#<?php echo $module['module_name'];?> .reason").click(function(){alert($(this).attr('title'));return false;});
		$(".del").click(function(){
				id=$(this).attr('href');
				$("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
					            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

					$("#state_"+id).html(v.info);
					if(v.state=='success'){
					$("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
					}
				});
			return false;	
		});
		
		var state=get_param('state');
		if(state!=''){$("#state").prop('value',state);}
    });
    
    
    function monxin_table_filter(id){
            if($("#"+id).prop("value")!=-1){
                key=id.replace("_filter","");
                url=window.location.href;
                url=replace_get(url,key,$("#"+id).prop("value"));
                if(key!="search"){url=replace_get(url,"search","");}else{url=replace_get(url,"current_page","1");url=replace_get(url,"state","");}
                //monxin_alert(url);
                window.location.href=url;	
            }
    }
    
	
	  
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{}
        
    #<?php echo $module['module_name'];?>_table .reason{ }
    #<?php echo $module['module_name'];?>_table .operator{width:100px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:80px;display:inline-block;}
    #<?php echo $module['module_name'];?>_table .money{width:80px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .billing_info{width:300px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .state{width:100px;display:inline-block;}
    #<?php echo $module['module_name'];?>_table .operation{width:150px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .operation_state{display:inline-block;}
    #<?php echo $module['module_name'];?>_table .refuse{display:inline-block;}
    #<?php echo $module['module_name'];?>_table .paid{display:inline-block;}
	#<?php echo $module['module_name'];?> .open_icon{ width:30px; }
	.money i{ font-size:0.8rem;	font-style:normal; opacity:0.5;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"></div></div>
    
    <table class=top_div width="100%">
    	<tr>
        	<td align="left">
            <span id=monxin_table_filter><?php echo self::$language['content_filter']?>:
    <?php echo $module['filter']?></span>
        <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
            </td>
            <td align="right">
            <?php echo self::$language['sum']?><?php echo self::$language['success']?><?php echo self::$language['withdraw']?>:<?php echo $module['sum_all']?>
            </td>
        </tr>
    </table>
    
       

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="money|desc" class="sorting"  asc="money|asc"><?php echo self::$language['withdraw']?><?php echo self::$language['amount']?></a></td>
                <td ><?php echo self::$language['withdraw_rate']?></td>
                <td ><?php echo self::$language['withdraw_method']?></td>
                <td ><?php echo self::$language['billing_info']?></td>
                <td ><?php echo self::$language['state']?></td>
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
