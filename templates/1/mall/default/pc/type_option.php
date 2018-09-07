<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#specifications_source").val($("#specifications_source").attr('monxin_value'));
		if($("#specifications_source").val()==1){$("#<?php echo $module['module_name'];?>_html").css('display','block');}
		$("#specifications_source").change(function(){
			
			if($(this).val()==1){
				$("#<?php echo $module['module_name'];?>_html").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?>_html").css('display','none');
			}
			
			
			$(this).next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=specifications_source',{specifications_source:$(this).val()}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#specifications_source").next().html(v.info);
			});
				
		});
		
		if($("#<?php echo $module['module_name'];?> #color").val()==1){
			$("#<?php echo $module['module_name'];?> #color").prop('checked',true);
		}
		if($("#<?php echo $module['module_name'];?> #diy_option").val()==1){
			$("#<?php echo $module['module_name'];?> #diy_option").prop('checked',true);
			$("#diy_option_div").css('display','block');
		}
		$("#<?php echo $module['module_name'];?> #diy_option").click(function(){
			if($("#<?php echo $module['module_name'];?> #diy_option").prop('checked')){
				$("#diy_option_div").css('display','block');
			}else{
				$("#diy_option_div").css('display','none');
			}
			var diy_option;
            if($("#<?php echo $module['module_name'];?> #diy_option").prop('checked')){diy_option=1;}else{diy_option=0;}
            $.get('<?php echo $module['action_url'];?>&act=diy_option',{diy_option:diy_option});
		});
		
        $("#<?php echo $module['module_name'];?> #color").click(function(){
			var color;
            if($("#<?php echo $module['module_name'];?> #color").prop('checked')){color=1;}else{color=0;}
             $.get('<?php echo $module['action_url'];?>&act=color',{color:color});
		});
        $("#<?php echo $module['module_name'];?> #option_name").blur(function(){
            $.get('<?php echo $module['action_url'];?>&act=option_name',{option_name:$("#<?php echo $module['module_name'];?> #option_name").val()});
		});
		
		
		
		
		
    });
    
    function add(){
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        sequenceNew=$("#<?php echo $module['module_name'];?> #sequence_new");
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(sequenceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),sequence:sequenceNew.prop('value')}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
			if(v.state=='success'){$("#<?php echo $module['module_name'];?> #state_new").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');}
        });
        	
        return false;
    }
    
    
    function update(id){
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        var sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),sequence:sequence.prop('value'),id:id,shop_id:$("#<?php echo $module['module_name'];?> #shop_"+id).val()}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        	
       return false; 
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
       return false; 
    }
    </script>
    <style>
	#<?php echo $module['module_name'];?> .specifications_source_div{  padding:20px;}
    #<?php echo $module['module_name'];?>_html{ display:none;}
    #<?php echo $module['module_name'];?>_html .name{width:200px;}
    #<?php echo $module['module_name'];?>_html .sequence{width:50px;}
	#diy_option_div{ display:none;}
    </style>
     <div class=specifications_source_div><?php echo self::$language['specifications_source'];?><select id=specifications_source monxin_value="<?php echo $module['specifications_source'];?>" ><option value="0"><?php echo self::$language['parent_specifications'];?></option><option value="1"><?php echo self::$language['self_specifications'];?></option></select> <span></span></div>

	<fieldset id="<?php echo $module['module_name'];?>_html"  monxin-table=1><legend><?php echo self::$language['self_specifications'];?></legend>
    
    <div  style="line-height:100px; margin:20px;">
    <input type="checkbox" value="<?php echo $module['color']?>" id=color name=color /><?php echo self::$language['color'];?>&nbsp; &nbsp; &nbsp; 
    <input type="checkbox" value="<?php echo $module['diy_option']?>" id=diy_option name=diy_option /><?php echo self::$language['diy_option'];?>
    
    </div>
    <fieldset id=diy_option_div ><legend><?php echo self::$language['diy_option'];?><?php echo self::$language['name'];?> <input type="text" value="<?php echo $module['option_name']?>" id=option_name name=option_name /></legend>
    <br />	
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:98%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><?php echo self::$language['option_option']?></td>
                <td><?php echo self::$language['sequence']?></td>
                <td><?php echo self::$language['type_option_shop_id']?></td>
                <td width="30%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
            <tr id="<?php echo $module['module_name'];?>_new">
              <td ><input type="text" name="name_new" id="name_new" class='name' /></td>
              <td><input type="text" name="sequence_new" id="sequence_new" value="0" class='sequence' /></td>
              <td>&nbsp;</td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
        </tbody>
    </table></div>
    
    </fieldset>
    </fieldset>

</div>
