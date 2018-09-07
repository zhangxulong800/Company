<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$('#img_new_ele').insertBefore($('#img_new_state'));
		
        $("#<?php echo $module['module_name'];?> .sequence").keydown(function(event){
            return isNumeric(event.keyCode);
        });
		
		$("#<?php echo $module['module_name'];?> .data_state").each(function(index, element) {
            if($(this).prop('value')==1){
				$(this).prop('checked',true);	
			}
        });
		
		$("#<?php echo $module['module_name'];?> .data_state").click(function(){
			if($(this).prop('checked')){
				$(this).prop('value',1);
			}else{
				$(this).prop('value',0);
			}
			
		});
		
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			$("img[src='"+replace_file+"']").attr('src',replace_file+"?&reflash="+Math.random());
			return false;
		});
		$('.icon_img').click(function(){
			replace_file=$(this).attr('file');
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//monxin_alert(replace_img);
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','index.php?monxin=index.replace_file&path='+replace_file+'&width=0&height=0&max_size=1024&min_size=1');
			//$(this).html($("#monxin_iframe").attr('src'));
			return false;	
		});
		
		
    });
    
    
    
    function update(id){
        var name=$("#name_"+id);	
        var url=$("#url_"+id);	
        var money=$("#money_"+id);	
        var quantity=$("#quantity_"+id);	
        var sequence=$("#sequence_"+id);	
        var state=$("#data_state_"+id);	
        if(name.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['name']?>');name.focus();return false;}	
        if(money.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['decrease']?>');width.focus();return false;}	
        if(quantity.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['quantity']?>');quantity.focus();return false;}	
        if(sequence.prop('value')==''){$("#state_"+id).html('<?php echo self::$language['please_input']?><?php echo self::$language['sequence']?>');sequence.focus();return false;}	   
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=update',{name:name.prop('value'),url:url.prop('value'),money:money.prop('value'),quantity:quantity.prop('value'),sequence:sequence.prop('value'),state:state.prop('value'),id:id}, function(data){
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
    
    
    
    
    function add(){
        nameNew=$("#<?php echo $module['module_name'];?> #name_new");
        imgNew=$("#<?php echo $module['module_name'];?> #img_new");
        urlNew=$("#<?php echo $module['module_name'];?> #url_new");
        moneyNew=$("#<?php echo $module['module_name'];?> #money_new");
        quantityNew=$("#<?php echo $module['module_name'];?> #quantity_new");
       if(nameNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['name']?></span>');nameNew.focus();return false;}	
       if(imgNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<span class=fail><?php echo self::$language['please_upload']?><?php echo self::$language['img']?></span>');imgNew.focus();return false;}	
       if(moneyNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['credit']?></span>');moneyNew.focus();return false;}	
       if(quantityNew.prop('value')==''){$("#<?php echo $module['module_name'];?> #state_new").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['quantity']?></span>');quantityNew.focus();return false;}	


        $("#<?php echo $module['module_name'];?> #state_new").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=add',{name:nameNew.prop('value'),img:imgNew.prop('value'),url:urlNew.prop('value'),money:moneyNew.prop('value'),quantity:quantityNew.prop('value')}, function(data){
			//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #state_new").html(v.info);
            if(v.state=='success'){
				  $("#<?php echo $module['module_name'];?> #state_new").html(v.info+' <a href="javascript:window.location.reload();"><?php echo self::$language['refresh']?></a>');
            }
    
        });
        return false;	
        
    }
    
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .info{}
    #<?php echo $module['module_name'];?> .info .line{ line-height:30px; margin-bottom:5px;}
    #<?php echo $module['module_name'];?> .info .line input{ width:300px;}
	#<?php echo $module['module_name'];?> .money{ width:50px;}
	#<?php echo $module['module_name'];?> .quantity{ width:50px;}
	#<?php echo $module['module_name'];?> .sequence{ width:50px;}
	#<?php echo $module['module_name'];?> .icon_img img{ height:100px;}
    </style>
    <div id=<?php echo $module['module_name'];?>_html  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
        <div class="actions">
        	<a href=./index.php?monxin=credit.use target="_blank" class=view><?php echo self::$language['pages']['credit.use']['name']?></a>
            &nbsp; &nbsp;
        	<a href=./index.php?monxin=credit.prize_log target="_blank"><?php echo self::$language['pages']['credit.prize_log']['name']?></a>
        </div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['name']?>" class="form-control" ></m_label></div></div></div>
    
    
    <div class="filter" style="display:none;"><?php echo self::$language['content_filter']?>:
        <input type="text" name="search_filter" id="search_filter" placeholder="<?php echo self::$language['name']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> <span id="search_state"></span>
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><input type="checkbox" group-checkable=1></td>
                <td ><?php echo self::$language['prize']?><?php echo self::$language['info']?></td>
                <td ><?php echo self::$language['decrease']?></td>
                <td ><a href=# name="<?php echo self::$language['order']?>" desc="quantity|desc" class="sorting"  asc="quantity|asc"><?php echo self::$language['quantity']?></a></td>
                <td ><a href=# name="<?php echo self::$language['order']?>" desc="use|desc" class="sorting"  asc="use|asc"><?php echo self::$language['use']?></a></td>
                <td ><a href=# name="<?php echo self::$language['order']?>" desc="sequence|desc" class="sorting"  asc="sequence|asc"><?php echo self::$language['sequence']?></a></td>
                <td ><a href=# name="<?php echo self::$language['order']?>" desc="state|desc" class="sorting"  asc="state|asc"><?php echo self::$language['open']?></a></td>
                <td  style=" width:150px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="4%"><input type="checkbox" group-checkable=1></td>
                <td >
                	<div class=info>
                        <div class=line><?php echo self::$language['name']?>  <input type="text" id="name_new" name="name_new" class="name" /></div>
                        <div class=line><?php echo self::$language['img']?>  <input type="hidden" id="img_new" name="img_new" class="img" /> <span id=img_new_state></span></div>
                        <div class=line><?php echo self::$language['url']?>  <input type=text id="url_new" name="url_new" class="url" placeholder="<?php echo self::$language['detail']?><?php echo self::$language['url']?>(<?php echo self::$language['optional']?>)" /></div>
                    </div>
                </td>
                <td ><input type=text id="money_new" name="money_new" class="money" /></td>
                <td ><input type=text id="quantity_new" name="quantity_new" class="quantity" /></td>
                <td class="operation_td" colspan="4"><a href="#" onclick="return add()"  class='add'><?php echo self::$language['add']?></a> <span id=state_new  class='state'></span></td>
            </tr>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
