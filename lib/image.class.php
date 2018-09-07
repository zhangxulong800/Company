<?php
class image{
	/*
	//$image =new Image();
	//$state=$image->thumb("test/test.jpg","test/th_test.jpg",-1,150);
	//$state=$image->addMark("test/test.jpg");
	*/
	
	function thumb($open_path,$save_path,$width,$height,$free_size=true){
		if(!is_file($open_path)){return false;}
		$info=$this->getInfo($open_path);
		//if($info['width']<$width || $info['height']<$height){return true;}
		$size=$this->get_thumb_size($info['width'],$info['height'],$width,$height,$free_size);
		switch($info['type']){
			case 1: //gif
				return $this->thumb_gif($open_path,$save_path,$size['width'],$size['height']);
				break;
			case 2: //jpg
				return $this->thumb_jpeg($open_path,$save_path,$size['width'],$size['height']);
				break;
			case 3: //png
				return $this->thumb_png($open_path,$save_path,$size['width'],$size['height']);
				break;
		}
	}
	
	function addMark($open_path,$save_path=''){
		if(!is_file($open_path)){return false;}
		if($save_path==''){$save_path=$open_path;}
		$config=require("config.php");
		if($config['image_mark']['type']=='logo'){
		 	return $this->imageMark($open_path,$save_path,$config['image_mark']['water_logo'],$config['image_mark']['position'],$config['image_mark']['opacity']);
		}else{
			return $this->textMark($config['web']['name'],$open_path,$save_path,$config['image_mark']['opacity'],$config['image_mark']['color'],$config['image_mark']['font_size'],$config['image_mark']['font_angle'],$config['image_mark']['position'],$config['image_mark']['ttf_path']);
		}	
	}
	function textMark($text,$open_path,$save_path,$opacity,$color,$font_size,$font_angle,$position,$ttf_path){
		$groundImg_info=$this->getInfo($open_path);
		if($groundImg_info['width']<$font_size*strlen($text) || $groundImg_info['height']<$font_size){return true;}
		$groundImg=$this->getImg($open_path,$groundImg_info);
		$color=imagecolorallocatealpha($groundImg,$color[0],$color[1],$color[2],$opacity);//
		$start=$this->get_text_start($groundImg_info['width'],$groundImg_info['height'],$position,$text,$ttf_path,$font_size,$font_angle);
		imagettftext($groundImg,$font_size,$font_angle,$start['left'],$start['top'],$color,$ttf_path,$text);
		$state=$this->saveImg($groundImg,$save_path,$groundImg_info);
		imagedestroy($groundImg);
		return $state;
	}
	
	
	
	function imageMark($open_path,$save_path,$logo_path,$position,$opacity,$bg=0){
		$groundImg_info=$this->getInfo($open_path);
		$groundImg=$this->getImg($open_path,$groundImg_info);
		
		
		$logoImg_info=$this->getInfo($logo_path);
		$logoImg=$this->getImg($logo_path,$logoImg_info);
		if($logoImg_info['width']>$groundImg_info['width'] || $logoImg_info['height']>$groundImg_info['height']){
			imagedestroy($groundImg);
			imagedestroy($logoImg);
			return true;
		}
		$start=$this->get_logo_start($groundImg_info['width'],$groundImg_info['height'],$logoImg_info['width'],$logoImg_info['height'],$position);
		$groundImg=$this->exe_merge($groundImg,$logoImg,$logoImg_info,$start['left'],$start['top'],$opacity);
		if($groundImg_info['type']==3){//==png
			$alpha = imagecolorallocatealpha($groundImg, 0, 0, 0, 127);
			if($bg){$alpha = imagecolorallocatealpha($groundImg, 255, 255, 255, 0);}
			imagefill($groundImg, 0, 0, $alpha);
			imagesavealpha($groundImg, true);
		}

		$state=$this->saveImg($groundImg,$save_path,$groundImg_info);
		imagedestroy($groundImg);
		imagedestroy($logoImg);
		return $state;
	}
	
	
	
	private function get_thumb_size($original_width,$original_height,$width,$height,$free_size){
		if(!$free_size){
			$size['width']=$width;
			$size['height']=$height;
			return $size;
		}
		$scaleX=$original_width/$width;
		if($width==-1){$scaleX=0;}
		$scaleY=$original_height/$height;
		if($height==-1){$scaleY=0;}
		$scale=max($scaleX,$scaleY);
		$size['width']=ceil($original_width/$scale);	
		$size['height']=ceil($original_height/$scale);	
		return $size;
		
	}
	
