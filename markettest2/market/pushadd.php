<?php
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort'])){ 
header("Location: pushmgm.php"); 
exit();
}
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
if (!isset($categoryname)) $categoryname = '';
if (!isset($Text)) $Text = '';
//if (!isset($type)) $type = '';
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
    if (empty($categoryname)) $ErrMsg = '小分類名稱不可為空白\n';
	if (isset($_POST['categoryname'])) $categoryname =$_POST['categoryname'];
	if (isset($_POST['Text'])) $Text =$_POST['Text'];
	//if (isset($_POST['type'])) $type = $_POST['type'];
	
    if (empty($ErrMsg)) {
		$sqlcmd = "SELECT count(*) AS reccount FROM beacons_push ";
		$rs = querydb($sqlcmd, $db_conn);
		$C = $rs[0]['reccount'];
		$C++;
		$ur ='http://140.129.25.75/api/pushpicture/push'.$C.'.png';
        $sqlcmd='INSERT INTO beacons_push (category_id,img,text) VALUES ('
				. "'$categoryname','$ur','$Text')";
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
				//$saveto = "../img/".$PLID.".".$src;
				$saveto = "../../api/pushpicture/push".$C.".png";
				move_uploaded_file($_FILES['upfile']['tmp_name'], $saveto);
			}
		}
		else
        {
         echo "圖片上傳失敗";
        }

        header("Location: pushmgm.php");
		exit();
    }
}
$PageTitle = '新增商品資料';
require_once("../include/header3.php");
?>
<body>
<div align="center">
<form action="" method="post" name="inputform" enctype="multipart/form-data">
<b>新增推播</b>
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
$type =array('0'=>'圖','1'=>'文字','2'=>'圖+文字');
    for ($p=0 ;$p<=2;$p++ ) {
		$a=$type["$p"];
        echo '    <option value="' . $p . '"';
        if ($p == $type) echo ' selected';
        echo ">$a</option>\n";
    } 
?>
    </select>
  </td>
</tr>
-->
<tr height="100">
  <th width="40%">文字</th>
  <td><textarea name="Text" style="width:500px;height:90px;"></textarea></td>
</tr>
</table>
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄新增">
</form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>