<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		if(get_param('publish')!=''){$("#publish").val(get_param('publish'))}
		$("#<?php echo $module['module_name'];?> .publish").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
    });
    

    function monxin_table_filter(id){
		if($("#"+id).prop("value")!=-1){
			key=id.replace("_filter","");
			url=window.location.href;
			url=replace_get(url,key,$("#"+id).prop("value"));
			if(key!="search"){url=replace_get(url,"search","");}else{
				url='./index.php?monxin=form.data_show_list&search='+$("#search_filter").val()+'&order='+get_param('order')+'&table_id='+get_param('table_id');
			}
			url=replace_get(url,"current_page","1");
			//monxin_alert(url);
			window.location.href=url;	
		}
		return false;
    }
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .sequence{ width:30px;}
	#<?php echo $module['module_name'];?> #search_filter{ width:50%;}
	#<?php echo $module['module_name'];?> .map{ display:inline-block; width:30px; }
	#<?php echo $module['module_name'];?> .filter_label{  padding-right:3px;	}

    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="filter"><?php echo $module['filter']?><input type="text" name="search_filter" id="search_filter" placeholder="<?php echo $module['search_placeholder']?>" value="<?php echo @$_GET['search']?>" />
        <a href="#" onclick="return e_search();" class="search"><?php echo self::$language['search']?></a> 
       &nbsp;  <a href="./index.php?monxin=form.data_add&table_id=<?php echo $_GET['table_id'];?>" target="_blank" class="add"><?php echo self::$language['add']?><?php echo self::$language['data']?></a> 
    </div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <?php echo $module['head_field'];?>
                <td  style=" width:250px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['view']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
