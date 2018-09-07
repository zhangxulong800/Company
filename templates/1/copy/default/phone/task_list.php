<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
            if($(this).attr('monxin_value')){$(this).val($(this).attr('monxin_value'));}
        });
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
    });
    
    
    
    function update(id){
        sequence=$("#sequence_"+id);
        if(sequence.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{sequence:sequence.prop('value'),state:$("#data_state_"+id).prop('value'),id:id}, function(data){
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
            obj[id]['state']=$("#data_state_"+ids[id]).prop('value');
            //monxin_alert(obj[id]['visible']);
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
            	//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_select").html(v.info);
                //monxin_alert(ids);
                success=v.ids.split("|");
                for(id in ids){
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                    }else{
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['executed'];?></span>");	
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
                //alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_alert(ids[id]);
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
    
	function all_re_copy(){
		$("#all_re_copy_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');;
        $.get('<?php echo $module['action_url'];?>&act=all_re_copy',function(data){
            //alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#all_re_copy_state").html(v.info);
		});
        return false;	
	}
	function get_all_task(){
		$("#get_all_task_a").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=get_all_task',function(data){
			
            //alert(data);
			//try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#get_all_task_a_state").html(data);
		});
         return false;	
	}
	function get_frist_page_task(){
		$("#get_frist_page_task_a").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');;
        $.get('<?php echo $module['action_url'];?>&act=get_frist_page_task',function(data){
			
            alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#get_frist_page_task_a").next().html('<?php echo self::$language['match'];?>:'+v.sum+'<?php echo self::$language['bar'];?> <?php echo self::$language['new_task']?>:'+v.new+' <a href="./index.php?monxin=copy.task_list&id=<?php echo $_GET['id'];?>" class=refresh><?php echo self::$language['refresh'];?></a>');
        });
         return false;	
	}
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .title{ display:inline-block; width: 10rem !important;}
	 #<?php echo $module['module_name'];?> .title img{ width:50px; border:0px;}
	 #<?php echo $module['module_name'];?> .task_page{ display:inline-block;  margin-left:30px; width:30px; text-align:center;}
	 #<?php echo $module['module_name'];?> .sequence{ width:2rem;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
        <input type="text" name="search_filter" id="search_filter" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
       &nbsp; &nbsp; <a href="#" id=get_frist_page_task_a onclick="get_frist_page_task()" class="add"><?php echo self::$language['get_frist_page_task']?></a> <span></span>  
       &nbsp; &nbsp; <br/><a href="#" id=get_all_task_a onclick="get_all_task()" class="add"><?php echo self::$language['get_all_task']?></a> <span id=get_all_task_a_state></span>  
        &nbsp; &nbsp; <a href="#" onclick="return all_re_copy();" class="reverse_select"><?php echo self::$language['all_re_copy']?></a> <span id="all_re_copy_state"></span>
        &nbsp; &nbsp; <a href="./index.php?monxin=copy.task&regular_id=<?php echo $_GET['id'];?>" class="open"><?php echo self::$language['open_copy_panel']?></a> <span id="open_copy_panel_state"></span>
       
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="4%"><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['name']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sequence|desc" class="sorting"  asc="sequence|asc"><?php echo self::$language['sequence']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['state']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td  style=" width:250px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
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
