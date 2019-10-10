<?php
require('../core/pdoConstructor.php');

header('Content-Type: application/json;charset=utf-8');

$category = $_GET["number"];

$sql = "SELECT beacons.name AS number,
       subcategories.name
FROM   subcategories
       INNER JOIN categories
               ON categories.id = subcategories.category_id
       INNER JOIN beacons_place
               ON beacons_place.id = categories.id
       INNER JOIN beacons
               ON beacons_place.id = beacons.id
WHERE  categories.number = $category
";
$statement = $pdo->prepare($sql);
$statement->execute();

echo json_encode(($result = $statement->fetchAll(PDO::FETCH_ASSOC)), 320);
