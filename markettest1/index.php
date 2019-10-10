<?php
require_once('include/gpsvars.php');
$PageTitle = 'TTU商場管理系統首頁';
require_once('include/header.php');
/*scrolling="no"*/
?>
<body>
<header>
   <title>TTU商場管理系統</title>
<h1>TTU商場管理系統
	<div class="dropdown" >
			<button class="dropbtn">類別</button>
			<div class="dropdown-content">
				<!--<a href="market/index1.php"  target="iframe_a">首頁</a>-->
				<a href="market/index1.php"  target="iframe_a">首頁</a>
				<!--<a href="market/contactmgm.php" target="iframe_a">商品</a>-->
				<a href="market/productdemo.php" target="iframe_a">商品展示</a>
				<a href='market/login.php' target='iframe_a'>管理介面</a>
			</div> 
	</div>
</h1>
</header>
<article>
  <iframe align="center"  width="100%" height="100%" style="border: 0px solid gray;"src="market/index1.php" name="iframe_a" scrolling="no"></iframe>
</article>
</body>
</html>
