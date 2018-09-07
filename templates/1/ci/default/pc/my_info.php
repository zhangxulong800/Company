<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		
		$("#<?php echo $module['module_name'];?> .icon img").each(function(index, element) {
            if($(this).attr('wsrc')!='./program/ci/img_thumb/'){$(this).attr('src',$(this).attr('wsrc'));}else{$(this).attr('src','./no_picture.png');}
        });
		$("#<?php echo $module['module_name'];?> .type a").each(function(index, element) {
			if($(this).attr('class')!='set'){$(this).html($(this).html()+' >');}
        });
		
		$("#m_close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			return false;
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> .set',function(){
			set_iframe_position(800,500);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .data_state").each(function(index, element) {
            if($(this).prop('value')==1){$(this).prop('checked',true);}
        });
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
		
        $("#<?php echo $module['module_name'];?> .sequence").blur(function(){
            id=this.id;
            id=id.replace("sequence_","");
            $.get('<?php echo $module['action_url'];?>&act=update_sequence',{id:id,sequence:$(this).val()},function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                
			});
        });        
		
        var get_search=get_param('search');
        if(get_search.length<1){
            var tag=get_param('tag');
            var position=get_param('position');
            var supplier=get_param('supplier');
            var type=get_param('type');
            if(tag!=''){$("#tag_filter").prop("value",tag);}
            if(position!=''){$("#position_filter").prop("value",position);}
            if(supplier!=''){$("#supplier_filter").prop("value",supplier);}
            if(type!=''){$("#type_filter").prop("value",type);}
        }
        
        $("[monxin-table] tbody tr").each(function(index, element) {
            $("#"+$(this).attr('id')+' .type').prop('value',$(this).attr('typeid'));
        });
        
    });
	function set_state(id,state){
		if(state==3){
			 if(!confirm("<?php echo self::$language['delete_confirm']?>")){return false;}
		}
		
		$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('<?php echo $module['action_url'];?>&act=set_state',{id:id,state:state}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
			$("#state_"+id).html(v.info);
			if(v.state=='success'){
				$("#tr_"+id+" .operation_td").html(v.info);
				$("#<?php echo $module['module_name'];?> #tr_"+id+" .data_state").html(v.html);
				if(state==3){$("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});}
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
    
	function update_reflash_time(id,v){
		$("#tr_"+id+" .time").html(v);
	}
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .set{display:inline-block; vertical-align:top; text-decoration:none;}
	#<?php echo $module['module_name'];?> [monxin-table] thead tr td{ white-space:nowrap;}
    #<?php echo $module['module_name'];?> #search_filter{ width:300px;}
    #<?php echo $module['module_name'];?>_table .icon{ width:110px; overflow:hidden; text-align:left; display:block;}
    #<?php echo $module['module_name'];?>_table .icon img{ height:80px; border:0px; margin-top:5px;}
    #<?php echo $module['module_name'];?>_table .title{ text-align:left; display:block; overflow:hidden; width:300px; height:30px;}
    #<?php echo $module['module_name'];?>_table .type_tag{ text-align:left; }
    #<?php echo $module['module_name'];?>_table .type_tag a{ }
    #<?php echo $module['module_name'];?>_table .type{ text-align:left; display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .tag{ text-align:right; display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .type a{ margin-right:10px; text-decoration:none;}
    #<?php echo $module['module_name'];?>_table .sequence{ width:50px;}
	#<?php echo $module['module_name'];?>_table .operation_td{ line-height:1.5rem;}
	#<?php echo $module['module_name'];?>_table .operation_td .edit{display:inline-block; vertical-align:top; }
	#<?php echo $module['module_name'];?>_table .operation_td .del{ display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?>_table .operation_td .m_close{   display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?>_table .operation_td .m_open{   display:inline-block; vertical-align:top;}
	#<?php echo $module['module_name'];?>_table .operation_td a{  font-size:16px;}
	
	#<?php echo $module['module_name'];?>_table .data_state{}
	#<?php echo $module['module_name'];?>_table .data_state .s_0{ }
	#<?php echo $module['module_name'];?>_table .data_state .s_1{ }
	#<?php echo $module['module_name'];?>_table .data_state .s_2{ }
	#<?php echo $module['module_name'];?> .m_close{ float:none;}

    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" onclick="return subimt_select();"><?php echo self::$language['submit']?></a></li> 
                    <li><a href="#"  onclick="return show_select(1);" class=show><?php echo self::$language['show']?></a></li> 
                    <li><a href="#" onclick="return show_select(0);" class=hide><?php echo self::$language['hide']?></a></li> 
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['title']?>/<?php echo self::$language['content']?>/<?php echo self::$language['linkman']?>/<?php echo self::$language['contact']?>" class="form-control" ></m_label></div></div></div>
    
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
       &nbsp; &nbsp; <a href="index.php?monxin=ci.add" target="_blank" class="add"><?php echo self::$language['release']?><?php echo self::$language['info'];?></a>  
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['cover_image']?></td>
                <td style="text-align:left; padding-left:5px;"><?php echo self::$language['title']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="visit|desc" class="sorting"  asc="visit|asc"><?php echo self::$language['visit']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="reflash|desc" class="sorting"  asc="reflash|asc"><?php echo self::$language['refresh']?><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['state']?></a></td>
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
