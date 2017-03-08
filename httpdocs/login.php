<?php

require '../init.php';

$form = json_decode(file_get_contents('php://input'));
$name = $form->username;
$pwd = $form->password;

$login = User::login($name, $pwd);

if($login) {
  $arr = array(
    'access' => true,
    'jwt' => $login['jwt']
// TODO:    'xsrf-token' => $login['xsrf-token']
  );
  echo json_encode($arr);
} else {
  User::logout();

  $arr = array(
    'access' => false
  );
  echo json_encode($arr);
}
