<?php
include ("lunercalendar.php");
$Month =array("1","2","3","4","5","6","7","8","9","10","11","12");
$Year = array("2019","2020","2021","2022","2023","2024","2025");
$MySelect =date('m');
$MyYear = date('Y');
if(isset($_POST)){
	if(isset($_POST["MySelect"])) $MySelect= $_POST["MySelect"];
	if(isset($_POST["MyYear"])) $MyYear= $_POST["MyYear"];
}
?>
<html>
<head>
<meta HTTP-EQUIV="Conent-Type" content="text/html; charset=UTF-8">
<meta HTTP-EQUIV="Expires" CONTENT="Tue, 01 Tan 1980 1:00:00 GMT">
<meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta name="viewport" content="width=device-width, intial-scale-1.0,minimum-scale=1.0, maximum-scale=1.6">
<title>月曆</title>
<style>
body{
	background-color:rgb(218, 255, 71);
}
th {
	color:blue;
}
</style>
</head>
<body>
<div style="text-align:center; margin:20px 0;">
	<form method="POST" name="month" action="" style="font-size:30px;">
		國曆&nbsp年
		<select name="MyYear" onchange="submit();" style="font-size:30px;" height="20">
				<?php
				foreach($Year as $ym){
					echo '<option value="'.$ym.'"';
					if($MyYear == $ym) echo 'selected';
					echo '>'.$ym.'</option>';
				}
				?>
		</select>
		月
		<select name="MySelect" onchange="submit();" style="font-size:30px;" height="20">
			<?php
			foreach($Month as $num){
				echo '<option value="'.$num.'"';
				if($MySelect == $num) echo 'selected';
				echo '>'.$num.'</option>';
			}
			?>
		</select><br />
	</form>
	<?php
	$m = $MySelect;
	$y = $MyYear;
	$arrMonth = array();
	for ($i=0; $i<6; $i++)
		for ($j=0; $j<7; $j++)
			$arrMonth[$i][$j] = '';
	$FirstDate = 1;
	$LastDate = date('t',mktime(1,0,0,$m,1,$y));
	$Row = 0;
	for ($d=1; $d<=$LastDate; $d++) {
		$Day = date('w',mktime(0,0,0,$m,$d,$y));
		if ($Day==0 &&$d>1) $Row++;
		$arrMonth[$Row][$Day] = $d;
	}
	?>
	<table border="1" align="center" width="800">
	<tr>
		<th width="50">日</th>
		<th width="50">一</th>
		<th width="50">二</th>
		<th width="50">三</th>
		<th width="50">四</th>
		<th width="50">五</th>
		<th width="50">六</th>
	</tr>
	<?php
	for ($i=0; $i<6; $i++) {
		if ($i>2 && empty($arrMonth[$i][0])) continue; //不顯示最後空行
	?>
	<tr align="center" height="100">
	<?php
		for ($j=0; $j<7; $j++){
			$ShowDate = $arrMonth[$i][$j];
			if(empty($ShowDate)){ 
				$ShowDate ='&nbsp;';
				$LDayName ='&nbsp;';
			}else{
				$Argument = date('Y-m-d',mktime(1,0,0,$m,$ShowDate,$y));
				$LDayName = GetLDay($Argument);
			}
			if($j==0||$j==6){
	?>
			<td style="font-size:20px; color:red;" ><strong><?php echo $ShowDate; ?></br><?php echo $LDayName; ?></strong></td>
		<?php
			}else{
		?>
			<td style="font-size:20px; color:blue;" ><strong><?php echo $ShowDate; ?></br><?php echo $LDayName; ?></strong></td>
		<?php
			}
		?>
	<?php
		}
	?>
	</tr>
	<?php
	}
	?>
	</table>
	<a href="../index.php"" style="color:rgb(130, 100, 62);"><br>總首頁</a>
</div>
</body>
</html>