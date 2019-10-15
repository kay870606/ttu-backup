<?php
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$PageTitle = '佳瑪商品介紹';
require_once("../include/headerup.php");
require_once("../include/headerdown.php");
$sqlcmd = "SELECT * FROM products WHERE id='$pid'";
$Contacts = querydb($sqlcmd, $db_conn);
$ID = $Contacts[0]['id'];
$Model = $Contacts[0]['ean'];
$Name = $Contacts[0]['name'];
$Price = $Contacts[0]['price'];
$Information = $Contacts[0]['description'];
?>
<body>
<table border="0" width="90%" align="center" cellspacing="0" cellpadding="2">
<tr >
	<td width="30%" rowspan="3">
		<img src="/images/products/<?php echo $ID.'.png'; ?>" width="300" height="300" border="0" align="absmiddle"alt="<?php echo $productname ?>">
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