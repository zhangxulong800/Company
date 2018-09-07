<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		
		$("#<?php echo $module['module_name'];?>_html #group").change(function(){
			get_managers($(this).val());	
		});
		$("#<?php echo $module['module_name'];?>_html #manager_submit").click(function(){
			set_manager($("#manager").val());	
			return false;
		});
		$("#<?php echo $module['module_name'];?>_html #group").prop('value',<?php echo $module['group']?>);
		var group=get_param('group');
		if(group!=''){
			$("#<?php echo $module['module_name'];?>_html #group_div").css('display','none');	
			get_managers(group);
			
		}else{
			$("#<?php echo $module['module_name'];?>_html #manager_div").css('display','none');	
		}
		
    });
	
    function get_managers(group){
		$("#<?php echo $module['module_name'];?>_html #group_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');   
		var ids=$("#<?php echo $module['module_name'];?>_html #ids").val(); 
        $.post("<?php echo $module['action_url'];?>&act=get_managers",{id:ids,group:group},function(data){
			//monxin_alert(data);
			            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			if(v.state=='fail'){
				$("#<?php echo $module['module_name'];?>_html #group_state").html(v.info);
			}else{
				$("#<?php echo $module['module_name'];?>_html #group_state").html('');
				$("#<?php echo $module['module_name'];?>_html #manager").html(v.info);
				$("#<?php echo $module['module_name'];?>_html #manager_div").css('display','inline-block');	
			}
			
	        });	
        	
    }
    function set_manager(manager){
		$("#<?php echo $module['module_name'];?>_html #manager_state").html('<span class=\'fa fa-spinner fa-spin\'></span>'); 
		var group=$("#<?php echo $module['module_name'];?>_html #group").val();  
		var ids=$("#<?php echo $module['module_name'];?>_html #ids").val();  
        $.post("<?php echo $module['action_url'];?>&act=set_manager",{id:ids,manager:manager,group:group},function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#<?php echo $module['module_name'];?>_html #manager_state").html(v.info+'<a href="<?php echo $module['back_url'];?>"class=return_button ><?php echo self::$language['return']?></a>');
			
	        });	
        	
    }
	
	</script>
	<style>
    #<?php echo $module['module_name'];?>_html{ text-align:center; padding-top:100px;}
    #<?php echo $module['module_name'];?>_html #manager_submit{ display:inline-block; margin-left:5px;}
    #<?php echo $module['module_name'];?>_html #group_div{ display:inline-block;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
                <div style="display:inline-block; border:1px #CCCCCC solid; height:200px; overflow:scroll; text-align:left;">
				<?php echo $module['user_list']?>
                <input type="hidden" name="ids" id="ids" value="<?php echo $module['ids']?>" />
                </div> 
      <div style="display:inline-block;vertical-align:top;">
	    <div id=group_div><?php echo self::$language['belong']?><?php echo self::$language['user_group']?>：<select name="group" id="group" class='group' >
                <option value="-1"><?php echo self::$language['select_please']?></option>
                <?php echo $module['parent_select']?>
                </select> <span id=group_state></span></div>
                <div id=manager_div><?php echo self::$language['parent']?>：<select name="manager" id="manager" class='manager' >
                </select><a href="#" id=manager_submit><div class="submit"><?php echo self::$language['submit']?></div></a> <span id=manager_state></span></div>
                 </div> 
	
    
  </div>
</div>
