<?php
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort'])){ 
header("Location: contactmgm.php"); 
exit();
}
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");

$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
if (!isset($ean)) $ean = '';
if (!isset($productname)) $productname = '';
if (!isset($price)) $price = '';

if (!isset($sectionname)) $sectionname = '';
if (!isset($categoryname)) $categoryname = '';
if (!isset($subcategoryname)) $subcategoryname = '';


if (!isset($description)) $description = '';
//增加敘述
$Specification="4";
if(isset($_POST['specification'])) $Specification= $_POST['specification'];
$sele = array("1","2","3","4","5","6","7","8","9","10");
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
if (isset($Confirm)) {   // 確認按鈕
    if (empty($ean)) $ErrMsg = '國際條碼不可為空白\n';
    if (empty($productname)) $ErrMsg = '商品名稱不可為空白\n';
	if (empty($price)) $ErrMsg = '價格不可為空白\n';
	if (isset($_POST['ean'])) $ean = $_POST['ean'];
	if (isset($_POST['productname'])) $productname = $_POST['productname'];
	if (isset($_POST['sectionname'])) $sectionname = $_POST['sectionname'];
	if (isset($_POST['categoryname'])) $categoryname =$_POST['categoryname'];
	if (isset($_POST['subcategoryname'])) $subcategoryname =$_POST['subcategoryname'];
	if (isset($_POST['price'])) $price =$_POST['price'];
	if (isset($_POST['description'])) $description = $_POST['description'];
    if (empty($ErrMsg)) {
		
		$specificationarray=array();
		for($k=1;$k<=$Specification;$k++){
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
		
        $sqlcmd='INSERT INTO products (ean,name,price,description,subcategory_id) VALUES ('
            . "'$ean','$productname','$price','$description','$subcategoryname')";
        $result = updatedb($sqlcmd, $db_conn);
		
		if($Specification>0&&!empty($jsspecification)){
			$sqlcmd="UPDATE products SET specification='$jsspecification' WHERE ean='$ean'";
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
				//$saveto = "../img/".$PLID.".".$src;
				$saveto = "/api/picture/".$ean.".png";
				move_uploaded_file($_FILES['upfile']['tmp_name'], $saveto);
			}
		}
		else
        {
         echo "圖片上傳失敗";
        }

        header("Location: contactmgm.php");
		exit();
    }
}
$PageTitle = '新增商品資料';
require_once("../include/header3.php");
?>
<body>
<div align="center">
<form action="" method="post" name="inputform" enctype="multipart/form-data">
<b>新增商品資料</b>
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
  <td><input type="number" name="price" value="<?php echo $price ?>" size="20"></td>
</tr>
<tr height="30">
  <th>區域名稱</th>
  <td><select name="sectionname">
<?php
    foreach ($SectionNames as $ID => $sectionName) {
        echo '    <option value="' . $ID . '"';
        echo ">$sectionName</option>\n";
    } 
?>
    </select>
  </td>
</tr>
<tr height="30">
  <th>分類名稱</th>
  <td><select name="categoryname">
<?php
    foreach ($CategoryNames as $ID => $categoryName) {
        echo '    <option value="' . $ID . '"';
        echo ">$ID-$categoryName</option>\n";
    } 
?>
    </select>
  </td>
</tr>
<tr height="30">
  <th>子分類名稱</th>
  <td><select name="subcategoryname">
<?php
    foreach ($SubcategoryNames as $ID => $subcategoryName) {
        echo '    <option value="' . $ID . '"';
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
for($i=1;$i<=$Specification;$i++){
	$leftspecification="leftspecification".$i;
	$rightspecification="rightspecification".$i;
	?>
<tr height="30">
  <th width="40%"><input type="text" name="<?php echo $leftspecification ?>" size="30"></th>
  <td><input type="text" name="<?php echo $rightspecification ?>" size="50"></td>
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