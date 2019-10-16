<?php
require('../core/pdoConstructor.php');

header('Content-Type: application/json;charset=utf-8');

$number = $_GET["number"];

$sql = "SELECT `name`,
       `price`,
       `description`,
       `specification`
FROM products
WHERE subcategory_id IN
    (SELECT id
     FROM subcategories
     WHERE category_id =
         (SELECT id
          FROM categories
          WHERE number = $number))
";

$statement = $pdo->prepare($sql);
$statement->execute();
echo json_encode(($result = $statement->fetchAll(PDO::FETCH_ASSOC)), 320);