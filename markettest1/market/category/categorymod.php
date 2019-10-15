<?php
require_once("../include/auth.php");
if (isset($_POST['Abort'])){
	header("Location: categorymgm.php");
	exit();
}
require_once("../include/require.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

// 處理使用者異動之資料
if (isset($Confirm)) {   // 確認按鈕
    if (empty($categoryname)) $ErrMsg = '分類名稱不可為空白\n';
	if (isset($_POST['categoryname'])) $categoryname =$_POST['categoryname'];
	if (isset($_POST['sectionname'])) $sectionname =$_POST['sectionname'];
	if (isset($_POST['categoryID'])) $categoryID =$_POST['categoryID'];
	
    if (empty($ErrMsg)) {   // 資料經初步檢核沒問題
        $sqlcmd="UPDATE categories SET name='$categoryname',section_id='$sectionname' WHERE id='$categoryID'";
        $result = updatedb($sqlcmd, $db_conn);
		
        header("Location: categorymgm.php");
        exit();
    }
}
if (!isset($categoryID)) {    
// 此處是在contactlist.php點選後進到這支程式，因此要由資料表將欲編輯的資料列調出
	$sqlcmd = "SELECT * FROM categories WHERE id=$pid";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) <= 0) die('No data found');      // 找不到資料，正常應該不會發生
	$categoryID=$rs[0]['id'];
	$categoryname = $rs[0]['name'];
	$categorynumber = $rs[0]['number'];
	$sectionnumber = $rs[0]['section_id'];
} 
$sqlcmd = "SELECT * FROM sections";
$rs = querydb($sqlcmd, $db_conn);
$SectionNames = array();
foreach ($rs as $item) {
    $SID = $item['id'];
    $SectionNames[$SID] = $item['name'];
}

$PageTitle = '修改商品類別';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");
?>
<body>
<div align="center">
<form action="" method="post" name="inputform" enctype="multipart/form-data">
<b>修改商品類別</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
<tr height="30">
  <th>區域名稱</th>
  <td><select name="sectionname">
<?php
    foreach ($SectionNames as $ID => $sectionName) {
        echo '    <option value="' . $ID . '"';
		if($ID==$sectionnumber) echo " selected";
        echo ">$sectionName</option>\n";
    } 
?>
    </select>
  </td>
</tr>
<tr height="30">
  <th>類別號碼</th>
  <td><?php echo $categorynumber ?></td>
</tr>
<tr height="30">
  <th>類別名稱</th>
  <td><input type="text" name="categoryname" value="<?php echo $categoryname ?>"></td>
</tr>
</table>
<input type="hidden" name="categoryID" value="<?php echo $categoryID; ?>">
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄修改">
</form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>