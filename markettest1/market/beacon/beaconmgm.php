<?php
require_once("../include/auth.php");
require_once("../include/require.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$PageTitle = '佳瑪商品';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");

$sqlcmd = "SELECT count(*) AS reccount FROM beacons_place";
$rs = querydb($sqlcmd, $db_conn);
//計算頁數
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['beaconCurPage'])&&$_SESSION['beaconCurPage']>0) $Page = $_SESSION['beaconCurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['beaconCurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;
//取出分類資料*************************/
/*$sqlcmd = "SELECT * FROM categories";
$rs = querydb($sqlcmd, $db_conn);
$CategoryNames = array();
foreach ($rs as $item) {
    $CID = $item['id'];
    $CategoryNames[$CID] = $item['number'].$item['name'];
}
//取出beacon資料
$sqlcmd = "SELECT * FROM beacons";
$rs = querydb($sqlcmd, $db_conn);
$BeaconsNames = array();
foreach ($rs as $item) {
    $BID = $item['id'];
    $BeaconsNames[$BID] =$item['name'];
}*/
/*$sqlcmd = "SELECT * FROM subcategories";
$rs = querydb($sqlcmd, $db_conn);
$SubcategoryNames = array();
foreach ($rs as $item) {
	$SCID = $item['id'];
    $CID = $item['category_id'];
    $SubcategoryNames[$SCID] = $CategoryNames[$CID].$item['number'].$item['name'];
}*/
/*******************************************/
$sqlcmd = "SELECT bp.id AS id,concat(cg.number,cg.name) AS category_name,b.name AS beacon_id FROM beacons_place bp,categories cg,beacons b where b.id=bp.beacon_id and bp.category_id=cg.id ORDER BY cg.id,b.name LIMIT $StartRec,$ItemPerPage";
$Contacts = querydb($sqlcmd, $db_conn);
?>
<body>
<?php
$logoname='beacon編輯';
$addname='beaconadd';
$modname='beaconmod';
$tablename=array('處理'=>'10','分類'=>'45','beacon號碼'=>'0');
//欄位名稱=>欄位大小(百分比)(0代表不設置)
$tableitem=array('ID'=>'id','1'=>'category_name','2'=>'beacon_id');
//(有要顯示出來用數字排序，否則根據要取的變數命名)=>(從資料庫取出的名字，若要顯示圖片則img)(圖片名字用ID命名，須放在前面)
require_once("../include/mkmgmtable.php");
?>
<!--/*******************************************/-->
<?php require_once("../include/footer.php"); ?>
</body>
</html>