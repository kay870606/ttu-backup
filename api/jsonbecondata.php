<?php 
require_once("../markettest1/include/gpsvars.php");
$dbname = "test5";
$dbhost = "localhost";
$dbuser = "main";
$dbpwd = "i3a3234";
require_once("../markettest1/include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

if(isset($category)){
	if($category == -1){
		if($sections==0) {
			$sqlcmd = "SELECT id,name FROM sections ORDER BY id";
		}
		else{
			$sqlcmd = "SELECT id,name FROM categories where section_id = $sections";
		}
	}
	else{
        $sqlcmd = "SELECT id FROM categories where section_id = $sections";
		$rs = querydb($sqlcmd, $db_conn);
		$cat=$rs[$category]['id'];
		$sqlcmd = "SELECT ean,name,price 
		           FROM products 
				   where subcategory_id 
				   IN(SELECT id FROM subcategories WHERE category_id=$cat)";
	}	
}
/*if(isset($beacon)){
    if(isset($auth)){
		  
	}
	else{
		$sqlcmd = "SELECT type FROM beacons_push";
		$rs = querydb($sqlcmd, $db_conn);
		for()
	}
}*/




$rs = querydb($sqlcmd, $db_conn);
echo json_encode($rs,320);

//$sqlcmd = "SELECT name,url FROM discount_image where status='$st'";
//$rs = querydb($sqlcmd, $db_conn);

//echo json_encode($rs,320);

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