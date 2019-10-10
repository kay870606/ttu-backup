<?php
require('../core/pdoConstructor.php');

header('Content-Type: application/json;charset=utf-8');

$sql = 'SELECT beacons.name AS number,
       beacons_push.text AS name
		FROM   beacons
       INNER JOIN beacons_push
               ON beacons_push.subcategory_id = beacons.subcategory_id ';
$statement = $pdo->prepare($sql);
$statement->execute();

echo json_encode(($result = $statement->fetchAll(PDO::FETCH_ASSOC)), JSON_UNESCAPED_UNICODE);