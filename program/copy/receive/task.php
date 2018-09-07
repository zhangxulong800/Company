<?php
set_time_limit(600);
$regular_id=intval(@$_GET['regular_id']);
$id=intval(@$_GET['id']);
$act=@$_GET['act'];
$show_result=intval(@$_GET['show_result']);
if($id==0){
	//update list
	$time=time();
	$sql="select * from ".self::$table_pre."regular where `switch`=1";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		if(($v['list_update_cycle']+$v['list_update_time'])<$time && $v['list_update_cycle']>0){
			$v=de_safe_str($v);
			$v['list_url']=str_replace('{var}',$v['start_number'],$v['list_url']);
			self::gat_task_list($pdo,$v,$v['id'],$v['list_url']);
			$sql="update ".self::$table_pre."regular set `list_update_time`='".$time."' where `id`=".$v['id'];
			$pdo->exec($sql);
			//echo 'xx';
		}	
	}
	
	
	if($regular_id!=0){
		$sql="select `id` from ".self::$table_pre."task where `regular_id`='".$regular_id."' order by `time` asc limit 0,1";	
	}else{
		$sql="select `id` from ".self::$table_pre."task order by `time` asc limit 0,1";	
	}
	$r=$pdo->query($sql,2)->fetch(2);
	$id=intval($r['id']);	
}
$download_url_prefix='http://'.str_replace('task','file',get_url());

if($id!=0){
	$sql="select * from ".self::$table_pre."task where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit('id err');}
		$sql="select `switch`,`name`,`detail_update_cycle`,`copy_interval` from ".self::$table_pre."regular where `id`=".$r['regular_id'];
		$temp=$pdo->query($sql,2)->fetch(2);
		$copy_interval=$temp['copy_interval'];
		if($temp['switch']==0){
			if($show_result){echo $temp['name'].' switch is off';}
			exit;	
		}
		if($r['state']==1 && $temp['detail_update_cycle']==0){
			
			
			if(isset($_GET['id'])){
				if($show_result){echo $temp['name'].' detail_update_cycle is off';}
				exit();	
			}else{
				$sql="select `id` from ".self::$table_pre."regular where `detail_update_cycle`>0";
				$temp2=$pdo->query($sql,2);
				$regular_ids='';
				foreach($temp2 as $v){
					$regular_ids.=$v['id'].',';	
				}
				$regular_ids=trim($regular_ids,',');
				if($regular_ids==''){
					$js='';
					$download_url=array();
					if(count($download_url)<100){
						$sql="select `id` from ".self::$table_pre."file where `state`=0 order by `id` asc limit 0,50";
						$r=$pdo->query($sql,2);
						foreach($r as $v){
							$download_url[]=$download_url_prefix.'&id='.$v['id'];	
						}	
					}
					foreach($download_url as $v){
						$js.='$.get("'.$v.'");';	
					}
					if($show_result){
						echo '<script>'.$js.'</script>';
						if(!isset($_GET['id'])){
							echo '<script>setTimeout("dalay_reload()",'.($copy_interval*1000).');</script>';	
						}
						
					}else{
						echo $js;	
					}
									
					
					if($show_result){
						if($js!=''){
							echo 'download file,image ing...';
							
						}else{
							echo 'no task';
/*							$sql="select `id`,`save_path` from ".self::$table_pre."file where `state`=1";
							$r=$pdo->query($sql,2);
							$fail='';
							foreach($r as $v){
								if(!file_exists($v['save_path'])){$fail.=$v['id'].',';}	
							}
							$fail=trim($fail,',');
							if($fail!=''){
								$sql="update ".self::$table_pre."file set `state`=0 where `id` in (".$fail.")";
								$pdo->exec($sql);
								header('./receive.php?target=copy.task');
								exit('have files downlaod fial');
							}else{
								echo 'no task to execute';	
							}
							
*/						}
						echo '<script>setTimeout("dalay_reload()",'.($copy_interval*1000).');</script>';	
					}
					exit;	
				}
				$sql="select * from ".self::$table_pre."task where `regular_id` in (".$regular_ids.") order by `time` asc limit 0,1";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['id']==''){
					if($show_result){echo 'no task to execute';}
					exit;	
				}
				
			}	
		}
	$regular_id=$r['regular_id'];
	$data_id=$r['data_id'];
	$sql="select * from ".self::$table_pre."regular where `id`=".$r['regular_id'];
	$reg=$pdo->query($sql,2)->fetch(2);
	if($reg['id']==''){exit('regular_id err');}
	$table=explode(',',$reg['save_to']);
	$open_url=$r['url'];
	$content=curl_open($r['url']);
	if($content==''){exit('can not open url:'.$r['url']);}
	//echo $content;
	if($reg['page_charset']!='' && $reg['page_charset']!='utf-8'){
		$content=iconv($reg['page_charset'],"utf-8",$content);  
	}

