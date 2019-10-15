<?php
require_once("../include/auth.php");
require_once("../include/require.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$PageTitle = '關鍵字清單';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");

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
<?php 
$logoname='關鍵字清單';
$addname='keywordsadd';
$modname='keywordsmod';
$tablename=array('處理'=>'10','關鍵字名稱'=>'20','關鍵字對應'=>'70');
//欄位名稱=>欄位大小(百分比)(0代表不設置)
$tableitem=array('ID'=>'id','1'=>'name','2'=>'mapping');
//(有要顯示出來用數字排序，否則根據要取的變數命名)=>(從資料庫取出的名字，若要顯示圖片則img)(圖片名字用ID命名，須放在前面)
require_once("../include/mkmgmtable.php");
require_once("../include/footer.php"); ?>
</body>
</html>