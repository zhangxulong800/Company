<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
    <script src="./plugin/datePicker/index.php"></script>
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
		$('#icon_ele').insertBefore($('#icon_state'));
		
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			
			$("#<?php echo $module['module_name'];?> .state").html('');	
			editor.sync();
			
			if($("#<?php echo $module['module_name'];?> #content").val()==''){$("#<?php echo $module['module_name'];?> #submit").next('span').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['content']?></span>');return false;}
			$("#<?php echo $module['module_name'];?> #submit").next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			if($("#<?php echo $module['module_name'];?> #bold").prop('checked')){is_bold=1;}else{is_bold=0;}
			
			$.post('<?php echo $module['action_url'];?>', {content:$("#<?php echo $module['module_name'];?> #content").val(),date:$("#<?php echo $module['module_name'];?> #date").val(),date_name:$("#<?php echo $module['module_name'];?> #date_name").val(),icon:$("#<?php echo $module['module_name'];?> #icon").val(),bold:is_bold},function(data){
				//alert(data);	
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
				if(v.state=='success'){
					if(v.fun=='new'){
						parent.add_new(v.id,v.html);
					}
					if(v.fun=='update'){
						parent.update_old(v.id,v.html);	
					}	
				}
				
				
			});	
		});
	
		
    });
    
	
    function submit_hidden(id){
        $("#icon_img").attr('src',"./temp/"+$("#"+id).val());
        
    }
    
	
    </script>
    
    <style>
	.fixed_right_div{ display:none;}
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> #icon_img{ height:30px; border-radius:15px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    <?php echo self::$language['content']?>:<br />
    <textarea name="content" id="content" style="display:none; width:100%; height:200px;"><?php echo @$module['data']['content']?></textarea>
    
    <br />
    <?php echo self::$language['date_str']?>: <input type="text"  name="date" id="date"  onclick=show_datePicker(this.id,'date_time') onblur= hide_datePicker() value="<?php echo @$module['data']['date'];?>"   /> &nbsp; &nbsp; 
	<?php echo self::$language['date_name']?>: <input type="text" name="date_name" id="date_name" class="date_name" placeholder="<?php echo self::$language['optional']?>"  value="<?php echo @$module['data']['date_name'];?>"  />  &nbsp; &nbsp; 
	<?php echo self::$language['icon_str']?>: <img id=icon_img src='<?php echo @$module['data']['icon']?>' /> <span id=icon_state></span> &nbsp; &nbsp; 
	<?php echo self::$language['bold']?>: <input type="checkbox" name="bold" id="bold"  class=bold /> &nbsp; &nbsp; 
    <a href="#" id=submit class=submit><?php echo self::$language['submit']?></a> <span class=state></span>
    
    </div>
</div>

