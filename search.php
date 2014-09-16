<?php

$app = require './core/app.php';

$city = isset($_GET['city']) ? $_GET['city'] : NULL;


$users = isset($city) ? User::findByCity($app->db, $city) : User::findAll($app->db);


function userToArray($user) {
  return array(
    'name' => $user->getName(),
    'email' => $user->getEmail(),
    'city' => $user->getCity()
  );
}

$jsonData = array_map('userToArray', $users);

header('Content-Type: application/json');
echo json_encode($jsonData);
