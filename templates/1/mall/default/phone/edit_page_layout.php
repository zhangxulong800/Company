<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){ 
		$("[monxin-table] tbody tr").unbind('mouseover');
		$("[monxin-table] tbody tr").unbind('mouseout'); 
		
	});
	
	
	
    function update(id){
        head=$("#<?php echo $module['module_name'];?> #head_"+id).val();
        left=$("#<?php echo $module['module_name'];?> #left_"+id).val();
        right=$("#<?php echo $module['module_name'];?> #right_"+id).val();
        full=$("#<?php echo $module['module_name'];?> #full_"+id).val();
        bottom=$("#<?php echo $module['module_name'];?> #bottom_"+id).val();
        phone=$("#<?php echo $module['module_name'];?> #phone_"+id).val();
        layout=$("#<?php echo $module['module_name'];?> #layout_"+id).val();
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
        $.post('<?php echo $module['action_url'];?>&act=update',{id:id,head:head,left:left,right:right,full:full,bottom:bottom,phone:phone,layout:layout}, function(data){
			//monxin_//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        
		return false;	
        
    }
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{line-height:40px;}
    #<?php echo $module['module_name'];?>_html legend{ }
    #<?php echo $module['module_name'];?>_html a{line-height:40px; }
    #<?php echo $module['module_name'];?>_html a:hover{  text-decoration:underline;}
	[monxin-table] .url{ display:inline-block;width:150px; overflow:hidden;}
	[monxin-table] .module_list{ display:inline-block;width:650px; overflow:hidden; text-align:right;}
	[monxin-table] .module_list input{ display:inline-block;width:530px; margin-left:5px; overflow:hidden; margin:5px;}
 	[monxin-table] .layout{ display:inline-block;width:100px; overflow:hidden;}
	[monxin-table] .target{ display:inline-block;width:100px; overflow:hidden;}
	[monxin-table] .tutorial{ display:inline-block;width:100px; overflow:hidden;}
	.url span{ display:block;}
	
	#<?php echo $module['module_name'];?>_html .name{ width:150px;}
	#<?php echo $module['module_name'];?>_html operation_td{ width:200px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>


    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  style="width:100%;" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['name'];?>/<?php echo self::$language['url'];?></td>
                <td><?php echo self::$language['module'];?></td>
                <td><?php echo self::$language['main_area'];?></td>
                <td width="10%"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody >
   
    <?php echo $module['list']?>
    
        </tbody>
    </table></div>
    </div>

</div>