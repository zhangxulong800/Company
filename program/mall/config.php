<?php return array (
  'program' => 
  array (
    'language' => 'chinese_simplified',
    'cache_time' => 5,
    'template_1' => 'default',
    'template_0' => 'default',
    'imageMark' => false,
    'state' => 'opening',
    'thumb_width' => '512',
    'thumb_height' => '512',
  ),
  'class_name' => 'mall',
  'version' => '4.0',
  'compatible_template_version' => '3.0',
  'author' => 'Monxin',
  'author_url' => 'http://www.monxin.com',
  'show_sold' => false,
  'show_comment' => true,
  'comment_check' => false,
  'goods_check' => '1',
  'show_invoice' => true,
  'decrease_quantity' => '8',
  'mall_master_email' => '20913966@qq.com',
  'mall_master_phone' => '15807407811',
  'volume_rate' => '5',
  'pay_time_limit' => 180,
  'receipt_time_limit' => 1,
  'refund_time_limit' => 10,
  'comment_time_limit' => 30,
  'comment_page_size' => 10,
  'monthly_sold_page_size' => 10,
  'hot_search' => '美食|数码|电器|百货|食品|手机|建材|服装|鞋包|车市',
  'search_placeholder' => '美味拦不住',
  'search_placeholder_url' => './index.php?monxin=mall.goods_list&search=肉',
  'storekeeper_group_id' => 65,
  'cashier_group_id' => 52,
  'headquarters_group_id' => 64,
  'shopkeeper_group_id' => 54,
  'agent_group_id' => 57,
  'buyer_group_id' => 13,
  'cart_show_independent' => 1,
  'type_update_time' => 1531966283,
  'goods_update_time' => 1536824185,
  'certificate_reg' => '/^[1-9]\\d{5}[1-9]\\d{3}((0\\d)|(1[0-2]))(([0|1|2]\\d)|3[0-1])\\d{3}([0-9]|X)$/i',
  'business_license_reg' => '/^(\\d{13}|\\d{15}|[0-9a-zA-Z]{18})$/',
  'check_code_template' => '【{web_name}】您刚提交的订单,对单码为{random_int},请牢记,进店消费时用于核对身份',
  'online_pay_fees' => 1,
  'shop_year_fees' => 365,
  'min_deposit' => '1000',
  'annual_shop_order_fees' => 1,
  'times_shop_order_fees' => 3,
  'ad_fees' => 3,
  'manage_fees' => 5,
  'agent_add_shop_fedds' => '50',
  'agent_annual_percentage' => 70,
  'agent_transaction_fees_percentage' => '30',
  'sms_fees' => 0.050000000000000003,
  'phone_goods_list_show_buy_button' => false,
  'unlogin_buy' => false,
  'give_credits' => '0.1',
  'task_y' => '2018',
  'task_m' => '2018-09',
  'task_w' => '37',
  'task_d' => '2018-09-13',
  'task_h' => '2018-09-13 15',
  'task_minute' => '2018-09-13 15:39',
  'receive_task_y' => '2018',
  'receive_task_m' => '2018-09',
  'receive_task_w' => '2016-06',
  'receive_task_d' => '2018-09-13',
  'receive_task_h' => '2018-09-13 15',
  'receive_task_minute' => '2018-09-13 15:36',
  'agency' => false,
  'distribution' => true,
  'new_goods_days' => 30,
  'near_default' => '4',
  'online_forbid_show' => false,
  'show_type_deep' => '2',
  'pay_mode' => 'credits',
  'mall_layout_modules' => 
  array (
    0 => 'mall.head',
    1 => 'mall.foot',
    2 => 'mall.nav',
    3 => 'mall.shop_search',
    4 => 'mall.shop_goods_type_module',
    5 => 'mall.shop_goods_list',
    6 => 'mall.shop_goods_list_module',
    7 => 'mall.shop_diymodule',
    8 => 'mall.menu',
    9 => 'mall.diymodule_show',
    10 => 'mall.diypage_show',
    11 => 'mall.slider_show',
    12 => 'mall.goods',
    13 => 'mall.auto_receipt_expire_order',
    14 => 'mall.shop_type_goods',
  ),
  'order_del_able' => 
  array (
    0 => 3,
    1 => 4,
    2 => 5,
    3 => 6,
    4 => 10,
  ),
  'order_del_able_seller' => 
  array (
    0 => 3,
    1 => 4,
    2 => 5,
  ),
  'order_del_able_master' => 
  array (
    0 => 0,
    1 => 3,
    2 => 4,
    3 => 5,
    4 => 6,
    5 => 10,
  ),
  'pay_method' => 
  array (
    'balance' => true,
    'cash_on_delivery' => false,
    'online_payment' => true,
    'credits' => true,
  ),
  'pay_method_sequence' => 
  array (
    'balance' => 9777,
    'cash_on_delivery' => 7,
    'online_payment' => 99999,
    'cash' => 2,
    'credit' => 1,
    'credits' => 44,
  ),
  'icon_thumb' => 
  array (
    'width' => 512,
    'height' => 512,
  ),
  'color_img_thumb' => 
  array (
    'width' => 48,
    'height' => 48,
  ),
  'multi_angle_img_thumb' => 
  array (
    'width' => 128,
    'height' => 128,
  ),
  'program_unlogin_function_power' => 
  array (
    0 => 'mall.show_type',
    1 => 'mall.show_type_module',
    2 => 'mall.type_module_left',
    3 => 'mall.goods_list',
    4 => 'mall.goods',
    5 => 'mall.search',
    6 => 'mall.cart',
    7 => 'mall.goods_module',
    8 => 'mall.my_cart',
    9 => 'mall.package',
    10 => 'mall.confirm_order',
    11 => 'mall.receiver_add',
    12 => 'mall.receiver_edit',
    13 => 'mall.pay',
    14 => 'mall.auto_print',
    15 => 'mall.checkout_pay',
    16 => 'mall.catalog',
    17 => 'mall.shop_list',
    18 => 'mall.shop',
    19 => 'mall.shop_goods_type',
    20 => 'mall.shop_goods_list',
    21 => 'mall.shop_diypage',
    22 => 'mall.apply_shop',
    23 => 'mall.shop_goods_type_module',
    24 => 'mall.shop_goods_list_module',
    25 => 'mall.shop_diymodule',
    26 => 'mall.index',
    27 => 'mall.shop_index',
    28 => 'mall.layout',
    29 => 'mall.diypage_show',
    30 => 'mall.type_module_two',
    31 => 'mall.shop_name',
    32 => 'mall.goods_snapshot',
    33 => 'mall.interest_goods',
    34 => 'mall.interest_goods_list',
    35 => 'mall.shop_map',
    36 => 'mall.shop_module',
    37 => 'mall.brand_module',
    38 => 'mall.type_goods',
    39 => 'mall.gbuy_goods',
    40 => 'mall.gbuy_confirm_order',
  ),
  'map_zoom' => 
  array (
    3 => 8192000,
    4 => 4096000,
    5 => 2048000,
    6 => 1024000,
    7 => 512000,
    8 => 256000,
    9 => 128000,
    10 => 64000,
    11 => 32000,
    12 => 16000,
    13 => 8000,
    14 => 8000,
    15 => 4000,
    16 => 2000,
    17 => 1000,
    18 => 500,
  ),
  'map_zoom_geo' => 
  array (
    3 => 1,
    4 => 1,
    5 => 2,
    6 => 2,
    7 => 3,
    8 => 3,
    9 => 4,
    10 => 4,
    11 => 4,
    12 => 4,
    13 => 4,
    14 => 5,
    15 => 5,
    16 => 6,
    17 => 6,
    18 => 6,
  ),
  'dashboard_module' => 
  array (
    0 => 'mall.buyer_sum',
    1 => 'mall.seller_sum',
    2 => 'mall.master_sum',
  ),
)?>