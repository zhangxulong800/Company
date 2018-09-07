<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
    });
    
    function update(id){
        var title=$("#title_"+id);	
        if(title.prop('value')==''){$("#state_"+id).html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['title']?></span>');title.focus();return false;}	
        
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{title:title.prop('value'),id:id}, function(data){
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
    
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_table .title{display:block; text-align:left; font-weight:bolder; text-decoration:none;}
    #<?php echo $module['module_name'];?>_table .content{ margin-left:50px;  text-align:left;  font-size:15px; line-height:25px; margin-bottom:20px;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?>_table .visible{}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="filter"><input type="text" name="search_filter" id="search_filter" value="<?php echo @$_GET['search']?>" placeholder="<?php echo self::$language['replay']?><?php echo self::$language['content']?>" />
        <a href="#" onclick="return e_search();" class="search"><span class=b_start> </span><span class=b_middle><?php echo self::$language['search']?></span><span class=b_end> </span></a> <span id="search_state"></span></div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['title']?>/<?php echo self::$language['replay']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="visible|desc" class="sorting"  asc="visible|asc"><?php echo self::$language['state']?></a></td>
                <td  style=" text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
