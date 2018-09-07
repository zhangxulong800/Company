<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$('#diy_qr_icon_ele').insertBefore($('#diy_qr_icon_state'));
		
			
		$("#<?php echo $module['module_name'];?>_html .url").click(function(){
			$('#myModal .qr_img').attr('src',"./plugin/qrcode/index.php?text="+$(this).html()+"&logo=1&logo_path=../../program/weixin/diy_qr_icon/<?php echo $_GET['wid']?>.png");
			$('#myModal .name').html($("#<?php echo $module['module_name'];?>_html #"+$(this).parent().parent().attr('id')+" .name").html());
			$('#myModal .key').html($("#<?php echo $module['module_name'];?>_html #"+$(this).parent().parent().attr('id')+" .key").html());
			$('#myModal').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			return false;	
		});
			
    });
    function add(){
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        keyNew=$("#<?php echo $module['module_name'];?> #key_new");	
        typeNew=$("#<?php echo $module['module_name'];?> #type_new");
        if($("#<?php echo $module['module_name'];?> #auto_answer_new").prop('checked')){auto_answer=1;}else{auto_answer=0;}
    
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');nameNew.focus();return false;}	
        if(keyNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #key_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['parameter']?>');keyNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),key:keyNew.prop('value'),type:typeNew.prop('value'),auto_answer:auto_answer}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
    
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
	
	
    function submit_hidden(id){
        //monxin_alert(id);
        obj=document.getElementById(id);
		//monxin_alert(obj.value);
        if(obj.value==''){}
        json="{'"+obj.id+"':'"+replace_quot(obj.value)+"'}";
        try{json=eval("("+json+")");}catch(exception){alert(json);}
        $("#"+obj.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
        $("#"+obj.id+"_state").load('<?php echo $module['action_url'];?>&act=icon',json,function(){
            if($(this).html().length>10){
               //alert($(this).html());
                try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
                $(this).html(v.info);
               	if(v.state=='success'){$("#diy_qr_icon_img").attr('src',$("#diy_qr_icon_img").attr('src')+'?&=re'+Math.random());}
                
            }
        });
        
    }
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>_table .type{width:100px;}
    #<?php echo $module['module_name'];?>_table .title{width:280px;}
    #<?php echo $module['module_name'];?>_table .editor{width:100px;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?>_table .sequence{width:40px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
        	<?php echo self::$language['qr_icon']?> <img id=diy_qr_icon_img src='./program/weixin/diy_qr_icon/<?php echo $_GET['wid']?>.png' /> <span id="diy_qr_icon_state" /></span>
            <span id=state_select></span>
            <div class="btn-group">
                <a class="btn" href="javascript:;" data-toggle="dropdown"><i class="fa fa-check-circle"></i><?php echo self::$language['operation']?><?php echo self::$language['selected']?><i class="fa fa-angle-down"></i></a>
                <ul class="dropdown-menu">
                    <li><a href="#" class="del" onclick="return del_select();"><?php echo self::$language['del']?></a></li> 
                </ul>
            </div>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['name']?>/<?php echo self::$language['parameter']?>" value="<?php echo @$_GET['search']?>" class="form-control" ></m_label></div></div></div>
    

    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['parameter']?></td>
                <td ><?php echo self::$language['validity_period']?></td>
                <td ><?php echo self::$language['auto_answer']?></td>
                <td ><?php echo self::$language['qr_code']?><?php echo self::$language['url']?></td>
                <td ><?php echo self::$language['time']?></td>
                <td  style=" width:240px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <tr id="<?php echo $module['module_name'];?>_new">
                <td id="new_td_first"></td>
                <td ><input type="text" name="name_new" id="name_new" class='name' style="width:97%;" /></td>
                <td ><input type="text" name="key_new" id="key_new" class='key'/></td>
              <td><select  name='type_new' id='type_new'  value=0><?php echo $module['period_option']?></select></td>
              <td><input type='checkbox' name='auto_answer_new' id='auto_answer_new' /></td>
              <td id="new_td_last" style="text-align:left;"  colspan="3" ><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    
    
        <!-- 模态框（Modal） -->
<div class="qr_modal modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               <b><?php echo self::$language['weixin'];?><?php echo self::$language['diy_qr'];?></b>
            </h4>
         </div>
         <div class="modal-body" style="text-align:center;">
             <img class="qr_img" src= />
             <div class=name  style="font-weight:bold;"></div>
             <div class=key></div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal"><?php echo self::$language['close']?>
            </button>
            
         </div>
      </div>
</div>
        
    
    
    
    </div>
</div>
