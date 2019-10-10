<?php
require('../core/pdoConstructor.php');

header('Content-Type: application/json;charset=utf-8');

$sql = 'SELECT  `number` AS `name`, `name` AS `number`FROM `beacons_tmp` WHERE LEngth(number) > 0 ';
$statement = $pdo->prepare($sql);
$statement->execute();

echo json_encode(($result = $statement->fetchAll(PDO::FETCH_ASSOC)), JSON_UNESCAPED_UNICODE);
