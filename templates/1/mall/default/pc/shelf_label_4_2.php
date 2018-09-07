<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$('#shelf_label_ele').insertBefore($('#shelf_label_state'));
		$("#<?php echo $module['module_name'];?>_html .print_set .submit").click(function(){
			window.print();
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?> [composing]").click(function(){
			url=window.location.href;
			url=replace_get(url,'composing',$(this).attr('composing'));
			window.location.href=url;
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
        $("#"+obj.id+"_state").load('<?php echo $module['action_url'];?>&act=icon&composing='+get_param('composing'),json,function(){
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
	
	[composing='4_2']{ color:red !important;}
    #<?php echo $module['module_name'];?>_html .print_set{}
    #<?php echo $module['module_name'];?>_html .print_set a{ border:1px dashed #000; padding:5px; border-radius:5px; display:inline-block;  margin-right:10px; cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .print_set a:hover{ background:#ccc;}
    #<?php echo $module['module_name'];?>_html .print_set img{ height:2rem;}
    #<?php echo $module['module_name'];?>_html .print_set .submit{ border:0px; line-height:20px;}
	
	#<?php echo $module['module_name'];?>_html .print_content{ width:1060px; height:1485px; overflow:hidden; background:url(./program/mall/shelf_label/<?php echo $module['shop_id']?>_4_2.png); background-size:cover; padding-left:15px; padding-right:25px; padding-top:41px; padding-bottom:41px; }
	#<?php echo $module['module_name'];?>_html .print_content .goods{ white-space:nowrap; display:inline-block; vertical-align:top; width:500px; height:360px; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .print_content .goods:nth-child(even){ padding-left:20px;}
   
   #<?php echo $module['module_name'];?>_html .print_content .goods .bar_code{ text-align:right; padding-top:22px;}
   #<?php echo $module['module_name'];?>_html .print_content .goods .bar_code img{ height:40px; width:190px; padding-right:10px;}
   #<?php echo $module['module_name'];?>_html .print_content .goods .name{ padding-top:15px; padding-left:65px; font-weight:bold; font-size:1.6rem; white-space:nowrap;}
   #<?php echo $module['module_name'];?>_html .print_content .goods .other{ line-height:38px;}
   #<?php echo $module['module_name'];?>_html .print_content .goods .other .grade{ display:inline-block; vertical-align:top; width:25%; overflow:hidden; padding-left:50px;}
   #<?php echo $module['module_name'];?>_html .print_content .goods .other .habitat{display:inline-block; vertical-align:top; width:25%; overflow:hidden; padding-left:45px;}
   #<?php echo $module['module_name'];?>_html .print_content .goods .other .contain{display:inline-block; vertical-align:top; width:50%; overflow:hidden;padding-left:50px;}
   #<?php echo $module['module_name'];?>_html .print_content .goods .price_qr{ padding-left:65px;}
   #<?php echo $module['module_name'];?>_html .print_content .goods .price_qr .price_div{display:inline-block; vertical-align:top; width:73%; overflow:hidden; padding-top:38px;}
   #<?php echo $module['module_name'];?>_html .print_content .goods .price_qr .price_div .price{}
   #<?php echo $module['module_name'];?>_html .print_content .goods .price_qr .price_div .group_price{ padding-left:20px; padding-top:20px; font-size:4rem; font-weight:bold; color:rgba(17,136,59,1);}
   #<?php echo $module['module_name'];?>_html .print_content .goods .price_qr .price_div .group_price .unit{ font-size:1.5rem;font-weight:normal;}
   #<?php echo $module['module_name'];?>_html .print_content .goods .price_qr .qr{display:inline-block; vertical-align:top; width:27%; overflow:hidden; }
    #<?php echo $module['module_name'];?>_html .print_content .goods .big_price{ display:none;}
   @media print {
	   #<?php echo $module['module_name'];?>{}
	   #<?php echo $module['module_name'];?>_html{}
	   #<?php echo $module['module_name'];?>_html .print_set{ display:none;}
	   
	}
	.page-header,#index_user_position,.fixed_right_div{ display:none;}
	.page-container{ width:1050px; padding:0px; margin:0px;}
	.decimal{ font-size:1.2rem; font-style:normal;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=print_set><?php echo self::$language['background']?> <img id=shelf_label_img src='./program/mall/shelf_label/<?php echo $module['shop_id']?>_4_2.png' /> <span id="shelf_label_state" /></span> <a href=./program/mall/label.zip target=_blank><?php echo self::$language['download']?><?php echo self::$language['background']?></a> <?php echo self::$language['composing']?>: <?php echo $module['composing_option'];?><a href=# class=submit><?php echo self::$language['print']?></a></div>
    	<?php echo $module['list'];?>
        
    </div>
</div>
