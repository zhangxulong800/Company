<?php
header('Content-Type:text/html;charset=utf-8');
?>

<!DOCTYPE html>
<head>
<link rel="shortcut icon" href="favicon.ico"/>
<title>在线提取域名网址工具</title>
<meta name=keywords content="在线提取域名网址工具">
<meta name="renderer" content="webkit" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1;" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<script src="./public/jquery.js"></script>
<script>
$(document).ready(function(){
	function getDomain(weburl){ 
		temp=weburl.split('.');
		if(temp.length>2 && temp[temp.length-2]!='com'){
			weburl=temp[temp.length-2]+'.'+temp[temp.length-1];	
		}
    	return weburl;
	}

	$(".submit").click(function(){
		
		var str=$(".input_content").val();		
		var regex=/([A-Za-z0-9]+(-[A-Za-z0-9]+)*\.)+(com|cn|com.\cn|net)/g;
		
		var arr=str.match(regex);
		Array.prototype.unique = function (isStrict) {
			if (this.length < 2)
				return [this[0]] || [];
			var tempObj = {}, newArr = [];
			for (var i = 0; i < this.length; i++) {
				var v = this[i];
				var condition = isStrict ? (typeof tempObj[v] != typeof v) : false;
				if ((typeof tempObj[v] == "undefined") || condition) {
					tempObj[v] = v;
					newArr.push(v);
				}
			}
			return newArr;
		}
		var r=arr;
		var r2=Array();
		domain='';
		for(var i=0;i<r.length;i++){
			r2[i]=getDomain(r[i]);
		}
		var r2=r2.unique(true);//去掉重复域名
		for(var i=0;i<r2.length;i++){
			domain+=r2[i]+"<br />";
		}
		
		$(".result_div").html(domain);	
				
		
		return false;
	});
});
</script>
<style>
	body{ padding:10px;}
	.input_content{ width:100%; height:200px;}
	.submit{ padding:10px; border-radius:5px; background-color:#F60; color:#FFF; line-height:50px;}
</style>
<body>
请网站源码或其它内容：<br />
<textarea class=input_content>

</textarea>
<a href=# class=submit >提取</a>
<div>提取结果</div>
<div class=result_div></div>
</body>
</html>
