<?php
// Authentication 認證
require_once("../include/auth.php");
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

if (isset($action) && $action=='recover'&& isset($pid)) {
    // Recover this item
    // Check whether this user have the right to modify this contact info
    $sqlcmd = "SELECT * FROM products WHERE id=$pid AND soft_delete='1'";
    $rs = querydb($sqlcmd, $db_conn);
	
    if (count($rs) > 0) {
//        $GID = $rs[0]['groupid'];
//        if (isset($GroupNames[$GID])) {     // Yes, the  user has the right. Perform update
            $sqlcmd = "UPDATE products SET soft_delete='0' WHERE id=$pid";
            $result = updatedb($sqlcmd, $db_conn);
        }
    //}
}
if (isset($action) && $action=='delete'&& isset($pid)) {
    // Invalid this item
    // Check whether this user have the right to modify this contact info
    $sqlcmd = "SELECT * FROM products WHERE id=$pid AND soft_delete='0'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) > 0) {
//        $GID = $rs[0]['groupid'];
//        if (isset($GroupNames[$GID])) {     // Yes, the user has the right. Perform update
            $sqlcmd = "UPDATE products SET soft_delete='1' WHERE id=$pid";
            $result = updatedb($sqlcmd, $db_conn);
        }
    //}
}
//$ItemPerPage = 1;
$PageTitle = '佳瑪商品';
require_once("../include/header3.php");

$sqlcmd = "SELECT count(*) AS reccount FROM products ";
$rs = querydb($sqlcmd, $db_conn);
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['CurPage'])) $Page = $_SESSION['CurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['CurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;
$sqlcmd = "SELECT PS.id PSI,PS.name PSN,PC.number PCI,PC.name PCN,PSC.number PSCI,PSC.name PSCN,P.id PPID,P.ean,P.name PN,P.price,P.description,P.specification,P.soft_delete FROM products P,categories PC,subcategories PSC,sections PS WHERE P.subcategory_id=PSC.id AND PSC.category_id=PC.id AND PC.section_id=PS.id LIMIT $StartRec,$ItemPerPage";
$Contacts = querydb($sqlcmd, $db_conn);
?>
<Script Language="JavaScript">
<!--
function confirmation(DspMsg, PassArg) {
var name = confirm(DspMsg)
    if (name == true) {
      location=PassArg;
    }
}
-->
</SCRIPT>
<body>
<div id="logo">商品清單</div>
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
    <a href="contactadd.php">新增</a>&nbsp;
    <!--<a href="/i4010/logout.php">登出</a>-->
  </td>
</tr>
</table>
<table class="mistab" width="90%" align="center">
<tr>
  <th width="5%">處理</th>
  <th width="5%">圖片</th>
  <th width="10%">國際條碼</th>
  <th width="13%">商品名稱</th>
  <th width="5%">價格</th>
  <th width="7%">區域名稱</th>
  <th width="5%">分類編號</th>
  <th width="12%">分類名稱</th>
  <th width="8%">子分類名稱</th>
  <th width="15%">資訊</th>
  <th width="15%">敘述</th>
</tr>
<?php
$c=1;
foreach ($Contacts AS $item) {
  $pid = $item['PPID'];
  $Model = $item['ean'];
  $ProductName = $item['PN'];
  $ProductSectionID = $item['PSI'];
  $ProductSectionName = $item['PSN'];
  $ProductCategoryID = $item['PCI'];
  $ProductCategoryName = $item['PCN'];
  $ProductSubcategoryID = $item['PSCI'];
  $ProductSubcategoryName = $item['PSCN'];
  $ProductInformation = $item['description'];
  $ProductSpecification = $item['specification'];
  $Price = $item['price'];
  $Status = $item['soft_delete'];
  $img = "<a href='#notice$c'><img src='/api/picture/$Model.png' width='25px' height='25px'></a>";
  $c++;
//  $GroupName = '&nbsp;';
//  if (isset($GroupNames[$GroupID])) $GroupName = $GroupNames[$GroupID];
  $DspMsg = "'確定刪除項目?'";
  $PassArg = "'contactmgm.php?action=delete&pid=$pid'";
  echo '<tr align="center"><td>';
  if ($Status=='1') {
?>
  <a href="contactmgm.php?action=recover&pid=<?php echo $pid; ?>">
    <img src="../images/recover.gif" border="0" align="absmiddle">
    </a></td>
  <td><?php echo $img;?></td>
  <td><STRIKE><?php echo $Model ?></STRIKE></td>
  <td><STRIKE><?php echo $ProductName ?></STRIKE></td>
<?php } else { ?>
  <a href="javascript:confirmation(<?php echo $DspMsg ?>, <?php echo $PassArg ?>)">
  <img src="../images/void.gif" border="0" align="absmiddle"
    alt="按此鈕將本項目作廢"></a>&nbsp;
  <a href="contactmod.php?pid=<?php echo $pid; ?>">
  <img src="../images/edit.gif" border="0" align="absmiddle"
    alt="按此鈕修改本項目"></a>&nbsp;
  </td>
  <td><?php echo $img;?></td>
  <td><?php echo xssfix($Model) ?></td>
  <td><?php echo xssfix($ProductName) ?></td>  
<?php } ?>
  <td><?php echo xssfix($Price)?></td>  
  <td><?php echo xssfix($ProductSectionName) ?></td>  
  <td><?php echo xssfix($ProductCategoryID) ?></td>  
  <td><?php echo xssfix($ProductCategoryName) ?></td>  
  <td><?php echo xssfix($ProductSubcategoryName) ?></td> 
  <td><?php echo xssfix($ProductInformation) ?></td>
  <td><?php echo xssfix($ProductSpecification) ?></td>    
  </tr>
<?php
}
//print_r($_SESSION);
?>
</table>
<?php
$c=1;
	foreach ($Contacts AS $item) {
	$Model = $item['ean'];
	$img="<img src='/api/picture/$Model.png' width='400px' height='400px'>";
	echo "<div class='lightbox-target' id='notice$c'>".$img."<a class='lightbox-close' href='##'></a></div>";
	$c++;
}
?>
<?php require_once("../include/footer.php"); ?>
</body>
</html>