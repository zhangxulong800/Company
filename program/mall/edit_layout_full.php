<?php
$edit_malllayout_language=require './language/'.self::$config['web']['language'].'.php';
$edit_panel='<p id=edit_page_layout_div style="display:none;"><span id=save_composing_state></span><a class=add_module href="./index.php?monxin=mall.edit_page_layout_add_module&area=head&url=">'.$edit_malllayout_language['add']. $edit_malllayout_language['module'].'</a><a href=# id=save_composing>'.$edit_malllayout_language['save'].$edit_malllayout_language['composing'].'</a><a href=# id=cancel_composing>'.$edit_malllayout_language['cancel'].$edit_malllayout_language['composing'].'</a><a href="./index.php?monxin=mall.edit_page_layout&program=mall&url='.$_GET['monxin'].'" id=expert_mode>'.$edit_malllayout_language['expert_mode'].'</a><a href=# id=switch_composing>'.$edit_malllayout_language['switch'].$edit_malllayout_language['composing'].'</a>
     <span id=composing_selection style="display:none;">
     	<a class=set_composing_full href="#" title="'.$edit_malllayout_language['full_screen'].'"></a>
     	<a class=set_composing_right href="#" title="'.$edit_malllayout_language['right_screen'].'"></a>
     	<a class=set_composing_left href="#" title="'.$edit_malllayout_language['left_screen'].'"></a>
        <span id=set_composing_state></span>
     </span>

     </span>
     </p>';
	 
