<?php
class install{
/**
 *	
 *   作者 梁长期 925434309@qq.com
 *   
 */
	function extract_zip($file){
		$zip = new ZipArchive;
		if ($zip->open($file) === TRUE) {
			$dir='./';
			@$zip->extractTo($dir);
			$zip->close();
			safe_unlink($file);
			return $dir;
		} else {
			return false;
		}
	}

	function add_program($program,$pdo){
		$sql="select `id` from ".$pdo->index_pre."program where `name`='$program'";
		$r=$pdo->query($sql,2)->fetch(2);
		if(!isset($r['id'])){
			$sql="insert into ".$pdo->index_pre."program (`name`) values ('$program')";
			$pdo->exec($sql);
		}

	}
	
	function add_program_menu($program,$pdo){
		$menu=require("./$program/index.class.php");
		foreach($menu as $key=>$v){
			$url=$key;	
			$sql="select `id` from ".$pdo->index_pre."program_menu where `url`='$url'";
			$r=$pdo->query($sql,2)->fetch(2);
			if(!isset($r['id'])){
				$sql="insert into ".$pdo->index_pre."program_menu (`url`) values ('$url')";
				$pdo->exec($sql);
			}
		}
	}


	function add_page($program,$pdo){
		$pages=require("./$program/pages.php");
		foreach($pages as $v){
			$sql="select count(id) as c from ".$pdo->index_pre."page where `url`='".$v['url']."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']>0){
				$fields='';
				foreach($v as $key=>$v2){
					$fields.="`$key`='".$v2."',";	
				}
				$fields=trim($fields,",");
				$sql="update ".$pdo->index_pre."page set $fields where `url`='".$v['url']."'";
			}else{
				$fields='';
				$values='';
				foreach($v as $key=>$v2){
					$fields.="`$key`,";	
					$values.="'$v2',";
				}
				$fields=trim($fields,",");
				$values=trim($values,",");
				$sql="insert into ".$pdo->index_pre."page ($fields) values ($values)";	
			}
			//echo $sql;
			$pdo->exec($sql);
		}
	}
	
	
	function add_function($program,$pdo){
		require_once("./$program/index.class.php");
		$config=require("./$program/config.php");
		$language=require("./$program/language/".$config['web']['language'].".php");
		$index=get_class_methods("index");
		foreach($index as $v){
			if($v!='__construct' && $v!='index'){
				$name=$program.".".$v;
				//echo $name."<br />";
				if(isset($language['functions'][$v])){
					$sql="select count(id) as c from ".$pdo->index_pre."function where `name`='$name'";
					$r=$pdo->query($sql,2)->fetch(2);
					if($r['c']==0){
						$sql="insert into ".$pdo->index_pre."function (`name`) values ('$name')";	
						$pdo->exec($sql);
					}
				}
			}
			}	
	}


}
?>