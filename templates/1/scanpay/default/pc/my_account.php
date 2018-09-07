<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
		$("#<?php echo $module['module_name'];?>_html .data_state").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
				
    });    
    function update(id){
		$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.post('<?php echo $module['action_url'];?>&act=update',{id:id,sequence:$("#tr_"+id+" .sequence").val()}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#state_"+id).html(v.info);
		});
        return false;	
        
    }
    
    function del(id){
        if(confirm("<?php echo self::$language['del_account_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.post('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
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
    #<?php echo $module['module_name'];?>{ font-size:12px;	}
    #<?php echo $module['module_name'];?> .sequence{width:3rem;  text-align:center;}
	#<?php echo $module['module_name'];?> .banner_div img{ height:7rem;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    <div class="filter" style=" text-align:right;">
        <a href="index.php?monxin=<?php echo $module['class_name'];?>.account_add" class="add"><?php echo self::$language['add']?><?php echo self::$language['scanpay_account']?></a>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['name']?></td>
                <td ><?php echo self::$language['type']?></td>
                <td ><?php echo self::$language['cumulative']?><?php echo self::$language['receive_money']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><?php echo self::$language['sequence']?></td>
                <td ><?php echo self::$language['state']?></td>
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
