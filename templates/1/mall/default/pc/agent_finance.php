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

		var type=get_param('type');
		if(type!=''){$("#<?php echo $module['module_name'];?> #type").prop("value",type);}
		var method=get_param('method');
		if(method!=''){$("#<?php echo $module['module_name'];?> #method").prop("value",method);}
	
		
        $("#<?php echo $module['module_name'];?> .sum .add").click(function(){
			if($("#<?php echo $module['module_name'];?> .increase_div").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .increase_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> .increase_div").css('display','none');	
			}
			return false;	
		});
        
		
        $("#username").keyup(function(event){
            keycode=event.which;
            if(keycode==13){show_username();}	
        });
		var state=get_param('state');
		if(state!=''){$("#state").prop('value',state);}
		var program=get_param('program');
		if(program!=''){$("#program").prop('value',program);}
    });
    
    
    
    function monxin_table_filter(id){
            if($("#"+id).prop("value")!=-1){
                key=id.replace("_filter","");
                url=window.location.href;
                url=replace_get(url,key,$("#"+id).prop("value"));
                if(key!="search"){url=replace_get(url,"search","");}else{url=replace_get(url,"current_page","1");url=replace_get(url,"state","");url=replace_get(url,"program","");}
				url=replace_get(url,"username","");
                //monxin_alert(url);
                window.location.href=url;	
            }
    }
    
    
	function show_username(){
		if($("#usernmae").val()!='' && $("#username").val()!='<?php echo self::$language['username']?>'){
			window.location.href='./index.php?monxin=index.money_log_admin&username='+$("#username").val();
		}else{
			monxin_alert('<?php echo self::$language['please_input']?><?php echo self::$language['username']?>');
			$("#usernmae").focus();return false;
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
    #<?php echo $module['module_name'];?>_table .after_money{width:90px;display:inline-block;overflow:hidden; display:none;}
    #<?php echo $module['module_name'];?>_table .reason{width:250px;display:inline-block;overflow:hidden; text-align:left;}
    #<?php echo $module['module_name'];?>_table .program{width:100px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .state{width:50px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .operation_state{display:inline-block;}
	#<?php echo $module['module_name'];?> .sum{ text-align:left; line-height:50px; font-size:16px; border-bottom:#CCC 2px solid; margin-bottom:10px; }
	#<?php echo $module['module_name'];?> .sum .detail{ display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?> .sum span{  font-weight:bold;font-size:26px;}
	#<?php echo $module['module_name'];?> .sum .profit{display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?> .sum .add span{  font-size:16px; font-weight:normal;}
	
	#<?php echo $module['module_name'];?> .increase_div{ display:none;  text-align:left; line-height:60px; border:#CCC solid 1px; border-radius:10px; padding:10px; margin-bottom:20px;}
	#<?php echo $module['module_name'];?> .increase_div .add_money{ width:100px;}
	#<?php echo $module['module_name'];?> .increase_div .add_reason{ width:400px;}
	#<?php echo $module['module_name'];?> .after_operation_switch{ cursor:pointer;}
	#<?php echo $module['module_name'];?> .add_money{ }
	#<?php echo $module['module_name'];?> .decrease_money{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    	<div class=sum>
        	<div class=detail><?php echo self::$language['finance_method'][1]?> <span class=income><?php echo $module['income']?></span> <?php echo self::$language['yuan']?> </div>
        </div>
   	
    <div class="filter">
            <?php echo self::$language['content_filter']?>:
            <?php echo $module['filter'];?>
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['reason']?>/<?php echo self::$language['amount']?>/<?php echo self::$language['shop_name']?>"  value="<?php echo @$_GET['search'];?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
        <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
	</div>
    
        

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['method']?></td>
                <td ><?php echo self::$language['type']?></td>
                <td ><span class=before_operation_switch><?php echo self::$language['before_operation']?></span></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="money|desc" class="sorting"  asc="money|asc"><?php echo self::$language['amount']?></a></td>
                <td ><span class=before_operation_switch><?php echo self::$language['after_operation']?></span></td>
                <td ><?php echo self::$language['reason']?></td>
                <td ><?php echo self::$language['shop_name']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
