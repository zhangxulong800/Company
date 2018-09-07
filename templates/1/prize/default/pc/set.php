<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script src="./plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){
		<?php echo $module['template_diy_js'];?>
		$('#share_icon_ele').insertBefore($('#share_icon_state'));
		
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
			if($(this).attr('monxin_value')){$(this).val($(this).attr('monxin_value'));}	
        });
		
		$("#<?php echo $module['module_name'];?> .nav-tabs a").click(function(){
			$("#<?php echo $module['module_name'];?> .nav-tabs li").removeClass('active');
			$(this).parent().addClass('active');
			$("#<?php echo $module['module_name'];?> [module_div]").css('display','none');
			$("#<?php echo $module['module_name'];?> [module_div='"+$(this).attr('div')+"']").css('display','block');
			
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .prize_number").change(function(){
			length=$(this).val();
			$("#<?php echo $module['module_name'];?> #prize_table tbody tr").each(function(index, element) {
				//alert(index+'<='+length);
                if(index<length){
					$("#prize_table tbody #prize_"+(index+1)).css('display','table-row');
				}else{
					$("#prize_table tbody #prize_"+(index+1)).css('display','none');
				}
            });
		});
		$("#<?php echo $module['module_name'];?> .prize_type").change(function(){
			if($(this).val()==1){
				$(this).next().css('display','none');
			}else{
				$(this).next().css('display','inline-block');
			}	
			if($(this).val()==2){
				$(this).next().attr('placeholder','<?php echo self::$language['object_type_2']?>');
				$(this).next().val('');
			}else{
				$(this).next().attr('placeholder','<?php echo self::$language['please_input']?>');	
			}	
		});
		
		$("#<?php echo $module['module_name'];?> #bg_color_picker").change(function(){
			if($(this).val()!=''){$(this).prev().val($(this).val());}
		});
		$("#<?php echo $module['module_name'];?> #bg_color").change(function(){
			if($(this).val()!=''){$(this).next().val($(this).val());}
		});
		
		$("#<?php echo $module['module_name'];?> .input input[type='text']").blur(function(){
			submit_update($(this).attr('id'));
		});
		$("#<?php echo $module['module_name'];?> .input select").change(function(){
			submit_update($(this).attr('id'));
		});
		
		$("input[type='hidden'],#share_icon").change(function(){
			alert('xx');
			submit_update($(this).attr('id'));
		});
		
		$("#<?php echo $module['module_name'];?> .input textarea").blur(function(){
			submit_update($(this).attr('id'));
		});
		
		$("#<?php echo $module['module_name'];?> #try_mode").change(function(){
			if($(this).val()==3 || $(this).val()==4 ){
				$("#<?php echo $module['module_name'];?> #try_mode_value_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> #try_mode_value_div").css('display','none');
			}
			if($(this).val()==5 ){
				$("#<?php echo $module['module_name'];?> #try_mode_5_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> #try_mode_5_div").css('display','none');
			}
			if($(this).val()==1 ){
				$("#<?php echo $module['module_name'];?> #try_mode_1_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> #try_mode_1_div").css('display','none');
			}
		});
		
		if($("#<?php echo $module['module_name'];?> #try_mode").val()==3){$("#<?php echo $module['module_name'];?> #try_mode_value_div").css('display','block');}
		if($("#<?php echo $module['module_name'];?> #try_mode").val()==4){$("#<?php echo $module['module_name'];?> #try_mode_value_div").css('display','block');}
		if($("#<?php echo $module['module_name'];?> #try_mode").val()==5){$("#<?php echo $module['module_name'];?> #try_mode_5_div").css('display','block');}
		if($("#<?php echo $module['module_name'];?> #try_mode").val()==1){$("#<?php echo $module['module_name'];?> #try_mode_1_div").css('display','block');}
		$("#<?php echo $module['module_name'];?> #prize_table tbody tr input").change(function(){
			$(this).removeClass('err_input');	
		});
		
		var prize_quantity=1;
		$("#<?php echo $module['module_name'];?> #prize_table tbody tr").each(function(index, element) {
            id=$(this).attr('id');
			if($("#<?php echo $module['module_name'];?> #"+id+" .prize_type").val()!=1){$("#<?php echo $module['module_name'];?> #"+id+" .prize_type").next('input').css('display','inline-block');prize_quantity++;}
        });
		
		$("#<?php echo $module['module_name'];?> .prize_number").val(prize_quantity+1);
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> #submit_state").html('');
			obj=new Object();
			is_null=false;
			$("#<?php echo $module['module_name'];?> #prize_table tbody tr").each(function(index, element) {
                if($(this).css('display')!='none'){
					id=$(this).attr('id');
					if($(this).attr('data_id')){data_id=$(this).attr('data_id');}else{data_id=id;}
					obj[data_id]=new Object();
					$("#<?php echo $module['module_name'];?> #"+id+" input,#<?php echo $module['module_name'];?> #"+id+" select").each(function(index, element) {
                        //if($(this).attr('class')=='prize_name' && $(this).val()==''){$(this).val($(this).parent().prev().html());}
						if($(this).attr('class')=='prize_type_value'){
							if($(this).prev().val()!=1){
								$(this).css('display','inline-block');
								if($(this).val()==''){$(this).addClass('err_input');$(this).focus();is_null=true;return false; }
							}
							if($(this).prev().val()!=1 && $(this).prev().val()!=2){
								if(!$.isNumeric($(this).val()) || parseFloat($(this).val())<0){$(this).addClass('err_input');$(this).focus();is_null=true;return false;}
							}
							
								
						}else{
							if($(this).val()==''){$(this).addClass('err_input');$(this).focus();is_null=true;return false; }
						}
						
						if($(this).attr('class')=='prize_rate' || $(this).attr('class')=='prize_sum' || $(this).attr('class')=='prize_day_max'){
							if(!$.isNumeric($(this).val()) || parseFloat($(this).val())<0){$(this).addClass('err_input');$(this).focus();is_null=true;return false;}
						}
						
						obj[data_id][$(this).attr('class')]=$(this).val();
						//alert(obj[data_id][$(this).attr('class')]);
						
                    });	
					if(is_null){return false;}
				}
            });
			
			if(is_null){$("#<?php echo $module['module_name'];?> #submit_state").html('<span class=fail><?php echo self::$language['is_null']?></span>');return false;}
			
			$("#<?php echo $module['module_name'];?> #submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update_prize',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> #submit_state").html(v.info);
			});
			return false;	
		});
    });
	
	function submit_update(id){
		if(id==undefined){return false;}
		//alert($("#<?php echo $module['module_name'];?> #"+id).val());
		if($("#<?php echo $module['module_name'];?> #"+id).attr('type')=='file'){return false;} 
		
		$("#<?php echo $module['module_name'];?> #"+id+"_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.post('<?php echo $module['action_url'];?>&act=update',{key:id,v:$("#<?php echo $module['module_name'];?> #"+id).val()}, function(data){
		   
		   try{v=eval("("+data+")");}catch(exception){alert(data);}
		   $("#<?php echo $module['module_name'];?> #"+id+"_state").html(v.info);
		});

	}
	
	function submit_hidden(id){
		$("#<?php echo $module['module_name'];?> #"+id+"_img").attr('src','./temp/'+$("#<?php echo $module['module_name'];?> #"+id).val());
		submit_update(id);
	}
	
    </script>
    
    
    <style>
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?> .line_div{ line-height:50px;}
    #<?php echo $module['module_name'];?> .line_div .m_label{ display:inline-block; vertical-align:top; width:15%; overflow:hidden; text-align:right; padding-right:5px;}
    #<?php echo $module['module_name'];?> .line_div .input{ display:inline-block; vertical-align:top; width:80%; overflow:hidden;}
	
	#<?php echo $module['module_name'];?> .nav-tabs{ margin-bottom:20px;}
	
	#<?php echo $module['module_name'];?> .diy_img img{ height:60px;}
	[module_div]{ display:none;}
	
	#<?php echo $module['module_name'];?> table input{ width:100px;}
	
	#<?php echo $module['module_name'];?> table .prize_type_value{ display:none;}
	
	#<?php echo $module['module_name'];?> #prize_table tbody tr{ display:none;}
	
	#<?php echo $module['module_name'];?> #bg_color_picker{ width:40px;}
	#<?php echo $module['module_name'];?> #diy_css{ width:80%; height:100px;}
	#<?php echo $module['module_name'];?> #share_title{ width:80%;}
	#<?php echo $module['module_name'];?> #share_describe{ width:80%; }
	
	#<?php echo $module['module_name'];?> #share_icon_img{ width:30px; display:inline-block; vertical-align:top;}
	
	.err_input{ border-color:red !important;}
	#prize_table{ white-space:nowrap; font-size:13px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"> 
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"><a href=#  div=base_div><?php echo self::$language['base'];?><?php echo self::$language['set'];?></a></li>
          <li role="presentation" div=ui_div><a href=#  div=ui_div><?php echo self::$language['ui'];?><?php echo self::$language['set'];?></a></li>
          <li role="presentation"><a href=#  div=try_div><?php echo self::$language['try_set'];?></a></li>
          <li role="presentation"><a href=#  div=prize_div><?php echo self::$language['prize'];?><?php echo self::$language['set'];?></a></li>
        </ul>
        <div module_div=base_div style="display:block;">
            <div class=line_div><span class=m_label><?php echo self::$language['activity'];?><?php echo self::$language['name'];?></span><span class=input><input type="text" name="name" id="name" value="<?php echo $module['data']['name'];?>" /><span id=name_state class=state></span></span></div>
               
            <div class=line_div><span class=m_label><?php echo self::$language['start_time'];?></span><span class=input><input type="text" id="start" name="start"  value="<?php echo $module['data']['start'];?>"   onclick=show_datePicker(this.id,'date_time') onblur= hide_datePicker()  /><span id=start_state class=state></span></span></div>
               
            <div class=line_div><span class=m_label><?php echo self::$language['end_time'];?></span><span class=input><input type="text" id="end" name="end"   value="<?php echo $module['data']['end'];?>"  onclick=show_datePicker(this.id,'date_time') onblur= hide_datePicker()  /><span id=end_state class=state></span></span></div>
            
            <div class=line_div><span class=m_label><?php echo self::$language['sponsor'];?></span><span class=input><input type="text" name="sponsor" id="sponsor" value="<?php echo $module['data']['sponsor'];?>" /><span id=sponsor_state class=state></span></span></div>

            <div class=line_div><span class=m_label><?php echo self::$language['pc_ad'];?></span><span class=input><select id=pc_ad monxin_value="<?php echo $module['data']['pc_ad']?>"><?php echo $module['ad_option']?></select><span id=pc_ad_state class=state></span></span></div>

            <div class=line_div><span class=m_label><?php echo self::$language['phone_ad'];?></span><span class=input><select id=phone_ad monxin_value="<?php echo $module['data']['phone_ad']?>"><?php echo $module['ad_option']?></select><span id=phone_ad_state class=state></span></span></div>
            
            <div class=line_div><span class=m_label><?php echo self::$language['ad_second'];?></span><span class=input><input type="text" name="ad_second" id="ad_second" value="<?php echo $module['data']['ad_second'];?>" /><span id=ad_second_state class=state></span></span></div>
            
            <div class=line_div><span class=m_label><?php echo self::$language['share_title'];?></span><span class=input><input type="text" name="share_title" id="share_title" value="<?php echo $module['data']['share_title'];?>" /><span id=share_title_state class=state></span></span></div>
            
            <div class=line_div><span class=m_label><?php echo self::$language['share_icon'];?></span><span class=input><img src="./program/prize/img/<?php echo $module['data']['share_icon']?>"	 id=share_icon_img /> <span id=share_icon_state class=state></span></span></div>
            
            <div class=line_div style="display:none;"><span class=m_label><?php echo self::$language['share_describe'];?></span><span class=input><input type="text" name="share_describe" id="share_describe" value="<?php echo $module['data']['share_describe'];?>" /><span id=share_describe_state class=state></span></span></div>
        
        </div>
        
        <div module_div=ui_div>
        	<?php echo $module['template_diy'];?>
            <div class=line_div><span class=m_label><?php echo self::$language['bg_color'];?></span><span class=input><input type="text" name="bg_color" id="bg_color" value="<?php echo $module['data']['bg_color'];?>" /> <input type="color" id=bg_color_picker /><span id=bg_color_state class=state></span></span></div>
            <div class=line_div><span class=m_label><?php echo self::$language['pc_padding_top'];?></span><span class=input><input type="text" name="pc_padding_top" id="pc_padding_top" value="<?php echo $module['data']['pc_padding_top'];?>" /><span id=pc_padding_top_state class=state></span></span></div>
            <div class=line_div><span class=m_label><?php echo self::$language['phone_padding_top'];?></span><span class=input><input type="text" name="phone_padding_top" id="phone_padding_top" value="<?php echo $module['data']['phone_padding_top'];?>" /><span id=phone_padding_top_state class=state></span></span></div>
            <div class=line_div><span class=m_label><?php echo self::$language['diy_css'];?></span><span class=input><textarea id=diy_css name=diy_css><?php echo $module['data']['diy_css']?></textarea><span id=diy_css_state class=state></span></span></div>
        </div>
        
        <div module_div=try_div>
            <div class=line_div><span class=m_label><?php echo self::$language['open_prize_quantity'];?></span><span class=input><select id=open_prize_quantity class=open_prize_quantity monxin_value=<?php echo $module['data']['open_prize_quantity']?>><option value="0"><?php echo self::$language['no']?></option><option value="1"><?php echo self::$language['yes']?></option></select><span id=open_prize_quantity_state class=state></span></span></div>
            
            <div class=line_div><span class=m_label><?php echo self::$language['open_prize_winner'];?></span><span class=input><select id=open_prize_winner class=open_prize_winner monxin_value=<?php echo $module['data']['open_prize_winner']?>><option value="0"><?php echo self::$language['no']?></option><option value="1"><?php echo self::$language['yes']?></option></select><span id=open_prize_winner_state class=state></span></span></div>
            
            <div class=line_div><span class=m_label><?php echo self::$language['usesr_day_try_times'];?></span><span class=input><input type="text" name="usesr_day_try_times" id="usesr_day_try_times" value="<?php echo $module['data']['usesr_day_try_times'];?>" /><span id=usesr_day_try_times_state class=state></span></span></div>
            <div class=line_div><span class=m_label><?php echo self::$language['usesr_try_times'];?></span><span class=input><input type="text" name="usesr_try_times" id="usesr_try_times" value="<?php echo $module['data']['usesr_try_times'];?>" /><span id=usesr_try_times_state class=state></span></span></div>
            
            <div class=line_div><span class=m_label><?php echo self::$language['user_day_prize_times'];?></span><span class=input><input type="text" name="user_day_prize_times" id="user_day_prize_times" value="<?php echo $module['data']['user_day_prize_times'];?>" /><span id=user_day_prize_times_state class=state></span></span></div>
            
            <div class=line_div><span class=m_label><?php echo self::$language['user_prize_times'];?></span><span class=input><input type="text" name="user_prize_times" id="user_prize_times" value="<?php echo $module['data']['user_prize_times'];?>" /><span id=user_prize_times_state class=state></span></span></div>
            
            <div class=line_div><span class=m_label><?php echo self::$language['day_prize_user_max'];?></span><span class=input><input type="text" name="day_prize_user_max" id="day_prize_user_max" value="<?php echo $module['data']['day_prize_user_max'];?>" /><span id=day_prize_user_max_state class=state></span></span></div>
            
            <div class=line_div><span class=m_label><?php echo self::$language['try_mode_str'];?></span><span class=input><select id=try_mode name=try_mode class=try_mode monxin_value=<?php echo $module['data']['try_mode']?>><?php echo $module['try_mode_option'];?></select><span id=try_mode_state class=state></span></span></div>
            
            <div class=line_div id=try_mode_value_div style=" display:none;"><span class=m_label><?php echo self::$language['try_mode_value'];?></span><span class=input><input type="text" name="try_mode_value" id="try_mode_value" value="<?php echo $module['data']['try_mode_value'];?>" /><span id=try_mode_value_state class=state></span></span></div>
            
            <div class=line_div id=try_mode_1_div style=" display:none;"><span class=m_label>&nbsp;</span><span class=input><a href=./index.php?monxin=prize.content_try_mode_1&c_id=<?php echo $module['data']['id']?> target="_blank"><?php echo self::$language['view']?><?php echo self::$language['pages']['prize.content_try_mode_1']['name']?></a></span></div>
            
            <div class=line_div id=try_mode_5_div style=" display:none;"><span class=m_label>&nbsp;</span><span class=input><a href=./index.php?monxin=prize.try_mode_5&c_id=<?php echo $module['data']['id']?> target="_blank"><?php echo self::$language['try_mode_5_set']?></a></span></div>
            
        </div>
        
        <div module_div=prize_div>
            <div class=line_div><span class=m_label><?php echo self::$language['prize_number'];?></span><span class=input><select class=prize_number>
            	<option value="1">1</option>
            	<option value="2">2</option>
            	<option value="3">3</option>
            	<option value="4">4</option>
            	<option value="5">5</option>
            	<option value="6">6</option>
            	<option value="7">7</option>
            	<option value="8">8</option>
            	<option value="9">9</option>
            	<option value="10">10</option>
                
            </select><span id=prize_number_state class=state></span></span></div>
            
            <div class=table_scroll style="width:80%; margin-left:15%;"><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%;" cellpadding="0" cellspacing="0" id=prize_table>
         <thead>
            <tr>
                <td><?php echo self::$language['ordinal']?></td>
                <td><?php echo self::$language['prize']?><?php echo self::$language['name']?></td>
                <td><?php echo self::$language['prize']?><?php echo self::$language['type']?></td>
                <td><?php echo self::$language['rate']?></td>
                <td><?php echo self::$language['prize']?><?php echo self::$language['quantity']?></td>
                <td><?php echo self::$language['day_max']?></td>
                <td><?php echo self::$language['today_won']?></td>
                <td><?php echo self::$language['won_sum']?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['prize'];?>

            
        </tbody>
    </table></div>
       <div class=line_div><span class=m_label>&nbsp;</span><span class=input><a href=# class=submit><?php echo self::$language['submit'];?></a><span id=submit_state class=state></span></span></div>

        </div>
       
       
    
    </div>
</div>