	private function get_logo_start($ground_width,$ground_height,$logo_width,$logo_height,$position){ 
		$margin=10;
		switch($position){
			case 1:
				$left=$margin;
				$top=$margin;
				break;
			case 2:
				$left=ceil($ground_width/2)-ceil($logo_width/2);
				$top=$margin;
				break;
			case 3:
				$left=$ground_width-$logo_width-$margin;
				$top=$margin;
				break;
			case 4:
				$left=$margin;
				$top=ceil($ground_height/2)-ceil($logo_height/2);
				break;
			case 5:
				$left=ceil($ground_width/2)-ceil($logo_width/2);
				$top=ceil($ground_height/2)-ceil($logo_height/2);
				break;
			case 6:
				$left=$ground_width-$logo_width-$margin;
				$top=ceil($ground_height/2)-ceil($logo_height/2);
				break;
			case 7:
				$left=$margin;
				$top=$ground_height-$logo_height-$margin;
				break;
			case 8:
				$left=ceil($ground_width/2)-ceil($logo_width/2);
				$top=$ground_height-$logo_height-$margin;
				break;
			case 9:
				$left=$ground_width-$logo_width-$margin;
				$top=$ground_height-$logo_height-$margin;
				break;
			case 10:
				$left_min=$margin;
				$left_max=$ground_width-$logo_width-$margin;
				$top_min=$margin;
				$top_max=$ground_height-$logo_height-$margin;
				$left=rand($left_min,$left_max);
				$top=rand($top_min,$top_max);
				break;
					
		}
		
		return array( 
		 "left"   => $left, 
		 "top"    => $top, 
		); 
	} 
	
	
	
	
	private function exe_merge($groundImg,$logoImg,$logoImg_info,$start_x,$start_y,$opacity){
		switch($logoImg_info["type"]){
			case 1: //gif
				imagecopyresampled($groundImg,$logoImg,$start_x,$start_y,0,0,$logoImg_info['width'],$logoImg_info['height'],$logoImg_info['width'],$logoImg_info['height']);
				break;
			case 2: //jpg
				imagecopymerge ($groundImg,$logoImg,$start_x,$start_y,0,0,$logoImg_info['width'],$logoImg_info['height'],$opacity);
				break;
			case 3: //png
			imagecopyresampled($groundImg,$logoImg,$start_x,$start_y,0,0,$logoImg_info['width'],$logoImg_info['height'],$logoImg_info['width'],$logoImg_info['height']);			
				break;
		}
		return $groundImg;
	}
		
	
	function getInfo($open_path){
		$data=getimagesize($open_path);
		$imageInfo["width"]=$data[0];
		$imageInfo["height"]=$data[1];
		$imageInfo["type"]=$data[2];
		return $imageInfo;
	}
	
	private function getImg($open_path, $imgInfo){
		switch($imgInfo["type"]){
			case 1: //gif
				$img=imagecreatefromgif($open_path);
				break;
			case 2: //jpg
				$img=imagecreatefromjpeg($open_path);
				break;
			case 3: //png
				$img=imagecreatefrompng($open_path);
				break;
			default:
				return false;
		}
		return $img;
	}
	
	
	private function saveImg($img,$save_path, $imgInfo){
		switch($imgInfo["type"]){
			case 1: //gif
				imagegif($img,$save_path);
				break;
			case 2: //jpg
				imagejpeg($img,$save_path);
				break;
			case 3: //png
				imagepng($img,$save_path);
				break;
			default:
				return false;
		}
		return true;
	}
	
	
	
