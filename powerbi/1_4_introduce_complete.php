<!DOCTYPE HTML>
<!--
	Linear by TEMPLATED
    templated.co @templatedco
    Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<?php
	$dbc=mysqli_connect("localhost","id8425688_joseph7898","joseph78987");
	mysqli_query($dbc,'use id8425688_josephtestdb1');
	mysqli_query($dbc,'set names utf8');
	$data=mysqli_query($dbc,'select * from connect');
	$num=$_POST['num'];
	$phone=$_POST['phone'];
	$message=$_POST['message'];
	$result=mysqli_query($dbc,'INSERT INTO connect(Num,Phone,Message) 
	VALUES ("'.$num.'","'.$phone.'","'.$message.'")');
	if($result==false) echo 'Error escription <br/>' . mysqli_error($dbc);
?>
<html>
	<head>
		<title>聯絡我們</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
		</noscript>
	</head>
	<body>

	<!-- Header -->
		<div id="header">
			<div id="nav-wrapper"> 
				<!-- Nav -->
				<nav id="nav">
					<ul>
						<li><a href="home.html">首頁</a></li>
						<li><a href="agenda2.php">促銷目錄</a></li>
						<li><a href="local3.html">交通資訊</a></li>
						<li class="active"><a href="introduce4.html">聯絡我們</a></li>
						<li><a href="login.html">會員登入</a></li>
					</ul>
				</nav>
			</div>
			<div class="container"> 
				
				<!-- Logo -->
				<div id="logo">
					<h1><a href="home.html"><font size="10">M A R K E T</font></a></h1>
					<br><font color="white"><font size="5">Recommand System 2019</font></font></br>
					<span class="tag">商品推薦系統</span>
				</div>
			</div>
		</div>
	<!-- Header --> 

	<!-- Main -->
		<div id="main">
			<div id="content" class="container" align="center">
				<section>
					<header>
						<h2>聯絡我們</h2>
					</header>
					<p>親愛的顧客您好：若您對本賣場有任何的建議或指教，我們非常歡迎您能來信指教。</p>
					若您有急需反應之事項，請您致電客服中心：<b>02-2182-2928</b>，線上將有專人為您提供服務。</p>
					<p>客服中心服務時間為<b>早上9:00至晚上9:00</b>，或者可透過語音直接轉由分店協助處理，謝謝您。</p>
					<p>填寫完成，將會盡快為您服務<p>
					
				</section>
			</div>
		</div>
	<!-- /Main -->

	<!-- Tweet -->
		<div id="tweet">
			<div class="container">
				<section>
					<blockquote>營業時間：00:00～24:00</blockquote>
					<blockquote>店面地址：10452台北市中山區中山北路三段40號</blockquote>
				</section>
			</div>
		</div>
	<!-- /Tweet -->

	<div id="copyright">
		<div class="container">
			<font size="5">20190113</font>
		</div>
	</div>


	</body>
</html>