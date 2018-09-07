<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #user_set_color").val('<?php echo $module['user_set_color'];?>');
		$("#<?php echo $module['module_name'];?> #user_set_circle").val('<?php echo $module['circle'];?>');
		
		$("#<?php echo $module['module_name'];?>_html select").change(function(){
            json="{'variable':'"+this.id+"','value':'"+this.value+"'}";
			
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
			if(!(this.id=='user_set_operation_sound' && this.value==0)){}
			
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&act=set',json,function(){
				//alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
                    $(this).html(v.info);
                    if(v.state=='fail'){$(this).html('');}else{}
                }
            });
		});
    });
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
    #<?php echo $module['module_name'];?>_html p{ line-height:40px;}
    #<?php echo $module['module_name'];?>_html .name{width:200px; display:inline-block; text-align:right; padding-right:5px;}
    #<?php echo $module['module_name'];?>_html .options{width:200px;text-align:left;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    <div class=remark_module style="display:none;"><?php echo self::$language['reminder']?>:<?php echo self::$language['relogin_effect']?></div>	
    <?php echo $module['list']?>
	<p><span class="name"><?php echo self::$language['default']?><?php echo self::$language['circle']?>:</span><span class="options"><select id="user_set_circle" name="user_set_circle"><?php echo $module['circle_option']?></select><span id="user_set_circle_state"></span></span></p>    
	<p><span class="name"><?php echo self::$language['user_color']?>:</span><span class="options"><select id="user_set_color" name="user_set_color"><?php echo $module['color_option']?></select><span id="user_set_color_state"></span></span></p>    
    </div>

</div>
