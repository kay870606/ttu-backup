<?php
$DBHost = '140.129.25.75';
$DBUser = 'test';
$DBName = 'market';
$DBPWD = 'test';

/*$DBHost = 'localhost';
$DBUser = 'root';
$DBName = 'test';
$DBPWD = '';*/
$dsn = "mysql:host=$DBHost;dbname=$DBName;charset=utf8mb4";
try{
$Conn = new PDO($dsn, $DBUser, $DBPWD);
}catch(PDOException $e){
	$e->getmessage();
}
$Conn->setAttribute(\PDO::ATTR_EMULATE_PREPARES,false);
?>