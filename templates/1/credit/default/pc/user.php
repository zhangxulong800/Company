<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$(document).on('click','#<?php echo $module['module_name'];?> [monxin-table] .increase',function(){
			set_iframe_position(1000,500);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=credit.increase&id='+$(this).attr('d_id'));
			return false;	
		});
		
		$(document).on('click','#<?php echo $module['module_name'];?> [monxin-table] .decrease',function(){
			set_iframe_position(1000,500);
			$("#monxin_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_monxin_iframe_div").css('display','block');
			$("#monxin_iframe").attr('src','./index.php?monxin=credit.decrease&id='+$(this).attr('d_id'));
			return false;	
		});
		
    });
	
	function re_set_credit(id,v){
		$("#<?php echo $module['module_name'];?> #tr_"+id+" .credit").html(v);	
	}
    </script>
	<style>    
	#<?php echo $module['module_name'];?>_html{}
    </style>
    <div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search"  placeholder="<?php echo self::$language['username']?>/<?php echo self::$language['reason']?>" class="form-control" ></m_label></div></div></div>
    <div class=sum_div><?php echo self::$language['sum'];?> : <span ><?php echo $module['sum']?></span></div>
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td ><?php echo self::$language['username']?></td>
                <td ><?php echo self::$language['credits']?></td>
                <td class=operation_td><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    </div>
</div>
