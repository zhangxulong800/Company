<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$('#import_file_ele').insertBefore($('#import_file_state'));
		
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
		
		
		
		$("#<?php echo $module['module_name'];?> .import").click(function(){
			if($("#<?php echo $module['module_name'];?> .import_div").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> .import_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> .import_div").css('display','none');
			}
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .submit").next('span').html('');
			if($("#<?php echo $module['module_name'];?> #import_file").val()==''){
					$("#<?php echo $module['module_name'];?> .submit").next('span').html('<span class=fail><?php echo self::$language['please_upload']?></span>');	
					return false;
			}
			$("#<?php echo $module['module_name'];?> .submit").css('display','none');
			$("#<?php echo $module['module_name'];?> .submit").next('span').html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['executing']?>');
			$.post("<?php echo $module['action_url'];?>&act=import",{import_file:$("#<?php echo $module['module_name'];?> #import_file").val()},function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .submit").next('span').html(v.info);
				$("#<?php echo $module['module_name'];?> .submit").next('span').css('display','block').width('100%');
				if(v.state=='fail'){
					$("#<?php echo $module['module_name'];?> .submit").css('display','inline-block');
					
				}else{
					$("#<?php echo $module['module_name'];?> .submit").next('span').html(v.info);
				}
			});	
			
			return false;	
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
        
		
		
		$(".g_w_price,.g_e_price").click(function(){
			if($(this).parent().children('.more_set').css('display')=='none'){
				$(this).parent().children('.more_set').css('display','block');
			}else{
				$(this).parent().children('.more_set').css('display','none');
			}
			return false;
		});
		$(".g_discount_rate .show_more").click(function(){
			if($(this).parent().parent().children('.more_set').css('display')=='none'){
				$(this).parent().parent().children('.more_set').css('display','block');
			}else{
				$(this).parent().parent().children('.more_set').css('display','none');
			}
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .discount_div .discount").change(function(){
			if(parseFloat($(this).val())>10){$(this).val(10);}
			v=$(this).val()*$(this).parent().attr('price')/10;
			v=v.toFixed(2);
			$(this).parent().children('.discount_money').val(v);
			update_discount($(this).parent().attr('goods_id'),$(this).parent().attr('group_id'),$(this).val());
		});
		
		$("#<?php echo $module['module_name'];?> .discount_div .discount_money").change(function(){
			if(parseFloat($(this).val())>parseFloat($(this).parent().attr('price'))){$(this).val($(this).parent().attr('price'));}
			v=$(this).val() / $(this).parent().attr('price');
			$(this).parent().children('.discount').val(v*10);
			update_discount($(this).parent().attr('goods_id'),$(this).parent().attr('group_id'),$(this).parent().children('.discount').val());
		});
		
		$("#<?php echo $module['module_name'];?> .price_div input").change(function(){
			update_goods_s($(this).parent().parent().attr('id'));
		});
		
		$("#<?php echo $module['module_name'];?> .g_e_price input").change(function(){
			update_goods($(this).parent().parent().attr('id'));
		});
		
		$("#<?php echo $module['module_name'];?> .g_w_price input").change(function(){
			update_goods($(this).parent().parent().attr('id'));
		});
		
		$("#<?php echo $module['module_name'];?> .batch_write").click(function(){
			id=$(this).parent().parent().parent().parent().attr('id');
			w_price=$(this).prev().val();
			e_price=$(this).parent().prev().children('.e_price').val();
			//alert(w_price+','+e_price);
			si=0;
			$("#<?php echo $module['module_name'];?> #"+id+" .price_div .s_price").each(function(index, element) {
                sid=$(this).attr('id');
				$("#<?php echo $module['module_name'];?> #"+sid+" .e_price").val(e_price);
				$("#<?php echo $module['module_name'];?> #"+sid+" .w_price").val(w_price);
				if(si!=0){update_goods_s(sid);}
				si++;
            });
			
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .where_div .submit").click(function(){
			$("#<?php echo $module['module_name'];?> .where_div .submit").next('.state').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			if($("#<?php echo $module['module_name'];?> .min_price").val()==''){
				$("#<?php echo $module['module_name'];?> .where_div .submit").next('.state').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['min_price']?></span>');
				return false;
			}
			if($("#<?php echo $module['module_name'];?> .max_price").val()==''){
				$("#<?php echo $module['module_name'];?> .where_div .submit").next('.state').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['max_price']?></span>');
				return false;
			}
			if($("#<?php echo $module['module_name'];?> .new_price").val()==''){
				$("#<?php echo $module['module_name'];?> .where_div .submit").next('.state').html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['price']?></span>');
				return false;
			}
			
			$.post("<?php echo $module['action_url'];?>&act=batch_reset",{min_price:$("#<?php echo $module['module_name'];?> .min_price").val(),max_price:$("#<?php echo $module['module_name'];?> .max_price").val(),new_price:$("#<?php echo $module['module_name'];?> .new_price").val(),type:$("#<?php echo $module['module_name'];?> #type_p").val(),tag:$("#<?php echo $module['module_name'];?> #tag_p").val(),position:$("#<?php echo $module['module_name'];?> #position_p").val(),supplier:$("#<?php echo $module['module_name'];?> #supplier_p").val()},function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				if(v.state=='fail'){
					$("#<?php echo $module['module_name'];?> .where_div .submit").next('.state').html(v.info);
				}else{
					monxin_alert(v.info+':'+v.success);
					window.location.reload();
				}
			});	
	
			return false;
		});
		
    });
	
	function update_discount(goods_id,group_id,v){
		$.post("<?php echo $module['action_url'];?>&act=update_discount",{goods_id:goods_id,group_id:group_id,discount:v},function(data){
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			if(v.state=='fail'){
				$("#<?php echo $module['module_name'];?> .discount_div div[gg='"+group_id+'_'+goods_id+"'] input").addClass('fail_input');
			}else{
				$("#<?php echo $module['module_name'];?> .discount_div div[gg='"+group_id+'_'+goods_id+"'] input").addClass('success_input');
			}
		});	
	}
    
	
	function update_goods_s(s_id){
		e_price=$("#<?php echo $module['module_name'];?> #"+s_id+" .e_price").val();
		w_price=$("#<?php echo $module['module_name'];?> #"+s_id+" .w_price").val();
		if(e_price==''){$("#<?php echo $module['module_name'];?> #"+s_id+" .e_price").addClass('fail_input');return false;}
		if(w_price==''){$("#<?php echo $module['module_name'];?> #"+s_id+" .w_price").addClass('fail_input');return false;}
		$.post("<?php echo $module['action_url'];?>&act=update_goods_s",{s_id:s_id,e_price:e_price,w_price:w_price},function(data){
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			if(v.state=='fail'){
				$("#<?php echo $module['module_name'];?> #"+s_id+" input").addClass('fail_input');
			}else{
				$("#<?php echo $module['module_name'];?> #"+s_id+" input").addClass('success_input');
			}
		});	
	}
    
	
	function update_goods(id){
		e_price=$("#<?php echo $module['module_name'];?> #"+id+" >span > .e_price").val();
		w_price=$("#<?php echo $module['module_name'];?> #"+id+" >span > .w_price").val();
		if(e_price==''){$("#<?php echo $module['module_name'];?> #"+id+" >span > .e_price").addClass('fail_input');return false;}
		if(w_price==''){$("#<?php echo $module['module_name'];?> #"+id+" >span > .w_price").addClass('fail_input');return false;}
		$.post("<?php echo $module['action_url'];?>&act=update_goods",{id:id,e_price:e_price,w_price:w_price},function(data){
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			if(v.state=='fail'){
				$("#<?php echo $module['module_name'];?> #"+id+" >span > input").addClass('fail_input');
			}else{
				$("#<?php echo $module['module_name'];?> #"+id+" >span > input").addClass('success_input');
			}
		});	
	}
    
    
    </script>
    <style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .goods_in_out_notice{ text-align:center; line-height:3rem;  opacity:0.5;}
	#<?php echo $module['module_name'];?>_html .act_select{ line-height:5rem; text-align:center;}
	#<?php echo $module['module_name'];?>_html .act_select a{ display:inline-block; line-height:4rem; padding-left:2rem; padding-right:2rem;}
	#<?php echo $module['module_name'];?>_html .act_select .import{ margin-left:3rem; }
	
	#<?php echo $module['module_name'];?>_html .import_div{ display:none; line-height:3rem;}
	
	#<?php echo $module['module_name'];?>_html .list .thead{ background-color: rgba(233,233,233,1.00); line-height:2.5rem;}
	#<?php echo $module['module_name'];?>_html .list .g{ line-height:2rem; border-bottom:1px dashed #ccc; padding-top:5px; padding-bottom:5px;}
	#<?php echo $module['module_name'];?>_html .list .g:hover{ background:rgba(237,235,235,1.00);}
	#<?php echo $module['module_name'];?>_html .list .g >span{ display:inline-block; vertical-align:top; white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .list .g .g_title{ width:37%; margin-right:20px; overflow:hidden; text-overflow:ellipsis;  text-indent:5px;}
	#<?php echo $module['module_name'];?>_html .list .g .g_cprice{ width:9%; overflow:hidden; text-overflow:ellipsis;}
	#<?php echo $module['module_name'];?>_html .list .g .g_w_price{ width:9%; overflow:hidden; text-overflow:ellipsis; cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .list .g .g_e_price{ width:9%; overflow:hidden; text-overflow:ellipsis; cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .list .g .g_discount_rate{ width:16%; overflow:hidden; text-overflow:ellipsis;}
	#<?php echo $module['module_name'];?>_html .list .g .qi{ font-size:0.9rem; color:#ccc; padding-left:3px; display:none;}
	#<?php echo $module['module_name'];?>_html .list .g input{ width:4rem; line-height:1.5rem; height:1.5rem;}
	#<?php echo $module['module_name'];?>_html .list .g .more_set{ display:none;}
	#<?php echo $module['module_name'];?>_html .list .g .more_set .price_div{ display:inline-block; vertical-align:top; overflow:hidden; text-align:right; width:66%;}
	#<?php echo $module['module_name'];?>_html .list .g .more_set .price_div .s_price >span{ display:inline-block; vertical-align:top; overflow:hidden; text-align:left; width:13.7%; border-top:1px dashed #DFDADA; font-size:0.8rem; opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .list .g .more_set .price_div .s_price .name{ width:30%; text-align:right; padding-right:5px;}
	#<?php echo $module['module_name'];?>_html .list .g .more_set .price_div .batch_write{ display:inline-block; width:20px; text-align:center; cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .list .g .more_set .price_div .batch_write:hover{ color:red;}
	
	
	#<?php echo $module['module_name'];?>_html .list .g .more_set .discount_div{ display:inline-block; vertical-align:top; overflow:hidden; width:34%; border-left:1px dashed #ccc; padding-left:10px;font-size:0.8rem; opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .list .g .show_more:before {font: normal normal normal 14px/1 FontAwesome;margin-left:2px;content:"\f103"; cursor:pointer;}
	
	#<?php echo $module['module_name'];?>_html .success_input{ background:rgba(24,233,106,1.00);}
	#<?php echo $module['module_name'];?>_html .fail_input{ background:rgba(239,76,79,1.00);}
	
	#<?php echo $module['module_name'];?> .where_div{}
	#<?php echo $module['module_name'];?> .where_div input{ width:5rem;}
	#<?php echo $module['module_name'];?> .where_div .submit{ margin-left:5px; cursor:pointer;} 
    </style>
    <div id="<?php echo $module['module_name'];?>_html" monxin-table='1'>
    	<div class=odl_div style="display:none;">
            <div class=act_select>
            <a href=<?php echo $module['action_url'];?>&act=export class=export  user_color=button target="_blank"><?php echo self::$language['export_current_data']?></a>
            
            <a href=# class=import  user_color=button><?php echo self::$language['import_new']?></a>
            
            </div>
        
            <div class=import_div>
                <?php echo self::$language['file']?> <?php echo self::$language['import_file_placeholder']?><?php echo self::$language['batch_reset_price_field']?><br /> 
                <span id=import_file_state></span> <a class=submit><?php echo self::$language['submit']?></a> <span class=state></span>
            </div>
        </div>
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['goods_name']?>/<?php echo self::$language['bar_code']?>/<?php echo self::$language['store_code']?>/<?php echo self::$language['detail']?>" class="form-control" ></m_label></div></div></div>
	<br />        
    <div class=where_div>
    	<?php echo self::$language['where_price']?><input type=text class=min_price placeholder="<?php echo self::$language['min_price']?>" /><input type=text class=max_price placeholder="<?php echo self::$language['max_price']?>" /><?php echo $module['where_price']?><?php echo self::$language['price_set_to']?><input type=text class=new_price /><a class=submit><?php echo self::$language['submit']?></a> <span class=state></span>
    </div>
    <div class="filter"><?php echo self::$language['content_filter']?>:
       <?php echo $module['filter']?>        
    </div>
    <div class=list>
    	<div class="g thead"><span class=g_title><?php echo self::$language['goods_name'] ?></span><span class=g_cprice><?php echo self::$language['cost_price'] ?></span><span class=g_e_price><?php echo self::$language['e_price'] ?></span><span class=g_w_price><?php echo self::$language['w_price'] ?></span><span class=g_discount_rate><?php echo self::$language['discount_rate'] ?></span></div>
		<?php echo $module['list']?>
    </div>
    <?php echo $module['page']?>
        
        
        
                        

	</div>
</div>



