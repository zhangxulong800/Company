<?php
return array(
		"talk.index"=>array(
		'talk.type_admin'=>array('talk.set_group',),
		'talk.type'=>array('talk.type_set','talk.title_set','talk.title_module','talk.title_module_set','talk.sum'),		
		),
		'talk.my'=>array('talk.title_add','talk.my_title','talk.my_content'=>array('talk.content_edit','talk.user_sum'),'talk.my_comment'),
		);
?>