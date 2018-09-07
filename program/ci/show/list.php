<?php
self::update_top_price($pdo,self::$table_pre);
$_GET['type']=intval(@$_GET['type']);
$module['data']['top_html']='';
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$show_method=(isset($_GET['show_method']))?$_GET['show_method']:'show_grid';
$module['ad']='';
$search_type=false;
if($_GET['search']!='' && !isset($_GET['no_search_type'])){
	$sql="select `id` from ".self::$table_pre."type where `visible`=1 and (`url`='' or `url` is null) and `name`='".$_GET['search']."' order by `parent` asc,`sequence` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){
		$sql="select `id` from ".self::$table_pre."type where `visible`=1 and (`url`='' or `url` is null) and  `name` like '%".$_GET['search']."%' order by `parent` asc,`sequence` desc  limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
	}
	if($r['id']!='' && strlen($_GET['search'])>5){$_GET['type']=$r['id'];$_GET['search']='';$search_type=true;}
}
$unit='';
$attribute_field='';
$field=',`icon`,`title`,`content`,`reflash`,`linkman`,`contact`';
$field_array=array('icon','title','content','reflash','linkman','contact');
if($_GET['search']==''){
	
	if($_GET['type']!=0){
		$sql="select `remark`,`list_show`,`id` from ".self::$table_pre."type where `id`=".$_GET['type'];
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){header('location:./index.php');exit;}
		$r=de_safe_str($r);
		$module['ad']='<div class=ad>'.$r['remark'].'</div>';
		$temp=explode(',',$r['list_show']);
		$field='';
		$field_array=array();
		foreach($temp as $v){
			if($v==''){continue;}
			if(is_numeric($v)){
				$attribute_field.=$v.',';
			}else{
				$field.=',`'.$v.'`';
			}	
			$field_array[]=$v;
		}
		$attribute_field=trim($attribute_field,',');
	}
	
	$sql="select `name`,`id` from ".self::$table_pre."type where `visible`=1 and `parent`=".$_GET['type']." order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$module['data']['top_html'].='<a href=index.php?monxin=ci.list&type='.$v['id'].' id=type_a_'.$v['id'].'>'.$v['name'].'</a>';	
	}
	if($module['data']['top_html']!=''){$module['data']['top_html']='<div id=type><div class=top_label>'.self::$language['type'].':</div><div class=top_html>'.$module['data']['top_html'].'</div></div>';}
	
}


$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select `id`,`top_price`".$field." from ".self::$table_pre."content where `state`=1";

$where="";
if($_GET['type']>0){
	$type_ids=$this->get_type_ids($pdo,$_GET['type']);
	$where.=" and `type` in (".$type_ids.")";
	
	
	$t_sql="select * from ".self::$table_pre."type where `id`=".$_GET['type'];
	$type_r=$pdo->query($t_sql,2)->fetch(2);
	$unit=$type_r['unit'];
					  //===================================================================================================================================================get_price
	$r=$type_r;
	
	if($r['price']!=''){
		$r['price']=de_safe_str($r['price']);
		$temp2=explode(',',$r['price']);
		$temp='';
		foreach($temp2 as $v){
			$temp3=explode('-',$v);
			if(isset($temp3[1])){
				$v=self::format_price(intval($temp3[0]),'',self::$language['million']).'-'.self::format_price(intval(@$temp3[1]),'',self::$language['million']);
			}else{
				$v=self::format_price(intval($temp3[0]),'',self::$language['million']).self::$language['above'];	
			}
			
			$temp.='<a href=# min_price='.intval($temp3[0]).' max_price='.@$temp3[1].'>'.$v.'</a>';	
		}
		if($temp!=''){
			$module['data']['top_html'].='<div id=price><div class=top_label>'.self::$language['type_price'].':</div><div class=top_html><a href=# min_price=-1 max_price= >'.self::$language['unlimited'].'</a>'.$temp.'</div></div>';	
		}	
	}

	$t_sql="select `id` from ".self::$table_pre."type where `parent`='".$_GET['type']."' limit 0,1";
	$r=$pdo->query($t_sql,2)->fetch(2);
	if($r['id']==''){						//=============================================================================================================================================get_attribute
		$t_sql="select `id`,`name`,`input_args`,`input_type` from ".self::$table_pre."type_attribute where `type_id`=".$_GET['type']." and `screening_show`=1 and (`input_type`='select' or `input_type`='checkbox' or `input_type`='radio') order by `sequence` desc";
		$r=$pdo->query($t_sql,2);
		$temp='';
		foreach($r as $v){
			$v=de_safe_str($v);
			$args=format_attribute($v['input_args']);
			switch ($v['input_type']) {
				case 'select':
					$temp3=explode('/',$args['select_option']);
					break;	
				case 'radio':
					$temp3=explode('/',$args['radio_option']);
					break;	
				case 'checkbox':
					$temp3=explode('/',$args['checkbox_option']);
					break;	
			}
			$temp3=array_filter($temp3);
			$temp2='';
			
			foreach($temp3 as $v2){
				$temp2.='<a href=#>'.$v2.'</a>';
			}
			$temp.='<div class=attribute id=a_'.$v['id'].'><div class=top_label old_name="'.$v['name'].'">'.$v['name'].':</div><div class=top_html><a href=# a_'.$v['id'].'=0>'.self::$language['unlimited'].'</a>'.$temp2.'</div></div>';	
		}
		if($temp!=''){
			$module['data']['top_html'].=$temp;	
		}	
		
		//========================================================================================================================================attribute sql
		foreach($_GET as $k=>$v){
			if(is_match('#a_[0-9]{1}#iU',$k) && $v!=''){
				$t_sql="select `c_id` from ".self::$table_pre."attribute_value where `a_id`=".intval(str_replace('a_','',$k))." and `content`='".safe_str($v)."'";
				$r=$pdo->query($t_sql,2);
				$temp=array();
				foreach($r as $v){
					$temp[$v['c_id']]=$v['c_id'];	
				}
				if(count($temp)>0){$where.=' and `id` in ('.implode(',',$temp).')';}else{$where.=' and `id`=0';}
			}	
		}
	}


}

