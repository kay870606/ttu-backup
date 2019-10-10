<?php
require('../core/pdoConstructor.php');

for ($i = 0; $i <= 20; $i++) {
    for ($j = 0; $j <= 15; $j++) {
        $id = sprintf("%02d", $i) . sprintf("%02d", $j);
        $sql = 'INSERT INTO beacons_tmp (name) VALUES (:id)';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}
echo 'Finish.';
