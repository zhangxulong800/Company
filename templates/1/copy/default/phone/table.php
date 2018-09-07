<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
            if($(this).attr('monxin_value')!=''){$(this).prop('value',$(this).attr('monxin_value'));}
        });
    });
    


    function update(id){
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		
        $.post('<?php echo $module['action_url'];?>&act=update',{
			tr_id:id,
			multiple:$("#"+id+" #multiple").val(),
			reg:$("#"+id+" #reg").val(),
			}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#state_"+id).html(v.info);
        });
         return false;	
        
    }
    
    </script>
	<style>
	#<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> textarea{ width:10rem; height:100px;margin-top:10px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['table']?></td>
                <td ><?php echo self::$language['quantity']?></td>
                <td ><?php echo self::$language['single_reg']?></td>
                <td  style=" width:280px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>
</div>
