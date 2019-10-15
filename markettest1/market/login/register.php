<?php
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort'])){ 
header("Location: index.php"); 
exit();
}
// Authentication 認證
//require_once("../include/auth.php");
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
// echo 'I am here';
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
// echo 'I am here point 2';
//$sqlcmd = "SELECT * FROM user WHERE loginid='$LoginID' AND valid='Y'";
//$rs = querydb($sqlcmd, $db_conn);
//if (count($rs) <= 0) die ('Unknown or invalid user!');
//$UserGroupID = $rs[0]['groupid'];
/*if (!isset($GroupID))  $GroupID = $rs[0]['groupid'];
if (!isset($Name)) $Name = '';
if (!isset($Phone)) $Phone = '';
if (!isset($Address)) $Address = '';*/
if (!isset($Account)) $Account = '';
if (!isset($Password)) $Password = '';
if (!isset($Gmail)) $Gmail = '';
if (!isset($Cardnumber)) $Cardnumber = '';

//if (!isset($URL)) $URL = '';
//增加敘述
$Description="4";
if(isset($_POST['description'])) $Description= $_POST['description'];
$sele = array("1","2","3","4","5","6","7","8","9","10");
// 取出群組資料

if (isset($Confirm)) {   // 確認按鈕
    if (empty($Account)) $ErrMsg = '帳號不可為空白\n';
	if (empty($Password)) $ErrMsg = '密碼不可為空白\n';
	//if (empty($URL)) $ErrMsg = '網址不可為空白\n';
	if (isset($_POST['Account'])) $Account = $_POST['Account'];
	if (isset($_POST['Password'])) $Password = $_POST['Password'];
	$Password=hash('sha1',$Password);
	if (isset($_POST['Gmail'])) $Gmail = $_POST['Gmail'];
	if (isset($_POST['Cardnumber'])) $Cardnumber =$_POST['Cardnumber'];
	//if (isset($_POST['URL'])) $URL = $_POST['URL'];
    if (empty($ErrMsg)) {
        // 確定此用戶可設定所選定群組的聯絡人資料
        /*$sqlcmd = "SELECT privilege FROM privileges "
            . "WHERE loginid='$LoginID' AND groupid='$GroupID' AND privilege>0";
        $rs = querydb($sqlcmd, $db_conn);*/
        // 若權限表未設定權限，則設為用戶的群組
        //if (count($rs) <= 0) $GroupID = $UserGroupID;
		
		$sqlcmd = "SELECT * FROM member WHERE account='$Account'";
		$Contacts = querydb($sqlcmd, $db_conn);
		if (count($Contacts) == 0) {
			$sqlcmd='INSERT INTO member (account,password,gmail,cardnumber) VALUES ('
            . "'$Account','$Password','$Gmail','$Cardnumber')";
			$result = updatedb($sqlcmd, $db_conn);
			
			echo "註冊成功";
			$url="index.php";
?>
			<meta http-equiv="refresh"  content="1; url=<?php echo $url; ?>"> 
<?php
			exit();
		}
		else{
			$ErrMsg = '此帳號已被註冊\n';
			
		}
	}
}
$PageTitle = '註冊';
require_once('../include/header.php');
require_once("index1.php");
?>
<div align="center">
<form action="" method="post" name="inputform" enctype="multipart/form-data">
<b>註冊會員</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">

<tr height="30">
  <th width="40%">帳號</th>
  <td><input type="text" name="Account"  size="20"></td>
</tr>
<tr height="30">
  <th width="40%">密碼</th>
  <td><input type="password" name="Password"  size="50"></td>
</tr>
<tr height="30">
  <th width="40%">Gmail</th>
  <td><input type="email" name="Gmail"  size="50"></td>
</tr>
<tr height="30">
  <th width="40%">Cardnumber(16碼)</th>
  <td><input type="number" name="Cardnumber"  size="50"></td>
</tr>

</table>
<input type="submit" name="Confirm" value="註冊">&nbsp;
<input type="submit" name="Abort" value="回主頁">
</form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>