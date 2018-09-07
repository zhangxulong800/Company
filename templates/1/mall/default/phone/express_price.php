<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .batch_write").click(function(){
			var id=$(this).parent().parent().attr('id');
			f_price=$("#<?php echo $module['module_name'];?> #"+id+" .first_price").val()
			c_price=$("#<?php echo $module['module_name'];?> #"+id+" .continue_price").val()
			if( !$.isNumeric(f_price) || !$.isNumeric(c_price) ){
				$("#<?php echo $module['module_name'];?> #"+id+" .state").html('<?php echo self::$language['please_input']?>');return false;
			}else{
				start=false;
				$("#<?php echo $module['module_name'];?> tr").each(function(index, element) {
					id2=$(this).attr('id');
                    if(id2==id){start=true;}
					if(start==true){
						if($("#<?php echo $module['module_name'];?> #"+id2+" .first_price").val()==''){
							$("#<?php echo $module['module_name'];?> #"+id2+" .first_price").val(f_price);
						}	
						if($("#<?php echo $module['module_name'];?> #"+id2+" .continue_price").val()==''){
							$("#<?php echo $module['module_name'];?> #"+id2+" .continue_price").val(c_price);
						}	
					}
                });
			}
			return false;	
		});
    });    
    
    function update(id){
        var first_price=$("#<?php echo $module['module_name'];?> #first_price_"+id);	
        var continue_price=$("#<?php echo $module['module_name'];?> #continue_price_"+id);	
        if(first_price.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['first_price']?>');first_price.focus();return false;}	
        if(continue_price.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['continue_price']?>');continue_price.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{first_price:first_price.prop('value'),continue_price:continue_price.prop('value'),id:<?php echo @$_GET['id'];?>,area_id:id}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        	
       return false; 
    }
    </script>
    <style>
	.fixed_right_div,.page-footer,#mall_cart{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
    #<?php echo $module['module_name'];?> {}
    #<?php echo $module['module_name'];?>_html .name{width:150px;}
    #<?php echo $module['module_name'];?>_html input{width:150px;}
    #<?php echo $module['module_name'];?>_html .sequence{width:50px;}
	#<?php echo $module['module_name'];?>_html .batch_write{ display:none;}
	#<?php echo $module['module_name'];?>_html tr:hover .batch_write{ display: inline-block;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><?php echo $module['express_name']?></td>
                <td><?php echo self::$language['first_price']?><?php echo $module['first_weight']?>,<?php echo $module['first_price']?></td>
                <td><?php echo self::$language['continue_price']?><?php echo $module['over_weight']?>,<?php echo $module['over_price']?></td>
                <td width="20%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    </div>

</div>
