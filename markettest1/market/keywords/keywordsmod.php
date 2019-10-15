<?php
require_once("../include/auth.php");
// 使用者點選放棄修改按鈕
if (isset($_POST['Abort'])){
	header("Location: keywordsmgm.php");
	unset($_SESSION['array']);
	exit();
}
// 變數及函式處理，請注意其順序
require_once("../include/require.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

//增加敘述
$Keywordmapping="0";
if(isset($_POST['keywordmapping'])) $Keywordmapping= $_POST['keywordmapping'];
$sele = array("0","1","2","3","4","5","6","7","8","9","10");
if(isset($_SESSION['array'])) {
	$keywordmappingarray=$_SESSION['array'];
}else{
	$keywordmappingarray= array();
}
// 處理使用者異動之資料
if (isset($Confirm)) {   // 確認按鈕
    if (empty($keywordname)) $ErrMsg = '關鍵字不可為空白\n';
	if (isset($_POST['keywordname'])) $keywordname = $_POST['keywordname'];
	$keywordmappingarray=array();
	$num=0;
	for($k=1;$k<=$keywordmapping_number;$k++){
		if (!empty($_POST["keywordmapping$k"])) {
			$keywordsmapping=$_POST["keywordmapping$k"];
			$num++;
		}else{
			continue;
		}
		$keywordmappingarray[$k]="$keywordsmapping";
	}
	if (empty($num)) $ErrMsg = '關鍵字對應不可為0\n';
    if (empty($ErrMsg)) {   // 資料經初步檢核沒問題	
		$jskeywordmapping=json_encode($keywordmappingarray,320);
        $sqlcmd="UPDATE keywords SET name='$keywordname',mapping='$jskeywordmapping' WHERE id='$id'";
        $result = updatedb($sqlcmd, $db_conn);
		
		unset($_SESSION['array']);
        header("Location: keywordsmgm.php");
        exit();
    }
}
if (!isset($keywordname)) {    
// 此處是在contactlist.php點選後進到這支程式，因此要由資料表將欲編輯的資料列調出
	$sqlcmd = "SELECT * FROM keywords WHERE id=$pid";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) <= 0) die('No data found');      // 找不到資料，正常應該不會發生
    $keywordname = $rs[0]['name'];
	$id = $rs[0]['id'];
	$keywordsmapping = $rs[0]['mapping'];
	if(!empty($keywordsmapping)){
		$keywordmappingarray=json_decode($keywordsmapping,true);
		$_SESSION['array']=$keywordmappingarray;
	}
} 

$PageTitle = '修改關鍵字資料';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");
?>
<body>
<div align="center">
<form action="" method="post" name="inputform" enctype="multipart/form-data">
<b>修改關鍵字資料</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
<tr height="30">
  <th width="40%">關鍵字名稱</th>
  <td><input type="text" name="keywordname" value="<?php echo $keywordname ?>" size="50"></td>
</tr>
<?php
$i=0;
foreach($keywordmappingarray as $num => $word ){
	$i++;
	$keywordsmapping="keywordmapping".$i;
	?>
<tr height="30">
  <th width="40%">對應關鍵字<?php echo $i ?></th>
  <td><input type="text" name="<?php echo $keywordsmapping ?>" value="<?php echo $word ?>" size="50"></td>
</tr>
<?php } ?>
<tr height="30">
  <th>幾個敘述</th>
	<td><select name="keywordmapping" onchange="submit();">
		<?php
		foreach($sele as $num){
			echo '<option value="'.$num.'"';
			if($Keywordmapping == $num) echo 'selected';
			echo '>'.$num.'</option>';
		}
		?>
	</select>
  </td>
</tr>
<?php
$s=$i;
for($k=1;$k<=$Keywordmapping;$k++){
	$s=$k+$i;
	$keywordsmapping="keywordmapping".$s; 
	?>
<tr height="30">
  <th width="40%">對應關鍵字<?php echo $k ?></th>
  <td><input type="text" name="<?php echo $keywordsmapping ?>" size="50"></td>
</tr>
<?php } ?>
</table>
<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="keywordmapping_number" value="<?php echo $s; ?>">
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄修改">
</form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>