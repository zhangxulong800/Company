<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <link rel="stylesheet" href="./plugin/bigcolorpicker/css/jquery.bigcolorpicker.css" type="text/css" />
	<script type="text/javascript" src="./plugin/bigcolorpicker/js/jquery.bigcolorpicker.js"></script>
	<script>
    $(document).ready(function(){  
        $('#up_new_ele').insertBefore($('#up_new_state'));function c_audio(id,v){
		   $("#<?php echo $module['module_name'];?>_html #"+id).attr('src',v);
		}
    
		
		$("#<?php echo $module['module_name'];?>_html #program").change(function(){
			url=window.location.href;
			url=replace_get(url,'program',$(this).prop("value"));
			window.location.href=url;	
		});
		$("#<?php echo $module['module_name'];?>_html #program").prop('value',get_param('program'));
		
        
        $(".not_install_install").click(function(){
			var id=$(this).attr('href');
            $("#"+id+"_install_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
            $("#"+id+"_install_state").load('./install.php?act=install&program='+id,function(){
				monxin_alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                    $(this).html(v.info);
                    if(v.state!='fail'){$("#"+id+'_li').html(v.info+"<a class=refresh href='javascript:window.location.reload();'><?php echo self::$language['refresh'];?></a>");}
                }
            });
			return false;
        });
        $(".not_install_del").click(function(){
			var id=$(this).attr('href');
            $("#"+id+"_del_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
            $("#"+id+"_del_state").load('<?php echo $module['action_url'];?>&act=del&program='+id,function(){
				//monxin_alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                    $(this).html(v.info);
                    if(v.state!='fail'){$("#"+id+'_li').animate({opacity:0},"slow",function(){$("#"+id+'_li').css('display','none');});}
                }
            });
			return false;
        });
        $("input").blur(function(){
            //monxin_alert(this.id);
            	
			this.value=replace_quot(this.value);
            json="{'"+this.id+"':'"+this.value+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&act=set&update='+this.id,json,function(){
				//monxin_alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                    $(this).html(v.info);
                    if(v.state=='fail'){$(this).html('');}else{}
                }
            });
        });
        
        $("textarea").blur(function(){
            //monxin_alert(this.id);
            
			str=this.value;
			while(str.indexOf("\r") >= 0){str= str.replace("\r", "\\r");}
			while(str.indexOf("\n") >= 0){str= str.replace("\n", "\\n");}
			str=replace_quot(str);
            json="{'"+this.id+"':'"+str+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&act=set&update='+this.id,json,function(){
				//monxin_alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                    $(this).html(v.info);
                    if(v.state=='fail'){$(this).html('');}else{}
                }
            });
        });
        
        $("select").change(function(){
            //monxin_alert(this.id);
            	
            json="{'"+this.id+"':'"+this.value+"'}";
			//monxin_alert(json);
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&act=set&update='+this.id,json,function(){
				//monxin_alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                    $(this).html(v.info);
                    if(v.state=='fail'){$(this).html('');}else{}
                }
            });
        });
        
        $(".uninstall").click(function(){
			if(confirm("<?php echo self::$language['delete_confirm']?>")){
				$(this).html('<span class=\'fa fa-spinner fa-spin\'></span>');
				//
				program=$(this).attr('id');
				$.get('./install.php?act=uninstall&program='+program, function(data){
					monxin_alert(data);
					            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

					$("#"+program).html(v.info);
					if(v.state=='success'){
					$("#"+program+"_li").animate({opacity:0},"slow",function(){$("#"+program+"_li").css('display','none');});
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
            monxin_alert(data);
                        try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#up_new_state").html(v.info);			
        });	
	}
            
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{line-height:40px; padding:20px; border-radius:3px;}
    #<?php echo $module['module_name'];?>_html legend{}
	#<?php echo $module['module_name'];?>_html fieldset{ margin-bottom:20px;}
    #<?php echo $module['module_name'];?>_html .input_text{width:150px;}
    #<?php echo $module['module_name'];?>_html .focus{ }
    #<?php echo $module['module_name'];?>_html div{ }
    #<?php echo $module['module_name'];?>_html .m_label2{ display:inline-block; width:440px; text-align:right;}
    #<?php echo $module['module_name'];?>_html .m_label{ display:inline-block; width:3rem; text-align:right;}
    #<?php echo $module['module_name'];?>_html .content{width:600px; display:inline-block; float:right;}
    #<?php echo $module['module_name'];?>_html .content input{width:320px;}
	#<?php echo $module['module_name'];?>_table .odd{ }
	#<?php echo $module['module_name'];?>_table .even{ }
	
    #<?php echo $module['module_name'];?>_html #icons li{line-height:20px;  list-style-type:none; display:block; width:100%;margin-bottom:2rem;  }
	.icon_div{ display:inline-block; vertical-align:top; width:30%; overflow:hidden; text-align:center;}
	.info_div{ display:inline-block; vertical-align:top; white-space:nowrap; text-align:left;width:70%; overflow:hidden; line-height:24px;}
    #<?php echo $module['module_name'];?>_html .icon_div img{width:80%;}
    #<?php echo $module['module_name'];?>_html .icon_div:hover img{width:80% opacity:0.9;}
    #<?php echo $module['module_name'];?>_html .info_div{padding-left:5px;}
    #<?php echo $module['module_name'];?>_html .info_div img{border:0px; padding-left:10px;}
    #<?php echo $module['module_name'];?>_html #icons{ line-height:20px; font-size:1rem; margin-top:20px;}
    #<?php echo $module['module_name'];?>_html #icons span{ display:inline-block; vertical-align:top; line-height:20px; font-size:1rem; }
    #<?php echo $module['module_name'];?>_html #icons a{ display:inline;}
    #<?php echo $module['module_name'];?>_html #icons a:hover{opacity:0.8; filter:alpha(opacity=80);}
    #<?php echo $module['module_name'];?>_html .set{ font-size:1rem;}
	#program_banner{ border-bottom:#ff9600 solid 5px; line-height:30px;}
	#installed_programs{ display:inline-block; padding:10px;}
	#program_market{  display:inline-block; padding:10px;}
	#up_div{ margin:10px;}
	ul{ margin:0px; padding:0px;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
        <div class="portlet-title" style="border-bottom: 1px solid #eee; margin-bottom:10px;">
        	<div class="caption" ><?php echo $module['monxin_table_name']?></div>
   	    </div>
    
   
    <?php echo $module['list'];?>
    </div>
	<br /><br /><br /><br /><br />
</div>