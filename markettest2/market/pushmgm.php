<?php
// Authentication 認證
 require_once("../include/auth.php");
//session_start();
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$PageTitle = '佳瑪商品';
require_once("../include/header3.php");

$sqlcmd = "SELECT count(*) AS reccount FROM beacons_push ";
$rs = querydb($sqlcmd, $db_conn);
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['pushCurPage'])&&$_SESSION['pushCurPage']>0) $Page = $_SESSION['pushCurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['pushCurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;
/*$sqlcmd = "SELECT * FROM beaconplace";
$rs = querydb($sqlcmd, $db_conn);
$place = array();
foreach ($rs as $item) {
    $BID = $item['beaconID'];
	$CID = $item['categoriesID'];
	if(isset($place[$CID])){
		$place[$CID] = $place[$CID]." ".$BID;
	}else{
		$place[$CID] =$BID;
	}
}*/
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
$sqlcmd = "SELECT * FROM beacons_push order by category_id,id LIMIT $StartRec,$ItemPerPage";
$Contacts = querydb($sqlcmd, $db_conn);
?>
<Script Language="JavaScript">
<!--
function confirmation(DspMsg, PassArg) {
var name = confirm(DspMsg)
    if (name == true) {
      location=PassArg;
    }
}
-->
</SCRIPT>
<body>
<div id="logo">推播清單</div>
<table border="0" width="90%" align="center" cellspacing="0"
  cellpadding="2">
<tr>
  <td width="50%" align="left">
<?php if ($TotalPage >=1) { ?>
<form name="SelPage" method="POST" action="">
  第<select name="Page" onchange="submit();">
<?php 
for ($p=1; $p<=$TotalPage; $p++) { 
    echo '  <option value="' . $p . '"';
    if ($p == $Page) echo ' selected';
    echo ">$p</option>\n";
}
?>
  </select>頁 共<?php echo $TotalPage ?>頁
</form>
<?php } ?>
  <td>
  <td align="right" width="30%">
    <a href="pushadd.php">新增</a>&nbsp;
    <!--<a href="/i4010/logout.php">登出</a>-->
  </td>
</tr>
</table>
<table class="mistab" width="90%" align="center">
<tr>
  <th width="5%">處理</th>
  <th width="20%">分類名稱</th>
  <!--<th width="10%">beacon號碼</th>-->
  <th width="10%">狀態</th>
  <th>文字</th>
  <th width="10%">圖片</th>
</tr>
<?php
$c=1;
foreach ($Contacts AS $item) {
  $ID=$item['id'];
  $CategoryID = $item['category_id'];
  /*$Type = $item['type'];
  if($Type==0){
	  $Type="圖";
  }else if($Type==1){
	  $Type="字";
  }else{
	  $Type="圖+字";
  }*/
  $Text = $item['text'];
  $Status = $item['soft_delete'];
    if($Status==0){
	  $Status="啟用";
  }else if($Status==1){
	  $Status="未啟用";
  }
  $url = $item['img'];
  $img ="<a href='#notice$c'><img src='$url' width='25px' height='25px'></a>";
  $c++;
  //$Bid = $place[$CategoryID];
  echo '<tr align="center"><td>';
?>
  <a href="pushmod.php?pid=<?php echo $ID; ?>">
  <img src="../images/edit.gif" border="0" align="absmiddle"
    alt="按此鈕修改本項目"></a>&nbsp;
  </td>
  <td align="left"><?php echo xssfix($CategoryNames[$CategoryID])  ?></td>  
  <!--<td><?php echo xssfix($Bid) ?></td>--> 
  <!--<td><?php echo xssfix($Type) ?></td>  -->
  <td><?php echo xssfix($Status) ?></td>  
  <td><?php echo xssfix($Text) ?></td>  
  <td><?php echo $img;?></td>     
  </tr>
<?php
}
//print_r($_SESSION);
?>
</table>
<?php
$c=1;
	foreach ($Contacts AS $item) {
	$url = $item['img'];
	$img ="<img src='$url'>";
	echo "<div class='lightbox-target' id='notice$c'>".$img."<a class='lightbox-close' href='##'></a></div>";
	$c++;
}
?>
<?php require_once("../include/footer.php"); ?>
</body>
</html>