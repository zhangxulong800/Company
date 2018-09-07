<link rel="stylesheet" href="<?php echo $css_path;?>" type="text/css">
<div id=mall_layout >
    <!--top_malllayout_start-->
	<div id='top_malllayout_out' align="center">
     	<div id='top_malllayout_inner' align="center">
            <div id='malllayout_top'>
            	<?php foreach($modules['head'] as $v){?>
                	<?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
                <?php }?>
            </div>
		</div>
    </div>
    <!--top_malllayout_end-->
    <!--middle_malllayout_start-->
    <div id='middle_malllayout_out' align="center">
        <div id='middle_malllayout_inner'  class="container">
            <div id='malllayout_left'  class=col-md-10>
            	<?php foreach($modules['left'] as $v){?>
                	<?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
                <?php }?>
            </div>
			<div id='malllayout_right' class=col-md-2>
            	<?php 
				foreach($modules['right'] as $v){?>
                	<?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
                <?php }?>
            </div>
       </div>     
    </div>
    <!--middle_malllayout_end-->
    <!--bottom_malllayout_start-->
	<div id='bottom_malllayout_out' align="center">
     	<div id='bottom_malllayout_inner'>
            <div id=mall'layout_bottom'>
            	<?php foreach($modules['bottom'] as $v){?>
                	<?php $v['object']->$v['method']($v['pdo'],$v['args'])?>
                <?php }?>
            </div>
		</div>
    </div>
     <!--bottom_layout_end-->
</div>
