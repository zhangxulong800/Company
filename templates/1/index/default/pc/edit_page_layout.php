<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){ 
		$("[monxin-table] tbody tr").unbind('mouseover');
		$("[monxin-table] tbody tr").unbind('mouseout'); 
		if(get_param('program')==''){$("#program_list").css('display','block');$("[monxin-table] table").css('display','none');}
		
		$("#<?php echo $module['module_name'];?>_html #tr_new .add").click(function(){
			var obj=new Object();
			obj['name']=$("#<?php echo $module['module_name'];?> #tr_new .name").val();
			obj['url']=$("#<?php echo $module['module_name'];?> #tr_new .url").val();
			obj['head']=$("#<?php echo $module['module_name'];?> #tr_new .head").val();
			obj['left']=$("#<?php echo $module['module_name'];?> #tr_new .left").val();
			obj['right']=$("#<?php echo $module['module_name'];?> #tr_new .right").val();
			obj['full']=$("#<?php echo $module['module_name'];?> #tr_new .full").val();
			obj['bottom']=$("#<?php echo $module['module_name'];?> #tr_new .bottom").val();
			obj['layout']=$("#<?php echo $module['module_name'];?> #tr_new .layout").val();
			obj['target']=$("#<?php echo $module['module_name'];?> #tr_new .target").val();
			obj['tutorial']=$("#<?php echo $module['module_name'];?> #tr_new .tutorial").val();
			if(obj['name']==''){alert('<?php echo self::$language['name']?><?php echo self::$language['is_null']?>');return false;}
			if(obj['url']==''){alert('<?php echo self::$language['url']?><?php echo self::$language['is_null']?>');return false;}
				
			$("#<?php echo $module['module_name'];?>_html #tr_new .add").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?>_html #tr_new .add").next().html(v.info);
			});
			return false;	
		});
		
	});
	
	
	
    function update(id){
        head=$("#<?php echo $module['module_name'];?> #head_"+id).val();
        left=$("#<?php echo $module['module_name'];?> #left_"+id).val();
        right=$("#<?php echo $module['module_name'];?> #right_"+id).val();
        full=$("#<?php echo $module['module_name'];?> #full_"+id).val();
        bottom=$("#<?php echo $module['module_name'];?> #bottom_"+id).val();
        phone=$("#<?php echo $module['module_name'];?> #phone_"+id).val();
        layout=$("#<?php echo $module['module_name'];?> #layout_"+id).val();
        target=$("#<?php echo $module['module_name'];?> #target_"+id).val();
        tutorial=$("#<?php echo $module['module_name'];?> #tutorial_"+id).val();
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		//
        $.post('<?php echo $module['action_url'];?>&act=update',{id:id,head:head,left:left,right:right,full:full,bottom:bottom,phone:phone,layout:layout,target:target,tutorial:tutorial,authorize:$("#<?php echo $module['module_name'];?> #authorize_"+id).val()}, function(data){
			//monxin_alert(data);
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

	
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{line-height:40px;}
    #<?php echo $module['module_name'];?>_html legend{ }
    #<?php echo $module['module_name'];?>_html a{line-height:40px; }
    #<?php echo $module['module_name'];?>_html a:hover{  text-decoration:underline;}
	#<?php echo $module['module_name'];?>_html .authorize{ width:8rem;}
	#program_list{ line-height:25px; margin:20px; display:none;}
	#program_list a{ display:inline-block; width:140px; height:140px; text-align:center; margin:20px; margin-left:25px; margin-right:25px; }
	#program_list a:hover{}
	#program_list a img{ width:120px; height:120px; border:none; border-radius:50%; background:<?php echo $_POST['monxin_user_color_set']['nv_2']['background']?>;}
	#program_list a img:hover{ width:120px; height:120px; border:none; border-radius:50%; background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>;}
	[monxin-table] .url{ display:inline-block;width:150px; overflow:hidden;}
	[monxin-table] .module_list{ display:inline-block;width:350px; overflow:hidden;}
	[monxin-table] .module_list input{ display:inline-block;width:230px; margin-left:5px; overflow:hidden; margin:5px;}
 	[monxin-table] .layout{ display:inline-block;width:100px; overflow:hidden;}
	[monxin-table] .target{ display:inline-block;width:100px; overflow:hidden;}
	[monxin-table] .tutorial{ display:inline-block;width:100px; overflow:hidden;}
	.url span{ display:block;}
	
	#<?php echo $module['module_name'];?>_html .name{ width:150px;}
	#<?php echo $module['module_name'];?>_html operation_td{ width:200px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
	
    <fieldset id=program_list><legend><?php echo self::$language['please_select'];?></legend>
    <?php echo $module['program_list'];?>
    </fieldset>


    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  style="width:auto;" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['name'];?>/<?php echo self::$language['url'];?></td>
                <td><?php echo self::$language['module'];?></td>
                <td><?php echo self::$language['main_area'];?></td>
                <td><?php echo self::$language['target'];?></td>
                <td><?php echo self::$language['tutorial'];?></td>
                <td width="10%"><span class=operation_icon> </span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody >
   
    <?php echo $module['list']?>
    
        </tbody>
    </table></div>
    </div>

</div>