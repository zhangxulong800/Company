<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){

    });
    
    function add(){
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");	
        first_weightNew=$("#<?php echo $module['module_name'];?> #first_weight_new");	
        over_weightNew=$("#<?php echo $module['module_name'];?> #over_weight_new");	
        first_priceNew=$("#<?php echo $module['module_name'];?> #first_price_new");	
        over_priceNew=$("#<?php echo $module['module_name'];?> #over_price_new");	
        sequenceNew=$("#<?php echo $module['module_name'];?> #sequence_new");
        if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['express_name']?>');nameNew.focus();return false;}	
        if(first_weightNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['first_weight']?>');first_weightNew.focus();return false;}	
        if(first_priceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['first_price']?>');first_priceNew.focus();return false;}	
        if(over_weightNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['over_weight']?>');over_weightNew.focus();return false;}	
        if(over_priceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['continue_price']?>');over_priceNew.focus();return false;}	
        if(sequenceNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequenceNew.focus();return false;}	
        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),first_weight:first_weightNew.prop('value'),first_price:first_priceNew.prop('value'),over_weight:over_weightNew.prop('value'),over_price:over_priceNew.prop('value'),sequence:sequenceNew.prop('value'),url:$("#<?php echo $module['module_name'];?> #url_new").prop('value')}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
			if(v.state=='success'){$("#<?php echo $module['module_name'];?> #state_new").html(v.info+'<a href="javascript:window.location.reload();" class=refresh><?php echo self::$language['refresh']?></a>');}
        });
        	
        return false;
    }
    
    
    function update(id){
        var name=$("#<?php echo $module['module_name'];?> #name_"+id);	
        var first_weight=$("#<?php echo $module['module_name'];?> #first_weight_"+id);	
        var first_price=$("#<?php echo $module['module_name'];?> #first_price_"+id);	
        var over_weight=$("#<?php echo $module['module_name'];?> #over_weight_"+id);	
        var over_price=$("#<?php echo $module['module_name'];?> #over_price_"+id);	
        var sequence=$("#<?php echo $module['module_name'];?> #sequence_"+id);	
        if(name.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['express_name']?>');name.focus();return false;}	
        if(sequence.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),first_weight:first_weight.prop('value'),over_weight:over_weight.prop('value'),first_price:first_price.prop('value'),over_price:over_price.prop('value'),sequence:sequence.prop('value'),url:$("#<?php echo $module['module_name'];?> #url_"+id).val(),id:id}, function(data){
           //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
        });
        	
       return false; 
    }
    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
                            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        	
       return false; 
    }
    </script>
    <style>
    #<?php echo $module['module_name'];?>_html input{width:110px;}
    #<?php echo $module['module_name'];?>_html .sequence{width:50px;}
	
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
        <div class="portlet-title">
            <div class="caption"><?php echo $module['monxin_table_name']?></div>
   	    </div>

    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0">
         <thead>
            <tr>
                <td><?php echo self::$language['express_name']?></td>
                <td><?php echo self::$language['first_weight']?></td>
                <td><?php echo self::$language['first_price']?></td>
                <td><?php echo self::$language['over_weight']?></td>
                <td><?php echo self::$language['continue_price']?></td>
                <td><?php echo self::$language['query_url']?></td>
                <td><?php echo self::$language['sequence']?></td>
                <td width="30%"  style="text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
            <tr id="<?php echo $module['module_name'];?>_new">
              <td ><input type="text" name="name_new" id="name_new" class='name' /></td>
              <td ><input type="text" name="first_weight_new" id="first_weight_new" class='first_weight' /></td>
              <td ><input type="text" name="first_price_new" id="first_price_new" class='first_price' /></td>
              <td ><input type="text" name="over_weight_new" id="over_weight_new" class='over_weight' /></td>
              <td ><input type="text" name="over_price_new" id="over_price_new" class='over_price' /></td>
              <td><input type="text" name="url_new" id="url_new" value="0" class='url' /></td>
              <td><input type="text" name="sequence_new" id="sequence_new" class='sequence' /></td>
              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
        </tbody>
    </table></div>
    </div>

</div>
