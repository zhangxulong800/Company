<!DOCTYPE html>
<head>
<link rel="shortcut icon" href="favicon.ico"/>
<?php echo $_POST['diy_meta'];?>
<meta charset="utf-8" />
<title><?php echo $head['title']?></title>
<meta name=keywords content="<?php echo $head['keywords']?>">
<meta name="description" content="<?php echo $head['description']?>">
<meta name="generator" content="梦行Monxin" />
<meta name="author" content="梦行Monxin Team" />
<meta name="renderer" content="webkit" />
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1;" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link href="./public/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="./public/animate.min.css" rel="stylesheet" type="text/css">
<link href="./templates/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
<script src="./public/jquery.js"></script>
<script src="./public/jquery-ui.min.js"></script>
<script src="./public/blocksit.min.js"></script>
<script src="./templates/bootstrap/js/bootstrap.js" type="text/javascript"></script>
<script src="./public/sys_head.js"></script>
<script src="./public/top_ajax_form.js"></script>
<script>
$(document).ready(function(){
	
});
</script>
<?php echo $color_data;?>

<link rel="stylesheet" href="<?php  echo  $css_path;?>" type="text/css">
</head>
<body iframe=<?php echo $_GET['iframe']?>>

<!--BEGIN HEADER -->
<div class="page-header" monxin_layout="head" user_color='head'>
    <?php foreach($modules['head'] as $v){?>

    <?php
    	//var_dump($v);
    ?>
        <?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
    <?php }?>
</div>
<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container" user_color='container'>
   <div class="page-content">
	    <div class="container" m_container="m_container">  
           <div class=row><div class=col-md-9 monxin_layout="left">
                <?php foreach($modules['left'] as $v){?>
                    <?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
                <?php }?></div><div class=col-md-3 monxin_layout="right">
                <?php foreach($modules['right'] as $v){?>
                    <?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
                <?php }?>
            </div></div> 
        </div>
    </div>
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer" monxin_layout="bottom" user_color='shape_bottom'>
    <?php foreach($modules['bottom'] as $v){?>
        <?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
    <?php }?>

    <script src="./public/sys_foot.js"></script>

</div>
<!-- END FOOTER -->
	 <div class=fixed_right_div >
		<div class=fixed_right_div_inner>
			<div class=share_text style="display:none;" share_title="<?php echo $share_title?>"  share_url="<?php echo $share_url?>" ><?php echo $share_text;?></div>
			<?php echo de_safe_str(file_get_contents('./program/index/right_buttons_'.$_COOKIE['monxin_device'].'_data.txt'));?>
		</div>
	 </div>
	 <div class=right_notice><span></span></div>
     <audio id="notice_audio" autoplay></audio>
     <p id=fade_div>
     <p id=set_monxin_iframe_div>
     	<a href=# id=close_button  title="<?php echo C_CLOSE;?>">&nbsp;</a>
     	<iframe  id=monxin_iframe frameborder=0 src='' scrolling="no" marginwidth=0 marginheight=0 vspace=0 hspace=0 allowtransparency=true></iframe>
    </p>
	</p>
<div class="ie_warning modal fade"  style="display:none;" tabindex="-1" role="dialog"   aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal" aria-hidden="true">
                      &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                   <b>亲！您的浏览器太out了，很多功能无法正常使用。	</b>
                </h4>
             </div>
             <div class="modal-body">
                换个潮点的浏览器吧，您会发现网页会更有趣哦！ <a href=http://www.baidu.com/s?wd=chrome target=_blank>点击搜索谷歌浏览器</a>
                <div ></div>
             </div>
             <div class="modal-footer">
                <button type="button" class="btn btn-default" 
                   data-dismiss="modal">不，我偏要用这个悲催的浏览器 > ></button>
                
             </div>
          </div> 
      </div>
</div>   
</body>
</html>