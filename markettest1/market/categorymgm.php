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

$sqlcmd = "SELECT count(*) AS reccount FROM categories";
$rs = querydb($sqlcmd, $db_conn);
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['categoryCurPage'])) $Page = $_SESSION['categoryCurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['categoryCurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;
/*******************************************/
$sqlcmd = "SELECT * FROM sections";
$rs = querydb($sqlcmd, $db_conn);
$SectionNames = array();
foreach ($rs as $item) {
    $SID = $item['id'];
    $SectionNames[$SID] = $item['name'];
}
/*******************************************/
$sqlcmd = "SELECT * FROM categories LIMIT $StartRec,$ItemPerPage";
$Contacts = querydb($sqlcmd, $db_conn);
?>
<body>
<div id="logo">分類的編輯</div>
<!--/*******************************************/-->
<table border="0" width="90%" align="center" cellspacing="0" cellpadding="2" style="margin:10px;">
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
	<a href="categoryadd.php">新增</a>&nbsp;
	<!--<a href="/i4010/logout.php">登出</a>-->
  </td>
</tr>
</table>
<table class="mistab" width="90%" align="center">
<tr>
  <th width="10%">處理</th>
  <th width="20%">區域名稱</th>
  <th width="15%">分類號碼</th>
  <th width="55%">分類名稱</th>
</tr>
<?php
foreach ($Contacts AS $item) {
  $ID=$item['id'];
  $section=$item['section_id'];
  $categoriesname = $item['name'];
  $number = $item['number'];
  $DspMsg = "'確定刪除項目?'";
  echo '<tr align="center"><td>';
?>
  <a href="categorymod.php?pid=<?php echo $ID; ?>&sid=<?php echo $section; ?>">
  <img src="../images/edit.gif" border="0" align="absmiddle"
	alt="按此鈕修改本項目"></a>&nbsp;
</td>
<td><?php echo xssfix($SectionNames[$section])?></td> 
<td><?php echo xssfix($number)?></td> 
<td><?php echo xssfix($categoriesname)?></td>       
</tr>
<?php
}
?>
</table>
<!--/*******************************************/-->
<?php require_once("../include/footer.php"); ?>
</body>
</html>