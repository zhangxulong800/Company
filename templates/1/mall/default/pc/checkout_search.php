<div id=<?php echo $module['module_name'];?> monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	temp=window.location.href;
	temp=temp.split('_search');
	$("#<?php echo $module['module_name'];?> .goods_filter a[data='"+temp[1]+"']").addClass('selected');
	$("#<?php echo $module['module_name'];?> .goods_filter").height($("#<?php echo $module['module_name'];?>").height());
	$("#<?php echo $module['module_name'];?> .goods_filter li a").click(function(){
		window.location.href='./index.php?monxin=mall.checkout_search'+$(this).attr('data');
			
	});
	
	$(window).keyup(function(e){
		//alert(e.keyCode);
　  　　if(e.keyCode==27){//esc
			if($("#myModal").css('display')!='block'){
				parent.close_checkout_search();
			}else{
				$("#myModal").modal("hide");	
			}
		}    

		if(e.keyCode==37){//left
			if(swtich_goods_option('left')==false){return false;}
			//
			v=$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").children('.quantity_div').children('.quantity').val();
			v--;
			if(v<1){v=1;}
			$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").children('.quantity_div').children('.quantity').val(v);
		}    

		if(e.keyCode==38){//up
			if(swtich_goods_option('left')==false){return false;}
			index=$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").index();
			if(index==0){index=$("#<?php echo $module['module_name'];?> .goods_list .goods").length;}
			$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").removeClass('goods_focus');
			$("#<?php echo $module['module_name'];?> .goods_list .goods").eq(index-1).addClass('goods_focus');
			$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").children('.quantity_div').children('.quantity').focus();
		}    

		if(e.keyCode==39){//right
			if(swtich_goods_option('right')==false){return false;}
			v=$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").children('.quantity_div').children('.quantity').val();
			v++;
			if(parseInt(v)>parseInt($("#<?php echo $module['module_name'];?> .goods_list .goods_focus").children('.quantity_div').children('.inventory').children('span').html())){
				v=$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").children('.quantity_div').children('.inventory').children('span').html();
			}
			$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").children('.quantity_div').children('.quantity').val(v);
		}    

		if(e.keyCode==40){//down
			if(swtich_goods_option('right')==false){return false;}
			index=$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").index();
			if(index==$("#<?php echo $module['module_name'];?> .goods_list .goods").length-1){index=-1;}
			$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").removeClass('goods_focus');
			$("#<?php echo $module['module_name'];?> .goods_list .goods").eq(index+1).addClass('goods_focus');
			$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").children('.quantity_div').children('.quantity').focus();
		}   
		
		if(e.keyCode==13){//Enter
			if($("#myModal").css('display')=='block'){
				
				if($("#myModal .specifications a[is_focus=1]").attr('class')!='selected'){
					$("#myModal .specifications a[is_focus=1]").parent().children('a').removeClass('selected');
					$("#myModal .specifications a[is_focus=1]").addClass('selected');	
				}else{
					$("#myModal .specifications a[is_focus=1]").removeClass('selected');
				}
				
				$("#<?php echo $module['module_name'];?>_html .goods_list .goods_focus #"+$("#myModal .specifications a[is_focus=1]").attr('id')).trigger("click");
				return false;
			}
			if($(e.target).attr('class')=='search'){return false;}
			g_id=$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").attr('id');
			quantity=$("#<?php echo $module['module_name'];?> #"+g_id+" .quantity").val();
			if(quantity==''){quantity=1;}
			if($("#<?php echo $module['module_name'];?> #"+g_id).children('.goods_info').children('.specifications').html()){
				
				
				if(!$("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id') || $("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id')==0){
					if($("#<?php echo $module['module_name'];?> #"+g_id+" .option_option a").length<=1 && $("#<?php echo $module['module_name'];?> #"+g_id+" .color_option a").length<=1 ){
						$("#<?php echo $module['module_name'];?> #"+g_id+" .option_option a").addClass('selected');
						$("#<?php echo $module['module_name'];?> #"+g_id+" .color_option a").addClass('selected');
						set_price_inventory2(g_id,$("#<?php echo $module['module_name'];?> #"+g_id+" .selected").attr('id'));
					}else{
						
						$('#myModal .specifications').html($("#<?php echo $module['module_name'];?> .goods_list .goods_focus .specifications").html());
						
						$('#myModal').modal({  
						   backdrop:true,  
						   keyboard:false,  
						   show:true  
						});  
						$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/3);	
						$('#myModal .specifications .option_option a:first-child').focus();	 
						return false;		
							
					}
					
					
					
				}
				$("#<?php echo $module['module_name'];?> #"+g_id+" .add_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
				parent.add_checkout($("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id'),'s_id',quantity);
			}else{
				$("#<?php echo $module['module_name'];?> #"+g_id+" .add_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
				parent.add_checkout(g_id.replace(/g_/,''),'g_id',quantity);
			}
			$("#<?php echo $module['module_name'];?> #"+g_id+" .add_state").html('<span class=success><?php echo self::$language['success'];?></span>');

		}   
		
		 
　　　});	

	$(document).on('click',"#<?php echo $module['module_name'];?> #myModal .specifications a",function(){
		if($(this).attr('class')!='selected'){
			$(this).parent().children('a').removeClass('selected');
			$(this).parent().children('a').removeAttr('is_focus');
			$(this).addClass('selected');
			$(this).attr('is_focus','1');
			
		}else{
			$(this).removeClass('selected');
		}
		
		$("#<?php echo $module['module_name'];?>_html .goods_list .goods_focus #"+$(this).attr('id')).trigger("click");
		return false;	
	});

	$("#<?php echo $module['module_name'];?> .goods_list .goods:first-child").addClass('goods_focus');
	$("#<?php echo $module['module_name'];?> .goods_list .goods:first-child .quantity").focus();
	$("#<?php echo $module['module_name'];?> .goods").click(function(){
		$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").removeClass('goods_focus');
		$(this).addClass('goods_focus');
		$("#<?php echo $module['module_name'];?> .goods_list .goods_focus").children('.quantity_div').children('.quantity').focus();
	});
	
	$("#<?php echo $module['module_name'];?> .goods .quantity").change(function(){
		if(!$.isNumeric($(this).val())){$(this).val('');}
	});
	$("#<?php echo $module['module_name'];?> .goods .quantity").keyup(function(){
		if(!$.isNumeric($(this).val())){$(this).val('');}
	});
	
	//$("#<?php echo $module['module_name'];?> .search").focus();
	
	$("#<?php echo $module['module_name'];?> .add_checkout").click(function(){
		g_id=$(this).parent().parent().attr('id');
		quantity=$("#<?php echo $module['module_name'];?> #"+g_id+" .quantity").val();
		if(quantity==''){quantity=1;}
		if($("#<?php echo $module['module_name'];?> #"+g_id).children('.goods_info').children('.specifications').html()){
			
			
			if(!$("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id') || $("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id')==0){
				if($("#<?php echo $module['module_name'];?> #"+g_id+" .option_option a").length<=1 && $("#<?php echo $module['module_name'];?> #"+g_id+" .color_option a").length<=1 ){
					$("#<?php echo $module['module_name'];?> #"+g_id+" .option_option a").addClass('selected');
					$("#<?php echo $module['module_name'];?> #"+g_id+" .color_option a").addClass('selected');
					set_price_inventory2(g_id,$("#<?php echo $module['module_name'];?> #"+g_id+" .selected").attr('id'));
				}else{
					if($("#<?php echo $module['module_name'];?> #"+g_id+" .option_label").html() && $("#<?php echo $module['module_name'];?> #"+g_id+" .color_label").html()){
						alert('<?php echo self::$language['please_select']?>'+$("#<?php echo $module['module_name'];?> #"+g_id+" .option_label").html()+' '+$("#<?php echo $module['module_name'];?> #"+g_id+" .color_label").html());
					}else{
						if($("#<?php echo $module['module_name'];?> #"+g_id+" .option_label").html()){
							alert('<?php echo self::$language['please_select']?>'+$("#<?php echo $module['module_name'];?> #"+g_id+" .option_label").html());
						}else{
							alert('<?php echo self::$language['please_select']?>'+$("#<?php echo $module['module_name'];?> #"+g_id+" .color_label").html());
						}
					}
					
					return false; 
				}
			}
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			parent.add_checkout($("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id'),'s_id',quantity);
		}else{
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			parent.add_checkout(g_id.replace(/g_/,''),'g_id',quantity);
		}
		$(this).next().html('<span class=success><?php echo self::$language['success'];?></span>');
		return false;
	});
	
	
		$("#<?php echo $module['module_name'];?>_html .goods .color_option a").click(function(){
			g_id=$(this).parent().parent().parent().parent().parent().attr('id');
			
			if($(this).attr('class')=='selected'){
				$("#<?php echo $module['module_name'];?>_html .goods .option_option a[class!='selected']").attr('class','');
				$(this).attr('class','');
				$("#color_selected_symbol").css('display','none');
				set_price_to_default(g_id);
				$("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id',0);
				
				return false;
			}			
			if($(this).attr('class')=='disable'){return false;}
			
			$("#<?php echo $module['module_name'];?>_html .goods .color_option a[class!='disable']").attr('class','');
			$(this).attr('class','selected');
			img_path=$(this).children().attr('src');
			if(img_path){
				if(img_path.indexOf('img_thumb')!=-1){
					$("#<?php echo $module['module_name'];?> #"+g_id+" .goods_a img").attr('src',img_path.replace('img_thumb','img'));	
				}else{
					$("#<?php echo $module['module_name'];?> #"+g_id+" .goods_a img").attr('src',$("#<?php echo $module['module_name'];?> #"+g_id+" .goods_a img").attr('old'));
				}
			}else{
					$("#<?php echo $module['module_name'];?> #"+g_id+" .goods_a img").attr('src',$("#<?php echo $module['module_name'];?> #"+g_id+" .goods_a img").attr('old'));
			}
			if(getCookie('user_set_page_auto_size')=='1' && getCookie('monxin_device')=='pc' && $(window).width()<1319){
				$("#color_selected_symbol").css('display','none');
			}else{
				$("#color_selected_symbol").css('display','block').css('left',$(this).offset().left+$(this).width()-3).css('top',$(this).offset().top+27);			}
			
			if($("#<?php echo $module['module_name'];?>_html  #"+g_id+" .option_line_div").html()){
				set_price_inventory(g_id,$(this).attr('id'));
			}else{
				set_price_inventory2(g_id,$(this).attr('id'));
			}
			
			return false;	
		});
		
		
		$("#<?php echo $module['module_name'];?>_html .goods .option_option a").click(function(){
			g_id=$(this).parent().parent().parent().parent().parent().attr('id');
			if($(this).attr('class')=='selected'){
				$("#<?php echo $module['module_name'];?>_html .goods .color_option a[class!='selected']").attr('class','');
				$(this).attr('class','');
				$("#option_selected_symbol").css('display','none');
				set_price_to_default(g_id);
				$("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id',0);
				return false;
			}
			if($(this).attr('class')=='disable'){return false;}
			$("#<?php echo $module['module_name'];?>_html .goods .option_option a[class!='disable']").attr('class','');
			$(this).attr('class','selected');
			
			if(getCookie('user_set_page_auto_size')=='1' && getCookie('monxin_device')=='pc' && $(window).width()<1319){
				$("#option_selected_symbol").css('display','none');
			}else{
				$("#option_selected_symbol").css('display','block').css('left',$(this).offset().left+$(this).width()-5).css('top',$(this).offset().top+27);
			}
			
			
			if($("#<?php echo $module['module_name'];?>_html  #"+g_id+" .color_line_div").html()){
				set_price_inventory(g_id,$(this).attr('id'));
			}else{
				set_price_inventory2(g_id,$(this).attr('id'));
			}
			return false;	
		});
		
	
	
	
	$("#<?php echo $module['module_name'];?> .search").keyup(function(event){
		if($(this).val()==''){return false;}
		if(event.keyCode==13 && $(this).val()!=''){
			window.location.href='./index.php?monxin=mall.checkout_search&search='+$(this).val();
		}
	});
	$("#<?php echo $module['module_name'];?> .search_div .submit").click(function(){
		window.location.href='./index.php?monxin=mall.checkout_search&search='+$("#<?php echo $module['module_name'];?> .search").val();
		return false;
	});
	
	function set_price_to_default(id){
		$("#<?php echo $module['module_name'];?> #"+id+" .price_span").html($("#<?php echo $module['module_name'];?> #"+id+" .price_span").attr('price'));
		$("#<?php echo $module['module_name'];?> #"+id+" .inventory span").html($("#<?php echo $module['module_name'];?> #"+id+" .inventory span").attr('value'));
	}
	function set_price_inventory(g_id,id){
		//alert(g_id+','+id);
		temp=$("#"+g_id+' .json').html();
		specifications=eval("("+temp+")");
		selected_option_id=$("#<?php echo $module['module_name'];?>_html .option_option .selected").attr('id');
		if(selected_option_id){selected_option_id=selected_option_id.replace(/option_/,'');}
		selected_color_id=$("#<?php echo $module['module_name'];?>_html .color_option .selected").attr('id');
		if(selected_color_id){selected_color_id=selected_color_id.replace(/color_/,'');}
		//alert(selected_option_id+','+selected_color_id);
		s_id=0;
		if(selected_option_id && selected_color_id){
			for( v in specifications ){
				if(specifications[v]['option_id']==selected_option_id && specifications[v]['color_id']==selected_color_id){s_id=v;break;}
			}	
		}
		//alert(specifications[s_id]['e_price']);
		if(s_id){
			$("#<?php echo $module['module_name'];?> #"+g_id+" .price_span").html('<span class=money_symbol><?php echo self::$language['money_symbol'];?></span><span class=money_value>'+specifications[s_id]['e_price']+'</span>');
			$("#<?php echo $module['module_name'];?> #"+g_id+" .inventory span").html(specifications[s_id]['quantity']);
			$("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id',s_id);
			
		}
		//alert(id.indexOf('color_'));
		if(id.indexOf('color_')==0){
			
			$("#<?php echo $module['module_name'];?>_html #"+g_id+" .option_option a").each(function(index, element) {
				exist_s=false;
				for( v in specifications ){
					if(specifications[v]['option_id']==$(this).attr('id').replace(/option_/,'') && specifications[v]['color_id']==id.replace(/color_/,'')){exist_s=true;break;}
				}
				if(exist_s){
					if($(this).attr('class')=='disable'){$(this).attr('class','');}	
				}else{
					$(this).attr('class','disable');
				}	
            });	
		}else{
			$("#<?php echo $module['module_name'];?>_html #"+g_id+" .color_option a").each(function(index, element) {
				exist_s=false;
				for( v in specifications ){
					if(specifications[v]['color_id']==$(this).attr('id').replace(/color_/,'') && specifications[v]['option_id']==id.replace(/option_/,'')){exist_s=true;break;}
				}
				if(exist_s){
					if($(this).attr('class')=='disable'){$(this).attr('class','');}	
				}else{
					$(this).attr('class','disable');
				}	
            });	
		}
	}
	function set_price_inventory2(g_id,id){
		specifications=eval('('+$("#"+g_id+' .json').html()+')');
		temp=id.replace(/color_/,'');
		temp=temp.replace(/option_/,'');
		s_id=0;
		if(id.indexOf('color_')==0){
			index_key='color_id';
		}else{
			index_key='option_id';
		}
		
		for( v in specifications ){

			if(specifications[v][index_key]==temp){s_id=v;break;}
		}
		
		if(s_id){
			$("#<?php echo $module['module_name'];?> #"+g_id+" .price_span").html('<span class=money_symbol><?php echo self::$language['money_symbol'];?></span><span class=money_value>'+specifications[s_id]['e_price']+'</span>');
			$("#<?php echo $module['module_name'];?> #"+g_id+" .inventory span").html(specifications[s_id]['quantity']);
			$("#<?php echo $module['module_name'];?> #"+g_id).attr('s_id',s_id);
		}
	}



	function add_checkout(id,price){
		//alert(id+','+price);
		var old_cart=getCookie('mall_cart');
		if(old_cart!=''){
			old_cart=old_cart.replace(/%3A/g,':');
			old_cart=old_cart.replace(/%2C/g,',');
			//alert(old_cart);
			old_cart=eval('('+old_cart+')');
			if(old_cart[id]){
				old_cart[id]['quantity']=parseInt(old_cart[id]['quantity'])+1;	
			}else{
				old_cart[id]=new Array();
				old_cart[id]['quantity']=1;		
				old_cart[id]['price']=price;		
			}
			old_cart[id]['time']=Date.parse(new Date());
			str='';
			for(v in old_cart){
				str+='"'+v+'":{"quantity":"'+old_cart[v]['quantity']+'","time":"'+old_cart[v]['time']+'","price":"'+old_cart[v]['price']+'"},';	
			}
			str=str.substring(0,str.length-1);
			str='{'+str+'}';
		}else{
			str='{"'+id+'":{"quantity":"1","time":"'+Date.parse(new Date())+'","price":"'+price+'"}}';
		}
		//alert(str);
		setCookie('mall_cart',str,30);
		try{update_cart_goods_sum();}catch(e){}
		$.get("./receive.php?target=mall::cart&act=update_cart");
	}
	
});
	function return_search_page(){
		alert('return_search_page');	
	}
	
	function swtich_goods_option(to){
		if(to=='right'){
			if($("#myModal").css('display')=='block'){
				is_focus=false;
				$("#<?php echo $module['module_name'];?> #myModal .specifications a").each(function(index, element) {
                    if($(this).attr('is_focus')=='1'){
						$("#<?php echo $module['module_name'];?> #myModal .specifications a").removeAttr('is_focus');
						if($("#<?php echo $module['module_name'];?> #myModal .specifications a").eq(index+1).html()){
							$("#<?php echo $module['module_name'];?> #myModal .specifications a").eq(index+1).attr('is_focus','1');
						}else{
							$("#<?php echo $module['module_name'];?> #myModal .specifications a").eq(0).attr('is_focus','1');
						}
						is_focus=true;return false;
					}
                });
				if(!is_focus){
					$("#<?php echo $module['module_name'];?> #myModal .specifications a").removeAttr('is_focus');
					$("#<?php echo $module['module_name'];?> #myModal .specifications a").eq(0).attr('is_focus','1');
				}
				return false;	
			}
		}else{
			if($("#myModal").css('display')=='block'){
				is_focus=false;
				$("#<?php echo $module['module_name'];?> #myModal .specifications a").each(function(index, element) {
                    if($(this).attr('is_focus')=='1'){
						$("#<?php echo $module['module_name'];?> #myModal .specifications a").removeAttr('is_focus');
						if($("#<?php echo $module['module_name'];?> #myModal .specifications a").eq(index-1).html()){
							$("#<?php echo $module['module_name'];?> #myModal .specifications a").eq(index-1).attr('is_focus','1');
						}else{
							$("#<?php echo $module['module_name'];?> #myModal .specifications a").eq($("#<?php echo $module['module_name'];?> #myModal .specifications a").length-1).attr('is_focus','1');
						}
						is_focus=true;return false;
					}
                });
				if(!is_focus){
					$("#<?php echo $module['module_name'];?> #myModal .specifications a").removeAttr('is_focus');
					$("#<?php echo $module['module_name'];?> #myModal .specifications a").eq(0).attr('is_focus','1');
				}
				return false;	
			}
		}
		return true;
	}
	
</script>

<style>
.page-header{ display:none;}
.fixed_right_div{ display:none;}
#layout_full{ }
.container{ width:100%; padding:0px; margin:0px;}
#<?php echo $module['module_name'];?>{ min-height:520px;}
#<?php echo $module['module_name'];?> .goods_filter{ display:inline-block; vertical-align:top; width:11%; overflow:hidden; background-color:#F6F6F6; height:100%; padding-left:1%; padding-top:15px;}
#<?php echo $module['module_name'];?> .goods_filter li{ list-style:none; cursor:pointer; line-height:30px;}
#<?php echo $module['module_name'];?> .goods_filter li ul{ margin-left:20px;}
#<?php echo $module['module_name'];?> .goods_filter a{ display:block; padding-left:10px;}
#<?php echo $module['module_name'];?> .goods_filter a:hover{ background:#F3F3F3;}
#<?php echo $module['module_name'];?> .goods_filter .selected{ background:#fff;}


#<?php echo $module['module_name'];?>_html{ display:inline-block; vertical-align:top; width:87%; padding-left:1%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .list{  border:1px solid #e7e7e7; padding-bottom:20px;}
#<?php echo $module['module_name'];?>_html .list .goods_list{}


#<?php echo $module['module_name'];?>_html .search_div{ text-align:left; padding-bottom:10px; }
#<?php echo $module['module_name'];?>_html .search_div .search{ width:40%; padding-left:5px; line-height:2.5rem; height:2.5rem; font-size:1.5rem;}
	
	.append_option{ }
	.append_option .goods_a{ display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?>_html .specifications{ line-height:2.5rem;}
	#<?php echo $module['module_name'];?>_html .specifications .color_label{display:inline-block; vertical-align:top; width:50px; text-align:right;}
	#<?php echo $module['module_name'];?>_html .specifications .color_line_div{ }
	#<?php echo $module['module_name'];?>_html .specifications .color_option{display:inline-block; vertical-align:top; line-height:3rem; white-space:normal; width:90%;  }
	#<?php echo $module['module_name'];?>_html .specifications .color_option a{margin-left:10px;  display:inline-block; vertical-align:top; line-height:20px;vertical-align:top; border:1px solid #ccc; overflow:hidden; padding:2px; }
	#<?php echo $module['module_name'];?>_html .specifications .color_option a:hover{ border:1px solid #ff3200; }
	#<?php echo $module['module_name'];?>_html .specifications .color_option a:hover img{}
	#<?php echo $module['module_name'];?>_html .specifications .color_option .selected{border:1px solid #ff3200;}
	#<?php echo $module['module_name'];?>_html .specifications .color_option .disable{ opacity:0.1; filter:alpha(opacity=10); cursor:default;}
	#<?php echo $module['module_name'];?>_html .specifications .color_option .disable:hover{ border:1px solid #ccc;}
	#<?php echo $module['module_name'];?>_html .specifications .color_option a img{ height:20px; width:20px;}
	
	
	#<?php echo $module['module_name'];?>_html .specifications .json{ display:none;}
	#<?php echo $module['module_name'];?>_html .specifications .option_label{ display:inline-block; vertical-align:top;width:50px; text-align:right;}
	#<?php echo $module['module_name'];?>_html .specifications .option_line_div{}
	#<?php echo $module['module_name'];?>_html .specifications .option_option{display:inline-block; vertical-align:top;white-space:normal; width:90%; }
	#<?php echo $module['module_name'];?>_html .specifications .option_option a{ margin-left:10px;  padding-left:4px; padding-right:4px; display:inline-block; vertical-align:top; line-height:30px; height:30px; vertical-align:top;  overflow:hidden; border:1px solid #ddd;}
	#<?php echo $module['module_name'];?>_html .specifications .option_option a:hover{ border:1px solid #ff3200;}
	#<?php echo $module['module_name'];?>_html .specifications .option_option .selected{ border:1px solid #ff3200;}
	#<?php echo $module['module_name'];?>_html .specifications .option_option .disable{ opacity:0.1; filter:alpha(opacity=10); cursor:default;}
	#<?php echo $module['module_name'];?>_html .specifications .option_option .disable:hover{ border:1px solid #ccc;}
	
	#<?php echo $module['module_name'];?>_html .goods_focus{ background-color:#F60; color:#FFF;}
	#<?php echo $module['module_name'];?>_html .goods_focus a{color:#FFF;}
	
	#<?php echo $module['module_name'];?>_html .goods{ white-space:nowrap; text-align:center; padding-bottom:5px; padding-top:5px; border-bottom: 1px dashed #CCCCCC;}
	#<?php echo $module['module_name'];?>_html .goods .goods_icon{ display:inline-block; vertical-align:top; width:8%;text-align:left;}
	#<?php echo $module['module_name'];?>_html .goods .goods_icon img{ width:80%;}
	#<?php echo $module['module_name'];?>_html .goods .goods_info{ display:inline-block; vertical-align:top;width:50%; text-align:left; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .goods .goods_info .title{ display:block;white-space: nowrap;text-overflow: ellipsis; width:100%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .goods .goods_info .specifications{ display:block;}
	
	#<?php echo $module['module_name'];?>_html .goods .price_div{ display:inline-block; vertical-align:top;width:10%;}
	#<?php echo $module['module_name'];?>_html .goods .price_div .price_span{ line-height:80px;}
	#<?php echo $module['module_name'];?>_html .goods .quantity_div{ display:inline-block; vertical-align:top;width:10%;}
	#<?php echo $module['module_name'];?>_html .goods .quantity_div .quantity{  width:50px; text-align:center; margin-top:25px;}
	#<?php echo $module['module_name'];?>_html .goods .quantity_div .inventory{ opacity:0.5;}
	#<?php echo $module['module_name'];?>_html .goods .act_div{ display:inline-block; vertical-align:top;width:20%;}
	#<?php echo $module['module_name'];?>_html .goods .act_div a{ line-height:80px; border:1px solid #ccc; border-radius:5px; padding:5px;}
	#<?php echo $module['module_name'];?>_html .goods .act_div a:hover{ opacity:0.6;}
	#<?php echo $module['module_name'];?>_html .goods .act_div span{ line-height:80px;}
	
	#<?php echo $module['module_name'];?>_html .goods_focus .act_div a{  border:1px solid #fff; }
	#<?php echo $module['module_name'];?>_html .goods_focus .specifications .color_option a{  border:1px solid #F60 ; }
	#<?php echo $module['module_name'];?>_html .goods_focus .specifications .option_option a{  border:1px solid #F60 ; }
	#<?php echo $module['module_name'];?>_html .goods_focus .specifications .color_option a:hover{  border:1px solid #fff ; }
	#<?php echo $module['module_name'];?>_html .goods_focus .specifications .option_option a:hover{  border:1px solid #fff ; }
	#<?php echo $module['module_name'];?>_html .goods_focus .specifications .color_option .selected{  border:1px solid #fff ; }
	#<?php echo $module['module_name'];?>_html .goods_focus .specifications .option_option .selected{  border:1px solid #fff ; }
	
	#myModal .specifications .option_label{ width:10%;}
	#myModal .specifications .color_label{ width:10%;}
	#myModal .specifications a[is_focus]{ background-color: #CCC;}
	.shortcut_key{ float:right; padding-right:10px;}
</style>

<ul class=goods_filter><li><a data=''><?php echo self::$language['all']?><?php echo self::$language['goods']?></a></li><?php echo $module['goods_filter']?></ul><div id="<?php echo $module['module_name'];?>_html">

<div class=search_div><input type="text"  class=search value="<?php echo @$_GET['search']?>" /> <a href="#" class="submit"><?php echo self::$language['search'];?></a><span class=shortcut_key><?php echo self::$language['shortcut_key']?>: Enter ESC ↑↓←→</span></div>
    <div class=content>
    	<div class="list_head goods"><div class=goods_icon><?php echo self::$language['image']?></div><div class=goods_info><?php echo self::$language['goods']?><?php echo self::$language['info']?></div><div class=price_div><?php echo self::$language['price']?></div><div class=quantity_div><?php echo self::$language['quantity']?></div><div class=act_div><?php echo self::$language['operation']?></div></div>
		<div class=list>
			<div class=goods_list><?php echo $module['list'];?></div>
        </div>
    </div>
    <?php echo $module['page']?>
    <div id=color_selected_symbol> </div><div id=option_selected_symbol> </div>


        
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
               <b><?php echo self::$language['please_select'];?></b>
            </h4>
         </div>
         <div class="modal-body">
             <div class=specifications></div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal"><?php echo self::$language['close']?>
            </button>
            
         </div>
      </div>
</div>
        
<script>
function monxin_page_go(v){return false;}
</script>
</div>
</div>