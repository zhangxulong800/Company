<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
				
		$("#<?php echo $module['module_name'];?> .mall_state").each(function(index, element) {
            $(this).prop('value',$(this).attr('monxin_value'));
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
		
        $("#<?php echo $module['module_name'];?> .mall_state").change(function(){
            id=this.id;
            id=id.replace("mall_state_","");
            $.get('<?php echo $module['action_url'];?>&act=update_mall_state',{id:id,state:$(this).val()},function(data){
				//alert(data);
                try{v=eval("("+data+")");}catch(exception){alert(data);}
				
                $("#state_"+id).html(v.info);
                
			});
        });        
		
        $("#<?php echo $module['module_name'];?> .data_state").click(function(){
            id=this.id;
            id=id.replace("data_state_","");
            if($(this).prop('checked')){visible=1;}else{visible=0;}
            $.get('<?php echo $module['action_url'];?>&act=update_state',{id:id,state:visible});
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
        
		
		$("#<?php echo $module['module_name'];?> .type a").each(function(index, element) {
			if($(this).attr('class')!='set'){$(this).html($(this).html()+' >');}
        });
		
		$("#close_button").click(function(){
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
    
    function set_mall_state(value){
		
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        $.get('<?php echo $module['action_url'];?>&act=set_mall_state&v='+value,{ids:ids}, function(data){
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#state_select").html(v.info);
			if(v.state=='success'){
				ids=ids.split('|');
				for(id in ids){$("#mall_state_"+ids[id]).prop('value',value);}
			}
        });
         return false;	
    }
    
	function update_type(id,c){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .type_tag .type").html(c);
	}
	function update_tag(id,c){
		$("#fade_div").css('display','none');
		$("#set_monxin_iframe_div").css('display','none');
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .type_tag .tag").html(c);
	}
	
    function mass(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
		window.location.href='<?php echo $module['action_url'];?>&act=mass_select&ids='+ids;
        return false;	
    }
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .set{display:inline-block; vertical-align:top; width:30px; text-decoration:none;}
	 #<?php echo $module['module_name'];?> .set:before{font: normal normal normal 15px/1 FontAwesome;content: "\f040";}
	#<?php echo $module['module_name'];?> [monxin-table] thead tr td{ white-space:nowrap;}
    #<?php echo $module['module_name'];?> #search_filter{ width:300px;}
    #<?php echo $module['module_name'];?>_table .icon{ width:110px; overflow:hidden; text-align:left; display:block;}
    #<?php echo $module['module_name'];?>_table .icon img{ height:80px; border:0px; margin-top:5px;}
    #<?php echo $module['module_name'];?>_table .title{ text-align:left; display:block; overflow:hidden; width:410px;  height:40px;}
    #<?php echo $module['module_name'];?>_table .type_tag{ text-align:left; }
    #<?php echo $module['module_name'];?>_table .type_tag a{ }
    #<?php echo $module['module_name'];?>_table .type{ text-align:left; display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .tag{ text-align:right; display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .type a{ margin-right:10px; text-decoration:none;}

    #<?php echo $module['module_name'];?>_table .sequence{ width:50px;}
	#<?php echo $module['module_name'];?>_table .operation_td .del{}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                 	<?php echo $module['mall_state'];?>
                    <li><a href="#" class="mass" onclick="return mass();"><?php echo self::$language['add']?><?php echo self::$language['mass']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['bar_code']?>/<?php echo self::$language['detail']?>"  class="form-control" ></m_label></div></div></div>
    

    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['cover_image']?></td>
                <td style="text-align:left;"><?php echo self::$language['goods_name']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sold|desc" class="sorting"  asc="sold|asc"><?php echo self::$language['sold']?></a></td>
                <td ><?php echo self::$language['shop_name']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="visit|desc" class="sorting"  asc="visit|asc"><?php echo self::$language['visit']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="sequence|desc" class="sorting"  asc="sequence|asc"><?php echo self::$language['sequence']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="mall_state|desc" class="sorting"  asc="mall_state|asc"><?php echo self::$language['state']?></a></td>
                <td  style=" width:170px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
