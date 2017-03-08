<?php

require_once '../init.php';

$form = json_decode(file_get_contents('php://input')); // Get user form
$name = $form["name"];
$pwd = $form["password"];

if(User::register($name, $pwd)) {
  echo "created";
} else {
  echo "not created";
}
