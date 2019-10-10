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

$sqlcmd = "SELECT count(*) AS reccount FROM carousel";
$rs = querydb($sqlcmd, $db_conn);
$RecCount = $rs[0]['reccount'];
$TotalPage = (int) ceil($RecCount/$ItemPerPage);
if (!isset($Page)) {
    if (isset($_SESSION['activityCurPage'])&&$_SESSION['activityCurPage']>0) $Page = $_SESSION['activityCurPage'];
    else $Page = 1;
}
if ($Page > $TotalPage) $Page = $TotalPage;
$_SESSION['activityCurPage'] = $Page;
$StartRec = ($Page-1) * $ItemPerPage;

$sqlcmd = "SELECT * FROM carousel LIMIT $StartRec,$ItemPerPage";
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
<div id="logo">活動清單</div>
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
    <a href="activityimgadd.php">新增</a>&nbsp;
    <!--<a href="/i4010/logout.php">登出</a>-->
  </td>
</tr>
</table>
<table class="mistab" width="90%" align="center">
<tr>
  <th width="10%">處理</th>
  <th width="30%">活動名稱</th>
  <th width="15%">開始時間</th>
  <th width="15%">結束時間</th>
  <th width="10%">活動狀態</th>
  <th width="10%">啟用狀態</th>
  <th>圖片</th>
</tr>
<?php
$c=1;
foreach ($Contacts AS $item) {
  $ID=$item['id'];
  $Activityname = $item['name'];
  $start_date = $item['start_date'];
  $end_date = $item['end_date'];
  $Status = $item['soft_delete'];
  $time=date('Y-m-d');
  if((strtotime($start_date)<=strtotime($time))&&(strtotime($end_date)>=strtotime($time))){
	  $activity="活動中";
  }else if(strtotime($start_date)>strtotime($time)){
	  $activity="活動未開始";
  }else if(strtotime($end_date)<strtotime($time)){
	  $activity="活動結束";
  }else{
	  $activity="未知狀態";
  }
  if($Status==0){
	  $Statusname="啟用";
  }else{
	  $Statusname="不啟用";
  }
  $url = $item['img'];
  $img ="<a href='#notice$c'><img src=\"$url\" width=\"55\" height=\"25\"></a>";
  $c++;
  $DspMsg = "'確定刪除項目?'";
  echo '<tr align="center"><td>';
?>
  <a href="activityimgmod.php?pid=<?php echo $ID; ?>">
  <img src="../images/edit.gif" border="0" align="absmiddle"
    alt="按此鈕修改本項目"></a>&nbsp;
  </td>
  <td><?php echo xssfix($Activityname)?></td> 
  <td><?php echo xssfix($start_date)?></td> 
  <td><?php echo xssfix($end_date)?></td> 
  <td><?php echo xssfix($activity)?></td> 
  <td><?php echo xssfix($Statusname)?></td>   
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
	$img ="<img src='$url' width='880px' height='400px'>";
	echo "<div class='lightbox-target' id='notice$c'>".$img."<a class='lightbox-close' href='##'></a></div>";
	$c++;
}
?>
<?php require_once("../include/footer.php"); ?>
</body>
</html>