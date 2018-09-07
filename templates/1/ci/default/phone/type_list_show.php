<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script>
    $(document).ready(function(){
		var list_show='<?php echo $module['list_show'];?>';
		list_show=list_show.split(',');
		for(i in list_show){
			if(list_show[i]){$("#<?php echo $module['module_name'];?> .checkbox_div #"+list_show[i]).prop('checked',true);}
		}
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$(this).next().html('');
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			temp='';
			$("#<?php echo $module['module_name'];?> .checkbox_div input").each(function(index, element) {
                if($(this).prop('checked')){temp+=$(this).attr('id')+',';}
            });
			//alert(temp);
            $.post('<?php echo $module['action_url'];?>',{list_show:temp}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				
            });
			return false;	
		});
    });
    
    
    </script>
    
    <style>
	.fixed_right_div{ display:none;}
    #<?php echo $module['module_name'];?>_html{ }
    #<?php echo $module['module_name'];?>_html .checkbox_div{ }
    #<?php echo $module['module_name'];?>_html .checkbox_div span{ display:inline-block; vertical-align:top; margin-right:20px; min-width:120px; text-align:left; height:40px;}
    #<?php echo $module['module_name'];?>_html .checkbox_div span input{ display:inline-block; vertical-align:top;  margin-top:-1px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=checkbox_div>
        	<span><input type="checkbox" id=icon /><?php echo self::$language['cover_image']?></span><span><input type="checkbox" id=title /><?php echo self::$language['title']?></span><span><input type="checkbox" id=content /><?php echo self::$language['content']?></span><span><input type="checkbox" id=price /><?php echo self::$language['price']?></span><span><input type="checkbox" id=reflash /><?php echo self::$language['time']?></span><span><input type="checkbox" id=linkman /><?php echo self::$language['linkman']?></span><span><input type="checkbox" id=contact /><?php echo self::$language['contact']?></span><?php echo $module['checkbox'];?>
        </div>
    	<a href=# class=submit><?php echo self::$language['submit']?></a> <span></span>
		  
    
    </div>
</div>

