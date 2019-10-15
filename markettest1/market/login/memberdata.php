<?php
session_start();
if (isset($_POST['Abort'])){
	header("Location: index.php");
	exit();
}
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
if (isset($Confirm)) {   // 確認按鈕
    //if (empty($Account)) $ErrMsg = '帳號不可為空白\n';
    if (empty($Password)) $ErrMsg = '密碼不可為空白\n';
	if (isset($_POST['Account'])) $Account = $_POST['Account'];
	if (isset($_POST['Password'])) $Password = $_POST['Password'];
	$Password=hash('sha1',$Password);
    if (empty($ErrMsg)) {   // 資料經初步檢核沒問題
        if (!get_magic_quotes_gpc()) {
            //$Account = addslashes($Account);
            $Password = addslashes($Password);
            $Gmail = addslashes($Gmail);
			$Cardnumber = addslashes($Cardnumber);
        }
        $sqlcmd="UPDATE member SET password='$Password',gmail='$Gmail',cardnumber='$Cardnumber' WHERE ID='$LoginID'";
        $result = updatedb($sqlcmd, $db_conn);
        header("Location: index.php");
        exit();
    }
}
if (!isset($Password)) {    
// 此處是在contactlist.php點選後進到這支程式，因此要由資料表將欲編輯的資料列調出
	$ID=$_SESSION['LoginID'];
	$sqlcmd = "SELECT *FROM member WHERE ID='$ID'";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) <= 0) die('No data found');      // 找不到資料，正常應該不會發生
    $Account = $rs[0]['account'];
	$Password = $rs[0]['password'];
	$Gmail = $rs[0]['gmail'];
	$Cardnumber = $rs[0]['cardnumber'];
} 
$PageTitle = '修改個人資料';
require_once('../include/header.php');
require_once("index1.php");
?>

<div align="center">
<form action="" method="post" name="inputform" enctype="multipart/form-data">
<b>修改個人資料</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">

<tr height="30">
  <th width="40%">帳號</th>
  <td><?php echo xssfix($Account) ?></td>
</tr>
<tr height="30">
  <th width="40%">密碼</th>
  <td><input type="password" name="Password" value="<?php echo xssfix($Password) ?>" size="50"></td>
</tr>
<tr height="30">
  <th width="40%">Gmail</th>
  <td><input type="email" name="Gmail" value="<?php echo xssfix($Gmail) ?>" size="50"></td>
</tr>
<tr height="30">
  <th width="40%">Cardnumber(16碼)</th>
  <td><input type="number" name="Cardnumber" value="<?php echo xssfix($Cardnumber) ?>" size="50"></td>
</tr>

</table>
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄修改">
</form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>