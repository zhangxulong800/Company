分红计算佣金文件为 program/mall/commission.php
/*----------*/
/program/mall/mall.class.php文件里说明：
商城数据显示类 示例 ./index.php?monxin=mall.goods_add (monxin=类名.方法名)，
大部分情况是通过 __call方法 加载执行 ./program/mall/show/ 目录下的对应名称的文件
/*----------*/
首页楼层文件program\mall\show\goods_module.php
/*-----自动收货-----*/
<script src="./receive.php?target=mall::auto_receipt_expire_order"></script>
