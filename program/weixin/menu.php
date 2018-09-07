<?php
return array(
		"weixin.admin_index"=>array('weixin.account_admin','weixin.function_list'=>array('weixin.function_add','weixin.function_edit'),'weixin.search_function_list'=>array('weixin.search_function_add','weixin.search_function_edit','weixin.sum')),
	
		
		"weixin.account_list"=>array(
			'weixin.account_add',
			'weixin.account_edit',
				'weixin.menu_list',
				'weixin.auto_answer_list'=>array('weixin.auto_answer_add','weixin.auto_answer_edit',),
				'weixin.user_list'=>array('weixin.user_edit',),
				'weixin.dialog_list'=>array('weixin.dialog','weixin.send_msg','weixin.user_sum'),
				'weixin.diy_qr',
				'weixin.mass',
		),


	);
?>