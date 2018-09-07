<?php
function sms_content_length($string){
    //将中文(3字符)替换成英文(1字符)然后再统计
   $string = preg_replace ( '/[\x80-\xff]{3}/', 'x', $string );
   return strlen ( $string );
}

		$time=time();
		$_POST['addressee']=safe_str(@$_POST['addressee']);
		$_POST['content']=safe_str(@$_POST['content']);
		//var_dump($_POST);
		if($_POST['addressee']!='' && $_POST['content']!=''){
			
			if(@$_POST['timing']=='on' && @$_POST['send_time']!=''){
				$timing=@$_POST['send_time'];
				//echo $timing;
				$timing=str_replace("-"," ",$timing);
				$timing=str_replace(":"," ",$timing);
				$timing=str_replace("/"," ",$timing);
				$timing=explode(" ",$timing);
				//echo self::$config['other']['date_style'][0];
				if(count($timing)==6){
					if(strtolower(self::$config['other']['date_style'][0])=='y'){$timing=mktime($timing[3],$timing[4],$timing[5],$timing[1],$timing[2],$timing[0]);}
					if(strtolower(self::$config['other']['date_style'][0])=='m'){$timing=mktime($timing[3],$timing[4],$timing[5],$timing[0],$timing[1],$timing[2]);}
					if(strtolower(self::$config['other']['date_style'][0])=='d'){$timing=mktime($timing[3],$timing[4],$timing[5],$timing[1],$timing[0],$timing[2]);}
					//echo date('Y-m-d H:i:s',$timing);
					//echo $timing-time();
					if($timing<time()+180){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['timing_time_must_be_later_than_current_time_3_minutes']."'}");}
				}else{$timing=0;}
			}
			
			
			$arr=explode(',',self::$config['sms']['disable_phrase']);
			$disable=false;
			foreach($arr as $v){
				//var_dump(strpos($_POST['content'],$v));
				if(strpos($_POST['content'],$v)!==false){$phrase=$v;$disable=true;continue;}	
			}
			if($disable){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['exist_disable_phrase']." ".$phrase."'}");}
			
			$sender=$_SESSION['monxin']['username'];
			$_POST['addressee']=explode(',',$_POST['addressee']);
			$_POST['addressee']=array_unique($_POST['addressee']);
			//$_POST['addressee']=array_filter($_POST['addressee']);
			$addressee='';
			$count=0;
			foreach($_POST['addressee'] as $v){
				if(preg_match(self::$config['other']['reg_phone'],$v)){$addressee.=$v.',';}
			}
			$addressee=trim($addressee,',');
			$addressee=explode(",",$addressee);
			//var_dump($addressee);
			$section=ceil(count($addressee)/self::$config['sms']['max']);
			//echo $section;
			for($i=0;$i<$section;$i++){
				$phone[$i]='';
				for($j=$i*self::$config['sms']['max'];$j<($i+1)*self::$config['sms']['max'];$j++){
					//echo $j.',';
					if(isset($addressee[$j])){$phone[$i].=$addressee[$j].self::$config['sms']['delimiter'];}
				}
				$phone[$i]=trim($phone[$i],self::$config['sms']['delimiter']);
				$temp=explode(self::$config['sms']['delimiter'],$phone[$i]);
				$count=count($temp);
				$length=ceil(sms_content_length($_POST['content'])/(self::$config['sms']['length']/2));
				$count=$length*$count;
				if(!isset($timing)){$timing=0;}
				
				if($phone[$i]!=''){
					$sql="insert into ".$pdo->index_pre."phone_msg (`sender`,`addressee`,`content`,`state`,`time`,`count`,`timing`) values ('$sender','".$phone[$i]."','".$_POST['content']."','1','$time','$count','$timing')";	
					if($pdo->exec($sql)){
						$info="{'state':'success','info':'<span class=success>&nbsp;</span><script>window.location.href='index.php?monxin=".self::$config['class_name'].".phone_msg_sender';</script>'}";
						
						send_sms(self::$config,$pdo,$pdo->lastInsertId());
					}else{
						$info="{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}";
					}
				}
			}
			if($phone[0]==''){$info="{'state':'fail','info':'<span class=fail>".self::$language['phone'].self::$language['pattern_err']."</span>'}";}
			exit($info);
			
			
			
			}

