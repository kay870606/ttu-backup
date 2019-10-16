<?php
require_once("../include/auth.php");
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort'])){ 
header("Location: keywordsmgm.php"); 
exit();
}
require_once("../include/require.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
if (!isset($keywordname)) $keywordname = '';

//增加對應關鍵字
$Keywordmapping="4";
if(isset($_POST['keywordmapping'])) $Keywordmapping= $_POST['keywordmapping'];
$sele = array("1","2","3","4","5","6","7","8","9","10");
if (isset($Confirm)) {   // 確認按鈕
    if (empty($keywordname)) $ErrMsg = '關鍵字不可為空白\n';
    if (empty($keywordmapping)) $ErrMsg = '關鍵字對應不可為0\n';
	if (isset($_POST['keywordname'])) $keywordname = $_POST['keywordname'];
	
	if (empty($num)) $ErrMsg = '關鍵字對應不可為0\n';
    if (empty($ErrMsg)) {
		//$keywordmappingarray=array();
		$num=0;
		for($k=1;$k<=$Keywordmapping;$k++){
			if (!empty($_POST["keywordmapping$k"])) {
				$keywordsmapping=$_POST["keywordmapping$k"];
				$num++;
			}else{
				continue;
			}
			$sqlcmd='INSERT INTO keywords (name,mapping) VALUES ('
            . "'$keywordname','$keywordsmapping')";
			$result = updatedb($sqlcmd, $db_conn);
			//$keywordmappingarray[$k]="$keywordsmapping";
			
		}
		//$jskeywordmapping=json_encode($keywordmappingarray,320);
		
        /*$sqlcmd='INSERT INTO keywords (name,mapping) VALUES ('
            . "'$keywordname','$jskeywordmapping')";
        $result = updatedb($sqlcmd, $db_conn);*/

        header("Location: keywordsmgm.php");
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
<b>新增關鍵字</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
<tr height="30">
  <th width="40%">關鍵字名稱</th>
  <td><input type="text" name="keywordname" value="<?php echo $keywordname ?>" size="20"></td>
</tr>
<tr height="30">
  <th>幾個對應的關鍵字</th>
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
for($i=1;$i<=$Keywordmapping;$i++){
	$keywordsmapping="keywordmapping".$i;
	?> 
<tr height="30">
  <th width="40%">對應關鍵字<?php echo $i ?></th>
  <td><input type="text" name="<?php echo $keywordsmapping ?>" size="50"></td>
</tr>
<?php } ?>
</table>
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄新增">
</form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>