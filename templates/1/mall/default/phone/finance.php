<script src="./plugin/datePicker/index.php"></script>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .before_operation_switch").click(function(){
			if($("#<?php echo $module['module_name'];?> .before_money").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .before_money").css('display','block');	
			}else{
				$("#<?php echo $module['module_name'];?> .before_money").css('display','none');	
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
        
		$("#<?php echo $module['module_name'];?> .increase_div .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .increase_div .state").html('');
			if($("#<?php echo $module['module_name'];?> .increase_div .add_method").val()==''){
				$("#<?php echo $module['module_name'];?> .increase_div .state").html('<span class=fail><?php echo self::$language['please_select']?><?php echo self::$language['method']?></span>');
				$("#<?php echo $module['module_name'];?> .increase_div .add_method").focus();
				return false;
			}
			if($("#<?php echo $module['module_name'];?> .increase_div .add_type").val()==''){
				$("#<?php echo $module['module_name'];?> .increase_div .state").html('<span class=fail><?php echo self::$language['please_select']?><?php echo self::$language['category']?></span>');
				$("#<?php echo $module['module_name'];?> .increase_div .add_type").focus();
				return false;
			}
			if($("#<?php echo $module['module_name'];?> .increase_div .add_money").val()==''){
				$("#<?php echo $module['module_name'];?> .increase_div .state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['money']?></span>');
				$("#<?php echo $module['module_name'];?> .increase_div .add_money").focus();
				return false;
			}
			if($("#<?php echo $module['module_name'];?> .increase_div .add_reason").val()==''){
				$("#<?php echo $module['module_name'];?> .increase_div .state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['reason']?></span>');
				$("#<?php echo $module['module_name'];?> .increase_div .add_reason").focus();
				return false;
			}
			obj=new Object();
			obj['method']=$("#<?php echo $module['module_name'];?> .increase_div .add_method").val();
			obj['type']=$("#<?php echo $module['module_name'];?> .increase_div .add_type").val();
			obj['money']=$("#<?php echo $module['module_name'];?> .increase_div .add_money").val();
			obj['reason']=$("#<?php echo $module['module_name'];?> .increase_div .add_reason").val();
			
			
			$("#<?php echo $module['module_name'];?> .increase_div .state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> .increase_div .state").html(v.info);
				if(v.state=='success'){
					$("#<?php echo $module['module_name'];?> .increase_div .state").html($("#<?php echo $module['module_name'];?> .increase_div .state").html()+' <a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');
				}
			});
			
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
    #<?php echo $module['module_name'];?>_table .after_money{width:90px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .reason{width:250px;display:inline-block;overflow:hidden; text-align:left;}
    #<?php echo $module['module_name'];?>_table .program{width:100px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .state{width:50px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .operation_state{display:inline-block;}
	#<?php echo $module['module_name'];?> .sum{ text-align:left; line-height:2rem; font-size:16px; border-bottom:#CCC 2px solid; padding-bottom:1rem; margin-bottom:1rem; }
	#<?php echo $module['module_name'];?> .sum .detail{ display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?> .sum span{  font-weight:bold;font-size:26px;}
	#<?php echo $module['module_name'];?> .sum .profit{display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?> .sum .add{ float:right;}
	#<?php echo $module['module_name'];?> .sum .add span{  font-size:16px; font-weight:normal;}
	
	#<?php echo $module['module_name'];?> .increase_div{ display:none;  text-align:left; line-height:3rem; border:#CCC solid 1px; border-radius:10px; padding:10px; margin-bottom:20px;}
	#<?php echo $module['module_name'];?> .increase_div .add_money{ }
	#<?php echo $module['module_name'];?> .increase_div .add_reason{ }
	#<?php echo $module['module_name'];?> .increase_div .submit{ margin-left:3rem;}
	#<?php echo $module['module_name'];?> .before_operation_switch{ cursor:pointer;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search" placeholder="<?php echo self::$language['operator']?>/<?php echo self::$language['reason']?>/<?php echo self::$language['amount']?>/<?php echo self::$language['shop_name']?>"   class="form-control" ></m_label></div></div></div>
    
 
    	<div class=sum>
        	<div class=detail><?php echo self::$language['finance_method'][1]?> <span class=income><?php echo $module['income']?></span> <?php echo self::$language['yuan']?> - <?php echo self::$language['finance_method'][0]?> <span class=expenditure><?php echo $module['expenditure']?></span> <?php echo self::$language['yuan']?> </div> = <div class=profit><?php echo self::$language['profit'];?> <span class=v><?php echo $module['profit']?></span> <?php echo self::$language['yuan']?></div> &nbsp; &nbsp; <a href=# class=add><?php echo self::$language['increase']?><?php echo self::$language['record'];?></a>
        </div>
        <div class=increase_div>
        	<?php echo self::$language['method'];?>：<?php echo $module['finance_method'];?> <br />
			<?php echo self::$language['category'];?>：<?php echo $module['finance_type'];?>  <br />
			<?php echo self::$language['money'];?>：<input type="text"  class=add_money /> <br />
			<?php echo self::$language['reason'];?>：<input type="text" class=add_reason  /> <br />
            <a href="#" class="submit"><?php echo self::$language['confirm']?><?php echo self::$language['submit']?></a> <span class="state"></span>
        </div>
    	
    <div class="filter">
            <?php echo self::$language['content_filter']?>:
            <?php echo $module['filter'];?>
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
                <td ><?php echo self::$language['after_operation']?></td>
                <td ><?php echo self::$language['reason']?></td>
                <td ><?php echo self::$language['shop_name']?></td>
                <td ><?php echo self::$language['operator']?></td>
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
