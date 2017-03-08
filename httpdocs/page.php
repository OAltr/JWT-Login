<?php

require_once '../init.php';

if(!User::isLoggedIn()) {
  die("no access");
}

echo "<h1>User Only Content</h1>";
echo "Here is some content<br />";
