<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
            if($(this).attr('monxin_value')!=''){$(this).prop('value',$(this).attr('monxin_value'));}
        });
		$(".data_source_type").change(function(){
			id=$(this).parent().parent().attr('id');
			//alert($("#"+id+" #data_source_type_"+$(this).val()).html());
			$("#"+id+" .data_source_type_option_div").css('display','none');
			$("#"+id+" #data_source_type_"+$(this).val()).css('display','block');	
		});
		$(".data_source_type").each(function(index, element) {
			id=$(this).parent().parent().attr('id');
			$("#"+id+" #data_source_type_"+$(this).val()).css('display','block');	
		});
		$(".data_type").change(function(){
			id=$(this).parent().parent().attr('id');
			//alert($("#"+id+" #data_type_"+$(this).val()).html());
			$("#"+id+" .data_type_option_div").css('display','none');
			$("#"+id+" #data_type_"+$(this).val()).css('display','block');	
		});
		
		$(".data_type").each(function(index, element) {
			id=$(this).parent().parent().attr('id');
			//alert($("#"+id+" #data_type_"+$(this).val()).html());
			$("#"+id+" #data_type_"+$(this).val()).css('display','block');	
        });
		$("#<?php echo $module['module_name'];?> .auto_update").each(function(index, element) {
            if($(this).prop('value')==1){$(this).prop('checked',true);}
        });
    });
    


    function update(id){
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
		if($("#"+id+" #auto_update").prop('checked')){$("#"+id+" #auto_update").val('1');}else{$("#"+id+" #auto_update").val('0');}
        $.post('<?php echo $module['action_url'];?>&act=update',{
			tr_id:id,
			default_value:$("#"+id+" #default_value").val(),
			auto_update:$("#"+id+" #auto_update").val(),
			replace_to:$("#"+id+" #replace_to").val(),
			data_source_type:$("#"+id+" #data_source_type").val(),
			data_source_2:$("#"+id+" #data_source_2").val(),
			data_source_3:$("#"+id+" #data_source_3").val(),
			data_source_4:$("#"+id+" #data_source_4").val(),
			extract_reg:$("#"+id+" #extract_reg").val(),
			data_type:$("#"+id+" #data_type").val(),
			data_type_img_save_path:$("#"+id+" #data_type_img_save_path").val(),
			data_type_img_imageMark:$("#"+id+" #data_type_img_imageMark").val(),
			data_type_img_thumb_save_path:$("#"+id+" #data_type_img_thumb_save_path").val(),
			data_type_img_thumb_width:$("#"+id+" #data_type_img_thumb_width").val(),
			data_type_img_thumb_height:$("#"+id+" #data_type_img_thumb_height").val(),
			data_type_file_save_path:$("#"+id+" #data_type_file_save_path").val(),
			allow_html:$("#"+id+" #allow_html").val(),
			html_img_save_path:$("#"+id+" #html_img_save_path").val(),
			html_img_watermark:$("#"+id+" #html_img_watermark").val(),
			}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#state_"+id).html(v.info);
        });
         return false;	
        
    }
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>_table .field_info{ display:inline-block; text-align:left; width:100%;}
	#<?php echo $module['module_name'];?> .default_value{ width:40px;}
	#<?php echo $module['module_name'];?> .data_source_type_option_div{ display:none;}
	#<?php echo $module['module_name'];?> .data_source_type_option_div div{ width:100px;}
	#<?php echo $module['module_name'];?> .data_type_option_div{ display:none; background-image:url(<?php echo get_template_dir(__FILE__);?>img/data_type_option_div_bg.png); border:1px solid #b2e7ff;}
	#<?php echo $module['module_name'];?> .data_type_option_div select{}
	#<?php echo $module['module_name'];?> .data_type_option_div input{width:100px;}
	.data_type_td div{ text-align:left;}
	.data_source_type_td div{ text-align:left;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><span class=field_info><?php echo self::$language['field_info']?></span></td>
                <td ><?php echo self::$language['default_value']?></td>
                <td ><?php echo self::$language['auto_update']?></td>
                <td ><?php echo self::$language['replace']?></td>
                <td ><?php echo self::$language['data_source_type']?></td>
                <td ><?php echo self::$language['extract_reg']?></td>
                <td ><?php echo self::$language['data_type']?></td>
                <td  style=" width:80px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
