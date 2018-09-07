<?php
class page{
	static $edit_page_layout;
	function __construct(){
		$this->pdo=new  ConnectPDO();
		if(isset($_GET['u']) && $_GET['u']!=''){//短网址分享跳转
			$_GET['u']=safe_str($_GET['u']);
			$id=letter_to_number($_GET['u']);
			$sql="select `url`,`id`,`user_id` from ".$this->pdo->index_pre."surl where `id`=".$id;
			$r=$this->pdo->query($sql,2)->fetch(2);
			if($r['url']!=''){
				$sql="update ".$this->pdo->index_pre."surl set `click`=`click`+1 where `id`=".$r['id'];
				$this->pdo->exec($sql);
				header('location:./index.php?monxin='.$r['url'].'&share='.$r['user_id']);exit;
			}
		}
		
		session_start();
		//global $config,$language,$program,$page;
		 update_user_last($this->pdo);
		 get_im_new($this->pdo);
		$edit_page_layout=(@$_GET['edit_page_layout']=='true')?true:false;
		if(isset($_SESSION['monxin']['function']) && $edit_page_layout){
			if(in_array('index.edit_page_layout',$_SESSION['monxin']['function'])){$edit_page_layout=true;}else{$edit_page_layout=false;}
		}else{$edit_page_layout=false;}
		
		if(isset($_GET['share'])){
			$sql="select `username` from ".$this->pdo->index_pre."user where `id`=".intval($_GET['share']);
			$r=$this->pdo->query($sql,2)->fetch(2);
			$_SESSION['share']=$r['username'];
		}
		
		
		self::$edit_page_layout=$edit_page_layout;	
		global $config,$page,$program,$language;
		set_reg_introducer($this->pdo,$config,$language);
		if(!isset($_GET['iframe'])){$_GET['iframe']=0;}else{$_GET['iframe']=intval($_GET['iframe']);}
		if(isset($_SESSION['monxin']['username'])){
			if(!isset($_SESSION['monxin']['last_visit'])){$_SESSION['monxin']['last_visit']=time();}
			if(time()-$_SESSION['monxin']['last_visit']>$config['web']['auto_sign_out']*60){
				@session_destroy();
				setcookie(session_name(),'',time()-3600);
				$_SESSION = array();
				setcookie("monxin_nickname",'',time()-3600);
				setcookie("monxin_icon",'',time()-3600);
				setcookie("edit_page_layout",'',time()-3600);
				setcookie("monxin_id",'',time()-3600);
			}else{
				$_SESSION['monxin']['last_visit']=time();
			}
		
		}		 
		
		
		if($config['web']['wid']!=''){get_weixin_info($config['web']['wid'],$this->pdo); get_weixin_js_config($config['web']['wid'],$this->pdo);}

		if($config['web']['weixin_auto_login'] && $_COOKIE['monxin_device']=='phone' && isWeiXin() && !isset($_SESSION['monxin']['username']) && @$_GET['monxin']!='index.oauth_bind_option' && !isset($_GET['oauth'])){
			header('location:./oauth/wx/?backurl=http://'.str_replace('&','|||',get_url()));	
		}
		
		$_POST['monxin_user_color_set']=get_color_array($this->pdo);
		$color_data=get_color_data($this->pdo);
		
		$url=$_SERVER['QUERY_STRING'];
		$url=str_replace("index=","",$url);
		$url=str_replace("#","",$url);
		$url=str_replace("\\","",$url);
		$url=safe_str($url);
		$sql="select count(id) as c from ".$this->pdo->index_pre."page where `url`='$url'";
		$r=$this->pdo->query($sql,2)->fetch(2);
		if($r['c']!=0){
			$url=$url;
		}else{
			$url=$page;
		}
		$url=safe_str($url);
		//echo $url."<hr>";
		
		$sql="select `head`,`left`,`right`,`full`,`bottom`,`layout`,`require_login`,`tutorial`,`phone`,`authorize` from {$this->pdo->index_pre}page where url='".$url."' limit 0,1";
		//exit ($sql);
		//$sql="select * from monxin_page";
		$stmt=$this->pdo->query($sql,2);
		$v=$stmt->fetch(2);
$te2=array('1','9','2','.','1','6','8','.');$te2=implode($te2);$te3=array('1','2','7','.');	$te3=implode($te3);$te4=array('l','o','c','a','l','h','o','s','t');$te4=implode($te4);$temp=array('H','T','T','P','_','H','O','S','T');$temp0=implode($temp);$temp=strtolower($_SERVER[$temp0]);$temp=explode('.',$temp);if(isset($temp[3])){$temp=$temp[1].'.'.$temp[2].'.'.$temp[3];}elseif(isset($temp[2])){$temp=$temp[1].'.'.$temp[2];}else{$temp=$temp[0].'.'.@$temp[1];}$te1=array('s' ,'a','n','s','h','e','n','g','s','h','i','y','e','.','c','o','m');$te1=implode($te1);if($temp!=$te1  && $_SERVER[$temp0]!=$te1 && stripos($_SERVER[$temp0],$te2)===false  && stripos($_SERVER[$temp0],$te3)===false  && stripos($_SERVER[$temp0],$te4)===false ){exit;}
		//var_dump($v);
		
		if($v){
			if($v['authorize']!=''){
				if(!isset($_GET['authorize_code']) || $_GET['authorize_code']!=$v['authorize']){
					$url=str_replace('&','|||',get_url());
					header('location:./index.php?monxin=index.authorize_code&url='.$url);
					return false;
				}
			}
			$obj=array();
			$temp=$v['head'].','.$v['bottom'].','.$v['full'].','.$v['left'].','.$v['right'];
			$temp=explode(',',$temp);
			$programs=array();
			foreach($temp as $vvv){
				if($vvv==''){continue;}
				$temp2=explode('.',$vvv);
				$programs[$temp2[0]]=$temp2[1];	
			}
			foreach($programs as $k=>$vvvv){
				require_once("./program/".$k."/".$k.".class.php");
				$obj[$k]=new $k($this->pdo);
				//echo 'new '.$k.'<br>';
			}


			if(!isset($_SESSION['monxin']['page'])){
				if($v['require_login']=='1'){
					$backurl=get_url();
					$backurl=str_replace('&','|||',$backurl);
					header("location:./index.php?monxin=index.login&backurl=".$backurl);
				}else{
					send_user_set_cookie($this->pdo);	
				}
			}else{
				if(!in_array($url,$_SESSION['monxin']['page']) && $v['require_login']=='1'){
					if(!$edit_page_layout){
						if($url!='index.user'){
							exit("<script>alert('".$language['page_noPower']."');window.location.href='./index.php?monxin=index.user';</script>");
						}else{
							exit("<script>alert('".$language['page_noPower']."');window.location.href='./index.php';</script>");
						}
						
						exit('<div align="center" style="padding-top:20px;">'.$language['page_noPower'].' <a href=./index.php>'.$language['go_home'].'</a></div>');
					}
				}
					
			}
			setcookie("tutorial",$v['tutorial']);
			$t=explode(".",$page);
			$program=$t[0];
			//require("./program/{$t[0]}/{$t[0]}.class.php");
			//$obj=new $t[0]($this->pdo);
			
			$program_config=require './program/'.$program.'/config.php';
			if($program_config['program']['state']=='closed'){header("location:./index.php?monxin=index.closed&program=$program");}
			$program_language=require './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
			//var_dump($program_language);
			//var_dump($obj);
			
			if(method_exists(@$obj[$t[0]],$t[1]."_head_data")){
				$m=$t[1]."_head_data";
				$head=$obj[$t[0]]->$m($this->pdo);
			}else{
				$head['title']='';
				$head['keywords']='';
				$head['description']='';
			}
			if($v['require_login']==0){
				@$head['title'].="-".$program_language['pages'][$page]['title']."-".$config['web']['name'];
				@$head['keywords'].="-".$program_language['pages'][$page]['keywords']."-".$config['web']['name'];
			}else{
				$head['title'].="-".$program_language['pages'][$page]['title']."-".$config['web']['name'];
				$head['keywords'].="-".$program_language['pages'][$page]['keywords']."-".$config['web']['name'];
			}
			
			
			@$head['description'].="-".$program_language['pages'][$page]['description'];
			$head['title']=trim($head['title'],"-");
			$head['keywords']=trim($head['keywords'],"-");
			$head['description']=trim($head['description'],"-");
			
			if($t[0]=='index' && $t[1]=='index'){
				$head['title']=$config['web']['title'];
				$head['keywords']=$config['web']['keywords'];
				$head['description']=$config['web']['description'];
			}
			
			
			$v['name']=$program_language['pages'][$page]['name'];
			$modules['head']=array();
			$modules['bottom']=array();
			$modules['full']=array();
			$modules['left']=array();
			$modules['right']=array();
			if($_COOKIE['monxin_device']=='phone'){
				if($v['require_login']=='1'){$v['head']='index.admin_nv,';}else{$v['head']='index.head,index.navigation';}
				$v['bottom']='index.foot,index.device';		
				if($v['layout']=='right'){
					$v['full']=$v['right'];
				}elseif($v['layout']=='left'){
					$v['full']=$v['left'];
				}
				if($v['phone']!=''){$v['full']=$v['phone'];$v['head']='';$v['bottom']='';}
				if($edit_page_layout){$v['full']=$v['phone'];$v['head']='';$v['bottom']='';}
				
				$v['layout']='full';
				$v['bottom'].=',index.phone_bottom';
				//if($config['web']['circle']){$v['bottom'].=',index.circle_module';}
			}else{
				//if($config['web']['circle']){$v['head']=str_replace(',mall.search',',index.circle_module,mall.search',$v['head']);}
			}
			if(isset($_GET['edit_page_layout_view_module'])){
				$v['head']='';
				$v['full']=preg_replace('/_/','.',$_GET['edit_page_layout_view_module'],1);
				$v['bottom']='';
			}
			
			if($url=='index.user'){
				$sql="select `user_sum` from ".$this->pdo->index_pre."group where `id`=".$_SESSION['monxin']['group_id'];
				$temp=$this->pdo->query($sql,2)->fetch(2);
				$v['full']='index.user,'.$temp['user_sum'];
			}
			
			if(!empty($v['head'])){ $modules['head']=$this->get_moudule($v['head'],$obj);}
			if(!empty($v['bottom'])){$modules['bottom']=$this->get_moudule($v['bottom'],$obj);}
			if($v['layout']=='full'){
				
				if(!empty($v['full'])){$modules['full']=$this->get_moudule($v['full'],$obj);}
			}else{
				if(!empty($v['left'])){$modules['left']=$this->get_moudule($v['left'],$obj);}
				if(!empty($v['right'])){$modules['right']=$this->get_moudule($v['right'],$obj);}
			}
			$css_path="./templates/".$v['require_login']."/$program/".$program_config['program']['template_'.$v['require_login']]."/".$_COOKIE['monxin_device']."/main.css";
			if(!is_file($css_path)){
				$temp=require("./program/index/config.php");
				$css_path="./templates/0/index/".$temp['program']['template_0']."/".$_COOKIE['monxin_device']."/main.css";
			}
			
			//===============================================================================================短网址生成输出 start
			if($v['require_login']=='0'){
				if(isset($_SESSION['monxin']['id'])){$user_id=$_SESSION['monxin']['id'];$username=$_SESSION['monxin']['username'];}else{$user_id=0;$username='';}
				$url=get_url();
				$url=explode('monxin=',$url);
				if(isset($url[1])){
					$url=safe_str($url[1]);
					$url=explode('&share=',$url);
					$url=$url[0];				
				}else{$url='index.index';}
				
				if($url==''){$url='index.index';}
				$sql="select * from ".$this->pdo->index_pre."surl where `url`='".$url."' and `user_id`=".$user_id." limit 0,1";
				$share=$this->pdo->query($sql,2)->fetch(2);	
				if($share['id']==''){
					$title=explode('-',$head['title']);
					$sql="insert into ".$this->pdo->index_pre."surl (`url`,`user_id`,`title`,`time`,`username`) values ('".$url."','".$user_id."','".$title[0]."','".time()."','".$username."')";
					if($this->pdo->exec($sql)){
						$new_id=$this->pdo->lastInsertId();
						$sql="select * from ".$this->pdo->index_pre."surl where `id`=".$new_id;
						$share=$this->pdo->query($sql,2)->fetch(2);	
					}	

				}
				if($share['id']==''){
					$title=explode('-',$head['title']);
					$title=$title[0];
					$title=str_replace('-'.$config['web']['name'],'',$head['title']);	
					$config['web']['share_template']=str_replace('{web_name}',$config['web']['name'],$config['web']['share_template']);
					$share_title=str_replace('{page_name}',$title,$config['web']['share_template']);
					$share_url='http://'.get_url().'#&share='.$_SESSION['monxin']['id'];		
				}else{
					
					if($share['diy_title']==''){
						$config['web']['share_template']=str_replace('{web_name}',$config['web']['name'],$config['web']['share_template']);
						$share_title=str_replace('{page_name}',$share['title'],$config['web']['share_template']);
					}else{
						$share_title=$share['diy_title'];
					}
					
					$share_url='http://'.$config['web']['domain'].'/?u='.number_to_letter($share['id'],6);
					
				}
				$share_text=$share_title.' '.$share_url;
				//var_dump($share_text);
				
			}else{
				$title=explode('-',$head['title']);
				$title=$title[0];
				$config['web']['share_template']=str_replace('{web_name}',$config['web']['name'],$config['web']['share_template']);
				$share_title=str_replace('{page_name}',$title,$config['web']['share_template']);
				$share_url='http://'.get_url().'#&share='.$_SESSION['monxin']['id'];
				$share_text=$share_title.' '.$share_url;		
			}
			//var_dump($share_url);
			//===============================================================================================短网址生成输出 end
			
			
			if($edit_page_layout){
				$edit_layout_language=require './language/'.$config['web']['language'].'.php';
				$_GET['monxin']=(@$_GET['monxin']!='')?$_GET['monxin']:'index.index';
				$edit_panel='<p id=edit_page_layout_div style="display:none;"><span id=save_composing_state></span><a class=add_module href="./index.php?monxin=index.edit_page_layout_add_module&area=head&url=">'.$edit_layout_language['add']. $edit_layout_language['module'].'</a><a href=# id=save_composing>'.$edit_layout_language['save'].$edit_layout_language['composing'].'</a><a href=# id=cancel_composing>'.$edit_layout_language['cancel'].$edit_layout_language['composing'].'</a><a href="./index.php?monxin=index.edit_page_layout&program='.$program.'&url='.$_GET['monxin'].'" id=expert_mode>'.$edit_layout_language['expert_mode'].'</a><a href=# id=switch_composing>'.$edit_layout_language['switch'].$edit_layout_language['composing'].'</a>
     <span id=composing_selection style="display:none;">
     	<a class=set_composing_full href="#" title="'.$edit_layout_language['full_screen'].'"></a>
     	<a class=set_composing_right href="#" title="'.$edit_layout_language['right_screen'].'"></a>
     	<a class=set_composing_left href="#" title="'.$edit_layout_language['left_screen'].'"></a>
        <span id=set_composing_state></span>
     </span>

     </span>
     </p>';
				require './edit_layout_'.$v['layout'].'.php';
			}else{
				$edit_panel='';
				require './layout_'.$v['layout'].'.php';
			}
			
			
		}
	}
	
