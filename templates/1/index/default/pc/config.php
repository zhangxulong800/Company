<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <link rel="stylesheet" href="./plugin/bigcolorpicker/css/jquery.bigcolorpicker.css" type="text/css" />
	<script type="text/javascript" src="./plugin/bigcolorpicker/js/jquery.bigcolorpicker.js"></script>
	<script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #openid_notice_template input").attr('disabled','disabled');
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
			if($(this).attr('monxin_value')){$(this).val($(this).attr('monxin_value'));}
		});

		id=get_param('id');
		if(id!=''){$("#"+get_param('id')).css('display','block');}else{$("fieldset").css('display','block');}
		
		$("#image_mark__color").bigColorpicker("image_mark__color","L",10);
		$("#image_mark__color").blur(function(){
			if($(this).val().search(",")==-1){
				$(this).val(hex2rgb($(this).val()));	
			}	
		});
		$("#position_<?php echo $module['mark_position']?>").attr('class','a_current_position');
		
		$(".a").mouseover(function(){
			if($(this).attr('class')=='a'){$(this).attr('class','a_over');}	
		});
		$(".a").mouseout(function(){
			if($(this).attr('class')=='a_over'){$(this).attr('class','a');}	
		});
		
		$('.a').click(function(){
			$("#image_mark__position").val($(this).attr('href'));
			$("#position_table a").attr('class','a');
			$(this).attr('class','a_current_position');
			submit_hidden('image_mark__position');
			return false;	
		});
		
		enter_to_tab();
		
		$('#image_mark__water_logo_ele').insertBefore($('#image_mark__water_logo_state'));
		$('#image_mark__ttf_path_ele').insertBefore($('#image_mark__ttf_path_state'));
        
		
        
        $("input").blur(function(){
            //monxin_alert(this.id);
            
			this.value=replace_quot(this.value);	
            json="{'"+this.id+"':'"+this.value+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&update='+this.id,json,function(){
				//alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
					

                    $(this).html(v.info);
                   // if(v.state=='fail'){$(this).html('');}else{}
					if(v.alert_str!=undefined){monxin_alert(v.alert_str);}
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
            $("#"+this.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&update='+this.id,json,function(){
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
            $(this).removeClass('focus');	
            json="{'"+this.id+"':'"+this.value+"'}";
			//alert(json);
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&update='+this.id,json,function(){
				//alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                    $(this).html(v.info);
                    if(v.state=='fail'){$(this).html('');}else{}
                }
            });
        });
        
        $(".reset_site_key").click(function(){
            $(this).html("<span class='fa fa-spinner fa-spin'></span>");
            $.post('<?php echo $module['action_url'];?>&act=reset_site_key',function(data){
				alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				$(".reset_site_key").html(v.info);
            });
			return false;
        });
		
		$("#update_url").load("<?php echo $module['action_url'];?>&act=url");

        field=get_param('field').split("|");
        for(var v in field){
            
            $("#tr_"+field[v]).css('display','block');
        }
        //monxin_alert(field);
        if(field==''){
            $("#edit_user_form tr").css('display','block');
			$("#edit_user_form #tr_manager").css('display','none');
        }else{
            document.title='<?php echo self::$language['require_info']?>';	
        }    
    
    
	
	});
    
    
    
    
    function submit_hidden(id){
        //monxin_alert(id);
        obj=document.getElementById(id);
		//monxin_alert(obj.value);
        if(obj.value==''){}
        json="{'"+obj.id+"':'"+obj.value+"'}";
        try{json=eval("("+json+")");}catch(exception){alert(json);}
        $("#"+obj.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
        $("#"+obj.id+"_state").load('<?php echo $module['action_url'];?>&update='+obj.id,json,function(){
            if($(this).html().length>10){
                //monxin_alert($(this).html());
                try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                $(this).html(v.info);
                if(v.state=='fail'){$(this).html('');}else{}
                imgs=obj.value.split("|");
                if(v.state=='success'){$("#"+id+"_img").attr("src","./program/index/user_"+id+"/"+imgs[imgs.length-1]);}
            }
        });
        
    }
    
    
    function set_area(id,v){
        $("#"+id).prop('value',v);
        submit_hidden(id);	
    }
    
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{line-height:40px; }
    #<?php echo $module['module_name'];?>_html #position_table{ display:inline-block; width:327px;}
    #<?php echo $module['module_name'];?>_html #position_table tr td a{ height:45px; }
    #<?php echo $module['module_name'];?>_html legend{ }
	#<?php echo $module['module_name'];?>_html fieldset{ margin-bottom:20px;}
    #<?php echo $module['module_name'];?>_html .input_text{width:150px;}
    #<?php echo $module['module_name'];?>_html div{ line-height:45px;}
    #<?php echo $module['module_name'];?>_html .m_label{width:45%; display:inline-block; vertical-align:top;  text-align:right;}
    #<?php echo $module['module_name'];?>_html .content{width:50%; display:inline-block;vertical-align:top;  margin-left:15px; }
    #<?php echo $module['module_name'];?>_html .content input{width:350px;}
    #<?php echo $module['module_name'];?>_html #web__description{width:345px; margin-top:15px; border-radius:3px; border:1px solid #CCC; line-height: 24px; min-height:120px;}
    #<?php echo $module['module_name'];?>_html #web__diy_meta{width:345px; margin-top:15px; border-radius:3px; border:1px solid #CCC;line-height: 24px;}
	#<?php echo $module['module_name'];?>_html #sms__disable_phrase{width:345px; margin-top:15px; border-radius:3px; border:1px solid #CCC;}
	#<?php echo $module['module_name'];?>_table .odd{ }
	#<?php echo $module['module_name'];?>_table .even{ }
	#<?php echo $module['module_name'];?>_html .a_over{ }
	#<?php echo $module['module_name'];?>_html #image_mark__water_logo_file{ border:none;}
	#<?php echo $module['module_name'];?>_html #image_mark__ttf_path_file{ border:none;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    <div id=update_url style="display:none;" ></div>
    <?php echo $module['list'];?>
    </div>

</div>