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
?>
<html>
	<head>
		<title>促銷目錄</title>
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
	<style>	
		#market{
			float:right;
			font-size:18px;
		}
	</style>
	<!-- Header -->
		<div id="header">
			<div id="nav-wrapper"> 
				<!-- Nav -->
				<nav id="nav">
					<ul>
						<li><a href="home.html">首頁</a></li>
						<li class="active"><a href="agenda2.php">促銷目錄</a></li>
						<li><a href="local3.html">交通資訊</a></li>
						<li><a href="introduce4.html">聯絡我們</a></li>
						<li><a href="login.html">會員登入</a></li>
						<div id="market">
						<a href="upload.html">賣場人員登入</a>
						</div>
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
		<!--<div id="main">
			<div id="content" class="container">-->
			<div id="featured">
			<div class="container" align="center">
				<section>
					<header>
						<h2>促銷目錄</h2>
						<span class="byline"></span>
					</header>
					<style>
						table, th, td {
							border: 1px solid black;
							border-collapse: collapse;
						}
						th, td {
							padding: 5px;
							text-align: center;    
						}
					</style>
					<font size="5", color="#000000", align="center">促銷日期：1/13～1/15</font>
					<br></br>
					<table width="80%" border="1" align="center" style="border:3px #000000 dashed;padding:10px;" rules="all" cellpadding='10';>
<?php
	$data=mysqli_query($dbc,'select * from discount');
	for($i=0;$i<mysqli_num_rows($data);$i++){
		$row=mysqli_fetch_row($data);
?>
						<tr align="center">
							<td width="40%"><img src="images/<?php echo $row[0]?>.jpg" width="100" height="100" alt="" /></td>
							<td width="30%" align="center" valign="center"><font size="4"><?php echo $row[1]?></font></td>
							<td width="30%" align="center" valign="center"><font size="4">$<?php echo $row[2]?></font></td>
						</tr>
<?php
	}
?>
					</table>
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