<div id=<?php echo $module['module_name'];?>  save_name="<?php echo $module['module_save_name'];?>"   class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #type").val('<?php echo @$_GET['type'];?>');
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
		$("#<?php echo $module['module_name'];?> .visible").each(function(index, element) {
           if($(this).prop('value')==1){$(this).prop('checked',true);}
        });
        $("#<?php echo $module['module_name'];?> .visible").click(function(){
            id=this.id;
            id=id.replace("visible_","");
            if($(this).prop('checked')){visible=1;}else{visible=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_visible',{id:id,visible:visible});
        });        
        var get_search=get_param('search');
        if(get_search.length<1){
            var visible=get_param('visible');
            var type=get_param('type');
            if(visible!=''){$("#visible_filter").prop("value",visible);}
            if(type!=''){$("#type_filter").prop("value",type);}
        }
        $(".table_scroll").preventScroll();
        
		if(<?php echo $module['liveupdate']?>==1){
			setInterval("liveupdate()",2000);
		}
		
    });
    
	function liveupdate(){
		last_id=0;
		$("#<?php echo $module['module_name'];?> .table_scroll table tbody tr").each(function(index, element) {
			id=$(this).attr('id').replace('tr_','');
            if(id>last_id){last_id=id;}
        });
        $.get('./receive.php?target=index::visitor_position&act=talk_title_new',{type:<?php echo $module['type']?>,last_id:last_id}, function(data){
			console.log(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			if(v.state=='success'){
				if(v.list!=''){
					if(!$("#<?php echo $module['module_name'];?> .table_scroll td .input_checkbox").attr('id')){
						$("#<?php echo $module['module_name'];?>_html  .table_scroll table tbody").append(v.list);
					}else{
						$("#<?php echo $module['module_name'];?> .temp_table").html(v.list);
						temp='';
						$("#<?php echo $module['module_name'];?> .temp_table tr").each(function(index, element) {
                            temp+='<tr id='+$(this).attr('id')+'><td>&nbsp;</td>'+$(this).html()+'</tr>';
                        });
						$("#<?php echo $module['module_name'];?> .temp_table").html('');
						$("#<?php echo $module['module_name'];?>_html  .table_scroll table tbody").append(temp);
						
					}
					
					$(window).scrollTop($("#<?php echo $module['module_name'];?>_html  .table_scroll table tbody").height()+$("#<?php echo $module['module_name'];?>_html  .table_scroll table tbody").offset().top-$(window).height()*0.5)
				}
			}
        });
	}
	
    
    
    
    function update(id){
        sequence=$("#sequence_"+id);
        if($("#visible_"+id).prop('checked')){visible=1;}else{visible=0;}
        if(sequence.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{sequence:sequence.prop('value'),id:id,visible:visible}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            $("#state_"+id).html(v.info);
        });
         return false;	
        
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false; 	
        
    }
    
    
    
    
    
    function subimt_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['sequence']=$("#sequence_"+ids[id]).prop('value');
            //monxin_//alert(obj[id]['visible']);
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
                $("#state_select").html(v.info);
                //alert(ids);
                success=v.ids.split("|");
                for(id in ids){
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
                }
        });	
        
         return false;
        
        	
    }
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
            //alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                if(v.state=='success'){
                //monxin_//alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_//alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
                }
                }
            });
        }	
         return false;	
    }
    
    function show_select(flag){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(flag){visible=true;}else{visible=false;}
        $.get('<?php echo $module['action_url'];?>&act=operation_visible&visible='+flag,{ids:ids}, function(data){
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                if(v.state=='success'){
                    ids=ids.split('|');
                    for(id in ids){$("#visible_"+ids[id]).prop('checked',visible);}
                }
        });
         return false;	
    }
    
    function move_to(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        $.get('<?php echo $module['action_url'];?>&act=move_to&to_type='+$("#<?php echo $module['module_name'];?> #type").val(),{ids:ids}, function(data){
			//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                if(v.state=='success'){
                    ids=ids.split('|');
                    for(id in ids){$("#visible_"+ids[id]).prop('checked',visible);}
                }
        });
         return false;	
    }
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>_table .type{width:100px;}
    #<?php echo $module['module_name'];?>_table .title{ display:inline-block;min-width:200px; float:left; text-align:left; margin-top:10px;margin-bottom:10px; font-weight:bold; padding-left:10px;}
    #<?php echo $module['module_name'];?>_table .thead_title{ text-align:left; padding-left:15px; width:600px;}
    #<?php echo $module['module_name'];?>_table .title:hover{  text-decoration:none;}
    #<?php echo $module['module_name'];?>_table .editor{width:100px;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?>_table .sequence{width:40px;}
    #<?php echo $module['module_name'];?>_table .visible{}
    #<?php echo $module['module_name'];?>_table .thumb_img{ width:280px; border:0px;}
	#<?php echo $module['module_name'];?>_table tbody tr td{ border-left:none;}
	#<?php echo $module['module_name'];?>_table #visible_12{ height:13px;}
	#<?php echo $module['module_name'];?>_html .add{ margin-top:10px; margin-bottom:10px; display:inline-block; height:30px;}
	.edit_type{ display:block; padding-left:1rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <a href="./index.php?monxin=talk.title_add&type=<?php echo @$_GET['type'];?>" class="add"><?php echo self::$language['add_title']?></a>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"   role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
             <?php echo $module['head_td'];?>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['batch_operation']?>
    <?php echo $module['page']?>
    <table class=temp_table style="display:none;"></table>
    </div>
</div>
