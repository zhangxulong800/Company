<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$('#shelf_label_ele').insertBefore($('#shelf_label_state'));
		$("#<?php echo $module['module_name'];?>_html .print_set .submit").click(function(){
			window.print();
			return false;	
		});
    });
  
	
    function submit_hidden(id){
        //monxin_alert(id);
        obj=document.getElementById(id);
		//monxin_alert(obj.value);
        if(obj.value==''){}
        json="{'"+obj.id+"':'"+replace_quot(obj.value)+"'}";
        try{json=eval("("+json+")");}catch(exception){alert(json);}
        $("#"+obj.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
        $("#"+obj.id+"_state").load('<?php echo $module['action_url'];?>&act=icon',json,function(){
            if($(this).html().length>10){
               //alert($(this).html());
                try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
                $(this).html(v.info);
               	if(v.state=='success'){$("#shelf_label_img").attr('src',$("#shelf_label_img").attr('src')+'?&=re'+Math.random());}
                
            }
        });
        
    }
    </script>
	<style>
    #<?php echo $module['module_name'];?>{} 
    #<?php echo $module['module_name'];?>_html{}
    #<?php echo $module['module_name'];?>_html .print_set{}
    #<?php echo $module['module_name'];?>_html .print_set img{ height:2rem;}
    #<?php echo $module['module_name'];?>_html .print_set .submit{}
	
	#<?php echo $module['module_name'];?>_html .print_content{ width:1050px; height:1485px; overflow:hidden; background:url(./program/mall/shelf_label/<?php echo $module['shop_id']?>.png); background-size:cover; padding-left:25px; padding-right:25px; padding-top:41px; padding-bottom:41px; }
	#<?php echo $module['module_name'];?>_html .print_content .goods{ white-space:nowrap; display:inline-block; vertical-align:top; width:500px; height:201px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .code{display:inline-block; vertical-align:top; padding-top:65px;width:135px;overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .code .qr img{ margin-left:17px; width:82px; height:82px; border-radius:5px;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .code .bar_code img{ margin-top:15px; margin-left:17px; width:110px; height:30px; }
	#<?php echo $module['module_name'];?>_html .print_content .goods .text{display:inline-block; vertical-align:top; width:350px;overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .name{ margin-top:10px; padding-left:60px; line-height:50px; font-size:30px;font-weight:bold;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .other{}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .other .other_left{ display:inline-block; vertical-align:top; width:128px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .other .other_left .grade{ padding-left:50px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .other .other_left .contain{ padding-left:50px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .other .other_left .unit_habitat{ line-height:35px;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .other .other_left .unit_habitat .unit{ display:inline-block; vertical-align:top; width:50%; overflow:hidden;padding-left:50px;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .other .other_left .unit_habitat .habitat{ display:inline-block; vertical-align:top; width:50%; overflow:hidden;padding-left:50px;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .other .other_right{display:inline-block; vertical-align:top; width:220px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .other .other_right .big_price{ padding-left:50px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .other .other_right .price{ padding-left:50px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html .print_content .goods .text .other .other_right .group_price{ padding-left:60px; line-height:70px; font-size:30px; font-weight:bold;}
   
   @media print {
	   #<?php echo $module['module_name'];?>{}
	   #<?php echo $module['module_name'];?>_html{}
	   #<?php echo $module['module_name'];?>_html .print_set{ display:none;}
	}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=print_set><?php echo self::$language['background']?> <img id=shelf_label_img src='./program/mall/shelf_label/<?php echo $module['shop_id']?>.png' /> <span id="shelf_label_state" /></span> <a href=# class=submit><?php echo self::$language['print']?></a></div>
    	<?php echo $module['list'];?>
        
    </div>
</div>
