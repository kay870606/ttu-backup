<?php
require_once("../include/auth.php");
if (isset($_POST['Abort'])){
	header("Location: contactmgm.php");
	unset($_SESSION['array']);
	exit();
}
// 變數及函式處理，請注意其順序
require_once("../include/require.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

//增加敘述
$Specification="0";
if(isset($_POST['specification'])) $Specification= $_POST['specification'];
$sele = array("0","1","2","3","4","5","6","7","8","9","10");
if(isset($_SESSION['array'])) {
	$specificationarray=$_SESSION['array'];
}else{
	$specificationarray= array();
}
// 處理使用者異動之資料
if (isset($Confirm)) {   // 確認按鈕
    if (empty($ean)) $ErrMsg = '國際條碼不可為空白\n';
    if (empty($productname)) $ErrMsg = '商品名稱不可為空白\n';
	if (empty($price)) $ErrMsg = '價格不可為空白\n';
	if (isset($_POST['ean'])) $ean= $_POST['ean'];
	if (isset($_POST['productname'])) $productname = $_POST['productname'];
	if (isset($_POST['subcategoryname'])) $subcategoryname =$_POST['subcategoryname'];
	if (isset($_POST['description'])) $description =$_POST['description'];
	if (isset($_POST['price'])) $price = $_POST['price'];
	if (isset($_POST['specification_number'])) $specification_number = $_POST['specification_number'];
	
    if (empty($ErrMsg)) {   // 資料經初步檢核沒問題
        if (!get_magic_quotes_gpc()) {
            $ean = addslashes($ean);
            $productname = addslashes($productname);
			$description = addslashes($description);
			$subcategoryname = addslashes($subcategoryname);
            $price = addslashes($price);
        }
		$specificationarray=array();
		for($k=1;$k<=$specification_number;$k++){
			if (!empty($_POST["leftspecification$k"])) {
				$leftspecification=$_POST["leftspecification$k"];
			}else{
				continue;
			}
			if (!empty($_POST["rightspecification$k"])) {
				$rightspecification=$_POST["rightspecification$k"];
			}else{
				continue;
			}
			$specificationarray["$leftspecification"]="$rightspecification";
		}
		$jsspecification=json_encode($specificationarray,JSON_UNESCAPED_UNICODE);
		
        $sqlcmd="UPDATE products SET ean='$ean',name='$productname',price='$price',subcategory_id='$subcategoryname',description='$description' WHERE id='$pid'";
        $result = updatedb($sqlcmd, $db_conn);
		
		if($specification_number>0&&!empty($jsspecification)){
			$sqlcmd="UPDATE products SET specification='$jsspecification' WHERE id='$pid'";
			$result = updatedb($sqlcmd, $db_conn);
		}else{
			$sqlcmd="UPDATE products SET specification='' WHERE id='$pid'";
			$result = updatedb($sqlcmd, $db_conn);
		}
		
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
				$saveto = "/images/products/".$pid.".png";
				move_uploaded_file($_FILES['upfile']['tmp_name'], $saveto);
			}
		}
		unset($_SESSION['array']);
        header("Location: contactmgm.php");
        exit();
    }
}
if (!isset($ean)) {    
// 此處是在contactlist.php點選後進到這支程式，因此要由資料表將欲編輯的資料列調出
	$sqlcmd = "SELECT * FROM products WHERE id=$pid";
    $rs = querydb($sqlcmd, $db_conn);
    if (count($rs) <= 0) die('No data found');      // 找不到資料，正常應該不會發生
    $ean = $rs[0]['ean'];
	$productname = $rs[0]['name'];
	$price = $rs[0]['price'];
	//$sectionname = $rs[0]['PSI'];
	//$categoryname = $rs[0]['PCI'];
	$subcategoryname = $rs[0]['subcategory_id'];
	$description= $rs[0]['description'];
	$specification = $rs[0]['specification'];
	if(!empty($specification)){
		$specificationarray=json_decode($specification,true);
		$_SESSION['array']=$specificationarray;
	}
} 

