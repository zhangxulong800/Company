<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <link rel="stylesheet" href="./plugin/bigcolorpicker/css/jquery.bigcolorpicker.css" type="text/css" />
	<script type="text/javascript" src="./plugin/bigcolorpicker/js/jquery.bigcolorpicker.js"></script>
	<script>
    $(document).ready(function(){ 
		$("[type=<?php echo $_GET['type']?>]").addClass('active'); 
        $('#up_new_ele').insertBefore($('#up_new_state'));$("#<?php echo $module['module_name'];?>_html #program").change(function(){
			url=window.location.href;
			url=replace_get(url,'program',$(this).prop("value"));
			url=replace_get(url,'type',"<?php echo $_GET['type']?>");
			window.location.href=url;	
		});
		$("#<?php echo $module['module_name'];?>_html #program").prop('value',get_param('program'));
		
        $(".apply").click(function(){
				var id=$(this).attr('id');
				var path=$(this).attr('href');
				//monxin_alert(id);
				$("#"+id).html("<span class=\'fa fa-spinner fa-spin\'></span>");
				$("#"+id).load('<?php echo $module['action_url'];?>&act=apply&path='+path,function(){
					//monxin_alert($(this).html());
					if($(this).html().length>10){
						try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


						$(this).html(v.info);
						if(v.state=='success'){
							monxin_alert(v.info);
							window.location.reload();	 
						}
					}
				});
			return false;
        });
        $(".del").click(function(){
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
				var id=$(this).attr('id');
				var path=$(this).attr('href');
				//monxin_alert(id);
				$("#"+id).html("<span class=\'fa fa-spinner fa-spin\'></span>");
				$("#"+id).load('<?php echo $module['action_url'];?>&act=del&path='+path,function(){
					//monxin_alert($(this).html());
					if($(this).html().length>10){
						try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


						$(this).html(v.info);
						//$("#"+id).html(v.info+"<a class=refresh href='javascript:window.location.reload();'><?php echo self::$language['refresh'];?></a>");
						 if(v.state!='fail'){$("#"+path+'_li').animate({opacity:0},"slow",function(){$("#"+path+'_li').css('display','none');});}
					}
				});
			}
			return false;
        });
        
    });
    
	function submit_hidden(id){
		$("#up_new_fieldset_failedList").css('display','none');
		$("#up_new_fieldset_succeedList").css('display','none');
		str=$("#"+id).val();
		$("#up_new_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post("<?php echo $module['action_url'];?>&act=up_new",{v:str},function(data){
			//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			$("#up_new_state").html(v.info);			
        });	
	}
            
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{line-height:40px; padding:20px;border-radius:3px;}
    #<?php echo $module['module_name'];?>_html legend{ }
	#<?php echo $module['module_name'];?>_html fieldset{ margin-bottom:20px;}
    #<?php echo $module['module_name'];?>_html .input_text{width:150px;}
    #<?php echo $module['module_name'];?>_html .focus{ }
    #<?php echo $module['module_name'];?>_html div{ }
    #<?php echo $module['module_name'];?>_html .m_label2{ display:inline-block; width:590px; text-align:right;}
    #<?php echo $module['module_name'];?>_html .m_label{ display:inline-block; width:40px; text-align:right;}
    #<?php echo $module['module_name'];?>_html .content{width:350px; display:inline-block; float:right;}
    #<?php echo $module['module_name'];?>_html .content input{width:320px;}
	#<?php echo $module['module_name'];?>_html .edit{ font-size:1rem;}
	#<?php echo $module['module_name'];?>_html .del{ font-size:1rem;}
	
    #<?php echo $module['module_name'];?>_html #icons li{line-height:20px; white-space:nowrap;  list-style-type:none; vertical-align:middle; width:290px; height:110px; float:left;}
	.icon_div{ display:inline-block; text-align:center;}
	.info_div{ display:inline-block; line-height:24px;}
	.info_div a{ }
    #<?php echo $module['module_name'];?>_html .icon_div img{width:70px; height:70px; border:0px;}
    #<?php echo $module['module_name'];?>_html .info_div{padding-left:5px;}
    #<?php echo $module['module_name'];?>_html .info_div img{border:0px; padding-left:10px;}
    #<?php echo $module['module_name'];?>_html #icons span{ line-height:20px; font-size:1rem;}
    #<?php echo $module['module_name'];?>_html #icons a{}
    #<?php echo $module['module_name'];?>_html #icons a:hover{ opacity:0.8; filter:alpha(opacity=80); }
	#up_div{ margin:10px;}
	#<?php echo $module['module_name'];?>_html input{ border:0px; margin-left:5px;}
	#<?php echo $module['module_name'];?>_html ul{ margin:0px; padding:0px;list-style:none;}
	#<?php echo $module['module_name'];?>_html li{  list-style:none !important; display:block; text-align:left;}
	#<?php echo $module['module_name'];?>_html fieldset{ margin-top:20px;}
	
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title" style="border-bottom: 1px solid #eee; margin-bottom:10px;">
       	 <div class="caption" ><?php echo $module['monxin_table_name']?></div>
   	    </div>
   
		<?php echo $module['list'];?>
    </div>

</div>