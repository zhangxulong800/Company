<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$('#import_file_ele').insertBefore($('#import_file_state'));
		$("#<?php echo $module['module_name'];?> .import_switch").click(function(){
			if($("#<?php echo $module['module_name'];?> .import_div").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .import_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> .import_div").css('display','none');
			}
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .exe_import").click(function(){
			$("#<?php echo $module['module_name'];?> .exe_import").next('span').html('');
			if($("#<?php echo $module['module_name'];?> #import_file").val()==''){
					$("#<?php echo $module['module_name'];?> .exe_import").next('span').html('<span class=fail><?php echo self::$language['please_upload']?></span>');	
					return false;
			}
			if($("#<?php echo $module['module_name'];?> .field_set").val()==''){
					$("#<?php echo $module['module_name'];?> .exe_import").next('span').html('<span class=fail><?php echo self::$language['please_input']?></span>');	
					$("#<?php echo $module['module_name'];?> .field_set").focus();
					return false;
			}
			$("#<?php echo $module['module_name'];?> .exe_import").css('display','none');
			$("#<?php echo $module['module_name'];?> .exe_import").next('span').html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['executing']?>');
			$.post("<?php echo $module['action_url'];?>&act=import",{field_set:$("#<?php echo $module['module_name'];?> .field_set").val(),import_file:$("#<?php echo $module['module_name'];?> #import_file").val()},function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .exe_import").next('span').html(v.info);
				$("#<?php echo $module['module_name'];?> .exe_import").next('span').css('display','block').width('100%');
				if(v.state=='fail'){
					$("#<?php echo $module['module_name'];?> .exe_import").css('display','inline-block');
					
				}else{
					$("#<?php echo $module['module_name'];?> .exe_import").next('span').html(v.info+' <a href=./index.php?monxin=mall.my_buyer><?php echo self::$language['refresh']?></a>');
				}
			});	
			
			return false;	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> .rehcarge,#<?php echo $module['module_name'];?> .credits',function(){
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		
		var group_id=get_param('group_id');
		if(group_id!=''){$("#group_id_filter").prop("value",group_id);}
		$("#<?php echo $module['module_name'];?> .group_id").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
		
    });
    
	
    function update(id){
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{group_id:$("#<?php echo $module['module_name'];?> #group_id_"+id).prop('value'),chip:$("#<?php echo $module['module_name'];?> #chip_"+id).prop('value'),id:id}, function(data){
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
				
                $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
       return false; 
    }
	
	function update_balance(id,v){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .balance").html(parseFloat($("#<?php echo $module['module_name'];?> #tr_"+id+" .balance").html())+parseFloat(v));	
	}
	function update_credits(id,v){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .creditss").html(parseFloat($("#<?php echo $module['module_name'];?> #tr_"+id+" .creditss").html())+parseFloat(v));	
	}
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html [monxin-table] .filter{ line-height:40px;}
	#<?php echo $module['module_name'];?>_html #search_filter{ width:30%;}
	#<?php echo $module['module_name'];?>_html .import_div{ text-align:right; border-bottom:1px solid #CCC; display:none;}
	#<?php echo $module['module_name'];?>_html .import_div #import_file_ele{ width:20rem !important; }
	#<?php echo $module['module_name'];?>_html .import_div .exe_import{ display:inline-block;   border-radius:0.5rem; padding:0.3rem;}
	#<?php echo $module['module_name'];?>_html .import_div .field_set{ width:20%;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
     <div class=import_div>
     	<?php echo self::$language['file']?>(<?php echo self::$language['import_file_placeholder']?>):
	 	<span id=import_file_state></span>
		&nbsp; <?php echo self::$language['import_field_set']?>: <input type="text" placeholder="<?php echo self::$language['import_field_set_placeholder']?>" class="field_set" /> <a class=exe_import><?php echo self::$language['submit']?></a> <span class=state></span></div>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
        	
        	<a href=# class=import_switch><?php echo self::$language['import_user']?></a>
            <a  href=./index.php?monxin=mall.increase_user class="add increase_user"><?php echo self::$language['increase']?><?php echo self::$language['member']?></a>
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
       
    </div>
                        
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search" placeholder="<?php echo self::$language['username']?>"  class="form-control" ></m_label></div></div></div>
    
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0" >
         <thead>
            <tr>
                <td ><?php echo self::$language['username']?></td>
                <td ><?php echo self::$language['successful_consumption']?></td>
                <td ><?php echo self::$language['cumulative_order']?></td>
                <td ><?php echo self::$language['store']?><?php echo self::$language['balance']?></td>
                <td ><?php echo self::$language['available']?><?php echo self::$language['credits']?></td>
                <td ><?php echo self::$language['cumulative']?><?php echo self::$language['credits']?></td>
                <td ><?php echo self::$language['first_time']?></td>
                <td ><?php echo self::$language['level']?></td>
                <td ><?php echo self::$language['shop_chip']?></td>
                <td  style=" width:270px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    
    <?php echo $module['page']?>
    </div>
    </div>

</div>