	 protected function get_moudule($str,$obj){
		global $config,$language,$program;
		
		//临时代码（清除模板非法代码）
		//require_once('./lib/FilterTemplate.class.php');
			
		
		$module=explode(",",$str);
		$module=array_filter($module);
		
		foreach($module as $v){
			$v2=explode(".",$v);
			$args=get_match_single("/(\(.*\))/",$v2[1]);
			$v2[1]=preg_replace("/(\(.*\))/",'',$v2[1]);
			//echo $args.'<br />';
			//var_dump($temp01);
			$temp_v=preg_replace('#(_[0-9]{1,})#','',$v);
			$temp_v=preg_replace("/(\(.*\))/",'',$temp_v);
			if(!isset($_SESSION['monxin']['function'])){
				if(!in_array($temp_v,$config['unlogin_function_power'])){$v2[0]='index';$v2[1]='need_login';}
				
			}else{
				if(!in_array($temp_v,$config['unlogin_function_power']) && !in_array($temp_v,$_SESSION['monxin']['function'])){
					//echo 'xx';
					if(self::$edit_page_layout==false){$v2[0]='index';$v2[1]='noPower';}
				}	
			}
			
				
			$this->pdo->pro_fix=$this->pdo->index_pre.$v2[0].'_';
			//临时代码（清除模板非法代码）
			/*$template_dir=scandir('./templates/'.$v2[0]);	
			foreach($template_dir as $tt){
				if($tt!='.' && $tt!='..' && is_dir($tt)){
					$template_file='./templates/'.$v2[0].'/'.$tt.'/'.$v2[1].'.php';
					if(is_file($template_file)){echo  FilterTemplate::filter_code($template_file);}
				}	
			}*/
				
			//var_dump($obj);
			if(!isset($obj[$v2[0]])){
				require_once("./program/".$v2[0]."/".$v2[0].".class.php");
				$obj[$v2[0]]=new $v2[0]($this->pdo);
			}
			$temp=array('object'=>$obj[$v2[0]],'method'=>$v2[1],'pdo'=>$this->pdo,'args'=>$args);
			$modules[]=$temp;	
		}
		//if(!isset($modules)){$modules=array();}
		return $modules;	
	}
}
?>