<?php
if(@$_GET['act']=='reset_site_key'){
	$url=self::$config['server_url'].'receive.php?target=server::synchronization&act=reset_site_key&site_id='.self::$config['web']['site_id'].'&site_key='.self::$config['web']['site_key'];
	$r=@file_get_contents($url);
	//echo $r;
	if($r!=''){
		$r=json_decode($r,1);
		if($r['state']=='success'){
			$config=require('./config.php');
			$config['web']['site_key']=$r['site_key'];
			if(file_put_contents('./config.php','<?php return '.var_export($config,true).'?>')){
				echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>','key':'".$r['site_key']."'}";
			}else{
				echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
			}	
			
		}else{
			echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
		}
	}
	
	exit;	
}

if(@$_GET['act']=='url'){
	$url1=get_url();
	$url1=explode("receive.php",$url1);
	$url1=$url1[0];
	$url=self::$config['server_url'].'receive.php?target=server::synchronization&update=site&id='.self::$config['web']['site_id'].'&key='.self::$config['web']['site_key'].'&field=url&v='.$url1;
	@file_get_contents($url);
	exit;	
}

$update=trim(@$_GET['update']);
//echo $update;

$$update=trim(@$_POST[$update]);
//echo $update.'='.$$update;
if($$update=='false'){$$update=false;}
if($$update=='true'){$$update=true;}
//echo $update.'='.var_dump($$update);
$key=explode('__',$update);
$config=require('./config.php');
if(count($key)==1){$config[$key[0]]=$$update;}		
if(count($key)==2){
	if($key[0]=='image_mark' && $key[1]=='water_logo'){
		@safe_unlink('./'.$config[$key[0]][$key[1]]);
		$temp=getimagesize('./temp/'.$$update);
		
		if($temp[2]==1){$v='image_mark.gif';}
		if($temp[2]==2){$v='image_mark.jpg';}
		if($temp[2]==3){$v='image_mark.png';}
		safe_rename('./temp/'.safe_path($$update),$v);
		$$update=$v;
		echo "<script>window.location.reload();</script>";
			
	}
	if($key[0]=='image_mark' && $key[1]=='ttf_path'){
		@safe_unlink('./'.$config[$key[0]][$key[1]]);
		safe_rename('./temp/'.$$update,'image_mark.ttf');
		$$update='image_mark.ttf';
			
	}
	
	if($key[0]=='web'){
		if($key[1]=='name' || $key[1]=='monxin_username' || $key[1]=='monxin_password' || $key[1]=='domain' || $key[1]=='url' || $key[1]=='title'){
			if($key[1]=='domain'){
				if(!is_local($$update) && !is_url('http://'.$$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>','alert_str':'".self::$language['pattern_err']."'}");}	
			}
			$url=self::$config['server_url'].'receive.php?target=server::synchronization&update=site&id='.self::$config['web']['site_id'].'&key='.self::$config['web']['site_key'].'&field='.$key[1].'&v='.$$update;
			
			if($key[1]=='monxin_password'){
				$url=self::$config['server_url'].'receive.php?target=server::synchronization&update=site&id='.self::$config['web']['site_id'].'&key='.self::$config['web']['site_key'].'&field='.$key[1].'&v='.$$update.'&username='.urlencode(self::$config['web']['monxin_username']);
			
			}
			$c=@file_get_contents($url);
			$c=trim($c);	
			if($key[1]=='monxin_username' || $key[1]=='monxin_password' ){
				if($c!='ok'){exit("{'state':'fail','info':'<span class=fail>".$c."</span>'}");}
			}
		}
		if($key[1]=='wid' && $$update!=''){
			$wid=safe_str($$update);
			$sql="select `id` from ".$pdo->sys_pre."weixin_account where `wid`='".$wid."' and `state`=1 limit 0,1";
			$t=$pdo->query($sql,2)->fetch(2);	
			if($t['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']." <a href=./index.php?monxin=weixin.account_add ><b>".self::$language['add']."</b></a></span>'}");}
			if($wid!=$config['web']['wid']){
				foreach($config['openid_notice_template'] as $kkk=>$vvv){
					$template_id=get_weixin_template_id($pdo,$wid,$kkk);
					if($template_id!=''){$config['openid_notice_template'][$kkk]=$template_id;}	
				}
			}
			
		}
		if($key[1]=='domain'){
			if($c=='exist'){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>','alert_str':'".self::$language['exist']."'}");}
			if($c!='ok'){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>','alert_str':'".self::$language['need_to_connnect_to_the_Monxin_server_can_be_used']."'}");}
			$$update=str_ireplace('http://','',$$update);	
			$temp=explode('/',$$update);	
			$$update=$temp[0];
			if(!is_local($_SERVER['HTTP_HOST'])){
				$url=get_url();
				$url=explode("receive.php",$url);
				$url=str_ireplace($_SERVER['HTTP_HOST'],$$update,$url[0]);
				//echo $url;
				$c=@file_get_contents("http://".$url);
				$title=get_match_single("/<title>(.*)<\/title>/",$c);
				if($title!=$config['web']['title']){
					exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>','alert_str':'".self::$language['please_resolve_domain_to_the_site']."'}");
				}
				$ht_mb=@file_get_contents('./m.htaccess');
				$ht=str_replace('{url}',$$update,$ht_mb);
				file_put_contents('./.htaccess',$ht);
			}
		}
		
		
	}
	
	if($key[0]=='cache' && $key[1]=='cache_time'){$$update=intval($$update);}
	if($key[0]=='cache' && $key[1]=='memcache_port'){$$update=intval($$update);}
	if($key[0]=='upload' && $key[1]=='sys_upload_max_filesize'){$$update=intval($$update);}
	if($key[0]=='upload' && $key[1]=='sys_post_max_size'){$$update=intval($$update);}
	if($key[0]=='sms' && $key[1]=='length'){$$update=intval($$update);}
	if($key[0]=='sms' && $key[1]=='max'){$$update=intval($$update);}
	if($key[0]=='image_mark' && $key[1]=='position'){$$update=intval($$update);}
	if($key[0]=='image_mark' && $key[1]=='opacity'){$$update=intval($$update);}
	if($key[0]=='image_mark' && $key[1]=='font_size'){$$update=intval($$update);}
	if($key[0]=='image_mark' && $key[1]=='font_angle'){$$update=intval($$update);}
	if($key[0]=='other' && $key[1]=='user_login_log'){$$update=intval($$update);}
	
	$config[$key[0]][$key[1]]=$$update;

}		
if(count($key)==3){$config[$key[0]][$key[1]][$key[2]]=$$update;}

if(file_put_contents('./config.php','<?php return '.var_export($config,true).'?>')){
	echo "{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}";
}else{
	echo "{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
}	
//echo '<pre>';
//var_dump($config);	
//echo '</pre>';

