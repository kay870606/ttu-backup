<?php
  $dsn = 'mysql:host=localhost;port=3306;dbname=id8425688_josephtestdb1';

  $pdo = new PDO($dsn,'id8425688_joseph7898','joseph78987');
  $pdo->query("SET NAMES 'utf8'");
  $sql = "SELECT * FROM customer";
  $query = $pdo->query($sql);
  $query->setFetchMode(PDO::FETCH_ASSOC);
  foreach($query as $row){
	echo $row['COL1'].',';  
	echo $row['COL2'].',';
	echo $row['COL3'].',';
	echo $row['COL4'].',';
	echo $row['COL5'].',';
	echo $row['COL6'].',';
	echo $row['COL7'].',';
	echo $row['COL8'].',';
	echo $row['COL9'];
	echo "\n";
  }
?>
