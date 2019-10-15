<?php
require_once("../include/auth.php");
if (isset($_POST['Abort'])){ 
header("Location: categorymgm.php"); 
exit();
}
require_once("../include/require.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
if (!isset($categoryname)) $categoryname = '';
if (!isset($sectionname)) $sectionname = '';
if (!isset($categorynumber)) $categorynumber = '';

$sqlcmd = "SELECT * FROM sections";
$rs = querydb($sqlcmd, $db_conn);
$SectionNames = array();
foreach ($rs as $item) {
    $SID = $item['id'];
    $SectionNames[$SID] = $item['name'];
}

if (isset($Confirm)) {   // 確認按鈕
    if (empty($categoryname)) $ErrMsg = '分類名稱不可為空白\n';
	if (empty($categorynumber)) $ErrMsg = '分類號碼不可為空白\n';
	if (isset($_POST['categoryname'])) $categoryname =$_POST['categoryname'];
	if (isset($_POST['categorynumber'])) $categorynumber =$_POST['categorynumber'];
	if (isset($_POST['sectionname'])) $sectionname =$_POST['sectionname'];
	$sqlcmd = "SELECT count(*) AS c FROM categories WHERE number='$categorynumber'";
	$Contacts = querydb($sqlcmd, $db_conn);
	$C=$Contacts[0]['c'];
	if($C>0) $ErrMsg = '此活動已存在\n';
	
    if (empty($ErrMsg)) {
        $sqlcmd="INSERT INTO categories (name,section_id,number) VALUES ('$categoryname','$sectionname','$categoryname')";
        $result = updatedb($sqlcmd, $db_conn);

        header("Location: categorymgm.php");
		exit();
    }
}
$PageTitle = '新增商品類別';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");
?>
<body>
<div align="center">
<form action="" method="post" name="inputform" enctype="multipart/form-data">
<b>新增商品類別</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
<tr height="30">
  <th>區域名稱</th>
  <td><select name="sectionname">
<?php
    foreach ($SectionNames as $ID => $sectionName) {
        echo '    <option value="' . $ID . '"';
        echo ">$sectionName</option>\n";
    } 
?>
    </select>
  </td>
</tr>
<tr height="30">
  <th>類別號碼</th>
  <td><input type="number" name="categorynumber" min="100" max="999" value="<?php echo $categorynumber ?>"></td>
</tr>
<tr height="30">
  <th>類別名稱</th>
  <td><input type="text" name="categoryname" value="<?php echo $categoryname ?>"></td>
</tr>
</table>
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄新增">
</form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>