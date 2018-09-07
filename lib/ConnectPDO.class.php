<?php
class ConnectPDO extends PDO{
	private $host='127.0.0.1';
	private $port='3306';
	private $user='root';
	private $password='root';
	public $dbname='sanshengshiye2';
	public $sys_pre='monxin_';
	public $index_pre='monxin_index_';
	function __construct(){
		try{
			if(!defined('PDO::MYSQL_ATTR_INIT_COMMAND')){exit('pdo_mysql not exist');}
			$driver_opts=array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES'UTF8'",PDO::MYSQL_ATTR_USE_BUFFERED_QUERY=>true);
			parent::__construct("mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=UTF8",$this->user,$this->password,$driver_opts);
		}catch(PDOException $e){
			if(is_file('./install_monxin.php') && !isset($_GET['act'])){
				//header("location:./install_monxin.php");
				exit('<script>window.location.href="./install_monxin.php"</script>');
			}else{
				echo "<br />database connect err：".$e->getMessage();exit;	
			}	
		}
		
	}
	function __toString(){
		return '';
		}
	
}

?>