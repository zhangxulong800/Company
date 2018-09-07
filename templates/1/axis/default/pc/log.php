<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>  table select").each(function(index, element) {
            if($(this).attr('monxin_value')){$(this).val($(this).attr('monxin_value'));}
        });
		
		$("#<?php echo $module['module_name'];?> tr .state").each(function(index, element) {
            if($(this).attr('monxin_value')==1){$(this).prop('checked',true);}
        });
		
		$(document).on('click','#<?php echo $module['module_name'];?> .set_content',function(){
			set_iframe_position($(window).width()-100,$(window).height()-20);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		reset_icon_span_height();
		 window.setTimeout("reset_icon_span_height()",100);
		 window.setTimeout("reset_icon_span_height()",1000);
    });
    
    
    
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#act_state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false;	
        
    }
    
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#act_state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
                $("#state_select").html(v.info);
                if(v.state=='success'){
                //monxin_alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //monxin_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#act_state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                        $("#act_state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
                }
                }
            });
        }	
        return false;	
    }
    
	function reset_icon_span_height(){
		$("#<?php echo $module['module_name'];?> .log_detail .icon").each(function(index, element) {
            $(this).height($(this).parent().height());
        });
	}
	
	function reset_icon_span_height_id(id){
		$("#<?php echo $module['module_name'];?> #log_"+id+" .icon").height($("#<?php echo $module['module_name'];?> #log_"+id).height());
	}
	
	function add_new(id,html){
		
		$('<tr id=tr_'+id+'><td><input type="checkbox" name='+id+' id='+id+' class=id /></td><td class=log_detail_td>'+html+'</td><td class=operation_td><a href=./index.php?monxin=axis.content&axis_id=<?php echo $_GET['axis_id'];?>&id='+id+' class="edit set_content"><?php echo self::$language['edit'];?></a><a href=# onclick="return del('+id+')"  class=del><?php echo self::$language['del'];?></a> <span id=act_state_'+id+' class=act_state></span></td></tr>').insertBefore("#<?php echo $module['module_name'];?>_table tbody tr:first");
		$("#log_"+id).html($("#log_"+id).html().replace(/""/g,'"'));
		 window.setTimeout("reset_icon_span_height_id("+id+")",1000);
		
			
	}
	function update_old(id,html){
		console.log(html);
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .log_detail_td").html(html);
		 window.setTimeout("reset_icon_span_height_id("+id+")",1000);	
	}
	
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
	.table_scroll{ border:none !important;}
    #<?php echo $module['module_name'];?> table tr{ text-align:left; border:none; background:none !important;}
    #<?php echo $module['module_name'];?> table td{ text-align:left; border:none; background:none !important; padding:0px;}
    #<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> .log_detail{ width:900px; min-height:50px; }
	#<?php echo $module['module_name'];?> .log_detail .date_name{ display:inline-block; vertical-align:top; width:13%; text-align:right; overflow:hidden;}
	#<?php echo $module['module_name'];?> .log_detail .icon{display:inline-block; vertical-align:top; width:5%; overflow:hidden; text-align:center !important;  min-height:50px; height:100%;	}
	#<?php echo $module['module_name'];?> .log_detail .icon .bg_line{ display:block; margin:auto; height:100%;min-height:50px; width:5px; background:#CCC;}
	
	#<?php echo $module['module_name'];?> .log_detail .icon img{ width:40px; height:40px; border-radius:20px; border:3px solid #FFF;}
	#<?php echo $module['module_name'];?> .log_detail .icon b{display:inline-block; margin:auto; vertical-align:top; width:18px; height:18px; overflow:hidden; padding:0px; margin:0px; border-radius:10px; border:3px solid #6C0; background-color:#fff; position:relative; }
	#<?php echo $module['module_name'];?> .log_detail .icon [bold='1']{display:inline-block; width:24px; height:24px; overflow:hidden; padding:0px; margin:0px; border-radius:12px; border:6px solid  #6C0; background-color:#fff;}
	#<?php echo $module['module_name'];?> .log_detail .content{display:inline-block; vertical-align:top; width:70%; line-height:25px; overflow:hidden; padding-bottom:30px;}
	#<?php echo $module['module_name'];?> .log_detail .content img{max-width:100%;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a></li> 
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['name']?>" class="form-control" ></m_label></div></div></div>
    <div style="text-align:right;"><a href=./index.php?monxin=axis.content&axis_id=<?php echo $_GET['axis_id']?>&id=0 class="add set_content"><?php echo self::$language['add']?><?php echo self::$language['pages']['axis.log']['name']?></a><div>
   <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['content']?></td>
                <td  style=" width:450px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
