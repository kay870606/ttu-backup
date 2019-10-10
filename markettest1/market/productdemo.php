<?php
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$PageTitle = '佳瑪商品展示';
require_once("../include/header1.php");
$sqlcmd = "SELECT P.id PPID,P.name PN,ean FROM products P WHERE P.active='0' GROUP BY P.id";
$Contacts = querydb($sqlcmd, $db_conn);
?>
<body>
<?php 
			foreach($Contacts as $item){
				$Model = $item['ean'];
				$productid = $item['PPID'];
				$productname = $item['PN'];
				echo "<div class='demo' style='display:inline-block;border:solid 0px;margin:6px;width:120px;height:100px;text-overflow:ellipsis;white-space: nowrap;vertical-align:top;overflow:hidden;'>";
?>
	<a href="product.php?pid=<?php echo $productid; ?>&pname=<?php echo $productname;?>">
	<img src="/api/picture/<?php echo $Model.'.png'; ?>" width="80" height="80" border="0" align="absmiddle"
    alt="<?php echo $productname ?>"></a>
<?php
				echo "</br>".$productname;
				echo "</div>" ;
			}
		?>
<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
  <script>
    $(function() {
      $("body").on("mouseenter", ".demo", function() {
        if (!this.title) this.title = $(this).text();
      });
    });
  </script>
</body>
</html>