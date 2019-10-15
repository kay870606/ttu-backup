<?php
require_once("../include/auth.php");
require_once("../include/require.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$PageTitle = '佳瑪商品';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");

$sqlcmd = "SELECT count(*) AS reccount FROM activities";
$rs = querydb($sqlcmd, $db_conn);
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['activityCurPage'])&&$_SESSION['activityCurPage']>0) $Page = $_SESSION['activityCurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['activityCurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;

$sqlcmd = "SELECT * FROM activities LIMIT $StartRec,$ItemPerPage";
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
$logoname='活動清單';
$addname='activityimgadd';
$modname='activityimgmod';
$activityimg=1;
$tablename=array('處理'=>'10','活動名稱'=>'30','開始時間'=>'15','結束時間'=>'15','活動狀態'=>'10','啟用狀態'=>'10','圖片'=>'0');
//欄位名稱=>欄位大小(百分比)(0代表不設置)
$tableitem=array('ID'=>'id','start_date'=>'start_date','end_date'=>'end_date','Status'=>'soft_delete','1'=>'name','2'=>'start_date','3'=>'end_date','4'=>'activity','5'=>'Statusname','6'=>'img');
//(有要顯示出來用數字排序，否則根據要取的變數命名)=>(從資料庫取出的名字，若要顯示圖片則img)(圖片名字用ID命名，須放在前面)
require_once("../include/mkmgmtable.php");
$c=1;
	foreach ($Contacts AS $item) {
	$img ="<img src='/images/activities/$ID.png' width='880px' height='400px'>";
	echo "<div class='lightbox-target' id='notice$c'>".$img."<a class='lightbox-close' href='##'></a></div>";
	$c++;
}
?>
<?php require_once("../include/footer.php"); ?>
</body>
</html>