<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		if(get_param('geo')=='' && getCookie('geo')==''){
			if (navigator.geolocation){navigator.geolocation.getCurrentPosition(showPosition);}
			function showPosition(position){
				latitude=position.coords.latitude;
				longitude=position.coords.longitude;
				v0=latitude+','+longitude;
				userAgent=window.navigator.userAgent;
				if(userAgent.indexOf('baidu')==-1){
					latitude=position.coords.latitude+<?php echo $module['gps_y']?>;
					longitude=position.coords.longitude+<?php echo $module['gps_x']?>;
				}
				
				v=latitude+','+longitude;
				setCookie('geo',v,300);
				window.location.href='./index.php?monxin=mall.shop_list&tag='+get_param('tag')+'&geo='+v;
			  
			}
		}else{
			user_geo=getCookie('geo');
			if(get_param('geo')!=''){user_geo=get_param('geo');}
			
			$("#<?php echo $module['module_name'];?>  .navigate").each(function(index, element) {
                //
				
				if('<?php echo $module['map_api']?>'=='baidumap'){
					$(this).attr('href','http://api.map.baidu.com/direction?origin=latlng:'+user_geo+'|name:我的位置&destination=latlng:'+$(this).attr('destination')+'|name:'+$(this).parent().parent().children('.name').html()+'&mode=driving&region='+$(this).parent().parent().children('.name').html()+'&output=html&src=yourCompanyName|yourAppName');
				}else{
					$(this).attr('href','https://www.google.com/maps/dir/'+user_geo+'/'+$(this).attr('destination'));
				}
			
				
            });	
		}
		
		
		$("#<?php echo $module['module_name'];?>  .navigate").click(function(){
			if($(this).attr('href')=='#'){$(this).attr('href',$(this).parent().parent().children('.name').attr('href'));}
				
		});
		
		$("#<?php echo $module['module_name'];?> .phone_filter div").click(function(){
			$("#<?php echo $module['module_name'];?> .phone_filter div").removeClass('c');
			if($("#<?php echo $module['module_name'];?> [filter='"+$(this).attr('class')+"']").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> [filter]").css('display','none');
				$("#<?php echo $module['module_name'];?> [filter='"+$(this).attr('class')+"']").css('display','block');
				$(this).addClass('c');
			}else{
				
				$("#<?php echo $module['module_name'];?> [filter='"+$(this).attr('class')+"']").css('display','none');
			}
			
			return false;	
		});
		
		$("#<?php echo $module['module_name'];?>_html .tag_list a").click(function(){
			url=window.location.href;
			url=replace_get(url,'tag',$(this).attr('tag'));
			window.location.href=url;
			return false;
		});
		
		$("#<?php echo $module['module_name'];?>_html .near_div a").click(function(){
			if($(this).attr('near')=='100'){window.location.href='./index.php?monxin=mall.shop_map';return false;}
			url=window.location.href;
			url=replace_get(url,'near',$(this).attr('near'));
			window.location.href=url;
			return false;
		});
		
		tag=get_param('tag');
		if(tag==''){tag=0;}
		$("#<?php echo $module['module_name'];?> .tag_list a[tag='"+tag+"']").addClass('c');
		$("#<?php echo $module['module_name'];?> .tag_icon a[tag='"+tag+"']").addClass('current');
		$("#<?php echo $module['module_name'];?> .phone_filter .tag span").html($("#<?php echo $module['module_name'];?> .tag_list a[tag='"+tag+"']").html());

		near=get_param('near');
		if(near==''){near=<?php echo $module['near_default'];?>;}
		$("#<?php echo $module['module_name'];?> .near_div a[near='"+near+"']").addClass('c');
		$("#<?php echo $module['module_name'];?> .phone_filter .near span").html($("#<?php echo $module['module_name'];?> .near_div a[near='"+near+"']").html());

		$("#<?php echo $module['module_name'];?> .circle_2 div").hover(function(){
			$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a[circle="+$(this).attr('upid')+"]").addClass('show_sub');	
		});
		
		$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_list a[circle]").click(function(){
			if($("#<?php echo $module['module_name'];?> [upid="+$(this).attr('circle')+"]").html()){
				//alert($("#<?php echo $module['module_name'];?> [upid="+$(this).attr('circle')+"]").css('display'));
				if($("#<?php echo $module['module_name'];?> [upid="+$(this).attr('circle')+"]").css('display')=='none'){
					$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a").removeClass('show_sub');
					$("#<?php echo $module['module_name'];?> .circle_2 div").css('display','none');
					$("#<?php echo $module['module_name'];?> .circle_2 div[upid="+$(this).attr('circle')+"]").css('display','block');
					return false;
				}	
			}
			setCookie('circle',$(this).attr('circle'),30);	
			url=window.location.href;
			url=replace_get(url,'circle',$(this).attr('circle'));
			window.location.href=url;
			return false;
		});
		
		circle=get_param('circle');
		if(circle==''){circle=getCookie('circle');}
		$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").addClass('c');
		$("#<?php echo $module['module_name'];?> .phone_filter .circle span").html($("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").html());
		
		if($("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().attr('upid')){
			$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().css('display','block');
			$("#<?php echo $module['module_name'];?> a[circle='"+$("#<?php echo $module['module_name'];?> a[circle='"+circle+"']").parent().attr('upid')+"']").addClass('show_sub');
		}
		
		
		$("#<?php echo $module['module_name'];?> .data_state").each(function(index, element) {
            $(this).val($(this).attr('monxin_value'));
        });
		
		
        var get_search=get_param('search');
        if(get_search.length<1){
            var state=get_param('state');
            if(state!=''){$("#state_filter").prop("value",state);}
        }
        
		var area_province=get_param('area_province');
		if(area_province!=''){$("#area_province").prop('value',area_province);}
		var area_city=get_param('area_city');
		if(area_city!=''){$("#area_city").prop('value',area_city);}
		var area_county=get_param('area_county');
		if(area_county!=''){$("#area_county").prop('value',area_county);}
		var area_twon=get_param('area_twon');
		if(area_twon!=''){$("#area_twon").prop('value',area_twon);}
		var area_village=get_param('area_village');
		if(area_village!=''){$("#area_village").prop('value',area_village);}
		var area_group=get_param('area_group');
		if(area_group!=''){$("#area_group").prop('value',area_group);}
		
		
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
		
		$("#<?php echo $module['module_name'];?> .phone_filter .area span").html($("#<?php echo $module['module_name'];?> option[value='"+$("#<?php echo $module['module_name'];?> .area_div select:last").val()+"']").html());
		if($("#<?php echo $module['module_name'];?> .phone_filter .area span").html()=='<?php echo self::$language['all']?>'){
			$("#<?php echo $module['module_name'];?> .phone_filter .area span").html($("#<?php echo $module['module_name'];?> option[value='"+$("#<?php echo $module['module_name'];?> .area_div select:last").prev().val()+"']").html());
		}
		
		$("#<?php echo $module['module_name'];?> .satisfaction").each(function(index, element) {
            v=Math.ceil(parseFloat($(this).attr('value'))/10);
			$(this).addClass('satisfaction_'+v);
        });
    });
    
    function monxin_table_filter(id){
            if($("#"+id).prop("value")!=-1){
                key=id.replace("_filter","");
                url=window.location.href;
                url=replace_get(url,key,$("#"+id).prop("value"));
                if(key!="search"){url=replace_get(url,"search","");}
				if(key=='area_province'){url=replace_get(url,"area_city","");url=replace_get(url,"area_county","");url=replace_get(url,"area_twon","");url=replace_get(url,"area_village","");url=replace_get(url,"area_group","");}
				if(key=='area_city'){url=replace_get(url,"area_county","");url=replace_get(url,"area_twon","");url=replace_get(url,"area_village","");url=replace_get(url,"area_group","");}
				if(key=='area_county'){url=replace_get(url,"area_twon","");url=replace_get(url,"area_village","");url=replace_get(url,"area_group","");}
				if(key=='area_twon'){url=replace_get(url,"area_village","");url=replace_get(url,"area_group","");}
				if(key=='area_village'){url=replace_get(url,"area_group","");}

                window.location.href=url;	
            }
    }
    </script>
    <style>
    #<?php echo $module['module_name'];?>{ background:<?php echo $_POST['monxin_user_color_set']['container']['background']?>;}	
	#<?php echo $module['module_name'];?>_html .filter{padding: 0.5rem; display:block; width:100%; background:#fff;}
	#<?php echo $module['module_name'];?>_html [monxin-table] .filter .m_label{ margin-left:100px; display:inline-block; vertical-align:top; margin-top:3px;}
	#<?php echo $module['module_name'];?>_html  #search_filter{width:280px;}
	#<?php echo $module['module_name'];?>_html .area_div{}
	#<?php echo $module['module_name'];?>_html .shop_div{ margin-top: 1rem;margin-bottom: 1rem;padding: 0.5rem; display:block; width:100%; background:#fff;}	
	#<?php echo $module['module_name'];?>_html .shop_div .info{ display:block; white-space:nowrap; font-size:0.9rem; border-bottom:1px dashed #ccc;  margin-bottom:0.5rem;}	
	#<?php echo $module['module_name'];?>_html .shop_div .info .icon{display:inline-block; vertical-align:top; width:20%; overflow:hidden;  text-align:center; }
	#<?php echo $module['module_name'];?>_html .shop_div .info .icon:hover{ opacity:0.7;}
	#<?php echo $module['module_name'];?>_html .shop_div .info .icon img{ width:58px; height:58px;border:none; border-radius:29px; border:1px solid #ccc;}
	#<?php echo $module['module_name'];?>_html .shop_div .info .other{display:inline-block; vertical-align:top;  width:80%; overflow:hidden; line-height:20px; }
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .name{ font-weight:bold; font-size:1rem; }
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .name .distance{ float:right; font-weight:normal; padding-right:0.5rem;}	
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .sum{ display:none;}
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .m_label{ display:inline-block; vertical-align: top; width:12%; overflow:hidden;  }
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .area{ white-space:nowrap;}
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .area .address{display:inline-block; vertical-align: top; width:83%; overflow:hidden;    text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .area .address:before{font: normal normal normal 14px/1 FontAwesome;margin-right: 5px; content: '\f041';}
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .area .distance{display:inline-block; vertical-align: top; width:15%;  text-align:left; background:#FF9900; color:#fff !important; border-radius:3px; padding-left:3px; padding-right:3px;}
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .main_business{ white-space:nowrap;overflow:hidden;  text-overflow: ellipsis; height:1.3rem;width:100%;}
	#<?php echo $module['module_name'];?>_html .shop_div .goods{ display:block;}	
	#<?php echo $module['module_name'];?>_html .shop_div .goods a{ display:inline-block; vertical-align:top; width:23%; text-align:center;  margin-right:2%;}	
	#<?php echo $module['module_name'];?>_html .shop_div .goods a:hover{ opacity:0.7;}
	#<?php echo $module['module_name'];?>_html .shop_div .goods a img{ width:90%;border:none;}	
	
	#<?php echo $module['module_name'];?>_html .phone_filter{  white-space:nowrap; margin-bottom:0.5rem; line-height:2rem; display:none;}
	#<?php echo $module['module_name'];?>_html .phone_filter div{ display:inline-block; vertical-align:top; width:33%; overflow:hidden; }
	#<?php echo $module['module_name'];?>_html .phone_filter .c{ border-bottom:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> 2px solid;}	
	#<?php echo $module['module_name'];?>_html .phone_filter .circle{ text-align:center;}
	#<?php echo $module['module_name'];?>_html .phone_filter .area{ text-align:right;}
	#<?php echo $module['module_name'];?>_html .phone_filter div span{}
	#<?php echo $module['module_name'];?>_html .phone_filter div:after {font: normal normal normal 18px/1 FontAwesome;margin-left: 5px;content:"\f107";
}
	
	
	#<?php echo $module['module_name'];?>_html .tag_div{ display:none; padding-bottom:1rem; line-height:2rem; }
	#<?php echo $module['module_name'];?>_html .circle_filter{display:none; line-height:2rem;  }
	#<?php echo $module['module_name'];?>_html .c_label{ display:none;}
	#<?php echo $module['module_name'];?>_html .tag_list{}
	#<?php echo $module['module_name'];?>_html .tag_list a{  display:inline-block; vertical-align:top;  width:19%; text-align:center; margin-right:1%;white-space:nowrap; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .tag_list .c{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;  }
	#<?php echo $module['module_name'];?>_html .tag_list a:hover{  }
	
	
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list{ text-align:center;}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1{}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a{ display:inline-block; vertical-align:top;  width:19%; text-align:center; margin-right:1%;white-space:nowrap; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 .c{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;  }
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 .show_sub{ border-bottom:2px <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> solid;}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a:hover{  }
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2{}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 { margin-top:0.5rem; height:2rem; line-height:2rem;}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div{ display:none; }
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div a{ display:inline-block; vertical-align:top;  width:19%; margin-right:1%; text-align:center; white-space:nowrap; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div a:hover{  }
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div .c{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	
	#<?php echo $module['module_name'];?>_html .near_div { display:none; float:right; width:35%;}
	#<?php echo $module['module_name'];?>_html .near_div a{ display:block;padding-left:0.5rem;}
	#<?php echo $module['module_name'];?>_html .near_div a:hover{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; opacity:0.7;}
	#<?php echo $module['module_name'];?>_html .near_div .c{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;  }
	
	#<?php echo $module['module_name'];?> .tag_icon{}
	#<?php echo $module['module_name'];?> .tag_icon a{ text-align:center; display:inline-block; vertical-align:top; width:18%; margin:1%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .tag_icon a img{ width:60%;}
	#<?php echo $module['module_name'];?> .tag_icon a span{ display:block;font-size:0.9rem; white-space:nowrap;}
	#<?php echo $module['module_name'];?> .tag_icon .current{ border-bottom:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	
	#<?php echo $module['module_name'];?>_html .navigate .m_label{ display:none !important;}
	.address
	/*#<?php echo $module['module_name'];?>_html .near_div a[near='100']{ display:none;}*/
	.filter{ background:#fff;}
	
	#<?php echo $module['module_name'];?> .satisfaction{white-space:normal;}
	
	
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
    <div class="filter">
        <div class=phone_filter>
            <div class=tag><?php echo self::$language['tag']?>:<span>xx</span></div><div class=circle><?php echo self::$language['circle']?>:<span>cc</span></div><div class=near><?php echo self::$language['near']?>:<span>near</span></div>
        </div>	
    	<div class=tag_div filter=tag><div class=c_label><?php echo self::$language['tag']?>:</div><div class=tag_list><?php echo $module['tag'];?></div></div>
        <div class=circle_filter filter=circle style="display:none;">
            <div class=c_label><?php echo self::$language['circle']?>:</div><div class=circle_list>
                <div class=circle_1><?php $module['circle_list'];?></div>
                <div class=circle_2><?php  $module['circle_list_sub'];?></div>
            </div>
        </div>
        
        <div class=near_div filter=near><?php echo $module['near_option']?></div>
    	 <input type="text" name="search_filter" id="search_filter" value="<?php echo @$_GET['search']?>" placeholder="<?php echo self::$language['shop_name']?>/<?php echo self::$language['main_business']?>/<?php echo self::$language['phone']?>" style="display:none;" />
        <div class=tag_icon><?php echo $module['tag_icon'];?></div>
    	 
    </div>
    <?php echo $module['list']?>
    
    <?php echo $module['page']?>
    </div>
    </div>

</div>