// 取出群組資料
$sqlcmd = "SELECT * FROM sections";
$rs = querydb($sqlcmd, $db_conn);
$SectionNames = array();
foreach ($rs as $item) {
    $SID = $item['id'];
    $SectionNames[$SID] = $item['name'];
}
$sqlcmd = "SELECT * FROM categories";
$rs = querydb($sqlcmd, $db_conn);
$CategoryNames = array();
foreach ($rs as $item) {
    $CID = $item['number'];
    $CategoryNames[$CID] = $item['name'];
}
$sqlcmd = "SELECT * FROM subcategories  ";
$rs = querydb($sqlcmd, $db_conn);
$SubcategoryNames = array();
foreach ($rs as $item) {
    $SCID = $item['id'];
    $SubcategoryNames[$SCID] = $item['name'];
}
$PageTitle = '修改商品資料';
require_once("../include/headerup.php");
require_once("../include/i4010.css");
require_once("../include/headerdown.php");
?>
<body>
<div align="center">
<form action="" method="post" name="inputform" enctype="multipart/form-data">
<b>修改商品資料</b>
<table border="1" width="60%" cellspacing="0" cellpadding="3" align="center">
<tr height="30">
  <th width="40%">商品圖片</th>
  <td><input Type="file" Name="upfile" size="20"></td>
</tr>
<tr height="30">
  <th width="40%">國際條碼</th>
  <td><input type="number" name="ean" value="<?php echo $ean ?>" size="20"></td>
</tr>
<tr height="30">
  <th width="40%">商品名稱</th>
  <td><input type="text" name="productname" value="<?php echo $productname ?>" size="50"></td>
</tr>
<tr height="30">
  <th width="40%">價格</th>
  <td><input type="number" name="price" value="<?php echo $price ?>" size="50"></td>
</tr>
<tr height="30">
  <th>子分類名稱</th>
  <td><select name="subcategoryname">
<?php
    foreach ($SubcategoryNames as $ID => $subcategoryName) {
        echo '    <option value="' . $ID . '"';
		if ($ID == $subcategoryname) echo ' selected';
        echo ">$ID-$subcategoryName</option>\n";
    } 
?>
    </select>
  </td>
</tr>
<tr height="100">
  <th width="40%">資訊</th>
  <td><textarea name="description" style="width:500px;height:90px;"><?php echo $description ?></textarea></td>
</tr>
<?php
$i=0;
foreach($specificationarray as $left => $right ){
	$i++;
	$leftspecification="leftspecification".$i;
	$rightspecification="rightspecification".$i;
	?>
<tr height="30">
  <th width="40%"><input type="text" name="<?php echo $leftspecification ?>" value="<?php echo $left ?>" size="30"></th>
  <td><input type="text" name="<?php echo $rightspecification ?>" value="<?php echo $right ?>" size="50"></td>
</tr>
<?php } ?>
<tr height="30">
  <th>幾個敘述</th>
	<td><select name="specification" onchange="submit();">
		<?php
		foreach($sele as $num){
			echo '<option value="'.$num.'"';
			if($Specification == $num) echo 'selected';
			echo '>'.$num.'</option>';
		}
		?>
	</select>
  </td>
</tr>
<?php
$s=$i;
for($k=1;$k<=$Specification;$k++){
	$s=$k+$i;
	$leftspecification="leftspecification".$s;
	$rightspecification="rightspecification".$s; 
	?>
<tr height="30">
  <th width="40%"><input type="text" name="<?php echo $leftspecification ?>" size="30"></th>
  <td><input type="text" name="<?php echo $rightspecification ?>" size="50"></td>
</tr>
<?php } ?>
</table>
<input type="hidden" name="pid" value="<?php echo $pid; ?>">
<input type="hidden" name="specification_number" value="<?php echo $s; ?>">
<input type="submit" name="Confirm" value="存檔送出">&nbsp;
<input type="submit" name="Abort" value="放棄修改">
</form>
</div>
<?php require_once("../include/footer.php"); ?>
</body>
</html>