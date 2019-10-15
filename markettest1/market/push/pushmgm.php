<?php
require_once("../include/auth.php");
require_once("../include/require.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$PageTitle = '佳瑪商品';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");

$sqlcmd = "SELECT count(*) AS reccount FROM beacons_push ";
$rs = querydb($sqlcmd, $db_conn);
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['pushCurPage'])&&$_SESSION['pushCurPage']>0) $Page = $_SESSION['pushCurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['pushCurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;
/*$sqlcmd = "SELECT * FROM beaconplace";
$rs = querydb($sqlcmd, $db_conn);
$place = array();
foreach ($rs as $item) {
    $BID = $item['beaconID'];
	$CID = $item['categoriesID'];
	if(isset($place[$CID])){
		$place[$CID] = $place[$CID]." ".$BID;
	}else{
		$place[$CID] =$BID;
	}
}*/
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
$sqlcmd = "SELECT bp.id id,concat(c.number,c.name) cname,bp.soft_delete,bp.text FROM beacons_push bp,categories c where c.id=bp.category_id order by bp.category_id,bp.id LIMIT $StartRec,$ItemPerPage";
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
$logoname='推播清單';
$addname='pushadd';
$modname='pushmod';
$activityimg=2;
$tablename=array('處理'=>'5','分類名稱'=>'20','狀態'=>'10','文字'=>'0','圖片'=>'10');
//欄位名稱=>欄位大小(百分比)(0代表不設置)
$tableitem=array('ID'=>'id','Status'=>'soft_delete','1'=>'cname','2'=>'Statusname','3'=>'text','4'=>'img');
//(有要顯示出來用數字排序，否則根據要取的變數命名)=>(從資料庫取出的名字，若要顯示圖片則img)(圖片名字用ID命名，須放在前面)
require_once("../include/mkmgmtable.php");
$c=1;
	foreach ($Contacts AS $item) {
	$img ="<img src='/images/beacons_push/$ID.png'>";
	echo "<div class='lightbox-target' id='notice$c'>".$img."<a class='lightbox-close' href='##'></a></div>";
	$c++;
}
?>
<?php require_once("../include/footer.php"); ?>
</body>
</html>