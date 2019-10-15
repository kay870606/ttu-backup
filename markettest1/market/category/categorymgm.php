<?php
require_once("../include/auth.php");
require_once("../include/require.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$PageTitle = '佳瑪商品';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");

if(!isset($section)){ 
if (isset($_SESSION['sectionCurPage'])) $section = $_SESSION['sectionCurPage'];
    else $section=7;
}
$_SESSION['sectionCurPage']=$section;
if (!isset($type)) {
		if (isset($_SESSION['typenumber'])) $type = $_SESSION['typenumber'];
		else $type = 1;
	}
$_SESSION['typenumber'] = $type;
if($type==1){
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
}else{
	$sqlcmd = "SELECT count(*) AS reccount FROM categories where section_id=$section";
	$rs = querydb($sqlcmd, $db_conn);
	$RecCount = $rs[0]['reccount'];
	$TotalPage = (int) ceil($RecCount/$ItemPerPage);
	if (!isset($Spage)) {
		if (isset($_SESSION['sectionPage'])) $Spage = $_SESSION['sectionPage'];
		else $Spage = 1;
	}
	if ($Spage > $TotalPage) $Spage = $TotalPage;
	$_SESSION['sectionPage'] = $Spage;
	$StartRec = ($Spage-1) * $ItemPerPage;
}
/*******************************************/
$sqlcmd = "SELECT * FROM sections where floor='3'";
$rs = querydb($sqlcmd, $db_conn);
$SectionNames = array();
foreach ($rs as $item) {
    $SID = $item['id'];
    $SectionNames[$SID] = $item['name'];
}
/*******************************************/
if($type==1){
	$sqlcmd = "SELECT s.name sname,c.id id,c.section_id,c.number,c.name cname  FROM categories c,sections s where s.id=c.section_id  LIMIT $StartRec,$ItemPerPage";
}else{
$sqlcmd = "SELECT s.name sname,c.id id,c.section_id,c.number,c.name cname  FROM categories c,sections s where s.id=c.section_id and s.id=$section LIMIT $StartRec,$ItemPerPage";	
}
$Contacts = querydb($sqlcmd, $db_conn);

?>
<body>
<?php 
$logoname='分類的編輯';
$addname='categoryadd';
$modname='categorymod';
$category=1;
$tablename=array('處理'=>'10','區域名稱'=>'20','分類號碼'=>'10','分類名稱'=>'55');
//欄位名稱=>欄位大小(百分比)(0代表不設置)
$tableitem=array('ID'=>'id','1'=>'sname','2'=>'number','3'=>'cname');
//(有要顯示出來用數字排序，否則根據要取的變數命名)=>(從資料庫取出的名字，若要顯示圖片則img)(圖片名字用ID命名，須放在前面)
require_once("../include/mkmgmtable.php");
require_once("../include/footer.php"); ?>
</body>
</html>