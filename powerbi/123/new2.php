<?php
ini_set("max_execution_time", "1000000000");
// Connect to the database 連接資料庫
$dbc = mysqli_connect('localhost', 'id8425688_joseph7898', 'joseph78987','id8425688_josephtestdb1');
// Set the charset to utf8 設定編碼爲utf8


$Import_TmpFile = $_FILES['myfile']['tmp_name']; 
$filename = $_FILES['myfile']['name'];
$handle = fopen($Import_TmpFile, "r");

function __fgetcsv(&$handle, $length = null, $d = ",", $e = '"')
{
    $d = preg_quote($d);
    $e = preg_quote($e);
    $_line = "";
    $eof=false;
    while ($eof != true)
    {
        $_line .= (empty ($length) ? fgets($handle) : fgets($handle, $length));
        $itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
        if ($itemcnt % 2 == 0)
            $eof = true;
    }
   $_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));


    $_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
    preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
    $_csv_data = $_csv_matches[1];


    for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++)
    {
        $_csv_data[$_csv_i] = preg_replace("/^" . $e . "(.*)" . $e . "$/s", "$1", $_csv_data[$_csv_i]);
        $_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
    }
    return empty ($_line) ? false : $_csv_data;
}


	if(mysqli_num_rows(mysqli_query($dbc,"SHOW TABLES LIKE 'customer'")) == 0) {
		mysqli_query($dbc,'use id8425688_josephtestdb1');
		$sqlstr1="CREATE TABLE customer (COL1 VARCHAR(10), COL2 VARCHAR(10), COL3 VARCHAR(10), COL4 VARCHAR(10), COL5 VARCHAR(10), COL6 VARCHAR(10), COL7 VARCHAR(10), COL8 VARCHAR(10), COL9 VARCHAR(10)) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		mysqli_query($dbc,$sqlstr1) or die("資料表建立失敗1");
	}
	if(mysqli_num_rows(mysqli_query($dbc,"SHOW TABLES LIKE 'item'")) == 0) {
		mysqli_query($dbc,'use id8425688_josephtestdb1');
		$sqlstr2="CREATE TABLE item (COL1 VARCHAR(10), COL2 VARCHAR(10), COL3 VARCHAR(10)) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		mysqli_query($dbc,$sqlstr2) or die("資料表建立失敗2");
	}
	if(mysqli_num_rows(mysqli_query($dbc,"SHOW TABLES LIKE 'pfs'")) == 0) {
		mysqli_query($dbc,'use id8425688_josephtestdb1');
		$sqlstr3="CREATE TABLE pfs (COL1 VARCHAR(10), COL2 VARCHAR(10), COL3 VARCHAR(10)) ENGINE=InnoDB DEFAULT CHARSET=utf8";
		mysqli_query($dbc,$sqlstr3) or die("資料表建立失敗3");
	}



mysqli_query($dbc,'use id8425688_josephtestdb1');
if($filename=='customer.csv'){
	if(mysqli_num_rows(mysqli_query($dbc,'SELECT * FROM customer'))>0) {
		mysqli_query($dbc,'TRUNCATE TABLE customer');
	}
	while (($data = __fgetcsv($handle, 10000, ',')))
	{
		mysqli_query($dbc,'use id8425688_josephtestdb1');
		$query = 'INSERT INTO customer (COL1,COL2,COL3,COL4,COL5,COL6,COL7,COL8,COL9) VALUES ("' . $data[0] . '", "' . $data[1] . '", "' . $data[2] . '", "' . $data[3] . '", "' . $data[4] . '", "' . $data[5] . '", "' . $data[6] . '", "' . $data[7] . '", "' . $data[8] . '")';
		$result = mysqli_query($dbc, $query);
		if ($result == false)
		{
			echo 'Error escription <br/>' . mysqli_error($dbc);
		}
	}
}
else if($filename=='item.csv'){
	if(mysqli_num_rows(mysqli_query($dbc,'SELECT * FROM item'))>0) {
		mysqli_query($dbc,'TRUNCATE TABLE item');
	}
	while (($data = __fgetcsv($handle, 10000, ',')))
	{
		mysqli_query($dbc,'use id8425688_josephtestdb1');
		$query = 'INSERT INTO item (COL1,COL2,COL3) VALUES ("' . $data[0] . '", "' . $data[1] . '", "' . $data[2] . '")';
		$result = mysqli_query($dbc, $query);
		if ($result == false)
		{
			echo 'Error escription <br/>' . mysqli_error($dbc);
		}
	}
}
else if($filename=='pfs.csv'){
	if(mysqli_num_rows(mysqli_query($dbc,'SELECT * FROM pfs'))>0) {
		mysqli_query($dbc,'TRUNCATE TABLE pfs');
	}
	while (($data = __fgetcsv($handle, 10000, ',')))
	{
		mysqli_query($dbc,'use id8425688_josephtestdb1');
		$query = 'INSERT INTO pfs (COL1,COL2,COL3) VALUES ("' . $data[0] . '", "' . $data[1] . '", "' . $data[2] . '")';
		$result = mysqli_query($dbc, $query);
		if ($result == false)
		{
			echo 'Error escription <br/>' . mysqli_error($dbc);
		}
	}
}

/*if (mysqli_query($dbc,'create database example')){
	echo "ssss";
	if(mysqli_query($dbc,'use example')){
		echo "123";
	}
	$sqlstr2="CREATE TABLE customer (COL1 INT, COL2 VARCHAR(10), COL3 VARCHAR(10), COL4 VARCHAR(10), COL5 VARCHAR(10), COL6 VARCHAR(10), COL7 VARCHAR(10), COL8 VARCHAR(10), COL9 VARCHAR(10))";
	mysqli_query($dbc,$sqlstr2) or die("資料表建立失敗");
	echo "2.資料表建立成功<br>";
}*/



?>