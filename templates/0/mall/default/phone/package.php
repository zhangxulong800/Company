<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script>
	function set_price_inventory(id,type){
temp=$("#"+id+" .json").html();
		specifications=eval("("+temp+")");
		if($("#"+id+" .option_option").prop('value')!=0 && $("#"+id+" .color_option").prop('value')!=0){
			for( v in specifications ){
				if(specifications[v]['option_id']==$("#"+id+" .option_option").prop('value') && specifications[v]['color_id']==$("#"+id+" .color_option").prop('value')){$("#"+id).attr('spec',v);break;}
			}	
		}
		//alert($("#"+id).attr('spec'));
		if($("#"+id).attr('spec')!=0){
			$("#"+id+" .discount .value").html(specifications[$("#"+id).attr('spec')]['w_price']*$("#"+id).attr('discount')/10);
			$("#"+id+" .discount .value").html(parseFloat($("#"+id+" .discount .value").html()).toFixed(2));
			$("#"+id+" .normal .value").html(specifications[$("#"+id).attr('spec')]['w_price']);
			$("#"+id+" .inventory .value").html(specifications[$("#"+id).attr('spec')]['quantity']);
		}
		if(type=='color'){
			//alert($("#"+id+" .color_option").prop('value'));
			$("#"+id+" .option_option a").each(function(index, element) {
				exist_s=false;
				for( v in specifications ){
					if(specifications[v]['option_id']==$(this).attr('id').replace(/option_/,'') && specifications[v]['color_id']==$("#"+id+" .color_option").prop('value')){exist_s=true;break;}
				}
				if(exist_s){
					if($(this).attr('class')=='disable'){$(this).attr('class','');}	
				}else{
					$(this).attr('class','disable');
				}	
            });	
		}else{
			//alert($("#"+id+" .option_option").prop('value'));
			$("#"+id+" .color_option a").each(function(index, element) {
				exist_s=false;
				for( v in specifications ){
					if(specifications[v]['color_id']==$(this).attr('id').replace(/color_/,'') && specifications[v]['option_id']==$("#"+id+" .option_option").prop('value')){exist_s=true;break;}
				}
				if(exist_s){
					if($(this).attr('class')=='disable'){$(this).attr('class','');}	
				}else{
					$(this).attr('class','disable');
				}	
            });	
		}
	}
	function set_price_inventory2(id,type){
		temp=$("#"+id+" .json").html();
		specifications=eval("("+temp+")");
		if($("#"+id+" .option_option").prop('value')!=0 && $("#"+id+" .color_option").prop('value')!=0){
			for( v in specifications ){
				if(specifications[v][type+'_id']==$("#"+id+" ."+type+"_option").prop('value')){$("#"+id).attr('spec',v);break;}
			}	
		}
		//alert($("#"+id).attr('spec'));
		if($("#"+id).attr('spec')!=0){
			$("#"+id+" .discount .value").html(specifications[$("#"+id).attr('spec')]['w_price']*$("#"+id).attr('discount')/10);
			$("#"+id+" .discount .value").html(parseFloat($("#"+id+" .discount .value").html()).toFixed(2));
			$("#"+id+" .normal .value").html(specifications[$("#"+id).attr('spec')]['w_price']);
			$("#"+id+" .inventory .value").html(specifications[$("#"+id).attr('spec')]['quantity']);
		}
		
	}
	function set_price_to_default(id){
		$("#<?php echo $module['module_name'];?> .normal .value").html($("#<?php echo $module['module_name'];?> .normal .value").prop('value'));
		$("#<?php echo $module['module_name'];?> .discount .value").html($("#<?php echo $module['module_name'];?> .discount .value").prop('value'));
		$("#<?php echo $module['module_name'];?> .inventory .value").html($("#<?php echo $module['module_name'];?> .inventory .value").prop('value'));
	}
	
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .buy_now").click(function(){
			need_select=false;
			temp=window.location.href+'&goods_src=package_id&quantity='+$("#<?php echo $module['module_name'];?> .quantity").val();
			$("#<?php echo $module['module_name'];?> .g").each(function(index, element) {
				//alert($(this).attr('id')+'='+ $(this).children('.other').children('.spec').children('.json').html().length);
                if($(this).attr('spec')==0 && $(this).children('.other').children('.spec').children('.json').html().length>5){
					alert('<?php echo self::$language['please_select']?><?php echo self::$language['goods_spec']?>');
					$(document).scrollTop($(this).offset().top);
					need_select=true;
					return false;
				}
				temp+="&"+$(this).attr('id')+'='+$(this).attr('spec');
            });
			if(need_select){return false;}
			//alert(temp);
			window.location.href=temp.replace(/package/,'confirm_order');
			
			return false;	
		});
		
		
		$("#<?php echo $module['module_name'];?> .option_option a").click(function(){
			if($(this).attr('class')=='disable'){return false;}
			g_id=$(this).parent().parent().parent().parent().parent().attr('id');
			//alert(g_id);
			if($(this).attr('class')=='selected'){
				$("#<?php echo $module['module_name'];?> #"+g_id+" .color_option a[class!='selected']").attr('class','');
				$(this).attr('class','');
				$("#<?php echo $module['module_name'];?> #"+g_id+" .option_selected_symbol").css('display','none');
				set_price_to_default(g_id);
				return false;
			}
			$("#<?php echo $module['module_name'];?> #"+g_id+" .option_selected_symbol").css('display','block').css('left',$(this).offset().left+$(this).width()-5).css('top',$(this).offset().top+25);
			$("#<?php echo $module['module_name'];?> #"+g_id+" .option_option a[class!='disable']").attr('class','');
			$(this).attr('class','selected');
			$(this).parent().prop('value',$(this).attr('id').replace(/option_/,''));
			if($("#<?php echo $module['module_name'];?> #"+g_id+" .color_option").html()){
				set_price_inventory(g_id,'option');
			}else{
				set_price_inventory2(g_id,'option');
			}
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .color_option a").click(function(){
			if($(this).attr('class')=='disable'){return false;}
			g_id=$(this).parent().parent().parent().parent().parent().attr('id');
			//alert(g_id);
			if($(this).attr('class')=='selected'){
				$("#<?php echo $module['module_name'];?> #"+g_id+" .option_option a[class!='selected']").attr('class','');
				$(this).attr('class','');
				$("#<?php echo $module['module_name'];?> #"+g_id+" .color_selected_symbol").css('display','none');
				set_price_to_default(g_id);
				return false;
			}
			$("#<?php echo $module['module_name'];?> #"+g_id+" .color_selected_symbol").css('display','block').css('left',$(this).offset().left+$(this).width()-5).css('top',$(this).offset().top+25);
			$("#<?php echo $module['module_name'];?> #"+g_id+" .color_option a[class!='disable']").attr('class','');
			$(this).attr('class','selected');
			$(this).parent().prop('value',$(this).attr('id').replace(/color_/,''));
			if($("#<?php echo $module['module_name'];?> #"+g_id+" .option_option").html()){
				set_price_inventory(g_id,'color');
			}else{
				set_price_inventory2(g_id,'color');
			}
			return false;	
		});
    });
	
	
    </script>
    <style>
    #<?php echo $module['module_name'];?>{ overflow:hidden;}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html fieldset{ border:#ccc  dashed 1px;}
    #<?php echo $module['module_name'];?>_html fieldset legend{; font-weight:bold; line-height:50px;}
    #<?php echo $module['module_name'];?>_html .quantity{ width:50px;  text-align:center;}
    #<?php echo $module['module_name'];?>_html .buy_now{font-size:1.2rem; padding:2px;}
    #<?php echo $module['module_name'];?>_html .buy_now:hover{ opacity:0.8;}
	
	
    #<?php echo $module['module_name'];?>_html .g{ margin-bottom:10px; border-bottom:1px solid #ccc; line-height:2rem;}
    #<?php echo $module['module_name'];?>_html .option_selected_symbol{ position:absolute; z-index:9;background-image:url(<?php echo get_template_dir(__FILE__);?>img/choosen.png); width:15px; height:15px; display:none; background-position:bottom; background-repeat:no-repeat;}
    #<?php echo $module['module_name'];?>_html .color_selected_symbol{ position:absolute; z-index:9;background-image:url(<?php echo get_template_dir(__FILE__);?>img/choosen.png); width:15px; height:15px; display:none; background-position:bottom; background-repeat:no-repeat;}
	
    #<?php echo $module['module_name'];?>_html .g .icon{ display:inline-block; vertical-align:top; width:20%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .g .icon img{ width:100%; border:none;}
    #<?php echo $module['module_name'];?>_html .g .other{ padding-left:10px; display:inline-block; vertical-align:top; width:80%;overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .g .other .title{ display:block; height:30px; line-height:30px; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .g .other .price_inventory{}
    #<?php echo $module['module_name'];?>_html .g .other .price_inventory .normal .m_label{ }
    #<?php echo $module['module_name'];?>_html .g .other .price_inventory .normal .money_symbol{padding-right:50px;}
    #<?php echo $module['module_name'];?>_html .g .other .price_inventory .normal .value{ text-decoration:line-through;}
	#<?php echo $module['module_name'];?>_html .g .other .price_inventory .discount{ display:block; white-space:nowrap;}
    #<?php echo $module['module_name'];?>_html .g .other .price_inventory .discount .m_label{}
    #<?php echo $module['module_name'];?>_html .g .other .price_inventory .discount .money_symbol{ padding-right:20px; }
    #<?php echo $module['module_name'];?>_html .g .other .price_inventory .discount .value{ font-size: 1.2rem;font-weight: bold;font-family: Georgia, "Times New Roman", Times, serif;}
    #<?php echo $module['module_name'];?>_html .g .other .price_inventory .inventory{ }
    #<?php echo $module['module_name'];?>_html .g .other .price_inventory .inventory .m_label{}
    #<?php echo $module['module_name'];?>_html .g .other .price_inventory .inventory .value{ font-weight:bold;}
    #<?php echo $module['module_name'];?>_html .g .other .price_inventory .inventory .unit{}
    #<?php echo $module['module_name'];?>_html .g .spec{}
    #<?php echo $module['module_name'];?>_html .g .spec .json{ display:none;}
	
	
	#<?php echo $module['module_name'];?>_html .g .spec .color_label{ display:inline-block; vertical-align:top; line-height:35px; vertical-align:top; text-align:right; padding-right:10px; width:25%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .g .spec .color_line_div{ }
	#<?php echo $module['module_name'];?>_html .g .spec .color_option{ display:inline-block; vertical-align:top; vertical-align:top; overflow:hidden; width:75%;}
	#<?php echo $module['module_name'];?>_html .g .spec .color_option a{ margin-left:4px; margin-right:4px; display:inline-block; vertical-align:top; line-height:30px; vertical-align:top; border:1px solid #ccc; overflow:hidden; padding:5px;  margin-bottom:10px;}
	#<?php echo $module['module_name'];?>_html .g .spec .color_option a:hover{ border:1px solid #ff3200; }
	#<?php echo $module['module_name'];?>_html .g .spec .color_option a:hover img{}
	#<?php echo $module['module_name'];?>_html .g .spec .color_option .selected{border:1px solid #ff3200;}
	#<?php echo $module['module_name'];?>_html .g .spec .color_option .disable{ opacity:0.1; filter:alpha(opacity=10); cursor:default;}
	#<?php echo $module['module_name'];?>_html .g .spec .color_option .disable:hover{ border:1px solid #ccc;}
	#<?php echo $module['module_name'];?>_html .g .spec .color_option a img{ height:30px; width:30px;}
	

	
	#<?php echo $module['module_name'];?>_html .g .spec .option_label{ display:inline-block; vertical-align:top; line-height:32px; vertical-align:top; text-align:right; width:25%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .g .spec .option_line_div{}
	#<?php echo $module['module_name'];?>_html .g .spec .option_option{ display:inline-block; vertical-align:top; vertical-align:top;overflow:hidden;  width:75%; }
	#<?php echo $module['module_name'];?>_html .g .spec .option_option a{ margin-bottom:10px;  margin-left:4px; margin-right:4px; padding-left:4px; padding-right:4px; display:inline-block; vertical-align:top; line-height:40px; height:40px; vertical-align:top;  overflow:hidden; border:1px solid #ddd;}
	#<?php echo $module['module_name'];?>_html .g .spec .option_option a:hover{ border:1px solid #ff3200;}
	#<?php echo $module['module_name'];?>_html .g .spec .option_option .selected{ border:1px solid #ff3200;}
	#<?php echo $module['module_name'];?>_html .g .spec .option_option .disable{ opacity:0.1; filter:alpha(opacity=10); cursor:default;}
	#<?php echo $module['module_name'];?>_html .g .spec .option_option .disable:hover{ border:1px solid #ccc;}
	
	#<?php echo $module['module_name'];?> .money_symbol{ padding-left:2px; font-size:0.9rem;}
	#<?php echo $module['module_name'];?> .value{ color:<?php echo $_POST['monxin_user_color_set']['nv_3_hover']['background']?>;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <fieldset>
    	<legend><?php echo self::$language['i_want_to_buy'];?> <input type="text" class="quantity" value="1"> <?php echo self::$language['package_unit'];?> <a href="#" id="submit" class="buy_now"><span class="b_start"> </span><span class="b_middle"><?php echo self::$language['buy_now'];?></span><span class="b_end"> </span></a></legend>
    	<?php echo $module['list'];?>
    </fieldset>
    </div>
</div>
