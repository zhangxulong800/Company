<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		user_geo='<?php echo $module['my_latlng'];?>';
			$("#<?php echo $module['module_name'];?>  .navigate").each(function(index, element) {
				if('<?php echo $module['map_api']?>'=='baidumap'){
					$(this).attr('href','http://api.map.baidu.com/direction?origin=latlng:'+user_geo+'|name:我的位置&destination=latlng:'+$(this).attr('destination')+'|name:'+$(this).parent().parent().children('.name').html()+'&mode=driving&region='+$(this).parent().parent().children('.name').html()+'&output=html&src=yourCompanyName|yourAppName');
				}else{
					$(this).attr('href','https://www.google.com/maps/dir/'+user_geo+'/'+$(this).attr('destination'));
				}
                
            });	
		
		$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a").hover(function(){
			$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a").removeClass('show_sub');
			$("#<?php echo $module['module_name'];?> .circle_2 div").css('display','none');
			$("#<?php echo $module['module_name'];?> .circle_2 div[upid="+$(this).attr('circle')+"]").css('display','block');
		});
		$("#<?php echo $module['module_name'];?> .circle_2 div").hover(function(){
			$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a[circle="+$(this).attr('upid')+"]").addClass('show_sub');	
		});
		
		$("#<?php echo $module['module_name'];?>_html .circle_filter .circle_list a[circle]").click(function(){
			url=window.location.href;
			url=replace_get(url,'circle',$(this).attr('circle'));
			window.location.href=url;
			//window.location.href='./index.php?monxin=mall.shop_list&circle='+$(this).attr('circle');
			return false;
		});
		
		$("#<?php echo $module['module_name'];?>_html .tag_list a").click(function(){
			url=window.location.href;
			url=replace_get(url,'tag',$(this).attr('tag'));
			window.location.href=url;
			return false;
		});
		tag=get_param('tag');
		if(tag==''){tag=0;}
		$("#<?php echo $module['module_name'];?> .tag_list a[tag='"+tag+"']").addClass('c');
		$("#<?php echo $module['module_name'];?> .tag_icon a[tag='"+tag+"']").addClass('current');

		circle=get_param('circle');
		if(circle==''){circle=getCookie('circle');}
		$("#<?php echo $module['module_name'];?>  .circle_filter .circle_list a[circle='"+circle+"']").addClass('c');
		
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
		
		$("#shop_goods_search .current_v").html('<?php echo self::$language['shop']?>');
		$("#shop_goods_search .current_v").attr('v','mall.shop_list>');
		
		
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
    #<?php echo $module['module_name'];?>{ padding-top:0px;}	
	#<?php echo $module['module_name'];?>_html [monxin-table] .filter{}
	#<?php echo $module['module_name'];?>_html [monxin-table] .filter .m_label{ margin-left:100px; display:inline-block; vertical-align:top; margin-top:3px;}
	#<?php echo $module['module_name'];?>_html  #search_filter{width:300px;}
	.area_div{ float:right; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .shop_div{ padding-bottom:1rem;margin-top:1rem; height:10rem; overflow:hidden; white-space:nowrap; border-bottom:1px dashed #CCCCCC;}	
	#<?php echo $module['module_name'];?>_html .shop_div .info{ display:inline-block; vertical-align:top; width:35%; overflow:hidden; white-space:nowrap; background:rgba(241,241,241,1);}	
	#<?php echo $module['module_name'];?>_html .shop_div .info .icon{display:inline-block; vertical-align:top; width:35%; overflow:hidden; border:solid  #F5F5F5 1px; text-align:center; }
	#<?php echo $module['module_name'];?>_html .shop_div .info .icon:hover{ opacity:0.7;}
	#<?php echo $module['module_name'];?>_html .shop_div .info .icon img{ width:86px; height:86px;border:none; margin-top:1.2rem;margin-bottom:1.2rem; border-radius:50%;}
	#<?php echo $module['module_name'];?>_html .shop_div .info .other{display:inline-block; vertical-align:top; padding-left:10px; width:63%; overflow:hidden; line-height:2rem;}
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .name{ font-weight:bold; }
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .sum{}
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .m_label{ }
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .area{width:100%; overflow:hidden;    text-overflow: ellipsis;}
	#<?php echo $module['module_name'];?>_html .shop_div .info .other .main_business{ white-space:nowrap; overflow:hidden; text-overflow: ellipsis; height:30px;width:100%;}
	#<?php echo $module['module_name'];?>_html .shop_div .goods{ display:inline-block; vertical-align:top; width:64%; padding-left:1%; overflow:hidden; white-space:nowrap;}	
	#<?php echo $module['module_name'];?>_html .shop_div .goods a{ display:inline-block; vertical-align:top; width:18%; text-align:center;  border:solid  #F5F5F5 1px; margin-right:2%;}	
	#<?php echo $module['module_name'];?>_html .shop_div .goods a:hover{ opacity:0.7;}
	#<?php echo $module['module_name'];?>_html .shop_div .goods a img{ width:90%;border:none;}	
	
	#<?php echo $module['module_name'];?>_html .tag_div{ margin-bottom:1rem; line-height:2rem;}
	#<?php echo $module['module_name'];?>_html .circle_filter{ line-height:2rem; }
	#<?php echo $module['module_name'];?>_html .c_label{ display:inline-block; vertical-align:top; width:5%; overflow:hidden; text-align:right;   padding-right:1%; white-space:nowrap; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .tag_list{display:inline-block; vertical-align:top; width:93%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .tag_list a{ display:inline-block; vertical-align:top;  width:5%; text-align:center; margin-right:1%; white-space:nowrap; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .tag_list .c{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>;   }
	#<?php echo $module['module_name'];?>_html .tag_list a:hover{ background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>; }
	
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list{display:inline-block; vertical-align:top; width:93%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1{}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a{ display:inline-block; vertical-align:top;  width:5%; text-align:center; margin-right:1%; white-space:nowrap; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 .c{  background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 .show_sub{ border-bottom:2px <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?> solid;}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_1 a:hover{background:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_2_hover']['text']?>;  }
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2{}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 { margin-top:0.5rem; height:2rem; line-height:2rem;}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div{ display:none; }
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div a{ display:inline-block; vertical-align:top;  width:5%; margin-right:1%; text-align:center;  white-space:nowrap; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div a:hover{background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; opacity:0.8;  }
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div .c{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
	
	#<?php echo $module['module_name'];?>_html .shop_div .info .navigate:before{font: normal normal normal 14px/1 FontAwesome;margin-right: 5px; content: '\f041'; opacity:0.6;}
	
	#<?php echo $module['module_name'];?> .tag_icon{ border-bottom:1px solid #ccc;}
	#<?php echo $module['module_name'];?> .tag_icon a{ text-align:center; display:inline-block; vertical-align:top; width:6%; margin:1%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .tag_icon a img{ width:60%;}
	#<?php echo $module['module_name'];?> .tag_icon a span{ display:block;font-size:0.9rem; white-space:nowrap;}
	#<?php echo $module['module_name'];?> .tag_icon .current{ border-bottom:2px solid <?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>;}
	
	#<?php echo $module['module_name'];?> .satisfaction{ font-size:0.9rem;}
	#<?php echo $module['module_name'];?> .shop_div .info .other .name .shop_credits_rate{ font-size:0.9rem; font-weight:normal;}
    </style>
	<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>

    <div class=tag_icon><?php echo $module['tag_icon'];?></div>
    <div class="filter">
    	 <input type="text" name="search_filter" id="search_filter" style="display:none;" value="<?php echo @$_GET['search']?>" placeholder="<?php echo self::$language['shop_name']?>/<?php echo self::$language['main_business']?>/<?php echo self::$language['phone']?>" />
        
    </div>
    <?php echo $module['list']?>
    
    <?php echo $module['page']?>
    </div>
    </div>

</div>