<?php
	$dbc=mysqli_connect("localhost","id8425688_joseph7898","joseph78987");
	mysqli_query($dbc,'use id8425688_josephtestdb1');
	mysqli_query($dbc,'set names utf8');
	session_start(); //開啟session的語法 要放在檔案最上方
?>
<!DOCTYPE HTML>
<!--
	Linear by TEMPLATED
    templated.co @templatedco
    Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>個人推薦</title>
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
<?php
	$data=mysqli_query($dbc,'select * from output');
	$cdata=$_SESSION['id'];
	for($i=1;$i<=mysqli_num_rows($data);$i++){
		$rs=mysqli_fetch_row($data);
		if($cdata==$rs[0]){
?>
<script language="JavaScript"> 
<!--
var slidespeed=3000 
var pic1="images/<?php echo $rs[1]?>.jpg"
var pic2="images/<?php echo $rs[3]?>.jpg"
var pic3="images/<?php echo $rs[5]?>.jpg"
var pic4="images/<?php echo $rs[7]?>.jpg"
var pic5="images/<?php echo $rs[9]?>.jpg"
var slideimages=new Array(pic1,pic2,pic3,pic4,pic5) 
var imageholder=new Array() 
var ie55=window.createPopup 
for (k=0;k<slideimages.length;k++){ 
imageholder[k]=new Image() 
imageholder[k].src=slideimages[k] 
} 
function gotoshow(){ 
window.location=slidelinks[whichlink] 
} 
-->
</script>
	<!-- Header -->
		<div id="header">
			<div id="nav-wrapper"> 
				<!-- Nav -->
				<nav id="nav">
					<ul>
						<li><a href="2home.html">首頁</a></li>
						<li><a href="2agenda2.php">促銷目錄</a></li>
						<li><a href="2local3.html">交通資訊</a></li>
						<li><a href="2introduce4.html">聯絡我們</a></li>
						<li class="active"><a href="2online5.php">個人推薦</a></li>
						<li class="active"><a href="logout.php">登出</a></li>
					</ul>
				</nav>
			</div>
			<div class="container"> 
				
				<!-- Logo -->
				<div id="logo">
					<h1><a href="2home.html"><font size="10">M A R K E T</font></a></h1>
					<br><font color="white"><font size="5">Recommand System 2019</font></font></br>
					<span class="tag">商品推薦系統</span>
				</div>
			</div>
		</div>
	<!-- Header --> 

	<!-- Main -->
		<div id="main">
			<div class="container">
				<div class="row">

					<!-- Content -->
					<div id="content" class="8u skel-cell-important">
						<section>
							<header>
								<h2>為您推薦</h2>
								<span class="byline"></span>
							</header>
							<p><img src="images/<?php $rs[1]?>.jpg" name="slide" border=0 style="filter:progid:DXImageTransform.Microsoft.Pixelate(MaxSquare=15,Duration=1)" alt="" width="400" height="400" class="alignleft">
							<ul>
								<?php
								if($rs[1]!=0){?>
								<li><a href="/recom.php?id=<?=$rs[1]?>"><?php echo $rs[2]?></a></li>
								<?php
							    }?>
								<?php
								if($rs[3]!=0){?>
								<li><a href="/recom.php?id=<?=$rs[3]?>"><?php echo $rs[4]?></a></li>
								<?php
								}?>
								<?php
								if($rs[5]!=0){?>
								<li><a href="/recom.php?id=<?=$rs[5]?>"><?php echo $rs[6]?></a></li>
								<?php
								}?>
								<?php
								if($rs[7]!=0){?>
								<li><a href="/recom.php?id=<?=$rs[7]?>"><?php echo $rs[8]?></a></li>
								<?php
								}?>
								<?php
								if($rs[9]!=0){?>
								<li><a href="/recom.php?id=<?=$rs[9]?>"><?php echo $rs[10]?></a></li>
								<?php
								}?>
							</ul>	
						</section>
					</div>

					<!-- Sidebar -->
					<div id="sidebar" class="4u">
						
						<section>
							<header>
							</header>
							
					<ul>
						<li>
							<h2>熱銷排行</h2>
							<ul>
								<li><a href="/recom.php?id=<?=10056355?>">MATSUMI背心袋10kg</a></li>
								<li><a href="/recom.php?id=<?=30011742?>">米圃精饌米-4kg</a></li>
								<li><a href="/recom.php?id=<?=10077941?>">中興金饌中興米-4kg</a></li>
								<li><a href="/recom.php?id=<?=10021538?>">三好米（特級米）-4kg</a></li>
								<li><a href="/recom.php?id=<?=3891?>">台灣青蔥</a></li>
							</ul>
						</li>
					</ul>
						</section>
					</div>
					
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
<script language="JavaScript1.1"> 
<!-- 
var whichlink=0 
var whichimage=0 
var pixeldelay=(ie55)? document.images.slide.filters[0].duration*1000 : 0 
function slideit(){ 
if (!document.images) return 
if (ie55) document.images.slide.filters[0].apply() 
document.images.slide.src=imageholder[whichimage].src 
if (ie55) document.images.slide.filters[0].play() 
whichlink=whichimage 
whichimage=(whichimage<slideimages.length-1)? whichimage+1 : 0 
setTimeout("slideit()",slidespeed+pixeldelay) 
} 
slideit() 
--> 
</script>
<?php
		}
	}
?>

	</body>
</html>