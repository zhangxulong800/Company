<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
	var replace_file='';
    $(document).ready(function(){
		
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			$("img[src='"+replace_file+"']").attr('src',replace_file+"?&reflash="+Math.random());
			return false;
		});
		$('.icon').click(function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			replace_file=$("#"+$(this).attr('id')+" img").attr('src');
			//monxin_alert(replace_img);
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','index.php?monxin=index.replace_file&path='+replace_file+'&width=128&height=128');
			return false;	
		});
		
        $("#<?php echo $module['module_name'];?> .visible").click(function(){
            id=this.id;
            id=id.replace("visible_","");
            if($(this).prop('checked')){visible=1;}else{visible=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_visible',{id:id,visible:visible});
        });
		
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			t=$("#monxin_iframe").attr('src');
			t=t.split('?id=');
			t=t[1].split('&');
			t=t[0];
			temp=getCookie('map_'+t);
			if(temp){
				$("#<?php echo $module['module_name'];?> #"+t).val(getCookie('map_'+t).replace(/%2C/g,','));
			}
			return false;
		});
		$("#<?php echo $module['module_name'];?> input[monxin_type='map']").focus(function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','http://<?php echo $module['map_api'];?>.monxin.com/get_point.php?id='+$(this).attr('id')+'&point='+$(this).val());
			return false;	
		});
		
		$(document).on('change',"#<?php echo $module['module_name'];?> .area_div select",function(){
			$(this).parent().parent().children('input').val($(this).val());
			//$("#<?php echo $module['module_name'];?> #area").prop('value',$(this).val());	
		});
		
    });
    
    
    function add(){
        parent_idNew=$("#<?php echo $module['module_name'];?> #parent_id_new");
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        centerNew=$("#<?php echo $module['module_name'];?> #center_new");	
        rangeNew=$("#<?php echo $module['module_name'];?> #range_new");	
        areaNew=$("#<?php echo $module['module_name'];?> #area");	
        sequenceNew=$("#<?php echo $module['module_name'];?> #sequence_new");
        if($("#<?php echo $module['module_name'];?> #visible_new").prop('checked')){visible=1;}else{visible=0;}
    
        if(parent_idNew.prop('value')<0){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_select']?><?php echo self::$language['parent']?>');parent_idNew.focus();return false;}	
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(centerNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['center']?>');centerNewNew.focus();return false;}	
        if(rangeNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['circle_range']?>');rangeNewNew.focus();return false;}	
        if(areaNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_select']?><?php echo self::$language['circle_area']?>');return false;}	
        if(sequenceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{parent_id:parent_idNew.prop('value'),name:nameNew.prop('value'),center:centerNew.prop('value'),range:rangeNew.prop('value'),area:areaNew.prop('value'),sequence:sequenceNew.prop('value'),visible:visible}, function(data){
            //alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');    
        });
        return false;	
        
    }
    
    
    function update(id){
        parent_id=$("#<?php echo $module['module_name'];?> #parent_id_"+id);
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        center=$("#<?php echo $module['module_name'];?> #center_"+id);	
        range=$("#<?php echo $module['module_name'];?> #range_"+id);	
        area=$("#<?php echo $module['module_name'];?> #area_"+id);	
        sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);
        if($("#<?php echo $module['module_name'];?> #visible_"+id).prop('checked')){visible=1;}else{visible=0;}
        if(parent_id.prop('value')<0){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_select']?><?php echo self::$language['parent']?>');parent_id.focus();return false;}	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(center.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['center']?>');center.focus();return false;}	
        if(range.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['circle_range']?>');range.focus();return false;}	
        if(area.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_select']?><?php echo self::$language['circle_area']?>');return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{parent_id:parent_id.prop('value'),name:name.prop('value'),center:center.prop('value'),range:range.prop('value'),area:area.prop('value'),sequence:sequence.prop('value'),id:id,visible:visible}, function(data){
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
                //alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false;	
        
    }

    function set_area(id,v){
		//alert(id+','+v);
        $("#"+id).prop('value',v);
        //submit_hidden(id);	
    }
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .name_td{ white-space:nowrap; text-align:right;}
    #<?php echo $module['module_name'];?> .id{ overflow:hidden; text-align:right;}
    #<?php echo $module['module_name'];?> .parent_id{ margin-right:10px;}
    #<?php echo $module['module_name'];?> .name{ width:5rem !important; }
    #<?php echo $module['module_name'];?> .center{width:10rem;}
    #<?php echo $module['module_name'];?> .range{ width:5rem;}
    #<?php echo $module['module_name'];?> .sequence{width:40px;}
    #<?php echo $module['module_name'];?> .visible{ width:40px;}
	#<?php echo $module['module_name'];?> .filter{ }
    #<?php echo $module['module_name'];?> #visible_filter{ height:26px;}
	#<?php echo $module['module_name'];?> #open_target_filter{ height:26px;}
	#<?php echo $module['module_name'];?> .icon{ background:#ff9600; border-radius:3px; display:inline-block; width:30px; height:30px; padding:2px; margin-right:5px;}
	#<?php echo $module['module_name'];?> .area_div select{ display:block;}
	#<?php echo $module['module_name'];?> .icon{ display:inline-block; vertical-align:top; width:2rem; overflow:hidden;}
	#<?php echo $module['module_name'];?> .icon img{ width:30px; height:30px; border:0px;}
	#<?php echo $module['module_name'];?> select{ max-width:150px; overflow:hidden;}
	.go_sub:before {font: normal normal normal 14px/1 FontAwesome;margin-right: 5px;content:"\f103";}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a></li> 
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                    <li><a href="#" class="show"  onclick="return show_select(1);"><?php echo self::$language['show']?></a></li> 
                    <li><a href="#" class="hide" onclick="return show_select(0);"><?php echo self::$language['hide']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"   id="<?php echo $module['module_name'];?>_table_a" style="width:100%" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td width="10%"><?php echo self::$language['parent']?></td>
                <td width="22%"><?php echo self::$language['circle']?><?php echo self::$language['name']?></td>
                <td width="18%"><?php echo self::$language['circle']?><?php echo self::$language['center']?></td>
                <td width="10%"><?php echo self::$language['circle_range']?></td>
                <td width="6%"><?php echo self::$language['circle_area']?></td>
                <td width="6%"><?php echo self::$language['sequence']?></td>
                <td width="6%"><?php echo self::$language['visible']?></td>
                <td width="22%"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody >
            <tr id="new">
                <td id="new_td_first"></td>
                <td><select name="parent_id_new" id="parent_id_new" class='parent_id'>
                <option value="-1"><?php echo self::$language['select_please']?></option>
                <option value="0">--<?php echo self::$language['none']?>--</option>
                <?php echo $module['parent']?>
                </select></td>
                <td width="168"><input type="text" name="name_new" id="name_new" style="width:98%;" class='name' /></td>
              <td><input type="text" name="center_new" id="center_new" class='center' monxin_type="map" /></td>
              <td><input type="text" name="range_new" id="range_new" class='range' /></td>
              <td><div class=area_div><input type="hidden" name="area" id="area" class='area' />  <script src="area_js.php?callback=set_area&input_id=area&id=0&level=4&output=select" id='area_area_js'></script> <span class=state id=area_state></span></div></td>
              <td><input type="text" name="sequence_new" id="sequence_new" value="0" class='sequence' /></td>
              <td><input type='checkbox' name='visible_new' id='visible_new' checked="checked"  /></td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
