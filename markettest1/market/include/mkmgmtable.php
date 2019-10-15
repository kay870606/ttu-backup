<div id="logo"><?php echo $logoname; ?></div>
<table border="0" width="90%" align="center" cellspacing="0"
  cellpadding="2">
<tr>
	<td width="50%" align="left">
	<?php if ($TotalPage >0) { ?>
		<form name="SelPage" method="POST" action="">
		<?php if(isset($category)){  ?>
			<select name="type" onchange="submit();">
			<?php 
			$ty=array('1'=>'選頁','2'=>'選區域');
			for ($p=1; $p<=2; $p++) { 
			echo '  <option value="' . $p . '"';
			if ($p == $type) echo ' selected';
			echo ">$ty[$p]</option>\n";
			}
			?>
			</select>
		<?php }
			if(isset($category)&&$type==2){?>
			&nbsp區域:<select name="section" onchange="submit();">
			<?php 
			for ($p=7; $p<=$SID; $p++) { 
			echo '  <option value="' . $p . '"';
			if ($p == $section) echo ' selected';
			echo ">$SectionNames[$p]</option>\n";
			}
			?>
			</select>
			第<select name="Spage" onchange="submit();">
			<?php 
			for ($p=1; $p<=$TotalPage; $p++) { 
			echo '  <option value="' . $p . '"';
			if ($p == $Spage) echo ' selected';
			echo ">$p</option>\n";
			}
			?>
			</select>頁 共<?php echo $TotalPage ?>頁
		<?php }else{  ?>
			第<select name="Page" onchange="submit();">
			<?php 
			for ($p=1; $p<=$TotalPage; $p++) { 
			echo '  <option value="' . $p . '"';
			if ($p == $Page) echo ' selected';
			echo ">$p</option>\n";
			}
			?>
			</select>頁 共<?php echo $TotalPage ?>頁
		<?php } ?>
		</form>
	<?php } ?>
	</td>
	<td align="right" width="30%">
		<a href="<?php echo $addname; ?>.php">新增</a>&nbsp;
	</td>
</tr>
</table>
<table class="mistab" width="90%" align="center">
<tr>
<?php 
foreach ($tablename AS $tname=>$tsize){
	if($tsize=='0'){
		echo "<th>$tname</th>";
	}else{
		echo "<th width='$tsize%'>$tname</th>";
	}
}
?>
</tr>
<?php
$c=1;
foreach ($Contacts AS $item) {	
	foreach($tableitem AS $index=>$name){
		if($name=='img'){
			if(isset($activityimg)){
				if($activityimg==1){
					$img = "<a href='#notice$c'><img src='/images/activities/$ID.png' width='25px' height='25px'></a>";
				}else if($activityimg==2){
					$img = "<a href='#notice$c'><img src='/images/beacons_push/$ID.png' width='25px' height='25px'></a>";
				}
			}else if(isset($contactmgm)){
				$img = "<a href='#notice$c'><img src='/images/products/$ID.png' width='25px' height='25px'></a>";
			}
		}else if(!is_numeric($index)){
			${"$index"}=$item["$name"];
		}
	}
	if(isset($activityimg)){//**********activityimg
		if($activityimg==1){//**********push
			$time=date('Y-m-d');
			if((strtotime($start_date)<=strtotime($time))&&(strtotime($end_date)>=strtotime($time))){
				$item['activity']="活動中";
			}else if(strtotime($start_date)>strtotime($time)){
				$item['activity']="活動未開始";
			}else if(strtotime($end_date)<strtotime($time)){
				$item['activity']="活動結束";
			}else{
				$item['activity']="未知狀態";
			}
		}
		if($Status==0){
		$item['Statusname']="啟用";
		}else{
		$item['Statusname']="不啟用";
		}
	}//*********************************
	$c++;
	$DspMsg = "'確定刪除項目?'";
	$PassArg = "'contactmgm.php?action=delete&pid=$ID'";
	echo '<tr align="center"><td>';
	//****************************************contact
	if(isset($contactmgm)){
		if ($Status=='1') {?>
			<a href="contactmgm.php?action=recover&pid=<?php echo $ID; ?>">
			<img src="../images/recover.gif" border="0" align="absmiddle">
			</a>
		<?php } else { ?>
			<a href="javascript:confirmation(<?php echo $DspMsg ?>, <?php echo $PassArg ?>)">
			<img src="../images/void.gif" border="0" align="absmiddle"
			alt="按此鈕將本項目作廢"></a>&nbsp;
			<a href="<?php echo $modname; ?>.php?pid=<?php echo $ID; ?>">
			<img src="../images/edit.gif" border="0" align="absmiddle"
			alt="按此鈕修改本項目"></a>&nbsp;
		<?php }
	}else{//***********************************?>
		<a href="<?php echo $modname; ?>.php?pid=<?php echo $ID; ?>">
		<img src="../images/edit.gif" border="0" align="absmiddle"
		alt="按此鈕修改本項目"></a>&nbsp;
	<?php }?>
	</td> 
	<?php
  	foreach($tableitem AS $index=>$name){
		if($name=='img'){
			echo "<td>$img</td>";
		}else if(is_numeric($index)){
			if(isset($arr)&&isset($arrname[$index])){
				echo "<td>".xssfix(${$arrname}[$item["$name"]])."</td>";
			}else{
				echo "<td>".xssfix($item["$name"])."</td>";
			}
		}
	}
?>
  </tr>
<?php
}
?>
</table>