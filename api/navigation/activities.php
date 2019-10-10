<?php
require('../core/pdoConstructor.php');

header('Content-Type: application/json;charset=utf-8');

$id = $_GET["id"];

$sql = "SELECT Concat('http:140.129.25.75:8080/images/activities/', `id`, '.png') AS url
       ,
       `name`
FROM   `activities`
WHERE  Curdate() > start_date
       AND Curdate() < end_date
       AND soft_delete = 0 
";

$statement = $pdo->prepare($sql);
$statement->execute();
echo json_encode(($result = $statement->fetchAll(PDO::FETCH_ASSOC)), 320);
