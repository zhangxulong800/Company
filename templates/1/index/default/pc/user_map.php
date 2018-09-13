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
				window.location.href='./index.php?monxin=index.user_map&geo='+v;
			  
			}
		}

		*/
		$(document).scrollTop($("#<?php echo $module['module_name'];?>").offset().top);
		
    });
	</script>    
    <style>
    #<?php echo $module['module_name'];?>{}	
	#<?php echo $module['module_name'];?>_html{ }
	.user_window{ width:180px; }
	.user_window img{ width:180px; height:180px;}
	.user_window .bottom_div{ }
	.user_window .bottom_div a{ display:inline-block; vertical-align:top; width:50%;}
	.user_window .bottom_div .go_shop{ text-align:right;}
    </style>
<div id="<?php echo $module['module_name'];?>_html"  monxin-table=1>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $module['map_secret'];?>"></script>

<style type="text/css">
	#<?php echo $module['module_name'];?>{ }
	#allmap {width: 100%;height: 500px;overflow: hidden;margin:0;}
</style>

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
				console.log(json);
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
								//return false;
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