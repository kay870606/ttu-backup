<?php
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort'])){ 
header("Location: activityimgmgm.php"); 
exit();
}
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
if (!isset($Activityname)) $Activityname = '';
if (!isset($start_date)) $start_date = '';
if (!isset($end_date)) $end_date = '';
if (isset($Confirm)) {   // 確認按鈕
    if (empty($Activityname)) $ErrMsg = '活動名稱不可為空白\n';
	if (isset($_POST['Activityname'])) $Activityname =$_POST['Activityname'];
	if (isset($_POST['start_date'])) $start_date =$_POST['start_date'];
	if (isset($_POST['end_date'])) $start_date =$_POST['end_date'];
	$sqlcmd = "SELECT count(*) AS c FROM carousel WHERE name='$Activityname' AND soft_delete='0'";
	$Contacts = querydb($sqlcmd, $db_conn);
	$C=$Contacts[0]['c'];
	if($C>0) $ErrMsg = '此活動已存在\n';
	
	if(strtotime($start_date)>strtotime($end_date)) $ErrMsg = '結束日期請大於等於開始日期\n';
	
    if (empty($ErrMsg)) {
		$sqlcmd = "SELECT count(*) AS reccount FROM carousel";
		$rs = querydb($sqlcmd, $db_conn);
		$C = $rs[0]['reccount'];
		$C++;
		$ur ='http://140.129.25.75/api/discountpicture/discount'.$C.'.png';
        $sqlcmd="INSERT INTO carousel (name,img,start_date,end_date) VALUES ('$Activityname','$ur','$start_date','$end_date')";
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
				$saveto = "../../api/discountpicture/discount".$C.".png";
				move_uploaded_file($_FILES['upfile']['tmp_name'], $saveto);
			}
		}
		else
        {
         echo "圖片上傳失敗";
        }

        header("Location: activityimgmgm.php");
		exit();
    }
}
$PageTitle = '新增商品資料';
require_once("../include/header3.php");
?>
<body>
<div align="center">
<form action="" method="post" name="inputform" enctype="multipart/form-data">
<b>新增活動圖片</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
<tr height="30">
  <th width="40%">圖片</th>
  <td><input Type="file" Name="upfile" size="20"></td>
</tr>
<tr height="30">
  <th>活動名稱</th>
  <td style="color:red;"><input type="text" name="Activityname" value="<?php echo $Activityname ?>">活動名稱請不要重複</td>
</tr>
<tr height="30">
  <th>開始日期</th>
  <td><input type="date" name="start_date" value="<?php echo $start_date ?>"></td>
</tr>
<tr height="30">
  <th>結束日期</th>
  <td style="color:red;"><input type="date" name="end_date" value="<?php echo $end_date ?>">結束日期請大於等於開始日期</td>
</tr>
</table>
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄新增">
</form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>