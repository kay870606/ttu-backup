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
	$data=mysqli_query($dbc,'select * from customer');
	$user_id=mysqli_num_rows($data);
	$age=$_POST['age'];
	$gender=$_POST['gender'];
	$family_population=$_POST['family_population'];
	$career=$_POST['career'];
	$education=$_POST['education'];
	$married_status=$_POST['married_status'];
	$child_num=$_POST['child_num'];
	$family_monthly_income=$_POST['family_monthly_income'];
	$result=mysqli_query($dbc,'INSERT INTO customer(COL1,COL2,COL3,COL4,COL5,COL6,COL7,COL8,COL9) 
	VALUES ("'.$user_id.'","'.$age.'","'.$gender.'","'.$family_population.'","'.$career.'","'.$education.'","'.$married_status.'","'.$child_num.'","'.$family_monthly_income.'")');
	if($result==false) echo 'Error escription <br/>' . mysqli_error($dbc);
?>
<html>
	<head>
		<title>會員中心</title>
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
						<li><a href="agenda2.html">促銷目錄</a></li>
						<li><a href="local3.html">交通資訊</a></li>
						<li><a href="introduce4.html">聯絡我們</a></li>
						<li class="active"><a href="login.html">會員中心</a></li>
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
						<h2>會員註冊</h2>
						
					</header>
					<p></p>
				</section>
				<div id="search">
        <form action="login.html" method="get" novalidate>
            <div id="search-input" >
				註冊成功！請點選＂登入＂來登入會員
            </div>
			<br></br>
            <input id="input-button" type="submit" value="登入">
			<br></br>
        </form>
    </div>
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