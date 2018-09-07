<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .data_state").each(function(index, element) {
            if($(this).prop('value')==1){$(this).prop('checked',true);}
        });
        $("#<?php echo $module['module_name'];?> .data_state").click(function(){
            id=this.id;
            id=id.replace("data_state_","");
            if($(this).prop('checked')){state=1;}else{state=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_state',{id:id,state:state});
		});
    });
    function get_user_list(){
			$("#<?php echo $module['module_name'];?> #get_user_list_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=get_user_list', function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#get_user_list_state").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');
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
    #<?php echo $module['module_name'];?>_table .icon_span img{width:32px;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="openid/<?php echo self::$language['nickname']?>/<?php echo self::$language['gender']?>/<?php echo self::$language['area']?>/<?php echo self::$language['binding'];?><?php echo self::$language['username']?>" value="<?php echo @$_GET['search']?>"  style="width:50%;" />
        <a href="#" onclick="return e_search();" class="search"><span class=b_start> </span><span class=b_middle><?php echo self::$language['search']?></span><span class=b_end> </span></a> <span id="search_state"></span>
      &nbsp; &nbsp; <a href="#" onclick="return get_user_list();" class="add"><span class=b_start> </span><span class=b_middle><?php echo self::$language['get_user_list']?></span><span class=b_end> </span></a> <span id="get_user_list_state"></span>
	</div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td width="4%"> </td>
                <td ><?php echo self::$language['icon']?></td>
                <td ><?php echo self::$language['nickname']?>/openid</td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="latitude|desc" class="sorting"  asc="latitude|asc"><?php echo self::$language['user_position']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sex|desc" class="sorting"  asc="sex|asc"><?php echo self::$language['gender']?></a></td>
                <td ><?php echo self::$language['area']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="subscribe|desc" class="sorting"  asc="subscribe|asc"><?php echo self::$language['is_subscribe']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="subscribe_time|desc" class="sorting"  asc="subscribe_time|asc"><?php echo self::$language['subscribe_time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['using']?></a></td>
                <td ><?php echo self::$language['binding'];?><?php echo self::$language['username']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['join']?><?php echo self::$language['time']?></a></td>
                <td  style=" width:370px;text-align:left;"><span class=operation_icon> </span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=batch_operation_div>
    			<span class="corner"> </span>
    
                <a href="#" class="select_all" onclick="return select_all();"><span class=b_start> </span><span class=b_middle><?php echo self::$language['select_all']?></span><span class=b_end> </span></a>
                <a href="#" class="reverse_select" onclick="return reverse_select();"><span class=b_start> </span><span class=b_middle><?php echo self::$language['reverse_select']?></span><span class=b_end> </span></a>
                 <?php echo self::$language['selected']?>:
                 <a href="#" class="del" onclick="return del_select();"><span class=b_start> </span><span class=b_middle><?php echo self::$language['del']?></span><span class=b_end> </span></a> 
                  <span id="state_select"></span>
                  </div>
    <?php echo $module['page']?>
    </div>
</div>
