<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
		$('#html4_up_ele').insertBefore($('#html4_up_state'));
		$('#html5_up_ele').insertBefore($('#html5_up_state'));
		$("#<?php echo $module['module_name'];?> #type").change(function(){
			if($(this).val()>0){
				show_up_div();
			}else{
				$("#html4_div").css('display','none');
				$("#html5_div").css('display','none');
			}	
		});
    });
	
	function show_up_div(){
		form_check=false;
		try{form_check= new FormData();}catch(e){}
		if(form_check==false){
			$("#html4_div").css('display','block');
			$("#html5_div").css('display','none');	
		}else{
			$("#html5_div").css('display','block');
			$("#html4_div").css('display','none');	
		}
	}
	
	
	function submit_hidden(id){
		str=$("#"+id).val();
		//alert(str);return false;
        $.post("<?php echo $module['action_url'];?>&act=add",{v:str,type:$("#<?php echo $module['module_name'];?> #type").val(),image_mark:$("#<?php echo $module['module_name'];?> #image_mark").val(),thumb_height:$("#<?php echo $module['module_name'];?> #thumb_height").val(),thumb_width:$("#<?php echo $module['module_name'];?> #thumb_width").val()},function(data){
            //monxin_alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#"+id+"_state").html(v.info);
			if(v.state=='success'){alert('<?php echo self::$language['upload'];?><?php echo self::$language['success'];?>');window.location.href='./index.php?monxin=image.admin&type='+$("#<?php echo $module['module_name'];?> #type").val();}			
        });	
	}
    
    </script>
    
    
    
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:50px; }
    #<?php echo $module['module_name'];?>_html #html5_up_file{ border:none;}
    #<?php echo $module['module_name'];?> #parent{}
	#<?php echo $module['module_name'];?> #html4_div{display:none;}
	#<?php echo $module['module_name'];?> #html5_div{display:none;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">   
    <div><a href=# class="advanced_options"><?php echo self::$language['advanced_options'];?><span id=advanced_options_div_state class=show>&nbsp;</span></a></div>
    <div id=advanced_options_div>
      <span class="m_label"><?php echo self::$language['open_image_mark'];?>：</span><select id="image_mark" name="image_mark">
      <?php echo $module['image_mark_option'];?>
      </select><br /><br />
   	  <div><span class="m_label"><?php echo self::$language['thumb'];?>：</span><span class=input_span>
      		<span class=width_label><?php echo self::$language['module_width'];?></span><input type="text" id="thumb_width" name="thumb_width" value="<?php echo $module['thumb_width'];?>" /> <span></span>
      		<span class=m_label><?php echo self::$language['module_height'];?></span><input type="text" id="thumb_height" name="thumb_height" value="<?php echo $module['thumb_height'];?>" /> <span></span>
      </span></div> 
	</div>
    <br />
      <?php echo self::$language['belong'];?>：<select id="type" name="type">
      <option value="-1"><?php echo self::$language['please_select']?></option>
      <?php echo $module['parent'];?></select> <a href="index.php?monxin=image.type"><?php echo self::$language['create']?></a><br /><br />
    
    
      
      <div id=html4_div><span id=html4_up_state></span></div>
      <div id=html5_div><span id=html5_up_state></span></div>
      
    </div>
</div>

