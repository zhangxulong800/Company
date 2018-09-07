<?php
$editor=isset($_GET['editor'])?$_GET['editor']:'editor';
$items='';
if(isset($_GET['simple'])){
	$items="items : [
						'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image', 'link'],";	
}
if(isset($_GET['items'])){
	$temp=explode('|',$_GET['items']);
	$i='';
	foreach($temp as $v){
		if($v==''){continue;}
		$i.="'".$v."',";
	}
	$i=trim($i,',');
	$items="items : [".$i."],";	
}
?>
        var <?php echo $editor;?>;
        <?php echo @$_GET['id']?>_ini();        
		if(!KindEditor){setTimeout("<?php echo @$_GET['id']?>_ini()",100);}
        function <?php echo @$_GET['id']?>_ini(){
            KindEditor.ready(function(K) {
                <?php echo $editor;?> = K.create('textarea[name="<?php echo @$_GET['id'];?>"]', {
                    <?php if(@$_GET['designMode']=='false'){echo 'designMode : false,';}?>
                    newlineTag:'br',
                    urlType:'relative',
                    <?php
                    if(is_file("lang/".$_GET['language'].".js")){$language=$_GET['language'];}else{$language='en';}
                    ?>
                    <?php echo $items;?>
                    langType : '<?php echo $language;?>',
                    extraFileUploadParams : {
                         program :"<?php echo @$_GET['program'];?>"
                    }
                });
                
    
            });	        
       	}
