<?php
if (isset($_POST['Abort'])){
	header("Location: pushmgm.php");
	exit();
}
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

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
// 處理使用者異動之資料
if (isset($Confirm)) {   // 確認按鈕
    if (empty($categoryname)) $ErrMsg = '分類名稱不可為空白\n';
	if (isset($_POST['categoryname'])) $categoryname =$_POST['categoryname'];
	if (isset($_POST['Text'])) $Text =$_POST['Text'];
	//if (isset($_POST['type'])) $type = $_POST['type'];
	if (isset($_POST['Status'])) $Status = $_POST['Status'];
	
    if (empty($ErrMsg)) {   // 資料經初步檢核沒問題
        $sqlcmd="UPDATE beacons_push SET text='$Text',category_id='$categoryname',soft_delete='$Status' WHERE id='$pid'";
        $result = updatedb($sqlcmd, $db_conn);
		
		if ( $_FILES["upfile"]["size"] > 0 ) 
        {
				$typeok = TRUE;
				/*switch($_FILES['upfile']['type'])
				{
				  case "image/gif":   $src ="gif"; break;
				  case "image/jpeg":  // Both regular and progressive jpegs
				  case "image/pjpeg": $src = "jpg"; break;
				  case "image/png":   $src = "png"; break;
				  default:            $typeok = FALSE; break;
				}*/
			if ($typeok)
			{
				$saveto = "../../api/pushpicture/push".$pid.".png";
				move_uploaded_file($_FILES['upfile']['tmp_name'], $saveto);
			}
		}
		
        header("Location: pushmgm.php");
        exit();
    }
}
if (!isset($productid)) {    
// 此處是在contactlist.php點選後進到這支程式，因此要由資料表將欲編輯的資料列調出
	$sqlcmd = "SELECT * FROM beacons_push WHERE id='$pid'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) <= 0) die('No data found');      // 找不到資料，正常應該不會發生
	$CategoryID = $rs[0]['category_id'];
	//$type = $rs[0]['type'];
	$Text = $rs[0]['text'];
	$Status = $rs[0]['soft_delete'];
} 

$PageTitle = '修改商品資料';
require_once("../include/header3.php");
?>
<body>
<div align="center">
<form action="" method="post" name="inputform" enctype="multipart/form-data">
<b>新增商品資料</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
<tr height="30">
  <th width="40%">圖片</th>
  <td><input Type="file" Name="upfile" size="20"></td>
</tr>
<tr height="30">
  <th>分類名稱</th>
  <td><select name="categoryname">
<?php
    foreach ($CategoryNames as $ID => $categoryName) {
        echo '    <option value="' . $ID . '"';
		if ($ID == $CategoryID) echo ' selected';
        echo ">$categoryName</option>\n";
    } 
?>
    </select>
  </td>
</tr>
<!--<tr height="30">
  <th>類型</th>
  <td><select name="type">
<?php
$typearray =array('0'=>'圖','1'=>'文字','2'=>'圖+文字');
    for ($p=0 ;$p<=2;$p++ ) {
		$a=$typearray["$p"];
        echo '    <option value="' . $p . '"';
        if ($p == $type) echo ' selected';
        echo ">$a</option>\n";
    } 
?>
    </select>
  </td>
</tr>-->
<tr height="30">
  <th>狀態</th>
  <td><select name="Status">
<?php
$statusarray =array('0'=>'啟用','1'=>'未啟用');
    for ($p=0 ;$p<=1;$p++ ) {
		$a=$statusarray["$p"];
        echo '    <option value="' . $p . '"';
        if ($p == $Status) echo ' selected';
        echo ">$a</option>\n";
    } 
?>
    </select>
  </td>
</tr>

<tr height="100">
  <th width="40%">文字</th>
  <td><textarea name="Text" style="width:500px;height:90px;"><?php echo $Text; ?></textarea></td>
</tr>
</table>
<input type="hidden" name="pid" value="<?php echo $pid; ?>">
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄修改">
</form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>