$html='';
$download_url=array();
$table_count=array();
$table_c=array();
for($i=0;$i<count($table);$i++){
	$sql="select * from ".self::$table_pre."table where `regular_id`='".$regular_id."' and `name`='".$table[$i]."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['reg']==''){$table_count[$i]=1;$table_c[$i][0]=$content;continue;}
	if($r['multiple']==0){$table_count[$i]=1;$table_c[$i][0]=$content;continue;}
	$r=de_safe_str($r);
	preg_match_all($r['reg'],$content,$c);
	$c[0]=array_unique($c[0]);
	$c[0]=array_values($c[0]);
	$table_count[$i]=count($c[0]);
	//var_dump($table_count[$i]);
	$table_c[$i]=$c[0];
}
$table_index=0;
$insert_id=0;
foreach($table as $v){
	$sub_1_html='';
	//echo $table_count[$table_index].'<hr />';
	for($i=0;$i<$table_count[$table_index];$i++){
		if($data_id && $table_index!=0){continue;}
		$fields='';	
		$values="";
		$update_sql='';			
		$sql="SHOW FULL COLUMNS FROM  `".$pdo->sys_pre.$v."`";
		//echo $sql;
		$r=$pdo->query($sql,2);
		
		//echo $i.'<br>';
		$content=$table_c[$table_index][$i];
		//if($table_index==1){echo $content.'<br />';}
		
		//var_dump($r);
		$sub_2_html='';
		foreach($r as $v2){
			if($v2['Field']=='id'){continue;}
			$value='';
			$sql="select * from ".self::$table_pre."field where `regular_id`='".$regular_id."' and  `table`='".$v."' and `field`='".$v2['Field']."'";
			$v3=$pdo->query($sql,2)->fetch(2);
			if($v3['id']==''){continue;}
			if($data_id  && $v3['auto_update']==0){continue;}
			//echo $sql.'<br />';
			$v3=de_safe_str($v3);
			//var_dump($v3);
			switch($v3['data_source_type']){
				case 0:
					$value=$v3['default_value'];
					if($value=='time()'){$value=time();}
					break;	
				case 1:
					//var_dump($v3['extract_reg']);
					if($v3['extract_reg']!=''){$value=get_match_single($v3['extract_reg'],$content);}
					break;	
				case 2:
					if($v3['data_source_2']!=''){
						$sql="select `".$v3['data_source_2']."` from ".self::$table_pre."task where `id`=".$id;
						$temp=$pdo->query($sql,2)->fetch(2);
						$value=$temp[$v3['data_source_2']];	
					}
					break;	
				case 3:
					if($v3['data_source_3']!=''){
						$sub_url=get_match_single($v3['data_source_3'],$content);
						if(is_url($sub_url)){$content=curl_open($sub_url);}
						if($v3['extract_reg']!=''){$value=get_match_single($v3['extract_reg'],$content);}
					}
					break;	
				case 4:
					if($insert_id!=0 && $v3['data_source_4']!=''){
						$value=$insert[$v3['data_source_4']];	
					}
					break;	
			}
			
			
			if($value!='' && $v3['replace_to']!=''){
				$v3['replace_to']=str_replace(",,,\r",',,,',$v3['replace_to']);
				$v3['replace_to']=str_replace(",,,\n",',,,',$v3['replace_to']);
				$temp=explode(',,,',$v3['replace_to']);
				$temp=array_filter($temp);
				//var_dump($temp);
				foreach($temp as $vv){
					if($vv==''){continue;}
					$temp2=explode('===',$vv);
					if($temp2[0][0]!='/' && $temp2[0][0]!='#'){$temp2[0]='#'.$temp2[0].'#';}
					//echo $temp2[0].'<br />';
					$value=preg_replace($temp2[0],@$temp2[1],$value);
					//echo $value.'<hr >';	
				}	
			}
			if($value==''){$value=$v3['default_value'];}
			switch($v3['data_type']){
				case 0:
					if($v3['allow_html']==0){$value=strip_tags($value,'<img>');}
					if($v3['html_img_save_path']!='' && is_dir($v3['html_img_save_path'])){
						$html_img=get_match_all('#<img .*src=\s?(?:"|\')?(.{5,})(?:"|\')? .*/?>#iUs',$value);
						$html_img=array_unique($html_img);
						$html_img=array_filter($html_img);
						$html_img=array_values($html_img);
						foreach($html_img as $key=>$vvvv){
							$sql="select count(id) as c from ".self::$table_pre."file where `field_id`='".$v3['id']."'";
							$temp=$pdo->query($sql,2)->fetch(2);
							$save_dir=str_replace('//','/',$v3['html_img_save_path'].'/').ceil($temp['c']/100);
							@mkdir($save_dir);
							$html_img[$key]=trim($html_img[$key]);	
							$html_img[$key]=trim($html_img[$key],'"');	
							$html_img[$key]=trim($html_img[$key],"'");
							$absolute_path=get_img_absolute_path($html_img[$key],$open_url);
							$save_path=$save_dir.'/'.md5($html_img[$key].time().rand(1000,9999)).'.'.get_file_postfix($html_img[$key]);
							$value=str_replace($html_img[$key],$save_path,$value);
							$html_img[$key]=$save_path;
							$sql="insert into ".self::$table_pre."file (`task_id`,`field_id`,`url`,`save_path`,`state`) values ('".$id."','".$v3['id']."','".$absolute_path."','".$save_path."',0)";
							//echo $sql.'<br />';
							$pdo->exec($sql);
							$download_url[]=$download_url_prefix.'&id='.$pdo->lastInsertId();
						}
					}
					break;
				case 1:
					if($v3['data_type_img_save_path']!='' && $v!=''){
						$sql="select count(id) as c from ".self::$table_pre."file where `field_id`='".$v3['id']."'";
						$temp=$pdo->query($sql,2)->fetch(2);
						$save_dir=str_replace('//','/',$v3['data_type_img_save_path'].'/').ceil($temp['c']/100);
						@mkdir($save_dir);
						$absolute_path=get_img_absolute_path($value,$open_url);
						$save_path=$save_dir.'/'.md5($value.time().rand(1000,9999)).'.'.get_file_postfix($value);
						$value=str_replace($v3['data_type_img_save_path'],'',$save_path);
						$sql="insert into ".self::$table_pre."file (`task_id`,`field_id`,`url`,`save_path`,`state`) values ('".$id."','".$v3['id']."','".$absolute_path."','".$save_path."',0)";
						//echo $sql.'<br />';
						$pdo->exec($sql);
						$download_url[]=$download_url_prefix.'&id='.$pdo->lastInsertId();
					}
					break;
					
				case 2:
					if($v3['data_type_file_save_path']!='' && $v!=''){
						$sql="select count(id) as c from ".self::$table_pre."file where `field_id`='".$v3['id']."'";
						$temp=$pdo->query($sql,2)->fetch(2);
						$save_dir=str_replace('//','/',$v3['data_type_file_save_path'].'/').ceil($temp['c']/100);
						@mkdir($save_dir);
						$absolute_path=get_img_absolute_path($value,$open_url);
						$save_path=$save_dir.'/'.md5($value.time().rand(1000,9999)).'.'.get_file_postfix($value);
						$value=str_replace($v3['data_type_img_save_path'],'',$save_path);
						$sql="insert into ".self::$table_pre."file (`task_id`,`field_id`,`url`,`save_path`,`state`) values ('".$id."','".$v3['id']."','".$absolute_path."','".$save_path."',0)";
						//echo $sql.'<br />';
						$pdo->exec($sql);
						$download_url[]=$download_url_prefix.'&id='.$pdo->lastInsertId();
					}
					break;	
						
			}
			$show_value=$value;
			$fields.='`'.$v2['Field'].'`,';	
			$values.="'".safe_str($value)."',";	
			$update_sql.="`".$v2['Field']."`='".safe_str($value)."',";		
			$sub_2_html.='<div class=match_line><span class=m_label><span class=s>&nbsp;</span><span class=m>'.$v2['Field'].'/'.$v2['Comment'].'</span><span class=e>&nbsp;</span></span><span class=input_div>'.$show_value.'</span></div>';
		}
		if($data_id){
			if($table_index==0){
				$sql="update ".$pdo->sys_pre.$v." set ".trim($update_sql,',')." where `id`=".$data_id;
				$pdo->exec($sql);	
			}
				
			//echo $sql.'<br />';
			
			if($insert_id==0){
				$insert_id=$data_id;
				$sql="select * from ".$pdo->sys_pre.$v." where `id`=".$insert_id;
				$insert=$pdo->query($sql,2)->fetch(2);	
			}
		}else{
			$sql="insert into ".$pdo->sys_pre.$v." (".trim($fields,',').") values (".trim($values,',').")";	
			//echo $sql.'<br />';
			$pdo->exec($sql);
			if($insert_id==0){
				$insert_id=$pdo->lastInsertId();
				$sql="select * from ".$pdo->sys_pre.$v." where `id`=".$insert_id;
				//echo $sql;
				$insert=$pdo->query($sql,2)->fetch(2);	
			}
		}
	
		$sub_1_html.='<fieldset id="web" style="display: block;"><legend>'.$v.'</legend><div>'.$sub_2_html.'</div></fieldset>';
	}
	$table_index++;
	$html.=$sub_1_html;
}
	if($data_id){
		$sql="update ".self::$table_pre."task set `state`=1,`time`='".time()."' where `id`=".$id;
	}else{
		$sql="update ".self::$table_pre."task set `state`=1,`time`='".time()."',`data_id`='".$insert_id."' where `id`=".$id;
	}
	$pdo->exec($sql);
	
	$js='';
	if(count($download_url)<100){
		$sql="select `id` from ".self::$table_pre."file where `state`=0 order by `id` asc limit 0,".(100-count($download_url));
		$r=$pdo->query($sql,2);
		foreach($r as $v){
			$download_url[]=$download_url_prefix.'&id='.$v['id'];	
		}	
	}
	foreach($download_url as $v){
		$js.='$.get("'.$v.'");';	
	}
	if($show_result){
		echo '<script>'.$js.'</script>';
		echo $html;
		if(!isset($_GET['id'])){
			echo '<script>setTimeout("dalay_reload()",'.($copy_interval*1000).');</script>';	
		}
		
	}else{
		echo $js;
			
	}
}