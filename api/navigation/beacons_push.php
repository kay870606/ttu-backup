<?php
require('../core/pdoConstructor.php');

header('Content-Type: application/json;charset=utf-8');

$name = $_GET["name"];

$sql = "SELECT Concat('http:140.129.25.75:8080/images/beacons_push/', `id`, '.png') AS url ,text
FROM beacons_push
WHERE category_id =
    (SELECT category_id
     FROM beacons_place
     WHERE id =
         (select id
          from beacons
          where name LIKE '$name'))
  AND soft_delete = 0
";

$statement = $pdo->prepare($sql);
$statement->execute();
echo json_encode(($result = $statement->fetchAll(PDO::FETCH_ASSOC)), 320);