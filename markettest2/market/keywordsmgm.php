<?php
// Authentication 認證
require_once("../include/auth.php");
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

//$ItemPerPage = 1;
$PageTitle = '關鍵字清單';
require_once("../include/header3.php");

$sqlcmd = "SELECT count(*) AS reccount FROM keywords";
$rs = querydb($sqlcmd, $db_conn);
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['keywordsPage'])) $Page = $_SESSION['keywordsPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['keywordsPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;

$sqlcmd = "SELECT * FROM keywords LIMIT $StartRec,$ItemPerPage";
$Contacts = querydb($sqlcmd, $db_conn);
?>
<body>
<div id="logo">關鍵字清單</div>
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
    <a href="keywordsadd.php">新增</a>&nbsp;
    <!--<a href="/i4010/logout.php">登出</a>-->
  </td>
</tr>
</table>
<table class="mistab" width="90%" align="center">
<tr>
  <th width="10%">處理</th>
  <th width="20%">關鍵字名稱</th>
  <th width="70%">關鍵字對應</th>
</tr>
<?php
$c=1;
foreach ($Contacts AS $item) {
  $keywordid = $item['id'];
  $keywordname = $item['name'];
  $keywordmapping = $item['mapping'];
  ?>
	<tr align="center"><td>
  <a href="keywordsmod.php?kid=<?php echo $keywordid; ?>">
  <img src="../images/edit.gif" border="0" align="absmiddle" alt="按此鈕修改本項目"></a>&nbsp;
  </td>
  <td><?php echo xssfix($keywordname) ?></td>
  <td><?php echo xssfix($keywordmapping) ?></td>    
  </tr>
<?php } ?>
</table>
<?php require_once("../include/footer.php"); ?>
</body>
</html>