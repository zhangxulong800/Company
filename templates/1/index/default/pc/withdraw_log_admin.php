<script src="./plugin/datePicker/index.php"></script>
<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){	
		$("#<?php echo $module['module_name'];?> .open_refuse").click(function(){
			$("#state_select").html('');
			ids=get_ids();
			if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
			idss='';
			ids=ids.split("|");	
			for(id in ids){
				if(ids[id]!='' && $("#tr_"+ids[id]+" .refuse").html()=='<?php echo self::$language['refuse']?>' ){
					$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');
					idss+=ids[id]+'|';
				}
			}
			if(idss==''){$("#state_select").html("<?php echo self::$language['no_actionable_content']?>");return false;}
			
			$('#myModal').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/3);		 		
			return false;
		});
		
		$("#<?php echo $module['module_name'];?>_html .set_3").click(function(){
			$("#state_select").html('');
			ids=get_ids();
			if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
			
			idss='';
			ids=ids.split("|");	
			for(id in ids){
				if(ids[id]!='' && $("#tr_"+ids[id]+" .paid").html()=='<?php echo self::$language['deduction_balance_0']?>' ){
					$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');
					idss+=ids[id]+'|';
				}				
			}
			if(idss==''){$("#state_select").html("<?php echo self::$language['no_actionable_content']?>");return false;}
			ids=idss.split("|");	
			
			//return false;
			
			$("#state_select").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=set_3',{ids:idss}, function(data){
				//monxin_alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#state_select").html(v.info);
				if(v.state=='success'){
				success=v.ids.split("|");
				for(id in ids){
				   //monxin_alert(ids[id]);
					if(in_array(ids[id],success)){
						$("#tr_"+ids[id]+" .operation_td a").css('display','none');
						$("#tr_"+ids[id]+" .state").html('<?php echo self::$language['withdraw_state'][3]?>');
						$("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
					}else{
						$("#state_"+ids[id]).html("<span class=fail><?php echo self::$language['fail'];?></span>");	
					}	
				}
				}
			});
			return false;	
			
		});
		
		
		$("#<?php echo $module['module_name'];?>_html .set_2").click(function(){
			$("#state_select").html('');
			ids=get_ids();
			if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
			if($("#<?php echo $module['module_name'];?> .batch_reason").val()==''){$("#<?php echo $module['module_name'];?> .batch_reason").focus();return false;}
			
			$("#myModal").modal("hide");
			idss='';
			ids=ids.split("|");	
			for(id in ids){
				if(ids[id]!='' && $("#tr_"+ids[id]+" .paid").html()=='<?php echo self::$language['deduction_balance_0']?>' ){
					$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');
					idss+=ids[id]+'|';
				}				
			}
			if(idss==''){$("#state_select").html("<?php echo self::$language['no_actionable_content']?>");return false;}
			ids=idss.split("|");	
			//return false;
			
			$("#state_select").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=set_2',{ids:idss,reason:$("#<?php echo $module['module_name'];?>_html .batch_reason").val()}, function(data){
				//monxin_alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#state_select").html(v.info);
				if(v.state=='success'){
				success=v.ids.split("|");
				for(id in ids){
				   //monxin_alert(ids[id]);
					if(in_array(ids[id],success)){
						$("#tr_"+ids[id]+" .operation_td a").css('display','none');
						$("#tr_"+ids[id]+" .state").html('<?php echo self::$language['withdraw_state'][2]?>');
						$("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
					}else{
						$("#state_"+ids[id]).html("<span class=fail><?php echo self::$language['fail'];?></span>");	
					}	
				}
				}
			});
			return false;	
			
		});
		
		
		
		$("#monxin_table_filter select").change(function(){
			monxin_table_filter($(this).attr('id'));	
		});
		
		$("#<?php echo $module['module_name'];?> .reason").click(function(){alert($(this).attr('title'));return false;});
		
		$("#<?php echo $module['module_name'];?> .sum_div a").click(function(){
			$(this).attr('href','<?php echo $module['action_url'];?>&act=export&search='+get_param('search')+'&start_time='+get_param('start_time')+'&end_time='+get_param('end_time')+'&state='+$(this).attr('state'));
			//alert($(this).attr('href'));
				
		});
		
		$(".paid").click(function(){
			if(confirm("<?php echo self::$language['opration_confirm']?>")){
				id=$(this).attr('href');
				$("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=paid',{id:id}, function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#"+$("#state_"+id).parent().parent().attr('id')+" .state").html('<?php echo self::$language['withdraw_state'][3]?>');
					$("#state_"+id).parent().html(v.info+"<a class=refresh href='javascript:window.location.reload();'><?php echo self::$language['refresh'];?></a>");
					
				});
			}
			return false;	
		});
		$(".refuse").click(function(){
				id=$(this).attr('href');
				if($("#reason_"+id).val()=='' || $("#reason_"+id).val()=='<?php echo self::$language['reason']?>:'){$("#reason_"+id).css('display','inline-block');$("#reason_"+id).focus();return false;}
				var reason=$("#reason_"+id).val();				
				$("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.get('<?php echo $module['action_url'];?>&act=refuse',{id:id,reason:reason}, function(data){
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#state_"+id).html(v.info+"<a class=refresh href='javascript:window.location.reload();'><?php echo self::$language['refresh'];?></a>");
				});
			return false;	
		});
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
    
    
    function del_select(){
		$("#state_select").html('');
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			idss='';
			ids=ids.split("|");	
			for(id in ids){
				if(ids[id]!='' && ($("#tr_"+ids[id]+" .state").html()=='<?php echo self::$language['withdraw_state'][2]?>' || $("#tr_"+ids[id]+" .state .reason").html()=='<?php echo self::$language['reason']?>' )){
					$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');
					idss+=ids[id]+'|';
				}							
			}
			if(idss==''){$("#state_select").html("<?php echo self::$language['no_actionable_content']?>");return false;}
			ids=idss.split("|");
			$("#state_select").html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#state_select").html(v.info);
                if(v.state=='success'){
                //monxin_alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                   //monxin_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                        $("#state_"+ids[id]).html("<span class=fail><?php echo self::$language['fail'];?></span>");	
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
        
    #<?php echo $module['module_name'];?>_table .reason{ }
    #<?php echo $module['module_name'];?>_table .operator{}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px;display:inline-block;}
    #<?php echo $module['module_name'];?>_table .money{width:80px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .state{display:inline-block;}
    #<?php echo $module['module_name'];?>_table .operation{width:130px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .operation_state{display:inline-block;}
    #<?php echo $module['module_name'];?>_table .refuse{display:inline-block;}
	#<?php echo $module['module_name'];?>_table .billing_info{  display:inline-block; width:300px; white-space:normal;}
    #<?php echo $module['module_name'];?>_table .paid{display:inline-block;}
	#<?php echo $module['module_name'];?>_table tbody{ white-space:nowrap; font-size:0.83rem;}
	#<?php echo $module['module_name'];?> #time_limit{ float:none; padding-left:30px;}
	#<?php echo $module['module_name'];?> .sum_div{line-height:25px; text-align:right;}
	.money i{ font-size:0.8rem;	font-style:normal; opacity:0.5;}
	.reason_input{ width:60px;}
	#<?php echo $module['module_name'];?>_html .open_icon{width:20px;}
	[monxin-table] .operation_td a{ margin:0px; padding:3px 3px;}

    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="set_3" ><?php echo self::$language['deduction_balance_0']?></a></li> 
                    <li><a href="#" class="open_refuse" ><?php echo self::$language['refuse']?></a></li> 
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"   placeholder="<?php echo self::$language['username']?>" value="<?php echo @$_GET['search'];?>"  class="form-control" ></m_label></div></div></div>
    
    <table class=top_div width="100%">
    	<tr>
        	<td align="left">
            <span id=monxin_table_filter><?php echo self::$language['content_filter']?>:
    <?php echo $module['filter']?></span>
        <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
            </td>
            <td class=sum_div>
				<div><?php echo self::$language['withdraw_state']['1']?>:<?php echo $module['state_1']?> <a href=# target="_blank"  state=1><?php echo self::$language['export']?></a></div>
				<div><?php echo self::$language['withdraw_state']['2']?>:<?php echo $module['state_2']?> <a href=# target="_blank"  state=2><?php echo self::$language['export']?></a></div>
				<div><?php echo self::$language['withdraw_state']['3']?>:<?php echo $module['state_3']?> <a href=# target="_blank" state=3><?php echo self::$language['export']?></a></div>
            </td>
        </tr>
    </table>
            

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['username']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="money|desc" class="sorting"  asc="money|asc"><?php echo self::$language['withdraw']?><?php echo self::$language['amount']?></a></td>
                <td ><?php echo self::$language['withdraw_rate']?></td>
                <td ><?php echo self::$language['withdraw_method']?></td>
                <td ><?php echo self::$language['real_name']?></td>
                <td ><?php echo self::$language['billing_info']?></td>
                <td ><?php echo self::$language['state']?></td>
                <td style="width:250px;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    
    
    
    
    
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
               <b><?php echo self::$language['refuse']?><?php echo self::$language['reason']?></b>
            </h4>
         </div>
         <div class="modal-body">
             <div class=batch_reason_div>
             	<input type=text class=batch_reason placeholder="<?php echo self::$language['please_input']?>" /> <a href=# class="submit set_2"><?php echo self::$language['submit']?></a>
             </div>
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
