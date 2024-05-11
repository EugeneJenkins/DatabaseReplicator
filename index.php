<?php

use Eugene\DatabaseReplicator\Factory\Factory;
use Eugene\DatabaseReplicator\Replicator;

require_once 'bootstrap.php';

$settings = Factory::createSettings();
$dev = Factory::createDatabase($settings['source']);
$local = Factory::createDatabase($settings['reference']);

try {
    $replicator = new Replicator($dev, $local);
    $replicator->merge();
} catch (Exception $exception) {
    echo $exception->getMessage();
}


//$faker = Faker\Factory::create();
//
//$data = [];
//$dat2 = [];
//
//for ($i = 0; $i < 10; $i++) {
//    $data[] = [
//        'name' => $faker->name,
//        'email' => $faker->email,
//        'phone' => $faker->phoneNumber,
//        'address' => $faker->address,
//    ];
//
//    $data2[] = [
//        'name' => $faker->name,
//        'email' => $faker->email,
//        'phone' => $faker->phoneNumber,
//        'address' => $faker->address,
//    ];
//}

//print_r(merge_by_keys($test, $test2));