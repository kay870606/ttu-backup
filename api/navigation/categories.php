<?php
require('../core/pdoConstructor.php');

header('Content-Type: application/json;charset=utf-8');

$sql = 'SELECT  `number`, `name` FROM `categories` WHERE 1';
$statement = $pdo->prepare($sql);
$statement->execute();

echo json_encode(($result = $statement->fetchAll(PDO::FETCH_ASSOC)), 320);
