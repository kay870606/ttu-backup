<?php
require_once("../include/auth.php");
if (isset($_POST['Abort'])) {
    header("Location: beaconmgm.php");
    exit();
}
require_once("../include/require.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

if (isset($Confirm)) {   // 確認按鈕
    if (empty($categoryname)) $ErrMsg = '分類名稱不可為空白\n';
    if (isset($_POST['categoryname'])) $categoryname = $_POST['categoryname'];
    if (isset($_POST['Text'])) $Text = $_POST['Text'];
	if (isset($_POST['BID'])) $BID = $_POST['BID'];
    if (empty($ErrMsg)) {
        $sqlcmd = "UPDATE beacons_place SET beacon_id='$Text' ,category_id='$categoryname' where id='$BID'";
        $result = updatedb($sqlcmd, $db_conn);
		
        header("Location: beaconmgm.php");
        exit();
    }
}
if (!isset($categoryID)) {    
// 此處是在contactlist.php點選後進到這支程式，因此要由資料表將欲編輯的資料列調出
	$sqlcmd = "SELECT * FROM beacons_place WHERE id=$pid";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) <= 0) die('No data found');      // 找不到資料，正常應該不會發生
	$BID=$rs[0]['id'];
	$categoryID=$rs[0]['category_id'];
	$beaconID=$rs[0]['beacon_id'];
} 
// 取出群組資料
$sqlcmd = "SELECT * FROM categories";
$rs = querydb($sqlcmd, $db_conn);
$CategoryNames = array();
foreach ($rs as $item) {
    $CID = $item['id'];
    $CategoryNames[$CID] = $item['number'] . $item['name'];
}
/*$sqlcmd = "SELECT * FROM subcategories";
$rs = querydb($sqlcmd, $db_conn);
$SubcategoryNames = array();
foreach ($rs as $item) {
	$SCID = $item['id'];
    $CID = $item['category_id'];
    $SubcategoryNames[$SCID] = $CategoryNames[$CID].$item['number'].$item['name'];
}*/
$PageTitle = '修改beacon類別';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");
?>
<body>
<div align="center">
    <form action="" method="post" name="inputform" enctype="multipart/form-data">
        <b>修改beacon類別</b>
        <table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
            <tr height="30">
                <th>分類名稱</th>
                <td><select name="categoryname">
                        <?php
                        foreach ($CategoryNames as $ID => $categoryName) {
                            echo '    <option value="' . $ID . '"';
							if($ID==$categoryID) echo " selected";
                            echo ">$categoryName</option>\n";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th width="40%">beacon號碼</th>
                <td><input type="number" name="Text" value="<?php echo $beaconID ?>"></td>
            </tr>
        </table>
		<input type="hidden" name="BID" value="<?php echo $BID; ?>">
        <input type="submit" name="Confirm" value="存檔送出">&nbsp;
        <input type="submit" name="Abort" value="放棄新增">
    </form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>