	private function thumb_gif($open_path,$save_path,$width,$height){
		//thumb_gif("test/test.gif","test/xx.gif",100,100);
		if(!@imagecreatefromgif($open_path)){return false;}
		$srcImg = imagecreatefromgif($open_path);
		$newImg=imagecreatetruecolor($width,$height);
		$otsc=imagecolortransparent($srcImg);
		if($otsc >=0 && $otsc <= imagecolorstotal($srcImg)){
			$tran=@imagecolorsforindex($srcImg, $otsc);
			$newt=imagecolorallocate($newImg, $tran["red"], $tran["green"], $tran["blue"]);
			imagefill($newImg, 0, 0, $newt);
			imagecolortransparent($newImg, $newt);
		}
		$srcWidth = imagesx($srcImg);
		$srcHeight = imagesy($srcImg);
		imagecopyresampled($newImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
		imagegif($newImg,$save_path);
		imagedestroy($srcImg);
		imagedestroy($newImg);
		return true;
	}
	private function thumb_jpeg($open_path,$save_path,$width,$height){
		//thumb_jpeg("test/test.jpg","test/xx.jpg",100,100);
		if(!@imagecreatefromjpeg($open_path)){return false;}
		$srcImg = imagecreatefromjpeg($open_path);
		$srcWidth = imagesx($srcImg);
		$srcHeight = imagesy($srcImg);
		$newImg = imagecreatetruecolor($width, $height);
		imagecopyresampled($newImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
		imagejpeg($newImg,$save_path);
		imagedestroy($srcImg);
		imagedestroy($newImg);
		return true;
	}
	private function thumb_png($open_path,$save_path,$width,$height){
		//thumb_png("test/test.png","test/xx.png",1300,100);
		if(!@imagecreatefrompng($open_path)){return false;}
		$srcImg = imagecreatefrompng($open_path);
		$srcWidth = imagesx($srcImg);
		$srcHeight = imagesy($srcImg);
		$newImg = imagecreatetruecolor($width, $height);
		//分配颜色 + alpha，将颜色填充到新图上
		$alpha = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
		imagefill($newImg, 0, 0, $alpha);
		//将源图拷贝到新图上，并设置在保存 PNG 图像时保存完整的 alpha 通道信息
		imagecopyresampled($newImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
		imagesavealpha($newImg, true);
		imagepng($newImg,$save_path);
		imagedestroy($srcImg);
		imagedestroy($newImg);
		return true;
	}
	private function get_text_start($img_width,$img_height,$position,$text,$fontFile,$fontSize,$fontAngle) { 
		$rect = imagettfbbox($fontSize,$fontAngle,$fontFile,$text); 
		$minX = min(array($rect[0],$rect[2],$rect[4],$rect[6])); 
		$maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6])); 
		$minY = min(array($rect[1],$rect[3],$rect[5],$rect[7])); 
		$maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7])); 
		$width=$maxX - $minX;
		$height=$maxY - $minY;
		$left=abs($minX) - 1;
		$top=abs($minY) - 1;
		$margin=10;
		//echo $left."==".$top."<br>";
		switch($position){
			case 1:
				$left+=$margin;
				$top+=$margin;
				break;
			case 2:
				$left=ceil($img_width/2)-ceil($width/2);
				$top+=$margin;
				break;
			case 3:
				$left=$img_width-$width-$margin;
				$top+=$margin;
				break;
			case 4:
				$left+=$margin;
				$top=ceil($img_height/2)-ceil($height/2);
				break;
			case 5:
				$left=ceil($img_width/2)-ceil($width/2);
				$top=ceil($img_height/2)-ceil($height/2);
				break;
			case 6:
				$left=$img_width-$width-$margin;
				$top=ceil($img_height/2)-ceil($height/2);
				break;
			case 7:
				$left+=$margin;
				if($fontAngle>0){
					$top=$img_height-$margin;
				}else{
					$top+=$img_height-$margin-$height;
				}
				break;
			case 8:
				$left=ceil($img_width/2)-ceil($width/2);
				if($fontAngle>0){
					$top=$img_height-$margin;
				}else{
					$top+=$img_height-$margin-$height;
				}
				break;
			case 9:
				$left=$img_width-$width-$margin;
				if($fontAngle>0){
					$top=$img_height-$margin;
				}else{
					$top+=$img_height-$margin-$height;
				}
				break;
			case 10:
				$left_min=$left+=$margin;
				$left_max=$img_width-$width-$margin;
				$top_min=$margin;
				if($fontAngle>0){
					$top_max=$img_height-$margin;
				}else{
					$top_max=$img_height-$margin-$height;
				}
				$left=rand($left_min,$left_max);
				$top=rand($top_min,$top_max);
				break;
					
		}
		
		return array( 
		 "left"   => $left, 
		 "top"    => $top, 
		); 
	} 
	
	
			
}
?>