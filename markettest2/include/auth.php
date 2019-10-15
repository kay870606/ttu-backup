<?php
session_start();
if (!isset($_SESSION['LoginID']) || empty($_SESSION['LoginID'])) {
    //die('您未登入');
	header("Location: ../market/login.php");
	exit();
}
?>