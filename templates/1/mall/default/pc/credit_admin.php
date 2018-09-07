<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> textarea").blur(function(){
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['executing']?>');
			$.post("<?php echo $module['action_url'];?>&act=repayment_remark",{username:$(this).parent().parent().attr('username'),repayment_remark:$(this).val()},function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> [username='"+v.username+"'] textarea").next('span').html(v.info);
			});	
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> .submit").click(function(){
			$(this).next('span').html('<span class=\'fa fa-spinner fa-spin\'></span> <?php echo self::$language['executing']?>');
			$.post("<?php echo $module['action_url'];?>&act=full_settlement",{username:$(this).parent().parent().attr('username')},function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> [username='"+v.username+"'] .submit").next('span').html(v.info);
				if(v.state=='success'){$("#<?php echo $module['module_name'];?> [username='"+v.username+"'] .submit").css('display','none');}
			});	
			return false;	
		});
		
		
    });
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html textarea{ width:400px; height:100px;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="portlet-title">
        <div class="caption"><?php echo $module['monxin_table_name']?></div>
    </div>
                        
                        
                        
                        
    <div class="m_row"><div class="half"><div class="dataTables_length"><select class="form-control" id="page_size" ><option value="10">10</option><option value="20">20</option><option value="50">50</option><option value="100">100</option></select> <?php echo self::$language['per_page']?></m_label></div></div><div class="half"><div class="dataTables_filter"><m_label><?php echo self::$language['search']?>:<input type="search" placeholder="<?php echo self::$language['username']?>"  class="form-control" ></m_label></div></div></div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid" style="width:100%" cellpadding="0" cellspacing="0" >
         <thead>
            <tr>
                <td ><?php echo self::$language['username']?></td>
                <td ><?php echo self::$language['pay_method']['credit']?><?php echo self::$language['money']?></td>
                <td ><?php echo self::$language['repayment_remark']?></td>
                <td  style=" width:270px;text-align:left;"><span class=operation_icon>&nbsp;</span><?php echo self::$language['operation']?></td>
            </tr>
        </thead>
        <tbody>
            <?php echo $module['list']?>
        </tbody>
    </table></div>
    
    <?php echo $module['page']?>
    </div>
    </div>

</div>
