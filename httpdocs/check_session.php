<?php

require_once '../init.php';

$form = json_decode(file_get_contents('php://input'));
$jwt = $form->jwt;

if(User::isLoggedIn($jwt)) {
  $arr = array('access' => true);
  echo json_encode($arr);
} else {
  $arr = array('access' => false);
  echo json_encode($arr);
}