$circle=intval($_COOKIE['circle']);
if($circle>0){
	$circle=get_circle_ids($pdo,$circle);
	$sql.=" and `circle` in (".$circle.")";	
}
	
$_GET['tag']=intval(@$_GET['tag']);
if($_GET['tag']>0){
	$where.=" and `tag` like '%|".$_GET['tag']."|%'";
}
if(intval(@$_GET['brand'])>0){
	$where.=" and `brand`=".$_GET['brand']."";
}

if(intval(@$_GET['min_price'])!=0){
	$where.=" and `price`>=".intval($_GET['min_price']);	
}
if(intval(@$_GET['max_price'])!=0){
	$where.=" and `price`<=".intval($_GET['max_price']);	
}
if($_GET['search']!=''){
	$where.=" and (`title` like '%".$_GET['search']."%')";
	if($_GET['current_page']==1 && !isset($_GET['click'])){
		$temp_sql="select `id` from ".self::$table_pre."search_log where `keyword`='".$_GET['search']."' limit 0,1";
		$r=$pdo->query($temp_sql,2)->fetch(2);
		if($r['id']==''){
			$temp_sql="insert into ".self::$table_pre."search_log (`keyword`) values ('".$_GET['search']."')";	
		}else{
			$temp_sql="update ".self::$table_pre."search_log set `sum`=`sum`+1,`year`=`year`+1,`month`=`month`+1,`week`=`week`+1,`day`=`day`+1 where `id`=".$r['id'];
		}
		$pdo->exec($temp_sql);
	}
}

$_GET['order']=safe_str(@$_GET['order']);
if($_GET['order']==''){
	if($_GET['type']==0){$order=" order by `id` desc";}else{$order=" order by `sequence` desc,`top_price` desc,`reflash` desc";}
}else{
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}
$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `id`,`top_price`".$field." "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_content and","_content where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_content and","_content where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
$time=time();
//var_dump($field_array);
foreach($r as $v){
	$v=de_safe_str($v);
	$width=100;
	$icon='';
	$price='';
	$reflash='';
	$title='';
	$content='';
	$other='';
	$linkman='';
	$contact='';
	if(in_array('icon',$field_array)){
		if($_COOKIE['monxin_device']=='pc'){$width-=12;}else{$width-=30;}
		
		$icon='<a href=./index.php?monxin=ci.detail&id='.$v['id'].' target='.self::$config['target'].' class=icon><img wsrc=./program/ci/img_thumb/'.$v['icon'].' /></a>';	
	}
	if(in_array('price',$field_array)){
		if($_COOKIE['monxin_device']=='pc'){$width-=10;}
		if($v['price']>0){
			$price='<span class=price>'.self::format_price($v['price'],self::$language['yuan'],self::$language['million_yuan']).'<span class=unit>'.$unit.'</span></span>';
		}else{
			$price='<span class=price>'.self::$language['negotiable'].'</span>';
		}
			
	}
	if(in_array('reflash',$field_array)){
		if($_COOKIE['monxin_device']=='pc'){$width-=10;}
		$reflash="<span class=reflash>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['reflash'])."</span>";	
	}
	if(in_array('title',$field_array)){
		if($v['top_price']>0){$v['title'].=' <span href="'.self::$config['top_url'].'" class="top_icon">'.self::$language['top_short'].'</span>';}
		$title='<a href=./index.php?monxin=ci.detail&id='.$v['id'].' target='.self::$config['target'].' class=title>'.$v['title'].'</a>';	
	}
	if(in_array('content',$field_array)){
		$content='<div class=content>'.mb_substr(strip_tags($v['content']),0,100,'utf-8').'</div>';	
	}
	if(in_array('linkman',$field_array)){
		$linkman='<span class=linkman>'.$v['linkman'].'</span>';	
	}
	if(in_array('contact',$field_array)){
		$contact='<span class=contact>'.$v['contact'].'</span>';	
	}
	if($linkman!='' || $contact!=''){$other=$linkman.$contact;}
	if($_GET['type']!=0){
		$a_ids='';
		foreach($field_array as $v3){
			if(is_numeric($v3)){$a_ids.=$v3.',';}	
		}
		//var_dump($a_ids);
		if($a_ids!=''){
			$a_ids=trim($a_ids,',');
			$sql="select `a_id`,`content` from ".self::$table_pre."attribute_value where `c_id`=".$v['id']." and `a_id` in (".$a_ids.")";
			$r2=$pdo->query($sql,2);
			$at=array();
			foreach($r2 as $v2){
				$at[$v2['a_id']]=trim($v2['content'],'/');	
			}
			$sql="select `id`,`postfix` from ".self::$table_pre."type_attribute where `id` in (".$a_ids.") order by `sequence` desc";
			$r2=$pdo->query($sql,2);
			foreach($r2 as $v2){
				$other.='<span>'.@$at[$v2['id']].'<postfix>'.$v2['postfix'].'</postfix></span>';	
			}
		}
		
	}
	
	if($other!=''){
		$other='<div class=other>'.$other.'</div>';	
	}
	//var_dump($other);
	$list.="<div class=line id=i_".$v['id'].">".$icon."<div class=middle style='width:".$width."%;'>".$title.$content.$other."</div>".$price.$reflash."</div>";
		
}
if($sum==0){
	if($search_type){header('location:http://'.get_url().'&no_search_type=ture');exit;}
	$list='<div align="center"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></div>';
}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=MonxinDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],false);


