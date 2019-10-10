<html>
<head>
<meta HTTP-EQUIV="Conent-Type" content="text/html; charset=UTF-8">
</head>
<body>
<?php
require("conn.php");
$sql = "select filepic,filetype from myimage ";
$pr = $Conn->prepare($sql);
$pr->execute();
$result=$pr->fetchAll();
$rowCount=count($result);
if ($rowCount > 0) {
	 
    // output data of each row
	foreach($result as $row) {
		// 輸出圖片資料
		echo "<img src=\"data:".$row[1].";base64,".$row[0]."\">";
	}
}else{
	echo "0 result";
}
?>
<div>
</div>
</body>
</html>