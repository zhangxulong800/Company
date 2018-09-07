<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		var tags='<?php echo $_GET['id']?>';
		//alert(tags);
		tags=tags.split('|');
		for(i in tags){
			if(tags[i]!=''){$("#<?php echo $module['module_name'];?> #t_"+tags[i]).prop('checked',true);}
		}
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			tag='';
			$("#<?php echo $module['module_name'];?> .tags input").each(function(index, element) {
				if($(this).prop('checked')){
					tag+='|'+$(this).attr('id');
				}
                
            });
			if(tag!=''){tag+='|';}
			//alert(tag);
			$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=submit',{tag:tag}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
                if(v.state=='success'){
                	parent.update_tag(<?php echo $_GET['c_id']?>,v.html);
                }
            });
		});
		
    });
    
    </script>
    <style>
	.fixed_right_div{ display:none;}
    #<?php echo $module['module_name'];?>_html{ }
    #<?php echo $module['module_name'];?>_html .tags{ line-height:40px;}
    #<?php echo $module['module_name'];?>_html .tags span{ display:inline-block; vertical-align:top; margin-right:20px;}
    #<?php echo $module['module_name'];?>_html .tags span input{ display:inline-block; vertical-align:top;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html">
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
    	<div class=tags><?php echo $module['data'];?></div>
        <br />
        <a href=# class=submit><?php echo self::$language['submit'];?></a> <span></span>
    </div>

</div>
