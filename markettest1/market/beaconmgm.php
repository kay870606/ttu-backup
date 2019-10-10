<?php
// Authentication 認證
require_once("../include/auth.php");
//session_start();
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$PageTitle = '佳瑪商品';
require_once("../include/header3.php");

$sqlcmd = "SELECT count(*) AS reccount FROM beacons_place";
$rs = querydb($sqlcmd, $db_conn);
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['beaconCurPage'])&&$_SESSION['beaconCurPage']>0) $Page = $_SESSION['beaconCurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['beaconCurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;
/*******************************************/
$sqlcmd = "SELECT * FROM categories";
$rs = querydb($sqlcmd, $db_conn);
$CategoryNames = array();
foreach ($rs as $item) {
    $CID = $item['id'];
    $CategoryNames[$CID] = $item['number'].$item['name'];
}
/*$sqlcmd = "SELECT * FROM subcategories";
$rs = querydb($sqlcmd, $db_conn);
$SubcategoryNames = array();
foreach ($rs as $item) {
	$SCID = $item['id'];
    $CID = $item['category_id'];
    $SubcategoryNames[$SCID] = $CategoryNames[$CID].$item['number'].$item['name'];
}*/
/*******************************************/
$sqlcmd = "SELECT * FROM beacons_place ORDER BY category_id,beacon_id LIMIT $StartRec,$ItemPerPage";
$Contacts = querydb($sqlcmd, $db_conn);
?>
<body>
<div id="logo">beacon編輯</div>
<!--/*******************************************/-->
<table border="0" width="90%" align="center" cellspacing="0"
  cellpadding="2">
<tr>
  <td width="50%" align="left">
<?php if ($TotalPage >=1) { ?>
<form name="SelPage" method="POST" action="">
  第<select name="Page" onchange="submit();">
<?php 
for ($p=1; $p<=$TotalPage; $p++) { 
	echo '  <option value="' . $p . '"';
	if ($p == $Page) echo ' selected';
	echo ">$p</option>\n";
}
?>
  </select>頁 共<?php echo $TotalPage ?>頁
</form>
<?php } ?>
  <td>
  <td align="right" width="30%">
	<a href="beaconadd.php">新增</a>&nbsp;
	<!--<a href="/i4010/logout.php">登出</a>-->
  </td>
</tr>
</table>
<table class="mistab" width="90%" align="center">
<tr>
  <th width="10%">處理</th>
  <th width="45%">分類</th>
  <th>beacon號碼</th>
</tr>
<?php
$c=1;
foreach ($Contacts AS $item) {
  $ID=$item['id'];
  $CategoryID = $item['category_id'];
  $BeaconID = $item['beacon_id'];
  $DspMsg = "'確定刪除項目?'";
  echo '<tr align="center"><td>';
?>
  <a href="beaconmod.php?pid=<?php echo $ID; ?>">
  <img src="../images/edit.gif" border="0" align="absmiddle"
	alt="按此鈕修改本項目"></a>&nbsp;
  </td>
  <td><?php echo xssfix($CategoryNames[$CategoryID])  ?></td> 
	<td><?php echo xssfix($BeaconID)?></td>    
  </tr>
<?php
}
?>
</table>
<!--/*******************************************/-->
<?php require_once("../include/footer.php"); ?>
</body>
</html>