<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#parent").prop('value',<?php echo $module['parent']?>);
    });
	
    function subimt_select(){
		$("#submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');   
		 parent=$("#parent").prop('value');    
        $.post("<?php echo $module['action_url'];?>&act=submit",{id:<?php echo @$_GET['id']?>,parent:parent},function(data){
			//monxin_alert(data);
			            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#submit_state").html(v.info);
	        });	
        	
    }
	
	</script>
	<style>
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html select{ height:30px; line-height:30px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
                <?php echo $module['name']?> <?php echo self::$language['parent']?>：<select name="parent" id="parent" class='group_parent' >
                <option value="-1"><?php echo self::$language['select_please']?></option>
                <?php echo $module['parent_select']?>
                </select> 
                <a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a> 
                <span id=submit_state></span>

    </div>
</div>
