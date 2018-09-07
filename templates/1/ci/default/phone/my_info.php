<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .show_act").click(function(){
			if($(this).parent().next('.operation_td').css('display')=='none'){
				$(this).parent().next('.operation_td').css('display','block');
			}else{
				$(this).parent().next('.operation_td').css('display','none');
			}
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .icon img").each(function(index, element) {
            if($(this).attr('wsrc')!='./program/ci/img_thumb/'){$(this).attr('src',$(this).attr('wsrc'));}else{$(this).attr('src','./no_picture.png');}
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
			set_iframe_position($(window).width()-100,500);
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
				if(state==3){$("#tr_"+id).animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});}
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
	.filter{box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1); margin-bottom:0.5rem; padding-bottom:1rem;}
    #<?php echo $module['module_name'];?> .list{background: #F6F6F6;}
    #<?php echo $module['module_name'];?> .list .info{ padding:0.5rem;  box-shadow: 0px 2px 5px 2px rgba(0, 0, 0, 0.1); margin-bottom:0.5rem;}
    #<?php echo $module['module_name'];?> .list .info .icon{ display:inline-block; vertical-align:top; width:25%; overflow:hidden; }
    #<?php echo $module['module_name'];?> .list .info .icon img{ width:80%;}
    #<?php echo $module['module_name'];?> .list .info .info_other{ display:inline-block; vertical-align:top; width:75%; overflow:hidden;}
    #<?php echo $module['module_name'];?> .list .info .info_other .title{ font-weight:bold; line-height:2rem; line-height:2rem; white-space:nowrap; overflow:hidden;text-overflow: ellipsis;}
    #<?php echo $module['module_name'];?> .list .info .info_other .type_tag{ line-height:2rem; line-height:2rem; white-space:nowrap; overflow:hidden;text-overflow: ellipsis;}
    #<?php echo $module['module_name'];?> .list .info .operation_td{ height:3rem; line-height:3rem; }
	
	#<?php echo $module['module_name'];?> .list .info .info_other .visit:before{margin-right:3px; font: normal normal normal 1rem/1 FontAwesome; content:"\f06e";}
	#<?php echo $module['module_name'];?> .list .info .info_other .time:before{margin-left:1rem;margin-right:3px; font: normal normal normal 1rem/1 FontAwesome; content:"\f017";}
	#<?php echo $module['module_name'];?> .list .info .info_other .show_act{ display:none;}
	#<?php echo $module['module_name'];?> .list .info .info_other .show_act:before{margin-left:1rem;margin-right:3px; font: normal normal normal 1rem/1 FontAwesome; content:"\f013"; opacity:0.6;}
	#<?php echo $module['module_name'];?> .list .info .operation_td{}
	#<?php echo $module['module_name'];?> .data_state{margin-left:1rem;}
	#<?php echo $module['module_name'];?> .data_state .s_0{ }
	#<?php echo $module['module_name'];?> .data_state .s_1{ }
	#<?php echo $module['module_name'];?> .data_state .s_2{ }
	#<?php echo $module['module_name'];?> .close{ float:none;}
	.operation_td br{ display:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['title']?>/<?php echo self::$language['content']?>/<?php echo self::$language['linkman']?>/<?php echo self::$language['contact']?>" class="form-control" ></m_label></div></div></div>
    
    
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <?php echo $module['filter']?>
       &nbsp; &nbsp; <a href="index.php?monxin=ci.add" target="_blank" class="add"><?php echo self::$language['release']?><?php echo self::$language['info'];?></a>  
    </div>
   	<div class=list>
    	<?php echo $module['list'];?>
    </div>

    <?php echo $module['page']?>
    </div>
</div>
