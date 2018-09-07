<!DOCTYPE html>
<head>
<link rel="shortcut icon" href="favicon.ico"/>
<?php echo $_POST['diy_meta'];?>
<meta charset="utf-8" />
<title><?php echo $head['title']?></title>
<meta name=keywords content="<?php echo $head['keywords']?>">
<meta name="description" content="<?php echo $head['description']?>">
<meta name="generator" content="梦行Monxin" />
<meta name="author" content="梦行Monxin Team" />
<meta name="renderer" content="webkit" />
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1;" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link href="./public/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="./public/animate.min.css" rel="stylesheet" type="text/css">
<link href="./templates/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
<script src="./public/jquery.js"></script>
<script src="./public/jquery-ui.min.js"></script>
<script src="./public/blocksit.min.js"></script>
<script src="./templates/bootstrap/js/bootstrap.js" type="text/javascript"></script>
<script src="./public/sys_head.js"></script>
<script src="./public/top_ajax_form.js"></script>
<script>
$(document).ready(function(){
	$(".set_composing_right").css('display','none');
    $("#edit_page_layout_div").css('display','block');
    $( "[monxin_layout]" ).sortable({
      connectWith: "[monxin_layout]"
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
		
		$("[monxin_layout=head] [monxin-module]").each(function(index, element) {
			if($(this).attr('save_name')){m_head+=$(this).attr('save_name')+',';}else{ m_head+=$(this).attr('monxin-module')+',';}
        });
		$("[monxin_layout=left] [monxin-module]").each(function(index, element) {
			if($(this).attr('save_name')){m_left+=$(this).attr('save_name')+',';}else{ m_left+=$(this).attr('monxin-module')+',';}
        });
		$("[monxin_layout=right] [monxin-module]").each(function(index, element) {
			if($(this).attr('save_name')){m_right+=$(this).attr('save_name')+',';}else{ m_right+=$(this).attr('monxin-module')+',';}
        });
		$("[monxin_layout=full] [monxin-module]").each(function(index, element) {
			if($(this).attr('save_name')){m_full+=$(this).attr('save_name')+',';}else{ m_full+=$(this).attr('monxin-module')+',';}
        });
		$("[monxin_layout=bottom] [monxin-module]").each(function(index, element) {
			if($(this).attr('save_name')){m_bottom+=$(this).attr('save_name')+',';}else{ m_bottom+=$(this).attr('monxin-module')+',';}
        });
		
		if($("[monxin_layout=full]").html()){
			layout='full';	
		}else{
			if($("[monxin_layout=left]").next().attr('monxin_layout')=='right'){
				layout='left';	
			}else{
				layout='right';	
			}	
		}
		
		$('#edit_page_layout_div #save_composing').html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.post("./receive.php?target=index::edit_page_layout&act=save_composing&layout="+layout+"&monxin="+get_param('monxin'), {m_head:m_head,m_left:m_left,m_right:m_right,m_full:m_full,m_bottom:m_bottom},function(data){
			//alert(data);
			v=eval("("+data+")");
			
			$('#edit_page_layout_div #save_composing').html(v.info);
			if(v.state=='success'){
				url=window.location.href;
				url=replace_get(url,'edit_page_layout',' ');
				if(get_param('monxin')==''){url='index.php';}
				window.location.href=url;	 
			}
		});
	});
	
	$('#edit_page_layout_div #cancel_composing').click(function(){
				url=window.location.href;
				url=replace_get(url,'edit_page_layout',' ');
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
		$("#set_composing_state").load("receive.php?target=index::edit_page_layout&act=switch_composing&layout=full&monxin="+get_param('monxin')+'&to='+css,function(){
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
			monxin_alert('<?php echo $edit_layout_language['this_is_the_main_module_of_the_page_can_not_be_remove'];?>');
			return false;	
		}
		
		
		$(this).parent().parent('[monxin-module]').remove();
        $(this).parent().remove();
		return false;	
	});
	
	
	$(".module_edit_content").each(function(index, element) {
    	module_name=$(this).parent().parent('[monxin-module]').attr('id'); 
		if($(this).parent().parent('[monxin-module]').attr('save_name')){
			module_name=$(this).parent().parent('[monxin-module]').attr('save_name');
			module_name=module_name.split('(');
			module_name=module_name[0];
		}	
		$(this).attr('href','receive.php?target=index::edit_page_layout&id=<?php echo @$_GET['id'];?>&act=go_module_content&module='+module_name);
    });
	$(".module_edit_template").each(function(index, element) {
		temp=$(this).parent().parent('[monxin-module]').attr('id');
		if($(this).parent().parent('[monxin-module]').attr('save_name')){
			temp=$(this).parent().parent('[monxin-module]').attr('save_name');
			temp=temp.split('(');
			temp=temp[0];
		}	
		
		if(temp){
    		module_name=temp.replace(/_\d{1,}/,'');   
			//monxin_alert(module_name);
			$(this).attr('href','receive.php?target=index::edit_page_layout&act=go_module_template&module='+module_name);
		}
    });
	$(".module_edit_quantity").each(function(index, element) {
    	module_name=$(this).parent().parent('[monxin-module]').attr('id');   
		if($(this).parent().parent('[monxin-module]').attr('save_name')){
			module_name=$(this).parent().parent('[monxin-module]').attr('save_name');
			module_name=module_name.split('(');
			module_name=module_name[0];
		}	
		//monxin_alert(module_name);
		$(this).attr('href','index.php?monxin=index.set_module_data_quantity&module='+module_name);
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
<?php echo $color_data;?>

<link rel="stylesheet" href="<?php  echo  $css_path;?>" type="text/css">
<style>
[monxin_layout]{ padding-bottom:10rem;}
.ui-sortable{ min-height:200px;}
.ui-sortable [monxin-module] a,ul,li{cursor:move; }
.ui-sortable [monxin-module] a:hover{cursor:move; }
.ui-sortable [monxin-module]{cursor:move; }

</style>
</head>
<body >

<!--BEGIN HEADER -->
<div class="page-header" monxin_layout="head" user_color='head'>
    <?php foreach($modules['head'] as $v){?>

         <?php 
            if($v['args']!=''){
                $attribute_set_url='./index.php?monxin='.get_class($v['object']).'.'.$v['method'].'_set&args='.urlencode($v['args']).'&url='.$_GET['monxin'].'&id='.@$_GET['id'];
                $attribute='<a href="'.$attribute_set_url.'" class="module_edit_attribute">'.$edit_layout_language['attribute'].'</a>';
            }else{
                $module_config=require('./program/'.get_class($v['object']).'/module_config.php');
                if(is_numeric(@$module_config[get_class($v['object']).'.'.$v['method']]['pagesize'])){
                    $attribute='<a href="#"  class="module_edit_quantity" target="_blank">'.$edit_layout_language['quantity'].'</a>';
                }else{
                    $attribute='';
                }

            }
            ?>     
       <div class=layout_button_div><a href="#" class="module_edit_content" target="_blank"><?php echo $edit_layout_language['content'];?></a><a href="#" class="module_edit_template" target="_blank"><?php echo $edit_layout_language['template'];?></a><?php echo $attribute;?><a href="#" class=module_del><?php echo $edit_layout_language['remove'];?></a></div>
        <?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
    <?php }?>
</div>
<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container" user_color='container'>
   <div class="page-content">
	    <div class="container" m_container="m_container"> 
            <div class=row><div class=col-md-3 monxin_layout="left">
                <?php foreach($modules['left'] as $v){?>
 
         <?php 
            if($v['args']!=''){
                $attribute_set_url='./index.php?monxin='.get_class($v['object']).'.'.$v['method'].'_set&args='.urlencode($v['args']).'&url='.$_GET['monxin'].'&id='.@$_GET['id'];
                $attribute='<a href="'.$attribute_set_url.'" class="module_edit_attribute">'.$edit_layout_language['attribute'].'</a>';
            }else{
                $module_config=require('./program/'.get_class($v['object']).'/module_config.php');
                if(is_numeric(@$module_config[get_class($v['object']).'.'.$v['method']]['pagesize'])){
                    $attribute='<a href="#"  class="module_edit_quantity" target="_blank">'.$edit_layout_language['quantity'].'</a>';
                }else{
                    $attribute='';
                }

            }
            ?>     
       <div class=layout_button_div><a href="#" class="module_edit_content" target="_blank"><?php echo $edit_layout_language['content'];?></a><a href="#" class="module_edit_template" target="_blank"><?php echo $edit_layout_language['template'];?></a><?php echo $attribute;?><a href="#" class=module_del><?php echo $edit_layout_language['remove'];?></a></div>                  
                   
                    <?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
                <?php }?></div><div class=col-md-9 monxin_layout="right">
                <?php foreach($modules['right'] as $v){?>
 
         <?php 
            if($v['args']!=''){
                $attribute_set_url='./index.php?monxin='.get_class($v['object']).'.'.$v['method'].'_set&args='.urlencode($v['args']).'&url='.$_GET['monxin'].'&id='.@$_GET['id'];
                $attribute='<a href="'.$attribute_set_url.'" class="module_edit_attribute">'.$edit_layout_language['attribute'].'</a>';
            }else{
                $module_config=require('./program/'.get_class($v['object']).'/module_config.php');
                if(is_numeric(@$module_config[get_class($v['object']).'.'.$v['method']]['pagesize'])){
                    $attribute='<a href="#"  class="module_edit_quantity" target="_blank">'.$edit_layout_language['quantity'].'</a>';
                }else{
                    $attribute='';
                }

            }
            ?>     
       <div class=layout_button_div><a href="#" class="module_edit_content" target="_blank"><?php echo $edit_layout_language['content'];?></a><a href="#" class="module_edit_template" target="_blank"><?php echo $edit_layout_language['template'];?></a><?php echo $attribute;?><a href="#" class=module_del><?php echo $edit_layout_language['remove'];?></a></div>                  
                    <?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
                <?php }?>
            </div></div>        
        </div>
    </div>
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer" monxin_layout="bottom" user_color='shape_bottom'>
    <?php foreach($modules['bottom'] as $v){?>
       

         <?php 
            if($v['args']!=''){
                $attribute_set_url='./index.php?monxin='.get_class($v['object']).'.'.$v['method'].'_set&args='.urlencode($v['args']).'&url='.$_GET['monxin'].'&id='.@$_GET['id'];
                $attribute='<a href="'.$attribute_set_url.'" class="module_edit_attribute">'.$edit_layout_language['attribute'].'</a>';
            }else{
                $module_config=require('./program/'.get_class($v['object']).'/module_config.php');
                if(is_numeric(@$module_config[get_class($v['object']).'.'.$v['method']]['pagesize'])){
                    $attribute='<a href="#"  class="module_edit_quantity" target="_blank">'.$edit_layout_language['quantity'].'</a>';
                }else{
                    $attribute='';
                }

            }
            ?>     
       <div class=layout_button_div><a href="#" class="module_edit_content" target="_blank"><?php echo $edit_layout_language['content'];?></a><a href="#" class="module_edit_template" target="_blank"><?php echo $edit_layout_language['template'];?></a><?php echo $attribute;?><a href="#" class=module_del><?php echo $edit_layout_language['remove'];?></a></div>       
        <?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
    <?php }?>

    <script src="./public/sys_foot.js"></script>

</div>
<!-- END FOOTER -->
	 <div class=fixed_right_div >
		<div class=fixed_right_div_inner>
			<div class=share_text style="display:none;" share_title="<?php echo $share_title?>"  share_url="<?php echo $share_url?>" ><?php echo $share_text;?></div>
			<?php echo de_safe_str(file_get_contents('./program/index/right_buttons_'.$_COOKIE['monxin_device'].'_data.txt'));?>
		</div>
	 </div>
	 <div class=right_notice><span></span></div>
     <audio id="notice_audio" autoplay></audio>
     <p id=fade_div>
     <p id=set_monxin_iframe_div>
     	<a href=# id=close_button  title="<?php echo C_CLOSE;?>">&nbsp;</a>
     	<iframe  id=monxin_iframe frameborder=0 src='' scrolling="no" marginwidth=0 marginheight=0 vspace=0 hspace=0 allowtransparency=true></iframe>
    </p>
	</p>
<div class="ie_warning modal fade"  tabindex="-1" role="dialog"   aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal" aria-hidden="true">
                      &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                   <b>亲！您的浏览器太out了，很多功能无法正常使用。	</b>
                </h4>
             </div>
             <div class="modal-body">
                换个潮点的浏览器吧，您会发现网页会更有趣哦！ <a href=http://www.baidu.com/s?wd=chrome target=_blank>点击搜索谷歌浏览器</a>
                <div ></div>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-default" 
                   data-dismiss="modal">不，我偏要用这个悲催的浏览器 > ></button>
                
             </div>
          </div> 
      </div>
</div>
     <?php echo $edit_panel;?>

</body>
</html>