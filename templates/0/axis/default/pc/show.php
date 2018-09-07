<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>  table select").each(function(index, element) {
            if($(this).attr('monxin_value')){$(this).val($(this).attr('monxin_value'));}
        });
		
		$("#<?php echo $module['module_name'];?> tr .state").each(function(index, element) {
            if($(this).attr('monxin_value')==1){$(this).prop('checked',true);}
        });
		
		$(document).on('click','#<?php echo $module['module_name'];?> .set_content',function(){
			set_iframe_position($(window).width()-100,$(window).height()-20);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		reset_icon_span_height();
		 window.setTimeout("reset_icon_span_height()",100);
		 window.setTimeout("reset_icon_span_height()",1000);
		 $.get("<?php echo $module['count_url']?>");
    });
    
    
    
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#act_state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false;	
        
    }
    
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#act_state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#state_select").html(v.info);
                if(v.state=='success'){
                //monxin_alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#act_state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                        $("#act_state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
                }
                }
            });
        }	
        return false;	
    }
    
	function reset_icon_span_height(){
		$("#<?php echo $module['module_name'];?> .log_detail .icon").each(function(index, element) {
            $(this).height($(this).parent().height());
        });
	}
	
	function reset_icon_span_height_id(id){
		$("#<?php echo $module['module_name'];?> #log_"+id+" .icon").height($("#<?php echo $module['module_name'];?> #log_"+id).height());
	}
	
    </script>
    <link href="<?php echo get_template_dir(__FILE__);?>/style/<?php echo $module['style']?>/main.css" rel="stylesheet" type="text/css">
    <style>
    #<?php echo $module['module_name'];?>{}
	.table_scroll{ border:none !important;}
    #<?php echo $module['module_name'];?> table tr{ text-align:left; border:none; background:none !important;}
    #<?php echo $module['module_name'];?> table td{ text-align:left; border:none; background:none !important; padding:0px;}
    #<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> .log_detail{  min-height:50px; }
	#<?php echo $module['module_name'];?> .log_detail .date_name{ display:inline-block; vertical-align:top; width:13%;color:#666; text-align:right; overflow:hidden;}
	#<?php echo $module['module_name'];?> .log_detail .icon{display:inline-block; vertical-align:top; width:7%; overflow:hidden; text-align:center !important;  min-height:50px; height:100%; }
	#<?php echo $module['module_name'];?> .log_detail .icon .bg_line{ display:block; margin:auto; height:100%;min-height:50px; width:5px; background:#CCC;}
	
	#<?php echo $module['module_name'];?> .log_detail .icon img{ width:40px; height:40px; border-radius:20px; border:3px solid #FFF;}
	#<?php echo $module['module_name'];?> .log_detail .icon b{display:inline-block; margin:auto; vertical-align:top; width:18px; height:18px; overflow:hidden; padding:0px; margin:0px; border-radius:10px; border:3px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; background-color:#fff; position:relative; }
	#<?php echo $module['module_name'];?> .log_detail .icon [bold='1']{display:inline-block; width:24px; height:24px; overflow:hidden; padding:0px; margin:0px; border-radius:12px; border:6px solid  <?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; background-color:#fff;}
	#<?php echo $module['module_name'];?> .log_detail .content{display:inline-block; vertical-align:top; width:78%; line-height:25px; overflow:hidden; padding-bottom:30px;}
	#<?php echo $module['module_name'];?> .log_detail .content img{max-width:100%;}
	
	.axis_name{ padding-left:13%;font-size:1.5rem; margin-bottom:20px; font-weight:bold; display:none;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    	<div class=axis_name><?php echo $module['axis_name'];?></div>
		<?php echo $module['list']?>
        <?php echo $module['page']?>
    </div>
</div>
