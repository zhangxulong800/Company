<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left  >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
		$("<br/>").insertAfter("#replace_div");
    	$("#<?php echo $module['module_name'];?> #type").val('<?php echo $module['type'];?>');
		$('#html4_up_ele').insertBefore($('#html4_up_state'));
		$("#<?php echo $module['module_name'];?> .replace").toggle(
		  function () {
			$(this).next('div').css('display','inline-block');
		  },
		  function () {
			$(this).next('div').css('display','none');
		  }
		);
		
				
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        var type=$("#<?php echo $module['module_name'];?> #type");
        var title=$("#<?php echo $module['module_name'];?> #title");
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content");
        if(type.prop('value')<1){monxin_alert('<?php echo self::$language['please_select']?><?php echo self::$language['belong']?>');type.focus();return false;}
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
		
		$("#<?php echo $module['module_name'];?> #link").val(add_http($("#<?php echo $module['module_name'];?> #link").val()));
		
        top_ajax_form('monxin_form','submit_state','show_result');
        return false;
        }
        
    
    function show_result(){
        $("#<?php echo $module['module_name'];?> #submit_state").css("display","none");
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        //monxin_alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		

        if(json.state=='fail'){$("#<?php echo $module['module_name'];?> #submit_state").html(json.info);$("#<?php echo $module['module_name'];?> #submit_state").css("display","inline-block");}
        
            
    }
    </script>
    
    <style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
    #<?php echo $module['module_name'];?>_html #html4_up_file{ border:none;}
    #<?php echo $module['module_name'];?> #parent{}
    #<?php echo $module['module_name'];?> #title{ width:600px;}
    #<?php echo $module['module_name'];?> #link{ width:600px;}
    #<?php echo $module['module_name'];?> #content{}
	#replace_div{ display:none; vertical-align:top;}
	#thumb_width,#thumb_height{ width:4rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    <form id="monxin_form" name="monxin_form" method="POST" action="<?php echo $module['action_url'];?>&id=<?php echo $_GET['id'];?>" onSubmit="return exe_check();">
    
      <?php echo self::$language['belong'];?>：<select id="type" name="type">
      <option value="-1"><?php echo self::$language['please_select']?></option>
      <?php echo $module['parent'];?></select> <a href="index.php?monxin=image.type"><?php echo self::$language['create']?></a><br /><br />
      <?php echo self::$language['title'];?>：<input type="text" name="title" id="title"  value='<?php echo $module['title']?>' /><br /><br />
      <?php echo self::$language['image'];?>：<a href=# class="replace"><?php echo self::$language['replace'];?></a>  <div id=replace_div><span id=html4_up_state></span></div><br />
      <img src='./program/image/img_thumb/<?php echo $module['src'];?>' style="width:10rem"><br />
      <?php echo self::$language['img_description'];?>：<br />
      
    <textarea name="content" id="content" style="display:none; width:100%; height:400px;"><?php echo $module['content']?></textarea>
    
    <br />
    <div><a href=# class="advanced_options"><?php echo self::$language['advanced_options'];?><span id=advanced_options_div_state class=show>&nbsp;</span></a></div>
    <div id=advanced_options_div>
		<span class="m_label"><?php echo self::$language['link'];?>：</span><input type="text" name="link" id="link"  value='<?php echo $module['link']?>' placeholder="http:// <?php echo self::$language['link_url'];?>" /><br /><br />
      <span class="m_label"><?php echo self::$language['open_image_mark'];?>：</span><select id="image_mark" name="image_mark">
      <?php echo $module['image_mark_option'];?>
      </select><br /><br />
   	  <div><span class="m_label"><?php echo self::$language['thumb'];?>：</span><span class=input_span>
      		<span class=width_label><?php echo self::$language['module_width'];?></span><input type="text" id="thumb_width" name="thumb_width" value="<?php echo $module['thumb_width'];?>" /> <span></span>
      		<span class=m_label><?php echo self::$language['module_height'];?></span><input type="text" id="thumb_height" name="thumb_height" value="<?php echo $module['thumb_height'];?>" /> <span></span>
      </span></div> 
	</div>
    <br />
    
    
      <input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span>
    </form>
    
    </div>
</div>

