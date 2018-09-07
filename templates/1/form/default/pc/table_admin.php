<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .write_state").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .read_state").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .default_publish").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .authcode").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .weixin_inform").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .email_inform").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		
		if(get_param('id')!=''){$("[monxin-table] .filter").css('display','none');}
		
		$("#<?php echo $module['module_name'];?> .url_qr").click(function(){
			$("#<?php echo $module['module_name'];?> .url_qr_img").attr('src',$("#<?php echo $module['module_name'];?> .url_qr_img").attr('t')+$(this).attr('d_id'));
			$("#<?php echo $module['module_name'];?> .url_a").html($("#<?php echo $module['module_name'];?> .url_a").attr('t')+$(this).attr('d_id'));
			$("#<?php echo $module['module_name'];?> .url_a").attr('href',$("#<?php echo $module['module_name'];?> .url_a").attr('t')+$(this).attr('d_id'));
			
			
			$('#myModal').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/5);	
			return flase;	 		
		});
				
		
    });
    
    function update(id){
        var j_name=$("#name_"+id);
        var j_description=$("#description_"+id);
		if(j_description.val()==''){$("#state_"+id).html('<span class=fail><?php echo self::$language['please_input'];?></span>');j_description.focus(); return false;}
		if(j_name.val()==''){$("#state_"+id).html('<span class=fail><?php echo self::$language['please_input'];?></span>');j_name.focus(); return false;}			
		if(!is_passwd(j_name.val()) ){
			$("#state_"+id).html('<span class=fail><?php echo self::$language['table_name'];?><?php echo self::$language['only_letters_numbers_underscores'];?></span>');j_name.focus(); return false;
		}
		write_state=($("#write_state_"+id).prop('checked'))?1:0;
		read_state=($("#read_state_"+id).prop('checked'))?1:0;
		default_publish=($("#default_publish_"+id).prop('checked'))?1:0;
		authcode=($("#authcode_"+id).prop('checked'))?1:0;
		weixin_inform=($("#weixin_inform_"+id).prop('checked'))?1:0;
		email_inform=($("#email_inform_"+id).prop('checked'))?1:0;
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{description:j_description.val(), name: j_name.val(),inform_user: $("#inform_user_"+id).val(),pay_money: $("#pay_money_"+id).val(),write_state:write_state,read_state:read_state,default_publish:default_publish,authcode:authcode,weixin_inform:weixin_inform,email_inform:email_inform,id:id}, function(data){
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
    #<?php echo $module['module_name'];?>_html a:hover{ }
	#<?php echo $module['module_name'];?>_html .m_label{ }
    #<?php echo $module['module_name'];?> .edit_none{ font-size:18px;}
	#<?php echo $module['module_name'];?> .weixin_inform{ height:13px;}
	#<?php echo $module['module_name'];?> .email_inform{ height:13px;}
    #<?php echo $module['module_name'];?> .inform_user{ width:150px; display:block;}
	#<?php echo $module['module_name'];?> .operation_td{ white-space:normal;}
	#<?php echo $module['module_name'];?> .operation_td br{ display:none;}
	#<?php echo $module['module_name'];?> .operation_td a{ display:inline-block; width:100px; overflow:hidden; text-align:center; line-height:20px;height:20px; padding:0px; margin:0px; font-size:14px;}
	
	#<?php echo $module['module_name'];?> #myModalLabel{ text-align:center;}
	#<?php echo $module['module_name'];?> .modal-body{ text-align:center;}
	#<?php echo $module['module_name'];?> .modal-body{ text-align:center;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    <div class="filter"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['name']?>/<?php echo self::$language['table_name']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> &nbsp; <a href="./index.php?monxin=form.table_add"  class="add"><?php echo self::$language['add']?><?php echo self::$language['form']?></a>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['name']?>/<?php echo self::$language['table_name']?></td>
                <td ><?php echo self::$language['write_able']?></td>
                <td ><?php echo self::$language['read_able']?></td>
                <td ><?php echo self::$language['default']?><?php echo self::$language['publish']?></td>
                <td ><?php echo self::$language['authcode']?></td>
                <td ><?php echo self::$language['input_inform']?></td>
                <td  style=" width:250px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    
    
        
        <!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               <b><?php echo self::$language['add_new']?><?php echo self::$language['url_qr'];?></b>
            </h4>
         </div>
         <div class="modal-body">
             <img src="" t="./plugin/qrcode/index.php?text=<?php echo $module['url_qr_pre'];?>" class=url_qr_img />
             <br /><a class="url_a" href="" t="<?php echo $module['url_pre'];?>"></a>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" 
               data-dismiss="modal"><?php echo self::$language['close']?>
            </button>
            
         </div>
      </div>
</div></div>
        
    
    
    </div>
</div>