echo $edit_panel;	 
?>
<script>
$(document).ready(function(){
	$(".set_composing_full").css('display','none');
    $("#edit_page_layout_div").css('display','block');
    $( "[shop_layout]" ).sortable({
      connectWith: "[shop_layout]"
    }).disableSelection();	


 
	$('#edit_page_layout_div .add_module').click(function(){
		temp=window.location.href.split('index.php?');
		if(temp[1]){temp=temp[1].replace(/&/g,'|||');}else{temp='';}
		$(this).attr('href',$(this).attr('href')+get_param('monxin')+'&params='+temp);
	});
	$('#edit_page_layout_div #save_composing').click(function(){
		var m_head='';
		var m_left='';
		var m_right='';
		var m_full='';
		var m_bottom='';
		
		$("[shop_layout=head] [monxin-module]").each(function(index, element) {
			if($(this).attr('save_name')){m_head+=$(this).attr('save_name')+',';}else{ m_head+=$(this).attr('monxin-module')+',';}
        });
		$("[shop_layout=left] [monxin-module]").each(function(index, element) {
			if($(this).attr('save_name')){m_left+=$(this).attr('save_name')+',';}else{ m_left+=$(this).attr('monxin-module')+',';}
        });
		$("[shop_layout=right] [monxin-module]").each(function(index, element) {
			if($(this).attr('save_name')){m_right+=$(this).attr('save_name')+',';}else{ m_right+=$(this).attr('monxin-module')+',';}
        });
		$("[shop_layout=full] [monxin-module]").each(function(index, element) {
			if($(this).attr('save_name')){m_full+=$(this).attr('save_name')+',';}else{ m_full+=$(this).attr('monxin-module')+',';}
        });
		$("[shop_layout=bottom] [monxin-module]").each(function(index, element) {
			if($(this).attr('save_name')){m_bottom+=$(this).attr('save_name')+',';}else{ m_bottom+=$(this).attr('monxin-module')+',';}
        });
		
		if($("[shop_layout=full]").html()){
			layout='full';	
		}else{
			if($("[shop_layout=left]").next().attr('shop_layout')=='right'){
				layout='left';	
			}else{
				layout='right';	
			}	
		}
		//alert(layout);
		$('#edit_page_layout_div #save_composing').html('<span class=\'fa fa-spinner fa-spin\'></span>');
		//alert(m_head+','+m_left+','+m_right+','+m_full+','+m_bottom);
		$.post("./receive.php?target=mall::edit_page_layout&act=save_composing&malllayout="+layout+"&monxin="+get_param('monxin'), {m_head:m_head,m_left:m_left,m_right:m_right,m_full:m_full,m_bottom:m_bottom},function(data){
			//alert(data);
			v=eval("("+data+")");
			
			$('#edit_page_layout_div #save_composing').html(v.info);
			if(v.state=='success'){
				url=window.location.href;
				url=replace_get(url,'edit_mall_layout',' ');
				if(get_param('monxin')==''){url='index.php';}
				window.location.href=url;	 
			}
		});
	});
	
	$('#edit_page_layout_div #cancel_composing').click(function(){
				url=window.location.href;
				url=replace_get(url,'edit_mall_layout',' ');
				if(get_param('monxin')==''){url='index.php';}
				window.location.href=url;	 
	});
	
	$("#edit_page_layout_div #switch_composing").click(function(){
		$("#edit_page_layout_div #composing_selection").slideToggle();
		return false;
	});


	$("#composing_selection a").click(function(){
		//return false;
		css=$(this).attr('class');
		if(css=='set_composing_full_use' || css=='set_composing_right_use' || css=='set_composing_left_use'){$("#set_composing_state").html('');return false;}
		//monxin_alert(css);
		$("#set_composing_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$("#set_composing_state").load("receive.php?target=mall::edit_page_layout&act=switch_composing&layout=full&monxin="+get_param('monxin')+'&to='+css,function(){
                if($(this).html().length>5){
                    //monxin_alert($(this).html());
                    v=eval("("+$(this).html()+")");
                    $(this).html(v.info);
                    if(v.state=='success'){
						$(this).html('');
						window.location.reload();	
					}
                }	
        });
		
		
		return false;
	});
	
	$("[monxin-module]").each(function(index, element) {
       	//$(this).prev('.layout_button_div')
		//$(this).append($(this).prev('.layout_button_div'));
		//$(this).css('height','auto');
    });
	
	$("[monxin-module]").hover(function(){
		//$(this).prev('.layout_button_div').css('display','block');	
	},function(){
		//$(this).prev('.layout_button_div').css('display','none');	
	});
	











	
	
	
	
   
    
    
    
	
	$("[monxin-module]").each(function(index, element) {
		 $($(this)).prepend($(this).prev('.layout_button_div'));      
    });
    
	$(".module_del").click(function(){
		page=get_param('monxin');
		if(page==''){page='index.index';}
		page=page.replace(/\./,'_');
		//monxin_alert($(this).parent().parent().prev().attr('id')+','+page);
		module_name=$(this).parent().parent('[monxin-module]').attr('id').replace(/_\d{1,}/,'');
		//monxin_alert(module_name);
		if(module_name==page){
			monxin_alert('<?php echo $edit_malllayout_language['this_is_the_main_module_of_the_page_can_not_be_remove'];?>');
			return false;	
		}
		
		
		$(this).parent().parent('[monxin-module]').remove();
        $(this).parent().remove();
		return false;	
	});
	
	$(".module_edit_content").each(function(index, element) {
    	module_name=$(this).parent().parent('[monxin-module]').attr('id');   
		$(this).attr('href','receive.php?target=mall::edit_page_layout&id=<?php echo @$_GET['id'];?>&act=go_module_content&module='+module_name);
    });
	$(".module_edit_template").each(function(index, element) {
		temp=$(this).parent().parent('[monxin-module]').attr('id');
		if(temp){
    		module_name=temp.replace(/_\d{1,}/,'');   
			//monxin_alert(module_name);
			$(this).attr('href','receive.php?target=mall::edit_page_layout&act=go_module_template&module='+module_name);
		}
    });
	$(".module_edit_quantity").each(function(index, element) {
    	module_name=$(this).parent().parent('[monxin-module]').attr('id');   
		//monxin_alert(module_name);
		$(this).attr('href','index.php?monxin=mall.set_module_data_quantity&module='+module_name);
    });
		
	$(".module_edit_quantity").click(function(){
		set_iframe_position(500,100);
		$("#fade_div").css('display','block');
		$("#set_monxin_iframe_div").css('display','block');
		$("#monxin_iframe").attr('src',$(this).attr('href'));		
		return false;
	});
    
	
});
</script>
<link rel="stylesheet" href="<?php echo $css_path;?>" type="text/css">
<style>
.ui-sortable{ min-height:200px;}
.ui-sortable [monxin-module] a,ul,li{cursor:move; }
.ui-sortable [monxin-module] a:hover{cursor:move; }
.ui-sortable [monxin-module]{cursor:move; }
</style>
<div id=mall_layout >

    <!--top_malllayout_start-->
	<div id='top_malllayout_out' align="center">
     	<div id='top_malllayout_inner' align="center">
            <div id='malllayout_top'  shop_layout="head">
            	<?php foreach($modules['head'] as $v){?>
                	<?php 
				if($v['args']!='' && !is_numeric($v['args'])){
					$attribute_set_url='./index.php?monxin='.get_class($v['object']).'.'.$v['method'].'_set&args='.urlencode($v['args']).'&url='.$_GET['monxin'].'&id='.@$_GET['id'];
					$attribute='<a href="'.$attribute_set_url.'" class="module_edit_attribute">'.$edit_malllayout_language['attribute'].'</a>';
				}else{
					$module_config=require('./program/'.get_class($v['object']).'/module_config.php');
					if(is_numeric(@$module_config[get_class($v['object']).'.'.$v['method']]['pagesize'])){
						$attribute='<a href="#"  class="module_edit_quantity" target="_blank">'.$edit_malllayout_language['quantity'].'</a>';
					}else{
						$attribute='';
					}
				}
				?>
                <div class=layout_button_div><a href="#" class="module_edit_content" target="_blank"><?php echo $edit_malllayout_language['content'];?></a><?php echo $attribute;?><a href="#" class=module_del><?php echo $edit_malllayout_language['remove'];?></a></div>
                	<?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
                <?php }?>
            </div>
		</div>
    </div>
    <!--top_malllayout_end-->
    <!--middle_malllayout_start-->
    <div id='middle_malllayout_out' align="center">
        <div id='middle_malllayout_inner'  class="container">
            <div id='malllayout_full' shop_layout="full">
            	<?php foreach($modules['full'] as $v){?>
                	<?php 
				if($v['args']!='' && !is_numeric($v['args'])){
					$attribute_set_url='./index.php?monxin='.get_class($v['object']).'.'.$v['method'].'_set&args='.urlencode($v['args']).'&url='.$_GET['monxin'].'&id='.@$_GET['id'];
					$attribute='<a href="'.$attribute_set_url.'" class="module_edit_attribute">'.$edit_malllayout_language['attribute'].'</a>';
				}else{
					$module_config=require('./program/'.get_class($v['object']).'/module_config.php');
					if(is_numeric(@$module_config[get_class($v['object']).'.'.$v['method']]['pagesize'])){
						$attribute='<a href="#"  class="module_edit_quantity" target="_blank">'.$edit_malllayout_language['quantity'].'</a>';
					}else{
						$attribute='';
					}
				}
				?>
                <div class=layout_button_div><a href="#" class="module_edit_content" target="_blank"><?php echo $edit_malllayout_language['content'];?></a><?php echo $attribute;?><a href="#" class=module_del><?php echo $edit_malllayout_language['remove'];?></a></div>
                	<?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
                <?php }?>
            </div>
        
        </div>
    
    </div>
    <!--middle_malllayout_end-->
    <!--bottom_malllayout_start-->
	<div id='bottom_malllayout_out' align="center">
     	<div id='bottom_malllayout_inner'>
            <div id=mall'layout_bottom'  shop_layout="bottom">
            	<?php foreach($modules['bottom'] as $v){?>
                	<?php 
				if($v['args']!='' && !is_numeric($v['args'])){
					$attribute_set_url='./index.php?monxin='.get_class($v['object']).'.'.$v['method'].'_set&args='.urlencode($v['args']).'&url='.$_GET['monxin'].'&id='.@$_GET['id'];
					$attribute='<a href="'.$attribute_set_url.'" class="module_edit_attribute">'.$edit_malllayout_language['attribute'].'</a>';
				}else{
					$module_config=require('./program/'.get_class($v['object']).'/module_config.php');
					if(is_numeric(@$module_config[get_class($v['object']).'.'.$v['method']]['pagesize'])){
						$attribute='<a href="#"  class="module_edit_quantity" target="_blank">'.$edit_malllayout_language['quantity'].'</a>';
					}else{
						$attribute='';
					}
				}
				?>
                <div class=layout_button_div><a href="#" class="module_edit_content" target="_blank"><?php echo $edit_malllayout_language['content'];?></a><?php echo $attribute;?><a href="#" class=module_del><?php echo $edit_malllayout_language['remove'];?></a></div>
                	<?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
                <?php }?>
            </div>
		</div>
    </div>
     <!--bottom_layout_end-->
</div>
