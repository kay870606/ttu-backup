<?php
// 使用者點選放棄修改按鈕
if (isset($_POST['Abort'])){
	header("Location: activityimgmgm.php");
	exit();
}
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

// 處理使用者異動之資料
if (isset($Confirm)) {   // 確認按鈕
    if (empty($Activityname)) $ErrMsg = '活動名稱不可為空白\n';
	if (isset($_POST['Activityname'])) $Activityname =$_POST['Activityname'];
	if (isset($_POST['ActivityID'])) $ActivityID =$_POST['ActivityID'];
	if (isset($_POST['start_date'])) $start_date =$_POST['start_date'];
	if (isset($_POST['end_date'])) $end_date =$_POST['end_date'];
	if (isset($_POST['Status'])) $Status = $_POST['Status'];
	
	$sqlcmd = "SELECT count(*) AS c FROM carousel WHERE name='$Activityname' AND soft_delete='0' AND id!='$ActivityID'";
	$Contacts = querydb($sqlcmd, $db_conn);
	$C=$Contacts[0]['c'];
	if($C>0) $ErrMsg = '此活動已存在\n';
	
    if (empty($ErrMsg)) {   // 資料經初步檢核沒問題
        $sqlcmd="UPDATE carousel SET name='$Activityname',soft_delete='$Status',start_date='$start_date',end_date='$end_date' WHERE id='$ActivityID'";
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
				$saveto = "../../api/discountpicture/discount".$ActivityID.".png";
				move_uploaded_file($_FILES['upfile']['tmp_name'], $saveto);
			}
		}
        header("Location: activityimgmgm.php");
        exit();
    }
}
if (!isset($productid)) {    
// 此處是在contactlist.php點選後進到這支程式，因此要由資料表將欲編輯的資料列調出
	$sqlcmd = "SELECT * FROM carousel WHERE id=$pid";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) <= 0) die('No data found');      // 找不到資料，正常應該不會發生
	$ActivityID=$rs[0]['id'];
	$Activityname = $rs[0]['name'];
	$start_date = $rs[0]['start_date'];
	$end_date = $rs[0]['end_date'];
	$Status = $rs[0]['soft_delete'];
} 

$PageTitle = '修改商品資料';
require_once("../include/header3.php");
?>
<body>
<div align="center">
<form action="" method="post" name="inputform" enctype="multipart/form-data">
<b>修改活動圖片</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
<tr height="30">
  <th width="40%">圖片</th>
  <td><input Type="file" Name="upfile" size="20"></td>
</tr>
<tr height="30">
  <th>活動名稱</th>
  <td><input type="text" name="Activityname" value="<?php echo $Activityname ?>"></td>
</tr>
<tr height="30">
  <th>開始日期</th>
  <td><input type="date" name="start_date" value="<?php echo $start_date ?>"></td>
</tr>
<tr height="30">
  <th>結束日期</th>
  <td style="color:red;"><input type="date" name="end_date" value="<?php echo $end_date ?>">結束日期請大於等於開始日期</td>
</tr>
<tr height="30">
  <th>啟用狀態</th>
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
</table>
<input type="hidden" name="ActivityID" value="<?php echo $ActivityID; ?>">
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄修改">
</form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>