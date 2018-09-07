<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .line select").each(function(index, element) {
            if($(this).attr('monxin_value')){$(this).val($(this).attr('monxin_value'));}
        });
		
        
        $("#<?php echo $module['module_name'];?> .line input").blur(function(){
			temp=$(this).attr('class');
            $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html("<span class='fa fa-spinner fa-spin'></span>");
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class')+'&v='+$(this).val().replace('&','|||'),function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html(v.info);
            });
        });
        $("#<?php echo $module['module_name'];?> .line select").change(function(){
			temp=$(this).attr('class');
            $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html("<span class='fa fa-spinner fa-spin'></span>");
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class')+'&v='+$(this).val(),function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html(v.info);
            });
        });
        
    });
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .line{  line-height:40px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align: middle; width:60%; text-align:right; padding-right:10px; box-shadow:none;}
	#<?php echo $module['module_name'];?>_html .line .value{ display:inline-block; vertical-align:top; width:35%;}
	#<?php echo $module['module_name'];?>_html .line .value input{ width:40%;}
    </style>    
	<div id="<?php echo $module['module_name'];?>_html">
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>

		<div class=line><span class=m_label><?php echo self::$language['add_notice_email'];?></span><span class=value><input type="text" class="add_notice_email" value="<?php echo $module['config']['add_notice_email']?>" /> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['info_verify'];?></span><span class=value><select class="info_verify" monxin_value="<?php echo $module['config']['info_verify']?>" ><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['visitor_add'];?></span><span class=value><select class="visitor_add" monxin_value="<?php echo $module['config']['visitor_add']?>" ><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
        
		<div class=line><span class=m_label><?php echo self::$language['day_add_max'];?></span><span class=value><input type="text" class="day_add_max" value="<?php echo $module['config']['day_add_max']?>" /> <span class=state></span></span></div>
        
		<div class=line><span class=m_label><?php echo self::$language['day_reflash_max'];?></span><span class=value><input type="text" class="day_reflash_max" value="<?php echo $module['config']['day_reflash_max']?>" /> <span class=state></span></span></div>
        
		<div class=line><span class=m_label><?php echo self::$language['reflash_price'];?></span><span class=value><input type="text" class="reflash_price" value="<?php echo $module['config']['reflash_price']?>" /> <span class=state></span></span></div>
        
		<div class=line><span class=m_label><?php echo self::$language['top_min_price'];?></span><span class=value><input type="text" class="top_min_price" value="<?php echo $module['config']['top_min_price']?>" /> <span class=state></span></span></div>
        
		<div class=line><span class=m_label><?php echo self::$language['give_3'];?></span><span class=value><input type="text" class="give_3" value="<?php echo $module['config']['give_3']?>" /> <span class=state></span></span></div>
        
		<div class=line><span class=m_label><?php echo self::$language['give_7'];?></span><span class=value><input type="text" class="give_7" value="<?php echo $module['config']['give_7']?>" /> <span class=state></span></span></div>
        
		<div class=line><span class=m_label><?php echo self::$language['give_15'];?></span><span class=value><input type="text" class="give_15" value="<?php echo $module['config']['give_15']?>" /> <span class=state></span></span></div>
        
		<div class=line><span class=m_label><?php echo self::$language['give_30'];?></span><span class=value><input type="text" class="give_30" value="<?php echo $module['config']['give_30']?>" /> <span class=state></span></span></div>
        
		<div class=line><span class=m_label><?php echo self::$language['target'];?></span><span class=value><input type="text" class="target" value="<?php echo $module['config']['target']?>" /> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['top_url'];?></span><span class=value><input type="text" class="top_url" value="<?php echo $module['config']['top_url']?>" /> <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['hot_search'];?></span><span class=value><input type="text" class="hot_search" value="<?php echo $module['config']['hot_search']?>" /> <span class=state></span></span></div>	
		
		<div class=line><span class=m_label><?php echo self::$language['search_placeholder'];?></span><span class=value><input type="text" class="search_placeholder" value="<?php echo $module['config']['search_placeholder']?>" /> <span class=state></span></span></div>
		
		<div class=line><span class=m_label><?php echo self::$language['search_placeholder_url'];?></span><span class=value><input type="text" class="search_placeholder_url" value="<?php echo $module['config']['search_placeholder_url']?>" /> <span class=state></span></span></div>
		
    </div>

</div>
