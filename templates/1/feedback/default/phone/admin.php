<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .content tr").attr('class','');
		$("#<?php echo $module['module_name'];?> .answer tr").attr('class','');
		state=get_param('state');
		if(state!=''){$("#feedback_state #"+state).attr('class','current');}else{$("#feedback_state a:first-child").addClass('current');}
		
		$("#<?php echo $module['module_name'];?> .answer_user").each(function(index, element) {
            if($(this).html()=='()'){$(this).parent('div').css('display','none');}
        });
		$("#<?php echo $module['module_name'];?> .msg_state").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
    });
    
    
    function update(id){
        var answer=$("#answer_"+id);
        var msg_state=$("#msg_state_"+id);	
        sequence=$("#sequence_"+id);
        if(msg_state.prop('checked')){msg_state=1;}else{msg_state=0;}
        if(sequence.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=update',{answer:answer.prop('value'),sequence:sequence.prop('value'),id:id,msg_state:msg_state}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#state_"+id).html(v.info);
        });
         return false;	
        
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				//monxin_alert(data);
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
            $.post('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
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
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .msg_div{ margin:10px;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info{ text-align:left;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info span{ display:inline-block; margin-right:20px;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .sender:before {font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content: "\f007";}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .time:before {font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content: "\f017";}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .ip:before {font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content: "\f041";}
	#<?php echo $module['module_name'];?>_html .msg_div .answer_info{ line-height:3rem !important;}
    #<?php echo $module['module_name'];?>_html .msg_div .sender_info .receive{}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info .time:before {font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content: "\f017";}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info .answer_user:before {font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content: "\f007";}
	
	#<?php echo $module['module_name'];?>_html .msg_div table tbody tr{ height:auto; background:none;}
	#<?php echo $module['module_name'];?>_html .msg_div table tbody tr td{ border:none; padding:0px; height:auto;}
    #<?php echo $module['module_name'];?>_html .msg_div .content_div .v{ display:inline-block; margin-top:-0.6rem; text-align:left; margin-bottom:20px; max-width:60%; padding:0.5rem; border-radius:0.5rem; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
	#<?php echo $module['module_name'];?>_html .msg_div .content_div:before{font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content: "\f0d8"; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; padding-left:1rem; display:block; }
	
	#<?php echo $module['module_name'];?>_html .msg_div .answer_div { text-align:right;}
	#<?php echo $module['module_name'];?>_html .msg_div .answer_div:after{font: normal normal normal 18px/1 FontAwesome;margin-right: 5px;content:"\f0d7"; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; padding-right:1rem; display:block; }
    #<?php echo $module['module_name'];?>_html .msg_div .answer_div .answer{display:inline-block; margin-bottom:-0.4rem; text-align:left;max-width:60%; padding:0.5rem; border-radius:0.5rem; background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;}
	
    #<?php echo $module['module_name'];?>_html .msg_div .answer_div .answer textarea{ width:100%; height:100px;}
    #<?php echo $module['module_name'];?>_html .msg_state{ height:13px;}
	
	
    #<?php echo $module['module_name'];?>_html .msg_div .answer_div{ display:block;}
	
	
    #<?php echo $module['module_name'];?>_html .msg_div .answer textarea{width:98%;}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info{ text-align:right;}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info span{ display:inline-block; margin-right:20px; }
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info .answer_user{}
    #<?php echo $module['module_name'];?>_html .msg_div .answer_info .time{}
    #<?php echo $module['module_name'];?>_html .msg_div .operation_div{ text-align:right;}
    #<?php echo $module['module_name'];?>_html .msg_div .operation_div span{ display:inline-block;}
    #<?php echo $module['module_name'];?>_html .msg_div .operation_div .sequence{width:60px;}
    #<?php echo $module['module_name'];?>_html .msg_div .operation_div .msg_state{}
    #<?php echo $module['module_name'];?>_html #feedback_state{  display:inline-block; }
    #<?php echo $module['module_name'];?>_html #feedback_state a{  line-height:2rem; display:inline-block; padding-left:0.5rem; padding-right:0.5rem; margin-right:1rem; text-align:center; }
    #<?php echo $module['module_name'];?>_html #feedback_state .current{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1 >
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['title']?>/<?php echo self::$language['content']?>" class="form-control" ></m_label></div></div></div>
    
    <div class="filter"><?php echo self::$language['state']?>:
        <div id=feedback_state>
       		<a href=./index.php?monxin=feedback.admin ><?php echo self::$language['unlimited'];?></a>
       		<a href=./index.php?monxin=feedback.admin&state=0 id=0><?php echo self::$language['feedback_state'][0];?></a>
       		<a href=./index.php?monxin=feedback.admin&state=1 id=1><?php echo self::$language['feedback_state'][1];?></a>
       		<a href=./index.php?monxin=feedback.admin&state=2 id=2><?php echo self::$language['feedback_state'][2];?></a>
       		<a href=./index.php?monxin=feedback.admin&state=3 id=3><?php echo self::$language['feedback_state'][3];?></a>
        </div>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding=0 cellspacing=0>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
