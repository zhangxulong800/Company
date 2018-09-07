<?php
if(!$this->check_wid_power($pdo,self::$table_pre)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}
$wid=safe_str(@$_GET['wid']);
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'fail','id':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}

function get_button_type($v){
	if(is_url($v['url'])){
		return '{	
               "type":"view",
               "name":"'.$v['name'].'",
               "url":"'.$v['url'].'"
            }';	
	}else{
		return '{
		               "type":"click",
		               "name":"'.$v['name'].'",
		               "key":"'.$v['url'].'"
		            }';	
	}
}

function crate_menu($language,$pdo,$table_pre,$wid){
	$sql="select * from ".$table_pre."menu where `wid`='".$wid."' and `parent`=0 and `visible`=1 order by `sequence` desc,`id` asc limit 0,3";
	$r=$pdo->query($sql,2);
	$button=array();
	foreach($r as $v){
		$sql="select count(id) as c from ".$table_pre."menu where `wid`='".$wid."' and `parent`='".$v['id']."' and `visible`=1";
		$r2=$pdo->query($sql,2)->fetch();
		if($r2['c']!=0){
			$sql="select * from ".$table_pre."menu where `wid`='".$wid."' and `parent`='".$v['id']."'  and `visible`=1 order by `sequence` desc,`id` asc limit 0,5";
			$r2=$pdo->query($sql,2);
			$sub='';
			foreach($r2 as $v2){
				$sub.=get_button_type($v2).',';
			}
			
			$button[]= '{"name":"'.$v['name'].'",
		           "sub_button":['.trim($sub,',').']},';
		}else{
			$button[]=get_button_type($v).',';
			
		}	
	}
	$str='';
	foreach($button as $v){
		$str.=$v;	
	}
	$str='{
     "button":['.trim($str,',').']
 }';
	//file_put_contents('test.txt',$str);
	//exit;
	$sql="select `AppId`,`AppSecret` from ".$table_pre."account where `wid`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$access_token=receive::get_access_token($pdo,$r['AppId'],$r['AppSecret'],$wid);
	if($access_token===false){exit("{'state':'fail','info':'<span class=fail>".$language['AppId'].$language['or'].$language['AppSecret'].$language['err']." </span>'}");}
	
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}");
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$tmpInfo = curl_exec($ch);
	if (curl_errno($ch)) {
	echo 'Errno'.curl_error($ch);
	}
	curl_close($ch);
	$tmpInfo=json_decode($tmpInfo,true);
	if($tmpInfo['errmsg']!='ok'){return $tmpInfo['errcode'].$tmpInfo['errmsg'];}else{return true;}
	//var_dump($tmpInfo);
	
}






function update_auto_answer($language,$pdo,$table_pre,$old_key,$r,$act=''){
	if(is_url($r['url']) && $old_key!=''){
		//echo $old_key;
		if(!is_url($old_key)){
			$sql="select * from ".$table_pre."auto_answer where `author`='monxin' and `key` like '%EventKey:".$old_key."|%'";
			$r=$pdo->query($sql,2)->fetch(2);
			//file_put_contents('test.txt',$sql);
			if($r['id']!=''){
				//echo $r['id'];
				$sql="delete from ".$table_pre."auto_answer where `id`='".$r['id']."'";
				//echo $sql;
				if($pdo->exec($sql)){
					receive::del_auto_answer_files($pdo,$table_pre,$r,$r['id']);
				}
			}
		}
		return '';	
	}
	if(!is_url($r['url'])){
		$key=$language['menu'].':'.$r['name'].'|EventKey:'.$r['url'].'|MsgType:event|Event:CLICK';
		$v=$r['name'];
		$time=time();
		$sql="select * from ".$table_pre."auto_answer where `author`='monxin' and `key` like '%EventKey:".$old_key."|%'";
		//echo $sql;
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']==''){
			$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$_GET['wid']."','".$key."','text','text','".$time."','".$v."','monxin')";
		}else{
			if($act=='del'){
				$sql="delete from ".$table_pre."auto_answer where `id`='".$r2['id']."'";
				//echo $sql;
				if($pdo->exec($sql)){
					receive::del_auto_answer_files($pdo,$table_pre,$r2,$r2['id']);
				}
				return '';
			}else{
				$sql="update ".$table_pre."auto_answer set `key`='".$key."' where `id`='".$r2['id']."'";
			}
			
		}
		//echo $sql;
		$pdo->exec($sql);
	}
		
}

