<?php
require_once("../include/auth.php");
require_once("../include/require.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

if (isset($action) && $action=='recover'&& isset($pid)) {
    // Recover this item
    // Check whether this user have the right to modify this contact info
    $sqlcmd = "SELECT * FROM products WHERE id=$pid AND soft_delete='1'";
    $rs = querydb($sqlcmd, $db_conn);
	
    if (count($rs) > 0) {
            $sqlcmd = "UPDATE products SET soft_delete='0' WHERE id=$pid";
            $result = updatedb($sqlcmd, $db_conn);
    }
}
if (isset($action) && $action=='delete'&& isset($pid)) {
    // Invalid this item
    // Check whether this user have the right to modify this contact info
    $sqlcmd = "SELECT * FROM products WHERE id=$pid AND soft_delete='0'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) > 0) {
            $sqlcmd = "UPDATE products SET soft_delete='1' WHERE id=$pid";
            $result = updatedb($sqlcmd, $db_conn);
    }

}
$PageTitle = '佳瑪商品';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");
//計算頁數
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
//抓商品資料
$sqlcmd = "SELECT PS.name PSN,PC.number PCI,PC.name PCN,PSC.name PSCN,P.id PPID,P.ean,P.name PN,P.price,P.description,P.specification,P.soft_delete FROM products P,categories PC,subcategories PSC,sections PS WHERE P.subcategory_id=PSC.id AND PSC.category_id=PC.id AND PC.section_id=PS.id LIMIT $StartRec,$ItemPerPage";
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
<?php
$logoname='商品清單';
$addname='contactadd';
$contactmgm=1;//有設置就會開啟刪除恢復功能
$modname='contactmod';
$tablename=array('處理'=>'5','圖片'=>'5','國際條碼'=>'10','商品名稱'=>'13','價格'=>'5','區域名稱'=>'7','分類編號'=>'5','分類名稱'=>'12','子分類名稱'=>'8','資訊'=>'15','敘述'=>'15');
//欄位名稱=>欄位大小(百分比)(0代表不設置)
$tableitem=array('Status'=>'soft_delete','ID'=>'PPID','1'=>'img','2'=>'ean','3'=>'PN','4'=>'price','5'=>'PSN','6'=>'PCI','7'=>'PCN','8'=>'PSCN','9'=>'description','10'=>'specification');
require_once("../include/mkmgmtable.php");
$c=1;
	foreach ($Contacts AS $item) {
	$Model = $item['ean'];
	$img="<img src='/images/products/$ID.png' width='400px' height='400px'>";
	echo "<div class='lightbox-target' id='notice$c'>".$img."<a class='lightbox-close' href='##'></a></div>";
	$c++;
}
?>
<?php require_once("../include/footer.php"); ?>
</body>
</html>