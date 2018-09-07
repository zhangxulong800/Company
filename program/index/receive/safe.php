<?php
$path=$_GET['path'];
if(!is_file($path)){exit('path err');}
$c=file_get_contents($path);
$c=str_replace('</textarea>','<\/textarea>',$c);
echo '<textarea  style="width:100%;height:100%;">'.$c.'</textarea>';
