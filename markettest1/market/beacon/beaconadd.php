<?php
require_once("../include/auth.php");
if (isset($_POST['Abort'])){
    header("Location: beaconmgm.php");
    exit();
}
require_once("../include/require.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
if (!isset($categoryname)) $categoryname = '';
if (!isset($Text)) $Text = '';
// 取出群組資料
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
if (isset($Confirm)) {   // 確認按鈕
    if (empty($categoryname)) $ErrMsg = '分類名稱不可為空白\n';
    if (isset($_POST['categoryname'])) $categoryname =$_POST['categoryname'];
    if (isset($_POST['Text'])) $Text =$_POST['Text'];

		$sqlcmd = "SELECT count(*) AS reccount FROM beacons_place where beacon_id='$Text' AND category_id='$categoryname' ";
		$rs = querydb($sqlcmd, $db_conn);
		$C = $rs[0]['reccount'];
		if($C>0) $ErrMsg = '不要輸入重複的資料\n';
    if (empty($ErrMsg)) {
        $sqlcmd='INSERT INTO beacons_place (beacon_id,category_id) VALUES ('
            . "'$Text','$categoryname')";
        $result = updatedb($sqlcmd, $db_conn);

        header("Location: beaconmgm.php");
        exit();
    }
}
$PageTitle = '新增商品資料';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");
?>
<body>
<div align="center">
    <form action="" method="post" name="inputform" enctype="multipart/form-data">
        <b>新增推播</b>
        <table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">

            <tr height="30">
                <th>分類名稱</th>
                <td><select name="categoryname">
                        <?php
                        foreach ($CategoryNames as $ID => $categoryName) {
                            echo '    <option value="' . $ID . '"';
                            echo ">$categoryName</option>\n";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th width="40%">beacon號碼</th>
                <td><input type="number" name="Text" ></td>
            </tr>
        </table>
        <input type="submit" name="Confirm" value="存檔送出">&nbsp;
        <input type="submit" name="Abort" value="放棄新增">
    </form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>