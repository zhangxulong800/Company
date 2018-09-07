<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
        $("#<?php echo $module['module_name'];?> .data_state").each(function(index, element) {
            if($(this).prop('value')==1){$(this).prop('checked',true);}
        });
        $("#<?php echo $module['module_name'];?> .like").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
    });
    
    
    function update(id){
        sequence=$("#sequence_"+id);
        if($("#data_state_"+id).prop('checked')){state=1;}else{state=0;}
        if(sequence.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{like:$("#like_"+id).val(),sequence:sequence.prop('value'),id:id,state:state}, function(data){
			////alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            $("#state_"+id).html(v.info);
        });
         return false;	
        
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				////alert(data);
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
			if($("#data_state_"+ids[id]).prop('checked')){state=1;}else{state=0;}
            obj[id]['state']=state;
            obj[id]['like']=$("#like_"+ids[id]).prop('value');
            obj[id]['sequence']=$("#sequence_"+ids[id]).prop('value');
            //monxin_//alert(obj[id]['visible']);
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                //monxin_//alert(ids);
                success=v.ids.split("|");
                for(id in ids){
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                    }else{
                        $("#state_"+ids[id]).html("<span class=fail><?php echo self::$language['fail'];?></span>");	
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
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>_table .type{width:100px;}
	#<?php echo $module['module_name'];?>_table .key{display:inline-block;}
    #<?php echo $module['module_name'];?>_table .title{width:280px;}
    #<?php echo $module['module_name'];?>_table .editor{width:100px;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?>_table .sequence{width:40px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['keyword']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
        <a href="index.php?monxin=<?php echo $module['class_name'];?>.auto_answer_add&wid=<?php echo @$_GET['wid'];?>" class="add"><?php echo self::$language['add']?><?php echo self::$language['keyword']?></a>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="4%"><input type="checkbox" group-checkable=1></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="key|desc" class="sorting"  asc="key|asc"><?php echo self::$language['keyword']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="like|desc" class="sorting"  asc="like|asc"><?php echo self::$language['like']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sequence|desc" class="sorting"  asc="sequence|asc"><?php echo self::$language['sequence']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['open']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="visit|desc" class="sorting"  asc="visit|asc"><?php echo self::$language['use_count']?></a></td>
                <td ><?php echo self::$language['author']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td  style=" width:240px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=batch_operation_div>
    			<span class="corner">&nbsp;</span>
    
                <a href="#" class="select_all" onclick="return select_all();"><?php echo self::$language['select_all']?></a>
                <a href="#" class="reverse_select" onclick="return reverse_select();"><?php echo self::$language['reverse_select']?></a>
                 <?php echo self::$language['selected']?>:
                 <a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a> 
                 <a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a> 
                  <span id="state_select"></span>
                  </div>
    <?php echo $module['page']?>
    </div>
</div>
