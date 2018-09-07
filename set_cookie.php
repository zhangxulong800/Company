<?php
header('Content-Type:text/html;charset=utf-8');
?>
<script>
function setCookie(name,value,expires){ 
	var cookieString=name+"="+escape(value); 
	if(expires>0){ 
		var date=new Date(); 
		date.setTime(date.getTime()+expires*1000); 
		cookieString+="; expires="+date.toGMTString(); 
	}
	document.cookie=cookieString;
	 
} 
setCookie('map_<?php echo @$_GET['key']?>','<?php echo @$_GET['value'];?>',30);
//alert('<?php echo @$_GET['value'];?>');
</script>
