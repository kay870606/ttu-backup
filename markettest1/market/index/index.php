<?php
require_once('../include/gpsvars.php');
$PageTitle = 'TTU商場管理系統首頁';
require_once("../include/headerup.php");
require_once("../include/indexstyle.css");
require_once("../include/headerdown.php");
/*scrolling="no"*/
?>
<body>
<header>
   <title>TTU商場管理系統</title>
<h1>TTU商場管理系統
	<div class="dropdown" >
			<button class="dropbtn">類別</button>
			<div class="dropdown-content">
				<a href="index1.php"  target="iframe_a">首頁</a>
				<a href="../product/productdemo.php" target="iframe_a">商品展示</a>
				<a href='../login/login.php' target='iframe_a'>管理介面</a>
			</div> 
	</div>
</h1>
</header>
<article>
  <iframe align="center"  width="100%" height="100%" style="border: 0px solid gray;"src="index1.php" name="iframe_a" scrolling="no"></iframe>
</article>
</body>
</html>
