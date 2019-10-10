<?php
require_once('../core/pdoConstructor.php');

for ($i = 1 ,$j = 14; $i <= 48,$j<=42; $i++,$j+=2) {
	
		$sql = "INSERT INTO beacons_place (category_id,beacon_id) VALUES ($j,$i)";
        $statement = $pdo->prepare($sql);
        $statement->execute();
		$i++;
		$sql = "INSERT INTO beacons_place (category_id,beacon_id) VALUES ($j,$i)";
        $statement = $pdo->prepare($sql);
        $statement->execute();
		$i++;
		$sql = "INSERT INTO beacons_place (category_id,beacon_id) VALUES ($j,$i)";
        $statement = $pdo->prepare($sql);
        $statement->execute();
}

echo 'Finish.';