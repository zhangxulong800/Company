<div id=<?php echo $module['module_name'];?>  class="" monxin-module="<?php echo $module['module_name'];?>" align=left >
<script src="./plugin/datePicker/index.php"></script>
	<script>
    $(document).ready(function(){
		enter_to_tab();
        $("#<?php echo $module['module_name'];?>_html .up_img").each(function(i,e){
            $(e).error(function(){$(e).attr("src","./<?php echo get_template_dir(__FILE__);?>img/defualt.png");});
            //monxin_alert(this.fileSize);
            if(this.fileSize<=0){this.src="./<?php echo get_template_dir(__FILE__);?>img/defualt.png";}
        });
		if(''=='<?php echo $module['icon']?>'){$("#<?php echo $module['module_name'];?>_html #tr_icon .up_img").attr("src","./<?php echo get_template_dir(__FILE__);?>img/defualt.png");}
		if(''=='<?php echo $module['banner']?>'){$("#<?php echo $module['module_name'];?>_html #tr_banner .up_img").attr("src","./<?php echo get_template_dir(__FILE__);?>img/defualt.png");}
		if(''=='<?php echo $module['license_photo_front']?>'){$("#<?php echo $module['module_name'];?>_html #tr_license_photo_front .up_img").attr("src","./<?php echo get_template_dir(__FILE__);?>img/defualt.png");}
		if(''=='<?php echo $module['license_photo_reverse']?>'){$("#<?php echo $module['module_name'];?>_html #tr_license_photo_reverse .up_img").attr("src","./<?php echo get_template_dir(__FILE__);?>img/defualt.png");}
		
        $('#icon_ele').insertBefore($('#icon_state'));
        $('#banner_ele').insertBefore($('#banner_state'));
        $('#license_photo_front_ele').insertBefore($('#license_photo_front_state'));
        $('#license_photo_reverse_ele').insertBefore($('#license_photo_reverse_state'));
               
        $("input[type='text']").blur(function(){
            //monxin_alert(this.id);
            	
            json="{'"+this.id+"':'"+replace_quot(this.value)+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&update='+this.id,json,function(){
				//monxin_alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}

                    $(this).html(v.info);
					if(v.state=='success' && get_param('field')!=''){alert('<?php echo self::$language['success']?>');window.location.href='./index.php?monxin=index.user';return false;}
                    if(v.state=='fail'){}else{}
                }
            });
        });
        
  //       $("input[type='password']").focus(function(){
  //          $(this).css('background','#F00');	
  //      });
        $("input[type='password']").blur(function(){
            //monxin_alert(this.id);
            $(this).css('background','');	
            json="{'"+this.id+"':'"+replace_quot(this.value)+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&update='+this.id,json,function(){			
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
                    $(this).html(v.info);
                }
            });
        });
        
        
        
        $("#edit_user_form tr").css('display','none');
        $("#update_password tr").css('display','block');
        $("#update_transaction_password tr").css('display','block');
        field=get_param('field').split("|");
        for(var v in field){
            $("#tr_"+field[v]).css('display','block');
        }
        //monxin_alert(field);
        if(field==''){
			$("#tr_introducer").remove();
            $("#edit_user_form tr").css('display','block');
			$("#edit_user_form #tr_manager").css('display','none');
        }else{
			if(field!='password' && field!='transaction_password'){
				document.title='<?php echo self::$language['require_info']?>';	
				$("#user_position .text").html('<?php echo self::$language['require_info']?>');
			}
        }
        if(field!='transaction_password'){$("#tr_transaction_password").css("display","none");}else{
			document.title='<?php echo self::$language['modify_transaction_password']?>';
			$("#user_position .text").html('<?php echo self::$language['modify_transaction_password']?>');
		}
        if(field!='password'){$("#tr_password").css("display","none");}else{
			document.title='<?php echo self::$language['modify_password']?>';
			$("#user_position .text").html('<?php echo self::$language['modify_password']?>');	
		}
		if('<?php echo $module['password']?>'==''){$("#old_password_td").css('display','none');}
		
		var user_field='<?php echo $module['user_field']?>';
		$("#edit_user_form > table > tr").each(function(index, element) {
			id=$(this).attr('id');
			if(id){
				 key=','+id.replace('tr_','')+',';
				 if(user_field.indexOf(key)==-1){
					 $(this).css('display','none !important');
					 $(this).remove();
				}
			}
        });
    
    });
    
    function update_password(){
        old_password=document.getElementById("old_password");
        new_password=document.getElementById("new_password");
        confirm_new_password=document.getElementById("confirm_new_password");
        //if(old_password.value.length<6){$("#old_password_state").html('<?php echo self::$language['less_six'];?>');$("#old_password").focus();return false}
        if(new_password.value.length<6){$("#new_password_state").html('<?php echo self::$language['less_six'];?>');$("#new_password").focus();return false}
        if(confirm_new_password.value.length<6){$("#confirm_new_password_state").html('<?php echo self::$language['less_six'];?>');$("#confirm_new_password").focus();return false}
        if(new_password.value!=confirm_new_password.value){$("#confirm_new_password_state").html('<?php echo self::$language['twice_password_not_same'];?>');$("#confirm_new_password").focus();return false}
        if(new_password.value==old_password.value){$("#new_password_state").html('<?php echo self::$language['password_new_equal_old'];?>');$("#new_password").focus();return false}
        json="{'"+old_password.id+"':'"+old_password.value+"','"+new_password.id+"':'"+new_password.value+"','"+confirm_new_password.id+"':'"+confirm_new_password.value+"'}";
        try{json=eval("("+json+")");}catch(exception){alert(json);}
        $("#update_password_state").html("<span class='fa fa-spinner fa-spin'></span>");
        $("#update_password_state").load('<?php echo $module['action_url'];?>&update=password',json,function(){
            if($(this).html().length>10){
                try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
				
                $(this).html(v.info);
                if(v.state=='success'){$("#update_password .submit_button").css("display","none");}
            }
        });
        
    
    }
    
    function update_transaction_password(){
        old_transaction_password=document.getElementById("old_transaction_password");
        new_transaction_password=document.getElementById("new_transaction_password");
        confirm_new_transaction_password=document.getElementById("confirm_new_transaction_password");
        //if(old_transaction_password.value.length<6){$("#old_transaction_password_state").html('<?php echo self::$language['less_six'];?>');$("#old_transaction_password").focus();return false;}
        if(new_transaction_password.value.length<6){$("#new_transaction_password_state").html('<?php echo self::$language['less_six'];?>');$("#new_transaction_password").focus();return false;}
        if(confirm_new_transaction_password.value.length<6){$("#confirm_new_transaction_password_state").html('<?php echo self::$language['less_six'];?>');$("#confirm_new_transaction_password").focus();return false;}
        if(new_transaction_password.value!=confirm_new_transaction_password.value){$("#confirm_new_transaction_password_state").html('<?php echo self::$language['twice_password_not_same'];?>');$("#confirm_new_transaction_password").focus();return false;}
        if(new_transaction_password.value==old_transaction_password.value){$("#new_transaction_password_state").html('<?php echo self::$language['transaction_password_new_equal_old'];?>');$("#new_transaction_password").focus();return false;}
        json="{'"+old_transaction_password.id+"':'"+old_transaction_password.value+"','"+new_transaction_password.id+"':'"+new_transaction_password.value+"','"+confirm_new_transaction_password.id+"':'"+confirm_new_transaction_password.value+"'}";
        try{json=eval("("+json+")");}catch(exception){alert(json);}
        $("#update_transaction_password_state").html("<span class='fa fa-spinner fa-spin'></span>");
        $("#update_transaction_password_state").load('<?php echo $module['action_url'];?>&update=transaction_password',json,function(){
            if($(this).html().length>10){
                try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
				
                $(this).html(v.info);
                if(v.state=='success'){$("#update_transaction_password .submit_button").css("display","none");}
            }
        });
        
    
    }
    function add_transaction_password(){
        new_transaction_password=document.getElementById("new_transaction_password");
        confirm_new_transaction_password=document.getElementById("confirm_new_transaction_password");
        if(new_transaction_password.value.length<6){$("#new_transaction_password_state").html('<?php echo self::$language['less_six'];?>');}
        if(confirm_new_transaction_password.value.length<6){$("#confirm_new_transaction_password_state").html('<?php echo self::$language['less_six'];?>');}
        if(new_transaction_password.value!=confirm_new_transaction_password.value){$("#confirm_new_transaction_password_state").html('<?php echo self::$language['twice_password_not_same'];?>');}
        json="{'"+new_transaction_password.id+"':'"+new_transaction_password.value+"','"+confirm_new_transaction_password.id+"':'"+confirm_new_transaction_password.value+"'}";
        try{json=eval("("+json+")");}catch(exception){alert(json);}
        $("#update_transaction_password_state").html("<span class='fa fa-spinner fa-spin'></span>");
        $("#update_transaction_password_state").load('<?php echo $module['action_url'];?>&update=add_transaction_password',json,function(){
            if($(this).html().length>10){
                try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
				
                $(this).html(v.info);
				if(v.state=='success'){alert('<?php echo self::$language['success']?>');window.location.href='./index.php?monxin=index.user';}
                if(v.state=='success'){$("#update_transaction_password .submit_button").css("display","none");}
            }
        });
        
    
    }
    
    
    
    function submit_hidden(id){
        //monxin_alert(id);
        obj=document.getElementById(id);
		//monxin_alert(obj.value);
        if(obj.value==''){}
        json="{'"+obj.id+"':'"+replace_quot(obj.value)+"'}";
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
	 #<?php echo $module['module_name'];?>{  background-color:#fff !important; }
    #<?php echo $module['module_name'];?>_html{line-height:40px;padding-bottom:3rem;} 
    #<?php echo $module['module_name'];?>_html #index_edit_user{ }
    #<?php echo $module['module_name'];?>_html #username_state{ display:inline-block; width:500px; margin-left:8px;}
    #<?php echo $module['module_name'];?>_html input{ margin-left:8px; width:250px; height:30px; line-height:30px; margin-bottom:10px; margin-top:10px; padding-left:5px;}
    #<?php echo $module['module_name'];?>_html select{ margin-left:8px; height:30px; line-height:30px; margin-bottom:10px; margin-top:10px;}
    #<?php echo $module['module_name'];?>_html #icon_img{ margin-left:8px;}
    #<?php echo $module['module_name'];?>_html .input_text{width:200px; height:30px;}
    #<?php echo $module['module_name'];?>_html #license_photo_front_img{ margin-left:8px;}
    #<?php echo $module['module_name'];?>_html #license_photo_reverse_img{ margin-left:8px;}
	#<?php echo $module['module_name'];?>_html #old_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #new_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #confirm_new_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #old_transaction_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #new_transaction_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #confirm_new_transaction_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #old_transaction_password_state{ font-size:1rem; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #find_transaction_password{ font-size:1rem;  line-height:30px;}
    #<?php echo $module['module_name'];?>_html .m_label{width:200px; text-align:right; font-size:1rem;}
	#<?php echo $module['module_name'];?>_html .submit_button{ margin-left:5px; margin-top:10px;}
	#<?php echo $module['module_name'];?>_html #icon_file{ border:none;}
	#<?php echo $module['module_name'];?>_html #license_photo_front_file{ border:none;}
	#<?php echo $module['module_name'];?>_html #license_photo_reverse_file{ border:none;}
	#<?php echo $module['module_name'];?>_table .odd{ }
	#<?php echo $module['module_name'];?>_table .even{ }

	

    </style>
    <div id="<?php echo $module['module_name'];?>_html" >
    <form id="edit_user_form" name="edit_user_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    <table border="0" cellpadding="0" cellspacing="0" id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left _table style="width:100%;">
    <tr id="tr_manager"><td class="m_label"><?php echo self::$language['manager']?></td><td align="left"><input type="text" id="manager" name="manager" value="" placeholder="<?php echo self::$language['please_input']?><?php echo self::$language['manager']?><?php echo self::$language['real_name']?>" /><span id="manager_state"></span></td></tr>
    <tr id="tr_username"><td class="m_label"><?php echo self::$language['username']?></td><td align="left"><span id="username_state"><?php echo $module['username']?></span></td></tr>
    
    <tr id="tr_nickname"><td class="m_label"><?php echo self::$language['nickname']?></td><td align="left"><input type="text" id="nickname" name="nickname" value="<?php echo $module['nickname']?>" /><span id="nickname_state"></span></td></tr>
    <tr id="tr_icon"><td class="m_label"><?php echo self::$language['icon']?></td><td align="left" id="tr_td_icon">
    <img id="icon_img" class="up_img" src="./program/index/user_icon/<?php echo $module['icon']?>" width="150"><br />
    <span id="icon_state"></span></td></tr>
    
    <tr id="tr_banner"><td class="m_label"><?php echo self::$language['banner']?></td><td align="left" id="tr_td_banner">
    <img id="banner_img" class="up_img" src="./program/index/user_banner/<?php echo $module['banner']?>" height="100"><br />
    <span id="banner_state"></span></td></tr>
    
    <tr id="tr_tel"><td class="m_label"><?php echo self::$language['tel']?></td><td align="left"><input type="text" id="tel" name="tel" value="<?php echo $module['tel']?>" /><span id="tel_state"></span></td></tr>
    <tr id="tr_address"><td class="m_label"><?php echo self::$language['address']?></td><td align="left"><input type="text" id="address" name="address" value="<?php echo $module['address']?>" /><span id="address_state"></span></td></tr>
    <tr id="tr_chat_type"><td class="m_label"><?php echo self::$language['chat_type']?></td><td align="left"><select id="chat_type" name="chat_type" onchange="submit_hidden('chat_type')"><?php echo $module['chat_type']?></select><span id="chat_type_state"></span></td></tr>
    <tr id="tr_chat"><td class="m_label"><?php echo self::$language['chat']?></td><td align="left"><input type="text" id="chat" name="chat" value="<?php echo $module['chat']?>" /><span id="chat_state"></span></td></tr>
    
    <tr id="tr_home_area"><td class="m_label"><?php echo self::$language['home_area']?></td><td align="left"><input type="hidden" id="home_area" name="home_area" value="<?php echo $module['home_area']?>" />
    <script src="area_js.php?callback=set_area&input_id=home_area&id=<?php echo $module['home_area']?>&output=select" id='home_area_area_js'></script>
    <span id="home_area_state" ></span></td></tr>
    <tr id="tr_current_area"><td class="m_label"><?php echo self::$language['current_area']?></td><td align="left"><input type="hidden" id="current_area" name="current_area" value="<?php echo $module['current_area']?>" />
    <script src="area_js.php?callback=set_area&input_id=current_area&id=<?php echo $module['current_area']?>&output=select" id='current_area_area_js'></script>
    <span id="current_area_state" ></span></td></tr>
    <tr id="tr_birthday"><td class="m_label"><?php echo self::$language['birthday']?></td><td align="left">
    <input type="text" id="birthday" name="birthday" value="<?php echo $module['birthday'];?>"   onclick=show_datePicker(this.id,'date') onblur="hide_datePicker()"  />
   
    <span id="birthday_state"></span></td></tr>
    <tr id="tr_introducer" ><td class="m_label"><?php echo self::$language['introducer']?></td><td align="left"><input type="text" id="introducer" name="introducer" value="<?php echo $module['introducer']?>" placeholder="<?php echo self::$language['please_input'];?><?php echo self::$language['introducer']?><?php echo self::$language['phone'];?>" /><span id="introducer_state"></span></td></tr>
    <tr id="tr_real_name"><td class="m_label"><?php echo self::$language['real_name']?></td><td align="left"><input type="text" id="real_name" name="real_name" value="<?php echo $module['real_name']?>"  placeholder="<?php echo self::$language['the_future_cannot_be_modified'];?>"  style="width:666px;"  /><span id="real_name_state"></span></td></tr>
    <tr id="tr_license_type"><td class="m_label"><?php echo self::$language['license_type']?></td><td align="left"><select id="license_type" name="license_type" onchange="submit_hidden('license_type')"><?php echo $module['license_type']?></select><span id="license_type_state"></span></td></tr>
    <tr id="tr_license_id"><td class="m_label"><?php echo self::$language['license_id']?></td><td align="left"><input type="text" id="license_id" name="license_id" value="<?php echo $module['license_id']?>" /><span id="license_id_state"></span></td></tr>
    
    <tr id="tr_license_photo_front"><td class="m_label"><?php echo self::$language['license_photo_front']?></td><td align="left" id="tr_td_license_photo_front">
    <img id="license_photo_front_img" class="up_img" src="./program/index/user_license_photo_front/<?php echo $module['license_photo_front']?>" width="150"><br />
    <span id="license_photo_front_state"></span></td></tr>

    <tr id="tr_license_photo_reverse"><td class="m_label"><?php echo self::$language['license_photo_reverse']?></td><td align="left" id="tr_td_license_photo_reverse">
    <img id="license_photo_reverse_img" class="up_img" src="./program/index/user_license_photo_reverse/<?php echo $module['license_photo_reverse']?>" width="150"><br />
    <span id="license_photo_reverse_state"></span></td></tr>

    
    <tr id="tr_gender"><td class="m_label"><?php echo self::$language['gender']?></td><td align="left"><select id="gender" name="gender" onchange="submit_hidden('gender')"><?php echo $module['gender']?></select><span id="gender_state"></span></td></tr>
    <tr id="tr_blood_type"><td class="m_label"><?php echo self::$language['blood_type']?></td><td align="left"><select id="blood_type" name="blood_type" onchange="submit_hidden('blood_type')"><?php echo $module['blood_type']?></select><span id="blood_type_state"></span></td></tr>
    <tr id="tr_profession"><td class="m_label"><?php echo self::$language['profession']?></td><td align="left"><input type="text" id="profession" name="profession" value="<?php echo $module['profession']?>" /><span id="profession_state"></span></td></tr>
    <tr id="tr_education"><td class="m_label"><?php echo self::$language['education']?></td><td align="left"><select id="education" name="education" onchange="submit_hidden('education')"><?php echo $module['education']?></select><span id="education_state"></span></td></tr>
    <tr id="tr_height"><td class="m_label"><?php echo self::$language['height']?></td><td align="left"><input type="text" id="height" name="height" value="<?php echo $module['height']?>" /><span id="height_state"></span></td></tr>
    <tr id="tr_weight"><td class="m_label"><?php echo self::$language['weight']?></td><td align="left"><input type="text" id="weight" name="weight" value="<?php echo $module['weight']?>" /><span id="weight_state"></span></td></tr>
    <tr id="tr_married"><td class="m_label"><?php echo self::$language['married']?></td><td align="left"><select id="married" name="married" onchange="submit_hidden('married')"><?php echo $module['married']?></select><span id="married_state"></span></td></tr>
    <tr id="tr_annual_income"><td class="m_label"><?php echo self::$language['annual_income']?></td><td align="left"><select id="annual_income" name="annual_income" onchange="submit_hidden('annual_income')"><?php echo $module['annual_income']?></select><span id="annual_income_state"></span></td></tr>
    <tr id="tr_domain"><td class="m_label"><?php echo self::$language['domain']?></td><td align="left"><input type="text" id="domain" name="domain" value="<?php echo $module['domain']?>" style=" text-align:right;" /><?php echo $module['domain_postfix']?> <span id="domain_state"></span></td></tr>
    <tr id="tr_homepage"><td class="m_label"><?php echo self::$language['homepage']?></td><td align="left"><input type="text" id="homepage" name="homepage" value="<?php echo $module['homepage']?>" /><span id="homepage_state"></span></td></tr>
    <tr id="tr_chip"><td class="m_label"><?php echo self::$language['chip']?></td><td align="left"><input type="text" id="chip" name="chip" value="<?php echo $module['chip']?>" /><span id="chip_state"></span></td></tr>
    
    <tr id="tr_password"><td colspan="2">
        <table id="update_password">
        <tr id=old_password_td><td class="m_label"><?php echo self::$language['old_password']?></td><td align="left"><input type="password" id="old_password" name="old_password" value="" /><span id="old_password_state"></span></td></tr>
        <tr><td class="m_label"><?php echo self::$language['new_password']?></td><td align="left"><input type="password" id="new_password" name="new_password" value="" /><span id="new_password_state"></span></td></tr>
        <tr><td class="m_label"><?php echo self::$language['confirm']?><?php echo self::$language['new_password'];?></td><td align="left"><input type="password" id="confirm_new_password" name="confirm_new_password" value="" /><span id="confirm_new_password_state"></span></td></tr>
        <tr><td class="m_label">&nbsp;</td><td align="left"><a href="#"  class="submit_button"  user_color='button'  onclick="return update_password();"><?php echo self::$language['submit']?></a><span id="update_password_state"></span></td></tr>
        </table>
    
    </td></tr>
    
    
    <tr id="tr_transaction_password"><td colspan="2">
        <table id="update_transaction_password">
        <?php if($module['transaction_password']!=''){?>
        <tr><td class="m_label"><?php echo self::$language['old_transaction_password']?></td><td align="left"><input type="password" id="old_transaction_password" name="old_transaction_password" value="" /><span id="old_transaction_password_state"></span>  <a href="./index.php?monxin=index.resetPassword&field=transaction_password" id="find_transaction_password"><?php echo self::$language['get_password']?></a></td></tr>
        <?php }?>
        <tr><td class="m_label"><?php echo self::$language['new_transaction_password']?></td><td align="left"><input type="password" id="new_transaction_password" name="new_transaction_password" value="" /><span id="new_transaction_password_state"></span></td></tr>
        <tr><td class="m_label"><?php echo self::$language['confirm']?><?php echo self::$language['new_transaction_password'];?></td><td align="left"><input type="password" id="confirm_new_transaction_password" name="confirm_new_transaction_password" value="" /><span id="confirm_new_transaction_password_state"></span></td></tr>
        <tr><td class="m_label">&nbsp;</td><td align="left"><a href="#" class="submit_button"  user_color='button' onclick="return <?php echo $module['transaction_password_act']?>_transaction_password();"><?php echo self::$language['submit']?></a><span id="update_transaction_password_state"></span></td></tr>
        </table>
    
    </td></tr>
    
    
    </table>
    </form>
    <br />
    <br />
    <br />&nbsp;
    <br />
    </div>

</div>