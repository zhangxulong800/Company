<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
    });
    
    
    
    
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
                //monxin_alert(ids);	
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
    </script>
	<style>    
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .sum_div{ float:right; text-align:right;}
	#<?php echo $module['module_name'];?> .sum_div .m_label{ }
	#<?php echo $module['module_name'];?> .sum_div .value{ font-weight:bold;padding-right:20px;}
	#<?php echo $module['module_name'];?> .title{ display:block; width:500px; overflow:hidden; text-align:left; white-space:nowrap; text-overflow: ellipsis; padding-left:15px; }
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['share_content']?>/<?php echo self::$language['username']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
		<div class=sum_div><b><?php echo self::$language['sum']?> </b> <?php echo $module['sum'];?></div>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="4%"><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['username']?></td>
                <td ><span class=title><?php echo self::$language['share_content']?></span></td>
                <td ><?php echo self::$language['visit']?></td>
                <td ><?php echo self::$language['reg']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="contribution|desc" class="sorting"  asc="contribution|asc"><?php echo self::$language['contribution']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td  style=" width:170px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
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
                 <a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a> 
                  <span id="state_select"></span>
                  </div>
    <?php echo $module['page']?>
    </div>
</div>
