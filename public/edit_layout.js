$(document).ready(function(){
	
	set_border();
	$("#close_button").click(function(){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
	});
	$(".module_del").click(function(){
		page=get_param('monxin');
		if(page==''){page='index.index';}
		page=page.replace(/\./,'_');
		//alert($(this).parent().parent().prev().attr('id')+','+page);
		module_name=$(this).parent().parent().prev().attr('id').replace(/_\d{1,}/,'');
		//alert(module_name);
		if(module_name==page){
			alert('<?php echo $edit_layout_language['this_is_the_main_module_of_the_page_can_not_be_remove'];?>');
			return false;	
		}
		
		
		$(this).parent().parent().parent().attr('class','monxin_module_div_deleted');
		return false;	
	});
	
	$(".module_edit_content").each(function(index, element) {
    	module_name=$(this).parent().parent().prev().attr('id');   
		//alert(module_name);
		$(this).attr('href','receive.php?target=index::edit_page_layout&id=<?php echo @$_GET['id'];?>&act=go_module_content&module='+module_name);
    });
	$(".module_edit_template").each(function(index, element) {
    	module_name=$(this).parent().parent().prev().attr('id').replace(/_\d{1,}/,'');   
		//alert(module_name);
		$(this).attr('href','receive.php?target=index::edit_page_layout&act=go_module_template&module='+module_name);
    });
	$(".module_edit_quantity").each(function(index, element) {
    	module_name=$(this).parent().parent().prev().attr('id');   
		//alert(module_name);
		$(this).attr('href','index.php?monxin=index.set_module_data_quantity&module='+module_name);
    });
	$(".module_edit_quantity").click(function(){
		$("#fade_div").css('display','block');
		$("#set_monxin_iframe_div").css('display','block');
		$("#monxin_iframe").attr('src',$(this).attr('href'));
		return false;
	});
	
	
	$("#cancel_composing").click(function(){
		url=window.location.href;
		url=replace_get(url,'edit_page_layout','false');
		url=url.replace(/edit_page_layout=true/g,'');
		window.location.href=url;	
		return false;
	});
	
	$("#switch_composing").click(function(){
		$("#composing_selection").slideToggle();
		return false;
	});
	
	$(".add_module").click(function(){
		area=$(this).attr('area');
		page=get_param('monxin');
		temp=window.location.href.split(page);
		params=temp[1].replace(/&/g,'|||');
		url='index.php?monxin=index.edit_page_layout_add_module&url='+page+'&area='+area+'&params='+params;
		//alert(url);
		window.location.href=url;	
		return false;
	});	

	$("#composing_selection a").click(function(){
		return false;
		css=$(this).attr('class');
		if(css=='set_composing_full_use' || css=='set_composing_right_use' || css=='set_composing_left_use'){$("#set_composing_state").html('');return false;}
		//alert(css);
		$("#set_composing_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$("#set_composing_state").load("receive.php?target=index::edit_page_layout&act=switch_composing&layout=full&monxin="+get_param('monxin')+'&to='+css,function(){
                if($(this).html().length>5){
                    //alert($(this).html());
                    v=eval("("+$(this).html()+")");
                    $(this).html(v.info);
                    if(v.state=='success'){
						$(this).html('');
						alert("<?php echo $edit_layout_language['success'];?>");
						url=window.location.href;
						window.location.href=url;	
					}
                }	
        });
		
		
		return false;
	});

















});
