<?php
		$update=trim(@$_GET['update']);
		$$update=trim(@$_POST[$update]);
		
		//exit($update.'='.$$update);
		
		
		$path=@$_GET['path'];
		$path=explode("__",$path);
		if($path[0]=='os_language'){
			$url='./language/'.$path[1].'.php';
		}else{
			$url='./program/'.$path[0].'/language/'.$path[1].'.php';
		}
		$language=require($url);
		
		$keys=str_replace('_dot_','.',$update);
		$keys=explode('__',$keys);
		if(count($keys)==1){
			$language[$keys[0]]=$$update;
		}
		if(count($keys)==2){
			$language[$keys[0]][$keys[1]]=$$update;
		}
		if(count($keys)==3){
			$language[$keys[0]][$keys[1]][$keys[2]]=$$update;
		}
		if(count($keys)==4){
			$language[$keys[0]][$keys[1]][$keys[2]][$keys[3]]=$$update;
		}
		
		
		if(file_put_contents($url,'<?php return '.var_export($language,true).'?>')){
			echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
		}else{
			echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
		}	
