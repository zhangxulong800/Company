<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #invoking_article_type").val('<?php echo $module['invoking_article_type_set'];?>');
		$("#<?php echo $module['module_name'];?> #invoking_menu_type").val('<?php echo $module['invoking_menu_type_set'];?>');
		
		$("#<?php echo $module['module_name'];?>_html select").change(function(){
            json="{'variable':'"+this.id+"','value':'"+this.value+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
			
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
	
	#<?php echo $module['module_name'];?>_html .edit:before {font: normal normal normal 1.2rem/1 FontAwesome;margin-right: 5px;content: "\f2e6";}
	#<?php echo $module['module_name'];?>_html .edit:hover { color:red;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
		<p><span class="name"><?php echo self::$language['invoking_article_type']?>:</span><span class="options"><select id="invoking_article_type" name="invoking_article_type"><?php echo $module['article_type']?></select><span id="invoking_article_type_state"></span> <a href=./index.php?monxin=article.type class=edit></a></span></p>    
		<p><span class="name"><?php echo self::$language['invoking_menu_type']?>:</span><span class="options"><select id="invoking_menu_type" name="invoking_menu_type"><?php echo $module['menu_type']?></select><span id="invoking_menu_type_state"></span> <a href=./index.php?monxin=menu.admin class=edit></a></span></p>    
    </div>

</div>
