<?php 
require_once("../markettest/include/gpsvars.php");
$dbname = "test5";
$dbhost = "localhost";
$dbuser = "main";
$dbpwd = "i3a3234";
require_once("../markettest/include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$sqlcmd = "SELECT name,url FROM discount_image where status='0'";
$rs = querydb($sqlcmd, $db_conn);
echo json_encode($rs,320);

/*foreach($rs as $item){
$name = $item['name'];
$price = $item['price'];
$floor = $item['floor'];
$sectionName= $item['section_name'];
$ProductSectionName = $item['category_id'];
$ProductCategoryID = $item['category_name];
$ProductCategoryName = $item['PCN'];
$ProductSubcategoryName = $item['PSCN'];
$ProductInformation = $item['information'];	
}
?>*/