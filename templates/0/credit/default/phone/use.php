<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .exchange").click(function(){
			if(getCookie('monxin_id')!=''){
				id=$(this).attr('d_id');
				if(<?php echo $module['credits']?><parseInt($("#<?php echo $module['module_name'];?> #prize_"+id+" .v").html())){
					alert('<?php echo self::$language['your']?><?php echo self::$language['credit']?>:<?php echo $module['credits']?>，<?php echo self::$language['insufficient']?>');
					return false;	
				}
				
				$(this).css('display','none');
				$(this).next('.state').html('<span class=\'fa fa-spinner fa-spin\'></span>');
				$.post('<?php echo $module['action_url'];?>&act=exchange',{id:id}, function(data){
					//alert(data);
					try{v=eval("("+data+")");}catch(exception){alert(data);}
					$("#<?php echo $module['module_name'];?> #prize_"+id+" .state").html(v.info);
					if(v.state=='success'){
						  alert('<?php echo self::$language['exchange']?><?php echo self::$language['success']?>,<?php echo self::$language['next_notice']?>');
						  window.location.href='./index.php?monxin=credit.my_use';
					}else{
						$("#<?php echo $module['module_name'];?> #prize_"+id+" .exchange").css('display','inline-block');
					}
			
				});
			}else{
				alert('<?php echo self::$language['please_login']?>');	
				window.location.href='./index.php?monxin=index.login';
			}
			return false;	
		});
    });
    </script>
    <style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?> .prize{ display:inline-block; vertical-align:top; width:48%; margin:1%; overflow:hidden; line-height:2rem; white-space:nowrap; }
	#<?php echo $module['module_name'];?> .prize:hover{ opacity:0.9;}
	#<?php echo $module['module_name'];?> .prize .icon_div{ height:170px; overflow:hidden;}
    #<?php echo $module['module_name'];?> .prize img{ width:100%;}
    #<?php echo $module['module_name'];?> .prize .name{ }
    #<?php echo $module['module_name'];?> .prize .name a{ font-size:0.9rem;}
    #<?php echo $module['module_name'];?> .prize .name a:hover{ font-weight:bold;}
    #<?php echo $module['module_name'];?> .prize .name a:before{font: normal normal normal 12px/1 FontAwesome;margin-left: 5px; content:"\f0c1";
}
    #<?php echo $module['module_name'];?> .prize .other{}
    #<?php echo $module['module_name'];?> .prize .other .credit{ display:inline-block; vertical-align:top; width:50%; overflow:hidden;}
    #<?php echo $module['module_name'];?> .prize .other .credit .v{ color:red; padding-left:5px;}
    #<?php echo $module['module_name'];?> .prize .other .act{display:inline-block; vertical-align:top; width:50%; overflow:hidden; text-align:right;}
    #<?php echo $module['module_name'];?> .prize .other .act a{ padding:2px; padding-left:5px; padding-right:5px; border-radius:3px;}
	
    </style>
    <div id=<?php echo $module['module_name'];?>_html>
    	
		<?php echo $module['list']?>
        <?php echo $module['page']?>
    </div>
</div>
