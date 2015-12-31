<?php
//genero la password random
  $pwd = "";
  $pwdRand = array_merge(range('A','Z'), range('a','z'), range(0,9));
  for($i=0; $i < 10; $i++) {$pwd .= $pwdRand[array_rand($pwdRand)];}

  $key = '$2y$11$';
  $salt = substr(hash('sha512',uniqid(rand(), true).$key.microtime()), 0, 22);
  $password =hash('sha512',$pwd . $salt);
echo $pwd;
?>