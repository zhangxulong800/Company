<?php
		function echo_html($language,$pdo,$key,$v){
			
			
			$config_language=$language['config_language'];
			
			$key2=str_replace(",","__",$key);
			//echo $key2.'<br>';
			$key=explode(',',$key);
			if(!isset($config_language[$key[0]])){var_dump($config_language[$key[0]]);}
			if(count($key)==2){$config_language=$config_language[$key[0]];}
			if(count($key)==3){$config_language=$config_language[$key[0]][$key[1]];}
			//var_dump($key);	
			//echo '<hr/>';	
			$upkey=$key[count($key)-2];
			$key=$key[count($key)-1];
			$div='';
			switch ($key){
				case ($key=='site_id' && $upkey=='web'):
				//var_dump($config_language);
					$div='<div id=div_'.$key2.'><span class="m_label">'.@$config_language[$key].'</span><span class="content">'.$v.'</span></div>';
					break;
				case ($key=='site_key' && $upkey=='web'):
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content">'.$v.' <a href=# class=reset_site_key>'.$language['reset'].'</a></span></div>';
					break;
					
				case ($key=='language' && $upkey=='web'):
					$option='';
					$r=scandir('./language/');
					foreach($r as $vv){
						if(!is_dir('./language/'.$vv)){
							$vv=str_replace(".php",'',$vv);
							$vv=str_replace(".PHP",'',$vv);
							//echo $v.'='.$vv.'<br/>';
							if($v==$vv){$selected='selected';}else{$selected='';}
							if(!isset($language['language_dir'][$vv])){$language['language_dir'][$vv]=$vv;}
							$option.='<option value="'.$vv.'" '.$selected.'>'.$language['language_dir'][$vv].'</option>';	
						}	
					}
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.'>'.$option.'</select><span id='.$key2.'_state ></span> <a href="./index.php?monxin=index.language_list&program=os_language">'.$language['edit'].'</a></span></div>';
					break;
					
				case ($key=='authcode_push_mode' && $upkey=='web'):
					$option='';
					foreach($language['authcode_push_mode_option'] as $kk=>$vv){
						$option.='<option value="'.$kk.'">'.$vv.'</option>';	
					}
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.' monxin_value='.$v.'>'.$option.'</select><span id='.$key2.'_state ></span></span></div>';
					break;
					
				case ($key=='balance_pay_check' && $upkey=='web'):
					$option='';
					foreach($language['balance_pay_check_option'] as $kk=>$vv){
						$option.='<option value="'.$kk.'">'.$vv.'</option>';	
					}
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.' monxin_value='.$v.'>'.$option.'</select><span id='.$key2.'_state ></span></span></div>';
					break;
				case ($key=='other_push_mode' && $upkey=='web'):
					$option='';
					foreach($language['other_push_mode_option'] as $kk=>$vv){
						$option.='<option value="'.$kk.'">'.$vv.'</option>';	
					}
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.' monxin_value='.$v.'>'.$option.'</select><span id='.$key2.'_state ></span></span></div>';
					break;
					
				case ($key=='template' && $upkey=='web'):
					$option='';
					$r=scandir('./templates/index/');
					foreach($r as $vv){
						if(is_dir('./templates/index/'.$vv) && $vv!='.' && $vv!='..'){
							if($v==$vv){$selected='selected';}else{$selected='';}
							if(!isset($language['template_dir'][$vv])){$language['template_dir'][$vv]=$vv;}
							$option.='<option value="'.$vv.'" '.$selected.'>'.$language['template_dir'][$vv].'</option>';	
						}	
					}
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.'>'.$option.'</select><span id='.$key2.'_state ></span></span></div>';
					break;
				case ($key=='map_api' && $upkey=='web'):
					$option='<option value="baidumap">Baidu</option>';
					$option.='<option value="googlemap">Google</option>';
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.' monxin_value='.$v.'>'.$option.'</select><span id='.$key2.'_state ></span></span></div>';
					break;
					
				case ($key=='group_upgrade' && $upkey=='web'):
					$option='<option value="money">'.$language['group_upgrade_option']['money'].'</option>';
					$option.='<option value="credits">'.$language['group_upgrade_option']['credits'].'</option>';
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.' monxin_value='.$v.'>'.$option.'</select><span id='.$key2.'_state ></span></span></div>';
					break;
					
					
				case ($key=='phone_country' && $upkey=='reg_set'):
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.' monxin_value='.$v.'>'.get_phone_country_opton($language['phone_country']).'</select><span id='.$key2.'_state ></span></span></div>';
					break;
					
				case ($key=='check' && $upkey=='reg_set'):
					
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.' monxin_value='.$v.'><option value=image>'.$language['config_language']['reg_set']['check_option']['image'].'</option><option value=phone>'.$language['config_language']['reg_set']['check_option']['phone'].'</option><option value=email>'.$language['config_language']['reg_set']['check_option']['email'].'</option><option value=weixin>'.$language['config_language']['reg_set']['check_option']['weixin'].'</option></select><span id='.$key2.'_state ></span></span></div>';
					break;
				case ($key=='default_group_id' && $upkey=='reg_set'):
					$sql="select `id`,`name` from ".$pdo->index_pre."group where `reg_able`=1 order by `parent` asc,`sequence` desc";
					$r=$pdo->query($sql,2);
					$option='';
					foreach($r as $v2){
						$option.='<option value='.$v2['id'].'>'.$v2['name'].'</option>';
					}
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.' monxin_value='.$v.'>'.$option.'</select><span id='.$key2.'_state ></span></span></div>';
					break;
				case ($key=='cache_type' && $upkey=='cache'):
					if($v=='file'){$memcache='';$file='selected';}else{$file='';$memcache='selected';}
					$option='<option value="file" '.$file.'>'.$language['cache_type']['file'].'</option>';
					$option.='<option value="memcache" '.$memcache.'>'.$language['cache_type']['memcache'].'</option>';
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.'>'.$option.'</select><span id='.$key2.'_state ></span></span></div>';
					break;
										
				case ($key=='time_style' && $upkey=='sms'):
					$option='<option value="Unix" '.return_selected($v,"Unix").'>'.$language['time_style']['Unix'].'</option>';
					$option.='<option value="Y-m-d H:i:s" '.return_selected($v,"Y-m-d H:i:s").'>'.$language['time_style']['Ymd'].'</option>';
					$option.='<option value="m-d-Y H:i:s" '.return_selected($v,"m-d-Y H:i:s").'>'.$language['time_style']['mdY'].'</option>';
					$option.='<option value="d-m-Y H:i:s" '.return_selected($v,"d-m-Y H:i:s").'>'.$language['time_style']['dmY'].'</option>';
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.'>'.$option.'</select><span id='.$key2.'_state ></span></span></div>';
					break;
				case ($key=='apikey' && $upkey=='sms'):
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><input type="text" id="'.$key2.'" name="'.$key2.'" value=\''.$v.'\' /><span id='.$key2.'_state ></span> <a href=https://www.yunpian.com/entry?method=register&utm_source=monxin target=_blank>'.$language['create'].'</a> <a href=http://www.monxin.com/index.php?monxin=doc.show&key=yunpian target=_blank>'.$language['tutorial'].'</a></span></div>';
					break;
										
				case ($key=='timeoffset' && $upkey=='other'):
					$option='<option value="-12"  '.return_selected($v,"-12").'>'.$language['timeoffset']['-12'].'</option>';
					$option.='<option value="-11"  '.return_selected($v,"-11").'>'.$language['timeoffset']['-11'].'</option>';
					$option.='<option value="-10"  '.return_selected($v,"-10").'>'.$language['timeoffset']['-10'].'</option>';
					$option.='<option value="-9"  '.return_selected($v,"-9").'>'.$language['timeoffset']['-9'].'</option>';
					$option.='<option value="-8"  '.return_selected($v,"-8").'>'.$language['timeoffset']['-8'].'</option>';
					$option.='<option value="-7"  '.return_selected($v,"-7").'>'.$language['timeoffset']['-7'].'</option>';
					$option.='<option value="-6"  '.return_selected($v,"-6").'>'.$language['timeoffset']['-6'].'</option>';
					$option.='<option value="-5"  '.return_selected($v,"-5").'>'.$language['timeoffset']['-5'].'</option>';
					$option.='<option value="-4"  '.return_selected($v,"-4").'>'.$language['timeoffset']['-4'].'</option>';
					$option.='<option value="-3.5"  '.return_selected($v,"-3.5").'>'.$language['timeoffset']['-3.5'].'</option>';
					$option.='<option value="-3"  '.return_selected($v,"-3").'>'.$language['timeoffset']['-3'].'</option>';
					$option.='<option value="-2"  '.return_selected($v,"-2").'>'.$language['timeoffset']['-2'].'</option>';
					$option.='<option value="-1"  '.return_selected($v,"-1").'>'.$language['timeoffset']['-1'].'</option>';
					$option.='<option value="0"  '.return_selected($v,"0").'>'.$language['timeoffset']['0'].'</option>';
					$option.='<option value="1"  '.return_selected($v,"1").'>'.$language['timeoffset']['1'].'</option>';
					$option.='<option value="2"  '.return_selected($v,"2").'>'.$language['timeoffset']['2'].'</option>';
					$option.='<option value="3"  '.return_selected($v,"3").'>'.$language['timeoffset']['3'].'</option>';
					$option.='<option value="3.5"  '.return_selected($v,"3.5").'>'.$language['timeoffset']['3.5'].'</option>';
					$option.='<option value="4"  '.return_selected($v,"4").'>'.$language['timeoffset']['4'].'</option>';
					$option.='<option value="4.5"  '.return_selected($v,"4.5").'>'.$language['timeoffset']['4.5'].'</option>';
					$option.='<option value="5"  '.return_selected($v,"5").'>'.$language['timeoffset']['5'].'</option>';
					$option.='<option value="5.5"  '.return_selected($v,"5.5").'>'.$language['timeoffset']['5.5'].'</option>';
					$option.='<option value="5.75"  '.return_selected($v,"5.75").'>'.$language['timeoffset']['5.75'].'</option>';
					$option.='<option value="6"  '.return_selected($v,"6").'>'.$language['timeoffset']['6'].'</option>';
					$option.='<option value="6.5"  '.return_selected($v,"6.5").'>'.$language['timeoffset']['6.5'].'</option>';
					$option.='<option value="7"  '.return_selected($v,"7").'>'.$language['timeoffset']['7'].'</option>';
					$option.='<option value="8"  '.return_selected($v,"8").'>'.$language['timeoffset']['8'].'</option>';
					$option.='<option value="9"  '.return_selected($v,"9").'>'.$language['timeoffset']['9'].'</option>';
					$option.='<option value="9.5"  '.return_selected($v,"9.5").'>'.$language['timeoffset']['9.5'].'</option>';
					$option.='<option value="10"  '.return_selected($v,"10").'>'.$language['timeoffset']['10'].'</option>';
					$option.='<option value="11"  '.return_selected($v,"11").'>'.$language['timeoffset']['11'].'</option>';
					$option.='<option value="12"  '.return_selected($v,"12").'>'.$language['timeoffset']['12'].'</option>';
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.'>'.$option.'</select><span id='.$key2.'_state ></span></span></div>';
					break;
										
				case ($key=='description' && $upkey=='web'):
					$div='<div id=div_'.$key2.' ><span class="m_label">'.$config_language[$key].'<br /><br /></span><span class="content"><textarea  id="'.$key2.'" name="'.$key2.'" style="height:80px; display:inline-block; " >'.$v.'</textarea><span id='.$key2.'_state ></span></span></div>';
					break;
				case ($key=='diy_meta' && $upkey=='web'):
					$div='<div id=div_'.$key2.' ><span class="m_label">'.$config_language[$key].'<br /><br /></span><span class="content"><textarea  id="'.$key2.'" name="'.$key2.'" style="height:80px; display:inline-block; " >'.$v.'</textarea><span id='.$key2.'_state ></span></span></div>';
					break;
				case ($key=='disable_phrase' && $upkey=='sms'):
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'<br /><br /></span><span class="content"><textarea  id="'.$key2.'" name="'.$key2.'" style="height:80px; display:inline-block; " >'.$v.'</textarea><span id='.$key2.'_state ></span></span></div>';
					break;

				case ($key=='type' && $upkey=='image_mark'):
					if($v=='text'){$logo='';$text='selected';}else{$text='';$logo='selected';}
					$option='<option value="text" '.$text.'>'.$language['mark_type']['text'].'</option>';
					$option.='<option value="logo" '.$logo.'>'.$language['mark_type']['logo'].'</option>';
					$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.'>'.$option.'</select><span id='.$key2.'_state ></span></span></div>';
					break;
					
				case ($key=='position' && $upkey=='image_mark'):
					$content='<style>.a_current_position{display:inline-block;width:105px; height:40px;text-align:center; color:#FFFFFF;background-color:#0066CC;}
					
					.a{display:inline-block;width:105px; height:40px;text-align:center; color:#0066CC;background-color:#FFFFFF;} 
					.a_over{display:inline-block;width:105px; height:40px;text-align:center; color:#0066CC;background-color:#FFFF00;} 
					</style><table width="100" border="1" cellspacing="0" id="'.$key.'_table">
        <tr>
          <td><a href="1" id="position_1" class="a">'.$language['mark_position']['top_left'].'</a></td>
          <td><a href="2" id="position_2" class="a">'.$language['mark_position']['top_mid'].'</a></td>
          <td><a href="3" id="position_3" class="a">'.$language['mark_position']['top_right'].'</a></td>
        </tr>
        <tr>
          <td><a href="4" id="position_4" class="a">'.$language['mark_position']['mid_left'].'</a></td>
          <td><a href="5" id="position_5" class="a">'.$language['mark_position']['mid_mid'].'</a></td>
          <td><a href="6" id="position_6" class="a">'.$language['mark_position']['mid_right'].'</a></td>
		</tr>
        <tr>
          <td><a href="7" id="position_7" class="a">'.$language['mark_position']['bottom_left'].'</a></td>
          <td><a href="8" id="position_8" class="a">'.$language['mark_position']['bottom_mid'].'</a></td>
          <td><a href="9" id="position_9" class="a">'.$language['mark_position']['bottom_right'].'</a></td>
        </tr>
	<tr><td colspan="3"><a href="10"  id="position_10"  class="a" style="width:100%;">'.$language['mark_position']['random'].'</a></td></tr>


	</table>';
					$div='<div id=div_'.$key2.' style="height:220px;"><span class="m_label">'.$config_language[$key].'</span><span class="content"><input type="hidden" id="'.$key2.'" name="'.$key2.'" value="'.$v.'" />'.$content.'<span id='.$key2.'_state ></span></span></div>';
					break;
					

					
				case ($key=='water_logo' && $upkey=='image_mark'):
					require_once "./plugin/html4Upfile/createHtml4.class.php";
					$html4Upfile=new createHtml4();
					echo "<span id='".$key2."_ele'>";
					$html4Upfile->echo_input($key2,'100px;','./temp/','true','false','jpg|gif|png|jpeg','500','5');
					echo '</span>';
					$div='<div id=div_'.$key2.' style="height:220px;overflow:hidden;"><span class="m_label">'.$config_language[$key].'<br /><br /></span><span class="content" ><span id='.$key2.'_state></span><img src='.$v.'></span></div>';
					break;
				
				case ($key=='ttf_path' && $upkey=='image_mark'):
					require_once "./plugin/html4Upfile/createHtml4.class.php";
					$html4Upfile=new createHtml4();
					echo "<span id='".$key2."_ele'>";
					$html4Upfile->echo_input($key2,'100px;','./temp/','true','false','ttf','50000','1');
					echo '</span>';

					$div='<div id=div_'.$key2.' style="height:100px;"><span class="m_label">'.$config_language[$key].'</span><span class="content">'.$v.' &nbsp; '.format_size(filesize($v)).'<br/><span id='.$key2.'_state></span></span></div>';
					break;
				
				default:
					if($v===true || $v===false){
						if($v==true){$false='';$true='selected';}else{$true='';$false='selected';}
						$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><select id='.$key2.' name='.$key2.'><option value="true" '.$true.'>'.$language['true'].'</option><option value="false" '.$false.'>'.$language['false'].'</option></select><span id='.$key2.'_state ></span></span></div>';
					}else{
						$div='<div id=div_'.$key2.'><span class="m_label">'.$config_language[$key].'</span><span class="content"><input type="text" id="'.$key2.'" name="'.$key2.'" value=\''.$v.'\' /><span id='.$key2.'_state ></span></span></div>';
					}
					break;
	
			}
			return $div;
		}
		
		$config=require('./config.php');
		$language=self::$language['config_language'];
			$module['list']='';
			foreach($config as $key=>$v){
				if($key=='unlogin_function_power' || $key=='program' || $key=='no_update'){continue;}
				if(is_array($v)){
					$module['list'].='<fieldset id='.$key.' style="display:none;"><legend>'.$language[$key]['this_name'].'</legend>';
					
							foreach($v as $key2=>$v2){
								if(is_array($v2)){
									$module['list'].='<fieldset><legend>'.$language[$key][$key2]['this_name'].'</legend>';
									
												foreach($v2 as $key3=>$v3){
													if(is_array($v3)){
														$module['list'].='<fieldset><legend>'.$language[$key][$key2][$key3]['this_name'].'</legend>';
														
														
														
														$module['list'].='</fieldset>';
														
													}else{
														$module['list'].=echo_html(self::$language,$pdo,$key.','.$key2.','.$key3,$v3);
													}
													
												}
									
									$module['list'].='</fieldset>';
									
								}else{
									$module['list'].=echo_html(self::$language,$pdo,$key.','.$key2,$v2);
								}
								
							}
					
					$module['list'].='</fieldset>';
					
				}
				
			}
			//$module['list'];
		
		
		
		
		
		$module['mark_position']=$config['image_mark']['position'];
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$module['monxin_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['monxin_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);

