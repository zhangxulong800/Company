<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left style="width:98%;" >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?> .del").click(function(){
		id=$(this).parent().parent().attr('id');
		$(this).parent().parent().animate({opacity:0},"slow",function(){$("#"+id).css('display','none');});
		$.get('<?php echo $module['action_url'];?>&act=del&id='+id,function(data){
			//alert(data);
		});
		return false;
	});
	$("#<?php echo $module['module_name'];?> .clear_all").click(function(){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){

			$("#<?php echo $module['module_name'];?> .content").animate({opacity:0},"slow",function(){$("#<?php echo $module['module_name'];?> .content").css('display','none');});
			$.get('<?php echo $module['action_url'];?>&act=clear_all',function(data){
				//alert(data);
			});
		}
		return false;
	});
});

</script>

<style>
#<?php echo $module['module_name'];?>{}
#<?php echo $module['module_name'];?>_html{background:#fff;}
#<?php echo $module['module_name'];?>_html a{}
#<?php echo $module['module_name'];?>_html .top{ text-align:right; padding-top:10px;}
#<?php echo $module['module_name'];?>_html .top .clear_all{height:25px; line-height:25px; display:inline-block;}
#<?php echo $module['module_name'];?>_html .top .clear_all:before{font: normal normal normal 1rem/1 FontAwesome;content: "\f014";margin-left: 2px;margin-right: 6px;}
#<?php echo $module['module_name'];?>_html .goods{ display:inline-block; vertical-align:top;; width:16%; margin:2%; overflow:hidden; text-align:center
;}
#<?php echo $module['module_name'];?>_html .goods:hover{ opacity:0.8;}
#<?php echo $module['module_name'];?>_html .goods .goods_a img{ border:none; height:12.85rem;}
#<?php echo $module['module_name'];?>_html .goods .goods_a .title{ text-align:left; display:block; line-height:25px; font-size:15px; height:50px; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .goods .sub_div{ opacity:0.5; text-align:left; line-height:16px; height:16px; margin-top:5px;}
#<?php echo $module['module_name'];?>_html .goods .sub_div .time{ text-align:left; display:inline-block; vertical-align:top;}
#<?php echo $module['module_name'];?>_html .goods .sub_div .del{vertical-align:top;float:right; width:16px; height:16px; text-align:right;}
#<?php echo $module['module_name'];?>_html .goods .sub_div .del:before{font: normal normal normal 1rem/1 FontAwesome;content: "\f014";margin-left: 2px;margin-right: 6px;}

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">


    <div class=content>
    	<div class=top><a href="#" class=clear_all><?php echo self::$language['clear_all'];?></a></div>
		<div class=list>
			<div class=goods_list><?php echo $module['list'];?></div>
        </div>
    </div>
    <?php echo $module['page']?>
</div>
</div>