<?php
require_once("../include/auth.php");
require_once('../include/gpsvars.php');
require_once('../include/header2.php');
?>
<body>
<header style="height:20px">
<table border="0" width="90%" align="center" cellspacing="0"cellpadding="2" >
<tr>
	<td><a href="contactmgm.php" target="iframe_b">商品管理</a></td>
	<td><a href="pushmgm.php" target="iframe_b">推播管理</a></td>
	<td><a href="activityimgmgm.php" target="iframe_b">活動管理</a></td>
	<td><a href="categorymgm.php" target="iframe_b">分類的編輯</a></td>
	<td><a href="beaconmgm.php" target="iframe_b">beacon編輯</a></td>
	<td><a href="keywordsmgm.php" target="iframe_b">關鍵字編輯</a></td>
	<td><a href="index1.php" >登出</a></td>
</tr>
</table>
</header>
<article>
  <iframe align="center"  width="100%" height="100%" style="border: 0px solid gray;"src="contactmgm.php" name="iframe_b"></iframe>
</article>
</body>
</html>
