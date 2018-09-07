<?php 

foreach($_POST  as $key=>$value){$$key=trim($value);}
	foreach($_GET  as $key=>$value){
		if(!is_array($value)){$$key=trim($value);}
		
		}
