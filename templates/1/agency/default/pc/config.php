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

        <div class=line><span class=m_label><?php echo self::$language['agency_mode'];?></span><span class=value><select class="agency_mode" monxin_value="<?php echo $module['config']['agency_mode']?>" ><option value="0"><?php echo self::$language['agency_mode_option'][0];?></option><option value="1"><?php echo self::$language['agency_mode_option'][1];?></option><option value="2"><?php echo self::$language['agency_mode_option'][2];?></option></select> <span class=state></span></span></div>
    
		<div class=line><span class=m_label><?php echo self::$language['default'];?><?php echo self::$language['rebate_1'];?></span><span class=value><input type="text" class="rebate_1" value="<?php echo $module['config']['rebate_1']?>" /> % <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['default'];?><?php echo self::$language['rebate_2'];?></span><span class=value><input type="text" class="rebate_2" value="<?php echo $module['config']['rebate_2']?>" /> % <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['default'];?><?php echo self::$language['rebate_3'];?></span><span class=value><input type="text" class="rebate_3" value="<?php echo $module['config']['rebate_3']?>" /> % <span class=state></span></span></div>
      
        <div class=line><span class=m_label><?php echo self::$language['volatility'];?></span><span class=value><input type="text" class="volatility" value="<?php echo $module['config']['volatility']?>" /> % <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['stock_max'];?></span><span class=value><input type="text" class="stock_max" value="<?php echo $module['config']['stock_max']?>" /> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['store_default_goods'];?></span><span class=value><input type="text" class="store_default_goods" value="<?php echo $module['config']['store_default_goods']?>" /> <span class=state></span></span></div>
		
        <div class=line><span class=m_label><?php echo self::$language['no_sub'];?></span><span class=value><select class="no_sub" monxin_value="<?php echo $module['config']['no_sub']?>" ><option value="true"><?php echo self::$language['yes'];?></option><option value="false"><?php echo self::$language['no'];?></option></select> <span class=state></span></span></div>
	
        <div class=line><span class=m_label><?php echo self::$language['agency_remark'];?></span><span class=value><textarea  type="text" style="width:80%; height:100px;" class="agency_remark" ><?php echo $module['config']['agency_remark']?></textarea><span class=state></span></span></div>
		
        <br /><br /><br /><br />

    </div>

</div>
