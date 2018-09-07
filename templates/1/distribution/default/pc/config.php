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
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html(v.info);
            });
        });
        $("#<?php echo $module['module_name'];?> .line textarea").blur(function(){
			temp=$(this).attr('class');
            $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html("<span class='fa fa-spinner fa-spin'></span>");
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class')+'&v='+$(this).val().replace('&','|||'),function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html(v.info);
            });
        });
        $("#<?php echo $module['module_name'];?> .line select").change(function(){
			temp=$(this).attr('class');
            $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html("<span class='fa fa-spinner fa-spin'></span>");
            $.get('<?php echo $module['action_url'];?>&act='+$(this).attr('class')+'&v='+$(this).val().replace('&','|||'),function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .line ."+temp).next('.state').html(v.info);
            });
        });
        
    });
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .line{  line-height:30px; height:50px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align: middle; width:30%; text-align:right; padding-right:10px; box-shadow:none; }
	#<?php echo $module['module_name'];?>_html .line .value{ display:inline-block; vertical-align: middle; width:60%;}
	#<?php echo $module['module_name'];?>_html .line .value input {text-align: right;}
    </style>    
	<div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
   	    </div>

        <div class=line><span class=m_label><?php echo self::$language['check_name'];?></span><span class=value><select class="check" monxin_value="<?php echo $module['config']['check']?>" ><option value="0"><?php echo self::$language['check_option'][0]?></option><option value="1"><?php echo self::$language['check_option'][1]?></option></select> <span class=state></span></span></div>
       
        <div class=line><span class=m_label><?php echo self::$language['all_order'];?></span><span class=value><select class="all_order" monxin_value="<?php echo $module['config']['all_order']?>" ><option value="0"><?php echo self::$language['all_order_state'][0]?></option><option value="1"><?php echo self::$language['all_order_state'][1]?></option></select> <span class=state></span></span></div>
       
        <div class=line><span class=m_label><?php echo self::$language['show'];?><?php echo self::$language['level'];?></span><span class=value><select class="level" monxin_value="<?php echo $module['config']['level']?>" ><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option></select> <?php echo self::$language['grade']?> <span class=state></span></span></div>
    
		<div class=line><span class=m_label><?php echo self::$language['shop_rate'];?></span><span class=value><input type="text" class="shop_rate" value="<?php echo $module['config']['shop_rate']?>" /> % <span class=state></span></span></div>
    
		<div class=line><span class=m_label><?php echo self::$language['level_1'];?><?php echo self::$language['level_postfix']?></span><span class=value><input type="text" class="level_1" value="<?php echo $module['config']['level_1']?>" /> % <span class=state></span></span></div>
		<div class=line><span class=m_label><?php echo self::$language['level_2'];?><?php echo self::$language['level_postfix']?></span><span class=value><input type="text" class="level_2" value="<?php echo $module['config']['level_2']?>" /> % <span class=state></span></span></div>
		<div class=line><span class=m_label><?php echo self::$language['level_3'];?><?php echo self::$language['level_postfix']?></span><span class=value><input type="text" class="level_3" value="<?php echo $module['config']['level_3']?>" /> % <span class=state></span></span></div>
		<div class=line><span class=m_label><?php echo self::$language['level_4'];?><?php echo self::$language['level_postfix']?></span><span class=value><input type="text" class="level_4" value="<?php echo $module['config']['level_4']?>" /> % <span class=state></span></span></div>
		<div class=line><span class=m_label><?php echo self::$language['level_5'];?><?php echo self::$language['level_postfix']?></span><span class=value><input type="text" class="level_5" value="<?php echo $module['config']['level_5']?>" /> % <span class=state></span></span></div>
		<div class=line><span class=m_label><?php echo self::$language['level_6'];?><?php echo self::$language['level_postfix']?></span><span class=value><input type="text" class="level_6" value="<?php echo $module['config']['level_6']?>" /> % <span class=state></span></span></div>
		<div class=line><span class=m_label><?php echo self::$language['level_7'];?><?php echo self::$language['level_postfix']?></span><span class=value><input type="text" class="level_7" value="<?php echo $module['config']['level_7']?>" /> % <span class=state></span></span></div>
		<div class=line><span class=m_label><?php echo self::$language['level_8'];?><?php echo self::$language['level_postfix']?></span><span class=value><input type="text" class="level_8" value="<?php echo $module['config']['level_8']?>" /> % <span class=state></span></span></div>
		<div class=line><span class=m_label><?php echo self::$language['level_9'];?><?php echo self::$language['level_postfix']?></span><span class=value><input type="text" class="level_9" value="<?php echo $module['config']['level_9']?>" /> % <span class=state></span></span></div>
		
		
        <br /><br /><br /><br />

    </div>

</div>
