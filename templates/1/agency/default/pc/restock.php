<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?>_html .parent").css('width',$(window).width()-$("#<?php echo $module['module_name'];?>_html .show_sub_div_out").width());
	$("#<?php echo $module['module_name'];?>_html").height($(window).height());
	type=get_param('type');
	if(type==''){
		$("#<?php echo $module['module_name'];?>_html .parent:first").addClass('parent_current');	
	}else{
		$("#<?php echo $module['module_name'];?>_html .parent[type_id="+type+"]").addClass('parent_current');
	}
	
	$("#<?php echo $module['module_name'];?> .agency").click(function(){
		id=$(this).attr('d_id');
		$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span><?php echo self::$language['executing'];?>');
		$.post('<?php echo $module['action_url'];?>&act=agency',{id:id} ,function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#<?php echo $module['module_name'];?> [d_id="+id+"]").next().html(v.info);
		});
		return false;   
	}); 
});
</script>
<style>
#<?php echo $module['module_name'];?>{ margin:0px; padding:0px; margin-top:1rem;}
#<?php echo $module['module_name'];?>_html{  }
#<?php echo $module['module_name'];?>_html .parent{ display:block; line-height:3.5rem; height:3.5rem; overflow:hidden; padding-left:1rem;}
#<?php echo $module['module_name'];?>_html .parent:hover{ font-weight:bold;}
#<?php echo $module['module_name'];?>_html .parent_current{ background-color:#FFF; border-right:none; border-left:#F60 3px solid; margin-left:1px;}
#<?php echo $module['module_name'];?>_html .parent .icon{ display:none;}
#<?php echo $module['module_name'];?>_html .parent .icon img{display:none;}
#<?php echo $module['module_name'];?>_html .parent .name{ display:inline-block; vertical-align:top; margin-left:8px;}

#<?php echo $module['module_name'];?>_html .title{ height:40px; padding-left:10px; line-height:40px; border-top:#F00 2px solid; background-color:#F5F5F5; box-shadow: 0px 1px 2px;}
#<?php echo $module['module_name'];?>_html .title .icon{ display:inline-block; vertical-align:top;  vertical-align:middle;}
#<?php echo $module['module_name'];?>_html .title .icon img{ width:40px; height:40px; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .title .name{ display:inline-block; vertical-align:top; margin-left:8px;}

#<?php echo $module['module_name'];?>_html .sub_div{ display:none; background-color:#fff;width:100%; }
#<?php echo $module['module_name'];?>_html .sub_2{ border-bottom:1px dotted #e7e7e7; padding-bottom:10px; padding-top:10px;}




#<?php echo $module['module_name'];?>_html{ white-space:nowrap;}
.parent_type_out{display:inline-block; vertical-align:top; width:30%; overflow:hidden; height:100%;background-color:#f3f4f6; }
.show_sub_div_out{display:inline-block; vertical-align:top; width:70%; overflow:hidden; height:100%;}
.parent_type_out .parent_type{ width:120%; height:100%; overflow:hidden; overflow-y:scroll;  }
#<?php echo $module['module_name'];?>_html .parent_type .parent{ display:block;border-bottom:#e0e0e0  1px solid;border-right:#e0e0e0  1px solid;}
.show_sub_div{width:110%; height:100%; overflow:hidden; overflow-y:scroll; padding:0.4rem;}
.show_sub_div .title{ display:none;}
.show_sub_div .remark img{ max-width:100%;}

#<?php echo $module['module_name'];?>_html .line{ margin-bottom:1rem; border-bottom: 1px dashed #CCCCCC;}
#<?php echo $module['module_name'];?>_html .line:hover{ border-bottom: 1px dashed  #FF3300;}
#<?php echo $module['module_name'];?>_html .line .goods_img{ display:inline-block; vertical-align:top; width:12%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .line .goods_img img{ width:90%;}
#<?php echo $module['module_name'];?>_html .line .good_info{display:inline-block; vertical-align:top; width:88%; overflow:hidden;}
#<?php echo $module['module_name'];?>_html .line .good_info .title{ display:block; background:none; border:none; box-shadow:none;}
.agency{color:#fff !important;}
.agency_info{}
.agency_info a{ display:inline-block; vertical-align:top; background-color:#F60; color:#fff; border-radius:0.5rem; padding-left:0.5rem; padding-right:0.5rem; line-height:1.5rem;}
.agency_info a:hover{ opacity:0.8;}

#<?php echo $module['module_name'];?>_html .price_span{ color:#F00; line-height:2rem;}
#<?php echo $module['module_name'];?>_html .already_agency{ padding-left:0.5rem; color:#999;}
</style>
<div id="<?php echo $module['module_name'];?>_html">
	<div class=parent_type_out><div class=parent_type><?php echo $module['type'];?></div></div><div class=show_sub_div_out>
    	<div class=show_sub_div>
            <?php echo $module['content'];?>
    	</div>
    </div>
    <?php echo $module['page']?>
</div>
</div>