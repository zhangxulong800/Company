<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
	var is_null=false;
    $(document).ready(function(){
            
        $("#<?php echo $module['module_name'];?> .submit").click(function(){
			money=$("#<?php echo $module['module_name'];?> .money").val();
			if(money=='' || !$.isNumeric(money)  || money==0){
				$("#<?php echo $module['module_name'];?> .money").val('');
				$("#<?php echo $module['module_name'];?> .money").focus();
				return false;	
			}
			var obj=new Object();
			obj['money']=money;
			obj['reason']=$("#<?php echo $module['module_name'];?> .reason").val();
			$("#<?php echo $module['module_name'];?> .submit").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post('<?php echo $module['action_url'];?>&act=add',obj, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> .submit").next().html(v.info);
				if(v.state=='success'){
						$("#<?php echo $module['module_name'];?> .submit").next().html(v.info+' <a href="javascript:window.location.reload();"><?php echo self::$language['refresh']?></a>');
					parent.update_credits(<?php echo @$_GET['id']?>,'-'+$("#<?php echo $module['module_name'];?> .money").val());	
				}
				
			});
			return false;
        });
			
    });
    </script>
    

    
    
    
    
    <style>
	.fixed_right_div,.page-footer,#mall_cart{ display:none !important;}
	.page-content .container { width:100% !important; height:100%;}
    #<?php echo $module['module_name'];?> { }
    #<?php echo $module['module_name'];?>_html{padding-bottom:20px;}
	#<?php echo $module['module_name'];?>_html .line{ display:inline-block; line-height:2.5rem;}
	#<?php echo $module['module_name'];?>_html .line .input input{}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=line><span class=m_label><?php echo self::$language['username']?></span><span class=input> <?php echo $module['username']?> <span class=state></span></span></div>
    	<div class=line><span class=m_label><?php echo self::$language['deduction_2']?><?php echo self::$language['credits']?></span><span class=input> <input type="text" class=money value=""  /> <span class=state></span></span></div>        
    	<div class=line><span class=m_label><input type="text" class=reason value=""  placeholder="<?php echo self::$language['deduction_2']?><?php echo self::$language['reason']?>"  /></span><span class=input> <a href=# class=submit><?php echo self::$language['submit']?></a> <span class=state></span></span></div>
    
    <div class=table_scroll><table class="table table-striped table-bordered table-hover dataTable no-footer"  role="grid"  id="<?php echo $module['module_name'];?>_table" style="width:100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td><?php echo self::$language['time']?></td>
                <td><?php echo self::$language['credits']?></td>
                <td><?php echo self::$language['reason']?></td>
            </tr>
        </thead>
        <tbody>
    <?php echo $module['list']?>
        </tbody>
    </table></div>
    <?php echo $module['page']?>
    
    
    
    </div>
</div>

