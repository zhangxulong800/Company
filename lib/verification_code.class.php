<?php
require_once '../config/functions.php';
    session_start();

    $code=new verification_code();

    $code->showImage();   //输出到页面中供 注册或登录使用

    class verification_code {
        private $width; //宽度
        private $height; //高度
        private $codeNum; //验证码字符数
        private $image;   //图像资源
        private $disturbColorNum; //干扰元素数目
        private $checkCode; //验证码字符串

        function __construct(){
			$width=isset($_GET['width'])?$_GET['width']:100;
			$height=isset($_GET['height'])?$_GET['height']:30; 
			$codeNum=6;
            $this->width=$width;
            $this->height=$height;
            $this->codeNum=$codeNum;
            $this->checkCode=$_SESSION['verification_code']; //返回一个随机字符串
            $number=floor($width*$height/15); //临时使用
           
            if($number > 240-$codeNum){
                $this->disturbColorNum=    240-$codeNum; //干扰点的数目 面积越大,干扰元素越多
            }else{
                $this->disturbColorNum=$number; //干扰点的数目
            }

       
        }
        //通过访问该方法向浏览器中输出图像
        function showImage($fontFace=""){
            //第一步：创建图像背景
            $this->createImage();
            //第二步：设置干扰元素
            $this->setDisturbColor();
            //第三步：向图像中随机画出文本
            $this->outputText($fontFace);
            //第四步：输出图像
            $this->outputImage();
        }
           
        //通过调用该方法获取随机创建的验证码字符串
        function getCheckCode(){
            return $this->checkCode; //每次随机的字符串会保存在这里
        }

        private function createImage(){//创建背景图
            //创建图像资源
            $this->image=imagecreatetruecolor($this->width, $this->height);
            //随机背景色
            $backColor=imagecolorallocate($this->image, rand(225, 255), rand(225,255), rand(225, 255));
            //为背景添充颜色
            imagefill($this->image, 0, 0, $backColor);
            //设置边框颜色
            $border=imagecolorallocate($this->image, 0, 0, 0);
            //画出矩形边框
            imagerectangle($this->image, 0, 0, $this->width-1, $this->height-1, $border);
        }

        private function  setDisturbColor(){
            for($i=0; $i<$this->disturbColorNum; $i++){
                $color=imagecolorallocate($this->image, rand(0, 255), rand(0, 255), rand(0, 255)); //分配随机色
                //画出随机点
                imagesetpixel($this->image, rand(1, $this->width-2), rand(1, $this->height-2), $color);
            }

            for($i=0; $i<10; $i++){//随机画圆弧
                $color=imagecolorallocate($this->image, rand(200, 255), rand(200, 255), rand(200, 255));
                imagearc($this->image, rand(-10, $this->width), rand(-10, $this->height), rand(30, 300), rand(20, 200), 55, 44, $color);
            }
        }

        private function createCheckCode(){
            $code="23456789abcdefghijkmnpqrstuvwxyzABCDEFGHIJKMNPQRSTUVWXYZ"; //这是随机数
            $string=''; //定义一个空字符串
            for($i=0; $i < $this->codeNum; $i++){ //codeNum为验证码的位数,一般为4
                $char=$code{rand(0, strlen($code)-1)}; //随机数,如果$code{0}那就是2
                $string.=$char; //附加验证码符号到字符串
            }

            return $string;
        }

        private function outputText($fontFace=""){ //fontFace是字体文件
            for($i=0; $i<$this->codeNum; $i++){
                $fontcolor=imagecolorallocate($this->image, rand(0, 128), rand(0, 128), rand(0, 128));
                if($fontFace==""){ //没有指定字体时
                    $fontsize=rand(6,16); //字体大小
                    $x=floor($this->width/$this->codeNum)*$i+3;  //字体的横坐标,每个字符每次都有规律的变化
                    $y=rand(0, $this->height-15); //字体的纵坐标,随机变化
                    imagechar($this->image,$fontsize, $x, $y, $this->checkCode{$i},$fontcolor);
                }else{
                    $fontsize=rand(12, 16); //有指定字体时字体要大点
                    $x=floor(($this->width-8)/$this->codeNum)*$i+8;
                    $y=rand($fontSize+5, $this->height);
                    imagettftext($this->image,$fontsize,rand(-30, 30),$x,$y ,$fontcolor, $fontFace, $this->checkCode{$i});
                }
            }
        }

        private function outputImage() {
            if(imagetypes() & IMG_GIF){//这是固定格式,手册imagetypes
                header("Content-Type:image/gif");
                imagepng($this->image);
            }else if(imagetypes() & IMG_JPG){
                header("Content-Type:image/jpeg");
                imagepng($this->image);
            }else if(imagetypes() & IMG_PNG){
                header("Content-Type:image/png");
                imagepng($this->image);
            }else if(imagetypes() & IMG_WBMP){
                header("Content-Type:image/vnd.wap.wbmp");
                imagepng($this->image);
            }else{
                die("PHP不支持图像创建");
            }
        }

        function __destruct(){//销毁图象资源
            imagedestroy($this->image);
        }
    }
?>
