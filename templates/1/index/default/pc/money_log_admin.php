<script src="./plugin/datePicker/index.php"></script>

<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    

    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> td .money").each(function(index, element) {
            if($(this).html()>0){
				$(this).addClass('add_money');
			}else{
				$(this).addClass('decrease_money');
			}
        });
		$("#<?php echo $module['module_name'];?> .before_operation_switch").click(function(){
			if($("#<?php echo $module['module_name'];?> .before_money").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .before_money").css('display','block');	
			}else{
				$("#<?php echo $module['module_name'];?> .before_money").css('display','none');	
			}
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .after_operation_switch").click(function(){
			if($("#<?php echo $module['module_name'];?> .after_money").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .after_money").css('display','block');	
			}else{
				$("#<?php echo $module['module_name'];?> .after_money").css('display','none');	
			}
			return false;
		});
		
		
		//set_current_order('time|desc');
        $("#username").keyup(function(event){
            keycode=event.which;
            if(keycode==13){show_username();}	
        });
		var program=get_param('program');
		if(program!=''){$("#program").prop('value',program);}
    });
    
    
	
	 
	function show_username(){
		if($("#usernmae").val()!='' && $("#username").val()!='<?php echo self::$language['username']?>'){
			window.location.href='./index.php?monxin=index.money_log_admin&username='+$("#username").val();
		}else{
			monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['username']?>');
			$("#usernmae").focus();return false;
		}
			
	} 
    function  monxin_table_filter(id){
            if($("#"+id).prop("value")!=-1){
                key=id.replace("_filter","");
                url=window.location.href;
                url=replace_get(url,key,$("#"+id).prop("value"));
                if(key!="search"){url=replace_get(url,"search","");}else{url=replace_get(url,"current_page","1");url=replace_get(url,"program","");}
				url=replace_get(url,"username","");
                //monxin_alert(url);
                window.location.href=url;	
            }
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
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['username']?>/<?php echo self::$language['reason']?>/<?php echo self::$language['amount']?>" class="form-control" ></m_label></div></div></div>

    <div class="filter"><?php echo self::$language['content_filter']?>:
    <?php echo $module['filter']?>
        <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
    </div>
        <div class=top_div><input type="text" name="username" id="username" value="<?php echo @$_GET['username'];?>"  placeholder="<?php echo self::$language['username']?>" /> <a href=# onclick="return show_username();" class="inquiry"><?php echo self::$language['inquiry']?></a> &nbsp; &nbsp; <?php echo $module['current_program'];?> <?php echo self::$language['sum']?>: +<?php echo $module['add']?> &nbsp; &nbsp; <?php echo $module['deduction']?></div>

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><?php echo self::$language['username']?></td>
                <td ><span class=before_operation_switch><?php echo self::$language['before_operation']?></span></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="money|desc" class="sorting"  asc="money|asc"><?php echo self::$language['amount']?></a></td>
                <td ><span class=after_operation_switch><?php echo self::$language['after_operation']?></span></td>
                <td ><?php echo self::$language['reason']?></td>
                <td ><?php echo self::$language['operator']?></td>
                <td ><?php echo self::$language['program']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
