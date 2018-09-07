<script src="./plugin/datePicker/index.php"></script>

<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		var state=get_param('state');
		if(state!=''){$("#state").prop('value',state);}
		var method=get_param('method');
		if(method!=''){$("#method").prop('value',method);}
		$("#monxin_table_filter select").change(function(){
			 monxin_table_filter($(this).attr('id'));		
		});
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_monxin_iframe_div").css('display','none');
			$("img[src='"+replace_file+"']").attr('src',replace_file+"?&reflash="+Math.random());
			return false;
		});

		$(".pay_photo").click(function(){
			
			set_iframe_position($(window).width()-100,$(window).height()-200);
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		$(".pay_info").click(function(){
			alert($(this).attr('title'));
			return false;	
		});
    });
    
    function monxin_table_filter(id){
		if($("#"+id).prop("value")!=-1){
			key=id.replace("_filter","");
			url=window.location.href;
			url=replace_get(url,key,$("#"+id).prop("value"));
			if(key!="search"){url=replace_get(url,"search","");}else{url=replace_get(url,"current_page","1");url=replace_get(url,"state","");}
			//monxin_alert(url);
			window.location.href=url;	
		}
    }
    
	
	  
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .pay_photo{  display:inline-block; height:30px; width:30px;}
    #<?php echo $module['module_name'];?>_html .pay_info{  display:inline-block; height:30px; width:30px;}
    #<?php echo $module['module_name'];?>_html .pay_photo:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f1c5";}
    #<?php echo $module['module_name'];?>_html .pay_info:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f0f6";}
    #<?php echo $module['module_name'];?>_table .username{width:100px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;display:inline-block;}
    #<?php echo $module['module_name'];?>_table .method{width:150px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .money{width:150px;display:inline-block;overflow:hidden;}
    #<?php echo $module['module_name'];?>_table .state{width:80px;display:inline-block;}
    #<?php echo $module['module_name'];?>_table .operation{width:350px;display:inline-block; text-align:left;}
    #<?php echo $module['module_name'];?>_table .operation_state{display:inline-block;}
	select{ margin-left:5px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"></div></div>
    <table class=top_div width="100%">
    	<tr>
        	<td align="left"> 
            <span id=monxin_table_filter><?php echo self::$language['content_filter']?>:
    <?php echo $module['filter']?></span>
        <span id=time_limit><span class=start_time_span><?php echo self::$language['start_time']?></span><input type="text" id="start_time" name="start_time" value="<?php echo @$_GET['start_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> -
        <span class=end_time_span><?php echo self::$language['end_time']?></span><input type="text" id="end_time" name="end_time"  value="<?php echo @$_GET['end_time'];?>"  onclick=show_datePicker(this.id,'date') onblur= hide_datePicker()  /> <a href="#" onclick="return time_limit();" class="submit"><?php echo self::$language['submit']?></a></span>
            </td>
            <td align="right">
            <?php echo self::$language['sum']?><?php echo self::$language['success']?><?php echo self::$language['recharge']?>:<?php echo $module['sum_all']?>
            </td>
        </tr>
    </table>
   

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="time|desc" class="sorting"  asc="time|asc"><?php echo self::$language['time']?></a></td>
                <td ><?php echo self::$language['pay_method']?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="money|desc" class="sorting"  asc="money|asc"><?php echo self::$language['amount']?></a></td>
                <td ><?php echo self::$language['reason']?></td>
                <td ><?php echo self::$language['state']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