$act=@$_GET['act'];
if($act=='add'){
	$_GET['parent']=intval(@$_GET['parent']);
	if($_GET['parent']>0){
		$sql="select count(id) as c from ".self::$table_pre."menu where `id`='".$_GET['parent']."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['parent_not_exist']."'}");}
	}
	$sequence=intval(@$_GET['sequence']);
	$visible=intval(@$_GET['visible']);
	$name=safe_str(@$_GET['name']);
	$url=safe_str(@$_GET['url']);
	$sql="select count(id) as c from ".self::$table_pre."menu where `url`='".$url."' and `wid`='".$wid."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','id':'url','info':'<span class=fail>".self::$language['url_or_key'].self::$language['already_exists']."</span>'}");}
	
	$sql="insert into ".self::$table_pre."menu (`parent`,`name`,`url`,`sequence`,`visible`,`wid`) values ('".$_GET['parent']."','".$name."','".$url."','".$sequence."','".$visible."','".$wid."')";
	if($pdo->exec($sql)){
		$id=$pdo->lastInsertId();
		$sql="select * from ".self::$table_pre."menu where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		update_auto_answer(self::$language,$pdo,self::$table_pre,'',$r);
		$r=crate_menu(self::$language,$pdo,self::$table_pre,$wid);
		if($r!==true){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." errmsg:".$r."</span>'}");}		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['parent']=intval(@$_GET['parent']);
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['visible']=intval(@$_GET['visible']);
	$_GET['name']=safe_str(@$_GET['name']);
	$_GET['url']=safe_str(@$_GET['url']);
	
	$sql="select count(id) as c from ".self::$table_pre."menu where `url`='".$_GET['url']."' and `wid`='".$wid."' and `id`!=".$_GET['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','id':'url','info':'<span class=fail>".self::$language['url_or_key'].self::$language['already_exists']."</span>'}");}
	
	$sql="select `url` from ".self::$table_pre."menu where `id`=".$_GET['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	$old_url=$r['url'];
	
	
	$sql="update ".self::$table_pre."menu set `parent`='".$_GET['parent']."',`name`='".$_GET['name']."',`url`='".$_GET['url']."',`sequence`='".$_GET['sequence']."',`visible`='".$_GET['visible']."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		$sql="select * from ".self::$table_pre."menu where `id`=".$_GET['id'];
		$r=$pdo->query($sql,2)->fetch(2);
		update_auto_answer(self::$language,$pdo,self::$table_pre,$old_url,$r);
		$r=crate_menu(self::$language,$pdo,self::$table_pre,$wid);
		if($r!==true){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." errmsg:".$r."</span>'}");}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='update_visible'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['visible']=intval(@$_GET['visible']);
	$sql="update ".self::$table_pre."menu set `visible`='".$_GET['visible']."' where `id`='".$_GET['id']."'";	
	$pdo->exec($sql);
	$r=crate_menu(self::$language,$pdo,self::$table_pre,$wid);
	if($r!==true){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." errmsg:".$r."</span>'}");}		
	exit();
}
if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="select count(id) as c from ".self::$table_pre."menu where `parent`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_sub']."'}");}
	
	$sql="select * from ".self::$table_pre."menu where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	
	$sql="delete from ".self::$table_pre."menu where `id`='$id'";
	if($pdo->exec($sql)){
		update_auto_answer(self::$language,$pdo,self::$table_pre,$r['url'],$r,'del');
		$r=crate_menu(self::$language,$pdo,self::$table_pre,$wid);
		if($r!==true){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." errmsg:".$r."</span>'}");}		
		
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}
if($act=='del_select'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="select count(id) as c from ".self::$table_pre."menu where `parent`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);		
		if($r['c']==0){
			$sql="select * from ".self::$table_pre."menu where `id`=".$id;
			$r=$pdo->query($sql,2)->fetch(2);
			$sql="delete from ".self::$table_pre."menu where `id`='$id'";
			if($pdo->exec($sql)){
				update_auto_answer(self::$language,$pdo,self::$table_pre,$r['url'],$r,'del');
				$success.=$id."|";
			}
		}
	}
	$success=trim($success,"|");
	$r=crate_menu(self::$language,$pdo,self::$table_pre,$wid);
	if($r!==true){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." errmsg:".$r."</span>'}");}		
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
if($act=='operation_visible'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=str_replace("|",",",$ids);
	$ids=trim($ids,",");
	$ids=explode(",",$ids);
	$ids=array_map('intval',$ids);
	$temp='';
	foreach($ids as $id){
		$temp.=$id.",";	
	}
	$ids=trim($temp,","); 
	$_GET['visible']=intval(@$_GET['visible']);
	$sql="update ".self::$table_pre."menu set `visible`='".$_GET['visible']."' where `id` in ($ids)";
	$pdo->exec($sql);
	$r=crate_menu(self::$language,$pdo,self::$table_pre,$wid);
	if($r!==true){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." errmsg:".$r."</span>'}");}		
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
}

if($act=='submit_select'){
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['parent']=intval($v['parent']);
		$v['sequence']=intval($v['sequence']);
		$v['name']=safe_str($v['name']);
		$v['url']=safe_str($v['url']);
		
		$sql="select count(id) as c from ".self::$table_pre."menu where `url`='".$v['url']."' and `id`!=".$v['id'];
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']!=0){continue;}
			
		$sql="select `url` from ".self::$table_pre."menu where `id`=".$v['id'];
		$r=$pdo->query($sql,2)->fetch(2);
		$old_url=$r['url'];
	
		$sql="update ".self::$table_pre."menu set `parent`='".$v['parent']."',`name`='".$v['name']."',`url`='".$v['url']."',`sequence`='".$v['sequence']."' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){
			$sql="select * from ".self::$table_pre."menu where `id`=".$v['id'];
			$r=$pdo->query($sql,2)->fetch(2);
			update_auto_answer(self::$language,$pdo,self::$table_pre,$old_url,$r);
			$success.=$v['id']."|";
		}
	}
	$success=trim($success,"|");	
	$r=crate_menu(self::$language,$pdo,self::$table_pre,$wid);
	if($r!==true){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." errmsg:".$r."</span>'}");}		
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

