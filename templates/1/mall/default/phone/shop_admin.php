<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#sequence").change(function(){
			url=window.location.href;
            url=replace_get(url,"order",$(this).prop('value'));
			window.location=url;	
		});
		var order=get_param('order');
		if(order!=''){$("#sequence").prop('value',order);}
		
		$("#<?php echo $module['module_name'];?> .payment").each(function(index, element) {
            v=$(this).attr('values');
			id=$(this).attr('id');
			$("#<?php echo $module['module_name'];?> #"+id+" input").each(function(index, element) {
                if(v.indexOf($(this).attr('value')+',')!==-1){$(this).prop('checked',true);}
            });
        });
		
		$("#<?php echo $module['module_name'];?> .all_user").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked','checked');}
        });
		$("#<?php echo $module['module_name'];?> .web_c_password").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked','checked');}
        });
		
		$("#<?php echo $module['module_name'];?> .pay_agent").click(function(){
			if(confirm("<?php echo self::$language['opration_confirm']?>")){
			id=$(this).parent().parent().parent().parent().parent().attr('id').replace(/tr_/,'');
			$("#<?php echo $module['module_name'];?> #tr_"+id+" .pay_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=pay_agent',{id:id}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> #tr_"+id+" .pay_state").html(v.info);
			});
			}
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .data_state").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
		
		$("#<?php echo $module['module_name'];?> .trusteeship").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
		
		$("#<?php echo $module['module_name'];?> .shops >div .s_left").click(function(){
			if($(this).next().css('display')=='none'){
				$(this).next().css('display','block');
			}else{
				$(this).next().css('display','none');
			}
		});
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});
		$(document).on('click','#<?php echo $module['module_name'];?> .edit',function(){
			set_iframe_position(800,500);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		$(document).on('click','#<?php echo $module['module_name'];?> .set',function(){
			set_iframe_position(850,500);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .data_state").change(function(){
			$(this).next().css('display','block');	
		});
		
        var get_search=get_param('search');
        if(get_search.length<1){
            var state=get_param('state');
            if(state!=''){$("#state_filter").prop("value",state);}
        }
        
		var area_province=get_param('area_province');
		if(area_province!=''){$("#area_province").prop('value',area_province);}
		var area_city=get_param('area_city');
		if(area_city!=''){$("#area_city").prop('value',area_city);}
		var area_county=get_param('area_county');
		if(area_county!=''){$("#area_county").prop('value',area_county);}
		var area_twon=get_param('area_twon');
		if(area_twon!=''){$("#area_twon").prop('value',area_twon);}
		var area_village=get_param('area_village');
		if(area_village!=''){$("#area_village").prop('value',area_village);}
		var area_group=get_param('area_group');
		if(area_group!=''){$("#area_group").prop('value',area_group);}
		
		
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
    });
    
    function monxin_table_filter(id){
            if($("#"+id).prop("value")!=-1){
                key=id.replace("_filter","");
                url=window.location.href;
                url=replace_get(url,key,$("#"+id).prop("value"));
                if(key!="search"){url=replace_get(url,"search","");}
				if(key=='area_province'){url=replace_get(url,"area_city","");url=replace_get(url,"area_county","");url=replace_get(url,"area_twon","");url=replace_get(url,"area_village","");url=replace_get(url,"area_group","");}
				if(key=='area_city'){url=replace_get(url,"area_county","");url=replace_get(url,"area_twon","");url=replace_get(url,"area_village","");url=replace_get(url,"area_group","");}
				if(key=='area_county'){url=replace_get(url,"area_twon","");url=replace_get(url,"area_village","");url=replace_get(url,"area_group","");}
				if(key=='area_twon'){url=replace_get(url,"area_village","");url=replace_get(url,"area_group","");}
				if(key=='area_village'){url=replace_get(url,"area_group","");}

                window.location.href=url;	
            }
    }
	
	
    function update(id){
        var sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
       
	    var rate=$("#<?php echo $module['module_name'];?> #rate_"+id);	
        if(rate.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['rate_3']?>');rate.focus();return false;}	
       
	    var annual_rate=$("#<?php echo $module['module_name'];?> #annual_rate_"+id);	
        if(annual_rate.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['annual_shop_tag_rate']?>');annual_rate.focus();return false;}	
        
		var credits_rate=$("#<?php echo $module['module_name'];?> #credits_rate_"+id);	
        if(credits_rate.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['credits']?>');credits_rate.focus();return false;}	
		
		var average=$("#<?php echo $module['module_name'];?> #average_"+id);	
        if(average.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['average']?>');average.focus();return false;}	
		var pay_money=$("#<?php echo $module['module_name'];?> #pay_money_"+id);	
        if(pay_money.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['pay_money']?>');pay_money.focus();return false;}	
		
		var return_credits=$("#<?php echo $module['module_name'];?> #return_credits_"+id);	
        if(return_credits.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['return_credits']?>');return_credits.focus();return false;}	
		
        if($("#<?php echo $module['module_name'];?> #tr_"+id+" .cause").css('display')=='block' && $("#<?php echo $module['module_name'];?> #tr_"+id+" .cause").val()==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['cause']?>');$("#<?php echo $module['module_name'];?> #tr_"+id+" .cause").focus();return false;}	
        payment='';
		$("#<?php echo $module['module_name'];?> #py_"+id+" input").each(function(index, element) {
            if($(this).prop('checked')){payment+=$(this).attr('value')+',';}
        });
		
		if($("#<?php echo $module['module_name'];?> #tr_"+id+" .all_user").prop('checked')){all_user=1;}else{all_user=0;}
		if($("#<?php echo $module['module_name'];?> #tr_"+id+" .web_c_password").prop('checked')){web_c_password=1;}else{web_c_password=0;}
		
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{state:$("#<?php echo $module['module_name'];?> #data_state_"+id).prop('value'),sequence:sequence.prop('value'),trusteeship:$("#<?php echo $module['module_name'];?> #trusteeship_"+id).prop('value'),id:id,cause:$("#<?php echo $module['module_name'];?> #tr_"+id+" .cause").val(), payment: payment, all_user: all_user, web_c_password: web_c_password,credits_rate:credits_rate.prop('value'),rate:rate.prop('value'),annual_rate:annual_rate.prop('value'),average:average.prop('value'),pay_money:pay_money.prop('value'),return_credits:return_credits.prop('value')}, function(data){
           //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        	
       return false; 
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
       return false; 
    }
	function update_tag(id,c){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .tag").html(c);
	}
    </script>
    <style>
    #<?php echo $module['module_name'];?>{     background-color: rgb(243, 243, 243);}
    #<?php echo $module['module_name'];?>_html >div{ background:#fff; padding:0.3rem;}
    #<?php echo $module['module_name'];?> .set{display:inline-block; vertical-align:top; width:30px; text-decoration:none;}
	#<?php echo $module['module_name'];?> .set:before{font: normal normal normal 15px/1 FontAwesome;content: "\f040";}
	
	
	#<?php echo $module['module_name'];?> .shops{ background:none; padding:0px;}
	#<?php echo $module['module_name'];?> .shops >div{ border-bottom:1px solid #ccc; background:#fff; margin-top:0.8rem; margin-bottom:0.8rem; padding:0.3rem;}
	#<?php echo $module['module_name'];?> .shops >div .s_left{ display:block; }
	#<?php echo $module['module_name'];?> .shops >div .s_left img{ width:80%;}
	#<?php echo $module['module_name'];?> .shops >div .s_right{ color:rgba(33,32,32,1.00); display:none; }
	#<?php echo $module['module_name'];?> .shops >div .s_right a{ color:rgba(33,32,32,1.00);}
	#<?php echo $module['module_name'];?> .shops >div .s_left .icon_logo{display:inline-block; width:30%; overflow:hidden; vertical-align:top; }
	#<?php echo $module['module_name'];?> .shops >div .s_left .icon_right{ display:inline-block; width:70%;overflow:hidden; vertical-align:top;  }
	#<?php echo $module['module_name'];?> .shops >div .s_left .name{ display:block; width:100%;  font-weight:bold;}

	#<?php echo $module['module_name'];?> .shops >div .s_right .payment >span{ display:inline-block; width:115px; overflow:hidden; white-space:nowrap;}
	
	#<?php echo $module['module_name'];?> .shops >div .s_right .username{ display:inline-block; width:33%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .shops >div .s_right .agent{ display:inline-block; width:33%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .shops >div .s_right .reg_time{ display:inline-block; width:33%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .shops >div .s_right >div{ display:inline-block; width:33%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .shops >div .s_right >span{ display:inline-block; width:33%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .shops >div .s_right .payment{ display:block; width:100%; border-top:1px dashed #ccc; padding-top:0.5rem; margin-top:0.5rem;}
	#<?php echo $module['module_name'];?> .shops >div .s_right .item{ display:block; width:100%;}
	#<?php echo $module['module_name'];?> .shops >div .s_right .item span{ display:inline-block; margin-right:1rem;}
	#<?php echo $module['module_name'];?> .shops >div .s_right .main_business{ display:block; width:100%;}
	#<?php echo $module['module_name'];?> .shops >div .s_right .input_act{ display:block; width:100%;}
	#<?php echo $module['module_name'];?> .shops >div .s_right .input_act span{ margin-right:1rem;}
	#<?php echo $module['module_name'];?> .shops >div .s_right .input_act input{ width:40px;}
	#<?php echo $module['module_name'];?> .shops >div .s_right .operation_td{ display:inline-block; vertical-align:top; width:40%;}
	
	#<?php echo $module['module_name'];?> .operation_td a{ display:inline-block;}
	#<?php echo $module['module_name'];?> .cause{ display:none;}
	#<?php echo $module['module_name'];?> .main_business{ border-top:1px dashed #ccc; padding-top:0.5rem; margin-top:0.5rem;}
	
	#<?php echo $module['module_name'];?> .shops >div .s_right >div{ display:block; width:100%;}
	#<?php echo $module['module_name'];?> .shops >div .s_right >span{ display:block; width:100%;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['shop_name']?>/<?php echo self::$language['username']?>/<?php echo self::$language['main_business']?>/<?php echo self::$language['phone']?>/<?php echo self::$language['email']?>"  class="form-control" ></m_label></div></div></div>
    
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
		<?php echo $module['batch_msg'];?>
        <?php echo $module['area'];?>
    </div>
    <div class=top_div><?php echo self::$language['sequence']?>:<select id=sequence name=sequence><?php echo $module['sequence']?></select></div>
    <div class=shops><?php echo $module['list']?></div>
    <div class=m_row><?php echo $module['page']?></div>
    </div>
    </div>

</div>
