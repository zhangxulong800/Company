<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){		
		$('#css_pc_bg_ele').insertBefore($('#css_pc_bg_state'));
		$('#css_phone_bg_ele').insertBefore($('#css_phone_bg_state'));
		
		$("#<?php echo $module['module_name'];?>_html .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .state").html('');
			obj=new Object();
			obj['css_width']=$("#<?php echo $module['module_name'];?> .css_width").val();
			obj['css_pc_bg']=$("#<?php echo $module['module_name'];?> #css_pc_bg").val();
			obj['css_pc_top']=$("#<?php echo $module['module_name'];?> .css_pc_top").val();
			obj['css_phone_bg']=$("#<?php echo $module['module_name'];?> #css_phone_bg").val();
			obj['css_phone_top']=$("#<?php echo $module['module_name'];?> .css_phone_top").val();
			obj['css_diy']=$("#<?php echo $module['module_name'];?> .css_diy").val();
			
			$("#<?php echo $module['module_name'];?>_html .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=update',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?>_html .submit").next().html(v.info);				
			});
			return false;	
		});
    });
	
	
	function submit_hidden(id){
		$("#<?php echo $module['module_name'];?> ."+id).attr('src','./temp/'+$("#"+id).val());
	}
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .line{  line-height:50px;}
	#<?php echo $module['module_name'];?>_html .line .m_label{ display:inline-block; vertical-align: top; width:15%; text-align:right; padding-right:10px; box-shadow:none; }
	#<?php echo $module['module_name'];?>_html .line .value{ display:inline-block; vertical-align: middle; width:80%;}
	#<?php echo $module['module_name'];?>_html .line .value input {}
	
	#<?php echo $module['module_name'];?>_html textarea{ width:100%; height:100px; }
	
	#<?php echo $module['module_name'];?>_html .css_pc_bg{ height:200px;}
	#<?php echo $module['module_name'];?>_html .css_phone_bg{ height:200px;}
    </style>    
	<div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
   	    </div>

		
        <div class=line><span class=m_label><?php echo self::$language['css_width'];?></span><span class=value><input type="text" class=css_width value="<?php echo $module['data']['css_width'] ?>" /> <span class=state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['css_pc_bg'];?></span><span class=value> <span class=state id=css_pc_bg_state></span>
        <?php echo $module['data']['css_pc_bg'] ?>
        </span></div>
        <div class=line><span class=m_label><?php echo self::$language['css_pc_top'];?></span><span class=value><input type="text" class=css_pc_top value="<?php echo $module['data']['css_pc_top'] ?>" /> <span class=state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['css_phone_bg'];?></span><span class=value> <span class=state id=css_phone_bg_state></span>
        <?php echo $module['data']['css_phone_bg'] ?>
        </span></div>
        <div class=line><span class=m_label><?php echo self::$language['css_phone_top'];?></span><span class=value><input type="text" class=css_phone_top value="<?php echo $module['data']['css_phone_top'] ?>" /> <span class=state></span></span></div>
        <div class=line><span class=m_label><?php echo self::$language['css_diy'];?></span><span class=value><textarea type="text" class=css_diy ><?php echo $module['data']['css_diy'] ?></textarea> <span class=state></span></span></div>
    
    	<div class=line><span class=m_label>&nbsp;</span><span class=input_span><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
		
    </div>

</div>