if(@$_GET['tag']!=''){
	$sql="select `name` from ".self::$table_pre."tag where `id`=".intval($_GET['tag']);
	$r=$pdo->query($sql,2)->fetch(2);
	$visitor_position_reset='<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="./index.php?monxin=ci.list">'.self::$language['pages']['ci.list']['name'].'</a>'.$r['name'].'</div>';
}elseif(@$_GET['search']!=''){
	$visitor_position_reset='<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="./index.php?monxin=ci.list">'.self::$language['pages']['ci.list']['name'].'</a>'.$_GET['search'].'</div>';
}else{
	$visitor_position_reset='<div id="visitor_position_reset" style="display:none;"><span id=current_position_text>'.self::$language['current_position'].'</span><a href="./index.php"><span id=visitor_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a>'.$this->get_type_position($pdo,$_GET['type']).'</div>';
}

$module['circle_list']='';
$module['circle_list_sub']='';
$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`=0 and `visible`=1 order by `sequence` desc,`id` asc";
$r=$pdo->query($sql,2);
$module['circle_list']='<a href="#" circle=0>'.self::$language['unlimited'].'</a>';
foreach($r as $v){
	$sub='';
	$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc,`id` asc";
	$r2=$pdo->query($sql,2);
	foreach($r2 as $v2){
		$sub.='<a href="#" circle='.$v2['id'].'>'.de_safe_str($v2['name']).'</a>';	
	}
	if($sub!=''){$sub='<div upid='.$v['id'].' >'.$sub.'</div>';}
	$module['circle_list_sub'].=$sub;
	$module['circle_list'].='<a href="#"  circle='.$v['id'].'>'.de_safe_str($v['name']).'</a>';
}
$module['circle_filter']='<div class=circle_filter>
            <div class=top_label>'.self::$language['circle'].':</div><div class=top_html>
                <div class=circle_1>'. $module['circle_list'].'</div>
                <div class=circle_2>'.$module['circle_list_sub'].'</div>
            </div>
        </div>';

$module['data']['top_html']=$module['circle_filter'].$module['data']['top_html'];
if($_COOKIE['monxin_device']=='pc'){
	if($module['data']['top_html']!=''){$module['data']['top_html']='<div class=top>'.$module['data']['top_html'].'</div>';}
}else{
	if($module['data']['top_html']!=''){$module['data']['top_html']='<div class=top><div class=diy_price><span>'.self::$language['price_region'].'</span><span><input type=text class=min_price placeholder="'.self::$language['min_value'].'" /> - <input type=text class=max_price placeholder="'.self::$language['max_value'].'" /></span></div>'.$module['data']['top_html'].'<div class=confirm_div><a href=# class=left_return>'.self::$language['return'].'</a><a href="./index.php?monxin=ci.list" class=determine user_color=button>'.self::$language['determine'].'</a></div></div>';}
}



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);

echo $visitor_position_reset;