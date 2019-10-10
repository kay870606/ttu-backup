<?php
require('../core/pdoConstructor.php');

header('Content-Type: application/json;charset=utf-8');

$id = $_GET["id"];

$sql = "SELECT 
	   `name`,
	   `price`,
	   `description`,
       `specification`
FROM   `products`
WHERE  id = $id
";

$statement = $pdo->prepare($sql);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$result[0][specification]=json_decode($result[0][specification]);
echo json_encode($result, 320);
