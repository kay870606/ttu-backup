<?php
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$PageTitle = '佳瑪商品介紹';
require_once("../include/header1.php");
$sqlcmd = "SELECT * FROM products WHERE name='$pname'";
$Contacts = querydb($sqlcmd, $db_conn);
$Model = $Contacts[0]['ean'];
$Name = $Contacts[0]['name'];
$Price = $Contacts[0]['price'];
//$Floor = $Contacts[0]['floor'];
//$SectionName = $Contacts[0]['section_name'];
//$CategoryId = $Contacts[0]['category_id'];
//$CategoryName = $Contacts[0]['category_name'];
//$SubcategoryName = $Contacts[0]['subcategory_name'];
$Information = $Contacts[0]['description'];
//$Specification = $Contacts[0]['specification'];
?>
<body>
<table border="0" width="90%" align="center" cellspacing="0" cellpadding="2">
<tr >
	<td width="30%" rowspan="3">
		<img src="/api/picture/<?php echo $Model.'.png'; ?>" width="300" height="300" border="0" align="absmiddle"alt="<?php echo $productname ?>">
	</td>
</tr>
<tr>
	<th width="70%" style="font-size:50px;">
	<?php echo $Name; ?>
	</th>
</tr>
<tr>
	<th width="70%" style="font-size:50px;">
	<?php echo $Price."元"; ?>
	</th>
</tr>
<!--<tr style="font-size:30px;">
	<th>位置</th>
	<td style="padding:15px;">
	<?php //echo $Floor."F".$SectionName."區".$CategoryId."-".$CategoryName."-".$SubcategoryName; ?>
	</td>
</tr>-->
<tr style="font-size:30px;">
	<th>資訊</th>
	<td style="padding:15px;">
	<?php echo $Information; ?>
	</td>
</tr>
<tr><td colspan="2" align="center"><a href="productdemo.php" >回上一頁</a></td></tr>
</table>
</body>
</html>