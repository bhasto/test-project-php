<?php

$app = require "./core/app.php";

function isValidEmail($s) {
  return filter_var($s, FILTER_VALIDATE_EMAIL) !== FALSE;
}

function isEmptyString($s) {
  return strlen(trim($s)) == 0;
}

function isValidName($s) {
  return !isEmptyString($s);
}

function isValidCity($s) {
  return !isEmptyString($s);
}

function validateUser($data) {
  $errorCodes = array();
  if (!isValidName($data['name'])) $errorCodes[] = 'name';
  if (!isValidEmail($data['email'])) $errorCodes[] = 'email';
  if (!isValidCity($data['city'])) $errorCodes[] = 'city';

  $valid = empty($errorCodes);
  $result = array('valid' => $valid);
  if (!$valid) $result['errorCodes'] = $errorCodes;
  return $result;
}


$data = array(
  'name' => isset($_POST['name']) ? $_POST['name'] : NULL,
  'email' => isset($_POST['email']) ? $_POST['email'] : NULL,
  'city' => isset($_POST['city']) ? $_POST['city'] : NULL,
);

$validationResult = validateUser($data);

if ($validationResult['valid']) {
  $user = new User($app->db);
  $user->insert($data);
  header('Location: index.php');
} else {
  $users = User::find($app->db, '*');
  $app->renderView('index', array(
	  'users' => $users,
    'errorCodes' => $validationResult['errorCodes'],
    'data' => $data
  ));
}
