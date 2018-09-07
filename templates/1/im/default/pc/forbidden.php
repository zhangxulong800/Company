<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
            $("#<?php echo $module['module_name'];?> .submit").next('.state').html("<span class='fa fa-spinner fa-spin'></span>");
            $.post('<?php echo $module['action_url'];?>&act=forbidden',{v:$("#<?php echo $module['module_name'];?> .forbidden").val()},function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#<?php echo $module['module_name'];?> .submit").next('.state').html(v.info);
            });
			return false;
		});
        
    });
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .forbidden{ width:95%; height:200px;}
    </style>    
	<div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?>(<?php echo self::$language['separated_by_commas']?>)</div>
   	    </div>
    
		<textarea class=forbidden><?php echo $module['forbidden']?></textarea>
		<br /><a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span>

		
    </div>

</div>
