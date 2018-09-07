<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$(document).on('click','#<?php echo $module['module_name'];?> .transfer',function(){
			set_iframe_position(850,600);
			//monxin_alert(replace_file);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src',$(this).attr('href'));
			return false;	
		});
		
    });
	function update_balance(id,v){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .balance").html(parseFloat($("#<?php echo $module['module_name'];?> #tr_"+id+" .balance").html())-parseFloat(v));	
	}
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .info{ width:350px; line-height:25px;}
    #<?php echo $module['module_name'];?>_html .info .icon{ display:inline-block; vertical-align:top; width:30%; overflow:hidden;}
    #<?php echo $module['module_name'];?>_html .info .icon img{ width:90%; padding:5%;}
    #<?php echo $module['module_name'];?>_html .info .other{ text-align:left; display:inline-block; vertical-align:top; width:70%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .name{ font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .main_business{   height:25px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .pay_agent{ font-size:13px;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>

    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0" >
         <thead>
            <tr>
                <td style="text-align:left;"><?php echo self::$language['shop']?><?php echo self::$language['info']?></td>
                <td ><?php echo self::$language['level'];?></td>
                <td ><?php echo self::$language['preferential_way_option'][5]?></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="credits|desc" class="sorting"  asc="credits|asc"><?php echo self::$language['store']?><?php echo self::$language['credits']?></a></td>
                <td ><a href=# title="<?php echo self::$language['order']?>" desc="balance|desc" class="sorting"  asc="balance|asc"><?php echo self::$language['store']?><?php echo self::$language['balance']?></a></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    <div class=m_row><?php echo $module['page']?></div>
    </div>
    </div>

</div>
