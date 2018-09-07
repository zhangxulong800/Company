<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .set_receiver_info").click(function(){
			$('#myModal').modal({  
			   backdrop:true,  
			   keyboard:true,  
			   show:true  
			});  
			$("#myModal").css('margin-top',($(window).height()-$("#myModal .modal-content").height())/3);
			$(".modal-body .receiver_div .prize_name").attr('new_id',$(this).attr('href'));	
			return false;	
		});
			
			
		$("#<?php echo $module['module_name'];?>_html .receiver_div .submit").click(function(){
			$("#<?php echo $module['module_name'];?>_html .receiver_div input").removeClass('err_input');
			$("#<?php echo $module['module_name'];?>_html .receiver_div .submit").next().html('');
			is_null=false;
			$("#<?php echo $module['module_name'];?>_html .receiver_div input").each(function(index, element) {
                if($(this).val()==''){
					$(this).addClass('err_input');
					$(this).focus();
					is_null=true;
					return false;	
				}
				
            });
			if(is_null){
				$("#<?php echo $module['module_name'];?>_html .receiver_div .submit").next().html('<span class=fail><?php echo self::$language['is_null']?></span>');
				return false;	
			}
			if(!$(".modal-body .receiver_div .prize_name").attr('new_id')){
				$("#<?php echo $module['module_name'];?>_html .receiver_div .submit").next().html('<span class=fail>new_id <?php echo self::$language['is_null']?></span>');
				return false;	
			}
			if(!$("#<?php echo $module['module_name'];?>_html .receiver_div .phone").val().match(<?php echo $module['phone_reg'];?>)){
				alert('<?php echo self::$language['phone'];?><?php echo self::$language['pattern_err'];?>');
				$("#<?php echo $module['module_name'];?>_html .receiver_div .phone").addClass('err_input');
				return false;	
			}
			
			
			$("#<?php echo $module['module_name'];?>_html .receiver_div .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add_receiver',{id:$(".modal-body .receiver_div .prize_name").attr('new_id'),name:$("#<?php echo $module['module_name'];?>_html .receiver_div .name").val(),phone:$("#<?php echo $module['module_name'];?>_html .receiver_div .phone").val(),address:$("#<?php echo $module['module_name'];?>_html .receiver_div .address").val()}, function(data){
			   
			   try{v=eval("("+data+")");}catch(exception){alert(data);}
			   $("#<?php echo $module['module_name'];?>_html .receiver_div .submit").next().html(v.info);
			   if(v.state=='success'){
				   $("#<?php echo $module['module_name'];?>_html .receiver_div .submit").css('display','none');
				   $("#<?php echo $module['module_name'];?>_html a[href='"+$(".modal-body .receiver_div .prize_name").attr('new_id')+"']").parent().html($("#<?php echo $module['module_name'];?>_html .receiver_div .name").val()+','+$("#<?php echo $module['module_name'];?>_html .receiver_div .phone").val()+','+$("#<?php echo $module['module_name'];?>_html .receiver_div .address").val());
				}
				 
			});
			
			return false;	
		});
		
				
    });    
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> .add_div{ text-align:right;}
	#<?php echo $module['module_name'];?> .qr{ display:inline-block; vertical-align:top; width:100px;}
	#<?php echo $module['module_name'];?> .name_url{ display:inline-block; vertical-align:top; width:220px; white-space: normal; line-height:20px; padding-left:5px;}
	
	.receiver_div{ display:inline-block;  margin:auto; width:200px; text-align:left; line-height:40px;}
	.err_input{ border-color:red !important;}
	
	
    </style>
    
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label></m_label></div></div></div>
    

    
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['qr_code']?>/<?php echo self::$language['name']?>/<?php echo self::$language['link']?></td>
                <td ><?php echo self::$language['prize']?><?php echo self::$language['type']?></td>
                <td ><?php echo self::$language['prize_name']?></td>
                <td ><?php echo self::$language['remark']?></td>
                <td ><?php echo self::$language['prize_time']?></td>
                <td ><?php echo self::$language['state']?></td>
                <td ><?php echo self::$language['cash_time']?></td>
                <td ><?php echo self::$language['operator']?></td>

            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal" aria-hidden="true">
                      &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                   <b><?php echo self::$language['set'];?><?php echo self::$language['receiver_info'];?></b>
                </h4>
             </div>
             <div class="modal-body">
                 <div class=prize_type_1 >
                 	<span class=receiver_div>
                    	<span class=prize_name></span>
                        <p><input type="text" class=name placeholder="<?php echo self::$language['receiver'];?>" /></p>
                        <p><input type="text" class=phone placeholder="<?php echo self::$language['phone'];?>" /></p>
                        <p><input type="text" class=address placeholder="<?php echo self::$language['address'];?>" /></p>
                        <p><a href=# class=submit><?php echo self::$language['submit'];?></a> <span class=state></span></p>
                    </span>
                 </div>
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
</div>
