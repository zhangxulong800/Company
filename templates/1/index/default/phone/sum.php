<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .clear_file_cache").click(function(){
			$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=clear_file_cache',function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .clear_file_cache").html(v.info);
				
			});
			return false;	
		});
		$("#<?php echo $module['module_name'];?> .clear_sql_cache").click(function(){
			$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=clear_sql_cache',function(data){
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$("#<?php echo $module['module_name'];?> .clear_sql_cache").html(v.info);
				
			});
			return false;	
		});
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?> .card_head{background-color: #390; }
	#<?php echo $module['module_name'];?> .clear_cache{}
	#<?php echo $module['module_name'];?> .clear_cache:hover{ font-weight:normal;}
	#<?php echo $module['module_name'];?> .clear_cache a{}
	#<?php echo $module['module_name'];?> .clear_cache a:before {font: normal normal normal 14px/1 FontAwesome;margin-right: 2px;content:"\f014";}
	#<?php echo $module['module_name'];?> .clear_cache a:hover{ font-weight:bold;}
    </style>
    
    <div id=<?php echo $module['module_name'];?>_html>
    	<a href='./index.php?monxin=index.admin_users' class=card_head>
        	<span class=big_num><?php echo $module['user'];?></span>
            <span class=remark><?php echo self::$language['member'];?></span>
        </a>
    	<div class=card_body>
        	<a href='./index.php?monxin=index.admin_users' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['member']?><?php echo self::$language['balance']?></span>
            	<span class=value><?php echo $module['user_money'];?></span>
            </a><div class="item clear_cache">
            	<a class="name clear_file_cache" href="#"><?php echo self::$language['clear_file_cache']?></a>
            	<a class="value clear_sql_cache" href="#"><?php echo self::$language['clear_sql_cache']?></a>
            	
            </div><a href='./index.php?monxin=index.admin_site_msg' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['site_msg']?></span>
            	<span class=value><?php echo $module['site_msg'];?></span>
            </a><a href='./index.php?monxin=index.credits_admin' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['member']?><?php echo self::$language['credits']?></span>
            	<span class=value><?php echo $module['credits'];?></span>
            </a><a href='./index.php?monxin=index.recharge_log_admin&state=4' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['success']?><?php echo self::$language['recharge']?></span>
            	<span class=value><?php echo $module['recharge'];?></span>
            </a><a href='./index.php?monxin=index.withdraw_log_admin&state=1' class=item>
            	<span class=name><?php echo self::$language['withdraw']?><?php echo self::$language['withdraw_state'][1]?></span>
            	<span class=value><?php echo $module['withdraw'];?></span>
            </a>
        </div>
        
        
    </div>
</div>