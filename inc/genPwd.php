<?php
//genero la password random
$pwd = "";
$pwdRand = array_merge(range('A','Z'), range('a','z'), range(0,9));
for($i=0; $i < 10; $i++) {$pwd .= $pwdRand[array_rand($pwdRand)];}
//genero il codice salt e cripto la password
if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
 $salt = '$2y$11$' . substr(md5(uniqid(rand(), true)), 0, 22);
 $password = crypt($pwd, $salt);
}
echo $pwd;
?>
