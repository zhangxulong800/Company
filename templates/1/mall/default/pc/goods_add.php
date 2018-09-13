<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script src="./plugin/datePicker/index.php"></script>
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=detail&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script charset="utf-8" src="editor/create.php?editor=m_dtail_editor&id=m_detail&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
	function set_goods_value(v){
		
		if(v.name && $("#<?php echo $module['module_name'];?> #title").val()==''){$("#<?php echo $module['module_name'];?> #title").val(v.name);}
		if(v.sold_price && $("#<?php echo $module['module_name'];?> #w_price").val()==''){$("#<?php echo $module['module_name'];?> #w_price").val(v.sold_price);}
		if(v.sold_price && $("#<?php echo $module['module_name'];?> #e_price").val()==''){$("#<?php echo $module['module_name'];?> #e_price").val(v.sold_price);}
		if(v.cost_price && $("#<?php echo $module['module_name'];?> #cost_price").val()==''){$("#<?php echo $module['module_name'];?> #cost_price").val(v.cost_price);}
		
		if(v.sold_price){
			$("#<?php echo $module['module_name'];?> .e_price").each(function(index, element) {
				if($(this).val()==''){$(this).val(v.sold_price);}
			});
			$("#<?php echo $module['module_name'];?> .w_price").each(function(index, element) {
				if($(this).val()==''){$(this).val(v.sold_price);}
			});
		}
		if(v.cost_price){
			$("#<?php echo $module['module_name'];?> .cost_price").each(function(index, element) {
				if($(this).val()==''){$(this).val(v.cost_price);}
			});
		}
		
		if(v.unit  && $("#<?php echo $module['module_name'];?> #unit").val()){$("#<?php echo $module['module_name'];?> #unit").next().val(v.unit).css('display','inline-block');$("#<?php echo $module['module_name'];?> #unit").css('display','none');}
		if(v.spec){
			$("#<?php echo $module['module_name'];?> #detail").val(v.spec);
			$("#<?php echo $module['module_name'];?> #detail").change();
		}
		if(v.location){
			$("#<?php echo $module['module_name'];?> #detail").val($("#<?php echo $module['module_name'];?> #detail").val()+v.location);
			$("#<?php echo $module['module_name'];?> #detail").change();
		}
		if(v.cover_image_show){
			$("#<?php echo $module['module_name'];?> #cover_image_show").html('<img src="'+v.cover_image_show+'" />');	
			$("#<?php echo $module['module_name'];?> #icon").val(v.icon);	
		}
		if(v.multi_angle_img){
			temp=v.multi_angle_img_show;
			temp=temp.split(',');
			str='';
			for(i in temp){
				if(temp[i]==''){continue;}
				str+='<div><img src="'+temp[i]+'"><br><a href="#" class="move_to_left">&nbsp;</a><a href="#" class="move_to_right">&nbsp;</a><a href="#" class="delete_me">&nbsp;</a></div>';	
			}
			$("#<?php echo $module['module_name'];?> #multi_angle_img_show").html(str);	
			$("#<?php echo $module['module_name'];?> #multi_angle_img").val(v.multi_angle_img);	
		}
		if(v.detail){
			editor.html(v.detail);
		}
		if(v.m_detail){
			m_dtail_editor.html(v.m_detail);
		}
		if(v.logistics_weight){$("#<?php echo $module['module_name'];?> #logistics_weight").val(v.logistics_weight);}
		if(v.logistics_volume){$("#<?php echo $module['module_name'];?> #logistics_volume").val(v.logistics_volume);}
		if(v.shelf_life){$("#<?php echo $module['module_name'];?> #shelf_life").val(v.shelf_life);}
	}
	
	function get_goods_info(){
		if($("#<?php echo $module['module_name'];?> #title").val()!=''){return false;}
		$("#<?php echo $module['module_name'];?> #bar_code").next().html('<span class=\'fa fa-spinner fa-spin\'></span><?php echo self::$language['get_goods_info_ing']?>');		
		$.post("<?php echo $module['action_url'];?>&act=get_goods_info",{barcode:$("#<?php echo $module['module_name'];?> #bar_code").val()},function(data){
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			if(v.state=='fail'){$("#<?php echo $module['module_name'];?> #bar_code").next().html('<span class=fail>'+v.info+'</span>');}
			
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> #bar_code").next().html('<span class=success>'+v.info+'</span>');
				set_goods_value(v);
			}
		
		});		
	}
	
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .quick_set a").click(function(){
			if($(this).attr('class')=='email_msg'){
				$("#<?php echo $module['module_name'];?> #virtual_auto_delivery").html('<?php echo self::$language['virtual_auto_delivery_email']?>');
				$("#<?php echo $module['module_name'];?> #virtual_auto_delivery").val('<?php echo self::$language['virtual_auto_delivery_email']?>');
			}else{
				$("#<?php echo $module['module_name'];?> #virtual_auto_delivery").html('<?php echo self::$language['virtual_auto_delivery_http']?>');
				$("#<?php echo $module['module_name'];?> #virtual_auto_delivery").val('<?php echo self::$language['virtual_auto_delivery_http']?>');
			}
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .new_option").click(function(){
			if($(this).next().css('display')=='none'){
				$(this).next().css('display','inline-block');
			}else{
				$(this).next().css('display','none');
			}
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .new_option_div .add").click(function(){
			if($("#<?php echo $module['module_name'];?> .new_option_div .new_name").val()==''){return false;}
			
			$("#<?php echo $module['module_name'];?> .new_option_div .state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
			$.post("<?php echo $module['action_url'];?>&act=add_option&type="+$(this).attr('type')+"&new_name="+$("#<?php echo $module['module_name'];?> .new_option_div .new_name").val(),function(data){
				//alert(data);
				try{json=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .new_option_div .state").html(json.info);
				if(json.state=='success'){
					name=$("#<?php echo $module['module_name'];?> .new_option_div .new_name").val();
					$("#<?php echo $module['module_name'];?> .new_option").before('<span class="option_span"><input type="checkbox" id="option_'+json.id+'" class="input_checkbox"><m_label for="option_'+json.id+'">'+$("#<?php echo $module['module_name'];?> .new_option_div .new_name").val()+'</m_label></span>');
					$("#<?php echo $module['module_name'];?> .new_option_div .new_name").prop('value','');
					option_html='';
					if($("#<?php echo $module['module_name'];?> #color_div").html()){
						$("#<?php echo $module['module_name'];?> #color_div .color_span").each(function(index, element) {
                            option_html+='<tr class='+$(this).children('input').attr('id')+' id=specifications_'+$(this).children('input').attr('id')+'__option_'+json.id+'><td>'+$(this).children('m_label').html()+'</td><td>'+name+'</td><td><input type=text class=quantity /></td><td><input type=text class=cost_price /></td><td><input type=text class=e_price /></td><td><input type=text class=w_price /></td><td><input type=text class=bar_code  maxlength="13" /><img class=s_bar_code_img /></td><td><input type=text class=store_code  maxlength="13" /><img class=s_store_code_img /></td><td><a href=# class=del><?php echo self::$language['del']?></a><a href=# class=batch_write><?php echo self::$language['batch_write']?></a> <span class=state>&nbsp;</span></td></tr>';
                        });
						
					}else{
						option_html+='<tr id=specifications_option_'+json.id+'><td>'+name+'</td><td><input type=text class=quantity /></td><td><input type=text class=cost_price /></td><td><input type=text class=e_price /></td><td><input type=text class=w_price /></td><td><input type=text class=bar_code  maxlength="13" /><img class=s_bar_code_img /></td><td><input type=text class=store_code  maxlength="13" /><img class=s_store_code_img /></td><td><a href=# class=del><?php echo self::$language['del']?></a><a href=# class=batch_write><?php echo self::$language['batch_write']?></a> <span class=state>&nbsp;</span></td></tr>';
					}
					$("#<?php echo $module['module_name'];?> #option_table tr:last").after(option_html);
				}
			
			});	
			
			return false;	
		});
		
		
		
		$("#<?php echo $module['module_name'];?> #title").change(function(){
			if($(this).val()!=''){
				$("#<?php echo $module['module_name'];?> .search_same").css('display','inline-block');
				$("#<?php echo $module['module_name'];?> .search_same").attr('href',$("#<?php echo $module['module_name'];?> .search_same").attr('href_pre')+$(this).val());	
			}else{
				$("#<?php echo $module['module_name'];?> .search_same").css('display','none');
			}
		});
		
		//$("#detail").val('xxx');
		//editor.html("#detail",'xxx');
		$("[monxin_value]").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
		
		$("#limit").change(function(){
			if($(this).val()!=0){
				$("[d=buy_limit]").css('display','block');
			}else{
				$("[d=buy_limit]").css('display','none');
			}
		});
		
		$("#goods_state").change(function(){
			$("[d]").css('display','none');
			$("[d=goods_state_"+$(this).val()+"]").css('display','block');
				
		});
		
		$('[device_tabs] a').click(function(){
			$(".detail_div").css('display','none');
			$(".m_detail_div").css('display','none');
			$("."+$(this).attr('target')).css('display','block');
			$('[device_tabs] li').removeClass('active');
			$(this).parent().addClass('active');
			return false;	
		});
		
		$(".fast_move .fast_move_switch").click(function(){
			//alert($(".fast_move").parent().width());
			if($(".fast_move").width()<150){
				$(".fast_move").animate({width:500,height:180},'fast');
				$(".fast_move").css('background-color','#CCC');
			}else{
				$(".fast_move").animate({width:150,height:50},'fast',function(){$(".fast_move").css('background','none');});
				
			}
			return false;
		});
		
		$(".fast_move .agreement").click(function(){
			if($(".fast_move .move_url").val()==''){
				$(".fast_move .state").html('<span class=fail><?php echo self::$language['please_input']?></span>');
				$(".fast_move .move_url").focus();
				return false;	
			}
			$(".fast_move .state").html('<span class=\'fa fa-spinner fa-spin\'> </span>');
			$.post("<?php echo $module['action_url'];?>&act=goods_move",{move_url:$(".fast_move .move_url").val()},function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$(".fast_move .state").html(v.info);
				if(v.state=='success'){
					$(".fast_move").animate({width:150,height:30},'fast',function(){$(".fast_move").css('background','none');});
					set_goods_value(v);
				}
				
			});	
					
			return false;	
		});
		
		$(document).on("click","#multi_angle_img_show .delete_me",function(){
			img_path=$(this).parent().children('img').attr('src');
			$(this).parent().remove();
			multi_angle_img_val_reset()
			return false;	
		});
		$(document).on("click","#multi_angle_img_show .move_to_left",function(){
			a=$(this).parent();
			b=a.prev();
			a.insertBefore(b);
			multi_angle_img_val_reset()
			return false;	
		});
		$(document).on("click","#multi_angle_img_show .move_to_right",function(){
			a=$(this).parent();
			b=a.next();
			a.insertAfter(b);
			multi_angle_img_val_reset()
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> #bar_code").focus();
		$("#<?php echo $module['module_name'];?> #bar_code").blur(function(){
			if($.isNumeric($(this).val())){
				$("#<?php echo $module['module_name'];?> .bar_code_img").attr('src','./plugin/barcode/buildcode.php?codebar=BCGcode128&text='+$(this).val());
				if(($(this).val().length==8  || $(this).val().length==13 )){
					 get_goods_info();
				}	
			}	
		});
		$("#<?php echo $module['module_name'];?> #bar_code").keyup(function(){
			if(event.keyCode==13 && $.isNumeric($(this).val()) && ($(this).val().length==8  || $(this).val().length==13 )){
				 get_goods_info();
			}	
		});
		$("#<?php echo $module['module_name'];?> .attribute_switch").click(function(){
			id=$(this).parent().parent().attr('id');
			if($("#<?php echo $module['module_name'];?> #"+id+"_input").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> #"+id+"_input").css('display','inline-block');
				$("#<?php echo $module['module_name'];?> #"+id+"_select").css('display','none');
			}else{
				$("#<?php echo $module['module_name'];?> #"+id+"_input").css('display','none');
				$("#<?php echo $module['module_name'];?> #"+id+"_select").css('display','inline-block');
			}
			
			if(''=='<?php echo @$_POST['option_option']?>'){
					
			}
			
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .switch_input").click(function(){
			id=$(this).prev().prev().prev().attr('id');
			if($("#<?php echo $module['module_name'];?> #"+id).css('display')=='none'){
				$("#<?php echo $module['module_name'];?> #"+id).css('display','inline-block');
				$("#<?php echo $module['module_name'];?> #"+id).next().css('display','none');
			}else{
				$("#<?php echo $module['module_name'];?> #"+id).css('display','none');
				$("#<?php echo $module['module_name'];?> #"+id).next().css('display','inline-block');
			}
			
			if(''=='<?php echo @$_POST['option_option']?>'){
					
			}
			
			return false;	
		});
		
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .del_color_img",function(){
			$(this).prev('img').css('display','none');	
			$(this).css('display','none');	
			$("#<?php echo $module['module_name'];?> #"+$(this).attr('input_id').replace(/_td/,'')).val('');
			return false;
		});		
		$('#icon_ele').insertBefore($('#icon_state'));
		$('#multi_angle_img_ele').insertBefore($('#multi_angle_img_state'));
		if(''=='<?php echo @$_POST['option_type'];?>'){
			$("#option_line").css('display','none');
			$("#no_specifications").css('display','block');
		}else{
			<?php echo $module['move_color_input'];?>
			option_html='';
		
			if(''!='<?php echo @$_POST['option_color']?>'){
				if(''=='<?php echo @$_POST['option_option']?>'){
					$("#<?php echo $module['module_name'];?> #color_div .color_span").each(function(index, element) {
						t_id=$(this).children('input').attr('id');
						t_name=$(this).children('m_label').children('span').html();
						option_html+='<tr class='+t_id+' id=specifications_'+t_id+'><td>'+$(this).children('m_label').html()+'</td><td><input type=text class=quantity /></td><td><input type=text class=cost_price /></td><td><input type=text class=e_price /></td><td><input type=text class=w_price /></td><td><input type=text class=bar_code maxlength="13" /><img class=s_bar_code_img /></td><td><input type=text class=store_code  maxlength="13" /><img class=s_store_code_img /></td><td class=op_td><a href=# class=del><?php echo self::$language['del']?></a><a href=# class=batch_write><?php echo self::$language['batch_write']?></a><span class=state>&nbsp;</span></td></tr>';
					});
						
				}else{
					$("#<?php echo $module['module_name'];?> #color_div .color_span").each(function(index, element) {
						t_id=$(this).children('input').attr('id');
						t_color_td=$(this).children('m_label').html();
						$("#<?php echo $module['module_name'];?> #option_option_div .option_span").each(function(index, element) {
							o_id=$(this).children('input').attr('id');
							option_html+='<tr class='+t_id+' id=specifications_'+t_id+'__'+o_id+'><td>'+t_color_td+'</td><td>'+$(this).children('m_label').html()+'</td><td><input type=text class=quantity /></td><td><input type=text class=cost_price /></td><td><input type=text class=e_price /></td><td><input type=text class=w_price /></td><td><input type=text class=bar_code maxlength="13" /><img class=s_bar_code_img /></td><td><input type=text class=store_code  maxlength="13" /><img class=s_store_code_img /></td><td class=op_td><a href=# class=del><?php echo self::$language['del']?></a><a href=# class=batch_write><?php echo self::$language['batch_write']?></a><span class=state>&nbsp;</span></td></tr>';
							
						});
					});
				}
				
			}else{
				$("#color_info_table").css('display','none');
				$("#<?php echo $module['module_name'];?> #option_option_div .option_span").each(function(index, element) {
					o_id=$(this).children('input').attr('id');
					option_html+='<tr id=specifications_'+o_id+'><td>'+$(this).children('m_label').html()+'</td><td><input type=text class=quantity /></td><td><input type=text class=cost_price /></td><td><input type=text class=e_price /></td><td><input type=text class=w_price /></td><td><input type=text class=bar_code maxlength="13" /><img class=s_bar_code_img /></td><td><input type=text class=store_code  maxlength="13" /><img class=s_store_code_img /></td><td class=op_td><a href=# class=del><?php echo self::$language['del']?></a><a href=# class=batch_write><?php echo self::$language['batch_write']?></a><span class=state>&nbsp;</span></td></tr>';
					
				});
			}
		
			
			$("#<?php echo $module['module_name'];?> #option_table tbody").html(option_html);
		
			
			$(".color_span input").change(function(){
				if($(this).prop('checked')){
					$("#tr_"+$(this).attr('id')).css('display','table-row');
				}else{
					$("#tr_"+$(this).attr('id')).css('display','none');
				}
				if(''=='<?php echo @$_POST['option_option']?>'){
					$("#specifications_"+$(this).attr('id')).css('display',$("#tr_"+$(this).attr('id')).css('display'));
				}else{
					t_id=$(this).attr('id');
					$("#<?php echo $module['module_name'];?> #option_option_div .option_span").each(function(index, element) {
						o_id=$(this).children('input').attr('id');
						if($("#"+o_id).prop('checked')){
							$("#specifications_"+t_id+'__'+o_id).css('display',$("#tr_"+t_id).css('display'));
						}
						
					});
				}	
			});
			
			$(document).on('change',"#<?php echo $module['module_name'];?> #option_option_div .option_span input",function(){
				if($(this).prop('checked')){
					if(''=='<?php echo @$_POST['option_color']?>'){
						$("#specifications_"+$(this).attr('id')).css('display','table-row');
					}else{
						o_id=$(this).attr('id');
						$("#<?php echo $module['module_name'];?> #color_div .color_span").each(function(index, element) {
							t_id=$(this).children('input').attr('id');
							//alert(t_id);
							if($("#"+t_id).prop('checked')){
								$("#specifications_"+t_id+'__'+o_id).css('display','table-row');
							}
						});
					}	
				}else{
					if(''=='<?php echo @$_POST['option_color']?>'){
						$("#specifications_"+$(this).attr('id')).css('display','none');
					}else{
						o_id=$(this).attr('id');
						$("#<?php echo $module['module_name'];?> #color_div .color_span").each(function(index, element) {
							t_id=$(this).children('input').attr('id');
							if($("#"+t_id).prop('checked')){
								$("#specifications_"+t_id+'__'+o_id).css('display','none');
							}
						});
					}	
				}	
			});
			
			
		
				
		}
		if($("#attribute_div").html().length<20){$("#attribute_line").css('display','none');}
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			goods_submit();
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> input").keydown(function(event){
			if(event.keyCode==13){
				if(event.target.className=='barcode' || event.target.className=='bar_code'){return false;}
				return goods_submit();
			}		  	
		});
		$("#option_table .del").click(function(){
			$(this).parent().parent().css('display','none');
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> #option_table .bar_code").blur(function(){
            if($(this).val()!=''){
				$(this).next().css('width','80px').css('margin-left','10px').attr('src','./plugin/barcode/buildcode.php?codebar=BCGcode128&text='+$(this).val());
			}
		});
		
		$(document).on('click',"#<?php echo $module['module_name'];?> .batch_write",function(){
			this_id=$(this).parent().parent().attr('id');
			find_this=false;
			//alert(this_id);
			$("#<?php echo $module['module_name'];?> #option_table tbody tr").each(function(index, element) {
               if($(this).attr('id')==this_id){find_this=true;} 
			   if(find_this){
				   if($("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .quantity").val()==''){$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .quantity").val($("#<?php echo $module['module_name'];?> #"+this_id+" .quantity").val());}
					if($("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .cost_price").val()==''){$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .cost_price").val($("#<?php echo $module['module_name'];?> #"+this_id+" .cost_price").val());}
					if($("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .e_price").val()==''){$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .e_price").val($("#<?php echo $module['module_name'];?> #"+this_id+" .e_price").val());}
					if($("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .w_price").val()==''){$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .w_price").val($("#<?php echo $module['module_name'];?> #"+this_id+" .w_price").val());}
					if($("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .bar_code").val()==''){$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .bar_code").val($("#<?php echo $module['module_name'];?> #"+this_id+" .bar_code").val());}
					if($("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .store_code").val()==''){$("#<?php echo $module['module_name'];?> #"+$(this).attr('id')+" .store_code").val($("#<?php echo $module['module_name'];?> #"+this_id+" .store_code").val());}
					
			   }
            });
			return false;	
		});
		$("#<?php echo $module['module_name'];?> input[class='color_name']").keyup(function(){
			id=$(this).attr('id').replace(/color_name_/,'');
            $("#<?php echo $module['module_name'];?> .color_"+id+" .color_name").html($(this).val());
        });


		
    });
    
    
    function goods_submit(){
        //表单输入值检测... 如果非法则返回 false
		editor.sync();
		m_dtail_editor.sync();
		$("#<?php echo $module['module_name'];?>_html .state").html('');
		
		if($("#<?php echo $module['module_name'];?> #unit").css('display')!='none'){
			var j_unit=$("#<?php echo $module['module_name'];?> #unit");
       		if(j_unit.prop('value')==-1){j_unit.next().next().html('<span class=fail><?php echo self::$language['please_select']?></span> ');j_unit.focus();return false;}
		}else{
			var j_unit=$("#<?php echo $module['module_name'];?> #unit").next();
        	if(j_unit.prop('value')==''){j_unit.next().html('<span class=fail><?php echo self::$language['please_input']?></span> ');j_unit.focus();return false;}
		}
		
        var title=$("#<?php echo $module['module_name'];?> #title");
        if(title.prop('value')==''){title.next().html('<span class=fail><?php echo self::$language['please_input']?></span>');title.focus();return false;}
		
		
		
        var icon=$("#<?php echo $module['module_name'];?> #icon");
        if(icon.prop('value')==''){$("#icon_ele").next().html('<span class=fail><?php echo self::$language['please_upload']?></span>');$("#icon_file").focus();return false;}
		var tag_v='';
		$("#<?php echo $module['module_name'];?> .tag").each(function(index, element) {
            if($(this).prop('checked')){tag_v+=$(this).prop('value')+'|';}
        });
		if(tag_v!=''){tag_v='|'+tag_v;}
		$("#<?php echo $module['module_name'];?> #tag").val(tag_v);
		if($("#attribute_line").css('display')=='none_stop'){
			is_null=false;
			$("#<?php echo $module['module_name'];?> .attribute_sub_div").each(function(index, element) {
                if($(this).children('.a_input').children('input').css('display')!='none'  && $(this).children('.a_input').children('input').val()==''){
					$(this).children('.a_input').children('.state').html('<span class=fail><?php echo self::$language['please_input']?></span>');$(this).children('.a_input').children('input').focus();is_null=true;return false;
				}
                if($(this).children('.a_input').children('select').css('display')!='none'  && $(this).children('.a_input').children('select').val()==-1){
					$(this).children('.a_input').children('.state').html('<span class=fail><?php echo self::$language['please_select']?></span>');$(this).children('.a_input').children('select').focus();is_null=true;return false;
				}
				
            });	
			if(is_null){return false;}
		}
		var obj=new Object();
	
		obj['attribute']=new Object();
		$("#<?php echo $module['module_name'];?> #attribute_div .attribute_sub_div").each(function(index, element) {
			a_id=$(this).attr('id');
			if($(this).children('.a_input').children('input').css('display')!='none'){
				obj['attribute'][a_id+'___value']=$(this).children('.a_input').children('input').val();
			}else{
				obj['attribute'][a_id+'___value']=$(this).children('.a_input').children('select').val();
			}				
		});
	
		if(''=='<?php echo @$_POST['option_type'];?>'){
		  var w_price=$("#<?php echo $module['module_name'];?> #w_price");
		  if(w_price.prop('value')==''){w_price.next().html('<span class=fail><?php echo self::$language['please_input']?></span>');w_price.focus();return false;}
		  var e_price=$("#<?php echo $module['module_name'];?> #e_price");
		  if(e_price.prop('value')==''){e_price.next().html('<span class=fail><?php echo self::$language['please_input']?></span>');e_price.focus();return false;}
		  var cost_price=$("#<?php echo $module['module_name'];?> #cost_price");
		  if(cost_price.prop('value')==''){cost_price.next().html('<span class=fail><?php echo self::$language['please_input']?></span>');cost_price.focus();return false;}
		  var inventory=$("#<?php echo $module['module_name'];?> #inventory");
		  if(inventory.prop('value')==''){inventory.next().html('<span class=fail><?php echo self::$language['please_input']?></span>');inventory.focus();return false;}
			obj['option_type']=0;	
			obj['bar_code']=$("#<?php echo $module['module_name'];?> #bar_code").val();	
			obj['store_code']=$("#<?php echo $module['module_name'];?> #store_code").val();	
			obj['w_price']=$("#<?php echo $module['module_name'];?> #w_price").val();	
			obj['e_price']=$("#<?php echo $module['module_name'];?> #e_price").val();	
			obj['cost_price']=$("#<?php echo $module['module_name'];?> #cost_price").val();	
			obj['inventory']=$("#<?php echo $module['module_name'];?> #inventory").val();	
			obj['virtual_auto_delivery']=$("#<?php echo $module['module_name'];?> #virtual_auto_delivery").val();	
		  if(!$.isNumeric(obj['bar_code']) && obj['bar_code']!=''){$("#<?php echo $module['module_name'];?> #bar_code").next().html('<span class=fail><?php echo self::$language['must_be']?><?php echo self::$language['number']?></span>');$("#<?php echo $module['module_name'];?> #bar_code").focus();return false;}
		}else{
			obj['option_type']='<?php echo @$_POST['option_type'];?>';	
			var sum=0;
			is_null=false;
			$("#<?php echo $module['module_name'];?> #option_table tbody tr").each(function(index, element) {
                //alert($(this).css('display'));
				if($(this).css('display')!='none'){
					sum++;
					if($(this).children('td').children('.quantity').val()==''){
						$(this).children('td').children('.state').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['quantity'];?></span>');
						$(this).children('td').children('.quantity').focus();
						
						is_null=true;
						return false;	
					}
					if($(this).children('td').children('.e_price').val()==''){
						$(this).children('td').children('.state').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['e_price'];?></span>');
						$(this).children('td').children('.e_price').focus();
						
						is_null=true;
						return false;	
					}
					if($(this).children('td').children('.w_price').val()==''){
						$(this).children('td').children('.state').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['w_price'];?></span>');
						$(this).children('td').children('.w_price').focus();
						
						is_null=true;
						return false;	
					}
					if($(this).children('td').children('.cost_price').val()==''){
						$(this).children('td').children('.state').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['cost_price'];?></span>');
						$(this).children('td').children('.cost_price').focus();
						
						is_null=true;
						return false;	
					}
				}
            });
			if(is_null){return false;}
			if(sum==0){$("#specifications_state").html('<span class=fail><?php echo self::$language['please_select']?><?php echo self::$language['option'];?></span> ');return false;}
			
			
			if(1=='<?php echo @$_POST['option_color'];?>' && 1=='<?php echo @$_POST['option_option'];?>'){
				
			}else{
				if(1=='<?php echo @$_POST['option_color'];?>'){
					
				}else{
						
				}
					
			}
			
			if(1=='<?php echo @$_POST['option_color'];?>'){
				obj['color_info']=new Object();
				$("#<?php echo $module['module_name'];?> #color_info_table tbody tr").each(function(index, element) {
            		if($(this).css('display')!='none'){
						 obj['color_info'][$(this).attr('id')]='name==='+$(this).children('td').children('.color_name').val()+',,,img==='+$("#color_img_"+$(this).attr('id').replace(/tr_color_/,'')).val();  
					} 
                });
			}
			
			
			obj['specifications']=new Object();
			$("#<?php echo $module['module_name'];?> #option_table tbody tr").each(function(index, element) {
				if($(this).css('display')!='none'){
					//alert($(this).attr('id'));
					obj['specifications'][$(this).attr('id')]='quantity==='+$(this).children('td').children('.quantity').val()+',,,cost_price==='+$(this).children('td').children('.cost_price').val()+',,,e_price==='+$(this).children('td').children('.e_price').val()+',,,w_price==='+$(this).children('td').children('.w_price').val()+',,,barcode==='+$(this).children('td').children('.bar_code').val()+',,,store_code==='+$(this).children('td').children('.store_code').val();
				}
            });
			
		}	
		
		obj['type']='<?php echo $_GET['type']?>';	
		
		if($("#<?php echo $module['module_name'];?> #shop_type").css('display')!='none'){
			obj['shop_type']=$("#<?php echo $module['module_name'];?> #shop_type").val();	
		}else{
			obj['shop_type']=$("#<?php echo $module['module_name'];?> #shop_type").next().val();
		}

		if($("#<?php echo $module['module_name'];?> #brand").css('display')!='none'){
			obj['brand']=$("#<?php echo $module['module_name'];?> #brand").val();	
		}else{
			obj['brand']=$("#<?php echo $module['module_name'];?> #brand").next().val();
		}

		if($("#<?php echo $module['module_name'];?> #position").css('display')!='none'){
			obj['position']=$("#<?php echo $module['module_name'];?> #position").val();	
		}else{
			obj['position']=$("#<?php echo $module['module_name'];?> #position").next().val();
		}

		if($("#<?php echo $module['module_name'];?> #storehouse").css('display')!='none'){
			obj['storehouse']=$("#<?php echo $module['module_name'];?> #storehouse").val();	
		}else{
			obj['storehouse']=$("#<?php echo $module['module_name'];?> #storehouse").next().val();
		}
		

		if($("#<?php echo $module['module_name'];?> #supplier").css('display')!='none'){
			obj['supplier']=$("#<?php echo $module['module_name'];?> #supplier").val();	
		}else{
			obj['supplier']=$("#<?php echo $module['module_name'];?> #supplier").next().val();	
		}
		if($("#<?php echo $module['module_name'];?> #unit").css('display')!='none'){
			obj['unit']=$("#<?php echo $module['module_name'];?> #unit").val();	
		}else{
			obj['unit']=$("#<?php echo $module['module_name'];?> #unit").next().val();	
		}
		if($("#<?php echo $module['module_name'];?> #grade").css('display')!='none'){
			obj['grade']=$("#<?php echo $module['module_name'];?> #grade").val();	
		}else{
			obj['grade']=$("#<?php echo $module['module_name'];?> #grade").next().val();	
		}
		if($("#<?php echo $module['module_name'];?> #habitat").css('display')!='none'){
			obj['habitat']=$("#<?php echo $module['module_name'];?> #habitat").val();	
		}else{
			obj['habitat']=$("#<?php echo $module['module_name'];?> #habitat").next().val();	
		}
		if($("#<?php echo $module['module_name'];?> #contain").css('display')!='none'){
			obj['contain']=$("#<?php echo $module['module_name'];?> #contain").val();	
		}else{
			obj['contain']=$("#<?php echo $module['module_name'];?> #contain").next().val();	
		}
		obj['title']=$("#<?php echo $module['module_name'];?> #title").val();	
		obj['advantage']=$("#<?php echo $module['module_name'];?> #advantage").val();	
		obj['tag']=$("#<?php echo $module['module_name'];?> #tag").val();	
		obj['icon']=$("#<?php echo $module['module_name'];?> #icon").val();	
		obj['multi_angle_img']=$("#<?php echo $module['module_name'];?> #multi_angle_img").val();	
		obj['free_shipping']=$("#<?php echo $module['module_name'];?> #free_shipping").val();
		obj['goods_type']=$("#<?php echo $module['module_name'];?> #goods_type").val();
		obj['only_integral']=$("#<?php echo $module['module_name'];?> #only_integral").val();
		obj['sales_promotion']=$("#<?php echo $module['module_name'];?> #sales_promotion").val();	
		obj['logistics_weight']=$("#<?php echo $module['module_name'];?> #logistics_weight").val();	
		obj['logistics_volume']=$("#<?php echo $module['module_name'];?> #logistics_volume").val();	
		obj['detail']=$("#<?php echo $module['module_name'];?> #detail").val();	
		obj['m_detail']=$("#<?php echo $module['module_name'];?> #m_detail").val();	
		obj['virtual_auto_delivery']=$("#<?php echo $module['module_name'];?> #virtual_auto_delivery").val();	
		obj['shelf_life']=$("#<?php echo $module['module_name'];?> #shelf_life").val();	
		obj['goods_state']=$("#<?php echo $module['module_name'];?> #goods_state").val();
		obj['limit']=$("#<?php echo $module['module_name'];?> #limit").val();	
		obj['limit_cycle']=$("#<?php echo $module['module_name'];?> #limit_cycle").val();
		
		if(obj['goods_state']==1){
			if($("#<?php echo $module['module_name'];?> #pre_discount").val()==''){
				$("#<?php echo $module['module_name'];?> #pre_discount").next().html('<span class=fail><?php echo self::$language['please_input']?></span>');$("#<?php echo $module['module_name'];?> #pre_discount").focus();return false;	
			}
			if($("#<?php echo $module['module_name'];?> #deposit").val()==''){
				$("#<?php echo $module['module_name'];?> #deposit").next().html('<span class=fail><?php echo self::$language['please_input']?></span>');$("#<?php echo $module['module_name'];?> #deposit").focus();return false;	
			}
			if($("#<?php echo $module['module_name'];?> #reduction").val()==''){
				$("#<?php echo $module['module_name'];?> #reduction").next().html('<span class=fail><?php echo self::$language['please_input']?></span>');$("#<?php echo $module['module_name'];?> #reduction").focus();return false;	
			}
			if($("#<?php echo $module['module_name'];?> #last_pay_start_time").val()==''){
				$("#<?php echo $module['module_name'];?> #last_pay_start_time").next().html('<span class=fail><?php echo self::$language['please_input']?></span>');$("#<?php echo $module['module_name'];?> #last_pay_start_time").focus();return false;	
			}
			if($("#<?php echo $module['module_name'];?> #last_pay_end_time").val()==''){
				$("#<?php echo $module['module_name'];?> #last_pay_end_time").next().html('<span class=fail><?php echo self::$language['please_input']?></span>');$("#<?php echo $module['module_name'];?> #last_pay_end_time").focus();return false;	
			}
			if($("#<?php echo $module['module_name'];?> #delivered").val()==''){
				$("#<?php echo $module['module_name'];?> #delivered").next().html('<span class=fail><?php echo self::$language['please_input']?></span>');$("#<?php echo $module['module_name'];?> #delivered").focus();return false;	
			}
			
			obj['pre_discount']=$("#<?php echo $module['module_name'];?> #pre_discount").val();
			obj['deposit']=$("#<?php echo $module['module_name'];?> #deposit").val();
			obj['reduction']=$("#<?php echo $module['module_name'];?> #reduction").val();
			obj['last_pay_start_time']=$("#<?php echo $module['module_name'];?> #last_pay_start_time").val();
			obj['last_pay_end_time']=$("#<?php echo $module['module_name'];?> #last_pay_end_time").val();
			obj['delivered']=$("#<?php echo $module['module_name'];?> #delivered").val();
			
			
			
		}
			
		if(obj['goods_state']==3){
			if($("#<?php echo $module['module_name'];?> #out_delivered").val()==''){
				$("#<?php echo $module['module_name'];?> #out_delivered").next().html('<span class=fail><?php echo self::$language['please_input']?></span>');$("#<?php echo $module['module_name'];?> #out_delivered").focus();return false;	
			}
			obj['out_delivered']=$("#<?php echo $module['module_name'];?> #out_delivered").val();
		}
			
		//return false;
		
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
		
        
		
        
		
        $.post("<?php echo $module['action_url'];?>&act=add",obj,function(data){
			//alert(data);
            try{json=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#<?php echo $module['module_name'];?> #submit_state").html(json.info);
			if(json.state=='fail'){
				if(json.id){
					$("#<?php echo $module['module_name'];?> #"+json.id).next().html(json.info);$("#<?php echo $module['module_name'];?> #"+json.id).focus();
					$("#<?php echo $module['module_name'];?> #submit_state").html('<span class=fail><?php echo self::$language['fail'];?></span>');
				}	
			}
        
        });	
        	
		
		
		
		return false;
        }
        	
	function submit_hidden(id){
		v=$("#"+id).val();
		if(id=='icon'){
			$("#cover_image_show").html('<img src="./temp/'+v+'" />');	
		}else if(id=='multi_angle_img'){
			$("#multi_angle_img_fieldset_succeedList").css('display','none');
			temp=v.split('|');
			temp_html='';
			for(i in temp){
				if(temp[i]!=''){
					temp_html+='<div><img src="./temp/'+temp[i]+'" /><br /><a href=# class=move_to_left>&nbsp;</a><a href=# class=move_to_right>&nbsp;</a><a href=# class=delete_me>&nbsp;</a></div>';	
				}
			}
			$("#multi_angle_img_show").html(temp_html);
		}else{
			$("#"+id+'_td').html('<img src="./temp/'+$("#"+id).val()+'" class=color_img_thumb /> <a href=# class=del_color_img input_id='+id+' title="<?php echo self::$language['del'];?><?php echo self::$language['image'];?>">&nbsp;</a>');
			$("#"+id+'_span').html('');
		}	
	}
	
	function multi_angle_img_val_reset(){
		temp='';
		$("#multi_angle_img_show div").each(function(index, element) {
            temp+='|'+$(this).children('img').attr('src').replace(/\.\/temp/,'');
        });	
		$("#multi_angle_img").val(temp);
	}
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
    #<?php echo $module['module_name'];?>_html #html4_up_file{ border:none;}
    #<?php echo $module['module_name'];?> .line_div{ line-height:50px;}
    #<?php echo $module['module_name'];?> .line_div .m_label{ display:inline-block; vertical-align:top; width:18%; text-align:right; padding-right:5px; white-space:nowrap; }
    #<?php echo $module['module_name'];?> .line_div .input_span{ display:inline-block; width:80%;}
    #<?php echo $module['module_name'];?> .line_div .input_span #bar_code{ vertical-align:top; margin-top:10px; }
    #<?php echo $module['module_name'];?> .line_div .input_span #title{ width:80%;}
    #<?php echo $module['module_name'];?> .line_div .input_span #advantage{ width:80%;}
    #<?php echo $module['module_name'];?> .line_div #attribute_div{border: #ddd solid 1px;  box-shadow:1px 1px 2px 0px rgba(0,0,0,.2);}
    #<?php echo $module['module_name'];?> .line_div #attribute_div .attribute_sub_div{ display:inline-block; vertical-align:top; width:45%; overflow:hidden; white-space:nowrap;}

    #<?php echo $module['module_name'];?> .line_div #attribute_div .attribute_sub_div .a_label{ display:inline-block; vertical-align:top;  width:150px; text-align:right; padding-right:5px; overflow:hidden;}
    #<?php echo $module['module_name'];?> .line_div #attribute_div .attribute_sub_div .a_input{ display:inline-block; width:300px; overflow:hidden; vertical-align:top; }
	#<?php echo $module['module_name'];?>  .a_input select{ display:inline-block; width:70% !important;}
	#<?php echo $module['module_name'];?>  .a_input input{ display:inline-block; width:70% !important;}
    #<?php echo $module['module_name'];?> .line_div #option_div{border: #ddd solid 1px;  box-shadow:1px 1px 2px 0px rgba(0,0,0,.2);padding:10px; width:78%;}
    #<?php echo $module['module_name'];?> .line_div #option_div #color_div img{width:25px;}
    #<?php echo $module['module_name'];?> .line_div #option_div #color_div .color_span{ display:inline-block; width:150px;}
    #<?php echo $module['module_name'];?> .line_div #option_div #color_div .color_span img{width:27px; vertical-align:middle;}
    #color_info_table{ width:80%;}
    #color_info_table tbody tr{ display:none;}
    .tr_color_icon{ height:29px; vertical-align:middle;}
	#option_table{ width:98%;}
	#option_table tbody tr{ display:none; }
	#option_table tbody img{width:25px; vertical-align:middle;}
	#option_table tbody input{width:80px;}
	#option_table tbody .bar_code{width:200px;}
	#<?php echo $module['module_name'];?> .require{display:inline-block;  width:20px; text-align:center;}
	#cover_image_show img{ height:200px;}
	#multi_angle_img_show div{ display:inline-block; vertical-align:top;   width:200px; margin:10px; overflow:hidden; text-align:center;}
	#multi_angle_img_show div img{ height:200px;}
	#multi_angle_img_show div a{ display:inline-block;  width:30px;}
	.color_img_thumb{height:100px;}	
	#<?php echo $module['module_name'];?>_html .create{ display:inline-block;  line-height:30px;}
	#<?php echo $module['module_name'];?>_html .create:before {font: normal normal normal 1rem/1 FontAwesome; content:"\f067"; padding-right:5px;}
	#<?php echo $module['module_name'];?>_html .create:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html #icon_file{ border:none;}
	#<?php echo $module['module_name'];?>_html #multi_angle_img_file{ border:none;}
	#<?php echo $module['module_name'];?>_html .checker span{ display:block;}
	#<?php echo $module['module_name'];?>_html .input_checkbox{}
	#<?php echo $module['module_name'];?>_html .move_to_left{display:inline-block;  width:50px; height:33px; margin-right:12px;}
	#<?php echo $module['module_name'];?>_html .move_to_left:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f104";}
	#<?php echo $module['module_name'];?>_html .move_to_left:hover{opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .move_to_right{ display:inline-block;  width:50px; height:33px; margin-left:12px; margin-right:12px;}
	#<?php echo $module['module_name'];?>_html .move_to_right:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f105";}
	#<?php echo $module['module_name'];?>_html .move_to_right:hover{opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .delete_me{ display:inline-block;  width:50px; height:33px; margin-left:12px;}
	#<?php echo $module['module_name'];?>_html .delete_me:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f014";}
	#<?php echo $module['module_name'];?>_html .delete_me:hover{opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .del_color_img{ display:inline-block;  background-repeat:no-repeat; width:18px; height:20px;}
	#<?php echo $module['module_name'];?>_html .del_color_img:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f014";}
	
	#<?php echo $module['module_name'];?>_html .m_label{ }
	#<?php echo $module['module_name'];?>_html .m_label .req{ }
	#<?php echo $module['module_name'];?>_html .color_name{ }
	#<?php echo $module['module_name'];?>_html .option_span{  margin-right:20px;}
	#<?php echo $module['module_name'];?>_html .title_span{ }
	#<?php echo $module['module_name'];?>_html .del{ display:inline-block; line-height:30px; width:50px;}
	#<?php echo $module['module_name'];?>_html .del:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f014";}
	#color_info_table{ border:1px solid #eee; width:98%; margin-left:1%; margin-right:1%; border-bottom:0px;}
	#color_info_table thead tr td{  padding-left:2%; padding-right:2%;  font-size:1rem;}
	#color_info_table tbody tr td{ border-bottom:1px solid #eee;  padding-left:2%;}
	#option_table{ border:1px solid #eee; width:98%; margin-left:1%; margin-right:1%; margin-top:20px; border-bottom:0px; }
	#option_table thead tr td{  padding-left:1%; padding-right:1%;  font-size:0.8rem;white-space:nowrap;}
	#option_table tbody tr td{ border-bottom:1px solid #eee;  padding-left:1%;white-space:nowrap;}
	#option_table tbody tr td .bar_code{width:50px;}
	#option_table tbody tr td .store_code{width:50px;}
	#option_table  td{  padding-left:1%; padding-right:1%;  font-size:0.8rem; white-space:nowrap;white-space:nowrap;}
	#option_table tbody tr td{ border-bottom:1px solid #eee;  padding-left:1%;white-space:nowrap;}
	#option_table tbody tr td .bar_code{width:100px;}
	#<?php echo $module['module_name'];?> #virtual_auto_delivery{ height:60px; width:80%;}
	
	#<?php echo $module['module_name'];?> .hide_input{ display:none;min-width:200px;}
	#<?php echo $module['module_name'];?> .input_span select{min-width:200px;}
	#<?php echo $module['module_name'];?>  .op_td{ text-align:left; white-space:nowrap; }
	
	
	#<?php echo $module['module_name'];?> .attribute_switch:before{
		font: normal normal normal 18px/1 FontAwesome;
		margin-left:5px;
		line-height:60px;
		content: "\f103";
		
	}
	#<?php echo $module['module_name'];?> .switch_input:before{
		font: normal normal normal 18px/1 FontAwesome;
		margin-left:5px;
		line-height:60px;
		content: "\f103";
		
	}
	.new_option_div{ display:none;}
	.new_option_div input{ width:60px;}
	#option_option_div{ white-space:normal; line-height:25px;}
	#option_option_div .option_span{white-space:nowrap; display:inline-block; width:100px; overflow:hidden; vertical-align:top;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">        
    	<div class=line_div>
        	<span class=m_label><span id=type><?php echo self::$language['belong'];?><?php echo self::$language['mall'];?><?php echo self::$language['type'];?></span><span class=state></span></span>
        	<span class=input_span><?php echo $module['type']?></span>
        </div>
        
        <div class=line_div>
            <span class=m_label><?php echo self::$language['bar_code'];?>(<?php echo self::$language['weight_goods_bar']?>)</span>
            <span class=input_span><input type="text" name="bar_code" id="bar_code"  class=barcode maxlength="13" /> <span class=state style="vertical-align: middle;"></span>  <img class=bar_code_img /></span>
        </div>
    	<div class=line_div>
        	<span class=m_label><span id=type><?php echo self::$language['belong'];?><?php echo self::$language['store'];?><?php echo self::$language['type'];?></span><span class=state></span></span>
        	<span class=input_span><select id=shop_type name=shop_type><option value=0>&nbsp;</option><?php echo $module['shop_type']?></select><input type="text" class="hide_input" /> <span class=state></span><a href="#" class=switch_input>&nbsp;</a>
            </span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['brand'];?></span>
        	<span class=input_span>
            	<select id="brand" name="brand">
      <option value="-1">&nbsp;</option> 
      <?php echo $module['brand_option'];?></select><input type="text" class="hide_input" /> <span class=state></span><a href="#" class=switch_input>&nbsp;</a>
            </span>
        </div>      
        

    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['grade'];?></span>
        	<span class=input_span>
            	<select id="grade" name="grade" >
      <option value="-1">&nbsp;</option> 
      <?php echo $module['grade_option'];?></select><input type="text" class="hide_input" /> <span class=state></span><a href="#" class=switch_input>&nbsp;</a>
            </span>
        </div>        

    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['habitat'];?></span>
        	<span class=input_span>
            	<select id="habitat" name="habitat" >
      <option value="-1">&nbsp;</option> 
      <?php echo $module['habitat_option'];?></select><input type="text" class="hide_input" /> <span class=state></span><a href="#" class=switch_input>&nbsp;</a>
            </span>
        </div>        

    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['contain'];?></span>
        	<span class=input_span>
            	<select id="contain" name="contain" >
      <option value="-1">&nbsp;</option> 
      <?php echo $module['contain_option'];?></select><input type="text" class="hide_input" /> <span class=state></span><a href="#" class=switch_input>&nbsp;</a>
            </span>
        </div>        

        
          
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['position'];?></span>
        	<span class=input_span>
            	<select id="position" name="position">
      <option value="-1">&nbsp;</option> 
      <?php echo $module['position'];?></select><input type="text" class="hide_input" /> <span class=state></span><a href="#" class=switch_input>&nbsp;</a>
            </span>
        </div>
		    

    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['storehouse'];?></span>
        	<span class=input_span>
            	<select id="storehouse" name="storehouse" >
      <option value="-1">&nbsp;</option> 
      <?php echo $module['storehouse'];?></select><input type="text" class="hide_input" /> <span class=state></span><a href="#" class=switch_input>&nbsp;</a>
            </span>
        </div>
		    
            
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['supplier'];?></span>
        	<span class=input_span>
            	<select id="supplier" name="supplier">
      <option value="-1">&nbsp;</option> 
      <?php echo $module['supplier'];?></select><input type="text" class="hide_input" /> <span class=state></span><a href="#" class=switch_input>&nbsp;</a>
            </span>
        </div>
		    
    	<div class=line_div>
        	<span class="m_label"><?php echo self::$language['unit'];?><span class=require>*</span></span>
        	<span class=input_span>
            	<select id="unit" name="unit">
      <option value="-1">&nbsp;</option> 
      <?php echo $module['unit'];?></select><input type="text" class="hide_input" /> <span class=state></span><a href="#" class=switch_input>&nbsp;</a>
            </span>
        </div>
		    
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['goods_name'];?><span class=require>*</span></span>
        	<span class=input_span><input type="text" name="title" id="title" /> <span class=state></span> <a  class="search_same" user_color="button" style="padding:5px; line-height:20px; display:none;" href=# href_pre="https://search.jd.com/Search?enc=utf-8&keyword=" target="_blank"><?php echo self::$language['search_same']?></a></span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['goods_advantage'];?></span>
        	<span class=input_span><textarea type="text" name="advantage" id="advantage"></textarea> <span class=state></span></span>
        </div>
		    
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['tag'];?></span>
        	<span class=input_span><input type="hidden" id="tag" name="tag" /><?php echo $module['tags'];?>  <span class=state></span><a href="index.php?monxin=mall.s_tag" class=create target="_blank"><?php echo self::$language['create']?></a>
            </span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['cover_image'];?><span class=require>*</span></span>
        	<span class=input_span><span class=state id=icon_state></span>
            <div id=cover_image_show></div></span>
        </div>
		    
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['multi_angle_img'];?></span>
        	<span class=input_span><span class=state id=multi_angle_img_state></span>
            <div id=multi_angle_img_show></div></span>
        </div>
		    
    	<div class=line_div id=attribute_line>
        	<span class=m_label><?php echo self::$language['attribute'];?></span>
        	<span class=input_span id=attribute_div><?php echo $module['attribute_html'];?></span>
        </div>
        <br />        
    	<div class=line_div id=option_line>
        	<span class=m_label><?php echo self::$language['option'];?></span>
        	<span class=input_span id=option_div>
            	<?php echo $module['option_html'];?>
                
               	<div class=table_scroll><table cellpadding="0" cellspacing="0" id="color_info_table">
                	<thead><tr><td><?php echo self::$language['color'];?> (<?php echo self::$language['goods_diy_option'];?>)</td><td><?php echo self::$language['image'];?>(<?php echo self::$language['optional'];?>)</td><td>&nbsp;</td></tr></thead>
                	<tbody>
                    	<?php echo $module['color_tr'];?>
                    </tbody>
                </table></div>
                
                <?php echo $module['option_table'];?>
                
                <div class="state" id=specifications_state></div>
            </span>
        </div>        
        
        <div id=no_specifications style="display:none;">
                    
            <div class=line_div>
                <span class=m_label><?php echo self::$language['store_code'];?></span>
                <span class=input_span><input type="text" name="store_code" id="store_code" class="store_code" maxlength="15" /> <span class=state></span>  <img class=store_code_img /></span>
                
            </div>
            <div class=line_div>
                <span class=m_label><?php echo self::$language['w_price'];?><span class=require>*</span></span>
                <span class=input_span><input type="text" name="w_price" id="w_price"  /> <span class=state></span></span>
            </div>
                
            <div class=line_div>
                <span class=m_label><?php echo self::$language['e_price'];?><span class=require>*</span></span>
                <span class=input_span><input type="text" name="e_price" id="e_price"  /> <span class=state></span></span>
            </div>
                
            <div class=line_div>
                <span class=m_label><?php echo self::$language['cost_price'];?><span class=require>*</span></span>
                <span class=input_span><input type="text" name="cost_price" id="cost_price"  /> <span class=state></span></span>
            </div>
                
            <div class=line_div>
                <span class=m_label><?php echo self::$language['inventory'];?><span class=require>*</span></span>
                <span class=input_span><input type="text" name="inventory" id="inventory"  /> <span class=state></span></span>
            </div>
            
        
        </div>
        
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['free_shipping'];?></span>
        	<span class=input_span>
            	<select id="free_shipping" name="free_shipping"><option value="0"><?php echo self::$language['no']?></option><option value="1"><?php echo self::$language['yes']?></option></select> <span class=state></span>
            </span>
        </div>
		<div class=line_div>
        	<span class=m_label>商品类型</span>
        	<span class=input_span>
            	<select id="goods_type" name="goods_type">
				<option value="0">普通商品</option>
				<option value="1">会员卡商品</option>
				<option value="2">399(jplus)商品</option>
				</select> <span class=state></span>
            </span>
        </div>
		<div class=line_div>
        	<span class=m_label>限定积分支付</span>
        	<span class=input_span>
            	<select id="only_integral" name="only_integral">
				<option value="0">否</option>
				<option value="1">是</option>
				</select> <span class=state></span>
            </span>
        </div>
		    
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['sales_promotion'];?></span>
        	<span class=input_span>
            	<select id="sales_promotion" name="sales_promotion"><option value="1"><?php echo self::$language['yes']?></option><option value="0"><?php echo self::$language['no']?></option></select> <span class=state></span>
            </span>
        </div>
		    
		 
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['goods'];?><?php echo self::$language['state'];?><span class=require>*</span></span>
        	<span class=input_span>
            	<select id="goods_state" name="goods_state" monxin_value="2"><?php echo $module['goods_state']?></select> <span class=state></span>
            </span>
        </div>
		    
    	<div class=line_div d="goods_state_1" style="display:none;">
        	<span class=m_label><?php echo self::$language['goods_state'][1];?><?php echo self::$language['set'];?></span>
        	<span class=input_span style="border:1px #CCCCCC solid;">
            	<div class=sub_line_div>
                	<span class=m_label><?php echo self::$language['booking'];?><?php echo self::$language['rebate'];?><span class=require>*</span></span><span class=input_span><input type="text" class="pre_discount" id="pre_discount" name="pre_discount" placeholder="1-10<?php echo self::$language['discount']?>, <?php echo self::$language['have_order_can_not_be_modified']?>"  /><span class=state></span></span>
                	<span class=m_label><?php echo self::$language['booking'];?><?php echo self::$language['deposit2'];?><span class=require>*</span></span><span class=input_span><input type="text" class="deposit" id="deposit" name="deposit" placeholder="<?php echo self::$language['have_order_can_not_be_modified']?>" />  <?php echo self::$language['yuan']?> <span class=state></span></span>
                	<span class=m_label><?php echo self::$language['deposit2'];?><?php echo self::$language['reduce'];?><span class=require>*</span></span><span class=input_span><input type="text" class="reduction" id="reduction" name="reduction" placeholder="<?php echo self::$language['have_order_can_not_be_modified']?>" /> <?php echo self::$language['yuan']?> <span class=state></span></span>
                	<span class=m_label><?php echo self::$language['last_pay_start_time'];?><span class=require>*</span></span><span class=input_span><input type="text" id="last_pay_start_time" name="last_pay_start_time" class="last_pay_start_time" onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /><span class=state></span></span>
                	<span class=m_label><?php echo self::$language['last_pay_end_time'];?><span class=require>*</span></span><span class=input_span><input type="text" id="last_pay_end_time" name="last_pay_end_time" class="last_pay_end_time" onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /><span class=state></span></span>
                	<span class=m_label><?php echo self::$language['delivered'];?><span class=require>*</span></span><span class=input_span><input type="text" id="delivered" name="delivered" onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /><span class=state></span></span>
                </div>
            
            </span>
        </div>
		    
    	<div class=line_div d="goods_state_3" style="display:none;">
        	<span class=m_label><?php echo self::$language['goods_state'][3];?>,<?php echo self::$language['estimate'];?><?php echo self::$language['send_time'];?><span class=require>*</span></span>
        	<span class=input_span><input type="text" name="out_delivered" id="out_delivered" onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <span class=state></span></span>
        </div>
		    
  
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['buy_limit'];?></span>
        	<span class=input_span>
            	<select id="limit" name="limit" monxin_value="0"><?php echo $module['buy_limit_option']?></select> <span class=state></span>
            </span>
        </div>
		    
    	<div class=line_div d="buy_limit" style="display:none;">
        	<span class=m_label><?php echo self::$language['buy_limit_cycle'];?></span>
        	<span class=input_span><select id="limit_cycle" name="limit_cycle" monxin_value="d"><?php echo $module['limit_cycle_option']?></select> <span class=state></span></span>
        </div>
		    
  
    	    
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['logistics_weight'];?></span>
        	<span class=input_span><input type="text" name="logistics_weight" id="logistics_weight"  /> <span class=state></span></span>
        </div>
		    
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['logistics_volume'];?></span>
        	<span class=input_span><input type="text" name="logistics_volume" id="logistics_volume"  /> <span class=state></span></span>
        </div>
    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['shelf_life'];?></span>
        	<span class=input_span><input type="text" name="shelf_life" id="shelf_life" /> <span class=state></span></span>
        </div>

    	<div class=line_div>
        	<span class=m_label><?php echo self::$language['virtual_auto_delivery'];?></span>
        	<span class=input_span>
            <div class=quick_set><a class=email_msg href=#><?php echo self::$language['email_msg']?><?php echo self::$language['sample']?></a> <a class=phone_msg href=#>http get & <?php echo self::$language['phone_msg']?><?php echo self::$language['sample']?></a> </div>
            <textarea type="text" name="virtual_auto_delivery" id="virtual_auto_delivery"  placeholder="<?php echo self::$language['virtual_auto_delivery_placeholder'];?>"></textarea> <span class=state></span></span>
        </div>

    <ul class="nav nav-tabs" device_tabs=1>
      <li role="presentation" class="active"><a href="#" target="detail_div"><?php echo self::$language['pc_device'];?><?php echo self::$language['detail'];?></a></li>
      <li role="presentation"><a href="#m_detail" target="m_detail_div"><?php echo self::$language['phone_device'];?><?php echo self::$language['detail'];?></a></li>
	</ul>
    

		<div class="detail_div"><textarea name="detail" id="detail" style="display:none; width:100%; height:400px;"></textarea></div>
        <div class="m_detail_div" style="display:none;"><textarea name="m_detail" id="m_detail" style="display:none; width:100%; height:400px;"></textarea></div>
            
        <br />   
        <a href="#" id=submit class="submit"><?php echo self::$language['submit']?></a> <span id=submit_state class=state></span>    
      
    </form>
    <style>
    .fast_move{ position:fixed; right:50px; top:260px; text-align:right; width:150px; height:50px; line-height:30px; overflow:hidden; padding:10px;}
    .fast_move .fast_move_switch{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>  !important;  height:30px; line-height:30px;  display:inline-block; border-radius:0px; padding-left:10px; padding-right:10px;}
    .fast_move .fast_move_detail{ text-align:left; padding-top:10px; white-space:nowrap;}
    .fast_move .fast_move_detail .agreement_t{ font-weight:bold; text-align:center;}
    .fast_move .fast_move_detail .agreement_c{ white-space:normal;}
    .fast_move .fast_move_detail .move_url{ width:60%;}
    .fast_move .fast_move_detail .agreement{ height:30px; line-height:30px;  display:inline-block; border-radius:0px; padding-left:10px; padding-right:10px;}
    </style>
    
    <div class=fast_move>
    	<a href=# class=fast_move_switch><?php echo self::$language['goods_fast_copy']?></a>
    	<div class=fast_move_detail>
        	<div class=agreement_t><?php echo self::$language['use_agreement']?></div>
        	<div class=agreement_c><?php echo self::$language['agreement_content']?></div>
            <input type="text" class=move_url placeholder="<?php echo self::$language['move_url_placeholder']?>" />
            <a href=# class=agreement><?php echo self::$language['consent_agreement']?></a> <span class=state></span>
        </div>
    </div>
    </div>
</div>

