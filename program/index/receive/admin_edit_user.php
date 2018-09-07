<?php
		
		$update=safe_str(@$_GET['update']);
		$$update=safe_str(@$_POST[$update]);
		$id=intval(@$_GET['id']);
		$forbid=array('id','username','group','money','state','identifying','password','transaction_password','email','phone','introducer');
		if(in_array($update,$forbid)){exit("forbid update $update field");}
		if($id==0){exit();}
		function is_same($pdo,$field,$v){
			$sql="select count(id) as c from ".$pdo->index_pre."user where `$field`='".$v."' and `id`!='".intval(@$_GET['id'])."'";
			$v=$pdo->query($sql,2)->fetch(2);
			if($v['c']!=0){return false;}else{return true;}
	
		}
		$$update=safe_str($$update);
		switch ($update) {
			case 'introducer':
				$sql="select `$update` from ".$pdo->index_pre."user where `id`='$id'";
				$v=$pdo->query($sql,2)->fetch(2);
				if($v[$update]!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['forbidden_modify']."</span>'}");}
				$sql="select id from ".$pdo->index_pre."user where `username`='".$$update."'";
				$v=$pdo->query($sql,2)->fetch(2);
				if($v['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['username_err']."</span>'}");}
				if($v['id']>=$id){exit("{'state':'fail','info':'<span class=fail>".self::$language['introducer'].self::$language['illegal']."</span>'}");}
				break;
			case 'nickname':
				if(!is_same($pdo,$update,$$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>'}");}
				break;
			case 'license_id':
				if(!is_same($pdo,$update,$$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>'}");}
				break;
			case 'domain':
				if(!is_same($pdo,$update,$$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>'}");}
				break;
			case 'chip':
				if(!is_same($pdo,$update,$$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>'}");}
				break;
			case 'phone':
					if(!preg_match(self::$config['other']['reg_phone'],$$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['phone'].self::$language['pattern_err']."</span>'}");}
				$sql="select count(id) as c from ".$pdo->index_pre."user where (`$update`='".$$update."' or `username`='".$$update."') and `id`!='$id' ";
				$v=$pdo->query($sql,2)->fetch(2);
				if($v['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>'}");}
				break;
			case 'email':
					if(!is_email($$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['email'].self::$language['pattern_err']."</span>'}");}
				$sql="select count(id) as c from ".$pdo->index_pre."user where (`$update`='".$$update."' or `username`='".$$update."') and `id`!='$id' ";
				$v=$pdo->query($sql,2)->fetch(2);
				if($v['c']!=0){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>'}");}
				break;
			case 'birthday':
				$$update=get_unixtime($$update,self::$config['other']['date_style']);
				if($$update>time()){exit("{'state':'fail','info':'<span class=fail>".self::$language['illegal']."</span>'}");}
				break;	
			case 'homepage':
				$$update=strtolower($$update);
				if(substr($$update,0,4)!='http'){$$update="http://".$$update;}
				if(!is_url($$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['homepage'].self::$language['pattern_err']."</span>'}");}
				break;
				
				
				
		}
		if($update=='icon' || $update=='license_photo_front' || $update=='license_photo_reverse'){
			$sql="select `$update` from ".$pdo->index_pre."user where `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			@safe_unlink("./program/index/user_{$update}/".$r[$update]);
		}
		$sql="update ".$pdo->index_pre."user set `$update`='".$$update."' where `id`='$id'";
		if($pdo->exec($sql)){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}