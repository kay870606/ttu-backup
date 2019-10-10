<?php
require_once('../core/pdoConstructor.php');

for ($i = 0; $i <= 15; $i++) {
    for ($j = 0; $j <= 2; $j++) {
        $id = sprintf("%02d", $i) . sprintf("%02d", $j);
        $sql = 'INSERT INTO beacons (name,mac) VALUES (:id ,"")';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}

echo 'Finish.';