<?php
session_start();
if (!isset($_SESSION['LoginID']) || empty($_SESSION['LoginID'])) {
    //die('您未登入');
	header("Location: ../login/login.php");
	exit();
}
?>