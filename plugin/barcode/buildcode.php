<?php
// Including all required classes
require_once('class/BCGFontFile.php');
require_once('class/BCGColor.php');
require_once('class/BCGDrawing.php');

$codebar =$_REQUEST['codebar']; //条形码将要数据的内容
$codebar=str_replace('.','',$codebar);
$codebar=str_replace('/','',$codebar);
// Including the barcode technology
require_once('class/'.$codebar.'.barcode.php');

// Loading Font
$font = new BCGFontFile('./font/Arial.ttf', 12);

// The arguments are R, G, B for color.
$color_black = new BCGColor(0, 0, 0);
$color_white = new BCGColor(255, 255, 255);

$drawException = null;
try {
	if(empty($_GET['scale'])){$_GET['scale']=2;}
	if(empty($_GET['height'])){$_GET['height']=30;}
    $code = new $codebar();//实例化对应的编码格式
    $code->setScale($_GET['scale']); // Resolution
    $code->setThickness($_GET['height']); // Thickness
    $code->setForegroundColor($color_black); // Color of bars
    $code->setBackgroundColor($color_white); // Color of spaces
    $code->setFont($font); // Font (or 0)
    $text = trim($_GET['text']); //条形码将要数据的内容
    $code->parse($text);
} catch(Exception $exception) {
    $drawException = $exception;
}

/* Here is the list of the arguments
1 - Filename (empty : display on screen)
2 - Background color */
$drawing = new BCGDrawing('', $color_white);
if($drawException) {
    $drawing->drawException($drawException);
} else {
    $drawing->setBarcode($code);
    $drawing->draw();
}

// Header that says it is an image (remove it if you save the barcode to a file)
header('Content-Type: image/png');

// Draw (or save) the image into PNG format.
$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
?>