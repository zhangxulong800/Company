<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		/*
		if(get_param('geo')==''){
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
				window.location.href='./index.php?monxin=mall.shop_map&geo='+v;
			  
			}
		}

		*/
		$(document).scrollTop($("#<?php echo $module['module_name'];?>").offset().top);
		
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
    #<?php echo $module['module_name'];?>{ padding-top:10px;}	
	#<?php echo $module['module_name'];?>_html{ }
	#<?php echo $module['module_name'];?>_html [monxin-table] .filter{}
	#<?php echo $module['module_name'];?>_html [monxin-table] .filter .m_label{ margin-left:100px; display:inline-block; vertical-align:top; margin-top:3px;}
	#<?php echo $module['module_name'];?>_html  #search_filter{width:300px;}
	.area_div{ float:right; padding-right:10px;}
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
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div a:hover{  }
	#<?php echo $module['module_name'];?>_html .circle_filter .circle_list .circle_2 div .c{ background:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['monxin_user_color_set']['nv_1_hover']['text']?>; }
    </style>
<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $module['map_secret'];?>"></script>

<style type="text/css">
	#<?php echo $module['module_name'];?>{ }
	#allmap {width: 100%;height: 500px;overflow: hidden;margin:0;}
	.shop_div{ white-space:normal; height:100px;}
	.shop_div img{width:200px;}
	.shop_window{}
	.shop_window .shop_name{ }
	.shop_window .shop_content{ border-top:1px solid #CCC; padding-top:5px;}
	.shop_window .shop_content .goods_div{ height:80px;}
	.shop_window .shop_content .goods_div a{ display:inline-block; vertical-align:top; width:33.33%;}
	.shop_window .shop_content .goods_div a img{ width:100%;}
	.shop_window .shop_content a:hover{ opacity:0.8;}
	.shop_window .shop_content .bottom_div{}
	.shop_window .shop_content .bottom_div .more{ float:left;}
	.shop_window .shop_content .bottom_div .go_shop{ float:right;}
	
	.filter{ text-align:right;}
</style>
    <div class="filter">
    	 <input type="text" name="search_filter" id="search_filter" value="<?php echo @$_GET['search']?>" placeholder="<?php echo self::$language['shop_name']?>/<?php echo self::$language['main_business']?>" />
        <a href="#" onclick="return e_search();" class="search"><span class=b_start> </span><span class=b_middle><?php echo self::$language['search']?></span><span class=b_end> </span></a> 
        
    </div>
    <div class=tag_div><div class=c_label><?php echo self::$language['tag']?>:</div><div class=tag_list><?php echo $module['tag'];?></div></div>	
    <div class=circle_filter style="display:none;">
    	<div class=c_label><?php echo self::$language['circle']?>:</div><div class=circle_list>
        	<div class=circle_1><?php echo $module['circle_list'];?></div>
        	<div class=circle_2><?php echo $module['circle_list_sub'];?></div>
        </div>
    </div>
    


<div id="allmap"></div>
<script type="text/javascript">

    function IsPC() {
        var userAgentInfo = navigator.userAgent;
        var Agents = ["Android","iPhone","SymbianOS","Windows Phone","iPad", "iPod"];
        var flag = true;
        for (var v = 0; v < Agents.length; v++) {
            if (userAgentInfo.indexOf(Agents[v]) > 0) {
                flag = false;
                break;
            }
        }
        return flag;
    }

    // 百度地图API功能
    var map = new BMap.Map("allmap");
        map.centerAndZoom(new BMap.Point(<?php echo $module['point'];?>), <?php echo $module['zoom'];?>);
    // 添加带有定位的导航控件
    var navigationControl = new BMap.NavigationControl({
        // 靠左上角位置
        anchor: BMAP_ANCHOR_TOP_LEFT,
        // LARGE类型
        type: BMAP_NAVIGATION_CONTROL_LARGE,
        enableGeolocation: false
    });
    //添加缩放控件
    map.addControl(navigationControl);
    //启用滚轮放大缩小
    map.enableScrollWheelZoom();
    //放大缩小回调事件
    function getJsonData ()
    {
		var pt = map.getBounds().getCenter();	
		obj=new Object();
		obj['latlng']=pt.lat+','+pt.lng;	
		obj['zoom']=map.getZoom();	

        $.ajax({
            type:"POST", //请求方式
            url:"<?php echo $module['action_url'];?>&act=get_shops&search="+get_param('search')+"&tag="+get_param('tag')+'&my_latlng=<?php echo $module['my_latlng'];?>', //虚拟数据返回接口
            data:{"latlng":obj['latlng'],zoom:obj['zoom']},  //虚拟参数
            success:function (json)
            {
                map.clearOverlays(); //清楚所有overlayer
                var aJsonData=eval('['+json+']');
                var aMarkPoint = [];
                var aContent = [];
                var iInfoWindowTop = 10; //弹出窗口的上下偏移量
                for (var i = 0 ; i <aJsonData.length; i++)
                {
                    var iPoint = {lng:aJsonData[i].point.split("|")[0],lat:aJsonData[i].point.split("|")[1]};
                        aMarkPoint.push(iPoint);
                    var sTitle = aJsonData[i].title;
                    var sContent = aJsonData[i].content;
                        aContent.push(sContent);
                    var bOpen = aJsonData[i].isOpen==1?true:false;
                    var sIcon = aJsonData[i].icon;

                    //alert(sTitle+"||"+sContent+"||"+bOpen+"||"+iIconPosition);

                    // 复杂的自定义覆盖物
                    function ComplexCustomOverlay(point, text, mouseoverText){
                        this._point = point;
                        this._text = text;
                    }
                    ComplexCustomOverlay.prototype = new BMap.Overlay();
                    ComplexCustomOverlay.prototype.initialize = function(map){
                        this._map = map;
                        //自定义样式
                        var div = this._div = document.createElement("div");
                        div.index=i;
                        div.style.position = "absolute";
                        div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
						div.style.backgroundColor="red";
                       // div.style.background = "url("+sIcon+") no-repeat";
                        div.style.backgroundImage = "url("+sIcon+")";
						div.style.backgroundRepeat="no-repeat";
						div.style.backgroundSize="25px 25px";
                        div.style.border = "1px solid white";
                        div.style.color = "white";
                        div.style.height = "25px";
                        div.style.padding = "2px";
                        div.style.paddingLeft = "28px";
                        div.style.lineHeight = "20px";
                        div.style.whiteSpace = "nowrap";
                        div.style.MozUserSelect = "none";
                        div.style.fontSize = "12px";
                        var span = this._span = document.createElement("span");
                        div.appendChild(span);
                        span.appendChild(document.createTextNode(this._text));
                        var that = this;
                        
											
						div.onmouseover = function(){
							div.style.backgroundColor="black";
							div.style.cursor="pointer";
						}
						 
						div.onmouseout = function(){
							 div.style.backgroundColor="red";
						}
											
						
						
						
						
                        tmpfun = map.onclick;

                        map.onclick = null;


                        if(IsPC())
                        {
                            div.onclick = function ()
                            {

                                var infoWindow = new BMap.InfoWindow(aContent[this.index]);
                                    infoWindow.disableAutoPan();
                                    infoWindow.disableCloseOnClick();
                                    map.openInfoWindow(infoWindow,new BMap.Point(aMarkPoint[this.index].lng, aMarkPoint[this.index].lat));
                            }
                        }
                        else
                        {
                            div.addEventListener("touchstart", function() {
                                map.onclick = tmpfun;
                                var infoWindow = new BMap.InfoWindow(aContent[this.index]);
                                    infoWindow.disableAutoPan();
                                    infoWindow.disableCloseOnClick();
                                    map.openInfoWindow(infoWindow,new BMap.Point(aMarkPoint[this.index].lng, aMarkPoint[this.index].lat));
                            });
                        }

                        map.getPanes().labelPane.appendChild(div);

                        return div;
                    }
                    ComplexCustomOverlay.prototype.draw = function(){
                        var map = this._map;
                        var pixel = map.pointToOverlayPixel(this._point);
                        this._div.style.left = pixel.x  + "px";
                        this._div.style.top  = pixel.y - iInfoWindowTop + "px";
                    }
                    var txt = sTitle;

                    var myCompOverlay = new ComplexCustomOverlay(iPoint, sTitle);

                        map.addOverlay(myCompOverlay);
                }

            },
            error:function (data)
            {
                //数据请求失败回调
            }
        });
    }

    map.addEventListener("tilesloaded",getJsonData);
    map.addEventListener("moving",function (e) {

        //e.stopPropagation();

    });
    map.addEventListener("moveend",function (e) {
       // e.stopPropagation();

    });


</script>

</div>
</div>