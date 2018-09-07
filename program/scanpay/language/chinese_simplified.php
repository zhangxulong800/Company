<?php return array (
  'pages' => 
  array (
	  'scanpay.master' => 
	  array (
		  'power_suggest' => '网站管理员以上',
		  'name' => '扫码付管理',
		  'title' => '扫码付管理',
		  'keywords' => '扫码付管理',
		  'description' => '扫码付管理',
	  ),
	  'scanpay.account_admin' => 
	  array (
		  'power_suggest' => '网站管理员以上',
		  'name' => '全站收款账号',
		  'title' => '全站收款账号',
		  'keywords' => '全站收款账号',
		  'description' => '全站收款账号',
	  ),
	  'scanpay.pay_admin' => 
	  array (
		  'power_suggest' => '网站管理员以上',
		  'name' => '全站收款记录',
		  'title' => '全站收款记录',
		  'keywords' => '全站收款记录',
		  'description' => '全站收款记录',
	  ),
	  'scanpay.payee' => 
	  array (
		  'power_suggest' => '店主商家以上',
		  'name' => '我的扫码付',
		  'title' => '我的扫码付',
		  'keywords' => '我的扫码付',
		  'description' => '我的扫码付',
	  ),
	  'scanpay.my_account' => 
	  array (
		  'power_suggest' => '店主商家以上',
		  'name' => '收款账号管理',
		  'title' => '收款账号管理',
		  'keywords' => '收款账号管理',
		  'description' => '收款账号管理',
	  ),
	  'scanpay.account_add' => 
	  array (
		  'power_suggest' => '店主商家以上',
		  'name' => '新增收款账号',
		  'title' => '新增收款账号',
		  'keywords' => '新增收款账号',
		  'description' => '新增收款账号',
	  ),
	  'scanpay.account_edit' => 
	  array (
		  'power_suggest' => '店主商家以上',
		  'name' => '编辑收款账号',
		  'title' => '编辑收款账号',
		  'keywords' => '编辑收款账号',
		  'description' => '编辑收款账号',
	  ),
	  'scanpay.account_pay_log' => 
	  array (
		  'power_suggest' => '店主商家以上',
		  'name' => '账号收款记录',
		  'title' => '账号收款记录',
		  'keywords' => '账号收款记录',
		  'description' => '账号收款记录',
	  ),
	  'scanpay.pay' => 
	  array (
		  'power_suggest' => '会员以上',
		  'name' => '码上付',
		  'title' => '码上付',
		  'keywords' => '码上付',
		  'description' => '码上付',
	  ),
	  'scanpay.operator_log' => 
	  array (
		  'power_suggest' => '收款员以上',
		  'name' => '我的收款记录',
		  'title' => '我的收款记录',
		  'keywords' => '我的收款记录',
		  'description' => '我的收款记录',
	  ),
  ),
  'functions' => 
  array (
	  'scanpay.master' => 
	  array (
		  'power_suggest' => '网站管理员以上',
		  'description' => '扫码付管理',
	  ),
	  'scanpay.account_admin' => 
	  array (
		  'power_suggest' => '网站管理员以上',
		  'description' => '全站收款账号',
	  ),
	  'scanpay.pay_admin' => 
	  array (
		  'power_suggest' => '网站管理员以上',
		  'description' => '全站收款记录',
	  ),
	  'scanpay.payee' => 
	  array (
		  'power_suggest' => '店主商家以上',
		  'description' => '我的扫码付',
	  ),
	  'scanpay.my_account' => 
	  array (
		  'power_suggest' => '店主商家以上',
		  'description' => '收款账号管理',
	  ),
	  'scanpay.account_add' => 
	  array (
		  'power_suggest' => '店主商家以上',
		  'description' => '新增收款账号',
	  ),
	  'scanpay.account_edit' => 
	  array (
		  'power_suggest' => '店主商家以上',
		  'description' => '编辑收款账号',
	  ),
	  'scanpay.account_pay_log' => 
	  array (
		  'power_suggest' => '店主商家以上',
		  'description' => '账号收款记录',
	  ),
	  'scanpay.pay' => 
	  array (
		  'power_suggest' => '会员以上',
		  'description' => '码上付',
	  ),
	  'scanpay.operator_log' => 
	  array (
		  'power_suggest' => '收款员以上',
		  'description' => '我的收款记录',
	  ),
  ),
  'program_name' => '梦行扫码付',
  'language_dir' => 
  array (
    'chinese_simplified' => '简体中文',
  ),
  'account_state' => 
  array (
    0 => '待审核',
    1 => '正常',
    2 => '关闭',
  ),
  'settlement_state' => 
  array (
    0 => '-',
    1 => '已结算',
    2 => '无需结算',
  ),
  'pay_state' => 
  array (
    0 => '未完成',
    1 => '失败',
    2 => '条码过期',
    3 => '成功',
    4 => '支付中',
  ),
  'account_name' => '收款主体名称',
  'account_banner' => '收款主体店铺门头',
  'account_name_placeholder' => '公司名或店名',
  'account_operator' => '收款操作员',
  'account_operator_placeholder' => '选填,不填否只能自己登录后台收款，填了其它用户名，相关用户登录后台也能为此账号收款',
  'account_type' => '账号类别',
  'scanpay_account' => '收款账号',
  'money' => '金额',
  'receive_money' => '收款',
  'del_account_confirm' => '确认要删除吗？将删除此收款账号下的收款记录',
  'pay_money' => '付款',
  'pay_username' => '付款人',
  'pay_reason' => '付款原因',
  'pay_barcode' => '付款码',
  'pay_barcode_placeholder' => '请用条码枪扫手机上的支付条码或手动输入支付码',
  'digit' => '位数',
  'settlement' => '结算状态',
  'success_fun' => '完后操作',
  'fail_reason' => '失败原因',
  'out_id' => '编号', 
  'is_web' => '平台公用',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  '' => '',
  'account_type_option' => array(
  	'alipay'=>'支付宝',
  	'weixin'=>'微信支付',
  ),
)?>