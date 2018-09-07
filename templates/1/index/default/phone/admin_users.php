<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script src="./plugin/datePicker/index.php"></script>
	<script>
    $(document).ready(function(){
		
		$("#<?php echo $module['module_name'];?> .import_im").click(function(){
			ids=get_ids();
			$("#<?php echo $module['module_name'];?> #state_select").html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get($(this).attr('href'),{ids:ids},function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#<?php echo $module['module_name'];?> #state_select").html(v.info);
            });
			return false;
		});
		
		
		$("#<?php echo $module['module_name'];?> .inquiry").click(function(){
			//if($("#<?php echo $module['module_name'];?> #start_time").val()==''){$("#<?php echo $module['module_name'];?> #start_time").focus();return false;}
			//if($("#<?php echo $module['module_name'];?> #end_time").val()==''){$("#<?php echo $module['module_name'];?> #end_time").focus();return false;}
			window.location.href='./index.php?monxin=index.admin_users&start_time='+$("#<?php echo $module['module_name'];?> #start_time").val()+'&end_time='+$("#<?php echo $module['module_name'];?> #end_time").val();
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?>_table .icon").each(function(index, element) {
            $(this).css('background','none');
			$(this).attr('target','_blank');
			if($(this).children('img').attr('wsrc')!='./program/index/user_icon/'){$(this).children('img').attr('src',$(this).children('img').attr('wsrc'));}
        });
		$("#<?php echo $module['module_name'];?>_html .show_more_option").toggle(function(){
				$(this).addClass('show_more_option_2');
				$("#<?php echo $module['module_name'];?>_html .more_option").css('display','block');
				return false;
			},function(){
				$(this).removeClass('show_more_option_2');
				$("#<?php echo $module['module_name'];?>_html .more_option").css('display','none');
				return false;
			});
			
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
		
		
		$("[monxin-table] tbody tr").unbind('mouseover');
		$("[monxin-table] tbody tr").unbind('mouseout');
		$("#sequence").change(function(){
			url=window.location.href;
            url=replace_get(url,"order",$(this).prop('value'));
			window.location=url;	
		});
		var order=get_param('order');
		if(order!=''){$("#sequence").prop('value',order);}
		var state=get_param('state');
		if(state!=''){$("#state").prop('value',state);}
		var group=get_param('group');
		if(group!=''){$("#group").prop('value',group);}
		var manager=get_param('manager');
		if(manager!=''){$("#manager").prop('value',manager);}
		var home_area_province=get_param('home_area_province');
		if(home_area_province!=''){$("#home_area_province").prop('value',home_area_province);}
		var home_area_city=get_param('home_area_city');
		if(home_area_city!=''){$("#home_area_city").prop('value',home_area_city);}
		var home_area_county=get_param('home_area_county');
		if(home_area_county!=''){$("#home_area_county").prop('value',home_area_county);}
		var home_area_twon=get_param('home_area_twon');
		if(home_area_twon!=''){$("#home_area_twon").prop('value',home_area_twon);}
		var home_area_village=get_param('home_area_village');
		if(home_area_village!=''){$("#home_area_village").prop('value',home_area_village);}
		var home_area_group=get_param('home_area_group');
		if(home_area_group!=''){$("#home_area_group").prop('value',home_area_group);}
		var current_area_province=get_param('current_area_province');
		if(current_area_province!=''){$("#current_area_province").prop('value',current_area_province);}
		var current_area_city=get_param('current_area_city');
		if(current_area_city!=''){$("#current_area_city").prop('value',current_area_city);}
		var current_area_county=get_param('current_area_county');
		if(current_area_county!=''){$("#current_area_county").prop('value',current_area_county);}
		var current_area_twon=get_param('current_area_twon');
		if(current_area_twon!=''){$("#current_area_twon").prop('value',current_area_twon);}
		var current_area_village=get_param('current_area_village');
		if(current_area_village!=''){$("#current_area_village").prop('value',current_area_village);}
		var current_area_group=get_param('current_area_group');
		if(current_area_group!=''){$("#current_area_group").prop('value',current_area_group);}
		var annual_income=get_param('annual_income');
		if(annual_income!=''){$("#annual_income").prop('value',annual_income);}
		var education=get_param('education');
		if(education!=''){$("#education").prop('value',education);}
		var gender=get_param('gender');
		if(gender!=''){$("#gender").prop('value',gender);}
		var married=get_param('married');
		if(married!=''){$("#married").prop('value',married);}
		var blood_type=get_param('blood_type');
		if(blood_type!=''){$("#blood_type").prop('value',blood_type);}
		var birthday_year=get_param('birthday_year');
		if(birthday_year!=''){$("#birthday_year").prop('value',birthday_year);}
		var birthday_month=get_param('birthday_month');
		if(birthday_month!=''){$("#birthday_month").prop('value',birthday_month);}
		var birthday_day=get_param('birthday_day');
		if(birthday_day!=''){$("#birthday_day").prop('value',birthday_day);}

        
        
        $("#<?php echo $module['module_name'];?>_table tbody tr td table tr").attr('class','');     
		   
		$("#<?php echo $module['module_name'];?> .set_selected_state").click(function(){
			ids=get_ids();
			state=$(this).attr('value');
			if(ids==''){alert("<?php echo self::$language['select_null']?>");return false;}
			//alert($(this).attr('href'));
			$("#state_select").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get($(this).attr('href')+"&ids="+ids,function(data){
				//alert(data);
			    try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#state_select").html(v.info);
				if(v.state=='success'){
					temp=ids.split('|');
					for(id in temp){
						$("#user_state_"+temp[id]).val(state);	
					}	
				}
				
			});
			return false;	
		});
		
		$(".actions ul a").click(function(){
			if($(this).attr('class')=='set_selected_state'){return false;}
			url=$(this).attr('href');
			ids=get_ids();
			if(ids==''){alert("<?php echo self::$language['select_null']?>");return false;}
			$("#state_select").html('');
			url+="&ids="+ids;	
			//monxin_alert(url);
			$(this).attr('href',url);
		});
		$('#bulk_action_state_a').click(function(){
			url=$(this).attr('href');
			var bulk_action_state=$("#bulk_action_state").val();
			$("#bulk_action_state_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get(url,{state:bulk_action_state}, function(data){
			    try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#bulk_action_state_state").html(v.info);
			});
		return false;			
		});
		$('#bulk_action_state_selected_a').click(function(){
			url=$(this).attr('href');
			var bulk_action_state_selected=$("#bulk_action_state_selected").val();
			ids=get_ids();
			if(ids==''){monxin_alert("<?php echo self::$language['select_null']?>");}
			$("#bulk_action_state_selected_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get(url,{state:bulk_action_state_selected,ids:ids}, function(data){
			    try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#bulk_action_state_selected_state").html(v.info);
			});
		return false;		
		});
    });
    
    
    
    function monxin_table_filter(id){
            if($("#"+id).prop("value")!=-1){
                key=id.replace("_filter","");
                url=window.location.href;
                url=replace_get(url,key,$("#"+id).prop("value"));
                if(key!="search"){url=replace_get(url,"search","");}
                if(key=="group"){url=replace_get(url,"manager","");}
				if(key=='home_area_province'){url=replace_get(url,"home_area_city","");url=replace_get(url,"home_area_county","");url=replace_get(url,"home_area_twon","");url=replace_get(url,"home_area_village","");url=replace_get(url,"home_area_group","");}
				if(key=='home_area_city'){url=replace_get(url,"home_area_county","");url=replace_get(url,"home_area_twon","");url=replace_get(url,"home_area_village","");url=replace_get(url,"home_area_group","");}
				if(key=='home_area_county'){url=replace_get(url,"home_area_twon","");url=replace_get(url,"home_area_village","");url=replace_get(url,"home_area_group","");}
				if(key=='home_area_twon'){url=replace_get(url,"home_area_village","");url=replace_get(url,"home_area_group","");}
				if(key=='home_area_village'){url=replace_get(url,"home_area_group","");}
				if(key=='current_area_province'){url=replace_get(url,"current_area_city","");url=replace_get(url,"current_area_county","");url=replace_get(url,"current_area_twon","");url=replace_get(url,"current_area_village","");url=replace_get(url,"current_area_group","");}
				if(key=='current_area_city'){url=replace_get(url,"current_area_county","");url=replace_get(url,"current_area_twon","");url=replace_get(url,"current_area_village","");url=replace_get(url,"current_area_group","");}
				if(key=='current_area_county'){url=replace_get(url,"current_area_twon","");url=replace_get(url,"current_area_village","");url=replace_get(url,"current_area_group","");}
				if(key=='current_area_twon'){url=replace_get(url,"current_area_village","");url=replace_get(url,"current_area_group","");}
				if(key=='current_area_village'){url=replace_get(url,"current_area_group","");}
				if(key=='birthday_year'){url=replace_get(url,"birthday_month","");url=replace_get(url,"birthday_day","");}
				if(key=='birthday_month'){url=replace_get(url,"birthday_day","");}

                window.location.href=url;	
            }
    }
    
    
    function update(id){
        var group=$("#group_"+id);
        var state=$("#user_state_"+id);
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=state',{state:state.prop('value'),id:id}, function(data){
           // monxin_alert(data);
                        try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            $("#state_"+id).html(v.info);
        });
        	
        return false;	
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
       return false; 
    }
    
    function subimt_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<span class=fail><?php echo self::$language['select_null']?></span>");return false;}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['state']=$("#user_state_"+ids[id]).prop('value');
			$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
			            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#state_select").html(v.info);
			//monxin_alert(ids);
			success=v.ids.split("|");
			for(id in ids){
				if(in_array(ids[id],success)){
					$("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
				}else{
					$("#state_"+ids[id]).html("<span class=success><?php echo self::$language['executed'];?></span>");	
				}	
			}
        });	
        
        
      return false;  
        	
    }
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<span class=fail><?php echo self::$language['select_null']?></span>");return false;return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
				//monxin_alert(data);
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
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
                }
                }
            });
        }	
       return false; 	
    }
    
    
    </script>
    <style>
	
	#import_file_ele{ display:none !important;}
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html #index_admin_users_table a{  font-size:1rem; padding-left:5px; padding-right:5px; border-radius:3px;}
	#<?php echo $module['module_name'];?>_html #index_admin_users_table a:hover{opacity:0.8; filter:alpha(opacity=80); text-decoration:none; }
	#<?php echo $module['module_name'];?>_html  .m_label{ width:20%; display:inline-block; vertical-align:top; text-align:right; padding-right:5px; margin-bottom:20px;}
	#<?php echo $module['module_name'];?>_html .option{ width:78%; display:inline-block;vertical-align:top;}
	#<?php echo $module['module_name'];?>_html #search_filter{ width:60%;}
	#<?php echo $module['module_name'];?>_html #sequence_div{ text-align:right; padding:10px;}
	#<?php echo $module['module_name'];?>_html #sequence{ height:30px; line-height:30px; margin-left:10px;}
    
	#<?php echo $module['module_name'];?> .show_more_option{ font-size:15px; line-height:100%;  padding:0.3rem;}
	#<?php echo $module['module_name'];?> .show_more_option:after{font: normal normal normal 1rem/1 FontAwesome; content:"\f103"; padding-left:3px;}
	#<?php echo $module['module_name'];?> .show_more_option_2:after{font: normal normal normal 1rem/1 FontAwesome; content:"\f102"; padding-left:3px;}
	#<?php echo $module['module_name'];?> .more_option{ display:none;}
    #<?php echo $module['module_name'];?>_table .icon img{ width:6rem; height:6rem;}
	#<?php echo $module['module_name'];?>_table .operation{ width:190px; overflow:hidden; text-align:left;}
	#<?php echo $module['module_name'];?> .change_group_selected{ }
	#<?php echo $module['module_name'];?> .change_manager_selected{ }
	#<?php echo $module['module_name'];?>_html{box-shadow:none; padding:0px; margin:0px;}
	#<?php echo $module['module_name'];?>_html .more_option{ line-height:2rem;}
	#<?php echo $module['module_name'];?>_html .top_div{ text-align:right;}
	#<?php echo $module['module_name'];?>_html .operation_td a{ display:block;}
	#<?php echo $module['module_name'];?>_html #import_file_ele{ display:none !important;}
	#<?php echo $module['module_name'];?>_html .u_info{ white-space:nowrap; width:15rem;}
	#<?php echo $module['module_name'];?>_html .u_info .u_label{ opacity:0.6; display:inline-block; vertical-align:top; width:30%; overflow:hidden; text-align:right;}
	#<?php echo $module['module_name'];?>_html .u_info .u_value{display:inline-block; vertical-align:top; width:70%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .openid:before {font: normal normal normal 1rem/1 FontAwesome;margin-left:2px;content: "\f1d7"; color:green;}
    .login_num{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?> !important; }
    </style>
    <div id="<?php echo $module['module_name'];?>_html" monxin-table='1' class='portlet light'>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <a  href=./index.php?monxin=index.increase_user class="add increase_user"><?php echo self::$language['increase']?><?php echo self::$language['member']?></a>
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a></li> 
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                    <?php echo $module['selected_action'];?>
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search" class="form-control" ></m_label></div></div></div>
    
    <div class="filter"><?php echo self::$language['content_filter']?>
  <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo $module['placeholder'];?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span> 
        
        <a href=# class=show_more_option style="display:inline-block !important; " user_color=button><?php echo self::$language['more']?><?php echo self::$language['option']?></a>
       
     <hr/>
        <div class=more_option><?php echo $module['filter']?></div>
    </div>
        <span id=time_limit><span class=start_time_span><?php echo self::$language['reg_user']?><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
       <span class=end_time_span><?php echo self::$language['reg_user']?><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="inquiry"><?php echo self::$language['inquiry']?></a></span>

    
    <div class=top_div><?php echo self::$language['sequence']?>:<select id=sequence name=sequence><?php echo $module['sequence']?></select></div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style=" width:100%" cellpadding="0" cellspacing="0" >
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td><?php echo self::$language['icon_short']?></td>
                <td><?php echo self::$language['info']?></td>
                <td><?php echo self::$language['credits']?></td>
                <td style="text-align:left;"><?php echo self::$language['balance']?></td>
                <td><?php echo self::$language['reg_time']?></td>
                <td><?php echo self::$language['state']?></td>
                <td class=operation_td><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            </tr>
    <?php echo  $module['list']?>
        </tbody>
    </table></div>

    <div class='monxin_table_bulk_action_div'><?php echo $module['bulk_action'];?></div>
   <?php echo $module['page']?>

</div>




</div>



