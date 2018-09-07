<div class="my_contact_info">
	<div class="my_tel">
		<div class="my_head">
			<a href="tel:{tel}" target="_blank">{tel}</a>
		</div>	
	</div>
	<div class="my_qq">
		<div class="my_head">
			<a href="http://wpa.qq.com/msgrd?v=3&uin={qq}&site=qq&menu=yes" target="_blank">{qq}</a>
		</div>
		
	</div>
	<div class="address">
		<div class="my_head">
			
            <a class="navigate" href="#" template="http://api.map.baidu.com/direction?origin=latlng:{user_latlng}|name:我的位置&destination=latlng:{shop_latlng}|name:{shopName}&mode=driving&region={shopName}&output=html&src=yourCompanyName|yourAppName" target="_blank">{address}</a>
		</div>
	</div>
</div>
<iframe width="100%" height="500" id="map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://{map_api}.monxin.com/map.php?point={position}&zoom=16&&icon={logo_path}&icon_width=200&icon_height=75&map_width=100%&map_height=500px&company={shop_name}" template="http://{map_api}.monxin.com/map.php?point={shop_position}&zoom=16&&icon={logo_path}&icon_width=200&icon_height=75&map_width=100%&map_height=500px&company={shopName}">
</iframe>

