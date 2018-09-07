<div id=<?php echo $module['module_name'];?>  class="portlet light" monxin-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
            
    });
    </script>
    

    <style>
    #<?php echo $module['module_name'];?>{ padding-top:2rem;}
    #<?php echo $module['module_name'];?> .qr_img_div{ text-align:center;}
    #<?php echo $module['module_name'];?> .qr_img_div img{ width:250px;}
    #<?php echo $module['module_name'];?> .url_div{ margin-top:2rem; margin-bottom:2rem; text-align:center;}
    #<?php echo $module['module_name'];?> .url_div a:hover{ color:#F60;}
    #<?php echo $module['module_name'];?> .share_c_div{ width:300px; height:533px; margin:auto; background:<?php echo $_POST['monxin_user_color_set']['nv_1']['background']?>; border-radius:3px; background-image:url(<?php echo get_template_dir(__FILE__);?>/img/recommend_bg.png); background-repeat:no-repeat; background-size:contain;}
	#<?php echo $module['module_name'];?> .share_c_div .logo_d{ height:100px;}
    #<?php echo $module['module_name'];?> .share_c_div .logo_img{ width:50%; padding-top:1rem; padding-left:1rem;}
	
	#<?php echo $module['module_name'];?> .share_c_div .u_info{ text-align:left; padding-left:2rem; padding-right:2rem; padding-bottom:1.8rem; }
	#<?php echo $module['module_name'];?> .share_c_div .u_info .u_icon{ display:inline-block; vertical-align:top; width:20%; overflow:hidden;}
	#<?php echo $module['module_name'];?> .share_c_div .u_info .u_icon img{ width:50px; height:50px; border-radius:25px;}
	#<?php echo $module['module_name'];?> .share_c_div .u_info .u_name{display:inline-block; vertical-align:top; padding-left:2%; width:80%; overflow:hidden;  }
	#<?php echo $module['module_name'];?> .share_c_div .u_info .u_name .uname{ font-size:1.3rem; font-weight:bold;white-space: nowrap;
    text-overflow: ellipsis; overflow:hidden;}
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    	<div class=share_c_div>
        	<div class=logo_d><img src=white_logo.png class=logo_img /></div>
            <div class=share_body>
                <div class=qr_img_div>
                   	<div class=u_info>
                    	<div class=u_icon><img src="<?php echo $module['user_icon']?>" /></div><div class=u_name>
                        	<div class=uname><?php echo $module['nickname']?></div>
                            <div class=recommend_word><?php echo $module['recommend_word']?></div>
                        </div>
                    </div>
                    <img src='./plugin/qrcode/index.php?text=<?php echo $module['qr_text'];?>' />
                     <div><?php echo self::$language['wechat_scan'];?></div>
                </div>            
            </div>
        </div>

        <div class=url_div><?php echo $module['recommend_word']?> <a href=<?php echo $module['reg_url'];?> target=_blank><?php echo $module['reg_url'];?></a>
        <br /> <br />
        <a href=./index.php?monxin=index.my_new_user class=submit><?php echo self::$language['view']?><?php echo self::$language['pages']['index.my_new_user']['name']?></a>
        </div>
        
    </div>
</div>