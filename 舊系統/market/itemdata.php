
<html>
<head>
<?php require("header.html")?>
<style>

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    margin-left:auto; 
    margin-right:auto;
    width: 90%;
}

td, th {
    border: 1px solid #000000;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>
<a href="addimg.html" >加圖</a>
<?php

require("conn.php");
$sql = "SELECT * 
FROM items";
$pr = $Conn->prepare($sql);
$pr->execute();
$result=$pr->fetchAll();
$rowCount=count($result);
if ($rowCount > 0) {
    // output data of each row
	echo "<table>
		<tr>
			<th>商品編號</th>
			<th>商品名稱</th>
			<th>商品條碼</th>
			<th>商品進貨單位</th>
			<th>商品販售單位</th>
			<th>商品保存類別</th>
			<th>安全庫存量</th>
			<th>最大庫存量</th>
			<th>商品進貨成本</th>
			<th>商品銷售成本</th>
			<th>商品銷售定價</th>
			<th>區域編號</th>
			<th>種類</th>
			<th>最小名稱</th>
		</tr>";
	foreach($result as $row) {
		echo "
		<tr>
			<th>".$row["item_id"]."</th>
			<th>".$row["name"]."</th>
			<th>".$row["barcode"]."</th>
			<th>".$row["inunit"]."</th>
			<th>".$row["sellunit"]."</th>
			<th>".$row["store_class"]."</th>
			<th>".$row["safe_stocks"]."</th>
			<th>".$row["max_stocks"]."</th>
			<th>".$row["in_cost"]."</th>
			<th>".$row["sell_cost"]."</th>
			<th>".$row["sell_pricer"]."</th>
			<th>".$row["zone_id"]."</th>
			<th>".$row["category_id"]."</th>
			<th>".$row["category_minor_name"]."</th>
		</tr>

		";
	}
}else{
echo "0 result";
}
?>


</body>
</html>