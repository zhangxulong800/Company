<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		if(get_param('type')!=''){$("#<?php echo $module['module_name'];?> #type_filter").val(get_param('type'));}		
		$("#<?php echo $module['module_name'];?>_html .print_set .print").click(function(){
			window.print();
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?>_html .print_set .submit").click(function(){
			if($("#<?php echo $module['module_name'];?> .print_set .min").val()==''){alert('<?php echo self::$language['is_null']?>');}
			if($("#<?php echo $module['module_name'];?> .print_set .max").val()==''){alert('<?php echo self::$language['is_null']?>');}
			window.location.href='./index.php?monxin=mall.print_bar_code&min='+$("#<?php echo $module['module_name'];?> .print_set .min").val()+'&max='+$("#<?php echo $module['module_name'];?> .print_set .max").val()+"&search="+$("#<?php echo $module['module_name'];?> .print_set #search_filter").val()+"&type="+$("#<?php echo $module['module_name'];?> .print_set #type_filter").val();
			return false;	
		});
		
		
		
    });
	
    </script>
	<style>
    #<?php echo $module['module_name'];?>{} 
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .print_set{ padding-bottom:10px; }
    #<?php echo $module['module_name'];?>_html .print_set input{ width:3rem; text-align:center;}
    #<?php echo $module['module_name'];?>_html .print_set div{ display:inline-block; vertical-align:top; }
    #<?php echo $module['module_name'];?>_html .print_set .p_left{ width:80%;}
    #<?php echo $module['module_name'];?>_html .print_set .p_right{ text-align:right;width:20%;}
    #<?php echo $module['module_name'];?>_html .print_set .submit{ }
	
	#<?php echo $module['module_name'];?>_html .print_content{ width:1050px; height:1485px; overflow:hidden;  background-size:cover; padding-left:25px; padding-right:25px; padding-top:41px; padding-bottom:41px; }
	#<?php echo $module['module_name'];?>_html .print_content .goods{ display:inline-block; vertical-align:top; width:30.3%; margin:1.5%; overflow:hidden; text-align:center; margin-border-bottom:22px;}
	#<?php echo $module['module_name'];?>_html .print_content .goods img{ width:90%; height:80px;}
	#<?php echo $module['module_name'];?>_html .print_content .goods span{ display:block; white-space:nowrap; overflow:hidden;    text-overflow: ellipsis;}
   
   @media print {
	   #index_user_position,.page-header{ display:none;}
	   .light{ padding:0px;}
	   [m_container='m_container']{ padding:0px;}
	   #<?php echo $module['module_name'];?>{}
	   #<?php echo $module['module_name'];?>_html{}
	   #<?php echo $module['module_name'];?>_html .print_set{ display:none;}
	}
    </style>
    <div id="<?php echo $module['module_name'];?>_html" monxin-table=1>
        
    	<div class=print_set>
        <div class=p_left>
            <div class="filter"><?php echo self::$language['content_filter']?>:<?php echo $module['filter']?> <input type=text id=search_filter name=search_filter value="<?php echo @$_GET['search']?>" placeholder="<?php echo self::$language['search']?>" style="width:100px; margin-right:40px;" /></div>
        
        <input type="text" value="<?php echo @$_GET['min']?>" class=min /> - <input type="text" value="<?php echo @$_GET['max']?>" class=max /> <?php echo self::$language['bar_code_length']?> <a href=# class=submit><?php echo self::$language['inquiry']?></a>
        </div><div class=p_right><a href=# class="add print"><?php echo self::$language['print']?></a></div>
        </div>
    	<?php echo $module['list'];?>
        
    </div>
</div>
